<!-- BEGIN .post -->
<div <?php post_class('post'); ?>>

	<article>
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
		<?php
            the_content();
            $args = array (
                'before'           => '<div class="post-pages pages clearfix">',
                'after'            => '</div>',
                'link_before'      => '<span></span>',
                'link_after'       => '',
                'next_or_number'   => 'next',
                'nextpagelink'     => __('Next page', PLSH_THEME_DOMAIN),
                'previouspagelink' => __('Previous page', PLSH_THEME_DOMAIN),
                'pagelink'         => '%',
                'echo'             => 1
            );
            wp_link_pages($args);
        ?>
	</article>

<!-- END .post -->	
</div>