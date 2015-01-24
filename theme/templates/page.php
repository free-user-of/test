<div <?php post_class('post'); ?>>
    <?php    
    if ( have_posts() ) : 
        while ( have_posts() ) : the_post();
            
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

        endwhile;
    else :
        echo _e('no posts found!', PLSH_THEME_DOMAIN);
    endif;
    ?>
</div>