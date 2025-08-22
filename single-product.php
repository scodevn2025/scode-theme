<?php
/**
 * Single Product Template - Professional E-commerce Layout
 * 
 * @package SCODE_Theme
 * @version 2.0.0
 */

get_header(); ?>

<main class="main-content single-product-page" id="main-content">
    <div class="container">
        
        <?php while (have_posts()) : the_post(); ?>
            <?php if (class_exists('WooCommerce')) : ?>
                <?php global $product; ?>
                
                <!-- Breadcrumb -->
                <nav class="breadcrumb">
                    <div class="breadcrumb-container">
                        <a href="<?php echo home_url(); ?>">Trang chủ</a>
                        <span class="separator">/</span>
                        <a href="<?php echo get_permalink(wc_get_page_id('shop')); ?>">Sản phẩm</a>
                        <span class="separator">/</span>
                        <span class="current"><?php the_title(); ?></span>
                    </div>
                </nav>

                <!-- Main Product Layout - 2 Columns -->
                <div class="product-main-layout">
                    
                    <!-- Left Column: Media Gallery (60%) -->
                    <div class="product-gallery-column">
                        <div class="product-gallery-wrapper">
                            
                            <!-- Main Image Display -->
                            <div class="main-image-container">
                                <?php if (has_post_thumbnail()) : ?>
                                    <div class="main-image active" data-index="0">
                                        <img src="<?php echo get_the_post_thumbnail_url(get_the_ID(), 'full'); ?>" 
                                             alt="<?php the_title_attribute(); ?>" 
                                             class="product-main-img"
                                             data-zoom="<?php echo get_the_post_thumbnail_url(get_the_ID(), 'full'); ?>">
                                        
                                        <!-- MI VIETNAM.VN Watermark -->
                                        <div class="brand-watermark">
                                            <span>MI VIETNAM.VN</span>
                                        </div>
                                        
                                        <!-- Zoom Icon -->
                                        <div class="zoom-trigger">
                                            <i class="fas fa-search-plus"></i>
                                        </div>
                                    </div>
                                <?php endif; ?>
                                
                                <?php
                                $attachment_ids = $product->get_gallery_image_ids();
                                $image_index = 1;
                                foreach ($attachment_ids as $attachment_id) :
                                    $image_url = wp_get_attachment_url($attachment_id);
                                ?>
                                    <div class="main-image" data-index="<?php echo $image_index; ?>">
                                        <img src="<?php echo $image_url; ?>" 
                                             alt="<?php echo get_post_meta($attachment_id, '_wp_attachment_image_alt', true); ?>" 
                                             class="product-main-img"
                                             data-zoom="<?php echo $image_url; ?>">
                                        
                                        <!-- MI VIETNAM.VN Watermark -->
                                        <div class="brand-watermark">
                                            <span>MI VIETNAM.VN</span>
                                        </div>
                                        
                                        <!-- Zoom Icon -->
                                        <div class="zoom-trigger">
                                            <i class="fas fa-search-plus"></i>
                                        </div>
                                    </div>
                                <?php 
                                    $image_index++;
                                endforeach; 
                                ?>
                                
                                <!-- Video Thumbnails from ACF -->
                                <?php 
                                $marketing_media = get_field('marketing_media');
                                if ($marketing_media && isset($marketing_media['youtube_urls'])) :
                                    foreach ($marketing_media['youtube_urls'] as $video_url) :
                                        $video_id = preg_replace('~^.*/([^/?#]+).*$~', '$1', $video_url);
                                        $video_thumb = 'https://img.youtube.com/vi/' . $video_id . '/hqdefault.jpg';
                                ?>
                                    <div class="main-image video-main" data-index="<?php echo $image_index; ?>" data-video="<?php echo esc_attr($video_url); ?>">
                                        <img src="<?php echo $video_thumb; ?>" 
                                             alt="Video sản phẩm" 
                                             class="product-main-img">
                                        
                                        <!-- Video Play Button -->
                                        <div class="video-play-overlay">
                                            <i class="fas fa-play-circle"></i>
                                        </div>
                                        
                                        <!-- MI VIETNAM.VN Watermark -->
                                        <div class="brand-watermark">
                                            <span>MI VIETNAM.VN</span>
                                        </div>
                                    </div>
                                <?php 
                                        $image_index++;
                                    endforeach;
                                endif; 
                                ?>
                            </div>
                            
                            <!-- Thumbnail Gallery Strip -->
                            <div class="thumbnail-gallery-strip">
                                <div class="thumb-nav left">
                                    <i class="fas fa-chevron-left"></i>
                                </div>
                                
                                <div class="thumbnails-container">
                                    <?php if (has_post_thumbnail()) : ?>
                                        <div class="thumb-item active" data-index="0">
                                            <img src="<?php echo get_the_post_thumbnail_url(get_the_ID(), 'medium'); ?>" 
                                                 alt="<?php the_title_attribute(); ?>">
                                        </div>
                                    <?php endif; ?>
                                    
                                    <?php 
                                    $thumb_index = 1;
                                    foreach ($attachment_ids as $attachment_id) : ?>
                                        <div class="thumb-item" data-index="<?php echo $thumb_index; ?>">
                                            <img src="<?php echo wp_get_attachment_image_url($attachment_id, 'medium'); ?>" 
                                                 alt="<?php echo get_post_meta($attachment_id, '_wp_attachment_image_alt', true); ?>">
                                        </div>
                                    <?php 
                                        $thumb_index++;
                                    endforeach; 
                                    ?>
                                    
                                    <!-- Video Thumbnails -->
                                    <?php 
                                    if ($marketing_media && isset($marketing_media['youtube_urls'])) :
                                        foreach ($marketing_media['youtube_urls'] as $video_url) :
                                            $video_id = preg_replace('~^.*/([^/?#]+).*$~', '$1', $video_url);
                                            $video_thumb = 'https://img.youtube.com/vi/' . $video_id . '/mqdefault.jpg';
                                    ?>
                                        <div class="thumb-item video-thumb" data-index="<?php echo $thumb_index; ?>" data-video="<?php echo esc_attr($video_url); ?>">
                                            <img src="<?php echo $video_thumb; ?>" alt="Video sản phẩm">
                                            <div class="video-indicator">
                                                <i class="fas fa-play"></i>
                                            </div>
                                        </div>
                                    <?php 
                                            $thumb_index++;
                                        endforeach;
                                    endif; 
                                    ?>
                                </div>
                                
                                <div class="thumb-nav right">
                                    <i class="fas fa-chevron-right"></i>
                                </div>
                            </div>
                            
                        </div>
                    </div>
                    
                    <!-- Right Column: Purchase Summary (40%) -->
                    <div class="product-summary-column">
                        <div class="product-summary-wrapper">
                            
                            <!-- Brand & Series Info -->
                            <div class="brand-series-info">
                                <?php 
                                $brand = get_field('brand') ?: 'Thương hiệu: ' . wc_get_product_category_list($product->get_id(), ' | ');
                                $series = get_field('series');
                                ?>
                                <div class="brand-info">
                                    <span class="brand-label">Thương hiệu:</span>
                                    <span class="brand-value"><?php echo $brand; ?></span>
                                </div>
                                <?php if ($series) : ?>
                                    <div class="series-info">
                                        <span class="series-label">Series:</span>
                                        <span class="series-value"><?php echo esc_html($series); ?></span>
                                    </div>
                                <?php endif; ?>
                            </div>
                            
                            <!-- Product Title -->
                            <h1 class="product-title"><?php the_title(); ?></h1>
                            
                            <!-- Product Rating -->
                            <div class="product-rating-section">
                                <?php if ($product->get_average_rating()) : ?>
                                    <div class="rating-stars">
                                        <?php echo wc_get_rating_html($product->get_average_rating()); ?>
                                    </div>
                                    <span class="rating-count">(<?php echo $product->get_review_count(); ?> đánh giá)</span>
                                <?php else : ?>
                                    <div class="rating-stars">
                                        <i class="far fa-star"></i>
                                        <i class="far fa-star"></i>
                                        <i class="far fa-star"></i>
                                        <i class="far fa-star"></i>
                                        <i class="far fa-star"></i>
                                    </div>
                                    <span class="rating-count">(0 đánh giá)</span>
                                <?php endif; ?>
                            </div>
                            
                            <!-- Product Badges -->
                            <div class="product-badges-section">
                                <?php
                                $product_id = $product->get_id();
                                $regular_price = $product->get_regular_price();
                                $sale_price = $product->get_sale_price();
                                
                                // Calculate discount percentage
                                if ($regular_price && $sale_price) {
                                    $discount_percentage = round((($regular_price - $sale_price) / $regular_price) * 100);
                                    if ($discount_percentage > 0) : ?>
                                        <span class="badge discount-badge">Tiết kiệm <?php echo $discount_percentage; ?>%</span>
                                    <?php endif;
                                }
                                
                                // Custom badges
                                if (get_post_meta($product_id, '_is_new', true)) : ?>
                                    <span class="badge new-badge">MỚI</span>
                                <?php endif;
                                
                                if (get_post_meta($product_id, '_is_premium', true)) : ?>
                                    <span class="badge premium-badge">CAO CẤP</span>
                                <?php endif;
                                
                                if (get_post_meta($product_id, '_is_global', true)) : ?>
                                    <span class="badge global-badge">Global Version</span>
                                <?php endif;
                                
                                if (get_post_meta($product_id, '_is_genuine', true)) : ?>
                                    <span class="badge genuine-badge">100% CHÍNH HÃNG</span>
                                <?php endif; ?>
                            </div>
                            
                            <!-- Product Price Section -->
                            <div class="product-price-section">
                                <?php if ($sale_price && $regular_price) : ?>
                                    <div class="current-price"><?php echo scode_format_price($sale_price); ?></div>
                                    <div class="old-price"><?php echo scode_format_price($regular_price); ?></div>
                                    <div class="save-amount">Tiết kiệm: <?php echo scode_format_price($regular_price - $sale_price); ?></div>
                                <?php else : ?>
                                    <div class="current-price"><?php echo scode_format_price($product->get_price()); ?></div>
                                <?php endif; ?>
                            </div>
                            
                            <!-- Flash Sale Countdown -->
                            <?php 
                            $promo_deadline = get_field('promo_deadline');
                            if ($promo_deadline) : ?>
                                <div class="flash-sale-countdown" data-deadline="<?php echo esc_attr($promo_deadline); ?>">
                                    <div class="countdown-label">ƯU ĐÃI MỞ BÁN</div>
                                    <div class="countdown-timer">
                                        <div class="time-unit">
                                            <span class="time-value" id="countdown-hours">00</span>
                                            <span class="time-label">Giờ</span>
                                        </div>
                                        <div class="time-separator">:</div>
                                        <div class="time-unit">
                                            <span class="time-value" id="countdown-minutes">00</span>
                                            <span class="time-label">Phút</span>
                                        </div>
                                        <div class="time-separator">:</div>
                                        <div class="time-unit">
                                            <span class="time-value" id="countdown-seconds">00</span>
                                            <span class="time-label">Giây</span>
                                        </div>
                                    </div>
                                </div>
                            <?php endif; ?>
                            
                            <!-- Gifts/Combo Section -->
                            <?php 
                            $gifts = get_field('gifts');
                            if ($gifts && is_array($gifts)) : ?>
                                <div class="gifts-section">
                                    <div class="gifts-title">
                                        <i class="fas fa-gift"></i>
                                        <span>Quà tặng kèm</span>
                                    </div>
                                    <div class="gifts-list">
                                        <?php foreach ($gifts as $gift) : ?>
                                            <div class="gift-item">
                                                <?php if ($gift['gift_image']) : ?>
                                                    <div class="gift-image">
                                                        <img src="<?php echo wp_get_attachment_image_url($gift['gift_image'], 'thumbnail'); ?>" 
                                                             alt="<?php echo esc_attr($gift['gift_title']); ?>">
                                                    </div>
                                                <?php endif; ?>
                                                <div class="gift-info">
                                                    <div class="gift-title"><?php echo esc_html($gift['gift_title']); ?></div>
                                                    <?php if ($gift['gift_note']) : ?>
                                                        <div class="gift-note"><?php echo esc_html($gift['gift_note']); ?></div>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                            <?php endif; ?>
                            
                            <!-- Trust Policies Section -->
                            <div class="trust-policies-section">
                                <?php 
                                $policies = get_field('policies');
                                if ($policies && is_array($policies)) :
                                    foreach ($policies as $policy) : ?>
                                        <div class="policy-item">
                                            <i class="fas fa-<?php echo esc_attr($policy['icon']); ?>"></i>
                                            <span><?php echo esc_html($policy['text']); ?></span>
                                        </div>
                                    <?php endforeach;
                                else : ?>
                                    <!-- Default policies -->
                                    <div class="policy-item">
                                        <i class="fas fa-truck"></i>
                                        <span>Giao nhanh 2-4h nội thành</span>
                                    </div>
                                    <div class="policy-item">
                                        <i class="fas fa-undo"></i>
                                        <span>Đổi mới 7 ngày</span>
                                    </div>
                                    <div class="policy-item">
                                        <i class="fas fa-shield-alt"></i>
                                        <span>Bảo hành tại nhà</span>
                                    </div>
                                    <div class="policy-item">
                                        <i class="fas fa-credit-card"></i>
                                        <span>Hỗ trợ trả góp 0%</span>
                                    </div>
                                    <div class="policy-item">
                                        <i class="fas fa-exchange-alt"></i>
                                        <span>Lỗi 1 đổi 1</span>
                                    </div>
                                <?php endif; ?>
                            </div>
                            
                            <!-- Product Form -->
                            <form class="cart" action="<?php echo esc_url(apply_filters('woocommerce_add_to_cart_form_action', $product->get_permalink())); ?>" method="post" enctype='multipart/form-data'>
                                
                                <!-- Quantity Section -->
                                <div class="quantity-section">
                                    <label for="quantity">Số lượng:</label>
                                    <div class="quantity-controls">
                                        <button type="button" class="qty-btn minus">-</button>
                                        <input type="number" 
                                               id="quantity" 
                                               class="input-text qty text" 
                                               step="1" 
                                               min="1" 
                                               max="<?php echo $product->get_max_purchase_quantity(); ?>" 
                                               name="quantity" 
                                               value="1" 
                                               title="Qty" 
                                               inputmode="numeric">
                                        <button type="button" class="qty-btn plus">+</button>
                                    </div>
                                </div>
                                
                                <!-- CTA Buttons Section -->
                                <div class="cta-buttons-section">
                                    <button type="submit" 
                                            name="add-to-cart" 
                                            value="<?php echo esc_attr($product->get_id()); ?>" 
                                            class="cta-button add-to-cart-btn">
                                        <i class="fas fa-shopping-cart"></i>
                                        <span>THÊM VÀO GIỎ</span>
                                    </button>
                                    
                                    <button type="button" class="cta-button buy-now-btn">
                                        <i class="fas fa-bolt"></i>
                                        <span>MUA NGAY</span>
                                    </button>
                                    
                                    <?php 
                                    $installment_enabled = get_field('installment_enabled');
                                    if ($installment_enabled) : ?>
                                        <button type="button" class="cta-button installment-btn">
                                            <i class="fas fa-credit-card"></i>
                                            <span>TRẢ GÓP 0%</span>
                                        </button>
                                    <?php endif; ?>
                                </div>
                                
                                <!-- Hotline/Consultant Box -->
                                <div class="consultant-box">
                                    <div class="consultant-avatar">
                                        <?php 
                                        $hotline_avatar = get_field('hotline_block')['avatar'];
                                        if ($hotline_avatar) : ?>
                                            <img src="<?php echo wp_get_attachment_image_url($hotline_avatar, 'thumbnail'); ?>" 
                                                 alt="Tư vấn viên">
                                        <?php else : ?>
                                            <div class="avatar-placeholder">
                                                <i class="fas fa-user"></i>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                    <div class="consultant-info">
                                        <div class="consultant-name">
                                            <?php echo get_field('hotline_block')['name'] ?: 'Ms. Thảo'; ?>
                                        </div>
                                        <div class="consultant-phone">
                                            <i class="fas fa-phone"></i>
                                            <span><?php echo get_field('hotline_block')['phone'] ?: '0834.777.111'; ?></span>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Shipping Badges -->
                                <div class="shipping-badges">
                                    <span class="shipping-badge free-shipping">
                                        <i class="fas fa-shipping-fast"></i>
                                        Miễn phí ship nội thành
                                    </span>
                                    <span class="shipping-badge check-before">
                                        <i class="fas fa-eye"></i>
                                        Kiểm tra hàng trước khi nhận
                                    </span>
                                </div>
                                
                            </form>
                            
                        </div>
                    </div>
                    
                </div>
                
                <!-- Right Sidebar: Related Products -->
                <div class="related-products-sidebar">
                    <h3 class="sidebar-title">SẢN PHẨM LIÊN QUAN</h3>
                    <div class="related-products-list">
                        <?php
                        $related_ids = wc_get_related_products($product->get_id(), 6);
                        if ($related_ids) :
                            foreach ($related_ids as $related_id) :
                                $related_product = wc_get_product($related_id);
                                if ($related_product) :
                        ?>
                            <div class="related-product-card">
                                <div class="product-image">
                                    <a href="<?php echo get_permalink($related_id); ?>">
                                        <?php echo get_the_post_thumbnail($related_id, 'thumbnail', array('class' => 'product-img')); ?>
                                    </a>
                                </div>
                                <div class="product-info">
                                    <h4 class="product-title">
                                        <a href="<?php echo get_permalink($related_id); ?>">
                                            <?php echo get_the_title($related_id); ?>
                                        </a>
                                    </h4>
                                    <div class="product-price">
                                        <?php echo $related_product->get_price_html(); ?>
                                    </div>
                                </div>
                            </div>
                        <?php 
                                endif;
                            endforeach;
                        endif; 
                        ?>
                    </div>
                </div>
                
                <!-- Full Width Sections Below -->
                
                <!-- Product Tabs Section -->
                <div class="product-tabs-section">
                    <div class="tabs-nav">
                        <button class="tab-btn active" data-tab="description">MÔ TẢ / TÍNH NĂNG</button>
                        <button class="tab-btn" data-tab="techspecs">THÔNG SỐ KỸ THUẬT</button>
                        <button class="tab-btn" data-tab="reviews">ĐÁNH GIÁ (<?php echo $product->get_review_count(); ?>)</button>
                    </div>
                    
                    <div class="tabs-content">
                        <div class="tab-pane active" id="description">
                            <div class="product-description">
                                <?php the_content(); ?>
                                
                                <!-- Marketing Media Section -->
                                <?php if ($marketing_media) : ?>
                                    <div class="marketing-media-section">
                                        <!-- Banners -->
                                        <?php if (isset($marketing_media['banners']) && is_array($marketing_media['banners'])) : ?>
                                            <div class="marketing-banners">
                                                <?php foreach ($marketing_media['banners'] as $banner) : ?>
                                                    <div class="marketing-banner">
                                                        <img src="<?php echo wp_get_attachment_image_url($banner, 'full'); ?>" 
                                                             alt="Marketing banner">
                                                    </div>
                                                <?php endforeach; ?>
                                            </div>
                                        <?php endif; ?>
                                        
                                        <!-- Videos -->
                                        <?php if (isset($marketing_media['youtube_urls']) && is_array($marketing_media['youtube_urls'])) : ?>
                                            <div class="marketing-videos">
                                                <h3>Công nghệ nổi bật</h3>
                                                <div class="video-grid">
                                                    <?php foreach ($marketing_media['youtube_urls'] as $video_url) : ?>
                                                        <div class="video-item">
                                                            <?php 
                                                            $video_id = preg_replace('~^.*/([^/?#]+).*$~', '$1', $video_url);
                                                            $embed_url = 'https://www.youtube.com/embed/' . $video_id;
                                                            ?>
                                                            <div class="video-container">
                                                                <iframe src="<?php echo $embed_url; ?>" 
                                                                        frameborder="0" 
                                                                        allowfullscreen>
                                                                </iframe>
                                                            </div>
                                                        </div>
                                                    <?php endforeach; ?>
                                                </div>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                        
                        <div class="tab-pane" id="techspecs">
                            <div class="techspecs-section">
                                <?php
                                $techspecs = get_field('techspecs');
                                if ($techspecs && is_array($techspecs)) : ?>
                                    <div class="specs-grid">
                                        <?php foreach ($techspecs as $spec) : ?>
                                            <div class="spec-item">
                                                <span class="spec-label"><?php echo esc_html($spec['label']); ?></span>
                                                <strong class="spec-value"><?php echo esc_html($spec['value']); ?></strong>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                <?php else : ?>
                                    <p>Không có thông số kỹ thuật cho sản phẩm này.</p>
                                <?php endif; ?>
                            </div>
                        </div>
                        
                        <div class="tab-pane" id="reviews">
                            <div class="reviews-section">
                                <?php comments_template(); ?>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Sticky Add to Cart Bar -->
                <div class="sticky-cart-bar" id="sticky-cart-bar">
                    <div class="sticky-cart-content">
                        <div class="sticky-product-info">
                            <div class="sticky-product-image">
                                <?php if (has_post_thumbnail()) : ?>
                                    <?php echo get_the_post_thumbnail($product->get_id(), 'thumbnail'); ?>
                                <?php endif; ?>
                            </div>
                            <div class="sticky-product-details">
                                <h4 class="sticky-product-title"><?php the_title(); ?></h4>
                                <div class="sticky-product-price">
                                    <?php if ($sale_price && $regular_price) : ?>
                                        <span class="sticky-current-price"><?php echo scode_format_price($sale_price); ?></span>
                                        <span class="sticky-old-price"><?php echo scode_format_price($regular_price); ?></span>
                                    <?php else : ?>
                                        <span class="sticky-current-price"><?php echo scode_format_price($product->get_price()); ?></span>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                        <div class="sticky-cart-actions">
                            <button type="button" class="sticky-add-to-cart">
                                <i class="fas fa-shopping-cart"></i>
                                <span>THÊM VÀO GIỎ</span>
                            </button>
                            <button type="button" class="sticky-buy-now">
                                <i class="fas fa-bolt"></i>
                                <span>MUA NGAY</span>
                            </button>
                        </div>
                    </div>
                </div>
                
            <?php else : ?>
                <div class="woocommerce-not-active">
                    <p>WooCommerce plugin không được kích hoạt.</p>
                </div>
            <?php endif; ?>
            
        <?php endwhile; ?>
        
    </div>
</main>

<!-- Lightbox Modal for Image Zoom -->
<div class="lightbox-modal" id="lightbox-modal">
    <div class="lightbox-content">
        <button class="lightbox-close">&times;</button>
        <img src="" alt="" class="lightbox-image">
        <div class="lightbox-nav">
            <button class="lightbox-prev">&lt;</button>
            <button class="lightbox-next">&gt;</button>
        </div>
    </div>
</div>

<!-- Video Modal -->
<div class="video-modal" id="video-modal">
    <div class="video-modal-content">
        <button class="video-modal-close">&times;</button>
        <div class="video-container">
            <iframe src="" frameborder="0" allowfullscreen></iframe>
        </div>
    </div>
</div>

<?php get_footer(); ?>
