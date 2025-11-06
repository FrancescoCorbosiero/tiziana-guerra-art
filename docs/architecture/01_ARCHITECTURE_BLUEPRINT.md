# 🏗️ Alpacode Studio Theme - Premium Architecture Blueprint
## Enterprise-Grade Sage 10+ Theme | CSS4-First | Performance-Obsessed

---

## 📋 Executive Summary

**Goal:** Transform the Sage 10 theme into a premium, production-ready foundation that serves both as Alpacode Studio's showcase AND a reusable client base theme.

**Philosophy:** 
- **Portability First** - Core files work with ANY Sage 10+ project
- **CSS4 Native** - Modern CSS features, minimal dependencies
- **Performance Budget** - Lighthouse 95+, FCP <1.5s
- **Developer Experience** - Clear separation of concerns, intuitive patterns
- **Client Flexibility** - Protected design system + editable content zones

---

## 🎯 Architecture Principles

### 1. **Separation of Concerns**

```
┌─────────────────────────────────────────────────────────┐
│ PORTABLE CORE (Sage 10+ Compatible)                    │
│ ─────────────────────────────────────────────────────── │
│ • functions.php                                         │
│ • app/setup.php                                         │
│ • app/Providers/ThemeServiceProvider.php               │
│ • resources/css/app.css (design system only)           │
│ • resources/js/app.js (core functionality)             │
│ • resources/views/layouts/app.blade.php                │
└─────────────────────────────────────────────────────────┘
                          ↓
┌─────────────────────────────────────────────────────────┐
│ PROJECT-SPECIFIC LAYER                                  │
│ ─────────────────────────────────────────────────────── │
│ • resources/views/sections/* (hardcoded UI)            │
│ • resources/views/components/* (reusable elements)     │
│ • resources/css/sections/* (scoped styles)             │
│ • resources/js/sections/* (component logic)            │
└─────────────────────────────────────────────────────────┘
```

### 2. **CSS4-First Architecture**

**NO MORE TAILWIND BLOAT** - Pure CSS4 with:
- CSS Custom Properties (design tokens)
- CSS Layers (@layer) for cascade control
- CSS Nesting (native, no preprocessor)
- Container Queries for true component isolation
- CSS Grid/Flexbox modern layout
- View Transitions API for smoothness
- Fluid typography with clamp()

### 3. **Performance-First Patterns**

- **Critical CSS Inlining** - Above-the-fold styles inline
- **Lazy Loading** - Components load on-demand
- **Code Splitting** - Route-based JS chunks
- **Progressive Enhancement** - Works without JS
- **Web Font Optimization** - WOFF2, preload, font-display
- **Image Optimization** - WebP, AVIF, lazy loading
- **Minimal Dependencies** - Alpine.js ONLY for interactivity

---

## 📁 File Structure (Refactored)

