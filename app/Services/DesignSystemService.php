<?php

namespace App\Services;

/**
 * Design System Service
 *
 * Manages design tokens, theme switching, and CSS generation
 */
class DesignSystemService
{
    /**
     * Get all design tokens as associative array
     *
     * @return array
     */
    public function getTokens(): array
    {
        return [
            'colors' => [
                'brand' => [
                    'primary' => 'oklch(65% 0.23 40)',
                    'secondary' => 'oklch(70% 0.12 180)',
                    'accent' => 'oklch(75% 0.18 120)',
                ],
                'neutral' => [
                    '0' => 'oklch(100% 0 0)',
                    '1000' => 'oklch(10% 0 0)',
                ],
            ],
            'spacing' => [
                'sm' => 'clamp(1rem, 0.9rem + 0.5vw, 1.25rem)',
                'md' => 'clamp(1.5rem, 1.35rem + 0.75vw, 1.875rem)',
                'lg' => 'clamp(2rem, 1.8rem + 1vw, 2.5rem)',
                'xl' => 'clamp(3rem, 2.7rem + 1.5vw, 3.75rem)',
            ],
            'typography' => [
                'fontFamily' => [
                    'base' => 'Inter Variable, system-ui, sans-serif',
                    'mono' => 'JetBrains Mono, Consolas, monospace',
                ],
                'fontSize' => [
                    'base' => 'clamp(1rem, 0.9rem + 0.5vw, 1.125rem)',
                    'lg' => 'clamp(1.125rem, 1rem + 0.625vw, 1.25rem)',
                    'xl' => 'clamp(1.25rem, 1.1rem + 0.75vw, 1.5rem)',
                    '2xl' => 'clamp(1.5rem, 1.3rem + 1vw, 2rem)',
                    '3xl' => 'clamp(1.875rem, 1.6rem + 1.375vw, 2.5rem)',
                    '4xl' => 'clamp(2.25rem, 1.9rem + 1.75vw, 3rem)',
                    '5xl' => 'clamp(3rem, 2.5rem + 2.5vw, 4rem)',
                ],
            ],
        ];
    }

    /**
     * Get current theme mode (light/dark/auto)
     *
     * @return string
     */
    public function getCurrentTheme(): string
    {
        // Check cookie preference first
        if (isset($_COOKIE['theme'])) {
            $theme = sanitize_text_field($_COOKIE['theme']);
            if (in_array($theme, ['light', 'dark', 'auto'])) {
                return $theme;
            }
        }

        // Default to auto (system preference)
        return 'auto';
    }

    /**
     * Get critical CSS for inline injection
     *
     * Includes only tokens, reset, and essential layout
     * Target: <14KB minified
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

        // Minify CSS (basic minification)
        $css = preg_replace('/\/\*.*?\*\//s', '', $css); // Remove comments
        $css = preg_replace('/\s+/', ' ', $css); // Remove extra whitespace
        $css = str_replace([' {', '{ ', ' }', '; ', ': '], ['{', '{', '}', ';', ':'], $css);

        return $css;
    }

    /**
     * Generate theme-specific CSS custom properties
     *
     * @param string $theme The theme mode (light/dark)
     * @return string
     */
    public function generateThemeCss(string $theme): string
    {
        if ($theme === 'dark') {
            return "
                :root {
                    --color-surface-base: var(--color-neutral-1000);
                    --color-surface-raised: var(--color-neutral-900);
                    --color-text-primary: var(--color-neutral-0);
                }
            ";
        }

        return ''; // Light mode uses default tokens
    }

    /**
     * Output inline style tag with critical tokens
     *
     * @return void
     */
    public function inlineTokens(): void
    {
        $css = $this->getCriticalCss();
        echo '<style id="critical-css">' . $css . '</style>';
    }

    /**
     * Get theme data attribute for HTML element
     *
     * @return string
     */
    public function getThemeAttribute(): string
    {
        $theme = $this->getCurrentTheme();

        if ($theme === 'auto') {
            // Use system preference via media query
            return 'light'; // Default, will be overridden by JS
        }

        return $theme;
    }
}
