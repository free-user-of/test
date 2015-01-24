<?php 
    global $woocommerce;
?>
    <div class="main-body-color-mask"></div>

    <!-- BEGIN .main-body-wrapper -->
    <div class="main-body-wrapper">

        <!-- BEGIN .main-header -->
        <header class="main-header clearfix">
            <div class="row clearfix">
                <?php if(plsh_gs('use_image_logo') != 'on') { ?>
                    <a href="<?php echo home_url('/'); ?>" class="logo"><?php bloginfo('name'); ?></a>
                <?php } else { ?>
                    <a href="<?php echo home_url('/'); ?>" class="logo"><img src="<?php echo plsh_gs('logo_image'); ?>" alt="<?php plsh_gs('logo_image_alt'); ?>"/></a>
                <?php } ?>
                <span class="slogan"><?php bloginfo('description'); ?></span>
                                    
                <?php if(plsh_is_woocommerce_active()) : ?>
                <div class="menu<?php if(is_user_logged_in()) { echo ' wide'; } ?>">                    
                    <a href="<?php echo $woocommerce->cart->get_cart_url(); ?>" class="cart"><?php echo $woocommerce->cart->cart_contents_count ?> <?php _e('items', PLSH_THEME_DOMAIN); ?> (<?php echo $woocommerce->cart->get_cart_total(); ?> <?php _e('in total', PLSH_THEME_DOMAIN); ?>)</a>
                    <a href="<?php echo $woocommerce->cart->get_checkout_url(); ?>" class="checkout"><?php _e('Checkout', PLSH_THEME_DOMAIN); ?></a>
                    <?php if(is_user_logged_in())
                    {
                        ?> 
                            <a href="<?php echo wp_logout_url(plsh_current_page_url()); ?>"><?php _e('Logout?', PLSH_THEME_DOMAIN); ?></a>
                            <a href="<?php echo get_permalink( get_option('woocommerce_myaccount_page_id') ); ?>" class="account _logged-in"><?php _e('My account', PLSH_THEME_DOMAIN); ?></a>
                        <?php
                    }
                    else
                    {
                        ?> <a href="#" class="account"><?php _e('My account', PLSH_THEME_DOMAIN); ?></a> <?php
                    }
                    ?>
                </div>
                <?php endif; ?>
                <?php if(function_exists('icl_get_languages'))
                {
                    ?>
                    <!-- START WPML -->
                    <span id="flags_language_selector"<?php if(plsh_is_woocommerce_active()) { echo 'class="has-woo"'; }?>><?php language_selector_flags(); ?></span>
                    <!-- END WPML -->
                    <?php
                }
                ?>
                <?php get_template_part( 'searchform'); ?>
            </div>
			<?php if(plsh_is_woocommerce_active()) : ?>
	            <div class="row _user_auth clearfix">
	                <form action="<?php echo get_permalink( get_option('woocommerce_myaccount_page_id') ); ?>" method="post" class="login">
	                    <?php wp_nonce_field( 'woocommerce-login' ); ?>
	                    <label><?php _e('Log in', PLSH_THEME_DOMAIN); ?>:</label>
	                    <input type="text" name="username" placeholder="<?php _e('username or e-mail', PLSH_THEME_DOMAIN); ?>" />
	                    <p><input type="password" name="password" placeholder="<?php _e('password', PLSH_THEME_DOMAIN); ?>" /><a href="<?php 
	                     echo esc_url( wc_lostpassword_url() ); ?>" class="password"><?php _e('Forgot?', PLSH_THEME_DOMAIN); ?></a></p>
	                    <input type="submit" class="woo-submit" name="login" value="<?php _e('Log-in', PLSH_THEME_DOMAIN); ?>" />
	                </form>
	            </div>
			<?php endif; ?>
			
            <nav class="main-menu clearfix">
                <?php
                    if(has_nav_menu('primary'))
                    {
                        wp_nav_menu(array(
                            'theme_location'  => 'primary',
                            'container'       => false, 
                            'echo'            => true,
                            'depth'           => 3,
                            'fallback_cb'	  => false,
                            'link_before'     => '<span>',
                            'link_after'      => '</span>',
                            'menu_class'	  => false
                        ));
                        
                        $locations = get_nav_menu_locations();
                        if ( !empty($locations['primary']) ) 
                        {
                            echo '<div class="mobile-menu">';
                            $menu = wp_get_nav_menu_object($locations['primary']);
                            $menu_items = wp_get_nav_menu_items($menu->term_id);
                            
                            echo '<select class="navigationSelector">';
                                echo '<option value="">' . __('Menu', PLSH_THEME_DOMAIN) . '</option>';
                                foreach ( (array) $menu_items as $key => $menu_item )
                                {
                                    $prefix = '';
                                    if($menu_item->menu_item_parent != 0)
                                    {
                                        $prefix = "&ensp; > ";
                                    }
                                    $title = $prefix . $menu_item->title;
                                    $url = $menu_item->url;
                                    echo "<option value=\"" . $url . "\">" . $title . "</option>";
                                }

                            echo '</select>';
                            echo '</div>';
                        }
                    }
                ?>
                <?php get_template_part( 'searchform'); ?>
            </nav>
        <!-- END .main-header -->
        </header>