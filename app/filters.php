<?php

/**
 * Theme filters.
 */

namespace App;

/**
 * Add "… Continued" to the excerpt.
 *
 * @return string
 */
add_filter('excerpt_more', function () {
    return sprintf(' &hellip; <a href="%s">%s</a>', get_permalink(), __('Continued', 'sage'));
});

/**
 * Prevent frontend assets from loading in WordPress admin
 *
 * @return void
 */
add_action('wp_enqueue_scripts', function () {
    // This hook only runs on frontend, not in admin
    // No need to add conditional logic here
}, 999);

/**
 * Dequeue frontend scripts in admin if they somehow get enqueued
 *
 * @return void
 */
add_action('admin_enqueue_scripts', function () {
    // Dequeue main theme scripts/styles to prevent conflicts
    wp_dequeue_script('sage/app.js');
    wp_dequeue_style('sage/app.css');
}, 999);

/**
 * Add custom query vars for opere filtering.
 *
 * @param array $vars
 * @return array
 */
add_filter('query_vars', function ($vars) {
    $vars[] = 'categoria';
    $vars[] = 'tecnica';
    return $vars;
});

/**
 * Modify main query for opere archive filtering.
 *
 * @param \WP_Query $query
 * @return void
 */
add_action('pre_get_posts', function ($query) {
    // Exit early for admin, non-main queries, or queries with suppress_filters
    if (is_admin()) {
        return;
    }

    if (!$query->is_main_query()) {
        return;
    }

    if ($query->get('suppress_filters')) {
        return;
    }

    // Only run on post archives, categories, and tags
    if (!is_home() && !is_post_type_archive('post') && !is_category() && !is_tag()) {
        return;
    }

    // Don't run on singular pages
    if (is_singular()) {
        return;
    }

    // Build tax query for filtering
    $tax_query = [];

    // Filter by category (categoria)
    $categoria = get_query_var('categoria');
    if (!empty($categoria) && !is_category()) {
        $tax_query[] = [
            'taxonomy' => 'category',
            'field' => 'slug',
            'terms' => sanitize_text_field($categoria),
        ];
    }

    // Filter by tag/tecnica
    $tecnica = get_query_var('tecnica');
    if (!empty($tecnica) && !is_tag()) {
        $tax_query[] = [
            'taxonomy' => 'post_tag',
            'field' => 'slug',
            'terms' => sanitize_text_field($tecnica),
        ];
    }

    if (count($tax_query) > 1) {
        $tax_query['relation'] = 'AND';
    }

    if (!empty($tax_query)) {
        $query->set('tax_query', $tax_query);
    }

    // Set posts per page for opere archive
    $query->set('posts_per_page', 12);
}, 20, 1); // Higher priority to run later
