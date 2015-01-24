(function(jQuery){
    jQuery(document).ready(function(){		//when DOM is ready
        pandora.init();
    });
	jQuery(window).resize(function() {
		pandora.resizeHomepageSlider();
		pandora.adjustCollectionItemHeight();
		pandora.adjustFooterPadding();
		pandora.adjustSliderNavPos();
	});
})(jQuery);

var pandora = {
    quickshopCache: null,
	init: function() {
		this.initScrollTop();
		this.initFormElements();
        this.initSubmitSelector();
		this.adjustFooterPadding();
		this.initUserAuthMenu();
		this.initHomepageSlider();
		this.adjustSliderNavPos();
		this.adjustCollectionItemHeight();
		this.initNavigationSelector();
		this.initSingleProductImageSlider();
        this.initSingleProductImageVariants();
        this.initProductZoom();
		this.initProductLightbox();
		this.initCart();
		this.initQuickShop();
		this.initAccountLogin();
		this.initAddressManage();
        this.initCheckout();
        this.initReviewForm();
        this.initPageNavAlign();
	},
	initScrollTop: function() {
		jQuery('.back-to-the-top').click(function () {
			jQuery('body,html').animate({
				scrollTop: 0
			}, 400);
			return false;
		});
	},
	initFormElements: function() {
		if(jQuery("select:not(.no-uniform, #billing_country,  #shipping_country,  #billing_state_field select, #shipping_state_field select)").length > 0) {
            jQuery("select:not(.no-uniform, #billing_country, #shipping_country, #billing_state_field select, #shipping_state_field select)").uniform();
		}
        
		jQuery('._product-purchase-btn').click(function() {
			if(jQuery(this).attr('disabled') != 'disabled')
			{
				var productId = jQuery(this).parents('.item-info').attr('id');
				productId = productId.match(/\d+/g);
				jQuery('#product-actions-' + productId).submit();
			}
			return false;
		});
        
		jQuery('.form-submit-btn').click(function(){
			jQuery(this).parents('form').submit();
		});
	},
	customFormElements: function(selector) {
		jQuery(selector).uniform();
	},
	initNavigationSelector: function() {
		var selector = jQuery('.navigationSelector');
		if(selector.length > 0)
		{
			selector.change(function(){
				window.location = jQuery('option:selected', jQuery(this)).attr('value');
			});
		}
	},
    initSubmitSelector: function() {
        var selector = jQuery('.submit_selector');
		if(selector.length > 0)
		{
            selector.change(function(){
				jQuery(this).parents('form').submit();
			});
		}
    },        
	adjustFooterPadding: function() {        
        jQuery('.main-footer-wrapper').removeClass('fixed');
        if(jQuery(window).height() == jQuery('.main-body-wrapper').height())
        {
            if(!jQuery('body').hasClass('woocommerce-checkout'))
            {
                jQuery('.main-footer-wrapper').addClass('fixed');
            }
        }
	},
	initUserAuthMenu: function() {
		jQuery('.main-header .menu .account').not('._logged-in').click(function(){
			if(jQuery('._user_auth').is(':visible'))
			{
				jQuery('._user_auth .password').css('visibility', 'hidden');	//hack to prevent "forget" from showing while runnin slideup animation
				jQuery('._user_auth').slideUp(500, function(){
					jQuery('._user_auth .password').css('visibility', 'visible');
				});
			}
			else
			{
				jQuery('._user_auth').slideDown(500);
			}
			return false;
		});
	},
	initHomepageSlider: function() {        
        if(plsh_settings.enable_slider_auto_advance === 'on')
        {
            var timeout = plsh_settings.slider_advance_delay;
        }
        else
        {
            var timeout = 0;
        }
        
		jQuery('#hompage-slider_content').cycle({
			fx: plsh_settings.slider_animation,
            sync: true,
			speed: plsh_settings.slider_animation_speed,
			timeout: timeout,
			prev:   '.previous', 
			next:   '.next',
			pager: '#pager',
			activePagerClass: "active",
			easing: 'swing',
			slideResize: 0,
			containerResize: 1,
			slideExpr: '.item',
			pause: true,
			pagerAnchorBuilder: function(idx, slide) {  return ''; }
		});

        if(jQuery('#hompage-slider_content').children('.item').length <= 1)
        {
            jQuery('#hompage-slider_content .blank-item').hide();
            jQuery('.homepage-slider .navigation').hide();
        }

		jQuery('#pager a').click(function(){
			var index = jQuery('#pager a').index(jQuery(this));
			jQuery('#hompage-slider_content').cycle(index);
			return false;
		});
		
		jQuery('#hompage-slider_content').touchwipe({
		    wipeLeft: function() { jQuery('#hompage-slider_content').cycle('next'); },
		    wipeRight: function() { jQuery('#hompage-slider_content').cycle('prev'); },
			wipeUp: function() { return false; },
			wipeDown: function() { return false; },
		    min_move_x: 20,
		    min_move_y: 20,
		    preventDefaultEvents: false
		});
	},
	adjustSliderNavPos: function() {
		var nav = jQuery('.main-slider nav');
		var nav_width = nav.outerWidth();
		var scr_width = jQuery(window).width();
		nav.css('left', (scr_width-nav_width)/2);
	},
	resizeHomepageSlider: function() {
		jQuery('#hompage-slider_content .item, #hompage-slider_content').width(jQuery('body').width());
	},
	getCurrentResponsiveType: function() {
		var window_w = jQuery(window).width();
		if(window_w > 767 && window_w < 959 ) {	//ipad
			type = 'tablet';
		} else if(window_w <= 767) {	//iphone
			type = 'mobile';
		} else {	//full
			type = 'pc';
		}
		return type;
	},
	adjustCollectionItemHeight: function() {
		var type = pandora.getCurrentResponsiveType();
        
        jQuery('.items').each(function(){
            var items = jQuery(this).children('._collection-item');
            if(items.length > 0)
            {	
                var columns = 4;	//normal
                if(type == 'tablet') { columns = 3; }	//tablet
                if(type == 'mobile') { columns = 2; }	//mobile
                pandora.resizeRowItemHeight(items, columns);
            }
        });
        
        jQuery('.homepage-column .items').each(function(){
            var items = jQuery(this).children('.item-block-1');
            if(items.length > 0)
            {	
                pandora.resizeRowItemHeight(items, 2);
            }
        });
	},
	resizeRowItemHeight: function(items, columns) {
		var chunks = chunk(items, columns);
		
		for(var row in chunks)
		{
			var maxHeight = Math.max.apply(null, chunks[row].map(function ()
			{
				var height = jQuery(this).find('.image-wrapper').innerHeight() + jQuery(this).find('h2').innerHeight() + jQuery(this).find('.price').innerHeight();
				return height + 8;
			}).get());
			chunks[row].height(maxHeight);
		}
	},
	initSingleProductImageSlider: function() {
						
		jQuery('#_single-product-slider').cycle({
			fx: 'scrollHorz',
			speed: '600',
			timeout: 0,
			easing: 'swing',
			slideResize: 0,
			containerResize: 1,
			slideExpr: '.image'
		});

		var navBtns = jQuery('.main-item .thumbnails ul a');
		navBtns.click(function(){
			var index = navBtns.index(jQuery(this));
			navBtns.removeClass('active');
			jQuery(this).addClass('active');
			pandora.slideChanged = false;
			jQuery('#_single-product-slider').cycle(index);
			return false;
		});
		
        jQuery('.main-item .thumbnails ul').jcarousel();  
			
	},
    initProductZoom: function() {
        if(jQuery('.single-product').length > 0 && plsh_settings.enable_product_image_zoom === 'on' && pandora.getCurrentResponsiveType() === 'pc')
		{
			var images = jQuery('.main-item .image a');
			jQuery.each(images, function(key, value){
				var image = jQuery(this).children('img');
				jQuery(this).zoom({
					url: value.href 
				});
			})
		}
	},
    initSingleProductImageVariants: function() {
        
        jQuery('input[name=variation_id]').change(function(){
            var variation = jQuery('input[name=variation_id]').val();
            if(variation !== false)
            {
                var image = jQuery('#image-' + variation);
                var index = jQuery('#_single-product-slider .image').index(image);
                if(index >= 0)
                {
                    jQuery('#_single-product-slider').cycle(index);
                }
            }
        });
        
    },
	initQuickShopImageSlider: function() {
						
		jQuery('#_single-product-slider').cycle({
			fx: 'scrollHorz',
			speed: '600',
			timeout: 0,
			easing: 'swing',
			slideResize: 0,
			containerResize: 1,
			slideExpr: '.image'
		});

        var navBtns = jQuery('.quick-shop .thumbnails ul a');
		navBtns.click(function(){
			var index = navBtns.index(jQuery(this));
			navBtns.removeClass('active');
			jQuery(this).addClass('active');
			pandora.slideChanged = false;
			jQuery('#_single-product-slider').cycle(index);
			return false;
		});
		
        jQuery('.quick-shop .thumbnails ul').jcarousel();  
			
	},
	initCart: function() {
		jQuery('#cart_submit').click(function(){
			jQuery('.__checkout-btn').trigger('click');
			return false;
		});
		
		jQuery('#cart_update').click(function(){
			jQuery('.__update-btn').trigger('click');
			return false;
		});
		
		
		// + 1 quantity
		jQuery('.main-cart .quantity .more').click(function(){
			var quantity = jQuery(this).siblings('input[type=text]');
			var newQuantity = parseInt(quantity.val()) + 1;
            var max = quantity.attr('max');
            if(max === '') max = 9999;
            
            if(newQuantity <= max)
            {
                quantity.val(newQuantity);
            }
			
			return false;
		});
		
		// - 1 quantity
		jQuery('.main-cart .quantity .less').click(function(){
			var quantity = jQuery(this).siblings('input[type=text]');
			var oldQuantity = parseInt(quantity.val());
            var min = quantity.attr('min');
            if(min === '') min = 1;
            var newQuantity = oldQuantity - 1;
			if(newQuantity > 0 && (newQuantity >= min ))
			{
				quantity.val(newQuantity);
			}
			return false;
		});
		
		//allow only numbers to be entered in quantity box
		jQuery('.main-cart .quantity input[type=text]').keydown(function(event) {
	        // Allow: backspace, delete, tab and escape
	        if ( event.keyCode == 46 || event.keyCode == 8 || event.keyCode == 9 || event.keyCode == 27
		 		|| 
	            (event.keyCode == 65 && event.ctrlKey === true) 
				|| 
	            (event.keyCode >= 35 && event.keyCode <= 39)) {
	                 return;
	        }

	        // Ensure that it is a number and stop the keypress
	        if ((event.keyCode < 48 || event.keyCode > 57) && (event.keyCode < 96 || event.keyCode > 105 )) {
	            event.preventDefault(); 
	        }   
		});
	},
	initQuickShop: function() {		
		jQuery('.quickshop').click(function(){
            
            var productId = jQuery(this).attr('id');
            
            var data = {
                action: 'quickshop',
                product: productId
            };

            jQuery.post(ajax_object.ajaxurl, data, function(response) {
                
                jQuery('body').append(response);
                jQuery('.lightbox').fadeIn(350);	//IE does not allow to fadein transparent stuff
                jQuery('.quick-shop').fadeIn(350, pandora.adjustQuickShopPopupPosition());
                jQuery('.quick-shop .content select').uniform();
                pandora.initQuickShopImageSlider();
                pandora.initQuickShopAjaxSubmit();
                pandora.initProductLightbox();
                pandora.initSingleProductImageVariants();
            });
			
			return false;
		});
        
		jQuery('.lightbox, .close').live('click', function(){
			pandora.closeQuickShopPopup();
			return false;
		});
		
		jQuery(window).resize(function(){
			pandora.adjustQuickShopPopupPosition();
		});
	},
    initQuickShopAjaxSubmit: function() {
        
        //remove previous events
        jQuery(document).off('submit', 'form.quickshop-form');
        
        jQuery(document).on('submit', 'form.quickshop-form', function(e) {
            e.preventDefault();
            var data = jQuery(this).serialize();
            var action = jQuery(this).attr('action');
            
            jQuery('.ajax-form-submited-wrap').fadeIn(500);
            jQuery('.ajax-form-submited-wrap .ajax-form-submited-success').hide();
            
            jQuery.post(action, data, function(response) {
                jQuery('.ajax-form-submited-wrap .ajax-form-loader').hide();
                jQuery('.ajax-form-submited-wrap .ajax-form-submited-success').show();        
                
                jQuery('.ajax-form-submited-wrap').delay(3000).fadeOut(500, function(){
                    jQuery('.ajax-form-submited-wrap .ajax-form-loader').attr('style', '');
                    jQuery('.ajax-form-submited-wrap .ajax-form-submited-success').attr('style', '');
                });
                
                var data = {
                    action: 'get_cart'
                };

                jQuery.post(ajax_object.ajaxurl, data, function(response) {
                    jQuery('.menu .cart').html(response);
                });
                
            });
            
            return false;
        });
    },
	adjustQuickShopPopupPosition: function() {
		
        var left = (jQuery(window).width() - jQuery('.quick-shop').outerWidth())/2;
        var top = (jQuery(window).height() - jQuery('.quick-shop').outerHeight())/2;
        
        //prevent the close button from being invisible and window start of going off page in case or large quickshop
        if(left < 20) left = 20;
        if(top < 20) top = 20;
        
        jQuery('.quick-shop').css({
			position: 'fixed',
			left: left,
			top: top
		});	
        
        jQuery('.quick-shop > img').css({
			"max-height": jQuery(window).height() - 40,
		});
        
        if(pandora.getCurrentResponsiveType() === 'mobile')
        {
            jQuery('.quick-shop > img').css({
                "max-width": jQuery(window).width() - 40,
            });
        }
        
	},
	closeQuickShopPopup: function() {

        if(pandora.quickshopCache !== null)
		{
			jQuery('.quick-shop').html(pandora.quickshopCache);
			pandora.quickshopCache = null;
            pandora.initProductLightbox();
			pandora.adjustQuickShopPopupPosition();
		}
		else
		{
            jQuery('.quick-shop').fadeOut(350);			//close popup
            jQuery('.lightbox').hide();

            jQuery('.quick-shop').remove();
            jQuery('.lightbox').remove();
		}
        
        jQuery('.lightbox, .close, .quick-shop > img').die();
	},
	initProductLightbox: function() {

        jQuery('.lightbox, .close, .quick-shop > img').die();

		jQuery('.lightbox-launcher').click(function(){
			
			var elem = jQuery(this);
			var imgSrc = elem.attr('href');
			            
            if(jQuery('.quick-shop').is(':visible')) //if quick shop is already open
			{
				pandora.quickshopCache = jQuery('.quick-shop').html();
                jQuery('.quick-shop').html('');
			}
            else
            {
                var quickshop = '<div class="quick-shop clearfix">\n\
                    <a href="#" class="close"></a>\n\
                </div>';
                jQuery('body').append('<div class="lightbox"></div>');
                jQuery('body').append(quickshop);
            }
            
            jQuery('.lightbox, .close, .quick-shop > img').live('click', function(){
                pandora.closeQuickShopPopup();
                return false;
            });
            
			var productImage = new Image();
			productImage.onload = function() {
				jQuery('.quick-shop').append(productImage);
				pandora.adjustQuickShopPopupPosition();
                
                jQuery('.lightbox').fadeIn(350);
                
				jQuery('.quick-shop').fadeIn(350, function(){
					pandora.adjustQuickShopPopupPosition();
				});
			};
			productImage.src = imgSrc;
			
			return false;
		});
		
		jQuery(window).resize(function(){
			pandora.adjustQuickShopPopupPosition();
		});
	},
	initAccountLogin: function() {

		if (window.location.hash == '#recover') {
			jQuery('#login_form').hide();
			jQuery('#password_recovery').show();
		}
		
		jQuery('#forgot_password').click(function() {
			jQuery('#login_form').fadeOut(200, function(){
				jQuery('#password_recovery').fadeIn(200);
			});
			return false;
		});
	
		jQuery('#login').click(function() {
			jQuery('#password_recovery').fadeOut(200, function(){
				jQuery('#login_form').fadeIn(200);
			});
			return false;
		});
	
		jQuery('#login_submit').click(function() {
			jQuery('#customer_login').submit();
			return false;
		});
	
		jQuery('#recover_submit').click(function() {
			jQuery(this).parents('form').submit();
			return false;
		});
	},
	initAddressManage: function() {

		jQuery('.edit-address-btn').click(function(){
			var editForm = 'edit_' + jQuery(this).parents('.row').attr('id');				
			jQuery('#' + editForm ).slideDown(300);
			return false;
		});
		
		jQuery('.address-edit-form-cancel').click(function(){
			jQuery(this).parents('.address-edit-form').slideUp(300);
			return false;
		});
	},
    initCheckout: function() {
        
        pandora.checkoutShippingToggle();
        
        jQuery('#shiptobilling input[type=checkbox]').change(function(){
            pandora.checkoutShippingToggle();
        });
        
        jQuery('.checkout-step').first().fadeIn(500);
        jQuery('form.checkout').addClass('step-1');
        
        jQuery('.checkout').on('click', '.next-step a.button-1', function() {
            var step = jQuery(this).parents('.checkout-step');
            
            var no = parseInt(jQuery('.checkout-step-no').html());
            
            jQuery("body").animate({ scrollTop: 0 }, 200, function() {
                step.fadeOut(500, function() {
                    jQuery('.checkout-step:eq(' + no + ')').fadeIn(500);
                    jQuery('.checkout-step-no').html(++no);
                    jQuery('form.checkout').removeClass('step-1 step-2 step-3');
                    jQuery('form.checkout').addClass('step-' + no);
                    jQuery('#order_review .blockOverlay').hide();
                }); 
            });
            
            return false;
        });
        
        jQuery('.checkout').on('click', 'input[name=payment_method]', function() {
            var value = jQuery(this).val();
            jQuery('.payment_methods .payment_box').hide();
            jQuery('.payment_methods .payment_method_' + value).show(); 
        });
        
        jQuery('form[name=checkout]').on('submit', function(){
            jQuery('.checkout-step').fadeOut(500, function(){
                jQuery('form.checkout').removeClass('step-1 step-2 step-3');
                jQuery('.checkout-step').first().fadeIn(500);
                jQuery('.checkout-step-no').html(1);
                jQuery('form.checkout').addClass('step-1');
            });
        });
        
        if(jQuery('.checkout-thankyou').length > 0 || jQuery('.next-step').length === 0)
        {
            jQuery('.checkout-step-title').hide();
        }
        
    },
    checkoutShippingToggle: function() {
        if(jQuery('#shiptobilling input[type=checkbox]').is(':checked')) {
            jQuery('.same-as-billing').hide();
            jQuery('.shipping_address').show();
            
        } else {
            jQuery('.same-as-billing').show();
            jQuery('.shipping_address').hide();
        }
    },
    initReviewForm: function() {
        jQuery('#review_form_launcher').click(function(){
            jQuery(this).fadeOut(function(){
                jQuery('#review_form_wrapper').slideDown(500, function(){
                    var stars = jQuery('.stars a');

                    stars.hover(
                    function(){
                        var index = stars.index(jQuery(this));

                        for(var i = 0; i<=index; i++)
                        {
                            stars.eq(i).addClass('selected');
                            stars.eq(i).addClass('hovered');
                        }
                    }, function(){
                        jQuery('.hovered').not('.locked').removeClass('selected').removeClass('temp');
                    });

                    stars.click(function(){
                        stars.removeClass('selected');
                        stars.removeClass('locked');
                        var index = stars.index(jQuery(this));
                        for(var i = 0; i<=index; i++)
                        {
                            stars.eq(i).addClass('selected');
                            stars.eq(i).addClass('locked');
                        }
                    });
                });
            });
            
            return false;
        });
    },
    initPageNavAlign: function() {
        var count = jQuery('.post-pages a').length;
        
        if(count === 1)
        {
            var item = jQuery('.post-pages a').eq(0);
            if(item.html().indexOf('Next') > 0)
            {
                item.addClass('next');
            }
            if(item.html().indexOf('Prev') > 0)
            {
                item.addClass('prev');
            }
        }
    }
}

function chunk (arr, len) {

  var chunks = [],
      i = 0,
      n = arr.length;

  while (i < n) {
    chunks.push(arr.slice(i, i += len));
  }

  return chunks;
}