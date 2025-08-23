<?php
/**
 * Enhanced Single Product Template
 * Complete WooCommerce integration with custom styling
 * 
 * @package SCODE_Theme
 * @version 2.0.0
 */

defined('ABSPATH') || exit;
global $product;

// Don't proceed if no product
if (!$product) {
    return;
}

do_action('woocommerce_before_single_product');

if (post_password_required()) {
    echo get_the_password_form();
    return;
}

$product_id = $product->get_id();
$regular_price = $product->get_regular_price();
$sale_price = $product->get_sale_price();
$current_price = $product->get_price();
$gallery_ids = $product->get_gallery_image_ids();
$has_thumbnail = has_post_thumbnail();
?>

<div id="product-<?php echo $product_id; ?>" <?php wc_product_class('otnt-pdp', $product); ?>>
    
    <!-- Product Gallery Section -->
    <div class="otnt-pdp__gallery-section">
        <div class="otnt-pdp__gallery-main">
            <?php if ($has_thumbnail) : ?>
                <div class="otnt-pdp__main-image">
                    <?php the_post_thumbnail('large', array('class' => 'otnt-pdp__main-img')); ?>
                    <button class="otnt-pdp__zoom-btn" aria-label="Phóng to hình ảnh">
                        <i class="fas fa-search-plus"></i>
                    </button>
                </div>
            <?php endif; ?>
        </div>
        
        <?php if (!empty($gallery_ids)) : ?>
            <div class="otnt-pdp__gallery-thumbs">
                <?php if ($has_thumbnail) : ?>
                    <div class="otnt-pdp__thumb-item active" data-index="0">
                        <?php the_post_thumbnail('thumbnail', array('class' => 'otnt-pdp__thumb-img')); ?>
                    </div>
                <?php endif; ?>
                
                <?php foreach ($gallery_ids as $index => $image_id) : ?>
                    <div class="otnt-pdp__thumb-item" data-index="<?php echo $index + 1; ?>">
                        <?php echo wp_get_attachment_image($image_id, 'thumbnail', false, array('class' => 'otnt-pdp__thumb-img')); ?>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
    
    <!-- Product Summary Section -->
    <div class="otnt-pdp__summary-section">
        <div class="otnt-pdp__product-header">
            <!-- Product Title -->
            <h1 class="otnt-pdp__product-title"><?php the_title(); ?></h1>
            
            <!-- Product Rating -->
            <?php if ($product->get_average_rating() > 0) : ?>
                <div class="otnt-pdp__product-rating">
                    <div class="otnt-pdp__rating-stars">
                        <?php
                        $rating = $product->get_average_rating();
                        for ($i = 1; $i <= 5; $i++) {
                            if ($i <= $rating) {
                                echo '<i class="fas fa-star"></i>';
                            } elseif ($i - $rating < 1) {
                                echo '<i class="fas fa-star-half-alt"></i>';
                            } else {
                                echo '<i class="far fa-star"></i>';
                            }
                        }
                        ?>
                    </div>
                    <span class="otnt-pdp__rating-count">(<?php echo $product->get_review_count(); ?> đánh giá)</span>
                </div>
            <?php endif; ?>
        </div>
        
        <!-- Product Price -->
        <div class="otnt-pdp__product-price">
            <?php if ($sale_price && $regular_price && $sale_price < $regular_price) : ?>
                <div class="otnt-pdp__price-current"><?php echo number_format($sale_price, 0, ',', '.'); ?>₫</div>
                <div class="otnt-pdp__price-old"><?php echo number_format($regular_price, 0, ',', '.'); ?>₫</div>
                <div class="otnt-pdp__price-save">Tiết kiệm: <?php echo number_format($regular_price - $sale_price, 0, ',', '.'); ?>₫</div>
            <?php else : ?>
                <div class="otnt-pdp__price-current"><?php echo number_format($current_price, 0, ',', '.'); ?>₫</div>
            <?php endif; ?>
        </div>
        
        <!-- Product Description -->
        <div class="otnt-pdp__product-description">
            <?php the_excerpt(); ?>
        </div>
        
        <!-- Product Form -->
        <div class="otnt-pdp__product-form">
            <?php
            // Add to cart form
            woocommerce_template_single_add_to_cart();
            ?>
        </div>
        
        <!-- Trust Badges -->
        <div class="otnt-pdp__trust-badges">
            <div class="otnt-pdp__trust-item">
                <i class="fas fa-shield-alt"></i>
                <span>Chính hãng 100%</span>
            </div>
            <div class="otnt-pdp__trust-item">
                <i class="fas fa-truck"></i>
                <span>Giao hàng toàn quốc</span>
            </div>
            <div class="otnt-pdp__trust-item">
                <i class="fas fa-undo"></i>
                <span>Đổi trả 7 ngày</span>
            </div>
            <div class="otnt-pdp__trust-item">
                <i class="fas fa-headset"></i>
                <span>Hỗ trợ 24/7</span>
            </div>
        </div>
        
        <!-- Hotline Section -->
        <div class="otnt-pdp__hotline">
            <div class="otnt-pdp__hotline-avatar">
                <i class="fas fa-user-tie"></i>
            </div>
            <div class="otnt-pdp__hotline-info">
                <div class="otnt-pdp__hotline-name">Tư vấn viên</div>
                <div class="otnt-pdp__hotline-phone"><?php echo esc_html(get_theme_mod('scode_hotline', '0834.777.111')); ?></div>
                <div class="otnt-pdp__hotline-note">Gọi ngay để được hỗ trợ</div>
            </div>
        </div>
    </div>
