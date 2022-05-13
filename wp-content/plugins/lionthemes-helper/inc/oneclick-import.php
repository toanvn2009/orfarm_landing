<?php
// Import slider, setup menu locations, setup home page
	
function logerror123($msg){
	if (WP_DEBUG_LOG) {
		if ( ! defined( 'IMPORT_LOG_PATH' ) ) define('IMPORT_LOG_PATH', dirname(dirname(__DIR__)));
		$datafeed = date('Y-m-d H:i:s') . ": " . $msg . "\r\n\r\n";
		$fp = fopen(IMPORT_LOG_PATH . '/aaalog.txt', 'a+');
		fwrite($fp, print_r($msg,true));
		fclose($fp);
	}
}

function import_widget( $demo_active_import , $demo_directory_path) {
	
	global $wp_filesystem;
	WP_Filesystem();
	$widget_file = $demo_directory_path.'widgets.wie';
	$response = $wp_filesystem->get_contents($widget_file);
	$absolute_path = __FILE__;
	$path_to_file = explode( 'wp-content', $absolute_path );
	$path_to_wp = $path_to_file[0];	
	
	if ( file_exists( $demo_directory_path.'widgets.wie') ) { 
		if ( file_exists( $path_to_wp.'wp-content/plugins/widget-importer-exporter/widget-importer-exporter.php' ) ) {
		//plugin is activated

			require_once( $path_to_wp.'wp-content/plugins/widget-importer-exporter/widget-importer-exporter.php');
			require_once( $path_to_wp.'wp-content/plugins/widget-importer-exporter/includes/import.php');
				wie_process_import_file($widget_file); 	
		}

	} 
}

function import_slider ($demo_directory_path) {
	include $demo_directory_path.'data_demo.php';					
	$absolute_path = __FILE__;
	$path_to_file = explode( 'wp-content', $absolute_path );
	$path_to_wp = $path_to_file[0];				
	require_once( $path_to_wp.'/wp-load.php' );
	require_once( $path_to_wp.'/wp-includes/functions.php');
	require_once( $path_to_wp.'/wp-admin/includes/file.php');
	require_once( $path_to_wp.'wp-content/plugins/revslider/revslider.php');				
	$slider = new RevSlider();			
	foreach($sliderArray as $filepath) {	

		//echo THEME_DIRECTORY.'/road_importdata/'.$filepath . '<br />';	
		$slider->importSliderFromPost(true, true, $demo_directory_path.$filepath);  					
	}
}

function set_menu_location () {
				
				//set option for menu 
				$locations = get_theme_mod( 'nav_menu_locations' );
				if(empty($locations)) {
					$locations = array(
						'primary' => 'primary',
						'mobilemenu' => 'mobilemenu',
						'categories' => 'categories',
					);
				}

				if(!empty($locations))
				{
						
					foreach($locations as $locationId => $menuValue)
					{
						switch($locationId)
						{
							case 'primary':
								$menu = get_term_by('name', 'Main Menu', 'nav_menu');
							break; 
						
							case 'mobilemenu':
								$menu = get_term_by('name', 'Main Menu', 'nav_menu');
							break;
							
							case 'categories':
								$menu = get_term_by('name', 'Categories', 'nav_menu');
							break;

						}

						if(isset($menu->term_id))
						{
							$locations[$locationId] = $menu->term_id;
						}
					}
					 
					set_theme_mod('nav_menu_locations', $locations);
				}
}

function update_elementor_config($demo_directory_path) {
			// Elementor default setting
	$elementor = $demo_directory_path.'elementor-default-settings.txt';
	if ( file_exists( $elementor ) ) {
		$file_content = file_get_contents ( $elementor );
		if ( $file_content !== false && $el_id = get_option('elementor_active_kit') ) {
			$value = unserialize($file_content);
			update_post_meta( $el_id, '_elementor_page_settings', $value);
		}
	}

}

function import_option_data($opt_name="",$file="",$type="") {
		global $wp_filesystem;
		WP_Filesystem();
		$response = $wp_filesystem->get_contents($file);
		$xsp_opt =  json_decode ($response);
		$xsp_opt = json_decode(json_encode($xsp_opt), true);
		if($type =='menu') {
			if(isset($xsp_opt['last_modified'])) {
				$xsp_opt['last_modified'] = time() + 30;	
			}
		}
		$slug = explode('orfarm_opt_',$opt_name);
		$slug = $slug[1];
		$footer = 'Footer v1';
		if($slug == 'home-shop-1' ) {
			$footer = 'Footer v1';
		}elseif($slug == 'home-shop-2' ) {
			$footer = 'Footer v1';
		}elseif($slug == 'home-shop-3' ) {
			$footer = 'Footer v2';
		}elseif($slug == 'home-shop-4' ) {
			$footer = 'Footer v3';
		}elseif($slug == 'home-shop-5' ) {
			$footer = 'Footer v4';
		}elseif($slug == 'home-shop-6' ) {
			$footer = 'Footer v3';
		}
		
		$footer = get_page_by_title( $footer,OBJECT,'lionthemes_block' );
		
		$xsp_opt['footer_layout'] = $footer->ID;
		update_option($opt_name,$xsp_opt);
}

