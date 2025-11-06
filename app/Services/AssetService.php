<?php

namespace App\Services;

/**
 * Asset Service
 *
 * Handles smart asset loading, conditional enqueuing, and optimization
 */
class AssetService
{
    /**
     * Enqueue asset conditionally based on a callback
     *
     * @param string $handle Asset handle
     * @param callable $condition Condition callback
     * @return void
     */
    public function enqueueConditional(string $handle, callable $condition): void
    {
        if (call_user_func($condition)) {
            // Check if it's a script or style
            if (wp_script_is($handle, 'registered')) {
                wp_enqueue_script($handle);
            } elseif (wp_style_is($handle, 'registered')) {
                wp_enqueue_style($handle);
            }
        }
    }

    /**
     * Add defer attribute to script
     *
     * @param string $handle Script handle
     * @return void
     */
    public function deferScript(string $handle): void
    {
        add_filter('script_loader_tag', function ($tag, $script_handle, $src) use ($handle) {
            if ($script_handle === $handle) {
                if (strpos($tag, 'defer') === false && strpos($tag, 'async') === false) {
                    $tag = str_replace(' src', ' defer src', $tag);
                }
            }
            return $tag;
        }, 10, 3);
    }

    /**
     * Get assets needed for a specific template
     *
     * @param string $template Template name
     * @return array
     */
    public function getPageAssets(string $template): array
    {
        $assets = [
            // Core assets (loaded on all pages)
            'core' => [
                'css' => ['app.css'],
                'js' => ['app.js'],
            ],
        ];

        // Template-specific assets
        $templateAssets = [
            'single' => [
                'css' => ['single.css'],
                'js' => ['comments.js'],
            ],
            'page' => [
                'css' => ['page.css'],
                'js' => [],
            ],
            'archive' => [
                'css' => ['archive.css'],
                'js' => ['filters.js'],
            ],
        ];

        if (isset($templateAssets[$template])) {
            return array_merge_recursive($assets['core'], $templateAssets[$template]);
        }

        return $assets['core'];
    }

    /**
     * Enqueue modern script with module/nomodule pattern
     *
     * @param string $handle Script handle
     * @param string $modern Modern script URL
     * @param string $legacy Legacy script URL
     * @param array $deps Dependencies
     * @param string|null $version Version
     * @return void
     */
    public function moduleNomoduleScript(string $handle, string $modern, string $legacy, array $deps = [], ?string $version = null): void
    {
        // Enqueue modern script
        wp_register_script($handle . '-modern', $modern, $deps, $version, true);
        add_filter('script_loader_tag', function ($tag, $script_handle) use ($handle) {
            if ($script_handle === $handle . '-modern') {
                $tag = str_replace('<script ', '<script type="module" ', $tag);
            }
            return $tag;
        }, 10, 2);
        wp_enqueue_script($handle . '-modern');

        // Enqueue legacy script
        wp_register_script($handle . '-legacy', $legacy, $deps, $version, true);
        add_filter('script_loader_tag', function ($tag, $script_handle) use ($handle) {
            if ($script_handle === $handle . '-legacy') {
                $tag = str_replace('<script ', '<script nomodule ', $tag);
            }
            return $tag;
        }, 10, 2);
        wp_enqueue_script($handle . '-legacy');
    }

    /**
     * Preload font file
     *
     * @param string $url Font URL
     * @param string $type Font type (e.g., 'font/woff2')
     * @return void
     */
    public function preloadFont(string $url, string $type = 'font/woff2'): void
    {
        add_action('wp_head', function () use ($url, $type) {
            echo sprintf(
                '<link rel="preload" href="%s" as="font" type="%s" crossorigin>',
                esc_url($url),
                esc_attr($type)
            );
        }, 1);
    }

    /**
     * Add async attribute to script
     *
     * @param string $handle Script handle
     * @return void
     */
    public function asyncScript(string $handle): void
    {
        add_filter('script_loader_tag', function ($tag, $script_handle, $src) use ($handle) {
            if ($script_handle === $handle) {
                if (strpos($tag, 'async') === false && strpos($tag, 'defer') === false) {
                    $tag = str_replace(' src', ' async src', $tag);
                }
            }
            return $tag;
        }, 10, 3);
    }

    /**
     * Remove query strings from static resources
     *
     * @return void
     */
    public function removeQueryStrings(): void
    {
        add_filter('script_loader_src', [$this, 'removeQueryString'], 15, 1);
        add_filter('style_loader_src', [$this, 'removeQueryString'], 15, 1);
    }

    /**
     * Remove query string from URL
     *
     * @param string $src Source URL
     * @return string
     */
    public function removeQueryString(string $src): string
    {
        $parts = explode('?ver', $src);
        return $parts[0];
    }

    /**
     * Disable emoji scripts
     *
     * @return void
     */
    public function disableEmojis(): void
    {
        remove_action('wp_head', 'print_emoji_detection_script', 7);
        remove_action('admin_print_scripts', 'print_emoji_detection_script');
        remove_action('wp_print_styles', 'print_emoji_styles');
        remove_action('admin_print_styles', 'print_emoji_styles');
        remove_filter('the_content_feed', 'wp_staticize_emoji');
        remove_filter('comment_text_rss', 'wp_staticize_emoji');
        remove_filter('wp_mail', 'wp_staticize_emoji_for_email');
    }
}
