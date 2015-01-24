<?php

function plsh_load_admin_menus() 
{
	add_menu_page( plsh_gs('theme_name'), plsh_gs('theme_name'), 'administrator', plsh_gs('theme_slug').'-admin', 'plsh_admin');
	add_submenu_page( plsh_gs('theme_slug').'-admin', 'Theme Options', 'Theme Options', 'administrator', plsh_gs('theme_slug').'-admin', 'plsh_admin');
}

function plsh_load_admin_styles() 
{
	 wp_enqueue_style('admin-style', get_template_directory_uri() .'/core/panel/assets/css/style.css');
     wp_enqueue_style('fileupload-ui-noscript', get_template_directory_uri() .'/core/panel/assets/css/jquery.fileupload-ui-noscript.css');
     wp_enqueue_style('fileupload-ui', get_template_directory_uri() .'/core/panel/assets/css/jquery.fileupload-ui.css');
     wp_enqueue_style('fileupload-ui-base', get_template_directory_uri() .'/core/panel/assets/css/jquery.fileupload.base.css');
     wp_enqueue_style('roboto', 'http://fonts.googleapis.com/css?family=Roboto:100,300,400');
}
 
function plsh_load_admin_scripts() 
{	 	
 	wp_enqueue_script('jquery');
    wp_enqueue_script('jquery-ui-core');
    wp_enqueue_script('jquery-ui-widget');
 	wp_enqueue_script('admin-scripts', get_template_directory_uri() .'/core/panel/assets/js/scripts.js');
    wp_enqueue_script('uniform', get_template_directory_uri() .'/core/panel/assets/js/jquery.uniform.js');
    wp_enqueue_script('dropkick', get_template_directory_uri() .'/core/panel/assets/js/jquery.dropkick.js');
    wp_enqueue_script('fileupload', get_template_directory_uri() .'/core/panel/assets/js/jquery.fileupload.js');
    wp_enqueue_script('iframe-transport', get_template_directory_uri() .'/core/panel/assets/js/jquery.iframe-transport.js');
}

function plsh_save_settings()
{
    check_ajax_referer('plsh_save_settings');
 	parse_str($_POST['data'],$data);
 	
    Plsh_Settings :: store_settings($data);
 	
 	die(json_encode(array('status' => 'ok', 'msg' => 'Settings saved!')));
}
 
function plsh_import_settings()
{
    check_ajax_referer('plsh_import_settings');
    parse_str($_POST['data'],$data);
       
    Plsh_Settings :: import_settings($data['settings_export']);
    
    die(json_encode(array('status' => 'ok', 'msg' => 'Settings imported!')));
}

function plsh_reset_settings()
{
    check_ajax_referer('plsh_reset_settings');
    
    Plsh_Settings :: reset_settings();
    
    die(json_encode(array('status' => 'ok', 'msg' => 'Settings reset!')));
}

