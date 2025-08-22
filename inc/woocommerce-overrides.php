<?php
/**
 * WooCommerce Template Overrides
 * 
 * @package SCODE_Theme
 * @version 1.0.0
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

// ===== WOOCOMMERCE TEMPLATE OVERRIDES =====

/**
 * Override WooCommerce content wrapper
 */
function scode_woocommerce_content() {
    if (is_singular('product')) {
        while (have_posts()) {
            the_post();
            wc_get_template_part('content', 'single-product');
        }
    } else {
        if (have_posts()) {
            do_action('woocommerce_before_shop_loop');
            
            woocommerce_product_loop_start();
            
            if (wc_get_loop_prop('is_shortcode')) {
                $columns = absint(wc_get_loop_prop('columns'));
            } else {
                $columns = wc_get_default_products_per_row();
            }
            
            woocommerce_product_loop_start();
            
            if (have_posts()) {
                while (have_posts()) {
                    the_post();
                    do_action('woocommerce_shop_loop');
                    wc_get_template_part('content', 'product');
                }
            }
            
            woocommerce_product_loop_end();
            
            do_action('woocommerce_after_shop_loop');
        } else {
            do_action('woocommerce_no_products_found');
        }
    }
}

/**
 * Customize product loop columns
 */
function scode_woocommerce_loop_columns() {
    return 4; // Default 4 columns
}
add_filter('loop_shop_columns', 'scode_woocommerce_loop_columns');

/**
 * Customize products per page
 */
function scode_woocommerce_products_per_page() {
    return 12; // Default 12 products per page
}
add_filter('loop_shop_per_page', 'scode_woocommerce_products_per_page');

/**
 * Customize product sorting options
 */
function scode_woocommerce_catalog_orderby($sorting_options) {
    $sorting_options = array(
        'menu_order' => __('Mặc định', 'scode-theme'),
        'popularity' => __('Phổ biến', 'scode-theme'),
        'rating' => __('Đánh giá cao', 'scode-theme'),
        'date' => __('Mới nhất', 'scode-theme'),
        'price' => __('Giá thấp đến cao', 'scode-theme'),
        'price-desc' => __('Giá cao đến thấp', 'scode-theme'),
    );
    
    return $sorting_options;
}
add_filter('woocommerce_catalog_orderby', 'scode_woocommerce_catalog_orderby');

/**
 * Customize pagination
 */
function scode_woocommerce_pagination_args($args) {
    $args['prev_text'] = '<i class="fas fa-chevron-left"></i> Trước';
    $args['next_text'] = 'Sau <i class="fas fa-chevron-right"></i>';
    $args['type'] = 'list';
    
    return $args;
}
add_filter('woocommerce_pagination_args', 'scode_woocommerce_pagination_args');

/**
 * Customize breadcrumbs
 */
function scode_woocommerce_breadcrumb_defaults($args) {
    $args['delimiter'] = '<i class="fas fa-chevron-right"></i>';
    $args['wrap_before'] = '<nav class="woocommerce-breadcrumb">';
    $args['wrap_after'] = '</nav>';
    $args['before'] = '';
    $args['after'] = '';
    $args['home'] = _x('Trang chủ', 'breadcrumb', 'scode-theme');
    
    return $args;
}
add_filter('woocommerce_breadcrumb_defaults', 'scode_woocommerce_breadcrumb_defaults');

/**
 * Customize sale flash
 */
function scode_woocommerce_sale_flash($html, $post, $product) {
    if ($product->is_on_sale()) {
        $regular_price = $product->get_regular_price();
        $sale_price = $product->get_sale_price();
        
        if ($regular_price && $sale_price) {
            $percentage = round((($regular_price - $sale_price) / $regular_price) * 100);
            return '<span class="onsale">-' . $percentage . '%</span>';
        }
    }
    
    return $html;
}
add_filter('woocommerce_sale_flash', 'scode_woocommerce_sale_flash', 10, 3);

/**
 * Customize add to cart button
 */
function scode_woocommerce_add_to_cart_button() {
    global $product;
    
    if ($product->is_type('simple')) {
        echo '<button type="submit" class="single_add_to_cart_button button alt">
            <i class="fas fa-shopping-cart"></i> Thêm vào giỏ hàng
        </button>';
    } elseif ($product->is_type('variable')) {
        echo '<button type="submit" class="single_add_to_cart_button button alt">
            <i class="fas fa-shopping-cart"></i> Chọn mua
        </button>';
    }
}

