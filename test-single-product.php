<?php
/**
 * Test Single Product Template
 */

get_header(); ?>

<div style="padding: 20px; background: #f0f0f0; margin: 20px;">
    <h1>Test Single Product Template</h1>
    <p>Nếu bạn thấy trang này, có nghĩa là template hierarchy đang hoạt động.</p>
    
    <h2>Thông tin trang:</h2>
    <ul>
        <li>is_woocommerce(): <?php echo is_woocommerce() ? 'true' : 'false'; ?></li>
        <li>is_product(): <?php echo is_product() ? 'true' : 'false'; ?></li>
        <li>is_shop(): <?php echo is_shop() ? 'true' : 'false'; ?></li>
        <li>Post Type: <?php echo get_post_type(); ?></li>
        <li>Template: <?php echo get_page_template_slug(); ?></li>
    </ul>
    
    <h2>Nội dung sản phẩm:</h2>
    <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
        <h3><?php the_title(); ?></h3>
        <div><?php the_content(); ?></div>
    <?php endwhile; endif; ?>
</div>

<?php get_footer(); ?>
