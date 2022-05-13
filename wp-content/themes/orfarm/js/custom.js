/* Theme Customize JS */

(function($) {
	'use strict';
	// Create by Nguyen Duc Viet

	// search toggle
	$(document).on('click', '.search-opener', function() {
		$(this).closest('.search-switcher').toggleClass('showing');
	});
	$(document).on('click', '.close-popup, .popup-overlay', function() {
		$(this).closest('.search-switcher').removeClass('showing');
	});
	$(document).on('click', '.search-content-popup li.cat-item a', function() {
		var slug = $(this).data('slug');
		$(this).parent().siblings('.selected').removeClass('selected');
		$(this).parent().addClass('selected'); 
		$(this).closest('.categories-list').find('input[type="hidden"]').val(slug);
	});

	$(document).on('click', '.lock-icon', function() {
		$(this).closest('.header-login-form').children('.acc-form').stop().slideToggle(400);
	});

	//Category view mode
	$(document).on('click', '.view-mode1 > a', function() {
		if (!$(this).hasClass('active')) {
			var current_class = $(this).siblings('.active').data('mode');
			var new_class = $(this).data('mode');
			$(this).addClass('active').siblings('.active').removeClass('active');
			$('#archive-product .shop-products').removeClass(current_class);
			$('#archive-product .shop-products').addClass(new_class);
		}
	});

	//quickview button
	$(document).on('click', 'a.quickview', function(event) {
		event.preventDefault();
		var productID = $(this).attr('data-quick-id');
		showQuickView(productID);
	});

	$(document).on('click', '.closeqv', function() {
		hideQuickView();
	});

	//categories accordion both products & posts
	$(document).on('click', '.widget ul li.cat-item > i.opener', function() {
		var el = $(this).parent();
		if (el.hasClass('opening')) {
			el.removeClass('opening').children('ul').stop().slideUp(300);
			$(this).removeClass('icon-chevron-up icons').addClass('icon-chevron-down icons');
		} else {
			$(this).removeClass('icon-chevron-down icons').addClass('icon-chevron-up icons');
			el.siblings('.opening').find('i.opener').removeClass('icon-chevron-up icons').addClass('icon-chevron-down icons');
			el.siblings('.opening').removeClass('opening').children('ul').stop().slideUp(300);
			el.addClass('opening').children('ul').slideDown(300);
		}
	});
	$(document).on('click', '.catmenu-opener', function() {
		$(this).parent().toggleClass('opening');
	});

	//Go to top
	$(document).on('click', '#back-top', function() {
		$('html, body').animate({ scrollTop: 0 }, 'slow');
		
	});
	
	var scrolled_back = false;
	 $(window).scroll(function () { 
		var screenWidth = $(window).width();
		var currentTop = $(this).scrollTop();
		if($('#back-top').length > 0 && screenWidth >= 768){
			
			if (currentTop > 400 && !scrolled_back) {
				$('#back-top').show();
				scrolled_back = true;
			}
	
			if (currentTop <= 400) {
				$('#back-top').hide();
				scrolled_back = false;
			}

		}
	 })	


	$(document).on('click', '.vc_tta-tabs-list > li', function() {
		var currentP = $(window).scrollTop();
		$('body, html').animate({ scrollTop: currentP + 1 }, 10);
	});

	$(document).on('click', '.filter-options .btn', function() {
		$(this).siblings('.btn').removeClass('active');
		$(this).addClass('active');
		var filter = $(this).data('group');
		if (filter) {
			if (filter == 'all') {
				$('#projects_list .project').removeClass('hide');
			} else {
				$('#projects_list .project').each(function() {
					var my_group = $(this).data('groups');
					console.log(my_group);
					if (my_group.indexOf(filter) != -1) {
						$(this).removeClass('hide');
					} else {
						$(this).addClass('hide');
					}
				});
			}
		}
		$(window).resize();
	});

	$(document).on('change', 'select.vitual-style-el', function() {
		var my_val = $(this).children(':selected').text();
		$(this).parent().children('.vitual-style').text(my_val);
	});

	//toggle showmore menu
	$(document).on('click', '.showmore-menu .showmore-opener', function() {
		$(this).parent().toggleClass('opening');
	});
	$(document).on('click', '.showmore-menu .showmore-cats', function() {
		$(this).toggleClass('expanded');
		$(this).closest('.showmore-menu').toggleClass('all');
		$(this).closest('.showmore-menu').find('li.out-li').stop().slideToggle(300);
	});

	// ajax like a post
	$(document).on('click', 'a.orfarm_like_post', function(e) {
		var like_title;
		if ($(this).hasClass('liked')) {
			$(this).removeClass('liked');
			like_title = $(this).data('unliked_title');
		} else {
			$(this).addClass('liked');
			like_title = $(this).data('liked_title');
		}
		var post_id = $(this).data('post_id');
		var me = $(this);
		$.ajax({
			type: 'POST',
			dataType: 'json',
			url: ajaxurl,
			data: 'action=orfarm_update_like&post_id=' + post_id,
			success: function(data) {
				me.children('.number').text(data);
				me.parent('.likes-counter')
					.attr('title', '')
					.attr('data-original-title', like_title);
			},
		});
		e.preventDefault();
		return false;
	});

	//sidebar toggle for mobile
	$(document).on('click', '.sidebar-toggle', function() {
		$(this).parent().toggleClass('opening');
		$(this).siblings().slideToggle(400);
	});

	// mobile categories menu
	$(document).on('click', '.categories-menu li.menu-item-has-children > .opener, .categories-menu li.page_item_has_children > .opener', function() {
			if ($(this).parent().hasClass('opening')) {
				$(this).parent().removeClass('opening').children('ul').stop().slideUp(300);
			} else {
				$(this).parent().siblings('.opening').removeClass('opening').children('ul').stop().slideUp(300);
				$(this).parent().addClass('opening').children('ul').stop().slideDown(300);
			}
		},
	);

	// show all search results
	$(document).on('click', '.orfarm-autocomplete-search-results .last-total-result', function() {
		$(this).closest('form').submit();
	});
	$(document).on('click', 'body', function(e) {
		if (!$(e.target).closest('form').hasClass('woocommerce-product-search')) {
			$('.orfarm-autocomplete-search-results').hide();
		}
	});

	// close theme verify
	$(document).on('click', '#orfarm_missing_purchased_code .close', function() {
		$(this).parent().remove();
	});

	// Toggle filter
	$(document).on('click', '.shop-filters .toggle-filter', function() {
        $(this).parent().toggleClass('opening');
        if ($('.canvas-sidebar').length > 0 || $('.shop-filters-left-sidebar').length > 0) {
            $('#secondary').toggleClass('opened');
        } else {
		    $(this).siblings('.filter-content').stop().slideToggle(300);
        }
	});

    if($('.maincol-sidebar-shop-filters-v2').length > 0){
        $(document).on('click', '.shop-filters .widget-title', function() {
            $(this).closest('.widget').toggleClass('opened');
        });
    }
	
	// Hide cart side content 
	$(document).on('click', '.toggle-cartside', function() {
		$('.cart-side-content').toggleClass('opened');
	});
	
	// Hide sidebar on mobile 
	$(document).on('click', '#secondary .toggle-action', function() {
		$(this).closest('#secondary').toggleClass('opened');
	});
	
	// show / hide mobile menu
	$(document).on('click', 'header .toggle-menu, header .mobile-menu-overlay', function() {
		$('header .nav-menus').toggleClass('opened');
	});

})(jQuery);

