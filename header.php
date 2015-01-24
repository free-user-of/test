<!DOCTYPE html>

<!-- BEGIN html -->
<!--[if IE 6]>
<html id="ie6" <?php language_attributes(); ?>>
<![endif]-->
<!--[if IE 7]>
<html id="ie7" <?php language_attributes(); ?>>
<![endif]-->
<!--[if IE 8]>
<html id="ie8" <?php language_attributes(); ?>>
<![endif]-->
<!--[if !(IE 6) | !(IE 7) | !(IE 8)  ]><!-->
<html <?php language_attributes(); ?>>
	
	<!-- BEGIN head -->
	<head>
		
		<!-- Title -->
		<title><?php
			/*
			 * Print the <title> tag based on what is being viewed.
			 */
			global $page, $paged;
		
			wp_title( '|', true, 'right' );
		
			// Add the blog name.
			bloginfo( 'name' );
		
			// Add the blog description for the home/front page.
			$site_description = get_bloginfo( 'description', 'display' );
			if ( $site_description && ( is_home() || is_front_page() ) )
				echo " | $site_description";
		
			// Add a page number if necessary:
			if ( $paged >= 2 || $page >= 2 )
				echo ' | ' . sprintf( __( 'Page %s', PLSH_THEME_DOMAIN ), max( $paged, $page ) );
		
		?></title>
        
        <!-- Meta tags -->
		<meta http-equiv="content-type" content="text/html; charset=utf-8" />
		<meta name="viewport" content="width=100%, initial-scale=1, minimum-scale=1" />
        
		<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
        <?php if(plsh_gs('favicon')) : ?>
        <link rel="shortcut icon" href="<?php echo plsh_gs('favicon'); ?>" />
        <?php endif; ?>
		<?php
			if ( is_singular() && get_option( 'thread_comments' ) )
            {
                wp_enqueue_script( 'comment-reply' );
            }
		
			wp_head();
		?>
	</head>
    <?php 
    $body_class = 'top';
    if(plsh_is_shop_installed() && is_checkout())
    {
        $body_class .= ' pandora-checkout';
    }
    ?>
	<body <?php body_class($body_class); ?>>
		<?php plsh_get_theme_template('header'); ?>