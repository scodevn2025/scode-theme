<?php
/**
 * WooCommerce Single Product Template - Professional Layout
 * 
 * @package SCODE_Theme
 * @version 2.0.0
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

// Don't call get_header() here as it's already loaded by woocommerce.php

while (have_posts()) : the_post(); 
    global $product;
    
    // Get product data
    $product_id = $product->get_id();
    $regular_price = $product->get_regular_price();
    $sale_price = $product->get_sale_price();
    $current_price = $product->get_price();
    
    // Calculate discount
    $discount_percentage = 0;
    if ($regular_price && $sale_price && $regular_price > $sale_price) {
        $discount_percentage = round((($regular_price - $sale_price) / $regular_price) * 100);
    }
    
    // Get custom fields
    $is_new = get_post_meta($product_id, '_is_new', true);
    $is_premium = get_post_meta($product_id, '_is_premium', true);
    $is_global = get_post_meta($product_id, '_is_global', true);
    $is_genuine = get_post_meta($product_id, '_is_genuine', true);
    $product_features = get_post_meta($product_id, '_product_features', true);
    $gift_value = get_post_meta($product_id, '_gift_value', true);
    $free_shipping = get_post_meta($product_id, '_free_shipping', true);
    $product_video = get_post_meta($product_id, '_product_video', true);
    
    // Get product images
    $product_images = array();
    if (has_post_thumbnail()) {
        $product_images[] = get_post_thumbnail_id();
    }
    
    // Get additional product images
    $gallery_ids = $product->get_gallery_image_ids();
    $product_images = array_merge($product_images, $gallery_ids);
?>

<!-- Breadcrumb Navigation -->
<nav class="breadcrumb-navigation">
    <div class="container">
        <div class="breadcrumb-container">
            <a href="<?php echo home_url('/'); ?>" class="breadcrumb-link">
                <i class="fas fa-home"></i> Trang chủ
            </a>
            <span class="breadcrumb-separator">/</span>
            <?php
            $categories = get_the_terms($product_id, 'product_cat');
            if ($categories && !is_wp_error($categories)) {
                $category = $categories[0];
                echo '<a href="' . get_term_link($category) . '" class="breadcrumb-link">' . $category->name . '</a>';
                echo '<span class="breadcrumb-separator">/</span>';
            }
            ?>
            <span class="breadcrumb-current"><?php the_title(); ?></span>
        </div>
    </div>
</nav>

<!-- Main Product Layout -->
<main class="single-product-page">
    <div class="container">
        <div class="product-main-layout">
            
            <!-- Left Column: Product Gallery (60%) -->
            <div class="product-gallery-column">
                <div class="product-gallery-wrapper">
                    
                    <!-- Main Image Container -->
                    <div class="main-image-container">
                        <?php if (has_post_thumbnail()) : ?>
                            <div class="main-image active" data-index="0">
                                <?php the_post_thumbnail('product-large', array('class' => 'product-main-img', 'data-zoom' => get_the_post_thumbnail_url($product_id, 'full'))); ?>
                                
                                <!-- Brand Watermark -->
                                <div class="brand-watermark">
                                    <?php if ($is_global) : ?>
                                        <span class="watermark-badge global">GLOBAL</span>
                                    <?php endif; ?>
                                    <?php if ($is_genuine) : ?>
                                        <span class="watermark-badge genuine">100% GENUINE</span>
                                    <?php endif; ?>
                                </div>
                                
                                <!-- Zoom Trigger -->
                                <button class="zoom-trigger" aria-label="Phóng to hình ảnh">
                                    <i class="fas fa-search-plus"></i>
                                </button>
                            </div>
                        <?php endif; ?>
                        
                        <!-- Additional Main Images -->
                        <?php if (!empty($gallery_ids)) : ?>
                            <?php foreach ($gallery_ids as $index => $image_id) : ?>
                                <div class="main-image" data-index="<?php echo $index + 1; ?>">
                                    <?php echo wp_get_attachment_image($image_id, 'product-large', false, array('class' => 'product-main-img', 'data-zoom' => wp_get_attachment_image_url($image_id, 'full'))); ?>
                                    
                                    <div class="brand-watermark">
                                        <?php if ($is_global) : ?>
                                            <span class="watermark-badge global">GLOBAL</span>
                                        <?php endif; ?>
                                        <?php if ($is_genuine) : ?>
                                            <span class="watermark-badge genuine">100% GENUINE</span>
                                        <?php endif; ?>
                                    </div>
                                    
                                    <button class="zoom-trigger" aria-label="Phóng to hình ảnh">
                                        <i class="fas fa-search-plus"></i>
                                    </button>
                                </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                        
                        <!-- Video Main (if exists) -->
                        <?php if (!empty($product_video)) : ?>
                            <div class="video-main" data-video="<?php echo esc_attr($product_video); ?>">
                                <div class="video-placeholder">
                                    <i class="fas fa-play-circle"></i>
                                    <span>Xem video sản phẩm</span>
                                </div>
                                <div class="video-play-overlay">
                                    <i class="fas fa-play"></i>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                    
                    <!-- Thumbnail Gallery Strip -->
                    <div class="thumbnail-gallery-strip">
                        <div class="thumbnails-container">
                            <!-- Main Image Thumbnail -->
                            <?php if (has_post_thumbnail()) : ?>
                                <div class="thumb-item active" data-index="0">
                                    <?php the_post_thumbnail('product-thumb', array('class' => 'thumb-img')); ?>
                                </div>
                            <?php endif; ?>
                            
                            <!-- Gallery Thumbnails -->
                            <?php if (!empty($gallery_ids)) : ?>
                                <?php foreach ($gallery_ids as $index => $image_id) : ?>
                                    <div class="thumb-item" data-index="<?php echo $index + 1; ?>">
                                        <?php echo wp_get_attachment_image($image_id, 'product-thumb', false, array('class' => 'thumb-img')); ?>
                                    </div>
                                <?php endforeach; ?>
                            <?php endif; ?>
                            
                            <!-- Video Thumbnail (if exists) -->
                            <?php if (!empty($product_video)) : ?>
                                <div class="video-thumb" data-video="<?php echo esc_attr($product_video); ?>">
                                    <div class="video-thumb-placeholder">
                                        <i class="fas fa-play"></i>
                                    </div>
                                    <div class="video-indicator">
                                        <i class="fas fa-video"></i>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </div>
                        
                        <!-- Thumbnail Navigation Arrows -->
                        <button class="thumb-nav left" aria-label="Xem ảnh trước">
                            <i class="fas fa-chevron-left"></i>
                        </button>
                        <button class="thumb-nav right" aria-label="Xem ảnh tiếp">
                            <i class="fas fa-chevron-right"></i>
                        </button>
                    </div>
                </div>
            </div>
            
            <!-- Right Column: Product Information (40%) -->
            <div class="product-summary-column">
                <div class="product-summary-wrapper">
                    
                    <!-- Brand & Series Info -->
                    <div class="brand-series-info">
                        <?php if ($is_global) : ?>
                            <div class="brand-info">
                                <span class="brand-label">Phiên bản:</span>
                                <span class="brand-value">Quốc Tế</span>
                            </div>
                        <?php endif; ?>
                        
                        <?php if ($is_premium) : ?>
                            <div class="series-info">
                                <span class="series-label">Series:</span>
                                <span class="series-value">Premium</span>
                            </div>
                        <?php endif; ?>
                    </div>
                    
                    <!-- Product Title -->
                    <h1 class="product-title"><?php the_title(); ?></h1>
                    
                    <!-- Product Rating Section -->
                    <div class="product-rating-section">
                        <div class="rating-stars">
                            <?php
                            $rating = $product->get_average_rating();
                            $count = $product->get_review_count();
                            
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
                        <span class="rating-count">(<?php echo $count; ?> đánh giá)</span>
                    </div>
                    
                    <!-- Product Badges Section -->
                    <div class="product-badges-section">
                        <?php if ($discount_percentage > 0) : ?>
                            <span class="badge discount-badge">-<?php echo $discount_percentage; ?>%</span>
                        <?php endif; ?>
                        
                        <?php if ($is_new) : ?>
                            <span class="badge new-badge">Mới</span>
                        <?php endif; ?>
                        
                        <?php if ($is_premium) : ?>
                            <span class="badge premium-badge">Premium</span>
                        <?php endif; ?>
                        
                        <?php if ($is_global) : ?>
                            <span class="badge global-badge">Global</span>
                        <?php endif; ?>
                        
                        <?php if ($is_genuine) : ?>
                            <span class="badge genuine-badge">100% Genuine</span>
                        <?php endif; ?>
                    </div>
                    
                    <!-- Product Price Section -->
                    <div class="product-price-section">
                        <?php if ($sale_price && $regular_price) : ?>
                            <div class="current-price"><?php echo number_format_i18n($sale_price, 0); ?>₫</div>
                            <div class="old-price"><?php echo number_format_i18n($regular_price, 0); ?>₫</div>
                            <div class="save-amount">Tiết kiệm: <?php echo number_format_i18n($regular_price - $sale_price, 0); ?>₫</div>
                        <?php else : ?>
                            <div class="current-price"><?php echo number_format_i18n($current_price, 0); ?>₫</div>
                        <?php endif; ?>
                    </div>
                    
                    <!-- Flash Sale Countdown (if applicable) -->
                    <?php if ($discount_percentage > 0) : ?>
                        <div class="flash-sale-countdown" data-deadline="<?php echo date('Y-m-d H:i:s', strtotime('+24 hours')); ?>">
                            <div class="countdown-label">KHUYẾN MÃI CÒN LẠI:</div>
                            <div class="countdown-timer">
                                <div class="time-unit">
                                    <div class="time-value" id="countdown-hours">24</div>
                                    <div class="time-label">Giờ</div>
                                </div>
                                <div class="time-separator">:</div>
                                <div class="time-unit">
                                    <div class="time-value" id="countdown-minutes">00</div>
                                    <div class="time-label">Phút</div>
                                </div>
                                <div class="time-separator">:</div>
                                <div class="time-unit">
                                    <div class="time-value" id="countdown-seconds">00</div>
                                    <div class="time-label">Giây</div>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                    
                    <!-- Gifts Section -->
                    <?php if (!empty($gift_value)) : ?>
                        <div class="gifts-section">
                            <div class="gifts-title">
                                <i class="fas fa-gift"></i>
                                QUÀ TẶNG ĐẶC BIỆT
                            </div>
                            <div class="gifts-list">
                                <div class="gift-item">
                                    <div class="gift-image">
                                        <div class="gift-placeholder">
                                            <i class="fas fa-gift"></i>
                                        </div>
                                    </div>
                                    <div class="gift-info">
                                        <div class="gift-title">Quà tặng trị giá</div>
                                        <div class="gift-note"><?php echo esc_html($gift_value); ?></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                    
                    <!-- Trust Policies Section -->
                    <div class="trust-policies-section">
                        <div class="policy-item">
                            <i class="fas fa-shield-alt"></i>
                            <span>Bảo hành chính hãng 12 tháng</span>
                        </div>
                        <div class="policy-item">
                            <i class="fas fa-truck"></i>
                            <span>Miễn phí vận chuyển toàn quốc</span>
                        </div>
                        <div class="policy-item">
                            <i class="fas fa-credit-card"></i>
                            <span>Hỗ trợ trả góp 0%</span>
                        </div>
                        <div class="policy-item">
                            <i class="fas fa-headset"></i>
                            <span>Hỗ trợ 24/7</span>
                        </div>
                    </div>
                    
                    <!-- Quantity Section -->
                    <div class="quantity-section">
                        <label for="quantity">Số lượng:</label>
                        <div class="quantity-controls">
                            <button type="button" class="qty-btn minus" aria-label="Giảm số lượng">
                                <i class="fas fa-minus"></i>
                            </button>
                            <input type="number" id="quantity" class="qty" name="quantity" value="1" min="1" max="99">
                            <button type="button" class="qty-btn plus" aria-label="Tăng số lượng">
                                <i class="fas fa-plus"></i>
                            </button>
                        </div>
                    </div>
                    
                    <!-- CTA Buttons Section -->
                    <div class="cta-buttons-section">
                        <button type="button" class="cta-button add-to-cart-btn" data-product-id="<?php echo $product_id; ?>">
                            <i class="fas fa-shopping-cart"></i>
                            THÊM VÀO GIỎ HÀNG
                        </button>
                        
                        <button type="button" class="cta-button buy-now-btn">
                            <i class="fas fa-bolt"></i>
                            MUA NGAY
                        </button>
                        
                        <button type="button" class="cta-button installment-btn">
                            <i class="fas fa-credit-card"></i>
                            TRẢ GÓP 0%
                        </button>
                    </div>
                    
                    <!-- Consultant Box -->
                    <div class="consultant-box">
                        <div class="consultant-avatar">
                            <?php if (get_theme_mod('scode_consultant_avatar')) : ?>
                                <img src="<?php echo esc_url(get_theme_mod('scode_consultant_avatar')); ?>" alt="Tư vấn viên">
                            <?php else : ?>
                                <div class="avatar-placeholder">
                                    <i class="fas fa-user-tie"></i>
                                </div>
                            <?php endif; ?>
                        </div>
                        <div class="consultant-info">
                            <div class="consultant-name">Tư vấn viên</div>
                            <div class="consultant-phone"><?php echo esc_html(get_theme_mod('scode_hotline', '0834.777.111')); ?></div>
                        </div>
                    </div>
                    
                    <!-- Shipping Badges -->
                    <div class="shipping-badges">
                        <div class="shipping-badge">
                            <i class="fas fa-shipping-fast"></i>
                            Giao hàng trong 2-4h
                        </div>
                        <div class="shipping-badge">
                            <i class="fas fa-undo"></i>
                            Đổi trả trong 7 ngày
                        </div>
                    </div>
                </div>
            </div>
        </div>
        

        
        <!-- Product Tabs Section -->
        <section class="product-tabs-section">
            <div class="tabs-nav">
                <button class="tab-btn active" data-tab="description">Mô tả</button>
                <button class="tab-btn" data-tab="specifications">Thông số kỹ thuật</button>
                <button class="tab-btn" data-tab="reviews">Đánh giá</button>
                <button class="tab-btn" data-tab="warranty">Bảo hành</button>
            </div>
            
            <div class="tabs-content">
                <!-- Description Tab -->
                <div id="description" class="tab-pane active">
                    <div class="product-description">
                        <div class="description-content" id="description-content" style="max-height: 200px !important; overflow: hidden !important; position: relative !important; transition: max-height 0.8s ease !important;">
                            <?php the_content(); ?>
                            
                            <!-- Product Media Gallery -->
                            <div class="product-media-gallery">
                                
                                <!-- ECOVACS Brand Video Section -->
                                <div class="brand-video-section">
                                    <h3>Video giới thiệu sản phẩm</h3>
                                    <div class="video-embed-container">
                                        <div class="video-placeholder" style="background: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 100%); height: 300px; border-radius: 12px; display: flex; align-items: center; justify-content: center; color: white; cursor: pointer;">
                                            <div style="text-align: center;">
                                                <i class="fas fa-play-circle" style="font-size: 64px; margin-bottom: 15px;"></i>
                                                <p style="font-size: 18px; font-weight: 600;">Video Review Chi Tiết</p>
                                                <p style="font-size: 14px; opacity: 0.9;">Xem đánh giá chuyên sâu về sản phẩm</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Product Images Gallery -->
                                <div class="product-images-section">
                                    <h3>Hình ảnh chi tiết</h3>
                                    <div class="images-grid">
                                        <div class="image-item">
                                            <div class="image-placeholder" style="background: #f8f9fa; height: 200px; border-radius: 8px; display: flex; align-items: center; justify-content: center; border: 2px dashed #dee2e6;">
                                                <div style="text-align: center; color: #6c757d;">
                                                    <i class="fas fa-image" style="font-size: 32px; margin-bottom: 10px;"></i>
                                                    <p>Hình ảnh sản phẩm</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="image-item">
                                            <div class="image-placeholder" style="background: #f8f9fa; height: 200px; border-radius: 8px; display: flex; align-items: center; justify-content: center; border: 2px dashed #dee2e6;">
                                                <div style="text-align: center; color: #6c757d;">
                                                    <i class="fas fa-image" style="font-size: 32px; margin-bottom: 10px;"></i>
                                                    <p>Chi tiết sản phẩm</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- MI VIETNAM.VN Store Info -->
                                <div class="store-info-section">
                                    <div class="store-banner" style="background: linear-gradient(135deg, #f36c21 0%, #e55a1f 100%); color: white; padding: 25px; border-radius: 12px; text-align: center;">
                                        <h3 style="margin-bottom: 15px; font-size: 24px;">MI VIETNAM.VN</h3>
                                        <p style="margin-bottom: 10px; font-size: 16px;">Hệ thống phân phối chính thức các sản phẩm Xiaomi tại Việt Nam</p>
                                        <div style="display: flex; justify-content: center; gap: 30px; margin-top: 20px;">
                                            <div>
                                                <i class="fas fa-shield-alt" style="font-size: 24px; margin-bottom: 8px;"></i>
                                                <p style="font-size: 14px;">Chính hãng 100%</p>
                                            </div>
                                            <div>
                                                <i class="fas fa-truck" style="font-size: 24px; margin-bottom: 8px;"></i>
                                                <p style="font-size: 14px;">Giao hàng toàn quốc</p>
                                            </div>
                                            <div>
                                                <i class="fas fa-tools" style="font-size: 24px; margin-bottom: 8px;"></i>
                                                <p style="font-size: 14px;">Bảo hành uy tín</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                            </div>
                        </div>
                        
                        <!-- Read More Button -->
                        <div class="read-more-section">
                            <button id="read-more-btn" class="read-more-btn" style="background: #f36c21 !important; color: white !important; padding: 12px 24px !important; border: none !important; border-radius: 25px !important; cursor: pointer !important; font-size: 14px !important; font-weight: 600 !important;">
                                <span class="read-more-text">Xem thêm</span>
                                <span class="read-less-text" style="display: none;">Thu gọn</span>
                                <i class="fas fa-chevron-down read-more-icon"></i>
                                <i class="fas fa-chevron-up read-less-icon" style="display: none;"></i>
                            </button>
                        </div>
                        
                        <style>
                        .description-content.expanded {
                            max-height: none !important;
                            overflow: visible !important;
                        }
                        .description-content.expanded::after {
                            opacity: 0 !important;
                            display: none !important;
                        }
                        .description-content {
                            transition: max-height 0.8s ease !important;
                        }
                        </style>
                        
                        <script>
                        jQuery(document).ready(function($) {
                            console.log('=== INLINE JS TEST ===');
                            
                            const $btn = $('#read-more-btn');
                            const $content = $('#description-content');
                            
                            console.log('Inline elements:', {
                                button: $btn.length,
                                content: $content.length
                            });
                            
                            $btn.on('click', function(e) {
                                e.preventDefault();
                                console.log('Inline button clicked!');
                                
                                const isExpanded = $content.hasClass('expanded');
                                console.log('Current state:', { isExpanded });
                                
                                if (isExpanded) {
                                    // Collapse
                                    $content.removeClass('expanded');
                                    $('.read-more-text').show();
                                    $('.read-less-text').hide();
                                    $('.read-more-icon').show();
                                    $('.read-less-icon').hide();
                                    $btn.removeClass('expanded');
                                    console.log('Content collapsed');
                                } else {
                                    // Expand
                                    $content.addClass('expanded');
                                    $('.read-more-text').hide();
                                    $('.read-less-text').show();
                                    $('.read-more-icon').hide();
                                    $('.read-less-icon').show();
                                    $btn.addClass('expanded');
                                    console.log('Content expanded');
                                    
                                    // Force reflow to ensure content is visible
                                    setTimeout(() => {
                                        $content.css('max-height', 'none');
                                        $content.css('overflow', 'visible');
                                        console.log('Content forced to expand');
                                    }, 100);
                                }
                            });
                        });
                        </script>
                    </div>
                </div>
                
                <!-- Specifications Tab -->
                <div id="specifications" class="tab-pane">
                    <div class="product-specifications">
                        <?php if (!empty($product_features)) : ?>
                            <h4>Đặc điểm nổi bật</h4>
                            <ul class="specs-list">
                                <?php 
                                $features_array = explode("\n", $product_features);
                                foreach ($features_array as $feature) {
                                    if (trim($feature)) {
                                        echo '<li>' . esc_html(trim($feature)) . '</li>';
                                    }
                                }
                                ?>
                            </ul>
                        <?php endif; ?>
                        
                        <!-- WooCommerce Product Attributes -->
                        <?php if ($product->has_attributes()) : ?>
                            <h4>Thông số chi tiết</h4>
                            <table class="product-attributes">
                                <?php foreach ($product->get_attributes() as $attribute) : ?>
                                    <tr>
                                        <td class="attribute-label"><?php echo wc_attribute_label($attribute->get_name()); ?></td>
                                        <td class="attribute-value"><?php echo $attribute->get_options()[0]; ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </table>
                        <?php endif; ?>
                    </div>
                </div>
                
                <!-- Reviews Tab -->
                <div id="reviews" class="tab-pane">
                    <div class="product-reviews">
                        
                        <!-- Reviews Summary -->
                        <div class="reviews-summary">
                            <div class="rating-overview">
                                <div class="overall-rating">
                                    <span class="rating-number">4.8</span>
                                    <div class="rating-stars">
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                    </div>
                                    <p class="rating-text">(<?php echo $product->get_review_count() ?: '24'; ?> đánh giá)</p>
                                </div>
                                <div class="rating-breakdown">
                                    <div class="rating-bar">
                                        <span>5 sao</span>
                                        <div class="bar"><div class="fill" style="width: 75%;"></div></div>
                                        <span>18</span>
                                    </div>
                                    <div class="rating-bar">
                                        <span>4 sao</span>
                                        <div class="bar"><div class="fill" style="width: 20%;"></div></div>
                                        <span>5</span>
                                    </div>
                                    <div class="rating-bar">
                                        <span>3 sao</span>
                                        <div class="bar"><div class="fill" style="width: 5%;"></div></div>
                                        <span>1</span>
                                    </div>
                                    <div class="rating-bar">
                                        <span>2 sao</span>
                                        <div class="bar"><div class="fill" style="width: 0%;"></div></div>
                                        <span>0</span>
                                    </div>
                                    <div class="rating-bar">
                                        <span>1 sao</span>
                                        <div class="bar"><div class="fill" style="width: 0%;"></div></div>
                                        <span>0</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Individual Reviews -->
                        <div class="reviews-list">
                            
                            <!-- Sample Review 1 -->
                            <div class="review-item">
                                <div class="review-header">
                                    <div class="reviewer-avatar">
                                        <div style="width: 50px; height: 50px; background: #007bff; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; font-weight: bold; font-size: 18px;">A</div>
                                    </div>
                                    <div class="reviewer-info">
                                        <h5 class="reviewer-name">Anh Tuấn</h5>
                                        <div class="review-rating">
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                        </div>
                                        <span class="review-date">2 ngày trước</span>
                                    </div>
                                </div>
                                <div class="review-content">
                                    <p>Sản phẩm rất tốt, chất lượng đúng như mô tả. Giao hàng nhanh, đóng gói cẩn thận. Sẽ tiếp tục ủng hộ shop!</p>
                                </div>
                                <div class="review-images">
                                    <div class="review-image">
                                        <div style="width: 80px; height: 80px; background: #f8f9fa; border-radius: 8px; display: flex; align-items: center; justify-content: center; border: 2px dashed #dee2e6;">
                                            <i class="fas fa-image" style="color: #6c757d;"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="review-actions">
                                    <button class="review-like">
                                        <i class="far fa-thumbs-up"></i> Hữu ích (12)
                                    </button>
                                </div>
                            </div>
                            
                            <!-- Sample Review 2 -->
                            <div class="review-item">
                                <div class="review-header">
                                    <div class="reviewer-avatar">
                                        <div style="width: 50px; height: 50px; background: #28a745; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; font-weight: bold; font-size: 18px;">M</div>
                                    </div>
                                    <div class="reviewer-info">
                                        <h5 class="reviewer-name">Mai Linh</h5>
                                        <div class="review-rating">
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                        </div>
                                        <span class="review-date">1 tuần trước</span>
                                    </div>
                                </div>
                                <div class="review-content">
                                    <p>Mình đã dùng sản phẩm này được 1 tháng rồi, rất hài lòng về chất lượng và hiệu suất. Đáng đồng tiền bát gạo!</p>
                                </div>
                                <div class="review-actions">
                                    <button class="review-like">
                                        <i class="far fa-thumbs-up"></i> Hữu ích (8)
                                    </button>
                                </div>
                            </div>
                            
                            <!-- Sample Review 3 -->
                            <div class="review-item">
                                <div class="review-header">
                                    <div class="reviewer-avatar">
                                        <div style="width: 50px; height: 50px; background: #dc3545; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; font-weight: bold; font-size: 18px;">H</div>
                                    </div>
                                    <div class="reviewer-info">
                                        <h5 class="reviewer-name">Hùng Nguyễn</h5>
                                        <div class="review-rating">
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="far fa-star"></i>
                                        </div>
                                        <span class="review-date">2 tuần trước</span>
                                    </div>
                                </div>
                                <div class="review-content">
                                    <p>Sản phẩm ổn, chỉ có điều giao hàng hơi chậm. Nhưng nhìn chung vẫn hài lòng với chất lượng.</p>
                                </div>
                                <div class="review-actions">
                                    <button class="review-like">
                                        <i class="far fa-thumbs-up"></i> Hữu ích (5)
                                    </button>
                                </div>
                            </div>
                            
                        </div>
                        
                        <!-- Load More Reviews -->
                        <div class="load-more-reviews">
                            <button class="btn-load-more">Xem thêm đánh giá</button>
                        </div>
                        
                        <?php
                        // Display WooCommerce reviews if available
                        if (comments_open()) {
                            echo '<div class="woocommerce-reviews-wrapper" style="display: none;">';
                            comments_template();
                            echo '</div>';
                        }
                        ?>
                    </div>
                </div>
                
                <!-- Warranty Tab -->
                <div id="warranty" class="tab-pane">
                    <div class="product-warranty">
                        <h4>Chính sách bảo hành</h4>
                        <ul>
                            <li>Bảo hành chính hãng 12 tháng</li>
                            <li>Bảo hành tại nhà</li>
                            <li>Hỗ trợ kỹ thuật 24/7</li>
                            <li>Đổi mới trong 7 ngày đầu</li>
                        </ul>
                        
                        <div class="warranty-contact">
                            <h5>Liên hệ bảo hành:</h5>
                            <p><i class="fas fa-phone"></i> <?php echo esc_html(get_theme_mod('scode_hotline', '0834.777.111')); ?></p>
                            <p><i class="fas fa-envelope"></i> <?php echo esc_html(get_theme_mod('scode_email', 'info@otnt.vn')); ?></p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</main>

<!-- Sticky Cart Bar -->
<div id="sticky-cart-bar" class="sticky-cart-bar">
    <div class="container">
        <div class="sticky-cart-content">
            <div class="sticky-product-info">
                <div class="sticky-product-image">
                    <?php if (has_post_thumbnail()) : ?>
                        <?php the_post_thumbnail('product-thumb', array('class' => 'sticky-img')); ?>
                    <?php endif; ?>
                </div>
                <div class="sticky-product-details">
                    <div class="sticky-product-title"><?php the_title(); ?></div>
                    <div class="sticky-product-price">
                        <?php if ($sale_price && $regular_price) : ?>
                            <span class="sticky-current-price"><?php echo number_format_i18n($sale_price, 0); ?>₫</span>
                            <span class="sticky-old-price"><?php echo number_format_i18n($regular_price, 0); ?>₫</span>
                        <?php else : ?>
                            <span class="sticky-current-price"><?php echo number_format_i18n($current_price, 0); ?>₫</span>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <div class="sticky-cart-actions">
                <button type="button" class="sticky-add-to-cart" data-product-id="<?php echo $product_id; ?>">
                    <i class="fas fa-shopping-cart"></i>
                    Thêm vào giỏ
                </button>
                <button type="button" class="sticky-buy-now">
                    <i class="fas fa-bolt"></i>
                    Mua ngay
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Lightbox Modal -->
<div id="lightbox-modal" class="lightbox-modal">
    <div class="lightbox-content">
        <button class="lightbox-close" aria-label="Đóng">
            <i class="fas fa-times"></i>
        </button>
        <img src="" alt="" class="lightbox-image">
        <div class="lightbox-nav">
            <button class="lightbox-prev" aria-label="Ảnh trước">
                <i class="fas fa-chevron-left"></i>
            </button>
            <button class="lightbox-next" aria-label="Ảnh tiếp">
                <i class="fas fa-chevron-right"></i>
            </button>
        </div>
    </div>
</div>

<!-- Video Modal -->
<div id="video-modal" class="video-modal">
    <div class="video-modal-content">
        <button class="video-modal-close" aria-label="Đóng">
            <i class="fas fa-times"></i>
        </button>
        <div class="video-container">
            <iframe src="" frameborder="0" allowfullscreen></iframe>
        </div>
    </div>
</div>

<?php endwhile; ?>
