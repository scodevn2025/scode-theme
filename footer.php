        </div><!-- .container -->
    </main><!-- .main-content -->

    <!-- Site Footer -->
    <footer class="site-footer" role="contentinfo">
        <div class="container">
            <div class="footer-widgets">
                <!-- About Us Widget -->
                <div class="footer-widget">
                    <h3>Về chúng tôi</h3>
                    <p>OTNT Ông Trùm Nội Trợ — hệ thống bán lẻ gia dụng & smart home hàng đầu Việt Nam với các sản phẩm chất lượng cao và dịch vụ chăm sóc khách hàng tốt nhất.</p>
                    
                    <div class="contact-info">
                        <p><i class="fas fa-phone"></i> Hotline: <?php echo esc_html(get_theme_mod('scode_hotline', '0834.777.111')); ?></p>
                        <p><i class="fas fa-envelope"></i> Email: <?php echo esc_html(get_theme_mod('scode_email', 'info@otnt.vn')); ?></p>
                        <p><i class="fas fa-map-marker-alt"></i> Địa chỉ: <?php echo esc_html(get_theme_mod('scode_address', 'Hà Nội, Việt Nam')); ?></p>
                    </div>
                </div>
                
                <!-- Policy Widget -->
                <div class="footer-widget">
                    <h3>Chính sách</h3>
                    <ul>
                        <li><a href="<?php echo home_url('/bao-hanh'); ?>">Bảo hành</a></li>
                        <li><a href="<?php echo home_url('/van-chuyen'); ?>">Vận chuyển</a></li>
                        <li><a href="<?php echo home_url('/doi-tra'); ?>">Đổi trả</a></li>
                        <li><a href="<?php echo home_url('/chinh-sach-ban-hang'); ?>">Chính sách bán hàng</a></li>
                        <li><a href="<?php echo home_url('/chinh-sach-bao-mat'); ?>">Chính sách bảo mật</a></li>
                    </ul>
                </div>
                
                <!-- Support Widget -->
                <div class="footer-widget">
                    <h3>Hỗ trợ</h3>
                    <ul>
                        <li><a href="<?php echo home_url('/huong-dan'); ?>">Hướng dẫn mua hàng</a></li>
                        <li><a href="<?php echo home_url('/faq'); ?>">Câu hỏi thường gặp</a></li>
                        <li><a href="<?php echo home_url('/quy-dinh-bao-hanh'); ?>">Quy định bảo hành</a></li>
                        <li><a href="<?php echo home_url('/lien-he'); ?>">Liên hệ hỗ trợ</a></li>
                        <li><a href="<?php echo home_url('/bao-hanh-online'); ?>">Bảo hành online</a></li>
                    </ul>
                </div>
                
                <!-- Newsletter Widget -->
                <div class="footer-widget">
                    <h3>Đăng ký nhận tin</h3>
                    <p>Nhận thông tin về sản phẩm mới và khuyến mãi đặc biệt</p>
                    
                    <form class="newsletter-form" action="#" method="post">
                        <div class="newsletter-input">
                            <input type="email" name="newsletter_email" placeholder="Email của bạn" required>
                            <button type="submit" class="newsletter-submit">
                                <i class="fas fa-paper-plane"></i>
                            </button>
                        </div>
                    </form>
                    
                    <!-- Social Media Links -->
                    <div class="social-links">
                        <h4>Theo dõi chúng tôi</h4>
                        <div class="social-icons">
                            <?php if (get_theme_mod('scode_social_facebook')) : ?>
                                <a href="<?php echo esc_url(get_theme_mod('scode_social_facebook')); ?>" target="_blank" aria-label="Facebook">
                                    <i class="fab fa-facebook-f"></i>
                                </a>
                            <?php endif; ?>
                            
                            <?php if (get_theme_mod('scode_social_instagram')) : ?>
                                <a href="<?php echo esc_url(get_theme_mod('scode_social_instagram')); ?>" target="_blank" aria-label="Instagram">
                                    <i class="fab fa-instagram"></i>
                                </a>
                            <?php endif; ?>
                            
                            <?php if (get_theme_mod('scode_social_youtube')) : ?>
                                <a href="<?php echo esc_url(get_theme_mod('scode_social_youtube')); ?>" target="_blank" aria-label="YouTube">
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
                        <p>&copy; <?php echo date('Y'); ?> <?php bloginfo('name'); ?>. <?php echo esc_html(get_theme_mod('scode_footer_text', 'Tất cả quyền được bảo lưu.')); ?></p>
                    </div>
                    
                    <div class="payment-icons">
                        <div class="payment-icon">VISA</div>
                        <div class="payment-icon">MC</div>
                        <div class="payment-icon">MOMO</div>
                        <div class="payment-icon">ZALO</div>
                        <div class="payment-icon">COD</div>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    
    <!-- Back to Top Button -->
    <button id="back-to-top" class="back-to-top" aria-label="<?php _e('Back to top', 'scode-theme'); ?>">
        <i class="fas fa-chevron-up"></i>
    </button>
    
    <!-- WordPress Footer -->
    <?php wp_footer(); ?>
</body>
</html>
