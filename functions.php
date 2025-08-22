<?php
/**
 * ScodeTheme Functions
 * 
 * @package ScodeTheme
 * @version 2.0.0
 * 
 * Theme Architecture:
 * - Assets organization (CSS/JS/IMG/Fonts)
 * - WooCommerce integration
 * - Custom Post Types & Taxonomies
 * - Theme Options (ACF)
 * - Component system
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Theme Setup & Foundation
 */
function scode_theme_setup() {
    // Add theme support for various features
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('custom-logo');
    add_theme_support('custom-background');
    add_theme_support('custom-header');
    add_theme_support('html5', array(
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
        'style',
        'script'
    ));
    
    // WooCommerce support
    add_theme_support('woocommerce');
    add_theme_support('wc-product-gallery-zoom');
    add_theme_support('wc-product-gallery-lightbox');
    add_theme_support('wc-product-gallery-slider');
    
    // Editor styles
    add_theme_support('editor-styles');
    add_editor_style('assets/css/editor-style.css');
    
    // Set content width (1200-1320px as per requirements)
    if (!isset($content_width)) {
        $content_width = 1320;
    }
    
    // Register navigation menus
    register_nav_menus(array(
        'primary' => __('Primary Menu', 'scode-theme'),
        'mega-menu' => __('Mega Menu Categories', 'scode-theme'),
        'footer' => __('Footer Menu', 'scode-theme'),
        'mobile' => __('Mobile Menu', 'scode-theme')
    ));
    
    // Add image sizes
    add_image_size('scode-thumbnail', 350, 250, true);
    add_image_size('scode-medium', 600, 400, true);
    add_image_size('scode-large', 800, 600, true);
    add_image_size('scode-hero', 1320, 600, true);
    add_image_size('scode-product-card', 280, 280, true);
    add_image_size('scode-brand-logo', 120, 60, true);
}
add_action('after_setup_theme', 'scode_theme_setup');

/**
 * Enqueue scripts and styles with proper versioning
 */
function scode_theme_scripts() {
    // Get file modification time for versioning
    $css_version = file_exists(get_template_directory() . '/assets/css/main.css') 
        ? filemtime(get_template_directory() . '/assets/css/main.css') 
        : '1.0.0';
    
    $js_version = file_exists(get_template_directory() . '/assets/js/main.js') 
        ? filemtime(get_template_directory() . '/assets/js/main.js') 
        : '1.0.0';
    
    // Enqueue main stylesheet
    wp_enqueue_style('scode-theme-style', get_stylesheet_uri(), array(), '1.0.0');
    
    // Enqueue main CSS file - ensure this loads
    wp_enqueue_style('scode-main', get_template_directory_uri() . '/assets/css/main.css', array(), $css_version);
    
    // Google Fonts
    wp_enqueue_style('scode-google-fonts', 'https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=JetBrains+Mono:wght@400;500;600&display=swap', array(), null);
    
    // Font Awesome
    wp_enqueue_style('scode-fontawesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css', array(), '6.4.0');
    
    // Swiper for sliders
    wp_enqueue_style('swiper', 'https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css', array(), '10.0.0');
    
    // Enqueue theme JavaScript
    wp_enqueue_script('swiper', 'https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js', array(), '10.0.0', true);
    wp_enqueue_script('scode-main', get_template_directory_uri() . '/assets/js/main.js', array('swiper'), $js_version, true);
    
    // Localize script for AJAX
    wp_localize_script('scode-main', 'scode_ajax', array(
        'ajax_url' => admin_url('admin-ajax.php'),
        'nonce' => wp_create_nonce('scode_nonce'),
        'home_url' => home_url(),
        'is_woocommerce' => class_exists('WooCommerce')
    ));
    
    // Comment reply script
    if (is_singular() && comments_open() && get_option('thread_comments')) {
        wp_enqueue_script('comment-reply');
    }
}
add_action('wp_enqueue_scripts', 'scode_theme_scripts');

/**
 * Register widget areas
 */
function scode_theme_widgets_init() {
    // Sidebar
    register_sidebar(array(
        'name'          => __('Sidebar', 'scode-theme'),
        'id'            => 'sidebar-1',
        'description'   => __('Add widgets here to appear in your sidebar.', 'scode-theme'),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget'  => '</section>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ));
    
    // Footer widget areas
    for ($i = 1; $i <= 4; $i++) {
        register_sidebar(array(
            'name'          => sprintf(__('Footer Widget Area %d', 'scode-theme'), $i),
            'id'            => 'footer-' . $i,
            'description'   => sprintf(__('Add widgets here to appear in footer area %d.', 'scode-theme'), $i),
            'before_widget' => '<div id="%1$s" class="widget %2$s">',
            'after_widget'  => '</div>',
            'before_title'  => '<h3 class="widget-title">',
            'after_title'   => '</h3>',
        ));
    }
}
add_action('widgets_init', 'scode_theme_widgets_init');

/**
 * Custom Post Types
 */