/**
 * Customize product meta
 */
function scode_woocommerce_product_meta() {
    global $product;
    
    if ($product->get_sku()) {
        echo '<span class="sku_wrapper">SKU: <span class="sku">' . $product->get_sku() . '</span></span>';
    }
    
    if ($product->get_categories()) {
        echo '<span class="posted_in">Danh mục: ' . $product->get_categories() . '</span>';
    }
    
    if ($product->get_tags()) {
        echo '<span class="tagged_as">Tags: ' . $product->get_tags() . '</span>';
    }
}

/**
 * Customize related products
 */
function scode_woocommerce_related_products_args($args) {
    $args['posts_per_page'] = 4; // Show 4 related products
    $args['columns'] = 4; // 4 columns
    
    return $args;
}
add_filter('woocommerce_output_related_products_args', 'scode_woocommerce_related_products_args');

/**
 * Customize upsell products
 */
function scode_woocommerce_upsell_products_args($args) {
    $args['posts_per_page'] = 4; // Show 4 upsell products
    $args['columns'] = 4; // 4 columns
    
    return $args;
}
add_filter('woocommerce_upsell_display_args', 'scode_woocommerce_upsell_products_args');

/**
 * Customize cross-sell products
 */
function scode_woocommerce_cross_sell_products_args($args) {
    $args['posts_per_page'] = 4; // Show 4 cross-sell products
    $args['columns'] = 4; // 4 columns
    
    return $args;
}
add_filter('woocommerce_cross_sells_total', function() { return 4; });

/**
 * Customize product gallery
 */
function scode_woocommerce_product_gallery() {
    global $product;
    
    $attachment_ids = $product->get_gallery_image_ids();
    $post_thumbnail_id = $product->get_image_id();
    
    if ($post_thumbnail_id) {
        $attachment_ids = array_merge(array($post_thumbnail_id), $attachment_ids);
    }
    
    if (!empty($attachment_ids)) {
        echo '<div class="woocommerce-product-gallery">';
        echo '<div class="gallery-main">';
        
        foreach ($attachment_ids as $attachment_id) {
            $image_url = wp_get_attachment_image_url($attachment_id, 'product-large');
            $image_alt = get_post_meta($attachment_id, '_wp_attachment_image_alt', true);
            
            echo '<div class="gallery-item">';
            echo '<img src="' . esc_url($image_url) . '" alt="' . esc_attr($image_alt) . '">';
            echo '</div>';
        }
        
        echo '</div>';
        
        if (count($attachment_ids) > 1) {
            echo '<div class="gallery-thumbs">';
            foreach ($attachment_ids as $attachment_id) {
                $image_url = wp_get_attachment_image_url($attachment_id, 'product-thumb');
                $image_alt = get_post_meta($attachment_id, '_wp_attachment_image_alt', true);
                
                echo '<div class="thumb-item">';
                echo '<img src="' . esc_url($image_url) . '" alt="' . esc_attr($image_alt) . '">';
                echo '</div>';
            }
            echo '</div>';
        }
        
        echo '</div>';
    }
}

/**
 * Customize product tabs
 */
function scode_woocommerce_product_tabs($tabs) {
    // Reorder tabs
    $tabs['description']['priority'] = 10;
    $tabs['additional_information']['priority'] = 20;
    $tabs['reviews']['priority'] = 30;
    
    // Customize tab titles
    $tabs['description']['title'] = __('Mô tả', 'scode-theme');
    $tabs['additional_information']['title'] = __('Thông số kỹ thuật', 'scode-theme');
    $tabs['reviews']['title'] = __('Đánh giá', 'scode-theme');
    
    return $tabs;
}
add_filter('woocommerce_product_tabs', 'scode_woocommerce_product_tabs');

/**
 * Customize checkout fields
 */
