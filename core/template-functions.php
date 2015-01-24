<?php
/*************** TEMPLATES ***************/

function plsh_get_theme_template($name)
{
    if(PLSH_IS_CHILD)
    {
        $path = PLSH_CHILD_TEMPLATE_PATH . $name . '.php';
        if(file_exists($path))
        {
            include($path);
            return;
        }
    }

    $path = PLSH_TEMPLATE_PATH . $name . '.php';    
    
	if(file_exists($path))
	{
		include($path);
	}
	else
	{
        if(is_single())	//TODO - is internal?!
		{
			$template = 'loop-default-single';
		}
		else
		{
            $template = 'loop-default-list-item';
		}
        
        include(PLSH_TEMPLATE_PATH . $template . '.php' );
        //trigger_error(_e('Template: "' . $name . '" not found', PLSH_THEME_DOMAIN));
	}
}


/*************** Thumbnails ***************/


function plsh_get_thumbnail( $size, $return_url = false, $placeholder = true ) {
    global $post;
    $image_sizes = plsh_gs('image_sizes');
    
    if(!empty($image_sizes[$size]))
    {       
        if ( has_post_thumbnail() )
        {
            if($return_url)
            {
                $src_parts = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), $size);
                return $src_parts[0];
            }
            else
            {
                $src_parts = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), $size);
                return '<img src="' . $src_parts[0] . '" alt=""/>';
                //return get_the_post_thumbnail($post->ID, $size);
            }
        }
        else
        {
            if($placeholder)
            {
                if($return_url)
                {
                    return PLSH_IMG_URL . 'no-image.jpg';
                }
                else
                {
                    return '<img src="'. PLSH_IMG_URL .'no-image.gif" alt="Placeholder" width="' . $image_sizes[$size][0] . '" height="' . $image_sizes[$size][1] . '" />';
                }
            }
            else
            {
                return false;
            }
        }
    }
}


/*************** MENU ***************/

function plsh_cache_menu_item_children()
{
	//cache menu items with children in global array declared in init
	global $menu_item_hierarchy;
	global $wpdb;
	$data = $wpdb->get_results("SELECT COUNT(meta_id) as count, meta_value as parent_id FROM " . $wpdb->prefix . "postmeta WHERE meta_key='_menu_item_menu_item_parent' GROUP BY meta_value", 'ARRAY_A');
	
	foreach($data as $item)
	{
		$menu_item_hierarchy[$item['parent_id']] = $item['count'];
	}
	
	return $menu_item_hierarchy;
}

function plsh_check_for_submenu($classes, $item) {
	 // assign the class has-class to list items with sub menu.
 	global $menu_item_hierarchy;
 	
 	if(empty($menu_item_hierarchy))
    {
    	$menu_item_hierarchy = plsh_cache_menu_item_children();
    }
	if(plsh_get($menu_item_hierarchy, $item->ID) > 0)
	{
		array_push($classes,'has-children');
	}
    
    return $classes;
}

/*************** PAGINATION ***************/

function plsh_pagination_exists()
{
	global $wp_query;
	if ( $wp_query->max_num_pages > 1 )  return true;	
	return false;
}

function plsh_get_pagination()
{
	$total = plsh_get_max_pages();
	
	if ( $total > 1 )  
	{
		$current_page = plsh_get_current_page_num();  		
		
        $base = get_pagenum_link(1);
        $append = '';
		$permalinks_set =  get_option('permalink_structure'); // structure of "format" depends on whether we're using pretty permalinks
		if(empty( $permalinks_set )) 
		{
			$format = '&paged=%#%';
		}
		else
		{
			$format =  'page/%#%/';
                        
            if(strpos($base, '?') !== false)
            {
                $pos = strpos($base, '?');
                $append = substr($base, $pos);
                $base = substr($base, 0, $pos);
            }
		}
		

                
		return paginate_links(array(
		  'base' => $base . '%_%' . $append,
		  'format' => $format,
		  'current' => $current_page,
		  'total' => $total,
		  'mid_size' => 4,
		  'type' => 'array',
		  'prev_next' => false,
		));	
	}
	
	return array();
}

