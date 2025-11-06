# ⚡ Quick Start Guide - TL;DR
## Get Started in 10 Minutes

---

## 🎯 What You Have

✅ **4 Comprehensive Documents** (worth €10k of premium agency work):

1. **Architecture Blueprint** - Complete technical specification
2. **Design System Manifesto** - Full visual identity system
3. **Claude Code Prompts** - 40+ ready-to-use prompts
4. **Migration Strategy** - Safe transition guide

---

## 🚀 Fastest Path to Implementation

### Option A: Use Claude Code (RECOMMENDED)

**Best for:** Iterative development, testing in real environment

```bash
# 1. Open Claude Code in your terminal
cd /path/to/your/sage-theme

# 2. Copy-paste prompts from 03_CLAUDE_CODE_PROMPTS.md
# Start with PHASE 1: FOUNDATION
# Execute prompts 1.1 through 1.5

# 3. Test after each phase
npm run build

# 4. Continue through all phases
# PHASE 2 → PHASE 3 → PHASE 4 → etc.

# 5. Deploy when ready
```

**Timeline with Claude Code:**
- Phase 1 (Foundation): 1 day
- Phase 2 (Services): 2 days  
- Phase 3 (Templates): 3 days
- Phase 4 (JS): 2 days
- Phase 5 (Components): 2 days
- Phase 6 (Polish): 2 days
**Total: ~12 days** of active work

---

### Option B: Manual Implementation

**Best for:** Learning the architecture, full control

```bash
# 1. Read Architecture Blueprint (30 min)
# Understand the structure and philosophy

# 2. Read Design System Manifesto (20 min)
# Understand the design patterns

# 3. Follow Migration Strategy (ongoing)
# Safe, incremental implementation

# 4. Reference Claude Code Prompts as needed
# Use as detailed specifications
```

**Timeline Manual:**
- Foundation: 2-3 days
- Services: 3-4 days
- Templates: 5-7 days  
- JS: 3-4 days
- Components: 4-5 days
- Polish: 3-4 days
**Total: ~3-4 weeks** of active work

---

## 📋 Critical First Steps (Do This Now)

### 1. Backup Current State (5 min)

```bash
git checkout -b backup-before-refactor
git add -A
git commit -m "Backup: Complete theme before refactor"
git push origin backup-before-refactor

git checkout -b feature/premium-architecture
```

### 2. Install Dependencies (2 min)

```bash
npm install --save-dev autoprefixer cssnano postcss-preset-env
npm install web-vitals
```

### 3. Create Foundation Structure (3 min)

```bash
mkdir -p resources/css/foundation
mkdir -p resources/css/components
mkdir -p resources/css/sections
mkdir -p resources/js/core
mkdir -p app/Services
mkdir -p app/ViewComposers
mkdir -p config
```

**You're now ready to start!**

---

## 🎨 Design System Quick Reference

### Color Tokens

```css
/* Use these in your CSS */
--color-brand-primary: oklch(60% 0.15 250);
--color-text-primary: var(--color-neutral-1000);
--color-surface-base: var(--color-neutral-0);
```

### Typography Scale

```css
/* Fluid type that scales perfectly */
font-size: var(--font-size-5xl);  /* Hero */
font-size: var(--font-size-3xl);  /* Section headings */
font-size: var(--font-size-base); /* Body */
```

### Spacing Scale

```css
/* Harmonious spacing */
padding: var(--space-lg);    /* 32-40px */
gap: var(--space-md);        /* 24-30px */
margin-block-end: var(--space-xl); /* 48-60px */
```

### Common Patterns

```css
/* Button */
.button {
  padding: var(--space-sm) var(--space-lg);
  background: var(--color-brand-primary);
  color: var(--color-text-inverse);
  border-radius: var(--radius-md);
  transition: all var(--duration-base) var(--easing-out);
}

/* Card */
.card {
  background: var(--color-surface-raised);
  padding: var(--space-lg);
  border-radius: var(--radius-lg);
  box-shadow: var(--shadow-sm);
}

/* Container */
.container {
  max-width: var(--container-xl);
  margin-inline: auto;
  padding-inline: var(--gutter);
}
```

