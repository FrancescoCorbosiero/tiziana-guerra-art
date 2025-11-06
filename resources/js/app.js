/**
 * Alpacode Studio Theme - Main JavaScript
 * WITH INTEGRATED LIBRARIES
 */

// Import Alpine.js
import Alpine from 'alpinejs'

// Import core modules
import { initPageLoader } from './core/loader'
import { initThemeSwitcher } from './core/theme-switcher'
import { initNavigation } from './core/navigation'
import { initViewTransitions } from './core/view-transitions' // Re-enabled with improved safeguards
import { initPerformance } from './core/performance'
import { initAccessibility } from './core/accessibility'
import './core/animations' // Scroll-triggered animations
import './utils/animations' // Advanced animation utilities

// Import NEW library initialization
import { initAllLibraries, initVanta } from './libraries/init-libraries'
import { GSAPUtils } from './libraries/utilities'
import { AlpineLibraryHelpers } from './libraries/alpine-helpers'
import { initShowcaseAnimations } from './libraries/showcase-init'

// Import section-specific modules
import { initOrbitingHero } from './sections/orbiting-hero'

// Make Alpine & utilities available globally
window.Alpine = Alpine
window.GSAPUtils = GSAPUtils

// Register Alpine helpers
Alpine.data('swiperController', AlpineLibraryHelpers.swiperController)
Alpine.data('gsapTrigger', AlpineLibraryHelpers.gsapTrigger)
Alpine.data('galleryController', AlpineLibraryHelpers.galleryController)
Alpine.data('counterAnimation', AlpineLibraryHelpers.counterAnimation)
Alpine.data('parallaxContainer', AlpineLibraryHelpers.parallaxContainer)
Alpine.data('scrollProgress', AlpineLibraryHelpers.scrollProgress)
Alpine.data('aosController', AlpineLibraryHelpers.aosController)
Alpine.data('timelineController', AlpineLibraryHelpers.timelineController)

// Import static assets
import.meta.glob([
  '../images/**',
  '../fonts/**',
])

/**
 * Check if we're in WordPress admin
 */
function isWordPressAdmin() {
  return document.body.classList.contains('wp-admin') ||
         document.body.classList.contains('wp-core-ui')
}

/**
 * Initialize theme on DOM ready
 */
document.addEventListener('DOMContentLoaded', () => {
  // Prevent multiple initializations
  if (window.alpineInitialized) {
    return
  }
  window.alpineInitialized = true

  // Don't initialize frontend features in WordPress admin
  if (isWordPressAdmin()) {
    // Only start Alpine.js for admin
    Alpine.start()
    return
  }

  try {
    // Initialize page loader FIRST (before everything else)
    initPageLoader()
  } catch (error) {
    console.error('Failed to initialize page loader:', error)
  }

  try {
    // Initialize theme switcher
    initThemeSwitcher()
  } catch (error) {
    console.error('Failed to initialize theme switcher:', error)
  }

  try {
    // Initialize navigation
    initNavigation()
  } catch (error) {
    console.error('Failed to initialize navigation:', error)
  }

  try {
    // Initialize view transitions with improved safeguards
    // Provides SPA-like smoothness for navigation
    initViewTransitions()
  } catch (error) {
    console.error('Failed to initialize view transitions:', error)
  }

  try {
    // Initialize performance monitoring
    initPerformance()
  } catch (error) {
    console.error('Failed to initialize performance monitoring:', error)
  }

  try {
    // Initialize accessibility features
    initAccessibility()
  } catch (error) {
    console.error('Failed to initialize accessibility features:', error)
  }

  try {
    // Initialize NEW libraries
    initAllLibraries()
  } catch (error) {
    console.error('Failed to initialize libraries:', error)
  }

  try {
    // Initialize Vanta on specific pages (if element exists)
    if (document.querySelector('#vanta-bg') || document.querySelector('#hero-vanta')) {
      const vantaId = document.querySelector('#hero-vanta') ? '#hero-vanta' : '#vanta-bg'
      initVanta(vantaId)
    }
  } catch (error) {
    console.error('Failed to initialize Vanta:', error)
  }

  // Start Alpine.js
  Alpine.start()

  // Initialize showcase animations after a short delay to ensure GSAP is ready
  setTimeout(() => {
    try {
      initShowcaseAnimations()
    } catch (error) {
      console.error('Failed to initialize showcase animations:', error)
    }
  }, 100)

  try {
    // Initialize section-specific features
    initOrbitingHero()
  } catch (error) {
    console.error('Failed to initialize orbiting hero:', error)
  }

  console.log('🚀 Theme fully initialized with all libraries')
})
