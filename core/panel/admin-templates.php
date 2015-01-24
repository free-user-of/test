<?php

function plsh_sidebar()
{
    global $_SETTINGS;
    $head = $_SETTINGS->admin_head;
        
    ?>
        <!-- BEGIN .sidebar -->
        <div class="sidebar">
            <div class="logo">
                <img src="<?php echo PLSH_ADMIN_ASSET_URL; ?>images/logo-planetshine-1.png" alt="Planetshine Control Panel" />
            </div>
            <?php
                
                if(!empty($head))
                {
                    
                    $view = plsh_get($_GET, 'view', $head[key($head)]['slug']);   //get view; defaults to first element of header
                    
                    echo '<ul class="menu">';
                    
                    foreach($head as $h)
                    {
                         echo '<li class="' . $h['slug'];
                         if($view == $h['slug']) echo ' active';
                         echo '">';
                         
                         if($h['type'] == 'plsh_visual_editor')
                         {
                            echo '<a href="' . $h['link'] . '">' . $h['name'] . '</a>';
                         }
                         else
                         {
                            echo '<a href="' . get_admin_url() . 'admin.php?page=' . plsh_gs('theme_slug') . '-admin' . '&view=' . $h['slug'] . '">' . $h['name'] . '</a>';
                         }
                         
                         if(!empty($h['children']))
                         {
                             echo '<ul>';
                             
                             foreach($h['children'] as $ch)
                             {
                                 echo '<li><a href="#' . $ch['slug'] . '"><span>•</span>' . $ch['name'] . '</a></li>';
                             }
                             
                             echo '</ul>';
                         }
                         
                         echo '</li>';
                    }
                    
                    echo '</ul>';
                }
            ?>
        <!-- END .sidebar -->
        </div>
    <?php
}

function plsh_option_list()
{
    global $_SETTINGS;
    $head = $_SETTINGS->admin_head;
    $body = $_SETTINGS->admin_body;
    $view = plsh_get($_GET, 'view', $head[key($head)]['slug']);   //get view; defaults to first element of header

    ?>
    <form name="settings" class="no-submit">
            
        <?php
            if(!empty($body[$view]))
            {
                foreach($body[$view] as $key => $section)
                {
                    echo '<!-- BEGIN .section-item -->
                            <div class="section-item clearfix" id="' . $key . '">';

                    echo '<h3>' . $head[$view]['children'][$key]['name'] . '</h3>';

                    foreach($section as $option)
                    {
                        plsh_output_theme_setting($option);
                    }

                    echo '<!-- END .section-item -->
                          </div>';
                }
            }
        ?>
					
        <!-- BEGIN .section-save -->
        <div class="section-save">
            <a href="#" id="save" class="button-2">Save changes</a>
        <!-- END .section-save -->
        </div>
    </form>
    <script type="text/javascript">
        jQuery(document).ready(function () {
            jQuery('#save').click(function(){		//option update
                var result = jQuery('form[name=settings]').serializeArray();

                result = result.concat(
                    jQuery('form[name=settings] input[type=checkbox]:not(:checked)').map(
                        function() {
                            return {"name": this.name, "value": 'off'}
                        }).get()
                );

                var admin_ajax = '<?php echo site_url() .'/wp-admin/admin-ajax.php'; ?>';
                var nonce = '<?php echo wp_create_nonce('plsh_save_settings') ?>';
                var data = { action: 'plsh_save_settings', _ajax_nonce: nonce, data: result};

                jQuery.ajax({
                    type: "POST",
                    url: admin_ajax,
                    traditional: true,
                    dataType: 'json',
                    data: { action: 'plsh_save_settings', _ajax_nonce: nonce, data: jQuery.param(result) },
                    success: function(msg){
                        console.log(msg);
                        show_save_result(msg);
                    }
                });

                return false;
            });
        });
        
        var global_image_url = '<?php echo site_url() .'/wp-admin/admin-ajax.php'; ?>?action=plsh_upload_image&_ajax_nonce=<?php echo wp_create_nonce('plsh_upload_image') ?>';
        
    </script>
    <?php
}


