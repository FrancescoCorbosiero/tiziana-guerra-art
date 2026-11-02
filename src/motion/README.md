# Animazioni (`src/motion/`)

Il motore di animazioni del sito. Viene dal catalogo **alpacode-motion**
([FrancescoCorbosiero/alpacode-motion](https://github.com/FrancescoCorbosiero/alpacode-motion)). Il catalogo segue una regola precisa (D1): **è contesto, non una dipendenza**. Il codice si copia nel sito e si adatta; il repository non si installa.

## Da dove viene

| Parte | Origine | Note |
|---|---|---|
| `core/` | alpacode-motion `src/engine/core/` al commit `7b1a203` | Copiato com'è, tranne `scroll.ts` (vedi sotto) |
| `effects/reveal.ts`, `split-lines.ts` (+ `.css`), `_headings.ts`, `scrub.ts` | alpacode-motion `src/engine/effects/` al commit `7b1a203` | `scrub.ts` adattato (vedi sotto) |
| `effects/split-wipe.ts`, `clip.ts`, `hero-away.ts`, `hscroll.ts`, `kinetic.ts`, `lens.ts` (+ `.css`), `magnetic.ts`, `wordmark.ts` | Portati qui dai sorgenti citati nel catalogo, ai commit che il catalogo fissa: alpacode.it `0876836`, comunicazionecinofila `505c8c6` | Nel catalogo risultano ancora `src`. Ogni file cita le righe d'origine |
| `effects/years.ts` | Scritto per questo sito | Parente di `rail` |
| `config.ts`, `registry.ts`, `index.ts` | Scritti per questo sito, come prevede il catalogo | |

I commenti nel codice del motore sono in inglese, come nel catalogo, per poterlo riallineare facilmente con alpacode-motion.

## Dove sono usati

| Effetto | Cosa fa | Dove |
|---|---|---|
| intro CSS (`.intro-words`, `.intro-clip`, `.reveal` in `global.css`) | Sopra la piega: i titoli salgono parola per parola, le opere si aprono a sipario. Solo CSS | Titoli di tutte le pagine, opere dell'hero, scheda, banner |
| `hero-away` | Il titolo dell'hero si allontana e sfuma scorrendo | Home |
| `split-lines` / `split-wipe` | Le righe dei titoli salgono dalla maschera, oppure si scoprono da sinistra. Titoli vicini alternano le due mosse | Titoli di sezione sotto la piega |
| `reveal` | I blocchi salgono a gruppi | Paragrafi, opere delle griglie, voci degli eventi, colonne del footer |
| `clip` | La foto si apre da un ritaglio | Immagini sotto la piega (home, Chi sono, contatti) |
| `hscroll` | Galleria orizzontale guidata dallo scroll verticale, con barra e contatore. Stage sticky in CSS, nessun pin di GSAP | Carosello della home, solo su desktop |
| `kinetic` | Le righe delle frasi scorrono in versi opposti, solo mentre si scorre | Frasi della home |
| `scrub` | Le parole si accendono man mano che si leggono | Frase del footer, frase dell'artista in Chi sono |
| `years` | L'anno degli eventi che si stanno leggendo diventa scuro, con la pennellata sotto | Timeline di Chi sono |
| `lens` | Lente d'ingrandimento sul dipinto: pennellate e spatola da vicino | Scheda dell'opera, desktop con mouse |
| `magnetic` | L'elemento si lascia attirare dal puntatore | "Torna su", frecce del carosello |
| `wordmark` | Le lettere del nome salgono dalla maschera | Nome a tutta larghezza nel footer |

## Adattamenti rispetto al catalogo

Da riportare in alpacode-motion:

- **`core/scroll.ts`**: niente offset. Lenis 1.3 sottrae già lo `scroll-padding-top` del contenitore (`lenis.mjs`, `scrollTo`), e questo sito lo usa per la barra fissa. Con l'offset del core lo spazio veniva lasciato due volte.
- **`effects/scrub.ts`**, per WCAG:
  - opacità di partenza 0,5 invece di 0,16: le parole non ancora lette restano a 3:1 di contrasto (contro 1,37:1);
  - `aria: "none"` in SplitText: l'`aria-label` predefinito non è ammesso su un `<p>` (ARIA 1.2), e le parole divise in `span` si leggono uguali.
- **`effects/hscroll.ts`**: invece del `pin: true` dell'originale usa lo stage sticky in CSS (decisione D6 del catalogo). In più gestisce le frecce e il contatore e, quando un'opera riceve il focus con Tab, porta la pagina a quell'opera.
- **`effects/lens.ts`**:
  - il ticker gira solo mentre la lente è visibile (nota di porting del catalogo);
  - la lente appare solo sopra il dipinto, non sul passe-partout;
  - usa il file più grande disponibile nel formato scelto dal browser.

## Regole (dal catalogo)

- **Primo paint senza JavaScript**: sopra la piega il movimento è CSS. GSAP lavora sotto la piega.
- **Niente nascosto dal CSS**: gli effetti nascondono i blocchi con il JS, all'avvio e solo sotto la piega. Senza JavaScript la pagina è completa.
- **Riduzione del movimento**: niente Lenis, niente animazioni allo scroll, niente loader; ogni scena è nel suo stato finale.
- **Effetti di puntatore** (lente, magnetismo) solo con un mouse.
- **Una mossa forte per sezione**: sezioni vicine non ripetono la stessa mossa.
- **Stampa**: `global.css` mostra tutto ciò che il motore tiene nascosto.

## Peso

Il bundle con GSAP 3.15 (ScrollTrigger, SplitText), Lenis 1.3, il core e gli effetti pesa circa **57 KB gzip** (152 KB minificato). Il catalogo stima 53 KB per le sole librerie. Lo script è un modulo e non blocca il primo paint.

## Aggiungere un effetto

1. Partire dalla storia della sezione, non dal catalogo: scegliere una sola mossa che la racconti.
2. Copiare il modulo da alpacode-motion, oppure dal sorgente citato in `catalog.md`, in `effects/<id>.ts`, con il suo CSS dello stato finale.
3. Registrarlo in `registry.ts` e mettere l'attributo `data-*` nel markup. Le classi del sito si mappano in `config.ts`.
4. Verificare in quattro modi: riduzione del movimento, senza JavaScript, axe, stampa.