```
alpacode-theme/
│
├── functions.php                    [PORTABLE] Theme bootstrapper
├── style.css                        [PORTABLE] WordPress metadata only
│
├── app/
│   ├── setup.php                    [PORTABLE] WordPress hooks & theme support
│   ├── filters.php                  [PORTABLE] WordPress filters
│   ├── helpers.php                  [NEW] Pure PHP helper functions
│   │
│   ├── Providers/
│   │   └── ThemeServiceProvider.php [PORTABLE] Service container
│   │
│   ├── Services/                    [NEW] Business logic layer
│   │   ├── DesignSystemService.php  → Design token management
│   │   ├── PerformanceService.php   → Critical CSS, preloading, caching
│   │   ├── SeoService.php           → Meta tags, Schema.org, OG
│   │   ├── I18nService.php          → Translation management
│   │   └── AssetService.php         → Smart asset loading
│   │
│   └── ViewComposers/               [NEW] Data binding for Blade
│       ├── GlobalComposer.php       → Site-wide data
│       ├── NavigationComposer.php   → Menu data
│       └── SectionComposer.php      → Section-specific data
│
├── resources/
│   ├── css/
│   │   ├── app.css                  [PORTABLE] Main entry (design system)
│   │   ├── editor.css               [PORTABLE] Gutenberg editor styles
│   │   │
│   │   ├── foundation/              [NEW] CSS4 Design System
│   │   │   ├── _tokens.css          → CSS custom properties (colors, spacing, etc.)
│   │   │   ├── _reset.css           → Modern CSS reset
│   │   │   ├── _typography.css      → Fluid type scale
│   │   │   ├── _layout.css          → Grid systems, containers
│   │   │   ├── _utilities.css       → Minimal utility classes
│   │   │   └── _animations.css      → Transitions, keyframes
│   │   │
│   │   ├── components/              [PROJECT] Component-scoped styles
│   │   │   ├── _button.css
│   │   │   ├── _card.css
│   │   │   ├── _form.css
│   │   │   └── _navigation.css
│   │   │
│   │   └── sections/                [PROJECT] Section-specific styles
│   │       ├── _hero.css
│   │       ├── _features.css
│   │       └── _footer.css
│   │
│   ├── js/
│   │   ├── app.js                   [PORTABLE] Main entry (core features)
│   │   ├── editor.js                [PORTABLE] Gutenberg enhancements
│   │   │
│   │   ├── core/                    [NEW] Core functionality
│   │   │   ├── theme-switcher.js    → Dark/light mode
│   │   │   ├── navigation.js        → Enhanced nav with prefetch
│   │   │   ├── view-transitions.js  → SPA-like navigation
│   │   │   ├── performance.js       → Web Vitals tracking
│   │   │   └── accessibility.js     → A11y enhancements
│   │   │
│   │   ├── components/              [PROJECT] Component logic
│   │   │   ├── modal.js
│   │   │   ├── accordion.js
│   │   │   └── slider.js
│   │   │
│   │   └── utils/                   [NEW] Utility functions
│   │       ├── dom.js               → DOM helpers
│   │       ├── events.js            → Event delegation
│   │       └── api.js               → Fetch wrappers
│   │
│   ├── views/
│   │   ├── layouts/
│   │   │   └── app.blade.php        [PORTABLE] Master layout
│   │   │
│   │   ├── templates/               [PORTABLE] WordPress templates
│   │   │   ├── index.blade.php      → Blog index
│   │   │   ├── single.blade.php     → Single post
│   │   │   ├── page.blade.php       → Default page
│   │   │   └── 404.blade.php        → Error page
│   │   │
│   │   ├── partials/                [PORTABLE] Reusable partials
│   │   │   ├── header.blade.php
│   │   │   ├── footer.blade.php
│   │   │   └── sidebar.blade.php
│   │   │
│   │   ├── components/              [PROJECT] UI components
│   │   │   ├── button.blade.php
│   │   │   ├── card.blade.php
│   │   │   ├── modal.blade.php
│   │   │   └── alert.blade.php
│   │   │
│   │   └── sections/                [PROJECT] Full sections
│   │       ├── hero.blade.php
│   │       ├── features.blade.php
│   │       ├── testimonials.blade.php
│   │       └── cta.blade.php
│   │
│   └── fonts/                       [NEW] Self-hosted web fonts
│       └── inter/                   → Inter variable font
│
├── config/                          [NEW] Configuration files
│   ├── theme.php                    → Theme settings
│   ├── performance.php              → Performance config
│   └── i18n.php                     → Translation config
│
├── languages/                       [NEW] Translation files
│   ├── sage.pot                     → Template file
│   ├── it_IT.po                     → Italian translation
│   └── en_US.po                     → English translation
│
└── public/                          [BUILD OUTPUT]
    └── build/                       → Vite compiled assets
```

---

## 🎨 Design System Architecture

### CSS4 Token System

**File: `resources/css/foundation/_tokens.css`**

