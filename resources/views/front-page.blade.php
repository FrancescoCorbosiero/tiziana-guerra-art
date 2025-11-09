{{--
  Template Name: Front Page (Homepage)
  Artist Portfolio Homepage
--}}

@extends('layouts.app')

@section('content')

  {{-- Hero Section --}}
  <section class="artist-hero">
    <div class="container">
      <div class="artist-hero__content">
        <h1 class="artist-hero__title">Tiziana Guerra</h1>
        <p class="artist-hero__tagline">Where art comes to life</p>
        <div class="artist-hero__actions">
          <a href="{{ get_permalink(get_option('page_for_posts')) ?: home_url('/') }}" class="button button--primary button--large">
            Esplora le Opere
          </a>
          <a href="#chi-sono" class="button button--secondary button--large">
            Chi Sono
          </a>
        </div>
      </div>
    </div>
  </section>

  {{-- Featured Paintings Section --}}
  <section class="featured-opere section">
    <div class="container">
      <header class="section-header text-center">
        <h2 class="heading-2">Opere in Evidenza</h2>
        <p class="section-subtitle">Una selezione delle mie creazioni più recenti</p>
      </header>

      @php
        // Lightweight query with caching enabled for optimal performance
        $featured_opere = get_posts([
          'post_type' => 'post',
          'posts_per_page' => 6,
          'orderby' => 'date',
          'order' => 'DESC',
          'post_status' => 'publish',
          'suppress_filters' => true,  // Prevent pre_get_posts from running
          'no_found_rows' => true,     // Performance improvement
          'ignore_sticky_posts' => true,
          'update_post_term_cache' => false,
          // CRITICAL: cache_results MUST be true (default) to enable WordPress object caching
        ]);
      @endphp

      @if (!empty($featured_opere))
        <div class="opere-grid opere-grid--featured">
          @foreach ($featured_opere as $post)
            @php(setup_postdata($post))
            @php
              $stato = function_exists('get_field') ? get_field('stato') : 'disponibile';
              $stato = $stato ?: 'disponibile';
              $is_venduto = $stato === 'venduto';
            @endphp

            <article class="opera-card">
              <a href="{{ get_permalink() }}" class="opera-card__link">
                @if (has_post_thumbnail())
                  <div class="opera-card__image">
                    {!! get_the_post_thumbnail(null, 'medium_large', ['loading' => 'lazy']) !!}

                    @if ($is_venduto)
                      <div class="opera-card__venduto-overlay">
                        <span class="venduto-badge">VENDUTO</span>
                      </div>
                    @endif

                    <div class="opera-card__hover-overlay">
                      <div class="opera-card__info">
                        <h3 class="opera-card__title">{{ get_the_title() }}</h3>
                        @if (function_exists('get_field') && ($anno = get_field('anno')))
                          <p class="opera-card__meta">{{ $anno }}</p>
                        @endif
                      </div>
                    </div>
                  </div>
                @endif

                <div class="opera-card__content">
                  <h3 class="opera-card__title-below">{{ get_the_title() }}</h3>
                  @php
                    $meta_items = [];
                    if (function_exists('get_field')) {
                      if ($anno = get_field('anno')) $meta_items[] = $anno;
                      if ($tecnica = get_field('tecnica')) $meta_items[] = ucfirst($tecnica);
                    }
                  @endphp
                  @if (count($meta_items) > 0)
                    <p class="opera-card__meta-below">{{ implode(' • ', $meta_items) }}</p>
                  @endif
                </div>
              </a>
            </article>
          @endforeach
        </div>

        <div class="text-center" style="margin-top: var(--space-xl);">
          <a href="{{ get_permalink(get_option('page_for_posts')) ?: home_url('/') }}" class="button button--primary">
            Vedi Tutte le Opere →
          </a>
        </div>
      @endif

      @php(wp_reset_postdata())
    </div>
  </section>

  {{-- Chi Sono Section --}}
  <section id="chi-sono" class="chi-sono-section section">
    <div class="container--md">
      <div class="chi-sono-grid">
        <div class="chi-sono__image">
          {{-- You can add an artist photo here via WordPress Customizer or static image --}}
          <img
            src="https://images.unsplash.com/photo-1513364776144-60967b0f800f?w=800&auto=format&fit=crop"
            alt="Tiziana Guerra"
            loading="lazy"
          />
        </div>

        <div class="chi-sono__content">
          <h2 class="heading-2">Chi Sono</h2>
          <div class="chi-sono__text">
            <p>
              Sono un'artista appassionata che trova ispirazione nella bellezza della natura,
              nelle emozioni umane e nei colori vibranti della vita. Ogni mia opera è un viaggio
              personale, un'esplorazione dell'anima attraverso pennelli e tele.
            </p>
            <p>
              La mia arte è il risultato di anni di studio, sperimentazione e amore per la pittura.
              Dalle tecniche classiche all'innovazione contemporanea, cerco di creare opere che
              parlino al cuore di chi le osserva.
            </p>
          </div>
          <a href="#contact" class="button button--secondary">
            Contattami
          </a>
        </div>
      </div>
    </div>
  </section>

  {{-- CTA Section --}}
  <section class="homepage-cta section">
    <div class="container text-center">
      <h2 class="heading-2">Interessato a Commissioni o Collaborazioni?</h2>
      <p class="body-large" style="color: var(--color-text-secondary); margin-top: var(--space-md);">
        Sono sempre aperta a nuovi progetti artistici e collaborazioni creative.
      </p>
      <div style="margin-top: var(--space-lg);">
        <a href="#contact" class="button button--primary button--large">
          Richiedi Informazioni
        </a>
      </div>
    </div>
  </section>

@endsection
