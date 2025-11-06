/**
 * View Transitions
 *
 * DISABLED by default due to conflicts with WordPress admin bar and content preservation issues.
 * Can be enabled for specific use cases, but requires careful implementation.
 *
 * Issues when enabled:
 * - Conflicts with WordPress admin bar
 * - Doesn't reinitialize WordPress scripts
 * - Doesn't reinitialize scroll animations
 * - Causes "ghost content" preservation between pages
 * - Aggressive speculation can cause UX issues
 */

/**
 * Initialize view transitions
 *
 * ENABLED with WordPress compatibility fixes
 */
export function initViewTransitions() {
  // Enable View Transitions with proper safeguards
  return enableViewTransitions()
}

/**
 * Enable view transitions (use with caution)
 */
function enableViewTransitions() {
  // Check if View Transitions API is supported
  if (!document.startViewTransition) {
    console.info('View Transitions API not supported by browser')
    return
  }

  // Don't enable in WordPress admin
  if (document.body.classList.contains('wp-admin') ||
      document.body.classList.contains('wp-core-ui') ||
      document.querySelector('#wpadminbar')) {
    console.info('View Transitions: Disabled in WordPress admin')
    return
  }

  // Intercept navigation clicks
  document.addEventListener('click', (e) => {
    const link = e.target.closest('a')

    // Debug logging
    if (link) {
      console.log('[ViewTransitions] Link clicked:', link.href, 'intercept:', shouldInterceptNavigation(link))
    }

    if (shouldInterceptNavigation(link)) {
      e.preventDefault()
      console.log('[ViewTransitions] Intercepting navigation to:', link.href)
      navigateWithTransition(link.href)
    }
  })

  // Handle browser back/forward
  window.addEventListener('popstate', () => {
    navigateWithTransition(window.location.href, false)
  })

  console.info('View Transitions: Enabled')
}

/**
 * Check if navigation should be intercepted
 */
function shouldInterceptNavigation(link) {
  if (!link) return false
  if (!link.href) return false // No href attribute
  if (link.target === '_blank') return false
  if (link.getAttribute('download')) return false
  if (link.classList.contains('no-transition')) return false

  // Don't intercept special protocols
  if (link.href.startsWith('mailto:') ||
      link.href.startsWith('tel:') ||
      link.href.startsWith('javascript:') ||
      link.href === '#' ||
      link.href.endsWith('#')) return false

  try {
    const url = new URL(link.href)
    const currentUrl = new URL(window.location.href)

    // Only intercept same-origin links
    if (url.origin !== currentUrl.origin) return false

    // Don't intercept hash links on same page
    if (url.pathname === currentUrl.pathname && url.hash) return false

    // Don't intercept if we're already on the exact same URL
    if (url.href === currentUrl.href) return false

    // Don't intercept WordPress admin links
    if (url.pathname.includes('/wp-admin/') || url.pathname.includes('/wp-login.php')) return false

    return true
  } catch (e) {
    // Invalid URL, don't intercept
    console.warn('[ViewTransitions] Invalid URL:', link.href, e)
    return false
  }
}

/**
 * Navigate to URL with view transition
 */
async function navigateWithTransition(url, updateHistory = true) {
  try {
    // Show loading indicator
    document.documentElement.classList.add('is-navigating')

    // Fetch the new page
    const response = await fetch(url, {
      headers: {
        'X-Requested-With': 'XMLHttpRequest' // Let WordPress know this is AJAX
      }
    })

    if (!response.ok) {
      throw new Error(`HTTP error! status: ${response.status}`)
    }

    const html = await response.text()

    // Parse the HTML
    const parser = new DOMParser()
    const doc = parser.parseFromString(html, 'text/html')

    // CRITICAL: Verify we have valid content
    const newMain = doc.querySelector('main#main')
    const oldMain = document.querySelector('main#main')

    if (!newMain || !oldMain) {
      throw new Error('Required elements not found, falling back to full navigation')
    }

    // Start view transition
    const transition = document.startViewTransition(() => {
      // CRITICAL FIX: Clear old content completely before swapping
      oldMain.innerHTML = ''

      // Force reflow to ensure clear
      void oldMain.offsetHeight

      // Now swap in new content
      oldMain.innerHTML = newMain.innerHTML

      // Update the title
      document.title = doc.title

      // Update meta tags
      updateMetaTags(doc)

      // Update body classes (important for WordPress context)
      const newBodyClasses = doc.body.className
      document.body.className = newBodyClasses

      // Update URL
      if (updateHistory) {
        history.pushState({ url }, '', url)
      }

      // Remove loading indicator
      document.documentElement.classList.remove('is-navigating')
    })

    // Wait for transition to complete
    await transition.finished

    // CRITICAL: Reinitialize WordPress and theme scripts
    await reinitializeScripts()

    // Dispatch event for other scripts to listen to
    window.dispatchEvent(new CustomEvent('pagechange', { detail: { url } }))

    // Scroll to top smoothly
    window.scrollTo({ top: 0, behavior: 'instant' })

    console.info('View transition completed:', url)

  } catch (error) {
    console.error('View transition failed:', error)

    // Remove loading indicator
    document.documentElement.classList.remove('is-navigating')

    // Fallback to normal navigation on error
    window.location.href = url
  }
}

/**
 * Update meta tags from new document
 */
function updateMetaTags(doc) {
  // Update description
  const description = doc.querySelector('meta[name="description"]')
  const currentDescription = document.querySelector('meta[name="description"]')

  if (description && currentDescription) {
    currentDescription.setAttribute('content', description.getAttribute('content'))
  }

  // Update OG tags
  const ogTags = doc.querySelectorAll('meta[property^="og:"]')
  ogTags.forEach(tag => {
    const property = tag.getAttribute('property')
    const current = document.querySelector(`meta[property="${property}"]`)

    if (current) {
      current.setAttribute('content', tag.getAttribute('content'))
    }
  })
}

/**
 * Reinitialize scripts after content swap
 * CRITICAL for WordPress compatibility
 */
async function reinitializeScripts() {
  // Small delay to ensure DOM is ready
  await new Promise(resolve => setTimeout(resolve, 50))

  // Reinitialize WordPress scripts
  if (window.wp && window.wp.domReady) {
    try {
      window.wp.domReady()
    } catch (e) {
      console.warn('WordPress domReady failed:', e)
    }
  }

  // Reinitialize Alpine.js if present
  if (window.Alpine) {
    try {
      window.Alpine.destroyTree(document.body)
      window.Alpine.initTree(document.body)
    } catch (e) {
      console.warn('Alpine.js reinitialization failed:', e)
    }
  }

  // CRITICAL: Reinitialize scroll animations
  // This is handled by the pagechange event listener in animations.js

  // Trigger DOMContentLoaded for other scripts
  const domReadyEvent = new Event('DOMContentLoaded', {
    bubbles: true,
    cancelable: true
  })
  document.dispatchEvent(domReadyEvent)

  console.info('Scripts reinitialized after view transition')
}

