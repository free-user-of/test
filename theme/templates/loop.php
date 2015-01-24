<?php
if ( have_posts() ) : 
	while ( have_posts() ) : the_post();
		$template = 'loop';
		if(get_post_format())
		{
			$template .= '-' . get_post_format();
		}
		else
		{
			$template .= '-' . 'default';
		}
		
		if(is_single())	//TODO - is internal?!
		{
			$template .= '-single';
		}
		else
		{
			$template .= '-list-item';
		}
		plsh_get_theme_template($template);
		
	endwhile;
else :
	echo _e('no posts found!', PLSH_THEME_DOMAIN);
endif;
?>