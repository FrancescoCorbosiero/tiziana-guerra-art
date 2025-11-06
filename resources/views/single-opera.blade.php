@extends('layouts.app')

@section('content')
  @while(have_posts()) @php(the_post())
    @php
      // Get ACF fields or custom meta
      $foto = function_exists('get_field') ? get_field('foto') : null;
      $anno = function_exists('get_field') ? get_field('anno') : '';
      $tecnica = function_exists('get_field') ? get_field('tecnica') : '';
      $dimensioni = function_exists('get_field') ? get_field('dimensioni') : '';
      $prezzo = function_exists('get_field') ? get_field('prezzo') : '';
      $stato = function_exists('get_field') ? (get_field('stato') ?: 'disponibile') : 'disponibile';
      $timeline_mostre = function_exists('get_field') ? get_field('timeline_mostre') : '';
      $link_processo = function_exists('get_field') ? get_field('link_processo_creativo') : '';
      $disponibile = $stato === 'disponibile' || $stato === 'non_in_vendita';
      $is_venduto = $stato === 'venduto';
    @endphp

    <article @php(post_class('single-opera'))>
      {{-- Large featured image section --}}
      <section class="opera-hero">
        @if($foto && is_array($foto) && isset($foto['url']))
          <img src="{{ $foto['url'] }}" alt="{{ $foto['alt'] ?? get_the_title() }}" class="opera-image" loading="eager">
        @elseif(has_post_thumbnail())
          {!! get_the_post_thumbnail(null, 'full', ['class' => 'opera-image', 'loading' => 'eager']) !!}
        @endif

        @if($is_venduto)
          <div class="opera-venduto-badge">
            <span>VENDUTO</span>
          </div>
        @endif
      </section>

      {{-- Artwork details --}}
      <section class="opera-details section">
        <div class="container container--md">
          <h1 class="opera-title">{!! get_the_title() !!}</h1>

          <dl class="opera-meta">
            @if($anno)
              <div class="opera-meta-item">
                <dt>Anno</dt>
                <dd>{{ $anno }}</dd>
              </div>
            @endif

            @if($tecnica)
              <div class="opera-meta-item">
                <dt>Tecnica</dt>
                <dd>{{ ucfirst($tecnica) }}</dd>
              </div>
            @endif

            @if($dimensioni)
              <div class="opera-meta-item">
                <dt>Dimensioni</dt>
                <dd>{{ $dimensioni }}</dd>
              </div>
            @endif

            @if($prezzo && !$is_venduto)
              <div class="opera-meta-item">
                <dt>Prezzo</dt>
                <dd>{{ $prezzo }}</dd>
              </div>
            @endif
          </dl>

          @if(get_the_content())
            <div class="opera-description">
              @php(the_content())
            </div>
          @endif

          {{-- Categories and Tags --}}
          @php
            $categories = get_the_category();
            $tags = get_the_tags();
          @endphp

          @if($categories || $tags)
            <div class="opera-taxonomies">
              @if($categories)
                <div class="taxonomy-group">
                  <strong class="taxonomy-label">Categoria:</strong>
                  <div class="taxonomy-terms">
                    @foreach($categories as $category)
                      <a href="{{ get_category_link($category->term_id) }}" class="taxonomy-term">
                        {{ $category->name }}
                      </a>
                    @endforeach
                  </div>
                </div>
              @endif

              @if($tags)
                <div class="taxonomy-group">
                  <strong class="taxonomy-label">Tecniche:</strong>
                  <div class="taxonomy-terms">
                    @foreach($tags as $tag)
                      <a href="{{ get_tag_link($tag->term_id) }}" class="taxonomy-term">
                        {{ $tag->name }}
                      </a>
                    @endforeach
                  </div>
                </div>
              @endif
            </div>
          @endif

          {{-- Timeline Mostre --}}
          @if($timeline_mostre && is_string($timeline_mostre))
            <div class="opera-timeline">
              <h2 class="opera-section-title">Mostre ed Esposizioni</h2>
              @php
                $lines = preg_split("/\r?\n/", (string) $timeline_mostre);
                $lines = is_array($lines) ? $lines : [];
                $mostre = array_slice(array_filter(array_map('trim', $lines)), 0, 100);
              @endphp
              <ul class="timeline-list">
                @foreach($mostre as $mostra)
                  <li class="timeline-item">{{ trim($mostra) }}</li>
                @endforeach
              </ul>
            </div>
          @endif

          {{-- Action Buttons --}}
          <div class="opera-actions">
            @if($link_processo)
              <a href="{{ $link_processo }}" target="_blank" rel="noopener noreferrer" class="button button--primary">
                Guarda il Processo Creativo
              </a>
            @endif

            @if($disponibile)
              <a href="{{ home_url('/contatti') }}" class="button button--secondary">
                Richiedi Informazioni o Acquista
              </a>
            @endif
          </div>

          {{-- Navigation --}}
          @php
            $previous = get_previous_post();
            $next = get_next_post();
          @endphp

          @if($previous || $next)
            <nav class="opera-navigation" aria-label="Navigazione opere">
              <div class="opera-nav-grid">
                @if($previous)
                  <a href="{{ get_permalink($previous) }}" class="opera-nav-link opera-nav-link--prev">
                    <span class="opera-nav-label">← Precedente</span>
                    <span class="opera-nav-title">{{ get_the_title($previous) }}</span>
                  </a>
                @else
                  <div></div>
                @endif

                <a href="{{ get_post_type_archive_link('post') ?: home_url('/') }}" class="opera-nav-link opera-nav-link--all">
                  <span class="opera-nav-label">Tutte le Opere</span>
                </a>

                @if($next)
                  <a href="{{ get_permalink($next) }}" class="opera-nav-link opera-nav-link--next">
                    <span class="opera-nav-label">Successiva →</span>
                    <span class="opera-nav-title">{{ get_the_title($next) }}</span>
                  </a>
                @else
                  <div></div>
                @endif
              </div>
            </nav>
          @endif
        </div>
      </section>
    </article>
  @endwhile
