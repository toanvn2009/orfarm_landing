<?php
defined( 'ABSPATH' ) || exit;

if ( file_exists( get_template_directory().'/includes/megamenu/megamenu.php' ) ) {
	require_once( get_template_directory().'/includes/megamenu/megamenu.php' );
}
if ( file_exists( get_template_directory().'/includes/megamenu/megamenu-mobile.php' ) ) {
	require_once( get_template_directory().'/includes/megamenu/megamenu-mobile.php' );
}
if ( file_exists( get_template_directory().'/includes/megamenu/megamenu-categories.php' ) ) {
	require_once( get_template_directory().'/includes/megamenu/megamenu-categories.php' );
}
if ( file_exists( get_template_directory().'/includes/megamenu/megamenu-backend.php' ) ) {
	require_once( get_template_directory().'/includes/megamenu/megamenu-backend.php' );
}
if ( file_exists( get_template_directory().'/includes/megamenu/categories-mobile.php' ) ) {
	require_once( get_template_directory().'/includes/megamenu/categories-mobile.php' );
}
class MegamenuLocation {
	/**
	 * Primary Mega Menu
	 */
	public  function megamenu_primary( $args = array() ) {
		$defaults = array(
			'theme_location' => 'primary',
			'container_class' => 'primary-menu-container',
			'menu_class' => 'nav-menu',
			'menu_id'        => 'mega_main_menu_ul',
		);


		$args = wp_parse_args( $args, $defaults );

		if ( has_nav_menu( 'primary' ) && class_exists( 'Megamenu_Walker_Nav_Menu' ) ) {
			$args['walker'] = new Megamenu_Walker_Nav_Menu;
		}
		global $megamenu_primary;

		ob_start();

		wp_nav_menu( $args );

		$megamenu_primary = ob_get_clean();

		echo '' . $megamenu_primary;
	}
	/**
	 * Primary Mega mobile Menu
	 */
	public  function megamenu_mobile( $args = array() ) {

		$defaults = array(
			'theme_location' => 'mobilemenu',
			'container_class' => 'mobile-menu-container',
			'menu_class'     => 'nav-menu mobile-menu',
			'menu_id'        => 'bl-megamenu_mobile',
		);


		$args = wp_parse_args( $args, $defaults );
		if ( has_nav_menu( 'mobilemenu' ) && class_exists( 'Megamenu_Mobile_Walker_Nav_Menu' ) ) {
			$args['walker'] = new Megamenu_Mobile_Walker_Nav_Menu;
		}
		global $megamenu_mobile;

		ob_start();

		wp_nav_menu( $args );

		$megamenu_mobile = ob_get_clean();

		echo '' . $megamenu_mobile;
	}
	// categories menu 
	public  function megamenu_categories( $args = array() ) {
		
		$defaults = array(
			'theme_location' => 'categories',
			'container_class' => 'categories-menu-container',
			'menu_class'     => 'nav-menu ',
		);

		$args = wp_parse_args( $args, $defaults );
		if ( has_nav_menu( 'categories' ) && class_exists( 'Megamenu_Categories_Walker_Nav_Menu' ) ) {
			$args['walker'] = new Megamenu_Categories_Walker_Nav_Menu;
		}
		global $megamenu_categories;

		ob_start();

		wp_nav_menu( $args );

		$megamenu_categories = ob_get_clean();

		echo '' . $megamenu_categories;
		
	}

	/**
	 * Primary Mega mobile Menu
	 */
	public  function categories_mobile( $args = array() ) {

		$defaults = array(
			'theme_location' => 'categories',
			'container_class' => 'mobile-categories-container',
			'menu_class'     => 'nav-menu mobile-menu',
			'menu_id'        => 'bl-megamenu_mobile',
		);


		$args = wp_parse_args( $args, $defaults );
		if ( has_nav_menu( 'categories' ) && class_exists( 'Megamenu_Categories_Mobile_Walker_Nav_Menu' ) ) {
			$args['walker'] = new Megamenu_Categories_Mobile_Walker_Nav_Menu;
		}
		global $categories_mobile;

		ob_start();

		wp_nav_menu( $args );

		$categories_mobile = ob_get_clean();

		echo '' . $categories_mobile;
	}	
	
}
