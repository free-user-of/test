<?php

function plsh_gs($param = NULL)	//get setting
{
	global $_SETTINGS;
	if($param === NULL) return $_SETTINGS->active;
	if(!empty($_SETTINGS->active[$param])) return $_SETTINGS->active[$param];
	if(!empty($_SETTINGS->$param)) return $_SETTINGS->$param;
	return false;
}

function plsh_ss($name, $value) //save setting
{
	global $_SETTINGS;
	$_SETTINGS->update_single($name, $value);
}

function plsh_get_settings_admin_head()
{
	global $_SETTINGS;
	return $_SETTINGS->admin_head;
}

function plsh_get_settings_admin_body()
{
	global $_SETTINGS;
	return $_SETTINGS->admin_body;
}

function debug($variable, $die=true)
{
    if ((is_scalar($variable)) || (is_null($variable)))
    {
    	if (is_null($variable))
    	{
    	    $output = '<i>NULL</i>';
    	}
    	elseif (is_bool($variable))
        {
            $output = '<i>' . (($variable) ? 'TRUE' : 'FALSE') . '</i>';
        }
        else 
        {
            $output = $variable;
        }
        echo '<pre>variable: ' . $output . '</pre>';
    }
    else // non-scalar
    {
		echo '<pre>';
		print_r($variable);
		echo '</pre>';
    }

	if ($die)
	{
        die();
	}
}

function plsh_dbSE($value)
{
    global $wpdb;
    return $wpdb->_real_escape($value);
}

function plsh_file_get_contents_curl($url) 
{
    $ch = curl_init();

    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_URL, $url);

    $data = curl_exec($ch);
    curl_close($ch);

    return $data;
}

function plsh_get( $array, $key, $default = NULL )
{
	if(is_array($array))
	{
		if( !empty( $array[$key] ) )
		{
			return $array[$key];
		}
	}
	return $default;
}

function plsh_current_page_url() 
{
	$pageURL = 'http';
	
	if (plsh_get($_SERVER, "HTTPS") == "on") {$pageURL .= "s";}
	
	$pageURL .= "://";
	
	if ($_SERVER["SERVER_PORT"] != "80") 
	{
		$pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
	} 
	else
	{
		$pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
	}
    
    
	return $pageURL;
}

function plsh_assamble_url($pageURL = false, $add_params = array(), $remove_params = array())
{
    if(!$pageURL)
    {
        $pageURL = plsh_current_page_url();
    }
    
    if(!empty($remove_params))
    {
        foreach($remove_params as $remove)
        if(strpos($pageURL, $remove) !== false)
        {
            $parts = explode('?', $pageURL);
            if(count($parts) > 1)
            {
                $query_parts = explode('&', $parts[1]);
                foreach($query_parts as $key => $value)
                {
                    if(strpos($value, $remove) !== false)
                    {
                        unset($query_parts[$key]);
                    }
                }
                if(!empty($query_parts))
                {    
                    $parts[1] = implode('&', $query_parts);
                }
                else
                {
                    unset($parts[1]);
                }
            }
            
            $pageURL = implode('?', $parts);
        }
    }
    
    if(!empty($add_params))
    {
        foreach($add_params as $add)
        {        
            if(strpos($pageURL, '?') !== false)
            {
                $pageURL .= '&' . $add;
            }
            else
            {
                $pageURL .= '?' . $add;
            }
        }
    }
    
    return $pageURL;
        
}

function plsh_get_post_id_from_slug( $slug, $post_type = 'post' ) 
{
    global $wpdb;
    
    $id = $wpdb->get_var( "SELECT ID FROM $wpdb->posts WHERE post_name = '$slug' AND post_type = '$post_type'" );  
    if ( ! empty( $id ) ) {
        return $id;
    } else {
        return 0;
    }
}

function plsh_get_post_slug_from_id( $post_id ) 
{
    $post = get_post( $post_id );
    if ( isset( $post->post_name ) ) {
        return $post->post_name;
    } else {
        return null;
    }
}

function plsh_add_auto_pages() 
{
	$default_pages = plsh_gs('auto_pages');
    $pages = get_option('plsh_auto_pages', json_encode($default_pages));
    $pages = json_decode($pages, true);
    
	foreach($pages as &$page)
	{
		if(empty($page['id']) || get_post($page['id']) == NULL) //if page is not created of has been deleted
		{
            $page['id'] = plsh_create_page($page);
			
			//set up frontpage & blog page
			if($page['role'] == 'front_page')
			{
				update_option( 'page_on_front', $page['id'] );
				update_option( 'show_on_front', 'page' );
			}
			if($page['role'] == 'posts')
			{
				update_option( 'page_for_posts', $page['id'] );
			}
		}
	}
    
	update_option('plsh_auto_pages', json_encode($pages));
}

