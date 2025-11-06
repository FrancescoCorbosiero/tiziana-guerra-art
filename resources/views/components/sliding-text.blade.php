{{--
  Sliding Text Component

  Animated horizontal text slider with customizable direction, words, and styling.

  Props:
  - direction: 'ltr' (left to right) or 'rtl' (right to left)
  - words: Array of words to display
  - separator: Character between words (default: '✦')
  - outline: Boolean - use outline text style
  - speed: Animation duration in seconds (default: 30)
  - className: Additional CSS classes
--}}

@props([
    'direction' => 'ltr',
    'words' => [],
    'separator' => '✦',
    'outline' => true,
    'speed' => 30,
    'className' => '',
])

@php
    // Default words if none provided
    if (empty($words)) {
        $words = $direction === 'ltr'
            ? ['INNOVAZIONE', 'CREATIVITÀ', 'ECCELLENZA', 'PASSIONE', 'RISULTATI']
            : ['WEB DESIGN', 'BRANDING', 'E-COMMERCE', 'SEO', 'MARKETING'];
    }

    // Set separator based on direction or use provided
    if ($separator === '✦' && $direction === 'rtl') {
        $separator = '●';
    }
@endphp

<div class="sliding-text-track {{ $className }}" data-direction="{{ $direction }}" role="marquee">
    <div class="sliding-text-track__content {{ $direction === 'rtl' ? 'sliding-text-track__content--reverse' : '' }}"
         style="--animation-duration: {{ $speed }}s;">
        @foreach($words as $word)
            <span class="sliding-text-track__word {{ $outline ? 'sliding-text-track__word--outline' : '' }}">{{ $word }}</span>
            <span class="sliding-text-track__separator" aria-hidden="true">{{ $separator }}</span>
        @endforeach
    </div>
    <div class="sliding-text-track__content {{ $direction === 'rtl' ? 'sliding-text-track__content--reverse' : '' }}"
         aria-hidden="true"
         style="--animation-duration: {{ $speed }}s;">
        @foreach($words as $word)
            <span class="sliding-text-track__word {{ $outline ? 'sliding-text-track__word--outline' : '' }}">{{ $word }}</span>
            <span class="sliding-text-track__separator" aria-hidden="true">{{ $separator }}</span>
        @endforeach
    </div>
</div>

{{--
  Usage Examples:
  ----------------
  Basic LTR:
  <x-sliding-text />

  RTL with outline:
  <x-sliding-text direction="rtl" :outline="true" />

  Custom words and speed:
  <x-sliding-text
      :words="['DESIGN', 'CODE', 'LAUNCH']"
      separator="⚡"
      :speed="20"
  />

  With custom class:
  <x-sliding-text
      className="my-custom-slider"
      direction="rtl"
  />
--}}

{{-- Styles for this component are in /resources/css/components/_sliding-text.css --}}