function openTab(evt, tab_name) {
  var i, tabcontent, tablinks;
  tabcontent = document.getElementsByClassName("tabcontent");
  for (i = 0; i < tabcontent.length; i++) {
    tabcontent[i].style.display = "none";
  }
  tablinks = document.getElementsByClassName("tablinks");
  for (i = 0; i < tablinks.length; i++) {
    tablinks[i].className = tablinks[i].className.replace(" active", "");
  }
  document.getElementById(tab_name).style.display = "block";
  evt.currentTarget.className += " active";
}

jQuery(document).ready(function($) {
	$('.category-tab-content').removeAttr('style');
	$('.category-tab').click(function(){
			$(this).parent().parent().find('.category-tab-content').removeAttr('style');
	});
	// hide sticky 
	var offset = $('.header-container .header-sticky').outerHeight();
	
	offset = offset + 40;
	
	var prevScrollpos = window.pageYOffset;
	$(window).scroll(function () { 
		
		var screenWidth = $(window).width();
		
		if($('.header-container').hasClass('sticky') ){
			
			var currentScroll = $(window).scrollTop();
			var currentScrollPos = window.pageYOffset;
			
			if(prevScrollpos > currentScrollPos && currentScroll > offset ) {
				$(".header-container").addClass("sticky");
				$(".header-container").addClass('orfarm_scroll_up').removeClass('orfarm_scroll_down');
			} 
			else if(currentScroll <= offset ) {
				console.log(currentScroll);
				console.log(offset);
				$(".header-container").removeClass("sticky");
				$(".header-container").removeClass('orfarm_scroll_up orfarm_scroll_down');
			} 
			else{
				$(".header-container").addClass("sticky");
				$(".header-container").addClass('orfarm_scroll_down').removeClass('orfarm_scroll_up');
			}
			prevScrollpos = currentScrollPos;
		}
		
	});
	//show hide footer on mobile 

	var winWide = $(window).width();
	if (winWide <=767) {
	
		$('#footer-dropdown .footer-content').hide();
		$('#footer-dropdown .footer-title').click(function() {
			$(this).parent().find('.footer-content').toggle();
			
		});
		
		$('#footer-dropdown .elementor-widget-text-editor').hide();
		$('#footer-dropdown .elementor-widget-heading').click(function() {
			$(this).parent().find('.elementor-widget-text-editor').toggle();
			
		});
	} 
	// show all sub categories 
	$('.sub_hide').hide();
	$('.show_all').click(function() {
		$(this).parent().find('.sub_hide').show();
	});
	
   // login popup 
    $('.lost-pwlink').attr('href','#login-form-popup');
    $('.lost-pwlink').attr('id','login-inline');	
	$('#login-form-popup').hide();
	$('#register-form-popup').hide();
	$("a#login-inline").fancybox({
		'width': 700,
		'height':700,
		'transitionIn'	:	'elastic',
		'transitionOut'	:	'elastic',
		'speedIn'		:	700, 
		'speedOut'		:	700, 
		'overlayShow'	:	false,
		afterLoad: function() {

		}
	});


	// Logo To MeNu on Header 
	var _menu_items = $('.header-container.with-center-logo .nav-menus .nav-desktop ul > li');
	var _mega_menu_items = $('.header-container.with-center-logo .nav-menus .nav-desktop ul.mega_main_menu_ul > li');
	var _default_menu_items = $('.header-container.with-center-logo .nav-menus .nav-desktop ul.nav-menu > li');
	var _logo_img = $('.header-container.with-center-logo .header-logo .logo');
	if (_logo_img.size() && _menu_items.size()) {
		var _logo =	'<li class="menu-item logo d-none d-lg-inline-block">' + _logo_img.html() + '</li>';
		
		if (_mega_menu_items.size() ) {
			var _total_item = _mega_menu_items.size();
			var _insert_index = Math.floor(_total_item / 2) - 1;
			_mega_menu_items.eq(_insert_index).after(_logo);
		} else if (_default_menu_items.size()) {
			var _total_item = _default_menu_items.size();
			var _insert_index = Math.floor(_total_item / 2) - 1;
			_default_menu_items.eq(_insert_index).after(_logo);
		}
	}

    //post ajax fake order
    if($('#purchase-fake-order').length > 0){
        var show_number_seconds = parseInt($('#purchase-fake-order').attr('data-seconds-displayed'));
        var show_number_hide = parseInt($('#purchase-fake-order').attr('data-seconds-hide'));
        var url_fake = $('#purchase-fake-order').attr('data-url');
        var interval_fake_order = setInterval(getProductRandom, show_number_seconds*1000);
        $(document).on('click', '#purchase-fake-order .purchase-close', function(){
            clearInterval(interval_fake_order);
            $('#purchase-fake-order').removeClass('fadeInUp');
            $('#purchase-fake-order').addClass('fadeOutDown');
        });
        function getProductRandom(){
            if(!$('#purchase-fake-order').hasClass('fadeInUp')){
                $.ajax({
                    type: 'POST',
                    url: url_fake,
                    data: {
                        'action': 'fake_order_get_post_content'
                    }, success: function (result) {
                        if(result.html != ""){
                            $('#purchase-fake-order .product-purchase').html(result.html);
                            $('#purchase-fake-order').removeClass('fadeOutDown');
                            $('#purchase-fake-order').addClass('fadeInUp');
                            $('#purchase-fake-order').removeAttr("style");
                            setTimeout(function(){
                                $('#purchase-fake-order').removeClass('fadeInUp');
                                $('#purchase-fake-order').addClass('fadeOutDown');
                            }, show_number_hide*1000);
                        }
                    }
                });
            }
            else{
                $('#purchase-fake-order').removeClass('fadeInUp');
                $('#purchase-fake-order').addClass('fadeOutDown');
            }
        }
    }
	
	// set view for mobile & tablet
	updateShopView();
	// loading ajax
	$('body').append('<div id="loading"><div class="overlay-bg"><div class="lds-ripple"><div></div><div></div></div></div></div>'); 
	$(document).ajaxComplete(function(event, request, options) {
		
		// added to cart
		if (options.url.indexOf('wc-ajax=add_to_cart') != -1) {
			var title = $('a.added_to_cart').attr('title');
			$('a.added_to_cart').removeAttr('title').closest('p.add_to_cart_inline').attr('data-original-title', title);
			if ($('.cart-widget-content').size()) {
				$('.cart-widget-content').parent().addClass('opened');
			}
			if ($('.header-container .topcart .qty').size()) {
				var count = parseInt($('.header-container .topcart .qty').text());
				$('.header-container .topcart .qty').html(count + 1);
			}
		}
		if (options.data) {
			var params = JSON.parse('{"' + decodeURI(options.data).replace(/"/g, '\\"').replace(/&/g, '","').replace(/=/g, '":"') +	'"}');
			
			if ($('.quick-wishlist').size()) {
				var current_count = parseInt($('.quick-wishlist .badge').text());
				// remove_from_wishlist
				if (params && params.action && params.action == 'remove_from_wishlist') {
					var new_count = current_count > 0 ? current_count - 1 : 0;
					$('.quick-wishlist .badge').html(new_count);
				}
				// "add_to_wishlist"
				if (params && params.action && params.action == 'add_to_wishlist') {
					var new_count = current_count + 1;
					$('.quick-wishlist .badge').html(new_count);
				}
			}
			
			if ($('.header .wl-icon-wrapper').size()) {
				var current_count = parseInt($('.header .wl-icon-wrapper .qty-count').text());
				// remove_from_wishlist
				if (params && params.action && params.action == 'remove_from_wishlist') {
					var new_count = current_count > 0 ? current_count - 1 : 0;
					$('.header .wl-icon-wrapper .qty-count').html(new_count);
				}
				// "add_to_wishlist"
				if (params && params.action && params.action == 'add_to_wishlist') {
					var new_count = current_count + 1;
					$('.header .wl-icon-wrapper .qty-count').html(new_count);
				}
			}
			
			if ($('.quick-compare').size()) {
				// remove_from_compare
				if (params && params.action && params.action == 'yith-woocompare-reload-product') {
					if (request.responseText) {
						var list = jQuery(request.responseText);
						var counter = list.not('.list_empty').length;
						$('.quick-compare .badge').html(counter);
					}
				}
				// add_to_compare
				if (params && params.action && params.action == 'yith-woocompare-add-product') {
					var current_count = parseInt($('.quick-compare .badge').text());
					$('.quick-compare .badge').html(current_count + 1);
				}
			}
		}
		
		$('#loading').fadeOut(400);
	});
	$(document).ajaxSend(function(event, xhr, options) {
		if (options.url.indexOf('wc-ajax=add_to_cart') != -1) {
			$('#loading').show();
		}
		if (options.url.indexOf('wc-ajax=get_refreshed_fragments') != -1) {
			if ($('body').hasClass('fragments_refreshed')) {
				xhr.abort();
			} else {
				$('body').addClass('fragments_refreshed');
			}
		}
	});
	
	$(document).on('click', '.product-archive-colors a', function(){
		var src = $(this).data( "src" );
		var productid = $(this).data( "productid" );
		$(this).closest('.product-archive-colors').find('a').removeClass('active');
		$(this).addClass('active');
		$(this).closest('.post-'+productid).find('img').attr("src",src);
		$(this).closest('.post-'+productid).find('img').attr("srcset",src);
		return false;
	});

    stickyAddCart();

	//categories accordion auto open
	$('.widget ul li.cat-item').each(function () {
		if ($(this).children('ul').length) {
			if ($(this).children('.opener').length) {
				$(this).children('.opener').remove();
			}
			$(this).children('ul').hide();
			$(this).append('<i class="opener icon-chevron-down icons"></i>');
		}
	});
	$('.widget li.current-cat, .widget li.current-cat-parent').addClass('opening').children('ul').show();
	if ($('.widget li.current-cat').closest('li').length) {
		$('.widget li.current-cat').closest('li').addClass('opening').children('ul').show();
	}
	$('ul.woocommerce-widget-layered-nav-list').each(function () {
		if ($(this).find('span.variable-item-color').length) {
			$(this).addClass('color-variable-list');
		}
	});
	// init Animate Scroll
	if ($('body').hasClass('orfarm-animate-scroll') && !Modernizr.touch) {
		wow = new WOW({
			mobile: false,
		});
		wow.init();
	}

	// Scroll
	var currentP = 0;
	$(window).scroll(function() {
		var headerH = $('.header-container').height();
		var scrollP = $(window).scrollTop();
		if (scrollP != currentP) {
			if (scrollP >= headerH) {
				$('#back-top').addClass('show');
			} else {
				$('#back-top').removeClass('show');
			}

			currentP = $(window).scrollTop();
		}
		if (Modernizr.mq('(min-width: 992px)')) {
			if (scrollP > $(window).height()) {
				if ($('.header-container .categories-menu').hasClass('opening')	) {
					$('.header-container .categories-menu').removeClass('opening');
				}
			} else if ($('.header-container .categories-menu').hasClass('default-open')) {
				$('.header-container .categories-menu').addClass('opening');
			}
		}

		if (!Modernizr.mq('(max-width: 767px)') && $('.product-view.scroll-layout').length) {
			var _product = $('.product-view.scroll-layout');
			var _left = _product.find('.right-product-info').offset().left + 15;
			var _width = _product.find('.right-product-info').width();
			var _float = _product.find('.right-product-info .single-product-info');
			var _images = _product.find('.product-scroll-images');
			var _topStart = _product.offset().top;
			var _top = 10;
			if (scrollP > _topStart) {
				if ($('.header-container').hasClass('sticky')) {
					_top = _top + $('.header-container .header').height();
				}
				if ($('body').hasClass('admin-bar')) {
					_top = _top + 45;
				}
				var mgTop = scrollP - _topStart;

				if (mgTop + _float.height() > _images.height()) {
					_float.css({
						position: 'absolute',
						right: 15,
						bottom: 0,
						left: 'auto',
						top: 'auto',
						width: _width
					});
				} else {
					_float.css({
						position: 'fixed',
						right: 'auto',
						bottom: 'auto',
						left: _left,
						top: _top,
						width: _width
					});
				}
			} else {
				_float.css({
					position: 'static',
					right: 'auto',
					bottom: 'auto',
					left: 'auto',
					width: 'auto',
					top: 'auto'
				});
			}
		}

		if ($('.load-more-product.scroll-more').length) {
			var mytop = parseInt($('.load-more-product').offset().top - $(window).height());
			if (scrollP >= mytop) {
				loadmoreProducts();
			}
		}
		if ($('.load-more-post.scroll-more').length) {
			var mytop = parseInt($('.load-more-post').offset().top - $(window).height());
			if (scrollP >= mytop) {
				loadmorePosts();
			}
		}

        stickyAddCart();

	});

	//tooltip
	$('.view-mode a, a.quickview, a.add_to_wishlist, a.compare.button, .yith-wcwl-wishlistexistsbrowse a[rel="nofollow"], .yith-wcwl-share a, .social-icons a').each(function() {
		var text = $.trim($(this).text());
		var title = $.trim($(this).attr('title'));
		$(this).attr('data-bs-toggle', 'tooltip');
		if (!title) {
			$(this).attr('title', text);
		}
	});
	
	$('.list-view a.add_to_wishlist').attr('data-bs-toggle',''); 
	$('.list-view a.compare.button').attr('data-bs-toggle',''); 
	$('.list-view .yith-wcwl-wishlistexistsbrowse a[rel="nofollow"]').attr('data-bs-toggle',''); 
	$('.list-view  a.add_to_cart_button').attr('data-bs-toggle',''); 
	
	$('a.add_to_wishlist, a.compare.button, .yith-wcwl-wishlistexistsbrowse a[rel="nofollow"],  a.quickview').each(function() {
		$(this).attr('data-bs-placement', 'left');
	})
	
	var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
	var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
	  return new bootstrap.Tooltip(tooltipTriggerEl)
	})

	
	//categories menu
	if ($('#main-content').hasClass('home3-content')) {
		var winW = $(window).width();
		if (winW >= 1024) {
			$('.categories-menu').addClass('opening');
		}
	}
	$('.categories-menu ul.mega_main_menu_ul li.menu-item-has-children, .categories-menu li.page_item_has_children').append('<span class="opener icon-chevron-down icons"></span>');
	//header top setting
	$(document).on('click', '.header-top-setting #header-more-option', function(){
		$(this).closest('.header-top-setting').find('.setting-container').stop().slideToggle(300);
		return false;
	}); 
	$('.header-top-setting .setting-container').css('max-height', ($(window).height() - $('.setting-container').height()) + 'px');
	//mobile menu display
	$(document).on('click', '.mobile-navigation #close-menu-moblie a', function(){
	  $('body').removeClass('mobile-nav-on');
	});
	$(document).on('click', '.toggle-menu, .mobile-menu-overlay', function(){
	  	$('body').toggleClass('mobile-nav-on');
	});
	//mobile menu add opener
	$('.mobile-menu li.dropdown').append('<span class="toggle-submenu"><i class="icon icon-chevron-down icons"></i></span>');
	
	//quantity
	var number_click = 1;
	$(document).on('click', '.qty-down-fixed-onclick', function() {
		var val_input = $(this).closest('div.quantity').find('.input-text').val();
		val_input = val_input ? parseInt(val_input) : 0;
		if (val_input <= number_click) {
			if ($(this).closest('tr').hasClass('woocommerce-grouped-product-list-item')) {
				val_input = val_input - number_click;
				if (val_input <= 0) {
					val_input = 0;
				}
			} else {
				val_input = number_click;
			}
		} else {
			val_input = val_input - number_click;
		}
		$(this).closest('div.quantity').find('.input-text').val(val_input);
		if ($('.woocommerce-cart-form').length > 0) {
			$('.woocommerce-cart-form .actions .button').prop('disabled', false);
		}
		return false;
	});
	$(document).on('click', '.qty-up-fixed-onclick', function() {
		var val_input = $(this).closest('div.quantity').find('.input-text').val();
		val_input = val_input ? parseInt(val_input) : 0;
		val_input = val_input + number_click;
		$(this).closest('div.quantity').find('.input-text').val(val_input);
		if ($('.woocommerce-cart-form').length > 0) {
			$('.woocommerce-cart-form .actions .button').prop('disabled', false);
		}
		return false;
	});
	$('.woocommerce-grouped-product-list.group_table .quantity').each(function() {
		var val_input = $(this).find('.input-text').val();
		val_input = val_input ? parseInt(val_input) : 0;
		$(this).find('.input-text').val(val_input);
	});

    // add to cart button is clicked
    $(document).on('click', '.sticky-add-to-cart .action-button', function() { 
        onAddToCartClick(); 
        return false;
    });

    // update price on any product option change  
	$(document).on('change', '.product form.cart :input', function() {
        return setFromProductPrice(); 
    });

	//gird layout auto arrange
	$('.side-by-side-layout .auto-grid').each(function() {
		var $col = $(this).data('col') ? $(this).data('col') : 4;
		var $pad_y = $(this).data('pady') ? $(this).data('pady') : 0;
		var $pad_x = $(this).data('padx') ? $(this).data('padx') : 0;
		var $margin_bot = $(this).data('marbot') ? $(this).data('marbot') : 0;
		$(this).autoGrid({
			no_columns: $col,
			padding_y: $pad_y,
			padding_x: $pad_x,
			margin_bottom: $margin_bot
		});
	});

	//Fancy box for single project
	$('.prfancybox').fancybox({
		openEffect: 'fade',
		closeEffect: 'elastic',
		nextEffect: 'fade',
		prevEffect: 'fade',
		maxHeight: $(window).height() - 150,
		helpers: {
			title: {
				type: 'inside',
			},
			overlay: {
				showEarly: false,
			},
			buttons: {},
			thumbs: {
				width: 100,
				height: 100,
			}
		}
	});

	//project gallery
	jQuery('.project-gallery .sub-images').owlCarousel({
		items: 5,
		nav: false,
		dots: true,
		responsive: {
			0: {
				items: 3,
			},

			480: {
				items: 3,
			},

			640: {
				items: 4,
			},

			991: {
				items: 5,
			},
			1199: {
				items: 5,
			}
		}
	});

	//select html vitual style
	$('select.vitual-style-el').each(function() {
		var my_val = $(this).children(':selected').text();
		if (!$(this).parent().hasClass('vitual-style-wrap')) {
			$(this).wrap('<div class="vitual-style-wrap"></div>');
		}
		if (!$(this).parent().children('.vitual-style').length) {
			$(this).parent().append('<span class="vitual-style">' + my_val + '</span>');
		} else {
			$(this).parent().children('.vitual-style').text(my_val);
		}
	});

	//product countdown
	window.setInterval(function() {
		$('.deals-countdown').each(function() {
			var me = $(this);
			var days = parseInt(me.find('.days_left').text());
			var hours = parseInt(me.find('.hours_left').text());
			var mins = parseInt(me.find('.mins_left').text());
			var secs = parseInt(me.find('.secs_left').text());
			if (days > 0 || hours > 0 || mins > 0 || secs > 0) {
				if (secs == 0) {
					secs = 59;
					if (mins == 0) {
						mins = 59;
						if (hours == 0) {
							hours = 23;
							if ((days = 0)) {
								hours = 0;
								mins = 0;
								secs = 0;
							} else {
								days = days - 1;
							}
						} else {
							hours = hours - 1;
						}
					} else {
						mins = mins - 1;
					}
				} else {
					secs = secs - 1;
				}
				me.find('.days_left').html(days);
				me.find('.hours_left').html(hours);
				me.find('.mins_left').html(mins);
				me.find('.secs_left').html(secs);
			}
		});
	}, 1000);
}); //end of document ready

