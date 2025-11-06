@extends('layouts.app')

@section('content')
  @while(have_posts()) @php(the_post())
    <article @php(post_class('single-post'))>
      {{-- Hero section with featured image --}}
      @if(has_post_thumbnail())
        <section class="post-featured-image">
          <div class="featured-image-wrapper">
            {!! get_the_post_thumbnail(null, 'large', ['class' => 'featured-image', 'loading' => 'eager']) !!}
          </div>
        </section>
      @endif

      <div class="post-container container container--md">
        {{-- Post Header --}}
        <header class="post-header">
          @php
            $categories = get_the_category();
            $primary_category = !empty($categories) ? $categories[0] : null;
          @endphp

          @if($primary_category)
            <div class="post-category">
              <a href="{{ get_category_link($primary_category->term_id) }}" class="category-link">
                {{ $primary_category->name }}
              </a>
            </div>
          @endif

          <h1 class="post-title">{!! get_the_title() !!}</h1>

          <div class="post-meta">
            <time class="post-date" datetime="{{ get_post_time('c', true) }}">
              {{ get_the_date('j F Y') }}
            </time>

            @if(get_the_author())
              <span class="meta-separator">•</span>
              <span class="post-author">
                {{ get_the_author() }}
              </span>
            @endif

            @php
              $reading_time = ceil(str_word_count(strip_tags(get_the_content())) / 200);
            @endphp
            @if($reading_time > 0)
              <span class="meta-separator">•</span>
              <span class="reading-time">
                {{ $reading_time }} {{ $reading_time === 1 ? 'minuto' : 'minuti' }} di lettura
              </span>
            @endif
          </div>
        </header>

        {{-- Post Content --}}
        <div class="post-content">
          @php(the_content())
        </div>

        {{-- Post Footer --}}
        <footer class="post-footer">
          {{-- Tags --}}
          @php($tags = get_the_tags())
          @if($tags)
            <div class="post-tags">
              <span class="tags-label">Tag:</span>
              <div class="tags-list">
                @foreach($tags as $tag)
                  <a href="{{ get_tag_link($tag->term_id) }}" class="tag-link">
                    {{ $tag->name }}
                  </a>
                @endforeach
              </div>
            </div>
          @endif

          {{-- Author Bio --}}
          @if(get_the_author_meta('description'))
            <div class="author-bio">
              <div class="author-avatar">
                {!! get_avatar(get_the_author_meta('ID'), 80) !!}
              </div>
              <div class="author-info">
                <h3 class="author-name">{{ get_the_author() }}</h3>
                <p class="author-description">{{ get_the_author_meta('description') }}</p>
              </div>
            </div>
          @endif

          {{-- Post Navigation --}}
          @php
            $previous = get_previous_post();
            $next = get_next_post();
          @endphp

          @if($previous || $next)
            <nav class="post-navigation" aria-label="Navigazione articoli">
              @if($previous)
                <a href="{{ get_permalink($previous) }}" class="post-nav-link post-nav-link--prev">
                  <span class="nav-label">← Articolo precedente</span>
                  <span class="nav-title">{{ get_the_title($previous) }}</span>
                </a>
              @endif

              @if($next)
                <a href="{{ get_permalink($next) }}" class="post-nav-link post-nav-link--next">
                  <span class="nav-label">Articolo successivo →</span>
                  <span class="nav-title">{{ get_the_title($next) }}</span>
                </a>
              @endif
            </nav>
          @endif
        </footer>

        {{-- Comments --}}
        @if(comments_open() || get_comments_number())
          <div class="post-comments">
            @php(comments_template())
          </div>
        @endif
      </div>
    </article>
  @endwhile
@endsection

