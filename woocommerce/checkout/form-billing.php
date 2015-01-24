<?php
/**
 * Checkout billing information form
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.1.2
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $woocommerce;
?>

<div class="main-title">
    <?php if ( WC()->cart->ship_to_billing_address_only() && WC()->cart->needs_shipping() ) : ?>

        <p class="custom-font-1"><?php _e( 'Billing &amp; Shipping', 'woocommerce' ); ?></p>									

    <?php else : ?>

        <p class="custom-font-1"><?php _e( 'Billing Address', 'woocommerce' ); ?></p>	

    <?php endif; ?>
</div>
    
<?php do_action('woocommerce_before_checkout_billing_form', $checkout ); ?>

<div class="items">
    <?php foreach ($checkout->checkout_fields['billing'] as $key => $field) : ?>
        <?php
            $field['class'][] = 'clearfix';
            woocommerce_form_field( $key, $field, $checkout->get_value( $key ) );
        ?>
    <?php endforeach; ?>
</div>

	<?php if ( WC()->cart->needs_shipping() && ! WC()->cart->ship_to_billing_address_only() ) : ?>

		<?php
			if ( empty( $_POST ) ) {

				$ship_to_different_address = get_option( 'woocommerce_ship_to_billing' ) == 'no' ? 1 : 0;
				$ship_to_different_address = apply_filters( 'woocommerce_ship_to_different_address_checked', $ship_to_different_address );

			} else {

				$ship_to_different_address = $checkout->get_value( 'ship_to_different_address' );

			}
		?>

        <p class="checkbox" id="shiptobilling">
            <input id="ship-to-different-address-checkbox" class="input-checkbox" <?php checked( $ship_to_different_address, 1 ); ?> type="checkbox" name="ship_to_different_address" value="1" />
            <?php _e( 'Ship to a different address?', 'woocommerce' ); ?>
        </p>

    <?php endif; ?>


<?php do_action('woocommerce_after_checkout_billing_form', $checkout ); ?>


<?php if ( ! is_user_logged_in() && $checkout->enable_signup ) : ?>

	<?php if ( $checkout->enable_guest_checkout ) : ?>

		<p class="checkbox">
            <label for="shiptobilling-checkbox">&nbsp;</label>
            <input id="createaccount" <?php checked( ( true === $checkout->get_value( 'createaccount' ) || ( true === apply_filters( 'woocommerce_create_account_default_checked', false ) ) ), true) ?> type="checkbox" name="createaccount" value="1" />
            <?php _e( 'Create an account?', 'woocommerce' ); ?>
		</p>

	<?php endif; ?>

	<?php do_action( 'woocommerce_before_checkout_registration_form', $checkout ); ?>

    <?php if ( ! empty( $checkout->checkout_fields['account'] ) ) : ?>
        
        <div class="create-account">

            <p><?php _e( 'Create an account by entering the information below. If you are a returning customer please login at the top of the page.', 'woocommerce' ); ?></p>
            <?php $counter = 1; ?>
            <?php foreach ($checkout->checkout_fields['account'] as $key => $field) : ?>
                <?php 
                    if(!empty($field['label']))
                    {
                        if(count($checkout->checkout_fields['account']) == 3)  
                        {
                            if($counter == 1) $field['label'] = 'Username';
                            elseif($counter == 2) $field['label'] = 'Password';
                            else $field['label'] = 'Confirm password';
                        }
                        else     //e-mail as username
                        {
                            if($counter == 1) $field['label'] = 'Your Password';
                            else $field['label'] = 'Confirm password';
                        }
                    }
                ?>
                <?php woocommerce_form_field( $key, $field, $checkout->get_value( $key ) ); ?>
                <?php $counter++; ?>
            <?php endforeach; ?>

            <div class="clear"></div>

        </div>
        
    <?php endif; ?>

	<?php do_action( 'woocommerce_after_checkout_registration_form', $checkout ); ?>

<?php endif; ?>