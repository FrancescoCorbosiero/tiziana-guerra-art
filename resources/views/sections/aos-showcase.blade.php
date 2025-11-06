{{--
  AOS (Animate On Scroll) Showcase Section

  Demonstrates:
  - Different animation types
  - Delays and durations
  - Easing functions
  - Using the animated-section component
--}}

<section class="aos-showcase section-padding" id="aos">
  <div class="container">
    {{-- Section Header --}}
    <header class="section-header" data-aos="fade-up">
      <span class="section-tag">AOS - Animate On Scroll</span>
      <h2 class="section-title text-gradient">Simple Scroll Animations</h2>
      <p class="section-description">
        Lightweight animations triggered by scrolling - perfect for content reveals
      </p>
    </header>

    {{-- Fade Animations --}}
    <div class="aos-demo-group">
      <h3 class="aos-demo-group__title" data-aos="fade-up">Fade Animations</h3>
      <div class="aos-grid">
        <div class="aos-card" data-aos="fade-up">
          <div class="aos-card__icon">↑</div>
          <h4>Fade Up</h4>
          <code>data-aos="fade-up"</code>
        </div>
        <div class="aos-card" data-aos="fade-down">
          <div class="aos-card__icon">↓</div>
          <h4>Fade Down</h4>
          <code>data-aos="fade-down"</code>
        </div>
        <div class="aos-card" data-aos="fade-left">
          <div class="aos-card__icon">←</div>
          <h4>Fade Left</h4>
          <code>data-aos="fade-left"</code>
        </div>
        <div class="aos-card" data-aos="fade-right">
          <div class="aos-card__icon">→</div>
          <h4>Fade Right</h4>
          <code>data-aos="fade-right"</code>
        </div>
      </div>
    </div>

    {{-- Zoom Animations --}}
    <div class="aos-demo-group">
      <h3 class="aos-demo-group__title" data-aos="fade-up">Zoom Animations</h3>
      <div class="aos-grid">
        <div class="aos-card" data-aos="zoom-in">
          <div class="aos-card__icon">⊕</div>
          <h4>Zoom In</h4>
          <code>data-aos="zoom-in"</code>
        </div>
        <div class="aos-card" data-aos="zoom-out">
          <div class="aos-card__icon">⊖</div>
          <h4>Zoom Out</h4>
          <code>data-aos="zoom-out"</code>
        </div>
        <div class="aos-card" data-aos="zoom-in-up">
          <div class="aos-card__icon">⇱</div>
          <h4>Zoom In Up</h4>
          <code>data-aos="zoom-in-up"</code>
        </div>
        <div class="aos-card" data-aos="zoom-in-down">
          <div class="aos-card__icon">⇲</div>
          <h4>Zoom In Down</h4>
          <code>data-aos="zoom-in-down"</code>
        </div>
      </div>
    </div>

    {{-- Flip Animations --}}
    <div class="aos-demo-group">
      <h3 class="aos-demo-group__title" data-aos="fade-up">Flip Animations</h3>
      <div class="aos-grid">
        <div class="aos-card" data-aos="flip-up">
          <div class="aos-card__icon">↻</div>
          <h4>Flip Up</h4>
          <code>data-aos="flip-up"</code>
        </div>
        <div class="aos-card" data-aos="flip-down">
          <div class="aos-card__icon">↺</div>
          <h4>Flip Down</h4>
          <code>data-aos="flip-down"</code>
        </div>
        <div class="aos-card" data-aos="flip-left">
          <div class="aos-card__icon">⟲</div>
          <h4>Flip Left</h4>
          <code>data-aos="flip-left"</code>
        </div>
        <div class="aos-card" data-aos="flip-right">
          <div class="aos-card__icon">⟳</div>
          <h4>Flip Right</h4>
          <code>data-aos="flip-right"</code>
        </div>
      </div>
    </div>

    {{-- Timing Variations --}}
    <div class="aos-demo-group">
      <h3 class="aos-demo-group__title" data-aos="fade-up">Duration & Delay</h3>
      <div class="timing-demo">
        <div class="timing-card" data-aos="fade-up" data-aos-duration="400">
          <div class="timing-card__badge">400ms</div>
          <h4>Fast</h4>
          <code>data-aos-duration="400"</code>
        </div>
        <div class="timing-card" data-aos="fade-up" data-aos-duration="800">
          <div class="timing-card__badge">800ms</div>
          <h4>Medium</h4>
          <code>data-aos-duration="800"</code>
        </div>
        <div class="timing-card" data-aos="fade-up" data-aos-duration="1200">
          <div class="timing-card__badge">1200ms</div>
          <h4>Slow</h4>
          <code>data-aos-duration="1200"</code>
        </div>
      </div>

      <div class="timing-demo" style="margin-top: var(--space-xl)">
        <div class="timing-card" data-aos="fade-up" data-aos-delay="0">
          <div class="timing-card__badge">0ms</div>
          <h4>No Delay</h4>
          <code>data-aos-delay="0"</code>
        </div>
        <div class="timing-card" data-aos="fade-up" data-aos-delay="200">
          <div class="timing-card__badge">+200ms</div>
          <h4>Delay 200</h4>
          <code>data-aos-delay="200"</code>
        </div>
        <div class="timing-card" data-aos="fade-up" data-aos-delay="400">
          <div class="timing-card__badge">+400ms</div>
          <h4>Delay 400</h4>
          <code>data-aos-delay="400"</code>
        </div>
      </div>
    </div>

    {{-- Using Component --}}
    <div class="aos-demo-group">
      <h3 class="aos-demo-group__title" data-aos="fade-up">Using Component</h3>
      <div class="component-demo">
        <x-animated-section animation="fade-up" :delay="100">
          <div class="component-showcase">
            <sl-icon name="code-square" style="font-size: 3rem; color: var(--color-brand-primary);"></sl-icon>
            <h4>Animated Section Component</h4>
            <p>Use <code>&lt;x-animated-section&gt;</code> for easy AOS integration</p>
          </div>
        </x-animated-section>

        <x-animated-section animation="zoom-in" :delay="200" :duration="1000">
          <div class="component-showcase">
            <sl-icon name="lightning" style="font-size: 3rem; color: var(--color-brand-primary);"></sl-icon>
            <h4>Customizable</h4>
            <p>Control animation type, delay, duration, and easing</p>
          </div>
        </x-animated-section>

        <x-animated-section animation="flip-left" :delay="300">
          <div class="component-showcase">
            <sl-icon name="star" style="font-size: 3rem; color: var(--color-brand-primary);"></sl-icon>
            <h4>Simple to Use</h4>
            <p>Wrap your content and let AOS handle the rest</p>
          </div>
        </x-animated-section>
      </div>
    </div>

    {{-- Code Example --}}
    <div class="code-showcase" data-aos="fade-up">
      <h3 class="code-showcase__title">How It Works</h3>
      <pre class="code-block"><code class="language-html">&lt;!-- Basic usage --&gt;
