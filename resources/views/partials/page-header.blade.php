<header class="page-header section--sm text-center" style="background: var(--bg-secondary); border-block-end: 1px solid var(--border-color);">
  <div class="container">
    <h1 class="heading-1">{!! $title !!}</h1>

    @if (is_archive() && get_the_archive_description())
      <div class="body-large text-muted" style="margin-block-start: var(--space-md); max-width: 48rem; margin-inline: auto;">
        {!! get_the_archive_description() !!}
      </div>
    @endif
  </div>
</header>