function lionthemes_helper_wbc_extended_example( $demo_active_import , $demo_directory_path ) {
	reset( $demo_active_import );
	logerror123($demo_active_import);
	$current_key = key( $demo_active_import );
	// Import widget 
	import_widget($demo_active_import , $demo_directory_path);
	// Revolution Slider import all
	import_slider ($demo_directory_path);				 
	// menu localtion settings
	set_menu_location();
	// update elementor css
	update_elementor_config($demo_directory_path);
	//update theme option 
	$slug = "";
	foreach ($demo_active_import as $id => $demo_data) {
		$slug = $demo_data['directory'];
	}
	$json_file = $demo_directory_path.'theme-options.json';
	if($slug == 'home-shop-1' ) {
		$opt_name = 'orfarm_opt_'.$slug;
	    import_option_data($opt_name,$json_file,'theme_option');
	    import_option_data('orfarm_opt',$json_file,'theme_option');
	} else {
	    $opt_name = 'orfarm_opt_'.$slug;
	    import_option_data($opt_name,$json_file,'theme_option');
    }

	$home_page = 'Home Shop 1';
	if($slug == 'home-shop-1' ) {
		$home_page = 'Home Shop 1';
	}elseif($slug == 'home-shop-2' ) {
		$home_page = 'Home Shop 2';
	}elseif($slug == 'home-shop-3' ) {
		$home_page = 'Home Shop 3';
	}elseif($slug == 'home-shop-4' ) {
		$home_page = 'Home Shop 4';
	}elseif($slug == 'home-shop-5' ) {
		$home_page = 'Home Shop 5';
	}elseif($slug == 'home-shop-6' ) {
		$home_page = 'Home Shop 6';
	}
	// Home page setup default
	$page_options = array(
		'page_on_front' => $home_page,
		'page_for_posts' => 'Blog',
		'woocommerce_shop_page_id' => 'Shop',
		'woocommerce_cart_page_id' => 'Cart',
		'woocommerce_checkout_page_id' => 'Checkout',
		'woocommerce_myaccount_page_id' => 'My account',
	);
	
	foreach ( $page_options as $key => $page_title ) {
		$page = get_page_by_title( $page_title );
		if ( isset( $page->ID ) ) {
			update_option( $key, $page->ID );
		}
	}
	
	update_option( 'woocommerce_single_image_width', 800 );
	update_option( 'woocommerce_thumbnail_image_width', 500 );
	update_option( 'woocommerce_thumbnail_cropping', '1:1' );
	update_option( 'show_on_front', 'page' );
	update_option( 'elementor_container_width', 1400 );
	update_option( 'yith_woocompare_compare_button_in_products_list', 'no' );
	update_option( 'date_format', 'd M, Y' );
	update_option( 'permalink_structure', '/%postname%/' );
	update_option( 'mc4wp_default_form_id', 1402 );
}
add_action( 'wbc_importer_after_content_import', 'lionthemes_helper_wbc_extended_example', 10, 2 );

add_action( 'wbc_importer_before_content_import', 'lionthemes__before_content_import', 10, 1 );
function lionthemes__before_content_import($demo_directory_path) {
	$src = $demo_directory_path . 'elementor/css';
	if ( file_exists( $src ) ) {
		$dir = opendir($src);
		if (!file_exists(ABSPATH  . 'wp-content/uploads/elementor')) {
			mkdir(ABSPATH  . 'wp-content/uploads/elementor', 0755, true);
			mkdir(ABSPATH  . 'wp-content/uploads/elementor/css', 0755, true);
		} elseif (!file_exists(ABSPATH  . 'wp-content/uploads/elementor/css')) {
			mkdir(ABSPATH  . 'wp-content/uploads/elementor/css', 0755, true);
		}
		$dst =  ABSPATH  . 'wp-content/uploads/elementor/css';
		while(false !== ( $file = readdir($dir)) ) { 
			if (( $file != '.' ) && ( $file != '..' )) { 
				copy($src . '/' . $file, $dst . '/' . $file);  
			} 
		} 
		closedir($dir);
	}
}

