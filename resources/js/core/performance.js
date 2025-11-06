/**
 * Performance Monitoring
 * Track Web Vitals and send to analytics
 */

import { onCLS, onFCP, onFID, onLCP, onTTFB } from 'web-vitals'

/**
 * Initialize performance monitoring
 */
export function initPerformance() {
  // Only run in production
  if (import.meta.env.DEV) {
    return
  }

  // Track all Core Web Vitals
  onCLS(sendToAnalytics)
  onFCP(sendToAnalytics)
  onFID(sendToAnalytics)
  onLCP(sendToAnalytics)
  onTTFB(sendToAnalytics)
}

/**
 * Send metric to analytics endpoint
 */
function sendToAnalytics(metric) {
  const body = JSON.stringify({
    name: metric.name,
    value: metric.value,
    rating: metric.rating,
    delta: metric.delta,
    id: metric.id,
    url: window.location.href,
    userAgent: navigator.userAgent,
    timestamp: Date.now(),
  })

  const url = '/wp-json/theme/v1/vitals'

  // Use sendBeacon if available (more reliable)
  if (navigator.sendBeacon) {
    navigator.sendBeacon(url, body)
  } else {
    // Fallback to fetch
    fetch(url, {
      body,
      method: 'POST',
      keepalive: true,
      headers: {
        'Content-Type': 'application/json',
      },
    }).catch(error => {
      console.error('Failed to send web vitals:', error)
    })
  }
}

/**
 * Log performance metrics to console (development only)
 */
if (import.meta.env.DEV) {
  onCLS((metric) => console.log('CLS:', metric))
  onFCP((metric) => console.log('FCP:', metric))
  onFID((metric) => console.log('FID:', metric))
  onLCP((metric) => console.log('LCP:', metric))
  onTTFB((metric) => console.log('TTFB:', metric))
}
