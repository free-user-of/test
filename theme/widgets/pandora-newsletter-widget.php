<?php 
class PandoraNewsletter extends WP_Widget {

    var $widget_cssclass;
	var $widget_description;
	var $widget_idbase;
	var $widget_name;
    
	function PandoraNewsletter() {

		/* Widget variable settings. */
		$this->widget_cssclass = 'newsletter';
		$this->widget_description = __( 'Display newsletter signup form.', PLSH_THEME_DOMAIN );
		$this->widget_idbase = 'pandora_newsletter';
		$this->widget_name = __( 'Pandora Newsletter', PLSH_THEME_DOMAIN );

		/* Widget settings. */
		$widget_ops = array( 'classname' => $this->widget_cssclass, 'description' => $this->widget_description );

		/* Create the widget. */
		$this->WP_Widget('pandora_newsletter', $this->widget_name, $widget_ops);

		add_action( 'save_post', array( $this, 'flush_widget_cache' ) );
		add_action( 'deleted_post', array( $this, 'flush_widget_cache' ) );
		add_action( 'switch_theme', array( $this, 'flush_widget_cache' ) );
	}

	function widget($args, $instance) 
    {
		$cache = wp_cache_get('pandora_newsletter', 'widget');

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

		$title = apply_filters('widget_title', empty($instance['title']) ? __('Pandora Newsletter', PLSH_THEME_DOMAIN) : $instance['title'], $instance, $this->id_base);
		$description = apply_filters('widget_text', empty($instance['description']) ? plsh_gs('newsletter_description') : $instance['description'], $instance, $this->id_base);
        $widget_id = isset( $instance['widget_id'] ) ? $instance['widget_id'] : false;
        if(function_exists('icl_t'))
        {
            $description = icl_t('pandora-newsletter-widget', 'description', $description);
        }
?>
		<?php echo $before_widget; ?>
		<?php if ( $title ) echo $before_title . $title . $after_title; ?>
        
            <p><?php echo $description; ?></p>
            <form action="<?php echo plsh_gs('newsletter_form_action'); ?>" method="<?php echo plsh_gs('newsletter_form_method'); ?>">
                <input type="text" name="<?php echo plsh_gs('newsletter_email_field'); ?>" placeholder="<?php _e('e-mail address', PLSH_THEME_DOMAIN); ?>" />
            </form>

		<?php echo $after_widget; ?>
        <?php
		// Reset the global $the_post as this query will have stomped on it
		wp_reset_postdata();

		$cache[$args['widget_id']] = ob_get_flush();
		wp_cache_set('pandora_newsletter', $cache, 'widget');
	}

	function update( $new_instance, $old_instance ) 
    {
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
        $instance['description'] = strip_tags($new_instance['description']);
		$this->flush_widget_cache();

		$alloptions = wp_cache_get( 'alloptions', 'options' );
		if ( isset($alloptions['pandora_newsletter']) )
			delete_option('pandora_newsletter');

		return $instance;
	}

	function flush_widget_cache() 
    {
		wp_cache_delete('pandora_newsletter', 'widget');
	}

	function form( $instance ) 
    {
		$title = isset( $instance['title'] ) ? esc_attr( $instance['title'] ) : '';
        $description = isset( $instance['description'] ) ? esc_attr( $instance['description'] ) : '';
        if($description == '' && plsh_gs('newsletter_description'))
        {
            $description = esc_attr(plsh_gs('newsletter_description'));
        }
        //wpml
        if(function_exists('icl_register_string'))
        {
            icl_register_string('pandora-newsletter-widget', 'description', $description);
        }

?>
		<p><label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:', PLSH_THEME_DOMAIN ); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo $title; ?>" /></p>
        
        <p><label for="<?php echo $this->get_field_id( 'description' ); ?>"><?php _e( 'Description:', PLSH_THEME_DOMAIN ); ?></label>
        <textarea class="widefat" name="<?php echo $this->get_field_name( 'description' ); ?>"><?php echo $description; ?></textarea>
        </p>
        
		<p><?php _e( 'Setup newsletter in ' , PLSH_THEME_DOMAIN); ?> <a href="<?php echo get_admin_url() . 'admin.php?page=' . plsh_gs('theme_slug') . '-admin' . '&view=footer#footer_newsletter' ?>"><?php _e( 'theme settings' , PLSH_THEME_DOMAIN); ?></a>.</p>
<?php
	}
}