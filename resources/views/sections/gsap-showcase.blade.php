{{--
  GSAP Animations Showcase Section

  Demonstrates:
  - Scroll-triggered animations
  - Stagger effects
  - Parallax scrolling
  - Pin/Scrub effects
  - Timeline animations
--}}

<section class="gsap-showcase section-padding" id="gsap">
  <div class="container">
    {{-- Section Header --}}
    <header class="section-header" data-aos="fade-up">
      <span class="section-tag">GSAP + ScrollTrigger</span>
      <h2 class="section-title text-gradient">Professional Animations</h2>
      <p class="section-description">
        Harness the power of GSAP for stunning, performant animations
      </p>
    </header>

    {{-- Parallax Demo --}}
    <div class="gsap-demo gsap-demo--parallax">
      <h3 class="gsap-demo__title" data-aos="fade-up">Parallax Effect</h3>
      <div class="parallax-container">
        <div class="parallax-layer parallax-layer--back"></div>
        <div class="parallax-layer parallax-layer--middle"></div>
        <div class="parallax-layer parallax-layer--front">
          <h4>Scroll to see parallax magic</h4>
        </div>
      </div>
    </div>

    {{-- Stagger Animation Demo --}}
    <div class="gsap-demo gsap-demo--stagger">
      <h3 class="gsap-demo__title" data-aos="fade-up">Stagger Animation</h3>
      <div class="stagger-grid" id="stagger-demo">
        @for($i = 1; $i <= 12; $i++)
          <div class="stagger-item">
            <div class="stagger-item__icon">{{ $i }}</div>
            <h4 class="stagger-item__title">Item {{ $i }}</h4>
            <p class="stagger-item__text">Animates in sequence</p>
          </div>
        @endfor
      </div>
    </div>

    {{-- Fade & Slide Demo --}}
    <div class="gsap-demo gsap-demo--fade-slide">
      <div class="fade-slide-content" id="fade-slide-demo">
        <div class="feature-box">
          <sl-icon name="lightning" class="feature-box__icon"></sl-icon>
          <h3>Lightning Fast</h3>
          <p>GSAP uses advanced optimization for 60fps animations</p>
        </div>
        <div class="feature-box">
          <sl-icon name="gear" class="feature-box__icon"></sl-icon>
          <h3>Highly Customizable</h3>
          <p>Control every aspect of your animations with ease</p>
        </div>
        <div class="feature-box">
          <sl-icon name="star" class="feature-box__icon"></sl-icon>
          <h3>Industry Standard</h3>
          <p>Trusted by major brands and developers worldwide</p>
        </div>
      </div>
    </div>

    {{-- Rotating Element Demo --}}
    <div class="gsap-demo gsap-demo--rotate">
      <h3 class="gsap-demo__title" data-aos="fade-up">Rotation on Scroll</h3>
      <div class="rotate-container">
        <div class="rotate-element" id="rotate-demo">
          <svg viewBox="0 0 100 100" class="rotate-svg">
            <circle cx="50" cy="50" r="45" fill="none" stroke="currentColor" stroke-width="2"/>
            <path d="M50 10 L50 30 M50 70 L50 90 M10 50 L30 50 M70 50 L90 50" stroke="currentColor" stroke-width="2"/>
          </svg>
        </div>
      </div>
    </div>

    {{-- Code Examples --}}
    <div class="code-showcase" data-aos="fade-up">
      <h3 class="code-showcase__title">How It Works</h3>
      <div class="code-tabs">
        <pre class="code-block"><code class="language-javascript">// Fade in on scroll
GSAPUtils.fadeInOnScroll('.element', {
  y: 50,
  duration: 0.8,
  stagger: 0.2
});

// Parallax effect
GSAPUtils.parallax('.bg-layer', 0.5);

// Stagger animation
GSAPUtils.staggerOnScroll('#container', '.item');

// Rotate on scroll
GSAPUtils.rotateOnScroll('#element', 360);</code></pre>
      </div>
    </div>
  </div>
</section>

{{-- Note: GSAP animations are initialized in resources/js/libraries/showcase-init.js --}}

<style>
.gsap-showcase {
  background: linear-gradient(to bottom, var(--color-surface-base), var(--color-surface-raised));
  position: relative;
}

.gsap-demo {
  margin-bottom: var(--space-3xl);
  padding: var(--space-xl);
  background: var(--color-surface-overlay);
  border-radius: var(--radius-xl);
}

