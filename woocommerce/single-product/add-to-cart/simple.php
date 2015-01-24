<?php
/**
 * Simple product add to cart
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.1.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $woocommerce, $product, $post;

if ( ! $product->is_purchasable() ) return;
?>

<?php
	// Availability
	$availability = $product->get_availability();

	if ($availability['availability']) :
		echo apply_filters( 'woocommerce_stock_html', '<p class="stock ' . esc_attr( $availability['class'] ) . '">' . esc_html( $availability['availability'] ) . '</p>', $availability['availability'] );
    endif;
?>



    <?php do_action('woocommerce_before_add_to_cart_button'); ?>

    <?php woocommerce_template_single_price(); ?>

    <?php if ( $product->is_in_stock() ) : ?>
        
        <input type="hidden" name="add-to-cart" value="<?php echo esc_attr( $product->id ); ?>" />
                
        <div class="buy">
            <button type="submit" class="single_add_to_cart_button button alt"><?php echo $product->single_add_to_cart_text(); ?></button>
            <?php if(!empty($post->is_quickshop)) : ?>
                <span class="ajax-form-submited-wrap"><div class="ajax-form-loader"></div><div class="ajax-form-submited-success"><?php _e('Item added to cart!' , PLSH_THEME_DOMAIN); ?></div></span>
            <?php endif; ?>
        </div>

    <?php endif; ?>

    <?php do_action('woocommerce_after_add_to_cart_button'); ?>

