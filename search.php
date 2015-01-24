<?php get_header(); ?>
<?php plsh_get_theme_template('breadcrumbs'); ?>

	<!-- BEGIN .main-content-wrapper -->
	<section class="main-content-wrapper clearfix">

        <!-- BEGIN .main-content-left -->
        <section class="main-content-left">

			<div class="blog-list">
				<?php
				if ( have_posts() ) :
					while ( have_posts() ) : the_post();
						?>
                        <article <?php post_class(); ?>>
                            <h2 class="title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
                            <div class="title-details">
                                <a href="<?php the_permalink(); ?>" class="time"><?php the_date(); ?></a>
                                <?php
                                    $cats = wp_get_post_categories(get_the_ID());
                                    if(!empty($cats))
                                    {
                                        echo '<span class="category-links">';
                                        $count = count($cats);
                                        $counter = 1;
                                        foreach($cats as $cat )
                                        {
                                            $category = get_category($cat);
                                            $link = get_category_link($category);
                                            echo '<a href="' . esc_url( $link ) . '" title="' . $category->name . '">' . $category->name . '</a>';

                                            if($counter++ < $count)
                                            {
                                                echo ', ';
                                            }
                                        }
                                        echo '</span>';
                                    }

                                    $tags = wp_get_post_tags(get_the_ID());
                                    if(!empty($tags))
                                    {
                                        echo '<span class="category-links">';
                                        $count = count($tags);
                                        $counter = 1;
                                        foreach($tags as $tag )
                                        {
                                            $tag = get_tag($tag);
                                            $link = get_tag_link($category);
                                            echo '<a href="' . esc_url( $link ) . '" title="' . $tag->name . '">' . $tag->name . '</a>';

                                            if($counter++ < $count)
                                            {
                                                echo ', ';
                                            }
                                        }
                                        echo '</span>';
                                    }
                                ?>
                                <a href="<?php comments_link(); ?>" class="comments"><?php comments_number('0', '1', '%'); ?></a>
                            </div>
                            <div><?php echo plsh_get_thumbnail('blog_thumbnail', false, false) ?></div>
                            <?php echo strip_shortcodes(get_the_excerpt()); ?>
                            <p><a href="<?php the_permalink(); ?>" class="more-link">Read more <b>+</b></a></p>
                        </article>
                        <?php
					endwhile;
				else :
					echo 'no posts found!';
				endif;
				?>
			</div>
			
			<?php get_template_part( 'pagination'); ?>
			
		<!-- END .main-left-wrapper -->
		</section>

        <!-- BEGIN .main-sidebar -->
        <section class="main-sidebar">
            <?php get_sidebar(); ?>
        </section>

		<div class="clear"></div>

	<!-- END .main-content-wrapper -->
	</section>


<?php get_footer(); ?>