```css
@layer tokens {
  :root {
    /* ═══════════════════════════════════════════════════
       COLOR SYSTEM - High Contrast, Accessible
       ═══════════════════════════════════════════════════ */
    
    /* Neutral palette (9.0:1 contrast minimum) */
    --color-neutral-0: oklch(100% 0 0);        /* Pure white */
    --color-neutral-50: oklch(98% 0 0);
    --color-neutral-100: oklch(96% 0 0);
    --color-neutral-200: oklch(90% 0 0);
    --color-neutral-300: oklch(80% 0 0);
    --color-neutral-400: oklch(65% 0 0);
    --color-neutral-500: oklch(50% 0 0);
    --color-neutral-600: oklch(40% 0 0);
    --color-neutral-700: oklch(30% 0 0);
    --color-neutral-800: oklch(20% 0 0);
    --color-neutral-900: oklch(15% 0 0);
    --color-neutral-1000: oklch(10% 0 0);      /* Near black */
    
    /* Brand colors (Alpacode Studio) */
    --color-brand-primary: oklch(60% 0.15 250);   /* Deep blue */
    --color-brand-secondary: oklch(70% 0.12 180); /* Teal accent */
    --color-brand-accent: oklch(75% 0.18 120);    /* Fresh green */
    
    /* Semantic colors */
    --color-success: oklch(65% 0.15 145);
    --color-warning: oklch(75% 0.15 85);
    --color-error: oklch(60% 0.20 25);
    --color-info: oklch(65% 0.12 240);
    
    /* Surface colors (adaptive for light/dark) */
    --color-surface-base: var(--color-neutral-0);
    --color-surface-raised: var(--color-neutral-50);
    --color-surface-overlay: var(--color-neutral-100);
    
    /* Text colors (high contrast) */
    --color-text-primary: var(--color-neutral-1000);
    --color-text-secondary: var(--color-neutral-700);
    --color-text-tertiary: var(--color-neutral-500);
    --color-text-inverse: var(--color-neutral-0);
    
    /* ═══════════════════════════════════════════════════
       TYPOGRAPHY - Fluid Scale
       ═══════════════════════════════════════════════════ */
    
    /* Font families */
    --font-family-base: 'Inter Variable', system-ui, sans-serif;
    --font-family-mono: 'JetBrains Mono', 'Fira Code', monospace;
    
    /* Fluid type scale (min 375px → max 1920px) */
    --font-size-xs: clamp(0.75rem, 0.7rem + 0.25vw, 0.875rem);
    --font-size-sm: clamp(0.875rem, 0.8rem + 0.375vw, 1rem);
    --font-size-base: clamp(1rem, 0.9rem + 0.5vw, 1.125rem);
    --font-size-lg: clamp(1.125rem, 1rem + 0.625vw, 1.25rem);
    --font-size-xl: clamp(1.25rem, 1.1rem + 0.75vw, 1.5rem);
    --font-size-2xl: clamp(1.5rem, 1.3rem + 1vw, 2rem);
    --font-size-3xl: clamp(1.875rem, 1.6rem + 1.375vw, 2.5rem);
    --font-size-4xl: clamp(2.25rem, 1.9rem + 1.75vw, 3rem);
    --font-size-5xl: clamp(3rem, 2.5rem + 2.5vw, 4rem);
    --font-size-6xl: clamp(3.75rem, 3rem + 3.75vw, 5rem);
    
    /* Line heights */
    --line-height-tight: 1.2;
    --line-height-snug: 1.375;
    --line-height-normal: 1.5;
    --line-height-relaxed: 1.625;
    --line-height-loose: 2;
    
    /* Font weights */
    --font-weight-light: 300;
    --font-weight-normal: 400;
    --font-weight-medium: 500;
    --font-weight-semibold: 600;
    --font-weight-bold: 700;
    
    /* Letter spacing */
    --letter-spacing-tight: -0.025em;
    --letter-spacing-normal: 0;
    --letter-spacing-wide: 0.025em;
    
    /* ═══════════════════════════════════════════════════
       SPACING - Harmonious Scale
       ═══════════════════════════════════════════════════ */
    
    --space-3xs: clamp(0.25rem, 0.2rem + 0.25vw, 0.375rem);
    --space-2xs: clamp(0.5rem, 0.45rem + 0.25vw, 0.625rem);
    --space-xs: clamp(0.75rem, 0.7rem + 0.25vw, 0.875rem);
    --space-sm: clamp(1rem, 0.9rem + 0.5vw, 1.25rem);
    --space-md: clamp(1.5rem, 1.35rem + 0.75vw, 1.875rem);
    --space-lg: clamp(2rem, 1.8rem + 1vw, 2.5rem);
    --space-xl: clamp(3rem, 2.7rem + 1.5vw, 3.75rem);
    --space-2xl: clamp(4rem, 3.6rem + 2vw, 5rem);
    --space-3xl: clamp(6rem, 5.4rem + 3vw, 7.5rem);
    
    /* ═══════════════════════════════════════════════════
       LAYOUT - Containers & Breakpoints
       ═══════════════════════════════════════════════════ */
    
    --container-xs: 40rem;      /* 640px */
    --container-sm: 48rem;      /* 768px */
    --container-md: 64rem;      /* 1024px */
    --container-lg: 80rem;      /* 1280px */
    --container-xl: 90rem;      /* 1440px */
    --container-2xl: 100rem;    /* 1600px */
    
    --gutter: var(--space-md);
    
    /* ═══════════════════════════════════════════════════
       BORDERS & RADIUS
       ═══════════════════════════════════════════════════ */
    
    --border-width-thin: 1px;
    --border-width-medium: 2px;
    --border-width-thick: 4px;
    
    --radius-sm: 0.25rem;
    --radius-md: 0.5rem;
    --radius-lg: 1rem;
    --radius-xl: 1.5rem;
    --radius-full: 9999px;
    
    /* ═══════════════════════════════════════════════════
       SHADOWS - Subtle Depth
       ═══════════════════════════════════════════════════ */
    
    --shadow-sm: 0 1px 2px 0 oklch(0% 0 0 / 0.05);
    --shadow-md: 0 4px 6px -1px oklch(0% 0 0 / 0.1);
    --shadow-lg: 0 10px 15px -3px oklch(0% 0 0 / 0.1);
    --shadow-xl: 0 20px 25px -5px oklch(0% 0 0 / 0.1);
    
    /* ═══════════════════════════════════════════════════
       TRANSITIONS - Smooth & Natural
       ═══════════════════════════════════════════════════ */
    
    --duration-fast: 150ms;
    --duration-base: 250ms;
    --duration-slow: 350ms;
    --duration-slower: 500ms;
    
    --easing-linear: linear;
    --easing-in: cubic-bezier(0.4, 0, 1, 1);
    --easing-out: cubic-bezier(0, 0, 0.2, 1);
    --easing-in-out: cubic-bezier(0.4, 0, 0.2, 1);
    --easing-bounce: cubic-bezier(0.68, -0.55, 0.265, 1.55);
    
    /* ═══════════════════════════════════════════════════
       Z-INDEX - Layering System
       ═══════════════════════════════════════════════════ */
    
    --z-base: 0;
    --z-dropdown: 100;
    --z-sticky: 200;
    --z-fixed: 300;
    --z-modal-backdrop: 400;
    --z-modal: 500;
    --z-popover: 600;
    --z-tooltip: 700;
  }
  
  /* ═════════════════════════════════════════════════════
     DARK MODE TOKENS
     ═════════════════════════════════════════════════════ */
  
  [data-theme="dark"] {
    /* Inverted surfaces */
    --color-surface-base: var(--color-neutral-1000);
    --color-surface-raised: var(--color-neutral-900);
    --color-surface-overlay: var(--color-neutral-800);
    
    /* Inverted text */
    --color-text-primary: var(--color-neutral-0);
    --color-text-secondary: var(--color-neutral-300);
    --color-text-tertiary: var(--color-neutral-500);
    --color-text-inverse: var(--color-neutral-1000);
    
    /* Adjusted brand colors for dark mode */
    --color-brand-primary: oklch(70% 0.15 250);
    --color-brand-secondary: oklch(75% 0.12 180);
    --color-brand-accent: oklch(80% 0.18 120);
    
    /* Softer shadows for dark mode */
    --shadow-sm: 0 1px 2px 0 oklch(0% 0 0 / 0.3);
    --shadow-md: 0 4px 6px -1px oklch(0% 0 0 / 0.4);
    --shadow-lg: 0 10px 15px -3px oklch(0% 0 0 / 0.5);
    --shadow-xl: 0 20px 25px -5px oklch(0% 0 0 / 0.6);
  }
}
```

