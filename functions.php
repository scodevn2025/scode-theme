<?php
/**
 * SCODE Theme Functions - Complete Version
 * 
 * @package SCODE_Theme
 * @version 3.0.0
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
    add_image_size('product-medium', 400, 400, true);
    add_image_size('thumbnail', 150, 150, true);
    add_image_size('medium', 300, 300, false);
    add_image_size('large', 1024, 1024, false);
}
add_action('after_setup_theme', 'scode_theme_setup');

// ===== WOOCOMMERCE SETUP =====
function scode_woocommerce_setup() {
    // Only run if WooCommerce is active
    if (!class_exists('WooCommerce')) {
        return;
    }
    
    // Remove default WooCommerce styles
    add_filter('woocommerce_enqueue_styles', '__return_empty_array');
    
    // Custom content wrappers
    add_action('woocommerce_before_main_content', 'scode_woocommerce_wrapper_start');
    add_action('woocommerce_after_main_content', 'scode_woocommerce_wrapper_end');
    
    // Customize product loop
    add_action('woocommerce_before_shop_loop', 'scode_woocommerce_loop_start');
    add_action('woocommerce_after_shop_loop', 'scode_woocommerce_loop_end');
    
    // Add custom product fields
    add_action('woocommerce_product_options_general_product_data', 'scode_add_custom_product_fields');
    add_action('woocommerce_process_product_meta', 'scode_save_custom_product_fields');
    
    // Customize add to cart text
    add_filter('woocommerce_product_add_to_cart_text', 'scode_customize_add_to_cart_text', 10, 2);
    
    // Add custom product meta display
    add_action('woocommerce_single_product_summary', 'scode_display_custom_product_fields', 25);
    
    // Fix image display issues
    add_filter('woocommerce_product_get_image', 'scode_fix_product_image', 10, 2);
    add_filter('woocommerce_single_product_image_thumbnail_html', 'scode_fix_single_product_image', 10, 2);
    

}
add_action('after_setup_theme', 'scode_woocommerce_setup');

// ===== FIX IMAGE DISPLAY ISSUES =====
function scode_fix_product_image($image, $product) {
    if (!$product || !is_object($product)) {
        return $image;
    }
    
    $product_id = $product->get_id();
    if (has_post_thumbnail($product_id)) {
        $thumbnail_id = get_post_thumbnail_id($product_id);
        $image_url = wp_get_attachment_image_url($thumbnail_id, 'product-thumb');
        $image_alt = get_post_meta($thumbnail_id, '_wp_attachment_image_alt', true);
        
        if ($image_url) {
            return sprintf(
                '<img src="%s" alt="%s" class="attachment-woocommerce_thumbnail size-woocommerce_thumbnail" loading="lazy" width="300" height="300">',
                esc_url($image_url),
                esc_attr($image_alt)
            );
        }
    }
    
    return $image;
}

function scode_fix_single_product_image($html, $attachment_id) {
    if (!$attachment_id) {
        return $html;
    }
    
    $image_url = wp_get_attachment_image_url($attachment_id, 'product-large');
    $image_alt = get_post_meta($attachment_id, '_wp_attachment_image_alt', true);
    
    if ($image_url) {
        return sprintf(
            '<img src="%s" alt="%s" class="wp-post-image" loading="lazy">',
            esc_url($image_url),
            esc_attr($image_alt)
        );
    }
    
    return $html;
}

// WooCommerce wrapper functions
function scode_woocommerce_wrapper_start() {
    echo '<div class="woocommerce-wrapper">';
    echo '<div class="container">';
}

function scode_woocommerce_wrapper_end() {
    echo '</div>';
    echo '</div>';
}

function scode_woocommerce_loop_start() {
    echo '<div class="woocommerce-loop">';
}

function scode_woocommerce_loop_end() {
    echo '</div>';
}


// Add custom product fields
function scode_add_custom_product_fields() {
    // Only run if WooCommerce is active
    if (!class_exists('WooCommerce')) {
        return;
    }
    
    global $woocommerce, $post;
    
    echo '<div class="options_group">';
    
    // Product Badges
    echo '<h4 style="margin: 20px 0 10px; padding: 10px; background: #f1f1f1; border-left: 4px solid #0073aa;">Product Badges</h4>';
    
    woocommerce_wp_checkbox(array(
        'id' => '_is_new',
        'label' => __('Is New Product', 'scode-theme'),
        'description' => __('Check if this is a new product', 'scode-theme')
    ));
    
    woocommerce_wp_checkbox(array(
        'id' => '_is_premium',
        'label' => __('Is Premium Product', 'scode-theme'),
        'description' => __('Check if this is a premium product', 'scode-theme')
    ));
    
    woocommerce_wp_checkbox(array(
        'id' => '_is_global',
        'label' => __('Is Global Version', 'scode-theme'),
        'description' => __('Check if this is a global version', 'scode-theme')
    ));
    
    woocommerce_wp_checkbox(array(
        'id' => '_is_genuine',
        'label' => __('Is 100% Genuine', 'scode-theme'),
        'description' => __('Check if this is 100% genuine product', 'scode-theme')
    ));
    
    // Product Features
    echo '<h4 style="margin: 20px 0 10px; padding: 10px; background: #f1f1f1; border-left: 4px solid #0073aa;">Product Features</h4>';
    
    woocommerce_wp_textarea_input(array(
        'id' => '_product_features',
        'label' => __('Product Features', 'scode-theme'),
        'description' => __('Enter product features (one per line)', 'scode-theme'),
        'placeholder' => "Feature 1\nFeature 2\nFeature 3"
    ));
    
    woocommerce_wp_text_input(array(
        'id' => '_gift_value',
        'label' => __('Gift Value', 'scode-theme'),
        'description' => __('Enter gift value (e.g., 4.990K, 279K)', 'scode-theme'),
        'placeholder' => '4.990K'
    ));
    
    woocommerce_wp_text_input(array(
        'id' => '_gift_description',
        'label' => __('Gift Description', 'scode-theme'),
        'description' => __('Enter gift description', 'scode-theme'),
        'placeholder' => 'Máy hút bụi Tineco iFloor 2 Max'
    ));
    
    echo '</div>';
}

function scode_save_custom_product_fields($post_id) {
    // Only run if WooCommerce is active
    if (!class_exists('WooCommerce')) {
        return;
    }
    
    // Save product badges
    $is_new = isset($_POST['_is_new']) ? 'yes' : 'no';
    update_post_meta($post_id, '_is_new', $is_new);
    
    $is_premium = isset($_POST['_is_premium']) ? 'yes' : 'no';
    update_post_meta($post_id, '_is_premium', $is_premium);
    
    $is_global = isset($_POST['_is_global']) ? 'yes' : 'no';
    update_post_meta($post_id, '_is_global', $is_global);
    
    $is_genuine = isset($_POST['_is_genuine']) ? 'yes' : 'no';
    update_post_meta($post_id, '_is_genuine', $is_genuine);
    
    // Save product features
    if (isset($_POST['_product_features'])) {
        update_post_meta($post_id, '_product_features', sanitize_textarea_field($_POST['_product_features']));
    }
    
    if (isset($_POST['_gift_value'])) {
        update_post_meta($post_id, '_gift_value', sanitize_text_field($_POST['_gift_value']));
    }
    
    if (isset($_POST['_gift_description'])) {
        update_post_meta($post_id, '_gift_description', sanitize_text_field($_POST['_gift_description']));
    }
}

function scode_display_custom_product_fields() {
    // Only run if WooCommerce is active
    if (!class_exists('WooCommerce')) {
        return;
    }
    
    global $product;
    if (!$product) return;
    
    $product_id = $product->get_id();
    
    // Display product badges
    $badges = array();
    if (get_post_meta($product_id, '_is_new', true) === 'yes') {
        $badges[] = '<span class="badge new">NEW</span>';
    }
    if (get_post_meta($product_id, '_is_premium', true) === 'yes') {
        $badges[] = '<span class="badge premium">PREMIUM</span>';
    }
    if (get_post_meta($product_id, '_is_global', true) === 'yes') {
        $badges[] = '<span class="badge global">GLOBAL</span>';
    }
    if (get_post_meta($product_id, '_is_genuine', true) === 'yes') {
        $badges[] = '<span class="badge genuine">100% GENUINE</span>';
    }
    
    if (!empty($badges)) {
        echo '<div class="product-badges-section">';
        echo '<h4>Sản phẩm của chúng tôi</h4>';
        echo '<div class="badges-container">';
        foreach ($badges as $badge) {
            echo $badge;
        }
        echo '</div>';
        echo '</div>';
    }
    
    // Display product features
    $features = get_post_meta($product_id, '_product_features', true);
    if (!empty($features)) {
        echo '<div class="product-features-display">';
        echo '<h3>Đặc điểm nổi bật</h3>';
        echo '<ul>';
        $features_array = explode("\n", $features);
        foreach ($features_array as $feature) {
            if (trim($feature)) {
                echo '<li>' . esc_html(trim($feature)) . '</li>';
            }
        }
        echo '</ul>';
        echo '</div>';
    }
    
    // Display gift information
    $gift_value = get_post_meta($product_id, '_gift_value', true);
    $gift_description = get_post_meta($product_id, '_gift_description', true);
    
    if (!empty($gift_value) || !empty($gift_description)) {
        echo '<div class="product-gift-info">';
        echo '<div class="gift-badge">';
        echo '<i class="fas fa-gift"></i>';
        echo '<span>QUÀ TẶNG</span>';
        echo '</div>';
        if (!empty($gift_description)) {
            echo '<p class="gift-text">' . esc_html($gift_description);
            if (!empty($gift_value)) {
                echo ' - Giá trị: ' . esc_html($gift_value);
            }
            echo '</p>';
        }
        echo '</div>';
    }
}

function scode_customize_add_to_cart_text($text, $product) {
    // Only run if WooCommerce is active
    if (!class_exists('WooCommerce')) {
        return $text;
    }
    
    if ($product->is_type('simple')) {
        return __('Thêm vào giỏ', 'scode-theme');
    } elseif ($product->is_type('variable')) {
        return __('Chọn mua', 'scode-theme');
    } elseif ($product->is_type('grouped')) {
        return __('Xem sản phẩm', 'scode-theme');
    } elseif ($product->is_type('external')) {
        return __('Mua ngay', 'scode-theme');
    }
    
    return $text;
}

// ===== CUSTOM POST TYPES =====
function scode_register_slides_post_type() {
    $labels = array(
        'name' => 'Hero Slides',
        'singular_name' => 'Hero Slide',
        'menu_name' => 'Hero Slides',
        'add_new' => 'Add New Slide',
        'add_new_item' => 'Add New Hero Slide',
        'edit_item' => 'Edit Hero Slide',
        'new_item' => 'New Hero Slide',
        'view_item' => 'View Hero Slide',
        'search_items' => 'Search Hero Slides',
        'not_found' => 'No hero slides found',
        'not_found_in_trash' => 'No hero slides found in trash'
    );
    
    $args = array(
        'labels' => $labels,
        'public' => false,
        'show_ui' => true,
        'show_in_menu' => true,
        'capability_type' => 'post',
        'hierarchical' => false,
        'rewrite' => false,
        'supports' => array('title', 'editor', 'thumbnail', 'custom-fields'),
        'menu_icon' => 'dashicons-slides'
    );
    
    register_post_type('hero_slide', $args);
}
add_action('init', 'scode_register_slides_post_type');

// ===== HELPER FUNCTIONS =====
function scode_get_hero_slides($limit = 5) {
    $args = array(
        'post_type' => 'hero_slide',
        'post_status' => 'publish',
        'posts_per_page' => $limit,
        'orderby' => 'menu_order',
        'order' => 'ASC'
    );
    
    return new WP_Query($args);
}

function scode_get_featured_products($limit = 12) {
    if (!class_exists('WooCommerce')) {
        return new WP_Query(array('post__in' => array(0))); // Return empty query
    }
    
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
    if (!class_exists('WooCommerce')) {
        return new WP_Query(array('post__in' => array(0))); // Return empty query
    }
    
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
    if (!class_exists('WooCommerce')) {
        return new WP_Query(array('post__in' => array(0))); // Return empty query
    }
    
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
    if (!class_exists('WooCommerce')) {
        return new WP_Query(array('post__in' => array(0))); // Return empty query
    }
    
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
    if (!$product || !class_exists('WooCommerce')) return '';
    
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
    if (!$product || !class_exists('WooCommerce')) return '';
    
    $badges = array();
    
    // Sale badge
    if ($product->is_on_sale()) {
        $regular_price = $product->get_regular_price();
        $sale_price = $product->get_sale_price();
        if ($regular_price && $sale_price) {
            $percentage = round((($regular_price - $sale_price) / $regular_price) * 100);
            $badges[] = sprintf('<span class="product-badge sale">-%s%%</span>', $percentage);
        }
    }
    
    // Custom badges
    $product_id = $product->get_id();
    if (get_post_meta($product_id, '_is_new', true) === 'yes') {
        $badges[] = '<span class="product-badge new">NEW</span>';
    }
    if (get_post_meta($product_id, '_is_premium', true) === 'yes') {
        $badges[] = '<span class="product-badge featured">PREMIUM</span>';
    }
    
    if (!empty($badges)) {
        return '<div class="product-badges">' . implode('', $badges) . '</div>';
    }
    
    return '';
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
                <div class="rating-stars">%s</div>
                <div class="rating-count">(%s)</div>
            </div>',
            $stars,
            $count
        );
    }
    
    return '';
}

// ===== ENQUEUE SCRIPTS AND STYLES =====
function scode_enqueue_scripts() {
    // Theme stylesheet
    wp_enqueue_style('scode-style', get_stylesheet_uri(), array(), '3.0.0');
    
    // Main CSS - Single file with all colors and styles
    if (file_exists(get_template_directory() . '/assets/css/main.css')) {
        wp_enqueue_style('scode-main', get_template_directory_uri() . '/assets/css/main.css', array(), '3.0.0');
    }
    
    // Single Product CSS
    if (file_exists(get_template_directory() . '/assets/css/single-product.css')) {
        wp_enqueue_style('scode-single-product', get_template_directory_uri() . '/assets/css/single-product.css', array(), '1.0.0');
    }
    
    // No Borders CSS - REMOVED (no longer needed)
    
    // jQuery (WordPress includes this by default)
    wp_enqueue_script('jquery');
    
    // Main JavaScript
    if (file_exists(get_template_directory() . '/assets/js/main.js')) {
        wp_enqueue_script('scode-main', get_template_directory_uri() . '/assets/js/main.js', array('jquery'), '3.0.0', true);
    }
    
    // Single Product JavaScript
    if (file_exists(get_template_directory() . '/assets/js/single-product.js')) {
        wp_enqueue_script('scode-single-product', get_template_directory_uri() . '/assets/js/single-product.js', array('jquery'), '1.0.0', true);
    }
    
    // Product Item JavaScript
    if (file_exists(get_template_directory() . '/assets/js/product-item.js')) {
        wp_enqueue_script('scode-product-item', get_template_directory_uri() . '/assets/js/product-item.js', array('jquery'), '1.0.0', true);
    }
    
    // Localize script for AJAX
    if (wp_script_is('scode-main', 'enqueued')) {
        wp_localize_script('scode-main', 'scode_ajax', array(
            'ajax_url' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('scode_nonce'),
            'cart_url' => (class_exists('WooCommerce') && function_exists('wc_get_cart_url')) ? wc_get_cart_url() : '',
            'checkout_url' => (class_exists('WooCommerce') && function_exists('wc_get_checkout_url')) ? wc_get_checkout_url() : '',
        ));
    }
    
    // WooCommerce specific scripts
    if (class_exists('WooCommerce') && function_exists('WC') && file_exists(get_template_directory() . '/assets/js/woocommerce.js')) {
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
    
    // ECOVACS Logo
    $wp_customize->add_setting('scode_ecovacs_logo', array(
        'default' => '',
        'sanitize_callback' => 'esc_url_raw',
    ));
    
    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'scode_ecovacs_logo', array(
        'label' => __('ECOVACS Logo', 'scode-theme'),
        'section' => 'scode_logo',
        'settings' => 'scode_ecovacs_logo',
    )));
    
    // Roborock Logo
    $wp_customize->add_setting('scode_roborock_logo', array(
        'default' => '',
        'sanitize_callback' => 'esc_url_raw',
    ));
    
    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'scode_roborock_logo', array(
        'label' => __('Roborock Logo', 'scode-theme'),
        'section' => 'scode_logo',
        'settings' => 'scode_roborock_logo',
    )));
    
    // Contact section
    $wp_customize->add_section('scode_contact', array(
        'title' => __('Contact Information', 'scode-theme'),
        'priority' => 35,
    ));
    
    // Hotline
    $wp_customize->add_setting('scode_hotline', array(
        'default' => '0834.777.111',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    
    $wp_customize->add_control('scode_hotline', array(
        'label' => __('Hotline Number', 'scode-theme'),
        'section' => 'scode_contact',
        'type' => 'text',
    ));
    
    // Email
    $wp_customize->add_setting('scode_email', array(
        'default' => 'info@otnt.vn',
        'sanitize_callback' => 'sanitize_email',
    ));
    
    $wp_customize->add_control('scode_email', array(
        'label' => __('Email Address', 'scode-theme'),
        'section' => 'scode_contact',
        'type' => 'email',
    ));
    
    // Address
    $wp_customize->add_setting('scode_address', array(
        'default' => 'Tp.HCM: Số 334 Nguyễn Văn Công, Phường 3, Quận Gò Vấp, Tp.Hồ Chí Minh',
        'sanitize_callback' => 'sanitize_textarea_field',
    ));
    
    $wp_customize->add_control('scode_address', array(
        'label' => __('Address', 'scode-theme'),
        'section' => 'scode_contact',
        'type' => 'textarea',
    ));
    
    // Social Media section
    $wp_customize->add_section('scode_social', array(
        'title' => __('Social Media', 'scode-theme'),
        'priority' => 40,
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
}
add_action('customize_register', 'scode_customize_register');

// ===== WIDGETS INITIALIZATION =====
function scode_widgets_init() {
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
    if (!class_exists('WooCommerce')) {
        return number_format($price, 0, ',', '.') . '₫';
    }
        return wc_price($price);
}

// ===== AJAX FUNCTIONS =====
function scode_ajax_add_to_cart() {
    // Verify nonce
    if (!wp_verify_nonce($_POST['nonce'], 'scode_nonce')) {
        wp_die('Security check failed');
    }
    
    // Check if WooCommerce is active
    if (!class_exists('WooCommerce')) {
        wp_send_json_error('WooCommerce is not active');
    }
    
    $product_id = intval($_POST['product_id']);
    $quantity = intval($_POST['quantity']);
    
    if ($product_id <= 0 || $quantity <= 0) {
        wp_send_json_error('Invalid product or quantity');
    }
        
    // Add to cart
    $cart_item_key = WC()->cart->add_to_cart($product_id, $quantity);
    
    if ($cart_item_key) {
            wp_send_json_success(array(
            'message' => 'Product added to cart successfully',
                'cart_count' => WC()->cart->get_cart_contents_count()
            ));
        } else {
        wp_send_json_error('Failed to add product to cart');
    }
}
add_action('wp_ajax_scode_add_to_cart', 'scode_ajax_add_to_cart');
add_action('wp_ajax_nopriv_scode_add_to_cart', 'scode_ajax_add_to_cart');

function scode_ajax_update_cart_count() {
    if (!class_exists('WooCommerce')) {
        wp_send_json_error('WooCommerce is not active');
    }
    
        wp_send_json_success(array(
            'cart_count' => WC()->cart->get_cart_contents_count()
        ));
}
add_action('wp_ajax_scode_update_cart_count', 'scode_ajax_update_cart_count');
add_action('wp_ajax_nopriv_scode_update_cart_count', 'scode_ajax_update_cart_count');

// ===== PERFORMANCE OPTIMIZATIONS =====
function scode_optimize_images() {
    // Add image optimization hooks
    add_filter('wp_get_attachment_image_src', 'scode_optimize_image_src', 10, 4);
    add_filter('wp_calculate_image_srcset', 'scode_optimize_image_srcset', 10, 5);
}

function scode_optimize_image_src($image, $attachment_id, $size, $icon) {
    // Optimize image loading
    if (is_array($image) && isset($image[0])) {
        $image[0] = esc_url($image[0]);
    }
    return $image;
}

function scode_optimize_image_srcset($sources, $size_array, $image_src, $image_meta, $attachment_id) {
    // Optimize srcset for better performance
    return $sources;
}

add_action('init', 'scode_optimize_images');

// ===== SECURITY ENHANCEMENTS =====
function scode_security_headers() {
    // Add security headers
    if (!is_admin()) {
        header('X-Content-Type-Options: nosniff');
        header('X-Frame-Options: SAMEORIGIN');
        header('X-XSS-Protection: 1; mode=block');
    }
}
add_action('send_headers', 'scode_security_headers');

// ===== DEBUG MODE =====
if (defined('WP_DEBUG') && WP_DEBUG) {
    // Enable error logging for debugging
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
}

// ===== THEME ACTIVATION HOOK =====
function scode_theme_activation() {
    // Flush rewrite rules
    flush_rewrite_rules();
    
    // Create default pages if they don't exist
    scode_create_default_pages();
}
add_action('after_switch_theme', 'scode_theme_activation');

function scode_create_default_pages() {
    // Create default pages
    $pages = array(
        'home' => array(
            'title' => 'Trang chủ',
            'content' => 'Đây là trang chủ của website.'
        ),
        'about' => array(
            'title' => 'Giới thiệu',
            'content' => 'Thông tin về công ty chúng tôi.'
        ),
        'contact' => array(
            'title' => 'Liên hệ',
            'content' => 'Thông tin liên hệ của chúng tôi.'
        )
    );
    
    foreach ($pages as $slug => $page_data) {
        if (!get_page_by_path($slug)) {
            wp_insert_post(array(
                'post_title' => $page_data['title'],
                'post_content' => $page_data['content'],
                'post_status' => 'publish',
                'post_type' => 'page',
                'post_name' => $slug
            ));
        }
    }
}

// ===== SIMPLE WOOCOMMERCE IMAGE LOADER =====
function scode_get_simple_product_image($product_id, $size = 'product-thumb', $class = 'product-img') {
    // Check if product has thumbnail
    if (has_post_thumbnail($product_id)) {
        $thumbnail_id = get_post_thumbnail_id($product_id);
        $image_url = wp_get_attachment_image_url($thumbnail_id, $size);
        
        if ($image_url) {
            $image_alt = get_post_meta($thumbnail_id, '_wp_attachment_image_alt', true);
            if (empty($image_alt)) {
                $image_alt = get_the_title($product_id);
            }
            
            // Simple image tag without JavaScript error handling
            return sprintf(
                '<img src="%s" alt="%s" class="%s" loading="lazy">',
                esc_url($image_url),
                esc_attr($image_alt),
                esc_attr($class)
            );
        }
    }
    
    // Simple fallback - use WooCommerce default placeholder
    if (class_exists('WooCommerce')) {
        $placeholder_url = wc_placeholder_img_src($size);
        return sprintf(
            '<img src="%s" alt="%s" class="%s placeholder-image" loading="lazy">',
            esc_url($placeholder_url),
            esc_attr(get_the_title($product_id)),
            esc_attr($class)
        );
    }
    
    // Last resort - simple text placeholder
    return sprintf(
        '<div class="%s" style="width: 100%%; height: 200px; background: #f0f0f0; display: flex; align-items: center; justify-content: center; color: #999; font-size: 14px; border: 1px dashed #ccc;">
            <span>%s</span>
        </div>',
        esc_attr($class),
        esc_html(get_the_title($product_id))
    );
}

// ===== FIX PRODUCT IMAGE DISPLAY ISSUES =====
function scode_get_product_image_fallback($product_id, $size = 'product-thumb', $class = '') {
    // Check if product has thumbnail
    if (has_post_thumbnail($product_id)) {
        $thumbnail_id = get_post_thumbnail_id($product_id);
        $image_url = wp_get_attachment_image_url($thumbnail_id, $size);
        
        if ($image_url) {
            $image_alt = get_post_meta($thumbnail_id, '_wp_attachment_image_alt', true);
            if (empty($image_alt)) {
                $image_alt = get_the_title($product_id);
            }
            
            return sprintf(
                '<img src="%s" alt="%s" class="%s" loading="lazy" onerror="this.style.display=\'none\'; this.nextElementSibling.style.display=\'block\';">',
                esc_url($image_url),
                esc_attr($image_alt),
                esc_attr($class)
            );
        }
    }
    
    // Fallback to placeholder image
    $placeholder_url = get_template_directory_uri() . '/assets/images/placeholder-product.jpg';
    
    // Check if placeholder exists, if not use default WooCommerce placeholder
    if (!file_exists(get_template_directory() . '/assets/images/placeholder-product.jpg')) {
        if (class_exists('WooCommerce')) {
            $placeholder_url = wc_placeholder_img_src($size);
        } else {
            // Create a simple SVG placeholder if no WooCommerce
            $placeholder_url = 'data:image/svg+xml;base64,' . base64_encode('<svg xmlns="http://www.w3.org/2000/svg" width="300" height="300" viewBox="0 0 300 300"><rect width="300" height="300" fill="#f0f0f0"/><text x="150" y="150" text-anchor="middle" dy=".3em" fill="#999" font-family="Arial" font-size="16">No Image</text></svg>');
        }
    }
    
    return sprintf(
        '<img src="%s" alt="%s" class="%s placeholder-image" loading="lazy" onerror="this.style.display=\'none\'; this.nextElementSibling.style.display=\'block\';">
        <div class="image-placeholder" style="display: none; width: 100%%; height: 250px; background: #f0f0f0; display: flex; align-items: center; justify-content: center; color: #999; font-size: 14px;">
            <i class="fas fa-image" style="font-size: 32px; margin-right: 10px;"></i>
            <span>%s</span>
        </div>',
        esc_url($placeholder_url),
        esc_attr(get_the_title($product_id)),
        esc_attr($class),
        esc_html(get_the_title($product_id))
    );
}

// Enhanced product image function for homepage
function scode_get_homepage_product_image($product_id, $class = 'product-img') {
    return scode_get_product_image_fallback($product_id, 'product-thumb', $class);
}

// Force regenerate thumbnails on theme activation
function scode_regenerate_thumbnails() {
    if (class_exists('WooCommerce')) {
        // Get all products
        $products = get_posts(array(
            'post_type' => 'product',
            'numberposts' => -1,
            'post_status' => 'publish'
        ));
        
        foreach ($products as $product) {
            $thumbnail_id = get_post_thumbnail_id($product->ID);
            if ($thumbnail_id) {
                // Force regenerate thumbnails
                $full_size_path = get_attached_file($thumbnail_id);
                if ($full_size_path && file_exists($full_size_path)) {
                    $metadata = wp_generate_attachment_metadata($thumbnail_id, $full_size_path);
                    wp_update_attachment_metadata($thumbnail_id, $metadata);
                }
            }
        }
    }
}

// Add this to theme activation
add_action('after_switch_theme', 'scode_regenerate_thumbnails');

// Debug function to check image issues
function scode_debug_product_images() {
    if (current_user_can('administrator') && isset($_GET['debug_images'])) {
        echo '<div style="background: #f0f0f0; padding: 20px; margin: 20px; border: 1px solid #ccc;">';
        echo '<h3>Debug Product Images</h3>';
        
        if (class_exists('WooCommerce')) {
            $products = get_posts(array(
                'post_type' => 'product',
                'numberposts' => 5,
                'post_status' => 'publish'
            ));
            
            foreach ($products as $product) {
                echo '<h4>' . $product->post_title . '</h4>';
                echo '<p>Product ID: ' . $product->ID . '</p>';
                echo '<p>Has thumbnail: ' . (has_post_thumbnail($product->ID) ? 'Yes' : 'No') . '</p>';
                
                if (has_post_thumbnail($product->ID)) {
                    $thumbnail_id = get_post_thumbnail_id($product->ID);
                    $image_url = wp_get_attachment_image_url($thumbnail_id, 'product-thumb');
                    echo '<p>Thumbnail URL: ' . ($image_url ? $image_url : 'NULL') . '</p>';
                    echo '<p>Thumbnail ID: ' . $thumbnail_id . '</p>';
                    
                    // Check if file exists
                    $upload_dir = wp_upload_dir();
                    $file_path = str_replace($upload_dir['baseurl'], $upload_dir['basedir'], $image_url);
                    echo '<p>File exists: ' . (file_exists($file_path) ? 'Yes' : 'No') . '</p>';
                    echo '<p>File path: ' . $file_path . '</p>';
                }
                echo '<hr>';
            }
        }
        echo '</div>';
    }
}
add_action('wp_footer', 'scode_debug_product_images');

// Add debug info to admin bar
function scode_add_debug_admin_bar($wp_admin_bar) {
    if (current_user_can('administrator')) {
        $wp_admin_bar->add_node(array(
            'id' => 'debug-images',
            'title' => 'Debug Images',
            'href' => add_query_arg('debug_images', '1', home_url())
        ));
    }
}
add_action('admin_bar_menu', 'scode_add_debug_admin_bar', 999);

// Function to fix image display issues
function scode_fix_image_display_issues() {
    // Remove any CSS that might hide images
    add_action('wp_head', function() {
        echo '<style>
        /* Force all product images to be visible */
        .product-img,
        .product-image img,
        .attachment-woocommerce_thumbnail,
        .wp-post-image,
        .placeholder-image,
        .product-card img,
        .product-image-wrapper img,
        .featured-products img {
            display: block !important;
            opacity: 1 !important;
            visibility: visible !important;
            max-width: 100% !important;
            height: auto !important;
        }
        
        /* Override any JavaScript hiding */
        .product-img[style*="display: none"],
        .product-image img[style*="display: none"] {
            display: block !important;
        }
        
        /* Debug borders - REMOVED */
        </style>';
    });
    
    // Add JavaScript to prevent images from being hidden and handle errors
    add_action('wp_footer', function() {
        echo '<script>
        jQuery(document).ready(function($) {
            // Force all images to be visible
            function forceImageVisibility() {
                $(".product-img, .product-image img, .attachment-woocommerce_thumbnail, .wp-post-image").each(function() {
                    $(this).css({
                        "display": "block",
                        "opacity": "1",
                        "visibility": "visible"
                    });
                });
            }
            
            // Handle broken images
            function handleBrokenImages() {
                $("img").each(function() {
                    const $img = $(this);
                    const $placeholder = $img.next(".image-placeholder");
                    
                    // Check if image is broken
                    if ($img[0].naturalWidth === 0 || $img[0].complete === false) {
                        $img.hide();
                        if ($placeholder.length) {
                            $placeholder.show();
                        }
                    }
                });
            }
            
            // Run immediately
            forceImageVisibility();
            handleBrokenImages();
            
            // Run after a delay to catch any late changes
            setTimeout(function() {
                forceImageVisibility();
                handleBrokenImages();
            }, 1000);
            
            setTimeout(function() {
                forceImageVisibility();
                handleBrokenImages();
            }, 3000);
            
            // Monitor for changes
            const observer = new MutationObserver(function(mutations) {
                mutations.forEach(function(mutation) {
                    if (mutation.type === "attributes" && mutation.attributeName === "style") {
                        forceImageVisibility();
                    }
                });
            });
            
            // Observe all product images
            $(".product-img, .product-image img").each(function() {
                observer.observe(this, { attributes: true });
            });
            
            // Handle image load errors
            $(document).on("error", "img", function() {
                const $img = $(this);
                const $placeholder = $img.next(".image-placeholder");
                
                $img.hide();
                if ($placeholder.length) {
                    $placeholder.show();
    } else {
                    // Create placeholder if none exists
                    const placeholder = $("<div>")
                        .addClass("image-placeholder")
                        .html("<i class=\"fas fa-image\"></i><span>Ảnh không khả dụng</span>");
                    $img.after(placeholder);
                }
            });
        });
        </script>';
    });
}

