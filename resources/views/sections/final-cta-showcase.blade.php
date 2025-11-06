{{--
  Final CTA Showcase Section

  Features:
  - Alpine.js scroll progress
  - Call to action
  - Summary of libraries
  - Links to documentation
--}}

<section class="final-cta-showcase section-padding" id="get-started">
  {{-- Scroll Progress Bar --}}
  <div class="scroll-progress" x-data="scrollProgress">
    <div class="scroll-progress__bar" :style="`width: ${progress}%`"></div>
  </div>

  <div class="container">
    {{-- Main CTA --}}
    <div class="cta-content" data-aos="fade-up">
      <sl-icon name="rocket-takeoff" class="cta-icon"></sl-icon>

      <h2 class="cta-title text-gradient">
        Ready to Build Something Amazing?
      </h2>

      <p class="cta-description">
        You now have access to 6 powerful libraries working seamlessly together.
        Start creating stunning, performant web experiences today.
      </p>

      <div class="cta-buttons">
        <sl-button variant="primary" size="large" href="/docs/LIBRARIES.md">
          <sl-icon slot="prefix" name="book"></sl-icon>
          View Documentation
        </sl-button>

        <sl-button variant="default" size="large" href="#hero-vanta">
          <sl-icon slot="prefix" name="arrow-up"></sl-icon>
          Back to Top
        </sl-button>
      </div>
    </div>

    {{-- Libraries Summary --}}
    <div class="libraries-summary" data-aos="fade-up" data-aos-delay="200">
      <h3 class="libraries-summary__title">What's Included</h3>

      <div class="libraries-grid">
        <div class="library-card">
          <div class="library-card__header">
            <sl-icon name="activity"></sl-icon>
            <h4>GSAP</h4>
          </div>
          <p>Professional animations with ScrollTrigger</p>
          <ul class="library-features">
            <li>10+ utility functions</li>
            <li>Scroll-triggered animations</li>
            <li>Timeline controls</li>
          </ul>
        </div>

        <div class="library-card">
          <div class="library-card__header">
            <sl-icon name="eye"></sl-icon>
            <h4>AOS</h4>
          </div>
          <p>Lightweight scroll animations</p>
          <ul class="library-features">
            <li>Multiple animation types</li>
            <li>Customizable timing</li>
            <li>Mobile-optimized</li>
          </ul>
        </div>

        <div class="library-card">
          <div class="library-card__header">
            <sl-icon name="collection"></sl-icon>
            <h4>Swiper</h4>
          </div>
          <p>Touch-enabled carousels</p>
          <ul class="library-features">
            <li>Responsive design</li>
            <li>Multiple effects</li>
            <li>Navigation & pagination</li>
          </ul>
        </div>

        <div class="library-card">
          <div class="library-card__header">
            <sl-icon name="images"></sl-icon>
            <h4>PhotoSwipe</h4>
          </div>
          <p>Image lightbox gallery</p>
          <ul class="library-features">
            <li>Full-screen viewing</li>
            <li>Zoom & pan</li>
            <li>Keyboard navigation</li>
          </ul>
        </div>

        <div class="library-card">
          <div class="library-card__header">
            <sl-icon name="stars"></sl-icon>
            <h4>Vanta.js</h4>
          </div>
          <p>Animated 3D backgrounds</p>
          <ul class="library-features">
            <li>Multiple effects</li>
            <li>Three.js powered</li>
            <li>Customizable colors</li>
          </ul>
        </div>

        <div class="library-card">
          <div class="library-card__header">
            <sl-icon name="puzzle"></sl-icon>
            <h4>Shoelace</h4>
          </div>
          <p>Modern web components</p>
          <ul class="library-features">
            <li>50+ components</li>
            <li>Customizable themes</li>
            <li>Fully accessible</li>
          </ul>
        </div>
      </div>
    </div>

    {{-- Alpine.js Utilities Demo --}}
    <div class="alpine-demo" data-aos="fade-up" data-aos-delay="400">
      <h3 class="alpine-demo__title">Alpine.js Integration</h3>
      <p class="alpine-demo__description">
        All libraries integrate seamlessly with Alpine.js for reactive, interactive experiences
      </p>

      <div class="alpine-examples">
        <div class="alpine-example">
          <h4>Counter Animation</h4>
          <div class="counter-display" x-data="counterAnimation(999, 3)">
            <span class="counter-value" x-text="Math.round(value)">0</span>
          </div>
          <code>x-data="counterAnimation(999, 3)"</code>
        </div>

        <div class="alpine-example">
          <h4>Scroll Progress</h4>
          <div class="progress-display" x-data="scrollProgress">
            <div class="progress-circle">
              <span x-text="Math.round(progress)">0</span>%
            </div>
          </div>
          <code>x-data="scrollProgress"</code>
        </div>

        <div class="alpine-example">
          <h4>GSAP Trigger</h4>
          <div class="gsap-trigger-demo" x-data="gsapTrigger">
            <div class="trigger-item">1</div>
            <div class="trigger-item">2</div>
            <div class="trigger-item">3</div>
          </div>
          <code>x-data="gsapTrigger"</code>
        </div>
      </div>
    </div>

    {{-- Performance Stats --}}
    <div class="performance-stats" data-aos="fade-up" data-aos-delay="600">
      <div class="stat-card">
        <sl-icon name="lightning-charge"></sl-icon>
        <div class="stat-content">
          <span class="stat-number">~265KB</span>
          <span class="stat-label">Total Bundle (gzipped)</span>
        </div>
      </div>

      <div class="stat-card">
        <sl-icon name="speedometer"></sl-icon>
        <div class="stat-content">
          <span class="stat-number">60 FPS</span>
          <span class="stat-label">Smooth Animations</span>
        </div>
      </div>

      <div class="stat-card">
        <sl-icon name="check-circle"></sl-icon>
        <div class="stat-content">
          <span class="stat-number">100%</span>
          <span class="stat-label">Ready to Use</span>
        </div>
      </div>
    </div>
  </div>
