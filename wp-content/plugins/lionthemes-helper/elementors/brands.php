<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

class Lionthemes_Brands_Element extends \Elementor\Widget_Base {

	public function get_name() {
		return 'ourbrands';
	}

	public function get_title() {
		return __( 'Brand Logos', 'orfarm' );
	}
	public function get_icon() {
		return 'fa fa-cubes';
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
			'style',
			[
				'label' => __( 'Style', 'orfarm' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'options' => [
					'grid'	=> 'Grid',
					'carousel'	=> 'Carousel',
				],
				'default' => 'grid'
			]
		);
		$this->add_control(
			'showon_effect',
			[
				'label' => __( 'Show on effect', 'orfarm' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'options' => lionthemes_get_effect_list()
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
		
		
		
		$this->start_controls_section(
			'grid_columns',
			[
				'label' => __( 'Grid/Carousel Columns', 'orfarm' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);
		$this->add_control(
			'colsnumber',
			[
				'label' => __( 'Number of columns', 'orfarm' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'options' => [
					'1'	=> '1',
					'2'	=> '2',
					'3'	=> '3',
					'4'	=> '4',
					'5'	=> '5',
					'6'	=> '6',
				],
				'default' => '5'
			]
		);
		$this->add_control(
			'rows',
			[
				'label' => __( 'Number of rows', 'orfarm' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'options' => [
					'1'	=> '1',
					'2'	=> '2',
					'3'	=> '3',
					'4'	=> '4',
				],
				'default' => '4'
			]
		);
		$this->add_control(
			'control_nav',
			[
				'label' => __( 'Control Navigation', 'orfarm' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);
		$this->add_control(
			'pagination',
			[
				'label' => __( 'Pagination', 'orfarm' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);
		$this->add_control(
			'autoplay',
			[
				'label' => __( 'Auto rotate', 'orfarm' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);
		$this->add_control(
			'playtimeout',
			[
				'label' => __( 'Play Timeout', 'orfarm' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'input_type' => 'number',
				'default' => '5000'
			]
		);
		$this->add_control(
			'speed',
			[
				'label' => __( 'Rotate speed', 'orfarm' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'input_type' => 'number',
				'default' => '250'
			]
		);
		$this->add_control(
			'bigdesk',
			[
				'label' => __( 'Screen width over 1500px', 'orfarm' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'options' => [
					'1'	=> '1',
					'2'	=> '2',
					'3'	=> '3',
					'4'	=> '4',
					'5'	=> '5',
					'6'	=> '6',
				],
				'default' => '5'
			]
		);
		$this->add_control(
			'desksmall',
			[
				'label' => __( 'Screen width 992px to 1199px', 'orfarm' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'options' => [
					'1'	=> '1',
					'2'	=> '2',
					'3'	=> '3',
					'4'	=> '4',
					'5'	=> '5',
					'6'	=> '6',
				],
				'default' => '4'
			]
		);
		$this->add_control(
			'bigtablet',
			[
				'label' => __( 'Screen width 768px to 991px', 'orfarm' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'options' => [
					'1'	=> '1',
					'2'	=> '2',
					'3'	=> '3',
					'4'	=> '4',
					'5'	=> '5',
					'6'	=> '6',
				],
				'default' => '4'
			]
		);
		$this->add_control(
			'tablet_count',
			[
				'label' => __( 'Screen width 640px to 767px', 'orfarm' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'options' => [
					'1'	=> '1',
					'2'	=> '2',
					'3'	=> '3',
					'4'	=> '4',
					'5'	=> '5',
				],
				'default' => '3'
			]
		);
		$this->add_control(
			'tabletsmall',
			[
				'label' => __( 'Screen width 480px to 639px', 'orfarm' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'options' => [
					'1'	=> '1',
					'2'	=> '2',
					'3'	=> '3',
					'4'	=> '4',
					'5'	=> '5',
				],
				'default' => '2'
			]
		);
		$this->add_control(
			'mobile_count',
			[
				'label' => __( 'Screen width under 479px', 'orfarm' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'options' => [
					'1'	=> '1',
					'2'	=> '2',
					'3'	=> '3',
					'4'	=> '4',
				],
				'default' => '1'
			]
		);
		$this->add_control(
			'margin',
			[
				'label' => __( 'Spacing', 'orfarm' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'input_type' => 'number',
				'default' => '20'
			]
		);
		$this->end_controls_section();
		
		
		
		$this->start_controls_section(
			'brands_opt',
			[
				'label' => __( 'Brand logos', 'orfarm' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);
		
		$repeater = new \Elementor\Repeater();

		
		$repeater->add_control(
			'title',
			[
				'label' => __( 'Title', 'orfarm' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'placeholder' => __( 'Brand title', 'orfarm' ),
				'label_block' => true,
			]
		);
		$repeater->add_control(
			'link',
			[
				'label' => __( 'Link', 'orfarm' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => __( '#', 'orfarm' ),
				'placeholder' => __( 'Brand url', 'orfarm' ),
				'label_block' => true,
			]
		);
		
		$repeater->add_control(
			'image',
			[
				'label' => __( 'Logo', 'orfarm' ),
				'type' => \Elementor\Controls_Manager::MEDIA,
			]
		);
		

		$this->add_control(
			'brands',
			[
				'label' => __( 'Brand Items', 'elementor' ),
				'type' => \Elementor\Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
				'default' => [
					[
						'title' => '',
					],
					[
						'title' => '',
					],
				],
			]
		);
		
		$this->end_controls_section();
	}
	
	protected function get_screen_column_class($col, $prefix) {
		switch ($col) {
			case '6':
				return $prefix . '-2';
			case '5':
				return $prefix . '-20';
			case '4':
				return $prefix . '-3';
			case '3':
				return $prefix . '-4';
			case '2':
				return $prefix . '-6';
			default:
				return $prefix . '-12';	
		}
	}
	
	protected function render() {
		$settings = $this->get_settings_for_display();
		
		
		$brands = $this->get_settings_for_display( 'brands' );
		
		$smalest = $this->get_screen_column_class($settings['mobile_count'], 'col-xs');
		$tablet = $this->get_screen_column_class($settings['tablet_count'], 'col-sm');
		$bigtablet = $this->get_screen_column_class($settings['bigtablet'], 'col-md');
		$desksmall = $this->get_screen_column_class($settings['desksmall'], 'col-lg');
		$bigdesktop = $this->get_screen_column_class($settings['bigdesk'], 'col-xl');
		
		$class_column = $smalest . ' ' . $tablet . ' ' . $bigtablet . ' ' . $desksmall . ' ' . $bigdesktop;
		
		if(count($brands) <= 0) return;
		
		$control_nav = (($settings['control_nav'] != '') ? true : false);
		$pagination = (($settings['pagination'] != '') ? true : false);
		$autoplay = (($settings['autoplay'] != '') ? true : false);
		$owl_data = '';
		if($settings['style'] == 'carousel'){
			$owl_data .= 'data-owl="slide" data-ow-rtl="false" ';
			$owl_data .= 'data-desksmall="'. esc_attr($settings['desksmall']) .'" ';
			$owl_data .= 'data-tabletsmall="'. esc_attr($settings['tabletsmall']) .'" ';
			$owl_data .= 'data-bigtablet="'. esc_attr($settings['bigtablet']) .'" ';
			$owl_data .= 'data-mobile="'. esc_attr($settings['mobile_count']) .'" ';
			$owl_data .= 'data-tablet="'. esc_attr($settings['tablet_count']) .'" ';
			$owl_data .= 'data-margin="'. esc_attr($settings['margin']) .'" ';
			$owl_data .= 'data-item-slide="'. esc_attr($settings['colsnumber']) .'" ';
			$owl_data .= 'data-autoplay="'. esc_attr($autoplay) .'" ';
			$owl_data .= 'data-nav="'. esc_attr($control_nav) .'" ';
			$owl_data .= 'data-dots="'. esc_attr($pagination) .'" ';
			$owl_data .= 'data-playtimeout="'. esc_attr($settings['playtimeout']) .'" ';
			$owl_data .= 'data-speed="'. esc_attr($settings['speed']) .'" ';
		}
		$showon_effect = ($settings['showon_effect']) ? 'wow ' . $settings['showon_effect'] : ''; 
		$title = $settings['title'];	
		$el_class = $settings['el_class'];	
		$style = $settings['style'];	
		$rows = $settings['rows'];	
		$short_desc = $settings['short_desc'];	 
		?>
		
		<div class="brand_widget <?php echo esc_attr($el_class) ?>">
			<?php if ( $title ||  $short_desc) { ?>
				<div class="element-widget-title"> 
				<?php if($title){ ?>
					<h3 class="widget-title vc-brands-title <?php echo (($settings['alignment'] != '') ? ' '. $settings['alignment'] : ''); ?>"><span><?php echo esc_html($title) ?></span></h3>
				<?php } ?>
				<?php if ( $short_desc ) { ?>
						<div class="widget-sub-title <?php echo (($settings['alignment'] != '') ? ' '. $settings['alignment'] : ''); ?>"><?php echo nl2br($short_desc) ?></div>
				<?php } ?> 
				</div> 
			<?php }
			if($style == 'grid'){ 
				$wrapdiv = '<div class="brands-gird row">';  
			}else{
				$class_column = '';
				$wrapdiv = '<div '. $owl_data .' class="owl-carousel owl-theme brands-slide">';
			}
			echo $wrapdiv; 
			$duration = 100;
			$brand_index = 0;
			foreach($brands as $brand) {
				if(!empty($brand['image']['url'])) {
					$image = $brand['image']['url'];
					$brand_index ++;
					?>
					<?php if($style == 'carousel' && $rows > 1){ ?>
						<?php if ( (0 == ( $brand_index - 1 ) % $rows ) || $brand_index == 1) { ?>
							<div class="group">
						<?php } ?>
					<?php } ?>
					<div class="brand_item <?php echo $showon_effect; ?> <?php echo $class_column; ?>" data-wow-delay="<?php echo $duration ?>ms" data-wow-duration="0.5s">
						<a href="<?php echo esc_url($brand['link'] ? $brand['link'] : '#'); ?>" title="<?php echo $brand['title']; ?>" target="_blank">
							<img src="<?php echo $image; ?>" alt="<?php echo esc_html($brand['title']); ?>" />
						</a>
					</div>
					<?php if($style == 'carousel' && $rows > 1){ ?>
						<?php if ( ( ( 0 == $brand_index % $rows || $brandfound == $brand_index ))  ) { ?>
							</div>
						<?php } ?>
					<?php } ?>
					<?php $duration = $duration + 100; 
				}
			} 
			echo '</div>';
			?>
		</div>
		<?php
		if ($settings['style'] == 'carousel') { ?>
			<script>
				jQuery(document).ready(function($) {
					<?php if (isset($_POST['action']) && $_POST['action'] == 'elementor_ajax') { ?>
					if (typeof owlCarousel !== "undefined") $('.brand_widget [data-owl="slide"]').owlCarousel('destroy');
					<?php } ?>
					if (typeof initOwl !== "undefined") initOwl($('.brand_widget [data-owl="slide"]'));
				});
			</script>
		<?php }
	}
}