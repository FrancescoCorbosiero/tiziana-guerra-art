/**
 * Navigation
 * Enhanced navigation with mobile menu, smooth scroll, and prefetching
 */

/**
 * Initialize navigation
 */
export function initNavigation() {
  initMobileMenu()
  initSmoothScroll()
  initStickyHeader()
  initActiveLinkHighlight()
}

/**
 * Mobile menu toggle
 */
function initMobileMenu() {
  const toggle = document.querySelector('[data-mobile-menu-toggle]')
  const menu = document.querySelector('[data-mobile-menu]')

  if (!toggle || !menu) return

  toggle.addEventListener('click', () => {
    const isExpanded = toggle.getAttribute('aria-expanded') === 'true'

    toggle.setAttribute('aria-expanded', !isExpanded)
    menu.style.display = isExpanded ? 'none' : 'block'
  })

  // Close menu when clicking outside
  document.addEventListener('click', (e) => {
    if (!toggle.contains(e.target) && !menu.contains(e.target)) {
      toggle.setAttribute('aria-expanded', 'false')
      menu.style.display = 'none'
    }
  })

  // Close menu on window resize (if viewport becomes large)
  let resizeTimer
  window.addEventListener('resize', () => {
    clearTimeout(resizeTimer)
    resizeTimer = setTimeout(() => {
      if (window.innerWidth >= 768) {
        toggle.setAttribute('aria-expanded', 'false')
        menu.style.display = 'none'
      }
    }, 250)
  })
}

/**
 * Smooth scroll for anchor links
 */
function initSmoothScroll() {
  document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function (e) {
      const href = this.getAttribute('href')
      if (href === '#') return

      const target = document.querySelector(href)
      if (target) {
        e.preventDefault()
        target.scrollIntoView({
          behavior: 'smooth',
          block: 'start'
        })

        // Update URL without page jump
        history.pushState(null, '', href)
      }
    })
  })
}

/**
 * Sticky header with scroll direction detection
 */
function initStickyHeader() {
  const header = document.querySelector('.site-header')
  if (!header) return

  let lastScroll = 0
  let ticking = false

  window.addEventListener('scroll', () => {
    if (!ticking) {
      window.requestAnimationFrame(() => {
        const currentScroll = window.pageYOffset

        // Add/remove shadow based on scroll position
        if (currentScroll > 10) {
          header.style.boxShadow = 'var(--shadow-sm)'
        } else {
          header.style.boxShadow = 'none'
        }

        lastScroll = currentScroll
        ticking = false
      })

      ticking = true
    }
  })
}

/**
 * Highlight active navigation link
 */
function initActiveLinkHighlight() {
  const navLinks = document.querySelectorAll('.header__nav a, .mobile-menu a')
  const currentPath = window.location.pathname

  navLinks.forEach(link => {
    const linkPath = new URL(link.href).pathname

    if (linkPath === currentPath) {
      link.setAttribute('aria-current', 'page')
      link.style.color = 'var(--color-brand-primary)'
      link.style.fontWeight = 'var(--font-weight-semibold)'
    }
  })
}
