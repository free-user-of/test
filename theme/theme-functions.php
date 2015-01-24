<?php
add_action( 'after_setup_theme', 'plsh_setup' );
add_action( 'wp_enqueue_scripts', 'plsh_add_stylesheets');
add_action( 'wp_enqueue_scripts', 'plsh_add_scripts' );
add_action( 'wp_default_scripts', 'plsh_print_scripts_in_footer' );
add_action( 'parse_query', 'wpse_71157_parse_query' );  //fix wp bug
add_action( 'init', 'plsh_add_slider_post_type' );
add_action( 'init', 'plsh_add_banner_post_type' );
add_action( 'widgets_init', 'plsh_add_widgets');

add_action( 'add_meta_boxes', 'plsh_banner_meta_box' );
add_action( 'save_post', 'plsh_banner_save_postdata' );

add_action( 'wp_ajax_quickshop', 'plsh_quickshop_callback' );
add_action( 'wp_ajax_nopriv_quickshop', 'plsh_quickshop_callback' );

add_action( 'wp_footer', 'plsh_add_sharethis' );

add_filter( 'excerpt_length', 'plsh_custom_excerpt_length', 999 );
add_filter( 'excerpt_more', 'plsh_custom_excerpt_more', 999 );
add_filter( 'the_title','wp_kses_post' );
//add_filter( 'the_content','wp_kses_post' );
add_filter( 'comment_text','wp_kses_post' );
add_filter( 'comment_author_url','wp_kses_post' );

add_action( 'customize_register', 'plsh_customize_register' );
add_action( 'wp_head', 'plsh_header_output');

add_action( 'tgmpa_register', 'pandora_register_required_plugins' );
add_action( 'wp_head', 'plsh_output_theme_version' );

add_filter('the_content', 'plsh_shortcode_empty_paragraph_fix');

/* SETUP */

function plsh_setup() 
{

	/* Make theme available for translation.
	 * Translations can be added to the /languages/ directory.
	 */
	load_theme_textdomain( PLSH_THEME_DOMAIN, get_template_directory() . '/languages' );
    
    
	// This theme styles the visual editor with editor-style.css to match the theme style.
	add_theme_support('woocommerce');
    add_editor_style();
	add_theme_support( 'automatic-feed-links' );
	
    register_nav_menu( 'primary', __( 'Primary Menu', PLSH_THEME_DOMAIN ) );
    register_nav_menu( 'footer', __( 'Footer Menu', PLSH_THEME_DOMAIN ) );
    
	add_theme_support( 'post-thumbnails' );
    plsh_add_image_sizes();
            
	plsh_cache_menu_item_children();
	plsh_include_woocommerce_functions();
    
    $sidebars = plsh_gs('sidebars');
    if(!empty($sidebars))
    {
        foreach($sidebars as $sidebar)
        {
            register_sidebar( $sidebar );
        }
    }
    
    include_once('shortcodes.php');
    
	add_filter( 'nav_menu_css_class', 'plsh_check_for_submenu', 10, 2);
}

function plsh_include_woocommerce_functions()
{
    if (!plsh_is_woocommerce_active()) return;  
    include_once 'woocommerce.php';
}

/* POST TYPES */

function plsh_add_slider_post_type() 
{
  $labels = array(
    'name' => 'Slide',
    'singular_name' => 'Slide',
    'add_new' => 'Add New',
    'add_new_item' => 'Add New Slide',
    'edit_item' => 'Edit Slide',
    'new_item' => 'New Slide',
    'all_items' => 'All Slides',
    'view_item' => 'View Slide',
    'search_items' => 'Search Slides',
    'not_found' =>  'No slides found',
    'not_found_in_trash' => 'No slides found in Trash', 
    'parent_item_colon' => '',
    'menu_name' => 'Slider'
  );

  $args = array(
    'labels' => $labels,
    'public' => true,
    'publicly_queryable' => true,
    'show_ui' => true, 
    'show_in_menu' => true, 
    'query_var' => true,
    'rewrite' => array( 'slug' => 'slider' ),
    'capability_type' => 'post',
    'has_archive' => false, 
    'hierarchical' => false,
    'menu_position' => null,
    'supports' => array( 'title', 'thumbnail', 'excerpt' )
  ); 

  register_post_type( 'slider', $args );
}

function plsh_add_banner_post_type() 
{
  $labels = array(
    'name' => 'Banners',
    'singular_name' => 'Banner',
    'add_new' => 'Add New',
    'add_new_item' => 'Add New Banner',
    'edit_item' => 'Edit Banner',
    'new_item' => 'New Banner',
    'all_items' => 'All Banners',
    'view_item' => 'View Banner',
    'search_items' => 'Search Banners',
    'not_found' =>  'No banners found',
    'not_found_in_trash' => 'No banners found in Trash', 
    'parent_item_colon' => '',
    'menu_name' => 'Banners'
  );

  $args = array(
    'labels' => $labels,
    'public' => true,
    'publicly_queryable' => true,
    'show_ui' => true, 
    'show_in_menu' => true, 
    'query_var' => true,
    'rewrite' => array( 'slug' => 'banner' ),
    'capability_type' => 'post',
    'has_archive' => false, 
    'hierarchical' => false,
    'menu_position' => null,
    'supports' => array( 'title', 'thumbnail', 'excerpt')
  ); 

  register_post_type( 'banner', $args );
}

