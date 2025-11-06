{{--
  Pricing Preview Section - Package Cards

  Three pricing tiers:
  - Starter (€299)
  - Professional (€699) - Featured
  - Business (€1,499)
--}}

<section class="pricing-preview" aria-labelledby="pricing-title">
  {{-- Section Header --}}
  <div class="pricing-preview__header">
    <h2 class="pricing-preview__title" id="pricing-title">
      I Nostri Pacchetti
    </h2>
    <p class="pricing-preview__subtitle">
      Soluzioni per ogni esigenza
    </p>
  </div>

  {{-- Pricing Cards Grid --}}
  <div class="pricing-preview__grid">

    {{-- Card 1: Starter --}}
    <article class="pricing-card" data-animate>
      <span class="pricing-card__badge">Per Chi Inizia</span>
      <div class="pricing-card__price">Da €299</div>
      <h3 class="pricing-card__title">Starter</h3>
      <p class="pricing-card__description">
        Sito one-page professionale, perfetto per freelance
      </p>
      <ul class="pricing-card__features">
        <li class="pricing-card__feature">
          <svg class="pricing-card__feature-icon" viewBox="0 0 20 20" aria-hidden="true">
            <path d="M16.5 5L7.5 14 3.5 10" stroke-linecap="round" stroke-linejoin="round"/>
          </svg>
          <span>Dominio incluso (1 anno)</span>
        </li>
        <li class="pricing-card__feature">
          <svg class="pricing-card__feature-icon" viewBox="0 0 20 20" aria-hidden="true">
            <path d="M16.5 5L7.5 14 3.5 10" stroke-linecap="round" stroke-linejoin="round"/>
          </svg>
          <span>Hosting incluso (1 anno)</span>
        </li>
        <li class="pricing-card__feature">
          <svg class="pricing-card__feature-icon" viewBox="0 0 20 20" aria-hidden="true">
            <path d="M16.5 5L7.5 14 3.5 10" stroke-linecap="round" stroke-linejoin="round"/>
          </svg>
          <span>Email professionale</span>
        </li>
        <li class="pricing-card__feature">
          <svg class="pricing-card__feature-icon" viewBox="0 0 20 20" aria-hidden="true">
            <path d="M16.5 5L7.5 14 3.5 10" stroke-linecap="round" stroke-linejoin="round"/>
          </svg>
          <span>Design responsive</span>
        </li>
        <li class="pricing-card__feature">
          <svg class="pricing-card__feature-icon" viewBox="0 0 20 20" aria-hidden="true">
            <path d="M16.5 5L7.5 14 3.5 10" stroke-linecap="round" stroke-linejoin="round"/>
          </svg>
          <span>SEO base</span>
        </li>
      </ul>
      <div class="pricing-card__cta">
        <a href="/contact?plan=starter" class="button button--secondary" style="width: 100%; justify-content: center;">
          Inizia ora
        </a>
      </div>
    </article>

    {{-- Card 2: Professional (Featured) --}}
    <article class="pricing-card pricing-card--featured" data-animate>
      <span class="pricing-card__badge">Più Popolare</span>
      <div class="pricing-card__price">Da €699</div>
      <h3 class="pricing-card__title">Professional</h3>
      <p class="pricing-card__description">
        Sito multi-pagina con blog integrato
      </p>
      <ul class="pricing-card__features">
        <li class="pricing-card__feature">
          <svg class="pricing-card__feature-icon" viewBox="0 0 20 20" aria-hidden="true">
            <path d="M16.5 5L7.5 14 3.5 10" stroke-linecap="round" stroke-linejoin="round"/>
          </svg>
          <span>Tutto da Starter</span>
        </li>
        <li class="pricing-card__feature">
          <svg class="pricing-card__feature-icon" viewBox="0 0 20 20" aria-hidden="true">
            <path d="M16.5 5L7.5 14 3.5 10" stroke-linecap="round" stroke-linejoin="round"/>
          </svg>
          <span>Blog/Portfolio</span>
        </li>
        <li class="pricing-card__feature">
          <svg class="pricing-card__feature-icon" viewBox="0 0 20 20" aria-hidden="true">
            <path d="M16.5 5L7.5 14 3.5 10" stroke-linecap="round" stroke-linejoin="round"/>
          </svg>
          <span>Form contatti avanzato</span>
        </li>
        <li class="pricing-card__feature">
          <svg class="pricing-card__feature-icon" viewBox="0 0 20 20" aria-hidden="true">
            <path d="M16.5 5L7.5 14 3.5 10" stroke-linecap="round" stroke-linejoin="round"/>
          </svg>
          <span>Integrazioni social</span>
        </li>
        <li class="pricing-card__feature">
          <svg class="pricing-card__feature-icon" viewBox="0 0 20 20" aria-hidden="true">
            <path d="M16.5 5L7.5 14 3.5 10" stroke-linecap="round" stroke-linejoin="round"/>
          </svg>
          <span>Analytics incluse</span>
        </li>
      </ul>
      <div class="pricing-card__cta">
        <a href="/contact?plan=professional" class="button button--primary" style="width: 100%; justify-content: center;">
          Scegli Professional
        </a>
      </div>
    </article>

    {{-- Card 3: Business --}}
    <article class="pricing-card" data-animate>
      <span class="pricing-card__badge">Per Attività</span>
      <div class="pricing-card__price">Da €1,499</div>
      <h3 class="pricing-card__title">Business</h3>
      <p class="pricing-card__description">
        Sito completo con funzionalità avanzate
      </p>
      <ul class="pricing-card__features">
        <li class="pricing-card__feature">
          <svg class="pricing-card__feature-icon" viewBox="0 0 20 20" aria-hidden="true">
            <path d="M16.5 5L7.5 14 3.5 10" stroke-linecap="round" stroke-linejoin="round"/>
          </svg>
          <span>Tutto da Professional</span>
        </li>
        <li class="pricing-card__feature">
          <svg class="pricing-card__feature-icon" viewBox="0 0 20 20" aria-hidden="true">
            <path d="M16.5 5L7.5 14 3.5 10" stroke-linecap="round" stroke-linejoin="round"/>
          </svg>
          <span>Area riservata clienti</span>
        </li>
        <li class="pricing-card__feature">
          <svg class="pricing-card__feature-icon" viewBox="0 0 20 20" aria-hidden="true">
            <path d="M16.5 5L7.5 14 3.5 10" stroke-linecap="round" stroke-linejoin="round"/>
          </svg>
          <span>Prenotazioni online</span>
        </li>
        <li class="pricing-card__feature">
          <svg class="pricing-card__feature-icon" viewBox="0 0 20 20" aria-hidden="true">
            <path d="M16.5 5L7.5 14 3.5 10" stroke-linecap="round" stroke-linejoin="round"/>
          </svg>
          <span>Newsletter integrata</span>
        </li>
        <li class="pricing-card__feature">
          <svg class="pricing-card__feature-icon" viewBox="0 0 20 20" aria-hidden="true">
            <path d="M16.5 5L7.5 14 3.5 10" stroke-linecap="round" stroke-linejoin="round"/>
          </svg>
          <span>Supporto prioritario</span>
        </li>
      </ul>
      <div class="pricing-card__cta">
        <a href="/contact?plan=business" class="button button--secondary" style="width: 100%; justify-content: center;">
          Contattaci
        </a>
      </div>
    </article>

  </div>
</section>

{{--
  Note: Scroll animation trigger handled by JavaScript
  See resources/js/core/animations.js for IntersectionObserver implementation
--}}
