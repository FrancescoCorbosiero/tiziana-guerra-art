{{--
  Final CTA Section - Conversion-Focused

  Powerful call-to-action with:
  - Animated gradient background
  - Clear headline and subheadline
  - Prominent CTA button with pulse effect
  - Trust indicators
--}}

<section class="final-cta" aria-label="Call to action finale">
  <div class="final-cta__container" data-animate>

    {{-- Headline --}}
    <h2 class="final-cta__headline">
      Pronto a iniziare il tuo progetto?
    </h2>

    {{-- Subheadline --}}
    <p class="final-cta__subheadline">
      Parliamo del tuo sito. Prima consulenza gratuita, preventivo chiaro, zero vincoli.
    </p>

    {{-- CTA Button --}}
    <div class="final-cta__button">
      <a href="/contact" class="button button--lg">
        Inizia Ora — Preventivo Gratuito
      </a>
    </div>

    {{-- Trust Indicators --}}
    <div class="final-cta__trust">
      <span class="final-cta__trust-item">
        <svg width="16" height="16" viewBox="0 0 16 16" fill="none" aria-hidden="true">
          <path d="M8 1l2 5h5l-4 3.5 1.5 5L8 11l-4.5 3.5L5 9 1 5.5h5L8 1z" fill="currentColor" stroke="currentColor" stroke-width="1"/>
        </svg>
        Risposta in 24 ore
      </span>
      <span aria-hidden="true">•</span>
      <span class="final-cta__trust-item">
        <svg width="16" height="16" viewBox="0 0 16 16" fill="none" aria-hidden="true">
          <path d="M8 1v14M3 6h10M3 10h10" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
        </svg>
        Consulenza gratuita
      </span>
      <span aria-hidden="true">•</span>
      <span class="final-cta__trust-item">
        <svg width="16" height="16" viewBox="0 0 16 16" fill="none" aria-hidden="true">
          <path d="M13.5 4L6 11.5L2.5 8" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
        Nessun impegno
      </span>
    </div>

  </div>
</section>

{{--
  Note: Scroll animation trigger handled by JavaScript
  See resources/js/core/animations.js for IntersectionObserver implementation
--}}
