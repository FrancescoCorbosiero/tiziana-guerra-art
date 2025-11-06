<?php

/**
 * Internationalization Configuration
 */

return [
    /**
     * Default locale
     */
    'default_locale' => 'it_IT',

    /**
     * Available locales for the theme
     */
    'available_locales' => [
        'it_IT' => 'Italiano',
        'en_US' => 'English (US)',
        'es_ES' => 'Español',
    ],

    /**
     * Fallback locale
     */
    'fallback_locale' => 'it_IT',

    /**
     * Auto-detect user locale from browser
     */
    'auto_detect' => true,

    /**
     * Right-to-left (RTL) locales
     */
    'rtl_locales' => [
        'ar',    // Arabic
        'he_IL', // Hebrew
        'fa_IR', // Persian
        'ur',    // Urdu
    ],

    /**
     * Text domain for translations
     */
    'text_domain' => 'sage',
];
