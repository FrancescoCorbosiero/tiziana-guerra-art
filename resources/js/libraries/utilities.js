/**
 * High-Level Utility Functions
 * Built on top of libraries for common use cases
 */

import { gsap } from 'gsap'
import { ScrollTrigger } from 'gsap/ScrollTrigger'

// Register ScrollTrigger plugin
gsap.registerPlugin(ScrollTrigger)

/**
 * Fade In on Scroll (GSAP-based)
 * @param {string} selector - Elements to animate
 * @param {object} options - Custom options
 */
export function fadeInOnScroll(selector, options = {}) {
  const defaults = {
    y: 50,
    opacity: 0,
    duration: 0.8,
    stagger: 0.2,
  }

  const settings = { ...defaults, ...options }

  gsap.from(selector, {
    scrollTrigger: {
      trigger: selector,
      start: 'top 80%',
      toggleActions: 'play none none none',
    },
    ...settings
  })
}

/**
 * Parallax Effect (GSAP-based)
 * @param {string} selector - Element to parallax
 * @param {number} speed - Parallax speed (0.5 = half speed)
 */
export function parallax(selector, speed = 0.5) {
  gsap.to(selector, {
    yPercent: 100 * speed,
    ease: 'none',
    scrollTrigger: {
      trigger: selector,
      start: 'top bottom',
      end: 'bottom top',
      scrub: true,
    }
  })
}

/**
 * Stagger Animation on Scroll
 * @param {string} selector - Parent container
 * @param {string} childSelector - Children to animate
 */
export function staggerOnScroll(selector, childSelector = '.item') {
  const elements = document.querySelectorAll(`${selector} ${childSelector}`)

  gsap.from(elements, {
    scrollTrigger: {
      trigger: selector,
      start: 'top 75%',
    },
    y: 50,
    opacity: 0,
    stagger: 0.1,
    duration: 0.6,
    ease: 'power2.out'
  })
}

/**
 * Pin Element While Scrolling
 * @param {string} selector - Element to pin
 * @param {string} endTrigger - When to unpin
 */
export function pinOnScroll(selector, endTrigger = '+=500') {
  ScrollTrigger.create({
    trigger: selector,
    start: 'top top',
    end: endTrigger,
    pin: true,
    pinSpacing: false,
  })
}

/**
 * Create Timeline Animation
 * Convenience wrapper for GSAP timelines
 */
export function createTimeline(options = {}) {
  return gsap.timeline({
    scrollTrigger: {
      trigger: options.trigger,
      start: options.start || 'top 80%',
      toggleActions: 'play none none none',
      ...options.scrollTrigger
    },
    ...options
  })
}

/**
 * Animate Counter (Number Count-Up)
 * @param {string} selector - Element containing number
 * @param {number} endValue - Target number
 * @param {number} duration - Animation duration
 */
export function animateCounter(selector, endValue, duration = 2) {
  const element = document.querySelector(selector)
  if (!element) return

  gsap.to(element, {
    textContent: endValue,
    duration: duration,
    snap: { textContent: 1 },
    scrollTrigger: {
      trigger: element,
      start: 'top 80%',
      toggleActions: 'play none none none',
    }
  })
}

/**
 * Reveal Animation (from hidden state)
 * @param {string} selector - Elements to reveal
 * @param {object} options - Animation options
 */
export function revealOnScroll(selector, options = {}) {
  const defaults = {
    opacity: 0,
    scale: 0.8,
    duration: 0.8,
    stagger: 0.1,
  }

  const settings = { ...defaults, ...options }

  gsap.from(selector, {
    scrollTrigger: {
      trigger: selector,
      start: 'top 85%',
      toggleActions: 'play none none none',
    },
    ...settings
  })
}

/**
 * Slide In Animation
 * @param {string} selector - Elements to slide in
 * @param {string} direction - 'left', 'right', 'up', 'down'
 * @param {object} options - Additional options
 */