/* META BOXES */
add_action( 'add_meta_boxes', 'plsh_banner_meta_box' );
add_action( 'add_meta_boxes', 'plsh_slider_meta_box' );
add_action( 'save_post', 'plsh_banner_save_postdata' );
add_action( 'save_post', 'plsh_slider_save_postdata' );

//banners
function plsh_banner_meta_box() 
{
    add_meta_box(
        'banner_bg_id',
        __('Banner properties', PLSH_THEME_DOMAIN),
        'plsh_banner_inner_custom_box',
        'banner'
    );
}

function plsh_banner_inner_custom_box( $post ) 
{
    // Use nonce for verification
    wp_nonce_field( plugin_basename( __FILE__ ), 'banner_noncename' );

    $url = get_post_meta( $post->ID, $key = 'banner_url_meta', $single = true );
    echo '<p>';
    echo '<label for="banner_url">';
         _e("Web address that the banner will link to:", PLSH_THEME_DOMAIN);
    echo '</label><br/>';
    echo '<input type="text" id="banner_url" name="banner_url" value="' . esc_attr($url) . '" style="width: 400px;">';
    echo '</p>';

    $background = get_post_meta( $post->ID, $key = 'banner_background_meta', $single = true );
    echo '<p>';
    echo '<label for="banner_background">';
         _e("Select banner background:", PLSH_THEME_DOMAIN);
    echo '</label><br/>';
    echo '<select id="banner_background" name="banner_background" value="' . esc_attr($background) . '" style="width: 200px;">';
      echo '<option value="sale"'; if(esc_attr($background) == 'sale') echo 'selected="selected"'; echo '>' . __('Green', PLSH_THEME_DOMAIN) . '</option>';
      echo '<option value="percent-off"'; if(esc_attr($background) == 'percent-off') echo 'selected="selected"'; echo '>' . __('Blue', PLSH_THEME_DOMAIN) . '</option>';
      echo '<option value="specials"'; if(esc_attr($background) == 'specials') echo 'selected="selected"'; echo '>' . __('Orange', PLSH_THEME_DOMAIN) . '</option>';
      echo '<option value="image"'; if(esc_attr($background) == 'image') echo 'selected="selected"'; echo '>' . __('Featured image',PLSH_THEME_DOMAIN) . '</option>';
    echo '</select>';
    echo '</p>';

    $group = get_post_meta( $post->ID, $key = 'banner_group_meta', $single = true );
    echo '<p>';
    echo '<label for="banner_group">';
         _e("Banner group (leave empty for a global banner):", PLSH_THEME_DOMAIN);
    echo '</label><br/>';
    echo '<input type="text" id="banner_group" name="banner_group" value="' . esc_attr($group) . '" style="width: 400px;">';
    echo '</p>';
}

function plsh_banner_save_postdata( $post_id ) 
{
    // Check if the current user is authorised to do this action. 
    if ( 'page' == plsh_get($_POST, 'post_type') || 'page' == plsh_get($_GET, 'post_type') ) {
      if ( ! current_user_can( 'edit_page', $post_id ) )
          return;
    } else {
      if ( ! current_user_can( 'edit_post', $post_id ) )
          return;
    }

    //Nonce verfy
    if ( ! isset( $_POST['banner_noncename'] ) || ! wp_verify_nonce( $_POST['banner_noncename'], plugin_basename( __FILE__ ) ) )
        return;

    $post_ID = $_POST['post_ID'];
    $background = trim(sanitize_text_field( $_POST['banner_background'] ));
    $url = trim(sanitize_text_field( $_POST['banner_url'] ));
    $group = trim(sanitize_text_field( $_POST['banner_group'] ));

    update_post_meta($post_ID, 'banner_background_meta', $background);
    update_post_meta($post_ID, 'banner_url_meta', $url);
    update_post_meta($post_ID, 'banner_group_meta', $group);
}


//sliders
function plsh_slider_meta_box() 
{
    add_meta_box(
        'slider_bg_id',
        __('Slider properties', PLSH_THEME_DOMAIN),
        'plsh_slider_inner_custom_box',
        'slider'
    );
}

/* Prints the box content */
function plsh_slider_inner_custom_box( $post ) 
{
    // Use nonce for verification
    wp_nonce_field( plugin_basename( __FILE__ ), 'slider_noncename' );

    $url = get_post_meta( $post->ID, $key = 'slider_url_meta', $single = true );
    echo '<p>';
    echo '<label for="slider_url">';
         _e("Web address that the slide will link to:", PLSH_THEME_DOMAIN);
    echo '</label><br/>';
    echo '<input type="text" id="slider_url" name="slider_url" value="' . esc_attr($url) . '" style="width: 400px;">';
    echo '</p>';
}

/* When the post is saved, saves our custom data */
function plsh_slider_save_postdata( $post_id ) 
{
    // Check if the current user is authorised to do this action. 
    if ( 'page' == plsh_get($_POST, 'post_type') || 'page' == plsh_get($_GET, 'post_type') ) {
      if ( ! current_user_can( 'edit_page', $post_id ) )
          return;
    } else {
      if ( ! current_user_can( 'edit_post', $post_id ) )
          return;
    }

    //Nonce verfy
    if ( ! isset( $_POST['slider_noncename'] ) || ! wp_verify_nonce( $_POST['slider_noncename'], plugin_basename( __FILE__ ) ) )
        return;

    $post_ID = $_POST['post_ID'];
    $url = trim(sanitize_text_field( $_POST['slider_url'] ));

    update_post_meta($post_ID, 'slider_url_meta', $url);
}


