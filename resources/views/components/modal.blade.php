@props([
    'id' => 'modal-' . uniqid(),
    'title' => '',
    'size' => 'md',
])

@php
$dialogClasses = 'modal__dialog';
if ($size !== 'md') {
    $dialogClasses .= ' modal__dialog--' . $size;
}
@endphp

<div
  x-data="{ open: false }"
  x-on:keydown.escape.window="open = false"
  {{ $attributes }}
>
  {{-- Backdrop --}}
  <div
    x-show="open"
    x-transition.opacity
    @click="open = false"
    class="modal-backdrop"
    style="display: none;"
  ></div>

  {{-- Modal --}}
  <div
    x-show="open"
    x-transition
    class="modal"
    role="dialog"
    aria-modal="true"
    aria-labelledby="{{ $id }}-title"
    style="display: none;"
  >
    <div class="{{ $dialogClasses }}" @click.stop>
      {{-- Header --}}
      <header class="modal__header">
        <h2 id="{{ $id }}-title" class="modal__title">
          {{ $title }}
        </h2>
        <button
          type="button"
          @click="open = false"
          class="modal__close"
          aria-label="{{ __('Close modal', 'sage') }}"
        >
          <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor">
            <path d="M18 6L6 18M6 6l12 12" stroke-width="2" stroke-linecap="round"/>
          </svg>
        </button>
      </header>

      {{-- Body --}}
      <div class="modal__body">
        {{ $slot }}
      </div>

      {{-- Footer (optional) --}}
      @isset($footer)
        <footer class="modal__footer">
          {{ $footer }}
        </footer>
      @endisset
    </div>
  </div>
</div>
