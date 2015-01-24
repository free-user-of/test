<?php
/**
 * My Account page
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.0.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $woocommerce;

wc_print_notices(); ?>

<p class="global-message">
	<?php
    
    printf( __( 'From your account dashboard you can view your recent orders, manage your shipping and billing addresses and <a href="%s">edit your password and account details</a>.', 'woocommerce' ),
		wc_customer_edit_account_url()
	);
	?>
</p>

<?php do_action( 'woocommerce_before_my_account' ); ?>

<!-- BEGIN .shipping-address-history -->
<div class="shipping-address-history">
    
        <?php woocommerce_get_template( 'myaccount/my-downloads.php' ); ?>

        <?php woocommerce_get_template( 'myaccount/my-address.php' ); ?>
    
<!-- END .shipping-address-history -->
</div>



<?php woocommerce_get_template( 'myaccount/my-orders.php', array( 'order_count' => $order_count ) ); ?>

<?php do_action( 'woocommerce_after_my_account' ); ?>