function plsh_sidebar_manager()
{
    global $_SETTINGS;
    $head = $_SETTINGS->admin_head;
    $view = plsh_get($_GET, 'view', $head[key($head)]['slug']);   //get view; defaults to first element of header
    $sidebars_select = array();
    foreach(plsh_gs('sidebars') as $sidebar)
    {
        $sidebars_select[$sidebar['id']] = $sidebar['name'];
    }
    $pages_sidebars = plsh_gs('page_sidebars');
    
    ?>
        
        <div class="section-item clearfix" id="all_sidebars">
            <ul class="sidebar-list">
                <h3><?php _e('All Sidebars', PLSH_THEME_DOMAIN); ?></h3>
                <?php
                    $sidebars = plsh_gs('sidebars');
                    foreach($sidebars as $sidebar)
                    {
                        echo '<li><span>' . $sidebar['name'] . '</span> ';
                        if($sidebar['id'] !== 'default_sidebar' && $sidebar['id'] !== 'footer_sidebar')
                        {
                            echo '<a href="#" class="delete-sidebar" id="' . $sidebar['id'] . '"></a></li>';
                        }
                    }
                ?>
            </ul>
        </div>
        <div class="section-item clearfix" id="create_sidebar">
            <h3><?php _e('Create Sidebar', PLSH_THEME_DOMAIN); ?></h3>
            <form name="add-new" class="no-submit">
                <input type="hidden" name="action" value="new" />
                <?php plsh_output_theme_setting(array(
                    'slug' => 'name',
                    'title' => 'Sidebar name',
                    'type'  => 'textbox',
                    'value' => ''
                ));
                ?>
                <!-- BEGIN .section-save -->
                <div class="section-save">
                    <a href="#" id="add_new" class="button-1">Add Sidebar</a>
                <!-- END .section-save -->
                </div>
            </form>
        </div>
    
        <div class="section-item clearfix" id="manage_sidebars">
            <h3><?php _e('Manage Sidebars', PLSH_THEME_DOMAIN); ?></h3>
            <form name="manage-sidebars" class="no-submit">
                <input type="hidden" name="action" value="manage" />
                <?php
                $templates = plsh_gs('page_types');
                foreach($templates as $key => $template)
                {
                    plsh_output_theme_setting(array(
                        'slug' => $key,
                        'title' => $template,
                        'type'  => 'select',
                        'value' => plsh_get($pages_sidebars, $key, NULL),
                        'data'  => $sidebars_select
                    ));
                }
                ?>
            </form>
        </div>
    
        <!-- BEGIN .section-save -->
        <div class="section-save">
            <a href="#" id="save" class="button-2">Save changes</a>
        <!-- END .section-save -->
        </div>
					
    <script type="text/javascript">
        jQuery(document).ready(function () {

            jQuery('#add_new').click(function(){
               
                var result = jQuery('form[name=add-new]').serialize();

                var admin_ajax = '<?php echo site_url() .'/wp-admin/admin-ajax.php'; ?>';
                var nonce = '<?php echo wp_create_nonce('plsh_save_sidebar') ?>';
                var data = { action: 'plsh_save_sidebar', _ajax_nonce: nonce, data: result};

                jQuery.post(admin_ajax,data,function(msg){
                    show_save_result(msg);

                    if(msg['status'] === 'ok')
                    {
                        jQuery('.sidebar-list').append(msg['html']);
                        jQuery('.sidebar-list li').last().slideDown(200);
                        add_sidebar_option();
                    }

                }, 'json');

                return false;
            });
            
            jQuery('#save').click(function(){
               
                var result = jQuery('form[name=manage-sidebars]').serialize();

                var admin_ajax = '<?php echo site_url().'/wp-admin/admin-ajax.php'; ?>';
                var nonce = '<?php echo wp_create_nonce('plsh_save_sidebar') ?>';
                var data = { action: 'plsh_save_sidebar', _ajax_nonce: nonce, data: result};

                jQuery.post(admin_ajax,data,function(msg){
                    show_save_result(msg);
                }, 'json');

                return false;
            });

            jQuery('.sidebar-list').on('click', '.delete-sidebar', function(){;
                var item = jQuery(this);
                var id = jQuery(this).attr('id');
                var data = 'action=delete&id='+ id;

                var admin_ajax = '<?php echo site_url().'/wp-admin/admin-ajax.php'; ?>';
                var nonce = '<?php echo wp_create_nonce('plsh_save_sidebar') ?>';
                var data = { action: 'plsh_save_sidebar', _ajax_nonce: nonce, data: data};

                jQuery.post(admin_ajax,data,function(msg){
                    show_save_result(msg);

                    if(msg['status'] === 'ok')
                    {
                        item.parent().slideUp();
                        remove_sidebar_option(id);
                    }

                }, 'json');

                return false;
            });

        });
    </script>
    <?php
}

