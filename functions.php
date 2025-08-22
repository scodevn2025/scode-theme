<?php
/**
 * ScodeTheme Functions
 * 
 * @package ScodeTheme
 * @version 2.0.0
 * 
 * Theme Architecture:
 * - Assets organization (CSS/JS/IMG/Fonts)
 * - WooCommerce integration
 * - Custom Post Types & Taxonomies
 * - Theme Options (ACF)
 * - Component system
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Theme Setup & Foundation
 */
function scode_theme_setup() {
    // Add theme support for various features
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('custom-logo');
    add_theme_support('custom-background');
    add_theme_support('custom-header');
    add_theme_support('html5', array(
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
        'style',
        'script'
    ));
    
    // WooCommerce support
    add_theme_support('woocommerce');
    add_theme_support('wc-product-gallery-zoom');
    add_theme_support('wc-product-gallery-lightbox');
    add_theme_support('wc-product-gallery-slider');
    
    // Hide admin bar for non-admin users
    if (!current_user_can('administrator')) {
        show_admin_bar(false);
    }
    
    // Editor styles
    add_theme_support('editor-styles');
    add_editor_style('assets/css/editor-style.css');
    
    // Set content width (1200-1320px as per requirements)
    if (!isset($content_width)) {
        $content_width = 1320;
    }
    
    // Register navigation menus
    register_nav_menus(array(
        'primary' => __('Primary Menu', 'scode-theme'),
        'mega-menu' => __('Mega Menu Categories', 'scode-theme'),
        'footer' => __('Footer Menu', 'scode-theme'),
        'mobile' => __('Mobile Menu', 'scode-theme')
    ));
    
    // Add image sizes
    add_image_size('scode-thumbnail', 350, 250, true);
    add_image_size('scode-medium', 600, 400, true);
    add_image_size('scode-large', 800, 600, true);
    add_image_size('scode-hero', 1320, 600, true);
    add_image_size('scode-product-card', 280, 280, true);
    add_image_size('scode-brand-logo', 120, 60, true);
}
add_action('after_setup_theme', 'scode_theme_setup');

/**
 * Enqueue scripts and styles with proper versioning
 */
function scode_theme_scripts() {
    // Get file modification time for versioning
    $css_version = file_exists(get_template_directory() . '/assets/css/main.css') 
        ? filemtime(get_template_directory() . '/assets/css/main.css') 
        : '1.0.0';
    
    $js_version = file_exists(get_template_directory() . '/assets/js/main.js') 
        ? filemtime(get_template_directory() . '/assets/js/main.js') 
        : '1.0.0';
    
    // Enqueue main stylesheet
    wp_enqueue_style('scode-theme-style', get_stylesheet_uri(), array(), '1.0.0');
    
    // Enqueue main CSS file - ensure this loads
    if (file_exists(get_template_directory() . '/assets/css/main.css')) {
        wp_enqueue_style('scode-main', get_template_directory_uri() . '/assets/css/main.css', array(), $css_version);
    }
    
    // Enqueue custom CSS file
    if (file_exists(get_template_directory() . '/assets/css/custom.css')) {
        wp_enqueue_style('scode-custom', get_template_directory_uri() . '/assets/css/custom.css', array('scode-main'), $css_version);
    }
    
    // Google Fonts
    wp_enqueue_style('scode-google-fonts', 'https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=JetBrains+Mono:wght@400;500;600&display=swap', array(), null);
    
    // Font Awesome
    wp_enqueue_style('scode-fontawesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css', array(), '6.4.0');
    
    // Swiper for sliders
    wp_enqueue_style('swiper', 'https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css', array(), '10.0.0');
    
    // Enqueue theme JavaScript
    wp_enqueue_script('swiper', 'https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js', array(), '10.0.0', true);
    wp_enqueue_script('scode-main', get_template_directory_uri() . '/assets/js/main.js', array('swiper'), $js_version, true);
    
    // Localize script for AJAX
    wp_localize_script('scode-main', 'scode_ajax', array(
        'ajax_url' => admin_url('admin-ajax.php'),
        'nonce' => wp_create_nonce('scode_nonce'),
        'home_url' => home_url(),
        'is_woocommerce' => class_exists('WooCommerce')
    ));
    
    // Comment reply script
    if (is_singular() && comments_open() && get_option('thread_comments')) {
        wp_enqueue_script('comment-reply');
    }
}
add_action('wp_enqueue_scripts', 'scode_theme_scripts');

/**
 * Register widget areas
 */
