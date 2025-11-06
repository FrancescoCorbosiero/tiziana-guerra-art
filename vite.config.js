import { defineConfig } from 'vite'
import laravel from 'laravel-vite-plugin'
import { wordpressPlugin, wordpressThemeJson } from '@roots/vite-plugin'
import autoprefixer from 'autoprefixer'
import cssnano from 'cssnano'
import postcssPresetEnv from 'postcss-preset-env'

export default defineConfig({
  base: '/app/themes/sage/public/build/',

  plugins: [
    laravel({
      input: [
        'resources/css/app.css',
        'resources/js/app.js',
        'resources/css/editor.css',
        'resources/js/editor.js',
      ],
      refresh: true,
    }),

    wordpressPlugin(),

    // Generate theme.json without Tailwind dependencies
    wordpressThemeJson({
      disableTailwindColors: true,
      disableTailwindFonts: true,
      disableTailwindFontSizes: true,
    }),
  ],

  build: {
    manifest: true,
    outDir: 'public/build',
    rollupOptions: {
      output: {
        manualChunks: {
          // Split vendor code
          'vendor': ['alpinejs'],
          // Split core functionality
          'core': [
            '/resources/js/core/theme-switcher.js',
            '/resources/js/core/navigation.js',
          ],
        },
      },
    },
    cssCodeSplit: true,
    minify: 'esbuild',
    target: 'es2020',
  },

  css: {
    devSourcemap: true,
    postcss: {
      plugins: [
        // Modern CSS features (stage 2)
        postcssPresetEnv({
          stage: 2,
          features: {
            'nesting-rules': true,
            'custom-properties': true,
            'color-function': true,
          },
        }),
        // Autoprefixer for browser compatibility
        autoprefixer(),
        // CSS minification (production only)
        ...(process.env.NODE_ENV === 'production'
          ? [cssnano({ preset: 'default' })]
          : []
        ),
      ],
    },
  },

  resolve: {
    alias: {
      '@scripts': '/resources/js',
      '@styles': '/resources/css',
      '@fonts': '/resources/fonts',
      '@images': '/resources/images',
    },
  },

  server: {
    host: '0.0.0.0',
    port: 5173,
    strictPort: true,
    hmr: {
      host: 'localhost',
    },
  },
})