export function slideInOnScroll(selector, direction = 'left', options = {}) {
  const directionMap = {
    left: { x: -100 },
    right: { x: 100 },
    up: { y: -100 },
    down: { y: 100 }
  }

  const defaults = {
    ...directionMap[direction],
    opacity: 0,
    duration: 0.8,
    stagger: 0.1,
  }

  const settings = { ...defaults, ...options }

  gsap.from(selector, {
    scrollTrigger: {
      trigger: selector,
      start: 'top 80%',
      toggleActions: 'play none none none',
    },
    ...settings
  })
}

/**
 * Rotate On Scroll
 * @param {string} selector - Element to rotate
 * @param {number} degrees - Rotation amount in degrees
 */
export function rotateOnScroll(selector, degrees = 360) {
  gsap.to(selector, {
    rotation: degrees,
    scrollTrigger: {
      trigger: selector,
      start: 'top bottom',
      end: 'bottom top',
      scrub: 1,
    }
  })
}

/**
 * Scale On Scroll
 * @param {string} selector - Element to scale
 * @param {number} scale - Scale amount (1.5 = 150%)
 */
export function scaleOnScroll(selector, scale = 1.2) {
  gsap.to(selector, {
    scale: scale,
    scrollTrigger: {
      trigger: selector,
      start: 'top bottom',
      end: 'bottom top',
      scrub: 1,
    }
  })
}

/**
 * Split Text Into Characters
 * Creates individual spans for character-level animation
 * @param {string} selector - Text element to split
 * @returns {HTMLElement[]} Array of character spans
 */
export function splitTextChars(selector) {
  const element = document.querySelector(selector)
  if (!element) return []

  const text = element.textContent
  const chars = text.split('')

  element.innerHTML = chars.map(char => {
    if (char === ' ') return '<span class="char">&nbsp;</span>'
    return `<span class="char">${char}</span>`
  }).join('')

  return element.querySelectorAll('.char')
}

/**
 * Animate Text Characters (Stagger)
 * Reveals text character by character
 * @param {string} selector - Text element to animate
 * @param {object} options - Animation options
 */
export function animateTextChars(selector, options = {}) {
  const chars = splitTextChars(selector)
  if (chars.length === 0) return

  const defaults = {
    y: 50,
    opacity: 0,
    duration: 0.5,
    stagger: 0.03,
    ease: 'back.out(1.7)'
  }

  const settings = { ...defaults, ...options }

  gsap.from(chars, {
    scrollTrigger: {
      trigger: selector,
      start: 'top 80%',
      toggleActions: 'play none none none',
    },
    ...settings
  })
}

/**
 * Hero Entrance Animation (Preset Combo)
 * Complete hero section entrance with title, subtitle, and CTA
 * @param {object} selectors - Object with title, subtitle, cta selectors
 */
export function heroEntrance(selectors = {}) {
  const {
    title = '.hero__title',
    subtitle = '.hero__subtitle',
    cta = '.hero__cta',
    background = '.hero__background'
  } = selectors

  // Background parallax
  if (document.querySelector(background)) {
    parallax(background, 0.3)
  }

  // Title animation
  if (document.querySelector(title)) {
    fadeInOnScroll(title, {
      y: 100,
      opacity: 0,
      duration: 1.2,
      delay: 0.2
    })
  }

  // Subtitle animation
  if (document.querySelector(subtitle)) {
    fadeInOnScroll(subtitle, {
      y: 50,
      opacity: 0,
      duration: 1,
      delay: 0.4
    })
  }

  // CTA buttons
  if (document.querySelector(cta)) {
    fadeInOnScroll(cta, {
      y: 30,
      opacity: 0,
      duration: 0.8,
      delay: 0.6
    })
  }
}

/**
 * Scroll Progress Indicator
 * Creates a progress bar that fills as user scrolls
 * @param {string} selector - Progress bar element
 * @param {string} trigger - Section to track (defaults to body)
 */
export function scrollProgress(selector, trigger = 'body') {
  gsap.to(selector, {
    scaleX: 1,
    ease: 'none',
    scrollTrigger: {
      trigger: trigger,
      start: 'top top',
      end: 'bottom bottom',
      scrub: 0.3,
    }
  })
}

/**
 * Magnetic Element Effect
 * Element follows cursor with smooth easing
 * @param {string} selector - Element to make magnetic
 * @param {number} strength - Magnetic strength (0.3 = 30% movement)
 */