jQuery(window).bind('load', function() {
	// calculate number of categories items display on categories memu
	var el = jQuery('.categories-menu .mega_main_menu_ul').length ? '.mega_main_menu_ul' : '.nav_menu';
	var items = parseInt(jQuery('.categories-menu .showmore-cats').data('items'));
	var first_lv_items = jQuery('.categories-menu').find(el + ' > li.menu-item').size();
	jQuery('.categories-menu').find(el + ' > li.menu-item').each(function(index) {
		if (index > items - 1) {
			jQuery(this).addClass('out-li').hide();
		}
	});
	if (first_lv_items > items - 1) {
		jQuery('.categories-menu .showmore-cats').removeClass('hide');
	}
	jQuery('.nav-menus .categories-menu .menu-container').css('max-height',	jQuery(window).outerHeight() - 66 + 'px');

	// product thumbnail gallery
	var gallery = jQuery('.product-view.thumbnail-layout .woocommerce-product-gallery .flex-control-nav');
	if (gallery.size() && gallery.children().size()) {
		gallery.slick({
			vertical: !gallery.parent().hasClass('horizontal-slider'),
			slidesToScroll: 1,
			slidesToShow: gallery.parent().data('columns'),
			dots: false,
			infinite: false,
			verticalSwiping: false
		});
	}
	//init for owl carousel
	var owl = jQuery('[data-owl="slide"]');
	setTimeout(function() {
		owl.each(function(index, el) {
			initOwl(el);
		});
	}, 100);
});

