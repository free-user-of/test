<?php
global $product;
?>
<div class="item-block-1">
    <?php woocommerce_show_product_loop_sale_flash(); ?>
    <div class="image-wrapper">
        <div class="image">
            <div class="overlay">
                <div class="position">
                    <div>
                        <a href="<?php the_permalink(); ?>" class="view"><?php _e('View more', PLSH_THEME_DOMAIN); ?></a>
                    </div>
                </div>
            </div>
            <a href="<?php the_permalink(); ?>"><?php echo plsh_get_thumbnail('product_catalog_small') ?></a>
        </div>
    </div>
    <?php woocommerce_template_loop_price(); ?>
</div>