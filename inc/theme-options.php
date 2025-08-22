<?php
/**
 * Theme Options (ACF Integration)
 * 
 * @package ScodeTheme
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Check if ACF is active
 */
function scode_theme_acf_active() {
    return class_exists('ACF');
}

/**
 * Register ACF Options Page
 */
if (scode_theme_acf_active()) {
    if (function_exists('acf_add_options_page')) {
        acf_add_options_page(array(
            'page_title' => __('ScodeTheme Options', 'scode-theme'),
            'menu_title' => __('Theme Options', 'scode-theme'),
            'menu_slug' => 'scode-theme-options',
            'capability' => 'edit_posts',
            'redirect' => false,
            'icon_url' => 'dashicons-admin-generic',
        ));
    }
}

/**
 * ACF Field Groups for Theme Options
 */
if (scode_theme_acf_active() && function_exists('acf_add_local_field_group')) {
    
    // Hero Section Options
    acf_add_local_field_group(array(
        'key' => 'group_hero_section',
        'title' => 'Hero Section Options',
        'fields' => array(
            array(
                'key' => 'field_hero_title',
                'label' => 'Hero Title',
                'name' => 'hero_title',
                'type' => 'text',
                'default_value' => 'Chào mừng đến với ScodeTheme',
                'required' => 1,
            ),
            array(
                'key' => 'field_hero_description',
                'label' => 'Hero Description',
                'name' => 'hero_description',
                'type' => 'textarea',
                'default_value' => 'Theme WordPress hiện đại, tối ưu cho WooCommerce với thiết kế sạch sẽ và hiệu suất tuyệt vời.',
                'required' => 1,
            ),
            array(
                'key' => 'field_hero_cta_text',
                'label' => 'CTA Button Text',
                'name' => 'hero_cta_text',
                'type' => 'text',
                'default_value' => 'Khám phá ngay',
                'required' => 1,
            ),
            array(
                'key' => 'field_hero_cta_url',
                'label' => 'CTA Button URL',
                'name' => 'hero_cta_url',
                'type' => 'url',
                'default_value' => '/shop',
                'required' => 1,
            ),
        ),
        'location' => array(
            array(
                array(
                    'param' => 'options_page',
                    'operator' => '==',
                    'value' => 'scode-theme-options',
                ),
            ),
        ),
        'menu_order' => 0,
        'position' => 'normal',
        'style' => 'default',
        'label_placement' => 'top',
        'instruction_placement' => 'label',
        'hide_on_screen' => '',
    ));
    
    // Company Information
    acf_add_local_field_group(array(
        'key' => 'group_company_info',
        'title' => 'Company Information',
        'fields' => array(
            array(
                'key' => 'field_hotline',
                'label' => 'Hotline',
                'name' => 'hotline',
                'type' => 'text',
                'default_value' => '+84 123 456 789',
                'required' => 1,
            ),
            array(
                'key' => 'field_address',
                'label' => 'Address',
                'name' => 'address',
                'type' => 'textarea',
                'default_value' => '123 Đường ABC, Quận XYZ, TP.HCM',
                'required' => 1,
            ),
            array(
                'key' => 'field_email',
                'label' => 'Email',
                'name' => 'email',
                'type' => 'email',
                'default_value' => 'info@scode.com',
                'required' => 1,
            ),
            array(
                'key' => 'field_working_hours',
                'label' => 'Working Hours',
                'name' => 'working_hours',
                'type' => 'text',
                'default_value' => 'Thứ 2 - Thứ 6: 8:00 - 18:00',
                'required' => 0,
            ),
        ),
        'location' => array(
            array(
                array(
                    'param' => 'options_page',
                    'operator' => '==',
                    'value' => 'scode-theme-options',
                ),
            ),
        ),
        'menu_order' => 1,
        'position' => 'normal',
        'style' => 'default',
        'label_placement' => 'top',
        'instruction_placement' => 'label',
        'hide_on_screen' => '',
    ));
    
    // Social Media Links
    acf_add_local_field_group(array(
        'key' => 'group_social_media',
        'title' => 'Social Media Links',
        'fields' => array(
            array(
                'key' => 'field_social_facebook',
                'label' => 'Facebook',
                'name' => 'social_facebook',
                'type' => 'url',
                'required' => 0,
            ),
            array(
                'key' => 'field_social_twitter',
                'label' => 'Twitter',
                'name' => 'social_twitter',
                'type' => 'url',
                'required' => 0,
            ),
            array(
                'key' => 'field_social_instagram',
                'label' => 'Instagram',
                'name' => 'social_instagram',
                'type' => 'url',
                'required' => 0,
            ),
            array(
                'key' => 'field_social_linkedin',
                'label' => 'LinkedIn',
                'name' => 'social_linkedin',
                'type' => 'url',
                'required' => 0,
            ),
            array(
                'key' => 'field_social_youtube',
                'label' => 'YouTube',
                'name' => 'social_youtube',
                'type' => 'url',
                'required' => 0,
            ),
        ),
        'location' => array(
            array(
                array(
                    'param' => 'options_page',
                    'operator' => '==',
                    'value' => 'scode-theme-options',
                ),
            ),
        ),
        'menu_order' => 2,
        'position' => 'normal',
        'style' => 'default',
        'label_placement' => 'top',
        'instruction_placement' => 'label',
        'hide_on_screen' => '',
    ));
    
    // Utility Icons Section
    acf_add_local_field_group(array(
        'key' => 'group_utility_icons',
        'title' => 'Utility Icons Section',
        'fields' => array(
            array(
                'key' => 'field_utility_icons',
                'label' => 'Utility Icons',
                'name' => 'utility_icons',
                'type' => 'repeater',
                'layout' => 'table',
                'button_label' => 'Add Icon',
                'sub_fields' => array(
                    array(
                        'key' => 'field_icon_title',
                        'label' => 'Icon Title',
                        'name' => 'icon_title',
                        'type' => 'text',
                        'required' => 1,
                    ),
                    array(
                        'key' => 'field_icon_description',
                        'label' => 'Icon Description',
                        'name' => 'icon_description',
                        'type' => 'text',
                        'required' => 1,
                    ),
                    array(
                        'key' => 'field_icon_link',
                        'label' => 'Icon Link',
                        'name' => 'icon_link',
                        'type' => 'url',
                        'required' => 0,
                    ),
                    array(
                        'key' => 'field_icon_color',
                        'label' => 'Icon Color',
                        'name' => 'icon_color',
                        'type' => 'color_picker',
                        'default_value' => '#FF6A00',
                        'required' => 0,
                    ),
                ),
                'min' => 4,
                'max' => 6,
            ),
        ),
        'location' => array(
            array(
                array(
                    'param' => 'options_page',
                    'operator' => '==',
                    'value' => 'scode-theme-options',
                ),
            ),
        ),
        'menu_order' => 3,
        'position' => 'normal',
        'style' => 'default',
        'label_placement' => 'top',
        'instruction_placement' => 'label',
        'hide_on_screen' => '',
    ));
    
    // Section Visibility
    acf_add_local_field_group(array(
        'key' => 'group_section_visibility',
        'title' => 'Section Visibility',
        'fields' => array(
            array(
                'key' => 'field_show_hero_section',
                'label' => 'Show Hero Section',
                'name' => 'show_hero_section',
                'type' => 'true_false',
                'default_value' => 1,
                'ui' => 1,
            ),
            array(
                'key' => 'field_show_utility_icons',
                'label' => 'Show Utility Icons',
                'name' => 'show_utility_icons',
                'type' => 'true_false',
                'default_value' => 1,
                'ui' => 1,
            ),
            array(
                'key' => 'field_show_flash_sale',
                'label' => 'Show Flash Sale Section',
                'name' => 'show_flash_sale',
                'type' => 'true_false',
                'default_value' => 1,
                'ui' => 1,
            ),
            array(
                'key' => 'field_show_brand_strip',
                'label' => 'Show Brand Strip',
                'name' => 'show_brand_strip',
                'type' => 'true_false',
                'default_value' => 1,
                'ui' => 1,
            ),
            array(
                'key' => 'field_show_trust_boxes',
                'label' => 'Show Trust Boxes',
                'name' => 'show_trust_boxes',
                'type' => 'true_false',
                'default_value' => 1,
                'ui' => 1,
            ),
        ),
        'location' => array(
            array(
                array(
                    'param' => 'options_page',
                    'operator' => '==',
                    'value' => 'scode-theme-options',
                ),
            ),
        ),
        'menu_order' => 4,
        'position' => 'normal',
        'style' => 'default',
        'label_placement' => 'top',
        'instruction_placement' => 'label',
        'hide_on_screen' => '',
    ));
}

