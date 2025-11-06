@props([
    'title' => '',
    'description' => '',
    'buttonText' => '',
    'buttonHref' => '#',
    'variant' => 'centered',
])

@php
$classes = 'cta cta--' . $variant;
@endphp

<section {{ $attributes->merge(['class' => $classes]) }}>
  <div class="container">
    <div class="cta__content">
      @if($variant === 'centered')
        <h2 class="cta__title">{{ $title }}</h2>
        @if($description)
          <p class="cta__description">{{ $description }}</p>
        @endif
        @if($buttonText)
          <div class="cta__actions">
            <x-button variant="primary" size="lg" :href="$buttonHref">
              {{ $buttonText }}
            </x-button>
          </div>
        @endif
      @else
        <div class="cta__text">
          <h2 class="cta__title">{{ $title }}</h2>
          @if($description)
            <p class="cta__description">{{ $description }}</p>
          @endif
        </div>
        @if($buttonText)
          <div class="cta__actions">
            <x-button variant="primary" size="lg" :href="$buttonHref">
              {{ $buttonText }}
            </x-button>
          </div>
        @endif
      @endif

      {{ $slot }}
    </div>
  </div>
</section>
