@props([
    'hover' => false,
    'padding' => 'md',
])

@php
$classes = 'card';
if ($hover) {
    $classes .= ' card--hover';
}
if ($padding && $padding !== 'none') {
    $classes .= ' card--padding-' . $padding;
}
@endphp

<article {{ $attributes->merge(['class' => $classes]) }}>
  @isset($header)
    <header class="card__header">
      {{ $header }}
    </header>
  @endisset

  <div class="card__body">
    {{ $slot }}
  </div>

  @isset($footer)
    <footer class="card__footer">
      {{ $footer }}
    </footer>
  @endisset
</article>
