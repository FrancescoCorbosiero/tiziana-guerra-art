<?php

namespace App\Services;

/**
 * Internationalization Service
 *
 * Handles translations, locale detection, and RTL support
 */
class I18nService
{
    /**
     * Configuration array
     *
     * @var array
     */
    protected array $config;

    /**
     * Constructor
     */
    public function __construct()
    {
        $configFile = get_theme_file_path('config/i18n.php');
        $this->config = file_exists($configFile) ? require $configFile : $this->getDefaultConfig();
    }

    /**
     * Get current locale
     *
     * @return string
     */
    public function getLocale(): string
    {
        // Check WordPress locale
        $locale = get_locale();

        // Validate against available locales
        if (in_array($locale, array_keys($this->config['available_locales']))) {
            return $locale;
        }

        return $this->config['default_locale'];
    }

    /**
     * Translate string with replacements
     *
     * @param string $key Translation key
     * @param array $replace Replacement values
     * @return string
     */
    public function translate(string $key, array $replace = []): string
    {
        $translated = __($key, $this->config['text_domain']);

        // Replace placeholders
        foreach ($replace as $placeholder => $value) {
            $translated = str_replace(':' . $placeholder, $value, $translated);
        }

        return $translated;
    }

    /**
     * Check if current locale is RTL
     *
     * @return bool
     */
    public function isRtl(): bool
    {
        $locale = $this->getLocale();

        // Check if locale is in RTL list
        foreach ($this->config['rtl_locales'] as $rtlLocale) {
            if (strpos($locale, $rtlLocale) === 0) {
                return true;
            }
        }

        // Also check WordPress is_rtl() function
        return is_rtl();
    }

    /**
     * Get available locales
     *
     * @return array
     */
    public function getAvailableLocales(): array
    {
        return $this->config['available_locales'];
    }

    /**
     * Set user locale preference
     *
     * @param string $locale Locale code
     * @return void
     */
    public function setLocale(string $locale): void
    {
        if (in_array($locale, array_keys($this->config['available_locales']))) {
            // Set cookie for 1 year
            setcookie('locale', $locale, time() + (365 * 24 * 60 * 60), '/');

            // Switch locale for current request
            switch_to_locale($locale);
        }
    }

    /**
     * Get locale from browser accept-language header
     *
     * @return string|null
     */
    public function detectBrowserLocale(): ?string
    {
        if (!$this->config['auto_detect']) {
            return null;
        }

        if (!isset($_SERVER['HTTP_ACCEPT_LANGUAGE'])) {
            return null;
        }

        $browserLocales = explode(',', $_SERVER['HTTP_ACCEPT_LANGUAGE']);
        $availableLocales = array_keys($this->config['available_locales']);

        foreach ($browserLocales as $browserLocale) {
            // Parse locale (e.g., "en-US;q=0.9" -> "en_US")
            $locale = str_replace('-', '_', strtok($browserLocale, ';'));

            if (in_array($locale, $availableLocales)) {
                return $locale;
            }

            // Try language code only (e.g., "en" matches "en_US")
            $language = strtok($locale, '_');
            foreach ($availableLocales as $available) {
                if (strpos($available, $language) === 0) {
                    return $available;
                }
            }
        }

        return null;
    }

    /**
     * Get default configuration
     *
     * @return array
     */
    protected function getDefaultConfig(): array
    {
        return [
            'default_locale' => 'en_US',
            'available_locales' => ['en_US' => 'English'],
            'fallback_locale' => 'en_US',
            'auto_detect' => true,
            'rtl_locales' => ['ar', 'he_IL'],
            'text_domain' => 'sage',
        ];
    }
}
