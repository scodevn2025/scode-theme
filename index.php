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
        <?php if (class_exists('WooCommerce')) : ?>
        <section class="product-section">
            <div class="section-header">
                <h2 class="section-title">Sản phẩm nổi bật</h2>
                <a href="<?php echo home_url('/san-pham-noi-bat'); ?>" class="view-all">Xem tất cả</a>
            </div>
            
            <?php
            $featured_products = scode_get_featured_products(12);
            if ($featured_products->have_posts()) :
            ?>
                <div class="products-grid cols-6">
                    <?php while ($featured_products->have_posts()) : $featured_products->the_post(); 
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
                    <p>Chưa có sản phẩm nổi bật nào.</p>
                </div>
            <?php endif; ?>
        </section>
        <?php endif; ?>

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
