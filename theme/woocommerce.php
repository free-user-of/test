<?php

/* Remove woo front end styles */ 
if ( version_compare( WOOCOMMERCE_VERSION, "2.1" ) >= 0 ) {
	add_filter( 'woocommerce_enqueue_styles', '__return_false' );
} else {
	define( 'WOOCOMMERCE_USE_CSS', false );
}
child_manage_woo_styles();

/* General */
remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10);
remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10);    
add_action('woocommerce_before_main_content', 'plsh_wrapper_start', 10);
add_action('woocommerce_after_main_content', 'plsh_wrapper_end', 10);
plsh_image_dimensions();

/* Shop */
remove_action( 'woocommerce_before_main_content' , 'woocommerce_breadcrumb', 20, 0 );
add_action( 'woocommerce_before_main_content' , 'plsh_woocommerce_breadcrumb', 9 );

remove_action( 'woocommerce_after_shop_loop_item' , 'woocommerce_template_loop_add_to_cart', 10 );
remove_action( 'woocommerce_pagination'          , 'woocommerce_catalog_ordering', 20 );  

remove_action('woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30);
remove_action('woocommerce_before_shop_loop', 'woocommerce_result_count', 20);

add_action( 'woocommerce_before_shop_loop' , 'plsh_catalog_start', 9 );
add_action( 'woocommerce_before_shop_loop' , 'plsh_woocommerce_sorting', 10 );

add_action( 'woocommerce_after_shop_loop' , 'plsh_catalog_end', 9 );

add_filter( 'woocommerce_get_price_html', 'plsh_get_price_html', 100, 2 );

remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 5 );

/* Product */

remove_action( 'woocommerce_before_single_product_summary', 'woocommerce_show_product_sale_flash', 10);

remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_title', 5);
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_price', 10);
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_excerpt', 20);
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 30);
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40);
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_sharing', 50);

remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_product_data_tabs', 10);
remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20);
remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_upsell_display', 15);
add_action( 'woocommerce_after_single_product', 'woocommerce_output_product_data_tabs', 10);
add_action( 'woocommerce_after_single_product', 'woocommerce_output_related_products', 20);
add_action( 'woocommerce_after_single_product', 'woocommerce_upsell_display', 15);

add_action('woocommerce_share', 'plsh_woocommerce_product_share');

add_filter ('woocommerce_get_image_size_product_catalog_small', 'woocommerce_get_image_size_product_catalog_small');


/* Cart */

remove_action( 'woocommerce_before_cart', 'woocommerce_template_single_title', 5);
add_action( 'wp_ajax_get_cart', 'plsh_cart_summary' );
add_action( 'wp_ajax_nopriv_get_cart', 'plsh_cart_summary' );

/* Checkout */

remove_action( 'woocommerce_before_checkout_form', 'woocommerce_checkout_coupon_form', 10 );


/* Functions */

function get_woocommerce_featured_products($count = 8)
{
    global $woocommerce;
    global $wpdb;
    
    $query_args = array('posts_per_page' => $count, 'no_found_rows' => 1, 'post_status' => 'publish', 'post_type' => 'product' );

    $query_args['meta_query'] = $woocommerce->query->get_meta_query();
    $query_args['meta_query'][] = array(
        'key' => '_featured',
        'value' => 'yes'
    );

    $result = new WP_Query($query_args);
    return $result->posts;
}

function get_woocommerce_latest_products($count = 8)
{
    return plsh_get_posts_by_type('product', $count);
}

function get_woocommerce_popular_products($count = 8)
{
    $params = array(
        'post_type' => 'product',
        'meta_key'  => 'total_sales', 
    );
    
    return plsh_get_post_collection($params, $count, 'meta_value');
}

function get_woocommerce_products_by_taxonomy($category = NULL, $tag = NULL, $count = 8)
{
    $params = array(
        'post_type' => 'product',
        'product_cat' => $category,
        'product_tag' => $tag
    );
    return plsh_get_post_collection($params, $count);
}


/* Actions */

function plsh_wrapper_start()
{
	?>
	<!-- BEGIN .main-content-wrapper -->
	<section class="main-content-wrapper <?php if(is_product()) echo 'main-item-wrapper'; ?> clearfix">
		
	<?php
}

function plsh_wrapper_end()
{
	?>
	
	<!-- END .main-content-wrapper -->
	</section>
	<?php
}

function plsh_image_dimensions() 
{
    // Image sizes
    update_option( 'woocommerce_thumbnail_image_width', '70' ); // Image gallery thumbs
    update_option( 'woocommerce_thumbnail_image_height', '71' );
    update_option( 'woocommerce_single_image_width', '470' ); // Featured product image
    update_option( 'woocommerce_single_image_height', '470' ); 
    update_option( 'woocommerce_catalog_image_width', '210' ); // Product category thumbs
    update_option( 'woocommerce_catalog_image_height', '260' );

    // Hard Crop [0 = false, 1 = true]
    update_option( 'woocommerce_thumbnail_image_crop', 1 );
    update_option( 'woocommerce_single_image_crop', 1 ); 
    update_option( 'woocommerce_catalog_image_crop', 1 );
    
}

function plsh_woocommerce_breadcrumb()
{
    $args = array(
        'delimiter' => '',
        'wrap_before'  => '',
		'wrap_after' => '',
		'before'   => '<span>',
		'after'   => '</span>',
		'home'    => null
    );
    woocommerce_breadcrumb($args);
}

