<?php
/**
 * WooCommerce Single Product Template
 * 
 * @package SCODE_Theme
 * @version 3.0.0
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

get_header(); ?>

<div class="woocommerce-wrapper">
    <div class="container">
        <?php while (have_posts()) : the_post(); ?>
            <?php wc_get_template_part('content', 'single-product'); ?>
        <?php endwhile; ?>
    </div>
</div>

<?php get_footer(); ?>
