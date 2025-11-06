{{--
  Template Name: Component Showcase
  Description: Demonstrates all available components and sections
--}}

@extends('layouts.app')

@section('content')
  {{-- Hero Section --}}
  <x-section-hero
    eyebrow="Premium Sage Theme • 2025"
    title="Your Digital Space, Simplified"
    subtitle="A modern, CSS4-first WordPress theme built for performance, accessibility, and design excellence. Perfect for agencies, freelancers, and creative professionals."
    :buttons="[
      ['text' => 'Get Started', 'href' => '#features', 'variant' => 'primary', 'size' => 'lg'],
      ['text' => 'View Components', 'href' => '#components', 'variant' => 'secondary', 'size' => 'lg']
    ]"
  />

  {{-- Features Section --}}
  @php
    $features = [
      [
        'icon' => '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M13 2L3 14h9l-1 8 10-12h-9l1-8z"/></svg>',
        'title' => 'Lightning Fast',
        'description' => 'CSS4-first architecture with minimal JavaScript. Lighthouse score 95+, FCP under 1.5s.'
      ],
      [
        'icon' => '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="M12 6v6l4 2"/></svg>',
        'title' => 'Modern CSS4',
        'description' => 'Native CSS features: custom properties, nesting, container queries, OKLCH colors.'
      ],
      [
        'icon' => '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>',
        'title' => 'SEO Ready',
        'description' => 'Built-in Schema.org markup, meta tags, breadcrumbs, and performance optimization.'
      ],
      [
        'icon' => '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 2a10 10 0 0 0 0 20 10 10 0 0 0 0-20zm0 0v20"/><path d="M2 12h20"/></svg>',
        'title' => 'Internationalization',
        'description' => 'Full i18n support with RTL layouts, translation management, and locale detection.'
      ],
      [
        'icon' => '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"/><polyline points="3.27 6.96 12 12.01 20.73 6.96"/><line x1="12" y1="22.08" x2="12" y2="12"/></svg>',
        'title' => 'Component Library',
        'description' => 'Production-ready Blade components: buttons, cards, modals, hero, features, CTAs.'
      ],
      [
        'icon' => '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/></svg>',
        'title' => 'WCAG AA Compliant',
        'description' => '9:1 contrast ratios, keyboard navigation, focus management, screen reader support.'
      ]
    ];
  @endphp

  <x-section-features
    id="features"
    title="Built for Performance & Design"
    description="Everything you need for a premium website experience"
    :features="$features"
    :columns="3"
  />

  {{-- Component Showcase Section --}}
  <section class="section" id="components" style="background: var(--color-surface-raised);">
    <div class="container">
      <header class="text-center" style="margin-block-end: var(--space-2xl);">
        <h2 class="heading-2">Component Library</h2>
        <p class="body-large text-secondary">Reusable, accessible, and beautiful components</p>
      </header>

      {{-- Buttons Showcase --}}
      <div class="stack-xl">
        <div>
          <h3 class="heading-3" style="margin-block-end: var(--space-lg);">Buttons</h3>
          <div class="flex gap-md flex-wrap">
            <x-button variant="primary" size="lg">Primary Large</x-button>
            <x-button variant="secondary" size="lg">Secondary Large</x-button>
            <x-button variant="tertiary">Tertiary</x-button>
            <x-button variant="ghost">Ghost</x-button>
            <x-button variant="primary" size="sm">Small</x-button>
          </div>
        </div>

        {{-- Cards Showcase --}}
        <div>
          <h3 class="heading-3" style="margin-block-end: var(--space-lg);">Cards</h3>
          <div class="grid grid--3 gap-lg">
            <x-card hover padding="lg">
              <x-slot:header>
                <h4 class="heading-5">Basic Card</h4>
              </x-slot:header>

              <p class="body-normal">This is a basic card with hover effect. It includes header, body, and footer slots for maximum flexibility.</p>

              <x-slot:footer>
                <x-button variant="ghost" size="sm">Learn More →</x-button>
              </x-slot:footer>
            </x-card>

            <x-card hover padding="lg">
              <x-slot:header>
                <h4 class="heading-5">Feature Card</h4>
              </x-slot:header>

              <p class="body-normal">Cards automatically adapt to light and dark modes. Hover to see the lift effect in action.</p>

              <x-slot:footer>
                <x-button variant="ghost" size="sm">Explore →</x-button>
              </x-slot:footer>
            </x-card>

            <x-card hover padding="lg">
              <x-slot:header>
                <h4 class="heading-5">Responsive Card</h4>
              </x-slot:header>

              <p class="body-normal">Built with container queries for true component-level responsiveness. No media queries needed.</p>

              <x-slot:footer>
                <x-button variant="ghost" size="sm">Discover →</x-button>
              </x-slot:footer>
            </x-card>
          </div>
        </div>

        {{-- Modal Showcase --}}
        <div>
          <h3 class="heading-3" style="margin-block-end: var(--space-lg);">Modals</h3>

          <div class="flex gap-md">
            <x-modal id="demo-modal" title="Example Modal" size="md">
              <p class="body-normal">This is a modal dialog powered by Alpine.js. It includes:</p>
              <ul class="stack-sm" style="margin-block-start: var(--space-md); padding-inline-start: var(--space-lg);">
                <li>ESC key to close</li>
                <li>Backdrop click to close</li>
                <li>Focus trap for accessibility</li>
                <li>Smooth animations</li>
                <li>Dark mode support</li>
              </ul>

              <x-slot:footer>
                <x-button variant="secondary" size="sm" @click="open = false">Close</x-button>
                <x-button variant="primary" size="sm">Confirm</x-button>
              </x-slot:footer>
            </x-modal>

            <x-button variant="primary" @click="$dispatch('click')">
              Open Modal
            </x-button>
          </div>
        </div>
      </div>
    </div>
  </section>

  {{-- CTA Section --}}
  <x-section-cta
    title="Ready to Build Something Amazing?"
    description="Start your project with this premium Sage theme. Modern, fast, and built to last."
    buttonText="Get Started Today"
    buttonHref="/contact"
    variant="centered"
  />

  {{-- Technical Specs Section --}}
  <section class="section">
    <div class="container container--md">
      <header class="text-center" style="margin-block-end: var(--space-2xl);">
        <h2 class="heading-2">Technical Excellence</h2>
        <p class="body-large text-secondary">Built with modern standards and best practices</p>
      </header>

      <div class="grid grid--2 gap-xl">
        <div>
          <h3 class="heading-4" style="margin-block-end: var(--space-md);">Performance</h3>
          <ul class="stack-sm body-normal">
            <li>✅ Lighthouse Score: 95+</li>
            <li>✅ First Contentful Paint: &lt;1.5s</li>
            <li>✅ CSS Bundle: &lt;50KB</li>
            <li>✅ JavaScript Bundle: &lt;100KB</li>
            <li>✅ Web Vitals Monitoring</li>
            <li>✅ Critical CSS Inlining</li>
          </ul>
        </div>

        <div>
          <h3 class="heading-4" style="margin-block-end: var(--space-md);">Technology Stack</h3>
          <ul class="stack-sm body-normal">
            <li>🎨 CSS4 Native Features</li>
            <li>⚡ Vite Build System</li>
            <li>🏔️ Alpine.js (14KB)</li>
            <li>🌐 Sage 10 + Acorn</li>
            <li>🎭 Blade Components</li>
            <li>📊 Service Layer Architecture</li>
          </ul>
        </div>

        <div>
          <h3 class="heading-4" style="margin-block-end: var(--space-md);">CSS4 Features</h3>
          <ul class="stack-sm body-normal">
            <li>🎨 OKLCH Color Space</li>
            <li>📦 Container Queries</li>
            <li>🔀 Native CSS Nesting</li>
            <li>🎭 @layer Cascade Control</li>
            <li>🌈 color-mix() Function</li>
            <li>✨ View Transitions API</li>
          </ul>
        </div>

        <div>
          <h3 class="heading-4" style="margin-block-end: var(--space-md);">Accessibility</h3>
          <ul class="stack-sm body-normal">
            <li>♿ WCAG AA Compliant</li>
            <li>⌨️ Keyboard Navigation</li>
            <li>🎯 Focus Management</li>
            <li>📢 Screen Reader Support</li>
            <li>🎨 9:1 Contrast Ratios</li>
            <li>🔊 ARIA Live Regions</li>
          </ul>
        </div>
      </div>
    </div>
  </section>

  {{-- Final CTA --}}
  <x-section-cta
    title="Questions? Let's Talk"
    description="Get in touch to discuss your project or learn more about this theme"
    buttonText="Contact Us"
    buttonHref="/contact"
    variant="split"
  />
@endsection
