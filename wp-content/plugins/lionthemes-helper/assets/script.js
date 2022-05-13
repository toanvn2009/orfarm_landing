(function($) {
	"use strict";
	// Create by Nguyen Duc Viet
	
	$(document).ready(function(){
		$(document).on('click', '.categories-tabs-widget .category-tab-actions li a', function(){
			var tabs = $(this).closest('.category-tab-actions').children('li').size();
			var me = $(this).parent().index();
			var current = $(this).closest('.category-tab-actions').children('li.active').index();
			var main_el = $(this).closest('.categories-tabs-widget');
			var tab_el = $(this).closest('.category-tab-actions').children('li');
			var tab_me = $(this).parent();
			var content_el = main_el.children('.category-tab-contents').children('.category-tab-content');
			if(!$(this).parent().hasClass('active')){
				content_el.eq(current).stop().fadeOut(200, function(){
					$(this).removeClass('active');
					tab_el.eq(current).removeClass('active');
					content_el.eq(me).stop().fadeIn(200, function(){
						$(this).addClass('active');
						tab_el.eq(me).addClass('active');
						//main_el.children('.category-tab-contents').css('min-height', $(this).outerHeight() + 'px');
						if(!content_el.eq(me).find('.animated').length){
							var currentP = $(window).scrollTop();
							$('body, html').animate({'scrollTop': currentP+1}, 10);
						}
					});
				});
			}
		});
	});
})(jQuery);
