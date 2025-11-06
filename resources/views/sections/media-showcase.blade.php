{{--
  Media Showcase Section

  Demonstrates:
  - Swiper carousel
  - PhotoSwipe gallery
  - Alpine.js carousel controller
--}}

<section class="media-showcase section-padding" id="media">
  <div class="container">
    {{-- Section Header --}}
    <header class="section-header" data-aos="fade-up">
      <span class="section-tag">Swiper + PhotoSwipe</span>
      <h2 class="section-title text-gradient">Media Components</h2>
      <p class="section-description">
        Beautiful carousels and lightbox galleries for stunning media presentations
      </p>
    </header>

    {{-- Swiper Carousel Demo --}}
    <div class="media-demo" data-aos="fade-up">
      <h3 class="media-demo__title">Swiper Carousel</h3>
      <p class="media-demo__description">
        Touch-enabled, responsive carousels with smooth transitions
      </p>

      <x-carousel
        :slides="[
          [
            'title' => 'GSAP Animations',
            'content' => 'Professional-grade animations with ScrollTrigger for stunning scroll effects',
            'image' => 'https://picsum.photos/800/400?random=1',
            'link' => ['url' => '#gsap', 'text' => 'Learn More']
          ],
          [
            'title' => 'AOS Scroll Effects',
            'content' => 'Lightweight scroll animations that bring your content to life',
            'image' => 'https://picsum.photos/800/400?random=2',
            'link' => ['url' => '#aos', 'text' => 'Explore']
          ],
          [
            'title' => 'Shoelace Components',
            'content' => 'Modern web components for beautiful UI elements',
            'image' => 'https://picsum.photos/800/400?random=3',
            'link' => ['url' => '#shoelace', 'text' => 'View Components']
          ],
          [
            'title' => 'Vanta.js Backgrounds',
            'content' => 'Animated 3D backgrounds powered by Three.js',
            'image' => 'https://picsum.photos/800/400?random=4',
            'link' => ['url' => '#hero-vanta', 'text' => 'See Demo']
          ],
          [
            'title' => 'PhotoSwipe Galleries',
            'content' => 'Elegant image lightboxes with zoom and navigation',
            'image' => 'https://picsum.photos/800/400?random=5',
            'link' => ['url' => '#gallery', 'text' => 'View Gallery']
          ]
        ]"
        class="showcase-carousel"
      />

      {{-- Code Example --}}
      <div class="code-showcase" style="margin-top: var(--space-xl);">
        <h4>Usage</h4>
        <pre class="code-block"><code class="language-blade">&lt;x-carousel
  :slides="[
    [
      'title' => 'Slide Title',
      'content' => 'Description here',
      'image' => '/path/to/image.jpg',
      'link' => ['url' => '/page', 'text' => 'Learn More']
    ],
    // More slides...
  ]"
/&gt;</code></pre>
      </div>
    </div>

    {{-- PhotoSwipe Gallery Demo --}}
    <div class="media-demo" data-aos="fade-up" id="gallery">
      <h3 class="media-demo__title">PhotoSwipe Gallery</h3>
      <p class="media-demo__description">
        Click any image to open in full-screen lightbox with zoom and navigation
      </p>

      <x-gallery
        :images="[
          [
            'full' => 'https://picsum.photos/1920/1080?random=10',
            'thumbnail' => 'https://picsum.photos/400/300?random=10',
            'width' => 1920,
            'height' => 1080,
            'alt' => 'Stunning landscape',
            'caption' => 'Beautiful mountain vista'
          ],
          [
            'full' => 'https://picsum.photos/1920/1080?random=11',
            'thumbnail' => 'https://picsum.photos/400/300?random=11',
            'width' => 1920,
            'height' => 1080,
            'alt' => 'Urban architecture',
            'caption' => 'Modern city skyline'
          ],
          [
            'full' => 'https://picsum.photos/1920/1080?random=12',
            'thumbnail' => 'https://picsum.photos/400/300?random=12',
            'width' => 1920,
            'height' => 1080,
            'alt' => 'Nature photography',
            'caption' => 'Serene forest path'
          ],
          [
            'full' => 'https://picsum.photos/1920/1080?random=13',
            'thumbnail' => 'https://picsum.photos/400/300?random=13',
            'width' => 1920,
            'height' => 1080,
            'alt' => 'Ocean waves',
            'caption' => 'Coastal sunset'
          ],
          [
            'full' => 'https://picsum.photos/1920/1080?random=14',
            'thumbnail' => 'https://picsum.photos/400/300?random=14',
            'width' => 1920,
            'height' => 1080,
            'alt' => 'Desert landscape',
            'caption' => 'Golden sand dunes'
          ],
          [
            'full' => 'https://picsum.photos/1920/1080?random=15',
            'thumbnail' => 'https://picsum.photos/400/300?random=15',
            'width' => 1920,
            'height' => 1080,
            'alt' => 'Mountain peak',
            'caption' => 'Snow-capped summit'
          ]
        ]"
        :columns="3"
        class="showcase-gallery"
      />

      {{-- Code Example --}}
      <div class="code-showcase" style="margin-top: var(--space-xl);">
        <h4>Usage</h4>
        <pre class="code-block"><code class="language-blade">&lt;x-gallery
  :images="[
    [
      'full' => '/full-size.jpg',
      'thumbnail' => '/thumb.jpg',
      'width' => 1920,
      'height' => 1080,
      'alt' => 'Image description',
      'caption' => 'Optional caption'
    ],
    // More images...
  ]"
  :columns="3"
