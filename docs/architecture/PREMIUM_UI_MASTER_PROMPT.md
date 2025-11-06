# 🎨 PREMIUM UI IMPLEMENTATION - Claude Code Master Prompt
## Shockingly Amazing Wix/Webflow-Inspired Interface

---

## 🎯 MASTER CONTEXT PROMPT FOR CLAUDE CODE

```
MISSION: Transform the Alpacode Studio theme into a visually stunning, premium UI that rivals Wix Studio and Webflow's modern aesthetic.

CURRENT STATE:
✅ Foundation complete (CSS4 tokens, typography, layout)
✅ Services layer implemented (DesignSystem, Performance, SEO, etc.)
✅ Core templates created (app.blade.php, index, single, page)
✅ Components structure ready (_button.css, _card.css, _modal.css)
✅ Sections structure ready (_hero.css, _features.css, _cta.css)

YOUR MISSION:
Create a breathtaking, production-ready UI for the Alpacode Studio homepage that demonstrates:
1. Minimal elegant design (generous white space, clean hierarchy)
2. Fluid, responsive typography (perfect scale across all devices)
3. High contrast accessibility (9:1 minimum, WCAG AAA)
4. Always fresh feel (subtle animations, micro-interactions)
5. Premium quality (looks expensive, feels professional)

DESIGN INSPIRATION:
- Wix Studio's clean, modern interface
- Webflow's sophisticated layouts
- Vercel's minimalist approach
- Linear's smooth interactions
- Stripe's clarity and hierarchy

REFERENCE DOCUMENTATION:
- docs/architecture/02_DESIGN_SYSTEM_MANIFESTO.md (complete design system)
- docs/architecture/manifest.md (brand positioning, copy)
- docs/architecture/marketing.md (messaging, tone)

IMPLEMENTATION PHASES:
I'll guide you through creating these sections in order:
1. Hero Section (stunning first impression)
2. Value Proposition (why Alpacode)
3. Features Grid (what we do)
4. Social Proof (testimonials/stats)
5. Pricing Preview (clear offerings)
6. Final CTA (conversion focused)
7. Premium Footer (comprehensive)

Ready to create something amazing?
```

---

## 🚀 PHASE 1: HERO SECTION (Stunning First Impression)

### PROMPT UI-1.1: Hero Section - Main Implementation

```
Create a breathtaking hero section for the Alpacode Studio homepage.

DESIGN REQUIREMENTS:

**Layout:**
- Full viewport height (min-height: 100vh)
- Centered content (both vertical and horizontal)
- Max-width container for readability
- Background: Subtle gradient mesh (modern, not overpowering)

**Content Structure:**
1. Eyebrow text (small, uppercase, branded color)
   - Text: "Web Development • 2025"
2. Hero headline (largest font, bold, perfect contrast)
   - Text: "Nel 2025, lavorare online senza un sito web è come avere un negozio senza insegna"
   - Alternative: "Il tuo talento merita un sito professionale. Noi te lo creiamo."
3. Hero subheadline (large, readable, secondary color)
   - Text: "Creiamo siti web per freelance e creator. Chiari nei prezzi, professionali nei risultati."
4. CTA buttons (horizontal, side-by-side)
   - Primary: "Inizia il tuo progetto" → /contact
   - Secondary: "Vedi i prezzi" → /pricing
5. Trust indicators (below CTAs)
   - Small text: "✓ Preventivo gratuito  ✓ Prezzi trasparenti  ✓ Supporto continuo"

**Visual Enhancements:**
- Animated gradient background (subtle, slow movement)
- Floating geometric shapes (optional, very subtle)
- Fade-in animation for content (stagger children)
- Scroll indicator at bottom (animated arrow)

**Technical Implementation:**
- File: resources/views/sections/hero.blade.php
- CSS: resources/css/sections/_hero.css
- Use design tokens from foundation
- Mobile-first responsive
- Accessible (proper heading hierarchy, ARIA)
- Performance optimized (no heavy images)

**CSS Animation Requirements:**
- Fade in content: 800ms delay
- Stagger children: 100ms between elements
- Subtle floating animation on shapes
- Smooth transitions on hover

COPY TO USE (from marketing.md):
- Pull exact copy from docs/architecture/marketing.md
- Use Italian as primary language
- Professional but approachable tone

Create the Blade component and CSS now. Make it stunning.
```

