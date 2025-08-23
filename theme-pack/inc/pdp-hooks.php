<?php
if ( ! defined( 'ABSPATH' ) ) exit;
class OTNT_PDP_Hooks {
  public function __construct() {
    add_action('wp_enqueue_scripts', [$this, 'enqueue_assets']);
    add_action('woocommerce_single_product_summary', [$this, 'save_percent_badge'], 9);
    add_action('woocommerce_single_product_summary', [$this, 'countdown_block'], 12);
    add_action('woocommerce_single_product_summary', [$this, 'gifts_block'], 13);
    add_action('woocommerce_single_product_summary', [$this, 'policies_block'], 25);
    add_action('woocommerce_after_add_to_cart_button', [$this, 'buy_now_button']);
    add_action('template_redirect', [$this, 'buy_now_redirect']);
    add_action('woocommerce_product_thumbnails', [$this, 'video_thumbnails'], 30);
    add_action('woocommerce_after_single_product_summary', [$this, 'specs_section'], 6);
    add_action('wp_footer', [$this, 'sticky_bar']);
    add_action('wp_footer', [$this, 'jsonld_product'], 20);
  }
  public function enqueue_assets() {
    if ( ! is_product() ) return;
    $u = get_stylesheet_directory_uri();
    wp_enqueue_style('otnt-pdp', $u . '/assets/css/pdp.css', [], '1.0');
    wp_enqueue_script('otnt-pdp', $u . '/assets/js/pdp.js', [], '1.0', true);
  }
  public function save_percent_badge() {
    global $product; if (! $product || ! $product->is_on_sale()) return;
    $reg = (float) $product->get_regular_price(); $sale = (float) $product->get_sale_price();
    if ($reg<=0||$sale<=0) return; $off = round((1-$sale/$reg)*100);
    echo '<div class="otnt-save">Tiết kiệm <strong>'.esc_html($off).'%</strong></div>';
  }
  public function countdown_block() {
    $deadline = function_exists('get_field') ? get_field('promo_deadline') : ''; if(!$deadline) return;
    echo '<div class="otnt-countdown" data-deadline="'.esc_attr($deadline).'"><span class="otnt-countdown__label">FLASH SALE</span><span class="otnt-countdown__time">00:00:00</span></div>';
  }
  public function gifts_block() {
    if(! function_exists('get_field')) return; $g = get_field('gifts'); if(!$g) return;
    echo '<div class="otnt-gifts"><div class="otnt-gifts__title">Quà tặng</div><ul class="otnt-gifts__list">';
    foreach($g as $r){ $img = !empty($r['gift_image'])?esc_url($r['gift_image']):''; $ttl = esc_html($r['gift_title']??''); $note = esc_html($r['gift_note']??''); 
      echo '<li class="otnt-gift">'.($img?'<img class="otnt-gift__img" src="'.$img.'" alt="" />':'').'<div class="otnt-gift__txt"><div class="otnt-gift__ttl">'.$ttl.'</div>'.($note?'<small class="otnt-gift__note">'.$note.'</small>':'').'</div></li>';
    } echo '</ul></div>';
  }
  public function policies_block() {
    if(! function_exists('get_field')) return; $pol = get_field('policies'); if(!$pol) return;
    echo '<div class="otnt-policies">';
    foreach($pol as $p){ $icon = esc_html($p['icon']??'shield'); $text = esc_html($p['text']??''); echo '<div class="otnt-policy"><span class="otnt-policy__ico otnt-ico-'.$icon.'"></span><span>'.$text.'</span></div>'; }
    echo '</div>';
  }
  public function buy_now_button(){ global $product; if(!$product) return; $link = wc_get_checkout_url().'?add-to-cart='.$product->get_id();
    echo '<a class="button otnt-buy-now" href="'.esc_url($link).'">MUA NGAY</a>'; }
  public function buy_now_redirect(){ if(isset($_GET['buy-now'])){ wp_safe_redirect(wc_get_checkout_url()); exit; } }
  protected function youtube_id($url){ if (preg_match('~(?:youtu\.be/|youtube\.com/(?:shorts/|watch\?v=|embed/))([A-Za-z0-9_-]{6,})~',$url,$m)) return $m[1]; return ''; }
  public function video_thumbnails(){ if(! function_exists('get_field')) return; $grp = get_field('marketing_media'); $rows = $grp['youtube_urls']??[]; if(!$rows) return;
    foreach($rows as $r){ $url=$r['url']??''; $id=$this->youtube_id($url); if(!$id) continue; $thumb='https://img.youtube.com/vi/'.$id.'/hqdefault.jpg';
      echo '<div class="woocommerce-product-gallery__image otnt-video-thumb" data-video="'.esc_url($url).'"><img src="'.esc_url($thumb).'" alt="Video"></div>'; } }
  public function specs_section(){ if(! function_exists('get_field')) return; $s = get_field('techspecs'); if(!$s) return;
    echo '<section class="otnt-specs"><h2>Thông số kỹ thuật</h2><div class="otnt-specs__grid">';
    foreach($s as $row){ $label=esc_html($row['label']??''); $value=esc_html($row['value']??''); echo '<div class="otnt-spec"><span class="otnt-spec__label">'.$label.'</span><span class="otnt-spec__value">'.$value.'</span></div>'; }
    echo '</div></section>'; }
  public function sticky_bar(){ if(!is_product())return; global $product; if(!$product)return;
    $add = esc_url( add_query_arg('add-to-cart', $product->get_id(), wc_get_cart_url()) ); $buy = esc_url( wc_get_checkout_url() . '?add-to-cart=' . $product->get_id() ); ?>
    <div id="otnt-sticky" class="otnt-sticky" aria-hidden="true"><div class="otnt-sticky__txt">
      <div class="otnt-sticky__title"><?php the_title(); ?></div><div class="otnt-sticky__price"><?php echo wp_kses_post($product->get_price_html()); ?></div></div>
      <div class="otnt-sticky__cta"><a href="<?php echo $add; ?>" class="button">Thêm vào giỏ</a><a href="<?php echo $buy; ?>" class="button otnt-btn-danger">Mua ngay</a></div></div><?php }
  public function jsonld_product(){ if(!is_product())return; global $product; if(!$product)return;
    $images=[]; $main=wp_get_attachment_image_url($product->get_image_id(),'full'); if($main)$images[]=$main; foreach($product->get_gallery_image_ids() as $gid){$u=wp_get_attachment_image_url($gid,'full'); if($u)$images[]=$u;}
    $data=["@context"=>"https://schema.org/","@type"=>"Product","name"=>get_the_title(),"image"=>$images,"sku"=>$product->get_sku(),
           "brand"=>["@type"=>"Brand","name"=>wp_get_post_terms(get_the_ID(),'product_brand',['fields'=>'names'])],
           "offers"=>["@type"=>"Offer","priceCurrency"=>get_woocommerce_currency(),"price"=>$product->get_price(),"availability"=>$product->is_in_stock()?"https://schema.org/InStock":"https://schema.org/OutOfStock","url"=>get_permalink()]];
    $rc=$product->get_rating_count(); $avg=$product->get_average_rating(); if($rc){ $data["aggregateRating"]=["@type"=>"AggregateRating","ratingValue"=>(string)$avg,"reviewCount"=>(string)$rc]; }
    echo '<script type="application/ld+json">'.wp_json_encode($data).'</script>'; }
}
new OTNT_PDP_Hooks();
