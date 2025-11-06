# 🔄 Migration Strategy - Safe Transition Guide
## From Current Sage Theme to Premium Architecture

---

## 🎯 Overview

This document outlines the **safe, incremental migration path** from your current Sage 10 + Tailwind setup to the premium CSS4-first architecture. The goal is to refactor without breaking existing functionality.

**Philosophy:** Build the new system alongside the old, then cut over when ready.

---

## 🛡️ Pre-Migration Checklist

### 1. Backup Everything

```bash
# Create a full backup
git checkout -b backup-before-refactor
git add -A
git commit -m "Backup: Complete theme state before refactor"
git push origin backup-before-refactor

# Export WordPress database (if testing locally)
wp db export backup-$(date +%Y%m%d).sql

# Backup wp-content/uploads
tar -czf uploads-backup-$(date +%Y%m%d).tar.gz wp-content/uploads/
```

### 2. Create Feature Branch

```bash
# Create dedicated branch for refactor
git checkout -b feature/premium-architecture-refactor
```

### 3. Document Current State

```bash
# Take screenshots of:
# - Homepage
# - Blog index
# - Single post
# - Any custom pages
# - Mobile views
# - Dark mode (if exists)

# Run baseline performance audit
npx lighthouse https://your-staging-site.com --output html --output-path ./before-refactor.html

# Document current bundle sizes
npm run build
ls -lh public/build/assets/
```

---

## 📊 Migration Phases (6-Week Timeline)

```
Week 1: Foundation (No Breaking Changes)
├── Create new CSS foundation files
├── Build service layer (empty shells)
└── Set up new file structure

Week 2: Parallel CSS Systems (Both Active)
├── Import new CSS alongside Tailwind
├── Implement services
└── Test design system in isolation

Week 3: Template Migration (Gradual)
├── Refactor one template at a time
├── Test each template thoroughly
└── Keep old templates as fallback

Week 4: Component Migration (Incremental)
├── Build new components
├── Replace old components one by one
└── A/B test if needed

Week 5: JavaScript Modernization
├── Add new core JS modules
├── Remove old scripts gradually
└── Test all interactions

Week 6: Cutover & Cleanup
├── Remove Tailwind completely
├── Delete old files
├── Performance optimization
└── Final testing
```

---

## 🔧 Phase-by-Phase Migration

### PHASE 1: Foundation (Days 1-5)

**Goal:** Create new architecture without touching existing code.

#### Step 1.1: Install New Dependencies

```bash
# Install PostCSS plugins (don't remove Tailwind yet)
npm install --save-dev autoprefixer cssnano postcss-preset-env

# Install Web Vitals
npm install web-vitals

# Update package.json scripts
npm run build  # Ensure build still works
```

**Test:** Build should complete successfully, site should look identical.

#### Step 1.2: Create CSS Foundation

```bash
# Create new directory structure
mkdir -p resources/css/foundation
mkdir -p resources/css/components
mkdir -p resources/css/sections

# Create foundation files (keep empty for now)
touch resources/css/foundation/_tokens.css
touch resources/css/foundation/_reset.css
touch resources/css/foundation/_typography.css
touch resources/css/foundation/_layout.css
touch resources/css/foundation/_utilities.css
touch resources/css/foundation/_animations.css
```

**Test:** Build should still work, site unchanged.

#### Step 1.3: Build Service Layer Shells

```bash
# Create service directory
mkdir -p app/Services
mkdir -p app/ViewComposers

# Create empty service files
touch app/Services/DesignSystemService.php
touch app/Services/PerformanceService.php
touch app/Services/SeoService.php
touch app/Services/I18nService.php
touch app/Services/AssetService.php
touch app/ViewComposers/GlobalComposer.php
```

**Test:** Theme should activate without errors.

---

### PHASE 2: Parallel Systems (Days 6-12)

**Goal:** Run new CSS system alongside Tailwind, isolated.

#### Step 2.1: Populate CSS Foundation

1. Copy token values from Design System Manifesto into `_tokens.css`
2. Add modern CSS reset to `_reset.css`
3. Build typography system in `_typography.css`
4. Add layout utilities to `_layout.css`
5. Add minimal utilities to `_utilities.css`
6. Add animations to `_animations.css`

**IMPORTANT:** Wrap everything in unique namespace to avoid conflicts:

```css
/* _tokens.css */
@layer alpacode-tokens {
  .alpacode-theme {
    /* All your token definitions */
    --color-brand-primary: oklch(60% 0.15 250);
    /* ... */
  }
}
```

#### Step 2.2: Create Parallel app-new.css