function plsh_customize_register( $wp_customize ) 
{   

    $settings = Plsh_Settings :: get_visual_editor_settings();
    
    if(!empty($settings['head']))
    {
        foreach($settings['head'] as $section)
        {
            $wp_customize->add_section( $section['slug'] , array(
                'title'      => __( $section['name'] , PLSH_THEME_DOMAIN ),
                'priority'   => plsh_get($section, 'priority', 20),
            ) );
            
            if(!empty($settings['body'][$section['slug']]))
            {
                $body = $settings['body'][$section['slug']];
                foreach($body as $item)
                {
                    $wp_customize->add_setting(
                        $item['slug'] , array(
                            'default'     => $item['default'],
                            'transport'   => 'refresh',
                        )
                    );
                    
                    $params = array(
                        'label'        => __( $item['title'], PLSH_THEME_DOMAIN ),
                        'section'    => $section['slug'],
                        'settings'   => $item['slug'],
                    );
                    
                    if($item['type'] == 'color')
                    {
                        $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, $item['slug'], $params ));
                    }
                    elseif($item['type'] == 'background')
                    {
                        $wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, $item['slug'], $params ));
                    }
                    else
                    {
                        $control = new WP_Customize_Control( $wp_customize, $item['slug'], $params );
                        if($item['type'] == 'checkbox')
                        {
                            $control->type = $item['type'];
                        }
                        if($item['type'] == 'select' && !empty($item['data']))
                        {
                            $control->type = $item['type'];
                            $control->choices = $item['data'];
                        }
                        if($item['type'] == 'font_select' && !empty($item['data']))
                        {
                            $control->type = 'select';
                            $data = $item['data'];
                            
                            foreach($data as $key => $value)
                            {
                                $control->choices[$key] = $value['name'];
                            }
                        }
                        $wp_customize->add_control( $control );
                    }
                }
            }
            
        }
        
    }
        
}

