import type { APIRoute } from 'astro';
import { getImage } from 'astro:assets';
import { getEntry } from 'astro:content';
import { getOpere, urlOpera } from '~/lib/opere';

/** Indice per la ricerca (generato in fase di build, caricato solo quando si apre "Cerca"). */
export const GET: APIRoute = async () => {
  const opere = await getOpere();
  const normalizza = (s: string) =>
    s
      .normalize('NFD')
      .replace(/\p{Diacritic}/gu, '')
      .toLowerCase();

  const voci = await Promise.all(
    opere.map(async (o) => {
      const tema = await getEntry(o.data.tema);
      const miniatura = await getImage({ src: o.data.immagine, width: 144, height: 144, fit: 'cover', format: 'webp' });
      const meta = [o.data.anno, o.data.tecnica, o.data.dimensioni].filter(Boolean).join(' · ');
      const testo = [o.data.titolo, tema?.data.titolo, meta, o.body ?? ''].join(' ');
      return {
        t: o.data.titolo,
        u: urlOpera(o),
        i: miniatura.src,
        n: tema?.data.titolo ?? '',
        m: meta,
        s: normalizza(testo).replace(/\s+/g, ' '),
      };
    }),
  );

  return new Response(JSON.stringify(voci), {
    headers: { 'Content-Type': 'application/json; charset=utf-8' },
  });
};
