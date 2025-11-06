@props([
    'eyebrow' => null,
    'title' => '',
    'subtitle' => '',
    'buttons' => [],
    'background' => null,
    'overlay' => true,
    'overlayOpacity' => '0.5',
    'parallaxSpeed' => 0.3,
    'height' => 'full', // full, tall, medium, compact
    'alignment' => 'center', // left, center, right
    'animateTitle' => true,
    'animateSubtitle' => true,
    'titleDelay' => 0.2,
    'subtitleDelay' => 0.4,
])

@php
$classes = 'parallax-hero';
$classes .= ' parallax-hero--' . $height;
$classes .= ' parallax-hero--align-' . $alignment;

// Generate unique ID for this instance
$heroId = 'parallax-hero-' . uniqid();
$bgId = $heroId . '-bg';
$titleId = $heroId . '-title';
$subtitleId = $heroId . '-subtitle';
$contentId = $heroId . '-content';
@endphp

<section {{ $attributes->merge(['class' => $classes]) }} id="{{ $heroId }}">
  @if($background)
    <div class="parallax-hero__background" id="{{ $bgId }}">
      <img
        src="{{ $background }}"
        alt=""
        class="parallax-hero__image"
        loading="eager"
      >
      @if($overlay)
        <div
          class="parallax-hero__overlay"
          style="opacity: {{ $overlayOpacity }};"
        ></div>
      @endif
    </div>
  @endif

  <div class="container">
    <div class="parallax-hero__content" id="{{ $contentId }}">
      @if($eyebrow)
        <p class="parallax-hero__eyebrow" data-animate>{{ $eyebrow }}</p>
      @endif

      <h1 class="parallax-hero__title" id="{{ $titleId }}">
        {{ $title }}
      </h1>

      @if($subtitle)
        <p class="parallax-hero__subtitle" id="{{ $subtitleId }}">
          {{ $subtitle }}
        </p>
      @endif

      @if(!empty($buttons))
        <div class="parallax-hero__cta" data-animate>
          @foreach($buttons as $button)
            <x-button
              :variant="$button['variant'] ?? 'primary'"
              :href="$button['href'] ?? '#'"
              :size="$button['size'] ?? 'lg'"
            >
              {{ $button['text'] }}
            </x-button>
          @endforeach
        </div>
      @endif

      {{ $slot }}
    </div>
  </div>
</section>

@push('scripts')
<script>
(function() {
  function initParallaxHero{{ str_replace('-', '_', $heroId) }}() {
    if (!window.GSAPUtils) {
      console.warn('GSAPUtils not available yet, retrying...');
      setTimeout(initParallaxHero{{ str_replace('-', '_', $heroId) }}, 100);
      return;
    }

    try {
      @if($background)
      var bgElement = document.querySelector('#{{ $bgId }}');
      if (bgElement) {
        window.GSAPUtils.parallax('#{{ $bgId }}', {{ $parallaxSpeed }});
      }
      @endif

      @if($animateTitle)
      var titleElement = document.querySelector('#{{ $titleId }}');
      if (titleElement) {
        window.GSAPUtils.fadeInOnScroll('#{{ $titleId }}', {
          y: 100,
          opacity: 0,
          duration: 1.2,
          delay: {{ $titleDelay }}
        });
      }
      @endif

      @if($animateSubtitle && $subtitle)
      var subtitleElement = document.querySelector('#{{ $subtitleId }}');
      if (subtitleElement) {
        window.GSAPUtils.fadeInOnScroll('#{{ $subtitleId }}', {
          y: 50,
          opacity: 0,
          duration: 1,
          delay: {{ $subtitleDelay }}
        });
      }
      @endif
    } catch (error) {
      console.error('Error initializing parallax hero:', error);
    }
  }

  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initParallaxHero{{ str_replace('-', '_', $heroId) }});
  } else {
    initParallaxHero{{ str_replace('-', '_', $heroId) }}();
  }
})();
</script>
@endpush
