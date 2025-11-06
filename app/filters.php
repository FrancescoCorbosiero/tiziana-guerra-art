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
