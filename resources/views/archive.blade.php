@extends('layouts.app')

@section('content')
  {{-- Page Header --}}
  <header class="opere-archive-header section--sm">
    <div class="container text-center">
      <h1 class="heading-1">{{ is_category() ? single_cat_title('', false) : (is_tag() ? single_tag_title('', false) : 'Le Mie Opere') }}</h1>
      @if (is_category() || is_tag())
        <p class="body-large" style="color: var(--color-text-secondary); margin-top: var(--space-sm);">
          {{ category_description() ?: tag_description() }}
        </p>
      @else
        <p class="body-large tagline">Where art comes to life</p>
      @endif
    </div>
  </header>

  {{-- Filters --}}
  <div class="opere-filters section--sm">
    <div class="container">
      <form method="get" action="{{ get_post_type_archive_link('post') }}" class="filters-form">
        <div class="filters-grid">
          {{-- Category Filter --}}
          <div class="filter-group">
            <label for="categoria" class="filter-label">Categoria</label>
            <select name="categoria" id="categoria" class="filter-select" onchange="this.form.submit()">
              <option value="">Tutte le categorie</option>
              @php
                $categories = get_categories(['hide_empty' => true]);
                $current_cat = get_query_var('categoria') ?: (is_category() ? get_queried_object()->slug : '');
              @endphp
              @foreach ($categories as $category)
                <option value="{{ $category->slug }}" {{ $current_cat == $category->slug ? 'selected' : '' }}>
                  {{ $category->name }} ({{ $category->count }})
                </option>
              @endforeach
            </select>
          </div>

          {{-- Tag Filter (Tecniche) --}}
          <div class="filter-group">
            <label for="tecnica-tag" class="filter-label">Tecnica</label>
            <select name="tecnica" id="tecnica-tag" class="filter-select" onchange="this.form.submit()">
              <option value="">Tutte le tecniche</option>
              @php
                $tags = get_tags(['hide_empty' => true]);
                $current_tag = get_query_var('tecnica') ?: (is_tag() ? get_queried_object()->slug : '');
              @endphp
              @foreach ($tags as $tag)
                <option value="{{ $tag->slug }}" {{ $current_tag == $tag->slug ? 'selected' : '' }}>
                  {{ $tag->name }} ({{ $tag->count }})
                </option>
              @endforeach
            </select>
          </div>

          {{-- Reset Button --}}
          @if (get_query_var('categoria') || get_query_var('tecnica') || is_category() || is_tag())
            <div class="filter-group">
              <a href="{{ get_post_type_archive_link('post') }}" class="button button--secondary filter-reset">
                Reset Filtri
              </a>
            </div>
          @endif
        </div>
      </form>
    </div>
  </div>

  {{-- Gallery Grid --}}
  <div class="container section">
    @if (have_posts())
      <div class="opere-grid">
        @while (have_posts())
          @php(the_post())
          @php
            $stato = function_exists('get_field') ? get_field('stato') : 'disponibile';
            $stato = $stato ?: 'disponibile';
            $is_venduto = $stato === 'venduto';
          @endphp

          <article @php(post_class('opera-card'))>
            <a href="{{ get_permalink() }}" class="opera-card__link">
              @if (has_post_thumbnail())
                <div class="opera-card__image">
                  {!! get_the_post_thumbnail(null, 'large', ['loading' => 'lazy']) !!}

                  {{-- Venduto Overlay --}}
                  @if ($is_venduto)
                    <div class="opera-card__venduto-overlay">
                      <span class="venduto-badge">VENDUTO</span>
                    </div>
                  @endif

                  {{-- Hover Overlay with Info --}}
                  <div class="opera-card__hover-overlay">
                    <div class="opera-card__info">
                      <h3 class="opera-card__title">{{ get_the_title() }}</h3>
                      @if (function_exists('get_field') && ($anno = get_field('anno')))
                        <p class="opera-card__meta">{{ $anno }}</p>
                      @endif
                      @if (function_exists('get_field') && ($dimensioni = get_field('dimensioni')))
                        <p class="opera-card__meta">{{ $dimensioni }}</p>
                      @endif
                    </div>
                  </div>
                </div>
              @else
                <div class="opera-card__image opera-card__image--placeholder">
                  <span>Nessuna immagine</span>
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
        @endwhile
      </div>

      {{-- Pagination --}}
      @if (get_the_posts_pagination())
        <nav class="pagination" aria-label="Navigazione opere">
          {!! get_the_posts_pagination([
            'prev_text' => '← Precedente',
            'next_text' => 'Successivo →',
          ]) !!}
        </nav>
      @endif
    @else
      <div class="text-center">
        <div class="card" style="padding: var(--space-xl); max-width: 48rem; margin-inline: auto;">
          <p class="body-large">{{ __('Nessuna opera trovata con i filtri selezionati.', 'sage') }}</p>
          <a href="{{ get_post_type_archive_link('post') }}" class="button button--primary" style="margin-top: var(--space-md);">
            Vedi tutte le opere
          </a>
        </div>
      </div>
    @endif
  </div>

  @php(wp_reset_postdata())
@endsection
