# 🤖 Claude Code Prompts - Alpacode Studio Theme Refactor
## Granular File-by-File Implementation Guide

---

## 📋 How to Use These Prompts

1. **Copy each prompt verbatim** into Claude Code
2. **Execute prompts in order** (dependencies matter)
3. **Test after each major section** (Foundation → Services → Templates → Components)
4. **Commit after each successful implementation**
5. **Reference the Architecture Blueprint** for context when needed

---

## 🏗️ PHASE 1: FOUNDATION

### PROMPT 1.1: Package.json Update

```
Update package.json to remove Tailwind CSS dependencies and add required CSS4 tooling.

REQUIREMENTS:
1. Remove @tailwindcss/vite and any Tailwind-related packages
2. Add autoprefixer for vendor prefixes
3. Add cssnano for production minification
4. Add postcss-preset-env for modern CSS features
5. Keep existing Sage/Acorn packages intact
6. Keep Alpine.js (core interactivity)
7. Add web-vitals package for performance monitoring

Current file location: package.json
Output: Updated package.json with new dependencies
```

### PROMPT 1.2: Vite Config Refactor

```
Refactor vite.config.js to remove Tailwind and optimize for CSS4-first architecture.

REQUIREMENTS:
1. Remove Tailwind plugin import and usage
2. Update wordpressThemeJson to disable all Tailwind features:
   - disableTailwindColors: true
   - disableTailwindFonts: true
   - disableTailwindFontSizes: true
3. Add PostCSS configuration with:
   - autoprefixer
   - cssnano (production only)
   - postcss-preset-env (stage: 2)
4. Configure code splitting:
   - Vendor chunk (alpinejs)
   - Core chunk (theme-switcher, navigation)
5. Set CSS code splitting to true
6. Add source maps for development
7. Keep all existing paths and aliases

Current file location: vite.config.js
Reference: 01_ARCHITECTURE_BLUEPRINT.md section "Vite Configuration"
Output: Refactored vite.config.js
```

### PROMPT 1.3: Create CSS Foundation Structure

```
Create the CSS4 design system foundation files in resources/css/foundation/.

REQUIREMENTS:
1. Create directory: resources/css/foundation/
2. Create file: _tokens.css (copy entire content from 02_DESIGN_SYSTEM_MANIFESTO.md - "CSS4 Token System" section)
3. Create file: _reset.css with modern CSS reset (use latest best practices)
4. Create file: _typography.css with:
   - Font-face declarations for Inter Variable
   - Typography utility classes from Design System Manifesto
   - Fluid type scale implementation
5. Create file: _layout.css with:
   - Container system
   - Grid utilities
   - Flex utilities
6. Create file: _utilities.css with minimal utility classes:
   - Display utilities (flex, grid, block, inline-block)
   - Spacing utilities (only most common: m-0, p-0, etc.)
   - Text utilities (text-center, text-left, text-right)
7. Create file: _animations.css with:
   - Keyframe animations from Design System Manifesto
   - Transition utilities
   - View Transitions API setup

All files should use CSS @layer directive:
- @layer tokens { ... } for _tokens.css
- @layer reset { ... } for _reset.css
- @layer typography { ... } for _typography.css
- @layer layout { ... } for _layout.css
- @layer utilities { ... } for _utilities.css
- @layer animations { ... } for _animations.css

Reference: 02_DESIGN_SYSTEM_MANIFESTO.md for complete token values and design patterns
Output: 6 new CSS files in resources/css/foundation/
```

### PROMPT 1.4: Refactor app.css

```
Refactor resources/css/app.css to import the new CSS4 foundation instead of Tailwind.

REQUIREMENTS:
1. Remove @import "tailwindcss" directive completely
2. Remove @source directives (no longer needed without Tailwind)
3. Add imports for foundation files in correct order:
   @import "./foundation/_tokens.css";
   @import "./foundation/_reset.css";
   @import "./foundation/_typography.css";
   @import "./foundation/_layout.css";
   @import "./foundation/_utilities.css";
   @import "./foundation/_animations.css";
4. Add comment header:
   /**
    * Alpacode Studio Theme - Main Stylesheet
    * CSS4-First Architecture | No Framework Dependencies
    */
5. Add placeholder sections for future imports:
   /* Components */
   /* @import "./components/_button.css"; */
   
   /* Sections */
   /* @import "./sections/_hero.css"; */

Current file location: resources/css/app.css
Output: Refactored app.css with CSS4 foundation imports
```

