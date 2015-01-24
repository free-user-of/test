<?php
/**
 * Thankyou page
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.2.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

?><div class="checkout-thankyou"><?php

if ( $order ) : ?>

	<?php if ( $order->has_status( 'failed' ) ) : ?>

		<p class="headline"><?php _e( 'Unfortunately your order cannot be processed as the originating bank/merchant has declined your transaction.', 'woocommerce' ); ?></p>

		<p><?php
			if ( is_user_logged_in() )
				_e( 'Please attempt your purchase again or go to your account page.', 'woocommerce' );
			else
				_e( 'Please attempt your purchase again.', 'woocommerce' );
		?></p>

		<p>
			<a href="<?php echo esc_url( $order->get_checkout_payment_url() ); ?>" class="button pay"><?php _e( 'Pay', 'woocommerce' ) ?></a>
			<?php if ( is_user_logged_in() ) : ?>
			<a href="<?php echo esc_url( get_permalink( woocommerce_get_page_id( 'myaccount' ) ) ); ?>" class="button pay"><?php _e( 'My Account', 'woocommerce' ); ?></a>
			<?php endif; ?>
		</p>

	<?php else : ?>

		<p class="headline"><?php _e( 'Thank you. Your order has been received.', 'woocommerce' ); ?></p>

        <div class="order_meta_wrap">
            <table class="order_meta">
                <tr class="heading">
                    <th><?php _e( 'Order', 'woocommerce' ); ?></th>
                    <th><?php _e( 'Date', 'woocommerce' ); ?></th>
                    <th><?php _e( 'Total', 'woocommerce' ); ?></th>
                    <th><?php _e( 'Payment method', 'woocommerce' ); ?></th>
                </tr>
                <tr>
                    <td><?php echo $order->get_order_number(); ?></td>
                    <td><?php echo date_i18n( get_option( 'date_format' ), strtotime( $order->order_date ) ); ?></td>
                    <td><?php echo $order->get_formatted_order_total(); ?></td>
                    <td>
                        <?php if ( $order->payment_method_title ) : ?>
                            <?php echo $order->payment_method_title; ?>
                        <?php endif; ?>
                    </td>
                </tr>
            </table>
        </div>
            
		<div class="clear"></div>

	<?php endif; ?>

	<div class="payment-method"><?php do_action( 'woocommerce_thankyou_' . $order->payment_method, $order->id ); ?></div>
	
    <?php do_action( 'woocommerce_thankyou', $order->id ); ?>
    
<?php else : ?>

	<p><?php _e( 'Thank you. Your order has been received.', 'woocommerce' ); ?></p>

<?php endif; ?>

</div>