function showQuickView(productID) {
	jQuery('#quickview-content').html('');
	window.setTimeout(function() {
		jQuery('.quickview-wrapper').addClass('open');

		jQuery.post(
			ajaxurl,
			{
				action: 'product_quickview',
				data: productID
			},
			function(response) {
				jQuery('.quickview-wrapper .quick-modal').addClass('show');
				jQuery('#quickview-content').html(response);

				/*thumbnails carousel*/
				jQuery('.quick-thumbnails').addClass('owl-carousel owl-theme');
				jQuery('.quick-thumbnails').owlCarousel({
					items: 1,
					dots: true,
					nav: false
				}); 

				/* variable product form */
				if (jQuery('#quickview-content .variations_form').length) {
					jQuery('#quickview-content .variations_form').wc_variation_form();
					jQuery('#quickview-content .variations_form .variations select').change();
				}

				jQuery('.woocommerce-review-link').on('click', function(event) {
					event.preventDefault();
					var reviewLink = jQuery('.see-all').attr('href');

					window.location.href = reviewLink + '#reviews';
				});
			}
		);
	}, 300);
}

function hideQuickView() {
	jQuery('.quickview-wrapper .quick-modal').removeClass('show');
	jQuery('.quickview-wrapper').removeClass('open');
}

var requesting = false;

