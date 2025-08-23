<?php
/**
 * Enhanced Single Product Template - MI VIETNAM.VN Style
 * Complete WooCommerce integration with professional layout
 * 
 * @package SCODE_Theme
 * @version 3.0.0
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
?>

<div id="product-<?php echo $product_id; ?>" <?php wc_product_class('otnt-pdp', $product); ?>>
    
    <!-- Main Product Section - Two Column Layout -->
    <div class="otnt-pdp__main-section">
        
        <!-- Left Column - Product Gallery -->
        <div class="otnt-pdp__gallery-column">
            <div class="otnt-pdp__gallery-container">
                
                <!-- Sale Badges -->
                <div class="otnt-pdp__sale-badges">
                    <div class="otnt-pdp__sale-badge otnt-badge-summer">HÈ RỰC RÕ</div>
                    <div class="otnt-pdp__sale-badge otnt-badge-deal">Săn Deal Cực Đỉnh</div>
                </div>
                
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
                
                <!-- Thumbnail Gallery -->
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
        
        <!-- Right Column - Product Summary -->
        <div class="otnt-pdp__summary-column">
            <div class="otnt-pdp__summary-container">
                
                <!-- Product Header -->
                <div class="otnt-pdp__product-header">
                    <h1 class="otnt-pdp__product-title"><?php the_title(); ?></h1>
                    
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
                        <span class="otnt-pdp__rating-count">(<?php echo $product->get_review_count(); ?> đánh giá của khách hàng)</span>
                    </div>
                <?php endif; ?>
                
                <!-- Product Price -->
                <div class="otnt-pdp__product-price">
                    <?php if ($is_on_sale && $sale_price && $regular_price && $sale_price < $regular_price) : ?>
                        <div class="otnt-pdp__price-current"><?php echo number_format($sale_price, 0, ',', '.'); ?>₫</div>
                        <div class="otnt-pdp__price-old"><?php echo number_format($regular_price, 0, ',', '.'); ?>₫</div>
                        <div class="otnt-pdp__price-vat">(Đã bao gồm VAT)</div>
                    <?php else : ?>
                        <div class="otnt-pdp__price-current"><?php echo number_format($current_price, 0, ',', '.'); ?>₫</div>
                        <div class="otnt-pdp__price-vat">(Đã bao gồm VAT)</div>
                    <?php endif; ?>
                </div>
                
                <!-- Product Variants -->
                <div class="otnt-pdp__product-variants">
                    <h3 class="otnt-pdp__variants-title">Chọn Phiên bản</h3>
                    <div class="otnt-pdp__variants-grid">
                        <button class="otnt-pdp__variant-btn active" data-variant="x8-pro">
                            <span class="otnt-pdp__variant-name">X8 Pro Omni</span>
                            <span class="otnt-pdp__variant-price">17.900.000₫</span>
                        </button>
                        <button class="otnt-pdp__variant-btn" data-variant="x5-pro">
                            <span class="otnt-pdp__variant-name">X5 Pro Omni</span>
                            <span class="otnt-pdp__variant-price">16.500.000₫</span>
                        </button>
                        <button class="otnt-pdp__variant-btn" data-variant="t50-pro">
                            <span class="otnt-pdp__variant-name">T50 Pro Omni</span>
                            <span class="otnt-pdp__variant-price">15.400.000₫</span>
                        </button>
                        <button class="otnt-pdp__variant-btn" data-variant="t30s-kr">
                            <span class="otnt-pdp__variant-name">T30s KR</span>
                            <span class="otnt-pdp__variant-price">13.900.000₫</span>
                        </button>
                        <button class="otnt-pdp__variant-btn" data-variant="n30-pro">
                            <span class="otnt-pdp__variant-name">N30 Pro Omni</span>
                            <span class="otnt-pdp__variant-price">9.690.000₫</span>
                        </button>
                        <button class="otnt-pdp__variant-btn" data-variant="t30s-combo">
                            <span class="otnt-pdp__variant-name">T30s Combo</span>
                            <span class="otnt-pdp__variant-price">14.900.000₫</span>
                        </button>
                    </div>
                    
                    <!-- Additional Options -->
                    <div class="otnt-pdp__additional-options">
                        <div class="otnt-pdp__option-row">
                            <button class="otnt-pdp__option-btn" data-option="pump-black">
                                <span>Bơm xả nước tự động (Đen)</span>
                            </button>
                            <button class="otnt-pdp__option-btn" data-option="standard-demo">
                                <span>Tiêu chuẩn (Demo)</span>
                            </button>
                        </div>
                        <div class="otnt-pdp__option-row">
                            <button class="otnt-pdp__option-btn" data-option="standard-black">
                                <span>Tiêu chuẩn (Đen)</span>
                            </button>
                            <button class="otnt-pdp__option-btn" data-option="standard-white">
                                <span>Tiêu chuẩn (Trắng)</span>
                            </button>
                        </div>
                    </div>
                </div>
                
                <!-- Suggested Products Section -->
                <div class="otnt-pdp__suggested-products">
                    <h3 class="otnt-pdp__suggested-title">
                        <i class="fas fa-lightbulb"></i>
                        Sản phẩm gợi ý khác
                    </h3>
                    <div class="otnt-pdp__suggested-grid">
                        <div class="otnt-pdp__suggested-item">
                            <div class="otnt-pdp__suggested-image">
                                <img src="https://via.placeholder.com/80x80/007bff/ffffff?text=Robot" alt="Robot hút bụi Dreame">
                            </div>
                            <div class="otnt-pdp__suggested-info">
                                <div class="otnt-pdp__suggested-name">Robot hút bụi Dreame L10s Ultra</div>
                                <div class="otnt-pdp__suggested-price">12.990.000₫</div>
                                <button class="otnt-pdp__suggested-btn" data-product="dreame-l10s">Chọn sản phẩm này</button>
                            </div>
                        </div>
                        
                        <div class="otnt-pdp__suggested-item">
                            <div class="otnt-pdp__suggested-image">
                                <img src="https://via.placeholder.com/80x80/28a745/ffffff?text=Robot" alt="Robot hút bụi Roborock">
                            </div>
                            <div class="otnt-pdp__suggested-info">
                                <div class="otnt-pdp__suggested-name">Robot hút bụi Roborock S8 Pro Ultra</div>
                                <div class="otnt-pdp__suggested-price">15.500.000₫</div>
                                <button class="otnt-pdp__suggested-btn" data-product="roborock-s8">Chọn sản phẩm này</button>
                            </div>
                        </div>
                        
                        <div class="otnt-pdp__suggested-item">
                            <div class="otnt-pdp__suggested-image">
                                <img src="https://via.placeholder.com/80x80/dc3545/ffffff?text=Robot" alt="Robot hút bụi iRobot">
                            </div>
                            <div class="otnt-pdp__suggested-info">
                                <div class="otnt-pdp__suggested-name">Robot hút bụi iRobot Roomba j7+</div>
                                <div class="otnt-pdp__suggested-price">18.900.000₫</div>
                                <button class="otnt-pdp__suggested-btn" data-product="irobot-j7">Chọn sản phẩm này</button>
                            </div>
                        </div>
                        
                        <div class="otnt-pdp__suggested-item">
                            <div class="otnt-pdp__suggested-image">
                                <img src="https://via.placeholder.com/80x80/ffc107/ffffff?text=Robot" alt="Robot hút bụi Tineco">
                            </div>
                            <div class="otnt-pdp__suggested-info">
                                <div class="otnt-pdp__suggested-name">Robot hút bụi Tineco iFloor 3</div>
                                <div class="otnt-pdp__suggested-price">8.990.000₫</div>
                                <button class="otnt-pdp__suggested-btn" data-product="tineco-ifloor3">Chọn sản phẩm này</button>
                            </div>
                        </div>
                    </div>
                    
                    <!-- View More Products Link -->
                    <div class="otnt-pdp__view-more">
                        <a href="<?php echo esc_url(get_permalink(wc_get_page_id('shop'))); ?>" class="otnt-pdp__view-more-btn">
                            <i class="fas fa-arrow-right"></i>
                            Xem thêm sản phẩm khác
                        </a>
                    </div>
                </div>
                
                <!-- Promotions -->
                <div class="otnt-pdp__promotions">
                    <h3 class="otnt-pdp__promotions-title">
                        <i class="fas fa-gift"></i>
                        Khuyến mãi hấp dẫn
                    </h3>
                    <ul class="otnt-pdp__promotions-list">
                        <li>Ưu đãi 15.08-31.08: Tặng 01 Quạt cầm tay Lumias F3600 trị giá 390K (dành cho bản tiêu chuẩn mới)</li>
                        <li>Tặng 02 Nước lau sàn OMO 110ml chuyên dụng (Số lượng có hạn)</li>
                    </ul>
                </div>
                
                <!-- Call to Action Buttons -->
                <div class="otnt-pdp__cta-buttons">
                    <button class="otnt-pdp__cta-btn otnt-pdp__cta-primary">
                        <i class="fas fa-shopping-cart"></i>
                        MUA NGAY
                    </button>
                    <button class="otnt-pdp__cta-btn otnt-pdp__cta-secondary">
                        <i class="fas fa-clock"></i>
                        ĐẶT HÀNG TRƯỚC
                    </button>
                </div>
                
                <!-- Delivery Info -->
                <div class="otnt-pdp__delivery-info">
                    <div class="otnt-pdp__delivery-item">
                        <i class="fas fa-truck"></i>
                        <span>Giao hàng nhanh tận nơi</span>
                    </div>
                    <div class="otnt-pdp__delivery-item">
                        <i class="fas fa-box"></i>
                        <span>Nhận hàng sớm nhất khi có hàng</span>
                    </div>
                </div>
                
                <!-- Payment Options -->
                <div class="otnt-pdp__payment-options">
                    <div class="otnt-pdp__payment-section">
                        <h4>TRẢ GÓP QUA THẺ</h4>
                        <div class="otnt-pdp__payment-logos">
                            <i class="fab fa-cc-visa"></i>
                            <i class="fab fa-cc-mastercard"></i>
                            <i class="fab fa-cc-jcb"></i>
                        </div>
                    </div>
                    <div class="otnt-pdp__payment-section">
                        <h4>MUA NGAY - TRẢ SAU</h4>
                        <div class="otnt-pdp__payment-logos">
                            <i class="fas fa-home"></i>
                            <span>Home Credit</span>
                        </div>
                    </div>
                </div>
                
                <!-- Savings Info -->
                <div class="otnt-pdp__savings-info">
                    <i class="fas fa-piggy-bank"></i>
                    <span>Tiết kiệm thêm đến 300,000₫ cho Mifan</span>
                </div>
                
                <!-- Discount Link -->
                <div class="otnt-pdp__discount-link">
                    <a href="#" class="otnt-pdp__discount-btn">
                        <i class="fas fa-comments"></i>
                        Nhắn tin Giảm Giá sản phẩm này
                    </a>
                </div>
                
                <!-- Warranty Block -->
                <div class="otnt-pdp__warranty-block">
                    <div class="otnt-pdp__warranty-header">
                        <h3>BẢO HÀNH ROBOT TẠI NHÀ</h3>
                        <h4>SỐ 1 HẬU MÃI</h4>
                    </div>
                    <div class="otnt-pdp__warranty-phone">
                        <span class="otnt-pdp__phone-number">1900.068.828</span>
                        <button class="otnt-pdp__call-btn">GỌI NGAY</button>
                    </div>
                    <div class="otnt-pdp__warranty-info">
                        <div class="otnt-pdp__warranty-icon">
                            <i class="fas fa-truck"></i>
                        </div>
                        <div class="otnt-pdp__warranty-text">
                            <span>Bán kính 20km từ cửa hàng</span>
                        </div>
                    </div>
                </div>
                
                <!-- Partnership Badge -->
                <div class="otnt-pdp__partnership-badge">
                    <div class="otnt-pdp__partnership-logo">10</div>
                    <div class="otnt-pdp__partnership-text">
                        <strong>MIVIETNAM.VN LÀ ĐỐI TÁC PHÂN PHỐI CHIẾN LƯỢC ECOVACS TẠI VIỆT NAM</strong>
                    </div>
                    <div class="otnt-pdp__ecovacs-logo">
                        <i class="fas fa-robot"></i>
                    </div>
                </div>
                
                <!-- Product Policies -->
                <div class="otnt-pdp__product-policies">
                    <ul class="otnt-pdp__policies-list">
                        <li><i class="fas fa-check"></i> Hàng chính hãng, giá full VAT</li>
                        <li><i class="fas fa-check"></i> Hàng Demo</li>
                        <li><i class="fas fa-check"></i> Bảo hành điện tử 24 tháng</li>
                        <li><i class="fas fa-check"></i> Đổi mới trong 15 ngày</li>
                        <li><i class="fas fa-check"></i> Tặng gói bảo hành tại nhà</li>
                        <li><i class="fas fa-check"></i> Cam kết hàng mới 100% Brandnew</li>
                        <li><i class="fas fa-check"></i> Lắp đặt, HDSD kĩ càng</li>
                        <li><i class="fas fa-check"></i> Đảm bảo dịch vụ hậu mãi</li>
                        <li><i class="fas fa-check"></i> Miễn phí vận chuyển Toàn Quốc</li>
                    </ul>
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
            <button class="otnt-pdp__tab-btn" data-tab="related">SẢN PHẨM LIÊN QUAN</button>
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
            
            <!-- Related Products Tab -->
            <div id="related" class="otnt-pdp__tab-pane">
                <div class="otnt-pdp__tab-content">
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
                </div>
            </div>
        </div>
    </div>
    
    <!-- VIP Service Section -->
    <div class="otnt-pdp__vip-section">
        <div class="otnt-pdp__vip-header">
            <h2>Mua hàng như Vua - Phục vụ như VIP</h2>
            <div class="otnt-pdp__quality-badge">QUALITY CONTROL APPROVED</div>
        </div>
        <ul class="otnt-pdp__vip-list">
            <li><i class="fas fa-shield-alt"></i> Đảm bảo chính hãng 100%</li>
            <li><i class="fas fa-star"></i> Chuyên nghiệp, chất lượng, tin cậy</li>
            <li><i class="fas fa-headset"></i> Dịch vụ sau bán hàng nhanh chóng</li>
            <li><i class="fas fa-truck"></i> Miễn phí giao hàng với đơn hàng từ 500.000₫ trong nội thành - bán kính 15km từ cửa hàng</li>
        </ul>
    </div>
    
</div>

<?php do_action('woocommerce_after_single_product'); ?>