### PROMPT 1.5: Create editor.css

```
Create resources/css/editor.css for Gutenberg block editor styling.

REQUIREMENTS:
1. Import foundation tokens and typography:
   @import "./foundation/_tokens.css";
   @import "./foundation/_typography.css";
2. Add editor-specific styles:
   - Match frontend typography scale
   - Add container constraints for editor blocks
   - Style Gutenberg core blocks consistently
   - Ensure dark mode works in editor
3. Add comment:
   /**
    * Gutenberg Block Editor Styles
    * Matches frontend design system
    */
4. Target .editor-styles-wrapper for all styles
5. Ensure styles don't leak outside editor

Current file location: resources/css/editor.css
Output: New editor.css with design system integration
```

---

## 🔧 PHASE 2: SERVICES LAYER

### PROMPT 2.1: Create DesignSystemService

```
Create app/Services/DesignSystemService.php for design token management.

REQUIREMENTS:
1. Create directory: app/Services/
2. Create file: DesignSystemService.php
3. Implement class with namespace: App\Services
4. Methods to implement:
   
   public function getTokens(): array
   - Return all design tokens as associative array
   - Parse from _tokens.css or config file
   
   public function getCurrentTheme(): string
   - Detect current theme (light/dark/auto)
   - Check cookie/localStorage preference
   - Return 'light', 'dark', or 'auto'
   
   public function getCriticalCss(): string
   - Extract critical above-the-fold CSS
   - Include tokens, reset, and layout only
   - Minified for inline injection
   
   public function generateThemeCss(string $theme): string
   - Generate theme-specific CSS custom properties
   - Handle light/dark mode token overrides
   
   public function inlineTokens(): void
   - Output inline <style> tag with critical tokens
   - For use in theme head
   
5. Use dependency injection for any dependencies
6. Follow PSR-4 autoloading standards
7. Add PHPDoc comments for all methods
8. Type hint all parameters and return types

Reference: 01_ARCHITECTURE_BLUEPRINT.md section "DesignSystemService"
Output: New app/Services/DesignSystemService.php
```

### PROMPT 2.2: Create PerformanceService

```
Create app/Services/PerformanceService.php for asset optimization.

REQUIREMENTS:
1. Create file: app/Services/PerformanceService.php
2. Implement class with namespace: App\Services
3. Methods to implement:
   
   public function getCriticalCss(): string
   - Return critical CSS for inline injection
   - Should be minimal (<14KB)
   
   public function preloadAssets(array $assets): void
   - Generate <link rel="preload"> tags
   - Support fonts, CSS, JS
   
   public function generateResourceHints(): string
   - Generate DNS prefetch, preconnect hints
   - Return HTML string of link tags
   
   public function setupLazyLoading(): void
   - Add lazy loading attributes to images
   - Setup Intersection Observer
   
   public function deferNonCriticalCss(string $href): string
   - Return HTML for deferred CSS loading
   - Use media="print" onload trick
   
4. Add method for Web Vitals tracking setup
5. Use dependency injection
6. Add comprehensive PHPDoc comments

Reference: 01_ARCHITECTURE_BLUEPRINT.md section "PerformanceService"
Output: New app/Services/PerformanceService.php
```

### PROMPT 2.3: Create SeoService

```
Create app/Services/SeoService.php for SEO management.

REQUIREMENTS:
1. Create file: app/Services/SeoService.php
2. Implement class with namespace: App\Services
3. Methods to implement:
   
   public function getMetaTags(): string
   - Generate OG, Twitter Card meta tags
   - Handle page-specific metadata
   - Return HTML string
   
   public function getSchemaMarkup(): string
   - Generate Schema.org JSON-LD
   - Support Organization, WebSite, BreadcrumbList
   - Return <script type="application/ld+json"> tag
   
   public function getBreadcrumbs(): array
   - Generate breadcrumb trail
   - Return array of items
   
   public function getCanonicalUrl(): string
   - Get canonical URL for current page
   
   public function generateSitemap(): array
   - Generate sitemap data
   - Return array of URLs with metadata
   
4. Use WordPress functions (get_bloginfo, home_url, etc.)
5. Add PHPDoc comments
6. Type hint everything

Reference: 01_ARCHITECTURE_BLUEPRINT.md section "SeoService"
Output: New app/Services/SeoService.php
```