function plsh_header_output() {
   ?>
   <!--Customizer CSS--> 
   <style type="text/css">
       <?php
       /***** Fonts *****/     
       
            //logo
            generate_css('.main-header .logo', 'font-family', 'logo_font', '', ', sans-serif');
            
            //slogan
            generate_css('.main-header .slogan', 'font-family', 'slogan_font', '', ', sans-serif');
            
            //menu
            generate_css('.main-menu', 'font-family', 'menu_font', '', ', sans-serif');
            
            //titles
            generate_css('.main-title p', 'font-family', 'title_font', '', ', sans-serif');
            generate_css('.welcome-message-1 h2', 'font-family', 'title_font', '', ', sans-serif');
            generate_css('.homepage-columns .blog h2', 'font-family', 'title_font', '', ', sans-serif');
            generate_css('.main-slider .title .headline', 'font-family', 'title_font', '', ', sans-serif');
            generate_css('.blog-list article .title', 'font-family', 'title_font', '', ', sans-serif');
            generate_css('.post article .title', 'font-family', 'title_font', '', ', sans-serif');
            generate_css('.pages', 'font-family', 'title_font', '', ', sans-serif');
            generate_css('.main-item .item-info h2', 'font-family', 'title_font', '', ', sans-serif');
            generate_css('.woocommerce-tabs .tabs li a', 'font-family', 'title_font', '', ', sans-serif');
            generate_css('.checkout-thankyou .headline', 'font-family', 'title_font', '', ', sans-serif');
            generate_css('.order-details h2.details-title', 'font-family', 'title_font', '', ', sans-serif');
            generate_css('.order-details .order-totals .value', 'font-family', 'title_font', '', ', sans-serif');
            generate_css('.order-details .details .details-item h4', 'font-family', 'title_font', '', ', sans-serif');
            generate_css('.shipping-address-history .content h3', 'font-family', 'title_font', '', ', sans-serif');
            generate_css('.recent-posts article h2', 'font-family', 'title_font', '', ', sans-serif');
            generate_css('.sidebar-item li', 'font-family', 'title_font', '', ', sans-serif');
            
                    
            //product titles
            generate_css('.item-block-1 h2', 'font-family', 'product_name_font', '', ', sans-serif !important');
            generate_css('.main-item .item-info .price', 'font-family', 'product_name_font', '', ', sans-serif');
            generate_css('.item-block-1 .price', 'font-family', 'product_name_font', '', ', sans-serif');
            generate_css('.product_list_widget li', 'font-family', 'product_name_font', '', ', sans-serif');
            generate_css('.main-sidebar .best-sellers .price', 'font-family', 'product_name_font', '', ', sans-serif');
            generate_css('.product_list_widget li a', 'font-family', 'product_name_font', '', ', sans-serif');
            generate_css('.featured-items .item-block-1 .price', 'font-family', 'product_name_font', '', ', sans-serif');
            generate_css('.main-cart form .product h4', 'font-family', 'product_name_font', '', ', sans-serif');
            generate_css('.main-cart form .product p', 'font-family', 'product_name_font', '', ', sans-serif');
            generate_css('.main-cart .product h4', 'font-family', 'product_name_font', '', ', sans-serif');
            generate_css('.main-cart .price', 'font-family', 'product_name_font', '', ', sans-serif');
            generate_css('.main-cart .total p', 'font-family', 'product_name_font', '', ', sans-serif');
            
            //buttons
            generate_css('button', 'font-family', 'button_font', '', ', sans-serif');
            generate_css('input[type="submit"]', 'font-family', 'button_font', '', ', sans-serif !important');
            generate_css('.button-1', 'font-family', 'button_font', '', ', sans-serif !important');
             
            //breadcrumbs
            generate_css('.main-navigation .title', 'font-family', 'breadcrumb_font', '', ', sans-serif');
            generate_css('.main-navigation .navigation', 'font-family', 'breadcrumb_font', '', ', sans-serif');
            
       
       /***** Colors *****/

            //selection color
            generate_css('::selection, ::-moz-selection, ::-webkit-selection', 'background-color', 'selection_color', '#');
            
            //regular text color
            generate_css('body', 'color', 'regular_text_color', '#');
            generate_css('.main-item .item-info .item-text', 'color', 'regular_text_color', '#');
            
            //regular_link_color
            generate_css('a', 'color', 'regular_link_color', '#');
            
            //menu_item_color
            generate_css('.main-menu ul li a', 'color', 'menu_item_color', '#');
            
            //footer_heading_color
            generate_css('.main-footer .navigation .main-title', 'color', 'footer_heading_color', '#');
            generate_css('.main-footer .twitter .main-title', 'color', 'footer_heading_color', '#');
            generate_css('.main-footer .newsletter .main-title', 'color', 'footer_heading_color', '#');
            generate_css('.main-footer .about-us .main-title', 'color', 'footer_heading_color', '#');
            
            //logo color
            generate_css('.main-header .logo', 'color', 'logo_color', '#');
            generate_css('.main-header .slogan', 'color', 'logo_color', '#');
            
            //primary_special_text_color
            generate_css('a:hover', 'color', 'primary_special_text_color', '#');
            generate_css('blockquote', 'color', 'primary_special_text_color', '#');
            generate_css('.main-login .input-error-wrapper span', 'color', 'primary_special_text_color', '#');
            generate_css('button', 'background-color', 'primary_special_text_color', '#');
            generate_css('.title-details a:hover', 'color', 'primary_special_text_color', '#');
            generate_css('.more-link', 'color', 'primary_special_text_color', '#');
            generate_css('.main-header .login .password', 'color', 'primary_special_text_color', '#');
            generate_css('.pages a, .pages .page-numbers', 'color', 'primary_special_text_color', '#');
            
            generate_css('.pages .current', 'background-color', 'primary_special_text_color', '#');
            generate_css('.pages .current:hover', 'background-color', 'primary_special_text_color', '#');
            generate_css('.main-slider nav a', 'color', 'primary_special_text_color', '#');
            
            $default = plsh_gs('primary_special_text_color'); 
            $mod = get_theme_mod('primary_special_text_color', $default);            
            if ( ! empty( $mod ) ) 
            {
                $mod = str_replace('#', '', $mod);
                $mod = '#' . $mod;
                echo '.main-slider nav a { box-shadow: ' . $mod . ' 0 3px 0 inset, ' . $mod . ' 0 -3px 0 inset, ' . $mod . ' 3px 0 0 inset, ' . $mod . ' -3px 0 0 inset; }';
                echo '.quick-shop .close { box-shadow: ' . $mod . ' 0 3px 0 inset, ' . $mod . ' 0 -3px 0 inset, ' . $mod . ' 3px 0 0 inset, ' . $mod . ' -3px 0 0 inset; }';
            }
            
            generate_css('.main-slider nav a:hover', 'background-color', 'primary_special_text_color', '#');
            generate_css('.main-slider nav .active', 'background-color', 'primary_special_text_color', '#');
            generate_css('.main-slider .title .headline', 'background-color', 'primary_special_text_color', '#');
            generate_css('.main-slider .title .intro', 'background-color', 'primary_special_text_color', '#');
            generate_css('.quick-shop .close', 'background-color', 'primary_special_text_color', '#');
            generate_css('.welcome-message-1 h2', 'color', 'primary_special_text_color', '#');
            generate_css('.featured-items .item-block-1 .price', 'color', 'primary_special_text_color', '#');
            generate_css('.homepage-columns .blog h2 a', 'color', 'primary_special_text_color', '#');
            generate_css('.homepage-columns .best-sellers .price', 'color', 'primary_special_text_color', '#');
            generate_css('.blog-list article .title a', 'color', 'primary_special_text_color', '#');
            generate_css('.post article .title a', 'color', 'primary_special_text_color', '#');  
            generate_css('.post h1, .post h2, .post h3, .post h4, .post h5, .post h6', 'color', 'primary_special_text_color', '#');
            generate_css('.single-full-width h1, .single-full-width h2, .single-full-width h3, .single-full-width h4, .single-full-width h5, .single-full-width h6', 'color', 'primary_special_text_color', '#');
            generate_css('.post article .title a', 'color', 'primary_special_text_color', '#');
            //generate_css('.post li, .single-full-width li', 'color', 'primary_special_text_color', '#');
            generate_css('.comments .item .comment-reply-link', 'color', 'primary_special_text_color', '#');
            generate_css('.pages .nav-next a:hover, .pages .nav-previous a:hover', 'color', 'primary_special_text_color', '#');
            generate_css('.tags .active', 'color', 'primary_special_text_color', '#');
            generate_css('.main-sidebar .best-sellers .price', 'color', 'primary_special_text_color', '#');            
            generate_css('.recent-posts article .title a', 'color', 'primary_special_text_color', '#');
            generate_css('.catalog .sorting .tags .active', 'color', 'primary_special_text_color', '#');
            generate_css('.catalog .item-block-1 .price', 'color', 'primary_special_text_color', '#');
            generate_css('.quick-shop .close', 'color', 'primary_special_text_color', '#');
            generate_css('.grouped-prouducts .button', 'background-color', 'primary_special_text_color', '#');
            generate_css('.main-item .item-info .details .tags a', 'color', 'primary_special_text_color', '#');
            generate_css('.main-item .item-info .price', 'color', 'primary_special_text_color', '#');
            generate_css('.main-cart .product p a:hover', 'color', 'primary_special_text_color', '#');
            generate_css('.main-cart .price', 'color', 'primary_special_text_color', '#');
            generate_css('.main-cart .total p', 'color', 'primary_special_text_color', '#');
            generate_css('.order-wrapper .row a', 'color', 'primary_special_text_color', '#');
            generate_css('.order-wrapper .row .price', 'color', 'primary_special_text_color', '#');
            generate_css('.order-wrapper .row .total', 'color', 'primary_special_text_color', '#');
            generate_css('.order-wrapper .buttons span a', 'color', 'primary_special_text_color', '#');
            generate_css('.manage-addresses .edit a', 'color', 'primary_special_text_color', '#');
            generate_css('.shipping-address-history .content a', 'color', 'primary_special_text_color', '#');
            generate_css('.order-history a', 'color', 'primary_special_text_color', '#');
            generate_css('.main-login a', 'color', 'primary_special_text_color', '#');
            generate_css('.checkout-thankyou .headline', 'color', 'primary_special_text_color', '#');
            generate_css('.order-details .order-totals .value', 'color', 'primary_special_text_color', '#');
            generate_css('.edit-address input[type="submit"]', 'background-color', 'primary_special_text_color', '#');

            //woo
            generate_css('.woo-submit', 'color', 'primary_special_text_color', '#');
            generate_css('.product_list_widget li', 'color', 'primary_special_text_color', '#');
            generate_css('.checkout-item a', 'color', 'primary_special_text_color', '#');
            generate_css('.next-step b a', 'color', 'primary_special_text_color', '#');
            generate_css('.order-id a', 'color', 'primary_special_text_color', '#');
            
            generate_css('.main-item .item-info .stock', 'background-color', 'primary_special_text_color', '#');
            generate_css('body div.pp_woocommerce .pp_close', 'background-color', 'primary_special_text_color', '#');
            generate_css('#commentform #submit', 'background-color', 'primary_special_text_color', '#');
            generate_css('.add_review .button', 'background-color', 'primary_special_text_color', '#');
            generate_css('.main-cart .apply_coupon', 'background-color', 'primary_special_text_color', '#');
            generate_css('.main-cart .buttons input[type="submit"]', 'background-color', 'primary_special_text_color', '#');
            generate_css('.pandora-checkout .button-1', 'background-color', 'primary_special_text_color', '#');
            
            
            //secondary special text
            generate_css('button:hover', 'color', 'secondary_special_text_color', '#');
            generate_css('.main-footer a:hover', 'color', 'secondary_special_text_color', '#');
            generate_css('.main-footer .navigation', 'color', 'secondary_special_text_color', '#');
            generate_css('.main-footer .twitter a', 'color', 'secondary_special_text_color', '#');
            generate_css('.main-footer .twitter a:hover', 'color', 'secondary_special_text_color', '#');
            generate_css('.main-menu li:hover > a', 'color', 'secondary_special_text_color', '#');
            generate_css('.main-menu li > a:hover', 'color', 'secondary_special_text_color', '#');
            generate_css('.main-menu ul ul li:hover > a', 'color', 'secondary_special_text_color', '#');
            generate_css('.main-menu ul ul ul li:hover > a', 'color', 'secondary_special_text_color', '#');
            generate_css('.main-slider .title a:hover', 'color', 'secondary_special_text_color', '#');
            generate_css('.grouped-prouducts .button:hover', 'color', 'secondary_special_text_color', '#');
            generate_css('.edit-address input[type="submit"]:hover', 'color', 'secondary_special_text_color', '#');
            generate_css('.pandora-checkout .button-1:hover', 'color', 'secondary_special_text_color', '#');

            //woo
            generate_css('.woo-submit:hover', 'color', 'secondary_special_text_color', '#');
            generate_css('#commentform #submit:hover', 'color', 'secondary_special_text_color', '#');
            generate_css('.add_review .button:hover', 'color', 'secondary_special_text_color', '#');
            generate_css('.main-cart .apply_coupon:hover ', 'color', 'secondary_special_text_color', '#');
            generate_css('.main-cart .buttons input[type="submit"]:hover', 'color', 'secondary_special_text_color', '#');
            
            
            //overlay
            generate_css('.item-block-1 .overlay', 'background-color', 'image_overlay_color', '#');
                      
            /***** background *****/
            
            $default = plsh_gs('background_image'); 
            $mod = get_theme_mod('background_image', $default);
            if ( ! empty( $mod ) ) 
            {
                generate_css('body', 'background-image', 'background_image', 'url(', ')' );
                generate_css('.quick-shop .content', 'background-image', 'background_image', 'url(', ')' );
            }
            else
            {
                echo 'body { background-image: none; }' . "\n";
                echo '.quick-shop .content { background-image: none; }' . "\n";
            }
            
            generate_css('body', 'background-color', 'background_color', '#' );
            generate_css('.quick-shop .content', 'background-color', 'background_color', '#' );
            
            generate_css('body', 'background-repeat', 'background_repeat' );
            generate_css('.quick-shop .content', 'background-repeat', 'background_repeat' );
            
            //main body mask
            $default = plsh_gs('show_backround_overlay'); 
            $mod = get_theme_mod('show_backround_overlay', $default);
            if ( ! empty( $mod ) ) 
            {
                generate_css('.main-body-color-mask', 'background-color', 'background_overlay', '#' );
            }
            
            //footer background
            $default = plsh_gs('footer_background'); 
            $mod = get_theme_mod('footer_background', $default);
            if ( ! empty( $mod ) ) 
            {
                generate_css('.main-footer-wrapper', 'background-color', 'footer_background', '#');
            }
            
            
            //wpcf7
            generate_css('div.wpcf7 input[type=submit]', 'color', 'primary_special_text_color', '#');
            generate_css('div.wpcf7-mail-sent-ok', 'border', 'primary_special_text_color', '2px solid #');
            
            
            //wp default widgets
            generate_css('#calendar_wrap caption', 'color', 'primary_special_text_color', '#');
            generate_css('.widget_rss li a', 'color', 'primary_special_text_color', '#');
            generate_css('.sidebar-item li a', 'color', 'primary_special_text_color', '#');
            generate_css('.sticky .title a ', 'background-color', 'primary_special_text_color', '#');
            
       ?>
   </style> 
   <!--/Customizer CSS
   
   <!-- User CSS -->
   <style type="text/css">
       <?php echo stripslashes(plsh_gs('custom_css')); ?>
   </style>
   <!--/User CSS  -->
   
   <!-- User JS -->
   <script type="text/javascript">
       <?php echo stripslashes(plsh_gs('custom_js')); ?>
   </script>
   <!--/User JS -->
   
   
   <!-- Javascript settings -->
   <script type="text/javascript">
        var plsh_settings = new Object();
      
        //slider settings
        plsh_settings['enable_slider_auto_advance'] = '<?php echo plsh_gs('enable_slider_auto_advance'); ?>';
        plsh_settings['slider_advance_delay'] = '<?php echo plsh_gs('slider_advance_delay'); ?>';
        plsh_settings['slider_animation'] = '<?php echo plsh_gs('slider_animation'); ?>';
        plsh_settings['slider_animation_speed'] = '<?php echo plsh_gs('slider_animation_speed'); ?>';
        plsh_settings['enable_product_image_zoom'] = '<?php echo plsh_gs('enable_product_image_zoom'); ?>';
   </script>
   <!-- Javascript settings -->
   
   <?php
}

