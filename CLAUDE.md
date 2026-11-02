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
  - JavaScript minimo e progressivo: tutto funziona anche senza;
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
  layouts/BaseLayout    <head>, header (3 varianti), piè di pagina, overlay (menu, ricerca), "Torna su"
  components/           un componente per ogni blocco del tema (header, carosello, masonry, marquee…)
  lib/opere.ts          query e helper delle opere: ordinamento, URL, alt, masonry calcolata in build
  lib/eventi.ts         voci degli eventi "Evento / luogo — dettagli"
  lib/inline-md.ts      *corsivo* e **grassetto** nei testi brevi del frontmatter (HTML sempre escapato)
  pages/                le rotte (elenco nel README › Pagine)
  scripts/overlays.ts   rende "modali" gli overlay Popover (inert + gestione del focus)
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
- **JavaScript**:
  - solo negli `<script>` di Astro, che diventano file esterni: la CSP non ammette script inline;
  - inline sono ammessi solo i blocchi JSON-LD e le speculation rules.
- **Funzionalità senza JS**:
  - Popover API per menu, ricerca e zoom;
  - View Transitions tra le pagine;
  - animazioni scroll-driven dentro `@supports`;
  - tutte le animazioni dentro `prefers-reduced-motion: no-preference`.
- **Nuovi campi dei contenuti**: vanno nello schema (`content.config.ts`), facoltativi e con un commento, e vanno documentati nel README.
- **Tipografia dei testi**: apostrofi tipografici (’) e lineette lunghe (—), come nei contenuti importati.

## Insidie note

- **Specificità negli stili scoped**: Astro aggiunge `[data-astro-cid-…]` a ogni selettore composto. Per questo `.a > *` ha più specificità di `.b` e la batte anche se `.b` sta in una media query successiva. Meglio usare selettori espliciti.
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

## Come verificare una modifica visiva

1. Eseguire `npm run check` e `npm run build`.
2. Fare screenshot con Playwright a 390, 1024, 1440 e 1920 px; se serve, confrontarli con il sito originale. Negli ambienti cloud Playwright è preinstallato: `require('playwright')` da uno script `.cjs`.
3. Controllare l'accessibilità con axe-core: lo standard del progetto è 0 violazioni (WCAG 2.1 AA e best practice).
4. Non cambiare i testi dell'artista senza dirlo. Si correggono solo refusi evidenti e si elencano nel README. Nomi e fatti dubbi si segnalano, senza modificarli.
