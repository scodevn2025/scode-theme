<?php
/**
 * The sidebar containing the main widget area
 *
 * @package ScodeTheme
 */

if (!is_active_sidebar('sidebar-1')) {
    return;
}
?>

<aside id="secondary" class="sidebar" role="complementary">
    <?php dynamic_sidebar('sidebar-1'); ?>
    
    <!-- Default Sidebar Content if no widgets -->
    <?php if (!is_active_sidebar('sidebar-1')) : ?>
        <div class="widget">
            <h3 class="widget-title"><?php _e('About ScodeTheme', 'scode-theme'); ?></h3>
            <p><?php _e('A modern WordPress theme optimized for performance and user experience. Perfect for blogs, portfolios, and e-commerce websites.', 'scode-theme'); ?></p>
        </div>
        
        <div class="widget">
            <h3 class="widget-title"><?php _e('Recent Posts', 'scode-theme'); ?></h3>
            <ul>
                <?php
                $recent_posts = wp_get_recent_posts(array(
                    'numberposts' => 5,
                    'post_status' => 'publish'
                ));
                
                foreach ($recent_posts as $post) : ?>
                    <li>
                        <a href="<?php echo get_permalink($post['ID']); ?>">
                            <?php echo $post['post_title']; ?>
                        </a>
                        <span class="post-date"><?php echo get_the_date('', $post['ID']); ?></span>
                    </li>
                <?php endforeach;
                wp_reset_postdata();
                ?>
            </ul>
        </div>
        
        <?php if (class_exists('WooCommerce')) : ?>
            <div class="widget">
                <h3 class="widget-title"><?php _e('Recent Products', 'scode-theme'); ?></h3>
                <ul>
                    <?php
                    $recent_products = wc_get_recent_products(array(
                        'limit' => 5,
                        'status' => 'publish'
                    ));
                    
                    foreach ($recent_products as $product) : ?>
                        <li>
                            <a href="<?php echo get_permalink($product->get_id()); ?>">
                                <?php echo $product->get_name(); ?>
                            </a>
                            <span class="product-price"><?php echo $product->get_price_html(); ?></span>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>
        
        <div class="widget">
            <h3 class="widget-title"><?php _e('Categories', 'scode-theme'); ?></h3>
            <ul>
                <?php
                $categories = get_categories(array(
                    'orderby' => 'count',
                    'order' => 'DESC',
                    'number' => 10
                ));
                
                foreach ($categories as $category) : ?>
                    <li>
                        <a href="<?php echo get_category_link($category->term_id); ?>">
                            <?php echo $category->name; ?>
                        </a>
                        <span class="category-count">(<?php echo $category->count; ?>)</span>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
        
        <div class="widget">
            <h3 class="widget-title"><?php _e('Tags', 'scode-theme'); ?></h3>
            <div class="tag-cloud">
                <?php
                $tags = get_tags(array(
                    'orderby' => 'count',
                    'order' => 'DESC',
                    'number' => 20
                ));
                
                foreach ($tags as $tag) : ?>
                    <a href="<?php echo get_tag_link($tag->term_id); ?>" class="tag-link">
                        <?php echo $tag->name; ?>
                    </a>
                <?php endforeach; ?>
            </div>
        </div>
        
        <div class="widget">
            <h3 class="widget-title"><?php _e('Newsletter', 'scode-theme'); ?></h3>
            <p><?php _e('Subscribe to our newsletter for updates and exclusive content.', 'scode-theme'); ?></p>
            <form class="newsletter-form" method="post">
                <div class="newsletter-input">
                    <input type="email" name="newsletter_email" placeholder="<?php _e('Your email address', 'scode-theme'); ?>" required>
                    <button type="submit" class="newsletter-submit">
                        <i class="fas fa-paper-plane"></i>
                    </button>
                </div>
            </form>
        </div>
        
        <div class="widget">
            <h3 class="widget-title"><?php _e('Follow Us', 'scode-theme'); ?></h3>
            <div class="social-links">
                <a href="#" aria-label="Facebook" class="social-link">
                    <i class="fab fa-facebook"></i>
                </a>
                <a href="#" aria-label="Twitter" class="social-link">
                    <i class="fab fa-twitter"></i>
                </a>
                <a href="#" aria-label="Instagram" class="social-link">
                    <i class="fab fa-instagram"></i>
                </a>
                <a href="#" aria-label="LinkedIn" class="social-link">
                    <i class="fab fa-linkedin"></i>
                </a>
                <a href="#" aria-label="YouTube" class="social-link">
                    <i class="fab fa-youtube"></i>
                </a>
            </div>
        </div>
    <?php endif; ?>
</aside>
