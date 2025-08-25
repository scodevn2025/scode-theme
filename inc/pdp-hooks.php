<?php
/**
 * Product Detail Page (PDP) Hooks - Enhanced Version
 * Works without ACF dependency
 * 
 * @package SCODE_Theme
 * @version 2.0.0
 */

if (!defined('ABSPATH')) exit;

class OTNT_PDP_Hooks {
    
    public function __construct() {
        add_action('wp_enqueue_scripts', [$this, 'enqueue_assets']);
        
        // Product summary hooks
        add_action('woocommerce_single_product_summary', [$this, 'save_percent_badge'], 9);
        add_action('woocommerce_single_product_summary', [$this, 'countdown_block'], 12);
        add_action('woocommerce_single_product_summary', [$this, 'gifts_block'], 13);
        add_action('woocommerce_single_product_summary', [$this, 'policies_block'], 25);
        add_action('woocommerce_single_product_summary', [$this, 'trust_badges'], 35);
        
        // After add to cart
        add_action('woocommerce_after_add_to_cart_button', [$this, 'buy_now_button']);
        
        // Product gallery
        add_action('woocommerce_product_thumbnails', [$this, 'video_thumbnails'], 30);
        
        // After product summary
        add_action('woocommerce_after_single_product_summary', [$this, 'specs_section'], 6);
        add_action('woocommerce_after_single_product_summary', [$this, 'enhanced_description'], 7);
        
        // Footer elements
        add_action('wp_footer', [$this, 'sticky_bar']);
        add_action('wp_footer', [$this, 'jsonld_product'], 20);
        
        // Remove default WooCommerce elements
        add_action('init', [$this, 'remove_default_elements']);
    }
    
    /**
     * Remove default WooCommerce elements
     */
    public function remove_default_elements() {
        if (!class_exists('WooCommerce')) return;
        
        // Remove default elements
        remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_rating', 10);
        remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40);
        remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_sharing', 50);
        remove_action('woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20);
    }
    
    /**
     * Enqueue assets
     */
    public function enqueue_assets() {
        if (!is_product()) return;
        
        $u = get_stylesheet_directory_uri();
            wp_enqueue_style('otnt-single-product', $u . '/assets/css/single-product.css', [], '3.0.0');
    wp_enqueue_script('otnt-single-product', $u . '/assets/js/single-product.js', [], '3.0.0', true);
    }
    
    /**
     * Save percentage badge
     */
    public function save_percent_badge() {
        global $product;
        if (!$product || !$product->is_on_sale()) return;
        
        $reg = (float) $product->get_regular_price();
        $sale = (float) $product->get_sale_price();
        
        if ($reg <= 0 || $sale <= 0) return;
        
        $off = round((1 - $sale / $reg) * 100);
        echo '<div class="otnt-save">Tiết kiệm <strong>' . esc_html($off) . '%</strong></div>';
    }
    
    /**
     * Countdown block
     */
    public function countdown_block() {
        // Try to get deadline from ACF first, then fallback to sample
        $deadline = '';
        if (function_exists('get_field')) {
            $deadline = get_field('promo_deadline');
        }
        
        // Fallback to sample deadline (24 hours from now)
        if (!$deadline) {
            $deadline = date('Y-m-d H:i:s', strtotime('+24 hours'));
        }
        
        echo '<div class="otnt-countdown" data-deadline="' . esc_attr($deadline) . '">';
        echo '<span class="otnt-countdown__label">FLASH SALE</span>';
        echo '<span class="otnt-countdown__time">00:00:00</span>';
        echo '</div>';
    }
    
    /**
     * Gifts block
     */
    public function gifts_block() {
        $gifts = [];
        
        // Try to get gifts from ACF first
        if (function_exists('get_field')) {
            $gifts = get_field('gifts');
        }
        
        // Fallback to sample gifts if none exist
        if (empty($gifts)) {
            $gifts = [
                [
                    'gift_image' => '',
                    'gift_title' => 'Máy hút bụi Tineco iFloor 2 Max',
                    'gift_note' => 'Giá trị: 4.990.000₫'
                ],
                [
                    'gift_image' => '',
                    'gift_title' => 'Bộ phụ kiện thay thế',
                    'gift_note' => 'Bao gồm: Giẻ lau, bàn chải, lọc bụi'
                ]
            ];
        }
        
        echo '<div class="otnt-gifts">';
        echo '<div class="otnt-gifts__title">Quà tặng đặc biệt</div>';
        echo '<ul class="otnt-gifts__list">';
        
        foreach ($gifts as $gift) {
            $img = !empty($gift['gift_image']) ? esc_url($gift['gift_image']) : '';
            $title = esc_html($gift['gift_title'] ?? '');
            $note = esc_html($gift['gift_note'] ?? '');
            
            echo '<li class="otnt-gift">';
            if ($img) {
                echo '<img class="otnt-gift__img" src="' . $img . '" alt="" />';
            } else {
                echo '<div class="otnt-gift__img-placeholder"><i class="fas fa-gift"></i></div>';
            }
            echo '<div class="otnt-gift__txt">';
            echo '<div class="otnt-gift__ttl">' . $title . '</div>';
            if ($note) {
                echo '<small class="otnt-gift__note">' . $note . '</small>';
            }
            echo '</div>';
            echo '</li>';
        }
        
        echo '</ul>';
        echo '</div>';
    }
    
