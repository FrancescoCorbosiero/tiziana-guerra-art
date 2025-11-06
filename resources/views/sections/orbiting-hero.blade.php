{{-- Alpacode Orbiting Hero Component --}}
<section id="about" class="orbiting-hero" aria-label="Chi Siamo">
  <div class="wrapper">
    {{-- Main Content --}}
    <div class="orbiting-hero__content">
      <div class="orbiting-hero__text" data-aos="fade-down">
        <h1 class="orbiting-hero__title">
          Concentrati sulla tua attività,<br>
          <span class="orbiting-hero__title-accent">al resto ci pensiamo noi</span>
        </h1>
        <p class="orbiting-hero__subtitle">
          Siti web professionali per freelance, creator e piccole attività.<br>
          Tutto quello che ti serve, in un unico ecosistema.
        </p>
        <div class="orbiting-hero__actions">
          <a href="/contatti" class="button button--primary button--lg">
            <svg class="button__icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" aria-hidden="true">
              <path d="M12 2L3 7v6c0 5.5 3.8 10.7 9 12 5.2-1.3 9-6.5 9-12V7l-9-5z"/>
            </svg>
            Inizia il tuo progetto
          </a>
          <a href="#servizi" class="button button--secondary button--lg">
            <svg class="button__icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" aria-hidden="true">
              <circle cx="12" cy="12" r="10"/><path d="M12 16v-4m0-4h.01"/>
            </svg>
            Esplora i servizi
          </a>
        </div>
      </div>

      {{-- Orbital Ecosystem --}}
      <div class="orbiting-hero__ecosystem" data-aos="fade-up" data-aos-delay="200">
        {{-- Center Core --}}
        <div class="ecosystem__core">
          <div class="ecosystem__logo">
            <img src="/images/alpacode-logo.png"
                 alt="Alpacode Studio"
                 class="ecosystem__logo-image">
            <div class="ecosystem__glow" aria-hidden="true"></div>
          </div>
        </div>

        {{-- Orbit 1 - Core Services --}}
        <div class="ecosystem__orbit ecosystem__orbit--1">
          <div class="orbit__item" data-service="web-design">
            <div class="orbit__badge">
              <svg class="orbit__icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" aria-hidden="true">
                <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
              </svg>
              <span class="orbit__label">Web Design</span>
            </div>
            <div class="orbit__tooltip">Design moderno e responsive</div>
          </div>
          <div class="orbit__item" data-service="development">
            <div class="orbit__badge">
              <svg class="orbit__icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" aria-hidden="true">
                <path d="M16 18l6-6-6-6M8 6l-6 6 6 6"/>
              </svg>
              <span class="orbit__label">Sviluppo</span>
            </div>
            <div class="orbit__tooltip">Codice pulito e performante</div>
          </div>
          <div class="orbit__item" data-service="seo">
            <div class="orbit__badge">
              <svg class="orbit__icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" aria-hidden="true">
                <circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/>
              </svg>
              <span class="orbit__label">SEO</span>
            </div>
            <div class="orbit__tooltip">Prima pagina su Google</div>
          </div>
          <div class="orbit__item" data-service="performance">
            <div class="orbit__badge">
              <svg class="orbit__icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" aria-hidden="true">
                <path d="M13 2L3 14h9l-1 8 10-12h-9l1-8z"/>
              </svg>
              <span class="orbit__label">Performance</span>
            </div>
            <div class="orbit__tooltip">Siti velocissimi</div>
          </div>
        </div>

        {{-- Orbit 2 - Solutions --}}
        <div class="ecosystem__orbit ecosystem__orbit--2">
          <div class="orbit__item" data-service="ecommerce">
            <div class="orbit__badge orbit__badge--secondary">
              <svg class="orbit__icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" aria-hidden="true">
                <circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/><path d="M1 1h4l2.68 13.39a2 2 0 002 1.61h9.72a2 2 0 002-1.61L23 6H6"/>
              </svg>
              <span class="orbit__label">E-commerce</span>
            </div>
            <div class="orbit__tooltip">Vendi online facilmente</div>
          </div>
          <div class="orbit__item" data-service="booking">
            <div class="orbit__badge orbit__badge--secondary">
              <svg class="orbit__icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" aria-hidden="true">
                <rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><path d="M16 2v4M8 2v4M3 10h18"/>
              </svg>
              <span class="orbit__label">Booking</span>
            </div>
            <div class="orbit__tooltip">Prenotazioni automatiche</div>
          </div>
          <div class="orbit__item" data-service="portfolio">
            <div class="orbit__badge orbit__badge--secondary">
              <svg class="orbit__icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" aria-hidden="true">
                <rect x="3" y="3" width="18" height="18" rx="2" ry="2"/><circle cx="8.5" cy="8.5" r="1.5"/><path d="M21 15l-5-5L5 21"/>
              </svg>
              <span class="orbit__label">Portfolio</span>
            </div>
            <div class="orbit__tooltip">Mostra i tuoi lavori</div>
          </div>
          <div class="orbit__item" data-service="blog">
            <div class="orbit__badge orbit__badge--secondary">
              <svg class="orbit__icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" aria-hidden="true">
                <path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z"/><path d="M14 2v6h6M16 13H8M16 17H8M10 9H8"/>
              </svg>
              <span class="orbit__label">Blog</span>
            </div>
            <div class="orbit__tooltip">Condividi contenuti</div>
          </div>
          <div class="orbit__item" data-service="membership">
            <div class="orbit__badge orbit__badge--secondary">
              <svg class="orbit__icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" aria-hidden="true">
                <path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2"/><circle cx="12" cy="7" r="4"/>
              </svg>
              <span class="orbit__label">Membership</span>
            </div>
            <div class="orbit__tooltip">Area membri esclusiva</div>
          </div>
        </div>

        {{-- Orbit 3 - Features --}}
        <div class="ecosystem__orbit ecosystem__orbit--3">
          <div class="orbit__item" data-service="support">
            <div class="orbit__badge orbit__badge--tertiary">
              <svg class="orbit__icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" aria-hidden="true">
                <path d="M3 11h3a2 2 0 012 2v3a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a9 9 0 0118 0v5a2 2 0 01-2 2h-1a2 2 0 01-2-2v-3a2 2 0 012-2h3"/>
              </svg>
              <span class="orbit__label">Supporto 24/7</span>
            </div>
            <div class="orbit__tooltip">Sempre al tuo fianco</div>
          </div>
          <div class="orbit__item" data-service="hosting">
            <div class="orbit__badge orbit__badge--tertiary">
              <svg class="orbit__icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" aria-hidden="true">
                <path d="M18 10h-1.26A8 8 0 109 20h9a5 5 0 000-10z"/>
              </svg>
              <span class="orbit__label">Hosting</span>
            </div>
            <div class="orbit__tooltip">Veloce e sicuro</div>
          </div>
          <div class="orbit__item" data-service="analytics">
            <div class="orbit__badge orbit__badge--tertiary">
              <svg class="orbit__icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" aria-hidden="true">
                <path d="M3 3v18h18"/><path d="m19 9-5 5-4-4-3 3"/>
              </svg>
              <span class="orbit__label">Analytics</span>
            </div>
            <div class="orbit__tooltip">Monitora i risultati</div>
          </div>
        </div>

        {{-- Connection Lines --}}
        <svg class="ecosystem__connections" viewBox="0 0 600 600" aria-hidden="true">
          <defs>
            <linearGradient id="lineGradient" x1="0%" y1="0%" x2="100%" y2="100%">
              <stop offset="0%" stop-color="var(--color-brand-primary)" stop-opacity="0.3" />
              <stop offset="100%" stop-color="var(--color-brand-primary)" stop-opacity="0" />
            </linearGradient>
          </defs>
        </svg>
      </div>
    </div>
  </div>
</section>

{{-- Styles for this section are in /resources/css/sections/_orbiting-hero.css --}}
{{-- JavaScript for this section is in /resources/js/sections/orbiting-hero.js --}}
