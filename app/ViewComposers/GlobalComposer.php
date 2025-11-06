<?php

namespace App\ViewComposers;

use Roots\Acorn\View\Composer;
use App\Services\DesignSystemService;
use App\Services\SeoService;
use App\Services\I18nService;

/**
 * Global View Composer
 *
 * Binds data to all Blade views
 */
class GlobalComposer extends Composer
{
    /**
     * List of views served by this composer.
     *
     * @var array
     */
    protected static $views = ['*'];

    /**
     * Design System Service
     *
     * @var DesignSystemService
     */
    protected DesignSystemService $designSystem;

    /**
     * SEO Service
     *
     * @var SeoService
     */
    protected SeoService $seo;

    /**
     * I18n Service
     *
     * @var I18nService
     */
    protected I18nService $i18n;

    /**
     * Constructor
     *
     * @param DesignSystemService $designSystem
     * @param SeoService $seo
     * @param I18nService $i18n
     */
    public function __construct(
        DesignSystemService $designSystem,
        SeoService $seo,
        I18nService $i18n
    ) {
        $this->designSystem = $designSystem;
        $this->seo = $seo;
        $this->i18n = $i18n;
    }

    /**
     * Data to be passed to view before rendering.
     *
     * @return array
     */
    public function with(): array
    {
        $data = [
            'siteName' => get_bloginfo('name'),
            'siteDescription' => get_bloginfo('description'),
            'title' => $this->getTitle(),
        ];

        // Only add frontend-specific data when NOT in admin
        if (!is_admin()) {
            $data['currentUrl'] = home_url(add_query_arg(null, null));
            $data['locale'] = $this->i18n->getLocale();
            $data['isRtl'] = $this->i18n->isRtl();
            $data['theme'] = $this->designSystem->getThemeAttribute();
            $data['metaTags'] = $this->seo->getMetaTags();
            $data['schemaMarkup'] = $this->seo->getSchemaMarkup();
        }

        return $data;
    }

    /**
     * Get the title for the current page
     *
     * @return string
     */
    protected function getTitle(): string
    {
        // Check if we're in the loop
        if (in_the_loop()) {
            return get_the_title();
        }

        // Check if it's a singular post/page
        if (is_singular()) {
            return get_the_title();
        }

        // For archives
        if (is_archive()) {
            return get_the_archive_title();
        }

        // For search
        if (is_search()) {
            return sprintf(__('Search Results for: %s', 'sage'), get_search_query());
        }

        // For 404
        if (is_404()) {
            return __('Page Not Found', 'sage');
        }

        // Default to site name
        return get_bloginfo('name');
    }
}
