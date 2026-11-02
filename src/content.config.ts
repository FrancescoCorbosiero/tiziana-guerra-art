import { defineCollection, reference } from 'astro:content';
import { file, glob } from 'astro/loaders';
import { z } from 'astro/zod';

/**
 * OPERE — una cartella per opera:
 *
 *   src/content/opere/lago-fatato/index.md   ← scheda (frontmatter + testo)
 *   src/content/opere/lago-fatato/foto.jpg   ← fotografia (alta risoluzione)
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
      /** Tema (vedi src/content/temi.yaml). */
      tema: reference('temi'),
      anno: z.number().int().min(1900).max(2100).optional(),
      /** Es. "Acrilico su tela" */
      tecnica: z.string().optional(),
      /** Es. "70 × 50 cm" */
      dimensioni: z.string().optional(),
      /** Se assente, la scheda mostra solo "Richiedi informazioni". */
      disponibilita: z
        .enum(['disponibile', 'venduta', 'collezione-privata', 'su-richiesta'])
        .optional(),
      /** Mostrato solo se presente, es. "€ 450". */
      prezzo: z.string().optional(),
      /** Opere mostrate in homepage. */
      inEvidenza: z.boolean().default(false),
      /** Ordinamento manuale (numeri più bassi prima). Senza: per anno, dal più recente. */
      ordine: z.number().optional(),
      /** Fotografie aggiuntive: dettagli, opera incorniciata, ambientata… */
      dettagli: z
        .array(z.object({ immagine: image(), alt: z.string().optional() }))
        .default([]),
      /** Breve testo critico citato nella scheda. */
      citazione: z.object({ testo: z.string(), autore: z.string().optional() }).optional(),
      /** Le bozze sono visibili solo in sviluppo (npm run dev). */
      bozza: z.boolean().default(false),
    }),
});

/** TEMI — usati per suddividere le pitture (paesaggi, ritratti, astratti…). */
const temi = defineCollection({
  loader: file('./src/content/temi.yaml'),
  schema: z.object({
    titolo: z.string(),
    descrizione: z.string().optional(),
    ordine: z.number().default(100),
  }),
});

/** PAGINE — testi lunghi modificabili in Markdown (es. biografia "Chi sono"). */
const pagine = defineCollection({
  loader: glob({ pattern: '*.md', base: './src/content/pagine' }),
  schema: ({ image }) =>
    z.object({
      titolo: z.string(),
      sottotitolo: z.string().optional(),
      /** Riassunto mostrato in homepage. */
      estratto: z.string().optional(),
      immagine: image().optional(),
      immagineAlt: z.string().optional(),
      descrizioneSeo: z.string().optional(),
    }),
});

export const collections = { opere, temi, pagine };
