@extends('layouts.app')

@section('content')
  @include('partials.page-header')

  <div class="container section">
    @if (have_posts())
      <div class="grid grid--auto gap-lg">
        @while (have_posts())
          @php(the_post())

          <article @php(post_class('card hover-lift'))>
            @if (has_post_thumbnail())
              <a href="{{ get_permalink() }}" class="block">
                {!! get_the_post_thumbnail(null, 'large', ['class' => 'w-full h-auto', 'loading' => 'lazy']) !!}
              </a>
            @endif

            <div class="stack-md" style="padding: var(--space-lg);">
              <header>
                <h2 class="heading-3">
                  <a href="{{ get_permalink() }}" class="transition-colors">
                    {!! $title !!}
                  </a>
                </h2>

                @include('partials.entry-meta')
              </header>

              <div class="body-normal">
                {!! get_the_excerpt() !!}
              </div>

              <footer>
                <a href="{{ get_permalink() }}" class="button button--ghost button--sm">
                  {{ __('Read more', 'sage') }} →
                </a>
              </footer>
            </div>
          </article>
        @endwhile
      </div>

      @if (get_the_posts_navigation())
        <nav class="pagination" style="margin-block-start: var(--space-xl);" aria-label="{{ __('Posts navigation', 'sage') }}">
          {!! get_the_posts_navigation() !!}
        </nav>
      @endif
    @else
      <div class="text-center">
        <div class="card" style="padding: var(--space-xl); max-width: 48rem; margin-inline: auto;">
          <p class="body-large">{{ __('Sorry, no posts were found.', 'sage') }}</p>
        </div>
      </div>
    @endif
  </div>
@endsection
