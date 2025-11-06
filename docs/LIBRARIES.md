# 📚 Third-Party Libraries Guide

## Overview

This theme integrates 6 premium JavaScript and CSS libraries for advanced animations, UI components, and effects. All libraries are configured to work seamlessly with Alpine.js and the existing design system.

## Installed Libraries

### Animation Libraries
- **GSAP v3.x** - Professional-grade animation engine with ScrollTrigger
- **AOS v3.x** - Lightweight scroll animation library

### UI Component Libraries
- **Shoelace v2.x** - Modern web components library
- **Swiper v11.x** - Touch-enabled carousel/slider
- **PhotoSwipe v5.x** - JavaScript image gallery and lightbox

### Effect Libraries
- **Vanta.js v0.5.x** - Animated 3D backgrounds (requires Three.js)
- **Three.js v0.160.x** - 3D graphics library (peer dependency)

---

## Quick Start

All libraries are automatically initialized on page load. You can use them immediately in your Blade templates or JavaScript code.

### Check Installation

After running `npm run dev`, you should see in the console:
```
✅ GSAP initialized with ScrollTrigger
✅ AOS initialized
✅ Shoelace initialized
✅ Swiper initialized (X instances)
✅ PhotoSwipe initialized
🎉 All libraries initialized successfully
🚀 Theme fully initialized with all libraries
```

---

## Usage Examples

### 1. GSAP Animations

#### Basic Usage (JavaScript)
```javascript
import { fadeInOnScroll } from './libraries/utilities'

// Fade in elements on scroll
fadeInOnScroll('.my-element', {
  y: 100,
  duration: 1,
  stagger: 0.2
})

// Parallax effect
parallax('.parallax-element', 0.5)

// Counter animation
animateCounter('.stat-number', 1000, 2)
```

#### Using Global GSAPUtils
```javascript
// Available globally via window.GSAPUtils
GSAPUtils.slideInOnScroll('.hero-content', 'left')
GSAPUtils.rotateOnScroll('.rotating-logo', 360)
GSAPUtils.scaleOnScroll('.scale-element', 1.5)
```

#### Alpine.js Integration
```blade
<div x-data="gsapTrigger">
  <!-- Children will animate in with stagger on scroll -->
  <div>Item 1</div>
  <div>Item 2</div>
  <div>Item 3</div>
</div>
```

### 2. AOS (Animate On Scroll)

#### Basic Usage
```blade
<div data-aos="fade-up">
  Content fades up on scroll
</div>

<div data-aos="fade-left" data-aos-delay="200">
  Content fades from left with delay
</div>

<div data-aos="zoom-in" data-aos-duration="1000">
  Content zooms in slowly
</div>
```

#### Available Animations
- Fade: `fade`, `fade-up`, `fade-down`, `fade-left`, `fade-right`
- Flip: `flip-up`, `flip-down`, `flip-left`, `flip-right`
- Slide: `slide-up`, `slide-down`, `slide-left`, `slide-right`
- Zoom: `zoom-in`, `zoom-out`

#### Using Component
```blade
<x-animated-section animation="fade-up" :delay="200" :duration="800">
  <h2>Animated Section</h2>
  <p>This entire section animates on scroll</p>
</x-animated-section>
```

### 3. Swiper Carousel

#### Using Component
```blade
<x-carousel :slides="[
  [
    'image' => '/path/to/image1.jpg',
    'title' => 'Slide 1',
    'content' => 'Description here',
    'link' => ['url' => '/page', 'text' => 'Learn More']
  ],
  [
    'image' => '/path/to/image2.jpg',
    'title' => 'Slide 2',
    'content' => 'Another description'
  ],
  [
    'image' => '/path/to/image3.jpg',
    'title' => 'Slide 3'
  ]
]" />
```

#### Alpine.js Controller
```blade
<div class="swiper" x-data="swiperController">
  <div class="swiper-wrapper">
    <!-- Slides -->
  </div>

  <!-- Custom controls -->
  <button @click="prev()">Previous</button>
  <button @click="next()">Next</button>
  <span x-text="currentSlide"></span>
</div>
```

