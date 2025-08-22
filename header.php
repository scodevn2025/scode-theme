<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="<?php bloginfo('description'); ?>">
    
    <!-- Preconnect to external domains -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=JetBrains+Mono:wght@400;500;600&display=swap" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- WordPress Head -->
    <?php wp_head(); ?>
    
    <!-- Theme Custom CSS -->
    <style>
        /* Additional inline styles for better performance */
        .loading {
            opacity: 0;
            transition: opacity 0.3s ease;
        }
        .loaded {
            opacity: 1;
        }
    </style>
</head>

<body <?php body_class(); ?>>
    <?php wp_body_open(); ?>
    
    <!-- Skip to content link for accessibility -->
    <a class="skip-link screen-reader-text" href="#main-content">
        <?php _e('Skip to content', 'scode-theme'); ?>
    </a>
    
    <!-- Utility Bar (Top dark bar) -->
    <div class="utility-bar">
        <div class="container">
            <div class="utility-links">
                <a href="<?php echo home_url('/chinh-sach-ban-hang'); ?>">Chính sách bán hàng</a>
                <a href="<?php echo home_url('/chinh-sach-van-chuyen'); ?>">Chính sách vận chuyển</a>
            </div>
            <div class="utility-right">
                <a href="<?php echo home_url('/quy-dinh-bao-hanh'); ?>">Quy Định Bảo Hành</a>
                <a href="<?php echo home_url('/chinh-sach-bao-mat'); ?>">Chính Sách Bảo Mật</a>
            </div>
        </div>
    </div>
    
    <!-- Site Header -->
    <header class="site-header" role="banner">
        <div class="container">
            <div class="header-content">
                <!-- Header Left: Logo + Category Toggle -->
                <div class="header-left">
                    <!-- Site Logo -->
                    <div class="site-logo">
                        <span class="mi-icon">MI</span>
                        <div>
                            <div>VIETNAM.VN</div>
                            <div class="since">since 2015</div>
                        </div>
                    </div>
                    
                    <!-- Category Toggle Button -->
                    <button class="category-toggle" id="category-toggle">
                        <i class="fas fa-bars"></i>
                        <span>Danh mục</span>
                    </button>
                </div>
                
                <!-- Search Bar -->
                <div class="search-container">
                    <form role="search" method="get" class="search-form" action="<?php echo home_url('/'); ?>">
                        <input type="search" class="search-input" placeholder="Bạn tìm gì..." value="<?php echo get_search_query(); ?>" name="s" />
                        <button type="submit" class="search-button" aria-label="<?php _e('Search', 'scode-theme'); ?>">
                            <i class="fas fa-search"></i>
                        </button>
                    </form>
                </div>
                
                <!-- Header Actions -->
                <div class="header-actions">
                    <!-- WooCommerce Cart -->
                    <?php if (class_exists('WooCommerce')) : ?>
                        <div class="cart-icon" style="position: relative;">
                            <a href="<?php echo wc_get_cart_url(); ?>" aria-label="<?php _e('View cart', 'scode-theme'); ?>">
                                <i class="fas fa-shopping-cart"></i>
                                <span>Giỏ hàng</span>
                                <span class="cart-count"><?php echo WC()->cart->get_cart_contents_count(); ?></span>
                            </a>
                        </div>
                        
                        <!-- User Account -->
                        <div class="user-account">
                            <?php if (is_user_logged_in()) : ?>
                                <a href="<?php echo get_permalink(get_option('woocommerce_myaccount_page_id')); ?>" aria-label="<?php _e('My account', 'scode-theme'); ?>">
                                    <i class="fas fa-user"></i>
                                    <span>Tài khoản</span>
                                </a>
                            <?php else : ?>
                                <a href="<?php echo get_permalink(get_option('woocommerce_myaccount_page_id')); ?>" aria-label="<?php _e('Login/Register', 'scode-theme'); ?>">
                                    <i class="fas fa-sign-in-alt"></i>
                                    <span>Đăng nhập</span>
                                </a>
                            <?php endif; ?>
                        </div>
                    <?php else : ?>
                        <!-- Fallback if WooCommerce not active -->
                        <div class="user-account">
                            <a href="<?php echo home_url('/wp-admin'); ?>" aria-label="<?php _e('Login', 'scode-theme'); ?>">
                                <i class="fas fa-sign-in-alt"></i>
                                <span>Đăng nhập</span>
                            </a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </header>
    
    <!-- Main Layout Container -->
    <div class="main-layout">
        <!-- Left Sidebar - Mega Menu -->
        <aside class="sidebar-left" id="sidebar-left">
            <nav class="mega-menu" role="navigation" aria-label="<?php _e('Category navigation', 'scode-theme'); ?>">
                <div class="mega-menu-item">
                    <a href="<?php echo home_url('/category/robot-hut-bui'); ?>" class="mega-menu-link">
                        <span class="menu-icon"><i class="fas fa-robot"></i></span>
                        <span>ROBOT HÚT BỤI</span>
                        <span class="arrow"><i class="fas fa-chevron-right"></i></span>
                    </a>
                </div>
                
                <div class="mega-menu-item">
                    <a href="<?php echo home_url('/category/timi-xiaomi'); ?>" class="mega-menu-link">
                        <span class="menu-icon"><i class="fas fa-mobile-alt"></i></span>
                        <span>TIMI XIAOMI</span>
                        <span class="arrow"><i class="fas fa-chevron-right"></i></span>
                    </a>
                </div>
                
                <div class="mega-menu-item">
                    <a href="<?php echo home_url('/category/may-hut-bui'); ?>" class="mega-menu-link">
                        <span class="menu-icon"><i class="fas fa-wind"></i></span>
                        <span>MÁY HÚT BỤI</span>
                        <span class="arrow"><i class="fas fa-chevron-right"></i></span>
                    </a>
                </div>
                
                <div class="mega-menu-item">
                    <a href="<?php echo home_url('/category/may-chay-bo'); ?>" class="mega-menu-link">
                        <span class="menu-icon"><i class="fas fa-running"></i></span>
                        <span>MÁY CHẠY BỘ KINGSMITH</span>
                        <span class="arrow"><i class="fas fa-chevron-right"></i></span>
                    </a>
                </div>
                
                <div class="mega-menu-item">
                    <a href="<?php echo home_url('/category/may-loc-khong-khi'); ?>" class="mega-menu-link">
                        <span class="menu-icon"><i class="fas fa-leaf"></i></span>
                        <span>MÁY LỌC KHÔNG KHÍ</span>
                        <span class="arrow"><i class="fas fa-chevron-right"></i></span>
                    </a>
                </div>
                
                <div class="mega-menu-item">
                    <a href="<?php echo home_url('/category/quat-thong-minh'); ?>" class="mega-menu-link">
                        <span class="menu-icon"><i class="fas fa-fan"></i></span>
                        <span>QUẠT THÔNG MINH</span>
                        <span class="arrow"><i class="fas fa-chevron-right"></i></span>
                    </a>
                </div>
                
                <div class="mega-menu-item">
                    <a href="<?php echo home_url('/category/thiet-bi-gia-dung'); ?>" class="mega-menu-link">
                        <span class="menu-icon"><i class="fas fa-home"></i></span>
                        <span>THIẾT BỊ GIA DỤNG</span>
                        <span class="arrow"><i class="fas fa-chevron-right"></i></span>
                    </a>
                </div>
                
                <div class="mega-menu-item">
                    <a href="<?php echo home_url('/category/camera-wifi'); ?>" class="mega-menu-link">
                        <span class="menu-icon"><i class="fas fa-video"></i></span>
                        <span>CAMERA - THIẾT BỊ WIFI</span>
                        <span class="arrow"><i class="fas fa-chevron-right"></i></span>
                    </a>
                </div>
                
                <div class="mega-menu-item">
                    <a href="<?php echo home_url('/category/suc-khoe-the-thao'); ?>" class="mega-menu-link">
                        <span class="menu-icon"><i class="fas fa-heartbeat"></i></span>
                        <span>SỨC KHỎE - THỂ THAO</span>
                        <span class="arrow"><i class="fas fa-chevron-right"></i></span>
                    </a>
                </div>
                
                <div class="mega-menu-item">
                    <a href="<?php echo home_url('/category/flycam-dji'); ?>" class="mega-menu-link">
                        <span class="menu-icon"><i class="fas fa-plane"></i></span>
                        <span>FLYCAM - THIẾT BỊ QUAY DJI</span>
                        <span class="arrow"><i class="fas fa-chevron-right"></i></span>
                    </a>
                </div>
                
                <div class="mega-menu-item">
                    <a href="<?php echo home_url('/category/phu-kien-robot'); ?>" class="mega-menu-link">
                        <span class="menu-icon"><i class="fas fa-tools"></i></span>
                        <span>PHỤ KIỆN ROBOT</span>
                        <span class="arrow"><i class="fas fa-chevron-right"></i></span>
                    </a>
                </div>
                
                <div class="mega-menu-item">
                    <a href="<?php echo home_url('/category/sua-chua-robot'); ?>" class="mega-menu-link">
                        <span class="menu-icon"><i class="fas fa-wrench"></i></span>
                        <span>SỬA CHỮA ROBOT HÚT BỤI</span>
                        <span class="arrow"><i class="fas fa-chevron-right"></i></span>
                    </a>
                </div>
            </nav>
        </aside>
        
        <!-- Main Content Area -->
        <main class="main-content" id="main-content">
