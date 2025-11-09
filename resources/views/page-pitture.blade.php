{{--
  Template Name: Pitture Grid
--}}

@extends('layouts.app')

@section('content')
  <div class="pitture-archive">
    {{-- Page Header --}}
    <header class="archive-header section--sm">
      <div class="container text-center">
        <h1 class="archive-title">Pitture</h1>
        <p class="archive-subtitle">Esplora la collezione completa delle opere d'arte</p>
      </div>
    </header>

    {{-- Grid Controls & Filters --}}
    <div class="archive-controls section--sm">
      <div class="container">
        <div class="controls-wrapper">
          {{-- Grid Column Selector --}}
          <div class="grid-controls">
            <span class="controls-label">Vista:</span>
            <a href="?columns=3{{ isset($_GET['categoria']) ? '&categoria=' . esc_attr($_GET['categoria']) : '' }}"
               class="grid-toggle {{ (!isset($_GET['columns']) || $_GET['columns'] == '3') ? 'active' : '' }}"
               aria-label="3 Colonne">
              3 Colonne
            </a>
            <a href="?columns=4{{ isset($_GET['categoria']) ? '&categoria=' . esc_attr($_GET['categoria']) : '' }}"
               class="grid-toggle {{ (isset($_GET['columns']) && $_GET['columns'] == '4') ? 'active' : '' }}"
               aria-label="4 Colonne">
              4 Colonne
            </a>
          </div>

          {{-- Category Filter --}}
          <div class="filter-controls">
            <label for="filter" class="controls-label">Filtra per:</label>
            <select id="filter" name="categoria" class="filter-select" onchange="window.location.href='?categoria='+this.value{{ isset($_GET['columns']) ? '&columns=' . esc_attr($_GET['columns']) : '' }}">
              <option value="">Tutte le Opere</option>
              @php
                $categories = get_categories([
                  'hide_empty' => true,
                  'orderby' => 'name',
                  'order' => 'ASC'
                ]);
                $current_categoria = isset($_GET['categoria']) ? sanitize_text_field($_GET['categoria']) : '';
              @endphp
              @foreach($categories as $category)
                <option value="{{ $category->slug }}" {{ $current_categoria == $category->slug ? 'selected' : '' }}>
                  {{ $category->name }}
                </option>
              @endforeach
            </select>

            @if($current_categoria)
              <a href="?{{ isset($_GET['columns']) ? 'columns=' . esc_attr($_GET['columns']) : '' }}" class="filter-reset">
                Rimuovi Filtro
              </a>
            @endif
          </div>
        </div>
      </div>
    </div>

    {{-- Opera Grid --}}
    <section class="opera-grid-section section">
      <div class="container">
        @php
          // Get column count from URL parameter
          $columns = isset($_GET['columns']) ? intval($_GET['columns']) : 3;
          $columns = in_array($columns, [3, 4]) ? $columns : 3;
          $grid_class = 'opera-grid opera-grid--' . $columns . 'col';

          // Get category filter
          $categoria = isset($_GET['categoria']) ? sanitize_text_field($_GET['categoria']) : '';

          // Lightweight query with caching enabled for optimal performance
          $args = [
            'post_type' => 'post',
            'posts_per_page' => -1,
            'orderby' => 'date',
            'order' => 'DESC',
            'post_status' => 'publish',
            'suppress_filters' => true,  // Prevent pre_get_posts from running
            'no_found_rows' => true,     // Performance improvement
            'ignore_sticky_posts' => true,
            'update_post_term_cache' => false,
          ];

          if ($categoria) {
            $args['category_name'] = $categoria;
          }

          $opere = get_posts($args);
        @endphp

        @if(!empty($opere))
          <div class="{{ $grid_class }}">
            @foreach($opere as $post)
              @php(setup_postdata($post))

              <article class="opera-card">
                <a href="{{ get_permalink() }}" class="opera-card__link">
                  @if(has_post_thumbnail())
                    <div class="opera-card__image-wrapper">
                      {!! get_the_post_thumbnail(null, 'medium_large', ['class' => 'opera-card__image', 'loading' => 'lazy']) !!}

                      {{-- Venduto Badge --}}
                      @if(get_field('stato', $post->ID) === 'venduto')
                        <div class="opera-card__badge opera-card__badge--venduto">
                          VENDUTO
                        </div>
                      @endif

                      {{-- Hover overlay --}}
                      <div class="opera-card__overlay">
                        <span class="opera-card__zoom-icon" aria-hidden="true">+</span>
                      </div>
                    </div>
                  @else
                    <div class="opera-card__image-wrapper opera-card__image-wrapper--placeholder">
                      <span class="placeholder-text">Nessuna immagine</span>
                    </div>
                  @endif

                  <div class="opera-card__content">
                    <h2 class="opera-card__title">{!! get_the_title() !!}</h2>

                    @if(get_field('anno', $post->ID) || get_field('tecnica', $post->ID))
                      <p class="opera-card__meta">
                        @if(get_field('anno', $post->ID)){{ get_field('anno', $post->ID) }}@endif
                        @if(get_field('anno', $post->ID) && get_field('tecnica', $post->ID)) • @endif
                        @if(get_field('tecnica', $post->ID)){{ ucfirst(get_field('tecnica', $post->ID)) }}@endif
                      </p>
                    @endif
                  </div>
                </a>
              </article>
            @endforeach
          </div>

          {{-- Results count --}}
          <div class="archive-results">
            <p class="results-count">
              Visualizzate {{ count($opere) }} {{ count($opere) === 1 ? 'opera' : 'opere' }}
            </p>
          </div>
        @else
          <div class="no-results">
            <div class="no-results__content">
              <p class="no-results__text">Nessuna opera trovata{{ $categoria ? ' per questa categoria' : '' }}.</p>
              @if($categoria)
                <a href="?" class="button button--primary">
                  Vedi tutte le opere
                </a>
              @endif
            </div>
          </div>
        @endif

        @php(wp_reset_postdata())
      </div>
    </section>
  </div>