### PROMPT UI-1.2: Hero Visual Effects

```
Enhance the hero section with premium visual effects.

REQUIREMENTS:

**Animated Gradient Background:**
```css
.hero {
  background: 
    linear-gradient(
      135deg,
      color-mix(in oklch, var(--color-brand-primary), transparent 95%) 0%,
      color-mix(in oklch, var(--color-brand-secondary), transparent 97%) 50%,
      color-mix(in oklch, var(--color-brand-accent), transparent 95%) 100%
    );
  animation: gradient-shift 15s ease infinite;
  background-size: 200% 200%;
}

@keyframes gradient-shift {
  0%, 100% { background-position: 0% 50%; }
  50% { background-position: 100% 50%; }
}
```

**Floating Shapes (Optional):**
- 2-3 abstract shapes (circles, rounded rectangles)
- Very subtle, low opacity
- Slow floating animation
- Position: absolute, behind content
- CSS-only (no images)

**Scroll Indicator:**
```html
<div class="hero__scroll-indicator">
  <svg class="scroll-arrow" viewBox="0 0 24 24">
    <path d="M12 5v14m0 0l-7-7m7 7l7-7"/>
  </svg>
  <span class="sr-only">Scroll to content</span>
</div>
```

**Animation CSS:**
```css
@keyframes float {
  0%, 100% { transform: translateY(0px); }
  50% { transform: translateY(-20px); }
}

@keyframes bounce-down {
  0%, 100% { transform: translateY(0); }
  50% { transform: translateY(8px); }
}

.scroll-arrow {
  animation: bounce-down 2s ease-in-out infinite;
}
```

Implement these visual enhancements to make the hero unforgettable.
```

---

## 🎨 PHASE 2: VALUE PROPOSITION

### PROMPT UI-2.1: "Perché Alpacode" Section

```
Create a compelling value proposition section that explains why clients should choose Alpacode.

DESIGN REQUIREMENTS:

**Layout:**
- Full-width section with padding (var(--space-3xl) top/bottom)
- Centered content, max-width container
- Background: Subtle contrast from hero (light gray or white)

**Content Structure:**
1. Section title (centered, large)
   - Text: "Perché Scegliere Alpacode"
2. Four value props in grid (2x2 on desktop, 1 column on mobile)
   - Each with icon, title, description
3. Icons: Simple, line-based, branded color
4. Animated on scroll (fade + slide up)

**Four Value Props (from manifest.md):**

1. **Prezzi Onesti**
   - Icon: 💰 (or Price tag icon)
   - Title: "Prezzi Onesti"
   - Description: "Sai quanto spendi prima di iniziare. Niente sorprese, niente costi nascosti."

2. **Team Giovane**
   - Icon: 🚀 (or Rocket icon)
   - Title: "Team Giovane"
   - Description: "Capiamo le esigenze digitali di oggi. Cresciuti nel digitale, esperienza vera."

3. **Niente Vincoli**
   - Icon: 🔓 (or Unlock icon)
   - Title: "Niente Vincoli"
   - Description: "Il sito è tuo, punto. Gestiscilo come vuoi, quando vuoi."

4. **Supporto Reale**
   - Icon: 💬 (or Chat icon)
   - Title: "Supporto Reale"
   - Description: "Rispondiamo davvero alle tue domande. Non ti lasciamo solo dopo la consegna."

**Visual Treatment:**
- Cards with subtle shadow
- Hover effect: lift + shadow increase
- Icons in circular backgrounds (brand gradient)
- Typography: Title bold, description regular
- Spacing: Generous padding inside cards

**Technical:**
- File: resources/views/sections/value-proposition.blade.php
- CSS: resources/css/sections/_value-proposition.css
- Use Intersection Observer for scroll animations
- Accessible (proper semantics, focus states)

Create this section with premium quality.
```

