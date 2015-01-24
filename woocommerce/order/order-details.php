<?php
/**
 * Order details
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.2.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

$order = wc_get_order( $order_id );
?>
    <div class="order-details">
        
        <h2 class="details-title"><?php _e( 'Order Details', 'woocommerce' ); ?></h2>

        <!-- BEGIN .main-cart -->
        <div class="main-cart">

            <tbody>
                <?php
                if (sizeof($order->get_items())>0) :

                    foreach($order->get_items() as $item) :

                    $_product  = apply_filters( 'woocommerce_order_item_product', $order->get_product_from_item( $item ), $item );
                    $item_meta = new WC_Order_Item_Meta( $item['item_meta'] );

                        ?>
                            <div class="row clearfix">
                                <div class="item-block-1">
                                    <div class="image-wrapper">
                                        <div class="image">
                                            <?php echo $_product->get_image('order_review'); ?>
                                        </div>
                                    </div>
                                </div>

                                <div class="product">
                                    <h4><?php echo $item['name'];?></h4>
                                    <?php 
                                    echo '<p>';
                                    $item_meta->display(true);
                                    echo '</p>';
                                    
                                    if ( $_product && $_product->exists() && $_product->is_downloadable() && $order->is_download_permitted() ) {

                                        $download_files = $order->get_item_downloads( $item );
                                        $i              = 0;
                                        $links          = array();

                                        foreach ( $download_files as $download_id => $file ) {
                                            $i++;

                                            $links[] = '<p><a href="' . esc_url( $file['download_url'] ) . '">' . sprintf( __( 'Download file%s', 'woocommerce' ), ( count( $download_files ) > 1 ? ' ' . $i . ': ' : ': ' ) ) . esc_html( $file['name'] ) . '</a></p>';
                                        }

                                        echo implode( '', $links );
                                    }

                                    // Show any purchase notes
                                    if ( in_array( $order->status, array( 'processing', 'completed' ) ) && ( $purchase_note = get_post_meta( $_product->id, '_purchase_note', true ) ) ) {
                                         echo '<p>' . apply_filters( 'the_content', $purchase_note ) . '</p>';
                                    }

                                ?>
                                </div>
                                <div class="quantity"><strong><?php echo __('Quantity', PLSH_THEME_DOMAIN); ?>:</strong> <span><?php echo $item['qty']; ?></span></div>                                    
                                <div class="price"><?php echo $order->get_formatted_line_subtotal( $item ); ?></div>
                            </div>
                            <?php
                    endforeach;
                endif;

                do_action( 'woocommerce_order_items_table', $order );
                ?>
        </div>

        <div class="order-totals clearfix">
            <?php
                if ( $totals = $order->get_order_item_totals() )
                {
                    $count = count($totals);
                    $i = 1;

                    foreach ( $totals as $total ) :
                        ?>
                        <div class="order-total-row clearfix <?php if($i == $count) echo 'last'; ?>">
                            <div class="label"><?php echo $total['label']; ?></div>
                            <div class="value"><?php echo $total['value']; ?></div>
                        </div>
                        <?php
                        $i++;
                    endforeach;
                }
            ?>
        </div>

        <?php do_action( 'woocommerce_order_details_after_order_table', $order ); ?>

        <div class="details clearfix">
            <div class="inner-wrap">
                <div class="details-item">
                    <h4><?php _e( 'Customer details', 'woocommerce' ); ?></h4>
                    <?php
                        if ($order->billing_email) echo '<div class="clearfix"><div class="label">'.__( 'Email:', 'woocommerce' ).'</div><div class="value">'.$order->billing_email.'</div></div>';
                        if ($order->billing_phone) echo '<div class="clearfix"><div class="label">'.__( 'Telephone:', 'woocommerce' ).'</div><div class="value">'.$order->billing_phone.'</div></div>';
                    ?>
                </div>
                <?php if (get_option('woocommerce_ship_to_billing_address_only')=='no') : ?>
                    <div class="details-item">
                        <h4><?php _e( 'Billing Address', 'woocommerce' ); ?></h4>
                        <?php
                            if (!$order->get_formatted_billing_address()) _e( 'N/A', 'woocommerce' ); else echo $order->get_formatted_billing_address();
                        ?>
                    </div>
                <?php endif; ?>
                <?php if (get_option('woocommerce_ship_to_billing_address_only')=='no') : ?>
                    <div class="details-item">
                        <h4><?php _e( 'Shipping Address', 'woocommerce' ); ?></h4>
                        <?php
                            if (!$order->get_formatted_shipping_address()) _e( 'N/A', 'woocommerce' ); else echo $order->get_formatted_shipping_address();
                        ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>

    </div>
    
<div class="clear"></div>