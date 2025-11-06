/**
 * Accessibility Enhancements
 * Focus management, keyboard navigation, and screen reader support
 */

/**
 * Initialize accessibility features
 */
export function initAccessibility() {
  initFocusManagement()
  initKeyboardShortcuts()
  initAriaLiveAnnouncer()
  initSkipLink()
}

/**
 * Focus management for modals and overlays
 */
function initFocusManagement() {
  // Focus trap for modals
  document.addEventListener('keydown', (e) => {
    if (e.key === 'Tab') {
      const modal = document.querySelector('[role="dialog"][aria-modal="true"]')

      if (modal) {
        trapFocus(e, modal)
      }
    }
  })
}

/**
 * Trap focus within an element
 */
function trapFocus(event, element) {
  const focusableElements = element.querySelectorAll(
    'button, [href], input, select, textarea, [tabindex]:not([tabindex="-1"])'
  )

  const firstFocusable = focusableElements[0]
  const lastFocusable = focusableElements[focusableElements.length - 1]

  if (event.shiftKey && document.activeElement === firstFocusable) {
    event.preventDefault()
    lastFocusable.focus()
  } else if (!event.shiftKey && document.activeElement === lastFocusable) {
    event.preventDefault()
    firstFocusable.focus()
  }
}

/**
 * Keyboard shortcuts
 */
function initKeyboardShortcuts() {
  document.addEventListener('keydown', (e) => {
    // ESC key to close modals/overlays
    if (e.key === 'Escape') {
      closeAllOverlays()
    }

    // / key to focus search (like GitHub)
    if (e.key === '/' && !isInputFocused()) {
      e.preventDefault()
      const searchInput = document.querySelector('input[type="search"]')
      if (searchInput) {
        searchInput.focus()
      }
    }
  })
}

/**
 * Close all overlays (modals, dropdowns, mobile menu)
 */
function closeAllOverlays() {
  // Close mobile menu
  const mobileToggle = document.querySelector('[data-mobile-menu-toggle]')
  const mobileMenu = document.querySelector('[data-mobile-menu]')

  if (mobileToggle && mobileMenu) {
    mobileToggle.setAttribute('aria-expanded', 'false')
    mobileMenu.style.display = 'none'
  }

  // Close modals
  const modals = document.querySelectorAll('[role="dialog"][aria-modal="true"]')
  modals.forEach(modal => {
    modal.style.display = 'none'
    modal.setAttribute('aria-hidden', 'true')
  })
}

/**
 * Check if an input element is focused
 */
function isInputFocused() {
  const activeElement = document.activeElement

  return (
    activeElement.tagName === 'INPUT' ||
    activeElement.tagName === 'TEXTAREA' ||
    activeElement.tagName === 'SELECT' ||
    activeElement.isContentEditable
  )
}

/**
 * ARIA live region announcer
 */
function initAriaLiveAnnouncer() {
  // Create live region if it doesn't exist
  if (!document.querySelector('[role="status"][aria-live="polite"]')) {
    const announcer = document.createElement('div')
    announcer.setAttribute('role', 'status')
    announcer.setAttribute('aria-live', 'polite')
    announcer.setAttribute('aria-atomic', 'true')
    announcer.className = 'sr-only'
    document.body.appendChild(announcer)
  }
}

/**
 * Announce message to screen readers
 */
export function announce(message) {
  const announcer = document.querySelector('[role="status"][aria-live="polite"]')

  if (announcer) {
    // Clear previous message
    announcer.textContent = ''

    // Announce new message after a brief delay
    setTimeout(() => {
      announcer.textContent = message
    }, 100)
  }
}

/**
 * Skip link functionality
 */
function initSkipLink() {
  const skipLink = document.querySelector('.skip-link')

  if (skipLink) {
    skipLink.addEventListener('click', (e) => {
      const target = document.querySelector(skipLink.getAttribute('href'))

      if (target) {
        e.preventDefault()
        target.setAttribute('tabindex', '-1')
        target.focus()
      }
    })
  }
}
