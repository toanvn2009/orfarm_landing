/* Theme Megamenu JS */

(function($) {
	'use strict';
	$(document).ready(function(){
			//megamenu 
			$('#mega_main_menu_ul .menu-item').each(function(event ){
			   var popup   = $(this).find('.sub-menu');
			   var popupWidth = popup.outerWidth(true); 
			   var popupOffset = popup.offset();
			   var mainWidth = $('.header-container').width(); 
			   var viewWidth = $('.header .container').first().width();
			   if (viewWidth === undefined) { var viewWidth = 1650; }
			   var leftPopup;
			   if (!popupWidth || !popupOffset) {
			       return;
			   }
			   var typeSub = $(this).find('.sub-menu').data('type');
			   var widthSub = $(this).find('.sub-menu').data('width');
			   if ($(popup).hasClass( 'fullwidth' )) {
				   
				   if (popupOffset.left + popupWidth >= mainWidth) {
				       leftPopup = popupOffset.left + popupWidth - mainWidth;
					   $(this).find('.sub-menu').css('left',-leftPopup);
					}
			   } else if ($(popup).hasClass( 'default' )) {
			
				  var containerOffsetWidth = (mainWidth - viewWidth) / 2;
				  var popupOffsetLeft = popupOffset.left -containerOffsetWidth;
		
				  if (popupOffsetLeft + popupWidth >= viewWidth) {
						leftPopup = popupOffsetLeft + popupWidth - viewWidth;
						$(this).find('.sub-menu').css('left',-leftPopup);
					}
			   } else if (typeSub=='width') {
				   
				  $(this).find('.sub-menu').css('width',widthSub);
				  var containerOffsetWidth = (mainWidth - viewWidth) / 2;
				  var popupOffsetLeft = popupOffset.left -containerOffsetWidth;
					  popupWidth = popup.outerWidth(true);
				  if (popupOffsetLeft + popupWidth >= viewWidth) {
						leftPopup = popupOffsetLeft + popupWidth - viewWidth;
						$(this).find('.sub-menu').css('left',-leftPopup);
					}
			   }
	
			});
			//dropdown menu
			$('#menu-main-menu .menu-item').each(function(event ){
			   var typeSub = $(this).find('.sub-menu').data('type');
			   var widthSub = $(this).find('.sub-menu').data('width');
			   if(typeSub=='width'){
				    $(this).find('.sub-menu').css('width',widthSub);
			   }
			   
			});
			
			//mobile menu 
		    $(document).on('click',	'.mobile-menu li.dropdown .toggle-submenu',	function() {
			    if ($(this).parent().siblings('.opening').length) {
					var old_open = $(this).parent().siblings('.opening');
					old_open.children('ul').stop().slideUp(200);
					old_open.children('.toggle-submenu').children('.icon').removeClass('icon-chevron-up icons').addClass('icon-chevron-down icons');
					old_open.removeClass('opening');
				}
				if ($(this).parent().hasClass('opening')) {
					$(this).parent().removeClass('opening').children('ul').stop().slideUp(200);
					$(this).parent().children('.toggle-submenu').children('.icon').removeClass('icon-chevron-up icons').addClass('icon-chevron-down icons');
				} else {
					$(this).parent().addClass('opening').children('ul').stop().slideDown(200);
					$(this).parent().children('.toggle-submenu').children('.icon').removeClass('icon-chevron-down icons').addClass('icon-chevron-up icons');
				}
			}
		);
	});
})(jQuery);