function scode_theme_widgets_init() {
    // Sidebar
    register_sidebar(array(
        'name'          => __('Sidebar', 'scode-theme'),
        'id'            => 'sidebar-1',
        'description'   => __('Add widgets here to appear in your sidebar.', 'scode-theme'),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget'  => '</section>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ));
    
    // Footer widget areas
    for ($i = 1; $i <= 4; $i++) {
        register_sidebar(array(
            'name'          => sprintf(__('Footer Widget Area %d', 'scode-theme'), $i),
            'id'            => 'footer-' . $i,
            'description'   => sprintf(__('Add widgets here to appear in footer area %d.', 'scode-theme'), $i),
            'before_widget' => '<div id="%1$s" class="widget %2$s">',
            'after_widget'  => '</div>',
            'before_title'  => '<h3 class="widget-title">',
            'after_title'   => '</h3>',
        ));
    }
}
add_action('widgets_init', 'scode_theme_widgets_init');

/**
 * Custom Post Types
 */
function scode_theme_custom_post_types() {
    // Deal/Flash Sale CPT
    register_post_type('deal', array(
        'labels' => array(
            'name' => __('Deals', 'scode-theme'),
            'singular_name' => __('Deal', 'scode-theme'),
            'add_new' => __('Add New Deal', 'scode-theme'),
            'add_new_item' => __('Add New Deal', 'scode-theme'),
            'edit_item' => __('Edit Deal', 'scode-theme'),
            'new_item' => __('New Deal', 'scode-theme'),
            'view_item' => __('View Deal', 'scode-theme'),
            'search_items' => __('Search Deals', 'scode-theme'),
            'not_found' => __('No deals found', 'scode-theme'),
            'not_found_in_trash' => __('No deals found in trash', 'scode-theme'),
        ),
        'public' => true,
        'has_archive' => true,
        'supports' => array('title', 'editor', 'thumbnail', 'excerpt'),
        'menu_icon' => 'dashicons-clock',
        'show_in_rest' => true,
        'rewrite' => array('slug' => 'deal'),
    ));
    
    // Slide CPT for Homepage Slider
    register_post_type('slide', array(
        'labels' => array(
            'name' => __('Slides', 'scode-theme'),
            'singular_name' => __('Slide', 'scode-theme'),
            'add_new' => __('Thêm Slide Mới', 'scode-theme'),
            'add_new_item' => __('Thêm Slide Mới', 'scode-theme'),
            'edit_item' => __('Sửa Slide', 'scode-theme'),
            'new_item' => __('Slide Mới', 'scode-theme'),
            'view_item' => __('Xem Slide', 'scode-theme'),
            'search_items' => __('Tìm Slide', 'scode-theme'),
            'not_found' => __('Không tìm thấy slide nào', 'scode-theme'),
            'not_found_in_trash' => __('Không có slide nào trong thùng rác', 'scode-theme'),
        ),
        'public' => true,
        'has_archive' => false,
        'publicly_queryable' => false,
        'supports' => array('title', 'editor', 'thumbnail'),
        'menu_icon' => 'dashicons-slides',
        'show_in_rest' => true,
        'menu_position' => 20,
    ));
}
add_action('init', 'scode_theme_custom_post_types');

/**
 * Custom Taxonomies
 */
