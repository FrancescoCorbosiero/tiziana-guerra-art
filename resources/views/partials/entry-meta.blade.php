<div class="entry-meta body-small text-muted" style="display: flex; align-items: center; gap: var(--space-md); flex-wrap: wrap; margin-block: var(--space-sm);">
  <time class="dt-published" datetime="{{ get_post_time('c', true) }}">
    {{ get_the_date() }}
  </time>

  <span aria-hidden="true">•</span>

  <span>
    <span>{{ __('By', 'sage') }}</span>
    <a href="{{ get_author_posts_url(get_the_author_meta('ID')) }}" class="p-author h-card link">
      {{ get_the_author() }}
    </a>
  </span>

  @if (get_the_category_list(', '))
    <span aria-hidden="true">•</span>
    <span>{!! get_the_category_list(', ') !!}</span>
  @endif
</div>