// Run the fix
scode_fix_image_display_issues();

// Create SVG placeholder if image file doesn't exist
function scode_create_svg_placeholder() {
    $placeholder_path = get_template_directory() . '/assets/images/placeholder-product.jpg';
    
    if (!file_exists($placeholder_path)) {
        $svg_content = '<svg xmlns="http://www.w3.org/2000/svg" width="300" height="300" viewBox="0 0 300 300">
            <rect width="300" height="300" fill="#f8f9fa"/>
            <rect x="10" y="10" width="280" height="280" fill="#e9ecef" stroke="#dee2e6" stroke-width="2" stroke-dasharray="5,5"/>
            <circle cx="150" cy="120" r="30" fill="#adb5bd"/>
            <rect x="100" y="170" width="100" height="15" fill="#adb5bd" rx="2"/>
            <rect x="120" y="190" width="60" height="10" fill="#adb5bd" rx="2"/>
            <rect x="130" y="205" width="40" height="10" fill="#adb5bd" rx="2"/>
            <text x="150" y="250" text-anchor="middle" fill="#6c757d" font-family="Arial" font-size="12">No Image Available</text>
        </svg>';
        
        // Create directory if it doesn't exist
        $dir = dirname($placeholder_path);
        if (!is_dir($dir)) {
            wp_mkdir_p($dir);
        }
        
        // Write SVG content
        file_put_contents($placeholder_path, $svg_content);
    }
}

