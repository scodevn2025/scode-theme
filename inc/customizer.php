<?php
/**
 * WordPress Customizer Integration
 * 
 * @package ScodeTheme
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Customizer additions
 */
function scode_theme_customize_register($wp_customize) {
    // Add section for theme options
    $wp_customize->add_section('scode_theme_options', array(
        'title'    => __('ScodeTheme Options', 'scode-theme'),
        'priority' => 30,
    ));
    
    // Primary color setting
    $wp_customize->add_setting('scode_primary_color', array(
        'default'           => '#f26522',
        'sanitize_callback' => 'sanitize_hex_color',
    ));
    
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'scode_primary_color', array(
        'label'    => __('Primary Color (Orange)', 'scode-theme'),
        'section'  => 'scode_theme_options',
        'settings' => 'scode_primary_color',
        'description' => __('Main accent color for buttons and highlights', 'scode-theme'),
    )));
    
    // Secondary color setting
    $wp_customize->add_setting('scode_secondary_color', array(
        'default'           => '#1e3a8a',
        'sanitize_callback' => 'sanitize_hex_color',
    ));
    
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'scode_secondary_color', array(
        'label'    => __('Secondary Color (Blue)', 'scode-theme'),
        'section'  => 'scode_theme_options',
        'settings' => 'scode_secondary_color',
        'description' => __('Secondary color for links and accents', 'scode-theme'),
    )));
    
    // Hero section text
    $wp_customize->add_setting('scode_hero_title', array(
        'default'           => __('Chào mừng đến với ScodeTheme', 'scode-theme'),
        'sanitize_callback' => 'sanitize_text_field',
    ));
    
    $wp_customize->add_control('scode_hero_title', array(
        'label'    => __('Hero Title', 'scode-theme'),
        'section'  => 'scode_theme_options',
        'type'     => 'text',
        'description' => __('Main heading in the hero section', 'scode-theme'),
    ));
    
    // Hero section description
    $wp_customize->add_setting('scode_hero_description', array(
        'default'           => __('Theme WordPress hiện đại, tối ưu cho WooCommerce với thiết kế sạch sẽ và hiệu suất tuyệt vời.', 'scode-theme'),
        'sanitize_callback' => 'sanitize_textarea_field',
    ));
    
    $wp_customize->add_control('scode_hero_description', array(
        'label'    => __('Hero Description', 'scode-theme'),
        'section'  => 'scode_theme_options',
        'type'     => 'textarea',
        'description' => __('Subtitle text below the hero title', 'scode-theme'),
    ));
    
    // Hero CTA Button Text
    $wp_customize->add_setting('scode_hero_cta_text', array(
        'default'           => __('Khám phá ngay', 'scode-theme'),
        'sanitize_callback' => 'sanitize_text_field',
    ));
    
    $wp_customize->add_control('scode_hero_cta_text', array(
        'label'    => __('Hero Button Text', 'scode-theme'),
        'section'  => 'scode_theme_options',
        'type'     => 'text',
        'description' => __('Text for the call-to-action button', 'scode-theme'),
    ));
    
    // Hero CTA Button URL
    $wp_customize->add_setting('scode_hero_cta_url', array(
        'default'           => home_url('/shop'),
        'sanitize_callback' => 'esc_url_raw',
    ));
    
    $wp_customize->add_control('scode_hero_cta_url', array(
        'label'    => __('Hero Button URL', 'scode-theme'),
        'section'  => 'scode_theme_options',
        'type'     => 'url',
        'description' => __('Where the hero button should link to', 'scode-theme'),
    ));
    
    // Product Grid Columns
    $wp_customize->add_setting('scode_product_grid_columns', array(
        'default'           => '4',
        'sanitize_callback' => 'absint',
    ));
    
    $wp_customize->add_control('scode_product_grid_columns', array(
        'label'    => __('Product Grid Columns', 'scode-theme'),
        'section'  => 'scode_theme_options',
        'type'     => 'select',
        'choices'  => array(
            '2' => __('2 Columns', 'scode-theme'),
            '3' => __('3 Columns', 'scode-theme'),
            '4' => __('4 Columns', 'scode-theme'),
            '5' => __('5 Columns', 'scode-theme'),
        ),
        'description' => __('Number of product columns in the grid', 'scode-theme'),
    ));
    
    // Show/Hide Category Banners
    $wp_customize->add_setting('scode_show_category_banners', array(
        'default'           => true,
        'sanitize_callback' => 'rest_sanitize_boolean',
    ));
    
    $wp_customize->add_control('scode_show_category_banners', array(
        'label'    => __('Show Category Banners', 'scode-theme'),
        'section'  => 'scode_theme_options',
        'type'     => 'checkbox',
        'description' => __('Display circular category banners below hero section', 'scode-theme'),
    ));
    
    // Footer Text
    $wp_customize->add_setting('scode_footer_text', array(
        'default'           => __('© 2024 ScodeTheme. Tất cả quyền được bảo lưu.', 'scode-theme'),
        'sanitize_callback' => 'sanitize_text_field',
    ));
    
    $wp_customize->add_control('scode_footer_text', array(
        'label'    => __('Footer Copyright Text', 'scode-theme'),
        'section'  => 'scode_theme_options',
        'type'     => 'text',
        'description' => __('Copyright text in the footer', 'scode-theme'),
    ));
}
add_action('customize_register', 'scode_theme_customize_register');

/**
 * Custom CSS from customizer
 */
function scode_theme_custom_css() {
    $primary_color = get_theme_mod('scode_primary_color', '#FF6A00');
    $secondary_color = get_theme_mod('scode_secondary_color', '#1e3a8a');
    $product_grid_columns = get_theme_mod('scode_product_grid_columns', '4');
    
    ?>
    <style type="text/css">
        :root {
            --primary-color: <?php echo esc_attr($primary_color); ?>;
            --secondary-color: <?php echo esc_attr($secondary_color); ?>;
            --product-grid-columns: <?php echo esc_attr($product_grid_columns); ?>;
        }
        
        /* Responsive grid adjustments */
        @media (max-width: 1200px) {
            :root {
                --product-grid-columns: <?php echo min(3, intval($product_grid_columns)); ?>;
            }
        }
        
        @media (max-width: 768px) {
            :root {
                --product-grid-columns: <?php echo min(2, intval($product_grid_columns)); ?>;
            }
        }
        
        @media (max-width: 480px) {
            :root {
                --product-grid-columns: 1;
            }
        }
    </style>
    <?php
}
add_action('wp_head', 'scode_theme_custom_css');