/* ASSETS */

function plsh_add_image_sizes()
{    
    $image_sizes = plsh_gs('image_sizes');
    foreach($image_sizes as $key => $size)
    {
        add_image_size($key, $size[0], $size[1], $size[2]);
    }
}

function plsh_add_stylesheets() 
{
    wp_enqueue_style( 'main-stylesheet', PLSH_CSS_URL . 'main-stylesheet.css' );
    wp_enqueue_style( 'wp-default', PLSH_CSS_URL . 'wp-default.css' );
    if(plsh_is_shop_installed() && is_checkout())
    {
        wp_enqueue_style( 'checkout', PLSH_CSS_URL . 'checkout.css' );
    }
    wp_enqueue_style( 'woocommerce-overwrites', PLSH_CSS_URL . 'woocommerce.css' );
    wp_enqueue_style( 'style', get_bloginfo( 'stylesheet_url' ) ); 

    //add font stylesheets
    $fonts = plsh_gs('fonts');
    $custom_fonts = plsh_gs('custom_fonts');
    if(!empty($fonts) && !empty($custom_fonts))
    {
        foreach($custom_fonts as $cf)
        {
            $default = plsh_gs($cf);
            $font = get_theme_mod($cf, $default);
            if(!empty($font))
            {
                wp_enqueue_style( $font, 'http://fonts.googleapis.com/css?family=' . $fonts[$font]['url'] );
            }
        }
    }
    
    wp_enqueue_style( 'jcarousel', PLSH_CSS_URL . 'jcarousel.css' );
}

