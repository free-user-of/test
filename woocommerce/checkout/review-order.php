<?php
/**
 * Review order form
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.1.8
 * 
 * @edited      Planetshine
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $woocommerce;

?>    


<?php if ( ! is_ajax() ) : ?><div id="order_review"><?php endif; ?>

    <div id="payment" class="second-step checkout-step checkout-item payment">
        <div class="main-title">
            <p class="custom-font-1"><?php _e('How would you like to pay for you order?', PLSH_THEME_DOMAIN); ?></p>
        </div>

        <?php if ($woocommerce->cart->needs_payment()) : ?>
        <div class="payment_methods methods payment-type clearfix">
            <?php
                $available_gateways = $woocommerce->payment_gateways->get_available_payment_gateways();
                if ( ! empty( $available_gateways ) ) {

                    // Chosen Method
                    if ( isset( $woocommerce->session->chosen_payment_method ) && isset( $available_gateways[ $woocommerce->session->chosen_payment_method ] ) ) {
                        $available_gateways[ $woocommerce->session->chosen_payment_method ]->set_current();
                    } elseif ( isset( $available_gateways[ get_option( 'woocommerce_default_gateway' ) ] ) ) {
                        $available_gateways[ get_option( 'woocommerce_default_gateway' ) ]->set_current();
                    } else {
                        current( $available_gateways )->set_current();
                    }

                    foreach ( $available_gateways as $gateway ) {
                        ?>
                        <p>
                            <input type="radio" id="payment_method_<?php echo $gateway->id; ?>" class="input-radio" name="payment_method" value="<?php echo esc_attr( $gateway->id ); ?>" <?php checked( $gateway->chosen, true ); ?> />
                            <?php echo $gateway->get_title(); ?> <?php echo $gateway->get_icon(); ?>
                            <?php
                                if ( $gateway->has_fields() || $gateway->get_description() ) :
                                    echo '<div class="payment_box payment_method_' . $gateway->id . '" ' . ( $gateway->chosen ? '' : 'style="display:none;"' ) . '>';
                                    $gateway->payment_fields();
                                    echo '</div>';
                                endif;
                            ?>
                        </p>
                        <?php
                    }
                } else {

                    if ( ! $woocommerce->customer->get_country() )
                        echo '<p class="info">' . __( 'Please fill in your details above to see available payment methods.', 'woocommerce' ) . '</p>';
                    else
                        echo '<p class="info">' . __( 'Sorry, it seems that there are no available payment methods for your state. Please contact us if you require assistance or wish to make alternate arrangements.', 'woocommerce' ) . '</p>';

                }
            ?>
        </div>
        <?php endif; ?>

        <div class="next-step">
            <table>
                <tr>
                    <td>
                        <a href="#" class="button-1 custom-font-1"><span><?php _e('Continue to next step', PLSH_THEME_DOMAIN); ?></span></a><b><?php _e('or', PLSH_THEME_DOMAIN); ?> <a href="<?php echo home_url('/'); ?>"><?php _e('Return to store', PLSH_THEME_DOMAIN); ?></a></b>
                    </td>
                </tr>
            </table>
        </div> 
    </div>
    
    <div class="checkout-step final-checkout-step">
        <!-- BEGIN .main-cart -->
        <div class="main-cart">

            <div class="titles clearfix">
                <p class="product"><?php _e('Product name', PLSH_THEME_DOMAIN); ?></p>
                <p class="quantity"><?php _e('Quantity', PLSH_THEME_DOMAIN); ?></p>
                <p class="price"><?php _e('Total', PLSH_THEME_DOMAIN); ?></p>
            </div>

            <div class="cart-row-wrap">
            <?php
                do_action( 'woocommerce_review_order_before_cart_contents' );

                if (sizeof($woocommerce->cart->get_cart())>0) :
                    foreach ($woocommerce->cart->get_cart() as $item_id => $values) :
                        $_product = $values['data'];
                        if ($_product->exists() && $values['quantity']>0) :
                            ?>
                                <div class="row clearfix <?php echo esc_attr( apply_filters('woocommerce_checkout_table_item_class', 'checkout_table_item', $values, $item_id ) ); ?>">
                                    <div class="item-block-1">
                                        <div class="image-wrapper">
                                            <div class="image">
                                                <?php echo $_product->get_image('order_review'); ?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="product-detail-wrap">
                                        <div class="product">
                                            <h4><?php echo $_product->get_title(); ?></h4>
                                            <p><?php echo $woocommerce->cart->get_item_data( $values, true ); ?></p>
                                        </div>
                                        <div class="quantity"><?php echo $values['quantity']; ?></div>                                    
                                        <div class="price"><?php echo apply_filters( 'woocommerce_checkout_item_subtotal', $woocommerce->cart->get_product_subtotal( $_product, $values['quantity'] ), $values, $item_id ); ?></div>
                                    </div>
                                </div>
                            <?php
                        endif;
                    endforeach;
                endif;

                do_action( 'woocommerce_review_order_after_cart_contents' );
            ?>
                <div class="row clearfix">
                    <div class="total-table">
                        <table class="shop_table">
                            <tr class="cart-subtotal">
                                <th><?php _e( 'Cart Subtotal', 'woocommerce' ); ?>:</th>
                                <td><?php echo $woocommerce->cart->get_cart_subtotal(); ?></td>
                            </tr>

                            <?php foreach ( WC()->cart->get_coupons( 'cart' ) as $code => $coupon ) : ?>
                                <tr class="cart-discount coupon-<?php echo esc_attr( $code ); ?>">
                                    <th><?php _e( 'Coupon:', 'woocommerce' ); ?> <?php echo esc_html( $code ); ?></th>
                                    <td><?php wc_cart_totals_coupon_html( $coupon ); ?></td>
                                </tr>
                            <?php endforeach; ?>

                            <?php if ( WC()->cart->needs_shipping() && WC()->cart->show_shipping() ) : ?>

                                <?php do_action( 'woocommerce_review_order_before_shipping' ); ?>

                                <?php wc_cart_totals_shipping_html(); ?>

                                <?php do_action( 'woocommerce_review_order_after_shipping' ); ?>

                            <?php endif; ?>

                            <?php foreach ( WC()->cart->get_fees() as $fee ) : ?>
                                <tr class="fee">
                                    <th><?php echo esc_html( $fee->name ); ?></th>
                                    <td><?php wc_cart_totals_fee_html( $fee ); ?></td>
                                </tr>
                            <?php endforeach; ?>

                            <?php if ( WC()->cart->tax_display_cart === 'excl' ) : ?>
                                <?php if ( get_option( 'woocommerce_tax_total_display' ) === 'itemized' ) : ?>
                                    <?php foreach ( WC()->cart->get_tax_totals() as $code => $tax ) : ?>
                                        <tr class="tax-rate tax-rate-<?php echo sanitize_title( $code ); ?>">
                                            <th><?php echo esc_html( $tax->label ); ?></th>
                                            <td><?php echo wp_kses_post( $tax->formatted_amount ); ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else : ?>
                                    <tr class="tax-total">
                                        <th><?php echo esc_html( WC()->countries->tax_or_vat() ); ?></th>
                                        <td><?php echo wc_price( WC()->cart->get_taxes_total() ); ?></td>
                                    </tr>
                                <?php endif; ?>
                            <?php endif; ?>

                            <?php foreach ( WC()->cart->get_coupons( 'order' ) as $code => $coupon ) : ?>
                                <tr class="order-discount coupon-<?php echo esc_attr( $code ); ?>">
                                    <th><?php _e( 'Coupon:', 'woocommerce' ); ?> <?php echo esc_html( $code ); ?></th>
                                    <td><?php wc_cart_totals_coupon_html( $coupon ); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </table>
                    </div>
                    <div class="total">
                        <?php do_action( 'woocommerce_review_order_before_order_total' ); ?>
                            <tr class="<?php echo esc_attr( apply_filters( 'woocommerce_cart_item_class', 'cart_item', $cart_item, $cart_item_key ) ); ?>">
                                <td class="product-total">
                                    <label><?php _e( 'Order Total', 'woocommerce' ); ?>:</label>
                                    <p><?php wc_cart_totals_order_total_html(); ?></p>
                                </td>
                            </tr>
                         <?php do_action( 'woocommerce_review_order_after_order_total' ); ?>
                    </div>
                </div>                
                <div class="row place-order clearfix">

                    <?php do_action('woocommerce_before_order_notes', $checkout); ?>
                    <div class="note">
                        <?php if (get_option('woocommerce_enable_order_comments')!='no') : ?>

                            <?php foreach ($checkout->checkout_fields['order'] as $key => $field) : ?>
                                <?php 
                                    if(!empty($field['label']))
                                    {
                                        $field['label'] .= ':';
                                    }
                                ?>
                                <?php woocommerce_form_field( $key, $field, $checkout->get_value( $key ) ); ?>

                            <?php endforeach; ?>

                        <?php endif; ?>
                    </div>
                    <?php do_action('woocommerce_after_order_notes', $checkout); ?>


                    <?php wp_nonce_field( 'woocommerce-process_checkout' ); ?>

                    <?php do_action( 'woocommerce_review_order_before_submit' ); ?>
                    <div class="total">
                        <div class="buttons">
                            <?php
                                $order_button_text = apply_filters( 'woocommerce_order_button_text', __( 'Place order', 'woocommerce' ) );
                                echo apply_filters( 'woocommerce_order_button_html', '<input type="submit" class="checkout" name="woocommerce_checkout_place_order" id="place_order" value="' . esc_attr( $order_button_text ) . '" data-value="' . esc_attr( $order_button_text ) . '" />' );
                            ?>
                        </div>
                    </div>
                    
                    <?php if ( wc_get_page_id( 'terms' ) > 0 && apply_filters( 'woocommerce_checkout_show_terms', true ) ) { 
                        $terms_is_checked = apply_filters( 'woocommerce_terms_is_checked_default', isset( $_POST['terms'] ) );
                        ?>
                        <p class="form-row terms">
                            <label for="terms" class="checkbox"><?php printf( __( 'I&rsquo;ve read and accept the <a href="%s" target="_blank">terms &amp; conditions</a>', 'woocommerce' ), esc_url( get_permalink( wc_get_page_id( 'terms' ) ) ) ); ?></label>
                            <input type="checkbox" class="input-checkbox" name="terms" <?php checked( $terms_is_checked, true ); ?> id="terms" />
                        </p>
                    <?php } ?>

                    <?php do_action( 'woocommerce_review_order_after_submit' ); ?>

                </div>

            </div>
        </div>
    </div>
<?php if ( ! is_ajax() ) : ?></div><?php endif; ?>