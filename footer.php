        </main><!-- .main-content -->
    </div><!-- .main-layout -->

    <!-- Site Footer -->
    <footer class="site-footer" role="contentinfo">
        <div class="container">
            <div class="footer-content">
                <!-- Company Information -->
                <div class="footer-section">
                    <h3>Về OTNT - ÔNG TRÙM NỘI TRỢ</h3>
                    <p>Cửa hàng công nghệ hàng đầu Việt Nam với các sản phẩm chất lượng cao và dịch vụ chăm sóc khách hàng tốt nhất.</p>
                    
                    <?php if (scode_theme_get_option('hotline')) : ?>
                        <div class="contact-info">
                            <p><i class="fas fa-phone"></i> <?php echo esc_html(scode_theme_get_option('hotline')); ?></p>
                        </div>
                    <?php endif; ?>
                    
                    <?php if (scode_theme_get_option('email')) : ?>
                        <div class="contact-info">
                            <p><i class="fas fa-envelope"></i> <?php echo esc_html(scode_theme_get_option('email')); ?></p>
                        </div>
                    <?php endif; ?>
                    
                    <?php if (scode_theme_get_option('address')) : ?>
                        <div class="contact-info">
                            <p><i class="fas fa-map-marker-alt"></i> <?php echo esc_html(scode_theme_get_option('address')); ?></p>
                        </div>
                    <?php endif; ?>
                </div>
                
                <!-- Quick Links -->
                <div class="footer-section">
                    <h3>Liên kết nhanh</h3>
                    <ul class="footer-links">
                        <li><a href="<?php echo home_url(); ?>">Trang chủ</a></li>
                        <li><a href="<?php echo home_url('/about'); ?>">Về chúng tôi</a></li>
                        <li><a href="<?php echo home_url('/contact'); ?>">Liên hệ</a></li>
                        <?php if (class_exists('WooCommerce')) : ?>
                            <li><a href="<?php echo wc_get_page_permalink('shop'); ?>">Cửa hàng</a></li>
                            <li><a href="<?php echo wc_get_page_permalink('myaccount'); ?>">Tài khoản</a></li>
                        <?php endif; ?>
                    </ul>
                </div>
                
                <!-- Customer Service -->
                <div class="footer-section">
                    <h3>Chăm sóc khách hàng</h3>
                    <ul class="footer-links">
                        <li><a href="<?php echo home_url('/chinh-sach-ban-hang'); ?>">Chính sách bán hàng</a></li>
                        <li><a href="<?php echo home_url('/chinh-sach-van-chuyen'); ?>">Chính sách vận chuyển</a></li>
                        <li><a href="<?php echo home_url('/quy-dinh-bao-hanh'); ?>">Quy định bảo hành</a></li>
                        <li><a href="<?php echo home_url('/chinh-sach-bao-mat'); ?>">Chính sách bảo mật</a></li>
                        <li><a href="<?php echo home_url('/huong-dan-mua-hang'); ?>">Hướng dẫn mua hàng</a></li>
                    </ul>
                </div>
                
                <!-- Newsletter & Social -->
                <div class="footer-section">
                    <h3>Đăng ký nhận tin</h3>
                    <p>Nhận thông tin về sản phẩm mới và khuyến mãi đặc biệt</p>
                    
                    <form class="newsletter-form" action="#" method="post">
                        <div class="newsletter-input">
                            <input type="email" placeholder="Email của bạn" required>
                            <button type="submit" class="newsletter-btn">
                                <i class="fas fa-paper-plane"></i>
                            </button>
                        </div>
                    </form>
                    
                    <!-- Social Media Links -->
                    <div class="social-links">
                        <h4>Theo dõi chúng tôi</h4>
                        <div class="social-icons">
                            <?php if (scode_theme_get_option('social_facebook')) : ?>
                                <a href="<?php echo esc_url(scode_theme_get_option('social_facebook')); ?>" target="_blank" aria-label="Facebook">
                                    <i class="fab fa-facebook-f"></i>
                                </a>
                            <?php endif; ?>
                            
                            <?php if (scode_theme_get_option('social_twitter')) : ?>
                                <a href="<?php echo esc_url(scode_theme_get_option('social_twitter')); ?>" target="_blank" aria-label="Twitter">
                                    <i class="fab fa-twitter"></i>
                                </a>
                            <?php endif; ?>
                            
                            <?php if (scode_theme_get_option('social_instagram')) : ?>
                                <a href="<?php echo esc_url(scode_theme_get_option('social_instagram')); ?>" target="_blank" aria-label="Instagram">
                                    <i class="fab fa-instagram"></i>
                                </a>
                            <?php endif; ?>
                            
                            <?php if (scode_theme_get_option('social_youtube')) : ?>
                                <a href="<?php echo esc_url(scode_theme_get_option('social_youtube')); ?>" target="_blank" aria-label="YouTube">
                                    <i class="fab fa-youtube"></i>
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Footer Bottom -->
            <div class="footer-bottom">
                <div class="footer-bottom-content">
                    <div class="copyright">
                        <p>&copy; <?php echo date('Y'); ?> <?php bloginfo('name'); ?>. <?php echo esc_html(scode_theme_get_option('footer_text', 'Tất cả quyền được bảo lưu.')); ?></p>
                    </div>
                    
                    <div class="footer-bottom-links">
                        <a href="<?php echo home_url('/dieu-khoan-su-dung'); ?>">Điều khoản sử dụng</a>
                        <a href="<?php echo home_url('/chinh-sach-bao-mat'); ?>">Chính sách bảo mật</a>
                        <a href="<?php echo home_url('/sitemap'); ?>">Sitemap</a>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    
    <!-- Back to Top Button -->
    <button id="back-to-top" class="back-to-top" aria-label="<?php _e('Back to top', 'scode-theme'); ?>">
        <i class="fas fa-chevron-up"></i>
    </button>
    
    <!-- Loading Overlay -->
    <div class="loading-overlay" id="loading-overlay">
        <div class="loading-spinner">
            <i class="fas fa-spinner fa-spin"></i>
        </div>
    </div>
    
    <!-- WordPress Footer -->
    <?php wp_footer(); ?>
</body>
</html>
