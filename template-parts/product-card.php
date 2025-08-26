<?php
/**
 * Product Card Template Part - Redesigned with Dynamic Data
 * 
 * @package SCODE_Theme
 * @version 3.2.0
 */

// Ensure we have a product object
if (!isset($product) || !$product) {
    global $product;
}

if (!$product) {
    return;
}

$product_id = $product->get_id();
$regular_price = $product->get_regular_price();
$sale_price = $product->get_sale_price();
$current_price = $product->get_price();

// Calculate discount percentage
$discount_percent = 0;
if ($regular_price && $sale_price && $regular_price > $sale_price) {
    $discount_percent = round((($regular_price - $sale_price) / $regular_price) * 100);
}

// Check if product has discount tag
$has_discount = has_term(array('vot_tro-gia-1-000-000d', 'vot_tro-gia-500-000d'), 'product_tag', $product_id);

// Dynamic data from WooCommerce
$brand_name = get_post_meta($product_id, '_brand', true) ?: 'OTNT';
$promotion_type = get_post_meta($product_id, '_promotion_type', true) ?: 'Global week';
$warranty_status = get_post_meta($product_id, '_warranty_status', true) ?: 'Chính hãng';
$hot_sale_text = get_post_meta($product_id, '_hot_sale_text', true) ?: 'Hot Sale';
$discount_code_text = get_post_meta($product_id, '_discount_code_text', true) ?: 'Mã giảm giá';

// Check if product is new (created within last 30 days)
$is_new = (strtotime($product->get_date_created()) > strtotime('-30 days'));

// Check if product is featured
$is_featured = $product->is_featured();

// Check if product has stock
$has_stock = $product->is_in_stock();

// Dynamic promotion label based on product status
if ($is_new) {
    $promotion_type = 'GLOBAL';
} elseif ($is_featured) {
    $promotion_type = 'Featured';
} elseif ($discount_percent > 20) {
    $promotion_type = 'Flash Sale';
} elseif ($discount_percent > 10) {
    $promotion_type = 'Special Offer';
}

// Dynamic hot sale text based on discount percentage
if ($discount_percent > 30) {
    $hot_sale_text = 'Super Sale';
} elseif ($discount_percent > 20) {
    $hot_sale_text = 'Hot Sale';
} elseif ($discount_percent > 10) {
    $hot_sale_text = 'Sale';
}

// Dynamic discount code text based on product tags
if (has_term('vot_tro-gia-1-000-000d', 'product_tag', $product_id)) {
    $discount_code_text = 'Giảm 1.000.000đ';
} elseif (has_term('vot_tro-gia-500-000d', 'product_tag', $product_id)) {
    $discount_code_text = 'Giảm 500.000đ';
} elseif ($discount_percent > 0) {
    $discount_code_text = 'Giảm ' . $discount_percent . '%';
}

// Dynamic warranty status based on product attributes
$warranty_years = get_post_meta($product_id, '_warranty_years', true);
if ($warranty_years) {
    $warranty_status = 'Bảo hành ' . $warranty_years . ' năm';
} elseif ($product->is_on_sale()) {
    $warranty_status = 'Chính hãng';
} else {
    $warranty_status = 'Chất lượng cao';
}

// Get product image using the existing function
$product_image = scode_get_simple_product_image($product_id);
?>

<div class="product-card compact">
    <!-- Header section with dynamic logo and labels -->
    <div class="card-header">
        <div class="card-header-left">
            <div class="logo-small"><?php echo esc_html($brand_name); ?></div>
            <div class="medal-icon" title="<?php echo esc_attr($warranty_status); ?>">
                <i class="fas fa-medal"></i>
            </div>
        </div>
        <div class="card-header-right">
            <div class="global-week-label"><?php echo esc_html($promotion_type); ?></div>
        </div>
    </div>

    <!-- Product image section - Square container -->
    <div class="product-image-container">
        <a href="<?php the_permalink(); ?>" class="product-image-link">
            <?php echo $product_image; ?>
        </a>
        
        <!-- Vertical discount strip - Left side -->
        <?php if ($discount_percent > 0) : ?>
            <div class="discount-strip-vertical">
                -<?php echo $discount_percent; ?>%
            </div>
        <?php endif; ?>

        <!-- Hot Sale ribbon - Diagonal corner -->
        <?php if ($has_discount || $discount_percent > 0) : ?>
            <div class="hot-sale-ribbon">
                <?php echo esc_html($hot_sale_text); ?>
            </div>
        <?php endif; ?>

        <!-- Gift box icon with yellow ribbon - Right side of image -->
        <?php if ($has_discount || $discount_percent > 0) : ?>
            <div class="gift-box-icon" title="Có quà tặng kèm">
                <i class="fas fa-gift"></i>
                <div class="yellow-ribbon"></div>
            </div>
        <?php endif; ?>
    </div>

    <!-- Discount ribbon - Red banner above product title -->
    <?php if ($has_discount || $discount_percent > 0) : ?>
        <div class="discount-ribbon-red">
            <?php echo esc_html($discount_code_text); ?>
        </div>
    <?php endif; ?>

    <!-- Product title -->
    <div class="product-title-section">
        <h3 class="product-title">
            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
        </h3>
    </div>

    <!-- Product price section -->
    <div class="product-price-section">
        <?php if ($product->is_on_sale() && $discount_percent > 0) : ?>
            <div class="price-container">
                <span class="price-promotional">
                    <?php echo number_format_i18n($sale_price, 0); ?>đ
                </span>
                <span class="price-original">
                    <?php echo number_format_i18n($regular_price, 0); ?>đ
                </span>
            </div>
        <?php else : ?>
            <div class="price-container">
                <span class="price-current">
                    <?php echo number_format_i18n($current_price, 0); ?>đ
                </span>
            </div>
        <?php endif; ?>
    </div>
</div>
