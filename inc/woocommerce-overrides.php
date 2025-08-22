<?php
/**
 * WooCommerce Overrides and Customizations
 * 
 * @package ScodeTheme
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Check if WooCommerce is active
 */
if (!class_exists('WooCommerce')) {
    return;
}

/**
 * Remove WooCommerce default styles
 */
add_filter('woocommerce_enqueue_styles', '__return_empty_array');

/**
 * Customize WooCommerce pagination
 */
function scode_theme_woocommerce_pagination_args($args) {
    $args['prev_text'] = __('← Trước', 'scode-theme');
    $args['next_text'] = __('Sau →', 'scode-theme');
    return $args;
}
add_filter('woocommerce_pagination_args', 'scode_theme_woocommerce_pagination_args');

/**
 * Customize WooCommerce breadcrumbs
 */
function scode_theme_woocommerce_breadcrumb_defaults($args) {
    $args['delimiter'] = ' <i class="fas fa-chevron-right"></i> ';
    $args['wrap_before'] = '<nav class="woocommerce-breadcrumb">';
    $args['wrap_after'] = '</nav>';
    return $args;
}
add_filter('woocommerce_breadcrumb_defaults', 'scode_theme_woocommerce_breadcrumb_defaults');

/**
 * Add discount percentage to product cards
 */
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

/**
 * Customize WooCommerce product loop
 */
function scode_theme_woocommerce_product_loop_start() {
    echo '<div class="products-grid">';
}
add_action('woocommerce_before_shop_loop', 'scode_theme_woocommerce_product_loop_start', 40);

function scode_theme_woocommerce_product_loop_end() {
    echo '</div>';
}
add_action('woocommerce_after_shop_loop', 'scode_theme_woocommerce_product_loop_end', 5);

/**
 * Customize WooCommerce product classes
 */
function scode_theme_woocommerce_product_classes($classes, $product) {
    $classes[] = 'product-card';
    return $classes;
}
add_filter('woocommerce_product_class', 'scode_theme_woocommerce_product_classes', 10, 2);

/**
 * Customize WooCommerce product image
 */
function scode_theme_woocommerce_product_image() {
    global $product;
    if (has_post_thumbnail()) {
        echo '<a href="' . get_permalink() . '">';
        the_post_thumbnail('scode-product-card', array('class' => 'product-image'));
        echo '</a>';
    } else {
        echo '<a href="' . get_permalink() . '">';
        echo '<img src="' . get_template_directory_uri() . '/assets/img/placeholder-product.jpg" alt="' . get_the_title() . '" class="product-image">';
        echo '</a>';
    }
}
remove_action('woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail', 10);
add_action('woocommerce_before_shop_loop_item_title', 'scode_theme_woocommerce_product_image', 10);

/**
 * Customize WooCommerce product title
 */
function scode_theme_woocommerce_product_title() {
    echo '<h3 class="product-title"><a href="' . get_permalink() . '">' . get_the_title() . '</a></h3>';
}
remove_action('woocommerce_shop_loop_item_title', 'woocommerce_template_loop_product_title', 10);
add_action('woocommerce_shop_loop_item_title', 'scode_theme_woocommerce_product_title', 10);

/**
 * Customize WooCommerce product price
 */
function scode_theme_woocommerce_product_price() {
    global $product;
    echo '<div class="product-price">';
    if ($product->is_on_sale()) {
        echo '<span class="old-price">' . wc_price($product->get_regular_price()) . '</span>';
        echo '<span class="current-price">' . wc_price($product->get_sale_price()) . '</span>';
    } else {
        echo '<span class="current-price">' . wc_price($product->get_price()) . '</span>';
    }
    echo '</div>';
}
remove_action('woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_price', 10);
add_action('woocommerce_after_shop_loop_item_title', 'scode_theme_woocommerce_product_price', 10);

/**
 * Customize WooCommerce add to cart button
 */
