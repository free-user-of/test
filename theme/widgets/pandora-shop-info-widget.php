<?php 
class PandoraShopInfo extends WP_Widget {

    var $widget_cssclass;
	var $widget_description;
	var $widget_idbase;
	var $widget_name;
    
	function PandoraShopInfo() {

		/* Widget variable settings. */
		$this->widget_cssclass = 'about-us';
		$this->widget_description = __( 'Display information about your shop and accepted payment methods.', PLSH_THEME_DOMAIN );
		$this->widget_idbase = 'pandora_shop_info';
		$this->widget_name = __( 'Pandora Shop Info', PLSH_THEME_DOMAIN );

		/* Widget settings. */
		$widget_ops = array( 'classname' => $this->widget_cssclass, 'description' => $this->widget_description );

		/* Create the widget. */
		$this->WP_Widget('pandora_shop_info', $this->widget_name, $widget_ops);

		add_action( 'save_post', array( $this, 'flush_widget_cache' ) );
		add_action( 'deleted_post', array( $this, 'flush_widget_cache' ) );
		add_action( 'switch_theme', array( $this, 'flush_widget_cache' ) );
	}

	function widget($args, $instance) 
    {
		$cache = wp_cache_get('pandora_shop_info', 'widget');

		if ( !is_array($cache) )
			$cache = array();

		if ( ! isset( $args['widget_id'] ) )
			$args['widget_id'] = $this->id;

		if ( isset( $cache[ $args['widget_id'] ] ) ) {
			echo $cache[ $args['widget_id'] ];
			return;
		}

		ob_start();
		extract($args);

		$title = apply_filters('widget_title', empty($instance['title']) ? __('Pandora Shop Info', PLSH_THEME_DOMAIN) : $instance['title'], $instance, $this->id_base);
        $description = apply_filters('widget_text', empty($instance['description']) ? plsh_gs('about_us_text') : $instance['description'], $instance, $this->id_base);
        $widget_id = isset( $instance['widget_id'] ) ? $instance['widget_id'] : false;
        if(function_exists('icl_t'))
        {
            $description = icl_t('pandora-info-widget', 'description', $description);
        }
        
?>
		<?php echo $before_widget; ?>
		<?php if ( $title ) echo $before_title . $title . $after_title; ?>
        
            <p><?php echo $description; ?></p>

            <?php if(plsh_gs('show_footer_social')) : ?>
            <div class="social clearfix">
                <?php
                if(plsh_gs('social_facebook') != '')
                {
                    echo '<a href="' . plsh_gs('social_facebook') . '" target="_blank" class="facebook"></a>';
                }
                if(plsh_gs('social_twitter') != '')
                {
                    echo '<a href="' . plsh_gs('social_twitter') . '" target="_blank" class="twitter"></a>';
                }
                if(plsh_gs('social_flickr') != '')
                {
                    echo '<a href="' . plsh_gs('social_flickr') . '" target="_blank" class="flickr"></a>';
                }
                if(plsh_gs('social_youtube') != '')
                {
                    echo '<a href="' . plsh_gs('social_youtube') . '" target="_blank" class="youtube"></a>';
                }
                if(plsh_gs('social_rss') != '')
                {
                    echo '<a href="' . plsh_gs('social_rss') . '" target="_blank" class="rss"></a>';
                }
                if(plsh_gs('social_pinterest') != '')
                {
                    echo '<a href="' . plsh_gs('social_pinterest') . '" target="_blank" class="pinterest"></a>';
                }
                ?>
            </div>
            <?php endif; ?>

            <?php if(plsh_gs('show_footer_cards') == 'on') : ?>
            <div class="cards clearfix">
                <?php
                if(plsh_gs('footer_card_visa') == 'on')
                {
                    echo '<a href="#" class="visa"></a>';
                }
                if(plsh_gs('footer_card_mastercard') == 'on')
                {
                    echo '<a href="#" class="mastercard"></a>';
                }
                if(plsh_gs('footer_card_paypal') == 'on')
                {
                    echo '<a href="#" class="paypal"></a>';
                }
                if(plsh_gs('footer_card_discover') == 'on')
                {
                    echo '<a href="#" class="discover"></a>';
                }
                if(plsh_gs('footer_card_americanexpress') == 'on')
                {
                    echo '<a href="#" class="americanexpress"></a>';
                }
                if(plsh_gs('footer_card_google') == 'on')
                {
                    echo '<a href="#" class="google"></a>';
                }
                ?>
            </div>
            <?php endif; ?>

		<?php echo $after_widget; ?>
        <?php
		// Reset the global $the_post as this query will have stomped on it
		wp_reset_postdata();

		$cache[$args['widget_id']] = ob_get_flush();
		wp_cache_set('pandora_shop_info', $cache, 'widget');
	}

	function update( $new_instance, $old_instance ) 
    {
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
        $instance['description'] = strip_tags($new_instance['description']);
		$this->flush_widget_cache();

		$alloptions = wp_cache_get( 'alloptions', 'options' );
		if ( isset($alloptions['pandora_shop_info']) )
			delete_option('pandora_shop_info');

		return $instance;
	}

	function flush_widget_cache() 
    {
		wp_cache_delete('pandora_shop_info', 'widget');
	}

	function form( $instance ) 
    {
		$title     = isset( $instance['title'] ) ? esc_attr( $instance['title'] ) : '';
        $description     = isset( $instance['description'] ) ? esc_attr( $instance['description'] ) : '';
        if($description == '' && plsh_gs('newsletter_description'))
        {
            $description = esc_attr(plsh_gs('newsletter_description'));
        }
        
        //wpml
        if(function_exists('icl_register_string'))
        {
            icl_register_string('pandora-info-widget', 'description', $description);
        }
?>
		<p><label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' , PLSH_THEME_DOMAIN); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo $title; ?>" /></p>

        <p><label for="<?php echo $this->get_field_id( 'description' ); ?>"><?php _e( 'Description:', PLSH_THEME_DOMAIN ); ?></label>
        <textarea class="widefat" name="<?php echo $this->get_field_name( 'description' ); ?>"><?php echo $description; ?></textarea>
        </p>
    <?php
	}
}