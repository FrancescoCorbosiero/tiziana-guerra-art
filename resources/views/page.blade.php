@extends('layouts.app')

@section('content')
  @while (have_posts())
    @php(the_post())

    <article @php(post_class('container'))>
      <header class="section--sm text-center">
        <h1 class="heading-1">{!! $title !!}</h1>

        @if (has_post_thumbnail())
          <div style="margin-block-start: var(--space-lg);">
            {!! get_the_post_thumbnail(null, 'large', ['class' => 'w-full h-auto']) !!}
          </div>
        @endif
      </header>

      <div class="container--md section">
        @include('partials.content-page')
      </div>
    </article>
  @endwhile
@endsection