.gsap-demo__title {
  font-size: var(--font-size-2xl);
  font-weight: var(--font-weight-bold);
  margin-bottom: var(--space-lg);
  text-align: center;
  color: var(--color-brand-primary);
}

/* Parallax Demo */
.parallax-container {
  position: relative;
  height: 400px;
  overflow: hidden;
  border-radius: var(--radius-lg);
}

.parallax-layer {
  position: absolute;
  width: 100%;
  height: 100%;
  display: flex;
  align-items: center;
  justify-content: center;
}

.parallax-layer--back {
  background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
  opacity: 0.3;
}

.parallax-layer--middle {
  background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
  opacity: 0.3;
}

.parallax-layer--front {
  color: white;
  font-size: var(--font-size-3xl);
  font-weight: var(--font-weight-bold);
  text-align: center;
  text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);
}

/* Stagger Grid */
.stagger-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
  gap: var(--space-lg);
}

.stagger-item {
  background: var(--color-surface-base);
  padding: var(--space-lg);
  border-radius: var(--radius-lg);
  text-align: center;
  border: 2px solid transparent;
  transition: border-color var(--duration-base);
}

.stagger-item:hover {
  border-color: var(--color-brand-primary);
}

.stagger-item__icon {
  width: 60px;
  height: 60px;
  margin: 0 auto var(--space-md);
  background: var(--color-brand-primary);
  color: white;
  border-radius: var(--radius-full);
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: var(--font-size-2xl);
  font-weight: var(--font-weight-bold);
}

.stagger-item__title {
  font-size: var(--font-size-lg);
  margin-bottom: var(--space-xs);
}

.stagger-item__text {
  font-size: var(--font-size-sm);
  color: var(--color-text-secondary);
}

/* Fade Slide Demo */
.fade-slide-content {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
  gap: var(--space-xl);
}

.feature-box {
  background: var(--color-surface-base);
  padding: var(--space-xl);
  border-radius: var(--radius-lg);
  text-align: center;
  border: 1px solid var(--color-neutral-200);
}

[data-theme="dark"] .feature-box {
  border-color: var(--color-neutral-800);
}

.feature-box__icon {
  font-size: 3rem;
  color: var(--color-brand-primary);
  margin-bottom: var(--space-md);
}

.feature-box h3 {
  font-size: var(--font-size-xl);
  margin-bottom: var(--space-sm);
}

.feature-box p {
  color: var(--color-text-secondary);
}

/* Rotate Demo */
.rotate-container {
  display: flex;
  justify-content: center;
  padding: var(--space-3xl) 0;
}

.rotate-element {
  width: 200px;
  height: 200px;
}

.rotate-svg {
  width: 100%;
  height: 100%;
  color: var(--color-brand-primary);
}

/* Code Showcase */
.code-showcase {
  background: var(--color-surface-overlay);
  padding: var(--space-xl);
  border-radius: var(--radius-xl);
  margin-top: var(--space-2xl);
}

.code-showcase__title {
  font-size: var(--font-size-2xl);
  font-weight: var(--font-weight-bold);
  margin-bottom: var(--space-lg);
  color: var(--color-brand-primary);
}

.code-block {
  background: var(--color-neutral-900);
  color: var(--color-neutral-100);
  padding: var(--space-lg);
  border-radius: var(--radius-md);
  overflow-x: auto;
  font-family: var(--font-family-mono);
  font-size: var(--font-size-sm);
  line-height: var(--line-height-relaxed);
}

.section-padding {
  padding: var(--space-3xl) 0;
}

.section-header {
  text-align: center;
  margin-bottom: var(--space-3xl);
}

.section-tag {
  display: inline-block;
  background: var(--color-brand-primary);
  color: white;
  padding: var(--space-xs) var(--space-md);
  border-radius: var(--radius-full);
  font-size: var(--font-size-sm);
  font-weight: var(--font-weight-semibold);
  text-transform: uppercase;
  letter-spacing: var(--letter-spacing-wide);
  margin-bottom: var(--space-md);
}

.section-title {
  font-size: var(--font-size-4xl);
  font-weight: var(--font-weight-bold);
  margin-bottom: var(--space-md);
}

.section-description {
  font-size: var(--font-size-xl);
  color: var(--color-text-secondary);
  max-width: 600px;
  margin: 0 auto;
}

@media (max-width: 768px) {
  .stagger-grid {
    grid-template-columns: 1fr;
  }

  .fade-slide-content {
    grid-template-columns: 1fr;
  }
}
</style>
