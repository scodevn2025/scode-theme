<?php
/**
 * The main template file - MI VIETNAM.VN Style
 *
 * @package ScodeTheme
 */

get_header(); ?>

<!-- Hero Banner Section -->
<section class="hero-banner">
    <div class="container">
        <div class="hero-content">
            <div class="hero-text">
                <h1>QREVO C PRO</h1>
                <p>Robot hút bụi thông minh thế hệ mới</p>
                <a href="<?php echo home_url('/shop'); ?>" class="hero-cta">MUA NGAY</a>
            </div>
            <div class="hero-image">
                <img src="<?php echo get_template_directory_uri(); ?>/assets/img/hero-robot.png" alt="QREVO C PRO" onerror="this.style.display='none'">
            </div>
        </div>
    </div>
</section>

<!-- Category Quick Links -->
<section class="category-links">
    <div class="container">
        <div class="category-grid">
            <a href="<?php echo home_url('/category/dien-thoai'); ?>" class="category-item">
                <div class="category-icon">📱</div>
                <span>Điện thoại</span>
            </a>
            <a href="<?php echo home_url('/category/may-tinh-bang'); ?>" class="category-item">
                <div class="category-icon">💻</div>
                <span>Máy tính bảng</span>
            </a>
            <a href="<?php echo home_url('/category/robot-hut-bui'); ?>" class="category-item">
                <div class="category-icon">🤖</div>
                <span>Robot hút bụi</span>
            </a>
            <a href="<?php echo home_url('/category/thiet-bi-gia-dung'); ?>" class="category-item">
                <div class="category-icon">🏠</div>
                <span>Thiết bị gia dụng</span>
            </a>
            <a href="<?php echo home_url('/category/may-chay-bo'); ?>" class="category-item">
                <div class="category-icon">🏃</div>
                <span>Máy chạy bộ</span>
            </a>
            <a href="<?php echo home_url('/category/dong-ho-thong-minh'); ?>" class="category-item">
                <div class="category-icon">⌚</div>
                <span>Đồng hồ thông minh</span>
            </a>
        </div>
    </div>
</section>

<!-- Flash Sale Section -->
<section class="flash-sale">
    <div class="container">
        <div class="section-header">
            <h2>SẢN PHẨM MỚI</h2>
            <div class="countdown">
                <span>Flash Sale: </span>
                <span id="countdown-hours">00</span>:<span id="countdown-minutes">00</span>:<span id="countdown-seconds">00</span>
            </div>
        </div>
        
        <?php if (class_exists('WooCommerce')) : ?>
        <div class="products-grid">
            <?php
            $args = array(
                'post_type' => 'product',
                'posts_per_page' => 6,
                'meta_query' => array(
                    array(
                        'key' => '_sale_price',
                        'value' => '',
                        'compare' => '!='
                    )
                )
            );
            
            $sale_products = new WP_Query($args);
            
            if ($sale_products->have_posts()) :
                while ($sale_products->have_posts()) : $sale_products->the_post();
                    global $product;
                    ?>
                    <div class="product-card">
                        <?php if ($product->is_on_sale()) : ?>
                            <div class="discount-badge">
                                -<?php 
                                $regular_price = $product->get_regular_price();
                                $sale_price = $product->get_sale_price();
                                if ($regular_price && $sale_price) {
                                    echo round((1 - $sale_price / $regular_price) * 100);
                                }
                                ?>%
                            </div>
                        <?php endif; ?>
                        
                        <div class="product-image">
                            <a href="<?php the_permalink(); ?>">
                                <?php if (has_post_thumbnail()) : ?>
                                    <?php the_post_thumbnail('medium', array('class' => 'img-fluid')); ?>
                                <?php else : ?>
                                    <img src="<?php echo wc_placeholder_img_src(); ?>" alt="<?php the_title(); ?>">
                                <?php endif; ?>
                            </a>
                        </div>
                        
                        <div class="product-info">
                            <h3 class="product-title">
                                <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                            </h3>
                            
                            <div class="product-price">
                                <?php if ($product->is_on_sale()) : ?>
                                    <span class="old-price"><?php echo wc_price($product->get_regular_price()); ?></span>
                                    <span class="new-price"><?php echo wc_price($product->get_sale_price()); ?></span>
                                <?php else : ?>
                                    <span class="new-price"><?php echo wc_price($product->get_price()); ?></span>
                                <?php endif; ?>
                            </div>
                            
                            <button class="add-to-cart" data-product-id="<?php echo $product->get_id(); ?>">
                                Thêm vào giỏ
                            </button>
                        </div>
                    </div>
                    <?php
                endwhile;
                wp_reset_postdata();
            else :
                echo '<p style="grid-column: 1 / -1; text-align: center; padding: 2rem;">Không có sản phẩm khuyến mãi nào.</p>';
            endif;
            ?>
        </div>
        <?php else : ?>
            <p style="text-align: center; padding: 2rem;">Vui lòng kích hoạt WooCommerce để hiển thị sản phẩm.</p>
        <?php endif; ?>
    </div>
