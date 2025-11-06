@props([
    'eyebrow' => null,
    'title' => '',
    'subtitle' => '',
    'buttons' => [],
    'image' => null,
])

@php
$classes = 'hero';
if ($image) {
    $classes .= ' hero--image';
}
$style = $image ? "background-image: url('{$image}');" : '';
@endphp

<section {{ $attributes->merge(['class' => $classes]) }} @if($style) style="{{ $style }}" @endif>
  <div class="container">
    <div class="hero__content">
      @if($eyebrow)
        <p class="hero__eyebrow">{{ $eyebrow }}</p>
      @endif

      <h1 class="hero__title">{{ $title }}</h1>

      @if($subtitle)
        <p class="hero__subtitle">{{ $subtitle }}</p>
      @endif

      @if(!empty($buttons))
        <div class="hero__cta">
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
