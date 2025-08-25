<?php
/**
 * The main template file - Completely reprogrammed for homepage product display
 * 
 * @package SCODE_Theme
 * @version 2.0.0
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

        <!-- ===== FLASH SALE SECTION ===== -->
        <?php if (class_exists('WooCommerce')) : ?>
        <section class="home-products flash-sale-section">
            <div class="section-header">
                <div class="section-title-wrapper">
                    <div class="title-box">
                        <h2 class="section-title">
                            <i class="fas fa-bolt"></i>
                            FLASH SALE
                        </h2>
                    </div>
                    <a href="<?php echo home_url('/khuyen-mai/flash-sale'); ?>" class="view-all-link">
                        Xem tất cả
                    </a>
                </div>
            </div>
            
            <?php
            // Get products on sale with flash sale tag
            $flash_sale_args = array(
                'post_type' => 'product',
                'posts_per_page' => 8,
                'post_status' => 'publish',
                'meta_query' => array(
                    array(
                        'key' => '_sale_price',
                        'value' => '',
                        'compare' => '!='
                    ),
                    array(
                        'key' => '_regular_price',
                        'value' => '',
                        'compare' => '!='
                    )
                ),
                'tax_query' => array(
                    array(
                        'taxonomy' => 'product_tag',
                        'field' => 'slug',
                        'terms' => array('flash-sale', 'khuyen-mai', 'sale'),
                        'operator' => 'OR'
                    )
                )
            );
            
            $flash_sale_products = new WP_Query($flash_sale_args);
            
            if ($flash_sale_products->have_posts()) :
            ?>
                <div class="products-grid">
                    <?php while ($flash_sale_products->have_posts()) : $flash_sale_products->the_post(); 
                        global $product;
                        $product_id = $product->get_id();
                        
                        // Calculate discount percentage
                        $regular_price = $product->get_regular_price();
                        $sale_price = $product->get_sale_price();
                        $discount_percent = 0;
                        
                        if ($regular_price && $sale_price && $regular_price > $sale_price) {
                            $discount_percent = round((($regular_price - $sale_price) / $regular_price) * 100);
                        }
                        
                        // Check product attributes
                        $is_new = get_post_meta($product_id, '_is_new', true);
                        $is_premium = get_post_meta($product_id, '_is_premium', true);
                        $has_coupon = has_term('coupon', 'product_tag', $product_id);
                    ?>
                        <div class="product-card">
                            <div class="product-image-wrapper">
                                <?php if ($discount_percent > 0) : ?>
                                    <div class="discount-badge">
                                        -<?php echo $discount_percent; ?>%
                                    </div>
                                <?php endif; ?>
                                
                                <?php if ($has_coupon) : ?>
                                    <div class="ribbon">
                                        MÃ GIẢM GIÁ
                                    </div>
                                <?php endif; ?>
                                
                                <?php if ($is_new) : ?>
                                    <div class="badge-new">HÀNG MỚI</div>
                                <?php endif; ?>
                                
                                <?php if ($is_premium) : ?>
                                    <div class="badge-premium">PREMIUM</div>
                                <?php endif; ?>
                                
                                <a href="<?php the_permalink(); ?>">
                                    <?php echo scode_get_simple_product_image($product_id, 'product-thumb', 'product-img'); ?>
                                </a>
                            </div>

                            <div class="product-info">
                                <h3 class="product-title">
                                    <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                </h3>
                                
                                <div class="product-price">
                                    <?php if ($product->is_on_sale()) : ?>
                                        <span class="price-promotional">
                                            <?php echo number_format_i18n($sale_price, 0); ?>đ
                                        </span>
                                        <span class="price-original">
                                            <?php echo number_format_i18n($regular_price, 0); ?>đ
                                        </span>
                                    <?php else : ?>
                                        <span class="price-current">
                                            <?php echo number_format_i18n($product->get_price(), 0); ?>đ
                                        </span>
                                    <?php endif; ?>
                                </div>
                                
                                <div class="product-actions">
                                    <button class="btn-add-to-cart" data-product-id="<?php echo $product_id; ?>">
                                        <i class="fas fa-shopping-cart"></i>
                                        Chọn mua
                                    </button>
                                </div>
                            </div>
                        </div>
                    <?php endwhile; wp_reset_postdata(); ?>
                </div>
            <?php else : ?>
                <div class="no-products">
                    <p>Chưa có sản phẩm flash sale nào.</p>
                </div>
            <?php endif; ?>
        </section>
        <?php endif; ?>

        <!-- ===== GIẢM GIÁ SỐC SECTION ===== -->
        <?php if (class_exists('WooCommerce')) : ?>
        <section class="home-products shocking-discount-section">
            <div class="section-header">
                <div class="section-title-wrapper">
                    <div class="title-box">
                        <h2 class="section-title">
                            <i class="fas fa-fire"></i>
                            GIẢM GIÁ SỐC
                        </h2>
                    </div>
                    <a href="<?php echo home_url('/khuyen-mai/giam-gia-soc'); ?>" class="view-all-link">
                        Xem tất cả
                    </a>
                </div>
            </div>
            
            <?php
            // Get products with high discount percentage
            $shocking_discount_args = array(
                'post_type' => 'product',
                'posts_per_page' => 8,
                'post_status' => 'publish',
                'meta_query' => array(
                    array(
                        'key' => '_sale_price',
                        'value' => '',
                        'compare' => '!='
                    ),
                    array(
                        'key' => '_regular_price',
                        'value' => '',
                        'compare' => '!='
                    )
                )
            );
            
            $shocking_discount_products = new WP_Query($shocking_discount_args);
            
            if ($shocking_discount_products->have_posts()) :
            ?>
                <div class="products-grid">
                    <?php while ($shocking_discount_products->have_posts()) : $shocking_discount_products->the_post(); 
                        global $product;
                        $product_id = $product->get_id();
                        
                        // Calculate discount percentage
                        $regular_price = $product->get_regular_price();
                        $sale_price = $product->get_sale_price();
                        $discount_percent = 0;
                        
                        if ($regular_price && $sale_price && $regular_price > $sale_price) {
                            $discount_percent = round((($regular_price - $sale_price) / $regular_price) * 100);
                        }
                        
                        // Only show products with significant discount
                        if ($discount_percent < 15) continue;
                        
                        // Check product attributes
                        $is_new = get_post_meta($product_id, '_is_new', true);
                        $is_premium = get_post_meta($product_id, '_is_premium', true);
                    ?>
                        <div class="product-card">
                            <div class="product-image-wrapper">
                                <?php if ($discount_percent > 0) : ?>
                                    <div class="discount-badge">
                                        -<?php echo $discount_percent; ?>%
                                    </div>
                                <?php endif; ?>
                                
                                <?php if ($is_new) : ?>
                                    <div class="badge-new">HÀNG MỚI</div>
                                <?php endif; ?>
                                
                                <?php if ($is_premium) : ?>
                                    <div class="badge-premium">PREMIUM</div>
                                <?php endif; ?>
                                
                                <a href="<?php the_permalink(); ?>">
                                    <?php echo scode_get_simple_product_image($product_id, 'product-thumb', 'product-img'); ?>
                                </a>
                            </div>

                            <div class="product-info">
                                <h3 class="product-title">
                                    <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                </h3>
                                
                                <div class="product-price">
                                    <?php if ($product->is_on_sale()) : ?>
                                        <span class="price-promotional">
                                            <?php echo number_format_i18n($sale_price, 0); ?>đ
                                        </span>
                                        <span class="price-original">
                                            <?php echo number_format_i18n($regular_price, 0); ?>đ
                                        </span>
                                    <?php else : ?>
                                        <span class="price-current">
                                            <?php echo number_format_i18n($product->get_price(), 0); ?>đ
                                        </span>
                                    <?php endif; ?>
                                </div>
                                
                                <div class="product-actions">
                                    <button class="btn-add-to-cart" data-product-id="<?php echo $product_id; ?>">
                                        <i class="fas fa-shopping-cart"></i>
                                        Chọn mua
                                    </button>
                                </div>
                            </div>
                        </div>
                    <?php endwhile; wp_reset_postdata(); ?>
                </div>
            <?php else : ?>
                <div class="no-products">
                    <p>Chưa có sản phẩm giảm giá sốc nào.</p>
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

        <!-- ===== BÁN CHẠY SECTION ===== -->
        <?php if (class_exists('WooCommerce')) : ?>
        <section class="home-products best-sellers-section">
            <div class="section-header">
                <div class="section-title-wrapper">
                    <div class="title-box">
                        <h2 class="section-title">
                            <i class="fas fa-star"></i>
                            BÁN CHẠY
                        </h2>
                    </div>
                    <a href="<?php echo home_url('/ban-chay'); ?>" class="view-all-link">
                        Xem tất cả
                    </a>
                </div>
            </div>
            
            <?php
            // Get best selling products
            $best_sellers = scode_get_best_selling_products(8);
            
            if ($best_sellers->have_posts()) :
            ?>
                <div class="products-grid">
                    <?php while ($best_sellers->have_posts()) : $best_sellers->the_post(); 
                        global $product;
                        $product_id = $product->get_id();
                        
                        // Calculate discount percentage
                        $regular_price = $product->get_regular_price();
                        $sale_price = $product->get_sale_price();
                        $discount_percent = 0;
                        
                        if ($regular_price && $sale_price && $regular_price > $sale_price) {
                            $discount_percent = round((($regular_price - $sale_price) / $regular_price) * 100);
                        }
                        
                        // Check product attributes
                        $is_new = get_post_meta($product_id, '_is_new', true);
                        $is_premium = get_post_meta($product_id, '_is_premium', true);
                    ?>
                        <div class="product-card">
                            <div class="product-image-wrapper">
                                <?php if ($discount_percent > 0) : ?>
                                    <div class="discount-badge">
                                        -<?php echo $discount_percent; ?>%
                                    </div>
                                <?php endif; ?>
                                
                                <?php if ($is_new) : ?>
                                    <div class="badge-new">HÀNG MỚI</div>
                                <?php endif; ?>
                                
                                <?php if ($is_premium) : ?>
                                    <div class="badge-premium">PREMIUM</div>
                                <?php endif; ?>
                                
                                <a href="<?php the_permalink(); ?>">
                                    <?php echo scode_get_simple_product_image($product_id, 'product-thumb', 'product-img'); ?>
                                </a>
                            </div>

                            <div class="product-info">
                                <h3 class="product-title">
                                    <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                </h3>
                                
                                <div class="product-price">
                                    <?php if ($product->is_on_sale()) : ?>
                                        <span class="price-promotional">
                                            <?php echo number_format_i18n($sale_price, 0); ?>đ
                                        </span>
                                        <span class="price-original">
                                            <?php echo number_format_i18n($regular_price, 0); ?>đ
                                        </span>
                                    <?php else : ?>
                                        <span class="price-current">
                                            <?php echo number_format_i18n($product->get_price(), 0); ?>đ
                                        </span>
                                    <?php endif; ?>
                                </div>
                                
                                <div class="product-actions">
                                    <button class="btn-add-to-cart" data-product-id="<?php echo $product_id; ?>">
                                        <i class="fas fa-shopping-cart"></i>
                                        Chọn mua
                                    </button>
                                </div>
                            </div>
                        </div>
                    <?php endwhile; wp_reset_postdata(); ?>
                </div>
            <?php else : ?>
                <div class="no-products">
                    <p>Chưa có sản phẩm bán chạy nào.</p>
                </div>
            <?php endif; ?>
        </section>
        <?php endif; ?>

        <!-- ===== SẢN PHẨM MỚI SECTION ===== -->
        <?php if (class_exists('WooCommerce')) : ?>
        <section class="home-products new-products-section">
            <div class="section-header">
                <div class="section-title-wrapper">
                    <div class="title-box">
                        <h2 class="section-title">
                            <i class="fas fa-gift"></i>
                            SẢN PHẨM MỚI
                        </h2>
                    </div>
                    <a href="<?php echo home_url('/san-pham-moi'); ?>" class="view-all-link">
                        Xem tất cả
                    </a>
                </div>
            </div>
            
            <?php
            // Get new products
            $new_products_args = array(
                'post_type' => 'product',
                'posts_per_page' => 8,
                'post_status' => 'publish',
                'meta_query' => array(
                    array(
                        'key' => '_is_new',
                        'value' => '1',
                        'compare' => '='
                    )
                ),
                'orderby' => 'date',
                'order' => 'DESC'
            );
            
            $new_products = new WP_Query($new_products_args);
            
            if ($new_products->have_posts()) :
            ?>
                <div class="products-grid">
                    <?php while ($new_products->have_posts()) : $new_products->the_post(); 
                        global $product;
                        $product_id = $product->get_id();
                        
                        // Calculate discount percentage
                        $regular_price = $product->get_regular_price();
                        $sale_price = $product->get_sale_price();
                        $discount_percent = 0;
                        
                        if ($regular_price && $sale_price && $regular_price > $sale_price) {
                            $discount_percent = round((($regular_price - $sale_price) / $regular_price) * 100);
                        }
                        
                        // Check product attributes
                        $is_premium = get_post_meta($product_id, '_is_premium', true);
                    ?>
                        <div class="product-card">
                            <div class="product-image-wrapper">
                                <?php if ($discount_percent > 0) : ?>
                                    <div class="discount-badge">
                                        -<?php echo $discount_percent; ?>%
                                    </div>
                                <?php endif; ?>
                                
                                <div class="badge-new">HÀNG MỚI</div>
                                
                                <?php if ($is_premium) : ?>
                                    <div class="badge-premium">PREMIUM</div>
                                <?php endif; ?>
                                
                                <a href="<?php the_permalink(); ?>">
                                    <?php echo scode_get_simple_product_image($product_id, 'product-thumb', 'product-img'); ?>
                                </a>
                            </div>

                            <div class="product-info">
                                <h3 class="product-title">
                                    <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                </h3>
                                
                                <div class="product-price">
                                    <?php if ($product->is_on_sale()) : ?>
                                        <span class="price-promotional">
                                            <?php echo number_format_i18n($sale_price, 0); ?>đ
                                        </span>
                                        <span class="price-original">
                                            <?php echo number_format_i18n($regular_price, 0); ?>đ
                                        </span>
                                    <?php else : ?>
                                        <span class="price-current">
                                            <?php echo number_format_i18n($product->get_price(), 0); ?>đ
                                        </span>
                                    <?php endif; ?>
                                </div>
                                
                                <div class="product-actions">
                                    <button class="btn-add-to-cart" data-product-id="<?php echo $product_id; ?>">
                                        <i class="fas fa-shopping-cart"></i>
                                        Chọn mua
                                    </button>
                                </div>
                            </div>
                        </div>
                    <?php endwhile; wp_reset_postdata(); ?>
                </div>
            <?php else : ?>
                <div class="no-products">
                    <p>Chưa có sản phẩm mới nào.</p>
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

        <!-- Mid Banner 2 -->
        <section class="banner-wide">
            <a href="<?php echo home_url('/combo-khuyen-mai'); ?>">
                <div class="banner-placeholder" style="background: linear-gradient(135deg, #6f42c1, #e83e8c); height: 200px; border-radius: 10px; display: flex; align-items: center; justify-content: center; color: white; font-size: 1.5rem; font-weight: 700;">
                    <i class="fas fa-gift"></i>
                    <span style="margin-left: 1rem;">COMBO KHUYẾN MÃI</span>
                </div>
            </a>
        </section>

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
                            <div class="partner-icon" style="background: #007bff; color: white; width: 120px; height: 60px; display: flex; align-items: center; justify-content: center; font-weight: bold; border-radius: 8px;">
                                <i class="fas fa-mobile-alt"></i>
                                <span style="margin-left: 8px;">Xiaomi</span>
                            </div>
                        </div>
                        <div class="partner-logo">
                            <div class="partner-icon" style="background: #ff6b35; color: white; width: 120px; height: 60px; display: flex; align-items: center; justify-content: center; font-weight: bold; border-radius: 8px;">
                                <i class="fas fa-robot"></i>
                                <span style="margin-left: 8px;">Ecovacs</span>
                            </div>
                        </div>
                        <div class="partner-logo">
                            <div class="partner-icon" style="background: #00d4aa; color: white; width: 120px; height: 60px; display: flex; align-items: center; justify-content: center; font-weight: bold; border-radius: 8px;">
                                <i class="fas fa-robot"></i>
                                <span style="margin-left: 8px;">Roborock</span>
                            </div>
                        </div>
                        <div class="partner-logo">
                            <div class="partner-icon" style="background: #ff6b6b; color: white; width: 120px; height: 60px; display: flex; align-items: center; justify-content: center; font-weight: bold; border-radius: 8px;">
                                <i class="fas fa-robot"></i>
                                <span style="margin-left: 8px;">iRobot</span>
                            </div>
                        </div>
                        <div class="partner-logo">
                            <div class="partner-icon" style="background: #4ecdc4; color: white; width: 120px; height: 60px; display: flex; align-items: center; justify-content: center; font-weight: bold; border-radius: 8px;">
                                <i class="fas fa-wind"></i>
                                <span style="margin-left: 8px;">Tineco</span>
                            </div>
                        </div>
                        <div class="partner-logo">
                            <div class="partner-icon" style="background: #45b7d1; color: white; width: 120px; height: 60px; display: flex; align-items: center; justify-content: center; font-weight: bold; border-radius: 8px;">
                                <i class="fas fa-robot"></i>
                                <span style="margin-left: 8px;">Dreame</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

    </div><!-- .container -->
</main><!-- .main-content -->

<?php get_footer(); ?>
