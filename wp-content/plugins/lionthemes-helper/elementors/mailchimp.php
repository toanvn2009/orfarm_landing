<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

class Lionthemes_Mailchimp_Element extends \Elementor\Widget_Base {
	
	public function get_name() {
		return 'mailchimp';
	}

	public function get_title() {
		return __( 'Newsletter Form (Mail Chimp)', 'orfarm' );
	}
	public function get_icon() {
		return 'fa fa-database';
	}
	public function get_categories() {
		return [ 'lionthemes' ];
	}

	protected function _register_controls() {
		
		$this->start_controls_section(
			'general_opt',
			[
				'label' => __( 'General', 'orfarm' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'title',
			[
				'label' => __( 'Title', 'orfarm' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'input_type' => 'text',
			]
		);
		$this->add_control(
			'short_desc',
			[
				'label' => __( 'Short description', 'orfarm' ),
				'type' => \Elementor\Controls_Manager::TEXTAREA,
			]
		);
		$this->add_control(
			'alignment',
			[
				'label' => __( 'Title alignment', 'orfarm' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'options' => [
					'left' => esc_html__( 'Left', 'orfarm' ),
					'center' => esc_html__( 'Center', 'orfarm' ),
					'right' => esc_html__( 'Right', 'orfarm' ),
				],
				'default' => 'center'
			]
		);
		$this->add_control(
			'id',
			[
				'label' => __( 'Form ID', 'orfarm' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'input_type' => 'text',
			]
		);
		$this->add_control(
			'style',
			[
				'label' => __( 'Style', 'orfarm' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'options' => array(
					'style-1'	=> esc_html__( 'Style 1', 'orfarm' ),
					'style-2' 	=> esc_html__( 'Style 2', 'orfarm' ),
					'style-3' 	=> esc_html__( 'Style 3', 'orfarm' ),
				),
				'default' => 'style-1'
			]
		);
		$this->add_control(
			'el_class',
			[
				'label' => __( 'Extra class', 'orfarm' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'input_type' => 'text',
			]
		);
		$this->end_controls_section();
	}
	protected function render() {

		$settings = $this->get_settings_for_display();
		if($settings['id']) { ?>
		<div class="mailchimp_form_widget <?php echo esc_attr($settings['style']) ?> <?php echo esc_attr($settings['el_class']) ?>">
			<?php if($settings['title']) { ?>
				<h3 class="vc_widget_title vc_mailchimp_title <?php echo (($settings['alignment'] != '') ? ' '. $settings['alignment'] : ''); ?>"><span><?php echo esc_html($settings['title']) ?></span></h3>
			<?php } ?>
			<?php if($settings['short_desc']) { ?>
				<div class="widget-sub-title <?php echo (($settings['alignment'] != '') ? ' '. $settings['alignment'] : ''); ?>"><?php echo nl2br($settings['short_desc']) ?></div>
			<?php } ?>
			<?php echo do_shortcode( '[mc4wp_form id="'. intval($settings['id']) .'"]' ) ?>
		</div>
		<?php 
		}
	}
}