function loadmoreProducts() {
	var url = jQuery('.woocommerce-pagination ul li .current').parent().next().children('a').attr('href');
	if (url && url.indexOf('page') != -1 && !requesting) {
		requesting = true;
		jQuery('.load-more-product img').removeClass('hide');
		requesting = true;
		jQuery.get(url, function(data) {
			var $data = jQuery(data);
			var $products = $data.find('#archive-product .shop-products.products').html(); 
			
			jQuery('#archive-product .shop-products.products').append($products);
			jQuery('#archive-product .toolbar.tb-bottom').html($data.find('#archive-product .toolbar.tb-bottom').html());
			jQuery('#archive-product .woocommerce-result-count span').html($data.find('.woocommerce-result-count span').html());
			jQuery('#archive-product .toolbar .view-mode a.active').trigger('click');

			var urlCheck = jQuery('.woocommerce-pagination ul li .current').parent().next().children('a').attr('href');
			if (!urlCheck && jQuery('.load-more-product.button-more').size()) {
				jQuery('.load-more-product.button-more .button').html(jQuery('.load-more-product.button-more .button').data('all'));
			}
			jQuery('a.add_to_cart_button, a.add_to_wishlist, a.compare.button, .yith-wcwl-wishlistexistsbrowse a[rel="nofollow"], a.quickview').each(function() {
				var text = jQuery.trim(jQuery(this).text());
				var title = jQuery.trim(jQuery(this).attr('title'));
				if (!title) {
					jQuery(this).attr('title', text);
				}
			});
			jQuery('.load-more-product img').addClass('hide');
			setTimeout(function() {
				requesting = false;
			}, 100);
		});
	}
}

