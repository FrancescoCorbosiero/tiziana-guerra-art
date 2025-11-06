{{--
  SHOWCASE Hero Section

  Features:
  - Vanta.js animated 3D background (WAVES effect)
  - GSAP scroll-triggered animations
  - Alpine.js counter animation
  - Responsive design
  - Accessibility compliant
--}}

<x-vanta-background
  id="hero-vanta"
  color="#1a365d"
  class="hero-showcase"
>
  <div class="hero-showcase__content container">
    {{-- Eyebrow --}}
    <p class="hero-showcase__eyebrow" data-aos="fade-up" data-aos-duration="600">
      🎨 Premium Libraries Integration
    </p>

    {{-- Main Heading with GSAP animation --}}
    <h1
      class="hero-showcase__title text-gradient"
      x-data="gsapTrigger"
    >
      <span class="line">Unlock the Power</span>
      <span class="line">of Modern Web</span>
      <span class="line">Animation</span>
    </h1>

    {{-- Subtitle --}}
    <p
      class="hero-showcase__subtitle"
      data-aos="fade-up"
      data-aos-delay="200"
      data-aos-duration="800"
    >
      Experience <strong>GSAP</strong>, <strong>AOS</strong>, <strong>Swiper</strong>,
      <strong>PhotoSwipe</strong>, <strong>Vanta.js</strong>, and <strong>Shoelace</strong>
      working together seamlessly.
    </p>

    {{-- CTA Buttons --}}
    <div
      class="hero-showcase__cta"
      data-aos="fade-up"
      data-aos-delay="400"
      data-aos-duration="1000"
    >
      <sl-button variant="primary" size="large" href="#features">
        Explore Features
        <sl-icon slot="suffix" name="arrow-down"></sl-icon>
      </sl-button>

      <sl-button variant="default" size="large" href="#gallery">
        View Gallery
        <sl-icon slot="suffix" name="images"></sl-icon>
      </sl-button>
    </div>

    {{-- Stats with Alpine.js counter animation --}}
    <div
      class="hero-showcase__stats"
      data-aos="fade-up"
      data-aos-delay="600"
    >
      <div class="stat" x-data="counterAnimation(6, 2)">
        <span class="stat__number" x-text="Math.round(value)">0</span>
        <span class="stat__label">Libraries</span>
      </div>

      <div class="stat" x-data="counterAnimation(50, 2.5)">
        <span class="stat__number" x-text="Math.round(value)">0</span>+
        <span class="stat__label">Components</span>
      </div>

      <div class="stat" x-data="counterAnimation(100, 2)">
        <span class="stat__number" x-text="Math.round(value)">0</span>%
        <span class="stat__label">Awesome</span>
      </div>
    </div>

    {{-- Scroll Indicator --}}
    <div class="hero-showcase__scroll" data-aos="fade-up" data-aos-delay="800">
      <div class="scroll-indicator">
        <div class="scroll-indicator__dot"></div>
      </div>
      <span class="scroll-indicator__text">Scroll to explore</span>
    </div>
  </div>
</x-vanta-background>

<style>
.hero-showcase {
  position: relative;
  min-height: 100vh;
  display: flex;
  align-items: center;
  justify-content: center;
  overflow: hidden;
  background: linear-gradient(135deg, #1a365d 0%, #0f2847 100%);
}

.hero-showcase__content {
  position: relative;
  z-index: 10;
  text-align: center;
  padding: var(--space-3xl) var(--space-md);
  max-width: 1200px;
  margin: 0 auto;
}

.hero-showcase__eyebrow {
  font-size: var(--font-size-lg);
  font-weight: var(--font-weight-medium);
  color: var(--color-brand-secondary);
  margin-bottom: var(--space-md);
  letter-spacing: var(--letter-spacing-wide);
  text-transform: uppercase;
}

.hero-showcase__title {
  font-size: clamp(2.5rem, 8vw, 6rem);
  font-weight: var(--font-weight-bold);
  line-height: var(--line-height-tight);
  margin-bottom: var(--space-lg);
  display: flex;
  flex-direction: column;
  gap: var(--space-sm);
}

.hero-showcase__title .line {
  display: block;
}

.hero-showcase__subtitle {
  font-size: var(--font-size-xl);
  color: var(--color-neutral-100);
  margin-bottom: var(--space-2xl);
  max-width: 800px;
  margin-left: auto;
  margin-right: auto;
  line-height: var(--line-height-relaxed);
}

.hero-showcase__subtitle strong {
  color: var(--color-brand-primary);
  font-weight: var(--font-weight-semibold);
}

.hero-showcase__cta {
  display: flex;
  gap: var(--space-md);
  justify-content: center;
  flex-wrap: wrap;
  margin-bottom: var(--space-3xl);
}

.hero-showcase__stats {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
  gap: var(--space-xl);
  max-width: 600px;
  margin: 0 auto var(--space-3xl);
  padding: var(--space-xl);
  background: rgba(255, 255, 255, 0.05);
  backdrop-filter: blur(10px);
  border-radius: var(--radius-xl);
  border: 1px solid rgba(255, 255, 255, 0.1);
}

.stat {
  display: flex;
  flex-direction: column;
  align-items: center;
  gap: var(--space-xs);
}

.stat__number {
  font-size: var(--font-size-4xl);
  font-weight: var(--font-weight-bold);
  color: var(--color-brand-primary);
  line-height: 1;
}

.stat__label {
  font-size: var(--font-size-sm);
  color: var(--color-neutral-300);
  text-transform: uppercase;
  letter-spacing: var(--letter-spacing-wide);
}

.hero-showcase__scroll {
  display: flex;
  flex-direction: column;
  align-items: center;
  gap: var(--space-sm);
}

.scroll-indicator {
  width: 24px;
  height: 40px;
  border: 2px solid rgba(255, 255, 255, 0.3);
  border-radius: 12px;
  position: relative;
  animation: scroll-bounce 2s ease-in-out infinite;
}

.scroll-indicator__dot {
  width: 6px;
  height: 6px;
  background: var(--color-brand-primary);
  border-radius: 50%;
  position: absolute;
  top: 8px;
  left: 50%;
  transform: translateX(-50%);
  animation: scroll-dot 2s ease-in-out infinite;
}

.scroll-indicator__text {
  font-size: var(--font-size-sm);
  color: var(--color-neutral-300);
  text-transform: uppercase;
  letter-spacing: var(--letter-spacing-wide);
}

@keyframes scroll-bounce {
  0%, 100% {
    transform: translateY(0);
  }
  50% {
    transform: translateY(10px);
  }
}

@keyframes scroll-dot {
  0% {
    opacity: 1;
    transform: translateX(-50%) translateY(0);
  }
  100% {
    opacity: 0;
    transform: translateX(-50%) translateY(20px);
  }
}

@media (max-width: 768px) {
  .hero-showcase__content {
    padding: var(--space-2xl) var(--space-md);
  }

  .hero-showcase__cta {
    flex-direction: column;
    align-items: stretch;
  }

  .hero-showcase__stats {
    grid-template-columns: 1fr;
  }
}
</style>
