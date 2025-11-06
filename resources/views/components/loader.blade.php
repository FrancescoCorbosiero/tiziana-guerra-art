{{--
  Page Loader Component
  Amazing GSAP-animated loader for first page visit
--}}

<div
  id="page-loader"
  class="page-loader"
  aria-hidden="true"
  data-loader
>
  <div class="page-loader__content">
    {{-- Animated Logo/Brand --}}
    <div class="loader-brand">
      @if(has_custom_logo())
        <div class="loader-logo" data-loader-logo>
          {!! get_custom_logo() !!}
        </div>
      @else
        <div class="loader-text" data-loader-text>
          <span class="loader-text__word">
            @foreach(str_split(get_bloginfo('name')) as $char)
              <span class="loader-text__char">{{ $char }}</span>
            @endforeach
          </span>
        </div>
      @endif
    </div>

    {{-- Loading Progress --}}
    <div class="loader-progress" data-loader-progress>
      <div class="loader-progress__bar">
        <div class="loader-progress__fill" data-loader-progress-fill></div>
      </div>
      <div class="loader-progress__percentage" data-loader-percentage>
        <span data-loader-counter>0</span>%
      </div>
    </div>

    {{-- Animated Shapes (decorative) --}}
    <div class="loader-shapes" aria-hidden="true">
      <div class="loader-shape loader-shape--1" data-loader-shape></div>
      <div class="loader-shape loader-shape--2" data-loader-shape></div>
      <div class="loader-shape loader-shape--3" data-loader-shape></div>
      <div class="loader-shape loader-shape--4" data-loader-shape></div>
    </div>

    {{-- Loading Text --}}
    <div class="loader-status" data-loader-status>
      <span data-loader-status-text>Loading Experience</span>
      <span class="loader-dots">
        <span class="loader-dot"></span>
        <span class="loader-dot"></span>
        <span class="loader-dot"></span>
      </span>
    </div>
  </div>

  {{-- Overlay Background --}}
  <div class="page-loader__overlay" data-loader-overlay></div>
</div>
