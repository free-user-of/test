<?php
/*
Template Name: Page with sidebar
*/
?>
<?php get_header(); ?>
<?php plsh_get_theme_template('breadcrumbs'); ?>

<!-- BEGIN .main-content-wrapper -->
<section class="main-content-wrapper clearfix">
	
    <!-- BEGIN .main-content-left -->
    <section class="main-content-left">

        <?php plsh_get_theme_template('page'); ?>

        <?php comments_template( '', true ); ?>

    <!-- END .main-content-left -->
    </section>
    
    <!-- BEGIN .main-sidebar -->
    <section class="main-sidebar">

        <?php get_sidebar(); ?>

    </section>

<!-- END .main-content-wrapper -->
</section>

<?php get_footer(); ?>