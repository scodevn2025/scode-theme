<?php
/**
 * WooCommerce Template
 * 
 * @package SCODE_Theme
 * @version 1.0.0
 */

get_header(); ?>

<div class="woocommerce-wrapper">
    <div class="container">
        <?php if (is_woocommerce()) : ?>
            <?php woocommerce_content(); ?>
        <?php else : ?>
            <?php if (have_posts()) : ?>
                <?php while (have_posts()) : the_post(); ?>
                    <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                        <header class="entry-header">
                            <h1 class="entry-title"><?php the_title(); ?></h1>
                        </header>

                        <div class="entry-content">
                            <?php the_content(); ?>
                        </div>
                    </article>
                <?php endwhile; ?>
            <?php else : ?>
                <div class="no-content">
                    <h2>Không tìm thấy nội dung</h2>
                    <p>Xin lỗi, không có nội dung nào được tìm thấy.</p>
                </div>
            <?php endif; ?>
        <?php endif; ?>
    </div>
</div>

<?php get_footer(); ?>
