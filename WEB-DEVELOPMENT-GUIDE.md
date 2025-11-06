# Web Development Guide - Alpacode Studio Theme

## Philosophy: CSS4-First, Component-Driven Development

This theme is built on a **plug-and-play component architecture** that eliminates boilerplate code. When facing a blank file, developers should leverage the comprehensive framework rather than building from scratch.

---

## Table of Contents

1. [Quick Start Workflow](#quick-start-workflow)
2. [New Components Overview](#new-components-overview)
3. [Complete Usage Examples](#complete-usage-examples)
4. [GSAP Animation Utilities](#gsap-animation-utilities)
5. [CSS Design Tokens](#css-design-tokens)
6. [Best Practices](#best-practices)

---

## Quick Start Workflow

### Step 1: Choose Your Components

Available Blade components in `resources/views/components/`:

**Layout & Sections:**
- `<x-parallax-hero>` - Hero section with parallax background
- `<x-parallax-section>` - Generic parallax wrapper
- `<x-section-hero>` - Standard hero section
- `<x-section-features>` - Feature grid
- `<x-section-cta>` - Call-to-action section

**UI Elements:**
- `<x-button>` - Versatile button component
- `<x-card>` - Content card
- `<x-modal>` - Modal dialog
- `<x-carousel>` - Swiper carousel
- `<x-gallery>` - PhotoSwipe gallery
- `<x-social-icons>` - Social media icon bar
- `<x-sliding-text>` - Animated marquee

**Effects:**
- `<x-loader>` - Full-page loader
- `<x-vanta-background>` - 3D animated background

### Step 2: Apply Design Tokens

Your CSS architecture provides 100+ design tokens via CSS variables:

```css
/* Colors (OKLCH color space) */
var(--color-brand-primary)     /* #F65100 */
var(--color-surface-base)      /* Adaptive light/dark */
var(--color-text-primary)      /* High contrast */

/* Spacing (fluid responsive) */
var(--space-sm)   /* clamp(1rem, 0.9rem + 0.5vw, 1.25rem) */
var(--space-lg)   /* clamp(2rem, 1.8rem + 1vw, 2.5rem) */
var(--space-3xl)  /* clamp(6rem, 5.4rem + 3vw, 7.5rem) */

/* Typography (fluid) */
var(--font-size-3xl)       /* clamp(1.875rem, 1.25vw + 1.5rem, 2.5rem) */
var(--font-size-display-1) /* clamp(8rem, 12vw + 2rem, 18rem) */
```

### Step 3: Add Animations (GSAP)

Import utilities and apply scroll-triggered animations:

```javascript
// GSAPUtils is globally available via window.GSAPUtils

// Fade in on scroll
window.GSAPUtils.fadeInOnScroll('.hero__title', { y: 50, duration: 0.8 })

// Parallax effect
window.GSAPUtils.parallax('.hero__background', 0.5)

// Stagger children
window.GSAPUtils.staggerOnScroll('.feature-grid', '.feature-card')
```

---

## New Components Overview

### 1. Parallax Hero (`<x-parallax-hero>`)

**Purpose:** Pre-configured hero section with parallax background and GSAP animations.

**Props:**
- `eyebrow` - Small text above title
- `title` - Main headline (required)
- `subtitle` - Subheadline text
- `buttons` - Array of button configs
- `background` - Background image path
- `overlay` - Show overlay (default: true)
- `overlayOpacity` - Overlay opacity (default: 0.5)
- `parallaxSpeed` - Speed of parallax (default: 0.3)
- `height` - full, tall, medium, compact (default: full)
- `alignment` - left, center, right (default: center)
- `animateTitle` - Enable title animation (default: true)
- `animateSubtitle` - Enable subtitle animation (default: true)

**Basic Example:**

```blade
<x-parallax-hero
  title="Build Amazing Experiences"
  subtitle="With our CSS4-first theme framework"
  background="{{ asset('images/hero-bg.jpg') }}"
  :buttons="[
    ['text' => 'Get Started', 'href' => '/start', 'variant' => 'primary'],
    ['text' => 'Learn More', 'href' => '/docs', 'variant' => 'secondary']
  ]"
/>
```

**Advanced Example:**

```blade
<x-parallax-hero
  eyebrow="Welcome to the future"
  title="Design Without Limits"
  subtitle="Create stunning web experiences with our component-driven framework"
  background="{{ asset('images/hero.jpg') }}"
  overlay="true"
  overlayOpacity="0.6"
  parallaxSpeed="0.5"
  height="tall"
  alignment="left"
  :buttons="[
    ['text' => 'Start Free Trial', 'href' => '/trial', 'variant' => 'primary', 'size' => 'lg'],
    ['text' => 'View Demo', 'href' => '/demo', 'variant' => 'ghost', 'size' => 'lg']
  ]"
/>
```

---

### 2. Parallax Section (`<x-parallax-section>`)

**Purpose:** Generic parallax wrapper for any content.

**Props:**
- `speed` - Parallax speed (default: 0.5)
- `background` - Background image path
- `overlay` - Show overlay (default: false)
- `overlayOpacity` - Overlay opacity (default: 0.3)
- `layers` - Array of parallax layers for multi-layer effects

**Single Background Example:**

```blade
<x-parallax-section
  background="{{ asset('images/section-bg.jpg') }}"
  speed="0.3"
  overlay="true"
>
  <div class="container section">
    <h2 class="display-2" data-animate>Your Content Here</h2>
    <p data-animate>Any HTML content goes in the slot.</p>
  </div>
</x-parallax-section>
```

**Multi-Layer Parallax Example:**

```blade
<x-parallax-section
  :layers="[
    ['speed' => 0.2, 'image' => asset('images/layer-back.png'), 'class' => 'parallax-back'],
    ['speed' => 0.5, 'image' => asset('images/layer-middle.png'), 'class' => 'parallax-middle'],
    ['speed' => 0.8, 'image' => asset('images/layer-front.png'), 'class' => 'parallax-front']
  ]"
>
  <div class="container section">
    <h2>Multi-layer parallax depth</h2>
  </div>
</x-parallax-section>
```

---

### 3. Social Icons (`<x-social-icons>`)

**Purpose:** Social media icon bar with flexible positioning.

**Props:**
- `position` - inline, fixed-left, fixed-right, fixed-bottom (default: inline)
- `platforms` - Array of platform names or custom configs
- `size` - sm, base, lg (default: base)
- `variant` - default, minimal, filled, outlined, labeled (default: default)
- `animated` - Hover animation (default: true)
- `orientation` - vertical, horizontal (default: vertical for fixed, horizontal for inline)

**Supported Platforms:**
- github, twitter, linkedin, dribbble, instagram, youtube, facebook, email, codepen

**Basic Example:**

```blade
<x-social-icons
  :platforms="['github', 'twitter', 'linkedin', 'dribbble']"
/>
```

**Fixed Left Position:**

```blade
<x-social-icons
  position="fixed-left"
  :platforms="['github', 'twitter', 'linkedin']"
  variant="filled"
  size="lg"
/>
```

**Custom Platform:**

```blade
<x-social-icons
  :platforms="[
    'github',
    'twitter',
    [
      'url' => 'https://example.com',
      'label' => 'Custom Link',
      'icon' => '<svg>...</svg>'
    ]
  ]"
/>
```

**Labeled Variant:**

```blade
<x-social-icons
  variant="labeled"
  :platforms="['github', 'twitter', 'linkedin']"
  orientation="horizontal"
/>
```

---

## Complete Usage Examples

### Example 1: Parallax Hero with Social Icons

**The Old Way (50+ lines of code):**

```blade
<!-- Complex HTML structure -->
<section class="hero">
  <div class="hero-bg" id="hero-bg-123">
    <img src="...">
    <div class="overlay"></div>
  </div>
  <div class="container">
    <h1 id="hero-title-123">Title</h1>
    <p id="hero-subtitle-123">Subtitle</p>
    <div class="cta">
      <a href="..." class="button button--primary">CTA</a>
    </div>
  </div>
</section>

<!-- Separate CSS file -->
<style>
  .hero { /* 20+ lines of CSS */ }
  /* More CSS... */
</style>

<!-- Separate JS initialization -->
<script>
window.GSAPUtils.parallax('#hero-bg-123', 0.3)
window.GSAPUtils.fadeInOnScroll('#hero-title-123', { y: 100, duration: 1.2, delay: 0.2 })
window.GSAPUtils.fadeInOnScroll('#hero-subtitle-123', { y: 50, duration: 1, delay: 0.4 })
</script>
```

**The New Way (5 lines of code):**

```blade
<x-parallax-hero
  title="Build Amazing Experiences"
  subtitle="With our CSS4-first theme framework"
  background="{{ asset('images/hero-bg.jpg') }}"
  :buttons="[
    ['text' => 'Get Started', 'href' => '/start', 'variant' => 'primary'],
    ['text' => 'Learn More', 'href' => '/docs', 'variant' => 'secondary']
  ]"
/>

<x-social-icons
  position="fixed-left"
  :platforms="['github', 'twitter', 'linkedin', 'dribbble']"
  variant="filled"
/>
```

**That's it!** No custom CSS, no JS initialization, everything just works.

---

### Example 2: Complete Landing Page

```blade
{{-- Hero Section --}}
<x-parallax-hero
  eyebrow="Welcome to Alpacode"
  title="Design Without Limits"
  subtitle="Build stunning websites with our component-driven framework"
  background="{{ asset('images/hero.jpg') }}"
  height="full"
  :buttons="[
    ['text' => 'Start Free Trial', 'href' => '/trial', 'variant' => 'primary', 'size' => 'lg'],
    ['text' => 'View Demo', 'href' => '/demo', 'variant' => 'secondary', 'size' => 'lg']
  ]"
/>

{{-- Features Section with Parallax Background --}}
<x-parallax-section
  background="{{ asset('images/features-bg.jpg') }}"
  speed="0.4"
  overlay="true"
  overlayOpacity="0.7"
>
  <div class="container section">
    <h2 class="display-2 text-center" data-animate>Powerful Features</h2>

    <div class="grid grid--3 gap-lg mt-2xl">
      @foreach($features as $feature)
        <x-card>
          <x-slot:header>
            <h3>{{ $feature['title'] }}</h3>
          </x-slot:header>
          <p>{{ $feature['description'] }}</p>
        </x-card>
      @endforeach
    </div>
  </div>
</x-parallax-section>

{{-- Gallery Section --}}
<section class="section">
  <div class="container">
    <h2 class="display-2 text-center" data-animate>Our Work</h2>

    <x-gallery>
      @foreach($images as $image)
        <img src="{{ $image }}" alt="Portfolio item">
      @endforeach
    </x-gallery>
  </div>
</section>

{{-- CTA Section --}}
<x-section-cta
  title="Ready to Get Started?"
  subtitle="Join thousands of developers building with our framework"
  button-text="Start Free Trial"
  button-href="/trial"
/>

{{-- Fixed Social Icons --}}
<x-social-icons
  position="fixed-left"
  :platforms="['github', 'twitter', 'linkedin', 'dribbble']"
  variant="filled"
  animated="true"
/>
```

---

## GSAP Animation Utilities

### Basic Utilities

```javascript
// GSAPUtils is globally available via window.GSAPUtils

// Fade in on scroll
window.GSAPUtils.fadeInOnScroll('.element', {
  y: 50,           // Move from 50px below
  opacity: 0,      // Start transparent
  duration: 0.8,   // Animation duration
  stagger: 0.2     // Delay between multiple elements
})

// Parallax effect
window.GSAPUtils.parallax('.background', 0.5)  // 0.5 = half speed

// Slide in from direction
window.GSAPUtils.slideInOnScroll('.card', 'left', { duration: 1 })

// Stagger children
window.GSAPUtils.staggerOnScroll('.container', '.child')

// Reveal with scale
window.GSAPUtils.revealOnScroll('.box', { scale: 0.8, opacity: 0 })

// Rotate on scroll
window.GSAPUtils.rotateOnScroll('.icon', 360)

// Scale on scroll
window.GSAPUtils.scaleOnScroll('.image', 1.2)

// Animated counter
window.GSAPUtils.animateCounter('.stat-number', 1000, 2)

// Pin while scrolling
window.GSAPUtils.pinOnScroll('.sidebar', '+=500')
```

### NEW: Enhanced Utilities

```javascript
// Split text into characters for animation
window.GSAPUtils.splitTextChars('.title')

// Animate text character by character
window.GSAPUtils.animateTextChars('.title', {
  y: 50,
  opacity: 0,
  stagger: 0.03,
  ease: 'back.out(1.7)'
})

// Complete hero entrance (preset combo)
window.GSAPUtils.heroEntrance({
  title: '.hero__title',
  subtitle: '.hero__subtitle',
  cta: '.hero__cta',
  background: '.hero__background'
})

// Scroll progress indicator
window.GSAPUtils.scrollProgress('.progress-bar')

// Magnetic button effect
window.GSAPUtils.magneticEffect('.button--magnetic', 0.3)

// Image reveal with clip-path
window.GSAPUtils.imageReveal('.image', 'right')

// Card grid stagger animation
window.GSAPUtils.cardGridStagger('.grid', '.card')

// Floating animation (infinite loop)
window.GSAPUtils.floatingAnimation('.icon', { y: -20, duration: 2 })

// Batch scroll animations (performance optimized)
window.GSAPUtils.batchScrollAnimation('.fade-in-item', {
  y: 50,
  opacity: 0,
  stagger: 0.1
})
```

### Preset Animation Example

```blade
<section class="hero">
  <div class="hero__background">
    <img src="hero.jpg" alt="">
  </div>
  <div class="container">
    <h1 class="hero__title">Amazing Title</h1>
    <p class="hero__subtitle">Subtitle text</p>
    <div class="hero__cta">
      <button>Get Started</button>
    </div>
  </div>
</section>

<script type="module">
// GSAPUtils is globally available via window.GSAPUtils

// One line for complete hero animation!
window.GSAPUtils.heroEntrance()
</script>
```

---

## CSS Design Tokens

### Color System (OKLCH)

```css
/* Brand Colors */
--color-brand-primary: oklch(65% 0.23 40);     /* Orange #F65100 */
--color-brand-secondary: oklch(70% 0.12 180);  /* Teal */
--color-brand-accent: oklch(75% 0.18 120);     /* Green */

/* Neutral Palette (11 levels) */
--color-neutral-0: oklch(100% 0 0);   /* Pure white */
--color-neutral-100: oklch(98% 0 0);
--color-neutral-500: oklch(60% 0 0);  /* Mid gray */
--color-neutral-1000: oklch(0% 0 0);  /* Pure black */

/* Semantic Colors */
--color-surface-base: var(--color-neutral-0);     /* Adaptive */
--color-text-primary: var(--color-neutral-1000);  /* High contrast */
```

### Spacing System

```css
/* Fluid Responsive Spacing with clamp() */
--space-3xs: clamp(0.25rem, 0.2rem + 0.25vw, 0.375rem);
--space-xs: clamp(0.75rem, 0.7rem + 0.25vw, 0.875rem);
--space-sm: clamp(1rem, 0.9rem + 0.5vw, 1.25rem);
--space-md: clamp(1.5rem, 1.35rem + 0.75vw, 1.875rem);
--space-lg: clamp(2rem, 1.8rem + 1vw, 2.5rem);
--space-xl: clamp(3rem, 2.7rem + 1.5vw, 3.75rem);
--space-2xl: clamp(4rem, 3.6rem + 2vw, 5rem);
--space-3xl: clamp(6rem, 5.4rem + 3vw, 7.5rem);
```

### Typography

```css
/* Font Sizes (Fluid) */
--font-size-sm: clamp(0.875rem, 0.8rem + 0.35vw, 1rem);
--font-size-base: clamp(1rem, 0.9rem + 0.5vw, 1.125rem);
--font-size-xl: clamp(1.25rem, 1.1rem + 0.75vw, 1.5rem);
--font-size-3xl: clamp(1.875rem, 1.25vw + 1.5rem, 2.5rem);
--font-size-6xl: clamp(3.75rem, 2.5vw + 3rem, 5rem);
--font-size-display-1: clamp(8rem, 12vw + 2rem, 18rem);

/* Font Weights */
--font-weight-light: 300;
--font-weight-normal: 400;
--font-weight-medium: 500;
--font-weight-semibold: 600;
--font-weight-bold: 700;
```

### Layout Utilities

```css
/* Containers */
.container          /* Max-width container with gutters */
.container--xl      /* Extra large */
.container--full    /* Full width */

/* Grid */
.grid               /* CSS Grid */
.grid--2            /* 2 columns */
.grid--3            /* 3 columns */
.grid--4            /* 4 columns */
.grid--auto         /* Auto-fit responsive */

/* Flex */
.flex               /* Flexbox */
.flex-col           /* Column direction */
.items-center       /* Align center */
.justify-between    /* Space between */

/* Spacing */
.gap-sm             /* Gap between items */
.gap-lg
.section            /* Section padding */
.section--lg        /* Large section padding */

/* Text */
.text-center        /* Center text */
.display-1          /* Display heading */
.display-2
```

---

## Best Practices

### 1. Always Use Components First

**❌ Don't:**
```blade
<section class="my-custom-hero">
  <!-- Custom HTML -->
</section>
<style>
  .my-custom-hero { /* Custom CSS */ }
</style>
<script>
  // Custom JS
</script>
```

**✅ Do:**
```blade
<x-parallax-hero
  title="My Title"
  background="hero.jpg"
/>
```

### 2. Leverage Design Tokens

**❌ Don't:**
```css
.my-element {
  color: #333;
  margin-bottom: 32px;
  font-size: 24px;
}
```

**✅ Do:**
```css
.my-element {
  color: var(--color-text-primary);
  margin-block-end: var(--space-lg);
  font-size: var(--font-size-3xl);
}
```

### 3. Use GSAP Utilities Instead of Custom JS

**❌ Don't:**
```javascript
const element = document.querySelector('.element')
element.addEventListener('scroll', () => {
  // Custom parallax code
})
```

**✅ Do:**
```javascript
// GSAPUtils is globally available via window.GSAPUtils
window.GSAPUtils.parallax('.element', 0.5)
```

### 4. Compose Complex Sections

**✅ Do:**
```blade
<x-parallax-section background="bg.jpg">
  <div class="container section">
    <h2 class="display-2" data-animate>Title</h2>

    <div class="grid grid--3 gap-lg">
      @foreach($items as $item)
        <x-card>
          <h3>{{ $item->title }}</h3>
          <p>{{ $item->description }}</p>
        </x-card>
      @endforeach
    </div>

    <x-button variant="primary" href="/cta">
      Call to Action
    </x-button>
  </div>
</x-parallax-section>
```

### 5. Accessibility is Built-In

All components include:
- ARIA labels
- Focus states
- Keyboard navigation
- Reduced motion support
- High contrast colors (9:1 WCAG)

---

## Summary: Your Development Workflow

1. **Start with a blank file**
2. **Choose pre-built components** (`<x-parallax-hero>`, `<x-social-icons>`, etc.)
3. **Apply design tokens** (spacing, colors, typography via CSS variables)
4. **Add GSAP animations** (one-line utilities from `GSAPUtils`)
5. **Compose complex sections** (combine components)
6. **Ship fast** (no custom CSS/JS needed!)

---

## Need More Components?

Request or contribute additional components following these patterns:

1. Create Blade component in `resources/views/components/`
2. Create CSS in `resources/css/components/`
3. Import CSS in `resources/css/app.css`
4. Add GSAP utilities if needed in `resources/js/libraries/utilities.js`
5. Document usage in this guide

---

**Happy Building!** 🚀

For more information, visit the [Alpacode Studio website](https://alpacode.com).
