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
                <?php 
                // Load our custom single product template
                include get_template_directory() . '/woocommerce/single-product.php';
                ?>
                
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
