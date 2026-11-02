/**
 * Voci degli eventi (src/content/pagine/chi-sono.md, campo `eventi.anni[].voci`).
 *
 * Ogni voce è una riga di testo nella forma
 *
 *   "Premio Artisti nella Storia / Teatro Italia, Roma — targa e attestato di merito"
 *    └──────────────── titolo ────────────────────┘   └──────── dettaglio ────────┘
 *
 * La prima lineetta lunga " — " separa il titolo (evento e luogo) dai dettagli (premio,
 * menzione, curatori…), che nella pagina vengono mostrati più piccoli. Una lineetta dentro
 * un *corsivo* non conta. Le voci senza lineetta hanno solo il titolo.
 */
export type VoceEvento = { titolo: string; dettaglio: string };

export function dividiVoce(voce: string): VoceEvento {
  const separatore = /\s+[—–]\s+/g;
  for (let m = separatore.exec(voce); m; m = separatore.exec(voce)) {
    const prima = voce.slice(0, m.index);
    // numero pari di asterischi prima della lineetta = non siamo dentro un corsivo
    if ((prima.match(/\*/g)?.length ?? 0) % 2 === 0) {
      return { titolo: prima.trim(), dettaglio: voce.slice(m.index + m[0].length).trim() };
    }
  }
  return { titolo: voce.trim(), dettaglio: '' };
}

/** Ancora di un anno nella pagina Chi sono, es. "eventi-2025" (/chi-sono/#eventi-2025). */
export const ancoraAnno = (anno: number) => `eventi-${anno}`;
