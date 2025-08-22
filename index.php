<?php
/**
 * The main template file - Simplified Version
 *
 * @package ScodeTheme
 */

get_header(); ?>

<!-- Icons Row Section -->
<section class="icons-row">
    <div class="container">
        <div class="icons-grid">
            <div class="icon-item">
                <i class="fas fa-truck"></i>
                <h4>Giao nhanh</h4>
                <p>2–4h nội thành</p>
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
                <p>Hotline 0834.777.111</p>
            </div>
        </div>
    </div>
</section>

<!-- Flash Sale Section -->
<section class="product-section">
    <div class="container">
        <div class="section-header">
            <h2 class="section-title">FLASH SALE</h2>
            <div class="flash-sale-countdown">
                <span>Flash Sale: </span>
                <div class="countdown-timer">
                    <div class="countdown-segment" id="countdown-hours">00</div>
                    <span>:</span>
                    <div class="countdown-segment" id="countdown-minutes">00</div>
                    <span>:</span>
                    <div class="countdown-segment" id="countdown-seconds">00</div>
                </div>
            </div>
            <a href="<?php echo home_url('/khuyen-mai/flash-sale'); ?>" class="view-all">Xem tất cả</a>
        </div>
        
        <div class="products-grid cols-5">
            <div class="product-card">
                <div class="product-badges">
                    <div class="product-badge sale">-20%</div>
                </div>
                <div class="product-image">
                    <a href="#">
                        <img src="<?php echo get_template_directory_uri(); ?>/assets/img/placeholder-product.jpg" alt="Sản phẩm mẫu" onerror="this.style.display='none'">
                    </a>
                </div>
                <div class="product-info">
                    <h3 class="product-title">
                        <a href="#">Robot hút bụi thông minh</a>
                    </h3>
                    <div class="product-price">
                        <span class="old-price">2.500.000đ</span>
                        <span class="current-price">2.000.000đ</span>
                    </div>
                    <div class="product-actions">
                        <button class="add-to-cart" data-product-id="1">
                            Thêm vào giỏ
                        </button>
                        <button class="quick-view" data-product-id="1">
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>
                </div>
            </div>
            
            <div class="product-card">
                <div class="product-badges">
                    <div class="product-badge sale">-15%</div>
                </div>
                <div class="product-image">
                    <a href="#">
                        <img src="<?php echo get_template_directory_uri(); ?>/assets/img/placeholder-product.jpg" alt="Sản phẩm mẫu" onerror="this.style.display='none'">
                    </a>
                </div>
                <div class="product-info">
                    <h3 class="product-title">
                        <a href="#">Máy lọc không khí cao cấp</a>
                    </h3>
                    <div class="product-price">
                        <span class="old-price">3.200.000đ</span>
                        <span class="current-price">2.720.000đ</span>
                    </div>
                    <div class="product-actions">
                        <button class="add-to-cart" data-product-id="2">
                            Thêm vào giỏ
                        </button>
                        <button class="quick-view" data-product-id="2">
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>
                </div>
            </div>
            
            <div class="product-card">
                <div class="product-badges">
                    <div class="product-badge sale">-25%</div>
                </div>
                <div class="product-image">
                    <a href="#">
                        <img src="<?php echo get_template_directory_uri(); ?>/assets/img/placeholder-product.jpg" alt="Sản phẩm mẫu" onerror="this.style.display='none'">
                    </a>
                </div>
                <div class="product-info">
                    <h3 class="product-title">
                        <a href="#">Smartwatch thể thao</a>
                    </h3>
                    <div class="product-price">
                        <span class="old-price">1.800.000đ</span>
                        <span class="current-price">1.350.000đ</span>
                    </div>
                    <div class="product-actions">
                        <button class="add-to-cart" data-product-id="3">
                            Thêm vào giỏ
                        </button>
                        <button class="quick-view" data-product-id="3">
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>
                </div>
            </div>
            
            <div class="product-card">
                <div class="product-badges">
                    <div class="product-badge sale">-30%</div>
                </div>
                <div class="product-image">
                    <a href="#">
                        <img src="<?php echo get_template_directory_uri(); ?>/assets/img/placeholder-product.jpg" alt="Sản phẩm mẫu" onerror="this.style.display='none'">
                    </a>
                </div>
                <div class="product-info">
                    <h3 class="product-title">
                        <a href="#">Máy lọc nước gia đình</a>
                    </h3>
                    <div class="product-price">
                        <span class="old-price">4.500.000đ</span>
                        <span class="current-price">3.150.000đ</span>
                    </div>
                    <div class="product-actions">
                        <button class="add-to-cart" data-product-id="4">
                            Thêm vào giỏ
                        </button>
                        <button class="quick-view" data-product-id="4">
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>
                </div>
            </div>
            
            <div class="product-card">
                <div class="product-badges">
                    <div class="product-badge sale">-18%</div>
                </div>
                <div class="product-image">
                    <a href="#">
                        <img src="<?php echo get_template_directory_uri(); ?>/assets/img/placeholder-product.jpg" alt="Sản phẩm mẫu" onerror="this.style.display='none'">
                    </a>
                </div>
                <div class="product-info">
                    <h3 class="product-title">
                        <a href="#">Điện thoại thông minh</a>
                    </h3>
                    <div class="product-price">
                        <span class="old-price">8.900.000đ</span>
                        <span class="current-price">7.298.000đ</span>
                    </div>
                    <div class="product-actions">
                        <button class="add-to-cart" data-product-id="5">
                            Thêm vào giỏ
                        </button>
                        <button class="quick-view" data-product-id="5">
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Mid Banner 1 -->
<section class="banner-wide">
    <div class="container">
        <a href="<?php echo home_url('/khuyen-mai'); ?>">
            <div style="background: linear-gradient(135deg, #f36c21, #ff8c42); height: 200px; border-radius: 10px; display: flex; align-items: center; justify-content: center; color: white; font-size: 24px; font-weight: bold;">
                🎉 KHUYẾN MÃI ĐẶC BIỆT 🎉
            </div>
        </a>
    </div>