function plsh_print_scripts_in_footer( &$scripts) 
{
	if ( ! is_admin() )
    {
        $scripts->add_data( 'comment-reply', 'group', 1 );
    }
}

function plsh_add_scripts() 
{
    $protocol = ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";

    //wp_enqueue_script( $handle, $src = false, $deps = array(), $ver = false, $in_footer = false )
    wp_enqueue_script( 'jquery');
    wp_enqueue_script( 'twitterfeed', $protocol . 'widgets.twimg.com/j/2/widget.js', array(), false, true);
    wp_enqueue_script( 'placeholder', PLSH_JS_URL . 'jquery.placeholder.min.js', array( 'jquery' ), false, true);
	wp_enqueue_script( 'uniform', PLSH_JS_URL . 'jquery.uniform.js', array( 'jquery' ), false, true);
	wp_enqueue_script( 'html5shiv', PLSH_JS_URL . 'html5shiv.js', array(), false, true);
	wp_enqueue_script( 'cycle', PLSH_JS_URL . 'jquery.cycle.all.js', array( 'jquery' ), false, true);
	wp_enqueue_script( 'easing', PLSH_JS_URL . 'jquery.easing.1.3.js', array( 'jquery' ), false, true);
    wp_enqueue_script( 'jcarousel', PLSH_JS_URL . 'jquery.jcarousel.min.js', array( 'jquery' ), false, true);	
	wp_enqueue_script( 'touchwipe', PLSH_JS_URL . 'jquery.touchwipe.js', array( 'jquery' ), false, true);
    wp_enqueue_script( 'zoom', PLSH_JS_URL . 'jquery.zoom.js', array( 'jquery' ), false, true);
    
	wp_enqueue_script( 'theme', PLSH_JS_URL . 'theme.js', array( 'jquery', 'uniform', 'placeholder', 'touchwipe', 'cycle', 'easing' ), false, true);
    
    wp_localize_script( 'theme', 'ajax_object', array( 'ajaxurl' => admin_url( 'admin-ajax.php' ) ) );
}

