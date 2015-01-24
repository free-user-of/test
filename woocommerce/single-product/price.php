<?php
/**
 * Single Product Price, including microdata for SEO
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

global $post, $product;
?>
<div class="price">
    <?php 
    if($product->is_in_stock()) 
    {
        echo $product->get_price_html();
    }
    else
    {
        _e('Sold Out!', PLSH_THEME_DOMAIN);
    }
    ?>
</div>