function loadmorePosts() {
	var url = jQuery('main.blog-page > nav.pagination-row ul.pagination li.active').next().children('a').attr('href');
	if (url && url.indexOf('/page/') != -1 && !requesting) {
		requesting = true;
		jQuery('.load-more-post img').removeClass('hide');
		requesting = true;
		jQuery.get(url, function(data) {
			var $data = jQuery(data);
			var $posts = $data.find('main.blog-page > .list-posts').html();
			jQuery('main.blog-page > .list-posts').append($posts);
			jQuery('main.blog-page > nav.pagination-row').html(
				$data.find('main.blog-page > nav.pagination-row').html(),
			);

			jQuery('.side-by-side-layout .auto-grid').each(function() {
				var $grid = jQuery(this);
				var $col = $grid.data('col') ? $grid.data('col') : 4;
				var $pad_y = $grid.data('pady') ? $grid.data('pady') : 0;
				var $pad_x = $grid.data('padx') ? $grid.data('padx') : 0;
				var $margin_bot = $grid.data('marbot') ? $grid.data('marbot') : 0;
				$grid.autoGrid({
					no_columns: $col,
					padding_y: $pad_y,
					padding_x: $pad_x,
					margin_bottom: $margin_bot
				});
			});

			var urlCheck = jQuery('main.blog-page > nav.pagination-row ul.pagination li.active').next().children('a').attr('href');
			if (!urlCheck && jQuery('.load-more-post.button-more').size()) {
				jQuery('.load-more-post.button-more .button').html(jQuery('.load-more-post.button-more .button').data('all'));
			}

			jQuery('.load-more-post img').addClass('hide');
			setTimeout(function() {
				// Enable carousels
				jQuery('.su-carousel').each(function() {
					// Prepare data
					var $carousel = jQuery(this),
						$slides = $carousel.find('.su-carousel-slide');
					// Apply Swiper
					var $swiper = $carousel.swiper({
						wrapperClass: 'su-carousel-slides',
						slideClass: 'su-carousel-slide',
						slideActiveClass: 'su-carousel-slide-active',
						slideVisibleClass: 'su-carousel-slide-visible',
						pagination:	'#' + $carousel.attr('id') + ' .su-carousel-pagination',
						autoplay: $carousel.data('autoplay'),
						paginationClickable: true,
						grabCursor: true,
						mode: 'horizontal',
						mousewheelControl: $carousel.data('mousewheel'),
						speed: $carousel.data('speed'),
						slidesPerView: $carousel.data('items') > $slides.length	? $slides.length : $carousel.data('items'),
						slidesPerGroup: $carousel.data('scroll'),
						calculateHeight: $carousel.hasClass(
							'su-carousel-responsive-yes',
						),
						loop: true
					});
					// Prev button
					$carousel.on('click', '.su-carousel-prev', function(e) {
						$swiper.swipeNext();
					});
					// Next button
					$carousel.on('click', '.su-carousel-next', function(e) {
						$swiper.swipePrev();
					});
				});
				jQuery(window).resize();
				requesting = false;
			}, 100);
		});
	}
} 
jQuery(window).resize(function() {
	updateShopView();
});

