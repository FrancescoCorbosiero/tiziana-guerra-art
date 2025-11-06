@extends('layouts.app')

@section('content')
  @include('partials.page-header')

  <div class="container section">
    @if (! have_posts())
      <div class="text-center" style="max-width: 48rem; margin-inline: auto;">
        <div class="card" style="padding: var(--space-xl); background: var(--color-warning-light);">
          <p class="body-large" style="margin-block-end: var(--space-md);">
            {!! __('Sorry, no results were found.', 'sage') !!}
          </p>
          {!! get_search_form(false) !!}
        </div>
      </div>
    @else
      <div class="grid grid--auto gap-lg">
        @while(have_posts()) @php(the_post())
          @include('partials.content-search')
        @endwhile
      </div>

      @if (get_the_posts_navigation())
        <div style="margin-block-start: var(--space-xl);">
          {!! get_the_posts_navigation() !!}
        </div>
      @endif
    @endif
  </div>
@endsection