### PROMPT 2.4: Create I18nService

```
Create app/Services/I18nService.php for internationalization.

REQUIREMENTS:
1. Create file: app/Services/I18nService.php
2. Implement class with namespace: App\Services
3. Methods to implement:
   
   public function getLocale(): string
   - Get current locale (en_US, it_IT, etc.)
   - Check WordPress locale, user preference
   
   public function translate(string $key, array $replace = []): string
   - Wrapper for WordPress __() with replacements
   - Support variable interpolation
   
   public function isRtl(): bool
   - Detect if current locale is RTL
   - Check against config of RTL locales
   
   public function getAvailableLocales(): array
   - Return array of available translations
   - Read from config/i18n.php
   
   public function setLocale(string $locale): void
   - Set user locale preference
   - Save to cookie/session
   
4. Read config from config/i18n.php (create this file too)
5. Use WordPress i18n functions
6. Add PHPDoc comments

Reference: 01_ARCHITECTURE_BLUEPRINT.md section "I18nService"
Output: New app/Services/I18nService.php and config/i18n.php
```

### PROMPT 2.5: Create AssetService

```
Create app/Services/AssetService.php for smart asset loading.

REQUIREMENTS:
1. Create file: app/Services/AssetService.php
2. Implement class with namespace: App\Services
3. Methods to implement:
   
   public function enqueueConditional(string $handle, callable $condition): void
   - Enqueue asset only if condition is true
   - Support both CSS and JS
   
   public function deferScript(string $handle): void
   - Add defer attribute to script
   - Use WordPress script loader filter
   
   public function getPageAssets(string $template): array
   - Return assets needed for specific template
   - Map templates to required assets
   
   public function moduleNomoduleScript(string $modern, string $legacy): void
   - Enqueue modern script with type="module"
   - Enqueue legacy script with nomodule
   
   public function preloadFont(string $url): void
   - Add preload link for font
   
4. Use WordPress enqueue functions
5. Hook into appropriate WordPress actions
6. Add PHPDoc comments

Reference: 01_ARCHITECTURE_BLUEPRINT.md section "AssetService"
Output: New app/Services/AssetService.php
```

### PROMPT 2.6: Create ViewComposers

```
Create app/ViewComposers/ directory with GlobalComposer.php for Blade data binding.

REQUIREMENTS:
1. Create directory: app/ViewComposers/
2. Create file: GlobalComposer.php
3. Implement class extending Roots\Acorn\View\Composer
4. Properties:
   protected static $views = ['*'];  // Apply to all views
5. Constructor with dependency injection:
   - DesignSystemService
   - SeoService
   - I18nService
6. Implement with() method returning:
   - siteName
   - siteDescription
   - currentUrl
   - locale
   - isRtl
   - theme (light/dark)
   - metaTags
   - schemaMarkup
7. Follow exact pattern from Architecture Blueprint
8. Add use statements for all services
9. Add PHPDoc comments

Reference: 01_ARCHITECTURE_BLUEPRINT.md section "View Composer Pattern"
Output: New app/ViewComposers/GlobalComposer.php
```

### PROMPT 2.7: Update ThemeServiceProvider

```
Update app/Providers/ThemeServiceProvider.php to register all new services.

REQUIREMENTS:
1. Add to register() method:
   - Register DesignSystemService as singleton
   - Register PerformanceService as singleton
   - Register SeoService as singleton
   - Register I18nService as singleton
   - Register AssetService as singleton
2. Add to boot() method:
   - Register GlobalComposer with Acorn View
3. Add use statements for all services and composers
4. Keep existing Sage functionality intact
5. Follow Laravel service provider patterns
6. Add comments explaining each registration

Current file location: app/Providers/ThemeServiceProvider.php
Reference: 01_ARCHITECTURE_BLUEPRINT.md for service layer structure
Output: Updated ThemeServiceProvider.php with service registrations
```

