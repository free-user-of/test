<?php
/**
 * My Orders
 *
 * Shows recent orders on the account page
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.2.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $woocommerce;

$customer_orders = get_posts( apply_filters( 'woocommerce_my_account_my_orders_query', array(
	'numberposts' => $order_count,
	'meta_key'    => '_customer_user',
	'meta_value'  => get_current_user_id(),
    'post_type'   => wc_get_order_types( 'view-orders' ),
    'post_status' => array_keys( wc_get_order_statuses() )
) ) );

if ( $customer_orders ) : ?>


    <!-- BEGIN .order-history -->
    <div class="order-history">
        <div class="row title">
            <div class="order"><?php _e( 'Order', 'woocommerce' ); ?></div>
            <div class="date"><?php _e( 'Date', 'woocommerce' ); ?></div>
            <div class="fulfillment"><?php _e( 'Status', 'woocommerce' ); ?></div>
            <div class="total"><?php _e( 'Total', 'woocommerce' ); ?></div>
            <div class="actions">&nbsp;</div>
        </div>
        

		<?php
			foreach ( $customer_orders as $customer_order ) {
				$order = wc_get_order();
				$order->populate( $customer_order );
				$item_count = $order->get_item_count();

				?>
                <div class="row">
					<div class="order">
						<a href="<?php echo $order->get_view_order_url(); ?>">
							<?php echo $order->get_order_number(); ?>
						</a>
					</div>
					<div class="date">
						<time title="<?php echo esc_attr( strtotime( $order->order_date ) ); ?>"><?php echo date_i18n( get_option( 'date_format' ), strtotime( $order->order_date ) ); ?></time>
					</div>
					<div class="fulfillment" style="text-align:left; white-space:nowrap;">
                        <?php echo wc_get_order_status_name( $order->get_status() ); ?>
					</div>
					<div class="total">
						<?php echo sprintf( _n( '%s for %s item', '%s for %s items', $item_count, 'woocommerce' ), $order->get_formatted_order_total(), $item_count ); ?>
					</div>
					<div class="actions">
						<?php
							$actions = array();

                            if ( in_array( $order->get_status(), apply_filters( 'woocommerce_valid_order_statuses_for_cancel', array( 'pending', 'failed' ), $order ) ) ) {
                                $actions['cancel'] = array(
                                        'url'  => $order->get_cancel_order_url( get_permalink( wc_get_page_id( 'myaccount' ) ) ),
                                        'name' => __( 'Cancel', 'woocommerce' )
                                );
                            }

                            $actions['view'] = array(
								'url'  => $order->get_view_order_url(),
								'name' => __( 'View', 'woocommerce' )
							);

							$actions = apply_filters( 'woocommerce_my_account_my_orders_actions', $actions, $order );

							if ($actions) {
								foreach ( $actions as $key => $action ) {
									echo '<a href="' . esc_url( $action['url'] ) . '" class="button ' . sanitize_html_class( $key ) . '">' . esc_html( $action['name'] ) . '</a>';
								}
							}
                            
						?>
					</div>
				</div>
                <?php
			}
		?>

    <!-- END .order-history -->
    </div>

<?php endif; ?>