function plsh_woocommerce_sorting()
{
    $categories = plsh_get_taxonomy_hierarchy('product_cat');
    $shop_page_url = get_permalink( woocommerce_get_page_id( 'shop' ) );
    
    echo '<div class="sorting clearfix">';
    if(!empty($categories))
    {
        ?>
        <form action="<?php echo $shop_page_url; ?>" method="GET">
            <label><?php _e('Browse', PLSH_THEME_DOMAIN); ?>:</label>
            <select name="product_cat" class="submit_selector">
                <option value=""><?php _e('All categories', PLSH_THEME_DOMAIN); ?></option>
                <?php plsh_output_taxonomy_hierarchy_option_tree($categories, 'product_cat');  ?>
            </select>
        </form>
        <?php
    }
    
    if ( ! is_single() ) woocommerce_catalog_ordering();
    
    $args = array(
        'type'                     => 'post',
        'child_of'                 => 0,
        'orderby'                  => 'name',
        'order'                    => 'ASC',
        'hide_empty'               => 1,
        'hierarchical'             => 1,
        'taxonomy'                 => 'product_tag',
        'pad_counts'               => false 
    );
    
    if(plsh_gs('show_collection_tags') == 'on')
    {
        $tags = get_categories( $args );
        
        if(!empty($tags))
        {
            ?>   
                <div class="tags">
                    <label><?php _e('Tags', PLSH_THEME_DOMAIN); ?>:</label>
                    <?php
                    foreach($tags as $tag)
                    {
                        echo '<a href="' . plsh_assamble_url($shop_page_url, array('product_tag=' . $tag->slug), array('product_tag')) . '"';
                        if(plsh_get($_GET, 'product_tag') == $tag->slug) echo 'class="active"';
                        echo '>' . $tag->name . '</a>';
                    }
                    ?>
                </div>
            <?php
        }
    }
    
    echo '</div>';
}

function plsh_catalog_start()
{
    ?>
    <!-- BEGIN .catalog -->
    <section class="catalog">
    <?php
}

function plsh_catalog_end()
{
    ?>
    <!-- END .catalog -->
    </section>
    <?php
}

function woocommerce_template_loop_product_thumbnail() 
{
	?>
    <div class="image-wrapper">
        <div class="image">
            <?php if(plsh_gs('use_quickshop') == 'on') : ?>
            <div class="overlay">
                <div class="position">
                    <div>
                        <p><?php echo strip_tags(get_the_excerpt()); ?></p>
                        <a href="<?php the_permalink(); ?>" id="<?php the_ID(); ?>" class="quickshop button-quick-shop"><?php _e('Quick shop', PLSH_THEME_DOMAIN);?></a>
                    </div>
                </div>
            </div>
            <?php endif; ?>
            <a href="<?php the_permalink(); ?>"><?php echo plsh_get_thumbnail('product_catalog'); ?></a>
        </div>
    </div>
    <?php
}

function plsh_item_details_wrap_start()
{
    ?><div class="details clearfix"><?php
}

function plsh_item_details_wrap_end()
{
    ?></div><?php
}

function child_manage_woo_styles() 
{
	remove_action( 'wp_head', array( $GLOBALS['woocommerce'], 'generator' ) );
	remove_action( 'wp_enqueue_scripts', array( $GLOBALS['woocommerce'], 'frontend_scripts' ) );
}

function plsh_woocommerce_product_share() 
{
    ?>
    <p class="item">
    <label><?php _e('Share this item', PLSH_THEME_DOMAIN); ?>:</label>
    <span class="social-icons clearfix">
        <span class='st_facebook_custom facebook'></span>
        <span class='st_twitter_custom twitter'></span>
        <span class='st_linkedin_custom linkedin'></span>
        <span class='st_stumbleupon_custom stumbleupon'></span>
        <span class='st_blogger_custom blogspot'></span>
    </span>
    <a href="#" class="more st_sharethis_custom">more</a>
    </p>
    <?php
}

function plsh_cart_summary()
{
    global $woocommerce;
    ob_start();
    echo $woocommerce->cart->cart_contents_count . ' ';
    _e('items', PLSH_THEME_DOMAIN);
    echo ' (' . $woocommerce->cart->get_cart_total();
    _e(' in total', PLSH_THEME_DOMAIN);
    echo ')';
    $data = ob_get_contents();
    ob_end_clean();
    die($data);
}

/* Filters */

function plsh_get_price_html($price, $product )
{
    $price = str_replace('<span class="amount">', '', $price);
    $price = str_replace('<span class="from">', '', $price);
    $price = str_replace('</span>', '', $price);
    $price = str_replace('From: ', '<em>from</em>', $price);
    $price = str_replace('<ins>', '', $price);
    $price = str_replace('</ins>', '', $price);
    $price = str_replace('<del>', '<s>', $price);
    $price = str_replace('</del>', '</s>', $price);
    
    if(strpos($price, '</s>') !== false)
    {
        $price_parts = explode('</s>', $price);
        $price = $price_parts[1] . $price_parts[0] . '</s>';
    }
    
    return $price;
}

function woocommerce_get_image_size_product_catalog_small()
{
    $sizes = plsh_gs('image_sizes');
    return array(
        'width' => $sizes['product_catalog_small'][0],
        'height' => $sizes['product_catalog_small'][1],
        'crop' => $sizes['product_catalog_small'][2],
    );
    
}

?>