/* FILTERS */

function plsh_custom_excerpt_length( $length ) 
{
	return 25;
}

function plsh_custom_excerpt_more( $more )
{
	return '...';
}

function wpse_71157_parse_query( $wp_query )
{
    if ( $wp_query->is_post_type_archive && $wp_query->is_tax )
    {
        $wp_query->is_post_type_archive = false;
    }
}

/* OTHER FUNCTIONS */

function plsh_get_banners($group = NULL, $count = 3)
{
    if(!empty($group))
    {
        return plsh_get_posts_by_meta('banner_group_meta', $group, $count, 'banner');
    }
    else
    {
        return plsh_get_posts_by_type('banner', $count);
    }
}

function plsh_quickshop_callback()
{
    global $wpdb;
    ob_start();
    plsh_get_theme_template('quickshop');
    $data = ob_get_contents();
    ob_end_clean();
    die($data);
}

function plsh_add_sharethis()
{
    if((plsh_is_shop_installed() && !is_checkout()) || !plsh_is_shop_installed())
    {
        $protocol = ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') || $_SERVER['SERVER_PORT'] == 443) ? "https" : "http";
        if($protocol == 'https')
        {
            echo '<script type="text/javascript" src="https://ws.sharethis.com/button/buttons.js"></script>';
        }
        else
        {
            echo '<script type="text/javascript" src="http://w.sharethis.com/button/buttons.js"></script>';
        }
        echo '<script type="text/javascript">stLight.options({publisher: "' . plsh_gs('sharethis_publisher') . '" });</script>';
    }
}

function plsh_add_widgets()
{
    if(plsh_is_woocommerce_active())
    {
    
        require_once(PLSH_WIDGET_PATH . 'pandora-recent-posts-widget.php' );
        require_once(PLSH_WIDGET_PATH . 'pandora-product-list-widget.php' );
    
        register_widget( 'PandoraRecentPosts' );
        register_widget( 'PandoraProductList' );
    }
    
    require_once(PLSH_WIDGET_PATH . 'pandora-tweets-widget.php' );
    require_once(PLSH_WIDGET_PATH . 'pandora-newsletter-widget.php' );
    require_once(PLSH_WIDGET_PATH . 'pandora-shop-info-widget.php' );
    
    register_widget( 'PandoraTweets' );
    register_widget( 'PandoraNewsletter' );
    register_widget( 'PandoraShopInfo' );   
}



function plsh_shortcode_empty_paragraph_fix($content)
{   
    $array = array (
        '<p>[' => '[', 
        ']</p>' => ']', 
        ']<br />' => ']'
    );

    $content = strtr($content, $array);

    return $content;
}