---

## 📄 PHASE 3: TEMPLATES

### PROMPT 3.1: Refactor layouts/app.blade.php

```
Refactor resources/views/layouts/app.blade.php as the master layout template.

REQUIREMENTS:
1. Keep WordPress wp_head() and wp_body_open() hooks
2. Add critical CSS inline in <head> using PerformanceService
3. Add design tokens inline using DesignSystemService
4. Add meta tags using SeoService
5. Add Schema.org markup
6. Set up HTML structure:
   <!DOCTYPE html>
   <html @php(language_attributes()) data-theme="{{ $theme }}">
   <head>
     <meta charset="utf-8">
     <meta name="viewport" content="width=device-width, initial-scale=1">
     {!! $metaTags !!}
     {!! $schemaMarkup !!}
     <style>/* Critical CSS */</style>
     @php(wp_head())
   </head>
   <body @php(body_class())>
     @php(wp_body_open())
     <a class="skip-link" href="#main">Skip to content</a>
     
     @include('sections.header')
     
     <main id="main" class="main">
       @yield('content')
     </main>
     
     @include('sections.footer')
     
     @php(wp_footer())
   </body>
   </html>
7. Add ARIA landmarks
8. Add skip-to-content link
9. Use variables from GlobalComposer

Current file location: resources/views/layouts/app.blade.php
Reference: Architecture Blueprint for structure
Output: Refactored app.blade.php with modern structure
```

### PROMPT 3.2: Create index.blade.php

```
Create resources/views/index.blade.php for blog index template.

REQUIREMENTS:
1. Extend layouts/app.blade.php
2. Use @section('content')
3. Structure:
   - Page header with title
   - Posts loop using WordPress Loop
   - Post cards with:
     * Featured image (if available)
     * Title
     * Excerpt
     * Read more link
     * Post metadata (date, author, categories)
   - Pagination
4. Use semantic HTML5 elements (article, time, etc.)
5. Add appropriate ARIA labels
6. Use design system classes
7. Handle empty state (no posts)
8. Use WordPress functions: have_posts(), the_post(), etc.

Current file location: resources/views/index.blade.php
Output: New blog index template
```

### PROMPT 3.3: Create single.blade.php

```
Create resources/views/single.blade.php for single post template.

REQUIREMENTS:
1. Extend layouts/app.blade.php
2. Use @section('content')
3. Structure:
   - Article header:
     * Post title (h1)
     * Post metadata (date, author, categories)
     * Featured image (if available)
   - Article content:
     * The_content() output
   - Article footer:
     * Tags
     * Share buttons (placeholder)
     * Author bio (if available)
   - Comments section (if enabled)
   - Post navigation (prev/next)
4. Use semantic HTML5 (article, header, footer)
5. Add Schema.org Article markup
6. Add OpenGraph meta tags
7. Use design system classes
8. Handle edge cases (no featured image, no author, etc.)

Output: New resources/views/single.blade.php
```

### PROMPT 3.4: Create page.blade.php

```
Create resources/views/page.blade.php for default page template.

REQUIREMENTS:
1. Extend layouts/app.blade.php
2. Use @section('content')
3. Structure:
   - Page header:
     * Page title (h1)
     * Featured image (if available)
   - Page content:
     * The_content() output
   - Additional content areas (if defined)
4. Use semantic HTML5
5. Support Gutenberg blocks fully
6. Add OpenGraph meta tags
7. Use design system classes
8. Handle featured image gracefully

Output: New resources/views/page.blade.php
```

### PROMPT 3.5: Create 404.blade.php

```
Create resources/views/404.blade.php for error page.

REQUIREMENTS:
1. Extend layouts/app.blade.php
2. Use @section('content')
3. Structure:
   - Error section:
     * Large "404" heading
     * Friendly error message
     * Search form
     * Helpful links (Home, Recent Posts, Sitemap)
4. Center content vertically and horizontally
5. Use design system classes
6. Add illustration or icon (optional)
7. Make it friendly and helpful, not sterile
8. Add proper HTTP status code handling

Output: New resources/views/404.blade.php
```

