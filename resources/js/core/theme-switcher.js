/**
 * Theme Switcher
 * Handles dark/light mode switching with system preference detection
 */

/**
 * Initialize theme switcher
 */
export function initThemeSwitcher() {
  const html = document.documentElement
  const toggle = document.querySelector('[data-theme-toggle]')

  // Get stored theme preference or system preference
  const getPreferredTheme = () => {
    const stored = localStorage.getItem('theme')
    if (stored) {
      return stored
    }

    return window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light'
  }

  // Apply theme to document
  const applyTheme = (theme) => {
    html.dataset.theme = theme
    localStorage.setItem('theme', theme)
    updateToggleIcons(theme)

    // Emit custom event
    window.dispatchEvent(new CustomEvent('themechange', { detail: { theme } }))
  }

  // Update toggle button icons
  const updateToggleIcons = (theme) => {
    if (!toggle) return

    const lightIcon = toggle.querySelector('.theme-toggle__icon--light')
    const darkIcon = toggle.querySelector('.theme-toggle__icon--dark')

    if (theme === 'dark') {
      lightIcon.style.display = 'none'
      darkIcon.style.display = 'block'
    } else {
      lightIcon.style.display = 'block'
      darkIcon.style.display = 'none'
    }
  }

  // Toggle theme
  const toggleTheme = (e) => {
    e.preventDefault()
    const current = html.dataset.theme
    const next = current === 'dark' ? 'light' : 'dark'
    applyTheme(next)
  }

  // Initialize with preferred theme
  applyTheme(getPreferredTheme())

  // Handle toggle button click
  if (toggle) {
    toggle.addEventListener('click', toggleTheme)
  }

  // Listen for system preference changes
  window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', (e) => {
    // Only auto-switch if user hasn't set a preference
    if (!localStorage.getItem('theme')) {
      applyTheme(e.matches ? 'dark' : 'light')
    }
  })
}