Create `resources/css/app-new.css`:

```css
/**
 * NEW SYSTEM - Testing in isolation
 */
@import "./foundation/_tokens.css";
@import "./foundation/_reset.css";
@import "./foundation/_typography.css";
@import "./foundation/_layout.css";
@import "./foundation/_utilities.css";
@import "./foundation/_animations.css";
```

Update `vite.config.js` to build BOTH:

```javascript
input: [
  'resources/css/app.css',      // OLD (Tailwind)
  'resources/css/app-new.css',  // NEW (CSS4)
  'resources/js/app.js',
  // ...
],
```

#### Step 2.3: Test New System on Staging Page

Create test page in WordPress:
- Slug: `/design-system-test`
- Use custom template
- Apply `.alpacode-theme` wrapper class
- Enqueue `app-new.css` only on this page

**Test:** 
- Design system works in isolation
- No conflicts with main site
- All tokens render correctly

---

### PHASE 3: Template Migration (Days 13-21)

**Goal:** Migrate templates one at a time, keeping old as fallback.

#### Step 3.1: Create New Template Directory

```bash
mkdir -p resources/views/templates-new/
```

#### Step 3.2: Migrate Templates Individually

**Order of migration:**

1. **404.blade.php** (safest, least traffic)
   - Create `templates-new/404.blade.php`
   - Use new CSS classes
   - Test thoroughly
   - When ready, move to `templates/404.blade.php`

2. **page.blade.php** (medium risk)
   - Create new version
   - Test on staging pages
   - Gradual rollout

3. **single.blade.php** (higher risk)
   - Create new version
   - Test with various post types
   - Check comments, metadata

4. **index.blade.php** (highest risk)
   - Create new version
   - Test blog listing
   - Check pagination, filters

#### Step 3.3: A/B Testing Strategy (Optional)

For critical templates, implement A/B testing:

```php
// In template file
$use_new_design = (get_query_var('new_design') === '1') || (rand(1, 100) <= 50);

if ($use_new_design) {
    include(locate_template('templates-new/single.blade.php'));
} else {
    include(locate_template('templates/single.blade.php'));
}
```

**Test:**
- Compare metrics between old/new
- Monitor error logs
- Track user feedback

---

### PHASE 4: Service Implementation (Days 14-20)

**Goal:** Implement services without breaking existing code.

#### Step 4.1: Implement Services One by One

1. **DesignSystemService** (lowest risk)
   - Implement all methods
   - Test in isolation
   - Add to ThemeServiceProvider
   - Verify no errors

2. **I18nService** (low risk)
   - Implement
   - Test translations
   - Doesn't affect layout

3. **SeoService** (medium risk)
   - Implement
   - Test meta tags
   - Verify SEO tools still work

4. **PerformanceService** (medium risk)
   - Implement
   - Monitor actual performance
   - Ensure no slowdowns

5. **AssetService** (higher risk)
   - Implement carefully
   - Test asset loading
   - Check for missing scripts

#### Step 4.2: Gradual Service Adoption

Don't use all services immediately. Adopt gradually:

```php
// Week 1: Just register
$this->app->singleton(DesignSystemService::class);

// Week 2: Use in one place
public function boot() {
    $designSystem = app(DesignSystemService::class);
    // Use cautiously
}

// Week 3: Full integration
// Use everywhere
```

---

### PHASE 5: JavaScript Modernization (Days 22-28)

**Goal:** Add new JS modules without breaking old code.

#### Step 5.1: Create New JS Modules

```bash
mkdir -p resources/js/core
mkdir -p resources/js/utils

# Create new modules
touch resources/js/core/theme-switcher.js
touch resources/js/core/navigation.js
touch resources/js/core/view-transitions.js
touch resources/js/core/performance.js
touch resources/js/core/accessibility.js
```

#### Step 5.2: Feature Detection

Use feature detection to prevent conflicts:

```javascript
// In theme-switcher.js
if (!window.hasThemeSwitcher) {
  window.hasThemeSwitcher = true
  
  export function initThemeSwitcher() {
    // Implementation
  }
}
```

#### Step 5.3: Progressive Enhancement

Enable new features gradually:

```javascript
// In app.js
document.addEventListener('DOMContentLoaded', () => {
  // Enable new features one by one
  if (window.CSS && CSS.supports('selector(:has(*))')) {
    initViewTransitions()
  }
  
  if (window.matchMedia('(prefers-color-scheme: dark)').media !== 'not all') {
    initThemeSwitcher()
  }
  
  // Always safe
  initAccessibility()
})
```