/&gt;</code></pre>
      </div>
    </div>

    {{-- Features Grid --}}
    <div class="features-grid" data-aos="fade-up">
      <div class="feature-item">
        <sl-icon name="hand-index" class="feature-item__icon"></sl-icon>
        <h4>Touch Enabled</h4>
        <p>Swipe gestures on mobile and touch devices</p>
      </div>
      <div class="feature-item">
        <sl-icon name="arrows-angle-expand" class="feature-item__icon"></sl-icon>
        <h4>Responsive</h4>
        <p>Adapts perfectly to any screen size</p>
      </div>
      <div class="feature-item">
        <sl-icon name="lightning" class="feature-item__icon"></sl-icon>
        <h4>Performant</h4>
        <p>Smooth 60fps animations</p>
      </div>
      <div class="feature-item">
        <sl-icon name="keyboard" class="feature-item__icon"></sl-icon>
        <h4>Keyboard Navigation</h4>
        <p>Full keyboard support for accessibility</p>
      </div>
    </div>
  </div>
</section>

<style>
.media-showcase {
  background: linear-gradient(to bottom, var(--color-surface-base), var(--color-surface-overlay));
}

.media-demo {
  margin-bottom: var(--space-3xl);
  padding: var(--space-2xl);
  background: var(--color-surface-base);
  border-radius: var(--radius-xl);
  box-shadow: var(--shadow-lg);
}

.media-demo__title {
  font-size: var(--font-size-3xl);
  font-weight: var(--font-weight-bold);
  margin-bottom: var(--space-md);
  color: var(--color-brand-primary);
}

.media-demo__description {
  font-size: var(--font-size-lg);
  color: var(--color-text-secondary);
  margin-bottom: var(--space-2xl);
}

.showcase-carousel {
  margin-bottom: var(--space-xl);
  box-shadow: var(--shadow-xl);
}

.showcase-carousel .swiper-slide {
  display: flex;
  flex-direction: column;
}

.showcase-carousel .swiper-slide-image {
  width: 100%;
  height: 400px;
  object-fit: cover;
}

.showcase-carousel .swiper-slide-content {
  padding: var(--space-xl);
  background: var(--color-surface-raised);
  flex: 1;
  display: flex;
  flex-direction: column;
  justify-content: center;
}

.showcase-carousel .swiper-slide-title {
  font-size: var(--font-size-2xl);
  font-weight: var(--font-weight-bold);
  margin-bottom: var(--space-md);
  color: var(--color-brand-primary);
}

.showcase-carousel .swiper-slide-text {
  font-size: var(--font-size-lg);
  color: var(--color-text-secondary);
  margin-bottom: var(--space-lg);
  line-height: var(--line-height-relaxed);
}

.showcase-carousel .swiper-slide-link {
  display: inline-block;
  padding: var(--space-sm) var(--space-lg);
  background: var(--color-brand-primary);
  color: white;
  text-decoration: none;
  border-radius: var(--radius-md);
  font-weight: var(--font-weight-semibold);
  transition: transform var(--duration-base), box-shadow var(--duration-base);
  align-self: flex-start;
}

.showcase-carousel .swiper-slide-link:hover {
  transform: translateY(-2px);
  box-shadow: var(--shadow-lg);
}

.showcase-gallery {
  margin-bottom: var(--space-xl);
}

.features-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
  gap: var(--space-xl);
  margin-top: var(--space-3xl);
}

.feature-item {
  text-align: center;
  padding: var(--space-xl);
  background: var(--color-surface-base);
  border-radius: var(--radius-lg);
  border: 1px solid var(--color-neutral-200);
  transition: transform var(--duration-base), box-shadow var(--duration-base);
}

[data-theme="dark"] .feature-item {
  border-color: var(--color-neutral-800);
}

.feature-item:hover {
  transform: translateY(-4px);
  box-shadow: var(--shadow-lg);
}

.feature-item__icon {
  font-size: 3rem;
  color: var(--color-brand-primary);
  margin-bottom: var(--space-md);
}

.feature-item h4 {
  font-size: var(--font-size-xl);
  margin-bottom: var(--space-sm);
}

.feature-item p {
  color: var(--color-text-secondary);
}

.code-showcase h4 {
  font-size: var(--font-size-xl);
  font-weight: var(--font-weight-bold);
  margin-bottom: var(--space-md);
  color: var(--color-brand-primary);
}

@media (max-width: 768px) {
  .showcase-carousel .swiper-slide-image {
    height: 250px;
  }

  .features-grid {
    grid-template-columns: 1fr;
  }
}
</style>
