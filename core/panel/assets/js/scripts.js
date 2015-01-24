jQuery(window).resize(function() {
    resize_panel();
});
    
jQuery(document).ready(function(){
       
    jQuery(window).keypress(function(event) {
        if (!( String.fromCharCode(event.which).toLowerCase() === 's' && event.ctrlKey)) return true;
        
        alert("Ctrl-S pressed");
        event.preventDefault();
        return false;
    });
    
    //prevent submit of forms
    jQuery('.no-submit').submit(function(){
        return false;
    })
    
    var switches = document.querySelectorAll('input[type="checkbox"].switch');
    for (var i=0, sw; sw = switches[i++]; ) 
    {
        var div = document.createElement('div');
        div.className = 'switch';
        sw.parentNode.insertBefore(div, sw.nextSibling);
    }
    
    jQuery('input[type=checkbox]').change(function()
	{
		var thisCheck = jQuery(this);
		var id = jQuery(this).attr('id');
		var depend = 'depend_' + id;
		
		if (thisCheck.is(':checked')) {
			jQuery('.' + depend).fadeIn('fast');
		} else {
			jQuery('.' + depend).fadeOut('fast');
		}
	});
    
    jQuery(function(){
        jQuery('.default').dropkick();
    });
    
    jQuery(function(){
        jQuery('.styled').uniform();
    });
    
    jQuery(function () {
        'use strict';
        jQuery('.fileupload').fileupload({
            dataType: 'json',
            add: function(e, data) {
                var field = jQuery(this).attr('name')
                data.url = global_image_url + '&field=' + field;
                var jqXHR = data.submit()
                .success(function (result, textStatus, jqXHR) {
                    var responseObj =  jQuery.parseJSON( jqXHR.responseText );
                    var response = responseObj[Object.keys(responseObj)[0]];
                    if(typeof response[0].error !== "undefined")
                    {
                        show_save_result({status: 'fail', msg: 'Image upload failed'});
                    }
                    else
                    {
                        var url = response[0].url;
                        var valueField = jQuery('#' + field);
                        valueField.val(url);
                        var filename = valueField.parents('.form-item').children('.filename');
                        if(filename.length > 0)
                        {
                            filename.html(''); //remove current content
                        }

                        var name_parts = url.split('/');
                        var name = name_parts[name_parts.length - 1];
                        
                        filename.html('<a href="' + url + '" target="_blank">' + decodeURIComponent(name) +'</a>');
                    }
                    
                })
                .error(function (jqXHR, textStatus, errorThrown) {
                    show_save_result({status: 'fail', msg: 'Image upload failed'});
                })
            },
        });
    });
    
    resize_panel();
        
});

function resize_panel()
{
    var w_h = jQuery(window).height();
    var p_h = jQuery('.main-control-panel-wrapper').height();
    var p_w = jQuery('.main-content-wrapper').width();
    if(w_h > p_h)
    {
        jQuery('.main-control-panel-wrapper').css('height', w_h - 210);
        jQuery('.support-iframe').css('height', w_h - 210);  
    }
    jQuery('.support-iframe').css('width', p_w);  
    
}

function show_save_result(msg)
{
    if(msg.status === 'ok')
    {
        var element = jQuery('.save-message-1'); 
    }
    else
    {
        var element = jQuery('.error-message-1'); 
    }
    
    element.children('span').eq(0).html(msg.msg);
    
    jQuery('body,html').animate({
        scrollTop: 0
    }, 400, 'swing', function(){
        
        element.slideDown(500);
    
        var timeout = setTimeout(hide_save_result, 5000);

        element.children('.close').click(function() {
            window.clearTimeout(timeout);
            hide_save_result();
            return false;
        });
    });
    
}

function hide_save_result()
{
    jQuery('.save-message-1, .error-message-1').slideUp(500);
}

function add_sidebar_option()
{
    //get last item from sidebar list
    var item = jQuery('.sidebar-list li').last();
    var id = item.children('a').attr('id'); 
    var name = item.children('span').text();
    
    //add the item to select boxes    
    jQuery('#manage_sidebars select')
        .append(jQuery("<option></option>")
        .attr("value",id)
        .text(name));
    
    jQuery('.dk_options_inner')
        .append(jQuery('<li><a data-dk-dropdown-value="' + id + '">' + name + '</a></li>'));
    
    jQuery('.default').dropkick('reset');
    
}

function remove_sidebar_option(id)
{
    //remove item from select boxes
    jQuery('#manage_sidebars select option[value=' + id + ']').remove();
    jQuery('.dk_options_inner a[data-dk-dropdown-value=' + id + ']').remove();
    jQuery('.default').dropkick('reset');
}