// Run on theme init
add_action('init', 'scode_create_svg_placeholder');

/**
 * Render product item using the new product-item template
 * 
 * @param int $product_id Product ID
 * @param string $classes Additional CSS classes
 * @return void
 */
function scode_render_product_item($product_id, $classes = '') {
    global $product, $post;
    
    // Get the product object
    $product = wc_get_product($product_id);
    
    if (!$product) {
        return;
    }
    
    // Get the post object for this product
    $post = get_post($product_id);
    
    if (!$post) {
        return;
    }
    
    // Set up post data for the product
    setup_postdata($post);
    
    // Include the product-item template
    include get_template_directory() . '/template-parts/product-item.php';
    
    // Reset post data
    wp_reset_postdata();
}

/**
 * Get product items grid with specified columns
 * 
 * @param array $product_ids Array of product IDs
 * @param int $columns Number of columns (2-6)
 * @param string $classes Additional CSS classes
 * @return string HTML output
 */
function scode_get_product_items_grid($product_ids, $columns = 6, $classes = '') {
    if (empty($product_ids)) {
        return '';
    }
    
    $grid_classes = 'product-items-grid cols-' . min(max($columns, 2), 6);
    if ($classes) {
        $grid_classes .= ' ' . $classes;
    }
    
    ob_start();
    ?>
    <div class="<?php echo esc_attr($grid_classes); ?>">
        <?php foreach ($product_ids as $product_id) : ?>
            <?php scode_render_product_item($product_id); ?>
        <?php endforeach; ?>
    </div>
    <?php
    return ob_get_clean();
}

