{{--
  Value Proposition Section - Why Choose Alpacode

  Four key value propositions presented in a premium grid layout:
  - Prezzi Onesti
  - Team Giovane
  - Niente Vincoli
  - Supporto Reale
--}}

<section class="value-proposition" aria-labelledby="value-proposition-title">
  <div class="value-proposition__header">
    <h2 class="value-proposition__title" id="value-proposition-title">
      Perché Scegliere Alpacode
    </h2>
  </div>

  <div class="value-proposition__grid">
    {{-- Value Prop 1: Prezzi Onesti --}}
    <article class="value-card" data-animate>
      <div class="value-card__icon" aria-hidden="true">
        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
          <circle cx="12" cy="12" r="10"/>
          <path d="M16 8h-6a2 2 0 1 0 0 4h4a2 2 0 1 1 0 4H8"/>
          <path d="M12 18V6"/>
        </svg>
      </div>
      <h3 class="value-card__title">Prezzi Onesti</h3>
      <p class="value-card__description">
        Sai quanto spendi prima di iniziare. Niente sorprese, niente costi nascosti.
      </p>
    </article>

    {{-- Value Prop 2: Team Giovane --}}
    <article class="value-card" data-animate>
      <div class="value-card__icon" aria-hidden="true">
        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
          <path d="M12 2v20"/>
          <path d="m15 5-3-3-3 3"/>
          <path d="m2 15 3 3 3-3"/>
          <path d="M2 12h20"/>
          <path d="m22 9-3 3 3 3"/>
        </svg>
      </div>
      <h3 class="value-card__title">Team Giovane</h3>
      <p class="value-card__description">
        Capiamo le esigenze digitali di oggi. Cresciuti nel digitale, esperienza vera.
      </p>
    </article>

    {{-- Value Prop 3: Niente Vincoli --}}
    <article class="value-card" data-animate>
      <div class="value-card__icon" aria-hidden="true">
        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
          <rect x="3" y="11" width="18" height="11" rx="2" ry="2"/>
          <path d="M7 11V7a5 5 0 0 1 9.9-1"/>
        </svg>
      </div>
      <h3 class="value-card__title">Niente Vincoli</h3>
      <p class="value-card__description">
        Il sito è tuo, punto. Gestiscilo come vuoi, quando vuoi.
      </p>
    </article>

    {{-- Value Prop 4: Supporto Reale --}}
    <article class="value-card" data-animate>
      <div class="value-card__icon" aria-hidden="true">
        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
          <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/>
        </svg>
      </div>
      <h3 class="value-card__title">Supporto Reale</h3>
      <p class="value-card__description">
        Rispondiamo davvero alle tue domande. Non ti lasciamo solo dopo la consegna.
      </p>
    </article>
  </div>
</section>

{{--
  Note: Scroll animation trigger handled by JavaScript
  See resources/js/core/animations.js for IntersectionObserver implementation
--}}
