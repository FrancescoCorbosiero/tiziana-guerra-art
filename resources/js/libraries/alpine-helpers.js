/**
 * Alpine.js Integration Helpers
 * Connect libraries with Alpine components
 */

import { gsap } from 'gsap'

/**
 * Alpine Data: Swiper Controller
 */
export function alpineSwiperController(options = {}) {
  return {
    swiper: null,
    currentSlide: 0,

    init() {
      // Swiper is already initialized by initSwipers()
      // Just connect to it
      this.swiper = this.$el.swiper

      if (this.swiper) {
        this.swiper.on('slideChange', () => {
          this.currentSlide = this.swiper.activeIndex
        })
      }
    },

    next() {
      this.swiper?.slideNext()
    },

    prev() {
      this.swiper?.slidePrev()
    },

    goTo(index) {
      this.swiper?.slideTo(index)
    }
  }
}

/**
 * Alpine Data: GSAP Animation Trigger
 */
export function alpineGSAPTrigger() {
  return {
    animated: false,

    init() {
      const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
          if (entry.isIntersecting && !this.animated) {
            this.animate()
            this.animated = true
          }
        })
      })

      observer.observe(this.$el)
    },

    animate() {
      gsap.from(this.$el.children, {
        y: 50,
        opacity: 0,
        stagger: 0.1,
        duration: 0.6
      })
    }
  }
}

/**
 * Alpine Data: PhotoSwipe Gallery Controller
 */
export function alpineGalleryController() {
  return {
    items: [],

    init() {
      // Collect gallery items
      this.items = Array.from(this.$el.querySelectorAll('a')).map(link => ({
        src: link.href,
        width: parseInt(link.dataset.width) || 1200,
        height: parseInt(link.dataset.height) || 800,
        alt: link.querySelector('img')?.alt || ''
      }))
    },

    openGallery(index = 0) {
      // PhotoSwipe handles this automatically
      // This is just for custom triggers
    }
  }
}

/**
 * Alpine Data: Counter Animation
 * Animated number counter
 */
export function alpineCounterAnimation(targetValue, duration = 2) {
  return {
    value: 0,
    target: targetValue,

    init() {
      const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
          if (entry.isIntersecting) {
            this.startCounting()
            observer.disconnect()
          }
        })
      })

      observer.observe(this.$el)
    },

    startCounting() {
      gsap.to(this, {
        value: this.target,
        duration: duration,
        snap: { value: 1 },
        ease: 'power2.out'
      })
    }
  }
}

/**
 * Alpine Data: Parallax Container
 * Simple parallax effect using Alpine
 */
export function alpineParallaxContainer(speed = 0.5) {
  return {
    offset: 0,

    init() {
      window.addEventListener('scroll', () => {
        const rect = this.$el.getBoundingClientRect()
        const scrolled = window.pageYOffset
        this.offset = (scrolled - rect.top) * speed
      })
    }
  }
}

/**
 * Alpine Data: Scroll Progress Indicator
 */
export function alpineScrollProgress() {
  return {
    progress: 0,

    init() {
      window.addEventListener('scroll', () => {
        const winScroll = document.body.scrollTop || document.documentElement.scrollTop
        const height = document.documentElement.scrollHeight - document.documentElement.clientHeight
        this.progress = (winScroll / height) * 100
      })
    }
  }
}

/**
 * Alpine Data: AOS Refresh Controller
 * Useful for dynamic content
 */
export function alpineAOSController() {
  return {
    init() {
      // Refresh AOS when Alpine component is initialized
      if (window.AOS) {
        this.$nextTick(() => {
          window.AOS.refresh()
        })
      }
    },

    refresh() {
      if (window.AOS) {
        window.AOS.refresh()
      }
    }
  }
}

/**
 * Alpine Data: GSAP Timeline Controller
 * Control a GSAP timeline from Alpine
 */
export function alpineTimelineController() {
  return {
    timeline: null,
    isPlaying: false,

    init() {
      // Create a basic timeline
      this.timeline = gsap.timeline({ paused: true })

      // Add animations to timeline
      this.timeline.from(this.$el.children, {
        y: 50,
        opacity: 0,
        stagger: 0.1,
        duration: 0.6
      })
    },

    play() {
      this.timeline?.play()
      this.isPlaying = true
    },

    pause() {
      this.timeline?.pause()
      this.isPlaying = false
    },

    reverse() {
      this.timeline?.reverse()
    },

    restart() {
      this.timeline?.restart()
      this.isPlaying = true
    }
  }
}

// Export helpers for Alpine.js
export const AlpineLibraryHelpers = {
  swiperController: alpineSwiperController,
  gsapTrigger: alpineGSAPTrigger,
  galleryController: alpineGalleryController,
  counterAnimation: alpineCounterAnimation,
  parallaxContainer: alpineParallaxContainer,
  scrollProgress: alpineScrollProgress,
  aosController: alpineAOSController,
  timelineController: alpineTimelineController
}
