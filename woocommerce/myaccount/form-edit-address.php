<?php
/**
 * Edit address form
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.1.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $woocommerce, $current_user;

$page_title = ( $load_address == 'billing' ) ? __( 'Billing Address', 'woocommerce' ) : __( 'Shipping Address', 'woocommerce' );

get_currentuserinfo();
?>

<?php wc_print_notices(); ?>

    <?php if (!$load_address) : ?>

        <?php woocommerce_get_template('myaccount/my-address.php'); ?>

    <?php else : ?>
        <div class="edit-address">
            <form method="post">
                
                <div class="main-title"><p class="custom-font-1"><?php echo apply_filters( 'woocommerce_my_account_edit_address_title', $page_title ); ?></p></div>
                                        
                <div class="items">
                    
                    <?php foreach ( $address as $key => $field ) : ?>

                        <?php woocommerce_form_field( $key, $field, ! empty( $_POST[ $key ] ) ? wc_clean( $_POST[ $key ] ) : $field['value'] ); ?>

                    <?php endforeach; ?>
                    
                </div>

                <div class="buttons">
                    <table>
                        <tr>
                            <td>
                                <input type="submit" class="button" name="save_address" value="<?php _e( 'Save Address', 'woocommerce' ); ?>" />
                                <?php wp_nonce_field( 'woocommerce-edit_address' ); ?>
                                <input type="hidden" name="action" value="edit_address" />
                            </td>
                        </tr>
                    </table>
                </div>
            </form>
        </div>
    <?php endif; ?>
