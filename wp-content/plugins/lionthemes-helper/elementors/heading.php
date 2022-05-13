<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

class Lionthemes_Heading_Element extends \Elementor\Widget_Base {
	
	public function get_name() {
		return 'lionthemes_heading';
	}

	public function get_title() {
		return __( 'Dynamic Heading', 'orfarm' );
	}
	public function get_icon() {
		return 'fa fa-graduation-cap';
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
			'subtitle',
			[
				'label' => __( 'Sub heading', 'orfarm' ),
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
			'heading_image',
			[
				'label' => __( 'Heading image', 'orfarm' ),
				'type' => \Elementor\Controls_Manager::MEDIA,
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
					'style-4' 	=> esc_html__( 'Style 4', 'orfarm' ),
					'style-5' 	=> esc_html__( 'Style 5', 'orfarm' ),
				),
				'default' => 'style-1'
			]
		);
		$this->end_controls_section();
	}
	protected function render() {

		$settings = $this->get_settings_for_display();
		$title = $settings['title'];
		$subtitle = $settings['subtitle'];
		$heading_image = $settings['heading_image']['url'];
		$style = $settings['style']; ?>
		
		<div class="widget widget-lionthemes-heading <?php echo $style ?>">
		<?php if ( $title ) { ?>
			<h3 class="vc_widget_title vc_heading_title <?php echo (($settings['alignment'] != '') ? ' '. $settings['alignment'] : ''); ?>"><span><?php echo wp_kses($title, array('strong' => array())) ?></span></h3>
		<?php }
		if ( $subtitle ) { ?>
			<div class="widget-sub-title <?php echo (($settings['alignment'] != '') ? ' '. $settings['alignment'] : ''); ?>"><?php echo nl2br($subtitle) ?></div>
		<?php }
		if ( $heading_image ) { ?>
			<img src="<?php echo esc_url($heading_image) ?>" alt="'<?php echo esc_html($title) ?>" />
		<?php } ?>
		</div>
		<?php
	}
}