@endsection

@push('styles')
<style>
  /* Override to use modern sans-serif fonts */
  .single-opera h1,
  .single-opera h2,
  .single-opera h3 {
    font-family: var(--font-family-base);
    font-weight: var(--font-weight-light);
  }

  /* Hero Image Section */
  .opera-hero {
    position: relative;
    width: 100%;
    max-height: 85vh;
    background: var(--color-neutral-50);
    display: flex;
    align-items: center;
    justify-content: center;
    overflow: hidden;
  }

  .opera-image {
    width: 100%;
    height: auto;
    max-height: 85vh;
    object-fit: contain;
    display: block;
  }

  .opera-venduto-badge {
    position: absolute;
    top: var(--space-lg);
    right: var(--space-lg);
    background: rgba(0, 0, 0, 0.85);
    color: white;
    padding: var(--space-sm) var(--space-lg);
    font-size: var(--font-size-sm);
    font-weight: var(--font-weight-semibold);
    letter-spacing: 0.1em;
    border-radius: var(--radius-sm);
  }

  /* Details Section */
  .opera-details {
    padding-block: var(--space-3xl);
  }

  .opera-title {
    font-size: var(--font-size-4xl);
    font-weight: var(--font-weight-light);
    margin-block-end: var(--space-lg);
    color: var(--color-text-primary);
  }

  /* Metadata Grid */
  .opera-meta {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: var(--space-md);
    margin-block: var(--space-xl);
    padding-block: var(--space-lg);
    border-block: 1px solid var(--color-neutral-200);
  }

  .opera-meta-item {
    display: flex;
    flex-direction: column;
    gap: var(--space-3xs);
  }

  .opera-meta dt {
    font-size: var(--font-size-xs);
    font-weight: var(--font-weight-medium);
    text-transform: uppercase;
    letter-spacing: 0.05em;
    color: var(--color-text-secondary);
  }

  .opera-meta dd {
    font-size: var(--font-size-lg);
    font-weight: var(--font-weight-normal);
    color: var(--color-text-primary);
    margin: 0;
  }

  /* Description */
  .opera-description {
    margin-block: var(--space-xl);
    font-size: var(--font-size-lg);
    line-height: var(--line-height-relaxed);
    color: var(--color-text-primary);
  }

  /* Taxonomies */
  .opera-taxonomies {
    display: flex;
    flex-direction: column;
    gap: var(--space-md);
    margin-block: var(--space-xl);
  }

  .taxonomy-group {
    display: flex;
    flex-wrap: wrap;
    align-items: center;
    gap: var(--space-sm);
  }

  .taxonomy-label {
    font-size: var(--font-size-sm);
    font-weight: var(--font-weight-medium);
    color: var(--color-text-secondary);
  }

  .taxonomy-terms {
    display: flex;
    flex-wrap: wrap;
    gap: var(--space-xs);
  }

  .taxonomy-term {
    padding: var(--space-2xs) var(--space-sm);
    background: var(--color-neutral-100);
    border-radius: var(--radius-full);
    font-size: var(--font-size-sm);
    text-decoration: none;
    color: var(--color-text-primary);
    transition: all var(--duration-fast) var(--easing-out);
  }

  .taxonomy-term:hover {
    background: var(--color-accent-cta);
    color: white;
  }

  /* Timeline */
  .opera-timeline {
    margin-block: var(--space-2xl);
  }

  .opera-section-title {
    font-size: var(--font-size-2xl);
    font-weight: var(--font-weight-normal);
    margin-block-end: var(--space-lg);
    color: var(--color-text-primary);
  }

  .timeline-list {
    list-style: none;
    padding: 0;
    margin: 0;
  }

  .timeline-item {
    padding: var(--space-sm) 0;
    border-bottom: 1px solid var(--color-neutral-200);
    font-size: var(--font-size-base);
    line-height: var(--line-height-relaxed);
  }

  .timeline-item:last-child {
    border-bottom: none;
  }

  /* Action Buttons */
  .opera-actions {
    display: flex;
    flex-wrap: wrap;
    gap: var(--space-md);
    margin-block: var(--space-2xl);
  }

  .button {
    display: inline-flex;
    align-items: center;
    gap: var(--space-xs);
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

  .button--secondary {
    background: transparent;
    color: var(--color-text-primary);
    border: 2px solid var(--color-neutral-300);
  }

  .button--secondary:hover {
    background: var(--color-neutral-1000);
    color: white;
    border-color: var(--color-neutral-1000);
  }

  /* Navigation */
  .opera-navigation {
    margin-block-start: var(--space-3xl);
    padding-block-start: var(--space-xl);
    border-top: 1px solid var(--color-neutral-200);
  }

  .opera-nav-grid {
    display: grid;
    grid-template-columns: 1fr auto 1fr;
    gap: var(--space-md);
    align-items: center;
  }

  .opera-nav-link {
    display: flex;
    flex-direction: column;
    gap: var(--space-3xs);
    text-decoration: none;
    padding: var(--space-md);
    border-radius: var(--radius-md);
    transition: background var(--duration-fast) var(--easing-out);
  }

  .opera-nav-link:hover {
    background: var(--color-neutral-50);
  }

  .opera-nav-link--prev {
    text-align: left;
  }

  .opera-nav-link--next {
    text-align: right;
  }

  .opera-nav-link--all {
    text-align: center;
    justify-content: center;
  }

  .opera-nav-label {
    font-size: var(--font-size-xs);
    font-weight: var(--font-weight-medium);
    text-transform: uppercase;
    letter-spacing: 0.05em;
    color: var(--color-text-secondary);
  }

  .opera-nav-title {
    font-size: var(--font-size-base);
    color: var(--color-text-primary);
  }

  /* Mobile Responsive */
  @media (max-width: 640px) {
    .opera-hero {
      max-height: 60vh;
    }

    .opera-title {
      font-size: var(--font-size-3xl);
    }

    .opera-meta {
      grid-template-columns: 1fr;
    }

    .opera-nav-grid {
      grid-template-columns: 1fr;
      gap: var(--space-sm);
    }

    .opera-nav-link--prev,
    .opera-nav-link--next,
    .opera-nav-link--all {
      text-align: center;
    }

    .opera-venduto-badge {
      top: var(--space-sm);
      right: var(--space-sm);
      padding: var(--space-xs) var(--space-md);
    }
  }

  /* Tablet */
  @media (min-width: 641px) and (max-width: 1024px) {
    .opera-nav-grid {
      grid-template-columns: 1fr 1fr;
      gap: var(--space-md);
    }

    .opera-nav-link--all {
      grid-column: 1 / -1;
    }
  }
</style>
@endpush