---

## 🌟 PHASE 3: FEATURES GRID

### PROMPT UI-3.1: "Cosa Facciamo" Features Section

```
Create a stunning features grid showcasing Alpacode's services.

DESIGN REQUIREMENTS:

**Layout:**
- Full-width section, alternating background
- Three-column grid on desktop, single column on mobile
- Each feature as a card with image placeholder + content

**Content Structure (from manifest.md):**

1. **Siti Web Professionali**
   - Visual: Abstract geometric shape or mockup placeholder
   - Title: "Siti Web Professionali"
   - Description: "Portfolio personali, landing page, siti vetrina. Design moderno, navigazione intuitiva, ottimizzati per tutti i dispositivi."
   - Link: "Scopri di più →"

2. **Strumenti per Creator**
   - Visual: Dashboard/tool mockup placeholder
   - Title: "Strumenti per Creator"
   - Description: "Link in bio personalizzati, media kit digitali, dashboard analytics, portfolio che si aggiornano automaticamente."
   - Link: "Vedi esempi →"

3. **Soluzioni per Piccole Attività**
   - Visual: E-commerce/booking placeholder
   - Title: "Soluzioni per Attività"
   - Description: "Prenotazioni online, e-commerce semplici, sistemi di gestione clienti, automazioni che fanno risparmiare tempo."
   - Link: "Esplora soluzioni →"

**Visual Treatment:**
- Cards with prominent visual area (40% height)
- Visual: Use CSS gradients as placeholders (no images yet)
- Gradient should be unique per card (different brand color mix)
- Content area: Generous padding, clear hierarchy
- Hover: Lift card, show subtle glow
- Links: Inline, with arrow icon, hover underline

**Advanced CSS:**
- Use container queries for card responsiveness
- Each card is self-contained, independent layout
- Smooth transitions on all interactive elements

**Example Card Structure:**
```html
<article class="feature-card" style="container-type: inline-size;">
  <div class="feature-card__visual">
    <!-- CSS gradient placeholder -->
  </div>
  <div class="feature-card__content">
    <h3 class="feature-card__title">Siti Web Professionali</h3>
    <p class="feature-card__description">...</p>
    <a href="#" class="feature-card__link">
      Scopri di più
      <svg class="icon-arrow">→</svg>
    </a>
  </div>
</article>
```

**Animation:**
- Stagger fade-in on scroll
- Each card enters 100ms after previous
- Hover adds depth (transform + shadow)

Create this features grid with modern card design.
```

---

## 💬 PHASE 4: SOCIAL PROOF

### PROMPT UI-4.1: Testimonials + Stats Section

```
Create a social proof section combining testimonials with key statistics.

DESIGN REQUIREMENTS:

**Layout:**
- Split section: Stats on left, Testimonial on right (desktop)
- Stack on mobile: Stats top, Testimonial bottom
- Background: Subtle brand gradient (very light)

**Stats Component (Left Side):**
- Three key metrics in vertical stack
- Large number + label below

**Stats Content:**
1. **"50+"**
   - Label: "Progetti completati"
2. **"95%"**
   - Label: "Clienti soddisfatti"
3. **"<1 settimana"**
   - Label: "Tempo medio consegna"

**Stats Visual Treatment:**
- Numbers: Huge (var(--font-size-6xl)), bold, brand color
- Labels: Small, uppercase, secondary color
- Animated counting on scroll (optional enhancement)
- Vertical separator lines between stats

**Testimonial Component (Right Side):**
- Single featured testimonial
- Quote in large, readable font
- Author info with avatar placeholder

**Testimonial Content (from marketing.md):**
- Quote: "Finalmente qualcuno che parla chiaro. Prezzi onesti, lavoro pulito."
- Author: "Mario, Fotografo"
- Avatar: Colored circle with initials "M"

**Testimonial Visual Treatment:**
- Large quotation marks (decorative)
- Quote text: var(--font-size-xl), relaxed line-height
- Author: Flex layout (avatar + name/role)
- Avatar: 48px circle, gradient background, white text
- Subtle card background, rounded corners

**Technical:**
- File: resources/views/sections/social-proof.blade.php
- CSS: resources/css/sections/_social-proof.css
- Responsive breakpoint: Stack at <768px
- Accessible (proper semantic HTML)

Create this social proof section to build trust.
```

