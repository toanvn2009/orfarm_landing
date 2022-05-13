<?php 
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

final class Lionthemes_Elementor_Extension {

	private static $_instance = null;

	public static function instance() {
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}
		return self::$_instance;
	}
	public function __construct() {
		add_action( 'init', [ $this, 'i18n' ] );
		add_action( 'plugins_loaded', [ $this, 'init' ] );
	}
	public function i18n() {
		load_plugin_textdomain( 'orfarm' );
	}
	public function init() {
		add_action( 'elementor/widgets/widgets_registered', array( $this, 'init_widgets' ) );
		
	}
	public function init_widgets() {
		require_once( plugin_dir_path( __DIR__ ) . 'elementors/products.php' );
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \Lionthemes_Product_Element() );
		require_once( plugin_dir_path( __DIR__ ) . 'elementors/menus.php' );
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \Lionthemes_Menus_Element() );
		require_once( plugin_dir_path( __DIR__ ) . 'elementors/socialicons.php' );
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \Lionthemes_Socialicons_Element() );
		require_once( plugin_dir_path( __DIR__ ) . 'elementors/brands.php' );
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \Lionthemes_Brands_Element() );
		require_once( plugin_dir_path( __DIR__ ) . 'elementors/heading.php' );
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \Lionthemes_Heading_Element() );
		require_once( plugin_dir_path( __DIR__ ) . 'elementors/featuredcategories.php' );
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \Lionthemes_Featuredcategories_Element() );
		require_once( plugin_dir_path( __DIR__ ) . 'elementors/productscategory.php' );
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \Lionthemes_Productscategory_Element() );
		require_once( plugin_dir_path( __DIR__ ) . 'elementors/testimonials.php' );
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \Lionthemes_Testimonials_Element() );
		require_once( plugin_dir_path( __DIR__ ) . 'elementors/featurecontent.php' );
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \Lionthemes_Featuredcontent_Element() ); 
		require_once( plugin_dir_path( __DIR__ ) . 'elementors/blogposts.php' );
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \Lionthemes_Blogposts_Element() ); 
		require_once( plugin_dir_path( __DIR__ ) . 'elementors/categorytabs.php' );
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \Lionthemes_Categorytabs_Element() ); 
		require_once( plugin_dir_path( __DIR__ ) . 'elementors/categories.php' );
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \Lionthemes_Categories_Element() );
		require_once( plugin_dir_path( __DIR__ ) . 'elementors/categoriesgird.php' );
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \Lionthemes_Categoriesgird_Element() );
		require_once( plugin_dir_path( __DIR__ ) . 'elementors/countdownevent.php' );
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \Lionthemes_CountdownEvent_Element() );
		require_once( plugin_dir_path( __DIR__ ) . 'elementors/popup.php' );
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \Lionthemes_Popup_Element() ); 
		
	}
}
Lionthemes_Elementor_Extension::instance();

function lionthemes_add_elementor_widget_categories( $elements_manager ) {

		$elements_manager->add_category(
			'lionthemes',
			[
				'title' => __( 'Orfarm Theme Elements', 'orfarm' ),
				'icon' => 'fa fa-star',
			]
		);

	}
add_action( 'elementor/elements/categories_registered', 'lionthemes_add_elementor_widget_categories' );