function scode_theme_custom_post_types() {
    // Deal/Flash Sale CPT
    register_post_type('deal', array(
        'labels' => array(
            'name' => __('Deals', 'scode-theme'),
            'singular_name' => __('Deal', 'scode-theme'),
            'add_new' => __('Add New Deal', 'scode-theme'),
            'add_new_item' => __('Add New Deal', 'scode-theme'),
            'edit_item' => __('Edit Deal', 'scode-theme'),
            'new_item' => __('New Deal', 'scode-theme'),
            'view_item' => __('View Deal', 'scode-theme'),
            'search_items' => __('Search Deals', 'scode-theme'),
            'not_found' => __('No deals found', 'scode-theme'),
            'not_found_in_trash' => __('No deals found in trash', 'scode-theme'),
        ),
        'public' => true,
        'has_archive' => true,
        'supports' => array('title', 'editor', 'thumbnail', 'excerpt'),
        'menu_icon' => 'dashicons-clock',
        'show_in_rest' => true,
        'rewrite' => array('slug' => 'deal'),
    ));
    
    // Banner CPT for Hero Slider
    register_post_type('banner', array(
        'labels' => array(
            'name' => __('Banners', 'scode-theme'),
            'singular_name' => __('Banner', 'scode-theme'),
            'add_new' => __('Add New Banner', 'scode-theme'),
            'add_new_item' => __('Add New Banner', 'scode-theme'),
            'edit_item' => __('Edit Banner', 'scode-theme'),
            'new_item' => __('New Banner', 'scode-theme'),
            'view_item' => __('View Banner', 'scode-theme'),
            'search_items' => __('Search Banners', 'scode-theme'),
            'not_found' => __('No banners found', 'scode-theme'),
            'not_found_in_trash' => __('No banners found in trash', 'scode-theme'),
        ),
        'public' => true,
        'has_archive' => false,
        'supports' => array('title', 'editor', 'thumbnail'),
        'menu_icon' => 'dashicons-images-alt2',
        'show_in_rest' => true,
    ));
}
add_action('init', 'scode_theme_custom_post_types');

/**
 * Custom Taxonomies
 */
function scode_theme_custom_taxonomies() {
    // Brand taxonomy
    register_taxonomy('brand', array('product'), array(
        'labels' => array(
            'name' => __('Brands', 'scode-theme'),
            'singular_name' => __('Brand', 'scode-theme'),
            'search_items' => __('Search Brands', 'scode-theme'),
            'all_items' => __('All Brands', 'scode-theme'),
            'parent_item' => __('Parent Brand', 'scode-theme'),
            'parent_item_colon' => __('Parent Brand:', 'scode-theme'),
            'edit_item' => __('Edit Brand', 'scode-theme'),
            'update_item' => __('Update Brand', 'scode-theme'),
            'add_new_item' => __('Add New Brand', 'scode-theme'),
            'new_item_name' => __('New Brand Name', 'scode-theme'),
            'menu_name' => __('Brands', 'scode-theme'),
        ),
        'hierarchical' => true,
        'show_ui' => true,
        'show_admin_column' => true,
        'query_var' => true,
        'rewrite' => array('slug' => 'brand'),
        'show_in_rest' => true,
    ));
    
    // Feature tags (Nổi bật, Trả góp, etc.)
    register_taxonomy('feature_tag', array('product'), array(
        'labels' => array(
            'name' => __('Feature Tags', 'scode-theme'),
            'singular_name' => __('Feature Tag', 'scode-theme'),
            'search_items' => __('Search Feature Tags', 'scode-theme'),
            'all_items' => __('All Feature Tags', 'scode-theme'),
            'edit_item' => __('Edit Feature Tag', 'scode-theme'),
            'update_item' => __('Update Feature Tag', 'scode-theme'),
            'add_new_item' => __('Add New Feature Tag', 'scode-theme'),
            'new_item_name' => __('New Feature Tag Name', 'scode-theme'),
            'menu_name' => __('Feature Tags', 'scode-theme'),
        ),
        'hierarchical' => false,
        'show_ui' => true,
        'show_admin_column' => true,
        'query_var' => true,
        'rewrite' => array('slug' => 'feature'),
        'show_in_rest' => true,
    ));
}
add_action('init', 'scode_theme_custom_taxonomies');

/**
 * WooCommerce customizations
 */
