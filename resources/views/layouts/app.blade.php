<!doctype html>
<html @php(language_attributes()) data-theme="{{ $theme }}" @if($isRtl) dir="rtl" @endif>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    {{-- SEO Meta Tags --}}
    {!! $metaTags !!}

    {{-- Schema.org Markup --}}
    {!! $schemaMarkup !!}

    @php(do_action('get_header'))
    @php(wp_head())

    @vite(['resources/css/app.css', 'resources/js/app.js'])
  </head>

  <body @php(body_class())>
    @php(wp_body_open())

    {{-- Page Loader --}}
    @include('components.loader')

    <div id="app">
      {{-- Skip to content link for accessibility --}}
      <a class="skip-link sr-only focus:not-sr-only" href="#main">
        {{ __('Skip to content', 'sage') }}
      </a>

      {{-- Header --}}
      @include('sections.header')

      <main id="main" class="main" role="main">
        @yield('content')
      </main>

      @hasSection('sidebar')
        <aside class="sidebar" role="complementary">
          @yield('sidebar')
        </aside>
      @endif

      {{-- Footer --}}
      @include('sections.footer')
    </div>

    @php(do_action('get_footer'))
    @php(wp_footer())

    {{-- Component Scripts Stack --}}
    @stack('scripts')
  </body>
</html>