---

### PHASE 6: Cutover & Cleanup (Days 29-35)

**Goal:** Remove old system, clean up, optimize.

#### Step 6.1: Remove Tailwind (Day 29)

**This is the big switch. Do on low-traffic time.**

1. **Create rollback point:**
```bash
git add -A
git commit -m "Checkpoint before Tailwind removal"
git tag before-tailwind-removal
```

2. **Remove Tailwind from vite.config.js:**
```javascript
// REMOVE THIS LINE:
// import tailwindcss from '@tailwindcss/vite'

// REMOVE FROM plugins:
// tailwindcss(),

// UPDATE wordpressThemeJson:
wordpressThemeJson({
  disableTailwindColors: true,
  disableTailwindFonts: true,
  disableTailwindFontSizes: true,
}),
```

3. **Rename app-new.css to app.css:**
```bash
mv resources/css/app.css resources/css/app-old.css.backup
mv resources/css/app-new.css resources/css/app.css
```

4. **Remove Tailwind from package.json:**
```bash
npm uninstall @tailwindcss/vite tailwindcss
npm install  # Clean install
```

5. **Build and test:**
```bash
npm run build
# Test every page
# Check for styling issues
# Verify dark mode
# Test responsive
```

**Rollback procedure if needed:**
```bash
git reset --hard before-tailwind-removal
npm install
npm run build
```

#### Step 6.2: Delete Old Files (Day 30)

**Only after 24 hours of successful operation:**

```bash
# Remove old template backups
rm -rf resources/views/templates-old/

# Remove old CSS backup
rm resources/css/app-old.css.backup

# Remove Tailwind config if exists
rm tailwind.config.js

# Clean up any old component files
# (Manual review recommended)
```

#### Step 6.3: Optimize Build (Days 31-32)

Now that Tailwind is gone, optimize:

1. **Reduce bundle size:**
```javascript
// vite.config.js
build: {
  minify: 'esbuild',
  cssMinify: true,
  rollupOptions: {
    output: {
      manualChunks: {
        'vendor': ['alpinejs'],
        'core': ['/resources/js/core/theme-switcher.js'],
      },
    },
  },
}
```

2. **Inline critical CSS:**
```php
// In ThemeServiceProvider or layouts/app.blade.php
$criticalCss = app(PerformanceService::class)->getCriticalCss();
echo "<style>{$criticalCss}</style>";
```

3. **Preload fonts:**
```blade
<link rel="preload" href="{{ asset('fonts/inter/inter-variable.woff2') }}" as="font" type="font/woff2" crossorigin>
```

#### Step 6.4: Performance Verification (Days 33-34)

**Run comprehensive audits:**

```bash
# Lighthouse
npx lighthouse https://your-site.com --view

# Check bundle sizes
npm run build
ls -lh public/build/assets/

# Compare before/after
# Target improvements:
# - Bundle size: -50% or more
# - Lighthouse score: 95+ all categories
# - FCP: <1.5s
# - LCP: <2.5s
```

#### Step 6.5: Documentation Update (Day 35)

Update all docs with new architecture:

1. **README.md** - Remove Tailwind references
2. **COMPONENTS.md** - Document new components
3. **SECTIONS.md** - Document new sections
4. **DEPLOYMENT.md** - Update deployment guide

---

## 🚨 Rollback Procedures

### Immediate Rollback (Within 1 hour)

If critical issue found right after cutover:

```bash
# Rollback to before Tailwind removal
git reset --hard before-tailwind-removal
npm install
npm run build
composer install

# Redeploy
# Site should be back to old state
```

### Partial Rollback (Specific feature)

If one new feature is broken:

```javascript
// In app.js, disable the problematic feature
// document.addEventListener('DOMContentLoaded', () => {
//   initViewTransitions()  // Comment out if broken
// })
```

### CSS Emergency Fix

If CSS is completely broken:

```bash
# Quick fix: re-enable Tailwind temporarily
git checkout app-old.css.backup resources/css/app.css
npm run build
```

---

## 🔍 Testing Checklist

### After Each Phase

- [ ] Theme activates without errors
- [ ] Homepage loads correctly
- [ ] Blog index works
- [ ] Single post works
- [ ] Pages work
- [ ] Search works
- [ ] 404 page works
- [ ] Mobile responsive
- [ ] Dark mode (if implemented)
- [ ] Forms submit correctly
- [ ] Navigation works
- [ ] Footer displays
- [ ] No console errors
- [ ] No PHP errors in logs

### Before Cutover (Day 29)

