# View Transitions - WordPress-Compatible Implementation

## Overview

View Transitions API provides SPA-like navigation enhancements while maintaining WordPress compatibility. This is a **core architectural feature** of the theme that provides smooth page transitions without full page reloads.

## Previous Issues (Now Fixed)

The original implementation had critical bugs:

1. **Content Preservation**: "Ghost content" from previous pages preserved on new pages
2. **WordPress Admin Conflicts**: Didn't detect/skip WordPress admin context
3. **Animation Issues**: Scroll animations not reinitializing on page swaps
4. **Script Conflicts**: WordPress scripts not reinitializing properly

## Solution Implemented

### 1. Enhanced Content Swapping with Proper Cleanup

**File:** `resources/js/core/view-transitions.js`

**Key Fix:**
```javascript
// CRITICAL FIX: Clear old content completely before swapping
oldMain.innerHTML = ''

// Force reflow to ensure clear
void oldMain.offsetHeight

// Now swap in new content
oldMain.innerHTML = newMain.innerHTML
```

This prevents "ghost content" by:
- Completely clearing old content first
- Forcing a browser reflow
- Only then swapping in new content

### 2. WordPress Admin Detection

**Safeguard:**
```javascript
// Don't enable in WordPress admin
if (document.body.classList.contains('wp-admin') ||
    document.body.classList.contains('wp-core-ui') ||
    document.querySelector('#wpadminbar')) {
  console.info('View Transitions: Disabled in WordPress admin')
  return
}
```

Prevents View Transitions from:
- Running in WordPress admin pages
- Interfering with admin bar
- Breaking WordPress editor

### 3. Proper Script Reinitialization

**Enhancement:**
```javascript
async function reinitializeScripts() {
  // Small delay to ensure DOM is ready
  await new Promise(resolve => setTimeout(resolve, 50))

  // Reinitialize WordPress scripts
  if (window.wp && window.wp.domReady) {
    window.wp.domReady()
  }

  // Reinitialize Alpine.js
  if (window.Alpine) {
    window.Alpine.destroyTree(document.body)
    window.Alpine.initTree(document.body)
  }

  // Trigger pagechange event for scroll animations
  window.dispatchEvent(new CustomEvent('pagechange'))
}
```

Ensures all scripts work after transition:
- WordPress core scripts
- Alpine.js reactivity
- Scroll animations
- Custom theme scripts

### 4. Enhanced Animation Cleanup

**File:** `resources/js/core/animations.js`

**Enhancements:**
```javascript
function initScrollAnimations() {
  // Cleanup existing observer if any
  if (animationObserver) {
    animationObserver.disconnect()
    animationObserver = null
  }

  // Create new observer and observe elements
  animatedElements.forEach(el => {
    // Remove any stale animate-in class
    if (el.classList.contains('animate-in')) {
      el.classList.remove('animate-in')
    }
    animationObserver.observe(el)
  })
}

// Reinitialize on page change
window.addEventListener('pagechange', initScrollAnimations)
```

Prevents animation issues by:
- Cleaning up old observers
- Removing stale animation classes
- Reinitializing on page changes

### 5. Visual Loading Feedback

**File:** `resources/css/foundation/_animations.css`

Added animated loading bar:
```css
html.is-navigating::before {
  content: '';
  position: fixed;
  top: 0;
  left: 0;
  right: 0;
  height: 3px;
  background: linear-gradient(/* brand colors */);
  animation: loading-bar 1s ease-in-out infinite;
  z-index: 9999;
}
```

Provides UX feedback:
- Animated gradient bar at top
- Shows during navigation
- Prevents confusion during load

### 6. Additional Safeguards

**Content Verification:**
```javascript
// Verify we have valid content
const newMain = doc.querySelector('main#main')
const oldMain = document.querySelector('main#main')

if (!newMain || !oldMain) {
  throw new Error('Required elements not found, falling back')
}
```

**AJAX Header:**
```javascript
const response = await fetch(url, {
  headers: {
    'X-Requested-With': 'XMLHttpRequest'
  }
})
```

**Skip Links:**
- External links (different origin)
- Download links
- mailto: and tel: links
- WordPress admin links
- Links with `.no-transition` class
- Hash links on same page

## Testing

After these fixes, the theme now:

✅ **Smooth page transitions** - SPA-like experience maintained
✅ **No content preservation** - Complete content clear before swap
✅ **WordPress admin compatible** - Detects and skips admin context
✅ **Animations reinitialize** - Scroll animations work on each page
✅ **Scripts reinitialize** - WordPress/Alpine.js work correctly
✅ **Visual feedback** - Loading bar shows during navigation
✅ **Graceful fallback** - Full navigation on errors

## Browser Console Messages

You'll now see:
```
View Transitions: Enabled
Scroll animations initialized: X elements
View transition completed: /page-url
Scripts reinitialized after view transition
```

This confirms the feature is working correctly with all safeguards.

## How to Skip Transitions on Specific Links

Add the `no-transition` class to any link:
```html
<a href="/page" class="no-transition">Normal Navigation</a>
```

Automatically skipped:
- External links
- Download links
- mailto: and tel: links
- WordPress admin links
- Hash links on same page

## Performance Impact

**Positive:**
- Faster perceived page loads
- Smoother user experience
- Reduced bandwidth (partial page loads)
- Modern app-like feel

**Considerations:**
- Small increase in JavaScript overhead
- Requires modern browser (graceful fallback included)
- Slightly more complex debugging

## Browser Support

**Supported:**
- Chrome 111+
- Edge 111+
- Opera 97+

**Graceful Fallback:**
- Firefox, Safari, older browsers → Normal navigation
- No broken functionality, just traditional page loads

## Troubleshooting

**If you see content preservation:**
1. Check browser console for errors
2. Verify `main#main` element exists on all pages
3. Clear browser cache
4. Check if custom scripts interfere

**If transitions don't work:**
1. Check browser support (Chrome 111+)
2. Verify no JavaScript errors in console
3. Ensure View Transitions API available

**To disable if needed:**
```javascript
// In view-transitions.js, change line 22 to:
export function initViewTransitions() {
  // Disabled
  return
}
```

---

**Status:** ✅ **ENABLED** with WordPress Compatibility Fixes
**Updated:** 2025-10-22
**Version:** 2.0.0 (Enhanced Implementation)
