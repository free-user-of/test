<?php
/**
 * External product add to cart
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.1.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

?>
<?php do_action('woocommerce_before_add_to_cart_button'); ?>

    <?php woocommerce_template_single_price(); ?>

    <div class="buy">
        <button type="submit" class="single_add_to_cart_button button alt" onClick="window.open('<?php echo esc_url( $product_url ); ?>'); return false;"><?php echo $button_text; ?></button>
    </div>

<?php do_action('woocommerce_after_add_to_cart_button'); ?>