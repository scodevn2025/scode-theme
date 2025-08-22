<?php
/**
 * WooCommerce Template - Main WooCommerce Template File
 * 
 * @package SCODE_Theme
 * @version 1.0.0
 */

get_header(); ?>

<main class="main-content woocommerce-page" id="main-content">
    <div class="container">
        
        <?php if (is_woocommerce()) : ?>
            
            <?php if (is_product()) : ?>
                <!-- Single Product Page -->
                <?php get_template_part('woocommerce/single-product'); ?>
                
            <?php elseif (is_shop() || is_product_category() || is_product_tag()) : ?>
                <!-- Shop/Category/Tag Pages -->
                <div class="woocommerce-shop-wrapper">
                    <?php woocommerce_content(); ?>
                </div>
                
            <?php elseif (is_cart()) : ?>
                <!-- Cart Page -->
                <div class="woocommerce-cart-wrapper">
                    <?php woocommerce_content(); ?>
                </div>
                
            <?php elseif (is_checkout()) : ?>
                <!-- Checkout Page -->
                <div class="woocommerce-checkout-wrapper">
                    <?php woocommerce_content(); ?>
                </div>
                
            <?php elseif (is_account_page()) : ?>
                <!-- My Account Page -->
                <div class="woocommerce-account-wrapper">
                    <?php woocommerce_content(); ?>
                </div>
                
            <?php else : ?>
                <!-- Other WooCommerce Pages -->
                <div class="woocommerce-other-wrapper">
                    <?php woocommerce_content(); ?>
                </div>
                
            <?php endif; ?>
            
        <?php else : ?>
            <!-- Not a WooCommerce page -->
            <div class="not-woocommerce-page">
                <p>Trang này không phải là trang WooCommerce.</p>
            </div>
        <?php endif; ?>
        
    </div>
</main>

<?php get_footer(); ?>
