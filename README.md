# Tiziana Guerra Art — sito statico

Il sito [tizianaguerra.art](https://tizianaguerra.art) ricostruito come **sito statico**, mantenendo lo stile del tema WordPress "Ginevra": sfondo bianco e crema, maiuscole *extended*, numerazione in corsivo serif (`/01`), pennellata gialla sotto i link, menu a tutto schermo con le voci che passano al serif al passaggio del mouse.

Non ci sono PHP, database, CMS né plugin da aggiornare. Il risultato della build è una cartella di file HTML, CSS e immagini servita da nginx.

| | |
|---|---|
| **Generatore** | [Astro](https://astro.build) 7, output 100% statico |
| **JavaScript** | ~2 KB in tutto (ricerca, "torna su", overlay). Menu, zoom e filtri funzionano anche senza JS |
| **Immagini** | Generate in fase di build in AVIF e WebP, in più formati, con caricamento progressivo (lazy) |
| **Font** | Self-hosted, nessuna richiesta a Google. Nessun cookie, nessun tracciamento |
| **Server** | nginx non privilegiato in Docker, con header di sicurezza e cache ottimizzata |

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

| Indirizzo | Contenuto |
|---|---|
| `/` | Hero introduttiva, riassunto "Chi sono", opere in evidenza, temi |
| `/chi-sono/` | Biografia (testo in Markdown) |
| `/pitture/` | Tutte le opere su due colonne sfalsate, come nel tema, con filtro per tema |
| `/pitture/tema/<tema>/` | Opere di un tema (paesaggi, ritratti, astratti…) |
| `/pitture/<opera>/` | Scheda: foto con zoom, titolo, anno, tecnica, dimensioni, descrizione, "Richiedi informazioni" / "Acquista" |
| `/galleria/` | Tutte le opere in griglia a 2/3/4 colonne con zoom al passaggio del mouse, divise per anno |
| `/contatti/` | Email, telefono, WhatsApp, social (modulo facoltativo) |

## Gestione dei contenuti

Tutti i contenuti sono file di testo in `src/content/`.

```
src/content/
├── opere/
│   └── lago-fatato/          ← una cartella per opera (il nome diventa l'indirizzo)
│       ├── index.md          ← scheda
│       └── lago-fatato.jpg   ← fotografia
├── temi.yaml                 ← elenco dei temi
└── pagine/
    └── chi-sono.md           ← biografia
```

### Aggiungere un'opera

1. Crea una cartella in `src/content/opere/` con un nome semplice, minuscolo e con trattini, ad esempio `notte-sul-lago`.
2. Copia dentro la fotografia **originale, alla massima qualità**: non serve ridimensionarla, ci pensa la build.
3. Crea `index.md`:

```markdown
---
titolo: Notte sul lago
immagine: ./notte-sul-lago.jpg
tema: paesaggi
anno: 2024
tecnica: Acrilico su tela
dimensioni: 70 × 50 cm
disponibilita: disponibile
prezzo: "€ 450"
inEvidenza: true
---

Breve descrizione o testo critico, in Markdown.
```

| Campo | Obbligatorio | Note |
|---|---|---|
| `titolo` | sì | |
| `immagine` | sì | Percorso relativo alla cartella dell'opera |
| `tema` | sì | Una delle chiavi di `temi.yaml` |
| `anno`, `tecnica`, `dimensioni` | no | Se mancano, non vengono mostrati |
| `disponibilita` | no | `disponibile` (mostra "Acquista"), `venduta`, `collezione-privata`, `su-richiesta` |
| `prezzo` | no | Mostrato solo se l'opera è disponibile (disattivabile con `mostraPrezzi` in `site.ts`) |
| `inEvidenza` | no | Opera mostrata in homepage e nel menu |
| `ordine` | no | Ordinamento manuale: i numeri più bassi vengono prima. Senza questo campo l'ordine è per anno, dal più recente |
| `alt` | no | Descrizione per chi non vede l'immagine. Se manca viene generata |
| `dettagli` | no | Foto aggiuntive: `- immagine: ./dettaglio.jpg` |
| `citazione` | no | `testo:` e `autore:` di un breve testo critico |
| `bozza` | no | `true` = visibile solo in sviluppo |

Se un campo è sbagliato, ad esempio un tema inesistente o un'immagine mancante, la build si ferma con un messaggio che indica il file da correggere.

### Testi generali

`src/config/site.ts` contiene nome, sottotitolo, email, telefono, WhatsApp, social e un modulo di contatto facoltativo. I campi vuoti vengono nascosti.

## Deploy sul VPS (Docker)

```bash
docker compose up -d --build
```

Il container serve il sito su `127.0.0.1:8080`. Va collegato al reverse proxy già in uso sul VPS (Traefik, Caddy, nginx-proxy…), che gestisce il dominio e HTTPS al posto del container WordPress. Per aggiornare il sito dopo una modifica:

```bash
git pull && docker compose up -d --build
```

L'immagine è in due fasi: la prima genera il sito con Node, la seconda contiene solo nginx e i file statici. Il container gira senza root, con filesystem in sola lettura. La configurazione di nginx è in `deploy/`:

- `nginx.conf`: cache di un anno per i file con hash, gzip, redirect agli indirizzi con "/" finale, pagina 404 personalizzata;
- `snippets/security-headers.conf`: Content-Security-Policy senza `unsafe-inline` per gli script, più gli altri header di sicurezza (HSTS va impostato sul reverse proxy);
- `snippets/redirects.conf`: vecchi URL di WordPress. I percorsi `wp-admin`, `wp-login.php`, `xmlrpc.php` e simili rispondono `410 Gone`.

In alternativa, la cartella `dist/` funziona su qualsiasi hosting statico (Netlify, Cloudflare Pages, GitHub Pages…).

## Migrazione da WordPress: cosa manca

- [ ] **Importare le opere reali**: foto originali, titoli, anni, tecniche, dimensioni, descrizioni, temi
- [ ] Sostituire le due foto provvisorie (*Lago fatato*, *Tra i canneti e la quiete*), ritagliate a bassa risoluzione da uno screenshot
- [ ] Eliminare le cartelle `esempio-01` … `esempio-06` (opere dimostrative)
- [ ] Biografia in `src/content/pagine/chi-sono.md`
- [ ] Verificare l'email e aggiungere telefono, WhatsApp e social in `src/config/site.ts`
- [ ] Mappare i vecchi indirizzi WordPress in `deploy/snippets/redirects.conf`, per non perdere il posizionamento su Google
- [ ] Contenuto della pagina Galleria: ora mostra tutte le opere per anno. Se sul vecchio sito conteneva altro (mostre, eventi…), si adatta

## Note sullo stile

- **Font**: *Archivo* in versione larga (larghezza 122%, peso 550) sostituisce il font extended del tema. Misurato sugli screenshot, lo scarto di proporzioni è sotto l'1%. Il serif è *Cormorant Garamond*. Entrambi i font sono open source (OFL).
- **Colori**: campionati dagli screenshot del sito attuale. Crema `#f5f4ed`, testo `#222222` / `#211d13`, giallo pennellata `#fec600`.
- Tutti i valori (colori, font, dimensioni, spaziature) sono variabili CSS in `src/styles/global.css`. Con il CSS del tema si possono allineare in un solo punto.
