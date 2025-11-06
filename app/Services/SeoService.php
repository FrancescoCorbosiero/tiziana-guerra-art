<?php

namespace App\Services;

/**
 * SEO Service
 *
 * Handles meta tags, Schema.org markup, and SEO optimization
 */
class SeoService
{
    /**
     * Generate meta tags (OG, Twitter Card)
     *
     * @return string
     */
    public function getMetaTags(): string
    {
        $tags = [];

        // Get page data
        $title = $this->getPageTitle();
        $description = $this->getPageDescription();
        $image = $this->getPageImage();
        $url = $this->getCanonicalUrl();

        // Open Graph tags
        $tags[] = sprintf('<meta property="og:title" content="%s">', esc_attr($title));
        $tags[] = sprintf('<meta property="og:description" content="%s">', esc_attr($description));
        $tags[] = sprintf('<meta property="og:url" content="%s">', esc_url($url));
        $tags[] = '<meta property="og:type" content="website">';

        if ($image) {
            $tags[] = sprintf('<meta property="og:image" content="%s">', esc_url($image));
        }

        // Twitter Card tags
        $tags[] = '<meta name="twitter:card" content="summary_large_image">';
        $tags[] = sprintf('<meta name="twitter:title" content="%s">', esc_attr($title));
        $tags[] = sprintf('<meta name="twitter:description" content="%s">', esc_attr($description));

        if ($image) {
            $tags[] = sprintf('<meta name="twitter:image" content="%s">', esc_url($image));
        }

        // Canonical URL
        $tags[] = sprintf('<link rel="canonical" href="%s">', esc_url($url));

        return implode("\n", $tags);
    }

    /**
     * Generate Schema.org JSON-LD markup
     *
     * @return string
     */
    public function getSchemaMarkup(): string
    {
        $schema = [];

        // Organization schema
        $schema[] = [
            '@context' => 'https://schema.org',
            '@type' => 'Organization',
            'name' => get_bloginfo('name'),
            'url' => home_url(),
            'description' => get_bloginfo('description'),
        ];

        // WebSite schema
        $schema[] = [
            '@context' => 'https://schema.org',
            '@type' => 'WebSite',
            'name' => get_bloginfo('name'),
            'url' => home_url(),
            'potentialAction' => [
                '@type' => 'SearchAction',
                'target' => home_url('/?s={search_term_string}'),
                'query-input' => 'required name=search_term_string',
            ],
        ];

        // BreadcrumbList schema (if not home page)
        if (!is_front_page()) {
            $breadcrumbs = $this->getBreadcrumbs();
            if (!empty($breadcrumbs)) {
                $schema[] = [
                    '@context' => 'https://schema.org',
                    '@type' => 'BreadcrumbList',
                    'itemListElement' => array_map(function ($item, $index) {
                        return [
                            '@type' => 'ListItem',
                            'position' => $index + 1,
                            'name' => $item['title'],
                            'item' => $item['url'],
                        ];
                    }, $breadcrumbs, array_keys($breadcrumbs)),
                ];
            }
        }

        $output = '';
        foreach ($schema as $item) {
            $output .= '<script type="application/ld+json">' . wp_json_encode($item, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) . '</script>' . "\n";
        }

        return $output;
    }

    /**
     * Get breadcrumb trail
     *
     * @return array
     */
    public function getBreadcrumbs(): array
    {
        $breadcrumbs = [];

        // Always start with home
        $breadcrumbs[] = [
            'title' => 'Home',
            'url' => home_url(),
        ];

        if (is_single()) {
            // Single post
            $categories = get_the_category();
            if (!empty($categories)) {
                $category = $categories[0];
                $breadcrumbs[] = [
                    'title' => $category->name,
                    'url' => get_category_link($category->term_id),
                ];
            }
            $breadcrumbs[] = [
                'title' => get_the_title(),
                'url' => get_permalink(),
            ];
        } elseif (is_page()) {
            // Page
            $breadcrumbs[] = [
                'title' => get_the_title(),
                'url' => get_permalink(),
            ];
        } elseif (is_category()) {
            // Category archive
            $breadcrumbs[] = [
                'title' => single_cat_title('', false),
                'url' => get_category_link(get_queried_object_id()),
            ];
        } elseif (is_archive()) {
            // Other archives
            $breadcrumbs[] = [
                'title' => get_the_archive_title(),
                'url' => get_permalink(),
            ];
        }

        return $breadcrumbs;
    }

    /**
     * Get canonical URL for current page
     *
     * @return string
     */
    public function getCanonicalUrl(): string
    {
        if (is_singular()) {
            return get_permalink();
        }

        global $wp;
        return home_url(add_query_arg([], $wp->request));
    }

    /**
     * Get page title
     *
     * @return string
     */
    protected function getPageTitle(): string
    {
        if (is_singular()) {
            return get_the_title();
        }

        if (is_archive()) {
            return get_the_archive_title();
        }

        return get_bloginfo('name');
    }

    /**
     * Get page description
     *
     * @return string
     */
    protected function getPageDescription(): string
    {
        if (is_singular()) {
            $excerpt = get_the_excerpt();
            return $excerpt ?: wp_trim_words(get_the_content(), 30);
        }

        return get_bloginfo('description');
    }

    /**
     * Get page featured image
     *
     * @return string|null
     */
    protected function getPageImage(): ?string
    {
        if (is_singular() && has_post_thumbnail()) {
            return get_the_post_thumbnail_url(null, 'large');
        }

        return null;
    }
}
