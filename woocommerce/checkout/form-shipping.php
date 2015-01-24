<?php
/**
 * Checkout shipping information form
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.2.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

?>

	<?php if ( WC()->cart->needs_shipping() && ! WC()->cart->ship_to_billing_address_only() ) : ?>

		<?php
			if ( empty( $_POST ) ) {

				$ship_to_different_address = get_option( 'woocommerce_ship_to_destination' ) === 'shipping' ? 1 : 0;
				$ship_to_different_address = apply_filters( 'woocommerce_ship_to_different_address_checked', $ship_to_different_address );

			} else {

				$ship_to_different_address = $checkout->get_value( 'ship_to_different_address' );

			}
		?>
    
    <div class="main-title">
        <p><?php _e( 'Shipping Address', 'woocommerce' ); ?></p>
    </div>
    
	<div class="shipping_address">

		<?php do_action('woocommerce_before_checkout_shipping_form', $checkout); ?>

        <div class="items">
            <?php foreach ($checkout->checkout_fields['shipping'] as $key => $field) : ?>
                <?php
                    $field['class'][] = 'clearfix';
                    woocommerce_form_field( $key, $field, $checkout->get_value( $key ) );
                ?>
            <?php endforeach; ?>
        </div>
        
        <?php do_action('woocommerce_after_checkout_shipping_form', $checkout); ?>
        
	</div>
    <div class="item same-as-billing">
        <p class="message"><span><?php _e( 'Items(s) will be shipped to your billing address', PLSH_THEME_DOMAIN ); ?>.</span></p>
    </div>

<?php endif; ?>