#### Manual Initialization
```javascript
import Swiper from 'swiper'
import { Navigation, Pagination } from 'swiper/modules'

const swiper = new Swiper('.my-swiper', {
  modules: [Navigation, Pagination],
  slidesPerView: 3,
  spaceBetween: 30,
  navigation: {
    nextEl: '.swiper-button-next',
    prevEl: '.swiper-button-prev',
  }
})
```

### 4. PhotoSwipe Gallery

#### Using Component
```blade
<x-gallery :images="[
  [
    'full' => '/images/full/photo1.jpg',
    'thumbnail' => '/images/thumbs/photo1.jpg',
    'width' => 1920,
    'height' => 1080,
    'alt' => 'Photo description',
    'caption' => 'Optional caption'
  ],
  [
    'full' => '/images/full/photo2.jpg',
    'thumbnail' => '/images/thumbs/photo2.jpg',
    'width' => 1920,
    'height' => 1080
  ]
]" :columns="3" />
```

#### Manual HTML
```blade
<div class="gallery" x-data="galleryController">
  <a
    href="/full-image.jpg"
    data-pswp-width="1920"
    data-pswp-height="1080"
  >
    <img src="/thumbnail.jpg" alt="Image description">
  </a>
  <!-- More images... -->
</div>
```

### 5. Vanta.js Backgrounds

#### Using Component
```blade
<x-vanta-background color="#1a365d" id="hero-bg">
  <div class="hero-content">
    <h1>Amazing Hero Section</h1>
    <p>With animated 3D background</p>
  </div>
</x-vanta-background>
```

#### Manual Initialization
```javascript
import { initVanta } from './libraries/init-libraries'

// Initialize on specific element
initVanta('#custom-vanta-element')
```

#### Available Effects
- `vanta.waves` (default)
- `vanta.fog`
- `vanta.clouds`
- `vanta.birds`
- `vanta.net`

Change import in `init-libraries.js`:
```javascript
// Replace VantaWaves with another effect
import VantaFog from 'vanta/src/vanta.fog'
// or
import VantaClouds from 'vanta/src/vanta.clouds'
// or
import VantaBirds from 'vanta/src/vanta.birds'

// Then use in initVanta:
const vantaEffect = VantaFog({ el, THREE, ... })
```

### 6. Shoelace Web Components

#### Basic Usage
```blade
<sl-button variant="primary">Click Me</sl-button>

<sl-dialog label="Dialog Title" class="dialog-overview">
  <p>Dialog content</p>
  <sl-button slot="footer" variant="primary">Close</sl-button>
</sl-dialog>

<sl-alert variant="primary" open>
  <sl-icon slot="icon" name="info-circle"></sl-icon>
  This is an alert message
</sl-alert>
```

#### Available Components
- Buttons, inputs, selects, textareas
- Dialogs, drawers, dropdowns
- Alerts, badges, cards
- Progress bars, spinners
- And many more...

