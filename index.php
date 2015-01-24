<?php get_header(); ?>
<?php plsh_get_theme_template('breadcrumbs'); ?>

<!-- BEGIN .main-content-wrapper -->
<section class="main-content-wrapper clearfix">
	
	<!-- BEGIN .main-content-left -->
	<section class="main-content-left">
			
		<!-- BEGIN .blog-list -->
		<div class="blog-list">
			
			<?php plsh_get_theme_template('loop'); ?>
			
		<!-- END .blog-list -->	
		</div>
		
		<?php plsh_get_theme_template('pagination'); ?>
		
	<!-- END .main-content-left -->
	</section>
	
	<!-- BEGIN .main-sidebar -->
	<section class="main-sidebar">

		<?php get_sidebar(); ?>

	<!-- END .main-sidebar -->
	</section>

<!-- END .main-content-wrapper -->
</section>

<?php get_footer(); ?>