function plsh_get_max_pages()
{
	global $wp_query;
	return $wp_query->max_num_pages;
}

function plsh_get_current_page_num()
{
	return max(1, get_query_var('paged'));
}

function plsh_get_next_page_link()
{
	$max = plsh_get_max_pages();
	$current = plsh_get_current_page_num();
	
	if($max > $current) { $page_num = $current + 1; }
	else { $page_num = $max; }
	
	return get_pagenum_link($page_num);
}

function plsh_get_prev_page_link()
{
	$current = plsh_get_current_page_num();
	
	if( $current > 1) { $page_num = $current - 1; }
	else { $page_num = $current; }
	
	return get_pagenum_link($page_num);
}

/*************** Breadcrumbs ***************/


function plsh_breadcrumbs() {  
	$delimiter = '';
	$home = 'Home'; // text for the 'Home' link
	$blog = 'Blog';
	$before = '<a href="#">'; // tag before the current crumb
	$after = '</a>'; // tag after the current crumb
   
	global $post;
	$homeLink = home_url();
	echo '<a href="' . $homeLink . '">' . $home . '</a> ' . $delimiter . ' ';
	
	if ( get_post_type() == 'post' ) {
		if( get_option( 'show_on_front' ) == 'page' )
		{ 
			$posts_page_url = get_permalink( get_option('page_for_posts' ) );
		}
		else
		{
			$posts_page_url = home_url();
		}
		echo '<a href="' . $posts_page_url . '">' . $blog . '</a> ' . $delimiter . ' ';
	}
	
	if ( is_category() ) {
	  global $wp_query;
	  $cat_obj = $wp_query->get_queried_object();
	  $thisCat = $cat_obj->term_id;
	  $thisCat = get_category($thisCat);
	  $parentCat = get_category($thisCat->parent);
	  if ($thisCat->parent != 0) echo(get_category_parents($parentCat, TRUE, ' ' . $delimiter . ' '));
	  echo $before . 'Archive by category "' . single_cat_title('', false) . '"' . $after;
	
	} elseif ( is_day() ) {
	  echo '<a href="' . get_year_link(get_the_time('Y')) . '">' . get_the_time('Y') . '</a> ' . $delimiter . ' ';
	  echo '<a href="' . get_month_link(get_the_time('Y'),get_the_time('m')) . '">' . get_the_time('F') . '</a> ' . $delimiter . ' ';
	  echo $before . get_the_time('d') . $after;
	
	} elseif ( is_month() ) {
	  echo '<a href="' . get_year_link(get_the_time('Y')) . '">' . get_the_time('Y') . '</a> ' . $delimiter . ' ';
	  echo $before . get_the_time('F') . $after;
	
	} elseif ( is_year() ) {
	  echo $before . get_the_time('Y') . $after;
	
	} elseif ( is_single() && !is_attachment() ) {
	  if ( get_post_type() != 'post' ) {
	    $post_type = get_post_type_object(get_post_type());
	    $slug = $post_type->rewrite;
	    echo '<a href="' . $homeLink . '/' . $slug['slug'] . '/">' . $post_type->labels->singular_name . '</a> ' . $delimiter . ' ';
	    //echo $before . get_the_title() . $after;
	  } else {
	    $cat = get_the_category(); $cat = $cat[0];
	    echo get_category_parents($cat, TRUE, ' ' . $delimiter . ' ');
	    //echo $before . get_the_title() . $after;
	  }
	
	} elseif ( !is_single() && !is_page() && get_post_type() != 'post' ) {
	  $post_type = get_post_type_object(get_post_type());
      if(!empty($post_type))
      {
        echo $before . $post_type->labels->singular_name . $after;
      }
	} elseif ( is_attachment() ) {
	  $parent = get_post($post->post_parent);
	  $cat = get_the_category($parent->ID); $cat = $cat[0];
	  echo get_category_parents($cat, TRUE, ' ' . $delimiter . ' ');
	  echo '<a href="' . get_permalink($parent) . '">' . $parent->post_title . '</a> ' . $delimiter . ' ';
	  echo $before . get_the_title() . $after;
	
	} elseif ( is_page() && !$post->post_parent ) {
	  //echo $before . get_the_title() . $after;
	
	} elseif ( is_page() && $post->post_parent ) {
	  $parent_id  = $post->post_parent;
	  $breadcrumbs = array();
	  while ($parent_id) {
	    $page = get_page($parent_id);
	    $breadcrumbs[] = '<a href="' . get_permalink($page->ID) . '">' . get_the_title($page->ID) . '</a>';
	    $parent_id  = $page->post_parent;
	  }
	  $breadcrumbs = array_reverse($breadcrumbs);
	  foreach ($breadcrumbs as $crumb) echo $crumb . ' ' . $delimiter . ' ';
	  echo $before . get_the_title() . $after;
	
	} elseif ( is_search() ) {
	  echo $before . 'Search results for "' . get_search_query() . '"' . $after;
	
	} elseif ( is_tag() ) {
	  echo $before . 'Posts tagged "' . single_tag_title('', false) . '"' . $after;
	
	} elseif ( is_author() ) {
	   global $author;
	  $userdata = get_userdata($author);
	  echo $before . 'Articles posted by ' . $userdata->display_name . $after;
	
	} elseif ( is_404() ) {
	  echo $before . 'Error 404' . $after;
	}
	
	if ( get_query_var('paged') ) {
	  if ( is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author() ) echo ' (';
	  echo __('Page', PLSH_THEME_DOMAIN) . ' ' . get_query_var('paged');
	  if ( is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author() ) echo ')';
	}  
}