</section>

<style>
.final-cta-showcase {
  background: linear-gradient(180deg, var(--color-surface-base) 0%, #1a365d 100%);
  color: white;
  position: relative;
  overflow: hidden;
}

/* Scroll Progress Bar */
.scroll-progress {
  position: fixed;
  top: 0;
  left: 0;
  right: 0;
  height: 4px;
  background: rgba(255, 255, 255, 0.1);
  z-index: 9999;
}

.scroll-progress__bar {
  height: 100%;
  background: var(--color-brand-primary);
  transition: width 0.1s ease-out;
}

/* Main CTA */
.cta-content {
  text-align: center;
  margin-bottom: var(--space-3xl);
  padding: var(--space-3xl) 0;
}

.cta-icon {
  font-size: 5rem;
  color: var(--color-brand-primary);
  margin-bottom: var(--space-lg);
  animation: float 3s ease-in-out infinite;
}

@keyframes float {
  0%, 100% { transform: translateY(0); }
  50% { transform: translateY(-20px); }
}

.cta-title {
  font-size: var(--font-size-5xl);
  font-weight: var(--font-weight-bold);
  margin-bottom: var(--space-lg);
  line-height: var(--line-height-tight);
}

.cta-description {
  font-size: var(--font-size-xl);
  color: var(--color-neutral-200);
  max-width: 700px;
  margin: 0 auto var(--space-2xl);
  line-height: var(--line-height-relaxed);
}

.cta-buttons {
  display: flex;
  gap: var(--space-lg);
  justify-content: center;
  flex-wrap: wrap;
}

/* Libraries Summary */
.libraries-summary {
  margin-bottom: var(--space-3xl);
}

.libraries-summary__title {
  font-size: var(--font-size-3xl);
  font-weight: var(--font-weight-bold);
  text-align: center;
  margin-bottom: var(--space-2xl);
  color: var(--color-brand-primary);
}

.libraries-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
  gap: var(--space-xl);
}

.library-card {
  background: rgba(255, 255, 255, 0.05);
  backdrop-filter: blur(10px);
  padding: var(--space-xl);
  border-radius: var(--radius-lg);
  border: 1px solid rgba(255, 255, 255, 0.1);
  transition: transform var(--duration-base), box-shadow var(--duration-base);
}

.library-card:hover {
  transform: translateY(-4px);
  box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
  border-color: var(--color-brand-primary);
}

.library-card__header {
  display: flex;
  align-items: center;
  gap: var(--space-md);
  margin-bottom: var(--space-md);
}

