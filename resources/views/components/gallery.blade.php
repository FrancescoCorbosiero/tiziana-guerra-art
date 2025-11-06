@props([
  'images' => [],
  'columns' => 3,
])

<div
  {{ $attributes->merge(['class' => 'gallery gallery-grid']) }}
  x-data="galleryController"
  style="--gallery-columns: {{ $columns }};"
>
  @foreach($images as $index => $image)
    <a
      href="{{ $image['full'] }}"
      data-pswp-width="{{ $image['width'] ?? 1200 }}"
      data-pswp-height="{{ $image['height'] ?? 800 }}"
      target="_blank"
      class="gallery-item"
    >
      <img
        src="{{ $image['thumbnail'] }}"
        alt="{{ $image['alt'] ?? '' }}"
        loading="lazy"
        class="gallery-image"
      >
      @if(isset($image['caption']))
        <span class="gallery-caption">{{ $image['caption'] }}</span>
      @endif
    </a>
  @endforeach
</div>

<style>
.gallery-grid {
  display: grid;
  grid-template-columns: repeat(var(--gallery-columns, 3), 1fr);
  gap: var(--space-md, 1rem);
  padding: var(--space-md, 1rem);
}

@media (max-width: 768px) {
  .gallery-grid {
    grid-template-columns: repeat(2, 1fr);
  }
}

@media (max-width: 480px) {
  .gallery-grid {
    grid-template-columns: 1fr;
  }
}

.gallery-item {
  position: relative;
  overflow: hidden;
  border-radius: var(--radius-md, 0.5rem);
  aspect-ratio: 1;
  display: block;
  cursor: pointer;
  transition: transform var(--duration-base, 0.25s) var(--easing-out, ease-out);
}

.gallery-item:hover {
  transform: scale(1.05);
}

.gallery-image {
  width: 100%;
  height: 100%;
  object-fit: cover;
  display: block;
}

.gallery-caption {
  position: absolute;
  bottom: 0;
  left: 0;
  right: 0;
  background: linear-gradient(to top, rgba(0, 0, 0, 0.8), transparent);
  color: white;
  padding: var(--space-sm, 0.5rem);
  font-size: var(--font-size-sm, 0.875rem);
  transform: translateY(100%);
  transition: transform var(--duration-base, 0.25s) var(--easing-out, ease-out);
}

.gallery-item:hover .gallery-caption {
  transform: translateY(0);
}
</style>
