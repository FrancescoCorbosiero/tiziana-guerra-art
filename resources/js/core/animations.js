/**
 * Scroll-Triggered Animations
 *
 * Handles IntersectionObserver-based animations for elements with:
 * - [data-animate]: Single element animation
 * - [data-animate-stagger]: Staggered children animation
 *
 * Features:
 * - Automatic cleanup on page navigation
 * - Prevents double-initialization
 * - WordPress-compatible
 */

// Observer configuration
const observerOptions = {
  threshold: 0.1,
  rootMargin: '0px 0px -50px 0px' // Trigger slightly before element is in view
}

// Store observer instance globally to allow cleanup
let animationObserver = null

/**
 * Initialize scroll animations
 */
function initScrollAnimations() {
  // Cleanup existing observer if any
  if (animationObserver) {
    animationObserver.disconnect()
    animationObserver = null
  }

  // Create new IntersectionObserver
  animationObserver = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
      if (entry.isIntersecting) {
        entry.target.classList.add('animate-in')
        animationObserver.unobserve(entry.target) // Unobserve after animation
      }
    })
  }, observerOptions)

  // Find and observe all elements with data-animate
  const animatedElements = document.querySelectorAll('[data-animate]')
  animatedElements.forEach(el => {
    // Remove any stale animate-in class
    if (el.classList.contains('animate-in')) {
      el.classList.remove('animate-in')
    }
    animationObserver.observe(el)
  })

  // Observe elements with data-animate-stagger
  const staggeredContainers = document.querySelectorAll('[data-animate-stagger]')
  staggeredContainers.forEach(container => {
    // Remove any stale animate-in class
    if (container.classList.contains('animate-in')) {
      container.classList.remove('animate-in')
    }
    animationObserver.observe(container)
  })

  console.info(`Scroll animations initialized: ${animatedElements.length + staggeredContainers.length} elements`)
}

/**
 * Cleanup function
 */
function cleanupScrollAnimations() {
  if (animationObserver) {
    animationObserver.disconnect()
    animationObserver = null
  }
}

// Initialize on DOM ready
document.addEventListener('DOMContentLoaded', initScrollAnimations)

// Reinitialize on page change (for SPA-like navigation if enabled)
window.addEventListener('pagechange', () => {
  console.info('Page changed, reinitializing scroll animations')
  initScrollAnimations()
})

// Cleanup on page unload
window.addEventListener('beforeunload', cleanupScrollAnimations)

/**
 * Export for use in other modules
 */
export { animationObserver, observerOptions, initScrollAnimations, cleanupScrollAnimations }
