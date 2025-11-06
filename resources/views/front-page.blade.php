{{--
  Template Name: Front Page (Homepage)

  SHOWCASE landing page demonstrating all integrated libraries:
  - Vanta.js 3D backgrounds
  - GSAP professional animations
  - AOS scroll animations
  - Swiper carousels
  - PhotoSwipe galleries
  - Alpine.js reactive utilities
--}}

@extends('layouts.app')

@section('content')

  @include('sections.hero')
  @include('sections.features')
  @include('sections.pricing-preview')
  @include('sections.social-proof')
  @include('sections.value-proposition')
  @include('sections.final-cta')

@endsection
