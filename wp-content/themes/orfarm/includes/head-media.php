<?php
/**
* Theme stylesheet & javascript registration
*
* @package LionThemes
* @subpackage Orfarm_theme
* @since Orfarm Themes 2.0
*/
//Orfarm theme style and script 
function orfarm_register_script()
{
	global $orfarm_opt, $woocommerce, $post;
	$default_heading_font = "'Quicksand', sans-serif";
	$default_font = "'Jost', sans-serif";
	$post_id = get_option( 'page_on_front' );
	$slug_page = "";
	
	if( is_front_page() ) {
		$default_post = get_post($post_id);
		if(isset( $orfarm_opt['home_default'] )) { 
	        $slug_page = $orfarm_opt['home_default'];
		    $orfarm_opt = get_option('orfarm_opt_'.$slug_page); 
		}
		if( isset($orfarm_opt['home_default']) && $orfarm_opt['home_default'] == 'default' || $slug_page == 'default') { 
			$orfarm_opt = get_option( 'orfarm_opt' );
		}	
	} else { 
	 	if($post->post_name) {
		 if(get_option('orfarm_opt_'.$post->post_name) == false )  {
			     $orfarm_opt = get_option( 'orfarm_opt' );
			     $slug_page = $orfarm_opt['home_default'];
			 } else {
				$slug_page = $post->post_name;
			 }
			$orfarm_opt = get_option('orfarm_opt_'.$slug_page);  
			if($slug_page == 'default') $orfarm_opt = get_option( 'orfarm_opt' );
		}
	}
	
	$params = array(
		'heading_font'=> ((!empty($orfarm_opt['headingfont']['font-family'])) ? $orfarm_opt['headingfont']['font-family'] : $default_heading_font),
		'heading_color'=> ((!empty($orfarm_opt['headingfont']['color'])) ? $orfarm_opt['headingfont']['color'] : '#2D2A6E'),
		'heading_font_weight'=> ((!empty($orfarm_opt['headingfont']['font-weight'])) ? $orfarm_opt['headingfont']['font-weight'] : '700'),
		'menu_font'=> ((!empty($orfarm_opt['menufont']['font-family'])) ? $orfarm_opt['menufont']['font-family'] : $default_heading_font),
		'menu_color'=> ((!empty($orfarm_opt['menufont']['color'])) ? $orfarm_opt['menufont']['color'] : '#2D2A6E'),
		'menu_font_size'=> ((!empty($orfarm_opt['menufont']['font-size'])) ? $orfarm_opt['menufont']['font-size'] : '16px'),
		'menu_font_weight'=> ((!empty($orfarm_opt['menufont']['font-weight'])) ? $orfarm_opt['menufont']['font-weight'] : '500'),
		'sub_menu_bg'=> ((!empty($orfarm_opt['sub_menu_bg'])) ? $orfarm_opt['sub_menu_bg'] : '#fff'),
		'sub_menu_color'=> ((!empty($orfarm_opt['sub_menu_color'])) ? $orfarm_opt['sub_menu_color'] : '#4f4f4f'),
		'body_font'=> ((!empty($orfarm_opt['bodyfont']['font-family'])) ? $orfarm_opt['bodyfont']['font-family'] : $default_font),
		'text_color'=> ((!empty($orfarm_opt['bodyfont']['color'])) ? $orfarm_opt['bodyfont']['color'] : '#4D5574'),
		'text_size'=> ((!empty($orfarm_opt['bodyfont']['font-size'])) ? $orfarm_opt['bodyfont']['font-size'] : '16px'),
		'text_weight'=> ((!empty($orfarm_opt['bodyfont']['font-weight'])) ? $orfarm_opt['bodyfont']['font-weight'] : '400'),
		'link_color' => ((!empty($orfarm_opt['link_color'])) ? $orfarm_opt['link_color'] : '#4f4f4f'),
		'primary_color' => (!empty($orfarm_opt['primary_color'])) ? $orfarm_opt['primary_color'] : '#96AE00',
		'sale_color' => ((!empty($orfarm_opt['sale_color'])) ? $orfarm_opt['sale_color'] : '#f54949'),
		'saletext_color' => ((!empty($orfarm_opt['saletext_color'])) ? $orfarm_opt['saletext_color'] : '#ffffff'),
		'price_color' => ((!empty($orfarm_opt['price_color'])) ? $orfarm_opt['price_color'] : '#EA0D42'),
		'old_price_color' => ((!empty($orfarm_opt['old_price_color'])) ? $orfarm_opt['old_price_color'] : '#999999'),
		'button_background_color' => ((!empty($orfarm_opt['button_background_color'])) ? $orfarm_opt['button_background_color'] : '#96AE00'),
		'button_color' => ((!empty($orfarm_opt['button_color'])) ? $orfarm_opt['button_color'] : '#fff'),
		'rate_color' => ((!empty($orfarm_opt['rate_color'])) ? $orfarm_opt['rate_color'] : '#ffa200'),
		'page_width' => (!empty($orfarm_opt['box_layout_width'])) ? $orfarm_opt['box_layout_width'] . 'px' : '1430px',
		'body_bg_color' => ((!empty($orfarm_opt['background_opt']['background-color'])) ? $orfarm_opt['background_opt']['background-color'] : '#fff'),
		'sticky_bg' => (!empty($orfarm_opt['sticky_bg'])) ? $orfarm_opt['sticky_bg'] : '#fff',
		'sticky_color' => (!empty($orfarm_opt['sticky_color'])) ? $orfarm_opt['sticky_color'] : '#222',
		'top_bar' => (!empty($orfarm_opt['topbar_background']['background-color'])) ? $orfarm_opt['topbar_background']['background-color'] : '#2D2A6E',
		'topbar_color' => (!empty($orfarm_opt['topbar_color'])) ? $orfarm_opt['topbar_color'] : '#fff',
		'header_bg_color' => (!empty($orfarm_opt['header_background']['background-color'])) ? $orfarm_opt['header_background']['background-color'] : '#fff',
		'header_color' => (!empty($orfarm_opt['header_color'])) ? $orfarm_opt['header_color'] : '#2D2A6E',
		'header_icons_color' => (!empty($orfarm_opt['header_icons_color'])) ? $orfarm_opt['header_icons_color'] : '#2D2A6E',
		'logo_maxwidth' => (!empty($orfarm_opt['max_logo_width'])) ? $orfarm_opt['max_logo_width'] . 'px' : '90px',
		'box_layout_width' => (!empty($orfarm_opt['box_layout_width'])) ? $orfarm_opt['box_layout_width'] . 'px' : '1200px', 
	);
	

	
	if ( !$orfarm_opt || !class_exists('ReduxFramework') || !empty($orfarm_opt['use_design_font']) ) {
		wp_enqueue_style( 'redhat-display-font', '//fonts.googleapis.com/css2?family=Jost:ital,wght@0,300;0,400;0,500;0,600;0,700;1,400;1,500;1,600&display=swap" rel="stylesheet"' );
		wp_enqueue_style( 'quicksand-display-font', '//fonts.googleapis.com/css2?family=Quicksand:wght@300;400;500;600;700&display=swap" rel="stylesheet"' );
		$params['heading_font'] = "'Quicksand', sans-serif";
		$params['menu_font'] = "'Jost', sans-serif";
		$params['body_font'] = "'Jost', sans-serif";
	}
	if( function_exists('compileLess') ){
		if(isset($_GET['demo']) && !empty($demos[intval($_GET['demo'])])){
			compileLess('theme.less', 'theme_demo_' . intval($_GET['demo']) . '.css', $params);
		}else{
			compileLess('theme.less', 'theme.css', $params);
		}
	}
	wp_enqueue_style( 'fontawesome', get_template_directory_uri() . '/css/font-awesome.min.css' );
	wp_enqueue_style( 'orfarm-style', get_template_directory_uri() . '/style.css', array(), filemtime( get_template_directory() . '/style.css' ) );
	wp_enqueue_style( 'bootstrap', get_template_directory_uri() . '/css/bootstrap.css', array(), '5.0.2' );
	wp_enqueue_style( 'dukamarket-icon', get_template_directory_uri() . '/css/dukamarket-icon.css'  );
	wp_enqueue_style( 'owl-carousel', get_template_directory_uri() . '/ext/owl-carousel/owl.carousel.css'  );
	wp_enqueue_style( 'owl-carousel-transitions', get_template_directory_uri() . '/ext/owl-carousel/owl.transitions.css'  );
	wp_enqueue_style( 'animate', get_template_directory_uri() . '/css/animate.min.css' );
	wp_enqueue_style( 'fancybox', get_template_directory_uri() . '/ext/fancybox/jquery.fancybox.css' );
	wp_enqueue_style( 'slick', get_template_directory_uri() . '/ext/slick/slick.css' );
	wp_enqueue_style( 'slick-theme', get_template_directory_uri() . '/ext/slick/slick-theme.css' );
	if ( is_singular() ) wp_enqueue_script( 'comment-reply' );
	
	if(isset($_GET['demo']) && !empty($demos[$_GET['demo']])){
		if(file_exists( get_template_directory() . '/css/theme_demo_' . intval($_GET['demo']) . '.css' )){
			wp_enqueue_style( 'orfarm-theme-options', get_template_directory_uri() . '/css/theme_demo_' . intval($_GET['demo']) . '.css', array(), filemtime( get_template_directory() . '/css/theme_demo_' . intval($_GET['demo']) . '.css' ) );
		}
	}else{
		if(file_exists( get_template_directory() . '/css/theme.css' )){
			wp_enqueue_style( 'orfarm-theme-options', get_template_directory_uri() . '/css/theme.css', array(), filemtime( get_template_directory() . '/css/theme.css' )  );
		}
	}
	
	// add add-to-cart-variation js to all other pages without detail. it help quickview work with variable products
	if( class_exists('WooCommerce') && !is_product() ) {
		wp_enqueue_script( 'wc-add-to-cart-variation', $woocommerce->plugin_url() . '/assets/js/frontend/add-to-cart-variation.js', array('jquery'), '', true );
	}
	
	// add slide library ready for load more post
	if((is_archive() || is_author() || is_category() || is_tag() || is_home()) && function_exists('su_query_asset')) {
		su_query_asset( 'css', 'su-shortcodes' );
		su_query_asset( 'js', 'jquery' );
		su_query_asset( 'js', 'swiper' );
		su_query_asset( 'js', 'su-galleries-shortcodes' );
	}
	wp_enqueue_script( 'bootstrap-popper', get_template_directory_uri() . '/js/popper.min.js', array('jquery'), '1.12.9' );
	wp_enqueue_script( 'bootstrap-bundle-min', get_template_directory_uri() . '/js/bootstrap.bundle.min.js', array('jquery'), '5.0.2' );
    wp_enqueue_script( 'wow', get_template_directory_uri() . '/js/jquery.wow.min.js', array('jquery'), '', true );
    wp_enqueue_script( 'modernizr', get_template_directory_uri() . '/js/modernizr.custom.js', array('jquery'), '', true );
    wp_enqueue_script( 'owl-carousel', get_template_directory_uri() . '/ext/owl-carousel/owl.carousel.js', array('jquery'), '', true );
    wp_enqueue_script( 'auto-grid', get_template_directory_uri() . '/js/autoGrid.min.js', array('jquery'), '', true );
    wp_enqueue_script( 'fancybox', get_template_directory_uri() . '/ext/fancybox/jquery.fancybox.pack.js', array('jquery'), '', true );
    wp_enqueue_script( 'slick', get_template_directory_uri() . '/ext/slick/slick.min.js', array('jquery'), '', true );
	wp_enqueue_script( 'isotope', get_template_directory_uri() . '/js/isotope.js', array('jquery'), '', true );
    wp_enqueue_script( 'orfarm-custom', get_template_directory_uri() . '/js/custom.js', array('jquery'), filemtime( get_template_directory() . '/js/custom.js'), true );
	wp_enqueue_script( 'megamenu', get_template_directory_uri() . '/js/megamenu.js', array('jquery'), filemtime( get_template_directory() . '/js/megamenu.js'), true ); 
	// add ajaxurl
	$ajaxurl = 'var ajaxurl = "'. esc_js(admin_url('admin-ajax.php')) .'";';
	wp_add_inline_script( 'orfarm-custom', $ajaxurl, 'before' );
	
	 
	// add newletter popup js
	if(isset($orfarm_opt['enable_popup']) && $orfarm_opt['enable_popup']){
		if (is_front_page() && (!empty($orfarm_opt['popup_onload_form']) || !empty($orfarm_opt['popup_onload_content']))) {
			$newletter_js = 'jQuery(document).ready(function($){
								if($(\'#popup_onload\').length){
									$(\'#popup_onload\').fadeIn(400);
								}
								$(\'#popup_onload .close-popup, #popup_onload .overlay-bg, #popup_onload .no-thanks\').click(function(){
									var not_again = $(this).closest(\'#popup_onload\').find(\'.not-again input[type="checkbox"]\').prop(\'checked\');
									if(not_again){
										var datetime = new Date();
										var exdays = '. ((!empty($orfarm_opt['popup_onload_expires'])) ? intval($orfarm_opt['popup_onload_expires']) : 7) . ';
										datetime.setTime(datetime.getTime() + (exdays*24*60*60*1000));
										document.cookie = \'no_again=1; expires=\' + datetime.toUTCString();
									}
									$(this).closest(\'#popup_onload\').fadeOut(400);
								});
							});';
			wp_add_inline_script( 'orfarm-custom', $newletter_js );
		}
	}
	
		/**
		* Custom JS
		*/
		if ( $orfarm_opt[ 'custom_js_enable' ] ) {
			wp_add_inline_script( 'orfarm-custom', html_entity_decode(  $orfarm_opt['custom_js']) );
		}
	// add remove top cart item
	$remove_cartitem_js = 'jQuery(document).on(\'click\', \'.mini_cart_item .remove\', function(e){
							var product_id = jQuery(this).data("product_id");
							var item_li = jQuery(this).closest(\'li\');
							var a_href = jQuery(this).attr(\'href\');
							jQuery.ajax({
								type: \'POST\',
								dataType: \'json\',
								url: ajaxurl,
								data: \'action=orfarm_product_remove&\' + (a_href.split(\'?\')[1] || \'\'), 
								success: function(data){
									if(typeof(data) != \'object\'){
										alert(\'' . esc_html__('Could not remove cart item.', 'orfarm') . '\');
										return;
									}
									jQuery(\'.topcart .cart-toggler .qty\').html(data.qty);
									jQuery(\'.topcart .cart-toggler .subtotal\').html(data.subtotal);
									if(data.qtycount > 0){
										if (jQuery(\'.cart-side-content .total .amount\').size()) {
											jQuery(\'.cart-side-content .total .amount\').html(data.subtotal);
										}
										if (jQuery(\'.side-sticky-icons .quick-cart .badge\').size()) {
											jQuery(\'.side-sticky-icons .quick-cart .badge\').html(data.qty);
										}
									}else{
										if (jQuery(\'.cart-side-content .total .amount\').size()) {
											jQuery(\'.cart-side-content .cart_list\').html(\'<li class="empty">' .  esc_html__('No products in the cart.', 'orfarm') .'</li>\');
											jQuery(\'.cart-side-content .total\').remove();
										}
										jQuery(\'.cart-side-content .buttons\').remove();
										if (jQuery(\'.side-sticky-icons .quick-cart .badge\').size()) {
											jQuery(\'.side-sticky-icons .quick-cart .badge\').html(0);
										}
									}
									item_li.remove();
								}
							});
							e.preventDefault();
							return false;
						});';
	wp_add_inline_script( 'orfarm-custom', $remove_cartitem_js );
	
	//sticky header
	if(isset($orfarm_opt['sticky_header']) && $orfarm_opt['sticky_header']){ 
		$sticky_header_js = 'jQuery(document).ready(function($){
			$(window).scroll(function() {
				var start = $(".main-wrapper > header").outerHeight();
				' . ((is_admin_bar_showing()) ? '$("header .header-container").addClass("has_admin");' : '') . '
				if ($(this).scrollTop() > start){  
					$("header .header-container").addClass("sticky");
					if ($(".header-container .categories-menu").hasClass("opening")) {
						$(".header-container .categories-menu").removeClass("opening");
					}
				}
				else{
					$("header .header-container").removeClass("sticky");
				}
			});
		});';
		wp_add_inline_script( 'orfarm-custom', $sticky_header_js );
	}
	
	//ajax search autocomplete products
	if(!empty($orfarm_opt['enable_ajaxsearch'])){
		$enable_ajaxsearch_js = '
			var in_request = null;
			var last_key = "";
			jQuery(document).on("keyup focus change", ".header form[role=\"search\"] .search-field, .header form[role=\"search\"] .search-cat-field, .header form[role=\"search\"] li.cat-item a", function(e){
				var keyword = jQuery(this).closest("form").find(".search-field").val();
				var catslug = (jQuery(this).closest("form").find(".search-cat-field").length) ? jQuery(this).closest("form").find(".search-cat-field").val() : "";
				var _me_result = jQuery(this).closest("form").find(".orfarm-autocomplete-search-results");
				var _me_loading = jQuery(this).closest("form").find(".orfarm-autocomplete-search-loading");
				if (last_key != keyword) {
					_me_result.hide();
					_me_loading.show();
					if (in_request !== null){
						in_request.abort();
					}
					in_request = jQuery.ajax({
						type: "POST",
						dataType: "text",
						url: ajaxurl,
						data: "action=orfarm_autocomplete_search&keyword=" + keyword + "&cat=" + catslug, 
						success: function(data){
							_me_result.html(data).delay(500).show();
							_me_loading.hide();
							in_request = null;
							last_key = keyword;
						}
					});
				}
				e.preventDefault();
				return false;
			});
		';
		wp_add_inline_script( 'orfarm-custom', $enable_ajaxsearch_js );
	}
}
add_action( 'wp_enqueue_scripts', 'orfarm_register_script', 10 );

// bootstrap for back-end page
add_action( 'admin_enqueue_scripts', 'orfarm_admin_custom' );
function orfarm_admin_custom() {
	wp_enqueue_style( 'orfarm-admin-custom', get_template_directory_uri() . '/css/admin.css', array(), filemtime( get_template_directory() . '/css/admin.css'));
}
//Orfarm theme gennerate title
add_filter( 'wp_title', 'orfarm_wp_title', 10, 2 );
function orfarm_wp_title( $title, $sep ) {
	global $paged, $page;
	if ( is_feed() ) return $title;
	
	$title .= get_bloginfo( 'name', 'display' );
	
	// Add the site description for the home/front page.
	$site_description = get_bloginfo( 'description', 'display' );
	if ( $site_description && ( is_home() || is_front_page() ) )
		$title = "$title $sep $site_description";
	
	if ( $paged >= 2 || $page >= 2 )
		$title = "$title $sep " . sprintf( esc_html__( 'Page %s', 'orfarm' ), max( $paged, $page ) );
	
	return $title;
}

// add favicon to header
add_action( 'wp_head', 'orfarm_wp_custom_head', 100);
function orfarm_wp_custom_head(){
	$orfarm_opt = get_option( 'orfarm_opt' );
	if ( ! function_exists( 'has_site_icon' ) || ! has_site_icon() ) {
		if(isset($orfarm_opt['opt-favicon']) && $orfarm_opt['opt-favicon']!="") { 
			if(is_ssl()){
				$orfarm_opt['opt-favicon'] = str_replace('http:', 'https:', $orfarm_opt['opt-favicon']);
			}
		?>
			<link rel="icon" type="image/png" href="<?php echo esc_url($orfarm_opt['opt-favicon']['url']);?>">
		<?php }
	}
}
add_action('wp_head', 'orfarm_custom_styles', 100);

function orfarm_custom_styles()
{
 if( !isset($orfarm_opt['custom_css_enable']) ) return ;	
 $orfarm_opt = get_option( 'orfarm_opt' );
 $html = "<style>";
   $html .= html_entity_decode(  $orfarm_opt['custom_css'])	;
 $html .="</style>";

 echo esc_html($html); 
}
// body class for wow scroll script
add_filter('body_class', 'orfarm_effect_scroll');
function orfarm_effect_scroll($classes){
	if (is_admin_bar_showing()) {
		$classes[] = 'has_admin';
	}
	if (!in_array('home', $classes)) $classes[] = 'home';
	$classes[] = 'orfarm-animate-scroll';
	
	if (!class_exists( 'Redux_Framework_Plugin', false )) {
		$classes[] = 'orfarm-default-body';
	}
	
	return $classes;
}
?>