---

## 🔧 Essential Services

### Use in Blade Templates

```blade
{{-- Dark/Light theme --}}
<html data-theme="{{ $theme }}">

{{-- SEO Meta Tags --}}
{!! $metaTags !!}
{!! $schemaMarkup !!}

{{-- Translations --}}
{{ __('Read more', 'sage') }}

{{-- Current locale --}}
@if($isRtl)
  <html dir="rtl">
@endif
```

### Use in PHP

```php
// Get service instance
$designSystem = app(DesignSystemService::class);
$performance = app(PerformanceService::class);

// Use service methods
$tokens = $designSystem->getTokens();
$criticalCss = $performance->getCriticalCss();
```

---

## 🎭 Component Usage

### Button Component

```blade
<x-button variant="primary" size="lg" href="/contact">
  Get Started
</x-button>

<x-button variant="secondary" size="base" type="button">
  Learn More
</x-button>
```

### Card Component

```blade
<x-card hover padding="lg">
  <x-slot:header>
    <h3>Card Title</h3>
  </x-slot:header>
  
  <p>Card content goes here...</p>
  
  <x-slot:footer>
    <x-button variant="ghost">Read More</x-button>
  </x-slot:footer>
</x-card>
```

### Section Components

```blade
<x-section-hero
  title="Your Digital Space, Simplified"
  subtitle="Professional websites for freelancers and creators"
  :buttons="[
    ['text' => 'Get Started', 'href' => '/contact', 'variant' => 'primary'],
    ['text' => 'View Work', 'href' => '/portfolio', 'variant' => 'secondary']
  ]"
/>

<x-section-features
  title="What We Do"
  :features="[
    ['icon' => 'rocket', 'title' => 'Fast', 'description' => '...'],
    ['icon' => 'shield', 'title' => 'Secure', 'description' => '...']
  ]"
  :columns="3"
/>
```

---

## 🚨 Troubleshooting Quick Fixes

### Styles Not Working?

```bash
rm -rf public/build/
npm run build
wp cache flush
# Hard refresh browser (Cmd+Shift+R)
```

### Services Not Found?

```bash
composer dump-autoload
# Check ThemeServiceProvider registrations
```

### Build Errors?

```bash
npm install
rm -rf node_modules
npm install
npm run build
```

### Dark Mode Not Working?

```javascript
// Check in browser console
localStorage.getItem('theme')
document.documentElement.dataset.theme
```

---

## 📊 Success Criteria

✅ **Lighthouse Score:** 95+ all categories
✅ **Bundle Size:** CSS <50KB, JS <100KB
✅ **FCP:** <1.5 seconds
✅ **No Console Errors**
✅ **WCAG AA Compliance**
✅ **Dark Mode Works**
✅ **Mobile Responsive**

---

## 🎓 Learning Path

### Day 1: Understand
- [ ] Read Architecture Blueprint (focus on "Philosophy" and "File Structure")
- [ ] Read Design System Manifesto (focus on "Color System" and "Typography")
- [ ] Skim Migration Strategy

### Day 2-3: Foundation
- [ ] Execute Phase 1 prompts (CSS foundation)
- [ ] Test design system in isolation
- [ ] Verify tokens work

### Day 4-5: Services
- [ ] Execute Phase 2 prompts (Services)
- [ ] Test each service individually
- [ ] Verify ViewComposers work

### Day 6-8: Templates
- [ ] Execute Phase 3 prompts (Templates)
- [ ] Migrate one template at a time
- [ ] Test thoroughly after each

### Day 9-10: JavaScript
- [ ] Execute Phase 4 prompts (JS)
- [ ] Test interactions
- [ ] Verify dark mode, navigation

