{{--
  Hero Section - Premium First Impression

  A stunning, full-viewport hero section with:
  - Animated gradient background
  - Staggered content animations
  - Trust indicators
  - Scroll indicator
  - Floating shapes (optional)
--}}

<section class="hero" role="banner" aria-label="Hero principale">
  {{-- Floating decorative shapes --}}
  <div class="hero__shape hero__shape--1" aria-hidden="true"></div>
  <div class="hero__shape hero__shape--2" aria-hidden="true"></div>
  <div class="hero__shape hero__shape--3" aria-hidden="true"></div>

  {{-- Hero Content --}}
  <div class="hero__content">
    {{-- Eyebrow Text --}}
    <p class="hero__eyebrow">Web Development • 2025</p>

    {{-- Hero Headline --}}
    <h1 class="hero__title">
      Nel 2025, lavorare online senza un sito web è come avere un negozio senza insegna
    </h1>

    {{-- Hero Subheadline --}}
    <p class="hero__subtitle">
      Creiamo siti web per freelance e creator. Chiari nei prezzi, professionali nei risultati.
    </p>

    {{-- CTA Buttons --}}
    <div class="hero__cta">
      <a href="/contact" class="button button--primary button--lg">
        Inizia il tuo progetto
      </a>
      <a href="/pricing" class="button button--secondary button--lg">
        Vedi i prezzi
      </a>
    </div>

    {{-- Trust Indicators --}}
    <div class="hero__trust">
      <span class="hero__trust-item">
        <svg width="16" height="16" viewBox="0 0 16 16" fill="none" aria-hidden="true">
          <path d="M13.5 4L6 11.5L2.5 8" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
        Preventivo gratuito
      </span>
      <span aria-hidden="true">•</span>
      <span class="hero__trust-item">
        <svg width="16" height="16" viewBox="0 0 16 16" fill="none" aria-hidden="true">
          <path d="M13.5 4L6 11.5L2.5 8" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
        Prezzi trasparenti
      </span>
      <span aria-hidden="true">•</span>
      <span class="hero__trust-item">
        <svg width="16" height="16" viewBox="0 0 16 16" fill="none" aria-hidden="true">
          <path d="M13.5 4L6 11.5L2.5 8" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
        Supporto continuo
      </span>
    </div>
  </div>

  {{-- Scroll Indicator --}}
  <div class="hero__scroll-indicator" aria-hidden="true">
    <svg class="scroll-arrow" viewBox="0 0 24 24" aria-hidden="true">
      <path d="M12 5v14m0 0l-7-7m7 7l7-7"/>
    </svg>
  </div>
</section>