</section>

<!-- Main Product Categories -->
<?php if (class_exists('WooCommerce')) : ?>
<!-- Điện thoại Section -->
<section class="product-category">
    <div class="container">
        <div class="section-header">
            <h2>ĐIỆN THOẠI</h2>
            <a href="<?php echo home_url('/category/dien-thoai'); ?>" class="view-all">Xem tất cả</a>
        </div>
        
        <div class="products-grid">
            <?php
            $args = array(
                'post_type' => 'product',
                'posts_per_page' => 6,
                'tax_query' => array(
                    array(
                        'taxonomy' => 'product_cat',
                        'field' => 'slug',
                        'terms' => 'dien-thoai'
                    )
                )
            );
            
            $phone_products = new WP_Query($args);
            
            if ($phone_products->have_posts()) :
                while ($phone_products->have_posts()) : $phone_products->the_post();
                    global $product;
                    get_template_part('template-parts/product', 'card');
                endwhile;
                wp_reset_postdata();
            else :
                echo '<p style="grid-column: 1 / -1; text-align: center; padding: 2rem;">Không có sản phẩm điện thoại nào.</p>';
            endif;
            ?>
        </div>
    </div>
</section>

<!-- Robot hút bụi Section -->
<section class="product-category">
    <div class="container">
        <div class="section-header">
            <h2>ROBOT HÚT BỤI</h2>
            <a href="<?php echo home_url('/category/robot-hut-bui'); ?>" class="view-all">Xem tất cả</a>
        </div>
        
        <div class="products-grid">
            <?php
            $args = array(
                'post_type' => 'product',
                'posts_per_page' => 6,
                'tax_query' => array(
                    array(
                        'taxonomy' => 'product_cat',
                        'field' => 'slug',
                        'terms' => 'robot-hut-bui'
                    )
                )
            );
            
            $robot_products = new WP_Query($args);
            
            if ($robot_products->have_posts()) :
                while ($robot_products->have_posts()) : $robot_products->the_post();
                    global $product;
                    get_template_part('template-parts/product', 'card');
                endwhile;
                wp_reset_postdata();
            else :
                echo '<p style="grid-column: 1 / -1; text-align: center; padding: 2rem;">Không có sản phẩm robot hút bụi nào.</p>';
            endif;
            ?>
        </div>
    </div>
</section>

<!-- Máy lọc không khí Section -->
<section class="product-category">
    <div class="container">
        <div class="section-header">
            <h2>MÁY LỌC KHÔNG KHÍ</h2>
            <a href="<?php echo home_url('/category/may-loc-khong-khi'); ?>" class="view-all">Xem tất cả</a>
        </div>
        
        <div class="products-grid">
            <?php
            $args = array(
                'post_type' => 'product',
                'posts_per_page' => 6,
                'tax_query' => array(
                    array(
                        'taxonomy' => 'product_cat',
                        'field' => 'slug',
                        'terms' => 'may-loc-khong-khi'
                    )
                )
            );
            
            $air_products = new WP_Query($args);
            
            if ($air_products->have_posts()) :
                while ($air_products->have_posts()) : $air_products->the_post();
                    global $product;
                    get_template_part('template-parts/product', 'card');
                endwhile;
                wp_reset_postdata();
            else :
                echo '<p style="grid-column: 1 / -1; text-align: center; padding: 2rem;">Không có sản phẩm máy lọc không khí nào.</p>';
            endif;
            ?>
        </div>
    </div>