function scode_theme_custom_taxonomies() {
    // Brand taxonomy
    register_taxonomy('brand', array('product'), array(
        'labels' => array(
            'name' => __('Brands', 'scode-theme'),
            'singular_name' => __('Brand', 'scode-theme'),
            'search_items' => __('Search Brands', 'scode-theme'),
            'all_items' => __('All Brands', 'scode-theme'),
            'parent_item' => __('Parent Brand', 'scode-theme'),
            'parent_item_colon' => __('Parent Brand:', 'scode-theme'),
            'edit_item' => __('Edit Brand', 'scode-theme'),
            'update_item' => __('Update Brand', 'scode-theme'),
            'add_new_item' => __('Add New Brand', 'scode-theme'),
            'new_item_name' => __('New Brand Name', 'scode-theme'),
            'menu_name' => __('Brands', 'scode-theme'),
        ),
        'hierarchical' => true,
        'show_ui' => true,
        'show_admin_column' => true,
        'query_var' => true,
        'rewrite' => array('slug' => 'brand'),
        'show_in_rest' => true,
    ));
    
    // Feature tags (Nổi bật, Trả góp, etc.)
    register_taxonomy('feature_tag', array('product'), array(
        'labels' => array(
            'name' => __('Feature Tags', 'scode-theme'),
            'singular_name' => __('Feature Tag', 'scode-theme'),
            'search_items' => __('Search Feature Tags', 'scode-theme'),
            'all_items' => __('All Feature Tags', 'scode-theme'),
            'edit_item' => __('Edit Feature Tag', 'scode-theme'),
            'update_item' => __('Update Feature Tag', 'scode-theme'),
            'add_new_item' => __('Add New Feature Tag', 'scode-theme'),
            'new_item_name' => __('New Feature Tag Name', 'scode-theme'),
            'menu_name' => __('Feature Tags', 'scode-theme'),
        ),
        'hierarchical' => false,
        'show_ui' => true,
        'show_admin_column' => true,
        'query_var' => true,
        'rewrite' => array('slug' => 'feature'),
        'show_in_rest' => true,
    ));
    
    // Product Series taxonomy (for Roborock Qrevo series)
    register_taxonomy('product_series', array('product'), array(
        'labels' => array(
            'name' => __('Product Series', 'scode-theme'),
            'singular_name' => __('Product Series', 'scode-theme'),
            'search_items' => __('Search Product Series', 'scode-theme'),
            'all_items' => __('All Product Series', 'scode-theme'),
            'edit_item' => __('Edit Product Series', 'scode-theme'),
            'update_item' => __('Update Product Series', 'scode-theme'),
            'add_new_item' => __('Add New Product Series', 'scode-theme'),
            'new_item_name' => __('New Product Series Name', 'scode-theme'),
            'menu_name' => __('Product Series', 'scode-theme'),
        ),
        'hierarchical' => true,
        'show_ui' => true,
        'show_admin_column' => true,
        'query_var' => true,
        'rewrite' => array('slug' => 'series'),
        'show_in_rest' => true,
    ));
    
    // Product Type taxonomy (for different product types)
    register_taxonomy('product_type', array('product'), array(
        'labels' => array(
            'name' => __('Product Types', 'scode-theme'),
            'singular_name' => __('Product Type', 'scode-theme'),
            'search_items' => __('Search Product Types', 'scode-theme'),
            'all_items' => __('All Product Types', 'scode-theme'),
            'edit_item' => __('Edit Product Type', 'scode-theme'),
            'update_item' => __('Update Product Type', 'scode-theme'),
            'add_new_item' => __('Add New Product Type', 'scode-theme'),
            'new_item_name' => __('New Product Type Name', 'scode-theme'),
            'menu_name' => __('Product Types', 'scode-theme'),
        ),
        'hierarchical' => true,
        'show_ui' => true,
        'show_admin_column' => true,
        'query_var' => true,
        'rewrite' => array('slug' => 'type'),
        'show_in_rest' => true,
    ));
}
add_action('init', 'scode_theme_custom_taxonomies');

/**
 * Custom Meta Boxes for Slides
 */
