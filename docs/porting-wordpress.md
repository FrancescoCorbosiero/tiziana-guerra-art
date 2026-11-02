# Porting da WordPress: contesto e decisioni

La conversazione in cui è nato il porting è andata persa. Questo documento ne ricostruisce il contesto il 2 novembre 2026 a partire da tre fonti:

- la storia git;
- il codice;
- il sito WordPress, ancora online durante la ricostruzione.

Serve a capire **perché** il sito è fatto così prima di cambiarlo. Le istruzioni operative sono nel [README](../README.md) e in [CLAUDE.md](../CLAUDE.md).

## 1. Il sito di partenza

Dati rilevati dall'HTML pubblico di tizianaguerra.art (novembre 2026):

| Componente | Dettagli |
|---|---|
| CMS | WordPress 7.1.4 |
| Tema | **Ginevra** di Qode Interactive, con il tema child `ginevra-child` e il plugin `ginevra-core` (widget del tema) |
| Impaginazione | **Elementor** 3.35.3 e Qi Addons for Elementor |
| Slider della home | Slider Revolution 6.7.34 |
| Modulo di contatto | Contact Form 7, inviato tramite WP SMTP con **Amazon SES** |
| Cookie | Complianz GDPR (banner "Gestisci consenso") |
| SEO | Rank Math (`sitemap_index.xml`, dati strutturati) |
| Altro | Smash Balloon Instagram Feed |

Widget Elementor usati dalle pagine principali:

- **Home**:
  - Slider Revolution;
  - widget di `ginevra-core`: titolo di sezione, immagine singola, text marquee, portfolio list, info list, custom font, pulsante.
- **Chi sono**:
  - 4 titoli di sezione;
  - 3 blocchi di testo;
  - 3 immagini;
  - un titolo "custom font";
  - un divisore.

Indirizzi del vecchio sito, tutti reindirizzati (`deploy/snippets/redirects.conf`):

| Vecchio indirizzo | Contenuto |
|---|---|
| `/portfolio-item/<opera>/` | Schede delle opere |
| `/portfolio/` | Galleria |
| `/portfolio-tag/pitture/`, `/portfolio-tag/verticali/` | Elenchi per tag |
| `/portfolio-category/<categoria>/` | Elenchi per categoria |
| `/contatti-2/` | Contatti |
| `/privacy-policy-3/`, `/cookie-policy-ue/` | Privacy e cookie |
| `/ciao-mondo/`, `/work-in-progress/`, `/category/senza-categoria/` | Pagine di default di WordPress |

Non c'era accesso al pannello di WordPress. Testi e foto vengono dalle pagine pubbliche, scegliendo gli originali alla massima risoluzione disponibile. Lo stile viene dal CSS del tema, fornito da Francesco, e dalle misure prese sul sito live.

## 2. Obiettivi del porting

1. **Stesso aspetto**:
   - font, colori e misure del tema Ginevra;
   - pennellata gialla sotto i link;
   - menu a tutto schermo;
   - numerazione "/01";
   - pulsante circolare "Torna su".
2. **Niente da mantenere**: nessun PHP, database o plugin da aggiornare, quindi una superficie d'attacco minima.
3. **Velocità**:
   - immagini AVIF e WebP responsive;
   - pochi KB di JavaScript;
   - pagine precaricate al passaggio del mouse (Speculation Rules).
4. **Privacy**:
   - nessun cookie;
   - nessuna richiesta a terzi, nemmeno per i font;
   - quindi nessun banner dei cookie.
5. **Accessibilità** WCAG 2.1 AA e **SEO preservata**: redirect 301, sitemap, Open Graph, JSON-LD.
6. **Deploy semplice** su VPS con Docker, al posto del container WordPress, dietro il reverse proxy esistente.

## 3. Cronologia

### Sessione 1: 2 novembre 2026 ([PR #1](https://github.com/FrancescoCorbosiero/tiziana-guerra-art/pull/1), unita in `main`)

| Commit | Cosa |
|---|---|
| `c5a3ce5` | Repository inizializzato |
| `e905f97` | **Ricostruzione statica dagli screenshot.** Prima approssimazione dello stile (Archivo "esteso" al posto di Syne, Cormorant Garamond), tutte le pagine, schema dei contenuti, ricerca, SEO, Dockerfile, nginx con CSP, CI. Contenuti provvisori: 2 opere reali e 6 di esempio |
| `3178889` | **Import dei contenuti e allineamento al tema.** 22 opere con foto originali e nell'ordine della Galleria, home, Chi sono. Font reali (Syne, Archivo, Cormorant Infant), scala tipografica, colori e tempi delle animazioni del tema. Tre varianti di header, carosello, frasi scorrevoli, categorie multiple. Redirect verificati su nginx |
| `40cf44b` | **Modulo di contatto via AWS SES**: micro-servizio, test, job CI. Poi privacy policy, correzioni ai testi e `/cookie-policy-ue/` → `/privacy-policy/` |
| `c613926` | Branch di lavoro collegato a `main` |