    /**
     * Policies block
     */
    public function policies_block() {
        $policies = [];
        
        // Try to get policies from ACF first
        if (function_exists('get_field')) {
            $policies = get_field('policies');
        }
        
        // Fallback to default policies if none exist
        if (empty($policies)) {
            $policies = [
                ['icon' => 'shield-alt', 'text' => 'Bảo hành chính hãng 12 tháng'],
                ['icon' => 'truck', 'text' => 'Miễn phí vận chuyển toàn quốc'],
                ['icon' => 'credit-card', 'text' => 'Hỗ trợ trả góp 0%'],
                ['icon' => 'headset', 'text' => 'Hỗ trợ 24/7']
            ];
        }
        
        echo '<div class="otnt-policies">';
        foreach ($policies as $policy) {
            $icon = esc_html($policy['icon'] ?? 'shield-alt');
            $text = esc_html($policy['text'] ?? '');
            
            echo '<div class="otnt-policy">';
            echo '<span class="otnt-policy__ico otnt-ico-' . $icon . '">';
            echo '<i class="fas fa-' . $icon . '"></i>';
            echo '</span>';
            echo '<span>' . $text . '</span>';
            echo '</div>';
        }
        echo '</div>';
    }
    
    /**
     * Trust badges
     */
    public function trust_badges() {
        echo '<div class="otnt-trust-badges">';
        echo '<div class="otnt-trust-badge">';
        echo '<i class="fas fa-award"></i>';
        echo '<span>Chính hãng 100%</span>';
        echo '</div>';
        echo '<div class="otnt-trust-badge">';
        echo '<i class="fas fa-shipping-fast"></i>';
        echo '<span>Giao hàng 2-4h</span>';
        echo '</div>';
        echo '<div class="otnt-trust-badge">';
        echo '<i class="fas fa-undo"></i>';
        echo '<span>Đổi trả 7 ngày</span>';
        echo '</div>';
        echo '</div>';
    }
    
    /**
     * Buy now button
     */
    public function buy_now_button() {
        global $product;
        if (!$product) return;
        
        $link = wc_get_checkout_url() . '?add-to-cart=' . $product->get_id();
        echo '<a class="button otnt-buy-now" href="' . esc_url($link) . '">MUA NGAY</a>';
    }
    
