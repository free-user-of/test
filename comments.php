<!-- BEGIN .comments -->
<div class="comments">
	
    <?php if ( comments_open() ) : ?>
        <?php if ( have_comments() ) : ?>
            
            <div class="main-title clearfix">
                <p><?php _e('Comments', PLSH_THEME_DOMAIN); ?></p>
            </div>
    
            <ul class="items">
                <?php wp_list_comments( array( 'callback' => 'plsh_comments' ) ); ?>
            </ul>
            
        <?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : ?>
            <!-- BEGIN .pages -->	
            <div class="pages clearfix">
				<div class="nav-previous"><?php previous_comments_link( '<span></span>' .  __('Previous', PLSH_THEME_DOMAIN)); ?></div>
				<div class="nav-next"><?php next_comments_link(__('Next', PLSH_THEME_DOMAIN) . '<span></span>'); ?></div>
			</div>
		<?php endif; ?>
    
        <?php endif; ?>
        
        <div class="main-title clearfix">
            <p><?php _e('Add reply', PLSH_THEME_DOMAIN); ?></p>
        </div>
    
        <div class="add-comment">
            <?php comment_form(); ?>
        </div>
    <?php endif; ?>

<!-- END .comments -->
</div>
