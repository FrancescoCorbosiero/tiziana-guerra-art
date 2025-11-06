<?php

namespace App\Services;

/**
 * Performance Service
 *
 * Handles asset optimization, preloading, and performance monitoring
 */
class PerformanceService
{
    /**
     * Get critical CSS for inline injection
     *
     * @return string
     */
    public function getCriticalCss(): string
    {
        $criticalFiles = [
            get_theme_file_path('resources/css/foundation/_tokens.css'),
            get_theme_file_path('resources/css/foundation/_reset.css'),
        ];

        $css = '';
        foreach ($criticalFiles as $file) {
            if (file_exists($file)) {
                $css .= file_get_contents($file);
            }
        }

        // Basic CSS minification
        $css = preg_replace('/\/\*.*?\*\//s', '', $css);
        $css = preg_replace('/\s+/', ' ', $css);
        $css = str_replace([' {', '{ ', ' }', '; ', ': '], ['{', '{', '}', ';', ':'], $css);

        return trim($css);
    }

    /**
     * Generate resource hint tags (preload, prefetch, preconnect)
     *
     * @return string
     */
    public function generateResourceHints(): string
    {
        $hints = [];

        // Preconnect to external domains
        $hints[] = '<link rel="preconnect" href="https://fonts.googleapis.com" crossorigin>';

        // DNS prefetch for external resources
        $hints[] = '<link rel="dns-prefetch" href="https://fonts.googleapis.com">';

        return implode("\n", $hints);
    }

    /**
     * Preload critical assets
     *
     * @param array $assets Array of asset configurations
     * @return void
     */
    public function preloadAssets(array $assets): void
    {
        foreach ($assets as $asset) {
            $href = $asset['href'] ?? '';
            $as = $asset['as'] ?? '';
            $type = $asset['type'] ?? '';
            $crossorigin = $asset['crossorigin'] ?? false;

            if (!$href || !$as) {
                continue;
            }

            echo '<link rel="preload" href="' . esc_url($href) . '" as="' . esc_attr($as) . '"';

            if ($type) {
                echo ' type="' . esc_attr($type) . '"';
            }

            if ($crossorigin) {
                echo ' crossorigin';
            }

            echo '>';
        }
    }

    /**
     * Setup lazy loading for images
     *
     * @return void
     */
    public function setupLazyLoading(): void
    {
        // Add loading="lazy" to images
        add_filter('wp_get_attachment_image_attributes', function ($attr) {
            if (!isset($attr['loading'])) {
                $attr['loading'] = 'lazy';
            }
            return $attr;
        });

        // Add decoding="async" to images
        add_filter('wp_get_attachment_image_attributes', function ($attr) {
            if (!isset($attr['decoding'])) {
                $attr['decoding'] = 'async';
            }
            return $attr;
        });
    }

    /**
     * Generate HTML for deferred CSS loading
     *
     * @param string $href CSS file URL
     * @return string
     */
    public function deferNonCriticalCss(string $href): string
    {
        return sprintf(
            '<link rel="preload" as="style" href="%s" onload="this.onload=null;this.rel=\'stylesheet\'">
            <noscript><link rel="stylesheet" href="%s"></noscript>',
            esc_url($href),
            esc_url($href)
        );
    }

    /**
     * Add async or defer attribute to script tag
     *
     * @param string $tag HTML script tag
     * @param string $handle Script handle
     * @param string $src Script source
     * @return string
     */
    public function deferScript(string $tag, string $handle, string $src): string
    {
        // Add defer to app.js and editor.js
        if (in_array($handle, ['sage/app.js', 'sage/editor.js'])) {
            if (strpos($tag, 'defer') === false && strpos($tag, 'async') === false) {
                $tag = str_replace(' src', ' defer src', $tag);
            }
        }

        return $tag;
    }

    /**
     * Setup Web Vitals tracking
     *
     * @return void
     */
    public function setupWebVitals(): void
    {
        // Web Vitals will be initialized in JavaScript
        // This method can be used to add the REST API endpoint for collecting metrics
        add_action('rest_api_init', function () {
            register_rest_route('theme/v1', '/vitals', [
                'methods' => 'POST',
                'callback' => [$this, 'handleWebVitals'],
                'permission_callback' => '__return_true',
            ]);
        });
    }

    /**
     * Handle Web Vitals data from JavaScript
     *
     * @param \WP_REST_Request $request
     * @return \WP_REST_Response
     */
    public function handleWebVitals($request)
    {
        $metric = $request->get_json_params();

        // Log or store metrics (implement based on your needs)
        // Example: Store in transient, database, or send to analytics service
        error_log('Web Vitals: ' . json_encode($metric));

        return new \WP_REST_Response(['success' => true], 200);
    }
}
