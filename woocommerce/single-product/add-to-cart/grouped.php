<?php
/**
 * Grouped product add to cart
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.1.7
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $woocommerce, $product, $post;
$parent_product_post = $post;

do_action('woocommerce_before_add_to_cart_form'); ?>

<div class="grouped-prouducts clearfix">
    <?php foreach ( $grouped_products as $product_id ) :
					$product = get_product( $product_id );
					$post    = $product->post;
					setup_postdata( $post ); 
    ?>

    <div class="item <?php if($product->is_sold_individually()) echo 'quantity'; ?>">
        
        <div class="item-block-1 small">
            <div class="image-wrapper">
                <div class="image">
                    <?php echo $product->get_image('order_review'); ?>
                </div>
            </div>
        </div>
        
        <label for="product-<?php echo $product->id; ?>">
        <?php            
            echo $product->is_visible() ? '<a href="' . get_permalink() . '">' . get_the_title() . '</a>' : get_the_title();
        ?>
        </label>
        
        <div class="price">
        <?php echo $product->get_price_html(); ?>
        </div>
             
        <?php if ( $product->is_sold_individually() || ! $product->is_purchasable() ) : ?>
            <?php woocommerce_template_loop_add_to_cart(); ?>
        <?php else : ?>
            <?php
                $quantites_required = true;
                woocommerce_quantity_input( array( 'input_name' => 'quantity[' . $product_id . ']', 'input_value' => '0', 'grouped' => true ) );
            ?>
        <?php endif; ?>
    
    </div>
<?php endforeach; 
    // Reset to parent grouped product
    $post    = $parent_product_post;
    $product = get_product( $parent_product_post->ID );
    setup_postdata( $parent_product_post );
    ?>
</div>

<?php if ( $quantites_required ) : ?>

    <?php do_action('woocommerce_before_add_to_cart_button'); ?>
    <div class="buy">
        <button type="submit" class="single_add_to_cart_button button alt"><?php echo apply_filters('single_add_to_cart_text', __( 'Add to cart', 'woocommerce' ), $product->product_type); ?></button>
        <?php if(!empty($post->is_quickshop)) : ?>
            <span class="ajax-form-submited-wrap"><div class="ajax-form-loader"></div><div class="ajax-form-submited-success"><?php _e('Item added to cart!' , PLSH_THEME_DOMAIN); ?></div></span>
        <?php endif; ?>
    </div>
    <?php do_action('woocommerce_after_add_to_cart_button'); ?>

<?php endif; ?>