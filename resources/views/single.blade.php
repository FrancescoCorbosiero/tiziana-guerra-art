@extends('layouts.app')

@section('content')
  @while (have_posts())
    @php(the_post())
    @php
      // Get ACF fields with safety checks
      $dimensioni = function_exists('get_field') ? get_field('dimensioni') : '';
      $anno = function_exists('get_field') ? get_field('anno') : '';
      $tecnica = function_exists('get_field') ? get_field('tecnica') : '';
      $prezzo = function_exists('get_field') ? get_field('prezzo') : '';
      $stato = function_exists('get_field') ? (get_field('stato') ?: 'disponibile') : 'disponibile';
      $timeline_mostre = function_exists('get_field') ? get_field('timeline_mostre') : '';
      $link_processo = function_exists('get_field') ? get_field('link_processo_creativo') : '';
      $is_venduto = $stato === 'venduto';
    @endphp

    <article @php(post_class('opera-single'))>
      {{-- Hero Section with Featured Image --}}
      <section class="opera-hero">
        <div class="container--lg">
          @if (has_post_thumbnail())
            <div class="opera-hero__image-wrapper">
              {!! get_the_post_thumbnail(null, 'full', ['class' => 'opera-hero__image']) !!}

              @if ($is_venduto)
                <div class="opera-hero__venduto">
                  <span class="venduto-badge-large">VENDUTO</span>
                </div>
              @endif
            </div>
          @endif
        </div>
      </section>

      {{-- Main Content Section --}}
      <section class="opera-content section">
        <div class="container--md">
          {{-- Title and Metadata --}}
          <header class="opera-header">
            <h1 class="opera-title">{!! get_the_title() !!}</h1>

            @php
              // Build meta items safely without relying on count() on null
              $meta_items = array_filter([
                $anno ?: null,
                $dimensioni ?: null,
                $tecnica ? ucfirst($tecnica) : null,
              ]);
            @endphp

            @if (!empty($meta_items))
              <div class="opera-meta">
                {{ implode(' • ', $meta_items) }}
              </div>
            @endif

            @if ($is_venduto)
              <div class="opera-status opera-status--venduto">
                Questa opera è stata venduta
              </div>
            @elseif ($prezzo)
              <div class="opera-price">
                {{ $prezzo }}
              </div>
            @endif
          </header>

          {{-- Description / Content --}}
          @if (get_the_content())
            <div class="opera-description">
              @include('partials.content-single')
            </div>
          @endif

          {{-- Categories and Tags --}}
          <div class="opera-taxonomies">
            @php
              $categories = get_the_category();
              $tags = get_the_tags();
            @endphp

            @if ($categories)
              <div class="taxonomy-group">
                <strong class="taxonomy-label">Categoria:</strong>
                <div class="taxonomy-terms">
                  @foreach ($categories as $category)
                    <a href="{{ get_category_link($category->term_id) }}" class="taxonomy-term">
                      {{ $category->name }}
                    </a>
                  @endforeach
                </div>
              </div>
            @endif

            @if ($tags)
              <div class="taxonomy-group">
                <strong class="taxonomy-label">Tecniche:</strong>
                <div class="taxonomy-terms">
                  @foreach ($tags as $tag)
                    <a href="{{ get_tag_link($tag->term_id) }}" class="taxonomy-term">
                      {{ $tag->name }}
                    </a>
                  @endforeach
                </div>
              </div>
            @endif
          </div>

          {{-- Timeline Mostre (safe, bounded) --}}
          @if ($timeline_mostre && is_string($timeline_mostre) && mb_strlen($timeline_mostre) < 20000)
            <div class="opera-timeline">
              <h2 class="opera-section-title">Mostre ed Esposizioni</h2>
              <div class="timeline-content">
                @php
                  // Split on new lines, trim entries, filter empties, and hard-limit the number of items
                  $lines = preg_split("/\r?\n/", (string) $timeline_mostre);
                  $lines = is_array($lines) ? $lines : [];
                  $mostre = array_slice(array_filter(array_map('trim', $lines)), 0, 200);
                @endphp
                <ul class="timeline-list">
                  @foreach ($mostre as $mostra)
                    <li class="timeline-item">{{ trim($mostra) }}</li>
                  @endforeach
                </ul>
              </div>
            </div>
          @endif

          {{-- Action Buttons --}}
          <div class="opera-actions">
            @if ($link_processo)
              <a href="{{ $link_processo }}" target="_blank" rel="noopener noreferrer" class="button button--primary button--large">
                <svg class="button-icon" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                  <polygon points="5 3 19 12 5 21 5 3"></polygon>
                </svg>
                Guarda il Processo Creativo
              </a>
            @endif

            <a href="#contact" class="button button--secondary button--large">
              <svg class="button-icon" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path>
                <polyline points="22,6 12,13 2,6"></polyline>
              </svg>
              Richiedi Informazioni
            </a>
          </div>
        </div>
      </section>

      {{-- Navigation to Previous/Next Opera --}}
      @if (get_previous_post() || get_next_post())
        <nav class="opera-navigation section--sm" aria-label="Navigazione opere">
          <div class="container--md">
            <div class="opera-nav-grid">
              @if ($previous = get_previous_post())
                <a href="{{ get_permalink($previous) }}" class="opera-nav-item opera-nav-item--prev">
                  <span class="opera-nav-label">← Opera Precedente</span>
                  <span class="opera-nav-title">{{ get_the_title($previous) }}</span>
                </a>
              @endif

              @php
                // Determine archive link dynamically for current post type with graceful fallback
                $current_post_type = get_post_type();
                $archive_link = get_post_type_archive_link($current_post_type);
                if (!$archive_link) {
                  $posts_page = get_option('page_for_posts');
                  $archive_link = $posts_page ? get_permalink($posts_page) : home_url('/');
                }
              @endphp
              <a href="{{ $archive_link }}" class="opera-nav-item opera-nav-item--all">
                <span class="opera-nav-label">Tutte le Opere</span>
              </a>

              @if ($next = get_next_post())
                <a href="{{ get_permalink($next) }}" class="opera-nav-item opera-nav-item--next">
                  <span class="opera-nav-label">Opera Successiva →</span>
                  <span class="opera-nav-title">{{ get_the_title($next) }}</span>
                </a>
              @endif
            </div>
          </div>
        </nav>
      @endif
    </article>
  @endwhile
@endsection