function plsh_admin()
{
    plsh_load_admin_styles();
    plsh_load_admin_scripts();
    
    global $_SETTINGS;
    $head = $_SETTINGS->admin_head;
    $body = $_SETTINGS->admin_body;
    
    if(!empty($head) && !empty($body))
    {
        $view = plsh_get($_GET, 'view', $head[key($head)]['slug']);   //get view; defaults to first element of header
        
        ?>
        <!-- BEGIN .main-control-panel-wrapper -->
		<div class="main-control-panel-wrapper">
			
			<?php plsh_sidebar(); ?>
			
			<!-- BEGIN .main-content -->
			<div class="main-content-wrapper">
				<div class="main-content">
				
					<!-- BEGIN .header -->
					<div class="header">
						<h2><?php echo plsh_gs('theme_name'); ?></h2>
						<a href="<?php echo get_admin_url() . 'admin.php?page=' . plsh_gs('theme_slug') . '-admin' . '&view=help_support' ?>" class="support">Get support from Planetshine</a>
					<!-- END .header -->
					</div>
                    
                    <!-- BEGIN .save-message-1 -->
					<div class="save-message-1 clearfix">
						<span>Your settings have been saved!</span>
						<a href="#" class="close"></a>
					<!-- END .save-message-1 -->
					</div>
					
					<!-- BEGIN .error-message-1 -->
					<div class="error-message-1 clearfix">
						<span>Your settings have not been saved!</span>
						<a href="#" class="close"></a>
					<!-- END .error-message-1 -->
					</div>
                    <?php
                        if(!empty($head[$view]['type']))
                        {
                            if(function_exists($head[$view]['type']))
                            {
                                $head[$view]['type']();
                            }
                        }
                    ?>                         
				</div>
			<!-- END .main-content -->
			</div>
		
		<!-- END .main-control-panel-wrapper -->
		</div>
        <?php
    }
}

function plsh_backup_reset()
{
    ?>
        <div class="section-item clearfix" id="backup_settings">
            <h3><?php _e('Backup Settings', PLSH_THEME_DOMAIN); ?></h3>
            <?php
            plsh_output_theme_setting(array(
                    'slug'        => 'settings_export',
                    'title'       => 'Exported settings',
                    'type'        => 'textarea',
                    'value'       => Plsh_Settings::export_settings(),
                    'description' => '',
                    'warning'     => 'Copy & save these settings to your computer. You can later import them back using the form below.'
                ));
            ?>
        </div>
        
        <div class="section-item clearfix" id="import_settings">
            <h3><?php _e('Import Settings', PLSH_THEME_DOMAIN); ?></h3>
            <form name="import-settings" class="no-submit">
                <?php
                plsh_output_theme_setting(array(
                        'slug'        => 'settings_export',
                        'title'       => 'Settings for import',
                        'type'        => 'textarea',
                        'value'       => '',
                        'description' => '',
                        'warning'     => 'Paste here the settings that you previously exported/backed up from this theme. If the import fails, reset the settings using the button below.'
                    ));
                ?>
                <div class="row">
                    <a href="#" id="import-settings" class="button-1"><?php _e('Import', PLSH_THEME_DOMAIN) ?></a>
                </div>
            </form>
        </div>
        
        <div class="section-item clearfix" id="reset_settings">
            <h3><?php _e('Reset Settings', PLSH_THEME_DOMAIN); ?></h3>
            <div class="row">
                <a href="#" id="reset-theme" class="button-1"><?php _e('Reset Theme', PLSH_THEME_DOMAIN) ?></a>
            </div>
        </div>
        
        <script type="text/javascript">
            jQuery(document).ready(function () {

                jQuery('#import-settings').click(function(){
                    var result = jQuery('form[name=import-settings]').serialize();

                    var admin_ajax = '<?php echo site_url().'/wp-admin/admin-ajax.php'; ?>';
                    var nonce = '<?php echo wp_create_nonce('plsh_import_settings') ?>';
                    var data = { action: 'plsh_import_settings', _ajax_nonce: nonce, data: result};

                    jQuery.post(admin_ajax,data,function(msg){
                        show_save_result(msg);
                    }, 'json');

                    return false;
                });
                
                jQuery('#reset-theme').click(function(){
                    var c = confirm('Are you sure? By reseting theme You will permanently delete all you settings!');
                    if(c === true )
                    {
                        var admin_ajax = '<?php echo site_url().'/wp-admin/admin-ajax.php'; ?>';
                        var nonce = '<?php echo wp_create_nonce('plsh_reset_settings') ?>';
                        var data = { action: 'plsh_reset_settings', _ajax_nonce: nonce};

                        jQuery.post(admin_ajax,data,function(msg){
                            location.reload();
                        });
                    }
                    return false;
                });
            });
        </script>
    <?php
}

function plsh_support_iframe()
{
    ?>
        <iframe class="support-iframe" src="<?php echo plsh_gs('support_url') ?>" height="100%" border="none"></iframe>
    <?php
}

?>