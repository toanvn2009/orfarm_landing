<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

class Lionthemes_Popup_Element extends \Elementor\Widget_Base {

	public function get_name() {
		return 'popup';
	}

	public function get_title() {
		return __( 'Popup', 'orfarm' ); 
	} 
	public function get_icon() {
		return 'fa fa-newspaper-o';
	}
	public function get_categories() {
		return [ 'lionthemes' ];
	}
	private function get_taxonomies($tax = 'product_cat') {
		$cats = lionthemes_get_all_taxonomy_terms($tax, true, false);
		return array_flip($cats);
	}

	protected function _register_controls() { 
		$this->start_controls_section(
			'type_popup_opt',
			[
				'label' => __( 'Popup', 'orfarm' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		
		$this->add_control(
			'enable_popup',
			[
				'label' => __( 'Enable', 'orfarm' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);
	

		$this->add_control(
			'popup_onload_form',
			[
				'label' => __( 'Short code', 'orfarm' ),
				'type' => \Elementor\Controls_Manager::TEXTAREA,
				'input_type' => 'text',
			]
		);
		
		$this->add_control(
			'popup_width',
			[
				'label' => __( 'Width Popup', 'orfarm' ),
				'type' => \Elementor\Controls_Manager::TEXTAREA,
				'input_type' => 'text',
				'default' =>850
			]
		);
		
		$this->add_control(
			'enable_width',
			[
				'label' => __( 'Set Width Popup', 'orfarm' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);		
			
		$this->add_control(
			'popup_onload_expires',
			[
				'label' => __( 'Time expires', 'orfarm' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'input_type' => 'text',
				'default' =>1
			]
		);
	
	
		
		$this->end_controls_section();
		
		
	}
	protected function render() {
		$settings = $this->get_settings_for_display();
		if(!$settings['enable_popup']) return;
		$_id = lionthemes_make_id();
		$_page_id = get_queried_object_id();
		$no_again = 0; 
		$_cookie_id ="no_again_".$_page_id;
		if(isset($_COOKIE[$_cookie_id])){ 
			$no_again = $_COOKIE[$_cookie_id];
		} 
		if( $no_again > 0 )  return;

			include 'popup/popup_type1.php';
		
	}
}