@push('styles')
<style>
  /* Override to use modern sans-serif fonts */
  .single-post h1,
  .single-post h2,
  .single-post h3,
  .single-post h4,
  .single-post h5,
  .single-post h6 {
    font-family: var(--font-family-base);
  }

  .single-post h1 {
    font-weight: var(--font-weight-light);
  }

  .single-post h2,
  .single-post h3 {
    font-weight: var(--font-weight-normal);
  }

  /* Featured Image Section */
  .post-featured-image {
    width: 100%;
    margin-block-end: var(--space-2xl);
  }

  .featured-image-wrapper {
    width: 100%;
    max-height: 70vh;
    overflow: hidden;
    display: flex;
    align-items: center;
    justify-content: center;
    background: var(--color-neutral-50);
  }

  .featured-image {
    width: 100%;
    height: auto;
    max-height: 70vh;
    object-fit: cover;
    display: block;
  }

  /* Post Container */
  .post-container {
    padding-block: var(--space-2xl);
  }

  /* Post Header */
  .post-header {
    margin-block-end: var(--space-2xl);
    text-align: center;
  }

  .post-category {
    margin-block-end: var(--space-md);
  }

  .category-link {
    display: inline-block;
    padding: var(--space-2xs) var(--space-sm);
    background: var(--color-accent-cta);
    color: white;
    font-size: var(--font-size-xs);
    font-weight: var(--font-weight-medium);
    text-transform: uppercase;
    letter-spacing: 0.05em;
    text-decoration: none;
    border-radius: var(--radius-sm);
    transition: background var(--duration-fast) var(--easing-out);
  }

  .category-link:hover {
    background: color-mix(in oklch, var(--color-accent-cta), black 15%);
  }

  .post-title {
    font-size: var(--font-size-4xl);
    font-weight: var(--font-weight-light);
    line-height: var(--line-height-tight);
    margin-block: var(--space-md);
    color: var(--color-text-primary);
  }

  .post-meta {
    display: flex;
    align-items: center;
    justify-content: center;
    flex-wrap: wrap;
    gap: var(--space-xs);
    font-size: var(--font-size-sm);
    color: var(--color-text-secondary);
  }

  .meta-separator {
    color: var(--color-neutral-400);
  }

  /* Post Content */
  .post-content {
    font-size: var(--font-size-lg);
    line-height: var(--line-height-relaxed);
    color: var(--color-text-primary);
  }

  .post-content > * + * {
    margin-block-start: var(--space-md);
  }

  .post-content h2 {
    font-size: var(--font-size-2xl);
    margin-block-start: var(--space-xl);
    margin-block-end: var(--space-md);
  }

  .post-content h3 {
    font-size: var(--font-size-xl);
    margin-block-start: var(--space-lg);
    margin-block-end: var(--space-sm);
  }

  .post-content p {
    margin-block: var(--space-md);
  }

  .post-content img {
    max-width: 100%;
    height: auto;
    border-radius: var(--radius-md);
    margin-block: var(--space-lg);
  }

  .post-content blockquote {
    padding: var(--space-lg);
    margin-block: var(--space-xl);
    margin-inline: 0;
    border-left: 4px solid var(--color-accent-cta);
    background: var(--color-neutral-50);
    font-style: italic;
    font-size: var(--font-size-lg);
  }

  .post-content ul,
  .post-content ol {
    padding-inline-start: var(--space-lg);
    margin-block: var(--space-md);
  }

  .post-content li {
    margin-block: var(--space-xs);
  }

  /* Post Footer */
  .post-footer {
    margin-block-start: var(--space-3xl);
    padding-block-start: var(--space-xl);
    border-top: 1px solid var(--color-neutral-200);
  }

  /* Tags */
  .post-tags {
    display: flex;
    flex-wrap: wrap;
    align-items: center;
    gap: var(--space-sm);
    margin-block-end: var(--space-2xl);
  }

  .tags-label {
    font-size: var(--font-size-sm);
    font-weight: var(--font-weight-medium);
    color: var(--color-text-secondary);
  }

  .tags-list {
    display: flex;
    flex-wrap: wrap;
    gap: var(--space-xs);
  }

  .tag-link {
    padding: var(--space-2xs) var(--space-sm);
    background: var(--color-neutral-100);
    border-radius: var(--radius-full);
    font-size: var(--font-size-sm);
    text-decoration: none;
    color: var(--color-text-primary);
    transition: all var(--duration-fast) var(--easing-out);
  }

  .tag-link:hover {
    background: var(--color-neutral-1000);
    color: white;
  }

  /* Author Bio */
  .author-bio {
    display: flex;
    gap: var(--space-lg);
    padding: var(--space-xl);
    margin-block: var(--space-2xl);
    background: var(--color-neutral-50);
    border-radius: var(--radius-md);
  }

  .author-avatar {
    flex-shrink: 0;
  }

  .author-avatar img {
    width: 80px;
    height: 80px;
    border-radius: var(--radius-full);
  }

  .author-info {
    flex: 1;
  }

  .author-name {
    font-size: var(--font-size-xl);
    font-weight: var(--font-weight-normal);
    margin-block-end: var(--space-xs);
    color: var(--color-text-primary);
  }

  .author-description {
    font-size: var(--font-size-base);
    line-height: var(--line-height-normal);
    color: var(--color-text-secondary);
    margin: 0;
  }

  /* Post Navigation */
  .post-navigation {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
    gap: var(--space-lg);
    margin-block-start: var(--space-2xl);
  }

  .post-nav-link {
    display: flex;
    flex-direction: column;
    gap: var(--space-xs);
    padding: var(--space-lg);
    background: var(--color-neutral-50);
    border-radius: var(--radius-md);
    text-decoration: none;
    transition: all var(--duration-fast) var(--easing-out);
  }

  .post-nav-link:hover {
    background: var(--color-neutral-100);
    transform: translateY(-2px);
  }

  .post-nav-link--next {
    text-align: right;
  }

  .nav-label {
    font-size: var(--font-size-xs);
    font-weight: var(--font-weight-medium);
    text-transform: uppercase;
    letter-spacing: 0.05em;
    color: var(--color-text-secondary);
  }

  .nav-title {
    font-size: var(--font-size-lg);
    font-weight: var(--font-weight-normal);
    color: var(--color-text-primary);
  }

  /* Comments */
  .post-comments {
    margin-block-start: var(--space-3xl);
    padding-block-start: var(--space-2xl);
    border-top: 1px solid var(--color-neutral-200);
  }

  /* Mobile Responsive */
  @media (max-width: 640px) {
    .post-title {
      font-size: var(--font-size-3xl);
    }

    .post-meta {
      flex-direction: column;
      gap: var(--space-2xs);
    }

    .meta-separator {
      display: none;
    }

    .post-content {
      font-size: var(--font-size-base);
    }

    .author-bio {
      flex-direction: column;
      text-align: center;
    }

    .post-navigation {
      grid-template-columns: 1fr;
    }

    .post-nav-link--next {
      text-align: left;
    }

    .featured-image-wrapper {
      max-height: 50vh;
    }
  }

  /* Tablet */
  @media (min-width: 641px) and (max-width: 1024px) {
    .post-title {
      font-size: var(--font-size-3xl);
    }

    .featured-image-wrapper {
      max-height: 60vh;
    }
  }
</style>
@endpush
