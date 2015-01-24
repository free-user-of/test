<?php 
class PandoraRecentPosts extends WP_Widget {

    var $widget_cssclass;
	var $widget_description;
	var $widget_idbase;
	var $widget_name;
    
	function PandoraRecentPosts() {

		/* Widget variable settings. */
		$this->widget_cssclass = 'recent-posts';
		$this->widget_description = __( 'Display a list of Recent posts. Styled directly for Pandora.', PLSH_THEME_DOMAIN );
		$this->widget_idbase = 'pandora_recent_posts';
		$this->widget_name = __( 'Pandora Recent Posts', PLSH_THEME_DOMAIN );

		/* Widget settings. */
		$widget_ops = array( 'classname' => $this->widget_cssclass, 'description' => $this->widget_description );

		/* Create the widget. */
		$this->WP_Widget('pandora_recent_posts', $this->widget_name, $widget_ops);

		add_action( 'save_post', array( $this, 'flush_widget_cache' ) );
		add_action( 'deleted_post', array( $this, 'flush_widget_cache' ) );
		add_action( 'switch_theme', array( $this, 'flush_widget_cache' ) );
	}

	function widget($args, $instance) 
    {
		$cache = wp_cache_get('pandora_recent_entries', 'widget');

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

		$title = apply_filters('widget_title', empty($instance['title']) ? __('Pandora Recent Posts', PLSH_THEME_DOMAIN) : $instance['title'], $instance, $this->id_base);
		if ( empty( $instance['number'] ) || ! $number = absint( $instance['number'] ) )
 			$number = 10;
		$show_date = isset( $instance['show_date'] ) ? $instance['show_date'] : false;

		$r = new WP_Query( apply_filters( 'widget_posts_args', array( 'posts_per_page' => $number, 'no_found_rows' => true, 'post_status' => 'publish', 'ignore_sticky_posts' => true ) ) );
		if ($r->have_posts()) :
?>
		<?php echo $before_widget; ?>
		<?php if ( $title ) echo $before_title . $title . $after_title; ?>
        
        <div class="items">
            <?php while ( $r->have_posts() ) : $r->the_post(); ?>
                <article> 
                    <h2 class="title"><a href="<?php the_permalink() ?>" title="<?php echo esc_attr( get_the_title() ? get_the_title() : get_the_ID() ); ?>"><?php if ( get_the_title() ) the_title(); else the_ID(); ?></a></h2>
                    <div class="title-details">
                        <a href="<?php the_permalink() ?>" class="time"><?php echo get_the_date(); ?></a>
                        <a href="<?php the_permalink() ?>#comments" class="comments"><?php $comments = wp_count_comments(get_the_ID()); echo $comments->approved; ?></a>
                    </div>
                    <p><a href="<?php the_permalink() ?>" class="more-link"><?php _e('Read more', PLSH_THEME_DOMAIN); ?> <b>+</b></a></p>
                </article>	
            <?php endwhile; ?>
        </div>
        <!-- END .recent-posts -->

		<?php echo $after_widget; ?>
        <?php
		// Reset the global $the_post as this query will have stomped on it
		wp_reset_postdata();

		endif;

		$cache[$args['widget_id']] = ob_get_flush();
		wp_cache_set('pandora_recent_posts', $cache, 'widget');
	}

	function update( $new_instance, $old_instance ) 
    {
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['number'] = (int) $new_instance['number'];
		$instance['show_date'] = (bool) $new_instance['show_date'];
		$this->flush_widget_cache();

		$alloptions = wp_cache_get( 'alloptions', 'options' );
		if ( isset($alloptions['pandora_recent_posts']) )
			delete_option('pandora_recent_posts');

		return $instance;
	}

	function flush_widget_cache() 
    {
		wp_cache_delete('pandora_recent_posts', 'widget');
	}

	function form( $instance ) 
    {
		$title     = isset( $instance['title'] ) ? esc_attr( $instance['title'] ) : '';
		$number    = isset( $instance['number'] ) ? absint( $instance['number'] ) : 5;
		$show_date = isset( $instance['show_date'] ) ? (bool) $instance['show_date'] : false;
?>
		<p><label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' , PLSH_THEME_DOMAIN); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo $title; ?>" /></p>

		<p><label for="<?php echo $this->get_field_id( 'number' ); ?>"><?php _e( 'Number of posts to show:', PLSH_THEME_DOMAIN ); ?></label>
		<input id="<?php echo $this->get_field_id( 'number' ); ?>" name="<?php echo $this->get_field_name( 'number' ); ?>" type="text" value="<?php echo $number; ?>" size="3" /></p>

		<p><input class="checkbox" type="checkbox" <?php checked( $show_date ); ?> id="<?php echo $this->get_field_id( 'show_date' ); ?>" name="<?php echo $this->get_field_name( 'show_date' ); ?>" />
		<label for="<?php echo $this->get_field_id( 'show_date' ); ?>"><?php _e( 'Display post date?', PLSH_THEME_DOMAIN ); ?></label></p>
<?php
	}
}