---

## 💰 PHASE 5: PRICING PREVIEW

### PROMPT UI-5.1: Pricing Cards Section

```
Create an elegant pricing preview showcasing Alpacode's packages.

DESIGN REQUIREMENTS:

**Layout:**
- Three pricing cards in horizontal row
- Equal width, centered
- Single column stack on mobile
- Section padding: var(--space-3xl) top/bottom

**Section Header:**
- Centered title: "I Nostri Pacchetti"
- Subtitle: "Soluzioni per ogni esigenza"

**Pricing Cards (from manifest.md):**

**Card 1: Starter**
- Badge: "Per Chi Inizia"
- Price: "Da €299"
- Description: "Sito one-page professionale, perfetto per freelance"
- Features (checkmark list):
  - ✓ Dominio incluso (1 anno)
  - ✓ Hosting incluso (1 anno)
  - ✓ Email professionale
  - ✓ Design responsive
  - ✓ SEO base
- CTA: "Inizia ora" (Secondary button)

**Card 2: Professional** (FEATURED)
- Badge: "Più Popolare" (highlighted)
- Price: "Da €699"
- Description: "Sito multi-pagina con blog integrato"
- Features:
  - ✓ Tutto da Starter
  - ✓ Blog/Portfolio
  - ✓ Form contatti avanzato
  - ✓ Integrazioni social
  - ✓ Analytics incluse
- CTA: "Scegli Professional" (Primary button)
- Special styling: Elevated, border accent, subtle glow

**Card 3: Business**
- Badge: "Per Attività"
- Price: "Da €1,499"
- Description: "Sito completo con funzionalità avanzate"
- Features:
  - ✓ Tutto da Professional
  - ✓ Area riservata clienti
  - ✓ Prenotazioni online
  - ✓ Newsletter integrata
  - ✓ Supporto prioritario
- CTA: "Contattaci" (Secondary button)

**Visual Treatment:**
- Cards: White background, shadow, rounded corners (var(--radius-xl))
- Featured card: Slightly larger (transform: scale(1.05)), primary border
- Badges: Small, rounded pill, positioned top-right or top-center
- Price: Large, bold, brand color
- Features: Checkmark + text, generous spacing
- Hover: Lift + shadow increase

**Typography:**
- Price: var(--font-size-4xl)
- Title: var(--font-size-2xl), bold
- Description: var(--font-size-base), secondary color
- Features: var(--font-size-sm)

**Technical:**
- File: resources/views/sections/pricing-preview.blade.php
- CSS: resources/css/sections/_pricing-preview.css
- Use CSS Grid for card layout
- Featured card uses :nth-child(2) for special styling
- Fully responsive, mobile-optimized

Create premium pricing cards that convert.
```

---

## 🎯 PHASE 6: FINAL CTA

### PROMPT UI-6.1: Conversion-Focused CTA Section

```
Create a powerful, conversion-focused call-to-action section.

DESIGN REQUIREMENTS:

**Layout:**
- Full-width section with brand gradient background
- Centered content, max-width: var(--container-md)
- Generous padding: var(--space-3xl)
- High contrast (dark background, white text)

**Content Structure:**
1. Headline (large, bold, white)
   - Text: "Pronto a iniziare il tuo progetto?"
2. Subheadline (large, medium weight, subtle color)
   - Text: "Parliamo del tuo sito. Prima consulenza gratuita, preventivo chiaro, zero vincoli."
3. CTA Button (prominent)
   - Text: "Inizia Ora — Preventivo Gratuito"
   - Style: Large, high contrast (white bg, dark text)
   - Hover: Slight lift, shadow
4. Trust line (small text below)
   - Text: "⚡ Risposta in 24 ore  •  💬 Consulenza gratuita  •  ✓ Nessun impegno"

**Visual Treatment:**
- Background: Animated gradient (brand colors, slow shift)
- Text: All white for maximum contrast
- Button: White background, dark text, rounded
- Button hover: Transform scale(1.03), box-shadow increase
- Icons in trust line: Inline, subtle

**Animation:**
- Gradient background animation (similar to hero)
- Button pulse effect (subtle, infinite)
- Fade in on scroll

**Technical:**
- File: resources/views/sections/final-cta.blade.php
- CSS: resources/css/sections/_final-cta.css
- Accessible (WCAG AAA contrast)
- Mobile-optimized (stack content on small screens)

Create a CTA that's impossible to ignore.
```

