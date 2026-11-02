/**
 * Micro-servizio del modulo di contatto.
 *
 *   POST /api/contatti   → valida e inoltra il messaggio via AWS SES
 *   GET  /api/salute     → controllo di funzionamento (healthcheck)
 *
 * Risponde in JSON alle richieste fatte dalla pagina (fetch) e con un redirect alla
 * pagina di conferma/errore quando il modulo viene inviato senza JavaScript.
 * Non salva nulla: il messaggio esiste solo nella casella di posta di destinazione.
 */
import { createServer } from 'node:http';
import { SESv2Client, SendEmailCommand } from '@aws-sdk/client-sesv2';
import nodemailer from 'nodemailer';
import { componiEmail, leggiConfigurazione, valida } from './lib.js';

const MAX_BODY = 32 * 1024;
const PAGINA_OK = '/contatti/inviato/';
const PAGINA_ERRORE = '/contatti/errore/';

export function creaTrasporto(config) {
  if (config.modo === 'prova') return nodemailer.createTransport({ jsonTransport: true });
  if (config.modo === 'smtp') return nodemailer.createTransport(config.smtp);
  // Credenziali e regione lette da AWS_ACCESS_KEY_ID / AWS_SECRET_ACCESS_KEY / AWS_REGION
  const sesClient = new SESv2Client({});
  return nodemailer.createTransport({ SES: { sesClient, SendEmailCommand } });
}

function leggiCorpo(req) {
  return new Promise((resolve, reject) => {
    let size = 0;
    const parti = [];
    req.on('data', (chunk) => {
      size += chunk.length;
      if (size > MAX_BODY) {
        reject(Object.assign(new Error('corpo troppo grande'), { status: 413 }));
        req.destroy();
        return;
      }
      parti.push(chunk);
    });
    req.on('end', () => resolve(Buffer.concat(parti).toString('utf8')));
    req.on('error', reject);
  });
}

function interpreta(tipo, corpo) {
  if (tipo.includes('application/json')) {
    const dati = JSON.parse(corpo || '{}');
    return dati && typeof dati === 'object' ? dati : {};
  }
  if (tipo.includes('application/x-www-form-urlencoded') || tipo === '') {
    return Object.fromEntries(new URLSearchParams(corpo));
  }
  throw Object.assign(new Error('formato non supportato'), { status: 415 });
}

export function creaServer({ config, trasporto, log = console }) {
  return createServer(async (req, res) => {
    const url = new URL(req.url ?? '/', 'http://localhost');
    const vuoleJson = (req.headers.accept ?? '').includes('application/json');

    const rispondi = (status, json, redirect) => {
      if (vuoleJson || !redirect) {
        res.writeHead(status, { 'Content-Type': 'application/json; charset=utf-8', 'Cache-Control': 'no-store' });
        res.end(JSON.stringify(json));
      } else {
        res.writeHead(303, { Location: redirect, 'Cache-Control': 'no-store' });
        res.end();
      }
    };

    if (url.pathname === '/api/salute') {
      return rispondi(200, { ok: true, modo: config.modo });
    }
    if (url.pathname !== '/api/contatti') {
      return rispondi(404, { ok: false, errore: 'Non trovato' });
    }
    if (req.method !== 'POST') {
      res.setHeader('Allow', 'POST');
      return rispondi(405, { ok: false, errore: 'Metodo non consentito' });
    }

    let campi;
    try {
      campi = interpreta((req.headers['content-type'] ?? '').toLowerCase(), await leggiCorpo(req));
    } catch (err) {
      const status = err.status ?? 400;
      return rispondi(status, { ok: false, errore: 'Richiesta non valida' }, PAGINA_ERRORE);
    }

    const esito = valida(campi);
    if (!esito.ok) {
      return rispondi(422, { ok: false, errori: esito.errori }, PAGINA_ERRORE);
    }
    if (esito.spam) {
      // Ai bot rispondiamo "ok" senza inviare nulla.
      log.info?.('[contatti] messaggio scartato (campo trappola compilato)');
      return rispondi(200, { ok: true }, PAGINA_OK);
    }

    try {
      const info = await trasporto.sendMail(componiEmail(esito.dati, config));
      log.info?.(`[contatti] messaggio inoltrato (${config.modo}) id=${info.messageId ?? '—'}`);
      if (config.modo === 'prova') log.info?.(`[contatti] DRY_RUN:\n${info.message}`);
      return rispondi(200, { ok: true }, PAGINA_OK);
    } catch (err) {
      // Nessun dato personale nei log: solo il tipo di errore.
      log.error?.(`[contatti] invio non riuscito: ${err.name ?? 'Error'}: ${err.message}`);
      return rispondi(502, { ok: false, errore: 'Invio non riuscito' }, PAGINA_ERRORE);
    }
  });
}

// Avvio diretto (non durante i test)
if (import.meta.url === `file://${process.argv[1]}`) {
  const config = leggiConfigurazione();
  if (config.errori.length) {
    console.error('[contatti] configurazione incompleta:\n  - ' + config.errori.join('\n  - '));
    process.exit(1);
  }
  const server = creaServer({ config, trasporto: creaTrasporto(config) });
  server.listen(config.porta, () => console.info(`[contatti] in ascolto sulla porta ${config.porta} (modo: ${config.modo})`));
  const chiudi = () => server.close(() => process.exit(0));
  process.on('SIGTERM', chiudi);
  process.on('SIGINT', chiudi);
}
