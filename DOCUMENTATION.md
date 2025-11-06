# 📖 Alpacode Studio Theme - Complete Documentation

**Version:** 1.0.0
**Last Updated:** 2025-10-21
**Author:** Alpacode Studio
**License:** MIT

---

## 📋 Table of Contents

1. [Overview](#overview)
2. [Installation](#installation)
3. [Configuration](#configuration)
4. [Architecture](#architecture)
5. [Component Library](#component-library)
6. [Services](#services)
7. [Customization](#customization)
8. [Performance](#performance)
9. [Accessibility](#accessibility)
10. [Troubleshooting](#troubleshooting)

---

## 🎯 Overview

### What is This Theme?

A premium, production-ready WordPress theme built on **Sage 10** with a **CSS4-first architecture**. Designed for agencies, freelancers, and creative professionals who demand:

- ⚡ **Exceptional Performance** (Lighthouse 95+)
- 🎨 **Modern Design System** (CSS4, no framework bloat)
- ♿ **WCAG AA Compliance** (9:1 contrast ratios)
- 🌐 **Full Internationalization** (i18n + RTL support)
- 🧩 **Complete Component Library** (Production-ready Blade components)
- 📊 **Enterprise Architecture** (Service layer + ViewComposers)

### Key Features

✅ **CSS4-First** - No Tailwind, no Bootstrap. Pure CSS4 with custom properties, nesting, container queries
✅ **Performance Budget** - CSS <50KB, JS <100KB, FCP <1.5s
✅ **Dark Mode** - System preference detection + manual toggle
✅ **SEO Ready** - Schema.org, meta tags, breadcrumbs
✅ **Service Layer** - 5 enterprise services (DesignSystem, Performance, SEO, I18n, Asset)
✅ **Component Library** - 6 production-ready components (Button, Card, Modal, Hero, Features, CTA)
✅ **Web Vitals Tracking** - Real-time performance monitoring
✅ **View Transitions API** - SPA-like navigation

---

## 🚀 Installation

### Requirements

- **PHP:** 8.2+
- **WordPress:** 6.6+
- **Node.js:** 20+
- **Composer:** 2.0+

### Step-by-Step Installation

```bash
# 1. Clone the theme
git clone https://github.com/FrancescoCorbosiero/alpacodestudio-theme.git
cd alpacodestudio-theme

# 2. Install PHP dependencies
composer install

# 3. Install Node dependencies
npm install

# 4. Build assets (production)
npm run build

# 5. Activate theme in WordPress
# Navigate to Appearance > Themes and activate "Alpacode Studio"
```

### Development Setup

```bash
# Run development server with hot module replacement
npm run dev

# In another terminal, watch for PHP changes
composer dump-autoload --watch
```

---

## ⚙️ Configuration

### Design System Configuration

Brand colors are configured in `resources/css/foundation/_tokens.css`:

```css
/* Change the primary brand color */
--color-brand-primary: oklch(65% 0.23 40);  /* #F65100 Alpacode Orange */

/* Change secondary and accent colors */
--color-brand-secondary: oklch(70% 0.12 180);  /* Teal */
--color-brand-accent: oklch(75% 0.18 120);     /* Green */
```

### Internationalization Configuration

Edit `config/i18n.php`:

```php
return [
    'default_locale' => 'en_US',
    'available_locales' => [
        'en_US' => 'English (US)',
        'it_IT' => 'Italiano',
        // Add more locales here
    ],
    'auto_detect' => true,
    'rtl_locales' => ['ar', 'he_IL', 'fa_IR'],
];
```

### Navigation Menus

Register menus in `app/setup.php`:

```php
register_nav_menus([
    'primary_navigation' => __('Primary Navigation', 'sage'),
    'footer_navigation' => __('Footer Navigation', 'sage'),
]);
```

---

## 🏗️ Architecture

### File Structure

```
alpacodestudio-theme/
├── app/
│   ├── Providers/
│   │   └── ThemeServiceProvider.php    # Service registration
│   ├── Services/                        # Business logic layer
│   │   ├── DesignSystemService.php
│   │   ├── PerformanceService.php
│   │   ├── SeoService.php
│   │   ├── I18nService.php
│   │   └── AssetService.php
│   ├── ViewComposers/                   # Blade data binding
│   │   └── GlobalComposer.php
│   ├── setup.php                        # WordPress hooks
│   └── filters.php                      # WordPress filters
│
├── resources/
│   ├── css/
│   │   ├── foundation/                  # CSS4 Design System
│   │   │   ├── _tokens.css              # Design tokens
│   │   │   ├── _reset.css               # Modern reset
│   │   │   ├── _typography.css          # Type scale
│   │   │   ├── _layout.css              # Grid/flex
│   │   │   ├── _utilities.css           # Utilities
│   │   │   └── _animations.css          # Animations
│   │   ├── components/                  # Component styles
│   │   │   ├── _button.css
│   │   │   ├── _card.css
│   │   │   └── _modal.css
│   │   ├── sections/                    # Section styles
│   │   │   ├── _hero.css
│   │   │   ├── _features.css
│   │   │   └── _cta.css
│   │   ├── app.css                      # Main entry
│   │   └── editor.css                   # Gutenberg styles
│   │
│   ├── js/
│   │   ├── core/                        # Core functionality
│   │   │   ├── theme-switcher.js
│   │   │   ├── navigation.js
│   │   │   ├── view-transitions.js
│   │   │   ├── performance.js
│   │   │   └── accessibility.js
│   │   └── app.js                       # Main entry
│   │
│   └── views/
│       ├── layouts/
│       │   └── app.blade.php            # Master layout
│       ├── templates/                   # WordPress templates
│       ├── components/                  # Blade components
│       │   ├── button.blade.php
│       │   ├── card.blade.php
│       │   ├── modal.blade.php
│       │   ├── section-hero.blade.php
│       │   ├── section-features.blade.php
│       │   └── section-cta.blade.php
│       └── sections/                    # Header/footer
│
├── config/
│   └── i18n.php                         # i18n configuration
│
└── public/
    └── build/                           # Compiled assets
```

### Service Layer

The theme uses a **service-oriented architecture** with 5 core services:

#### 1. DesignSystemService
```php
// Get current theme (light/dark)
$theme = app(DesignSystemService::class)->getCurrentTheme();

// Get design tokens
$tokens = app(DesignSystemService::class)->getTokens();

// Get critical CSS for inline injection
$css = app(DesignSystemService::class)->getCriticalCss();
```

#### 2. PerformanceService
```php
// Generate resource hints
$hints = app(PerformanceService::class)->generateResourceHints();

// Defer non-critical CSS
$css = app(PerformanceService::class)->deferNonCriticalCss($href);
```

#### 3. SeoService
```php
// Get meta tags
$meta = app(SeoService::class)->getMetaTags();

// Get Schema.org markup
$schema = app(SeoService::class)->getSchemaMarkup();

// Get breadcrumbs
$breadcrumbs = app(SeoService::class)->getBreadcrumbs();
```

#### 4. I18nService
```php
// Get current locale
$locale = app(I18nService::class)->getLocale();

// Check if RTL
$isRtl = app(I18nService::class)->isRtl();

// Translate with replacements
$text = app(I18nService::class)->translate('Hello :name', ['name' => 'World']);
```

#### 5. AssetService
```php
// Enqueue asset conditionally
app(AssetService::class)->enqueueConditional('my-script', function() {
    return is_front_page();
});

// Defer script
app(AssetService::class)->deferScript('my-script');
```

---

## 🧩 Component Library

### Button Component

```blade
{{-- Basic usage --}}
<x-button variant="primary" size="lg" href="/contact">
  Get Started
</x-button>

{{-- All variants --}}
<x-button variant="primary">Primary</x-button>
<x-button variant="secondary">Secondary</x-button>
<x-button variant="tertiary">Tertiary</x-button>
<x-button variant="ghost">Ghost</x-button>

{{-- Sizes --}}
<x-button size="sm">Small</x-button>
<x-button size="base">Base</x-button>
<x-button size="lg">Large</x-button>

{{-- As button (not link) --}}
<x-button type="submit" variant="primary">
  Submit Form
</x-button>
```

**Props:**
- `variant` - primary, secondary, tertiary, ghost (default: primary)
- `size` - sm, base, lg (default: base)
- `href` - If provided, renders as `<a>`, otherwise `<button>`
- `type` - button, submit, reset (default: button)
- `icon` - SVG icon markup
- `iconPosition` - left, right (default: left)

### Card Component

```blade
<x-card hover padding="lg">
  <x-slot:header>
    <h3>Card Title</h3>
  </x-slot:header>

  Card content goes here...

  <x-slot:footer>
    <x-button variant="ghost">Learn More</x-button>
  </x-slot:footer>
</x-card>
```

**Props:**
- `hover` - Enable hover lift effect (default: false)
- `padding` - sm, md, lg, none (default: md)

**Slots:**
- `header` - Optional card header
- Default slot - Card body content
- `footer` - Optional card footer

### Modal Component

```blade
<x-modal id="example-modal" title="Modal Title" size="lg">
  <p>Modal content goes here...</p>

  <x-slot:footer>
    <x-button variant="secondary" @click="open = false">Cancel</x-button>
    <x-button variant="primary">Confirm</x-button>
  </x-slot:footer>
</x-modal>

{{-- Trigger button --}}
<x-button @click="$refs.exampleModal.open = true">
  Open Modal
</x-button>
```

**Props:**
- `id` - Unique modal ID (auto-generated if not provided)
- `title` - Modal title
- `size` - sm, md, lg, full (default: md)

**Features:**
- ESC key to close
- Backdrop click to close
- Focus trap
- ARIA attributes
- Smooth animations

### Hero Section

```blade
<x-section-hero
  eyebrow="Web Development 2025"
  title="Your Digital Space, Simplified"
  subtitle="Professional websites for freelancers and creators"
  :buttons="[
    ['text' => 'Get Started', 'href' => '/contact', 'variant' => 'primary'],
    ['text' => 'Learn More', 'href' => '/about', 'variant' => 'secondary']
  ]"
  image="/path/to/background.jpg"
/>
```

**Props:**
- `eyebrow` - Small text above title (optional)
- `title` - Main headline
- `subtitle` - Supporting text
- `buttons` - Array of button configs
- `image` - Background image URL (optional)

### Features Section

```blade
<x-section-features
  title="What We Do"
  description="Everything you need to succeed online"
  :features="[
    [
      'icon' => '<svg>...</svg>',
      'title' => 'Fast Performance',
      'description' => 'Lightning-fast load times'
    ],
    [
      'icon' => '<svg>...</svg>',
      'title' => 'SEO Ready',
      'description' => 'Built-in optimization'
    ]
  ]"
  :columns="3"
/>
```

**Props:**
- `title` - Section title
- `description` - Section description (optional)
- `features` - Array of feature objects
- `columns` - 2, 3, 4, or auto (default: 3)

### CTA Section

```blade
{{-- Centered variant --}}
<x-section-cta
  title="Ready to Start?"
  description="Let's create something amazing"
  buttonText="Get in Touch"
  buttonHref="/contact"
  variant="centered"
/>

{{-- Split variant --}}
<x-section-cta
  title="Ready to Start?"
  description="Let's create something amazing"
  buttonText="Get in Touch"
  buttonHref="/contact"
  variant="split"
/>
```

**Props:**
- `title` - CTA headline
- `description` - Supporting text
- `buttonText` - Button label
- `buttonHref` - Button URL
- `variant` - centered, split (default: centered)

---

## 🔧 Services

### Using Services in Templates

Services are automatically available in all Blade views via dependency injection:

```blade
{{-- Access global composer data --}}
<h1>{{ $siteName }}</h1>
<p>{{ $siteDescription }}</p>

{{-- Current locale --}}
<html lang="{{ $locale }}" @if($isRtl) dir="rtl" @endif>

{{-- Theme attribute --}}
<html data-theme="{{ $theme }}">

{{-- SEO meta tags (already rendered in layout) --}}
{!! $metaTags !!}

{{-- Schema.org markup --}}
{!! $schemaMarkup !!}
```

### Using Services in PHP

```php
use App\Services\DesignSystemService;
use App\Services\SeoService;

// Get service instance
$seo = app(SeoService::class);

// Use service methods
$breadcrumbs = $seo->getBreadcrumbs();
```

---

## 🎨 Customization

### Changing Brand Colors

Edit `resources/css/foundation/_tokens.css`:

```css
/* Your brand colors in OKLCH */
--color-brand-primary: oklch(65% 0.23 40);    /* Orange #F65100 */
--color-brand-secondary: oklch(70% 0.12 180); /* Teal */
--color-brand-accent: oklch(75% 0.18 120);    /* Green */
```

**How to convert HEX to OKLCH:**
1. Use https://oklch.com/
2. Paste your HEX color
3. Copy the OKLCH value

### Customizing Typography

Edit `resources/css/foundation/_tokens.css`:

```css
/* Change font families */
--font-family-base: 'Your Font', system-ui, sans-serif;

/* Adjust type scale */
--font-size-base: clamp(1rem, 0.9rem + 0.5vw, 1.125rem);
--font-size-xl: clamp(1.25rem, 1.1rem + 0.75vw, 1.5rem);
```

### Creating Custom Components

1. Create Blade component:
```bash
# Create file: resources/views/components/my-component.blade.php
```

2. Create component styles:
```bash
# Create file: resources/css/components/_my-component.css
```

3. Import in app.css:
```css
@import "./components/_my-component.css";
```

4. Use component:
```blade
<x-my-component />
```

---

## ⚡ Performance

### Performance Targets

✅ **Lighthouse Score:** 95+ (all categories)
✅ **First Contentful Paint (FCP):** <1.5s
✅ **Largest Contentful Paint (LCP):** <2.5s
✅ **Cumulative Layout Shift (CLS):** <0.1
✅ **CSS Bundle Size:** <50KB
✅ **JavaScript Bundle Size:** <100KB

### Optimization Strategies

**1. Critical CSS Inlining**
- Foundation tokens and reset are inlined in `<head>`
- Non-critical CSS is deferred

**2. Code Splitting**
- Vendor chunk (Alpine.js)
- Core chunk (theme-switcher, navigation)
- Component-specific chunks loaded on-demand

**3. Image Optimization**
- Lazy loading enabled by default
- `loading="lazy"` and `decoding="async"` attributes
- WebP/AVIF support

**4. JavaScript Optimization**
- Module/nomodule pattern for modern browsers
- Defer attribute on all scripts
- Alpine.js (14KB) for minimal JavaScript footprint

**5. Font Loading**
- Variable fonts (Inter Variable)
- `font-display: swap` for optimal rendering
- Preload critical fonts

### Web Vitals Monitoring

The theme automatically tracks Core Web Vitals and sends them to WordPress:

```php
// View metrics in your analytics or implement custom handler
add_action('rest_api_init', function() {
    // Metrics are sent to: /wp-json/theme/v1/vitals
});
```

---

## ♿ Accessibility

### WCAG AA Compliance

✅ **Contrast Ratios:**
- Body text: 9:1 (AAA level)
- Large text: 7:1 (AAA level)
- UI components: 4.5:1 (AA level)

✅ **Keyboard Navigation:**
- All interactive elements are keyboard accessible
- Visible focus indicators (2px outline)
- Skip to content link
- ESC key closes modals/overlays

✅ **Screen Reader Support:**
- ARIA landmarks (`role="main"`, `role="navigation"`)
- ARIA attributes (`aria-label`, `aria-expanded`, `aria-modal`)
- Live regions for dynamic content
- Semantic HTML5 elements

✅ **Focus Management:**
- Focus trap in modals
- Focus restoration on modal close
- Logical tab order

### Accessibility Features

**Skip Link:**
```html
<a class="skip-link sr-only focus:not-sr-only" href="#main">
  Skip to content
</a>
```

**ARIA Live Announcements:**
```javascript
import { announce } from './core/accessibility'

// Announce to screen readers
announce('Form submitted successfully')
```

**Keyboard Shortcuts:**
- `/` - Focus search input
- `ESC` - Close modals/overlays

---

## 🐛 Troubleshooting

### Build Errors

**Issue:** `npm run build` fails

**Solution:**
```bash
# Clear cache and reinstall
rm -rf node_modules package-lock.json
npm install
npm run build
```

### WordPress Admin Conflicts

**Issue:** Admin panel buttons not working

**Solution:** The theme automatically detects WordPress admin and disables frontend JavaScript. If issues persist:

```php
// Check app/Providers/ThemeServiceProvider.php
// Ensure is_admin() checks are in place
```

### Dark Mode Not Working

**Issue:** Dark mode toggle doesn't switch themes

**Solution:**
```javascript
// Check browser console for errors
// Verify localStorage:
localStorage.getItem('theme')

// Manually set theme:
localStorage.setItem('theme', 'dark')
// Refresh page
```

### Missing $title Variable

**Issue:** `$title` variable not available in templates

**Solution:** Ensure `GlobalComposer` is registered in `ThemeServiceProvider.php`:

```php
// app/Providers/ThemeServiceProvider.php
$this->app->make('view')->composer('*', GlobalComposer::class);
```

### Styles Not Loading

**Issue:** Styles don't appear on frontend

**Solution:**
```bash
# Rebuild assets
npm run build

# Clear WordPress cache
wp cache flush

# Hard refresh browser (Cmd+Shift+R or Ctrl+Shift+F5)
```

### Component Not Found

**Issue:** `Component [component-name] not found`

**Solution:** Blade components use kebab-case:

```blade
{{-- Correct --}}
<x-section-hero />

{{-- Incorrect --}}
<x-SectionHero />
```

---

## 📚 Additional Resources

### Documentation Files

- **Architecture Blueprint:** `docs/architecture/01_ARCHITECTURE_BLUEPRINT.md`
- **Design System Manifesto:** `docs/architecture/02_DESIGN_SYSTEM_MANIFESTO.md`
- **Claude Code Prompts:** `docs/architecture/03_CLAUDE_CODE_PROMPTS.md`
- **Quick Start Guide:** `docs/architecture/00_QUICK_START.md`

### External Resources

- **Sage Documentation:** https://roots.io/sage/docs/
- **CSS4 Features:** https://web.dev/new-css/
- **OKLCH Colors:** https://oklch.com/
- **Alpine.js:** https://alpinejs.dev/
- **Web Vitals:** https://web.dev/vitals/

---

## 🤝 Support

### Getting Help

1. **Documentation:** Read this file and architecture docs
2. **GitHub Issues:** Report bugs and request features
3. **Community:** Join Sage community at https://discourse.roots.io/

---

## 📝 Changelog

### Version 1.0.0 (2025-10-21)

**Initial Release**
- ✅ CSS4-first architecture
- ✅ Complete component library (6 components)
- ✅ Service layer (5 services)
- ✅ Dark mode support
- ✅ Full internationalization
- ✅ WCAG AA compliance
- ✅ Performance optimization
- ✅ SEO ready

---

**Built with ❤️ by Alpacode Studio**
