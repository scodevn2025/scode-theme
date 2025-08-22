<?php
/**
 * ScodeTheme Functions - Simplified Version
 *
 * @package ScodeTheme
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

// Define theme constants
define('SCODE_THEME_VERSION', '2.1.0');
define('SCODE_THEME_DIR', get_template_directory());
define('SCODE_THEME_URI', get_template_directory_uri());

/**
 * Theme Setup
 */
function scode_theme_setup() {
    // Add theme support
    add_theme_support('post-thumbnails');
    add_theme_support('title-tag');
    add_theme_support('custom-logo');
    add_theme_support('html5', array(
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
    ));
    
    // WooCommerce support
    add_theme_support('woocommerce');
    
    // Register navigation menus
    register_nav_menus(array(
        'primary' => __('Primary Menu', 'scode-theme'),
        'footer' => __('Footer Menu', 'scode-theme'),
    ));
    
    // Add image sizes
    add_image_size('product-thumb', 300, 300, true);
    add_image_size('product-medium', 400, 400, true);
}
add_action('after_setup_theme', 'scode_theme_setup');

/**
 * Enqueue scripts and styles
 */
function scode_theme_scripts() {
    // Main stylesheet
    wp_enqueue_style('scode-theme-style', get_stylesheet_uri(), array(), SCODE_THEME_VERSION);
    
    // Custom CSS
    wp_enqueue_style('scode-theme-custom', SCODE_THEME_URI . '/assets/css/custom.css', array(), SCODE_THEME_VERSION);
    
    // Google Fonts
    wp_enqueue_style('google-fonts', 'https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap', array(), null);
    
    // Font Awesome
    wp_enqueue_style('font-awesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css', array(), '6.4.0');
    
    // Main JavaScript
    wp_enqueue_script('scode-theme-main', SCODE_THEME_URI . '/assets/js/main.js', array('jquery'), SCODE_THEME_VERSION, true);
    
    // Localize script for AJAX
    wp_localize_script('scode-theme-main', 'scode_ajax', array(
        'ajax_url' => admin_url('admin-ajax.php'),
        'nonce' => wp_create_nonce('scode_nonce'),
        'site_url' => home_url(),
    ));
}
add_action('wp_enqueue_scripts', 'scode_theme_scripts');

/**
 * Register widget areas
 */
function scode_theme_widgets_init() {
    register_sidebar(array(
        'name' => __('Sidebar', 'scode-theme'),
        'id' => 'sidebar-1',
        'description' => __('Add widgets here.', 'scode-theme'),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget' => '</section>',
        'before_title' => '<h2 class="widget-title">',
        'after_title' => '</h2>',
    ));
    
    register_sidebar(array(
        'name' => __('Footer Widget 1', 'scode-theme'),
        'id' => 'footer-1',
        'description' => __('Footer widget area 1.', 'scode-theme'),
        'before_widget' => '<div id="%1$s" class="footer-widget %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h3>',
        'after_title' => '</h3>',
    ));
    
    register_sidebar(array(
        'name' => __('Footer Widget 2', 'scode-theme'),
        'id' => 'footer-2',
        'description' => __('Footer widget area 2.', 'scode-theme'),
        'before_widget' => '<div id="%1$s" class="footer-widget %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h3>',
        'after_title' => '</h3>',
    ));
    
    register_sidebar(array(
        'name' => __('Footer Widget 3', 'scode-theme'),
        'id' => 'footer-3',
        'description' => __('Footer widget area 3.', 'scode-theme'),
        'before_widget' => '<div id="%1$s" class="footer-widget %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h3>',
        'after_title' => '</h3>',
    ));
    
    register_sidebar(array(
        'name' => __('Footer Widget 4', 'scode-theme'),
        'id' => 'footer-4',
        'description' => __('Footer widget area 4.', 'scode-theme'),
        'before_widget' => '<div id="%1$s" class="footer-widget %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h3>',
        'after_title' => '</h3>',
    ));
}
add_action('widgets_init', 'scode_theme_widgets_init');

/**
 * Theme Options
 */
function scode_theme_get_option($key, $default = '') {
    $options = get_option('scode_theme_options', array());
    return isset($options[$key]) ? $options[$key] : $default;
}

/**
 * Customizer additions
 */
