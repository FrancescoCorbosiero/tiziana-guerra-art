{{--
  Features Section - What We Do

  Three premium feature cards showcasing Alpacode's core services:
  - Siti Web Professionali
  - Strumenti per Creator
  - Soluzioni per Piccole Attività
--}}

<section class="features" aria-labelledby="features-title">
  {{-- Section Header --}}
  <div class="features__header">
    <h2 class="features__title" id="features-title">
      Cosa Facciamo
    </h2>
    <p class="features__subtitle">
      Soluzioni web moderne per ogni esigenza
    </p>
  </div>

  {{-- Features Grid --}}
  <div class="features__grid">

    {{-- Feature 1: Siti Web Professionali --}}
    <article class="feature-card" data-animate style="container-type: inline-size;">
      <div class="feature-card__visual" aria-hidden="true"></div>
      <div class="feature-card__content">
        <h3 class="feature-card__title">Siti Web Professionali</h3>
        <p class="feature-card__description">
          Portfolio personali, landing page, siti vetrina. Design moderno, navigazione intuitiva, ottimizzati per tutti i dispositivi.
        </p>
        <a href="#servizi-web" class="feature-card__link">
          Scopri di più
          <svg class="icon-arrow" viewBox="0 0 16 16" aria-hidden="true">
            <path d="M1 8h14m0 0L8 1m7 7-7 7"/>
          </svg>
        </a>
      </div>
    </article>

    {{-- Feature 2: Strumenti per Creator --}}
    <article class="feature-card" data-animate style="container-type: inline-size;">
      <div class="feature-card__visual" aria-hidden="true"></div>
      <div class="feature-card__content">
        <h3 class="feature-card__title">Strumenti per Creator</h3>
        <p class="feature-card__description">
          Link in bio personalizzati, media kit digitali, dashboard analytics, portfolio che si aggiornano automaticamente.
        </p>
        <a href="#strumenti-creator" class="feature-card__link">
          Vedi esempi
          <svg class="icon-arrow" viewBox="0 0 16 16" aria-hidden="true">
            <path d="M1 8h14m0 0L8 1m7 7-7 7"/>
          </svg>
        </a>
      </div>
    </article>

    {{-- Feature 3: Soluzioni per Piccole Attività --}}
    <article class="feature-card" data-animate style="container-type: inline-size;">
      <div class="feature-card__visual" aria-hidden="true"></div>
      <div class="feature-card__content">
        <h3 class="feature-card__title">Soluzioni per Attività</h3>
        <p class="feature-card__description">
          Prenotazioni online, e-commerce semplici, sistemi di gestione clienti, automazioni che fanno risparmiare tempo.
        </p>
        <a href="#soluzioni-business" class="feature-card__link">
          Esplora soluzioni
          <svg class="icon-arrow" viewBox="0 0 16 16" aria-hidden="true">
            <path d="M1 8h14m0 0L8 1m7 7-7 7"/>
          </svg>
        </a>
      </div>
    </article>

  </div>
</section>

{{--
  Note: Scroll animation trigger handled by JavaScript
  See resources/js/core/animations.js for IntersectionObserver implementation
--}}
