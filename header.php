<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="<?php bloginfo('description'); ?>">
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- WordPress Head -->
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
    <?php wp_body_open(); ?>
    
    <!-- Top Bar -->
    <div class="top-bar">
        <div class="container">
            <div class="top-bar-left">
                <div class="top-bar-item">
                    <i class="fas fa-truck"></i>
                    <span>Miễn phí giao hàng đơn từ 500K</span>
                </div>
                <div class="top-bar-item">
                    <i class="fas fa-phone"></i>
                    <span>Hotline: <?php echo esc_html(get_theme_mod('scode_hotline', '0834.777.111')); ?></span>
                </div>
            </div>
            <div class="top-bar-right">
                <div class="top-bar-item">
                    <a href="<?php echo home_url('/khuyen-mai'); ?>">
                        <i class="fas fa-tags"></i>
                        <span>Khuyến mãi</span>
                    </a>
                </div>
                <div class="top-bar-item">
                    <a href="<?php echo home_url('/tin-tuc'); ?>">
                        <i class="fas fa-newspaper"></i>
                        <span>Tin tức</span>
                    </a>
                </div>
                <div class="top-bar-item">
                    <a href="<?php echo home_url('/lien-he'); ?>">
                        <i class="fas fa-envelope"></i>
                        <span>Liên hệ</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Main Header -->
    <header class="main-header">
        <div class="header-main">
            <div class="container">
                <div class="header-left">
                    <!-- Logo -->
                    <div class="logo">
                        <?php if (get_theme_mod('scode_logo')) : ?>
                            <a href="<?php echo home_url('/'); ?>">
                                <img src="<?php echo esc_url(get_theme_mod('scode_logo')); ?>" alt="<?php bloginfo('name'); ?>">
                            </a>
                        <?php else : ?>
                            <a href="<?php echo home_url('/'); ?>" class="logo-text">
                                <div class="logo-title">OTNT</div>
                                <div class="logo-subtitle">ÔNG TRÙM NỘI TRỢ</div>
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
                
                <div class="header-center">
                    <!-- Search Bar -->
                    <div class="search-box">
                        <form role="search" method="get" action="<?php echo home_url('/'); ?>">
                            <div class="search-input-wrapper">
                                <input type="search" placeholder="Tìm kiếm sản phẩm..." value="<?php echo get_search_query(); ?>" name="s" />
                                <button type="submit" class="search-btn">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
                
                <div class="header-right">
                    <!-- Header Actions -->
                    <div class="header-actions">
                        <div class="header-action">
                            <a href="<?php echo home_url('/tai-khoan'); ?>" class="action-link">
                                <i class="fas fa-user"></i>
                                <span>Tài khoản</span>
                            </a>
                        </div>
                        
                        <div class="header-action">
                            <a href="<?php echo home_url('/yeu-thich'); ?>" class="action-link">
                                <i class="fas fa-heart"></i>
                                <span>Yêu thích</span>
                            </a>
                        </div>
                        
                        <div class="header-action cart-action">
                            <a href="<?php echo home_url('/gio-hang'); ?>" class="action-link">
                                <i class="fas fa-shopping-cart"></i>
                                <span>Giỏ hàng</span>
                                <span class="cart-count">0</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Main Navigation -->
        <nav class="main-navigation">
            <div class="container">
                <div class="nav-wrapper">
                    <!-- Mobile Menu Toggle -->
                    <button class="mobile-menu-toggle" aria-controls="primary-menu" aria-expanded="false">
                        <i class="fas fa-bars"></i>
                    </button>
                    
                    <!-- Primary Menu -->
                    <div class="primary-menu-wrapper">
                        <?php
                        wp_nav_menu(array(
                            'theme_location' => 'primary',
                            'menu_id'        => 'primary-menu',
                            'menu_class'     => 'primary-menu',
                            'container'      => false,
                            'fallback_cb'    => 'scode_fallback_menu',
                        ));
                        ?>
                    </div>
                    
                    <!-- Category Menu -->
                    <div class="category-menu-wrapper">
                        <button class="category-toggle">
                            <i class="fas fa-th-large"></i>
                            <span>Danh mục</span>
                        </button>
                        <div class="category-dropdown">
                            <ul class="category-list">
                                <li><a href="<?php echo home_url('/danh-muc/gia-dung'); ?>"><i class="fas fa-home"></i> Gia dụng</a></li>
                                <li><a href="<?php echo home_url('/danh-muc/smart-home'); ?>"><i class="fas fa-cog"></i> Smart Home</a></li>
                                <li><a href="<?php echo home_url('/danh-muc/suc-khoe'); ?>"><i class="fas fa-heart"></i> Sức khỏe</a></li>
                                <li><a href="<?php echo home_url('/danh-muc/dien-thoai'); ?>"><i class="fas fa-mobile-alt"></i> Điện thoại</a></li>
                                <li><a href="<?php echo home_url('/danh-muc/laptop'); ?>"><i class="fas fa-laptop"></i> Laptop</a></li>
                                <li><a href="<?php echo home_url('/danh-muc/phu-kien'); ?>"><i class="fas fa-headphones"></i> Phụ kiện</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </nav>
    </header>
    
    <!-- Hero Slider -->
    <div class="hero-slider">
        <?php
        $slides = scode_get_hero_slides(5);
        if ($slides->have_posts()) :
            $slide_index = 0;
            while ($slides->have_posts()) : $slides->the_post();
                $slide_button_text = get_post_meta(get_the_ID(), 'button_text', true);
                $slide_button_url = get_post_meta(get_the_ID(), 'button_url', true);
                $slide_class = ($slide_index === 0) ? 'hero-slide active' : 'hero-slide';
                ?>
                
                <div class="<?php echo esc_attr($slide_class); ?>">
                    <?php if (has_post_thumbnail()) : ?>
                        <div class="hero-slide-bg" style="background-image: url('<?php echo get_the_post_thumbnail_url(get_the_ID(), 'slide-large'); ?>');"></div>
                    <?php endif; ?>
                    
                    <div class="hero-slide-overlay"></div>
                    
                    <div class="hero-slide-content">
                        <div class="slide-content-wrapper">
                            <h1 class="slide-title"><?php the_title(); ?></h1>
                            <div class="slide-description"><?php the_content(); ?></div>
                            
                            <?php if (!empty($slide_button_text) && !empty($slide_button_url)) : ?>
                                <div class="slide-actions">
                                    <a href="<?php echo esc_url($slide_button_url); ?>" class="slide-btn primary">
                                        <?php echo esc_html($slide_button_text); ?>
                                    </a>
                                    <a href="<?php echo home_url('/san-pham'); ?>" class="slide-btn secondary">
                                        Xem tất cả
                                    </a>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                <?php
                $slide_index++;
            endwhile;
            wp_reset_postdata();
            
            // Create navigation dots dynamically
            if ($slides->post_count > 1) :
                ?>
                <div class="slider-nav">
                    <?php for ($i = 0; $i < $slides->post_count; $i++) : ?>
                        <div class="slider-dot <?php echo ($i === 0) ? 'active' : ''; ?>" data-slide="<?php echo $i; ?>"></div>
                    <?php endfor; ?>
                </div>
                
                <!-- Slide Arrows -->
                <div class="slider-arrow prev">
                    <i class="fas fa-chevron-left"></i>
                </div>
                <div class="slider-arrow next">
                    <i class="fas fa-chevron-right"></i>
                </div>
                <?php
            endif;
        else :
            // Fallback if no slides
            ?>
            <div class="hero-slide active">
                <div class="hero-slide-bg" style="background: linear-gradient(135deg, #f36c21, #ff8c42);"></div>
                <div class="hero-slide-overlay"></div>
                
                <div class="hero-slide-content">
                    <div class="slide-content-wrapper">
                        <h1 class="slide-title">Chào mừng đến với OTNT - ÔNG TRÙM NỘI TRỢ</h1>
                        <div class="slide-description">Cửa hàng công nghệ hàng đầu Việt Nam với các sản phẩm chất lượng cao và dịch vụ chăm sóc khách hàng tốt nhất.</div>
                        <div class="slide-actions">
                            <a href="<?php echo home_url('/san-pham'); ?>" class="slide-btn primary">Khám phá ngay</a>
                            <a href="<?php echo home_url('/khuyen-mai'); ?>" class="slide-btn secondary">Khuyến mãi</a>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>
    
    <!-- Main Content -->
    <main class="main-content" id="main-content">
        <div class="container">

<?php
// Fallback menu function
function scode_fallback_menu() {
    echo '<ul class="primary-menu">';
    echo '<li><a href="' . home_url('/') . '">Trang chủ</a></li>';
    echo '<li><a href="' . home_url('/san-pham') . '">Sản phẩm</a></li>';
    echo '<li><a href="' . home_url('/khuyen-mai') . '">Khuyến mãi</a></li>';
    echo '<li><a href="' . home_url('/tin-tuc') . '">Tin tức</a></li>';
    echo '<li><a href="' . home_url('/lien-he') . '">Liên hệ</a></li>';
    echo '</ul>';
}
?>