function plsh_save_sidebar()
{
	global $_SETTINGS;
    check_ajax_referer('plsh_save_sidebar');
 	parse_str($_POST['data'],$data);
 	    
    if(!empty($data['action']))
    {
        //add new sidebar
        if($data['action'] == 'new')
        {
            if(strlen($data['name']) > 0)
            {
                $sidebars = plsh_gs('sidebars');
                foreach($sidebars as $sidebar)
                {
                    if($sidebar['name'] == $data['name'])
                    {
                        die(json_encode(array('status' => 'fail', 'msg' => 'name taken')));
                    }
                }
                
                $id = strtolower($data['name']);
                $id = preg_replace('/[^A-Za-z0-9-]/', '', $id);
                
                if(strlen($id) == 0)
                {
                    die(json_encode(array('status' => 'fail', 'msg' => 'invalid string')));
                }
                
                $sidebars[] = array(
                    'name' => $data['name'],
                    'id'   => $id,
                    'description' => '',
                    'class' => '',
                    'before_widget' => '<div id="%1$s" class="sidebar-item clearfix %2$s">',
                    'after_widget'  => '</div>',
                    'before_title'  => '<div class="main-title clearfix"><p>',
                    'after_title'   => '</p></div>'
                );
                
                plsh_ss('sidebars', $sidebars);
                
                $item = '<li style="display: none;"><span>' . $data['name'] . '</span> <a href="#" class="delete-sidebar" id="' . $id .  '"></a>';
                
                die(json_encode(array('status' => 'ok', 'msg' => 'saved', 'html' => $item)));
            }
            else 
            {
                die(json_encode(array('status' => 'fail', 'msg' => 'name empty')));
            }
        }
        else if($data['action'] == 'delete')
        {
            if(!empty($data['id']))
            {
                $sidebars = plsh_gs('sidebars');
                foreach($sidebars as $key => $sidebar)
                {
                    if($sidebar['id'] == $data['id'])
                    {
                        unset($sidebars[$key]);
                        plsh_ss('sidebars', $sidebars);
                        die(json_encode(array('status' => 'ok', 'msg' => 'deleted')));
                    }
                }

                die(json_encode(array('status' => 'fail', 'msg' => 'sidebar id not found')));
            }
        }
        else if($data['action'] == 'manage')
        {    
            unset($data['action']);
            
            $page_sidebars = plsh_gs('page_sidebars');
            
            $templates = plsh_gs('page_types');
            foreach($data as $key => $value)
            {
                if(in_array($key, array_keys($templates)))
                {
                    $page_sidebars[$key] = $value;
                }
            }
            
            plsh_ss('page_sidebars', $page_sidebars);
            
            die(json_encode(array('status' => 'ok', 'msg' => 'Sidebars saved')));
            
        }   
    }
     	
}


function plsh_upload_image() {
    
    check_ajax_referer('plsh_upload_image');
    
    $field = plsh_get($_GET, 'field', 'files');
    
    $options = array( 
        'upload_url' => PLSH_UPLOAD_URL,
        'upload_dir' => PLSH_UPLOAD_PATH,
        'param_name' => $field,
        'image_versions' => array(),
        'accept_file_types' => '/\.(gif|jpe?g|png|ico)$/i'
    );
    ob_start();
    $upload = new UploadHandler($options);
    $response = ob_get_contents();
    ob_end_clean();
    die($response);
}

