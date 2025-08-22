<?php
/**
 * Product Card Template Part
 * 
 * @package ScodeTheme
 */

global $product;
?>

<div class="product-card">
    <?php if ($product->is_on_sale()) : ?>
        <div class="discount-badge">
            -<?php 
            $regular_price = $product->get_regular_price();
            $sale_price = $product->get_sale_price();
            if ($regular_price && $sale_price) {
                echo round((1 - $sale_price / $regular_price) * 100);
            }
            ?>%
        </div>
    <?php endif; ?>
    
    <div class="product-image">
        <a href="<?php the_permalink(); ?>">
            <?php if (has_post_thumbnail()) : ?>
                <?php the_post_thumbnail('medium', array('class' => 'img-fluid')); ?>
            <?php else : ?>
                <img src="<?php echo wc_placeholder_img_src(); ?>" alt="<?php the_title(); ?>">
            <?php endif; ?>
        </a>
    </div>
    
    <div class="product-info">
        <h3 class="product-title">
            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
        </h3>
        
        <div class="product-price">
            <?php if ($product->is_on_sale()) : ?>
                <span class="old-price"><?php echo wc_price($product->get_regular_price()); ?></span>
                <span class="new-price"><?php echo wc_price($product->get_sale_price()); ?></span>
            <?php else : ?>
                <span class="new-price"><?php echo wc_price($product->get_price()); ?></span>
            <?php endif; ?>
        </div>
        
        <button class="add-to-cart" data-product-id="<?php echo $product->get_id(); ?>">
            Thêm vào giỏ
        </button>
    </div>
</div>
