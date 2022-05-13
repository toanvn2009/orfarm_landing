<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

class Lionthemes_Socialicons_Element extends \Elementor\Widget_Base {
	
	public function get_name() {
		return 'lionthemes_socialicons';
	}

	public function get_title() {
		return __( 'Social icons - From Theme options', 'orfarm' );
	}
	public function get_icon() {
		return 'fa fa-globe';
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
		$this->end_controls_section();
	}
	protected function render() {
		
		global $orfarm_opt; 
		$settings = $this->get_settings_for_display();
		$orfarm_opt = get_option('orfarm_opt');
		$title = $settings['title'];
		$short_desc = $settings['short_desc'];
		if(isset($orfarm_opt['social_icons'])) { ?>
			<div class="widget widget-social">
			<?php if ( $title ) { ?>
				<h3 class="vc_widget_title vc_socials_title <?php echo (($settings['alignment'] != '') ? ' '. $settings['alignment'] : ''); ?>"><span><?php echo $title ?></span></h3>
			<?php } ?>
			<?php if ( $short_desc ) { ?>
				<div class="widget-sub-title <?php echo (($settings['alignment'] != '') ? ' '. $settings['alignment'] : ''); ?>"><?php echo nl2br($short_desc) ?></div>
			<?php }  ?>
			<ul class="social-icons">
			<?php foreach($orfarm_opt['social_icons'] as $key=>$value ) {  ?>
				<?php if($value!=''){ 
					if($key=='vimeo') { ?>
						<li><a class="<?php echo esc_attr($key) ?> social-icon" href="<?php echo esc_url($value)?>" title="<?php echo ucwords(esc_attr($key))?>" target="_blank"><i class="fa fa-vimeo-square"></i></a></li>
					<?php } elseif ($key=='mail-to') { ?>
						<li><a class="<?php echo esc_attr($key)?> social-icon" href="<?php echo esc_url($value) ?>" title="<?php echo ucwords(esc_attr($key))?>" target="_blank"><i class="fa fa-envelope"></i></a></li>
					<?php } else { ?>
						<li><a class="<?php echo esc_attr($key)?> social-icon" href="<?php echo esc_url($value) ?>" title="<?php echo ucwords(esc_attr($key))?>" target="_blank"><i class="fa fa-<?php echo esc_attr($key)?>"></i></a></li>
					<?php }
				}
			} ?>
			</ul>
			</div>
		<?php }
	}
}