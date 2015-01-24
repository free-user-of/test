<?php
/**
 * Single product quantity inputs
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.1.0
 * 
 * @edited      Planetshine
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $product;

if(empty($grouped))
{
?>
<div class="item quantity">
    <label><?php _e('Quantity', PLSH_THEME_DOMAIN);?></label>
<?php } ?>
    
    <select name="<?php echo esc_attr( $input_name ); ?>">
        <?php
            if(empty($min_value)) $min_value = 1;
            if($product->product_type == 'grouped') $min_value = 0;
            if(empty($max_value)) $max_value = 10;
            if(empty($step)) $step = 1;
            $i = $min_value;
            $loops = 0;
            
            while($i < $max_value || $loops < 10)
            {    
                ?> <option value="<?php echo esc_attr($i); ?>"><?php echo esc_attr($i); ?></option> <?php
                $i += $step;
                $loops++;
            }
        ?>
    </select>
<?php 
if(empty($grouped))
{ ?>
    </div>
<?php } ?>