</div>

<!-- Product Tabs Section -->
<div class="otnt-pdp__tabs-section">
    <div class="otnt-pdp__tabs-nav">
        <button class="otnt-pdp__tab-btn active" data-tab="description">Mô tả</button>
        <button class="otnt-pdp__tab-btn" data-tab="specifications">Thông số</button>
        <button class="otnt-pdp__tab-btn" data-tab="reviews">Đánh giá</button>
        <button class="otnt-pdp__tab-btn" data-tab="warranty">Bảo hành</button>
    </div>
    
    <div class="otnt-pdp__tabs-content">
        <!-- Description Tab -->
        <div id="description" class="otnt-pdp__tab-pane active">
            <div class="otnt-pdp__tab-content">
                <?php the_content(); ?>
            </div>
        </div>
        
        <!-- Specifications Tab -->
        <div id="specifications" class="otnt-pdp__tab-pane">
            <div class="otnt-pdp__tab-content">
                <?php do_action('woocommerce_product_additional_information', $product); ?>
            </div>
        </div>
        
        <!-- Reviews Tab -->
        <div id="reviews" class="otnt-pdp__tab-pane">
            <div class="otnt-pdp__tab-content">
                <?php
                if (comments_open()) {
                    comments_template();
                }
                ?>
            </div>
        </div>
        
        <!-- Warranty Tab -->
        <div id="warranty" class="otnt-pdp__tab-pane">
            <div class="otnt-pdp__tab-content">
                <h3>Chính sách bảo hành</h3>
                <ul>
                    <li>Bảo hành chính hãng 12 tháng</li>
                    <li>Bảo hành tại nhà</li>
                    <li>Hỗ trợ kỹ thuật 24/7</li>
                    <li>Đổi mới trong 7 ngày đầu</li>
                </ul>
            </div>
        </div>
    </div>
</div>

<!-- Related Products -->
<?php
$related_products = wc_get_related_product_ids($product_id);
if (!empty($related_products)) :
?>
<div class="otnt-pdp__related-section">
    <h2 class="otnt-pdp__related-title">Sản phẩm liên quan</h2>
    <div class="otnt-pdp__related-grid">
        <?php
        $related_query = new WP_Query(array(
            'post_type' => 'product',
            'post__in' => $related_products,
            'posts_per_page' => 4
        ));
        
        if ($related_query->have_posts()) :
            while ($related_query->have_posts()) : $related_query->the_post();
                global $related_product;
                $related_product = wc_get_product(get_the_ID());
                ?>
                <div class="otnt-pdp__related-item">
                    <div class="otnt-pdp__related-image">
                        <a href="<?php the_permalink(); ?>">
                            <?php the_post_thumbnail('medium'); ?>
                        </a>
                    </div>
                    <div class="otnt-pdp__related-info">
                        <h3 class="otnt-pdp__related-name">
                            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                        </h3>
                        <div class="otnt-pdp__related-price">
                            <?php echo $related_product->get_price_html(); ?>
                        </div>
                    </div>
                </div>
                <?php
            endwhile;
            wp_reset_postdata();
        endif;
        ?>
    </div>
</div>
<?php endif; ?>

<?php do_action('woocommerce_after_single_product'); ?>