### PROMPT 3.6: Update sections/header.blade.php

```
Refactor resources/views/sections/header.blade.php with modern navigation.

REQUIREMENTS:
1. Structure:
   <header class="site-header">
     <div class="container">
       <div class="header__inner">
         <a href="/" class="header__logo">
           <!-- Logo or site name -->
         </a>
         <nav class="header__nav">
           <!-- Primary navigation -->
         </nav>
         <div class="header__actions">
           <button class="theme-toggle">
             <!-- Theme switcher -->
           </button>
         </div>
         <button class="mobile-menu-toggle">
           <!-- Mobile menu -->
         </button>
       </div>
     </div>
   </header>
2. Use WordPress nav menu (wp_nav_menu)
3. Add mobile menu toggle
4. Add theme switcher button
5. Make header sticky (CSS)
6. Use design system classes
7. Add ARIA labels for accessibility
8. Support mega menu if needed

Current file location: resources/views/sections/header.blade.php
Output: Updated header with modern navigation
```

### PROMPT 3.7: Update sections/footer.blade.php

```
Refactor resources/views/sections/footer.blade.php with multi-column layout.

REQUIREMENTS:
1. Structure:
   <footer class="site-footer">
     <div class="container">
       <div class="footer__main">
         <div class="footer__col footer__col--about">
           <!-- Logo, tagline, social links -->
         </div>
         <div class="footer__col footer__col--links">
           <!-- Footer navigation -->
         </div>
         <div class="footer__col footer__col--contact">
           <!-- Contact info -->
         </div>
       </div>
       <div class="footer__bottom">
         <p class="footer__copyright">
           © {{ date('Y') }} {{ siteName }}. All rights reserved.
         </p>
         <nav class="footer__legal">
           <!-- Privacy, Terms links -->
         </nav>
       </div>
     </div>
   </footer>
2. Use flexible grid layout
3. Add social media links
4. Add footer navigation
5. Add copyright notice
6. Use design system classes
7. Responsive (stack on mobile)

Current file location: resources/views/sections/footer.blade.php
Output: Updated footer with modern layout
```

---

## 🎨 PHASE 4: CORE JAVASCRIPT

### PROMPT 4.1: Create theme-switcher.js

```
Create resources/js/core/theme-switcher.js for dark/light mode.

REQUIREMENTS:
1. Create directory: resources/js/core/
2. Create file: theme-switcher.js
3. Functionality:
   - Detect system preference (prefers-color-scheme)
   - Allow manual override
   - Save preference to localStorage
   - Apply theme to document.documentElement.dataset.theme
   - Listen for system preference changes
   - Emit custom event when theme changes
4. Export initThemeSwitcher() function
5. Use modern JavaScript (ES6+)
6. Handle SSR/hydration properly
7. Add toggle button functionality
8. Smooth transition between themes

Reference: 02_DESIGN_SYSTEM_MANIFESTO.md section "Dark Mode Strategy"
Output: New resources/js/core/theme-switcher.js
```

### PROMPT 4.2: Create navigation.js

```
Create resources/js/core/navigation.js for enhanced navigation.

REQUIREMENTS:
1. Create file: resources/js/core/navigation.js
2. Functionality:
   - Mobile menu toggle
   - Smooth scroll for anchor links
   - Active link highlighting
   - Sticky header on scroll
   - Speculation Rules API for prefetching
   - Keyboard navigation support
3. Export initNavigation() function
4. Use event delegation
5. Handle resize events (debounced)
6. Add ARIA attributes dynamically
7. Support mega menu if present

Reference: Theme_features document for navigation enhancements
Output: New resources/js/core/navigation.js
```

### PROMPT 4.3: Create view-transitions.js

```
Create resources/js/core/view-transitions.js for SPA-like navigation.

REQUIREMENTS:
1. Create file: resources/js/core/view-transitions.js
2. Functionality:
   - Intercept link clicks
   - Use View Transitions API
   - Fetch next page
   - Swap content with transition
   - Update browser history
   - Fallback for unsupported browsers
3. Export initViewTransitions() function
4. Handle edge cases:
   - External links (don't intercept)
   - Download links (don't intercept)
   - Hash links (don't intercept)
5. Update page title and meta tags
6. Trigger analytics on page change

Reference: Architecture Blueprint for View Transitions
Output: New resources/js/core/view-transitions.js
```

