<?php
/**
 * Product form
 *
 * @author 		Planetshine
 * @package 	WooCommerce/Templates
 * @version     1
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $woocommerce, $product, $post;
?>

<?php do_action('woocommerce_before_add_to_cart_form'); ?>
<?php
    $protocol = ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') || $_SERVER['SERVER_PORT'] == 443) ? "https" : "http";
    
    if($product->product_type == 'variable' || $product->product_type == 'variable-subscription')
    {
        $action = esc_url( plsh_assamble_url( get_permalink($product->id), array('add-to-cart=' . $product->id )));
        if($protocol == 'https')
        {
            if(strpos($action, 'https') === false)
            {
                $action = str_replace($action, 'http', 'https');
            }
        }
        ?>
        <form action="<?php echo $action; ?>" class="variations_form cart <?php if(!empty($post->is_quickshop)) echo 'quickshop-form'; ?>" method="post" enctype='multipart/form-data' data-product_id="<?php echo $post->ID; ?>" data-product_variations="<?php echo esc_attr( json_encode( $available_variations ) ) ?>">
        <div><input type="hidden" name="product_id" value="<?php echo esc_attr( $post->ID ); ?>" /></div>
        <?php 
    } 
    else
    { 
        $action = esc_url( plsh_assamble_url( get_permalink($product->id), array('add-to-cart=' . $product->id )));
        if($protocol == 'https')
        {
            if(strpos($action, 'https') === false)
            {
                $action = str_replace($action, 'http', 'https');
            }
        }
        ?>
        <form action="<?php echo $action; ?>" class="cart <?php if(!empty($post->is_quickshop)) echo 'quickshop-form'; ?>" method="post" enctype='multipart/form-data'>
        <?php 
    } 
    ?>
