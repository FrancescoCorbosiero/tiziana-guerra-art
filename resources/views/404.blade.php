@extends('layouts.app')

@section('content')
  <div class="container container--md section min-h-screen flex items-center">
    <div class="text-center w-full">
      <h1 class="heading-1" style="font-size: var(--font-size-6xl); margin-block-end: var(--space-md);">
        404
      </h1>

      <p class="body-large" style="margin-block-end: var(--space-lg);">
        {{ __('Sorry, the page you are looking for could not be found.', 'sage') }}
      </p>

      <div class="stack-lg" style="max-width: 40rem; margin-inline: auto;">
        @include('forms.search')

        <div class="flex gap-md justify-center flex-wrap">
          <a href="{{ home_url('/') }}" class="button button--primary">
            {{ __('Go Home', 'sage') }}
          </a>
          <a href="{{ home_url('/blog') }}" class="button button--secondary">
            {{ __('View Blog', 'sage') }}
          </a>
        </div>
      </div>
    </div>
  </div>
@endsection