function scode_woocommerce_checkout_fields($fields) {
    // Customize billing fields
    $fields['billing']['billing_first_name']['label'] = __('Họ', 'scode-theme');
    $fields['billing']['billing_last_name']['label'] = __('Tên', 'scode-theme');
    $fields['billing']['billing_phone']['label'] = __('Số điện thoại', 'scode-theme');
    $fields['billing']['billing_email']['label'] = __('Email', 'scode-theme');
    $fields['billing']['billing_address_1']['label'] = __('Địa chỉ', 'scode-theme');
    $fields['billing']['billing_city']['label'] = __('Thành phố', 'scode-theme');
    $fields['billing']['billing_state']['label'] = __('Tỉnh/Thành phố', 'scode-theme');
    $fields['billing']['billing_postcode']['label'] = __('Mã bưu điện', 'scode-theme');
    
    // Customize shipping fields
    $fields['shipping']['shipping_first_name']['label'] = __('Họ', 'scode-theme');
    $fields['shipping']['shipping_last_name']['label'] = __('Tên', 'scode-theme');
    $fields['shipping']['shipping_address_1']['label'] = __('Địa chỉ', 'scode-theme');
    $fields['shipping']['shipping_city']['label'] = __('Thành phố', 'scode-theme');
    $fields['shipping']['shipping_state']['label'] = __('Tỉnh/Thành phố', 'scode-theme');
    $fields['shipping']['shipping_postcode']['label'] = __('Mã bưu điện', 'scode-theme');
    
    return $fields;
}
add_filter('woocommerce_checkout_fields', 'scode_woocommerce_checkout_fields');

/**
 * Customize order received text
 */
function scode_woocommerce_thankyou_order_received_text($str, $order) {
    return 'Cảm ơn bạn đã đặt hàng! Đơn hàng của bạn đã được nhận.';
}
add_filter('woocommerce_thankyou_order_received_text', 'scode_woocommerce_thankyou_order_received_text', 10, 2);

/**
 * Customize email templates
 */
function scode_woocommerce_email_styles($css) {
    $css .= '
        .woocommerce-email-header {
            background-color: #f36c21 !important;
            color: white !important;
        }
        .woocommerce-email-footer {
            background-color: #4a4a4a !important;
            color: white !important;
        }
    ';
    
    return $css;
}
add_filter('woocommerce_email_styles', 'scode_woocommerce_email_styles');

/**
 * Add custom product fields
 */
function scode_add_custom_product_fields() {
    global $woocommerce, $post;
    
    echo '<div class="options_group">';
    
    // Product brand
    woocommerce_wp_text_input(array(
        'id' => '_product_brand',
        'label' => __('Thương hiệu', 'scode-theme'),
        'placeholder' => __('Nhập thương hiệu sản phẩm', 'scode-theme'),
        'desc_tip' => true,
        'description' => __('Thương hiệu của sản phẩm', 'scode-theme'),
    ));
    
    // Product warranty
    woocommerce_wp_text_input(array(
        'id' => '_product_warranty',
        'label' => __('Bảo hành', 'scode-theme'),
        'placeholder' => __('Ví dụ: 12 tháng', 'scode-theme'),
        'desc_tip' => true,
        'description' => __('Thời gian bảo hành sản phẩm', 'scode-theme'),
    ));
    
    // Product features
    woocommerce_wp_textarea_input(array(
        'id' => '_product_features',
        'label' => __('Tính năng nổi bật', 'scode-theme'),
        'placeholder' => __('Nhập các tính năng (mỗi dòng một tính năng)', 'scode-theme'),
        'desc_tip' => true,
        'description' => __('Các tính năng chính của sản phẩm', 'scode-theme'),
    ));
    
    // Product video
    woocommerce_wp_text_input(array(
        'id' => '_product_video',
        'label' => __('Video sản phẩm', 'scode-theme'),
        'placeholder' => __('URL video YouTube hoặc Vimeo', 'scode-theme'),
        'desc_tip' => true,
        'description' => __('Link video giới thiệu sản phẩm', 'scode-theme'),
    ));
    
    echo '</div>';
}
add_action('woocommerce_product_options_general_product_data', 'scode_add_custom_product_fields');

/**
 * Save custom product fields
 */
function scode_save_custom_product_fields($post_id) {
    $fields = array(
        '_product_brand',
        '_product_warranty',
        '_product_features',
        '_product_video'
    );
    
    foreach ($fields as $field) {
        if (isset($_POST[$field])) {
            update_post_meta($post_id, $field, sanitize_text_field($_POST[$field]));
        }
    }
}
add_action('woocommerce_process_product_meta', 'scode_save_custom_product_fields');

