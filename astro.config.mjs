// @ts-check
import { defineConfig, fontProviders } from 'astro/config';
import sitemap from '@astrojs/sitemap';

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

  // Font del tema originale (Syne, Archivo, Cormorant Infant — licenza OFL), inclusi nel sito:
  // nessuna richiesta a Google. Astro genera fallback metrici per evitare salti di layout.
  fonts: [
    {
      provider: fontProviders.local(),
      name: 'Syne',
      cssVariable: '--font-syne',
      fallbacks: ['Arial', 'sans-serif'],
      options: {
        variants: [{ src: ['./src/assets/fonts/syne-latin.woff2'], weight: '400 800', style: 'normal' }],
      },
    },
    {
      provider: fontProviders.local(),
      name: 'Archivo',
      cssVariable: '--font-archivo',
      fallbacks: ['Arial', 'sans-serif'],
      options: {
        variants: [{ src: ['./src/assets/fonts/archivo-latin.woff2'], weight: '100 900', style: 'normal' }],
      },
    },
    {
      provider: fontProviders.local(),
      name: 'Cormorant Infant',
      cssVariable: '--font-cormorant',
      fallbacks: ['Georgia', 'serif'],
      options: {
        variants: [
          { src: ['./src/assets/fonts/cormorant-infant-latin.woff2'], weight: '300 700', style: 'normal' },
          { src: ['./src/assets/fonts/cormorant-infant-italic-latin.woff2'], weight: '300 700', style: 'italic' },
        ],
      },
    },
  ],
});
