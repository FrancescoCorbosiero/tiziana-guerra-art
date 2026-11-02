// @ts-check
import { defineConfig, fontProviders } from 'astro/config';
import sitemap from '@astrojs/sitemap';

/** @param {string} pkg @param {string} file */
const fontsource = (pkg, file) => `./node_modules/@fontsource-variable/${pkg}/files/${file}`;

export default defineConfig({
  site: 'https://tizianaguerra.art',
  trailingSlash: 'always',
  build: {
    format: 'directory',
    // CSS piccolo: inline nella pagina = una richiesta in meno sul percorso critico.
    inlineStylesheets: 'auto',
  },
  integrations: [sitemap()],

  vite: {
    build: {
      // Script sempre in file esterni: permette una Content-Security-Policy senza 'unsafe-inline'.
      assetsInlineLimit: (filePath) => (filePath.endsWith('.js') ? false : undefined),
    },
  },

  image: {
    service: {
      entrypoint: 'astro/assets/services/sharp',
      config: {
        // Qualità alta: sono fotografie di dipinti, le pennellate devono restare leggibili.
        avif: { quality: 62, effort: 4 },
        webp: { quality: 82, effort: 4 },
        jpeg: { quality: 84, mozjpeg: true, progressive: true },
      },
    },
  },

  // Font self-hosted (nessuna richiesta a Google: GDPR-friendly), con fallback metrici
  // generati da Astro per evitare salti di layout al caricamento.
  fonts: [
    {
      provider: fontProviders.local(),
      name: 'Archivo',
      cssVariable: '--font-archivo',
      fallbacks: ['Arial', 'sans-serif'],
      options: {
        variants: [
          {
            src: [fontsource('archivo', 'archivo-latin-standard-normal.woff2')],
            weight: '100 900',
            stretch: '62% 125%',
            style: 'normal',
          },
        ],
      },
    },
    {
      provider: fontProviders.local(),
      name: 'Cormorant Garamond',
      cssVariable: '--font-cormorant',
      fallbacks: ['Georgia', 'serif'],
      options: {
        variants: [
          {
            src: [fontsource('cormorant-garamond', 'cormorant-garamond-latin-wght-normal.woff2')],
            weight: '300 700',
            style: 'normal',
          },
          {
            src: [fontsource('cormorant-garamond', 'cormorant-garamond-latin-wght-italic.woff2')],
            weight: '300 700',
            style: 'italic',
          },
        ],
      },
    },
  ],
});
