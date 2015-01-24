<?php
/**
 * Single Product Image
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.0.14
 */

global $post, $product, $woocommerce;

$gallery = $product->get_gallery_attachment_ids();

?>
<div class="item-block-1">
    <div class="image-wrapper" id="_single-product-slider">
        <div class="image" id="image-<?php echo get_post_thumbnail_id(); ?>">
            <?php if ( has_post_thumbnail() ) : ?>

                <a href="<?php echo wp_get_attachment_url( get_post_thumbnail_id() ); ?>" class="lightbox-launcher" title="<?php echo get_the_title( get_post_thumbnail_id() ); ?>">
                    <?php
                    if(empty($post->is_quickshop)) echo plsh_get_thumbnail('product_single');
                    else echo plsh_get_thumbnail('quickshop');
                    ?>
                </a>

            <?php endif; ?>
        </div>
        
        <?php
        $variant_images_printed = false;
        
        if($product->product_type == 'variable')
        {
            $variations = $product->get_available_variations();
            foreach($variations as $variant)
            {
                if(has_post_thumbnail( $variant['variation_id'] ))
                {
                    $id = get_post_thumbnail_id($variant['variation_id']);
                    echo '<div class="image" id="image-' . $variant['variation_id'] . '">';
                    $img = NULL;
                    if(empty($post->is_quickshop))  $img = wp_get_attachment_image_src( $id, 'product_single' );
                    else $img = wp_get_attachment_image_src( $id, 'quickshop' );

                    printf( '<a href="%s" class="lightbox-launcher"><img src="%s" alt=""/></a>', wp_get_attachment_url( $id ), $img[0]);
                    echo '</div>';
                    
                    $variant_images_printed = true;
                }  
            }
        }
        
        if(!$variant_images_printed && !empty($gallery))
        {
            $loop = 0;
            foreach ( $gallery as $value ) 
            {
                echo '<div class="image" id="image-' . $value . '">';
                $img = NULL;
                if(empty($post->is_quickshop))  $img = wp_get_attachment_image_src( $value, 'product_single' );
                else $img = wp_get_attachment_image_src( $value, 'quickshop' );

                printf( '<a href="%s" class="lightbox-launcher"><img src="%s" alt=""/></a>', wp_get_attachment_url( $value ), $img[0]);
                echo '</div>';
            }
        }
        ?>
    </div>

    <?php do_action('woocommerce_product_thumbnails'); ?>
	
</div>