### PROMPT 4.4: Create performance.js

```
Create resources/js/core/performance.js for Web Vitals tracking.

REQUIREMENTS:
1. Create file: resources/js/core/performance.js
2. Import from 'web-vitals' package:
   import { onCLS, onFCP, onFID, onLCP, onTTFB } from 'web-vitals'
3. Functionality:
   - Track all Core Web Vitals
   - Send metrics to WordPress REST endpoint
   - Use sendBeacon for reliability
   - Fallback to fetch if sendBeacon unavailable
   - Batch multiple metrics
   - Add user agent, URL, timestamp
4. Export initPerformance() function
5. Handle errors gracefully
6. Only run in production (check debug mode)

Reference: Architecture Blueprint section "Monitoring & Analytics"
Output: New resources/js/core/performance.js
```

### PROMPT 4.5: Create accessibility.js

```
Create resources/js/core/accessibility.js for A11y enhancements.

REQUIREMENTS:
1. Create file: resources/js/core/accessibility.js
2. Functionality:
   - Focus management for modals
   - Trap focus in modals/dropdowns
   - Skip link functionality
   - Keyboard shortcuts (document.addEventListener('keydown'))
   - ARIA live region announcer
   - Restore focus on modal close
3. Export initAccessibility() function
4. Add focus-visible polyfill behavior
5. Handle ESC key for closing overlays
6. Announce dynamic content changes to screen readers
7. Support keyboard-only navigation

Output: New resources/js/core/accessibility.js
```

### PROMPT 4.6: Update app.js

```
Update resources/js/app.js to initialize all core functionality.

REQUIREMENTS:
1. Import Alpine.js
2. Import all core modules:
   - theme-switcher
   - navigation
   - view-transitions
   - performance
   - accessibility
3. Initialize on DOMContentLoaded:
   document.addEventListener('DOMContentLoaded', () => {
     initThemeSwitcher()
     initNavigation()
     initViewTransitions()
     initPerformance()
     initAccessibility()
   })
4. Start Alpine.js
5. Add error handling for each module
6. Add conditional loading (check if features supported)
7. Keep code modular and clean

Current file location: resources/js/app.js
Output: Updated app.js with all initializations
```

---

## 🧩 PHASE 5: COMPONENTS (Examples)

### PROMPT 5.1: Create Button Component

```
Create resources/views/components/button.blade.php Blade component.

REQUIREMENTS:
1. Create directory: resources/views/components/
2. Create file: button.blade.php
3. Props:
   - variant: 'primary' | 'secondary' | 'tertiary' | 'ghost'
   - size: 'sm' | 'base' | 'lg'
   - href: optional link URL
   - type: 'button' | 'submit' | 'reset' (for buttons)
   - icon: optional icon name
   - iconPosition: 'left' | 'right'
4. Render as <a> if href provided, else <button>
5. Apply design system classes
6. Support slots for content
7. Add ARIA attributes
8. Example usage:
   <x-button variant="primary" size="lg" href="/contact">
     Contact Us
   </x-button>

Also create: resources/css/components/_button.css with styles from Design System Manifesto

Output: New button.blade.php component and _button.css
```

### PROMPT 5.2: Create Card Component

```
Create resources/views/components/card.blade.php Blade component.

REQUIREMENTS:
1. Create file: card.blade.php
2. Props:
   - hover: boolean (enable hover effect)
   - padding: 'sm' | 'md' | 'lg'
3. Named slots:
   - header (optional)
   - footer (optional)
   - default (main content)
4. Structure:
   <article class="card" @if($hover) hover-lift @endif>
     @isset($header)
       <header class="card__header">{{ $header }}</header>
     @endisset
     <div class="card__body">{{ $slot }}</div>
     @isset($footer)
       <footer class="card__footer">{{ $footer }}</footer>
     @endisset>
   </article>
5. Use design system classes
6. Support container queries

Also create: resources/css/components/_card.css

Output: New card.blade.php component and _card.css
```