---

## 🔧 Service Layer Architecture

### DesignSystemService.php

**Purpose:** Centralize design token management, CSS generation, theming

**Responsibilities:**
- Generate CSS custom properties dynamically
- Handle theme switching (light/dark/auto)
- Provide token values to PHP/Blade templates
- Critical CSS extraction

**Key Methods:**
```php
public function getTokens(): array
public function getCriticalCss(): string
public function generateThemeCss(string $theme): string
public function inlineTokens(): void
```

### PerformanceService.php

**Purpose:** Optimize asset loading, caching, preloading

**Responsibilities:**
- Critical CSS inlining
- Resource hints (preload, prefetch, preconnect)
- Asset versioning & cache busting
- Lazy loading setup
- Web Vitals tracking

**Key Methods:**
```php
public function getCriticalCss(): string
public function preloadAssets(array $assets): void
public function generateResourceHints(): string
public function setupLazyLoading(): void
```

### SeoService.php

**Purpose:** Handle all SEO-related meta tags, Schema.org markup

**Responsibilities:**
- Meta tags (OG, Twitter Card)
- Schema.org JSON-LD
- Canonical URLs
- Breadcrumbs
- Sitemap generation

**Key Methods:**
```php
public function getMetaTags(): string
public function getSchemaMarkup(): string
public function getBreadcrumbs(): array
```

