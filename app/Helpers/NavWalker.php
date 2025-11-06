<?php

namespace App\Helpers;

/**
 * Custom Navigation Walker for dropdown menus
 * Generates accessible, semantic navigation with dropdown support
 */
class NavWalker extends \Walker_Nav_Menu
{
    /**
     * Start the element output.
     *
     * @param string   $output Used to append additional content (passed by reference).
     * @param \WP_Post $item   Menu item data object.
     * @param int      $depth  Depth of menu item. Used for padding.
     * @param \stdClass $args  An object of wp_nav_menu() arguments.
     * @param int      $id     Current item ID.
     */
    public function start_el(&$output, $item, $depth = 0, $args = null, $id = 0)
    {
        $indent = ($depth) ? str_repeat("\t", $depth) : '';

        $classes = empty($item->classes) ? [] : (array) $item->classes;
        $classes[] = 'menu-item-' . $item->ID;

        // Add depth class
        $classes[] = 'menu-item--depth-' . $depth;

        // Add has-children class if this item has children
        if (in_array('menu-item-has-children', $classes)) {
            $classes[] = 'has-dropdown';
        }

        // Add active class
        if (in_array('current-menu-item', $classes) || in_array('current-menu-ancestor', $classes)) {
            $classes[] = 'is-active';
        }

        $class_names = join(' ', apply_filters('nav_menu_css_class', array_filter($classes), $item, $args, $depth));
        $class_names = $class_names ? ' class="' . esc_attr($class_names) . '"' : '';

        $id = apply_filters('nav_menu_item_id', 'menu-item-' . $item->ID, $item, $args, $depth);
        $id = $id ? ' id="' . esc_attr($id) . '"' : '';

        $output .= $indent . '<li' . $id . $class_names . '>';

        $atts = [];
        $atts['title']  = !empty($item->attr_title) ? $item->attr_title : '';
        $atts['target'] = !empty($item->target) ? $item->target : '';
        $atts['rel']    = !empty($item->xfn) ? $item->xfn : '';
        $atts['href']   = !empty($item->url) ? $item->url : '';
        $atts['class']  = 'menu-link';

        // Add aria attributes for dropdowns
        if (in_array('menu-item-has-children', $classes)) {
            $atts['aria-haspopup'] = 'true';
            $atts['aria-expanded'] = 'false';
            $atts['class'] .= ' has-dropdown-trigger';
        }

        // Add aria-current for active items
        if (in_array('current-menu-item', $classes)) {
            $atts['aria-current'] = 'page';
        }

        $atts = apply_filters('nav_menu_link_attributes', $atts, $item, $args, $depth);

        $attributes = '';
        foreach ($atts as $attr => $value) {
            if (!empty($value)) {
                $value = ('href' === $attr) ? esc_url($value) : esc_attr($value);
                $attributes .= ' ' . $attr . '="' . $value . '"';
            }
        }

        $title = apply_filters('the_title', $item->title, $item->ID);
        $title = apply_filters('nav_menu_item_title', $title, $item, $args, $depth);

        $item_output = $args->before ?? '';
        $item_output .= '<a' . $attributes . '>';
        $item_output .= ($args->link_before ?? '') . $title . ($args->link_after ?? '');

        // Add dropdown icon for items with children
        if (in_array('menu-item-has-children', $classes)) {
            $item_output .= '<svg class="menu-dropdown-icon" width="12" height="12" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg">';
            $item_output .= '<path d="M3 4.5L6 7.5L9 4.5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>';
            $item_output .= '</svg>';
        }

        $item_output .= '</a>';
        $item_output .= $args->after ?? '';

        $output .= apply_filters('walker_nav_menu_start_el', $item_output, $item, $depth, $args);
    }

    /**
     * Starts the list before the elements are added.
     *
     * @param string   $output Used to append additional content (passed by reference).
     * @param int      $depth  Depth of menu item. Used for padding.
     * @param \stdClass $args  An object of wp_nav_menu() arguments.
     */
    public function start_lvl(&$output, $depth = 0, $args = null)
    {
        $indent = str_repeat("\t", $depth);
        $classes = 'sub-menu sub-menu--depth-' . $depth;

        if ($depth === 0) {
            $classes .= ' dropdown-menu';
        }

        $output .= "\n$indent<ul class=\"$classes\">\n";
    }
}
