import { getCollection, type CollectionEntry } from 'astro:content';
import { site } from '~/config/site';

export type Opera = CollectionEntry<'opere'>;
export type Tema = CollectionEntry<'temi'>;

/** Le bozze compaiono solo in sviluppo. */
const visibile = (o: Opera) => import.meta.env.DEV || !o.data.bozza;

/** Ordine: campo `ordine` (se presente), poi anno più recente, poi titolo. */
export function confrontaOpere(a: Opera, b: Opera): number {
  const oa = a.data.ordine ?? Number.POSITIVE_INFINITY;
  const ob = b.data.ordine ?? Number.POSITIVE_INFINITY;
  if (oa !== ob) return oa - ob;
  const ya = a.data.anno ?? Number.NEGATIVE_INFINITY;
  const yb = b.data.anno ?? Number.NEGATIVE_INFINITY;
  if (ya !== yb) return yb - ya;
  return a.data.titolo.localeCompare(b.data.titolo, 'it');
}

export async function getOpere(): Promise<Opera[]> {
  const opere = await getCollection('opere', visibile);
  return opere.sort(confrontaOpere);
}

export async function getOpereInEvidenza(max = 6): Promise<Opera[]> {
  const opere = await getOpere();
  const evidenza = opere.filter((o) => o.data.inEvidenza);
  return (evidenza.length ? evidenza : opere).slice(0, max);
}

export type TemaConOpere = { tema: Tema; opere: Opera[] };

/** Temi in ordine, ognuno con le sue opere; i temi vuoti vengono esclusi. */
export async function getTemiConOpere(): Promise<TemaConOpere[]> {
  const [temi, opere] = await Promise.all([getCollection('temi'), getOpere()]);
  return temi
    .sort((a, b) => a.data.ordine - b.data.ordine || a.data.titolo.localeCompare(b.data.titolo, 'it'))
    .map((tema) => ({ tema, opere: opere.filter((o) => o.data.tema.id === tema.id) }))
    .filter((t) => t.opere.length > 0);
}

export const urlOpera = (o: Opera) => `/pitture/${o.id}/`;

/** Nome per le View Transitions (immagine che "vola" dalla griglia alla scheda). */
export const vtName = (o: Opera) => `opera-${o.id.replace(/[^a-z0-9_-]/gi, '-')}`;
export const urlTema = (id: string) => `/pitture/tema/${id}/`;

/** "/01", "/02"… come nel tema originale. */
export const numero = (i: number) => `/${String(i + 1).padStart(2, '0')}`;

export function altOpera(o: Opera): string {
  if (o.data.alt) return o.data.alt;
  const parti = [o.data.titolo, o.data.tecnica, o.data.anno].filter(Boolean).join(', ');
  return `${parti} — opera di ${site.author}`;
}

/** Riga descrittiva breve: "2023 · Acrilico su tela · 70 × 50 cm" */
export function metaOpera(o: Opera): string {
  return [o.data.anno, o.data.tecnica, o.data.dimensioni].filter(Boolean).join(' · ');
}

export const etichettaDisponibilita: Record<NonNullable<Opera['data']['disponibilita']>, string> = {
  disponibile: 'Disponibile',
  venduta: 'Venduta',
  'collezione-privata': 'Collezione privata',
  'su-richiesta': 'Su richiesta',
};

/** Link email precompilato per richiedere informazioni o acquistare un'opera. */
export function mailtoOpera(o: Opera, motivo: 'info' | 'acquisto', pageUrl: string): string {
  const titolo = `"${o.data.titolo}"${o.data.anno ? ` (${o.data.anno})` : ''}`;
  const subject =
    motivo === 'acquisto' ? `Acquisto opera: ${o.data.titolo}` : `Informazioni sull'opera: ${o.data.titolo}`;
  const richiesta =
    motivo === 'acquisto'
      ? `sono interessato/a ad acquistare l'opera ${titolo}.`
      : `vorrei ricevere maggiori informazioni sull'opera ${titolo}.`;
  const body = `Buongiorno,\n\n${richiesta}\n${pageUrl}\n\nGrazie,\n`;
  return `mailto:${site.contatti.email}?subject=${encodeURIComponent(subject)}&body=${encodeURIComponent(body)}`;
}

export function whatsappOpera(o: Opera, pageUrl: string): string | undefined {
  if (!site.contatti.whatsapp) return undefined;
  const text = `Buongiorno, vorrei informazioni sull'opera "${o.data.titolo}": ${pageUrl}`;
  return `https://wa.me/${site.contatti.whatsapp}?text=${encodeURIComponent(text)}`;
}

/** "70 × 50 cm" → { larghezza: '70 cm', altezza: '50 cm' } (per i dati strutturati). */
export function parseDimensioni(dim?: string): { larghezza: string; altezza: string } | undefined {
  const m = dim?.match(/(\d+(?:[.,]\d+)?)\s*[x×]\s*(\d+(?:[.,]\d+)?)\s*(mm|cm|m)?/i);
  if (!m) return undefined;
  const unita = (m[3] ?? 'cm').toLowerCase();
  return { larghezza: `${m[1]} ${unita}`, altezza: `${m[2]} ${unita}` };
}

/**
 * Impaginazione "masonry" calcolata in fase di build: ogni opera va nella colonna più
 * corta, così le immagini mantengono le loro proporzioni senza buchi (come nel tema).
 * L'altezza è stimata in "larghezze di colonna": immagine + didascalia/spazio.
 */
export function colonneMasonry<T extends { item: Opera }>(
  voci: T[],
  colonne = 2,
  opzioni: { didascalia?: number; sfalsamento?: number } = {},
): T[][] {
  const { didascalia = 0.26, sfalsamento = 0.24 } = opzioni;
  const altezze = Array.from({ length: colonne }, (_, i) => (i === colonne - 1 && colonne > 1 ? sfalsamento : 0));
  const risultato: T[][] = Array.from({ length: colonne }, () => []);
  for (const voce of voci) {
    const { width, height } = voce.item.data.immagine;
    const col = altezze.indexOf(Math.min(...altezze));
    risultato[col]!.push(voce);
    altezze[col]! += height / width + didascalia;
  }
  return risultato;
}