/**
 * Helper function to get ACF option with fallback
 */
function scode_theme_get_acf_option($field_name, $default = '') {
    if (scode_theme_acf_active() && function_exists('get_field')) {
        $value = get_field($field_name, 'option');
        return $value !== null ? $value : $default;
    }
    return $default;
}

/**
 * Get theme option with fallback to ACF or theme mod
 */
function scode_theme_get_option($option_name, $default = '') {
    // Try ACF first
    $acf_value = scode_theme_get_acf_option($option_name, null);
    if ($acf_value !== null) {
        return $acf_value;
    }
    
    // Fallback to theme mod
    return get_theme_mod($option_name, $default);
}

/**
 * Get utility icons from ACF
 */
function scode_theme_get_utility_icons() {
    if (scode_theme_acf_active()) {
        return scode_theme_get_acf_option('utility_icons', array());
    }
    
    // Fallback default icons
    return array(
        array(
            'icon_title' => 'VIP',
            'icon_description' => 'Khách hàng VIP',
            'icon_link' => '/vip',
            'icon_color' => '#FF6A00'
        ),
        array(
            'icon_title' => 'Bảo hành',
            'icon_description' => 'Bảo hành chính hãng',
            'icon_link' => '/bao-hanh',
            'icon_color' => '#10B981'
        ),
        array(
            'icon_title' => 'Giao nhanh',
            'icon_description' => 'Giao hàng trong 2h',
            'icon_link' => '/giao-hang',
            'icon_color' => '#3B82F6'
        ),
        array(
            'icon_title' => 'CSKH',
            'icon_description' => 'Hỗ trợ 24/7',
            'icon_link' => '/lien-he',
            'icon_color' => '#8B5CF6'
        ),
    );
}

/**
 * Check if section should be visible
 */
function scode_theme_section_visible($section_name) {
    return scode_theme_get_option('show_' . $section_name, true);
}
