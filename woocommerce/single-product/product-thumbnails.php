<?php
/**
 * Single Product Thumbnails
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.0.3
 */

global $post, $product, $woocommerce;

if(has_post_thumbnail()) {

    $variant_images_found = false;
    if($product->product_type == 'variable')
    {
        $variations = $product->get_available_variations();
        foreach($variations as $variant)
        {
            if(has_post_thumbnail( $variant['variation_id'] ))
            {
                $gallery[] = get_post_thumbnail_id($variant['variation_id']);
                $variant_images_found = true;
            }
        }
    }
    
    if(!$variant_images_found)
    {
        $gallery = $product->get_gallery_attachment_ids();
    }
    

    if (count($gallery) > 0) 
    {
        $gallery = array_merge(array(get_post_thumbnail_id()), $gallery); //merge the main thumbnail

    ?>
    <div class="thumbnails clearfix">
        <?php

        $loop = 0;

        echo '<ul class="jcarousel-skin-tango">';

        foreach ( $gallery as $value ) 
        {

            $classes = array( );

            if ( $loop == 0 ) $classes[] = 'active';

            printf( '<li><a href="%s" rel="thumbnails" data-id="image-%s" class="%s">%s</a></li>', wp_get_attachment_url( $value ), $value, implode(' ', $classes), wp_get_attachment_image( $value, apply_filters( 'single_product_small_thumbnail_size', 'product_thumbnail' ) ) );

            $loop++;

        }

        echo '</ul>';
    ?>
    </div>
<?php 

    }
} ?>