function plsh_create_page($page) 
{
	$page_data = array(
        'post_status' 		=> 'publish',
        'post_type' 		=> 'page',
        'post_author' 		=> 1,
        'post_name' 		=> esc_sql( $page['slug'] ),
        'post_title' 		=> $page['name'],
        'post_content' 		=> $page['content'],
        'post_parent' 		=> 0,
        'comment_status' 	=> 'closed'
    );
    
    $page_id = wp_insert_post( $page_data );
    if($page['role'] == 'front_page')
    {
        update_post_meta( $page_id, '_wp_page_template', 'page-home.php' );
    }
	return $page_id;
}

function plsh_is_shop_installed() 
{
    require_once(ABSPATH . 'wp-admin/includes/plugin.php');
    $woocommerce = 'woocommerce/woocommerce.php';
    if( is_plugin_active( $woocommerce ) ) 
    {
        return true;
    }
    else
    {
        return false;
    }
}

function plsh_is_woocommerce_active()
{
    if ( plsh_is_shop_installed())
    {
        return true;
    }
    return false;
}

function plsh_dump_included_files()
{
    $included_files = get_included_files();
    $stylesheet_dir = str_replace( '\\', '/', get_stylesheet_directory() );
    $template_dir   = str_replace( '\\', '/', get_template_directory() );

    foreach ( $included_files as $key => $path ) {

        $path   = str_replace( '\\', '/', $path );

        if ( false === strpos( $path, $stylesheet_dir ) && false === strpos( $path, $template_dir ) )
            unset( $included_files[$key] );
    }

    debug( $included_files );
}

function plsh_get_posts_by_type($post_type = 'post', $count = 8)
{
    global $wpdb;
    
    $querydetails = "
        SELECT wposts.*
        FROM $wpdb->posts wposts
        WHERE
        wposts.post_status = 'publish'
        AND wposts.post_type = '" . plsh_dbSE($post_type) . "'
        ORDER BY wposts.post_date DESC
        LIMIT 0, $count
    ";
    return $wpdb->get_results($querydetails, OBJECT);
}

function plsh_get_posts_by_meta($key, $value, $count, $post_type = 'post')
{
    global $wpdb;
    
    $querydetails = "
        SELECT wposts.*
        FROM $wpdb->posts wposts, $wpdb->postmeta wpostmeta
        WHERE wposts.ID = wpostmeta.post_id
        AND wpostmeta.meta_key = '" . plsh_dbSE($key) . "'
        AND wpostmeta.meta_value = '" . plsh_dbSE($value) . "'
        AND wposts.post_status = 'publish'
        AND wposts.post_type = '" . plsh_dbSE($post_type) . "'
        ORDER BY wposts.post_date DESC
        LIMIT 0, $count
    ";
    return $wpdb->get_results($querydetails, OBJECT);
}

function plsh_get_post_collection($params = array(), $count = NULL, $orderby = 'date', $dir = 'DESC')
{
    $args = array();
    if(!empty($params))
    {
        foreach($params as $key => $value)
        {
            if($value != NULL) $args[$key] = $value;
        }
    }
    
    $args['orderby'] = $orderby;
    $args['order'] = $dir;
    $args['post_status'] = 'publish';
    if($count) $args['posts_per_page'] = $count;
    
    $posts = new WP_Query( $args);
    return $posts->posts;
}

function plsh_get_taxonomy_hierarchy($taxonomy, $parent_id = 0)
{
    $args = array(
        'type'                     => 'post',
        'parent'                   => $parent_id,
        'orderby'                  => 'name',
        'order'                    => 'ASC',
        'hide_empty'               => 1,
        //'hierarchical'             => 1,
        'taxonomy'                 => $taxonomy,
        'pad_counts'               => false 
    );
    $categories = get_categories( $args );
    
    foreach($categories as $key => $value)
    {
        $categories[$key]->children = plsh_get_taxonomy_hierarchy($taxonomy, $value->term_id);
    }
    
    return $categories;
}

function generate_css( $selector, $style, $mod_name, $prefix='', $postfix='', $echo=true ) {
      $return = '';
      $default = plsh_gs($mod_name);
      $mod = get_theme_mod($mod_name, $default);
      if ( ! empty( $mod ) ) {
         $mod = str_replace('#', '', $mod);
         $mod = str_replace('+', ' ', $mod);
         $return = sprintf('%s { %s:%s; }',
            $selector,
            $style,
            $prefix.$mod.$postfix
         );
         if ( $echo ) {
            echo $return . "\n";
         }
      }
      return $return;
    }

?>