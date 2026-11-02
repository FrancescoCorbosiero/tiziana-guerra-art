# Tiziana Guerra Art — sito statico

Il sito [tizianaguerra.art](https://tizianaguerra.art) ricostruito come **sito statico**. Lo stile è quello del tema WordPress "Ginevra" (Qode Interactive) usato finora:

- stessi font: Syne, Archivo e Cormorant Infant;
- stessi colori e stesse misure;
- pennellata gialla sotto i link;
- menu a tutto schermo con le voci che passano al serif;
- numerazione "/01";
- pulsante circolare "Torna su".

I contenuti (22 opere, home, biografia, eventi) sono stati importati dal sito WordPress.

Non ci sono PHP, database, CMS né plugin da aggiornare. Il risultato della build è una cartella di file HTML, CSS e immagini servita da nginx.

Altri documenti:

- [CLAUDE.md](CLAUDE.md): convenzioni del codice, insidie note e come verificare le modifiche. È il contesto per chi sviluppa, persone o assistenti AI.
- [docs/porting-wordpress.md](docs/porting-wordpress.md): com'era il sito WordPress, la cronologia del porting e le decisioni prese, con le motivazioni.

| | |
|---|---|
| **Generatore** | [Astro](https://astro.build) 7, output 100% statico |
| **JavaScript** | Pochi KB (ricerca, carosello, barra fissa, "torna su"). Menu e zoom funzionano anche senza JS |
| **Immagini** | Generate in fase di build in AVIF e WebP, in più formati (mai ingrandite oltre l'originale), con caricamento progressivo (lazy) |
| **Font** | Inclusi nel sito, nessuna richiesta a Google. Nessun cookie, nessun tracciamento: non serve il banner dei cookie |
| **Server** | nginx non privilegiato in Docker, con header di sicurezza, cache ottimizzata e redirect dai vecchi indirizzi |

## Avvio rapido

Serve Node.js ≥ 22.23.4 (consigliato 24, vedi `.nvmrc`).

```bash
npm install
npm run dev       # sito in sviluppo su http://localhost:4321 (si aggiorna da solo)
npm run build     # genera il sito finale in dist/
npm run preview   # anteprima di dist/
npm run check     # controllo tipi e contenuti
```

## Pagine

| Indirizzo | Contenuto | Vecchio indirizzo |
|---|---|---|
| `/` | "Vita e rinascita", introduzione, carosello delle opere verticali, frasi scorrevoli, chi sono, premi | `/` |
| `/chi-sono/` | Angelart (ritratto e presentazione), biografia, premio con *Chimera*, eventi anno per anno (`#eventi-2025`…) | `/chi-sono/` |
| `/pitture/` | Tutte le opere su due colonne, filtro per categoria | `/portfolio-tag/pitture/` |
| `/pitture/categoria/<categoria>/` | Acrilico, Spatola, Caffè | `/portfolio-category/…` |
| `/pitture/<opera>/` | Scheda: foto con zoom, titolo, descrizione, dimensioni, anno, tecnica, categoria, "Richiedi informazioni" | `/portfolio-item/<opera>/` |
| `/galleria/` | Tutte le opere su 3 colonne, zoom al passaggio del mouse | `/portfolio/` |
| `/contatti/` | Modulo di contatto (inoltro via AWS SES), email e Instagram | `/contatti-2/` |
| `/privacy-policy/` | Informativa privacy | `/privacy-policy-3/` |

I vecchi indirizzi rimandano automaticamente ai nuovi con un redirect 301, configurato in `deploy/snippets/redirects.conf`. Così Google e i link esistenti non finiscono su una pagina 404.

## Gestione dei contenuti

Tutti i contenuti sono file di testo in `src/content/`.

```
src/content/
├── opere/
│   └── lago-fatato/              ← una cartella per opera (il nome diventa l'indirizzo)
│       ├── index.md              ← scheda
│       └── lago-fatato.webp      ← fotografia
├── categorie.yaml                ← Acrilico, Spatola, Caffè
├── home/home.md                  ← testi e immagini della homepage
└── pagine/
    ├── chi-sono.md               ← presentazione, biografia, premio in evidenza, eventi
    └── privacy-policy.md         ← informativa privacy
src/config/site.ts                ← email, Instagram, motto, voci di menu
server/contatti/                  ← micro-servizio del modulo di contatto (AWS SES)
```

### Aggiungere un'opera

1. Crea una cartella in `src/content/opere/` con un nome semplice, minuscolo e con trattini, ad esempio `notte-sul-lago`.
2. Copia dentro la fotografia **originale, alla massima qualità**: non serve ridimensionarla, ci pensa la build.
3. Crea `index.md`:

```markdown
---
titolo: Notte sul lago
immagine: ./notte-sul-lago.jpg
categorie: [acrilico, spatola]
anno: 2026
tecnica: Acrilico e Spatola
dimensioni: 70 × 50 cm
ordine: 23
---

Breve descrizione o testo critico.\
Una barra rovesciata a fine riga manda a capo senza aprire un nuovo paragrafo.
```

| Campo | Obbligatorio | Note |
|---|---|---|
| `titolo` | sì | |
| `immagine` | sì | Percorso relativo alla cartella dell'opera |
| `categorie` | sì | Una o più chiavi di `categorie.yaml` |
| `anno`, `tecnica`, `dimensioni` | no | Se mancano, non vengono mostrati |
| `ordine` | no | Posizione nell'elenco (numeri più bassi prima). È l'ordine della Galleria del vecchio sito |
| `inEvidenza` | no | Opera nel carosello della homepage (sul vecchio sito: tag "Verticali") |
| `disponibilita` | no | `disponibile` (mostra anche "Acquista"), `venduta`, `collezione-privata`, `su-richiesta` |
| `prezzo` | no | Mostrato solo se l'opera è disponibile |
| `alt` | no | Descrizione per chi non vede l'immagine. Se manca viene generata |
| `dettagli` | no | Foto aggiuntive: `- immagine: ./dettaglio.jpg` |
| `bozza` | no | `true` = visibile solo in sviluppo |

Se un campo è sbagliato, ad esempio una categoria inesistente o un'immagine mancante, la build si ferma con un messaggio che indica il file da correggere.

### Pagina "Chi sono"

Il file è `src/content/pagine/chi-sono.md`. Il testo sotto il frontmatter è la biografia, in Markdown. Nel frontmatter:

| Campo | Contenuto |
|---|---|
| `titolo` | Frase grande in cima alla pagina |
| `intro` | Ritratto e presentazione. Sottocampi: `sopratitolo`, `titolo` (Angelart), `testo` (la frase in evidenza, in grande), `testo2`, `immagine`, `immagineAlt`, `immaginePosizione` |
| `biografia` | `sopratitolo` e `titolo` della biografia |
| `evidenza` | Premio in evidenza. Sottocampi: `sopratitolo`, `titolo` (se manca si usa il titolo dell'opera), `testo` (ammessi `*corsivo*` e `**grassetto**`), `opera` (nome della cartella dell'opera) |
| `eventi` | `sopratitolo`, `titolo`, la locandina (`immagine`, `immagineAlt`, `didascalia`) e l'elenco `anni` |

**Eventi.** Ogni voce occupa una riga, nella forma `Evento / luogo — dettagli`:

```yaml
    - anno: 2026
      voci:
        - "Premio Amare con l’Arte / Castello Orsini, Castel Madama, Roma — premio speciale sensibilità artistica"
        - "Mostra Personale *“Trame di Colore”* / Palazzo Valentini, Roma — 27 marzo"
        - "Artisti 26"
```

Il testo prima della prima lineetta lunga (—) è il titolo della voce. Il resto compare sotto, più piccolo. Se non c'è nessuna lineetta, la voce ha solo il titolo.

**Punto di fuoco dei ritagli.** `immaginePosizione` in Chi sono e `posizione` nelle immagini di `chiSono` in home indicano quale punto della foto tenere al centro quando la foto viene ritagliata. Il formato è "orizzontale verticale": ad esempio `"50% 30%"` centra in orizzontale e sposta il ritaglio un po' verso l'alto, così nei ritratti il viso non viene tagliato.

## Deploy sul VPS (Docker)

```bash
cp .env.example .env    # poi compilarlo (vedi "Modulo di contatto" qui sotto)
docker compose up -d --build
```

`docker compose` avvia due container:

- **sito**: nginx senza root, filesystem in sola lettura, che serve i file statici su `127.0.0.1:8080`. Va collegato al reverse proxy già in uso sul VPS (Traefik, Caddy, nginx-proxy…), che gestisce dominio e HTTPS, al posto del container WordPress.
- **contatti**: il micro-servizio del modulo di contatto. Non espone porte: lo raggiunge solo nginx su `/api/contatti`.

Per aggiornare il sito dopo una modifica:

```bash
git pull && docker compose up -d --build
```

La configurazione di nginx è in `deploy/`:

- `nginx.conf`:
  - cache di un anno per i file con hash;
  - gzip;
  - redirect agli indirizzi con "/" finale;
  - pagina 404;
  - inoltro di `/api/contatti` con un limite di 6 invii al minuto per IP;
  - log con IP anonimizzati.
- `snippets/security-headers.conf`: Content-Security-Policy senza `unsafe-inline` per gli script, più gli altri header di sicurezza (HSTS va impostato sul reverse proxy).
- `snippets/redirects.conf`: vecchi indirizzi WordPress → nuovi. I percorsi `wp-admin`, `wp-login.php`, `xmlrpc.php` e simili rispondono `410 Gone`.

Il reverse proxy davanti deve passare l'IP del visitatore in `X-Forwarded-For`, come fanno Traefik e Caddy di default. Serve al limite anti-abuso del modulo.

## Modulo di contatto (AWS SES)

Il modulo (`/contatti/`) invia i dati a `server/contatti`, un piccolo servizio Node.js. Il servizio controlla i campi, scarta lo spam (con un campo trappola invisibile) e inoltra il messaggio via **Amazon SES** all'indirizzo `MAIL_TO`. Il "Rispondi" va direttamente al visitatore. Non viene salvato niente sul server.

Funziona anche senza JavaScript: in quel caso si arriva a `/contatti/inviato/` oppure a `/contatti/errore/`. Il pulsante "Richiedi informazioni" di ogni scheda apre il modulo con l'oggetto già compilato.

Configurazione, nel file `.env` (vedi `.env.example`):

1. **Mittente verificato.** `MAIL_FROM` deve appartenere a un'identità verificata su SES, nella stessa regione indicata in `AWS_REGION`. Se WP SMTP inviava già con SES, il dominio è probabilmente già verificato. Non usare l'indirizzo Yahoo come mittente: Yahoo rifiuta le email inviate a suo nome da altri server (DMARC). Va bene come destinatario (`MAIL_TO`).
2. **Credenziali.** Due possibilità:
   - **A, consigliata.** Chiavi di un utente IAM (`AWS_ACCESS_KEY_ID`, `AWS_SECRET_ACCESS_KEY`) con il solo permesso di inviare:
     ```json
     {
       "Version": "2012-10-17",
       "Statement": [{ "Effect": "Allow", "Action": ["ses:SendEmail", "ses:SendRawEmail"], "Resource": "*" }]
     }
     ```
   - **B.** Le credenziali **SMTP** di SES, se WP SMTP usava quelle (`SMTP_HOST`, `SMTP_USER`, `SMTP_PASS`).
3. **Sandbox.** Se l'account SES è ancora in sandbox, si può inviare solo a indirizzi verificati. Per questo modulo basta che sia verificato `MAIL_TO`.
4. **Prova.** Con `DRY_RUN=1` il servizio non invia nulla e scrive il messaggio nei log (`docker compose logs contatti`).

Test del servizio: `cd server/contatti && npm install && npm test`.

## Ancora aperto

- [ ] **Foto a bassa risoluzione.** Alcuni originali caricati su WordPress sono piccoli: *La notte non era sola* (503 px), *Le radici della foresta* (563 px), *Soubrette* (630 px), *Il riflesso della natura* (732 px) e la foto della premiazione in home (331 px). Se esistono foto migliori, basta sostituire il file nella cartella.
- [ ] **Dati mancanti.** L'anno è indicato solo per 9 opere su 22, la tecnica per 14. Si possono completare nei file `index.md`.
- [ ] **Nomi da verificare con l'artista** (in `chi-sono.md`, non modificati):
  - "Josè Von Roy Dalì": di solito si trova scritto "Van Roy";
  - "Galleria Le Thuiller, Parigi": forse la Galerie Thuillier;
  - "Palazzo Ivanchic, Venezia": forse Palazzo Ivancich.
- [ ] **Privacy policy.** La bozza in `src/content/pagine/privacy-policy.md` descrive il funzionamento reale del sito:
  - nessun cookie;
  - log anonimizzati;
  - modulo inoltrato via SES.

  Va completata con il nome del fornitore del VPS, e conviene farla rivedere da un professionista.

Correzioni già fatte rispetto al vecchio sito:

- "Soubtrette" → "Soubrette" (l'indirizzo della pagina resta `/pitture/soubtrette/`);
- "A volta" → "A volte";
- "Un opera" → "Un’opera";
- il cognome della curatrice è uniformato in "Vetturini", come sulla locandina del premio;
- "con L’OPERA : CHIMERA" → "con l’opera *Chimera*" e "Bac edition" → "BAC Edition" (premio in evidenza in Chi sono).

## Note sullo stile

- **Font**: Syne (titoli, menu), Archivo 300 (testo) e Cormorant Infant (corsivi, numerazione, menu al passaggio del mouse), come nel tema. Sono inclusi in `src/assets/fonts/` con le licenze OFL.
- **Colori**:
  - testo `#4e4e4e`;
  - titoli `#212121`;
  - menu `#221d14`;
  - crema `#f5f4ed`;
  - giallo pennellata `#ffc600`.
- **Header**: come nel tema ne esistono tre varianti. La home ha il menu verticale a destra, Chi sono ha "Menu" che apre il menu a tutto schermo, le altre pagine hanno il menu a sinistra e il logo al centro. Scorrendo compare una barra compatta. Sotto i 1800 px il logo va a sinistra, perché menu e logo centrato non ci stanno.
- **Differenze volute**:
  - la Galleria è su 3 colonne invece di 2, come chiedevano le direttive iniziali;
  - la pagina Pitture ha un filtro per categoria;
  - la scheda ha il pulsante "Richiedi informazioni";
  - nella scheda, le frecce ← → della tastiera passano all'opera precedente o successiva;
  - la pagina Chi sono è stata reimpaginata su una griglia a 12 colonne con proporzioni corrette. L'impaginazione Elementor originale aveva testi su righe troppo lunghe, il ritratto tagliato ed eventi centrati difficili da leggere. I dettagli sono in [docs/porting-wordpress.md](docs/porting-wordpress.md#6-chi-sono-prima-e-dopo);
  - in stampa escono solo i contenuti, senza header, menu e pulsanti.
- Tutti i valori (colori, font, dimensioni) sono variabili CSS in `src/styles/global.css`.
