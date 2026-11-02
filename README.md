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
| `/chi-sono/` | Angelart, biografia, Chimera, elenco eventi | `/chi-sono/` |
| `/pitture/` | Tutte le opere su due colonne, filtro per categoria | `/portfolio-tag/pitture/` |
| `/pitture/categoria/<categoria>/` | Acrilico, Spatola, Caffè | `/portfolio-category/…` |
| `/pitture/<opera>/` | Scheda: foto con zoom, titolo, descrizione, dimensioni, anno, tecnica, categoria, "Richiedi informazioni" | `/portfolio-item/<opera>/` |
| `/galleria/` | Tutte le opere su 3 colonne, zoom al passaggio del mouse | `/portfolio/` |
| `/contatti/` | Email e Instagram (modulo facoltativo, vedi sotto) | `/contatti-2/` |

I vecchi indirizzi rimandano automaticamente ai nuovi con un redirect 301, configurato in `deploy/snippets/redirects.conf`. Così Google e i link esistenti non finiscono su una pagina 404.

## Gestione dei contenuti

Tutti i contenuti sono file di testo in `src/content/`.

```
src/content/
├── opere/
│   └── lago-fatato/            ← una cartella per opera (il nome diventa l'indirizzo)
│       ├── index.md            ← scheda
│       └── lago-fatato.webp    ← fotografia
├── categorie.yaml              ← Acrilico, Spatola, Caffè
├── home/home.md                ← testi e immagini della homepage
└── pagine/chi-sono.md          ← biografia ed eventi
src/config/site.ts              ← email, Instagram, motto, voci di menu
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

## Deploy sul VPS (Docker)

```bash
docker compose up -d --build
```

Il container serve il sito su `127.0.0.1:8080`. Va collegato al reverse proxy già in uso sul VPS (Traefik, Caddy, nginx-proxy…), che gestisce il dominio e HTTPS, al posto del container WordPress. Per aggiornare il sito dopo una modifica:

```bash
git pull && docker compose up -d --build
```

L'immagine è in due fasi: la prima genera il sito con Node, la seconda contiene solo nginx e i file statici. Il container gira senza root, con filesystem in sola lettura. La configurazione di nginx è in `deploy/`:

- `nginx.conf`: cache di un anno per i file con hash, gzip, redirect agli indirizzi con "/" finale, pagina 404 personalizzata;
- `snippets/security-headers.conf`: Content-Security-Policy senza `unsafe-inline` per gli script, più gli altri header di sicurezza (HSTS va impostato sul reverse proxy);
- `snippets/redirects.conf`: vecchi indirizzi WordPress → nuovi. I percorsi `wp-admin`, `wp-login.php`, `xmlrpc.php` e simili rispondono `410 Gone`.

## Da decidere / completare

- [ ] **Modulo di contatto.** Il vecchio sito aveva un modulo (Contact Form 7). Un sito statico non può inviare email da solo, per cui ora la pagina Contatti mostra email e Instagram e ogni scheda ha "Richiedi informazioni" (email precompilata). Per riavere il modulo basta un servizio esterno (Formspree, Web3Forms…) o un piccolo endpoint sul VPS: si imposta `contactFormEndpoint` in `src/config/site.ts`.
- [ ] **Privacy policy.** Sul vecchio sito la pagina era vuota. Il nuovo sito non usa cookie né raccoglie dati, ma un'informativa resta consigliata (soprattutto se si attiva il modulo). Quando c'è il testo, si imposta `privacyUrl` e compare nel piè di pagina.
- [ ] **Foto a bassa risoluzione.** Alcuni originali caricati su WordPress sono piccoli: *La notte non era sola* (503 px), *Le radici della foresta* (563 px), *Soubtrette* (630 px), *Il riflesso della natura* (732 px) e la foto della premiazione in home (331 px). Se esistono foto migliori, basta sostituire il file nella cartella.
- [ ] **Dati mancanti.** L'anno è indicato solo per 9 opere su 22, la tecnica per 14. Si possono completare nei file `index.md`.
- [ ] **Testi riportati così com'erano.** Ecco alcuni possibili refusi da verificare:
  - "Soubtrette" (forse "Soubrette");
  - "A volta il ponte" (forse "A volte");
  - "Un opera evocativa" (forse "Un'opera");
  - il cognome della curatrice è scritto sia "Venturini" sia "Vetturini".
- [ ] La didascalia "Descrizione dell'evento qui sopra" in home era un testo segnaposto del tema e non è stata riportata.

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
  - la scheda ha il pulsante "Richiedi informazioni".
- Tutti i valori (colori, font, dimensioni) sono variabili CSS in `src/styles/global.css`.