</section>

<!-- Máy chạy bộ Section -->
<section class="product-category">
    <div class="container">
        <div class="section-header">
            <h2>MÁY CHẠY BỘ</h2>
            <a href="<?php echo home_url('/category/may-chay-bo'); ?>" class="view-all">Xem tất cả</a>
        </div>
        
        <div class="products-grid">
            <?php
            $args = array(
                'post_type' => 'product',
                'posts_per_page' => 6,
                'tax_query' => array(
                    array(
                        'taxonomy' => 'product_cat',
                        'field' => 'slug',
                        'terms' => 'may-chay-bo'
                    )
                )
            );
            
            $treadmill_products = new WP_Query($args);
            
            if ($treadmill_products->have_posts()) :
                while ($treadmill_products->have_posts()) : $treadmill_products->the_post();
                    global $product;
                    get_template_part('template-parts/product', 'card');
                endwhile;
                wp_reset_postdata();
            else :
                echo '<p style="grid-column: 1 / -1; text-align: center; padding: 2rem;">Không có sản phẩm máy chạy bộ nào.</p>';
            endif;
            ?>
        </div>
    </div>
</section>

<!-- Đồng hồ thông minh Section -->
<section class="product-category">
    <div class="container">
        <div class="section-header">
            <h2>ĐỒNG HỒ THÔNG MINH</h2>
            <a href="<?php echo home_url('/category/dong-ho-thong-minh'); ?>" class="view-all">Xem tất cả</a>
        </div>
        
        <div class="products-grid">
            <?php
            $args = array(
                'post_type' => 'product',
                'posts_per_page' => 6,
                'tax_query' => array(
                    array(
                        'taxonomy' => 'product_cat',
                        'field' => 'slug',
                        'terms' => 'dong-ho-thong-minh'
                    )
                )
            );
            
            $watch_products = new WP_Query($args);
            
            if ($watch_products->have_posts()) :
                while ($watch_products->have_posts()) : $watch_products->the_post();
                    global $product;
                    get_template_part('template-parts/product', 'card');
                endwhile;
                wp_reset_postdata();
            else :
                echo '<p style="grid-column: 1 / -1; text-align: center; padding: 2rem;">Không có sản phẩm đồng hồ thông minh nào.</p>';
            endif;
            ?>
        </div>
    </div>
</section>

<!-- Thiết bị gia dụng Section -->
<section class="product-category">
    <div class="container">
        <div class="section-header">
            <h2>THIẾT BỊ GIA DỤNG</h2>
            <a href="<?php echo home_url('/category/thiet-bi-gia-dung'); ?>" class="view-all">Xem tất cả</a>
        </div>
        
        <div class="products-grid">
            <?php
            $args = array(
                'post_type' => 'product',
                'posts_per_page' => 6,
                'tax_query' => array(
                    array(
                        'taxonomy' => 'product_cat',
                        'field' => 'slug',
                        'terms' => 'thiet-bi-gia-dung'
                    )
                )
            );
            
            $home_products = new WP_Query($args);
            
            if ($home_products->have_posts()) :
                while ($home_products->have_posts()) : $home_products->the_post();
                    global $product;
                    get_template_part('template-parts/product', 'card');
                endwhile;
                wp_reset_postdata();
            else :
                echo '<p style="grid-column: 1 / -1; text-align: center; padding: 2rem;">Không có sản phẩm thiết bị gia dụng nào.</p>';
            endif;
            ?>
        </div>
    </div>
</section>

<!-- Camera giám sát Section -->
<section class="product-category">
    <div class="container">
        <div class="section-header">
            <h2>CAMERA GIÁM SÁT</h2>
            <a href="<?php echo home_url('/category/camera-giam-sat'); ?>" class="view-all">Xem tất cả</a>
        </div>
        
        <div class="products-grid">
            <?php
            $args = array(
                'post_type' => 'product',
                'posts_per_page' => 6,
                'tax_query' => array(
                    array(
                        'taxonomy' => 'product_cat',
                        'field' => 'slug',
                        'terms' => 'camera-giam-sat'
                    )
                )
            );
            
            $camera_products = new WP_Query($args);
            
            if ($camera_products->have_posts()) :
                while ($camera_products->have_posts()) : $camera_products->the_post();
                    global $product;
                    get_template_part('template-parts/product', 'card');
                endwhile;
                wp_reset_postdata();
            else :
                echo '<p style="grid-column: 1 / -1; text-align: center; padding: 2rem;">Không có sản phẩm camera giám sát nào.</p>';
            endif;
            ?>
        </div>
    </div>