---

## 🏢 PHASE 7: PREMIUM FOOTER

### PROMPT UI-7.1: Comprehensive Footer Implementation

```
Create a comprehensive, professional footer with all essential information.

DESIGN REQUIREMENTS:

**Layout:**
- Four-column grid on desktop, stack on mobile
- Background: Dark (var(--color-neutral-900))
- Text: Light (var(--color-neutral-200))
- Padding: var(--space-2xl) top/bottom

**Four Columns:**

**Column 1: Brand**
- Logo/brand name (larger text)
- Tagline: "Facciamo siti web. Bene, semplice."
- Social media icons (4-5 icons, horizontal)
  - GitHub, Twitter/X, LinkedIn, Instagram
  - Icon style: Simple, line-based, hover effect

**Column 2: Servizi**
- Title: "Servizi"
- Links:
  - Siti Web Professionali
  - Strumenti per Creator
  - Soluzioni per Attività
  - Consulenza Personalizzata

**Column 3: Risorse**
- Title: "Risorse"
- Links:
  - Portfolio
  - Blog
  - Domande Frequenti
  - Guida ai Prezzi

**Column 4: Contatti**
- Title: "Contatti"
- Email: hello@alpacode.studio
- Location: Monza Brianza, Italia
- Form link: "Invia un messaggio →"

**Footer Bottom:**
- Full-width bar below columns
- Left: Copyright "© 2025 Alpacode Studio"
- Right: Legal links (Privacy, Terms, Cookies)

**Visual Treatment:**
- Links: Light color, hover brightens + underline
- Social icons: Circular background, hover filled
- Columns: Equal width, balanced spacing
- Bottom bar: Border top, smaller text

**Technical:**
- File: resources/views/sections/footer.blade.php
- CSS: resources/css/sections/_footer.css
- Semantic HTML5 <footer> element
- Accessible link states
- Mobile: Stack columns, maintain hierarchy

Create a footer that's both functional and beautiful.
```

---

## ✨ PHASE 8: MICRO-INTERACTIONS & POLISH

### PROMPT UI-8.1: Add Premium Micro-Interactions

```
Add subtle micro-interactions throughout the site to enhance the premium feel.

REQUIREMENTS:

**Button Interactions:**
```css
.button {
  transition: 
    transform var(--duration-base) var(--easing-out),
    box-shadow var(--duration-base) var(--easing-out),
    background var(--duration-base) var(--easing-out);
}

.button:hover {
  transform: translateY(-2px);
  box-shadow: var(--shadow-lg);
}

.button:active {
  transform: translateY(0) scale(0.98);
  transition-duration: var(--duration-fast);
}
```

**Link Interactions:**
```css
a:not(.button) {
  position: relative;
  text-decoration: none;
  color: var(--color-brand-primary);
}

a:not(.button)::after {
  content: '';
  position: absolute;
  bottom: -2px;
  left: 0;
  width: 0;
  height: 2px;
  background: currentColor;
  transition: width var(--duration-base) var(--easing-out);
}

a:not(.button):hover::after {
  width: 100%;
}
```

**Card Hover Effects:**
```css
.card, .feature-card, .pricing-card {
  transition: 
    transform var(--duration-base) var(--easing-out),
    box-shadow var(--duration-base) var(--easing-out);
}

.card:hover {
  transform: translateY(-4px);
  box-shadow: var(--shadow-xl);
}
```

**Scroll-Triggered Animations:**
```javascript
// In resources/js/core/animations.js
const observerOptions = {
  threshold: 0.1,
  rootMargin: '0px 0px -50px 0px'
}