function scode_theme_customize_register($wp_customize) {
    // Header Section
    $wp_customize->add_section('scode_header', array(
        'title' => __('Header Settings', 'scode-theme'),
        'priority' => 30,
    ));
    
    // Logo
    $wp_customize->add_setting('scode_logo', array(
        'default' => '',
        'sanitize_callback' => 'esc_url_raw',
    ));
    
    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'scode_logo', array(
        'label' => __('Logo', 'scode-theme'),
        'section' => 'scode_header',
        'settings' => 'scode_logo',
    )));
    
    // Hotline
    $wp_customize->add_setting('scode_hotline', array(
        'default' => '0834.777.111',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    
    $wp_customize->add_control('scode_hotline', array(
        'label' => __('Hotline', 'scode-theme'),
        'section' => 'scode_header',
        'type' => 'text',
    ));
    
    // Email
    $wp_customize->add_setting('scode_email', array(
        'default' => 'info@otnt.vn',
        'sanitize_callback' => 'sanitize_email',
    ));
    
    $wp_customize->add_control('scode_email', array(
        'label' => __('Email', 'scode-theme'),
        'section' => 'scode_header',
        'type' => 'email',
    ));
    
    // Address
    $wp_customize->add_setting('scode_address', array(
        'default' => 'Hà Nội, Việt Nam',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    
    $wp_customize->add_control('scode_address', array(
        'label' => __('Address', 'scode-theme'),
        'section' => 'scode_header',
        'type' => 'textarea',
    ));
    
    // Social Media Section
    $wp_customize->add_section('scode_social', array(
        'title' => __('Social Media', 'scode-theme'),
        'priority' => 35,
    ));
    
    // Facebook
    $wp_customize->add_setting('scode_social_facebook', array(
        'default' => '',
        'sanitize_callback' => 'esc_url_raw',
    ));
    
    $wp_customize->add_control('scode_social_facebook', array(
        'label' => __('Facebook URL', 'scode-theme'),
        'section' => 'scode_social',
        'type' => 'url',
    ));
    
    // Instagram
    $wp_customize->add_setting('scode_social_instagram', array(
        'default' => '',
        'sanitize_callback' => 'esc_url_raw',
    ));
    
    $wp_customize->add_control('scode_social_instagram', array(
        'label' => __('Instagram URL', 'scode-theme'),
        'section' => 'scode_social',
        'type' => 'url',
    ));
    
    // YouTube
    $wp_customize->add_setting('scode_social_youtube', array(
        'default' => '',
        'sanitize_callback' => 'esc_url_raw',
    ));
    
    $wp_customize->add_control('scode_social_youtube', array(
        'label' => __('YouTube URL', 'scode-theme'),
        'section' => 'scode_social',
        'type' => 'url',
    ));
    
    // Footer Section
    $wp_customize->add_section('scode_footer', array(
        'title' => __('Footer Settings', 'scode-theme'),
        'priority' => 40,
    ));
    
    // Footer Text
    $wp_customize->add_setting('scode_footer_text', array(
        'default' => 'Tất cả quyền được bảo lưu.',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    
    $wp_customize->add_control('scode_footer_text', array(
        'label' => __('Footer Text', 'scode-theme'),
        'section' => 'scode_footer',
        'type' => 'text',
    ));
}
add_action('customize_register', 'scode_theme_customize_register');

/**
 * WooCommerce Customizations
 */
if (class_exists('WooCommerce')) {
    // Remove WooCommerce default styles
    add_filter('woocommerce_enqueue_styles', '__return_empty_array');
    
    // Add custom product fields
    add_action('woocommerce_product_options_general_product_data', 'scode_add_custom_product_fields');
    add_action('woocommerce_process_product_meta', 'scode_save_custom_product_fields');
}

/**
 * Add custom product fields
 */
function scode_add_custom_product_fields() {
    woocommerce_wp_text_input(array(
        'id' => '_product_brand',
        'label' => __('Brand', 'scode-theme'),
        'placeholder' => __('Enter product brand', 'scode-theme'),
    ));
    
    woocommerce_wp_textarea_input(array(
        'id' => '_product_features',
        'label' => __('Key Features', 'scode-theme'),
        'placeholder' => __('Enter key features (one per line)', 'scode-theme'),
    ));
}

/**
 * Save custom product fields
 */
function scode_save_custom_product_fields($post_id) {
    if (isset($_POST['_product_brand'])) {
        update_post_meta($post_id, '_product_brand', sanitize_text_field($_POST['_product_brand']));
    }
    
    if (isset($_POST['_product_features'])) {
        update_post_meta($post_id, '_product_features', sanitize_textarea_field($_POST['_product_features']));
    }
}

/**
 * Newsletter subscription handler
 */
function scode_newsletter_subscription() {
    if (!isset($_POST['newsletter_email'])) {
        return;
    }
    
    $email = sanitize_email($_POST['newsletter_email']);
    
    if (!is_email($email)) {
        return;
    }
    
    // Here you can add logic to save email to database or send to email service
    error_log('Newsletter subscription: ' . $email);
}
add_action('wp_ajax_scode_newsletter', 'scode_newsletter_subscription');
add_action('wp_ajax_nopriv_scode_newsletter', 'scode_newsletter_subscription');

/**
 * Custom excerpt length
 */
function scode_excerpt_length($length) {
    return 20;
}
add_filter('excerpt_length', 'scode_excerpt_length');

/**
 * Custom excerpt more
 */
function scode_excerpt_more($more) {
    return '...';
}
add_filter('excerpt_more', 'scode_excerpt_more');

/**
 * Add body classes
 */
function scode_body_classes($classes) {
    if (is_singular()) {
        $classes[] = 'singular';
    }
    
    if (class_exists('WooCommerce') && is_woocommerce()) {
        $classes[] = 'woocommerce-page';
    }
    
    return $classes;
}
add_filter('body_class', 'scode_body_classes');