function updateShopView() {
	var _mobile_view = jQuery('#archive-product .shop-products.products').data('mobileview');
	var _tablet_view = jQuery('#archive-product .shop-products.products').data('tabletview');
	var _current = jQuery('.toolbar .view-mode a.active').data('mode');
	if( _current == 'list-view' ) {
		if (Modernizr.mq('(max-width: 767px)')) {
			jQuery('#archive-product .shop-products.products').removeClass(_tablet_view).addClass(_mobile_view);
		} else if (Modernizr.mq('(max-width: 992px)')) {
			jQuery('#archive-product .shop-products.products').removeClass(_mobile_view).addClass(_tablet_view);
		} else {
			jQuery('#archive-product .shop-products.products').removeClass(_mobile_view).removeClass(_tablet_view).addClass(_current);
		}
	} else {
		if (Modernizr.mq('(max-width: 767px)')) {
			jQuery('#archive-product .shop-products.products').removeClass(_current).removeClass(_tablet_view).addClass(_mobile_view);
		} else if (Modernizr.mq('(max-width: 992px)')) {
			jQuery('#archive-product .shop-products.products').removeClass(_current).removeClass(_mobile_view).addClass(_tablet_view);
		} else {
			jQuery('#archive-product .shop-products.products').removeClass(_mobile_view).removeClass(_tablet_view).addClass(_current);
		}
	}
}

