@props([
    'title' => '',
    'description' => '',
    'features' => [],
    'columns' => 3,
])

@php
$gridClass = 'features__grid';
if ($columns && $columns !== 'auto') {
    $gridClass .= ' features__grid--' . $columns;
}
@endphp

<section {{ $attributes->merge(['class' => 'features']) }}>
  <div class="container">
    @if($title || $description)
      <header class="features__header">
        @if($title)
          <h2 class="features__title">{{ $title }}</h2>
        @endif
        @if($description)
          <p class="features__description">{{ $description }}</p>
        @endif
      </header>
    @endif

    <div class="{{ $gridClass }}">
      @foreach($features as $feature)
        <article class="feature">
          @if(!empty($feature['icon']))
            <div class="feature__icon">
              {!! $feature['icon'] !!}
            </div>
          @endif

          @if(!empty($feature['title']))
            <h3 class="feature__title">{{ $feature['title'] }}</h3>
          @endif

          @if(!empty($feature['description']))
            <p class="feature__description">{{ $feature['description'] }}</p>
          @endif
        </article>
      @endforeach
    </div>

    {{ $slot }}
  </div>
</section>
