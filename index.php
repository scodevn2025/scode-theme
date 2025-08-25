<?php
/**
 * The main template file
 * 
 * @package SCODE_Theme
 * @version 1.0.0
 */

get_header(); ?>

<!-- Main Content -->
<main class="main-content" id="main-content">
    <div class="container">
        
        <!-- Enhanced Icons Row Section -->
        <section class="icons-row">
            <div class="container">
                <div class="section-header text-center">
                    <h2 class="section-title">Dịch vụ của chúng tôi</h2>
                    <p class="section-subtitle">Cam kết chất lượng và dịch vụ tốt nhất</p>
                </div>
                
                <div class="icons-grid">
                    <div class="icon-item" data-aos="fade-up" data-aos-delay="100">
                        <div class="icon-wrapper">
                            <i class="fas fa-truck"></i>
                        </div>
                        <h4>Giao hàng nhanh</h4>
                        <p>2-4h nội thành, 1-2 ngày toàn quốc</p>
                        <div class="icon-features">
                            <span class="feature-tag">Miễn phí</span>
                            <span class="feature-tag">COD</span>
                        </div>
                    </div>
                    
                    <div class="icon-item" data-aos="fade-up" data-aos-delay="200">
                        <div class="icon-wrapper">
                            <i class="fas fa-shield-alt"></i>
                        </div>
                        <h4>Bảo hành chính hãng</h4>
                        <p>Đổi mới 7 ngày, bảo hành theo tiêu chuẩn</p>
                        <div class="icon-features">
                            <span class="feature-tag">Chính hãng</span>
                            <span class="feature-tag">12-24 tháng</span>
                        </div>
                    </div>
                    
                    <div class="icon-item" data-aos="fade-up" data-aos-delay="300">
                        <div class="icon-wrapper">
                            <i class="fas fa-credit-card"></i>
                        </div>
                        <h4>Trả góp 0%</h4>
                        <p>Qua thẻ tín dụng và ứng dụng ngân hàng</p>
                        <div class="icon-features">
                            <span class="feature-tag">0% lãi suất</span>
                            <span class="feature-tag">Thủ tục đơn giản</span>
                        </div>
                    </div>
                    
                    <div class="icon-item" data-aos="fade-up" data-aos-delay="400">
                        <div class="icon-wrapper">
                            <i class="fas fa-headset"></i>
                        </div>
                        <h4>Hỗ trợ 24/7</h4>
                        <p>Hotline: <?php echo esc_html(get_theme_mod('scode_hotline', '0834.777.111')); ?></p>
                        <div class="icon-features">
                            <span class="feature-tag">24/7</span>
                            <span class="feature-tag">Tư vấn miễn phí</span>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Enhanced Flash Sale Section -->
        <?php if (class_exists('WooCommerce')) : ?>
        <section class="product-section flash-sale-section">
            <div class="section-header">
                <div class="section-title-wrapper">
                    <h2 class="section-title">
                        <i class="fas fa-bolt"></i>
                        FLASH SALE
                    </h2>
                    <div class="flash-sale-countdown" data-deadline="<?php echo date('Y-m-d H:i:s', strtotime('+24 hours')); ?>">
                        <div class="countdown-item">
                            <span class="countdown-number" id="countdown-hours">24</span>
                            <span class="countdown-label">Giờ</span>
                        </div>
                        <div class="countdown-separator">:</div>
                        <div class="countdown-item">
                            <span class="countdown-number" id="countdown-minutes">00</span>
                            <span class="countdown-label">Phút</span>
                        </div>
                        <div class="countdown-separator">:</div>
                        <div class="countdown-item">
                            <span class="countdown-number" id="countdown-seconds">00</span>
                            <span class="countdown-label">Giây</span>
                        </div>
                    </div>
                </div>
                <a href="<?php echo home_url('/khuyen-mai/flash-sale'); ?>" class="view-all">
                    <i class="fas fa-arrow-right"></i>
                    Xem tất cả
                </a>
            </div>
            
            <?php
            $flash_sale_products = scode_get_sale_products(10);
            if ($flash_sale_products->have_posts()) :
            ?>
                <div class="products-grid cols-5">
                    <?php while ($flash_sale_products->have_posts()) : $flash_sale_products->the_post(); 
                        global $product;
                    ?>
                        <article class="mi-card">
                            <div class="mi-media">
                                <?php 
                                // Calculate discount percentage
                                $regular_price = $product->get_regular_price();
                                $sale_price = $product->get_sale_price();
                                $discount_percent = 0;
                                
                                if ($regular_price && $sale_price && $regular_price > $sale_price) {
                                    $discount_percent = round((($regular_price - $sale_price) / $regular_price) * 100);
                                }
                                
                                // Check if product has special tags
                                $has_coupon = has_term('coupon', 'product_tag', $product->get_id()) || 
                                             has_term('flash-sale', 'product_tag', $product->get_id()) ||
                                             has_term('khuyen-mai', 'product_tag', $product->get_id());
                                ?>
                                
                                <?php if ($discount_percent > 0) : ?>
                                    <span class="mi-badge-off"><?php echo $discount_percent; ?>%</span>
                                <?php endif; ?>
                                
                                <?php if (has_post_thumbnail()) : ?>
                                    <a href="<?php the_permalink(); ?>">
                                        <?php the_post_thumbnail('product-thumb', array('class' => 'product-img')); ?>
                                    </a>
                                <?php endif; ?>
                                
                                <?php if ($has_coupon) : ?>
                                    <span class="mi-ribbon">MÃ GIẢM GIÁ</span>
                                <?php endif; ?>
                            </div>

                            <h3 class="mi-title">
                                <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                            </h3>

                            <div class="mi-price">
                                <?php if ($product->is_on_sale()) : ?>
                                    <span class="mi-price-sale">
                                        <?php echo number_format_i18n($sale_price, 0); ?>
                                        <span class="cur">đ</span>
                                    </span>
                                    <span class="mi-price-regular">
                                        <?php echo number_format_i18n($regular_price, 0); ?>đ
                                    </span>
                                <?php else : ?>
                                    <span class="mi-price-sale">
                                        <?php echo number_format_i18n($product->get_price(), 0); ?>
                                        <span class="cur">đ</span>
                                    </span>
                                <?php endif; ?>
                            </div>
                        </article>
                    <?php endwhile; wp_reset_postdata(); ?>
                </div>
            <?php else : ?>
                <div class="no-products">
                    <p>Chưa có sản phẩm khuyến mãi nào.</p>
                </div>
            <?php endif; ?>
        </section>
        <?php endif; ?>

        <!-- Enhanced Mid Banner 1 -->
        <section class="banner-wide">
            <div class="container">
                <a href="<?php echo home_url('/khuyen-mai'); ?>" class="promo-banner">
                    <div class="banner-content">
                        <div class="banner-left">
                            <div class="banner-icon">
                                <i class="fas fa-tags"></i>
                            </div>
                            <div class="banner-text">
                                <h3>KHUYẾN MÃI ĐẶC BIỆT</h3>
                                <p>Giảm giá lên đến 50% cho các sản phẩm công nghệ</p>
                                <div class="banner-features">
                                    <span class="feature-badge">Flash Sale</span>
                                    <span class="feature-badge">Miễn phí vận chuyển</span>
                                    <span class="feature-badge">Tặng quà hấp dẫn</span>
                                </div>
                            </div>
                        </div>
                        <div class="banner-right">
                            <div class="banner-cta">
                                <span class="cta-text">Xem ngay</span>
                                <i class="fas fa-arrow-right"></i>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        </section>

        <!-- Featured Products Section -->
        <section class="product-section featured-products">
            <div class="container">
                <div class="section-header">
                    <h2 class="section-title">SẢN PHẨM NỔI BẬT</h2>
                    <a href="<?php echo home_url('/san-pham-noi-bat'); ?>" class="view-all">Xem tất cả</a>
                </div>
                
                <?php if (class_exists('WooCommerce')) : ?>
                    <?php
                    $featured_products = scode_get_featured_products(6);
                    if ($featured_products->have_posts()) :
                    ?>
                        <div class="products-grid cols-6">
                            <?php
                            while ($featured_products->have_posts()) : $featured_products->the_post();
                                global $product;
                                $product_id = $product->get_id();
                                $regular_price = $product->get_regular_price();
                                $sale_price = $product->get_sale_price();
                                $current_price = $product->get_price();
                                
                                // Calculate discount percentage
                                $discount_percentage = 0;
                                if ($regular_price && $sale_price) {
                                    $discount_percentage = round((($regular_price - $sale_price) / $regular_price) * 100);
                                }
                                
                                // Get product badges
                                $is_new = get_post_meta($product_id, '_is_new', true);
                                $is_premium = get_post_meta($product_id, '_is_premium', true);
                                $is_global = get_post_meta($product_id, '_is_global', true);
                                $is_genuine = get_post_meta($product_id, '_is_genuine', true);
                                
                                // Get product features
                                $product_features = get_post_meta($product_id, '_product_features', true);
                                $gift_value = get_post_meta($product_id, '_gift_value', true);
                                $free_shipping = get_post_meta($product_id, '_free_shipping', true);
                            ?>
                                <article class="mi-card">
                                    <div class="mi-media">
                                        <?php 
                                        // Calculate discount percentage
                                        $discount_percent = 0;
                                        if ($regular_price && $sale_price && $regular_price > $sale_price) {
                                            $discount_percent = round((($regular_price - $sale_price) / $regular_price) * 100);
                                        }
                                        
                                        // Check if product has special tags
                                        $has_coupon = has_term('coupon', 'product_tag', $product_id) || 
                                                     has_term('flash-sale', 'product_tag', $product_id) ||
                                                     has_term('khuyen-mai', 'product_tag', $product_id);
                                        ?>
                                        
                                        <?php if ($discount_percent > 0) : ?>
                                            <span class="mi-badge-off"><?php echo $discount_percent; ?>%</span>
                                        <?php endif; ?>
                                        
                                        <?php if (has_post_thumbnail()) : ?>
                                            <a href="<?php the_permalink(); ?>">
                                                <?php the_post_thumbnail('product-thumb', array('class' => 'product-img')); ?>
                                            </a>
                                        <?php endif; ?>
                                        
                                        <?php if ($has_coupon) : ?>
                                            <span class="mi-ribbon">MÃ GIẢM GIÁ</span>
                                        <?php endif; ?>
                                    </div>

                                    <h3 class="mi-title">
                                        <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                    </h3>

                                    <div class="mi-price">
                                        <?php if ($sale_price && $regular_price) : ?>
                                            <span class="mi-price-sale">
                                                <?php echo number_format_i18n($sale_price, 0); ?>
                                                <span class="cur">đ</span>
                                            </span>
                                            <span class="mi-price-regular">
                                                <?php echo number_format_i18n($regular_price, 0); ?>đ
                                            </span>
                                        <?php else : ?>
                                            <span class="mi-price-sale">
                                                <?php echo number_format_i18n($current_price, 0); ?>
                                                <span class="cur">đ</span>
                                            </span>
                                        <?php endif; ?>
                                    </div>
                                </article>
                            <?php endwhile; ?>
                        </div>
                        <?php wp_reset_postdata(); ?>
                    <?php else : ?>
                        <div class="no-products">
                            <p>Chưa có sản phẩm nổi bật nào.</p>
                        </div>
                    <?php endif; ?>
                <?php endif; ?>
            </div>
        </section>

        <!-- Best Sellers Section -->
        <?php if (class_exists('WooCommerce')) : ?>
        <section class="product-section">
            <div class="section-header">
                <h2 class="section-title">Bán chạy</h2>
                <a href="<?php echo home_url('/ban-chay'); ?>" class="view-all">Xem tất cả</a>
            </div>
            
            <?php
            $best_sellers = scode_get_best_selling_products(12);
            if ($best_sellers->have_posts()) :
            ?>
                <div class="products-grid cols-6">
                    <?php while ($best_sellers->have_posts()) : $best_sellers->the_post(); 
                        global $product;
                    ?>
                        <article class="mi-card">
                            <div class="mi-media">
                                <?php 
                                // Calculate discount percentage
                                $regular_price = $product->get_regular_price();
                                $sale_price = $product->get_sale_price();
                                $discount_percent = 0;
                                
                                if ($regular_price && $sale_price && $regular_price > $sale_price) {
                                    $discount_percent = round((($regular_price - $sale_price) / $regular_price) * 100);
                                }
                                
                                // Check if product has special tags
                                $has_coupon = has_term('coupon', 'product_tag', $product->get_id()) || 
                                             has_term('flash-sale', 'product_tag', $product->get_id()) ||
                                             has_term('khuyen-mai', 'product_tag', $product->get_id());
                                ?>
                                
                                <?php if ($discount_percent > 0) : ?>
                                    <span class="mi-badge-off"><?php echo $discount_percent; ?>%</span>
                                <?php endif; ?>
                                
                                <?php if (has_post_thumbnail()) : ?>
                                    <a href="<?php the_permalink(); ?>">
                                        <?php the_post_thumbnail('product-thumb', array('class' => 'product-img')); ?>
                                    </a>
                                <?php endif; ?>
                                
                                <?php if ($has_coupon) : ?>
                                    <span class="mi-ribbon">MÃ GIẢM GIÁ</span>
                                <?php endif; ?>
                            </div>

                            <h3 class="mi-title">
                                <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                            </h3>

                            <div class="mi-price">
                                <?php if ($product->is_on_sale()) : ?>
                                    <span class="mi-price-sale">
                                        <?php echo number_format_i18n($sale_price, 0); ?>
                                        <span class="cur">đ</span>
                                    </span>
                                    <span class="mi-price-regular">
                                        <?php echo number_format_i18n($regular_price, 0); ?>đ
                                    </span>
                                <?php else : ?>
                                    <span class="mi-price-sale">
                                        <?php echo number_format_i18n($product->get_price(), 0); ?>
                                        <span class="cur">đ</span>
                                    </span>
                                <?php endif; ?>
                            </div>
                        </article>
                    <?php endwhile; wp_reset_postdata(); ?>
                </div>
            <?php else : ?>
                <div class="no-products">
                    <p>Chưa có sản phẩm bán chạy nào.</p>
                </div>
            <?php endif; ?>
        </section>
        <?php endif; ?>

        <!-- Enhanced Category Strip Section -->
        <section class="category-strip">
            <div class="container">
                <div class="section-header text-center">
                    <h2 class="section-title">Danh mục nổi bật</h2>
                    <p class="section-subtitle">Khám phá các sản phẩm công nghệ hàng đầu</p>
                </div>
                
                <div class="categories-grid">
                    <a href="<?php echo home_url('/danh-muc/robot-hut-bui'); ?>" class="category-item" data-aos="zoom-in" data-aos-delay="100">
                        <div class="category-thumb">
                            <div class="category-icon">
                                <i class="fas fa-robot"></i>
                            </div>
                            <div class="category-overlay">
                                <i class="fas fa-arrow-right"></i>
                            </div>
                        </div>
                        <div class="category-info">
                            <span class="category-label">Robot hút bụi</span>
                            <span class="category-count">150+ sản phẩm</span>
                        </div>
                    </a>
                    
                    <a href="<?php echo home_url('/danh-muc/may-loc-khong-khi'); ?>" class="category-item" data-aos="zoom-in" data-aos-delay="200">
                        <div class="category-thumb">
                            <div class="category-icon">
                                <i class="fas fa-wind"></i>
                            </div>
                            <div class="category-overlay">
                                <i class="fas fa-arrow-right"></i>
                            </div>
                        </div>
                        <div class="category-info">
                            <span class="category-label">Máy lọc không khí</span>
                            <span class="category-count">80+ sản phẩm</span>
                        </div>
                    </a>
                    
                    <a href="<?php echo home_url('/danh-muc/may-loc-nuoc'); ?>" class="category-item" data-aos="zoom-in" data-aos-delay="300">
                        <div class="category-thumb">
                            <div class="category-icon">
                                <i class="fas fa-tint"></i>
                            </div>
                            <div class="category-overlay">
                                <i class="fas fa-arrow-right"></i>
                            </div>
                        </div>
                        <div class="category-info">
                            <span class="category-label">Máy lọc nước</span>
                            <span class="category-count">60+ sản phẩm</span>
                        </div>
                    </a>
                    
                    <a href="<?php echo home_url('/danh-muc/smartwatch'); ?>" class="category-item" data-aos="zoom-in" data-aos-delay="400">
                        <div class="category-thumb">
                            <div class="category-icon">
                                <i class="fas fa-clock"></i>
                            </div>
                            <div class="category-overlay">
                                <i class="fas fa-arrow-right"></i>
                            </div>
                        </div>
                        <div class="category-info">
                            <span class="category-label">Smartwatch</span>
                            <span class="category-count">120+ sản phẩm</span>
                        </div>
                    </a>
                    
                    <a href="<?php echo home_url('/danh-muc/phu-kien'); ?>" class="category-item" data-aos="zoom-in" data-aos-delay="500">
                        <div class="category-thumb">
                            <div class="category-icon">
                                <i class="fas fa-headphones"></i>
                            </div>
                            <div class="category-overlay">
                                <i class="fas fa-arrow-right"></i>
                            </div>
                        </div>
                        <div class="category-info">
                            <span class="category-label">Phụ kiện</span>
                            <span class="category-count">200+ sản phẩm</span>
                        </div>
                    </a>
                </div>
            </div>
        </section>

        <!-- Air Purifier Section -->
        <?php if (class_exists('WooCommerce')) : ?>
        <section class="product-section">
            <div class="section-header">
                <h2 class="section-title">Máy lọc không khí</h2>
                <a href="<?php echo home_url('/danh-muc/may-loc-khong-khi'); ?>" class="view-all">Xem tất cả</a>
            </div>
            
            <?php
            $air_purifiers = scode_get_products_by_category('may-loc-khong-khi', 10);
            if ($air_purifiers->have_posts()) :
            ?>
                <div class="products-grid cols-5">
                    <?php while ($air_purifiers->have_posts()) : $air_purifiers->the_post(); 
                        global $product;
                    ?>
                        <article class="mi-card">
                            <div class="mi-media">
                                <?php 
                                // Calculate discount percentage
                                $regular_price = $product->get_regular_price();
                                $sale_price = $product->get_sale_price();
                                $discount_percent = 0;
                                
                                if ($regular_price && $sale_price && $regular_price > $sale_price) {
                                    $discount_percent = round((($regular_price - $sale_price) / $regular_price) * 100);
                                }
                                
                                // Check if product has special tags
                                $has_coupon = has_term('coupon', 'product_tag', $product->get_id()) || 
                                             has_term('flash-sale', 'product_tag', $product->get_id()) ||
                                             has_term('khuyen-mai', 'product_tag', $product->get_id());
                                ?>
                                
                                <?php if ($discount_percent > 0) : ?>
                                    <span class="mi-badge-off"><?php echo $discount_percent; ?>%</span>
                                <?php endif; ?>
                                
                                <?php if (has_post_thumbnail()) : ?>
                                    <a href="<?php the_permalink(); ?>">
                                        <?php the_post_thumbnail('product-thumb', array('class' => 'product-img')); ?>
                                    </a>
                                <?php endif; ?>
                                
                                <?php if ($has_coupon) : ?>
                                    <span class="mi-ribbon">MÃ GIẢM GIÁ</span>
                                <?php endif; ?>
                            </div>

                            <h3 class="mi-title">
                                <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                            </h3>

                            <div class="mi-price">
                                <?php if ($product->is_on_sale()) : ?>
                                    <span class="mi-price-sale">
                                        <?php echo number_format_i18n($sale_price, 0); ?>
                                        <span class="cur">đ</span>
                                    </span>
                                    <span class="mi-price-regular">
                                        <?php echo number_format_i18n($regular_price, 0); ?>đ
                                    </span>
                                <?php else : ?>
                                    <span class="mi-price-sale">
                                        <?php echo number_format_i18n($product->get_price(), 0); ?>
                                        <span class="cur">đ</span>
                                    </span>
                                <?php endif; ?>
                            </div>
                        </article>
                    <?php endwhile; wp_reset_postdata(); ?>
                </div>
            <?php else : ?>
                <div class="no-products">
                    <p>Chưa có sản phẩm máy lọc không khí nào.</p>
                </div>
            <?php endif; ?>
        </section>
        <?php endif; ?>

        <!-- Water Purifier Section -->
        <?php if (class_exists('WooCommerce')) : ?>
        <section class="product-section">
            <div class="section-header">
                <h2 class="section-title">Máy lọc nước</h2>
                <a href="<?php echo home_url('/danh-muc/may-loc-nuoc'); ?>" class="view-all">Xem tất cả</a>
            </div>
            
            <?php
            $water_purifiers = scode_get_products_by_category('may-loc-nuoc', 10);
            if ($water_purifiers->have_posts()) :
            ?>
                <div class="products-grid cols-5">
                    <?php while ($water_purifiers->have_posts()) : $water_purifiers->the_post(); 
                        global $product;
                    ?>
                        <article class="mi-card">
                            <div class="mi-media">
                                <?php 
                                // Calculate discount percentage
                                $regular_price = $product->get_regular_price();
                                $sale_price = $product->get_sale_price();
                                $discount_percent = 0;
                                
                                if ($regular_price && $sale_price && $regular_price > $sale_price) {
                                    $discount_percent = round((($regular_price - $sale_price) / $regular_price) * 100);
                                }
                                
                                // Check if product has special tags
                                $has_coupon = has_term('coupon', 'product_tag', $product->get_id()) || 
                                             has_term('flash-sale', 'product_tag', $product->get_id()) ||
                                             has_term('khuyen-mai', 'product_tag', $product->get_id());
                                ?>
                                
                                <?php if ($discount_percent > 0) : ?>
                                    <span class="mi-badge-off"><?php echo $discount_percent; ?>%</span>
                                <?php endif; ?>
                                
                                <?php if (has_post_thumbnail()) : ?>
                                    <a href="<?php the_permalink(); ?>">
                                        <?php the_post_thumbnail('product-thumb', array('class' => 'product-img')); ?>
                                    </a>
                                <?php endif; ?>
                                
                                <?php if ($has_coupon) : ?>
                                    <span class="mi-ribbon">MÃ GIẢM GIÁ</span>
                                <?php endif; ?>
                            </div>

                            <h3 class="mi-title">
                                <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                            </h3>

                            <div class="mi-price">
                                <?php if ($product->is_on_sale()) : ?>
                                    <span class="mi-price-sale">
                                        <?php echo number_format_i18n($sale_price, 0); ?>
                                        <span class="cur">đ</span>
                                    </span>
                                    <span class="mi-price-regular">
                                        <?php echo number_format_i18n($regular_price, 0); ?>đ
                                    </span>
                                <?php else : ?>
                                    <span class="mi-price-sale">
                                        <?php echo number_format_i18n($product->get_price(), 0); ?>
                                        <span class="cur">đ</span>
                                    </span>
                                <?php endif; ?>
                            </div>
                        </article>
                    <?php endwhile; wp_reset_postdata(); ?>
                </div>
            <?php else : ?>
                <div class="no-products">
                    <p>Chưa có sản phẩm máy lọc nước nào.</p>
                </div>
            <?php endif; ?>
        </section>
        <?php endif; ?>

        <!-- Mid Banner 2 -->
        <section class="banner-wide">
            <a href="<?php echo home_url('/combo-khuyen-mai'); ?>">
                <div class="banner-placeholder" style="background: linear-gradient(135deg, #6f42c1, #e83e8c); height: 200px; border-radius: 10px; display: flex; align-items: center; justify-content: center; color: white; font-size: 1.5rem; font-weight: 700;">
                    <i class="fas fa-gift"></i>
                    <span style="margin-left: 1rem;">COMBO KHUYẾN MÃI</span>
                </div>
            </a>
        </section>

        <!-- Smartwatch & Fitness Section -->
        <?php if (class_exists('WooCommerce')) : ?>
        <section class="product-section">
            <div class="section-header">
                <h2 class="section-title">Smartwatch • Fitness</h2>
                <a href="<?php echo home_url('/danh-muc/smartwatch'); ?>" class="view-all">Xem tất cả</a>
            </div>
            
            <?php
            $smartwatch_products = scode_get_products_by_category('smartwatch', 12);
            if ($smartwatch_products->have_posts()) :
            ?>
                <div class="products-grid cols-6">
                    <?php while ($smartwatch_products->have_posts()) : $smartwatch_products->the_post(); 
                        global $product;
                    ?>
                        <article class="mi-card">
                            <div class="mi-media">
                                <?php 
                                // Calculate discount percentage
                                $regular_price = $product->get_regular_price();
                                $sale_price = $product->get_sale_price();
                                $discount_percent = 0;
                                
                                if ($regular_price && $sale_price && $regular_price > $sale_price) {
                                    $discount_percent = round((($regular_price - $sale_price) / $regular_price) * 100);
                                }
                                
                                // Check if product has special tags
                                $has_coupon = has_term('coupon', 'product_tag', $product->get_id()) || 
                                             has_term('flash-sale', 'product_tag', $product->get_id()) ||
                                             has_term('khuyen-mai', 'product_tag', $product->get_id());
                                ?>
                                
                                <?php if ($discount_percent > 0) : ?>
                                    <span class="mi-badge-off"><?php echo $discount_percent; ?>%</span>
                                <?php endif; ?>
                                
                                <?php if (has_post_thumbnail()) : ?>
                                    <a href="<?php the_permalink(); ?>">
                                        <?php the_post_thumbnail('product-thumb', array('class' => 'product-img')); ?>
                                    </a>
                                <?php endif; ?>
                                
                                <?php if ($has_coupon) : ?>
                                    <span class="mi-ribbon">MÃ GIẢM GIÁ</span>
                                <?php endif; ?>
                            </div>

                            <h3 class="mi-title">
                                <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                            </h3>

                            <div class="mi-price">
                                <?php if ($product->is_on_sale()) : ?>
                                    <span class="mi-price-sale">
                                        <?php echo number_format_i18n($sale_price, 0); ?>
                                        <span class="cur">đ</span>
                                    </span>
                                    <span class="mi-price-regular">
                                        <?php echo number_format_i18n($regular_price, 0); ?>đ
                                    </span>
                                <?php else : ?>
                                    <span class="mi-price-sale">
                                        <?php echo number_format_i18n($product->get_price(), 0); ?>
                                        <span class="cur">đ</span>
                                    </span>
                                <?php endif; ?>
                            </div>
                        </article>
                    <?php endwhile; wp_reset_postdata(); ?>
                </div>
            <?php else : ?>
                <div class="no-products">
                    <p>Chưa có sản phẩm smartwatch nào.</p>
                </div>
            <?php endif; ?>
        </section>
        <?php endif; ?>

        <!-- Accessories Section -->
        <?php if (class_exists('WooCommerce')) : ?>
        <section class="product-section">
            <div class="section-header">
                <h2 class="section-title">Phụ kiện • Đồ gia dụng nhỏ</h2>
                <a href="<?php echo home_url('/danh-muc/phu-kien'); ?>" class="view-all">Xem tất cả</a>
            </div>
            
                        <?php
            $accessories = scode_get_products_by_category('phu-kien', 12);
            if ($accessories->have_posts()) :
            ?>
                <div class="products-grid cols-6">
                    <?php while ($accessories->have_posts()) : $accessories->the_post(); 
                        global $product;
                    ?>
                        <article class="mi-card">
                            <div class="mi-media">
                                <?php 
                                // Calculate discount percentage
                                $regular_price = $product->get_regular_price();
                                $sale_price = $product->get_sale_price();
                                $discount_percent = 0;
                                
                                if ($regular_price && $sale_price && $regular_price > $sale_price) {
                                    $discount_percent = round((($regular_price - $sale_price) / $regular_price) * 100);
                                }
                                
                                // Check if product has special tags
                                $has_coupon = has_term('coupon', 'product_tag', $product->get_id()) || 
                                             has_term('flash-sale', 'product_tag', $product->get_id()) ||
                                             has_term('khuyen-mai', 'product_tag', $product->get_id());
                                ?>
                                
                                <?php if ($discount_percent > 0) : ?>
                                    <span class="mi-badge-off"><?php echo $discount_percent; ?>%</span>
                                <?php endif; ?>
                                
                                <?php if (has_post_thumbnail()) : ?>
                                    <a href="<?php the_permalink(); ?>">
                                        <?php the_post_thumbnail('product-thumb', array('class' => 'product-img')); ?>
                                    </a>
                                <?php endif; ?>
                                
                                <?php if ($has_coupon) : ?>
                                    <span class="mi-ribbon">MÃ GIẢM GIÁ</span>
                                <?php endif; ?>
                            </div>

                            <h3 class="mi-title">
                                <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                            </h3>

                            <div class="mi-price">
                                <?php if ($product->is_on_sale()) : ?>
                                    <span class="mi-price-sale">
                                        <?php echo number_format_i18n($sale_price, 0); ?>
                                        <span class="cur">đ</span>
                                    </span>
                                    <span class="mi-price-regular">
                                        <?php echo number_format_i18n($regular_price, 0); ?>đ
                                    </span>
                                <?php else : ?>
                                    <span class="mi-price-sale">
                                        <?php echo number_format_i18n($product->get_price(), 0); ?>
                                        <span class="cur">đ</span>
                                    </span>
                                <?php endif; ?>
                            </div>
                        </article>
                    <?php endwhile; wp_reset_postdata(); ?>
                </div>
            <?php else : ?>
                <div class="no-products">
                    <p>Chưa có sản phẩm phụ kiện nào.</p>
                </div>
            <?php endif; ?>
        </section>
        <?php endif; ?>

        <!-- Enhanced After Sales Support Section -->
        <section class="after-sales-section">
            <div class="container">
                <div class="section-header text-center">
                    <h2 class="section-title">
                        <i class="fas fa-headset"></i>
                        Hỗ trợ sau bán hàng
                    </h2>
                    <p class="section-subtitle">Cam kết dịch vụ chăm sóc khách hàng tốt nhất</p>
                </div>
                
                <div class="support-grid">
                    <div class="support-item" data-aos="fade-up" data-aos-delay="100">
                        <div class="support-icon-wrapper">
                            <i class="fas fa-headset"></i>
                        </div>
                        <div class="support-content">
                            <h4>Hỗ trợ 24/7</h4>
                            <p>Đội ngũ tư vấn chuyên nghiệp sẵn sàng hỗ trợ mọi lúc</p>
                            <div class="support-highlight">
                                <i class="fas fa-phone"></i>
                                Hotline: <?php echo esc_html(get_theme_mod('scode_hotline', '0834.777.111')); ?>
                            </div>
                            <a href="<?php echo home_url('/lien-he'); ?>" class="support-btn">
                                <i class="fas fa-comments"></i>
                                Liên hệ ngay
                            </a>
                        </div>
                    </div>
                    
                    <div class="support-item" data-aos="fade-up" data-aos-delay="200">
                        <div class="support-icon-wrapper">
                            <i class="fas fa-tools"></i>
                        </div>
                        <div class="support-content">
                            <h4>Bảo hành chính hãng</h4>
                            <p>Đổi mới 7 ngày, bảo hành theo tiêu chuẩn nhà sản xuất</p>
                            <div class="support-highlight">
                                <i class="fas fa-shield-alt"></i>
                                Bảo hành 12-24 tháng
                            </div>
                            <a href="<?php echo home_url('/bao-hanh'); ?>" class="support-btn">
                                <i class="fas fa-info-circle"></i>
                                Xem chi tiết
                            </a>
                        </div>
                    </div>
                    
                    <div class="support-item" data-aos="fade-up" data-aos-delay="300">
                        <div class="support-icon-wrapper">
                            <i class="fas fa-shipping-fast"></i>
                        </div>
                        <div class="support-content">
                            <h4>Giao hàng nhanh</h4>
                            <p>Dịch vụ giao hàng chuyên nghiệp, đảm bảo thời gian</p>
                            <div class="support-highlight">
                                <i class="fas fa-truck"></i>
                                2-4h nội thành, 1-2 ngày toàn quốc
                            </div>
                            <a href="<?php echo home_url('/van-chuyen'); ?>" class="support-btn">
                                <i class="fas fa-route"></i>
                                Tìm hiểu thêm
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- News & Partners Section -->
        <section class="news-partners-section">
            <div class="section-header">
                <h2 class="section-title">Tin tức & Đối tác</h2>
            </div>
            
            <div class="news-partners-grid">
                <!-- Latest News -->
                <div class="news-column">
                    <h3>Tin tức mới nhất</h3>
                    <div class="news-list">
                        <article class="news-item">
                            <div class="news-date"><?php echo date('d/m/Y'); ?></div>
                            <h4><a href="#">Công nghệ AI trong robot hút bụi 2024</a></h4>
                            <p>Khám phá những tiến bộ mới nhất trong công nghệ robot hút bụi...</p>
                        </article>
                        
                        <article class="news-item">
                            <div class="news-date"><?php echo date('d/m/Y', strtotime('-1 day')); ?></div>
                            <h4><a href="#">Xu hướng smart home tại Việt Nam</a></h4>
                            <p>Thị trường smart home Việt Nam đang phát triển mạnh mẽ...</p>
                        </article>
                        
                        <article class="news-item">
                            <div class="news-date"><?php echo date('d/m/Y', strtotime('-2 days')); ?></div>
                            <h4><a href="#">Hướng dẫn chọn robot hút bụi phù hợp</a></h4>
                            <p>Những tiêu chí quan trọng khi chọn mua robot hút bụi...</p>
                        </article>
                    </div>
                </div>
                
                <!-- Partners -->
                <div class="partners-column">
                    <h3>Đối tác của chúng tôi</h3>
                    <div class="partners-grid">
                        <div class="partner-logo">
                            <img src="https://via.placeholder.com/120x60/007bff/ffffff?text=Xiaomi" alt="Xiaomi">
                        </div>
                        <div class="partner-logo">
                            <img src="https://via.placeholder.com/120x60/ff6b35/ffffff?text=Ecovacs" alt="Ecovacs">
                        </div>
                        <div class="partner-logo">
                            <img src="https://via.placeholder.com/120x60/00d4aa/ffffff?text=Roborock" alt="Roborock">
                        </div>
                        <div class="partner-logo">
                            <img src="https://via.placeholder.com/120x60/ff6b6b/ffffff?text=iRobot" alt="iRobot">
                        </div>
                        <div class="partner-logo">
                            <img src="https://via.placeholder.com/120x60/4ecdc4/ffffff?text=Tineco" alt="Tineco">
                        </div>
                        <div class="partner-logo">
                            <img src="https://via.placeholder.com/120x60/45b7d1/ffffff?text=Dreame" alt="Dreame">
                        </div>
                    </div>
                </div>
            </div>
        </section>

    </div><!-- .container -->
</main><!-- .main-content -->

<?php get_footer(); ?>