### Sessione 2: 2 novembre 2026 (branch `claude/clever-thompson-vlmyg2`)

- **Contesto formalizzato**: `CLAUDE.md` e questo documento.
- **Chi sono reimpaginata**: il primo porting aveva copiato fedelmente anche i limiti dell'impaginazione fatta con Elementor (dettagli nel § 6).
- **Migliorie**:
  - dati strutturati `ProfilePage`, con la stessa entità `Person` (`/#artista`) in home, in Chi sono e come autrice delle opere;
  - punto di fuoco dei ritagli impostabile dai contenuti (`posizione`, `immaginePosizione`), usato per inquadrare il ritratto anche in home;
  - frecce ← → della tastiera per sfogliare le schede delle opere (`aria-keyshortcuts`);
  - foglio di stile per la stampa: solo i contenuti, senza header, menu e pulsanti;
  - link dalla biografia all'opera *Lago Fatato*.

## 4. Da WordPress ad Astro

| WordPress | Nuovo sito |
|---|---|
| CSS del tema Ginevra | Variabili e classi in `src/styles/global.css` più gli stili dei componenti |
| Pagine Elementor | Pagine `.astro` in `src/pages/` e testi in `src/content/` |
| Portfolio item, categorie e tag | Collezione `opere` e `categorie.yaml`. Il tag "Verticali" diventa `inEvidenza: true` |
| Slider Revolution (hero della home) | Hero statico con due opere e didascalie verticali |
| Portfolio list (carosello) | `Carousel.astro`: scroll-snap e circa 1 KB di JS per frecce e contatore |
| Text marquee | `Marquee.astro`, solo CSS |
| Info list (premi in home) | Elenco per anno in `index.astro` |
| Contact Form 7 + WP SMTP | `ContactForm.astro` e `server/contatti` (SES), funzionante anche senza JS |
| Complianz | Non serve più: il sito non usa cookie |
| Rank Math | `Seo.astro` (meta, Open Graph, JSON-LD), `@astrojs/sitemap`, redirect della vecchia sitemap |
| Ricerca di WordPress | `cerca.json` generato in build e overlay "Cerca" |
| Instagram Feed | Link al profilo. Un widget caricherebbe contenuti di terzi e richiederebbe il consenso |

## 5. Registro delle decisioni

| # | Decisione | Perché |
|---|---|---|
| D1 | **Astro statico, contenuti in Markdown/YAML con schema validato** al posto di un CMS | Sito piccolo e aggiornato di rado: zero manutenzione e zero costi. Gli errori nei contenuti fermano la build invece di arrivare online |
| D2 | **Font inclusi nel sito** (Fonts API di Astro, fallback metrici) | Nessuna richiesta a Google (GDPR) e nessun salto del layout al caricamento |
| D3 | **Popover API** per menu, ricerca e zoom; uno script li rende modali (`inert` più gestione del focus) | Funzionano senza JavaScript e sono accessibili |
| D4 | **Masonry calcolata in build** (`colonneMasonry`): ogni opera va nella colonna più corta | Niente JS né spostamenti di layout. Su mobile le opere restano in ordine |
| D5 | **Tre varianti di header come nel tema**: `switch` in home, `minimal` in Chi sono, `divided` altrove, più la barra compatta che compare scorrendo. Sotto i 1800px il logo va a sinistra | Fedeltà al tema. Menu e logo centrato non ci stanno sotto i 1800px |
| D6 | **Micro-servizio proprio per il modulo**, con SES | Stesso canale del vecchio WP SMTP e nessun servizio terzo in più. Campo trappola anti-spam, limite di 6 invii al minuto per IP, nessun dato salvato |
| D7 | **Redirect 301** per tutti gli indirizzi della vecchia sitemap; **410** per `wp-admin`, `xmlrpc.php` e simili | Google e i link esistenti arrivano alla pagina giusta. I bot che cercano falle di WordPress si arrendono prima |
| D8 | **CSP rigorosa**: script solo da file (`'self'`) più `'inline-speculation-rules'` | Niente `unsafe-inline` per gli script. Per questo il JS non viene mai messo inline |
| D9 | **Differenze volute** rispetto all'originale: Galleria a 3 colonne, filtro per categoria in Pitture, pulsante "Richiedi informazioni" nella scheda | Richieste nelle direttive iniziali o utili alla vendita |
| D10 | **Correzioni ai testi**: solo refusi evidenti, sempre elencati nel README. Nomi e fatti dubbi vanno segnalati, non cambiati | I testi sono dell'artista |
| D11 | **Chi sono: proporzioni corrette** al posto della fedeltà all'impaginazione Elementor (sessione 2) | Richiesta di Francesco. Stile e contenuti del tema restano invariati |
| D12 | **Voci degli eventi in formato "Evento / luogo — dettagli"** al posto di un formato strutturato più rigido | Il testo resta leggibile e modificabile come una riga. La pagina separa titolo e dettagli alla prima lineetta lunga |

