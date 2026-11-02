/**
 * Logica del modulo di contatto, senza dipendenze dal server HTTP (testabile).
 */

export const LIMITI = {
  nome: 100,
  email: 254,
  oggetto: 150,
  messaggio: 5000,
  messaggioMin: 10,
};

const EMAIL_RE = /^[^\s@<>()[\]\\,;:"]+@[^\s@<>()[\]\\,;:"]+\.[^\s@<>()[\]\\,;:"]{2,}$/;
const ACCETTATO = new Set(['on', 'true', '1', 'si', 'sì', 'yes']);

/** Toglie spazi e caratteri di controllo; i campi su una riga non possono contenere a capo. */
function pulisci(valore, { multilinea = false } = {}) {
  if (typeof valore !== 'string') return '';
  let s = valore.normalize('NFC');
  s = multilinea
    ? s.replace(/\r\n?/g, '\n').replace(/[\u0000-\u0008\u000b\u000c\u000e-\u001f\u007f]/g, '')
    : s.replace(/[\u0000-\u001f\u007f]+/g, ' ');
  return s.trim();
}

/**
 * Valida i campi ricevuti.
 * @returns {{ ok: true, dati: object, spam: boolean } | { ok: false, errori: Record<string,string> }}
 */
export function valida(input) {
  const campi = input && typeof input === 'object' ? input : {};
  // Campo trappola: invisibile alle persone, compilato solo dai bot.
  const spam = pulisci(campi.sito_web) !== '';

  const dati = {
    nome: pulisci(campi.nome),
    email: pulisci(campi.email).toLowerCase(),
    oggetto: pulisci(campi.oggetto),
    messaggio: pulisci(campi.messaggio, { multilinea: true }),
    privacy: ACCETTATO.has(pulisci(campi.privacy).toLowerCase()),
  };

  const errori = {};
  if (!dati.nome) errori.nome = 'Inserisci il tuo nome.';
  else if (dati.nome.length > LIMITI.nome) errori.nome = `Massimo ${LIMITI.nome} caratteri.`;

  if (!dati.email) errori.email = "Inserisci il tuo indirizzo email.";
  else if (dati.email.length > LIMITI.email || !EMAIL_RE.test(dati.email))
    errori.email = 'Indirizzo email non valido.';

  if (dati.oggetto.length > LIMITI.oggetto) errori.oggetto = `Massimo ${LIMITI.oggetto} caratteri.`;

  if (dati.messaggio.length < LIMITI.messaggioMin) errori.messaggio = 'Scrivi un messaggio un po’ più lungo.';
  else if (dati.messaggio.length > LIMITI.messaggio) errori.messaggio = `Massimo ${LIMITI.messaggio} caratteri.`;

  if (!dati.privacy) errori.privacy = 'Per inviare il messaggio serve il consenso al trattamento dei dati.';

  if (Object.keys(errori).length) return { ok: false, errori };
  return { ok: true, dati, spam };
}

/** Costruisce l'email per nodemailer: solo testo, risposta diretta al visitatore. */
export function componiEmail(dati, { from, to, sito = 'tizianaguerra.art', ora = new Date() } = {}) {
  const quando = new Intl.DateTimeFormat('it-IT', {
    dateStyle: 'long',
    timeStyle: 'short',
    timeZone: 'Europe/Rome',
  }).format(ora);
  const oggetto = dati.oggetto || 'Nuovo messaggio dal sito';
  return {
    from,
    to,
    replyTo: { name: dati.nome, address: dati.email },
    subject: `[${sito}] ${oggetto} — ${dati.nome}`,
    text: [
      `Nome: ${dati.nome}`,
      `Email: ${dati.email}`,
      `Oggetto: ${dati.oggetto || '—'}`,
      '',
      'Messaggio:',
      dati.messaggio,
      '',
      '—',
      `Inviato dal modulo di contatto di ${sito} il ${quando}.`,
      'Per rispondere basta usare "Rispondi": il messaggio arriva direttamente al mittente.',
    ].join('\n'),
  };
}

/** Legge e controlla la configurazione dalle variabili d'ambiente. */
export function leggiConfigurazione(env = process.env) {
  const errori = [];
  const to = (env.MAIL_TO || '').trim();
  const from = (env.MAIL_FROM || '').trim();
  if (!to) errori.push('MAIL_TO mancante (destinatario dei messaggi)');
  if (!from) errori.push('MAIL_FROM mancante (mittente verificato su SES, es. "Tiziana Guerra Art <sito@tizianaguerra.art>")');

  const smtp = Boolean(env.SMTP_HOST);
  if (smtp) {
    if (!env.SMTP_USER || !env.SMTP_PASS) errori.push('SMTP_USER e SMTP_PASS sono necessari con SMTP_HOST');
  } else if (!env.DRY_RUN) {
    if (!env.AWS_REGION) errori.push('AWS_REGION mancante (es. eu-west-1)');
    if (!env.AWS_ACCESS_KEY_ID || !env.AWS_SECRET_ACCESS_KEY)
      errori.push('AWS_ACCESS_KEY_ID e AWS_SECRET_ACCESS_KEY mancanti (oppure usa SMTP_HOST/SMTP_USER/SMTP_PASS)');
  }

  return {
    errori,
    to,
    from,
    modo: env.DRY_RUN ? 'prova' : smtp ? 'smtp' : 'ses',
    smtp: smtp
      ? {
          host: env.SMTP_HOST,
          port: Number(env.SMTP_PORT || 587),
          secure: Number(env.SMTP_PORT) === 465,
          auth: { user: env.SMTP_USER, pass: env.SMTP_PASS },
        }
      : undefined,
    sito: env.SITE_NAME || 'tizianaguerra.art',
    porta: Number(env.PORT || 3000),
  };
}
