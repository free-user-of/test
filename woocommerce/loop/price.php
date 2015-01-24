<?php
/**
 * Loop Price
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

global $product, $post;
?>

<?php 
$price_html = $product->get_price_html();
if ($price_html) 
{
    echo '<p class="price">' . $price_html . '</p>';
}
else
{
    $product = new WC_Product($post->ID);
    echo '<p class="price">' . $product->get_price_html() . '</p>';
}