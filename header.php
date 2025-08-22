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
    
    <!-- Topbar -->
    <div class="header-top">
        <div class="container">
            <div class="header-top-left">
                <span><i class="fas fa-truck"></i> Miễn phí giao hàng đơn từ 500K</span>
                <span><i class="fas fa-phone"></i> Hotline: <?php echo esc_html(get_theme_mod('scode_hotline', '0834.777.111')); ?></span>
            </div>
            <div class="header-top-right">
                <a href="<?php echo home_url('/khuyen-mai'); ?>">Khuyến mãi</a>
                <a href="<?php echo home_url('/tin-tuc'); ?>">Tin tức</a>
                <a href="<?php echo home_url('/lien-he'); ?>">Liên hệ</a>
            </div>
        </div>
    </div>
    
    <!-- Site Header -->
    <header class="site-header" role="banner">
        <div class="header-main">
            <div class="container">
                <!-- Site Logo -->
                <div class="site-logo">
                    <?php if (get_theme_mod('scode_logo')) : ?>
                        <img src="<?php echo esc_url(get_theme_mod('scode_logo')); ?>" alt="<?php bloginfo('name'); ?>">
                    <?php else : ?>
                        <div class="logo-text">
                            <div class="logo-title">OTNT</div>
                            <div class="logo-subtitle">ÔNG TRÙM NỘI TRỢ</div>
                        </div>
                    <?php endif; ?>
                </div>
                
                <!-- Search Bar -->
                <div class="header-search">
                    <form role="search" method="get" action="<?php echo home_url('/'); ?>">
                        <input type="search" placeholder="Tìm sản phẩm..." value="<?php echo get_search_query(); ?>" name="s" />
                        <button type="submit" aria-label="<?php _e('Search', 'scode-theme'); ?>">
                            <i class="fas fa-search"></i>
                        </button>
                    </form>
                </div>
                
                <!-- Header Actions -->
                <div class="header-actions">
                    <a href="<?php echo home_url('/gio-hang'); ?>" class="header-action">
                        <i class="fas fa-shopping-cart"></i>
                        <span>Giỏ hàng</span>
                    </a>
                    
                    <a href="<?php echo home_url('/tai-khoan'); ?>" class="header-action">
                        <i class="fas fa-user"></i>
                        <span>Tài khoản</span>
                    </a>
                </div>
            </div>
        </div>
        
        <!-- Main Navigation -->
        <nav class="main-navigation" role="navigation">
            <div class="container">
                <button class="menu-toggle" aria-controls="primary-menu" aria-expanded="false">
                    <i class="fas fa-bars"></i>
                </button>
                
                <?php
                wp_nav_menu(array(
                    'theme_location' => 'primary',
                    'menu_id'        => 'primary-menu',
                    'menu_class'     => 'main-menu',
                    'container'      => false,
                    'fallback_cb'    => 'scode_fallback_menu',
                ));
                ?>
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
                        <h1><?php the_title(); ?></h1>
                        <div class="hero-slide-description"><?php the_content(); ?></div>
                        
                        <?php if (!empty($slide_button_text) && !empty($slide_button_url)) : ?>
                            <a href="<?php echo esc_url($slide_button_url); ?>" class="hero-cta">
                                <?php echo esc_html($slide_button_text); ?>
                            </a>
                        <?php endif; ?>
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
                <div class="slider-arrow prev">‹</div>
                <div class="slider-arrow next">›</div>
                <?php
            endif;
        else :
            // Fallback if no slides
            ?>
            <div class="hero-slide active">
                <div class="hero-slide-bg" style="background: linear-gradient(135deg, #f36c21, #ff8c42);"></div>
                <div class="hero-slide-overlay"></div>
                
                <div class="hero-slide-content">
                    <h1>Chào mừng đến với OTNT - ÔNG TRÙM NỘI TRỢ</h1>
                    <div class="hero-slide-description">Cửa hàng công nghệ hàng đầu Việt Nam với các sản phẩm chất lượng cao và dịch vụ chăm sóc khách hàng tốt nhất.</div>
                    <a href="<?php echo home_url('/san-pham'); ?>" class="hero-cta">Khám phá ngay</a>
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
    echo '<ul class="main-menu">';
    echo '<li><a href="' . home_url('/') . '">Trang chủ</a></li>';
    echo '<li><a href="' . home_url('/san-pham') . '">Sản phẩm</a></li>';
    echo '<li><a href="' . home_url('/khuyen-mai') . '">Khuyến mãi</a></li>';
    echo '<li><a href="' . home_url('/tin-tuc') . '">Tin tức</a></li>';
    echo '<li><a href="' . home_url('/lien-he') . '">Liên hệ</a></li>';
    echo '</ul>';
}
?>
