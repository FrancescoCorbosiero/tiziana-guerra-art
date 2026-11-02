# CLAUDE.md

Contesto operativo per chi lavora su questo repository, persone o assistenti AI.

- Uso quotidiano (comandi, contenuti, deploy): [README](README.md).
- Storia del porting da WordPress, decisioni prese e motivazioni: [docs/porting-wordpress.md](docs/porting-wordpress.md).

## In breve

- **Cosa**: sito portfolio della pittrice **Tiziana Guerra** (nome d'arte **Angelart**): https://tizianaguerra.art.
- **Da dove viene**: WordPress con il tema **Ginevra** (Qode Interactive) e le pagine costruite con **Elementor**. È stato ricostruito come sito **statico** con **Astro 7**, conservando l'aspetto del tema.
- **Chi lo gestisce**: Francesco Corbosiero (sviluppatore), per conto dell'artista. Interfaccia, contenuti, codice e commit sono **in italiano**.
- **Principi**:
  - stessa estetica del tema Ginevra;
  - niente PHP, database o plugin;
  - JavaScript progressivo: tutto funziona anche senza. Le animazioni (motore alpacode-motion con GSAP e Lenis, circa 57 KB gzip) arricchiscono la pagina ma non servono per usarla;
  - nessun cookie né tracciamento, nessuna richiesta a server di terzi;
  - accessibilità WCAG 2.1 AA;
  - i vecchi URL di WordPress restano validi grazie ai redirect 301.

## Comandi

```bash
npm install
npm run dev        # http://localhost:4321 (con --background, o da un terminale non interattivo, resta in
                   # background: npx astro dev status|logs|stop; un lock impedisce di avviarne due)
npm run check      # tipi e schema dei contenuti (deve dare 0 errori)
npm run build      # sito in dist/ (circa 3 minuti: ricomprime ~500 varianti di immagini)
npm run preview    # serve dist/
cd server/contatti && npm install && npm test   # test del modulo di contatto
docker compose up -d --build                    # produzione (vedi README › Deploy)
```

Node ≥ 22.23.4, consigliato 24 (`.nvmrc`). La CI (`.github/workflows/ci.yml`) esegue `check`, `build` e i test del servizio contatti.

## Mappa del codice

```
src/
  config/site.ts        impostazioni: email, social, pseudonimo, menu, opera del menu a tutto schermo…
  content.config.ts     schema dei contenuti (zod): se un campo è sbagliato la build si ferma
  content/              opere/<slug>/index.md + foto, categorie.yaml, home/home.md, pagine/*.md
  layouts/BaseLayout    <head>, loader, banner, header (3 varianti), piè di pagina, overlay (menu, ricerca), "Torna su"
  components/           un componente per ogni blocco del tema (header, carosello, masonry, marquee…),
                        più Loader, Annuncio (banner), Parole (titoli divisi in parole per l'intro)
  lib/opere.ts          query e helper delle opere: ordinamento, URL, alt, masonry calcolata in build
  lib/eventi.ts         voci degli eventi "Evento / luogo — dettagli"
  lib/inline-md.ts      *corsivo* e **grassetto** nei testi brevi del frontmatter (HTML sempre escapato)
  pages/                le rotte (elenco nel README › Pagine)
  scripts/overlays.ts   rende "modali" gli overlay Popover (inert, focus, blocco dello scroll anche per Lenis)
  scripts/loader-gate.js  decide prima del primo paint se mostrare il loader (prima pagina della visita)
  motion/               motore di animazioni copiato da alpacode-motion e adattato (vedi motion/README.md)
  styles/global.css     design system: variabili del tema, tipografia, pennellata, overlay, stampa
server/contatti/        micro-servizio Node del modulo di contatto (AWS SES), con test node:test
deploy/                 nginx: cache, header di sicurezza e CSP, redirect WordPress → nuovo sito, 410 per wp-*
docs/                   documentazione di progetto
```

## Convenzioni

- **Lingua**: italiano per testi, commenti, nomi legati al dominio (`opera`, `categorie`, `voce`, `anno`, `ritratto`…) e messaggi di commit.
- **Formattazione**, in stile Prettier:
  - 2 spazi;
  - apici singoli;
  - circa 120 caratteri per riga;
  - virgole finali.
- **Impaginazione**:
  - tutte le sezioni stanno nel contenitore da 1300px (`.container`) e sulla griglia a 12 colonne `.grid-12` (da 769px, spazio `--grid-gap`): titoli, testi, immagini e piè di pagina partono dallo stesso bordo;
  - fanno eccezione solo le parti a tutta larghezza volute dal tema: header, carosello (che parte dal bordo del contenitore ed esce a destra) e frasi scorrevoli;
  - testi di lettura a 60–70 caratteri per riga (`max-width` in `ch`).
- **CSS**:
  - i valori del tema stanno nelle variabili di `global.css` (`--c-*`, `--f-*`, `--fs-*`, `--ease-*`);
  - ogni componente ha il suo `<style>` scoped;
  - classi in stile BEM con un prefisso per pagina, ad esempio `cs-` per Chi sono e `artwork__` per la scheda.
- **Breakpoint** ricorrenti:
  - 769px: tablet, due colonne;
  - 1025px: desktop, come nel tema;
  - 1800px: header con il logo al centro.
- **Immagini**:
  - sempre `<Picture>` con `formats={['avif', 'webp']}` e `fallbackFormat="jpg"`;
  - `widths` e `sizes` tarati sulla larghezza reale nel layout;
  - `priority` solo sull'immagine principale (LCP);
  - le foto non vengono mai ingrandite oltre l'originale.
- **Ritagli** (classe `.cover`): l'`aspect-ratio` va sul contenitore. Il punto di fuoco si imposta con `--pos`, letto dai campi `posizione` / `immaginePosizione` nei contenuti.
- **Opere**:
  - mai ritagliate: si mostrano intere;
  - nelle griglie l'anteprima è alta al massimo 1,6 volte la larghezza (`rapportoAnteprima` in `lib/opere.ts`); oltre, l'opera sta intera su un passe-partout crema;
  - nella scheda, da tablet, l'opera sta su un passe-partout con le sue proporzioni (`--r`, contenute tra 0,62 e 1,25) e alto al massimo quanto lo schermo (`--stage-max`).
- **JavaScript**:
  - solo negli `<script>` di Astro, che diventano file esterni: la CSP non ammette script inline;
  - inline sono ammessi solo i blocchi JSON-LD e le speculation rules.
- **Animazioni** (`src/motion/`, regole del catalogo alpacode-motion):
  - sopra la piega solo CSS (`.intro-words` con `<Parole>`, `.intro-clip`, `.reveal`); sotto la piega il motore, con gli attributi `data-*` (`data-reveal`, `data-split="lines|wipe"`, `data-clip`, `data-scrub`…);
  - una mossa forte per sezione; sezioni vicine non ripetono la stessa;
  - niente nascosto dal CSS: senza JS, con "riduci movimento" e in stampa la pagina è completa;
  - il codice di `src/motion/` è in inglese, come nel catalogo, per poterlo riallineare; le classi del sito si mappano in `motion/config.ts`.
- **Funzionalità senza JS**:
  - Popover API per menu, ricerca e zoom;
  - View Transitions tra le pagine;
  - animazioni scroll-driven dentro `@supports`;
  - tutte le animazioni dentro `prefers-reduced-motion: no-preference`.
- **Nuovi campi dei contenuti**: vanno nello schema (`content.config.ts`), facoltativi e con un commento, e vanno documentati nel README.
- **Tipografia dei testi**: apostrofi tipografici (’) e lineette lunghe (—), come nei contenuti importati.

## Insidie note

- **Specificità negli stili scoped**: Astro aggiunge `[data-astro-cid-…]` a ogni selettore composto. Per questo `.a > *` ha più specificità di `.b` e la batte anche se `.b` sta in una media query successiva. Meglio usare selettori espliciti.
- **Figli di `.grid-12`**: da 769px ogni figlio diretto va posizionato con `grid-column` anche sul tablet (per esempio `1 / -1`). Altrimenti finisce in una sola delle 12 colonne.
- **Slash finale**: `trailingSlash: 'always'` più il rewrite di nginx fanno sì che ogni link interno finisca con "/". Il rewrite esclude `/api/`, perché un redirect su una POST farebbe perdere il messaggio.
- **JavaScript sempre esterno**: `vite.build.assetsInlineLimit` impedisce di mettere il JS inline. Serve alla CSP.
- **Altezza degli header**:
  - `--header-h` vale 135px su desktop e 70px sotto i 1025px;
  - `--sticky-h` (70px) è l'altezza della barra compatta;
  - per il `top` degli elementi sticky usare queste variabili;
  - la barra compatta (`.sticky-header`) esiste solo da 1025px, sotto è l'header stesso a essere sticky.
- **Slug delle opere**: l'id di un'opera è il nome della sua cartella. Lo slug `soubtrette` (refuso del vecchio sito) resta così per non rompere i link; il titolo invece è corretto.
- **Ordine delle opere**: il campo `ordine` riproduce l'ordine della Galleria di WordPress.
- **Indice di ricerca**: `cerca.json` è generato in build. Se cambia la struttura delle opere, va aggiornato anche `src/pages/cerca.json.ts`.
- **Immagini in sviluppo**: in dev le immagini vengono generate al volo e sono lente. Per screenshot affidabili usare `npm run build && npm run preview`.
- **`clip-path` nei keyframes**: scrivere sempre entrambi gli estremi (`from` e `to`). Da `none` a `inset()` il browser non interpola: l'animazione salta a metà.
- **Lenis e `scroll-padding-top`**: Lenis 1.3 rispetta già lo `scroll-padding-top` di `html` (lo spazio per la barra fissa). Non aggiungere offset a `scrollTo`.
- **SplitText e ARIA**: per impostazione predefinita mette `aria-label` sull'elemento diviso, che su un `<p>` non è ammesso. Per i paragrafi divisi in parole usare `aria: "none"`.
- **Intro CSS e trasformazioni**: le intro usano `animation-fill-mode: backwards`, così a fine animazione lasciano libere le proprietà agli effetti allo scroll. Un elemento animato da un'intro non deve ricevere anche una trasformazione da GSAP: si anima l'interno (le parole), non il contenitore.
- **Classi su `<html>`**:
  - `con-loader`: messa da `loader-gate.js`, mostra il loader e ritarda le intro (`--intro-base`);
  - `has-motion`: messa dal motore quando parte;
  - `lenis`: messa da Lenis.
- **Banner e header della home**: su desktop l'header "switch" è sovrapposto alla pagina e scende sotto il banner tramite `--annuncio-top`.

## Come verificare una modifica visiva

1. Eseguire `npm run check` e `npm run build`.
2. Fare screenshot con Playwright a 390, 1024, 1440 e 1920 px; se serve, confrontarli con il sito originale. Negli ambienti cloud Playwright è preinstallato: `require('playwright')` da uno script `.cjs`. Accorgimenti:
   - per saltare il loader, mettere `sessionStorage.setItem('tg-loader', '1')` in un `addInitScript`;
   - per far partire gli effetti "once", scorrere a passi;
   - `page.click()` porta in vista l'elemento prima di cliccarlo, e così cambia la posizione dello scroll.
3. Controllare l'accessibilità con axe-core, dopo che le intro sono finite (circa 2,5 s). Lo standard del progetto è 0 violazioni (WCAG 2.1 AA e best practice).
4. Per le animazioni, provare anche con `reducedMotion: 'reduce'`, senza JavaScript e in stampa: la pagina deve essere sempre completa.
5. Non cambiare i testi dell'artista senza dirlo. Si correggono solo refusi evidenti e si elencano nel README. Nomi e fatti dubbi si segnalano, senza modificarli.