</section>

<!-- Thiết bị mạng Section -->
<section class="product-category">
    <div class="container">
        <div class="section-header">
            <h2>THIẾT BỊ MẠNG</h2>
            <a href="<?php echo home_url('/category/thiet-bi-mang'); ?>" class="view-all">Xem tất cả</a>
        </div>
        
        <div class="products-grid">
            <?php
            $args = array(
                'post_type' => 'product',
                'posts_per_page' => 6,
                'tax_query' => array(
                    array(
                        'taxonomy' => 'product_cat',
                        'field' => 'slug',
                        'terms' => 'thiet-bi-mang'
                    )
                )
            );
            
            $network_products = new WP_Query($args);
            
            if ($network_products->have_posts()) :
                while ($network_products->have_posts()) : $network_products->the_post();
                    global $product;
                    get_template_part('template-parts/product', 'card');
                endwhile;
                wp_reset_postdata();
            else :
                echo '<p style="grid-column: 1 / -1; text-align: center; padding: 2rem;">Không có sản phẩm thiết bị mạng nào.</p>';
            endif;
            ?>
        </div>
    </div>
</section>

<!-- Phụ kiện điện thoại Section -->
<section class="product-category">
    <div class="container">
        <div class="section-header">
            <h2>PHỤ KIỆN ĐIỆN THOẠI</h2>
            <a href="<?php echo home_url('/category/phu-kien-dien-thoai'); ?>" class="view-all">Xem tất cả</a>
        </div>
        
        <div class="products-grid">
            <?php
            $args = array(
                'post_type' => 'product',
                'posts_per_page' => 6,
                'tax_query' => array(
                    array(
                        'taxonomy' => 'product_cat',
                        'field' => 'slug',
                        'terms' => 'phu-kien-dien-thoai'
                    )
                )
            );
            
            $accessory_products = new WP_Query($args);
            
            if ($accessory_products->have_posts()) :
                while ($accessory_products->have_posts()) : $accessory_products->the_post();
                    global $product;
                    get_template_part('template-parts/product', 'card');
                endwhile;
                wp_reset_postdata();
            else :
                echo '<p style="grid-column: 1 / -1; text-align: center; padding: 2rem;">Không có sản phẩm phụ kiện điện thoại nào.</p>';
            endif;
            ?>
        </div>
    </div>
</section>

<!-- Thiết bị âm thanh Section -->
<section class="product-category">
    <div class="container">
        <div class="section-header">
            <h2>THIẾT BỊ ÂM THANH</h2>
            <a href="<?php echo home_url('/category/thiet-bi-am-thanh'); ?>" class="view-all">Xem tất cả</a>
        </div>
        
        <div class="products-grid">
            <?php
            $args = array(
                'post_type' => 'product',
                'posts_per_page' => 6,
                'tax_query' => array(
                    array(
                        'taxonomy' => 'product_cat',
                        'field' => 'slug',
                        'terms' => 'thiet-bi-am-thanh'
                    )
                )
            );
            
            $audio_products = new WP_Query($args);
            
            if ($audio_products->have_posts()) :
                while ($audio_products->have_posts()) : $audio_products->the_post();
                    global $product;
                    get_template_part('template-parts/product', 'card');
                endwhile;
                wp_reset_postdata();
            else :
                echo '<p style="grid-column: 1 / -1; text-align: center; padding: 2rem;">Không có sản phẩm thiết bị âm thanh nào.</p>';
            endif;
            ?>
        </div>
    </div>
</section>

