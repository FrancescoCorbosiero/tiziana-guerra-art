/**
 * Showcase-specific GSAP animations initialization
 * Only runs when showcase elements are present on the page
 */

import { GSAPUtils } from './utilities'

/**
 * Initialize GSAP showcase animations
 * Checks for element existence before animating
 */
export function initShowcaseAnimations() {
  // Only run if GSAPUtils is available
  if (typeof GSAPUtils === 'undefined') {
    console.warn('GSAPUtils not available, skipping showcase animations')
    return
  }

  // GSAP Showcase - Parallax layers
  const parallaxBack = document.querySelector('.parallax-layer--back')
  const parallaxMiddle = document.querySelector('.parallax-layer--middle')
  const parallaxFront = document.querySelector('.parallax-layer--front')

  if (parallaxBack && parallaxMiddle && parallaxFront) {
    try {
      GSAPUtils.parallax('.parallax-layer--back', 0.3)
      GSAPUtils.parallax('.parallax-layer--middle', 0.6)
      GSAPUtils.parallax('.parallax-layer--front', 0.9)
      console.log('✅ Parallax animations initialized')
    } catch (error) {
      console.error('Failed to initialize parallax animations:', error)
    }
  }

  // GSAP Showcase - Stagger grid
  const staggerDemo = document.querySelector('#stagger-demo')
  if (staggerDemo && staggerDemo.querySelector('.stagger-item')) {
    try {
      GSAPUtils.staggerOnScroll('#stagger-demo', '.stagger-item')
      console.log('✅ Stagger animations initialized')
    } catch (error) {
      console.error('Failed to initialize stagger animations:', error)
    }
  }

  // GSAP Showcase - Fade slide features
  const fadeSlideDemo = document.querySelector('#fade-slide-demo')
  if (fadeSlideDemo && fadeSlideDemo.querySelector('.feature-box')) {
    try {
      GSAPUtils.slideInOnScroll('#fade-slide-demo .feature-box', 'up', {
        stagger: 0.2,
        duration: 0.8
      })
      console.log('✅ Fade slide animations initialized')
    } catch (error) {
      console.error('Failed to initialize fade slide animations:', error)
    }
  }

  // GSAP Showcase - Rotate element
  const rotateDemo = document.querySelector('#rotate-demo')
  if (rotateDemo) {
    try {
      GSAPUtils.rotateOnScroll('#rotate-demo', 720)
      console.log('✅ Rotation animation initialized')
    } catch (error) {
      console.error('Failed to initialize rotation animation:', error)
    }
  }

  console.log('🎨 Showcase animations initialized')
}

/**
 * Cleanup showcase animations (for page transitions)
 */
export function cleanupShowcaseAnimations() {
  // ScrollTrigger cleanup is handled automatically by GSAP
  // This function is here for future cleanup needs
}
