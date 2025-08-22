<?php
/**
 * SCODE Theme Functions
 * 
 * @package SCODE_Theme
 * @version 1.0.0
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

// ===== THEME SETUP =====
function scode_theme_setup() {
    // Add theme support for various features
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
    
    // Add WooCommerce support
    add_theme_support('woocommerce');
    add_theme_support('wc-product-gallery-zoom');
    add_theme_support('wc-product-gallery-lightbox');
    add_theme_support('wc-product-gallery-slider');
    
    // Register navigation menus
    register_nav_menus(array(
        'primary' => __('Primary Menu', 'scode-theme'),
        'footer' => __('Footer Menu', 'scode-theme'),
    ));
    
    // Add custom image sizes
    add_image_size('slide-large', 1200, 400, true);
    add_image_size('banner-medium', 600, 200, true);
    add_image_size('product-thumb', 300, 300, true);
    add_image_size('product-large', 600, 600, true);
}
add_action('after_setup_theme', 'scode_theme_setup');

// ===== WOOCOMMERCE INTEGRATION =====
function scode_woocommerce_setup() {
    // Remove default WooCommerce styles
    add_filter('woocommerce_enqueue_styles', '__return_empty_array');
    
    // Customize WooCommerce hooks
    remove_action('woocommerce_before_main_content', 'woocommerce_breadcrumb', 20);
    remove_action('woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10);
    remove_action('woocommerce_sidebar', 'woocommerce_get_sidebar', 10);
    
    // Add custom WooCommerce hooks
    add_action('woocommerce_before_main_content', 'scode_woocommerce_wrapper_start', 10);
    add_action('woocommerce_after_main_content', 'scode_woocommerce_wrapper_end', 10);
    
    // Customize product loop
    add_filter('woocommerce_product_loop_start', 'scode_product_loop_start');
    add_filter('woocommerce_product_loop_end', 'scode_product_loop_end');
    
    // Add custom product fields
    add_action('woocommerce_single_product_summary', 'scode_product_extra_info', 25);
    
    // Customize add to cart button
    add_filter('woocommerce_product_add_to_cart_text', 'scode_custom_add_to_cart_text', 10, 2);
    
    // Add AJAX add to cart
    add_action('wp_ajax_scode_add_to_cart', 'scode_ajax_add_to_cart');
    add_action('wp_ajax_nopriv_scode_add_to_cart', 'scode_ajax_add_to_cart');
}
add_action('after_setup_theme', 'scode_woocommerce_setup');

// WooCommerce wrapper functions
function scode_woocommerce_wrapper_start() {
    echo '<main class="main-content woocommerce-content">';
    echo '<div class="container">';
}

function scode_woocommerce_wrapper_end() {
    echo '</div>';
    echo '</main>';
}

// Custom product loop start
function scode_product_loop_start() {
    return '<div class="products-grid cols-4">';
}

// Custom product loop end
function scode_product_loop_end() {
    return '</div>';
}

// Custom add to cart text
function scode_custom_add_to_cart_text($text, $product) {
    if ($product->is_type('simple')) {
        return 'Thêm vào giỏ';
    } elseif ($product->is_type('variable')) {
        return 'Chọn mua';
    }
    return $text;
}

// AJAX add to cart
function scode_ajax_add_to_cart() {
    $product_id = intval($_POST['product_id']);
    $quantity = intval($_POST['quantity']);
    
    if ($product_id > 0) {
        $result = WC()->cart->add_to_cart($product_id, $quantity);
        
        if ($result) {
            wp_send_json_success(array(
                'message' => 'Đã thêm sản phẩm vào giỏ hàng!',
                'cart_count' => WC()->cart->get_cart_contents_count()
            ));
        } else {
            wp_send_json_error('Không thể thêm sản phẩm vào giỏ hàng.');
        }
    } else {
        wp_send_json_error('ID sản phẩm không hợp lệ.');
    }
}

// ===== CUSTOM POST TYPE: SLIDES =====
function scode_register_slides_post_type() {
    $labels = array(
        'name' => 'Slides',
        'singular_name' => 'Slide',
        'menu_name' => 'Slides',
        'add_new' => 'Thêm Slide mới',
        'add_new_item' => 'Thêm Slide mới',
        'edit_item' => 'Sửa Slide',
        'new_item' => 'Slide mới',
        'view_item' => 'Xem Slide',
        'search_items' => 'Tìm kiếm Slides',
        'not_found' => 'Không tìm thấy Slides',
        'not_found_in_trash' => 'Không có Slides nào trong thùng rác'
    );
    
    $args = array(
        'labels' => $labels,
        'public' => true,
        'publicly_queryable' => false,
        'show_ui' => true,
        'show_in_menu' => true,
        'query_var' => true,
        'rewrite' => array('slug' => 'slide'),
        'capability_type' => 'post',
        'has_archive' => false,
        'hierarchical' => false,
        'menu_position' => 20,
        'menu_icon' => 'dashicons-images-alt2',
        'supports' => array('title', 'editor', 'thumbnail'),
        'show_in_rest' => true,
    );
    
    register_post_type('slides', $args);
}
add_action('init', 'scode_register_slides_post_type');

// Function to get hero slides
function scode_get_hero_slides($limit = 5) {
    $args = array(
        'post_type' => 'slides',
        'post_status' => 'publish',
        'posts_per_page' => $limit,
        'meta_key' => 'slide_order',
        'orderby' => 'meta_value_num',
        'order' => 'ASC',
        'meta_query' => array(
            array(
                'key' => 'slide_order',
                'compare' => 'EXISTS',
            ),
        ),
    );
    
    return new WP_Query($args);
}

// ===== PRODUCT FUNCTIONS =====
function scode_get_featured_products($limit = 12) {
    $args = array(
        'post_type' => 'product',
        'post_status' => 'publish',
        'posts_per_page' => $limit,
        'meta_query' => array(
            array(
                'key' => '_featured',
                'value' => 'yes',
                'compare' => '='
            )
        )
    );
    
    return new WP_Query($args);
}

function scode_get_sale_products($limit = 10) {
    $args = array(
        'post_type' => 'product',
        'post_status' => 'publish',
        'posts_per_page' => $limit,
        'meta_query' => array(
            'relation' => 'OR',
            array(
                'key' => '_sale_price',
                'value' => 0,
                'compare' => '>',
                'type' => 'numeric'
            ),
            array(
                'key' => '_regular_price',
                'value' => 0,
                'compare' => '>',
                'type' => 'numeric'
            )
        )
    );
    
    return new WP_Query($args);
}

function scode_get_products_by_category($category_slug, $limit = 12) {
    $args = array(
        'post_type' => 'product',
        'post_status' => 'publish',
        'posts_per_page' => $limit,
        'tax_query' => array(
            array(
                'taxonomy' => 'product_cat',
                'field' => 'slug',
                'terms' => $category_slug
            )
        )
    );
    
    return new WP_Query($args);
}

function scode_get_best_selling_products($limit = 12) {
    $args = array(
        'post_type' => 'product',
        'post_status' => 'publish',
        'posts_per_page' => $limit,
        'meta_key' => 'total_sales',
        'orderby' => 'meta_value_num',
        'order' => 'DESC'
    );
    
    return new WP_Query($args);
}

// ===== PRODUCT CARD HELPER FUNCTIONS =====
function scode_get_product_price_html($product) {
    if (!$product) return '';
    
    $regular_price = $product->get_regular_price();
    $sale_price = $product->get_sale_price();
    
    if ($sale_price) {
        $percentage = round((($regular_price - $sale_price) / $regular_price) * 100);
        return sprintf(
            '<div class="product-price">
                <span class="old-price">%s</span>
                <span class="current-price">%s</span>
                <span class="discount-badge">-%s%%</span>
            </div>',
            wc_price($regular_price),
            wc_price($sale_price),
            $percentage
        );
    } else {
        return sprintf(
            '<div class="product-price">
                <span class="current-price">%s</span>
            </div>',
            wc_price($regular_price)
        );
    }
}

function scode_get_product_badges($product) {
    if (!$product) return '';
    
    $badges = array();
    
    // Sale badge
    if ($product->is_on_sale()) {
        $badges[] = '<span class="product-badge sale">Giảm giá</span>';
    }
    
    // New badge (products created in last 30 days)
    $days_ago = (time() - strtotime($product->get_date_created())) / DAY_IN_SECONDS;
    if ($days_ago <= 30) {
        $badges[] = '<span class="product-badge new">Mới</span>';
    }
    
    // Featured badge
    if ($product->get_meta('_featured') === 'yes') {
        $badges[] = '<span class="product-badge featured">Nổi bật</span>';
    }
    
    if (!empty($badges)) {
        return '<div class="product-badges">' . implode('', $badges) . '</div>';
    }
    
    return '';
}

// ===== ENQUEUE SCRIPTS & STYLES =====
function scode_enqueue_scripts() {
    // Theme stylesheet
    wp_enqueue_style('scode-style', get_stylesheet_uri(), array(), '1.0.0');
    
    // Custom CSS
    wp_enqueue_style('scode-custom', get_template_directory_uri() . '/assets/css/custom.css', array(), '1.0.0');
    
    // jQuery (WordPress includes this by default)
    wp_enqueue_script('jquery');
    
    // Main JavaScript
    wp_enqueue_script('scode-main', get_template_directory_uri() . '/assets/js/main.js', array('jquery'), '1.0.0', true);
    
    // Localize script for AJAX
    wp_localize_script('scode-main', 'scode_ajax', array(
        'ajax_url' => admin_url('admin-ajax.php'),
        'nonce' => wp_create_nonce('scode_nonce'),
        'cart_url' => wc_get_cart_url(),
        'checkout_url' => wc_get_checkout_url(),
    ));
    
    // WooCommerce specific scripts
    if (class_exists('WooCommerce')) {
        wp_enqueue_script('scode-woocommerce', get_template_directory_uri() . '/assets/js/woocommerce.js', array('jquery'), '1.0.0', true);
    }
}
add_action('wp_enqueue_scripts', 'scode_enqueue_scripts');

// ===== CUSTOMIZER SETTINGS =====
function scode_customize_register($wp_customize) {
    // Logo section
    $wp_customize->add_section('scode_logo', array(
        'title' => __('Logo & Branding', 'scode-theme'),
        'priority' => 30,
    ));
    
    // Logo image
    $wp_customize->add_setting('scode_logo', array(
        'default' => '',
        'sanitize_callback' => 'esc_url_raw',
    ));
    
    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'scode_logo', array(
        'label' => __('Logo Image', 'scode-theme'),
        'section' => 'scode_logo',
        'settings' => 'scode_logo',
    )));
    
    // MI Logo
    $wp_customize->add_setting('scode_mi_logo', array(
        'default' => '',
        'sanitize_callback' => 'esc_url_raw',
    ));
    
    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'scode_mi_logo', array(
        'label' => __('MI Vietnam Logo', 'scode-theme'),
        'section' => 'scode_logo',
        'settings' => 'scode_mi_logo',
    )));
    
    // Roborock Logo
    $wp_customize->add_setting('scode_roborock_logo', array(
        'default' => '',
        'sanitize_customize_control' => 'esc_url_raw',
    ));
    
    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'scode_roborock_logo', array(
        'label' => __('Roborock Logo', 'scode-theme'),
        'section' => 'scode_logo',
        'settings' => 'scode_roborock_logo',
    )));
    
    // Contact section
    $wp_customize->add_section('scode_contact', array(
        'title' => __('Contact Information', 'scode-theme'),
        'priority' => 40,
    ));
    
    // Hotline
    $wp_customize->add_setting('scode_hotline', array(
        'default' => '0834.777.111',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    
    $wp_customize->add_control('scode_hotline', array(
        'label' => __('Hotline', 'scode-theme'),
        'section' => 'scode_contact',
        'type' => 'text',
    ));
    
    // Email
    $wp_customize->add_setting('scode_email', array(
        'default' => 'info@otnt.vn',
        'sanitize_callback' => 'sanitize_email',
    ));
    
    $wp_customize->add_control('scode_email', array(
        'label' => __('Email', 'scode-theme'),
        'section' => 'scode_contact',
        'type' => 'email',
    ));
    
    // Address
    $wp_customize->add_setting('scode_address', array(
        'default' => '123 Đường ABC, Quận XYZ, TP.HCM',
        'sanitize_callback' => 'sanitize_textarea_field',
    ));
    
    $wp_customize->add_control('scode_address', array(
        'label' => __('Address', 'scode-theme'),
        'section' => 'scode_contact',
        'type' => 'textarea',
    ));
}
add_action('customize_register', 'scode_customize_register');

// ===== WIDGET AREAS =====
function scode_widgets_init() {
    register_sidebar(array(
        'name' => __('Footer Widget 1', 'scode-theme'),
        'id' => 'footer-1',
        'description' => __('Add widgets here.', 'scode-theme'),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h3 class="widget-title">',
        'after_title' => '</h3>',
    ));
    
    register_sidebar(array(
        'name' => __('Footer Widget 2', 'scode-theme'),
        'id' => 'footer-2',
        'description' => __('Add widgets here.', 'scode-theme'),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h3 class="widget-title">',
        'after_title' => '</h3>',
    ));
    
    register_sidebar(array(
        'name' => __('Footer Widget 3', 'scode-theme'),
        'id' => 'footer-3',
        'description' => __('Add widgets here.', 'scode-theme'),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h3 class="widget-title">',
        'after_title' => '</h3>',
    ));
    
    register_sidebar(array(
        'name' => __('Footer Widget 4', 'scode-theme'),
        'id' => 'footer-4',
        'description' => __('Add widgets here.', 'scode-theme'),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h3 class="widget-title">',
        'after_title' => '</h3>',
    ));
}
add_action('widgets_init', 'scode_widgets_init');

// ===== UTILITY FUNCTIONS =====
function scode_get_theme_option($key, $default = '') {
    return get_theme_mod($key, $default);
}

function scode_format_price($price) {
    if (class_exists('WooCommerce')) {
        return wc_price($price);
    }
    return number_format($price, 0, ',', '.') . 'đ';
}

function scode_get_product_rating($product) {
    if (!$product || !class_exists('WooCommerce')) return '';
    
    $rating = $product->get_average_rating();
    $count = $product->get_review_count();
    
    if ($rating > 0) {
        $stars = '';
        for ($i = 1; $i <= 5; $i++) {
            if ($i <= $rating) {
                $stars .= '<i class="fas fa-star"></i>';
            } elseif ($i - $rating < 1) {
                $stars .= '<i class="fas fa-star-half-alt"></i>';
            } else {
                $stars .= '<i class="far fa-star"></i>';
            }
        }
        
        return sprintf(
            '<div class="product-rating">
                <div class="stars">%s</div>
                <span class="rating-text">(%s đánh giá)</span>
            </div>',
            $stars,
            $count
        );
    }
    
    return '';
}

// ===== INCLUDES =====
// Include customizer
require get_template_directory() . '/inc/customizer.php';

// Include theme options
require get_template_directory() . '/inc/theme-options.php';

// Include WooCommerce overrides
require get_template_directory() . '/inc/woocommerce-overrides.php';