if (class_exists('WooCommerce')) {
    // Remove WooCommerce default styles
    add_filter('woocommerce_enqueue_styles', '__return_empty_array');
    
    // Customize WooCommerce pagination
    function scode_theme_woocommerce_pagination_args($args) {
        $args['prev_text'] = __('← Trước', 'scode-theme');
        $args['next_text'] = __('Sau →', 'scode-theme');
        return $args;
    }
    add_filter('woocommerce_pagination_args', 'scode_theme_woocommerce_pagination_args');
    
    // Customize WooCommerce breadcrumbs
    function scode_theme_woocommerce_breadcrumb_defaults($args) {
        $args['delimiter'] = ' <i class="fas fa-chevron-right"></i> ';
        $args['wrap_before'] = '<nav class="woocommerce-breadcrumb">';
        $args['wrap_after'] = '</nav>';
        return $args;
    }
    add_filter('woocommerce_breadcrumb_defaults', 'scode_theme_woocommerce_breadcrumb_defaults');
    
    // AJAX cart count update
    function scode_theme_get_cart_count() {
        if (class_exists('WooCommerce')) {
            wp_send_json_success(array('count' => WC()->cart->get_cart_contents_count()));
        }
        wp_send_json_error();
    }
    add_action('wp_ajax_get_cart_count', 'scode_theme_get_cart_count');
    add_action('wp_ajax_nopriv_get_cart_count', 'scode_theme_get_cart_count');
    
    // Add discount percentage to product cards
    function scode_theme_product_discount_percentage() {
        global $product;
        if ($product->is_on_sale()) {
            $regular_price = $product->get_regular_price();
            $sale_price = $product->get_sale_price();
            if ($regular_price && $sale_price) {
                $percentage = round((1 - $sale_price / $regular_price) * 100);
                echo '<span class="discount-badge">-' . $percentage . '%</span>';
            }
        }
    }
    add_action('woocommerce_before_shop_loop_item_title', 'scode_theme_product_discount_percentage');
}

/**
 * Security enhancements
 */
function scode_theme_security_enhancements() {
    // Remove WordPress version from head
    remove_action('wp_head', 'wp_generator');
    
    // Remove WordPress version from RSS feeds
    add_filter('the_generator', '__return_empty_string');
    
    // Disable XML-RPC
    add_filter('xmlrpc_enabled', '__return_false');
    
    // Hide login errors
    add_filter('login_errors', function() {
        return __('Đã xảy ra lỗi!', 'scode-theme');
    });
}
add_action('init', 'scode_theme_security_enhancements');

/**
 * Performance optimizations
 */
function scode_theme_performance_optimizations() {
    // Remove unnecessary WordPress features
    remove_action('wp_head', 'wlwmanifest_link');
    remove_action('wp_head', 'rsd_link');
    remove_action('wp_head', 'wp_shortlink_wp_head');
    
    // Disable emojis
    remove_action('wp_head', 'print_emoji_detection_script', 7);
    remove_action('wp_print_styles', 'print_emoji_styles');
    remove_action('admin_print_scripts', 'print_emoji_detection_script');
    add_action('admin_print_styles', 'print_emoji_styles');
}
add_action('init', 'scode_theme_performance_optimizations');

/**
 * Theme activation hook
 */
function scode_theme_activation() {
    // Flush rewrite rules
    flush_rewrite_rules();
    
    // Set default options
    if (!get_option('scode_theme_options')) {
        update_option('scode_theme_options', array(
            'primary_color' => '#FF6A00',
            'secondary_color' => '#1e3a8a',
            'hero_title' => __('Chào mừng đến với ScodeTheme', 'scode-theme'),
            'hero_description' => __('Theme WordPress hiện đại, tối ưu cho WooCommerce với thiết kế sạch sẽ và hiệu suất tuyệt vời.', 'scode-theme'),
            'hero_cta_text' => __('Khám phá ngay', 'scode-theme'),
            'hero_cta_url' => home_url('/shop'),
            'product_grid_columns' => '4',
            'show_category_banners' => true,
            'footer_text' => __('© 2024 ScodeTheme. Tất cả quyền được bảo lưu.', 'scode-theme'),
            'hotline' => '+84 123 456 789',
            'address' => '123 Đường ABC, Quận XYZ, TP.HCM',
            'email' => 'info@scode.com',
        ));
    }
}
add_action('after_switch_theme', 'scode_theme_activation');

/**
 * Theme deactivation hook
 */
function scode_theme_deactivation() {
    // Flush rewrite rules
    flush_rewrite_rules();
}
add_action('switch_theme', 'scode_theme_deactivation');

/**
 * Load theme text domain
 */
function scode_theme_load_textdomain() {
    load_theme_textdomain('scode-theme', get_template_directory() . '/languages');
}
add_action('after_setup_theme', 'scode_theme_load_textdomain');

/**
 * Helper function to get theme option with fallback
 * Note: This function is now defined in inc/theme-options.php
 * to support both ACF and theme mods
 */

/**
 * Helper function to check if WooCommerce is active
 */
function scode_theme_is_woocommerce_active() {
    return class_exists('WooCommerce');
}

/**
 * Add custom body classes
 */
function scode_theme_body_classes($classes) {
    if (scode_theme_is_woocommerce_active()) {
        $classes[] = 'woocommerce-active';
    }
    
    if (get_theme_mod('scode_show_category_banners', true)) {
        $classes[] = 'show-category-banners';
    }
    
    return $classes;
}
add_filter('body_class', 'scode_theme_body_classes');

/**
 * Include additional functionality
 */
require_once str_replace('\\', '/', get_template_directory()) . '/inc/theme-options.php';
require_once str_replace('\\', '/', get_template_directory()) . '/inc/woocommerce-overrides.php';
require_once str_replace('\\', '/', get_template_directory()) . '/inc/customizer.php';
