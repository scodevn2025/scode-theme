<?php
/**
 * Template for product-item structure
 * 
 * @package SCODE_Theme
 * @version 1.0.0
 */

// Ensure we have a product object
if (!isset($product) || !$product) {
    global $product;
}

if (!$product) {
    return;
}

$product_id = $product->get_id();
$product_permalink = get_permalink($product_id);
$product_title = $product->get_name();
$product_price = $product->get_price();
$regular_price = $product->get_regular_price();
$sale_price = $product->get_sale_price();

// Calculate discount percentage
$discount_percent = 0;
if ($regular_price && $sale_price && $regular_price > $sale_price) {
    $discount_percent = round((($regular_price - $sale_price) / $regular_price) * 100);
}

// Check if product is on sale
$is_on_sale = $product->is_on_sale();

// Check if product is new (created within last 30 days)
$created_time = get_post_time('U', false, $product_id);
$is_new = $created_time && (time() - $created_time) < (30 * 24 * 60 * 60);

// Check stock status
$stock_status = $product->get_stock_status();
$stock_quantity = $product->get_stock_quantity();
?>

<div class="product-item">
    <div class="product-item-photo">
        <?php if ($is_on_sale && $discount_percent > 0) : ?>
            <span class="onsale">-<?php echo $discount_percent; ?>%</span>
        <?php endif; ?>
        
        <?php if ($is_new) : ?>
            <span class="new-badge">Mới</span>
        <?php endif; ?>
        
        <a href="<?php echo esc_url($product_permalink); ?>">
            <?php 
            // Use simple WooCommerce image loader
            echo scode_get_simple_product_image($product_id, 'product-thumb', 'product-item-img');
            ?>
        </a>
        
        <?php if ($is_on_sale) : ?>
            <div class="sale-program-image-icon">
                <i class="fas fa-tags"></i>
            </div>
        <?php endif; ?>
        
        <?php if ($stock_status === 'outofstock') : ?>
            <span class="stocks out-of-stock">Hết hàng</span>
        <?php elseif ($stock_quantity && $stock_quantity <= 5) : ?>
            <span class="stocks low-stock">Chỉ còn <?php echo $stock_quantity; ?></span>
        <?php endif; ?>
        
        <!-- Heart button -->
        <button class="heart-btn" data-product-id="<?php echo $product_id; ?>">
            <i class="far fa-heart"></i>
        </button>
    </div>
    
    <div class="product-item-detail">
        <h3 class="woocommerce-loop-product__title">
            <a href="<?php echo esc_url($product_permalink); ?>">
                <?php echo esc_html($product_title); ?>
            </a>
        </h3>
        
        <div class="price product-item-price">
            <?php if ($is_on_sale && $sale_price) : ?>
                <span class="sale-price"><?php echo number_format_i18n($sale_price, 0); ?>đ</span>
                <?php if ($regular_price && $regular_price > $sale_price) : ?>
                    <span class="regular-price"><?php echo number_format_i18n($regular_price, 0); ?>đ</span>
                <?php endif; ?>
            <?php else : ?>
                <span class="current-price"><?php echo number_format_i18n($product_price, 0); ?>đ</span>
            <?php endif; ?>
        </div>
        
        <!-- Add to cart button -->
        <button class="add-to-cart-btn" data-product-id="<?php echo $product_id; ?>">
            <i class="fas fa-shopping-cart"></i>
            Thêm vào giỏ
        </button>
    </div>
</div>
