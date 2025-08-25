<?php
/**
 * Optimized Single Product Template - MI VIETNAM.VN Style
 * Enhanced WooCommerce integration with performance optimizations
 * 
 * @package SCODE_Theme
 * @version 3.2.0
 */

defined('ABSPATH') || exit;

// Get product data efficiently
global $product;
if (!$product || !is_a($product, 'WC_Product')) {
    return;
}

// Check if password required
if (post_password_required()) {
    echo get_the_password_form();
    return;
}

// Cache product data to avoid multiple calls
$product_data = [
    'id' => $product->get_id(),
    'title' => $product->get_name(),
    'regular_price' => $product->get_regular_price(),
    'sale_price' => $product->get_sale_price(),
    'current_price' => $product->get_price(),
    'gallery_ids' => $product->get_gallery_image_ids(),
    'has_thumbnail' => has_post_thumbnail(),
    'is_on_sale' => $product->is_on_sale(),
    'stock_status' => $product->get_stock_status(),
    'short_description' => $product->get_short_description(),
    'rating' => $product->get_average_rating(),
    'review_count' => $product->get_review_count(),
    'sku' => $product->get_sku(),
    'weight' => $product->get_weight(),
    'dimensions' => $product->get_dimensions(false)
];

// Get categories after product_data is defined
$product_data['categories'] = wc_get_product_category_list($product_data['id']);

// Preload related products - use modern WooCommerce method
$related_products = [];
if (function_exists('wc_get_related_product_ids')) {
    $related_products = wc_get_related_product_ids($product_data['id']);
} else {
    // Fallback for newer WooCommerce versions
    $related_products = $product->get_upsell_ids();
}

$related_query = null;
if (!empty($related_products)) {
    $related_query = new WP_Query([
        'post_type' => 'product',
        'post__in' => array_slice($related_products, 0, 4),
        'posts_per_page' => 4,
        'no_found_rows' => true,
        'update_post_term_cache' => false,
        'update_post_meta_cache' => false
    ]);
}

do_action('woocommerce_before_single_product');
?>

