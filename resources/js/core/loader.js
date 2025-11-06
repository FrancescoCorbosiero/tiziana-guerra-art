/**
 * Page Loader with GSAP Animations
 * Amazing loader that only shows on first visit
 */

import { gsap } from 'gsap'

const LOADER_SESSION_KEY = 'alpacode_loader_shown'
const LOADER_DURATION = 3 // Total duration in seconds

/**
 * Check if loader should show (first visit only)
 */
function shouldShowLoader() {
  // Check if loader was already shown in this session
  const loaderShown = sessionStorage.getItem(LOADER_SESSION_KEY)

  // Only show on first page load of the session
  if (loaderShown) {
    return false
  }

  // Mark as shown for this session
  sessionStorage.setItem(LOADER_SESSION_KEY, 'true')
  return true
}

/**
 * Create GSAP timeline for loader animation
 */
function createLoaderTimeline() {
  const tl = gsap.timeline({
    defaults: {
      ease: 'power3.out'
    }
  })

  // Get elements
  const loader = document.querySelector('[data-loader]')
  const logo = document.querySelector('[data-loader-logo]')
  const text = document.querySelector('[data-loader-text]')
  const chars = document.querySelectorAll('.loader-text__char')
  const progress = document.querySelector('[data-loader-progress]')
  const progressFill = document.querySelector('[data-loader-progress-fill]')
  const counter = document.querySelector('[data-loader-counter]')
  const status = document.querySelector('[data-loader-status]')
  const shapes = document.querySelectorAll('[data-loader-shape]')
  const overlay = document.querySelector('[data-loader-overlay]')

  // Helper to filter null elements
  const filterNull = (elements) => {
    if (Array.isArray(elements)) {
      return elements.filter(el => el !== null && el !== undefined)
    }
    return elements
  }

  // Initial states (only set on existing elements)
  const brandElement = logo || text
  if (brandElement) {
    gsap.set(brandElement, { opacity: 0 })
  }
  if (progress) {
    gsap.set(progress, { opacity: 0 })
  }
  if (status) {
    gsap.set(status, { opacity: 0 })
  }
  if (shapes.length > 0) {
    gsap.set(shapes, { opacity: 0, scale: 0, rotation: 0 })
  }
  if (overlay) {
    gsap.set(overlay, { opacity: 0 })
  }

  // Animation sequence
  tl
    // Fade in overlay
    .to(overlay, {
      opacity: 1,
      duration: 0.3
    }, 0)

    // Animate shapes in
    .to(shapes, {
      opacity: 1,
      scale: 1,
      rotation: 360,
      stagger: 0.1,
      duration: 0.8,
      ease: 'back.out(1.7)'
    }, 0.2)

  // Animate logo or text brand element
  if (brandElement) {
    tl.to(brandElement, {
      opacity: 1,
      scale: 1,
      duration: 0.6,
      ease: 'back.out(1.7)'
    }, 0.3)
  }

  // If text with characters, animate them
  if (chars.length > 0) {
    tl.to(chars, {
      opacity: 1,
      y: 0,
      rotateX: 0,
      stagger: 0.05,
      duration: 0.6,
      ease: 'back.out(1.7)'
    }, logo ? '-=0.6' : 0.3)
  }

  // Show progress bar
  if (progress) {
    tl.to(progress, {
      opacity: 1,
      y: 0,
      duration: 0.4
    }, '-=0.2')
  }

  // Animate progress counter
  if (counter && progressFill) {
    tl.to(counter, {
      textContent: 100,
      duration: LOADER_DURATION * 0.6,
      snap: { textContent: 1 },
      ease: 'power2.inOut',
      onUpdate: function() {
        const value = Math.round(this.targets()[0].textContent)
        // Update progress bar width
        gsap.to(progressFill, {
          width: `${value}%`,
          duration: 0.1
        })
      }
    }, '-=0.2')
  }

  // Show status text
  if (status) {
    tl.to(status, {
      opacity: 1,
      y: 0,
      duration: 0.3
    }, '-=2')
  }

  // Rotate shapes during loading
  if (shapes.length > 0) {
    tl.to(shapes, {
      rotation: '+=180',
      duration: LOADER_DURATION * 0.7,
      ease: 'none',
      stagger: {
        each: 0.2,
        repeat: -1,
        yoyo: true
      }
    }, 0.5)
  }

  return tl
}

/**
 * Hide loader with animation
 */
function hideLoader() {
  const loader = document.querySelector('[data-loader]')
  const loaderContent = document.querySelector('.page-loader__content')
  const shapes = document.querySelectorAll('[data-loader-shape]')
  const overlay = document.querySelector('[data-loader-overlay]')

  if (!loader) return

  // Create exit timeline
  const exitTl = gsap.timeline({
    onComplete: () => {
      // Remove loader from DOM
      loader.remove()
      // Re-enable scrolling
      document.body.classList.remove('loader-active')
    }
  })

  // Scale up and fade out shapes
  if (shapes.length > 0) {
    exitTl.to(shapes, {
      scale: 2,
      opacity: 0,
      rotation: '+=180',
      stagger: 0.05,
      duration: 0.4,
      ease: 'power2.in'
    }, 0)
  }

  // Scale and fade out content
  if (loaderContent) {
    exitTl.to(loaderContent, {
      scale: 0.9,
      opacity: 0,
      duration: 0.5,
      ease: 'power3.in'
    }, '-=0.2')
  }

  // Fade out overlay with scale
  if (overlay) {
    exitTl.to(overlay, {
      opacity: 0,
      scale: 1.5,
      duration: 0.6,
      ease: 'power2.inOut'
    }, '-=0.3')
  }

  // Fade out entire loader
  exitTl.to(loader, {
    opacity: 0,
    duration: 0.3,
    ease: 'power2.inOut'
  }, '-=0.2')

  return exitTl
}

/**
 * Initialize page loader
 */
export function initPageLoader() {
  const loader = document.querySelector('[data-loader]')

  if (!loader) {
    console.warn('Loader element not found')
    return
  }

  // Check if we should show the loader
  if (!shouldShowLoader()) {
    // Hide immediately if already shown in this session
    loader.remove()
    return
  }

  // Prevent scrolling while loader is active
  document.body.classList.add('loader-active')

  // Create and start the loading animation
  const loaderTimeline = createLoaderTimeline()

  // Wait for minimum display time, then hide
  const minDisplayTime = LOADER_DURATION * 1000

  // Also wait for actual page load
  const onPageLoad = () => {
    setTimeout(() => {
      hideLoader()
    }, Math.max(0, minDisplayTime - performance.now()))
  }

  // If page is already loaded
  if (document.readyState === 'complete') {
    onPageLoad()
  } else {
    // Wait for page to load
    window.addEventListener('load', onPageLoad, { once: true })
  }

  // Fallback: Always hide after max time
  setTimeout(() => {
    if (loader && loader.parentElement) {
      hideLoader()
    }
  }, (LOADER_DURATION + 2) * 1000)
}

/**
 * Reset loader (useful for development/testing)
 */
export function resetLoader() {
  sessionStorage.removeItem(LOADER_SESSION_KEY)
  console.log('Loader reset - will show on next page load')
}

// Make reset function available globally for testing
if (typeof window !== 'undefined') {
  window.resetLoader = resetLoader
}