- [ ] All core features work
- [ ] All templates migrated
- [ ] All services implemented
- [ ] All JS modules work
- [ ] Performance improved
- [ ] Accessibility verified (axe)
- [ ] SEO verified (Lighthouse, Google Search Console)
- [ ] Cross-browser tested (Chrome, Firefox, Safari, Edge)
- [ ] Mobile tested (iOS Safari, Chrome Android)
- [ ] Staging matches production environment
- [ ] Backup created
- [ ] Rollback procedure tested
- [ ] Team trained on new system

---

## 📈 Success Metrics

### Performance

- **Before:** Lighthouse ~75-80
- **Target:** Lighthouse 95+
- **Metric:** CSS bundle size reduced by 50%+
- **Metric:** JS bundle size similar or smaller
- **Metric:** FCP < 1.5s
- **Metric:** LCP < 2.5s
- **Metric:** CLS < 0.1

### Developer Experience

- **Metric:** Build time same or faster
- **Metric:** Hot reload (HMR) works perfectly
- **Metric:** CSS changes reflected instantly
- **Metric:** Less code to maintain
- **Metric:** Clear separation of concerns

### User Experience

- **Metric:** No visual regressions
- **Metric:** Faster page loads (perceived)
- **Metric:** Smooth animations
- **Metric:** Better accessibility scores
- **Metric:** Dark mode works flawlessly

---

## 🛟 Troubleshooting Common Issues

### Issue 1: Styles Not Applying

**Symptom:** New CSS classes don't work

**Solution:**
```bash
# Clear build cache
rm -rf public/build/
npm run build

# Clear WordPress cache
wp cache flush

# Hard refresh browser (Cmd+Shift+R)
```

### Issue 2: JavaScript Errors

**Symptom:** Console shows module errors

**Solution:**
```javascript
// Check module paths in vite.config.js
resolve: {
  alias: {
    '@scripts': '/resources/js',  // Correct path?
  },
}
```

### Issue 3: Services Not Found

**Symptom:** Class not found errors

**Solution:**
```bash
# Regenerate autoload
composer dump-autoload

# Check namespace in service files
namespace App\Services;  // Correct?

# Verify registration in ThemeServiceProvider
```

### Issue 4: Dark Mode Not Working

**Symptom:** Theme doesn't switch

**Solution:**
```javascript
// Check if theme-switcher initialized
console.log(window.hasThemeSwitcher)

// Check localStorage
localStorage.getItem('theme')

// Check data attribute
document.documentElement.dataset.theme
```

### Issue 5: Performance Worse

**Symptom:** Lighthouse score decreased

**Solution:**
```bash
# Check bundle sizes
npm run build
ls -lh public/build/assets/

# Verify critical CSS inlined
view-source:https://your-site.com
# Look for <style> in <head>

# Check for render-blocking resources
npx lighthouse --view
```

---

## 📞 Support & Resources

### Documentation

- **Architecture Blueprint:** `01_ARCHITECTURE_BLUEPRINT.md`
- **Design System:** `02_DESIGN_SYSTEM_MANIFESTO.md`
- **Claude Code Prompts:** `03_CLAUDE_CODE_PROMPTS.md`
- **This Document:** `04_MIGRATION_STRATEGY.md`

### External Resources

- **Sage Docs:** https://roots.io/sage/docs/
- **Vite Docs:** https://vitejs.dev/
- **Laravel Blade:** https://laravel.com/docs/blade
- **Web.dev:** https://web.dev/
- **Can I Use:** https://caniuse.com/

### Emergency Contacts

- **Theme Lead:** [Your name]
- **DevOps:** [DevOps contact]
- **Hosting Support:** [Hosting provider]

---

## 🎯 Final Checklist

Before declaring migration complete:

- [ ] All old Tailwind code removed
- [ ] All templates using new design system
- [ ] All components documented
- [ ] All services working correctly
- [ ] Performance targets met
- [ ] Accessibility verified
- [ ] SEO verified
- [ ] Cross-browser tested
- [ ] Mobile tested
- [ ] Dark mode working
- [ ] Build process optimized
- [ ] Documentation updated
- [ ] Team trained
- [ ] Backup verified
- [ ] Monitoring in place
- [ ] No errors in production logs
- [ ] Stakeholders approved
- [ ] Launch announcement prepared

---

**Remember:** Take your time, test thoroughly, and don't rush the cutover. It's better to spend an extra week in parallel mode than to launch with issues.

**Version:** 1.0.0
**Last Updated:** 2025-10-21
**Migration Lead:** [Your name]
**Status:** Ready for Execution ✅