<div id="product-<?php echo esc_attr($product_data['id']); ?>" <?php wc_product_class('otnt-pdp', $product); ?>>
    
    <!-- Main Product Section - Optimized Two Column Layout -->
    <div class="otnt-pdp__main-section">
        
        <!-- Left Column - Enhanced Product Gallery -->
        <div class="otnt-pdp__gallery-column">
            <div class="otnt-pdp__gallery-container">
                
                <!-- Main Image with Enhanced Navigation -->
                <div class="otnt-pdp__main-image-container">
                    <?php if (count($product_data['gallery_ids']) > 0 || $product_data['has_thumbnail']) : ?>
                        <button class="otnt-pdp__nav-arrow otnt-pdp__nav-prev" aria-label="Ảnh trước">
                            <i class="fas fa-chevron-left"></i>
                        </button>
                    <?php endif; ?>
                    
                    <div class="otnt-pdp__main-image">
                        <?php if ($product_data['has_thumbnail']) : ?>
                            <?php 
                            the_post_thumbnail('large', [
                                'class' => 'otnt-pdp__main-img',
                                'loading' => 'eager',
                                'alt' => esc_attr($product_data['title'])
                            ]); 
                            ?>
                        <?php else : ?>
                            <div class="otnt-pdp__no-image">
                                <i class="fas fa-image"></i>
                                <span>Không có hình ảnh</span>
                            </div>
                        <?php endif; ?>
                    </div>
                    
                    <?php if (count($product_data['gallery_ids']) > 0 || $product_data['has_thumbnail']) : ?>
                        <button class="otnt-pdp__nav-arrow otnt-pdp__nav-next" aria-label="Ảnh tiếp">
                            <i class="fas fa-chevron-right"></i>
                        </button>
                    <?php endif; ?>
                </div>
                
                <!-- Optimized Thumbnail Gallery -->
                <?php if (!empty($product_data['gallery_ids']) || $product_data['has_thumbnail']) : ?>
                    <div class="otnt-pdp__thumbnail-gallery">
                        <?php if ($product_data['has_thumbnail']) : ?>
                            <div class="otnt-pdp__thumb-item active" data-index="0">
                                <?php 
                                the_post_thumbnail('thumbnail', [
                                    'class' => 'otnt-pdp__thumb-img',
                                    'loading' => 'lazy'
                                ]); 
                                ?>
                            </div>
                        <?php endif; ?>
                        
                        <?php foreach ($product_data['gallery_ids'] as $index => $image_id) : ?>
                            <div class="otnt-pdp__thumb-item" data-index="<?php echo $index + 1; ?>">
                                <?php 
                                echo wp_get_attachment_image($image_id, 'thumbnail', false, [
                                    'class' => 'otnt-pdp__thumb-img',
                                    'loading' => 'lazy'
                                ]); 
                                ?>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
                
            </div>
        </div>
        
        <!-- Right Column - Enhanced Product Summary -->
        <div class="otnt-pdp__summary-column">
            <div class="otnt-pdp__summary-container">
                
                <!-- Product Header with Enhanced Info -->
                <div class="otnt-pdp__product-header">
                    <h1 class="otnt-pdp__product-title"><?php echo esc_html($product_data['title']); ?></h1>
                    
                    <!-- SKU and Categories -->
                    <?php if ($product_data['sku']) : ?>
                        <div class="otnt-pdp__product-sku">
                            <span class="sku-label">Mã sản phẩm:</span>
                            <span class="sku-value"><?php echo esc_html($product_data['sku']); ?></span>
                        </div>
                    <?php endif; ?>
                    
                    <?php if ($product_data['categories']) : ?>
                        <div class="otnt-pdp__product-categories">
                            <?php echo wp_kses_post($product_data['categories']); ?>
                        </div>
                    <?php endif; ?>
                    
                    <!-- Enhanced Stock Status -->
                    <?php if ($product_data['stock_status'] === 'instock') : ?>
                        <div class="otnt-pdp__stock-status">
                            <i class="fas fa-check-circle"></i>
                            <span>Còn hàng</span>
                            <?php if ($product->get_stock_quantity()) : ?>
                                <span class="stock-quantity">(<?php echo esc_html($product->get_stock_quantity()); ?> sản phẩm)</span>
                            <?php endif; ?>
                        </div>
                    <?php elseif ($product_data['stock_status'] === 'outofstock') : ?>
                        <div class="otnt-pdp__stock-status out-of-stock">
                            <i class="fas fa-times-circle"></i>
                            <span>Hết hàng</span>
                        </div>
                    <?php endif; ?>
                </div>
                
                <!-- Enhanced Product Rating -->
                <?php if ($product_data['rating'] > 0) : ?>
                    <div class="otnt-pdp__product-rating">
                        <div class="otnt-pdp__rating-stars">
                            <?php
                            $rating = $product_data['rating'];
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
                        <span class="otnt-pdp__rating-count">(<?php echo esc_html($product_data['review_count']); ?> đánh giá)</span>
                        <a href="#reviews" class="otnt-pdp__review-link">Xem đánh giá</a>
                    </div>
                <?php endif; ?>
                
                <!-- Enhanced Product Price with VAT Info -->
                <div class="otnt-pdp__product-price">
                    <?php if ($product_data['is_on_sale'] && $product_data['sale_price'] && $product_data['regular_price'] && $product_data['sale_price'] < $product_data['regular_price']) : ?>
                        <div class="otnt-pdp__price-current"><?php echo number_format($product_data['sale_price'], 0, ',', '.'); ?>₫</div>
                        <div class="otnt-pdp__price-old"><?php echo number_format($product_data['regular_price'], 0, ',', '.'); ?>₫</div>
                        <div class="otnt-pdp__price-save">
                            Tiết kiệm: <?php echo number_format($product_data['regular_price'] - $product_data['sale_price'], 0, ',', '.'); ?>₫
                            <span class="discount-percentage">
                                (<?php echo round((($product_data['regular_price'] - $product_data['sale_price']) / $product_data['regular_price']) * 100); ?>%)
                            </span>
                        </div>
                    <?php else : ?>
                        <div class="otnt-pdp__price-current"><?php echo number_format($product_data['current_price'], 0, ',', '.'); ?>₫</div>
                    <?php endif; ?>
                    <div class="otnt-pdp__price-vat">(Đã bao gồm VAT)</div>
                </div>
                
                <!-- Enhanced Short Description -->
                <?php if ($product_data['short_description']) : ?>
                    <div class="otnt-pdp__short-description">
                        <?php echo wp_kses_post($product_data['short_description']); ?>
                    </div>
                <?php endif; ?>
                
                <!-- Enhanced Product Form -->
                <div class="otnt-pdp__product-form">
                    <?php
                    // Enhanced add to cart form with custom styling
                    woocommerce_template_single_add_to_cart();
                    ?>
                </div>
                
                <!-- Enhanced Trust Badges -->
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
                
                <!-- Enhanced Suggested Products Section -->
                <div class="otnt-pdp__suggested-products">
                    <h3 class="otnt-pdp__suggested-title">
                        <i class="fas fa-lightbulb"></i>
                        Sản phẩm gợi ý khác
                    </h3>
                    <div class="otnt-pdp__suggested-grid">
                        <?php
                        if ($related_query && $related_query->have_posts()) :
                            while ($related_query->have_posts()) : $related_query->the_post();
                                global $related_product;
                                $related_product = wc_get_product(get_the_ID());
                                $related_price = $related_product->get_price();
                                $related_thumbnail = has_post_thumbnail() ? get_the_post_thumbnail_url(get_the_ID(), 'thumbnail') : '';
                                ?>
                                <div class="otnt-pdp__suggested-item">
                                    <div class="otnt-pdp__suggested-image">
                                        <a href="<?php the_permalink(); ?>">
                                            <?php if ($related_thumbnail) : ?>
                                                <img src="<?php echo esc_url($related_thumbnail); ?>" 
                                                     alt="<?php echo esc_attr(get_the_title()); ?>"
                                                     loading="lazy">
                                            <?php else : ?>
                                                <div class="otnt-pdp__suggested-placeholder">
                                                    <i class="fas fa-image"></i>
                                                </div>
                                            <?php endif; ?>
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
                        else :
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
                                        <img src="https://via.placeholder.com/80x80/007bff/ffffff?text=Robot" 
                                             alt="<?php echo esc_attr($product['name']); ?>"
                                             loading="lazy">
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
                        endif;
                        ?>
                    </div>
                    
                    <!-- Enhanced View More Products Link -->
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
    
    <!-- Enhanced Product Tabs Section -->
    <div class="otnt-pdp__tabs-section">
        <div class="otnt-pdp__tabs-nav">
            <button class="otnt-pdp__tab-btn active" data-tab="description">
                <i class="fas fa-file-alt"></i>
                MÔ TẢ
            </button>
            <button class="otnt-pdp__tab-btn" data-tab="specifications">
                <i class="fas fa-cogs"></i>
                THÔNG SỐ KỸ THUẬT
            </button>
            <button class="otnt-pdp__tab-btn" data-tab="reviews">
                <i class="fas fa-star"></i>
                ĐÁNH GIÁ SẢN PHẨM
            </button>
            <button class="otnt-pdp__tab-btn" data-tab="shipping">
                <i class="fas fa-shipping-fast"></i>
                VẬN CHUYỂN & BẢO HÀNH
            </button>
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
                    
                    <!-- Additional Product Details -->
                    <?php if ($product_data['weight'] || $product_data['dimensions']) : ?>
                        <div class="otnt-pdp__product-details">
                            <?php if ($product_data['weight']) : ?>
                                <div class="otnt-pdp__detail-item">
                                    <span class="detail-label">Trọng lượng:</span>
                                    <span class="detail-value"><?php echo esc_html($product_data['weight']); ?> kg</span>
                                </div>
                            <?php endif; ?>
                            
                            <?php if ($product_data['dimensions']) : ?>
                                <div class="otnt-pdp__detail-item">
                                    <span class="detail-label">Kích thước:</span>
                                    <span class="detail-value">
                                        <?php 
                                        if (is_array($product_data['dimensions'])) {
                                            echo esc_html(implode(' x ', $product_data['dimensions']));
                                        } else {
                                            echo esc_html($product_data['dimensions']);
                                        }
                                        ?>
                                    </span>
                                </div>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
            
            <!-- Reviews Tab -->
            <div id="reviews" class="otnt-pdp__tab-pane">
                <div class="otnt-pdp__tab-content">
                    <?php
                    if (comments_open()) {
                        comments_template();
                    } else {
                        echo '<p class="otnt-pdp__no-reviews">Đánh giá sản phẩm đang được cập nhật.</p>';
                    }
                    ?>
                </div>
            </div>
            
            <!-- Shipping & Warranty Tab -->
            <div id="shipping" class="otnt-pdp__tab-pane">
                <div class="otnt-pdp__tab-content">
                    <div class="otnt-pdp__shipping-info">
                        <h4>Thông tin vận chuyển</h4>
                        <ul>
                            <li>Giao hàng miễn phí cho đơn hàng từ 500.000₫</li>
                            <li>Giao hàng trong 2-4 giờ tại TP.HCM</li>
                            <li>Giao hàng trong 1-3 ngày tại các tỉnh khác</li>
                            <li>Hỗ trợ giao hàng COD toàn quốc</li>
                        </ul>
                    </div>
                    
                    <div class="otnt-pdp__warranty-info">
                        <h4>Chính sách bảo hành</h4>
                        <ul>
                            <li>Bảo hành chính hãng 12-24 tháng</li>
                            <li>Bảo hành tại trung tâm bảo hành chính hãng</li>
                            <li>Hỗ trợ bảo hành tại nhà</li>
                            <li>Đổi trả miễn phí trong 7 ngày</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
</div>

<?php 
// Clean up
if ($related_query) {
    wp_reset_postdata();
}

do_action('woocommerce_after_single_product'); 
?>
