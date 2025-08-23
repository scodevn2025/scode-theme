<?php
defined('ABSPATH') || exit;
global $product;
do_action( 'woocommerce_before_single_product' );
if ( post_password_required() ) { echo get_the_password_form(); return; } ?>
<div id="product-<?php the_ID(); ?>" <?php wc_product_class( 'otnt-pdp', $product ); ?>>
  <div class="otnt-pdp__top">
    <div class="otnt-pdp__gallery"><?php do_action( 'woocommerce_before_single_product_summary' ); ?></div>
    <div class="summary entry-summary otnt-pdp__summary">
      <?php do_action( 'woocommerce_single_product_summary' ); ?>
      <?php $hotline = function_exists('get_field') ? get_field('hotline_block') : null;
      if ( $hotline && !empty($hotline['phone']) ) : ?>
        <aside class="otnt-hotline">
          <?php if (!empty($hotline['avatar'])): ?><img class="otnt-hotline__avatar" src="<?php echo esc_url($hotline['avatar']); ?>" alt="<?php echo esc_attr($hotline['name'] ?? 'Tư vấn'); ?>"><?php endif; ?>
          <div class="otnt-hotline__txt">
            <strong><?php echo esc_html($hotline['name'] ?? 'Chuyên viên tư vấn'); ?></strong>
            <div class="otnt-hotline__phone"><?php echo esc_html($hotline['phone']); ?></div>
            <small>Gọi ngay để được hỗ trợ nhanh</small>
          </div>
        </aside>
      <?php endif; ?>
    </div>
  </div>
  <div class="otnt-pdp__bottom"><?php do_action( 'woocommerce_after_single_product_summary' ); ?></div>
</div>
<?php do_action( 'woocommerce_after_single_product' ); ?>
