<?php
/*
Template Name: Homepage
*/
?>
<?php get_header(); ?>
<?php plsh_get_theme_template('slider'); ?>

<!-- BEGIN .main-content-wrapper -->
<section class="main-content-wrapper clearfix">
	 
   <?php
        if ( have_posts() ) : 
            while ( have_posts() ) : the_post();
                the_content();
            endwhile;
        endif;
    ?>
        
<!-- END .main-content-wrapper -->
</section>

<?php get_footer(); ?>