&lt;div data-aos="fade-up"&gt;
  Content animates on scroll
&lt;/div&gt;

&lt;!-- With duration and delay --&gt;
&lt;div
  data-aos="zoom-in"
  data-aos-duration="800"
  data-aos-delay="200"
&gt;
  Delayed zoom animation
&lt;/div&gt;

&lt;!-- Using component --&gt;
&lt;x-animated-section
  animation="fade-up"
  :delay="200"
  :duration="600"
&gt;
  Your content here
&lt;/x-animated-section&gt;</code></pre>
    </div>
  </div>
</section>

<style>
.aos-showcase {
  background: var(--color-surface-raised);
}

.aos-demo-group {
  margin-bottom: var(--space-3xl);
}

.aos-demo-group__title {
  font-size: var(--font-size-2xl);
  font-weight: var(--font-weight-bold);
  margin-bottom: var(--space-xl);
  text-align: center;
  color: var(--color-brand-primary);
}

.aos-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
  gap: var(--space-lg);
  margin-bottom: var(--space-xl);
}

.aos-card {
  background: var(--color-surface-base);
  padding: var(--space-xl);
  border-radius: var(--radius-lg);
  text-align: center;
  border: 2px solid var(--color-neutral-200);
  transition: transform var(--duration-base), border-color var(--duration-base);
}

[data-theme="dark"] .aos-card {
  border-color: var(--color-neutral-800);
}

.aos-card:hover {
  transform: translateY(-4px);
  border-color: var(--color-brand-primary);
}

.aos-card__icon {
  font-size: 3rem;
  color: var(--color-brand-primary);
  margin-bottom: var(--space-md);
  font-weight: bold;
}

.aos-card h4 {
  font-size: var(--font-size-lg);
  margin-bottom: var(--space-sm);
}

.aos-card code {
  background: var(--color-neutral-800);
  color: var(--color-brand-secondary);
  padding: var(--space-2xs) var(--space-xs);
  border-radius: var(--radius-sm);
  font-family: var(--font-family-mono);
  font-size: var(--font-size-xs);
  display: inline-block;
}

.timing-demo {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
  gap: var(--space-lg);
}

.timing-card {
  background: var(--color-surface-base);
  padding: var(--space-xl);
  border-radius: var(--radius-lg);
  text-align: center;
  position: relative;
  border: 2px solid var(--color-neutral-200);
}

[data-theme="dark"] .timing-card {
  border-color: var(--color-neutral-800);
}

.timing-card__badge {
  position: absolute;
  top: var(--space-sm);
  right: var(--space-sm);
  background: var(--color-brand-primary);
  color: white;
  padding: var(--space-2xs) var(--space-sm);
  border-radius: var(--radius-full);
  font-size: var(--font-size-xs);
  font-weight: var(--font-weight-semibold);
}

.timing-card h4 {
  font-size: var(--font-size-xl);
  margin-bottom: var(--space-sm);
}

.timing-card code {
  background: var(--color-neutral-800);
  color: var(--color-brand-secondary);
  padding: var(--space-2xs) var(--space-xs);
  border-radius: var(--radius-sm);
  font-family: var(--font-family-mono);
  font-size: var(--font-size-xs);
  display: inline-block;
}

.component-demo {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
  gap: var(--space-xl);
}

.component-showcase {
  background: var(--color-surface-base);
  padding: var(--space-2xl);
  border-radius: var(--radius-lg);
  text-align: center;
  border: 2px solid var(--color-neutral-200);
}

[data-theme="dark"] .component-showcase {
  border-color: var(--color-neutral-800);
}

.component-showcase h4 {
  font-size: var(--font-size-xl);
  margin: var(--space-md) 0 var(--space-sm);
}

.component-showcase p {
  color: var(--color-text-secondary);
}

.component-showcase code {
  background: var(--color-neutral-800);
  color: var(--color-brand-secondary);
  padding: var(--space-2xs) var(--space-xs);
  border-radius: var(--radius-sm);
  font-family: var(--font-family-mono);
  font-size: var(--font-size-xs);
}

@media (max-width: 768px) {
  .aos-grid {
    grid-template-columns: 1fr;
  }

  .timing-demo {
    grid-template-columns: 1fr;
  }

  .component-demo {
    grid-template-columns: 1fr;
  }
}
</style>
