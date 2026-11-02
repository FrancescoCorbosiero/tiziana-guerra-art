import assert from 'node:assert/strict';
import { once } from 'node:events';
import { test } from 'node:test';
import { SendEmailCommand } from '@aws-sdk/client-sesv2';
import nodemailer from 'nodemailer';
import { componiEmail, leggiConfigurazione, valida } from '../lib.js';
import { creaServer } from '../server.js';

const valido = {
  nome: 'Mario Rossi',
  email: 'Mario@Example.com',
  oggetto: "Informazioni sull'opera: Lago Fatato",
  messaggio: 'Buongiorno, vorrei sapere se l’opera è disponibile.',
  privacy: 'on',
};

test('valida: dati corretti', () => {
  const r = valida(valido);
  assert.equal(r.ok, true);
  assert.equal(r.dati.email, 'mario@example.com');
  assert.equal(r.spam, false);
});

test('valida: errori sui campi', () => {
  const r = valida({ nome: '', email: 'non-email', messaggio: 'corto', privacy: '' });
  assert.equal(r.ok, false);
  assert.deepEqual(Object.keys(r.errori).sort(), ['email', 'messaggio', 'nome', 'privacy']);
});

test('valida: niente a capo nei campi su una riga (no header injection)', () => {
  const r = valida({ ...valido, nome: 'Mario\r\nBcc: vittima@example.com', oggetto: 'Ciao\nBcc: x@y.it' });
  assert.equal(r.ok, true);
  assert.ok(!/[\r\n]/.test(r.dati.nome));
  assert.ok(!/[\r\n]/.test(r.dati.oggetto));
});

test('valida: campo trappola → spam', () => {
  assert.equal(valida({ ...valido, sito_web: 'http://spam' }).spam, true);
});

test('componiEmail: risposta al visitatore, oggetto e testo', () => {
  const m = componiEmail(valida(valido).dati, { from: 'Sito <sito@tizianaguerra.art>', to: 'dest@example.com' });
  assert.deepEqual(m.replyTo, { name: 'Mario Rossi', address: 'mario@example.com' });
  assert.match(m.subject, /^\[tizianaguerra\.art\] Informazioni sull'opera: Lago Fatato — Mario Rossi$/);
  assert.match(m.text, /Messaggio:\nBuongiorno/);
});

test('leggiConfigurazione: segnala ciò che manca', () => {
  assert.ok(leggiConfigurazione({}).errori.length >= 3);
  const ok = leggiConfigurazione({ MAIL_TO: 'a@b.it', MAIL_FROM: 'c@d.it', AWS_REGION: 'eu-west-1', AWS_ACCESS_KEY_ID: 'x', AWS_SECRET_ACCESS_KEY: 'y' });
  assert.deepEqual(ok.errori, []);
  assert.equal(ok.modo, 'ses');
  assert.equal(leggiConfigurazione({ MAIL_TO: 'a@b.it', MAIL_FROM: 'c@d.it', SMTP_HOST: 'email-smtp.eu-west-1.amazonaws.com', SMTP_USER: 'u', SMTP_PASS: 'p' }).modo, 'smtp');
});

/** Client SES finto: registra il comando invece di chiamare AWS. */
function sesFinto() {
  const inviati = [];
  return {
    inviati,
    sesClient: {
      config: { region: async () => 'eu-west-1' },
      async send(command) {
        inviati.push(command);
        return { MessageId: '0102-test' };
      },
    },
  };
}

async function avvia(trasporto) {
  const config = { to: 'forevertizzy@yahoo.it', from: 'Tiziana Guerra Art <sito@tizianaguerra.art>', modo: 'ses', sito: 'tizianaguerra.art' };
  const server = creaServer({ config, trasporto, log: { info() {}, error() {} } });
  server.listen(0);
  await once(server, 'listening');
  return { server, base: `http://127.0.0.1:${server.address().port}` };
}

test('POST JSON → inoltro via SES con mittente, destinatario e Reply-To corretti', async () => {
  const ses = sesFinto();
  const trasporto = nodemailer.createTransport({ SES: { sesClient: ses.sesClient, SendEmailCommand } });
  const { server, base } = await avvia(trasporto);
  try {
    const res = await fetch(base + '/api/contatti', {
      method: 'POST',
      headers: { 'Content-Type': 'application/json', Accept: 'application/json' },
      body: JSON.stringify(valido),
    });
    assert.equal(res.status, 200);
    assert.deepEqual(await res.json(), { ok: true });
    assert.equal(ses.inviati.length, 1);
    const input = ses.inviati[0].input;
    assert.ok(ses.inviati[0] instanceof SendEmailCommand);
    assert.equal(input.FromEmailAddress, 'Tiziana Guerra Art <sito@tizianaguerra.art>');
    assert.deepEqual(input.Destination.ToAddresses, ['forevertizzy@yahoo.it']);
    const raw = Buffer.from(input.Content.Raw.Data).toString('utf8');
    assert.match(raw, /^Reply-To: Mario Rossi <mario@example\.com>$/m);
    assert.match(raw, /^To: forevertizzy@yahoo\.it$/m);
  } finally {
    server.close();
  }
});

test('POST da modulo senza JS → redirect alla pagina di conferma / errore', async () => {
  const ses = sesFinto();
  const trasporto = nodemailer.createTransport({ SES: { sesClient: ses.sesClient, SendEmailCommand } });
  const { server, base } = await avvia(trasporto);
  try {
    const ok = await fetch(base + '/api/contatti', {
      method: 'POST',
      redirect: 'manual',
      headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
      body: new URLSearchParams(valido),
    });
    assert.equal(ok.status, 303);
    assert.equal(ok.headers.get('location'), '/contatti/inviato/');

    const ko = await fetch(base + '/api/contatti', {
      method: 'POST',
      redirect: 'manual',
      headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
      body: new URLSearchParams({ ...valido, email: 'sbagliata' }),
    });
    assert.equal(ko.status, 303);
    assert.equal(ko.headers.get('location'), '/contatti/errore/');
    assert.equal(ses.inviati.length, 1);
  } finally {
    server.close();
  }
});

test('spam, errori di invio, metodo e dimensione', async () => {
  const trasportoRotto = { sendMail: async () => { throw new Error('MessageRejected'); } };
  const { server, base } = await avvia(trasportoRotto);
  const json = { 'Content-Type': 'application/json', Accept: 'application/json' };
  try {
    const spam = await fetch(base + '/api/contatti', { method: 'POST', headers: json, body: JSON.stringify({ ...valido, sito_web: 'x' }) });
    assert.equal(spam.status, 200); // scartato in silenzio, nessun tentativo di invio
    const errore = await fetch(base + '/api/contatti', { method: 'POST', headers: json, body: JSON.stringify(valido) });
    assert.equal(errore.status, 502);
    const get = await fetch(base + '/api/contatti', { headers: { Accept: 'application/json' } });
    assert.equal(get.status, 405);
    const grande = await fetch(base + '/api/contatti', { method: 'POST', headers: json, body: JSON.stringify({ ...valido, messaggio: 'x'.repeat(40_000) }) }).catch(() => ({ status: 413 }));
    assert.equal(grande.status, 413);
    const salute = await fetch(base + '/api/salute');
    assert.equal(salute.status, 200);
  } finally {
    server.close();
  }
});
