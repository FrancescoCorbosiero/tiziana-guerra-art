/**
 * Advanced Animations Utilities
 *
 * Divine-level animation utilities for stunning effects:
 * - Split text animation
 * - Mouse following effects
 * - Scroll-based morphing
 * - Particle systems
 * - 3D tilt effects
 */

/**
 * Split Text into spans for character-by-character animation
 * Usage: <h1 x-data x-init="$el.innerHTML = splitText($el.textContent)">
 */
export function splitText(text) {
  return text
    .split('')
    .map((char, i) => {
      if (char === ' ') return '<span class="char-space">&nbsp;</span>'
      return `<span class="char" style="--char-index: ${i}">${char}</span>`
    })
    .join('')
}

/**
 * Mouse Follow Effect
 * Creates element that follows mouse with smooth easing
 */
export function mouseFollow() {
  return {
    x: 0,
    y: 0,
    targetX: 0,
    targetY: 0,
    ease: 0.1,

    init() {
      window.addEventListener('mousemove', (e) => {
        this.targetX = e.clientX
        this.targetY = e.clientY
      })

      this.animate()
    },

    animate() {
      this.x += (this.targetX - this.x) * this.ease
      this.y += (this.targetY - this.y) * this.ease

      requestAnimationFrame(() => this.animate())
    },

    get style() {
      return `transform: translate(${this.x}px, ${this.y}px)`
    }
  }
}

/**
 * Tilt 3D Effect
 * Creates 3D tilt effect on mouse move
 */
export function tilt3D(strength = 10) {
  return {
    rotateX: 0,
    rotateY: 0,

    handleMove(e) {
      const rect = e.currentTarget.getBoundingClientRect()
      const centerX = rect.left + rect.width / 2
      const centerY = rect.top + rect.height / 2

      const deltaX = (e.clientX - centerX) / rect.width
      const deltaY = (e.clientY - centerY) / rect.height

      this.rotateY = deltaX * strength
      this.rotateX = -deltaY * strength
    },

    handleLeave() {
      this.rotateX = 0
      this.rotateY = 0
    },

    get style() {
      return `transform: perspective(1000px) rotateX(${this.rotateX}deg) rotateY(${this.rotateY}deg)`
    }
  }
}

/**
 * Count Up Animation
 * Animates numbers counting up
 */
export function countUp(target, duration = 2000) {
  return {
    current: 0,
    target: target,

    init() {
      const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
          if (entry.isIntersecting) {
            this.animate()
            observer.unobserve(entry.target)
          }
        })
      })

      observer.observe(this.$el)
    },

    animate() {
      const increment = this.target / (duration / 16)
      const timer = setInterval(() => {
        this.current += increment
        if (this.current >= this.target) {
          this.current = this.target
          clearInterval(timer)
        }
      }, 16)
    },

    get display() {
      return Math.round(this.current)
    }
  }
}

/**
 * Magnetic Button Effect
 * Button that follows mouse when nearby
 */
export function magneticButton(strength = 0.3) {
  return {
    x: 0,
    y: 0,

    handleMove(e) {
      const rect = e.currentTarget.getBoundingClientRect()
      const centerX = rect.left + rect.width / 2
      const centerY = rect.top + rect.height / 2

      const deltaX = (e.clientX - centerX) * strength
      const deltaY = (e.clientY - centerY) * strength

      this.x = deltaX
      this.y = deltaY
    },

    handleLeave() {
      this.x = 0
      this.y = 0
    },

    get style() {
      return `transform: translate(${this.x}px, ${this.y}px)`
    }
  }
}

/**
 * Parallax Scroll Effect
 * Elements move at different speeds on scroll
 */
export function parallax(speed = 0.5) {
  return {
    offset: 0,

    init() {
      window.addEventListener('scroll', () => {
        const rect = this.$el.getBoundingClientRect()
        const scrolled = window.scrollY
        this.offset = scrolled * speed
      })
    },

    get style() {
      return `transform: translateY(${this.offset}px)`
    }
  }
}

/**
 * Morph Gradient on Scroll
 * Gradient changes based on scroll position
 */
export function morphGradient() {
  return {
    hue: 220,

    init() {
      window.addEventListener('scroll', () => {
        const scrollPercent = window.scrollY / (document.documentElement.scrollHeight - window.innerHeight)
        this.hue = 220 + (scrollPercent * 60) // 220 to 280
      })
    },

    get style() {
      return `background: linear-gradient(135deg, hsl(${this.hue}, 70%, 50%), hsl(${this.hue + 30}, 70%, 60%))`
    }
  }
}

/**
 * Reveal on Scroll
 * Element reveals with custom animation
 */
export function revealOnScroll(animation = 'fade-up') {
  return {
    visible: false,

    init() {
      // Check if element is already visible on page load
      const rect = this.$el.getBoundingClientRect()
      const isInitiallyVisible = rect.top < window.innerHeight && rect.bottom > 0

      if (isInitiallyVisible) {
        // Element is already in viewport, show immediately
        this.visible = true
      } else {
        // Element is below fold, use IntersectionObserver
        const observer = new IntersectionObserver((entries) => {
          entries.forEach(entry => {
            if (entry.isIntersecting) {
              this.visible = true
              observer.unobserve(entry.target)
            }
          })
        }, { threshold: 0.1 })

        observer.observe(this.$el)
      }
    }
  }
}

/**
 * Stagger Children Animation
 * Animate children with delay
 */
export function stagger(delay = 100) {
  return {
    init() {
      const children = this.$el.children
      Array.from(children).forEach((child, i) => {
        child.style.animationDelay = `${i * delay}ms`
      })
    }
  }
}

// Export all utilities
window.splitText = splitText
window.mouseFollow = mouseFollow
window.tilt3D = tilt3D
window.countUp = countUp
window.magneticButton = magneticButton
window.parallax = parallax
window.morphGradient = morphGradient
window.revealOnScroll = revealOnScroll
window.stagger = stagger