function stickyAddCart() {
    var scrollP = jQuery(window).scrollTop();
	var stickyAddCart = jQuery('.sticky-add-to-cart')
        single_product_info = jQuery('.single-product-info');
    if (stickyAddCart.length && single_product_info.length) {
        var top_sticky = single_product_info.offset().top + single_product_info.height();
        if (scrollP > top_sticky) {
            stickyAddCart.removeClass('slideOutUp').addClass('slideInDown');
        }else{
            stickyAddCart.removeClass('slideInDown').addClass('slideOutUp');
        }
    }
}

function getBarPriceElement() {
    return jQuery('.sticky-add-to-cart .price');
}

function getProductPriceElement() {
    var PriceSource = jQuery();
    if (jQuery('.woocommerce-variation-price') && jQuery('.woocommerce-variation-price').length > 0) {
        PriceSource = jQuery('.woocommerce-variation-price').find('price').filter(':last');
    }
    if (PriceSource.length == 0)
    {
        PriceSource = jQuery('.single-product-info .price').filter(':last');
    }

    return PriceSource;
}

function setFromProductPrice() {
    var productPrice = getProductPriceElement();
    var stickBarPrice = getBarPriceElement();
    if (productPrice.length > 0 && productPrice.html() != stickBarPrice.html()) {
        stickBarPrice.html(productPrice.html());
    }
}

function onAddToCartClick() {
    var addToCartButton = jQuery('[name=add-to-cart]:visible, .single_add_to_cart_button:visible');

    if (addToCartButton.filter('.disabled.wc-variation-selection-needed').length > 0) {
        var newTopPosition = jQuery('form.cart').offset().top - 50;
		jQuery('html, body').animate({
			scrollTop: newTopPosition
		}, 500);

		addToCartButton.focus();
    } else {
        addToCartButton.click();
    }

    return false;
}

function initOwl(el) {
	var $_this = jQuery(el);
	var $item = $_this.data('item-slide');
	var $rtl = $_this.data('ow-rtl');
	var $dots = $_this.data('dots') == true ? true : false;
	var $nav = $_this.data('nav') == false ? false : true;
	var $margin = $_this.data('margin') ? $_this.data('margin') : 0;
	var $bigdesk_items = $_this.data('bigdesk')	? $_this.data('bigdesk') : $item ? $item : 4;
	var $desksmall_items = $_this.data('desksmall')	? $_this.data('desksmall') : $item ? $item : 3;
	var $bigtablet_items = $_this.data('bigtablet')	? $_this.data('bigtablet') : $item ? $item : 3;
	var $tablet_items = $_this.data('tablet') ? $_this.data('tablet') : $item ? $item : 3;
	var $tabletsmall_items = $_this.data('tabletsmall')	? $_this.data('tabletsmall') : $item ? $item : 2;
	var $mobile_items = $_this.data('mobile') ? $_this.data('mobile') : $item ? $item : 1;
	var $tablet_margin = Math.floor($margin / 1.5);
	var $mobile_margin = Math.floor($margin / 3);
	var $default_items = $item ? $item : 4;
	var $autoplay = $_this.data('autoplay') == true ? true : false;
	var $autoplayTimeout = $_this.data('playtimeout') ? $_this.data('playtimeout') : 5000;
	var $smartSpeed = $_this.data('speed') ? $_this.data('speed') : 250;
	var loop = false;
	if ($autoplay) loop = true;

	var $next_text = $_this.data('navnext')	? $_this.data('navnext') : 'Next';
	var $prev_text = $_this.data('navprev')	? $_this.data('navprev') : 'Prev';
	$_this.owlCarousel({
		loop: loop,
		nav: $nav,
		dots: $dots,
		margin: $margin,
		rtl: $rtl,
		items: $default_items,
		autoplay: $autoplay,
		autoplayTimeout: $autoplayTimeout,
		smartSpeed: $smartSpeed,
		navText: [$next_text, $prev_text],
		responsive: {
			0: {
				items: $mobile_items, // In this configuration 1 is enabled from 0px up to 479px screen size
				margin: $mobile_margin,
			},
			480: {
				items: $tabletsmall_items, // from 480 to 677 default 1
				margin: $mobile_margin,
			},
			640: {
				items: $tablet_items, // from this breakpoint 640 to 767
				margin: $tablet_margin,
			},
			768: {
				items: $bigtablet_items, // from this breakpoint 768 to 991
				margin: $tablet_margin,
			},
			992: {
				items: $desksmall_items, // from this breakpoint 992 to 1199
				margin: $margin,
			},
			1200: {
				items: $default_items,
				margin: $margin,
			},
			1500: {
				items: $bigdesk_items,
				margin: $margin,
			}
		}
	});
}