<?php
/**
 * Variable product add to cart
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.1.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $woocommerce, $product, $post;
?>

<?php do_action('woocommerce_before_add_to_cart_button'); ?>

<div class="single_variation_wrap" style="display:none;">
      
    <?php
        if($product->product_type != 'variable-subscription')
        {
            if( $product->min_variation_price === $product->max_variation_price) //if products price does not vary
            {
                woocommerce_template_single_price();
            }
        }
    ?>
    
    <div class="single_variation"></div>
    <div class="variations_button">

        <div class="buy">
            <button type="submit" class="single_add_to_cart_button button alt"><?php echo $product->single_add_to_cart_text(); ?></button>

            <?php if(!empty($post->is_quickshop)) : ?>
                <span class="ajax-form-submited-wrap"><div class="ajax-form-loader"></div><div class="ajax-form-submited-success"><?php _e('Item added to cart!' , PLSH_THEME_DOMAIN); ?></div></span>
            <?php endif; ?>
        </div>
       
    </div>
    <input type="hidden" name="add-to-cart" value="<?php echo $product->id; ?>" />
    <input type="hidden" name="product_id" value="<?php echo esc_attr( $post->ID ); ?>" />
    <input type="hidden" name="variation_id" value="" />
</div>

<?php do_action('woocommerce_after_add_to_cart_button'); ?>