### PROMPT 5.3: Create Modal Component

```
Create resources/views/components/modal.blade.php Blade component with Alpine.js.

REQUIREMENTS:
1. Create file: modal.blade.php
2. Use Alpine.js for state management
3. Props:
   - id: unique modal ID
   - title: modal title
   - size: 'sm' | 'md' | 'lg' | 'full'
4. Features:
   - Backdrop click to close
   - ESC key to close
   - Focus trap
   - ARIA attributes (dialog, labelledby)
   - Smooth animations
5. Structure:
   <div x-data="{ open: false }" ...>
     <div class="modal-backdrop" x-show="open"></div>
     <div class="modal" role="dialog">
       <header class="modal__header">
         <h2>{{ $title }}</h2>
         <button @click="open = false">Close</button>
       </header>
       <div class="modal__body">{{ $slot }}</div>
     </div>
   </div>

Also create: resources/css/components/_modal.css

Output: New modal.blade.php component and _modal.css
```

---

## 🏠 PHASE 6: SECTIONS (Examples)

### PROMPT 6.1: Create Hero Section

```
Create resources/views/sections/hero.blade.php section component.

REQUIREMENTS:
1. Create directory: resources/views/sections/ (if not exists)
2. Create file: hero.blade.php
3. Props (use Blade component attributes):
   - title: Hero headline
   - subtitle: Hero subheadline
   - eyebrow: Optional small text above title
   - image: Optional background image URL
   - buttons: Array of button configs
4. Structure following Design System Manifesto "Hero Section" pattern
5. Center-aligned by default
6. Support both image background and gradient background
7. Animate content on load (fade-in)
8. Responsive typography
9. Example usage:
   <x-section-hero
     eyebrow="Web Development 2025"
     title="Your Digital Space, Simplified"
     subtitle="Professional websites for freelancers..."
     :buttons="[
       ['text' => 'Get Started', 'href' => '/contact', 'variant' => 'primary'],
       ['text' => 'View Work', 'href' => '/portfolio', 'variant' => 'secondary']
     ]"
   />

Also create: resources/css/sections/_hero.css with styles from Design System Manifesto

Output: New sections/hero.blade.php and _hero.css
```

### PROMPT 6.2: Create Features Section

```
Create resources/views/sections/features.blade.php section component.

REQUIREMENTS:
1. Create file: features.blade.php
2. Props:
   - title: Section title
   - features: Array of feature objects (icon, title, description)
   - columns: Number of columns (2, 3, or 4)
3. Structure following Design System Manifesto "Feature Grid" pattern
4. Use CSS Grid with auto-fit
5. Support SVG icons
6. Responsive (stack on mobile)
7. Animate features on scroll (Intersection Observer)
8. Example usage:
   <x-section-features
     title="What We Do"
     :features="[
       ['icon' => 'rocket', 'title' => 'Fast', 'description' => '...'],
       ['icon' => 'shield', 'title' => 'Secure', 'description' => '...']
     ]"
     :columns="3"
   />

Also create: resources/css/sections/_features.css

Output: New sections/features.blade.php and _features.css
```

### PROMPT 6.3: Create CTA Section

```
Create resources/views/sections/cta.blade.php call-to-action section.

REQUIREMENTS:
1. Create file: cta.blade.php
2. Props:
   - title: CTA headline
   - description: Supporting text
   - buttonText: Primary button text
   - buttonHref: Button link
   - variant: 'centered' | 'split'
3. Two layout variants:
   - Centered: Text and button centered
   - Split: Text left, button right
4. Use gradient background
5. High contrast for accessibility
6. Prominent button styling
7. Responsive layout
8. Example usage:
   <x-section-cta
     title="Ready to Start?"
     description="Let's create your digital space"
     buttonText="Get in Touch"
     buttonHref="/contact"
     variant="centered"
   />

Also create: resources/css/sections/_cta.css

Output: New sections/cta.blade.php and _cta.css
```

---

## 📚 PHASE 7: DOCUMENTATION

### PROMPT 7.1: Update README.md