.library-card__header sl-icon {
  font-size: 2rem;
  color: var(--color-brand-primary);
}

.library-card__header h4 {
  font-size: var(--font-size-xl);
  font-weight: var(--font-weight-bold);
  margin: 0;
}

.library-card > p {
  color: var(--color-neutral-300);
  margin-bottom: var(--space-md);
}

.library-features {
  list-style: none;
  padding: 0;
  margin: 0;
}

.library-features li {
  padding: var(--space-xs) 0;
  color: var(--color-neutral-400);
  font-size: var(--font-size-sm);
  position: relative;
  padding-left: var(--space-lg);
}

.library-features li::before {
  content: '✓';
  position: absolute;
  left: 0;
  color: var(--color-brand-primary);
  font-weight: bold;
}

/* Alpine Demo */
.alpine-demo {
  background: rgba(255, 255, 255, 0.05);
  backdrop-filter: blur(10px);
  padding: var(--space-2xl);
  border-radius: var(--radius-xl);
  border: 1px solid rgba(255, 255, 255, 0.1);
  margin-bottom: var(--space-3xl);
}

.alpine-demo__title {
  font-size: var(--font-size-2xl);
  font-weight: var(--font-weight-bold);
  text-align: center;
  margin-bottom: var(--space-md);
  color: var(--color-brand-primary);
}

.alpine-demo__description {
  text-align: center;
  color: var(--color-neutral-300);
  margin-bottom: var(--space-2xl);
}

.alpine-examples {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
  gap: var(--space-xl);
}

.alpine-example {
  text-align: center;
}

.alpine-example h4 {
  font-size: var(--font-size-lg);
  margin-bottom: var(--space-md);
}

.alpine-example code {
  display: block;
  background: rgba(0, 0, 0, 0.3);
  padding: var(--space-sm);
  border-radius: var(--radius-sm);
  font-family: var(--font-family-mono);
  font-size: var(--font-size-xs);
  color: var(--color-brand-secondary);
  margin-top: var(--space-md);
}

.counter-display {
  background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
  padding: var(--space-2xl);
  border-radius: var(--radius-lg);
}

.counter-value {
  font-size: var(--font-size-5xl);
  font-weight: var(--font-weight-bold);
}

.progress-display {
  background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
  padding: var(--space-2xl);
  border-radius: var(--radius-lg);
}

.progress-circle {
  font-size: var(--font-size-4xl);
  font-weight: var(--font-weight-bold);
}

.gsap-trigger-demo {
  display: flex;
  gap: var(--space-md);
  justify-content: center;
  padding: var(--space-xl);
  background: linear-gradient(135deg, #a8edea 0%, #fed6e3 100%);
  border-radius: var(--radius-lg);
}

.trigger-item {
  width: 60px;
  height: 60px;
  background: white;
  color: #333;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: var(--font-size-2xl);
  font-weight: var(--font-weight-bold);
  border-radius: var(--radius-md);
  box-shadow: var(--shadow-lg);
}

/* Performance Stats */
.performance-stats {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
  gap: var(--space-xl);
}

.stat-card {
  background: rgba(255, 255, 255, 0.05);
  backdrop-filter: blur(10px);
  padding: var(--space-xl);
  border-radius: var(--radius-lg);
  border: 1px solid rgba(255, 255, 255, 0.1);
  display: flex;
  align-items: center;
  gap: var(--space-lg);
}

.stat-card sl-icon {
  font-size: 3rem;
  color: var(--color-brand-primary);
  flex-shrink: 0;
}

.stat-content {
  display: flex;
  flex-direction: column;
}

.stat-number {
  font-size: var(--font-size-3xl);
  font-weight: var(--font-weight-bold);
  line-height: 1;
  margin-bottom: var(--space-xs);
  color: var(--color-brand-primary);
}

.stat-label {
  font-size: var(--font-size-sm);
  color: var(--color-neutral-300);
}

@media (max-width: 768px) {
  .cta-title {
    font-size: var(--font-size-3xl);
  }

  .libraries-grid {
    grid-template-columns: 1fr;
  }

  .alpine-examples {
    grid-template-columns: 1fr;
  }

  .performance-stats {
    grid-template-columns: 1fr;
  }

  .cta-buttons {
    flex-direction: column;
  }
}
</style>
