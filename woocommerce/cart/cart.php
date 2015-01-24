<?php
/**
 * Cart Page
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.1.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $woocommerce;

wc_print_notices();

?>

<!-- BEGIN .main-cart -->
<div class="main-cart">

    <div class="titles clearfix">
        <p class="product"><?php _e('Product name', PLSH_THEME_DOMAIN); ?></p>
        <p class="quantity"><?php _e('Quantity', PLSH_THEME_DOMAIN); ?></p>
        <p class="price"><?php _e('Price', PLSH_THEME_DOMAIN); ?></p>
    </div>

<?php do_action( 'woocommerce_before_cart' ); ?>

<form action="<?php echo esc_url( $woocommerce->cart->get_cart_url() ); ?>" method="post">

    <?php do_action( 'woocommerce_before_cart_table' ); ?>


    <?php do_action( 'woocommerce_before_cart_contents' ); ?>

    <?php
    if ( sizeof( $woocommerce->cart->get_cart() ) > 0 ) 
    {
        foreach ( $woocommerce->cart->get_cart() as $cart_item_key => $values ) 
        {
            $_product = $values['data'];
            if ( $_product->exists() && $values['quantity'] > 0 ) 
            {
                ?>
                <div class="row clearfix <?php echo esc_attr( apply_filters('woocommerce_cart_table_item_class', 'cart_table_item', $values, $cart_item_key ) ); ?>">
                    <div class="item-block-1">
                        <?php if ($_product->is_on_sale()) : ?>
                            <span class="tag-sale"></span>
                        <?php endif; ?>
                        <div class="image-wrapper">
                            <div class="image">
                                <div class="overlay">
                                    <div class="position">
                                        <div>
                                            <a href="<?php echo esc_url( get_permalink( apply_filters('woocommerce_in_cart_product_id', $values['product_id'] ) ) ); ?>" class="view"><?php _e('View more', PLSH_THEME_DOMAIN); ?></a>
                                        </div>
                                    </div>
                                </div>
                                <a href="<?php echo esc_url( get_permalink( apply_filters('woocommerce_in_cart_product_id', $values['product_id'] ) ) ); ?>">
                                <?php
                                    echo apply_filters( 'woocommerce_in_cart_product_thumbnail', $_product->get_image('product_catalog_small'), $values, $cart_item_key );
                                ?>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="product">
                        <?php
                            if ( ! $_product->is_visible() || ( ! empty( $_product->variation_id ) && ! $_product->parent_is_visible() ) )
                                echo apply_filters( 'woocommerce_in_cart_product_title', $_product->get_title(), $values, $cart_item_key );
                            else
                                printf('<h4><a href="%s">%s</a></h4>', esc_url( get_permalink( apply_filters('woocommerce_in_cart_product_id', $values['product_id'] ) ) ), apply_filters('woocommerce_in_cart_product_title', $_product->get_title(), $values, $cart_item_key ) );

                            // Meta data
                            echo '<p>' . $woocommerce->cart->get_item_data( $values, true ) . '</p>';

                            // Backorder notification
                            if ( $_product->backorders_require_notification() && $_product->is_on_backorder( $values['quantity'] ) )
                                echo '<p class="backorder_notification">' . __( 'Available on backorder', 'woocommerce' ) . '</p>';
                        ?>
                    </div>
                    <div class="quantity">
                        <?php
                            if ( $_product->is_sold_individually() ) {
                                $product_quantity = sprintf( '<strong>1</strong> <input type="hidden" name="cart[%s][qty]" value="1" />', $cart_item_key );
                            } else {

                                $step	= apply_filters( 'woocommerce_quantity_input_step', '1', $_product );
                                $min 	= apply_filters( 'woocommerce_quantity_input_min', '', $_product );
                                $max 	= apply_filters( 'woocommerce_quantity_input_max', $_product->backorders_allowed() ? '' : $_product->get_stock_quantity(), $_product );

                                $product_quantity = sprintf( '<input type="text" name="cart[%s][qty]" step="%s" min="%s" max="%s" value="%s" size="4" title="' . _x( 'Qty', 'Product quantity input tooltip', 'woocommerce' ) . '" />', $cart_item_key, $step, $min, $max, esc_attr( $values['quantity'] ) );
                                
                                $product_quantity .= '<button class="more"></button><button class="less"></button>';

                            }

                            echo apply_filters( 'woocommerce_cart_item_quantity', $product_quantity, $cart_item_key );
                        ?>

                    </div>
                    <div class="price">
                        <?php
                            $product_price = get_option('woocommerce_tax_display_cart') == 'excl' ? $_product->get_price_excluding_tax() : $_product->get_price_including_tax();
                            echo apply_filters('woocommerce_cart_item_price_html', woocommerce_price( $product_price ), $values, $cart_item_key );
                        ?>
                    </div>
                    <div class="delete">
                        <button onClick="window.location='<?php echo esc_url( $woocommerce->cart->get_remove_url( $cart_item_key ) ); ?>'; return false;"></button>
                    </div>
                </div>
                <?php
            }
        }
    }

    do_action( 'woocommerce_cart_contents' );
    
    ?>
    
    <div class="row clearfix">
        <?php woocommerce_cart_totals(); ?>
    </div>
    
    <div class="row clearfix">
        <?php if ( $woocommerce->cart->coupons_enabled() ) { ?>
            <div class="coupon">

                <label for="coupon_code"><?php _e( 'Coupon', 'woocommerce' ); ?>:</label>
                <input name="coupon_code" type="text" class="input-text" id="coupon_code" value="" />
                <input type="submit" class="apply_coupon" name="apply_coupon" value="<?php _e( 'Apply Coupon', 'woocommerce' ); ?>"/>

                <?php do_action('woocommerce_cart_coupon'); ?>

            </div>
        <?php } ?>
        
        <div class="buttons">
            <input type="submit" class="checkout" name="proceed" value="<?php _e( 'Proceed to Checkout', 'woocommerce' ); ?>" />
            <input type="submit" class="update" name="update_cart" value="<?php _e( 'Update Cart', 'woocommerce' ); ?>" />
        </div>
        <?php do_action('woocommerce_proceed_to_checkout'); ?>

        <?php wp_nonce_field( 'woocommerce-cart' ); ?>
    </div>
    
    <?php do_action( 'woocommerce_after_cart_contents' ); ?>

    <?php do_action( 'woocommerce_after_cart_table' ); ?>

    <div class="row clearfix">
        <?php do_action('woocommerce_cart_collaterals'); ?>

        <?php woocommerce_shipping_calculator(); ?>
    </div>
</form>
    
<?php do_action( 'woocommerce_after_cart' ); ?>

<!-- END .main-cart -->
</div>