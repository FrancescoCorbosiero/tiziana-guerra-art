import { getCollection, type CollectionEntry } from 'astro:content';
import { site } from '~/config/site';

export type Opera = CollectionEntry<'opere'>;
export type Categoria = CollectionEntry<'categorie'>;

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

export async function getOpereInEvidenza(max = 8): Promise<Opera[]> {
  const opere = await getOpere();
  const evidenza = opere.filter((o) => o.data.inEvidenza);
  return (evidenza.length ? evidenza : opere).slice(0, max);
}

export async function getOpera(id: string): Promise<Opera | undefined> {
  return (await getOpere()).find((o) => o.id === id);
}

export type CategoriaConOpere = { categoria: Categoria; opere: Opera[] };

/** Categorie in ordine, ognuna con le sue opere; le categorie vuote vengono escluse. */
export async function getCategorieConOpere(): Promise<CategoriaConOpere[]> {
  const [categorie, opere] = await Promise.all([getCollection('categorie'), getOpere()]);
  return categorie
    .sort((a, b) => a.data.ordine - b.data.ordine || a.data.titolo.localeCompare(b.data.titolo, 'it'))
    .map((categoria) => ({ categoria, opere: opere.filter((o) => o.data.categorie.some((c) => c.id === categoria.id)) }))
    .filter((c) => c.opere.length > 0);
}

export const urlOpera = (o: Opera) => `/pitture/${o.id}/`;
export const urlCategoria = (id: string) => `/pitture/categoria/${id}/`;

/** Nome per le View Transitions (immagine che "vola" dalla griglia alla scheda). */
export const vtName = (o: Opera) => `opera-${o.id.replace(/[^a-z0-9_-]/gi, '-')}`;

/**
 * Nelle griglie (Pitture, Galleria, correlate) un'anteprima non è mai più alta di 1,6 volte la sua
 * larghezza: le opere più verticali (es. 80 × 40 cm) restano intere, centrate su un passe-partout.
 */
export const RAPPORTO_MAX_ANTEPRIMA = 1.6;

export function rapportoAnteprima(o: Opera): number {
  const { width, height } = o.data.immagine;
  return Math.min(height / width, RAPPORTO_MAX_ANTEPRIMA);
}

/** "/01", "/02"… come nel tema originale. */
export const numero = (i: number) => `/${String(i + 1).padStart(2, '0')}`;

export function altOpera(o: Opera): string {
  if (o.data.alt) return o.data.alt;
  const parti = [o.data.titolo, o.data.tecnica, o.data.anno].filter(Boolean).join(', ');
  return `${parti} — opera di ${site.author}`;
}

/** Riga descrittiva breve: "2025 · Acrilico · 70 × 50 cm" */
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
  const { didascalia = 0.2, sfalsamento = 0 } = opzioni;
  const altezze = Array.from({ length: colonne }, (_, i) => (i === colonne - 1 && colonne > 1 ? sfalsamento : 0));
  const risultato: T[][] = Array.from({ length: colonne }, () => []);
  for (const voce of voci) {
    const col = altezze.indexOf(Math.min(...altezze));
    risultato[col]!.push(voce);
    altezze[col]! += rapportoAnteprima(voce.item) + didascalia;
  }
  return risultato;
}