</section>

<!-- Featured Products Section -->
<section class="product-section">
    <div class="container">
        <div class="section-header">
            <h2 class="section-title">Sản phẩm nổi bật</h2>
            <a href="<?php echo home_url('/san-pham-noi-bat'); ?>" class="view-all">Xem tất cả</a>
        </div>
        
        <div class="products-grid cols-6">
            <div class="product-card">
                <div class="product-badges">
                    <div class="product-badge featured">FEATURED</div>
                </div>
                <div class="product-image">
                    <a href="#">
                        <img src="<?php echo get_template_directory_uri(); ?>/assets/img/placeholder-product.jpg" alt="Sản phẩm mẫu" onerror="this.style.display='none'">
                    </a>
                </div>
                <div class="product-info">
                    <h3 class="product-title">
                        <a href="#">Laptop gaming cao cấp</a>
                    </h3>
                    <div class="product-price">
                        <span class="current-price">25.000.000đ</span>
                    </div>
                    <div class="product-actions">
                        <button class="add-to-cart" data-product-id="6">
                            Thêm vào giỏ
                        </button>
                        <button class="quick-view" data-product-id="6">
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>
                </div>
            </div>
            
            <div class="product-card">
                <div class="product-badges">
                    <div class="product-badge new">NEW</div>
                </div>
                <div class="product-image">
                    <a href="#">
                        <img src="<?php echo get_template_directory_uri(); ?>/assets/img/placeholder-product.jpg" alt="Sản phẩm mẫu" onerror="this.style.display='none'">
                    </a>
                </div>
                <div class="product-info">
                    <h3 class="product-title">
                        <a href="#">Tai nghe không dây</a>
                    </h3>
                    <div class="product-price">
                        <span class="current-price">2.500.000đ</span>
                    </div>
                    <div class="product-actions">
                        <button class="add-to-cart" data-product-id="7">
                            Thêm vào giỏ
                        </button>
                        <button class="quick-view" data-product-id="7">
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>
                </div>
            </div>
            
            <div class="product-card">
                <div class="product-image">
                    <a href="#">
                        <img src="<?php echo get_template_directory_uri(); ?>/assets/img/placeholder-product.jpg" alt="Sản phẩm mẫu" onerror="this.style.display='none'">
                    </a>
                </div>
                <div class="product-info">
                    <h3 class="product-title">
                        <a href="#">Máy tính bảng</a>
                    </h3>
                    <div class="product-price">
                        <span class="current-price">12.000.000đ</span>
                    </div>
                    <div class="product-actions">
                        <button class="add-to-cart" data-product-id="8">
                            Thêm vào giỏ
                        </button>
                        <button class="quick-view" data-product-id="8">
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>
                </div>
            </div>
            
            <div class="product-card">
                <div class="product-image">
                    <a href="#">
                        <img src="<?php echo get_template_directory_uri(); ?>/assets/img/placeholder-product.jpg" alt="Sản phẩm mẫu" onerror="this.style.display='none'">
                    </a>
                </div>
                <div class="product-info">
                    <h3 class="product-title">
                        <a href="#">Camera an ninh</a>
                    </h3>
                    <div class="product-price">
                        <span class="current-price">1.800.000đ</span>
                    </div>
                    <div class="product-actions">
                        <button class="add-to-cart" data-product-id="9">
                            Thêm vào giỏ
                        </button>
                        <button class="quick-view" data-product-id="9">
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>
                </div>
            </div>
            
            <div class="product-card">
                <div class="product-image">
                    <a href="#">
                        <img src="<?php echo get_template_directory_uri(); ?>/assets/img/placeholder-product.jpg" alt="Sản phẩm mẫu" onerror="this.style.display='none'">
                    </a>
                </div>
                <div class="product-info">
                    <h3 class="product-title">
                        <a href="#">Loa bluetooth</a>
                    </h3>
                    <div class="product-price">
                        <span class="current-price">800.000đ</span>
                    </div>
                    <div class="product-actions">
                        <button class="add-to-cart" data-product-id="10">
                            Thêm vào giỏ
                        </button>
                        <button class="quick-view" data-product-id="10">
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>
                </div>
            </div>
            
            <div class="product-card">
                <div class="product-image">
                    <a href="#">
                        <img src="<?php echo get_template_directory_uri(); ?>/assets/img/placeholder-product.jpg" alt="Sản phẩm mẫu" onerror="this.style.display='none'">
                    </a>
                </div>
                <div class="product-info">
                    <h3 class="product-title">
                        <a href="#">Đồng hồ thông minh</a>
                    </h3>
                    <div class="product-price">
                        <span class="current-price">3.500.000đ</span>
                    </div>
                    <div class="product-actions">
                        <button class="add-to-cart" data-product-id="11">
                            Thêm vào giỏ
                        </button>
                        <button class="quick-view" data-product-id="11">
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Category Strip Section -->
<section class="category-strip">
    <div class="container">
        <div class="section-header">
            <h2 class="section-title">Danh mục nổi bật</h2>
        </div>
        
        <div class="categories-grid">
            <a href="<?php echo home_url('/danh-muc/robot-hut-bui'); ?>" class="category-item">
                <div class="category-thumb">
                    <div style="background: linear-gradient(135deg, #f36c21, #ff8c42); height: 150px; border-radius: 10px; display: flex; align-items: center; justify-content: center; color: white; font-size: 48px;">
                        🤖
                    </div>
                </div>
                <div class="category-label">Robot hút bụi</div>
            </a>
            
            <a href="<?php echo home_url('/danh-muc/may-loc-khong-khi'); ?>" class="category-item">
                <div class="category-thumb">
                    <div style="background: linear-gradient(135deg, #17a2b8, #20c997); height: 150px; border-radius: 10px; display: flex; align-items: center; justify-content: center; color: white; font-size: 48px;">
                        🌬️
                    </div>
                </div>
                <div class="category-label">Máy lọc không khí</div>
            </a>
            
            <a href="<?php echo home_url('/danh-muc/may-loc-nuoc'); ?>" class="category-item">
                <div class="category-thumb">
                    <div style="background: linear-gradient(135deg, #007bff, #6610f2); height: 150px; border-radius: 10px; display: flex; align-items: center; justify-content: center; color: white; font-size: 48px;">
                        💧
                    </div>
                </div>
                <div class="category-label">Máy lọc nước</div>
            </a>
            
            <a href="<?php echo home_url('/danh-muc/smartwatch'); ?>" class="category-item">
                <div class="category-thumb">
                    <div style="background: linear-gradient(135deg, #28a745, #20c997); height: 150px; border-radius: 10px; display: flex; align-items: center; justify-content: center; color: white; font-size: 48px;">
                        ⌚
                    </div>
                </div>
                <div class="category-label">Smartwatch</div>
            </a>
            
            <a href="<?php echo home_url('/danh-muc/phu-kien'); ?>" class="category-item">
                <div class="category-thumb">
                    <div style="background: linear-gradient(135deg, #6f42c1, #e83e8c); height: 150px; border-radius: 10px; display: flex; align-items: center; justify-content: center; color: white; font-size: 48px;">
                        🔌
                    </div>
                </div>
                <div class="category-label">Phụ kiện</div>
            </a>
        </div>
    </div>
</section>

<?php get_footer(); ?>
