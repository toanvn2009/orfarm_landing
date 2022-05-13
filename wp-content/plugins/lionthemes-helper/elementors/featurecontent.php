<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

class Lionthemes_Featuredcontent_Element extends \Elementor\Widget_Base { 
	
 
	public function get_name() {
		return 'featurecontent';
	}

	public function get_title() {
		return __( 'Feature content', 'orfarm' );
	}
	public function get_icon() {
		return 'fa fa-cogs';
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
			'icon',
			[
				'label' => __( 'Icon shortcode', 'orfarm' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'description' => 'Support <a target="_blank" href="http://astronautweb.co/snippet/font-awesome/">Awesome icons (fa heart)</a> and <a target="_blank" href="https://linearicons.com/free">Linear icons(lnr car)</a>',
				'input_type' => 'text',
			]
		);
		$this->add_control(
			'heading_image',
			[
				'label' => __( 'Heading image', 'orfarm' ),
				'type' => \Elementor\Controls_Manager::MEDIA,
				'description' => __( 'It will replace icon setting above', 'orfarm')
			]
		);
		$this->add_control(
			'feature_text',
			[
				'label' => __( 'Feature text', 'orfarm' ),
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
			'showon_effect',
			[
				'label' => __( 'Show on effect', 'orfarm' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'options' => lionthemes_get_effect_list(true),
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
		
		if($settings['feature_text']) { 
		$showon_effect = ($settings['showon_effect']) ? 'wow ' . $settings['showon_effect'] : '';
		$classes = esc_attr($settings['showon_effect'] . ' ' . $settings['style'] . ' ' . $settings['el_class']); ?>
		<div class="feature_text_widget <?php echo $classes ?>" data-wow-delay="100ms" data-wow-duration="0.5s">
			<div class="feature_icon">
				<?php if($settings['heading_image']){ ?>
					<img src="<?php echo $settings['heading_image']['url']; ?>" alt="<?php echo $settings['feature_text']; ?>" />
				<?php }elseif($settings['icon']){ ?>
					<?php echo do_shortcode('[' . $settings['icon'] . ']') ?>
				<?php } ?>
			</div>
			<div class="feature_content">
				<div class="feature_text <?php echo (($settings['alignment'] != '') ? ' '. $settings['alignment'] : ''); ?>"><?php echo esc_html($settings['feature_text']) ?></div>
				<?php if($settings['short_desc']){ ?>
					<div class="short_desc <?php echo (($settings['alignment'] != '') ? ' '. $settings['alignment'] : ''); ?>"><?php echo nl2br($settings['short_desc']) ?></div>
				<?php } ?>
			</div>
		</div>
		<?php }
	}
}