```
Update README.md with comprehensive documentation.

REQUIREMENTS:
1. Add sections:
   - Overview (what is this theme)
   - Features (CSS4, services, performance, etc.)
   - Requirements (PHP 8.2+, WordPress 6.6+, Node 20+)
   - Installation (step-by-step)
   - Configuration (how to customize)
   - Architecture (high-level overview)
   - Development (how to run locally)
   - Build (production build process)
   - Deployment (deployment guidelines)
   - Customization (how to extend)
   - Troubleshooting (common issues)
   - Contributing (if open source)
   - License (MIT)
2. Use proper markdown formatting
3. Add code examples
4. Add badges (if applicable)
5. Link to other documentation files

Current file location: README.md
Reference: Architecture Blueprint for content
Output: Updated README.md
```

### PROMPT 7.2: Create COMPONENTS.md

```
Create COMPONENTS.md documenting all Blade components.

REQUIREMENTS:
1. Create file: COMPONENTS.md in project root
2. Document each component:
   - Name and purpose
   - Props and their types
   - Slots (if any)
   - Usage examples
   - Visual example (code)
   - CSS classes used
3. Include:
   - Button component
   - Card component
   - Modal component
   - Any other components created
4. Add table of contents
5. Use markdown formatting
6. Add code syntax highlighting

Output: New COMPONENTS.md file
```

### PROMPT 7.3: Create SECTIONS.md

```
Create SECTIONS.md documenting all section components.

REQUIREMENTS:
1. Create file: SECTIONS.md in project root
2. Document each section:
   - Name and purpose
   - Props and their types
   - Layout variants
   - Usage examples
   - Visual example (code)
3. Include:
   - Hero section
   - Features section
   - CTA section
   - Any other sections created
4. Add screenshots or ASCII diagrams if possible
5. Add table of contents

Output: New SECTIONS.md file
```

---

## ✅ PHASE 8: TESTING & OPTIMIZATION

### PROMPT 8.1: Performance Audit Script

```
Create a Node.js script to run Lighthouse performance audits.

REQUIREMENTS:
1. Create file: scripts/lighthouse.js
2. Use lighthouse npm package
3. Run audits for:
   - Desktop
   - Mobile
4. Check for:
   - Performance score >= 95
   - Accessibility score >= 95
   - Best Practices score >= 95
   - SEO score >= 95
5. Generate HTML report
6. Fail CI if scores below threshold
7. Add npm script to package.json: "audit": "node scripts/lighthouse.js"

Output: New scripts/lighthouse.js
```

### PROMPT 8.2: Bundle Size Analysis

```
Create script to analyze and report bundle sizes.

REQUIREMENTS:
1. Add to package.json scripts:
   "analyze": "vite-bundle-visualizer"
2. Add size budgets check script
3. Warn if:
   - Initial CSS > 50KB
   - Initial JS > 100KB
   - Total assets > 500KB
4. Create file: scripts/check-bundle-size.js
5. Run after build
6. Output size report to console

Output: New scripts/check-bundle-size.js and package.json update
```

---

## 🚀 DEPLOYMENT CHECKLIST

After completing all prompts above:

```
FINAL STEPS:
1. Run `composer install` to install PHP dependencies
2. Run `npm install` to install Node dependencies
3. Run `npm run build` to build production assets
4. Test theme in WordPress:
   - Activate theme
   - Check homepage
   - Check blog
   - Check single post
   - Check pages
   - Test dark mode
   - Test mobile menu
   - Test forms
5. Run Lighthouse audit: `npm run audit`
6. Check bundle sizes: `npm run analyze`
7. Test accessibility with axe DevTools
8. Test in multiple browsers
9. Verify SEO meta tags
10. Check Web Vitals in production
```

---

## 📝 NOTES

- **Execute prompts in order** - dependencies matter
- **Test after each phase** - don't accumulate errors
- **Commit frequently** - after each successful prompt
- **Reference documentation** - Blueprint and Manifesto
- **Ask for clarification** - if prompt is unclear
- **Iterate if needed** - prompts are starting points

---

**Version:** 1.0.0
**Last Updated:** 2025-10-21
**Status:** Ready for Claude Code Execution ✅
