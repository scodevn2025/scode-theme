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
        
        <!-- Icons Row Section -->
        <section class="icons-row">
            <div class="icons-grid">
                <div class="icon-item">
                    <i class="fas fa-truck"></i>
                    <h4>Giao nhanh</h4>
                    <p>2-4h nội thành</p>
                </div>
                <div class="icon-item">
                    <i class="fas fa-shield-alt"></i>
                    <h4>Bảo hành chính hãng</h4>
                    <p>Đổi mới 7 ngày</p>
                </div>
                <div class="icon-item">
                    <i class="fas fa-credit-card"></i>
                    <h4>Trả góp 0%</h4>
                    <p>Qua thẻ/ứng dụng</p>
                </div>
                <div class="icon-item">
                    <i class="fas fa-headset"></i>
                    <h4>Hỗ trợ 24/7</h4>
                    <p>Hotline <?php echo esc_html(get_theme_mod('scode_hotline', '0834.777.111')); ?></p>
                </div>
            </div>
        </section>

        <!-- Flash Sale Section -->
        <?php if (class_exists('WooCommerce')) : ?>
        <section class="product-section">
            <div class="section-header">
                <h2 class="section-title">FLASH SALE</h2>
                <a href="<?php echo home_url('/khuyen-mai/flash-sale'); ?>" class="view-all">Xem tất cả</a>
            </div>
            
            <?php
            $flash_sale_products = scode_get_sale_products(10);
            if ($flash_sale_products->have_posts()) :
            ?>
                <div class="products-grid cols-5">
                    <?php while ($flash_sale_products->have_posts()) : $flash_sale_products->the_post(); 
                        global $product;
                    ?>
                        <div class="product-card">
                            <div class="product-image">
                                <?php if (has_post_thumbnail()) : ?>
                                    <a href="<?php the_permalink(); ?>">
                                        <?php the_post_thumbnail('product-thumb', array('class' => 'product-img')); ?>
                                    </a>
                                <?php endif; ?>
                                
                                <?php echo scode_get_product_badges($product); ?>
                            </div>
                            
                            <div class="product-info">
                                <h3 class="product-title">
                                    <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                </h3>
                                
                                <?php echo scode_get_product_price_html($product); ?>
                                
                                <div class="product-actions">
                                    <button class="add-to-cart" data-product-id="<?php echo $product->get_id(); ?>">
                                        Thêm vào giỏ
                                    </button>
                                    <button class="quick-view" data-product-id="<?php echo $product->get_id(); ?>">
                                        Xem nhanh
                                    </button>
                                </div>
                            </div>
                        </div>
                    <?php endwhile; wp_reset_postdata(); ?>
                </div>
            <?php else : ?>
                <div class="no-products">
                    <p>Chưa có sản phẩm khuyến mãi nào.</p>
                </div>
            <?php endif; ?>
        </section>
        <?php endif; ?>

        <!-- Mid Banner 1 -->
        <section class="banner-wide">
            <a href="<?php echo home_url('/khuyen-mai'); ?>">
                <div class="banner-placeholder" style="background: linear-gradient(135deg, #f36c21, #ff8c42); height: 200px; border-radius: 10px; display: flex; align-items: center; justify-content: center; color: white; font-size: 1.5rem; font-weight: 700;">
                    <i class="fas fa-tags"></i>
                    <span style="margin-left: 1rem;">KHUYẾN MÃI ĐẶC BIỆT</span>
                </div>
            </a>
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
                                <div class="product-card featured">
                                    <!-- MI VIETNAM.VN Logo -->
                                    <div class="brand-logo">
                                        <span>MI VIETNAM.VN</span>
                                    </div>
                                    
                                    <div class="product-image">
                                        <?php if (has_post_thumbnail()) : ?>
                                            <img src="<?php echo get_the_post_thumbnail_url($product_id, 'product-thumb'); ?>" 
                                                 alt="<?php the_title_attribute(); ?>" 
                                                 class="product-img">
                                        <?php endif; ?>
                                        
                                        <!-- Discount Badge -->
                                        <?php if ($discount_percentage > 0) : ?>
                                            <div class="discount-badge">-<?php echo $discount_percentage; ?>%</div>
                                        <?php endif; ?>
                                        
                                        <!-- Additional Badges -->
                                        <div class="additional-badges">
                                            <?php if ($is_global) : ?>
                                                <div class="badge global">Global version</div>
                                            <?php endif; ?>
                                            
                                            <?php if ($is_premium) : ?>
                                                <div class="badge premium">SẢN PHẨM CAO CẤP</div>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                    
                                    <!-- Hot Sale Banner -->
                                    <div class="hot-sale-banner">
                                        <span>HOT SALE HÈ RỰC RỠ</span>
                                    </div>
                                    
                                    <!-- Product Info -->
                                    <div class="product-info">
                                        <h3 class="product-title">
                                            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                        </h3>
                                        
                                        <!-- Product Features List -->
                                        <?php if (!empty($product_features)) : ?>
                                            <div class="product-features-list">
                                                <?php 
                                                $features_array = explode("\n", $product_features);
                                                $features_count = 0;
                                                foreach ($features_array as $feature) {
                                                    if (trim($feature) && $features_count < 3) {
                                                        echo '<span class="feature-text">' . esc_html(trim($feature)) . '</span>';
                                                        $features_count++;
                                                    }
                                                }
                                                ?>
                                            </div>
                                        <?php endif; ?>
                                        
                                        <!-- Gift Information -->
                                        <?php if ($gift_value) : ?>
                                            <div class="gift-info">
                                                <span class="gift-text">QUÀ TẶNG <?php echo esc_html($gift_value); ?></span>
                                            </div>
                                        <?php endif; ?>
                                        
                                        <!-- Product Price -->
                                        <div class="product-price">
                                            <?php if ($sale_price && $regular_price) : ?>
                                                <span class="current-price"><?php echo scode_format_price($sale_price); ?></span>
                                                <span class="old-price"><?php echo scode_format_price($regular_price); ?></span>
                                            <?php else : ?>
                                                <span class="current-price"><?php echo scode_format_price($current_price); ?></span>
                                            <?php endif; ?>
                                        </div>
                                        
                                        <!-- Product Actions -->
                                        <div class="product-actions">
                                            <button class="add-to-cart" data-product-id="<?php echo $product_id; ?>">
                                                <i class="fas fa-shopping-cart"></i>
                                                Thêm vào giỏ
                                            </button>
                                            <button class="quick-view" data-product-id="<?php echo $product_id; ?>">
                                                <i class="fas fa-eye"></i>
                                                Xem nhanh
                                            </button>
                                        </div>
                                    </div>
                                </div>
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
                        <div class="product-card">
                            <div class="product-image">
                                <?php if (has_post_thumbnail()) : ?>
                                    <a href="<?php the_permalink(); ?>">
                                        <?php the_post_thumbnail('product-thumb', array('class' => 'product-img')); ?>
                                    </a>
                                <?php endif; ?>
                                
                                <?php echo scode_get_product_badges($product); ?>
                            </div>
                            
                            <div class="product-info">
                                <h3 class="product-title">
                                    <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                </h3>
                                
                                <?php echo scode_get_product_price_html($product); ?>
                                
                                <div class="product-actions">
                                    <button class="add-to-cart" data-product-id="<?php echo $product->get_id(); ?>">
                                        Thêm vào giỏ
                                    </button>
                                    <button class="quick-view" data-product-id="<?php echo $product->get_id(); ?>">
                                        Xem nhanh
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

        <!-- Category Strip Section -->
        <section class="category-strip">
            <div class="section-header">
                <h2 class="section-title">Danh mục nổi bật</h2>
            </div>
            
            <div class="categories-grid">
                <a href="<?php echo home_url('/danh-muc/robot-hut-bui'); ?>" class="category-item">
                    <div class="category-thumb">
                        <div class="category-placeholder" style="background: linear-gradient(135deg, #f36c21, #ff8c42); height: 120px; border-radius: 10px; display: flex; align-items: center; justify-content: center; color: white; font-size: 2rem;">
                            <i class="fas fa-robot"></i>
                        </div>
                    </div>
                    <span class="category-label">Robot hút bụi</span>
                </a>
                
                <a href="<?php echo home_url('/danh-muc/may-loc-khong-khi'); ?>" class="category-item">
                    <div class="category-thumb">
                        <div class="category-placeholder" style="background: linear-gradient(135deg, #17a2b8, #20c997); height: 120px; border-radius: 10px; display: flex; align-items: center; justify-content: center; color: white; font-size: 2rem;">
                            <i class="fas fa-wind"></i>
                        </div>
                    </div>
                    <span class="category-label">Máy lọc không khí</span>
                </a>
                
                <a href="<?php echo home_url('/danh-muc/may-loc-nuoc'); ?>" class="category-item">
                    <div class="category-thumb">
                        <div class="category-placeholder" style="background: linear-gradient(135deg, #007bff, #6610f2); height: 120px; border-radius: 10px; display: flex; align-items: center; justify-content: center; color: white; font-size: 2rem;">
                            <i class="fas fa-tint"></i>
                        </div>
                    </div>
                    <span class="category-label">Máy lọc nước</span>
                </a>
                
                <a href="<?php echo home_url('/danh-muc/smartwatch'); ?>" class="category-item">
                    <div class="category-thumb">
                        <div class="category-placeholder" style="background: linear-gradient(135deg, #28a745, #20c997); height: 120px; border-radius: 10px; display: flex; align-items: center; justify-content: center; color: white; font-size: 2rem;">
                            <i class="fas fa-clock"></i>
                        </div>
                    </div>
                    <span class="category-label">Smartwatch</span>
                </a>
                
                <a href="<?php echo home_url('/danh-muc/phu-kien'); ?>" class="category-item">
                    <div class="category-thumb">
                        <div class="category-placeholder" style="background: linear-gradient(135deg, #6f42c1, #e83e8c); height: 120px; border-radius: 10px; display: flex; align-items: center; justify-content: center; color: white; font-size: 2rem;">
                            <i class="fas fa-headphones"></i>
                        </div>
                    </div>
                    <span class="category-label">Phụ kiện</span>
                </a>
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
                        <div class="product-card">
                            <div class="product-image">
                                <?php if (has_post_thumbnail()) : ?>
                                    <a href="<?php the_permalink(); ?>">
                                        <?php the_post_thumbnail('product-thumb', array('class' => 'product-img')); ?>
                                    </a>
                                <?php endif; ?>
                                
                                <?php echo scode_get_product_badges($product); ?>
                            </div>
                            
                            <div class="product-info">
                                <h3 class="product-title">
                                    <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                </h3>
                                
                                <?php echo scode_get_product_price_html($product); ?>
                                
                                <div class="product-actions">
                                    <button class="add-to-cart" data-product-id="<?php echo $product->get_id(); ?>">
                                        Thêm vào giỏ
                                    </button>
                                    <button class="quick-view" data-product-id="<?php echo $product->get_id(); ?>">
                                        Xem nhanh
                                    </button>
                                </div>
                            </div>
                        </div>
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
                        <div class="product-card">
                            <div class="product-image">
                                <?php if (has_post_thumbnail()) : ?>
                                    <a href="<?php the_permalink(); ?>">
                                        <?php the_post_thumbnail('product-thumb', array('class' => 'product-img')); ?>
                                    </a>
                                <?php endif; ?>
                                
                                <?php echo scode_get_product_badges($product); ?>
                            </div>
                            
                            <div class="product-info">
                                <h3 class="product-title">
                                    <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                </h3>
                                
                                <?php echo scode_get_product_price_html($product); ?>
                                
                                <div class="product-actions">
                                    <button class="add-to-cart" data-product-id="<?php echo $product->get_id(); ?>">
                                        Thêm vào giỏ
                                    </button>
                                    <button class="quick-view" data-product-id="<?php echo $product->get_id(); ?>">
                                        Xem nhanh
                                    </button>
                                </div>
                            </div>
                        </div>
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
                        <div class="product-card">
                            <div class="product-image">
                                <?php if (has_post_thumbnail()) : ?>
                                    <a href="<?php the_permalink(); ?>">
                                        <?php the_post_thumbnail('product-thumb', array('class' => 'product-img')); ?>
                                    </a>
                                <?php endif; ?>
                                
                                <?php echo scode_get_product_badges($product); ?>
                            </div>
                            
                            <div class="product-info">
                                <h3 class="product-title">
                                    <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                </h3>
                                
                                <?php echo scode_get_product_price_html($product); ?>
                                
                                <div class="product-actions">
                                    <button class="add-to-cart" data-product-id="<?php echo $product->get_id(); ?>">
                                        Thêm vào giỏ
                                    </button>
                                    <button class="quick-view" data-product-id="<?php echo $product->get_id(); ?>">
                                        Xem nhanh
                                    </button>
                                </div>
                            </div>
                        </div>
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
                        <div class="product-card">
                            <div class="product-image">
                                <?php if (has_post_thumbnail()) : ?>
                                    <a href="<?php the_permalink(); ?>">
                                        <?php the_post_thumbnail('product-thumb', array('class' => 'product-img')); ?>
                                    </a>
                                <?php endif; ?>
                                
                                <?php echo scode_get_product_badges($product); ?>
                            </div>
                            
                            <div class="product-info">
                                <h3 class="product-title">
                                    <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                </h3>
                                
                                <?php echo scode_get_product_price_html($product); ?>
                                
                                <div class="product-actions">
                                    <button class="add-to-cart" data-product-id="<?php echo $product->get_id(); ?>">
                                        Thêm vào giỏ
                                    </button>
                                    <button class="quick-view" data-product-id="<?php echo $product->get_id(); ?>">
                                        Xem nhanh
                                    </button>
                                </div>
                            </div>
                        </div>
                    <?php endwhile; wp_reset_postdata(); ?>
                </div>
            <?php else : ?>
                <div class="no-products">
                    <p>Chưa có sản phẩm phụ kiện nào.</p>
                </div>
            <?php endif; ?>
        </section>
        <?php endif; ?>

    </div>
</main>

<?php get_footer(); ?>
