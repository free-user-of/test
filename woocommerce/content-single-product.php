<?php

/**
 * The template for displaying product content in the single-product.php template
 *
 * Override this template by copying it to yourtheme/woocommerce/content-single-product.php
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */
?>

<?php
    global $product;

	/**
	 * woocommerce_before_single_product hook
	 *
	 * @hooked woocommerce_show_messages - 10
	 */
	 do_action( 'woocommerce_before_single_product' );
?>

<!-- BEGIN .main-item -->
<section <?php post_class('main-item clearfix'); ?>>

	<?php
		/**
		 * woocommerce_show_product_images hook
		 *
		 * @hooked woocommerce_show_product_sale_flash - 10
		 * @hooked woocommerce_show_product_images - 20
		 */
		do_action( 'woocommerce_before_single_product_summary' );
	?>

	<div class="item-info">
        <h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
        <div class="item-text">
            <?php echo apply_filters( 'woocommerce_short_description', $post->post_excerpt ) ?>
        </div>
        <?php
            if($product->product_type != 'external')
            {
                //get form opening
                $params = array();

                if($product->product_type == 'variable' || $product->product_type == 'variable-subscription')
                {
                    $params = array(
                        'available_variations'  => $product->get_available_variations()
                    );
                }

                woocommerce_get_template('single-product/form.php', $params); 
            }
        ?>
            <div class="details clearfix">

                <?php
                    //if product is variable type, show variants
                    if($product->product_type == 'variable' || $product->product_type == 'variable-subscription')
                    {
                        woocommerce_get_template( 'single-product/variants.php', array(
                            'available_variations'  => $product->get_available_variations(),
                            'attributes'   			=> $product->get_variation_attributes(),
                            'selected_attributes' 	=> $product->get_variation_default_attributes()
                        ) );
                    }
                ?>

                <?php 	 		
                if ( ! $product->is_sold_individually() && $product->product_type != 'external' && $product->product_type != 'grouped')
	 			{
                    woocommerce_quantity_input( 
                        array(
                            'min_value' => apply_filters( 'woocommerce_quantity_input_min', 1, $product ),
                            'max_value' => apply_filters( 'woocommerce_quantity_input_max', $product->backorders_allowed() ? '' : $product->get_stock_quantity(), $product )
                        ) 
                    ); 
                }
                ?>
    
                <?php woocommerce_template_single_meta(); ?>
                
                <?php woocommerce_template_single_sharing(); ?>
                
                <?php
                    /**
                     * woocommerce_single_product_summary hook
                     * @all default hooks removed
                     */
                    do_action( 'woocommerce_single_product_summary' );
                ?>

            </div><!-- .details -->
            <?php
                if(!in_array($product->product_type, array('simple', 'external', 'variable', 'grouped', 'variable-subscription')))
                {
                    woocommerce_get_template('single-product/price.php');
                }
            ?>
            
            <?php woocommerce_template_single_add_to_cart(); ?>
        
        </form>
            
        <?php do_action('woocommerce_after_add_to_cart_form'); ?>
        
	</div><!-- .item-info -->

	<?php
		/**
		 * woocommerce_after_single_product_summary hook
		 *
		 * @hooked woocommerce_output_product_data_tabs - 10
		 * @hooked woocommerce_output_related_products - 20
		 */
		do_action( 'woocommerce_after_single_product_summary' );
	?>

<!-- END .main-item -->
</section>

<?php do_action( 'woocommerce_after_single_product' ); ?>