function scode_theme_woocommerce_add_to_cart_button() {
    global $product;
    echo '<button class="add-to-cart-btn" data-product-id="' . $product->get_id() . '">';
    echo __('Thêm vào giỏ', 'scode-theme');
    echo '</button>';
}
remove_action('woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10);
add_action('woocommerce_after_shop_loop_item', 'scode_theme_woocommerce_add_to_cart_button', 10);

/**
 * AJAX add to cart functionality
 */
function scode_theme_add_to_cart_ajax() {
    $product_id = intval($_POST['product_id']);
    
    if ($product_id > 0) {
        $result = WC()->cart->add_to_cart($product_id);
        
        if ($result) {
            wp_send_json_success(array(
                'message' => __('Sản phẩm đã được thêm vào giỏ hàng!', 'scode-theme'),
                'cart_count' => WC()->cart->get_cart_contents_count()
            ));
        } else {
            wp_send_json_error(array(
                'message' => __('Không thể thêm sản phẩm vào giỏ hàng.', 'scode-theme')
            ));
        }
    } else {
        wp_send_json_error(array(
            'message' => __('ID sản phẩm không hợp lệ.', 'scode-theme')
        ));
    }
}
add_action('wp_ajax_add_to_cart', 'scode_theme_add_to_cart_ajax');
add_action('wp_ajax_nopriv_add_to_cart', 'scode_theme_add_to_cart_ajax');

/**
 * Customize WooCommerce mini cart
 */
function scode_theme_woocommerce_mini_cart() {
    if (WC()->cart->is_empty()) {
        echo '<p class="woocommerce-mini-cart__empty-message">' . __('Giỏ hàng trống.', 'scode-theme') . '</p>';
    } else {
        echo '<ul class="woocommerce-mini-cart cart_list product_list_widget">';
        
        foreach (WC()->cart->get_cart() as $cart_item_key => $cart_item) {
            $_product = apply_filters('woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key);
            $product_id = apply_filters('woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key);
            
            if ($_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters('woocommerce_widget_cart_item_visible', true, $cart_item, $cart_item_key)) {
                $product_name = apply_filters('woocommerce_cart_item_name', $_product->get_name(), $cart_item, $cart_item_key);
                $thumbnail = apply_filters('woocommerce_cart_item_thumbnail', $_product->get_image(), $cart_item, $cart_item_key);
                $product_price = apply_filters('woocommerce_cart_item_price', WC()->cart->get_product_price($_product), $cart_item, $cart_item_key);
                
                echo '<li class="woocommerce-mini-cart-item">';
                echo '<a href="' . esc_url($_product->get_permalink()) . '">';
                echo $thumbnail;
                echo '<span class="product-name">' . esc_html($product_name) . '</span>';
                echo '</a>';
                echo '<span class="quantity">' . sprintf('%s &times; %s', $cart_item['quantity'], $product_price) . '</span>';
                echo '</li>';
            }
        }
        
        echo '</ul>';
        
        echo '<p class="woocommerce-mini-cart__total total"><strong>' . __('Tổng cộng:', 'scode-theme') . '</strong> <span class="woocommerce-Price-amount amount">' . WC()->cart->get_cart_subtotal() . '</span></p>';
        
        echo '<div class="woocommerce-mini-cart__buttons buttons">';
        echo '<a href="' . esc_url(wc_get_cart_url()) . '" class="button wc-forward">' . __('Xem giỏ hàng', 'scode-theme') . '</a>';
        echo '<a href="' . esc_url(wc_get_checkout_url()) . '" class="button checkout wc-forward">' . __('Thanh toán', 'scode-theme') . '</a>';
        echo '</div>';
    }
}

/**
 * Customize WooCommerce product archive page
 */
function scode_theme_woocommerce_archive_page() {
    if (is_shop() || is_product_category() || is_product_tag()) {
        echo '<div class="woocommerce-archive-header">';
        echo '<h1 class="archive-title">';
        if (is_shop()) {
            echo __('Cửa hàng', 'scode-theme');
        } elseif (is_product_category()) {
            single_cat_title();
        } elseif (is_product_tag()) {
            single_tag_title();
        }
        echo '</h1>';
        echo '</div>';
    }
}
add_action('woocommerce_before_main_content', 'scode_theme_woocommerce_archive_page', 10);

/**
 * Customize WooCommerce single product page
 */
function scode_theme_woocommerce_single_product() {
    if (is_product()) {
        echo '<div class="single-product-header">';
        echo '<h1 class="product-title">' . get_the_title() . '</h1>';
        echo '</div>';
    }
}
add_action('woocommerce_before_single_product', 'scode_theme_woocommerce_single_product', 10);

/**
 * Add custom fields to WooCommerce products
 */
function scode_theme_add_product_custom_fields() {
    global $post;
    
    echo '<div class="product-custom-fields">';
    
    // Add custom fields here if needed
    $custom_field = get_post_meta($post->ID, '_custom_field', true);
    if ($custom_field) {
        echo '<div class="custom-field">';
        echo '<strong>' . __('Custom Field:', 'scode-theme') . '</strong> ' . esc_html($custom_field);
        echo '</div>';
    }
    
    echo '</div>';
}
add_action('woocommerce_single_product_summary', 'scode_theme_add_product_custom_fields', 25);

/**
 * Customize WooCommerce checkout page
 */
function scode_theme_woocommerce_checkout_fields($fields) {
    // Customize checkout fields if needed
    return $fields;
}
add_filter('woocommerce_checkout_fields', 'scode_theme_woocommerce_checkout_fields');

/**
 * Add custom CSS for WooCommerce pages
 */
function scode_theme_woocommerce_custom_css() {
    if (is_woocommerce() || is_cart() || is_checkout() || is_account_page()) {
        ?>
        <style>
            /* WooCommerce specific styles */
            .woocommerce .products-grid {
                display: grid;
                grid-template-columns: repeat(var(--product-grid-columns), 1fr);
                gap: 1.5rem;
            }
            
            .woocommerce .product-card {
                background: var(--bg-primary);
                border: 1px solid var(--border-color);
                border-radius: var(--border-radius);
                overflow: hidden;
                transition: all 0.3s ease;
            }
            
            .woocommerce .product-card:hover {
                transform: translateY(-5px);
                box-shadow: var(--shadow-xl);
            }
            
            .woocommerce .discount-badge {
                position: absolute;
                top: 1rem;
                left: 1rem;
                background: var(--error-color);
                color: var(--text-white);
                padding: 0.25rem 0.75rem;
                border-radius: 20px;
                font-size: 0.875rem;
                font-weight: 600;
                z-index: 10;
            }
        </style>
        <?php
    }
}
add_action('wp_head', 'scode_theme_woocommerce_custom_css');
