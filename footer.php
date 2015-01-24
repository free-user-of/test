		<!-- BEGIN .main-footer-wrapper -->
		<footer class="main-footer-wrapper">
			
			<!-- BEGIN .main-footer -->
			<div class="main-footer clearfix">
                
                <?php dynamic_sidebar('footer'); ?>        
			
			<!-- END .main-footer -->
			</div>
			
			<!-- BEGIN .copyright -->
			<div class="copyright">
				<p><?php echo plsh_gs('copyrigts_text'); ?></p>
                <?php if(plsh_gs('show_planetshine') == 'on') : ?>
                    <p>Linhkien.info <a href="http:linhkien.info"></a></p>
                <?php endif; ?>
			<!-- END .copyright -->
			</div>
						
		<!-- END .main-footer-wrapper -->
		</footer>
		
		<!-- END .main-body-wrapper -->
		</div>

<?php wp_footer();?>

	<!-- END body -->
	</body>
	
<!-- END html -->
</html>