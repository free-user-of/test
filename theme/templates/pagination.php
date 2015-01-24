<?php
if(plsh_pagination_exists())
{
?>
	<!-- BEGIN .pages -->	
	<div class="pages clearfix">
		<?php
		$pages = plsh_get_pagination();
        //debug($pages);
		foreach($pages as $page)
		{
			echo $page;
		}
		?>
		<?php 			
		if(plsh_get_current_page_num() == plsh_get_max_pages())
		{
			echo '<a href="#" class="next disabled"><span></span></a>';
		}
		else
		{
			echo '<a href="' . plsh_get_next_page_link() . '" class="next"><span></span></a>';
		}
		
		if(plsh_get_current_page_num() == 1)
		{
			echo '<a href="#" class="previous disabled"><span></span></a>';
		}
		else
		{
			echo '<a href="' . plsh_get_prev_page_link() . '" class="previous"><span></span></a>';
		}
		?>
	<!-- END .pages -->	
	</div>
<?php 
}
?>