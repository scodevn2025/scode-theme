<?php
/**
 * Enhanced Single Product Template - MI VIETNAM.VN Style
 * Complete WooCommerce integration with professional layout
 * 
 * @package SCODE_Theme
 * @version 3.1.0
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
$is_on_sale = $product->is_on_sale();
$stock_status = $product->get_stock_status();
$short_description = $product->get_short_description();
$categories = wc_get_product_category_list($product_id);
?>

<div id="product-<?php echo $product_id; ?>" <?php wc_product_class('otnt-pdp', $product); ?>>
    
    <!-- Main Product Section - Two Column Layout -->
    <div class="otnt-pdp__main-section">
        
        <!-- Left Column - Product Gallery (Simplified) -->
        <div class="otnt-pdp__gallery-column">
            <div class="otnt-pdp__gallery-container">
                
                <!-- Main Image with Navigation -->
                <div class="otnt-pdp__main-image-container">
                    <button class="otnt-pdp__nav-arrow otnt-pdp__nav-prev" aria-label="Ảnh trước">
                        <i class="fas fa-chevron-left"></i>
                    </button>
                    
                    <div class="otnt-pdp__main-image">
                        <?php if ($has_thumbnail) : ?>
                            <?php the_post_thumbnail('large', array('class' => 'otnt-pdp__main-img')); ?>
                        <?php else : ?>
                            <div class="otnt-pdp__no-image">
                                <i class="fas fa-image"></i>
                                <span>Không có hình ảnh</span>
                            </div>
                        <?php endif; ?>
                    </div>
                    
                    <button class="otnt-pdp__nav-arrow otnt-pdp__nav-next" aria-label="Ảnh tiếp">
                        <i class="fas fa-chevron-right"></i>
                    </button>
                </div>
                
                <!-- Thumbnail Gallery (Compact) -->
                <?php if (!empty($gallery_ids) || $has_thumbnail) : ?>
                    <div class="otnt-pdp__thumbnail-gallery">
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
        </div>
        
        <!-- Right Column - Product Summary (Simplified) -->
        <div class="otnt-pdp__summary-column">
            <div class="otnt-pdp__summary-container">
                
                <!-- Product Header -->
                <div class="otnt-pdp__product-header">
                    <h1 class="otnt-pdp__product-title"><?php the_title(); ?></h1>
                    
                    <!-- Categories -->
                    <?php if ($categories) : ?>
                        <div class="otnt-pdp__product-categories">
                            <?php echo $categories; ?>
                        </div>
                    <?php endif; ?>
                    
                    <!-- Stock Status -->
                    <?php if ($stock_status === 'instock') : ?>
                        <div class="otnt-pdp__stock-status">
                            <i class="fas fa-check-circle"></i>
                            <span>Còn hàng</span>
                        </div>
                    <?php endif; ?>
                </div>
                
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
                
                <!-- Product Price -->
                <div class="otnt-pdp__product-price">
                    <?php if ($is_on_sale && $sale_price && $regular_price && $sale_price < $regular_price) : ?>
                        <div class="otnt-pdp__price-current"><?php echo number_format($sale_price, 0, ',', '.'); ?>₫</div>
                        <div class="otnt-pdp__price-old"><?php echo number_format($regular_price, 0, ',', '.'); ?>₫</div>
                        <div class="otnt-pdp__price-save">Tiết kiệm: <?php echo number_format($regular_price - $sale_price, 0, ',', '.'); ?>₫</div>
                    <?php else : ?>
                        <div class="otnt-pdp__price-current"><?php echo number_format($current_price, 0, ',', '.'); ?>₫</div>
                    <?php endif; ?>
                    <div class="otnt-pdp__price-vat">(Đã bao gồm VAT)</div>
                </div>
                
                <!-- Short Description -->
                <?php if ($short_description) : ?>
                    <div class="otnt-pdp__short-description">
                        <?php echo wp_kses_post($short_description); ?>
                    </div>
                <?php endif; ?>
                
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
                
                <!-- Suggested Products Section -->
                <div class="otnt-pdp__suggested-products">
                    <h3 class="otnt-pdp__suggested-title">
                        <i class="fas fa-lightbulb"></i>
                        Sản phẩm gợi ý khác
                    </h3>
                    <div class="otnt-pdp__suggested-grid">
                        <?php
                        // Get related products from WooCommerce
                        $related_products = wc_get_related_product_ids($product_id);
                        if (!empty($related_products)) {
                            $related_query = new WP_Query(array(
                                'post_type' => 'product',
                                'post__in' => $related_products,
                                'posts_per_page' => 4
                            ));
                            
                            if ($related_query->have_posts()) :
                                while ($related_query->have_posts()) : $related_query->the_post();
                                    global $related_product;
                                    $related_product = wc_get_product(get_the_ID());
                                    $related_price = $related_product->get_price();
                                    ?>
                                    <div class="otnt-pdp__suggested-item">
                                        <div class="otnt-pdp__suggested-image">
                                            <a href="<?php the_permalink(); ?>">
                                                <?php the_post_thumbnail('thumbnail'); ?>
                                            </a>
                                        </div>
                                        <div class="otnt-pdp__suggested-info">
                                            <div class="otnt-pdp__suggested-name">
                                                <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                            </div>
                                            <div class="otnt-pdp__suggested-price">
                                                <?php echo number_format($related_price, 0, ',', '.'); ?>₫
                                            </div>
                                            <a href="<?php the_permalink(); ?>" class="otnt-pdp__suggested-btn">
                                                Xem chi tiết
                                            </a>
                                        </div>
                                    </div>
                                    <?php
                                endwhile;
                                wp_reset_postdata();
                            endif;
                        } else {
                            // Fallback to sample products if no related products
                            $sample_products = [
                                ['name' => 'Robot hút bụi Dreame L10s Ultra', 'price' => '12.990.000₫', 'url' => '#'],
                                ['name' => 'Robot hút bụi Roborock S8 Pro Ultra', 'price' => '15.500.000₫', 'url' => '#'],
                                ['name' => 'Robot hút bụi iRobot Roomba j7+', 'price' => '18.900.000₫', 'url' => '#'],
                                ['name' => 'Robot hút bụi Tineco iFloor 3', 'price' => '8.990.000₫', 'url' => '#']
                            ];
                            
                            foreach ($sample_products as $product) : ?>
                                <div class="otnt-pdp__suggested-item">
                                    <div class="otnt-pdp__suggested-image">
                                        <img src="https://via.placeholder.com/80x80/007bff/ffffff?text=Robot" alt="<?php echo esc_attr($product['name']); ?>">
                                    </div>
                                    <div class="otnt-pdp__suggested-info">
                                        <div class="otnt-pdp__suggested-name"><?php echo esc_html($product['name']); ?></div>
                                        <div class="otnt-pdp__suggested-price"><?php echo esc_html($product['price']); ?></div>
                                        <a href="<?php echo esc_url($product['url']); ?>" class="otnt-pdp__suggested-btn">
                                            Xem chi tiết
                                        </a>
                                    </div>
                                </div>
                            <?php endforeach;
                        }
                        ?>
                    </div>
                    
                    <!-- View More Products Link -->
                    <div class="otnt-pdp__view-more">
                        <a href="<?php echo esc_url(get_permalink(wc_get_page_id('shop'))); ?>" class="otnt-pdp__view-more-btn">
                            <i class="fas fa-arrow-right"></i>
                            Xem thêm sản phẩm khác
                        </a>
                    </div>
                </div>
                
            </div>
        </div>
        
    </div>
    
    <!-- Product Tabs Section -->
    <div class="otnt-pdp__tabs-section">
        <div class="otnt-pdp__tabs-nav">
            <button class="otnt-pdp__tab-btn active" data-tab="description">MÔ TẢ</button>
            <button class="otnt-pdp__tab-btn" data-tab="specifications">THÔNG SỐ KỸ THUẬT</button>
            <button class="otnt-pdp__tab-btn" data-tab="reviews">ĐÁNH GIÁ SẢN PHẨM</button>
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
        </div>
    </div>
    
</div>

<?php do_action('woocommerce_after_single_product'); ?>
