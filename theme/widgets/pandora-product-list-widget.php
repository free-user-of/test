<?php

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class PandoraProductList extends WP_Widget {

    var $widget_cssclass;
	var $widget_description;
	var $widget_idbase;
	var $widget_name;
    
	function PandoraProductList() {

		/* Widget variable settings. */
		$this->widget_cssclass = 'best-sellers';
		$this->widget_description = __( 'Display a list of products on your site. Styled directly for Pandora.', PLSH_THEME_DOMAIN );
		$this->widget_idbase = 'pandora-best-sellers';
		$this->widget_name = __( 'Pandora Product List', PLSH_THEME_DOMAIN );

		/* Widget settings. */
		$widget_ops = array( 'classname' => $this->widget_cssclass, 'description' => $this->widget_description );

		/* Create the widget. */
		$this->WP_Widget('pandora_best_sellers', $this->widget_name, $widget_ops);

		add_action( 'save_post', array( $this, 'flush_widget_cache' ) );
		add_action( 'deleted_post', array( $this, 'flush_widget_cache' ) );
		add_action( 'switch_theme', array( $this, 'flush_widget_cache' ) );
	}


	function widget( $args, $instance ) {
		global $woocommerce;

		$cache = wp_cache_get('pandora_best_sellers', 'widget');

		if ( !is_array($cache) ) $cache = array();

		if ( isset($cache[$args['widget_id']]) ) {
			echo $cache[$args['widget_id']];
			return;
		}

		ob_start();
		extract($args);

		$title = apply_filters('widget_title', empty($instance['title']) ? __('Best Sellers', 'woocommerce' ) : $instance['title'], $instance, $this->id_base);
		$type = plsh_get($instance, 'type', 'best-sellers');
        
        if ( !$number = (int) $instance['number'] )
			$number = 10;
		else if ( $number < 1 )
			$number = 1;
		else if ( $number > 15 )
			$number = 15;

        if($type == 'best-sellers')
        {
            $query_args = array(
                'posts_per_page' => $number,
                'post_status' 	 => 'publish',
                'post_type' 	 => 'product',
                'meta_key' 		 => 'total_sales',
                'orderby' 		 => 'meta_value_num',
                'no_found_rows'  => 1,
            );

            $query_args['meta_query'] = array();

        }
        else if($type == 'recently-added')
        {

            $query_args = array(
                'posts_per_page' => $number,
                'no_found_rows' => 1,
                'post_status' => 'publish',
                'post_type' => 'product'
            );

            $query_args['meta_query'] = array();
            $query_args['parent'] = '0';

        }
        else if($type == 'on-sale')
        {
            // Get products on sale
            $product_ids_on_sale = woocommerce_get_product_ids_on_sale();

            $meta_query = array();

            $query_args = array(
                'posts_per_page' 	=> $number,
                'no_found_rows' => 1,
                'post_status' 	=> 'publish',
                'post_type' 	=> 'product',
                'orderby' 		=> 'date',
                'order' 		=> 'ASC',
                'meta_query' 	=> $meta_query,
                'post__in'		=> $product_ids_on_sale
            );
        }
        else if($type == 'top-rated')
        {
            add_filter( 'posts_clauses',  array( $woocommerce->query, 'order_by_rating_post_clauses' ) );

            $query_args = array(
                'posts_per_page' => $number,
                'no_found_rows' => 1,
                'post_status' => 'publish',
                'post_type' => 'product'
            );

            $query_args['meta_query'] = array();

        }
        else if($type == 'recently-viewed')
        {
            $viewed_products = ! empty( $_COOKIE['woocommerce_recently_viewed'] ) ? (array) explode( '|', $_COOKIE['woocommerce_recently_viewed'] ) : array();
            $viewed_products = array_filter( array_map( 'absint', $viewed_products ) );
            
            $query_args = array(
                'posts_per_page' => $number,
                'no_found_rows' => 1,
                'post_status' => 'publish',
                'post_type' => 'product',
                'post__in' => $viewed_products,
                'orderby' => 'rand'
            );
            $query_args['meta_query'] = array();
        }
        
        $query_args['meta_query'][] = $woocommerce->query->stock_status_meta_query();
        $query_args['meta_query'][] = $woocommerce->query->visibility_meta_query();
        
		$r = new WP_Query($query_args);

		if ( $r->have_posts() ) {

			echo $before_widget;

			if ( $title )
				echo $before_title . $title . $after_title;

			echo '<div class="items">';
                while ( $r->have_posts()) 
                {
                    $r->the_post();
                    global $product;
                
                    echo '<div class="item-block-1">';
                        if ( $product->is_on_sale() && isset( $product->regular_price ) )
                        {
                            echo '<span class="tag-sale"></span>';
                        }

                        echo '<div class="image-wrapper">
                        <div class="image">
                            <div class="overlay">
                                <div class="position">
                                    <div>';
                                    echo '<a href="' . get_permalink() . '" class="view">' . _x('View more', PLSH_THEME_DOMAIN) . '</a>';
                              echo' </div>
                                </div>
                            </div>';
                            echo '<a href="' . get_permalink() . '">';
                            if( has_post_thumbnail())
                            {
                                echo plsh_get_thumbnail('product_catalog_small');
                            }
                            echo '</a>';
                        echo '</div>
                         </div>';
                        echo '<p class="price">' . woocommerce_price( $product->get_price() ) . '</p>';
                    echo '</div>';
                }

			echo '</div>';

			echo $after_widget;
		}

		$content = ob_get_clean();

		if ( isset( $args['widget_id'] ) ) $cache[$args['widget_id']] = $content;

		echo $content;

		wp_cache_set('widget_best_sellers', $cache, 'widget');
	}


	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['number'] = (int) $new_instance['number'];
        $instance['type'] = $new_instance['type'];
        
		if ( isset( $new_instance['hide_free'] ) ) {
			$instance['hide_free'] = 1;
		}

		$this->flush_widget_cache();

		$alloptions = wp_cache_get( 'alloptions', 'options' );
		if ( isset($alloptions['pandora_best_sellers']) ) delete_option('pandora_best_sellers');

		return $instance;
	}


	function flush_widget_cache() {
		wp_cache_delete( 'pandora_best_sellers', 'widget' );
	}



	function form( $instance ) {
		$title = isset($instance['title']) ? esc_attr($instance['title']) : '';
        $type = isset($instance['type']) ? esc_attr($instance['type']) : 'best-sellers';
		if ( !isset($instance['number']) || !$number = (int) $instance['number'] ) $number = 4;
		$hide_free_checked = ( isset( $instance['hide_free'] ) && 1 == $instance['hide_free'] ) ? ' checked="checked"' : '';

		?>
		<p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e( 'Title:', 'woocommerce' ); ?></label>
		<input class="widefat" id="<?php echo esc_attr( $this->get_field_id('title') ); ?>" name="<?php echo esc_attr( $this->get_field_name('title') ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" /></p>

		<p><label for="<?php echo $this->get_field_id('number'); ?>"><?php _e( 'Number of products to show:', 'woocommerce' ); ?></label>
		<input id="<?php echo esc_attr( $this->get_field_id('number') ); ?>" name="<?php echo esc_attr( $this->get_field_name('number') ); ?>" type="text" value="<?php echo esc_attr( $number ); ?>" size="3" /></p>

        <p><label for="<?php echo $this->get_field_id('type'); ?>"><?php _e( 'What selection of products to show:', PLSH_THEME_DOMAIN ); ?></label>
            <select id="<?php echo esc_attr( $this->get_field_id('type') ); ?>" name="<?php echo esc_attr( $this->get_field_name('type') ); ?>">
                <option value="best-sellers" <?php if(esc_attr( $type ) == 'best-sellers') echo 'selected="selected"'; ?>><?php _e( 'Best sellers', PLSH_THEME_DOMAIN ); ?></option>
                <option value="recently-added" <?php if(esc_attr( $type ) == 'recently-added') echo 'selected="selected"'; ?>><?php _e( 'Recently added', PLSH_THEME_DOMAIN ); ?></option>
                <option value="on-sale" <?php if(esc_attr( $type ) == 'on-sale') echo 'selected="selected"'; ?>><?php _e( 'On sale', PLSH_THEME_DOMAIN ); ?></option>
                <option value="top-rated" <?php if(esc_attr( $type ) == 'top-rated') echo 'selected="selected"'; ?>><?php _e( 'Top rated', PLSH_THEME_DOMAIN ); ?></option>
                <option value="recently-viewed" <?php if(esc_attr( $type ) == 'recently-viewed') echo 'selected="selected"'; ?>><?php _e( 'Recently viewed', PLSH_THEME_DOMAIN ); ?></option>
            </select>
        </p>
        
		<?php
	}
}