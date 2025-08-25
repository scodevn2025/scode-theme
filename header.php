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
    
    <!-- Force Hide Scrollbar CSS -->
    <style>
        .no-scrollbar,
        .hero-sidebar.no-scrollbar,
        .vertical-mega-menu {
            scrollbar-width: none !important;
            -ms-overflow-style: none !important;
        }
        
        .no-scrollbar::-webkit-scrollbar,
        .hero-sidebar.no-scrollbar::-webkit-scrollbar,
        .vertical-mega-menu::-webkit-scrollbar {
            width: 0 !important;
            height: 0 !important;
            display: none !important;
        }
        
        .no-scrollbar::-webkit-scrollbar-track,
        .hero-sidebar.no-scrollbar::-webkit-scrollbar-track,
        .vertical-mega-menu::-webkit-scrollbar-track {
            display: none !important;
        }
        
        .no-scrollbar::-webkit-scrollbar-thumb,
        .hero-sidebar.no-scrollbar::-webkit-scrollbar-thumb,
        .vertical-mega-menu::-webkit-scrollbar-thumb {
            display: none !important;
        }
    </style>
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
    </header>
    
    <!-- Hero Section with 2-Column Layout (Only on Homepage) -->
    <?php if (is_home() || is_front_page()) : ?>
    <section class="hero-section">
        <div class="container">
            <div class="hero-grid">
                <!-- Left Column: Vertical Mega Menu -->
                <aside class="hero-sidebar no-scrollbar">
                    <nav class="vertical-mega-menu">
                        <div class="menu-header">
                            <i class="fas fa-th-large"></i>
                            <span>DANH MỤC SẢN PHẨM</span>
                        </div>
                        
                        <ul class="mega-menu-list">
                            <li class="mega-menu-item has-submenu">
                                <a href="<?php echo home_url('/danh-muc/robot-hut-bui'); ?>" class="menu-link">
                                    <i class="fas fa-robot"></i>
                                    <span>ROBOT HÚT BỤI</span>
                                    <i class="fas fa-chevron-right caret"></i>
                                </a>
                                <div class="submenu-dropdown">
                                    <div class="submenu-content">
                                        <div class="submenu-column">
                                            <h4>Thương hiệu</h4>
                                            <ul>
                                                <li><a href="<?php echo home_url('/danh-muc/roborock'); ?>">Roborock</a></li>
                                                <li><a href="<?php echo home_url('/danh-muc/xiaomi'); ?>">Xiaomi</a></li>
                                                <li><a href="<?php echo home_url('/danh-muc/ecovacs'); ?>">Ecovacs</a></li>
                                            </ul>
                                        </div>
                                        <div class="submenu-column">
                                            <h4>Giá cả</h4>
                                            <ul>
                                                <li><a href="<?php echo home_url('/danh-muc/duoi-5-trieu'); ?>">Dưới 5 triệu</a></li>
                                                <li><a href="<?php echo home_url('/danh-muc/5-10-trieu'); ?>">5-10 triệu</a></li>
                                                <li><a href="<?php echo home_url('/danh-muc/tren-10-trieu'); ?>">Trên 10 triệu</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            
                            <li class="mega-menu-item has-submenu">
                                <a href="<?php echo home_url('/danh-muc/tivi'); ?>" class="menu-link">
                                    <i class="fas fa-tv"></i>
                                    <span>TIVI XIAOMI</span>
                                    <i class="fas fa-chevron-right caret"></i>
                                </a>
                                <div class="submenu-dropdown">
                                    <div class="submenu-content">
                                        <div class="submenu-column">
                                            <h4>Kích thước</h4>
                                            <ul>
                                                <li><a href="<?php echo home_url('/danh-muc/tivi-32-inch'); ?>">32 inch</a></li>
                                                <li><a href="<?php echo home_url('/danh-muc/tivi-43-inch'); ?>">43 inch</a></li>
                                                <li><a href="<?php echo home_url('/danh-muc/tivi-55-inch'); ?>">55 inch</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            
                            <li class="mega-menu-item has-submenu">
                                <a href="<?php echo home_url('/danh-muc/may-loc-khong-khi'); ?>" class="menu-link">
                                    <i class="fas fa-wind"></i>
                                    <span>MÁY LỌC KHÔNG KHÍ</span>
                                    <i class="fas fa-chevron-right caret"></i>
                                </a>
                            </li>
                            
                            <li class="mega-menu-item has-submenu">
                                <a href="<?php echo home_url('/danh-muc/may-loc-nuoc'); ?>" class="menu-link">
                                    <i class="fas fa-tint"></i>
                                    <span>MÁY LỌC NƯỚC</span>
                                    <i class="fas fa-chevron-right caret"></i>
                                </a>
                            </li>
                            
                            <li class="mega-menu-item has-submenu">
                                <a href="<?php echo home_url('/danh-muc/smartwatch'); ?>" class="menu-link">
                                    <i class="fas fa-clock"></i>
                                    <span>SMARTWATCH</span>
                                    <i class="fas fa-chevron-right caret"></i>
                                </a>
                            </li>
                            
                            <li class="mega-menu-item has-submenu">
                                <a href="<?php echo home_url('/danh-muc/laptop'); ?>" class="menu-link">
                                    <i class="fas fa-laptop"></i>
                                    <span>LAPTOP</span>
                                    <i class="fas fa-chevron-right caret"></i>
                                </a>
                            </li>
                            
                            <li class="mega-menu-item has-submenu">
                                <a href="<?php echo home_url('/danh-muc/dien-thoai'); ?>" class="menu-link">
                                    <i class="fas fa-mobile-alt"></i>
                                    <span>ĐIỆN THOẠI</span>
                                    <i class="fas fa-chevron-right caret"></i>
                                </a>
                            </li>
                            
                            <li class="mega-menu-item has-submenu">
                                <a href="<?php echo home_url('/danh-muc/phu-kien'); ?>" class="menu-link">
                                    <i class="fas fa-headphones"></i>
                                    <span>PHỤ KIỆN</span>
                                    <i class="fas fa-chevron-right caret"></i>
                                </a>
                            </li>
                        </ul>
                    </nav>
                </aside>
                
                <!-- Right Column: Hero Slider -->
                <div class="hero-main">
                    <div class="hero-slider">
                        <?php
                        $slides = scode_get_hero_slides(5);
                        if ($slides->have_posts()) :
                            $slide_index = 0;
                            while ($slides->have_posts()) : $slides->the_post();
                                $slide_button_text = get_post_meta(get_the_ID(), 'button_text', true);
                                $slide_button_url = get_post_meta(get_the_ID(), 'button_url', true);
                                $slide_price_original = get_post_meta(get_the_ID(), 'price_original', true);
                                $slide_price_sale = get_post_meta(get_the_ID(), 'price_sale', true);
                                $slide_gifts = get_post_meta(get_the_ID(), 'gifts', true);
                                $slide_promotion_text = get_post_meta(get_the_ID(), 'promotion_text', true);
                                $slide_features = get_post_meta(get_the_ID(), 'features', true);
                                $slide_class = ($slide_index === 0) ? 'hero-slide active' : 'hero-slide';
                                ?>
                                
                                <div class="<?php echo esc_attr($slide_class); ?>">
                                    <?php if (has_post_thumbnail()) : ?>
                                        <div class="hero-slide-bg" style="background-image: url('<?php echo get_the_post_thumbnail_url(get_the_ID(), 'full'); ?>');"></div>
                                    <?php endif; ?>
                                    
                                    <div class="hero-slide-overlay"></div>
                                    
                                    <div class="hero-slide-content">
                                        <div class="slide-left">
                                            <div class="slide-brands">
                                                <?php if (get_theme_mod('scode_mi_logo')) : ?>
                                                    <img src="<?php echo esc_url(get_theme_mod('scode_mi_logo')); ?>" alt="Mi Vietnam" class="brand-logo">
                                                <?php else : ?>
                                                    <div class="brand-logo-placeholder">MI VIETNAM.VN</div>
                                                <?php endif; ?>
                                                
                                                <?php if (get_theme_mod('scode_ecovacs_logo')) : ?>
                                                    <img src="<?php echo esc_url(get_theme_mod('scode_ecovacs_logo')); ?>" alt="ECOVACS" class="brand-logo">
                                                <?php else : ?>
                                                    <div class="brand-logo-placeholder">ECOVACS</div>
                                                <?php endif; ?>
                                            </div>
                                            
                                            <h1 class="slide-title"><?php the_title(); ?></h1>
                                            <div class="slide-description"><?php the_content(); ?></div>
                                            
                                            <?php if (!empty($slide_promotion_text)) : ?>
                                                <div class="slide-promotion">
                                                    <div class="promotion-banner">
                                                        <span><?php echo esc_html($slide_promotion_text); ?></span>
                                                    </div>
                                                </div>
                                            <?php endif; ?>
                                            
                                            <?php if (!empty($slide_price_original) || !empty($slide_price_sale)) : ?>
                                                <div class="slide-pricing">
                                                    <div class="price-box">
                                                        <div class="price-label">Giá chỉ từ</div>
                                                        <?php if (!empty($slide_price_original)) : ?>
                                                            <div class="price-original"><?php echo esc_html($slide_price_original); ?></div>
                                                        <?php endif; ?>
                                                        <?php if (!empty($slide_price_sale)) : ?>
                                                            <div class="price-sale"><?php echo esc_html($slide_price_sale); ?></div>
                                                        <?php endif; ?>
                                                    </div>
                                                </div>
                                            <?php endif; ?>
                                            
                                            <?php if (!empty($slide_gifts)) : ?>
                                                <div class="slide-gifts">
                                                    <div class="gifts-box">
                                                        <div class="gifts-header">QUÀ TẶNG</div>
                                                        <div class="gifts-content">
                                                            <p><?php echo esc_html($slide_gifts); ?></p>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php endif; ?>
                                            
                                            <?php if (!empty($slide_features)) : ?>
                                                <div class="slide-features">
                                                    <div class="features-grid">
                                                        <?php 
                                                        $features_array = explode("\n", $slide_features);
                                                        foreach ($features_array as $feature) {
                                                            if (trim($feature)) {
                                                                echo '<div class="feature-item">';
                                                                echo '<div class="feature-icon">';
                                                                echo '<i class="fas fa-check-circle"></i>';
                                                                echo '</div>';
                                                                echo '<span>' . esc_html(trim($feature)) . '</span>';
                                                                echo '</div>';
                                                            }
                                                        }
                                                        ?>
                                                    </div>
                                                </div>
                                            <?php endif; ?>
                                            
                                            <?php if (!empty($slide_button_text) && !empty($slide_button_url)) : ?>
                                                <div class="slide-actions">
                                                    <a href="<?php echo esc_url($slide_button_url); ?>" class="slide-btn primary">
                                                        <?php echo esc_html($slide_button_text); ?>
                                                    </a>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                        
                                        <div class="slide-right">
                                            <!-- Product image will be shown as background, this area can be used for additional content -->
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
                                <?php
                            endif;
                        else :
                            // Fallback if no slides - create a sample slide like the ECOVACS ad
                            ?>
                            <div class="hero-slide active">
                                <div class="hero-slide-bg" style="background: linear-gradient(135deg, #1e3a8a, #7c3aed);"></div>
                                <div class="hero-slide-overlay"></div>
                                
                                <div class="hero-slide-content">
                                    <div class="slide-left">
                                        <div class="slide-brands">
                                            <div class="brand-logo-placeholder">MI VIETNAM.VN</div>
                                            <div class="brand-logo-placeholder">ECOVACS</div>
                                        </div>
                                        
                                        <h1 class="slide-title">DEEBOT T50 Series</h1>
                                        <div class="slide-description">Mỏng đến ngạc nhiên - Làm sạch toàn diện</div>
                                        
                                        <div class="slide-promotion">
                                            <div class="promotion-banner">
                                                <span>KHUYẾN MÃI ĐẶC BIỆT</span>
                                            </div>
                                        </div>
                                        
                                        <div class="slide-pricing">
                                            <div class="price-box">
                                                <div class="price-label">Giá chỉ từ</div>
                                                <div class="price-sale">14.590.000₫</div>
                                            </div>
                                        </div>
                                        
                                        <div class="slide-gifts">
                                            <div class="gifts-box">
                                                <div class="gifts-header">QUÀ TẶNG</div>
                                                <div class="gifts-content">
                                                    <p>Máy hút bụi Tineco iFloor 2 Max<br>Giá trị: 4.990.000₫</p>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="slide-features">
                                            <div class="features-grid">
                                                <div class="feature-item">
                                                    <div class="feature-icon">
                                                        <i class="fas fa-wind"></i>
                                                    </div>
                                                    <span>Lực hút 15.000Pa</span>
                                                </div>
                                                <div class="feature-item">
                                                    <div class="feature-icon">
                                                        <i class="fas fa-ruler-vertical"></i>
                                                    </div>
                                                    <span>Thiết kế siêu mỏng 81mm</span>
                                                </div>
                                                <div class="feature-item">
                                                    <div class="feature-icon">
                                                        <i class="fas fa-broom"></i>
                                                    </div>
                                                    <span>TruEdge 2.0 - Làm sạch cạnh</span>
                                                </div>
                                                <div class="feature-item">
                                                    <div class="feature-icon">
                                                        <i class="fas fa-magic"></i>
                                                    </div>
                                                    <span>ZeroTangle 2.0 - Chống rối</span>
                                                </div>
                                                <div class="feature-item">
                                                    <div class="feature-icon">
                                                        <i class="fas fa-tshirt"></i>
                                                    </div>
                                                    <span>Sấy giẻ & giặt giẻ nước nóng</span>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="slide-actions">
                                            <a href="<?php echo home_url('/san-pham'); ?>" class="slide-btn primary">ĐẶT NGAY</a>
                                        </div>
                                    </div>
                                    
                                    <div class="slide-right">
                                        <!-- This area will show the product image as background -->
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                    
                    <!-- Shortcut Categories Row - 3 Columns Layout -->
                    <div class="shortcut-categories">
                        <div class="shortcut-column">
                            <div class="shortcut-item">
                                <div class="shortcut-badge">
                                    <i class="fas fa-star"></i>
                                </div>
                                <span class="shortcut-label">NEW</span>
                            </div>
                            
                            <div class="shortcut-item">
                                <div class="shortcut-badge">
                                    <i class="fas fa-crown"></i>
                                </div>
                                <span class="shortcut-label">VIP</span>
                            </div>
                        </div>
                        
                        <div class="shortcut-column">
                            <div class="shortcut-item">
                                <div class="shortcut-badge">
                                    <i class="fas fa-running"></i>
                                </div>
                                <span class="shortcut-label">MÁY CHẠY BỘ</span>
                            </div>
                            
                            <div class="shortcut-item">
                                <div class="shortcut-badge">
                                    <i class="fas fa-robot"></i>
                                </div>
                                <span class="shortcut-label">ROBOT HÚT BỤI</span>
                            </div>
                        </div>
                        
                        <div class="shortcut-column">
                            <div class="shortcut-item">
                                <div class="shortcut-badge">
                                    <i class="fas fa-wind"></i>
                                </div>
                                <span class="shortcut-label">MÁY LỌC KHÔNG KHÍ</span>
                            </div>
                            
                            <div class="shortcut-item">
                                <div class="shortcut-badge">
                                    <i class="fas fa-cogs"></i>
                                </div>
                                <span class="shortcut-label">PHỤ KIỆN ROBOT</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <?php endif; ?>
    
    <!-- Main Content -->
    <?php if (!is_product()) : ?>
    <main class="main-content" id="main-content">
        <div class="container">
    <?php endif; ?>
