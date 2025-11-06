@if (! post_password_required())
  <section id="comments" class="comments" style="margin-block-start: var(--space-xl); padding-block-start: var(--space-xl); border-block-start: 1px solid var(--border-color);">
    @if ($responses())
      <h2 class="heading-2" style="margin-block-end: var(--space-lg);">
        {!! $title !!}
      </h2>

      <ol class="comment-list stack-lg" style="list-style: none; padding: 0; margin: 0;">
        {!! $responses !!}
      </ol>

      @if ($paginated())
        <nav class="comment-pagination" style="margin-block-start: var(--space-lg);" aria-label="{{ __('Comments navigation', 'sage') }}">
          <ul class="pagination-list flex gap-sm" style="list-style: none; padding: 0; margin: 0;">
            @if ($previous())
              <li class="previous">
                {!! $previous !!}
              </li>
            @endif

            @if ($next())
              <li class="next">
                {!! $next !!}
              </li>
            @endif
          </ul>
        </nav>
      @endif
    @endif

    @if ($closed())
      <div class="card" style="padding: var(--space-md); background: var(--color-warning-light); border-inline-start: 4px solid var(--color-warning); margin-block-end: var(--space-lg);">
        <p class="body-normal" style="margin: 0;">
          {!! __('Comments are closed.', 'sage') !!}
        </p>
      </div>
    @endif

    @if (!$closed())
      <div class="comment-form-wrapper" style="margin-block-start: var(--space-xl);">
        <h3 class="heading-3" style="margin-block-end: var(--space-md);">
          {{ __('Leave a Comment', 'sage') }}
        </h3>
        @php(comment_form())
      </div>
    @endif
  </section>
@endif