export function magneticEffect(selector, strength = 0.3) {
  const elements = document.querySelectorAll(selector)

  elements.forEach(element => {
    const handleMouseMove = (e) => {
      const rect = element.getBoundingClientRect()
      const centerX = rect.left + rect.width / 2
      const centerY = rect.top + rect.height / 2

      const deltaX = (e.clientX - centerX) * strength
      const deltaY = (e.clientY - centerY) * strength

      gsap.to(element, {
        x: deltaX,
        y: deltaY,
        duration: 0.3,
        ease: 'power2.out'
      })
    }

    const handleMouseLeave = () => {
      gsap.to(element, {
        x: 0,
        y: 0,
        duration: 0.5,
        ease: 'elastic.out(1, 0.3)'
      })
    }

    element.addEventListener('mousemove', handleMouseMove)
    element.addEventListener('mouseleave', handleMouseLeave)
  })
}

/**
 * Image Reveal Animation
 * Reveals images with clip-path effect
 * @param {string} selector - Image container selector
 * @param {string} direction - 'left', 'right', 'up', 'down'
 */
export function imageReveal(selector, direction = 'right') {
  const clipPathMap = {
    right: { from: 'inset(0 100% 0 0)', to: 'inset(0 0% 0 0)' },
    left: { from: 'inset(0 0 0 100%)', to: 'inset(0 0 0 0)' },
    down: { from: 'inset(0 0 100% 0)', to: 'inset(0 0 0% 0)' },
    up: { from: 'inset(100% 0 0 0)', to: 'inset(0% 0 0 0)' }
  }

  const paths = clipPathMap[direction]

  gsap.fromTo(selector,
    { clipPath: paths.from },
    {
      clipPath: paths.to,
      duration: 1.2,
      ease: 'power3.inOut',
      scrollTrigger: {
        trigger: selector,
        start: 'top 80%',
        toggleActions: 'play none none none',
      }
    }
  )
}

/**
 * Card Grid Stagger (Preset)
 * Animates a grid of cards with stagger and lift effect
 * @param {string} containerSelector - Grid container
 * @param {string} cardSelector - Card items selector
 */
export function cardGridStagger(containerSelector, cardSelector = '.card') {
  const cards = document.querySelectorAll(`${containerSelector} ${cardSelector}`)

  gsap.from(cards, {
    scrollTrigger: {
      trigger: containerSelector,
      start: 'top 75%',
    },
    y: 80,
    opacity: 0,
    scale: 0.95,
    stagger: {
      amount: 0.6,
      from: 'start'
    },
    duration: 0.8,
    ease: 'power2.out'
  })
}

/**
 * Floating Animation (Infinite Loop)
 * Creates a smooth floating effect
 * @param {string} selector - Element to animate
 * @param {object} options - Animation options
 */
export function floatingAnimation(selector, options = {}) {
  const defaults = {
    y: -20,
    duration: 2,
    ease: 'sine.inOut',
    repeat: -1,
    yoyo: true
  }

  const settings = { ...defaults, ...options }

  gsap.to(selector, settings)
}

/**
 * Batch Scroll Animations
 * Efficiently animates multiple elements with ScrollTrigger.batch
 * @param {string} selector - Elements to animate
 * @param {object} options - Animation options
 */
export function batchScrollAnimation(selector, options = {}) {
  const defaults = {
    y: 50,
    opacity: 0,
    stagger: 0.1,
    duration: 0.6
  }

  const settings = { ...defaults, ...options }

  ScrollTrigger.batch(selector, {
    onEnter: batch => gsap.to(batch, settings),
    start: 'top 85%',
  })
}

// Export all utilities as a named object
export const GSAPUtils = {
  // Original utilities
  fadeInOnScroll,
  parallax,
  staggerOnScroll,
  pinOnScroll,
  createTimeline,
  animateCounter,
  revealOnScroll,
  slideInOnScroll,
  rotateOnScroll,
  scaleOnScroll,

  // New enhanced utilities
  splitTextChars,
  animateTextChars,
  heroEntrance,
  scrollProgress,
  magneticEffect,
  imageReveal,
  cardGridStagger,
  floatingAnimation,
  batchScrollAnimation
}
