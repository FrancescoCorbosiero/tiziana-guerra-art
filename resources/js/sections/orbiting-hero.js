/**
 * Orbiting Hero - Interactive Connection Lines
 *
 * Creates dynamic SVG connection lines when hovering over orbit items,
 * connecting them to the center logo with a curved path.
 */

export function initOrbitingHero() {
  // Only run if the orbiting hero section exists
  const orbitingHero = document.querySelector('.orbiting-hero');
  if (!orbitingHero) return;

  const orbitItems = orbitingHero.querySelectorAll('.orbit__item');
  const svg = orbitingHero.querySelector('.ecosystem__connections');

  if (!svg || orbitItems.length === 0) return;

  // Create connection lines on hover
  orbitItems.forEach((item) => {
    item.addEventListener('mouseenter', function () {
      // Check if user prefers reduced motion
      if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
        return;
      }

      const rect = this.getBoundingClientRect();
      const containerRect = svg.getBoundingClientRect();
      const centerX = containerRect.width / 2;
      const centerY = containerRect.height / 2;
      const itemX = rect.left + rect.width / 2 - containerRect.left;
      const itemY = rect.top + rect.height / 2 - containerRect.top;

      // Create SVG path element
      const line = document.createElementNS('http://www.w3.org/2000/svg', 'path');
      line.setAttribute('class', 'connection-line');

      // Create a quadratic curve from center to item
      const controlX = (centerX + itemX) / 2;
      const controlY = (centerY + itemY) / 2 - 50;
      line.setAttribute(
        'd',
        `M ${centerX} ${centerY} Q ${controlX} ${controlY} ${itemX} ${itemY}`
      );

      svg.appendChild(line);

      // Remove the line after animation completes
      setTimeout(() => {
        if (line.parentNode) {
          line.remove();
        }
      }, 2000);
    });
  });

  // Optional: Add click interaction for accessibility
  orbitItems.forEach((item) => {
    item.addEventListener('click', function (e) {
      const service = this.getAttribute('data-service');
      if (service) {
        console.log(`Service clicked: ${service}`);
        // You can add custom click handling here
        // e.g., navigate to service page, open modal, etc.
      }
    });

    // Make items keyboard accessible
    if (!item.hasAttribute('tabindex')) {
      item.setAttribute('tabindex', '0');
    }

    // Handle keyboard interaction
    item.addEventListener('keydown', function (e) {
      if (e.key === 'Enter' || e.key === ' ') {
        e.preventDefault();
        this.click();
      }
    });
  });
}

// Auto-initialize when DOM is ready
if (document.readyState === 'loading') {
  document.addEventListener('DOMContentLoaded', initOrbitingHero);
} else {
  initOrbitingHero();
}
