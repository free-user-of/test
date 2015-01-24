<?php
/**
 * Single Product Meta
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

global $post, $product;
?>

<?php if($product->get_categories()) : ?>
    <p class="item">
        <label><?php _e('Category', PLSH_THEME_DOMAIN); ?>:</label>
       <?php echo $product->get_categories( '', '<span class="tags">', '</span>'); ?>
    </p>
<?php endif; ?>

<?php if($product->get_tags()) : ?>
<p class="item">
    <label><?php _e('Tags', PLSH_THEME_DOMAIN); ?>:</label>
    <?php echo $product->get_tags( '', '<span class="tags">', '</span>'); ?>
</p>
<?php endif; ?>

<?php if ( $product->is_type( array( 'simple', 'variable' ) ) && get_option('woocommerce_enable_sku') == 'yes' && $product->get_sku() ) : ?>
    <p itemprop="productID" class="item sku">
        <label><?php _e('SKU:', 'woocommerce'); ?></label>
        <span class="tags"><?php echo $product->get_sku(); ?></span>
    </p>
<?php endif; ?>