function plsh_output_taxonomy_hierarchy_option_tree($data, $taxonomy, $level = 0)
{
    $padding = '';
    for($i = 0; $i < $level; $i++)
    {
        $padding .= '&emsp;';
    }
    
    foreach($data as $item)
    {
        echo '<option value="' . $item->slug . '"';
        if(plsh_get($_GET, $taxonomy) == $item->slug) echo 'selected="selected"';
        echo '>' . $padding . $item->name . '</option>';
        if(!empty($item->children))
        {
            plsh_output_taxonomy_hierarchy_option_tree($item->children, $taxonomy, ++$level);
        }
    }
}

function plsh_get_sidebar_page_type() 
{
    $page = NULL;
    
    if( is_home() ) {
        $page = 'blog';
    } elseif( is_single() && get_post_type() == 'post' ) {
        $page = 'single_post';
    } elseif( is_category() ) {
        $page = 'categories';
    } elseif( is_search() ) {
        $page = 'search';
    } elseif( is_archive() ) {
        $page = 'archives';
    } elseif( is_page() ) {
        $page = 'page';
    }

    return $page;
}

function plsh_comments($comment, $args, $depth)
{
    global $comment_iterator_count;
    if(empty($comment_iterator_count))
    {
        $comment_iterator_count = 1;
    }
    else
    {
        $comment_iterator_count++;
    }
    
    if($comment->comment_type == '') //normal comment
    {
        ?>
        <li class="item clearfix" id="comment-<?php comment_ID(); ?>">
            <div class="comment-gravatar"><?php echo get_avatar( $GLOBALS['comment'], $size='60' ); ?></div>
            <div class="comment-text">
                <p class="name">
                    <a href="<?php comment_author_url(); ?>"><?php comment_author(); ?></a>
                    <?php
                        echo '<span class="nr">#' . $comment_iterator_count . '</span>';
                    ?>
                </p>
                <div class="title-details">
                    <a href="#" class="time"><?php comment_date(); ?></a>
                </div>
                <?php comment_text(); ?>
                <p>
                    <?php comment_reply_link( array_merge( $args, array( 'depth' => $depth,) ) ); ?>
                </p>
            </div>
        
        <?php
    }   
}

function plsh_output_theme_version()
{
    $theme = 'Planetshine - ' . plsh_gs('theme_name') . ' - ' . plsh_gs('theme_version');
    echo '<meta name="generator" content="' . $theme . '">';
}