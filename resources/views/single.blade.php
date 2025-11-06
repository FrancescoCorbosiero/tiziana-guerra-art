@extends('layouts.app')

@section('content')
  @while (have_posts())
    @php(the_post())

    <article @php(post_class('container'))>
      <header class="section--sm text-center">
        <h1 class="heading-1">{!! $title !!}</h1>

        @include('partials.entry-meta')

        @if (has_post_thumbnail())
          <div style="margin-block-start: var(--space-lg);">
            {!! get_the_post_thumbnail(null, 'large', ['class' => 'w-full h-auto']) !!}
          </div>
        @endif
      </header>

      <div class="container--md section">
        @include('partials.content-single')
      </div>

      <footer class="container--md section--sm">
        @php(the_tags('<div class="flex gap-sm flex-wrap"><strong>' . __('Tags:', 'sage') . '</strong> ', ', ', '</div>'))

        @if (comments_open() || get_comments_number())
          <div style="margin-block-start: var(--space-xl);">
            @php(comments_template())
          </div>
        @endif
      </footer>

      @if (get_previous_post() || get_next_post())
        <nav class="container--md section--sm flex justify-between" aria-label="{{ __('Post navigation', 'sage') }}">
          @if ($previous = get_previous_post())
            <a href="{{ get_permalink($previous) }}" class="button button--secondary">
              ← {{ __('Previous', 'sage') }}
            </a>
          @endif

          @if ($next = get_next_post())
            <a href="{{ get_permalink($next) }}" class="button button--secondary">
              {{ __('Next', 'sage') }} →
            </a>
          @endif
        </nav>
      @endif
    </article>
  @endwhile
@endsection