<!-- Thiết bị thông minh Section -->
<section class="product-category">
    <div class="container">
        <div class="section-header">
            <h2>THIẾT BỊ THÔNG MINH</h2>
            <a href="<?php echo home_url('/category/thiet-bi-thong-minh'); ?>" class="view-all">Xem tất cả</a>
        </div>
        
        <div class="products-grid">
            <?php
            $args = array(
                'post_type' => 'product',
                'posts_per_page' => 6,
                'tax_query' => array(
                    array(
                        'taxonomy' => 'product_cat',
                        'field' => 'slug',
                        'terms' => 'thiet-bi-thong-minh'
                    )
                )
            );
            
            $smart_products = new WP_Query($args);
            
            if ($smart_products->have_posts()) :
                while ($smart_products->have_posts()) : $smart_products->the_post();
                    global $product;
                    get_template_part('template-parts/product', 'card');
                endwhile;
                wp_reset_postdata();
            else :
                echo '<p style="grid-column: 1 / -1; text-align: center; padding: 2rem;">Không có sản phẩm thiết bị thông minh nào.</p>';
            endif;
            ?>
        </div>
    </div>
</section>

<!-- Phụ kiện khác Section -->
<section class="product-category">
    <div class="container">
        <div class="section-header">
            <h2>PHỤ KIỆN KHÁC</h2>
            <a href="<?php echo home_url('/category/phu-kien-khac'); ?>" class="view-all">Xem tất cả</a>
        </div>
        
        <div class="products-grid">
            <?php
            $args = array(
                'post_type' => 'product',
                'posts_per_page' => 6,
                'tax_query' => array(
                    array(
                        'taxonomy' => 'product_cat',
                        'field' => 'slug',
                        'terms' => 'phu-kien-khac'
                    )
                )
            );
            
            $other_products = new WP_Query($args);
            
            if ($other_products->have_posts()) :
                while ($other_products->have_posts()) : $other_products->the_post();
                    global $product;
                    get_template_part('template-parts/product', 'card');
                endwhile;
                wp_reset_postdata();
            else :
                echo '<p style="grid-column: 1 / -1; text-align: center; padding: 2rem;">Không có sản phẩm phụ kiện khác nào.</p>';
            endif;
            ?>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- After Sales Section -->
<section class="after-sales">
    <div class="container">
        <div class="after-sales-content">
            <div class="after-sales-text">
                <h2>SƠ HẬU MÃI</h2>
                <p>Hỗ trợ khách hàng 24/7</p>
                <div class="contact-info">
                    <span class="phone">1900 888 638</span>
                    <button class="support-btn">Hỗ trợ online</button>
                </div>
            </div>
            <div class="after-sales-image">
                <img src="<?php echo get_template_directory_uri(); ?>/assets/img/support-team.png" alt="Hỗ trợ khách hàng" onerror="this.style.display='none'">
            </div>
        </div>
    </div>
</section>

<!-- News & Partners Section -->
<section class="news-partners">
    <div class="container">
        <div class="news-partners-grid">
            <div class="news-section">
                <h3>TIN TỨC & SỰ KIỆN</h3>
                <div class="news-list">
                    <?php
                    $news_posts = new WP_Query(array(
                        'post_type' => 'post',
                        'posts_per_page' => 3,
                        'category_name' => 'tin-tuc'
                    ));
                    
                    if ($news_posts->have_posts()) :
                        while ($news_posts->have_posts()) : $news_posts->the_post();
                            ?>
                            <div class="news-item">
                                <?php if (has_post_thumbnail()) : ?>
                                    <div class="news-image">
                                        <?php the_post_thumbnail('thumbnail'); ?>
                                    </div>
                                <?php endif; ?>
                                <div class="news-content">
                                    <h4><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
                                    <p><?php echo wp_trim_words(get_the_excerpt(), 20); ?></p>
                                </div>
                            </div>
                            <?php
                        endwhile;
                        wp_reset_postdata();
                    else :
                        echo '<p style="text-align: center; padding: 1rem;">Không có tin tức nào.</p>';
                    endif;
                    ?>
                </div>
            </div>
            
            <div class="partners-section">
                <h3>ĐỐI TÁC</h3>
                <div class="partners-grid">
                    <div class="partner-logo">LG</div>
                    <div class="partner-logo">Xiaomi</div>
                    <div class="partner-logo">Samsung</div>
                    <div class="partner-logo">Apple</div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php get_footer(); ?>
