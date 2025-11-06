<?php

/**
 * Theme setup.
 */

namespace App;

use Illuminate\Support\Facades\Vite;

/**
 * Inject styles into the block editor.
 *
 * @return array
 */
add_filter('block_editor_settings_all', function ($settings) {
    try {
        $style = Vite::asset('resources/css/editor.css');

        $settings['styles'][] = [
            'css' => "@import url('{$style}')",
        ];
    } catch (\Exception $e) {
        // Vite manifest not found - assets need to be built
        // Run: npm run build
    }

    return $settings;
});

/**
 * Inject scripts into the block editor.
 *
 * @return void
 */
add_filter('admin_head', function () {
    if (! get_current_screen()?->is_block_editor()) {
        return;
    }

    try {
        $dependencies = json_decode(Vite::content('editor.deps.json'));

        foreach ($dependencies as $dependency) {
            if (! wp_script_is($dependency)) {
                wp_enqueue_script($dependency);
            }
        }

        echo Vite::withEntryPoints([
            'resources/js/editor.js',
        ])->toHtml();
    } catch (\Exception $e) {
        // Vite manifest not found - assets need to be built
        // Run: npm run build
    }
});

/**
 * Use the generated theme.json file.
 *
 * @return string
 */
add_filter('theme_file_path', function ($path, $file) {
    if ($file === 'theme.json') {
        $buildPath = public_path('build/assets/theme.json');
        return file_exists($buildPath) ? $buildPath : $path;
    }
    return $path;
}, 10, 2);

/**
 * Register the initial theme setup.
 *
 * @return void
 */
add_action('after_setup_theme', function () {
    /**
     * Disable full-site editing support.
     *
     * @link https://wptavern.com/gutenberg-10-5-embeds-pdfs-adds-verse-block-color-options-and-introduces-new-patterns
     */
    remove_theme_support('block-templates');

    /**
     * Register the navigation menus.
     *
     * @link https://developer.wordpress.org/reference/functions/register_nav_menus/
     */
    register_nav_menus([
        'primary_navigation' => __('Primary Navigation', 'sage'),
        'footer_navigation' => __('Footer Navigation', 'sage'),
    ]);

    /**
     * Disable the default block patterns.
     *
     * @link https://developer.wordpress.org/block-editor/developers/themes/theme-support/#disabling-the-default-block-patterns
     */
    remove_theme_support('core-block-patterns');

    /**
     * Enable plugins to manage the document title.
     *
     * @link https://developer.wordpress.org/reference/functions/add_theme_support/#title-tag
     */
    add_theme_support('title-tag');

    /**
     * Enable post thumbnail support.
     *
     * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
     */
    add_theme_support('post-thumbnails');

    /**
     * Enable responsive embed support.
     *
     * @link https://developer.wordpress.org/block-editor/how-to-guides/themes/theme-support/#responsive-embedded-content
     */
    add_theme_support('responsive-embeds');

    /**
     * Enable HTML5 markup support.
     *
     * @link https://developer.wordpress.org/reference/functions/add_theme_support/#html5
     */
    add_theme_support('html5', [
        'caption',
        'comment-form',
        'comment-list',
        'gallery',
        'search-form',
        'script',
        'style',
    ]);

    /**
     * Enable selective refresh for widgets in customizer.
     *
     * @link https://developer.wordpress.org/reference/functions/add_theme_support/#customize-selective-refresh-widgets
     */
    add_theme_support('customize-selective-refresh-widgets');
}, 20);

/**
 * Register the theme sidebars.
 *
 * @return void
 */
add_action('widgets_init', function () {
    $config = [
        'before_widget' => '<section class="widget %1$s %2$s">',
        'after_widget' => '</section>',
        'before_title' => '<h3>',
        'after_title' => '</h3>',
    ];

    register_sidebar([
        'name' => __('Primary', 'sage'),
        'id' => 'sidebar-primary',
    ] + $config);

    register_sidebar([
        'name' => __('Footer', 'sage'),
        'id' => 'sidebar-footer',
    ] + $config);
});

/**
 * AJAX handler for language switching.
 *
 * @return void
 */
add_action('wp_ajax_switch_locale', function () {
    // Verify nonce
    check_ajax_referer('switch_locale_nonce', 'nonce');

    $locale = sanitize_text_field($_POST['locale'] ?? '');

    if (empty($locale)) {
        wp_send_json_error(['message' => __('Invalid locale', 'sage')]);
        return;
    }

    // Use I18nService to set locale
    $i18nService = app(\App\Services\I18nService::class);
    $availableLocales = $i18nService->getAvailableLocales();

    if (!array_key_exists($locale, $availableLocales)) {
        wp_send_json_error(['message' => __('Locale not available', 'sage')]);
        return;
    }

    // Set the locale
    $i18nService->setLocale($locale);

    wp_send_json_success([
        'locale' => $locale,
        'message' => __('Language changed successfully', 'sage'),
    ]);
});

/**
 * AJAX handler for non-logged-in users (language switching should work for everyone).
 *
 * @return void
 */