    /**
     * Video thumbnails
     */
    public function video_thumbnails() {
        $videos = [];
        
        // Try to get videos from ACF first
        if (function_exists('get_field')) {
            $grp = get_field('marketing_media');
            if ($grp && !empty($grp['youtube_urls'])) {
                $videos = $grp['youtube_urls'];
            }
        }
        
        // Fallback to sample video if none exist
        if (empty($videos)) {
            $videos = [
                ['url' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ']
            ];
        }
        
        foreach ($videos as $video) {
            $url = $video['url'] ?? '';
            $id = $this->youtube_id($url);
            
            if (!$id) continue;
            
            $thumb = 'https://img.youtube.com/vi/' . $id . '/hqdefault.jpg';
            
            echo '<div class="woocommerce-product-gallery__image otnt-video-thumb" data-video="' . esc_url($url) . '">';
            echo '<img src="' . esc_url($thumb) . '" alt="Video sản phẩm">';
            echo '</div>';
        }
    }
    
    /**
     * Specifications section
     */
    public function specs_section() {
        $specs = [];
        
        // Try to get specs from ACF first
        if (function_exists('get_field')) {
            $specs = get_field('techspecs');
        }
        
        // Fallback to sample specs if none exist
        if (empty($specs)) {
            $specs = [
                ['label' => 'Lực hút', 'value' => '15.000Pa'],
                ['label' => 'Pin', 'value' => 'Li-ion 5200mAh'],
                ['label' => 'Thời gian hoạt động', 'value' => '150 phút'],
                ['label' => 'Trọng lượng', 'value' => '2.8kg'],
                ['label' => 'Kích thước', 'value' => '81mm x 350mm x 350mm'],
                ['label' => 'Kết nối', 'value' => 'WiFi 2.4GHz + Bluetooth']
            ];
        }
        
        echo '<section class="otnt-specs">';
        echo '<h2>Thông số kỹ thuật</h2>';
        echo '<div class="otnt-specs__grid">';
        
        foreach ($specs as $spec) {
            $label = esc_html($spec['label'] ?? '');
            $value = esc_html($spec['value'] ?? '');
            
            echo '<div class="otnt-spec">';
            echo '<span class="otnt-spec__label">' . $label . '</span>';
            echo '<span class="otnt-spec__value">' . $value . '</span>';
            echo '</div>';
        }
        
        echo '</div>';
        echo '</section>';
    }
    
    /**
     * Enhanced description
     */
    public function enhanced_description() {
        echo '<section class="otnt-enhanced-description">';
        echo '<h2>Mô tả chi tiết</h2>';
        echo '<div class="otnt-description-content">';
        echo '<p>Đây là mô tả chi tiết về sản phẩm với các tính năng nổi bật và thông tin quan trọng.</p>';
        echo '<ul>';
        echo '<li><strong>Thiết kế siêu mỏng:</strong> Chỉ 81mm, dễ dàng lau dọn dưới gầm giường, sofa</li>';
        echo '<li><strong>Lực hút mạnh mẽ:</strong> 15.000Pa, làm sạch hiệu quả mọi loại bụi bẩn</li>';
        echo '<li><strong>Pin bền bỉ:</strong> 150 phút hoạt động liên tục</li>';
        echo '<li><strong>Thông minh:</strong> Kết nối WiFi, điều khiển qua app</li>';
        echo '</ul>';
        echo '</div>';
        echo '</section>';
    }
    
    /**
     * Sticky bar
     */
    public function sticky_bar() {
        if (!is_product()) return;
        
        global $product;
        if (!$product) return;
        
        $add = esc_url(add_query_arg('add-to-cart', $product->get_id(), wc_get_cart_url()));
        $buy = esc_url(wc_get_checkout_url() . '?add-to-cart=' . $product->get_id());
        
        echo '<div id="otnt-sticky" class="otnt-sticky" aria-hidden="true">';
        echo '<div class="otnt-sticky__txt">';
        echo '<div class="otnt-sticky__title">' . get_the_title() . '</div>';
        echo '<div class="otnt-sticky__price">' . wp_kses_post($product->get_price_html()) . '</div>';
        echo '</div>';
        echo '<div class="otnt-sticky__cta">';
        echo '<a href="' . $add . '" class="button">Thêm vào giỏ</a>';
        echo '<a href="' . $buy . '" class="button otnt-btn-danger">Mua ngay</a>';
        echo '</div>';
        echo '</div>';
    }
    
    /**
     * JSON-LD structured data
     */
    public function jsonld_product() {
        if (!is_product()) return;
        
        global $product;
        if (!$product) return;
        
        $images = [];
        $main = wp_get_attachment_image_url($product->get_image_id(), 'full');
        if ($main) $images[] = $main;
        
        foreach ($product->get_gallery_image_ids() as $gid) {
            $u = wp_get_attachment_image_url($gid, 'full');
            if ($u) $images[] = $u;
        }
        
        $data = [
            "@context" => "https://schema.org/",
            "@type" => "Product",
            "name" => get_the_title(),
            "image" => $images,
            "sku" => $product->get_sku(),
            "brand" => [
                "@type" => "Brand",
                "name" => wp_get_post_terms(get_the_ID(), 'product_brand', ['fields' => 'names'])
            ],
            "offers" => [
                "@type" => "Offer",
                "priceCurrency" => get_woocommerce_currency(),
                "price" => $product->get_price(),
                "availability" => $product->is_in_stock() ? "https://schema.org/InStock" : "https://schema.org/OutOfStock",
                "url" => get_permalink()
            ]
        ];
        
        $rc = $product->get_rating_count();
        $avg = $product->get_average_rating();
        
        if ($rc) {
            $data["aggregateRating"] = [
                "@type" => "AggregateRating",
                "ratingValue" => (string) $avg,
                "reviewCount" => (string) $rc
            ];
        }
        
        echo '<script type="application/ld+json">' . wp_json_encode($data) . '</script>';
    }
    
    /**
     * Extract YouTube video ID
     */
    protected function youtube_id($url) {
        if (preg_match('~(?:youtu\.be/|youtube\.com/(?:shorts/|watch\?v=|embed/))([A-Za-z0-9_-]{6,})~', $url, $m)) {
            return $m[1];
        }
        return '';
    }
}

// Initialize the class
new OTNT_PDP_Hooks();