## 6. Chi sono: prima e dopo

### Prima

Nel primo porting la pagina riproduceva fedelmente l'impaginazione Elementor:

- **Bordi non allineati**: il titolo stava su una griglia da 1647px, i contenuti su una da 1300px.
- **Ritratto tagliato**: l'originale è 625 × 1024, ma era ritagliato quasi quadrato (625 × 650) e la testa usciva dal riquadro.
- **Presentazione sbilanciata**: il testo stava in una colonna stretta (460px), allineata in alto, con un grande vuoto sotto.
- **Biografia illeggibile**: con una larghezza di 1140px le righe arrivavano a circa 150 caratteri, il doppio della misura comoda (60–75).
- **Chimera fuori scala**: a 1000px di larghezza dominava la pagina. Il testo diceva "con L'OPERA : CHIMERA".
- **Eventi senza gerarchia**: una quarantina di voci centrate, difficili da scorrere, soprattutto su telefono.

### Dopo

- **Griglia comune**: 12 colonne sul contenitore da 1300px, con tutto allineato allo stesso bordo sinistro. Da 769px blocchi affiancati, sul telefono impilati.
- **Presentazione**:
  - ritratto in 4:5 con il viso al centro del ritaglio (`immaginePosizione`);
  - testo centrato in verticale accanto al ritratto;
  - la frase in prima persona, in Cormorant Infant grande, diventa la "voce" della pagina.
- **Biografia**: titolo a sinistra e testo a destra, con circa 70 caratteri per riga e un capolettera dove il browser lo supporta.
- **Premio**:
  - fascia crema con l'opera e il testo affiancati;
  - dati dell'opera e pulsante "Scopri l'opera";
  - l'immagine passa alla scheda con una View Transition.
- **Eventi**:
  - timeline per anno, con titolo e dettagli separati;
  - l'anno resta in vista mentre si scorre la sua lista;
  - scorciatoie per anno (`/chi-sono/#eventi-2025`);
  - su desktop la locandina resta fissa a lato.

## 7. Contenuti: correzioni e dubbi

Correzioni già fatte, con i dettagli nel README:

- *Soubrette*;
- "A volte";
- "Un’opera";
- il cognome "Vetturini".

Nella sessione 2:

- "L’OPERA : CHIMERA" → "con l’opera *Chimera*";
- "Bac edition" → "BAC Edition", come nell'elenco degli eventi;
- la voce "27 Marzo — Mostra Personale…" è stata riordinata in "Mostra Personale… — 27 marzo", perché il titolo venga prima della data.

Da verificare con l'artista, quindi **non modificati**:

- "Josè **Von** Roy Dalì": nelle fonti italiane il nome compare di solito come "Josè **Van** Roy Dalì".
- "Galleria **Le Thuiller**, Parigi": forse la Galerie **Thuillier**.
- "Palazzo **Ivanchic**, Venezia": forse Palazzo **Ivancich**.

## 8. Verifiche

- **Sessione 1**: axe con 0 violazioni (WCAG 2.1 AA) su tutte le pagine; redirect provati su nginx.
- **Sessione 2**, su Chi sono:
  - axe con 0 violazioni a 1440px e a 390px;
  - screenshot a 390, 800, 1024, 1440 e 1920 px;
  - anno e locandina restano in vista scorrendo;
  - resa di stampa: 6 pagine A4.
- **Ogni volta**:
  - `astro check` con 0 errori;
  - build completa;
  - test del servizio contatti.

## 9. Idee per il futuro

- **Modifica dei contenuti senza git**: un editor web che lavora sui file del repository, come Pages CMS o Decap CMS. Può servire se l'artista vuole aggiornare le opere da sola.
- **Foto e dati delle opere**: foto più grandi per le opere a bassa risoluzione e i dati mancanti (anno, tecnica), come da README › Ancora aperto.
- **Vendita**: `disponibilita` e `prezzo` sono già previsti dallo schema. Basta compilarli.
- **Versione inglese**: possibile, visti i premi internazionali. Astro supporta l'i18n con le rotte per lingua.