function pandora_register_required_plugins()
{
    /**
	 * Array of plugin arrays. Required keys are name and slug.
	 * If the source is NOT from the .org repo, then source is also required.
	 */
	$plugins = array(

		// This is an example of how to include a plugin pre-packaged with a theme
		array(
			'name'     				=> 'Visual Composer', // The plugin name
			'slug'     				=> 'js_composer', // The plugin slug (typically the folder name)
			'source'   				=> PLSH_PLUGIN_PATH . 'js_composer.zip', // The plugin source
			'required' 				=> false, // If false, the plugin is only 'recommended' instead of required
			'version' 				=> '', // E.g. 1.0.0. If set, the active plugin must be this version or higher, otherwise a notice is presented
			'force_activation' 		=> false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
			'force_deactivation' 	=> false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
			'external_url' 			=> '', // If set, overrides default API URL and points to an external URL
		),
        array(
			'name'     				=> 'WooCommerce', // The plugin name
			'slug'     				=> 'woocommerce', // The plugin slug (typically the folder name)
			'required' 				=> false, // If false, the plugin is only 'recommended' instead of required
		),
        array(
			'name'     				=> 'Contact Form 7', // The plugin name
			'slug'     				=> 'contact-form-7', // The plugin slug (typically the folder name)
			'required' 				=> false, // If false, the plugin is only 'recommended' instead of required
		),
	);
    
	// Change this to your theme text domain, used for internationalising strings
	$theme_text_domain = PLSH_THEME_DOMAIN;

	/**
	 * Array of configuration settings. Amend each line as needed.
	 * If you want the default strings to be available under your own theme domain,
	 * leave the strings uncommented.
	 * Some of the strings are added into a sprintf, so see the comments at the
	 * end of each line for what each argument will be.
	 */
	$config = array(
		'domain'       		=> $theme_text_domain,         	// Text domain - likely want to be the same as your theme.
		'default_path' 		=> '',                         	// Default absolute path to pre-packaged plugins
		'parent_menu_slug' 	=> 'themes.php', 				// Default parent menu slug
		'parent_url_slug' 	=> 'themes.php', 				// Default parent URL slug
		'menu'         		=> 'install-required-plugins', 	// Menu slug
		'has_notices'      	=> true,                       	// Show admin notices or not
		'is_automatic'    	=> false,					   	// Automatically activate plugins after installation or not
		'message' 			=> '',							// Message to output right before the plugins table
		'strings'      		=> array(
			'page_title'                       			=> __( 'Install Required Plugins', $theme_text_domain ),
			'menu_title'                       			=> __( 'Install Plugins', $theme_text_domain ),
			'installing'                       			=> __( 'Installing Plugin: %s', $theme_text_domain ), // %1$s = plugin name
			'oops'                             			=> __( 'Something went wrong with the plugin API.', $theme_text_domain ),
			'notice_can_install_required'     			=> _n_noop( 'This theme requires the following plugin: %1$s.', 'This theme requires the following plugins: %1$s.' ), // %1$s = plugin name(s)
			'notice_can_install_recommended'			=> _n_noop( 'This theme recommends the following plugin: %1$s.', 'This theme recommends the following plugins: %1$s.' ), // %1$s = plugin name(s)
			'notice_cannot_install'  					=> _n_noop( 'Sorry, but you do not have the correct permissions to install the %s plugin. Contact the administrator of this site for help on getting the plugin installed.', 'Sorry, but you do not have the correct permissions to install the %s plugins. Contact the administrator of this site for help on getting the plugins installed.' ), // %1$s = plugin name(s)
			'notice_can_activate_required'    			=> _n_noop( 'The following required plugin is currently inactive: %1$s.', 'The following required plugins are currently inactive: %1$s.' ), // %1$s = plugin name(s)
			'notice_can_activate_recommended'			=> _n_noop( 'The following recommended plugin is currently inactive: %1$s.', 'The following recommended plugins are currently inactive: %1$s.' ), // %1$s = plugin name(s)
			'notice_cannot_activate' 					=> _n_noop( 'Sorry, but you do not have the correct permissions to activate the %s plugin. Contact the administrator of this site for help on getting the plugin activated.', 'Sorry, but you do not have the correct permissions to activate the %s plugins. Contact the administrator of this site for help on getting the plugins activated.' ), // %1$s = plugin name(s)
			'notice_ask_to_update' 						=> _n_noop( 'The following plugin needs to be updated to its latest version to ensure maximum compatibility with this theme: %1$s.', 'The following plugins need to be updated to their latest version to ensure maximum compatibility with this theme: %1$s.' ), // %1$s = plugin name(s)
			'notice_cannot_update' 						=> _n_noop( 'Sorry, but you do not have the correct permissions to update the %s plugin. Contact the administrator of this site for help on getting the plugin updated.', 'Sorry, but you do not have the correct permissions to update the %s plugins. Contact the administrator of this site for help on getting the plugins updated.' ), // %1$s = plugin name(s)
			'install_link' 					  			=> _n_noop( 'Begin installing plugin', 'Begin installing plugins' ),
			'activate_link' 				  			=> _n_noop( 'Activate installed plugin', 'Activate installed plugins' ),
			'return'                           			=> __( 'Return to Required Plugins Installer', $theme_text_domain ),
			'plugin_activated'                 			=> __( 'Plugin activated successfully.', $theme_text_domain ),
			'complete' 									=> __( 'All plugins installed and activated successfully. %s', $theme_text_domain ), // %1$s = dashboard link
			'nag_type'									=> 'updated' // Determines admin notice type - can only be 'updated' or 'error'
		)
	);

	tgmpa( $plugins, $config );
}

function language_selector_flags(){
    if(function_exists('icl_get_languages'))
    {
        $languages = icl_get_languages('skip_missing=0&orderby=code');
        if(!empty($languages)){
            foreach($languages as $l){
                if(!$l['active']) echo '<a href="'.$l['url'].'">';
                echo '<img src="'.$l['country_flag_url'].'" height="12" alt="'.$l['language_code'].'" width="18" />';
                if(!$l['active']) echo '</a>';
            }
        }
    }
}

/**
 * Force Visual Composer to initialize as "built into the theme". This will hide certain tabs under the Settings->Visual Composer page
 */
if(function_exists('vc_set_as_theme')) { vc_set_as_theme(); }

?>