<?php

add_shortcode( 'welcome', 'sc_welcome_block' );
add_shortcode( 'product_catalog', 'sc_product_catalog' );
add_shortcode( 'product_column', 'sc_product_column' );
add_shortcode( 'banners', 'sc_banners' );
add_shortcode( 'columns_wrapper', 'sc_columns_wrapper' );
add_shortcode( 'post_column', 'sc_latest_posts' );
add_shortcode( 'about_column', 'sc_about_column' );


function sc_welcome_block( $atts, $content ) {
	extract( shortcode_atts( array(
		'title' => __('Welcome to <span>Pandora</span>, responsive Shopify theme', PLSH_THEME_DOMAIN),
		'image' => PLSH_IMG_URL . 'pandora-preview-1.png',
	), $atts ) );

    ?>
    <!-- BEGIN .welcome-message-1 -->
    <div class="welcome-message-1" style="background-image: url(<?php echo $image; ?>);">
        <h2><?php echo $title; ?></h2>
        <?php echo $content; ?>
    <!-- END .welcome-message-1 -->
    </div>
	<?php
}

function sc_product_catalog($atts) 
{
    if(!plsh_is_woocommerce_active())
    {
        //_e('Woocommerce is either disabled or not installed at all!', PLSH_THEME_DOMAIN);
        return;
    }
    
    extract( shortcode_atts( array(
		'title' => __('Featured items', PLSH_THEME_DOMAIN),
		'count' => 8,
        'url'   => get_permalink( woocommerce_get_page_id( 'shop' ) ),
        'type'  => 'latest',
     'category' => NULL,
        'tag'   => NULL
	), $atts ) );

    ?>
    <!-- BEGIN .featured-items -->
    <div class="catalog featured-items clearfix">
        <div class="main-title clearfix">
            <p><?php echo $title; ?></p>
            <a href="<?php echo $url; ?>" class="view"><?php _e('view more items', PLSH_THEME_DOMAIN);?></a>
        </div>
    <?php
    if(plsh_is_shop_installed())
    {
        $items = array();
        if(!$category && !$tag)
        {
            if($type == 'featured') $items = get_woocommerce_featured_products($count);
            if($type == 'latest')   $items = get_woocommerce_latest_products($count);
            if($type == 'popular')  $items = get_woocommerce_popular_products($count);
        }
        else
        {
            $items = get_woocommerce_products_by_taxonomy($category, $tag, $count);
        }
                
        if(!empty($items))
        {
            $ids = array();
            foreach($items as $key => $item)
            {    
                $ids[] = $item->ID;
            }
            echo do_shortcode('[products ids="' . implode(', ', $ids) . '"]');
        }
    }
    ?>
    <!-- END .featured-items -->
    </div>
    <?php
}

function sc_product_column($atts)
{
    if(!plsh_is_woocommerce_active())
    {
        //_e('Woocommerce is either disabled or not installed at all!', PLSH_THEME_DOMAIN);
        return;
    }
    
    extract( shortcode_atts( array(
		'title' => __('Popular items', PLSH_THEME_DOMAIN),
		'count' => 4,
        'url'   => get_permalink( woocommerce_get_page_id( 'shop' ) ),
        'type'  => 'latest',
     'category' => NULL,
        'tag'   => NULL
	), $atts ) );
    
    ?>
    <!-- BEGIN .best-sellers -->
    <div class="homepage-column best-sellers">

        <div class="main-title clearfix">
            <p><?php echo $title; ?></p>
        </div>
        <?php
        if(plsh_is_shop_installed())
        {
            $items = array();
            if(!$category && !$tag)
            {
                if($type == 'featured') $items = get_woocommerce_featured_products($count);
                if($type == 'latest')   $items = get_woocommerce_latest_products($count);
                if($type == 'popular')  $items = get_woocommerce_popular_products($count);
            }
            else
            {
                $items = get_woocommerce_products_by_taxonomy($category, $tag, $count);
            }
            
            if(!empty($items))
            {
                ?> <div class="items"> <?php
                   
                    global $post, $product;
                    foreach($items as $post)
                    {    
                        @setup_postdata($post);
                        plsh_get_theme_template('loop-product-list-item-small');
                    }
                
                ?> </div> <?php
            }
        }
        ?>
        
    <!-- END .best-sellers -->	
    </div> 
    <?php
    
}

function sc_banners($atts)
{
    extract( shortcode_atts( array(
		'title' => __('Special offers', PLSH_THEME_DOMAIN),
		'count' => 3,
        'group' => NULL
	), $atts ) );
    
    $items = plsh_get_banners($group, $count);
    if(!empty($items))
    {
    ?>
    <!-- BEGIN .special-offers -->
    <div class="special-offers clearfix">	
        <div class="main-title clearfix">
            <p><?php echo $title; ?></p>
        </div>
        <?php
            global $post;
            foreach($items as $post)
            {    
                setup_postdata($post);
                plsh_get_theme_template('banner');
            }
        ?>
    <!-- END .special-offers -->
    </div>
    <?php
    }
}

function sc_columns_wrapper($atts, $content)
{
    extract( shortcode_atts( array(
		'title' => __('Special offers', PLSH_THEME_DOMAIN),
		'count' => 3,
        'group' => NULL
	), $atts ) );
    ?>
    <!-- BEGIN .homepage-columns -->
    <div class="homepage-columns clearfix">
        <?php do_shortcode($content); ?>
    <!-- END .homepage-columns -->
    </div>
    <?php
}

function sc_latest_posts($atts)
{
    extract( shortcode_atts( array(
		'title' => __('Latest posts', PLSH_THEME_DOMAIN),
		'count' => 3,
        'category' => NULL,
        'tag'   => NULL
	), $atts ) );
    
    $args = array(
        'category_name' => $category,
        'tag' => $tag
    );
    
    ?>
    <div class="homepage-column blog">					
        <div class="main-title clearfix">
            <p><?php echo $title; ?></p>
        </div>
       <?php
           $items = plsh_get_post_collection($args, $count);
           if(!empty($items))
           {
               global $post; 
               ?> <div class="items"> <?php
                
               foreach($items as $post)
               {
                   setup_postdata($post);
                   plsh_get_theme_template('loop-default-widget-item');
               }
                
               ?> </div> <?php

           }
       ?>
    </div>
	<?php
}

function sc_about_column($atts, $content)
{
    extract( shortcode_atts( array(
		'title' => __('Contacts &amp; Info', PLSH_THEME_DOMAIN),
        'phone' => NULL,
        'email' => NULL
	), $atts ) );
    ?>
    <!-- BEGIN .about-us -->
    <div class="homepage-column about-us">

        <div class="main-title clearfix">
            <p><?php echo $title; ?></p>
        </div>
        
        <?php echo $content; ?>
        
        <?php if($phone) echo '<a href="#" class="phone">' . $phone . '</a>'; ?>
        <?php if($email) echo '<a href="mailto:' . $email . '" class="email">' . $email . '</a>'; ?>
        
    <!-- END .about-us -->	
    </div>
    <?php
}


?>