{{--
  Template Name: Component Demo
  Description: Demonstrates all new plug-and-play components
--}}

@extends('layouts.app')

@section('content')

{{-- ============================================
     DEMO 1: Basic Parallax Hero (Subtle parallax)
     ============================================ --}}

<x-parallax-hero
  title="Welcome to Component Heaven"
  subtitle="Build stunning websites in minutes, not hours"
  background="https://images.unsplash.com/photo-1451187580459-43490279c0fa?w=1920&q=80"
  parallaxSpeed="0.0"
  :buttons="[
    ['text' => 'Get Started', 'href' => '#demo', 'variant' => 'primary', 'size' => 'lg'],
    ['text' => 'View Docs', 'href' => '#docs', 'variant' => 'secondary', 'size' => 'lg']
  ]"
/>


{{-- ============================================
     DEMO 2: Parallax Hero with Eyebrow (Subtle parallax)
     ============================================ --}}

<x-parallax-hero
  eyebrow="New Release"
  title="Design Without Limits"
  subtitle="Experience the power of CSS4-first architecture with pre-built components"
  background="https://images.unsplash.com/photo-1557683316-973673baf926?w=1920&q=80"
  height="tall"
  alignment="center"
  parallaxSpeed="0.2"
  overlayOpacity="0.7"
  :buttons="[
    ['text' => 'Start Free Trial', 'href' => '#trial', 'variant' => 'primary'],
    ['text' => 'Watch Demo', 'href' => '#demo', 'variant' => 'ghost']
  ]"
/>


{{-- ============================================
     DEMO 3: Parallax Section with Cards
     ============================================ --}}

<x-parallax-section
  background="https://images.unsplash.com/photo-1517694712202-14dd9538aa97?w=1920&q=80"
  speed="0.25"
  overlay="true"
  overlayOpacity="0.8"
>
  <div class="container section section--lg">
    <header class="text-center stack-xl">
      <h2 class="display-2" style="color: var(--color-neutral-0);">
        Powerful Features
      </h2>
      <p class="body-large mx-auto" style="color: var(--color-neutral-100); max-width: 45rem;">
        Everything you need to build modern web experiences
      </p>
    </header>

    <div class="grid grid--3 gap-lg">
      <x-card padding="lg" hover>
        <x-slot:header>
          <h3 class="heading-4">CSS4-First</h3>
        </x-slot:header>
        <p class="body-normal">Modern CSS features like OKLCH colors, container queries, and CSS layers.</p>
      </x-card>

      <x-card padding="lg" hover>
        <x-slot:header>
          <h3 class="heading-4">GSAP Animations</h3>
        </x-slot:header>
        <p class="body-normal">Professional scroll-triggered animations with one-line utilities.</p>
      </x-card>

      <x-card padding="lg" hover>
        <x-slot:header>
          <h3 class="heading-4">Responsive</h3>
        </x-slot:header>
        <p class="body-normal">Fluid typography and spacing using clamp() for seamless scaling.</p>
      </x-card>
    </div>
  </div>
</x-parallax-section>


{{-- ============================================
     DEMO 4: Multi-Layer Parallax (Very subtle)
     ============================================ --}}

<x-parallax-section
  :layers="[
    [
      'speed' => 0.1,
      'image' => 'https://images.unsplash.com/photo-1506905925346-21bda4d32df4?w=1920&q=80',
      'class' => 'parallax-back'
    ],
    [
      'speed' => 0.2,
      'content' => '<div style=\'position: absolute; inset: 0; background: linear-gradient(180deg, transparent, rgba(0,0,0,0.5));\'></div>'
    ]
  ]"
>
  <div class="container section section--lg" style="position: relative; z-index: 3;">
    <header class="text-center stack-lg">
      <h2 class="display-2" style="color: var(--color-neutral-0);">
        Multi-Layer Depth
      </h2>
      <p class="body-large mx-auto" style="color: var(--color-neutral-100); max-width: 45rem;">
        Experience subtle parallax effects with multiple layers
      </p>
    </header>
  </div>
</x-parallax-section>


{{-- ============================================
     DEMO 5: Social Icons - All Variants
     ============================================ --}}

<section class="section section--lg" id="social-icons-demo" style="background: var(--color-surface-base);">
  <div class="container">
    <header class="text-center stack-xl">
      <h2 class="display-2">Social Icons Showcase</h2>
    </header>

    <div class="stack-2xl">
      {{-- Inline Default --}}
      <div class="text-center stack-md">
        <h3 class="heading-4">Inline Default</h3>
        <x-social-icons
          :platforms="['github', 'twitter', 'linkedin', 'dribbble']"
          orientation="horizontal"
        />
      </div>

      {{-- Inline Filled --}}
      <div class="text-center stack-md">
        <h3 class="heading-4">Inline Filled</h3>
        <x-social-icons
          variant="filled"
          :platforms="['github', 'twitter', 'linkedin', 'dribbble']"
          orientation="horizontal"
        />
      </div>

      {{-- Inline Outlined --}}
      <div class="text-center stack-md">
        <h3 class="heading-4">Inline Outlined</h3>
        <x-social-icons
          variant="outlined"
          :platforms="['github', 'twitter', 'linkedin', 'dribbble']"
          orientation="horizontal"
        />
      </div>

      {{-- Size Variations --}}
      <div class="text-center stack-md">
        <h3 class="heading-4">Size Variations</h3>
        <div class="flex gap-2xl justify-center items-center flex-wrap">
          <div class="stack-sm">
            <p class="body-small">Small</p>
            <x-social-icons
              size="sm"
              variant="filled"
              :platforms="['github', 'twitter', 'linkedin']"
              orientation="horizontal"
            />
          </div>
          <div class="stack-sm">
            <p class="body-small">Base</p>
            <x-social-icons
              size="base"
              variant="filled"
              :platforms="['github', 'twitter', 'linkedin']"
              orientation="horizontal"
            />
          </div>
          <div class="stack-sm">
            <p class="body-small">Large</p>
            <x-social-icons
              size="lg"
              variant="filled"
              :platforms="['github', 'twitter', 'linkedin']"
              orientation="horizontal"
            />
          </div>
        </div>
      </div>
    </div>
  </div>
