<article @php(post_class('card hover-lift'))>
  @if (has_post_thumbnail())
    <a href="{{ get_permalink() }}" class="block">
      {!! get_the_post_thumbnail(null, 'medium', ['class' => 'w-full h-auto', 'loading' => 'lazy']) !!}
    </a>
  @endif

  <div class="stack-md" style="padding: var(--space-lg);">
    <header>
      <h2 class="heading-3">
        <a href="{{ get_permalink() }}" class="transition-colors">
          {!! $title !!}
        </a>
      </h2>

      @includeWhen(get_post_type() === 'post', 'partials.entry-meta')
    </header>

    <div class="body-normal entry-summary">
      @php(the_excerpt())
    </div>

    <footer>
      <a href="{{ get_permalink() }}" class="button button--ghost button--sm">
        {{ __('Read more', 'sage') }} →
      </a>
    </footer>
  </div>
</article>
