<?php
/**
 * Variable product add to cart
 *
 * @author 		WooThemes/Planetshine
 * @package 	WooCommerce/Templates
 * @version     2.1.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $woocommerce, $product, $post;
?>

<div class="variations">
    <?php $loop = 0; foreach ( $attributes as $name => $options ) : $loop++; ?>
        <p class="item">
            <label for="<?php echo sanitize_title($name); ?>"><?php echo wc_attribute_label( $name ); ?>:</label>
            <select id="<?php echo esc_attr( sanitize_title($name) ); ?>" name="attribute_<?php echo sanitize_title($name); ?>">
                <option value=""><?php _e('Select', PLSH_THEME_DOMAIN) ?> <?php echo wc_attribute_label( $name ); ?></option>
                <?php
                    if ( is_array( $options ) ) {

                        if ( empty( $_POST ) )
                        {
                            $selected_value = ( isset( $selected_attributes[ sanitize_title( $name ) ] ) ) ? $selected_attributes[ sanitize_title( $name ) ] : '';
                        }
                        else
                        {
                            $selected_value = isset( $_POST[ 'attribute_' . sanitize_title( $name ) ] ) ? $_POST[ 'attribute_' . sanitize_title( $name ) ] : '';
                        }

                        // Get terms if this is a taxonomy - ordered
                        
                        if ( taxonomy_exists( sanitize_title( $name ) ) ) {
                            $orderby = wc_attribute_orderby( $name );

                            switch ( $orderby ) {
                                case 'name' :
                                    $args = array( 'orderby' => 'name', 'hide_empty' => false, 'menu_order' => false );
                                break;
                                case 'id' :
                                    $args = array( 'orderby' => 'id', 'order' => 'ASC', 'menu_order' => false );
                                break;
                                case 'menu_order' :
                                    $args = array( 'menu_order' => 'ASC' );
                                break;
                            }

                            $terms = get_terms( sanitize_title( $name ), $args );

                            foreach ( $terms as $term ) {
                                if ( ! in_array( $term->slug, $options ) ) continue;
                                echo '<option value="' . esc_attr( $term->slug ) . '" ' . selected( $selected_value, $term->slug, false ) . '>' . esc_html(apply_filters( 'woocommerce_variation_option_name', $term->name )) . '</option>';
                            }
                        } 
                        else 
                        {
                            foreach ( $options as $option )
                            {
                                echo '<option value="' . esc_attr( sanitize_title( $option ) ) . '" ' . selected( sanitize_title( $selected_value ), sanitize_title( $option ), false ) . '>' . esc_html (apply_filters( 'woocommerce_variation_option_name', $option )) . '</option>';
                            }
                        }
                    }
                ?>
            </select> 
        </p>
    <?php endforeach;?>
</div>