add_action('wp_ajax_nopriv_switch_locale', function () {
    // Verify nonce
    check_ajax_referer('switch_locale_nonce', 'nonce');

    $locale = sanitize_text_field($_POST['locale'] ?? '');

    if (empty($locale)) {
        wp_send_json_error(['message' => __('Invalid locale', 'sage')]);
        return;
    }

    // Use I18nService to set locale
    $i18nService = app(\App\Services\I18nService::class);
    $availableLocales = $i18nService->getAvailableLocales();

    if (!array_key_exists($locale, $availableLocales)) {
        wp_send_json_error(['message' => __('Locale not available', 'sage')]);
        return;
    }

    // Set the locale
    $i18nService->setLocale($locale);

    wp_send_json_success([
        'locale' => $locale,
        'message' => __('Language changed successfully', 'sage'),
    ]);
});

/**
 * Customize Posts labels to "Opere" (Paintings) for artist portfolio.
 *
 * @return void
 */
add_action('init', function () {
    global $wp_post_types;

    $labels = &$wp_post_types['post']->labels;
    $labels->name = 'Opere';
    $labels->singular_name = 'Opera';
    $labels->add_new = 'Aggiungi Nuova';
    $labels->add_new_item = 'Aggiungi Nuova Opera';
    $labels->edit_item = 'Modifica Opera';
    $labels->new_item = 'Nuova Opera';
    $labels->view_item = 'Visualizza Opera';
    $labels->search_items = 'Cerca Opere';
    $labels->not_found = 'Nessuna opera trovata';
    $labels->not_found_in_trash = 'Nessuna opera nel cestino';
    $labels->all_items = 'Tutte le Opere';
    $labels->menu_name = 'Opere';
    $labels->name_admin_bar = 'Opera';
}, 0);

/**
 * Customize Category labels for paintings.
 *
 * @return void
 */
add_action('init', function () {
    global $wp_taxonomies;

    if (isset($wp_taxonomies['category'])) {
        $labels = &$wp_taxonomies['category']->labels;
        $labels->name = 'Categorie Opere';
        $labels->singular_name = 'Categoria';
        $labels->menu_name = 'Categorie';
    }

    if (isset($wp_taxonomies['post_tag'])) {
        $labels = &$wp_taxonomies['post_tag']->labels;
        $labels->name = 'Tecniche';
        $labels->singular_name = 'Tecnica';
        $labels->menu_name = 'Tecniche';
    }
}, 0);

/**
 * Register ACF field group for paintings (opere).
 * This function registers fields programmatically if ACF is installed.
 *
 * @return void
 */
add_action('acf/include_fields', function () {
    if (!function_exists('acf_add_local_field_group')) {
        return;
    }

    acf_add_local_field_group([
        'key' => 'group_opere_details',
        'title' => 'Dettagli Opera',
        'fields' => [
            [
                'key' => 'field_dimensioni',
                'label' => 'Dimensioni',
                'name' => 'dimensioni',
                'type' => 'text',
                'instructions' => 'Es: 80x100 cm',
                'required' => 0,
                'placeholder' => '80x100 cm',
            ],
            [
                'key' => 'field_anno',
                'label' => 'Anno',
                'name' => 'anno',
                'type' => 'number',
                'instructions' => 'Anno di realizzazione',
                'required' => 0,
                'default_value' => date('Y'),
                'min' => 1900,
                'max' => date('Y') + 1,
            ],
            [
                'key' => 'field_tecnica',
                'label' => 'Tecnica',
                'name' => 'tecnica',
                'type' => 'select',
                'instructions' => 'Tecnica utilizzata',
                'required' => 0,
                'choices' => [
                    'olio' => 'Olio',
                    'acrilico' => 'Acrilico',
                    'mista' => 'Tecnica Mista',
                    'acquarello' => 'Acquarello',
                ],
                'default_value' => '',
                'allow_null' => 1,
            ],
            [
                'key' => 'field_prezzo',
                'label' => 'Prezzo',
                'name' => 'prezzo',
                'type' => 'text',
                'instructions' => 'Prezzo (opzionale)',
                'required' => 0,
                'placeholder' => 'Es: €1.500',
            ],
            [
                'key' => 'field_stato',
                'label' => 'Stato',
                'name' => 'stato',
                'type' => 'radio',
                'instructions' => 'Disponibilità dell\'opera',
                'required' => 1,
                'choices' => [
                    'disponibile' => 'Disponibile',
                    'venduto' => 'Venduto',
                    'non_in_vendita' => 'Non in Vendita',
                ],
                'default_value' => 'disponibile',
                'layout' => 'horizontal',
            ],
            [
                'key' => 'field_timeline_mostre',
                'label' => 'Timeline Mostre',
                'name' => 'timeline_mostre',
                'type' => 'textarea',
                'instructions' => 'Inserisci le mostre una per riga (es: 2024 - Galleria d\'Arte Moderna, Roma)',
                'required' => 0,
                'rows' => 5,
            ],
            [
                'key' => 'field_link_processo_creativo',
                'label' => 'Link Processo Creativo',
                'name' => 'link_processo_creativo',
                'type' => 'url',
                'instructions' => 'Link YouTube/Vimeo del processo creativo (opzionale)',
                'required' => 0,
                'placeholder' => 'https://www.youtube.com/watch?v=...',
            ],
        ],
        'location' => [
            [
                [
                    'param' => 'post_type',
                    'operator' => '==',
                    'value' => 'post',
                ],
            ],
        ],
        'menu_order' => 0,
        'position' => 'normal',
        'style' => 'default',
        'label_placement' => 'top',
        'instruction_placement' => 'label',
    ]);
});
