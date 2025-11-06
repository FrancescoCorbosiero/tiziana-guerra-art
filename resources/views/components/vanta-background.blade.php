@props([
  'effect' => 'waves',
  'color' => '#1a365d',
  'id' => 'vanta-bg',
])

<div
  id="{{ $id }}"
  {{ $attributes->merge(['class' => 'vanta-background']) }}
  data-vanta-effect="{{ $effect }}"
  data-vanta-color="{{ $color }}"
>
  {{ $slot }}
</div>

<style>
.vanta-background {
  position: relative;
  isolation: isolate;
  min-height: 100vh;
  width: 100%;
}

.vanta-background > canvas {
  position: absolute !important;
  inset: 0;
  z-index: -1;
}

.vanta-background > * {
  position: relative;
  z-index: 1;
}
</style>

@push('scripts')
<script>
  // Initialize Vanta after page load for this specific instance
  document.addEventListener('DOMContentLoaded', () => {
    const vantaElement = document.getElementById('{{ $id }}')
    if (vantaElement && typeof initVanta === 'function') {
      initVanta('#{{ $id }}')
    }
  })
</script>
@endpush