### I18nService.php

**Purpose:** Manage translations, locale detection, RTL support

**Responsibilities:**
- Load translation files
- Detect user locale
- Provide translation helpers for Blade
- RTL layout switching

**Key Methods:**
```php
public function getLocale(): string
public function translate(string $key, array $replace = []): string
public function isRtl(): bool
```

### AssetService.php

**Purpose:** Smart asset enqueueing with dependencies

**Responsibilities:**
- Conditional asset loading (only load what's needed)
- Defer/async script loading
- Module/nomodule pattern for modern JS
- CSS/JS splitting per page template

**Key Methods:**
```php
public function enqueueConditional(string $handle, callable $condition): void
public function deferScript(string $handle): void
public function getPageAssets(string $template): array
```

---

## 🎭 View Composer Pattern

**File: `app/ViewComposers/GlobalComposer.php`**

```php
<?php

namespace App\ViewComposers;

use Roots\Acorn\View\Composer;
use App\Services\DesignSystemService;
use App\Services\SeoService;
use App\Services\I18nService;

class GlobalComposer extends Composer
{
    protected static $views = ['*'];
    
    public function __construct(
        protected DesignSystemService $designSystem,
        protected SeoService $seo,
        protected I18nService $i18n
    ) {}
    
    public function with()
    {
        return [
            'siteName' => get_bloginfo('name'),
            'siteDescription' => get_bloginfo('description'),
            'currentUrl' => home_url(add_query_arg(null, null)),
            'locale' => $this->i18n->getLocale(),
            'isRtl' => $this->i18n->isRtl(),
            'theme' => $this->designSystem->getCurrentTheme(),
            'metaTags' => $this->seo->getMetaTags(),
            'schemaMarkup' => $this->seo->getSchemaMarkup(),
        ];
    }
}
```

---

## 🚀 Performance Optimizations

### 1. Critical CSS Strategy

**Inline critical CSS in `<head>`:**
- Above-the-fold styles only
- Design tokens (for FOUC prevention)
- Layout structure (container, grid)
- Typography base

**Defer non-critical CSS:**
```html
<link rel="preload" as="style" href="/app.css" onload="this.onload=null;this.rel='stylesheet'">
<noscript><link rel="stylesheet" href="/app.css"></noscript>
```

### 2. JavaScript Loading Strategy

```html
<!-- Core (critical, defer) -->
<script type="module" src="/app.js" defer></script>

<!-- Legacy fallback (nomodule) -->
<script nomodule src="/app.legacy.js" defer></script>

<!-- Section-specific (lazy load) -->
<script type="module" src="/sections/hero.js" defer></script>
```

### 3. Image Optimization Pattern

```blade
<picture>
  <source 
    srcset="/image.avif" 
    type="image/avif"
  >
  <source 
    srcset="/image.webp" 
    type="image/webp"
  >
  <img 
    src="/image.jpg" 
    loading="lazy"
    decoding="async"
    width="800" 
    height="600"
    alt="Description"
  >
</picture>
```

### 4. Font Loading Strategy

```css
@font-face {
  font-family: 'Inter Variable';
  src: url('/fonts/inter/inter-variable.woff2') format('woff2-variations');
  font-weight: 100 900;
  font-display: swap;
  font-named-instance: 'Regular';
}
```

```html
<!-- Preload critical fonts -->
<link rel="preload" href="/fonts/inter/inter-variable.woff2" as="font" type="font/woff2" crossorigin>
```

---

## 🌐 Internationalization (i18n)

### Translation File Structure

**File: `languages/it_IT.po`**
```po
msgid "Read more"
msgstr "Leggi di più"

msgid "Contact us"
msgstr "Contattaci"

msgctxt "navigation"
msgid "Menu"
msgstr "Menu"
```

### Blade Translation Helper

```blade
{{ __('Read more', 'sage') }}
{{ _x('Menu', 'navigation', 'sage') }}
{{ _n('1 item', '%d items', $count, 'sage') }}
```

### Config File: `config/i18n.php`

```php
<?php

return [
    'default_locale' => 'en_US',
    'available_locales' => ['en_US', 'it_IT'],
    'fallback_locale' => 'en_US',
    'auto_detect' => true,
    'rtl_locales' => ['ar', 'he'],
];
```

---

## 📦 Vite Configuration (Enhanced)

**File: `vite.config.js`**

```javascript
import { defineConfig } from 'vite'
import laravel from 'laravel-vite-plugin'
import { wordpressPlugin, wordpressThemeJson } from '@roots/vite-plugin'

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
    wordpressThemeJson({
      disableTailwindColors: true,   // NO TAILWIND
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
          // Split by feature
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
        // Autoprefixer for older browsers
        require('autoprefixer'),
        // CSS Nano for production minification
        ...(process.env.NODE_ENV === 'production' 
          ? [require('cssnano')({ preset: 'default' })] 
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
```

---

## 🧪 Testing & Quality Assurance

### Performance Testing Checklist

```bash
# Lighthouse CI
npx lighthouse https://alpacode.studio --view

# Web Vitals
npx web-vitals-cli https://alpacode.studio

# Bundle size analysis
npx vite-bundle-visualizer

# CSS stats
npx cssstats public/build/assets/*.css
```

### Browser Support Matrix

| Browser | Version | Support Level |
|---------|---------|---------------|
| Chrome  | 109+    | Full          |
| Firefox | 109+    | Full          |
| Safari  | 16.4+   | Full          |
| Edge    | 109+    | Full          |
| Opera   | 95+     | Full          |

**Note:** CSS Nesting, Container Queries, :has() supported natively

---

## 🔐 Security Hardening

### Content Security Policy

```php
// In ThemeServiceProvider
add_action('send_headers', function() {
    header("Content-Security-Policy: default-src 'self'; script-src 'self' 'unsafe-inline'; style-src 'self' 'unsafe-inline';");
});
```

### Disable WordPress Features (Security)

```php
// In app/setup.php
remove_action('wp_head', 'wp_generator');
remove_action('wp_head', 'wlwmanifest_link');
remove_action('wp_head', 'rsd_link');
add_filter('xmlrpc_enabled', '__return_false');
```

---

## 📊 Monitoring & Analytics

### Web Vitals Tracking

**File: `resources/js/core/performance.js`**

```javascript
import { onCLS, onFCP, onFID, onLCP, onTTFB } from 'web-vitals'

function sendToAnalytics(metric) {
  // Send to your analytics endpoint
  const body = JSON.stringify(metric)
  const url = '/wp-json/theme/v1/vitals'
  
  if (navigator.sendBeacon) {
    navigator.sendBeacon(url, body)
  } else {
    fetch(url, { body, method: 'POST', keepalive: true })
  }
}

onCLS(sendToAnalytics)
onFCP(sendToAnalytics)
onFID(sendToAnalytics)
onLCP(sendToAnalytics)
onTTFB(sendToAnalytics)
```

---

## 🎯 Design Principles (Wix/Webflow Style)

### 1. Minimal Elegant Design

**Characteristics:**
- Generous white space (negative space as design element)
- High-quality typography hierarchy
- Subtle animations (never distracting)
- Grid-based layouts with perfect alignment
- Micro-interactions (hover states, transitions)

### 2. Fluid Typography

**Implementation:**
```css
h1 { font-size: var(--font-size-5xl); }
h2 { font-size: var(--font-size-4xl); }
h3 { font-size: var(--font-size-3xl); }
p { font-size: var(--font-size-base); }

/* With optical sizing for variable fonts */
h1 { font-variation-settings: 'opsz' 36; }
```

### 3. High Contrast

**WCAG AAA Compliance:**
- Body text: 9:1 contrast minimum
- Large text: 7:1 contrast minimum
- Interactive elements: 4.5:1 minimum

### 4. Always Fresh

**Strategies:**
- View Transitions API for smoothness
- Subtle parallax on scroll
- Smooth scroll behavior
- Micro-animations on page load
- Dynamic gradient backgrounds
- CSS `color-mix()` for adaptive colors

---

## 🏁 Migration Strategy

### Phase 1: Foundation (Week 1)
1. ✅ Set up new file structure
2. ✅ Create CSS4 design system (_tokens.css)
3. ✅ Refactor app.css to use @layer
4. ✅ Remove Tailwind dependencies
5. ✅ Set up Service layer (empty shells)

### Phase 2: Core Services (Week 2)
1. ✅ Implement DesignSystemService
2. ✅ Implement PerformanceService
3. ✅ Implement SeoService
4. ✅ Implement I18nService
5. ✅ Implement AssetService
6. ✅ Wire up ViewComposers

### Phase 3: Templates (Week 3)
1. ✅ Refactor layouts/app.blade.php
2. ✅ Refactor index.blade.php
3. ✅ Update partials (header, footer)
4. ✅ Ensure WordPress template hierarchy works

### Phase 4: Components (Week 4)
1. ✅ Build reusable Blade components
2. ✅ Style with scoped CSS
3. ✅ Add Alpine.js interactivity
4. ✅ Document component API

### Phase 5: Sections (Week 5)
1. ✅ Build hardcoded sections
2. ✅ Style with section-scoped CSS
3. ✅ Optimize for performance
4. ✅ Test across devices

### Phase 6: Polish & Launch (Week 6)
1. ✅ Performance audit (Lighthouse)
2. ✅ Accessibility audit (WAVE, axe)
3. ✅ Browser testing
4. ✅ SEO verification
5. ✅ Documentation
6. ✅ Deploy 🚀

---

## 📚 Documentation Standards

### Code Comments

```php
/**
 * Get the current theme mode (light/dark/auto)
 * 
 * @return string The current theme mode
 * @throws ThemeException If theme mode is invalid
 */
public function getCurrentTheme(): string
{
    // Implementation
}
```

### README Sections

1. **Installation** - Step-by-step setup
2. **Configuration** - Config files explained
3. **Architecture** - High-level overview
4. **Services** - Service layer documentation
5. **Components** - Component library
6. **Customization** - How to extend/customize
7. **Performance** - Optimization techniques
8. **Troubleshooting** - Common issues

---

## 🎓 Best Practices

### CSS
✅ Use semantic class names
✅ Leverage CSS custom properties
✅ Use @layer for cascade control
✅ Container queries over media queries
✅ Logical properties (margin-inline, padding-block)
❌ No inline styles
❌ No !important (except utilities)
❌ No vendor prefixes (use autoprefixer)

### PHP
✅ Type hints everywhere
✅ Dependency injection via constructor
✅ Single Responsibility Principle
✅ Use Laravel collections
✅ Leverage Blade directives
❌ No global variables
❌ No WordPress query in templates (use View Composers)

### JavaScript
✅ ES6+ modules
✅ Use Alpine.js for UI state
✅ Progressive enhancement
✅ Event delegation
✅ Debounce scroll/resize handlers
❌ No jQuery
❌ No inline event handlers
❌ No blocking scripts

---

## 🔗 Resources & References

- **CSS4 Features:** https://web.dev/new-css/
- **View Transitions API:** https://developer.chrome.com/docs/web-platform/view-transitions/
- **Web Vitals:** https://web.dev/vitals/
- **OKLCH Colors:** https://oklch.com/
- **Sage Documentation:** https://roots.io/sage/docs/
- **Laravel Blade:** https://laravel.com/docs/blade
- **Alpine.js:** https://alpinejs.dev/

---

## 💰 Deliverables (10k Value)

✅ Complete architecture refactor
✅ CSS4 design system (production-ready)
✅ Service layer implementation
✅ Performance optimization (95+ Lighthouse)
✅ Accessibility compliance (WCAG AA)
✅ i18n framework
✅ Component library (documented)
✅ Portable core (works with any Sage project)
✅ Production deployment guide
✅ 6-month maintenance strategy

**Total Estimated Value:** €10,000
**Timeline:** 6 weeks (1 developer, full-time)
**ROI:** Reusable foundation for all future projects

---

**Version:** 1.0.0
**Last Updated:** 2025-10-21
**Author:** Premium Architecture Team
**Status:** Ready for Implementation ✅