const observer = new IntersectionObserver((entries) => {
  entries.forEach(entry => {
    if (entry.isIntersecting) {
      entry.target.classList.add('animate-in')
      observer.unobserve(entry.target)
    }
  })
}, observerOptions)

document.querySelectorAll('[data-animate]').forEach(el => {
  observer.observe(el)
})
```

**CSS Animation Classes:**
```css
[data-animate] {
  opacity: 0;
  transform: translateY(24px);
  transition: 
    opacity var(--duration-slow) var(--easing-out),
    transform var(--duration-slow) var(--easing-out);
}

[data-animate].animate-in {
  opacity: 1;
  transform: translateY(0);
}

/* Stagger children */
[data-animate-stagger] > * {
  opacity: 0;
  transform: translateY(24px);
  transition: 
    opacity var(--duration-slow) var(--easing-out),
    transform var(--duration-slow) var(--easing-out);
}

[data-animate-stagger].animate-in > * {
  opacity: 1;
  transform: translateY(0);
}

[data-animate-stagger].animate-in > *:nth-child(1) { transition-delay: 0ms; }
[data-animate-stagger].animate-in > *:nth-child(2) { transition-delay: 100ms; }
[data-animate-stagger].animate-in > *:nth-child(3) { transition-delay: 200ms; }
[data-animate-stagger].animate-in > *:nth-child(4) { transition-delay: 300ms; }
```

Implement these micro-interactions for a polished experience.
```

---

## 🎨 PHASE 9: HOMEPAGE ASSEMBLY

### PROMPT UI-9.1: Assemble Complete Homepage

```
Assemble all sections into a cohesive, stunning homepage.

REQUIREMENTS:

**File: resources/views/templates/front-page.blade.php**

```blade
@extends('layouts.app')

@section('content')
  {{-- Hero Section --}}
  @include('sections.hero')

  {{-- Value Proposition --}}
  @include('sections.value-proposition')

  {{-- Features Grid --}}
  @include('sections.features')

  {{-- Social Proof --}}
  @include('sections.social-proof')

  {{-- Pricing Preview --}}
  @include('sections.pricing-preview')

  {{-- Final CTA --}}
  @include('sections.final-cta')
@endsection
```

**Global Adjustments:**
1. Ensure consistent spacing between sections
2. Verify color flow (alternating backgrounds)
3. Check responsive behavior across all sections
4. Test dark mode compatibility (if implemented)
5. Validate accessibility (heading hierarchy, ARIA, contrast)

**Section Spacing Pattern:**
- Hero: Full viewport, no top/bottom padding
- Value Prop: var(--space-3xl) padding, light background
- Features: var(--space-3xl) padding, white background
- Social Proof: var(--space-3xl) padding, gradient background
- Pricing: var(--space-3xl) padding, light background
- Final CTA: var(--space-2xl) padding, dark gradient background

**Performance Optimization:**
1. Ensure critical CSS includes above-the-fold styles
2. Lazy load below-the-fold images (when added)
3. Defer non-critical JavaScript
4. Optimize animations (use transform/opacity only)

**Final Testing Checklist:**
- [ ] Desktop (1920px, 1440px, 1024px)
- [ ] Tablet (768px)
- [ ] Mobile (375px, 414px)
- [ ] Lighthouse score >95
- [ ] Accessibility (WAVE, axe)
- [ ] Cross-browser (Chrome, Firefox, Safari, Edge)

Assemble and test the complete homepage.
```

---

## 🚀 PHASE 10: REFINEMENT & POLISH

### PROMPT UI-10.1: Final Polish Pass

