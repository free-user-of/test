<!-- BEGIN .main-navigation -->
<section class="main-navigation clearfix">
	<nav>
		<div class="navigation">
			<?php plsh_breadcrumbs(); ?>
		</div>
		<div class="title">
			<?php
			 if(is_home())
			 {
			 	echo _e('Latest news', PLSH_THEME_DOMAIN);
			 }
			 else
			 {
			 	if(plsh_is_shop_installed() && is_account_page() && !is_user_logged_in())
                {
                    if(plsh_get($_GET, 'action', 'login') == 'register') _e('Register', PLSH_THEME_DOMAIN);
                    else if(strpos(plsh_current_page_url(), 'lost-password') !== false) _e('Lost Password', PLSH_THEME_DOMAIN);
                    else echo _e('Login', PLSH_THEME_DOMAIN);
                }
                else
                {
                    if((is_single()))
                    {
                        $cats = get_the_category();
                        if($cats)
                        {
                            echo $cats[0]->name;
                        }
                        else 
                        {
                            echo _e('Latest news', PLSH_THEME_DOMAIN);
                        }
                    }
                    else
                    {
                        echo wp_title( '', true, '0' );
                    }
                }
			 }
             
             if(plsh_is_shop_installed() && is_checkout())
             {
                 echo '<span class="checkout-step-title">';
                 _e('Step', PLSH_THEME_DOMAIN);
                 echo ' <span class="checkout-step-no">1</span>';
                 _e(' of ', PLSH_THEME_DOMAIN);
                 echo '3</span>';
             }
             
			 ?>
		</div>
	</nav>
<!-- END .main-navigation -->
</section>