</section>


{{-- ============================================
     DEMO 6: GSAP Animation Showcase
     ============================================ --}}

<section class="section section--lg" style="background: var(--color-surface-raised);">
  <div class="container">
    <header class="text-center stack-xl">
      <h2 class="display-2 fade-demo">GSAP Animation Utilities</h2>
    </header>

    <div class="stack-2xl">
      {{-- Fade In Demo --}}
      <div>
        <h3 class="heading-4 text-center stack-lg">Fade In Effect</h3>
        <div class="grid grid--3 gap-lg">
          <x-card padding="lg" class="fade-in-demo">
            <x-slot:header>
              <h4 class="heading-5">Fade In</h4>
            </x-slot:header>
            <p class="body-normal">Smooth fade in on scroll</p>
          </x-card>

          <x-card padding="lg" class="fade-in-demo">
            <x-slot:header>
              <h4 class="heading-5">With Stagger</h4>
            </x-slot:header>
            <p class="body-normal">Animated in sequence</p>
          </x-card>

          <x-card padding="lg" class="fade-in-demo">
            <x-slot:header>
              <h4 class="heading-5">Delay Effect</h4>
            </x-slot:header>
            <p class="body-normal">Staggered delay timing</p>
          </x-card>
        </div>
      </div>

      {{-- Slide In Demo --}}
      <div>
        <h3 class="heading-4 text-center stack-lg">Slide In Effect</h3>
        <div class="grid grid--2 gap-lg">
          <x-card padding="lg" class="slide-left-demo">
            <x-slot:header>
              <h4 class="heading-5">Slide from Left</h4>
            </x-slot:header>
            <p class="body-normal">Slides in from the left side</p>
          </x-card>

          <x-card padding="lg" class="slide-right-demo">
            <x-slot:header>
              <h4 class="heading-5">Slide from Right</h4>
            </x-slot:header>
            <p class="body-normal">Slides in from the right side</p>
          </x-card>
        </div>
      </div>

      {{-- Reveal Scale Demo --}}
      <div>
        <h3 class="heading-4 text-center stack-lg">Scale Reveal Effect</h3>
        <div class="grid grid--auto gap-md">
          <div class="reveal-demo" style="padding: var(--space-lg); background: var(--color-brand-primary); color: white; border-radius: var(--radius-md); text-align: center;">
            <h4 class="heading-5">Scale</h4>
          </div>
          <div class="reveal-demo" style="padding: var(--space-lg); background: var(--color-brand-secondary); color: white; border-radius: var(--radius-md); text-align: center;">
            <h4 class="heading-5">Reveal</h4>
          </div>
          <div class="reveal-demo" style="padding: var(--space-lg); background: var(--color-brand-accent); color: white; border-radius: var(--radius-md); text-align: center;">
            <h4 class="heading-5">Effect</h4>
          </div>
          <div class="reveal-demo" style="padding: var(--space-lg); background: var(--color-brand-primary); color: white; border-radius: var(--radius-md); text-align: center;">
            <h4 class="heading-5">Demo</h4>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>


{{-- ============================================
     DEMO 7: Final CTA Hero
     ============================================ --}}

<x-parallax-hero
  eyebrow="Get Started Today"
  title="Ready to Build Something Amazing?"
  subtitle="Join thousands of developers using our component framework"
  background="https://images.unsplash.com/photo-1519389950473-47ba0277781c?w=1920&q=80"
  height="medium"
  parallaxSpeed="0.15"
  :buttons="[
    ['text' => 'Start Free Trial', 'href' => '#', 'variant' => 'primary', 'size' => 'lg'],
    ['text' => 'Contact Sales', 'href' => '#', 'variant' => 'secondary', 'size' => 'lg']
  ]"
/>

@endsection

{{-- ============================================
     Initialize Custom GSAP Animations for Demo
     ============================================ --}}

@push('scripts')
<script>
(function() {
  function initDemoAnimations() {
    if (!window.GSAPUtils) {
      console.warn('GSAPUtils not available yet, retrying...');
      setTimeout(initDemoAnimations, 100);
      return;
    }

    try {
      // Demo animations
      if (document.querySelector('.fade-demo')) {
        window.GSAPUtils.fadeInOnScroll('.fade-demo', { y: 50, duration: 0.8 });
      }

      if (document.querySelector('.fade-in-demo')) {
        window.GSAPUtils.fadeInOnScroll('.fade-in-demo', { y: 50, duration: 0.8, stagger: 0.2 });
      }

      if (document.querySelector('.slide-left-demo')) {
        window.GSAPUtils.slideInOnScroll('.slide-left-demo', 'left', { duration: 1 });
      }

      if (document.querySelector('.slide-right-demo')) {
        window.GSAPUtils.slideInOnScroll('.slide-right-demo', 'right', { duration: 1 });
      }

      if (document.querySelector('.reveal-demo')) {
        window.GSAPUtils.revealOnScroll('.reveal-demo', { scale: 0.8, stagger: 0.1 });
      }

      console.log('✅ Demo animations initialized');
    } catch (error) {
      console.error('Error initializing demo animations:', error);
    }
  }

  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initDemoAnimations);
  } else {
    initDemoAnimations();
  }
})();
</script>
@endpush
