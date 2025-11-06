@props([
    'variant' => 'primary',
    'size' => 'base',
    'href' => null,
    'type' => 'button',
    'icon' => null,
    'iconPosition' => 'left',
])

@php
$classes = 'button';
$classes .= ' button--' . $variant;
if ($size !== 'base') {
    $classes .= ' button--' . $size;
}
@endphp

@if($href)
  <a href="{{ $href }}" {{ $attributes->merge(['class' => $classes]) }}>
    @if($icon && $iconPosition === 'left')
      <span class="button__icon">{!! $icon !!}</span>
    @endif
    {{ $slot }}
    @if($icon && $iconPosition === 'right')
      <span class="button__icon">{!! $icon !!}</span>
    @endif
  </a>
@else
  <button type="{{ $type }}" {{ $attributes->merge(['class' => $classes]) }}>
    @if($icon && $iconPosition === 'left')
      <span class="button__icon">{!! $icon !!}</span>
    @endif
    {{ $slot }}
    @if($icon && $iconPosition === 'right')
      <span class="button__icon">{!! $icon !!}</span>
    @endif
  </button>
@endif