function plsh_output_theme_setting($option) {
	 
    if(!empty($option['value']))
    {
        $value = $option['value'];
    }
    else
    {
        $value = plsh_gs($option['slug']);
    }    
    
	$value = stripslashes($value);
    
    
    
	$depend_class = $display_class = '';
	if(!empty($option['dependant'])) 	//if this option is dependant of other option
	{		
		$dep_slug = $option['dependant'];
		$depend_class = "depend_".$dep_slug;
		$display_class = 'depend_hide';
				
		if(plsh_gs($dep_slug)) 
		{
			if(plsh_gs($dep_slug) == 'on')
			{
				$display_class = '';
			}
		}
		/* WTF?! 
		elseif(isset($option_group->$dep_slug->value)) {
			if($option_group->$dep_slug->value != 'on') {
				$display_class = 'depend_hide';
			}
			
		}*/
		
	}
	
	$return = '<div class="form-item clearfix ' . $depend_class . ' ' . $display_class. '">';
    
    $description = '';
    if(!empty($option['description']))
    {
        $description = '<span class="tooltip-1"><i>' . $option['description'] . '</i></span>';
    }
	
	 if($option['type'] == "textbox") {
	 	
        $return.= '<p class="label">' . $option['title'] . ' ' . $description . '</p>';
        
        if(!empty($option['warning']))
        {
            $return.= '<div class="row-wrapper-2">';
            $return.= '      <div class="row">';
            $return.= '          <input name="' . $option['slug'] . '" value="' . $value . '" type="text" />';
            $return.= '      </div>';
            $return.= '     <div class="row">';
            $return.= '         <div class="info-message-1">' . $option['warning'] . '</div>';
            $return.= '     </div>';
            $return.= '</div>';
        }
        else
        {
            $return.= '<input name="' . $option['slug'] . '" value="' . $value . '" type="text" />';
        }        
        
	 }
	  elseif($option['type'] == "textarea") {
          
		$return.= '<p class="label">' . $option['title'] . ' ' . $description . '</p>';
        
        if(!empty($option['warning']))
        {
            $return.= '<div class="row-wrapper-2">';
            $return.= '      <div class="row">';
            $return.= '          <textarea name="' . $option['slug'] . '" $value>' . $value . '</textarea>';
            $return.= '      </div>';
            $return.= '     <div class="row">';
            $return.= '         <div class="info-message-1">' . $option['warning'] . '</div>';
            $return.= '     </div>';
            $return.= '</div>';
        }
        else
        {
            $return.= '<textarea name="' . $option['slug'] . '">' . $value . '</textarea>';
        }
	 }
	 elseif($option['type'] == "checkbox") {
	
        $return.= '<p class="label">' . $option['title'] . ' ' . $description . '</p>';
        $return.= '<input name="' . $option['slug'] . '" id="' . $option['slug'] . '" type="checkbox" class="styled"';
        if($value == 'on') { $return.= ' checked="checked"'; }
		$return.= ' />'; 
		
		//$return.= '<div class="description"><label for="'.$option['slug'].'">';
		//$return.= $option['description'];
		//$return.= '</label></div>';
	
	 }
     elseif($option['type'] == "switcher") {
	
        $return.= '<p class="label">' . $option['title'] . ' ' . $description . '</p>';
		
        if(!empty($option['warning']))
        {
            $return.= '<div class="row-wrapper-2">';
            $return.= '      <div class="row">';
            $return.= '     <label class="switch-wrapper"><input name="' . $option['slug'] . '" id="' . $option['slug'] . '" type="checkbox" class="switch"';
            if($value == 'on') { $return.= ' checked="checked"'; }
            $return.= '     /></label>';           
            $return.= '      </div>';
            $return.= '     <div class="row">';
            $return.= '         <div class="info-message-1">' . $option['warning'] . '</div>';
            $return.= '     </div>';
            $return.= '</div>';
        }
        else
        {
            $return.= '<label class="switch-wrapper"><input name="' . $option['slug'] . '" id="' . $option['slug'] . '" type="checkbox" class="switch"';
            if($value == 'on') { $return.= ' checked="checked"'; }
            $return.= ' /></label>'; 
        }       
        
	
	 }
	 elseif($option['type'] == "select") {
	
        $return.= '<p class="label">' . $option['title'] . ' ' . $description . '</p>';
        
		$return.= '<select name="'.$option['slug'].'" class="default" style="width: 347px;">';
		
		foreach($option['data'] as $key => $data) {
			$return.= '<option value="'. $key .'"';
			if($key == $value) { $return.= ' selected="selected"'; }
			$return.= '>' . $data . '</option>';
		}
		
		$return.= '</select>';
		
		//$return.= $option['description'];

	
	 }
	 elseif($option['type'] == "fileupload") {
	
        $return.= '<p class="label">' . $option['title'] . ' ' . $description . '</p>';
        $return.= '<input type="file" name="' .  $option['slug'] . '_file" class="styled fileupload" />';
        $return.= '<input type="hidden" id="' .  $option['slug'] . '_file" name="' .  $option['slug'] . '" value="' . $value . '" class="styled fileupload" />';
        $return.= '<p class="filename">';
        if($value)
        {
            $filename = explode('/', $value);
            $return.= ' <a href="' . $value . '" target="_blank">' . urldecode($filename[count($filename) - 1]) . '</a>';
        }
        $return.='</p>';
	 }
	 	 
	$return.= '</div>'; 
 	//$return.= '</div>';
 	
 	echo $return;
 }

?>