[Full Shoelace docs](https://shoelace.style/)

---

## Alpine.js Integration

### Available Alpine Data Functions

All registered automatically and ready to use:

1. **swiperController** - Control Swiper instances
2. **gsapTrigger** - Auto-animate children on scroll
3. **galleryController** - PhotoSwipe gallery controller
4. **counterAnimation** - Animated number counter
5. **parallaxContainer** - Simple parallax effect
6. **scrollProgress** - Track scroll progress
7. **aosController** - Refresh AOS for dynamic content
8. **timelineController** - Control GSAP timelines

### Examples

#### Counter Animation
```blade
<div x-data="counterAnimation(1000, 2)">
  <span x-text="Math.round(value)"></span>
</div>
```

#### Scroll Progress Bar
```blade
<div x-data="scrollProgress">
  <div class="progress-bar" :style="`width: ${progress}%`"></div>
</div>
```

#### Parallax Container
```blade
<div x-data="parallaxContainer(0.5)">
  <div :style="`transform: translateY(${offset}px)`">
    Parallax content
  </div>
</div>
```

---

## Performance Considerations

### Bundle Sizes
- **GSAP**: ~30KB
- **AOS**: ~5KB
- **Swiper**: ~40KB
- **PhotoSwipe**: ~15KB
- **Shoelace**: ~50KB (only used components)
- **Vanta + Three.js**: ~150KB (only loads when used)

**Total (without Vanta)**: ~140KB JS + ~50KB CSS
**Total (with Vanta)**: ~290KB JS

### Optimization Tips

1. **Disable AOS on mobile** (already configured):
   ```javascript
   AOS.init({
     disable: 'mobile'
   })
   ```

2. **Lazy load Vanta**:
   Only include Vanta components on pages that need them.

3. **Limit Swiper instances**:
   Each Swiper instance adds overhead.

4. **Use AOS for simple animations**:
   Reserve GSAP for complex animations.

5. **Tree-shaking Shoelace**:
   Only import components you use.

---

## Troubleshooting

### GSAP animations not working
- Check ScrollTrigger is registered: `gsap.registerPlugin(ScrollTrigger)`
- Ensure elements exist before animating
- Check browser console for errors

### AOS not animating
- Verify `data-aos` attributes are correct
- Call `AOS.refresh()` after dynamic content loads
- Check if disabled on mobile

### Swiper not initializing
- Ensure HTML structure is correct (`.swiper > .swiper-wrapper > .swiper-slide`)
- Check if modules are imported and passed to config
- Verify element exists when `initSwipers()` is called

### PhotoSwipe not opening
- Check `data-pswp-width` and `data-pswp-height` attributes exist
- Ensure parent has class `.gallery`
- Verify image links are correct

### Vanta not rendering
- Check Three.js is imported
- Ensure target element has ID
- Verify element exists before calling `initVanta()`
- Check browser console for WebGL errors

### Shoelace components not styling
- Verify base path is set correctly
- Check if assets are accessible
- Ensure component names are correct (hyphenated)

---

## Customization

### Override Library Styles

Edit `resources/css/vendor/_library-overrides.css`:

```css
/* Example: Change Swiper button colors */
.swiper-button-next,
.swiper-button-prev {
  color: var(--color-brand-secondary);
}

/* Example: Adjust AOS timing */
[data-aos] {
  transition-duration: 1s !important;
}
```

### Custom GSAP Animations

Add to `resources/js/libraries/utilities.js`:

```javascript
export function customAnimation(selector, options = {}) {
  gsap.from(selector, {
    scrollTrigger: {
      trigger: selector,
      start: 'top 80%',
    },
    ...options
  })
}
```

### Custom Alpine Helpers

Add to `resources/js/libraries/alpine-helpers.js`:

```javascript
export function customAlpineHelper() {
  return {
    // Your Alpine component data/methods
  }
}

// Register in app.js
Alpine.data('customHelper', customAlpineHelper)
```

---

## API Reference

### GSAP Utils

```javascript
// Available via window.GSAPUtils
GSAPUtils.fadeInOnScroll(selector, options)
GSAPUtils.parallax(selector, speed)
GSAPUtils.staggerOnScroll(selector, childSelector)
GSAPUtils.pinOnScroll(selector, endTrigger)
GSAPUtils.createTimeline(options)
GSAPUtils.animateCounter(selector, endValue, duration)
GSAPUtils.revealOnScroll(selector, options)
GSAPUtils.slideInOnScroll(selector, direction, options)
GSAPUtils.rotateOnScroll(selector, degrees)
GSAPUtils.scaleOnScroll(selector, scale)
```

### Init Functions

```javascript
import {
  initGSAP,
  initAOS,
  initSwipers,
  initPhotoSwipe,
  initVanta,
  initShoelace,
  initAllLibraries
} from './libraries/init-libraries'

// Initialize individual library
initGSAP()
initAOS()

// Or initialize all at once (default)
initAllLibraries()
```

---

## Resources

- [GSAP Documentation](https://greensock.com/docs/)
- [AOS Documentation](https://michalsnik.github.io/aos/)
- [Swiper Documentation](https://swiperjs.com/)
- [PhotoSwipe Documentation](https://photoswipe.com/)
- [Vanta.js Examples](https://www.vantajs.com/)
- [Shoelace Documentation](https://shoelace.style/)

---

## Support

For issues specific to library integration:
1. Check this documentation first
2. Review browser console for errors
3. Verify library initialization logs
4. Check if library-specific requirements are met

For library-specific issues, refer to official documentation linked above.
