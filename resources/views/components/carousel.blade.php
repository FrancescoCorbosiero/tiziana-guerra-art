@props([
  'slides' => [],
  'autoplay' => true,
  'loop' => true,
  'speed' => 5000,
])

<div class="swiper" x-data="swiperController" {{ $attributes->merge(['class' => 'carousel-component']) }}>
  <div class="swiper-wrapper">
    @foreach($slides as $slide)
      <div class="swiper-slide">
        @if(isset($slide['image']))
          <img
            src="{{ $slide['image'] }}"
            alt="{{ $slide['title'] ?? '' }}"
            loading="lazy"
            class="swiper-slide-image"
          >
        @endif
        @if(isset($slide['title']) || isset($slide['content']))
          <div class="swiper-slide-content">
            @if(isset($slide['title']))
              <h3 class="swiper-slide-title">{{ $slide['title'] }}</h3>
            @endif
            @if(isset($slide['content']))
              <p class="swiper-slide-text">{{ $slide['content'] }}</p>
            @endif
            @if(isset($slide['link']))
              <a href="{{ $slide['link']['url'] ?? '#' }}" class="swiper-slide-link">
                {{ $slide['link']['text'] ?? 'Learn More' }}
              </a>
            @endif
          </div>
        @endif
      </div>
    @endforeach
  </div>

  <!-- Navigation -->
  <div class="swiper-button-prev"></div>
  <div class="swiper-button-next"></div>

  <!-- Pagination -->
  <div class="swiper-pagination"></div>
</div>
