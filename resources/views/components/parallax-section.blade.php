@props([
    'speed' => 0.5,
    'background' => null,
    'overlay' => false,
    'overlayOpacity' => '0.3',
    'trigger' => null, // Custom trigger selector
    'start' => 'top bottom',
    'end' => 'bottom top',
    'layers' => [], // Array of layer configs: [['speed' => 0.3, 'class' => 'layer-1'], ...]
])

@php
$classes = 'parallax-section';
$sectionId = 'parallax-section-' . uniqid();
$hasMultipleLayers = !empty($layers);
@endphp

<div {{ $attributes->merge(['class' => $classes]) }} id="{{ $sectionId }}">
  @if($background && !$hasMultipleLayers)
    <div class="parallax-section__background" id="{{ $sectionId }}-bg">
      <img
        src="{{ $background }}"
        alt=""
        class="parallax-section__image"
        loading="lazy"
      >
      @if($overlay)
        <div
          class="parallax-section__overlay"
          style="opacity: {{ $overlayOpacity }};"
        ></div>
      @endif
    </div>
  @endif

  @if($hasMultipleLayers)
    <div class="parallax-section__layers">
      @foreach($layers as $index => $layer)
        <div
          class="parallax-section__layer {{ $layer['class'] ?? '' }}"
          id="{{ $sectionId }}-layer-{{ $index }}"
          data-speed="{{ $layer['speed'] ?? 0.5 }}"
        >
          @if(isset($layer['image']))
            <img
              src="{{ $layer['image'] }}"
              alt="{{ $layer['alt'] ?? '' }}"
              loading="lazy"
            >
          @endif
          @if(isset($layer['content']))
            {!! $layer['content'] !!}
          @endif
        </div>
      @endforeach
    </div>
  @endif

  <div class="parallax-section__content">
    {{ $slot }}
  </div>
</div>

@push('scripts')
<script>
(function() {
  function initParallaxSection{{ str_replace('-', '_', $sectionId) }}() {
    if (!window.GSAPUtils) {
      console.warn('GSAPUtils not available yet, retrying...');
      setTimeout(initParallaxSection{{ str_replace('-', '_', $sectionId) }}, 100);
      return;
    }

    try {
      @if(!$hasMultipleLayers && $background)
      var bgElement = document.querySelector('#{{ $sectionId }}-bg');
      if (bgElement) {
        window.GSAPUtils.parallax('#{{ $sectionId }}-bg', {{ $speed }});
      }
      @endif

      @if($hasMultipleLayers)
      @foreach($layers as $index => $layer)
      var layerElement{{ $index }} = document.querySelector('#{{ $sectionId }}-layer-{{ $index }}');
      if (layerElement{{ $index }}) {
        window.GSAPUtils.parallax('#{{ $sectionId }}-layer-{{ $index }}', {{ $layer['speed'] ?? 0.5 }});
      }
      @endforeach
      @endif
    } catch (error) {
      console.error('Error initializing parallax section:', error);
    }
  }

  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initParallaxSection{{ str_replace('-', '_', $sectionId) }});
  } else {
    initParallaxSection{{ str_replace('-', '_', $sectionId) }}();
  }
})();
</script>
@endpush