```
Perform a final polish pass to ensure premium quality throughout.

REFINEMENT CHECKLIST:

**Typography:**
- [ ] All headings use proper hierarchy (h1 → h6)
- [ ] Line heights are comfortable for reading
- [ ] Letter spacing enhances readability
- [ ] Font weights create clear emphasis
- [ ] All text has sufficient contrast

**Spacing:**
- [ ] Consistent vertical rhythm between sections
- [ ] Adequate padding inside components
- [ ] Comfortable margins around text
- [ ] Balanced negative space
- [ ] No elements feel cramped

**Colors:**
- [ ] Brand colors used consistently
- [ ] Backgrounds provide subtle contrast
- [ ] Interactive elements have clear states
- [ ] Dark mode tokens work (if implemented)
- [ ] All contrasts meet WCAG AAA

**Interactions:**
- [ ] All buttons have hover states
- [ ] Links have clear hover indication
- [ ] Cards respond to interaction
- [ ] Animations are smooth, not jarring
- [ ] Focus states are visible

**Responsive:**
- [ ] Layouts adapt gracefully
- [ ] Text remains readable at all sizes
- [ ] Touch targets are adequate on mobile
- [ ] No horizontal scroll
- [ ] Images/media scale properly

**Performance:**
- [ ] No layout shift (CLS <0.1)
- [ ] Fast paint times (FCP <1.5s)
- [ ] Smooth animations (60fps)
- [ ] Efficient CSS (no redundancy)
- [ ] Optimized critical path

**Accessibility:**
- [ ] Semantic HTML throughout
- [ ] ARIA labels where needed
- [ ] Keyboard navigation works
- [ ] Screen reader friendly
- [ ] Skip links functional

Make any necessary adjustments for perfection.
```

---

## 📊 SUCCESS METRICS

After completing all UI prompts, verify these metrics:

✅ **Visual Quality:**
- Looks like a $10k+ website
- Rivals Wix Studio / Webflow examples
- Clients say "wow" when they see it

✅ **Performance:**
- Lighthouse Desktop: 95+
- Lighthouse Mobile: 90+
- FCP: <1.5s
- LCP: <2.5s
- CLS: <0.1

✅ **Accessibility:**
- WCAG AAA compliance
- Keyboard navigable
- Screen reader friendly
- High contrast mode works

✅ **User Experience:**
- Clear hierarchy
- Easy to scan
- Obvious CTAs
- Trustworthy appearance
- Mobile-friendly

✅ **Brand Alignment:**
- Professional yet approachable
- Modern and fresh
- Confident without arrogance
- Clear value communication

---

## 💡 PRO TIPS FOR EXECUTION

**Tip 1: Work Section by Section**
Complete each section fully before moving to the next. Test thoroughly.

**Tip 2: Use Real Content**
Pull actual copy from marketing.md and manifest.md. Don't use Lorem Ipsum.

**Tip 3: Test Constantly**
After each section, test on multiple devices and browsers.

**Tip 4: Iterate on Feedback**
If something doesn't look right, refine it immediately.

**Tip 5: Reference Design System**
Always use tokens from 02_DESIGN_SYSTEM_MANIFESTO.md for consistency.

**Tip 6: Think in Components**
Build reusable patterns that can be used elsewhere.

**Tip 7: Mobile First**
Start with mobile layout, then enhance for desktop.

**Tip 8: Accessibility Always**
Don't save accessibility for last. Build it in from the start.

---

## 🎯 FINAL DELIVERABLE

When complete, you'll have:

✅ Stunning homepage with 7 premium sections
✅ Complete UI component library
✅ Fully responsive across all devices
✅ WCAG AAA accessible
✅ 95+ Lighthouse score
✅ Production-ready code
✅ Italian language content integrated
✅ Brand identity fully expressed
✅ Conversion-optimized layout
✅ Maintainable, documented codebase

**Estimated Timeline:**
- Phase 1-2 (Hero + Value): 2-3 hours
- Phase 3-4 (Features + Social): 2-3 hours
- Phase 5-6 (Pricing + CTA): 2 hours
- Phase 7-8 (Footer + Interactions): 2 hours
- Phase 9-10 (Assembly + Polish): 2 hours
**Total: ~10-13 hours of focused work**

---

**Ready to create something stunning? Let's start with PROMPT UI-1.1!** 🎨✨

---

**Version:** 1.0.0
**Created:** 2025-10-21
**Focus:** Premium UI Implementation
**Status:** Ready for Claude Code Execution ✅