@endsection

@push('styles')
<style>
  /* Override to use modern sans-serif fonts */
  .pitture-archive h1,
  .pitture-archive h2,
  .pitture-archive h3 {
    font-family: var(--font-family-base);
    font-weight: var(--font-weight-light);
  }

  /* Archive Header */
  .archive-header {
    padding-block: var(--space-2xl);
  }

  .archive-title {
    font-size: var(--font-size-5xl);
    font-weight: var(--font-weight-light);
    margin-block-end: var(--space-sm);
    color: var(--color-text-primary);
  }

  .archive-subtitle {
    font-size: var(--font-size-lg);
    color: var(--color-text-secondary);
    margin: 0;
  }

  /* Archive Controls */
  .archive-controls {
    background: var(--color-neutral-50);
    padding-block: var(--space-lg);
    border-block: 1px solid var(--color-neutral-200);
  }

  .controls-wrapper {
    display: flex;
    flex-wrap: wrap;
    align-items: center;
    justify-content: space-between;
    gap: var(--space-lg);
  }

  .controls-label {
    font-size: var(--font-size-sm);
    font-weight: var(--font-weight-medium);
    color: var(--color-text-secondary);
  }

  /* Grid Controls */
  .grid-controls {
    display: flex;
    align-items: center;
    gap: var(--space-sm);
  }

  .grid-toggle {
    padding: var(--space-xs) var(--space-md);
    border: 2px solid var(--color-neutral-300);
    border-radius: var(--radius-sm);
    font-size: var(--font-size-sm);
    font-weight: var(--font-weight-medium);
    text-decoration: none;
    color: var(--color-text-primary);
    transition: all var(--duration-fast) var(--easing-out);
  }

  .grid-toggle:hover {
    border-color: var(--color-neutral-400);
    background: var(--color-neutral-100);
  }

  .grid-toggle.active {
    background: var(--color-neutral-1000);
    color: white;
    border-color: var(--color-neutral-1000);
  }

  /* Filter Controls */
  .filter-controls {
    display: flex;
    align-items: center;
    gap: var(--space-sm);
  }

  .filter-select {
    padding: var(--space-xs) var(--space-md);
    border: 2px solid var(--color-neutral-300);
    border-radius: var(--radius-sm);
    font-size: var(--font-size-sm);
    font-weight: var(--font-weight-medium);
    color: var(--color-text-primary);
    background: white;
    cursor: pointer;
    transition: border-color var(--duration-fast) var(--easing-out);
  }

  .filter-select:hover,
  .filter-select:focus {
    border-color: var(--color-neutral-400);
    outline: none;
  }

  .filter-reset {
    padding: var(--space-xs) var(--space-md);
    background: transparent;
    border: 2px solid var(--color-neutral-300);
    border-radius: var(--radius-sm);
    font-size: var(--font-size-sm);
    font-weight: var(--font-weight-medium);
    color: var(--color-text-primary);
    text-decoration: none;
    transition: all var(--duration-fast) var(--easing-out);
  }

  .filter-reset:hover {
    background: var(--color-neutral-1000);
    color: white;
    border-color: var(--color-neutral-1000);
  }

  /* Opera Grid */
  .opera-grid-section {
    padding-block: var(--space-3xl);
  }

  .opera-grid {
    display: grid;
    gap: var(--space-lg);
  }

  .opera-grid--3col {
    grid-template-columns: repeat(3, 1fr);
  }

  .opera-grid--4col {
    grid-template-columns: repeat(4, 1fr);
  }

  /* Opera Card */
  .opera-card {
    position: relative;
    overflow: hidden;
    border-radius: var(--radius-md);
    background: var(--color-surface-base);
    transition: transform var(--duration-base) var(--easing-out);
  }

  .opera-card:hover {
    transform: translateY(-4px);
  }

  .opera-card__link {
    display: block;
    text-decoration: none;
    color: inherit;
  }

  .opera-card__image-wrapper {
    position: relative;
    aspect-ratio: 4 / 3;
    overflow: hidden;
    background: var(--color-neutral-100);
  }

  .opera-card__image-wrapper--placeholder {
    display: flex;
    align-items: center;
    justify-content: center;
  }

  .placeholder-text {
    font-size: var(--font-size-sm);
    color: var(--color-text-tertiary);
  }

  .opera-card__image {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform var(--duration-base) var(--easing-out);
  }

  .opera-card:hover .opera-card__image {
    transform: scale(1.05);
  }

  /* Badge */
  .opera-card__badge {
    position: absolute;
    top: var(--space-sm);
    right: var(--space-sm);
    padding: var(--space-2xs) var(--space-sm);
    font-size: var(--font-size-xs);
    font-weight: var(--font-weight-semibold);
    letter-spacing: 0.05em;
    text-transform: uppercase;
    border-radius: var(--radius-sm);
    z-index: var(--z-dropdown);
  }

  .opera-card__badge--venduto {
    background: rgba(0, 0, 0, 0.85);
    color: white;
  }

  /* Overlay */
  .opera-card__overlay {
    position: absolute;
    inset: 0;
    background: rgba(0, 0, 0, 0.6);
    display: flex;
    align-items: center;
    justify-content: center;
    opacity: 0;
    transition: opacity var(--duration-base) var(--easing-out);
  }

  .opera-card:hover .opera-card__overlay {
    opacity: 1;
  }

  .opera-card__zoom-icon {
    font-size: 4rem;
    font-weight: var(--font-weight-light);
    color: white;
    line-height: 1;
  }

  /* Card Content */
  .opera-card__content {
    padding: var(--space-md);
  }

  .opera-card__title {
    font-size: var(--font-size-lg);
    font-weight: var(--font-weight-normal);
    line-height: var(--line-height-snug);
    margin: 0 0 var(--space-2xs) 0;
    color: var(--color-text-primary);
  }

  .opera-card__meta {
    font-size: var(--font-size-sm);
    color: var(--color-text-secondary);
    margin: 0;
  }

  /* Results Count */
  .archive-results {
    margin-block-start: var(--space-2xl);
    text-align: center;
  }

  .results-count {
    font-size: var(--font-size-sm);
    color: var(--color-text-secondary);
    margin: 0;
  }

  /* No Results */
  .no-results {
    padding: var(--space-3xl) 0;
    text-align: center;
  }

  .no-results__content {
    max-width: 32rem;
    margin-inline: auto;
  }

  .no-results__text {
    font-size: var(--font-size-lg);
    color: var(--color-text-secondary);
    margin-block-end: var(--space-lg);
  }

  .button {
    display: inline-flex;
    align-items: center;
    padding: var(--space-sm) var(--space-lg);
    font-size: var(--font-size-base);
    font-weight: var(--font-weight-medium);
    text-decoration: none;
    border-radius: var(--radius-md);
    transition: all var(--duration-base) var(--easing-out);
  }

  .button--primary {
    background: var(--color-accent-cta);
    color: white;
    border: 2px solid var(--color-accent-cta);
  }

  .button--primary:hover {
    background: color-mix(in oklch, var(--color-accent-cta), black 15%);
    border-color: color-mix(in oklch, var(--color-accent-cta), black 15%);
  }

  /* Mobile First: Single column */
  @media (max-width: 640px) {
    .archive-title {
      font-size: var(--font-size-3xl);
    }

    .controls-wrapper {
      flex-direction: column;
      align-items: stretch;
    }

    .grid-controls,
    .filter-controls {
      flex-direction: column;
      align-items: stretch;
    }

    .grid-controls {
      flex-direction: row;
      justify-content: center;
    }

    .controls-label {
      margin-block-end: var(--space-2xs);
    }

    .filter-select {
      width: 100%;
    }

    .opera-grid--3col,
    .opera-grid--4col {
      grid-template-columns: 1fr;
    }

    .opera-card__zoom-icon {
      font-size: 3rem;
    }
  }

  /* Tablet: 2 columns */
  @media (min-width: 641px) and (max-width: 1024px) {
    .archive-title {
      font-size: var(--font-size-4xl);
    }

    .opera-grid--3col,
    .opera-grid--4col {
      grid-template-columns: repeat(2, 1fr);
    }
  }

  /* Desktop: 3-4 columns as specified */
  @media (min-width: 1025px) {
    .opera-grid--3col {
      grid-template-columns: repeat(3, 1fr);
    }

    .opera-grid--4col {
      grid-template-columns: repeat(4, 1fr);
    }
  }

  /* Large Desktop: maintain aspect for very wide screens */
  @media (min-width: 1600px) {
    .opera-grid--3col {
      grid-template-columns: repeat(3, minmax(0, 28rem));
      justify-content: center;
    }

    .opera-grid--4col {
      grid-template-columns: repeat(4, minmax(0, 22rem));
      justify-content: center;
    }
  }
</style>
@endpush