function scode_theme_slide_meta_boxes() {
    add_meta_box(
        'slide_details',
        'Thông Tin Slide',
        'scode_theme_slide_meta_box_callback',
        'slide',
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', 'scode_theme_slide_meta_boxes');

function scode_theme_slide_meta_box_callback($post) {
    wp_nonce_field('scode_theme_save_slide_meta', 'scode_theme_slide_meta_nonce');
    
    $slide_button_text = get_post_meta($post->ID, '_slide_button_text', true);
    $slide_button_url = get_post_meta($post->ID, '_slide_button_url', true);
    $slide_order = get_post_meta($post->ID, '_slide_order', true);
    $slide_active = get_post_meta($post->ID, '_slide_active', true);
    
    if (empty($slide_order)) $slide_order = 0;
    if (empty($slide_active)) $slide_active = 'yes';
    
    ?>
    <table class="form-table">
        <tr>
            <th scope="row">
                <label for="slide_button_text">Nút CTA</label>
            </th>
            <td>
                <input type="text" id="slide_button_text" name="slide_button_text" 
                       value="<?php echo esc_attr($slide_button_text); ?>" class="regular-text" 
                       placeholder="VD: MUA NGAY, XEM NGAY, KHÁM PHÁ">
                <p class="description">Văn bản hiển thị trên nút (để trống nếu không muốn hiển thị nút)</p>
            </td>
        </tr>
        <tr>
            <th scope="row">
                <label for="slide_button_url">Link Nút</label>
            </th>
            <td>
                <input type="url" id="slide_button_url" name="slide_button_url" 
                       value="<?php echo esc_url($slide_button_url); ?>" class="regular-text" 
                       placeholder="https://example.com">
                <p class="description">URL khi click vào nút</p>
            </td>
        </tr>
        <tr>
            <th scope="row">
                <label for="slide_order">Thứ Tự</label>
            </th>
            <td>
                <input type="number" id="slide_order" name="slide_order" 
                       value="<?php echo esc_attr($slide_order); ?>" class="small-text" min="0">
                <p class="description">Thứ tự hiển thị slide (số nhỏ hiển thị trước)</p>
            </td>
        </tr>
        <tr>
            <th scope="row">
                <label for="slide_active">Trạng Thái</label>
            </th>
            <td>
                <select id="slide_active" name="slide_active">
                    <option value="yes" <?php selected($slide_active, 'yes'); ?>>Kích hoạt</option>
                    <option value="no" <?php selected($slide_active, 'no'); ?>>Ẩn</option>
                </select>
                <p class="description">Chọn trạng thái hiển thị của slide</p>
            </td>
        </tr>
    </table>
    <?php
}

function scode_theme_save_slide_meta($post_id) {
    if (!isset($_POST['scode_theme_slide_meta_nonce']) || 
        !wp_verify_nonce($_POST['scode_theme_slide_meta_nonce'], 'scode_theme_save_slide_meta')) {
        return;
    }
    
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }
    
    if (!current_user_can('edit_post', $post_id)) {
        return;
    }
    
    if (isset($_POST['slide_button_text'])) {
        update_post_meta($post_id, '_slide_button_text', sanitize_text_field($_POST['slide_button_text']));
    }
    
    if (isset($_POST['slide_button_url'])) {
        update_post_meta($post_id, '_slide_button_url', esc_url_raw($_POST['slide_button_url']));
    }
    
    if (isset($_POST['slide_order'])) {
        update_post_meta($post_id, '_slide_order', intval($_POST['slide_order']));
    }
    
    if (isset($_POST['slide_active'])) {
        update_post_meta($post_id, '_slide_active', sanitize_text_field($_POST['slide_active']));
    }
}
add_action('save_post', 'scode_theme_save_slide_meta');

/**
 * Admin Columns for Slides
 */
function scode_theme_slide_admin_columns($columns) {
    $new_columns = array();
    $new_columns['cb'] = $columns['cb'];
    $new_columns['thumbnail'] = 'Hình Ảnh';
    $new_columns['title'] = $columns['title'];
    $new_columns['slide_order'] = 'Thứ Tự';
    $new_columns['slide_status'] = 'Trạng Thái';
    $new_columns['slide_button'] = 'Nút CTA';
    $new_columns['date'] = $columns['date'];
    
    return $new_columns;
}
add_filter('manage_slide_posts_columns', 'scode_theme_slide_admin_columns');

function scode_theme_slide_admin_column_content($column, $post_id) {
    switch ($column) {
        case 'thumbnail':
            if (has_post_thumbnail($post_id)) {
                echo '<img src="' . get_the_post_thumbnail_url($post_id, 'thumbnail') . '" style="width: 60px; height: 60px; object-fit: cover; border-radius: 4px;">';
            } else {
                echo '<span style="color: #999;">Không có hình</span>';
            }
            break;
            
        case 'slide_order':
            $order = get_post_meta($post_id, '_slide_order', true);
            echo $order ? $order : '0';
            break;
            
        case 'slide_status':
            $status = get_post_meta($post_id, '_slide_active', true);
            if ($status === 'yes') {
                echo '<span style="color: #46b450; font-weight: bold;">✓ Kích hoạt</span>';
            } else {
                echo '<span style="color: #dc3232;">✗ Ẩn</span>';
            }
            break;
            
        case 'slide_button':
            $button_text = get_post_meta($post_id, '_slide_button_text', true);
            $button_url = get_post_meta($post_id, '_slide_button_url', true);
            if ($button_text && $button_url) {
                echo '<strong>' . esc_html($button_text) . '</strong><br>';
                echo '<small style="color: #666;">' . esc_url($button_url) . '</small>';
            } else {
                echo '<span style="color: #999;">Không có nút</span>';
            }
            break;
    }
}
add_action('manage_slide_posts_custom_column', 'scode_theme_slide_admin_column_content', 10, 2);

/**
 * Make Slide Order Column Sortable
 */
function scode_theme_slide_sortable_columns($columns) {
    $columns['slide_order'] = 'slide_order';
    return $columns;
}
add_filter('manage_edit-slide_sortable_columns', 'scode_theme_slide_sortable_columns');

/**
 * Get Slides from Database
 */
function scode_theme_get_slides($limit = -1) {
    $args = array(
        'post_type' => 'slide',
        'post_status' => 'publish',
        'posts_per_page' => $limit,
        'meta_query' => array(
            array(
                'key' => '_slide_active',
                'value' => 'yes',
                'compare' => '='
            )
        ),
        'meta_key' => '_slide_order',
        'orderby' => 'meta_value_num',
        'order' => 'ASC'
    );
    
    $slides = new WP_Query($args);
    return $slides;
}

/**
 * WooCommerce customizations
 */
if (class_exists('WooCommerce')) {
    // Remove WooCommerce default styles
    add_filter('woocommerce_enqueue_styles', '__return_empty_array');
    
    // AJAX cart count update
    function scode_theme_get_cart_count() {
        if (class_exists('WooCommerce')) {
            wp_send_json_success(array('count' => WC()->cart->get_cart_contents_count()));
        }
        wp_send_json_error();
    }
    add_action('wp_ajax_get_cart_count', 'scode_theme_get_cart_count');
    add_action('wp_ajax_nopriv_get_cart_count', 'scode_theme_get_cart_count');
}

/**
 * Security enhancements
 */
function scode_theme_security_enhancements() {
    // Remove WordPress version from head
    remove_action('wp_head', 'wp_generator');
    
    // Remove WordPress version from RSS feeds
    add_filter('the_generator', '__return_empty_string');
    
    // Disable XML-RPC
    add_filter('xmlrpc_enabled', '__return_false');
    
    // Hide login errors
    add_filter('login_errors', function() {
        return __('Đã xảy ra lỗi!', 'scode-theme');
    });
}
add_action('init', 'scode_theme_security_enhancements');

/**
 * Performance optimizations
 */
function scode_theme_performance_optimizations() {
    // Remove unnecessary WordPress features
    remove_action('wp_head', 'wlwmanifest_link');
    remove_action('wp_head', 'rsd_link');
    remove_action('wp_head', 'wp_shortlink_wp_head');
    
    // Disable emojis
    remove_action('wp_head', 'print_emoji_detection_script', 7);
    remove_action('wp_print_styles', 'print_emoji_styles');
    remove_action('admin_print_scripts', 'print_emoji_detection_script');
    add_action('admin_print_styles', 'print_emoji_styles');
}
add_action('init', 'scode_theme_performance_optimizations');

/**
 * Theme activation hook
 */
function scode_theme_activation() {
    // Flush rewrite rules
    flush_rewrite_rules();
    
    // Set default options
    if (!get_option('scode_theme_options')) {
        update_option('scode_theme_options', array(
            'primary_color' => '#f26522',
            'secondary_color' => '#1e3a8a',
            'hero_title' => __('Chào mừng đến với OTNT - ÔNG TRÙM NỘI TRỢ', 'scode-theme'),
            'hero_description' => __('Cửa hàng công nghệ hàng đầu Việt Nam với các sản phẩm chất lượng cao.', 'scode-theme'),
            'hero_cta_text' => __('Khám phá ngay', 'scode-theme'),
            'hero_cta_url' => home_url('/shop'),
            'product_grid_columns' => '4',
            'show_category_banners' => true,
            'footer_text' => __('© 2024 OTNT - ÔNG TRÙM NỘI TRỢ. Tất cả quyền được bảo lưu.', 'scode-theme'),
            'hotline' => '+84 123 456 789',
            'address' => '123 Đường ABC, Quận XYZ, TP.HCM',
            'email' => 'info@otnt.com',
        ));
    }
}
add_action('after_switch_theme', 'scode_theme_activation');

/**
 * Theme deactivation hook
 */
function scode_theme_deactivation() {
    // Flush rewrite rules
    flush_rewrite_rules();
}
add_action('switch_theme', 'scode_theme_deactivation');

/**
 * Load theme text domain
 */
function scode_theme_load_textdomain() {
    load_theme_textdomain('scode-theme', get_template_directory() . '/languages');
}
add_action('after_setup_theme', 'scode_theme_load_textdomain');

/**
 * Helper function to get theme option with fallback
 * Note: This function is now defined in inc/theme-options.php
 * to support both ACF and theme mods
 */

/**
 * Helper function to check if WooCommerce is active
 */
function scode_theme_is_woocommerce_active() {
    return class_exists('WooCommerce');
}

/**
 * Add custom body classes
 */
function scode_theme_body_classes($classes) {
    if (scode_theme_is_woocommerce_active()) {
        $classes[] = 'woocommerce-active';
    }
    
    if (get_theme_mod('scode_show_category_banners', true)) {
        $classes[] = 'show-category-banners';
    }
    
    return $classes;
}
add_filter('body_class', 'scode_theme_body_classes');

/**
 * Include additional functionality
 */
require_once str_replace('\\', '/', get_template_directory()) . '/inc/theme-options.php';
require_once str_replace('\\', '/', get_template_directory()) . '/inc/woocommerce-overrides.php';
require_once str_replace('\\', '/', get_template_directory()) . '/inc/customizer.php';