/**
 * Display custom product fields on frontend
 */
function scode_display_custom_product_fields() {
    global $product;
    
    $brand = get_post_meta($product->get_id(), '_product_brand', true);
    $warranty = get_post_meta($product->get_id(), '_product_warranty', true);
    $features = get_post_meta($product->get_id(), '_product_features', true);
    $video = get_post_meta($product->get_id(), '_product_video', true);
    
    if ($brand || $warranty || $features || $video) {
        echo '<div class="product-extra-info">';
        
        if ($brand) {
            echo '<div class="product-brand">';
            echo '<strong>Thương hiệu:</strong> ' . esc_html($brand);
            echo '</div>';
        }
        
        if ($warranty) {
            echo '<div class="product-warranty">';
            echo '<strong>Bảo hành:</strong> ' . esc_html($warranty);
            echo '</div>';
        }
        
        if ($features) {
            echo '<div class="product-features">';
            echo '<strong>Tính năng nổi bật:</strong>';
            echo '<ul>';
            $feature_list = explode("\n", $features);
            foreach ($feature_list as $feature) {
                if (trim($feature)) {
                    echo '<li>' . esc_html(trim($feature)) . '</li>';
                }
            }
            echo '</ul>';
            echo '</div>';
        }
        
        if ($video) {
            echo '<div class="product-video">';
            echo '<strong>Video sản phẩm:</strong>';
            echo '<div class="video-container">';
            // Convert YouTube/Vimeo URL to embed
            if (strpos($video, 'youtube.com') !== false || strpos($video, 'youtu.be') !== false) {
                $video_id = '';
                if (preg_match('/youtube\.com\/watch\?v=([^&]+)/', $video, $matches)) {
                    $video_id = $matches[1];
                } elseif (preg_match('/youtu\.be\/([^?]+)/', $video, $matches)) {
                    $video_id = $matches[1];
                }
                if ($video_id) {
                    echo '<iframe width="560" height="315" src="https://www.youtube.com/embed/' . esc_attr($video_id) . '" frameborder="0" allowfullscreen></iframe>';
                }
            } elseif (strpos($video, 'vimeo.com') !== false) {
                $video_id = '';
                if (preg_match('/vimeo\.com\/([0-9]+)/', $video, $matches)) {
                    $video_id = $matches[1];
                }
                if ($video_id) {
                    echo '<iframe width="560" height="315" src="https://player.vimeo.com/video/' . esc_attr($video_id) . '" frameborder="0" allowfullscreen></iframe>';
                }
            }
            echo '</div>';
            echo '</div>';
        }
        
        echo '</div>';
    }
}
add_action('woocommerce_single_product_summary', 'scode_display_custom_product_fields', 25);

/**
 * Customize mini cart
 */
function scode_woocommerce_mini_cart() {
    if (WC()->cart->is_empty()) {
        echo '<p class="woocommerce-mini-cart__empty-message">Giỏ hàng trống</p>';
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
                echo '<a href="' . esc_url(wc_get_cart_remove_url($cart_item_key)) . '" class="remove remove_from_cart_link">&times;</a>';
                echo '</li>';
            }
        }
        
        echo '</ul>';
        
        echo '<p class="woocommerce-mini-cart__total total"><strong>Tổng cộng:</strong> <span class="woocommerce-Price-amount amount">' . WC()->cart->get_cart_subtotal() . '</span></p>';
        
        echo '<p class="woocommerce-mini-cart__buttons buttons">';
        echo '<a href="' . esc_url(wc_get_cart_url()) . '" class="button wc-forward">Xem giỏ hàng</a>';
        echo '<a href="' . esc_url(wc_get_checkout_url()) . '" class="button checkout wc-forward">Thanh toán</a>';
        echo '</p>';
    }
}

/**
 * AJAX update cart count
 */
function scode_ajax_update_cart_count() {
    wp_send_json_success(array(
        'cart_count' => WC()->cart->get_cart_contents_count()
    ));
}
add_action('wp_ajax_scode_update_cart_count', 'scode_ajax_update_cart_count');
add_action('wp_ajax_nopriv_scode_update_cart_count', 'scode_ajax_update_cart_count');
