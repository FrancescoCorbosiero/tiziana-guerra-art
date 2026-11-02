import { defineCollection, reference } from 'astro:content';
import { file, glob } from 'astro/loaders';
import { z } from 'astro/zod';

/**
 * OPERE — una cartella per opera:
 *
 *   src/content/opere/lago-fatato/index.md         ← scheda (frontmatter + descrizione)
 *   src/content/opere/lago-fatato/lago-fatato.jpg  ← fotografia (alta risoluzione)
 *
 * Il nome della cartella diventa l'indirizzo: /pitture/lago-fatato/
 */
const opere = defineCollection({
  loader: glob({
    pattern: '**/index.md',
    base: './src/content/opere',
    generateId: ({ entry }) => entry.replace(/\/index\.md$/, ''),
  }),
  schema: ({ image }) =>
    z.object({
      titolo: z.string(),
      /** Fotografia principale, percorso relativo alla cartella dell'opera. */
      immagine: image(),
      /** Testo alternativo per chi non vede l'immagine. Se assente viene generato. */
      alt: z.string().optional(),
      /** Una o più categorie (vedi src/content/categorie.yaml), es. [acrilico, spatola]. */
      categorie: z.array(reference('categorie')).min(1),
      anno: z.number().int().min(1900).max(2100).optional(),
      /** Es. "Acrilico e Spatola" */
      tecnica: z.string().optional(),
      /** Es. "70 × 50 cm" */
      dimensioni: z.string().optional(),
      /** Se assente, la scheda mostra solo "Richiedi informazioni". */
      disponibilita: z.enum(['disponibile', 'venduta', 'collezione-privata', 'su-richiesta']).optional(),
      /** Mostrato solo se l'opera è disponibile, es. "€ 450". */
      prezzo: z.string().optional(),
      /** Opere del carosello in homepage (sul vecchio sito: tag "Verticali"). */
      inEvidenza: z.boolean().default(false),
      /** Ordinamento (numeri più bassi prima): è l'ordine della Galleria del sito WordPress. */
      ordine: z.number().optional(),
      /** Fotografie aggiuntive: dettagli, opera incorniciata, ambientata… */
      dettagli: z.array(z.object({ immagine: image(), alt: z.string().optional() })).default([]),
      /** Le bozze sono visibili solo in sviluppo (npm run dev). */
      bozza: z.boolean().default(false),
    }),
});

/** CATEGORIE — suddivisione delle pitture (Acrilico, Spatola, Caffè…). */
const categorie = defineCollection({
  loader: file('./src/content/categorie.yaml'),
  schema: z.object({
    titolo: z.string(),
    descrizione: z.string().optional(),
    ordine: z.number().default(100),
  }),
});

const voceEventi = z.object({ anno: z.number().int(), voci: z.array(z.string()) });

/**
 * Punto dell'immagine da tenere al centro quando viene ritagliata (CSS object-position),
 * es. "50% 30%" = centrata in orizzontale, un po' verso l'alto: utile per i ritratti.
 */
const posizioneRitaglio = z
  .string()
  .regex(/^(\d{1,3}%|left|center|right)\s+(\d{1,3}%|top|center|bottom)$/, 'Formato: "50% 30%" oppure "center top"')
  .optional();

/** HOME — testi e immagini della homepage (src/content/home/home.md). */
const home = defineCollection({
  loader: glob({ pattern: 'home.md', base: './src/content/home' }),
  schema: ({ image }) =>
    z.object({
      titolo: z.string(),
      descrizioneSeo: z.string().optional(),
      /** Le due opere sotto il titolo: un'immagine libera oppure un'opera della collezione. */
      hero: z
        .array(
          z.object({
            titolo: z.string(),
            immagine: image().optional(),
            opera: reference('opere').optional(),
          }),
        )
        .max(2),
      intro: z.object({
        titolo: z.string(),
        testo: z.string(),
        link: z.object({ testo: z.string(), href: z.string() }),
        immagine: image().optional(),
        immagineAlt: z.string().default(''),
      }),
      /** Frasi che scorrono in grande. */
      frasi: z.array(z.string()).default([]),
      chiSono: z.object({
        immagini: z
          .array(z.object({ immagine: image(), alt: z.string().default(''), posizione: posizioneRitaglio }))
          .max(2),
        blocchi: z.array(z.object({ titolo: z.string(), testo: z.string() })),
        eventi: z.object({ titolo: z.string(), anni: z.array(voceEventi) }),
      }),
    }),
});

/** PAGINE — testi lunghi in Markdown (es. biografia "Chi sono"). */
const pagine = defineCollection({
  loader: glob({ pattern: '*.md', base: './src/content/pagine' }),
  schema: ({ image }) =>
    z.object({
      titolo: z.string(),
      descrizioneSeo: z.string().optional(),
      intro: z
        .object({
          sopratitolo: z.string().optional(),
          titolo: z.string(),
          testo: z.string().optional(),
          testo2: z.string().optional(),
          immagine: image().optional(),
          immagineAlt: z.string().default(''),
          immaginePosizione: posizioneRitaglio,
        })
        .optional(),
      biografia: z.object({ sopratitolo: z.string().optional(), titolo: z.string() }).optional(),
      /** Riquadro "in evidenza" (premio) con un'opera della collezione. */
      evidenza: z
        .object({
          sopratitolo: z.string().optional(),
          /** Se assente si usa il titolo dell'opera. */
          titolo: z.string().optional(),
          /** Testo breve: ammessi *corsivo* e **grassetto**. */
          testo: z.string(),
          opera: reference('opere').optional(),
        })
        .optional(),
      eventi: z
        .object({
          sopratitolo: z.string().optional(),
          titolo: z.string(),
          immagine: image().optional(),
          immagineAlt: z.string().default(''),
          /** Breve didascalia sotto l'immagine (facoltativa). */
          didascalia: z.string().optional(),
          /** Voci: "Evento / luogo — dettagli" (vedi src/lib/eventi.ts). */
          anni: z.array(voceEventi),
        })
        .optional(),
    }),
});

export const collections = { opere, categorie, home, pagine };
