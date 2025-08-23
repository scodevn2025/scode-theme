<?php
/**
 * Product Detail Page (PDP) Hooks
 * 
 * @package SCODE_Theme
 * @version 1.0.0
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

// ===== PRODUCT DETAIL PAGE HOOKS =====

/**
 * Add custom hooks for single product pages
 */
function scode_pdp_hooks() {
    // Only run if WooCommerce is active
    if (!class_exists('WooCommerce')) {
        return;
    }
    
    // Remove default WooCommerce elements
    remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_rating', 10);
    remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40);
    remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_sharing', 50);
    
    // Remove related products (we have custom implementation)
    remove_action('woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20);
    
    // Add custom product information
    add_action('woocommerce_single_product_summary', 'scode_product_brand_info', 15);
    add_action('woocommerce_single_product_summary', 'scode_product_features', 35);
    add_action('woocommerce_single_product_summary', 'scode_product_trust_badges', 45);
    
    // Customize product tabs
    add_filter('woocommerce_product_tabs', 'scode_customize_product_tabs');
    
    // Add custom CSS classes
    add_filter('body_class', 'scode_add_pdp_body_classes');
    
    // Customize product gallery
    add_filter('woocommerce_single_product_image_thumbnail_html', 'scode_customize_product_gallery', 10, 2);
}
add_action('init', 'scode_pdp_hooks');

/**
 * Add brand information to product summary
 */
function scode_product_brand_info() {
    global $product;
    
    if (!$product) return;
    
    $product_id = $product->get_id();
    $is_global = get_post_meta($product_id, '_is_global', true);
    $is_premium = get_post_meta($product_id, '_is_premium', true);
    
    if ($is_global || $is_premium) {
        echo '<div class="product-brand-info">';
        if ($is_global) {
            echo '<span class="brand-badge global">GLOBAL</span>';
        }
        if ($is_premium) {
            echo '<span class="brand-badge premium">PREMIUM</span>';
        }
        echo '</div>';
    }
}

/**
 * Add product features
 */
function scode_product_features() {
    global $product;
    
    if (!$product) return;
    
    $product_id = $product->get_id();
    $product_features = get_post_meta($product_id, '_product_features', true);
    
    if (!empty($product_features)) {
        echo '<div class="product-features">';
        echo '<h4>Đặc điểm nổi bật</h4>';
        echo '<ul class="features-list">';
        
        $features_array = explode("\n", $product_features);
        foreach ($features_array as $feature) {
            if (trim($feature)) {
                echo '<li><i class="fas fa-check"></i> ' . esc_html(trim($feature)) . '</li>';
            }
        }
        
        echo '</ul>';
        echo '</div>';
    }
}

/**
 * Add trust badges
 */
function scode_product_trust_badges() {
    echo '<div class="product-trust-badges">';
    echo '<div class="trust-badge">';
    echo '<i class="fas fa-shield-alt"></i>';
    echo '<span>Chính hãng 100%</span>';
    echo '</div>';
    echo '<div class="trust-badge">';
    echo '<i class="fas fa-truck"></i>';
    echo '<span>Giao hàng toàn quốc</span>';
    echo '</div>';
    echo '<div class="trust-badge">';
    echo '<i class="fas fa-tools"></i>';
    echo '<span>Bảo hành uy tín</span>';
    echo '</div>';
    echo '</div>';
}

/**
 * Customize product tabs
 */
function scode_customize_product_tabs($tabs) {
    // Modify existing tabs
    if (isset($tabs['description'])) {
        $tabs['description']['title'] = 'Mô tả';
        $tabs['description']['priority'] = 10;
    }
    
    if (isset($tabs['additional_information'])) {
        $tabs['additional_information']['title'] = 'Thông số kỹ thuật';
        $tabs['additional_information']['priority'] = 20;
    }
    
    if (isset($tabs['reviews'])) {
        $tabs['reviews']['title'] = 'Đánh giá';
        $tabs['reviews']['priority'] = 30;
    }
    
    // Add custom warranty tab
    $tabs['warranty'] = array(
        'title' => 'Bảo hành',
        'priority' => 40,
        'callback' => 'scode_warranty_tab_content'
    );
    
    return $tabs;
}

/**
 * Warranty tab content
 */
function scode_warranty_tab_content() {
    echo '<div class="warranty-content">';
    echo '<h4>Chính sách bảo hành</h4>';
    echo '<ul>';
    echo '<li>Bảo hành chính hãng 12 tháng</li>';
    echo '<li>Bảo hành tại nhà</li>';
    echo '<li>Hỗ trợ kỹ thuật 24/7</li>';
    echo '<li>Đổi mới trong 7 ngày đầu</li>';
    echo '</ul>';
    
    echo '<div class="warranty-contact">';
    echo '<h5>Liên hệ bảo hành:</h5>';
    echo '<p><i class="fas fa-phone"></i> ' . esc_html(get_theme_mod('scode_hotline', '0834.777.111')) . '</p>';
    echo '<p><i class="fas fa-envelope"></i> ' . esc_html(get_theme_mod('scode_email', 'info@otnt.vn')) . '</p>';
    echo '</div>';
    echo '</div>';
}

/**
 * Add custom body classes for product pages
 */
function scode_add_pdp_body_classes($classes) {
    if (is_product()) {
        $classes[] = 'single-product-page';
        $classes[] = 'pdp-enhanced';
    }
    return $classes;
}

/**
 * Customize product gallery
 */
function scode_customize_product_gallery($html, $attachment_id) {
    // Add custom attributes or modify gallery behavior
    return $html;
}

/**
 * Add custom product scripts
 */
function scode_pdp_scripts() {
    if (is_product()) {
        // Add any additional scripts needed for product pages
        wp_enqueue_script('scode-pdp-enhancements', get_template_directory_uri() . '/assets/js/pdp-enhancements.js', array('jquery'), '1.0.0', true);
    }
}
add_action('wp_enqueue_scripts', 'scode_pdp_scripts');

/**
 * Add custom product styles
 */
function scode_pdp_styles() {
    if (is_product()) {
        // Add any additional styles needed for product pages
        wp_enqueue_style('scode-pdp-enhancements', get_template_directory_uri() . '/assets/css/pdp-enhancements.css', array(), '1.0.0');
    }
}
add_action('wp_enqueue_scripts', 'scode_pdp_styles');