### Day 11-12: Components
- [ ] Build reusable components
- [ ] Document usage
- [ ] Test across pages

### Week 3: Polish & Deploy
- [ ] Performance optimization
- [ ] Accessibility audit
- [ ] Browser testing
- [ ] Deploy to staging
- [ ] Final testing
- [ ] Deploy to production

---

## 🔗 Essential Links

| Resource | Link |
|----------|------|
| Architecture Blueprint | `01_ARCHITECTURE_BLUEPRINT.md` |
| Design System | `02_DESIGN_SYSTEM_MANIFESTO.md` |
| Claude Code Prompts | `03_CLAUDE_CODE_PROMPTS.md` |
| Migration Strategy | `04_MIGRATION_STRATEGY.md` |
| Sage Docs | https://roots.io/sage/docs/ |
| Vite Docs | https://vitejs.dev/ |
| Web.dev | https://web.dev/ |

---

## 💡 Pro Tips

**Tip 1:** Start with ONE template
- Refactor 404.blade.php first (lowest risk)
- Test thoroughly
- Build confidence
- Then move to more critical templates

**Tip 2:** Use Git branches
- One branch per phase
- Commit after each successful prompt
- Easy rollback if needed

**Tip 3:** Test continuously
- Don't accumulate changes
- Test after every 2-3 prompts
- Fix issues immediately

**Tip 4:** Use browser DevTools
- Inspect CSS custom properties
- Check computed styles
- Verify dark mode tokens

**Tip 5:** Leverage Claude Code
- Copy prompts verbatim
- Let Claude Code handle file creation
- Review and test
- Iterate as needed

---

## 🎯 Your First Hour

```bash
# Hour 1: Setup & Foundation

# Minute 0-5: Backup
git checkout -b backup-before-refactor
git add -A && git commit -m "Backup"
git checkout -b feature/premium-architecture

# Minute 5-10: Dependencies
npm install --save-dev autoprefixer cssnano postcss-preset-env
npm install web-vitals

# Minute 10-15: File Structure
mkdir -p resources/css/foundation
mkdir -p app/Services
# ... (create all directories)

# Minute 15-25: Open Claude Code
cd your-theme
# Copy PROMPT 1.1 from 03_CLAUDE_CODE_PROMPTS.md
# Execute in Claude Code

# Minute 25-35: Execute PROMPT 1.2 (Vite Config)
# Copy, paste, execute

# Minute 35-50: Execute PROMPT 1.3 (CSS Foundation)
# This creates all foundation files

# Minute 50-60: Execute PROMPT 1.4 (app.css)
# Test build
npm run build

# ✅ You now have the foundation ready!
```

---

## 📞 Need Help?

**Check these in order:**

1. **Documentation** - All answers are in the 4 docs
2. **Migration Strategy** - Section "Troubleshooting Common Issues"
3. **Architecture Blueprint** - Section "Best Practices"
4. **Claude Code** - Ask for clarification on specific prompts
5. **Sage Community** - https://discourse.roots.io/

---

## ✅ Final Checklist

Before starting:
- [ ] Read this Quick Start (you are here!)
- [ ] Backup current theme
- [ ] Create feature branch
- [ ] Install dependencies
- [ ] Create directory structure

After each phase:
- [ ] Test build (`npm run build`)
- [ ] Test site (visual check)
- [ ] Check console for errors
- [ ] Commit to git
- [ ] Take notes

Before deploying:
- [ ] All prompts executed
- [ ] All tests passing
- [ ] Lighthouse score 95+
- [ ] Cross-browser tested
- [ ] Mobile tested
- [ ] Dark mode works
- [ ] No console errors
- [ ] Documentation updated

---

**You're Ready! Start with PROMPT 1.1 in Claude Code.**

**Good luck! 🚀**

---

**Version:** 1.0.0
**Created:** 2025-10-21
**Status:** Ready to Go ✅
