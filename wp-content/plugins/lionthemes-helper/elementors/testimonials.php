<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

class Lionthemes_Testimonials_Element extends \Elementor\Widget_Base {
	
	public function get_name() {
		return 'testimonials';
	}

	public function get_title() {
		return __( 'Testimonials', 'orfarm' ); 
	}
	public function get_icon() {
		return 'fa fa-thumbs-o-up';
	}
	public function get_categories() {
		return [ 'lionthemes' ];
	}

	protected function _register_controls() {
		$this->start_controls_section(
			'section_tabs',
			[
				'label' => __( 'Testimonials data', 'elementor' ),
			]
		);

		$repeater = new \Elementor\Repeater();

		
		$repeater->add_control(
			'author',
			[
				'label' => __( 'Author', 'orfarm' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'placeholder' => __( 'Enter Author', 'orfarm' ),
				'label_block' => true,
			]
		);
		$repeater->add_control(
			'job',
			[
				'label' => __( 'Job', 'orfarm' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'placeholder' => __( 'Enter Job', 'orfarm' ),
				'label_block' => true,
			]
		);
		$repeater->add_control(
			'avatar',
			[
				'label' => __( 'Avatar', 'orfarm' ),
				'type' => \Elementor\Controls_Manager::MEDIA,
				'label_block' => true,
			]
		);
		$repeater->add_control(
			'reviews',
			[
				'label' => __( 'Reviews Image', 'orfarm' ),
				'type' => \Elementor\Controls_Manager::MEDIA,
				'label_block' => true,
			]
		);
		$repeater->add_control(
			'quote',
			[
				'label' => __( 'Quote', 'orfarm' ),
				'type' => \Elementor\Controls_Manager::TEXTAREA,
				'rows' => 10,
				'placeholder' => __( 'Enter quote', 'orfarm' ),
				'label_block' => true,
			]
		);
		

		$this->add_control(
			'data',
			[
				'label' => __( 'Testimonial Items', 'elementor' ),
				'type' => \Elementor\Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
				'default' => [
					[
						'author' => __( 'Author 1', 'orfarm' ),
					],
					[
						'author' => __( 'Author 2', 'orfarm' ),
					],
				],
				'author_field' => '{{{ author }}}',
			]
		);
		$this->end_controls_section();
		
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
			'show_rate',
			[
				'label' => __( 'Show rate', 'orfarm' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'options' => [
					'yes' => esc_html__( 'Yes', 'orfarm' ),
					'no' => esc_html__( 'No', 'orfarm' ),
				],
				'default' => 'yes'
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
			'number',
			[
				'label' => __( 'Number of products to show', 'orfarm' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'input_type' => 'number',
				'default' => '10'
			]
		);
		$this->add_control(
			'item_style',
			[
				'label' => __( 'Item Design', 'orfarm' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'options' => [
					'style_1' => esc_html__( 'Design 1', 'orfarm' ),
					'style_2' => esc_html__( 'Design 2', 'orfarm' ),
					'style_3' => esc_html__( 'Design 3', 'orfarm' ),
					'style_4' => esc_html__( 'Design 4', 'orfarm' ),
					'style_5' => esc_html__( 'Design 5', 'orfarm' ),
				],
				'default' => 'style_1'
			]
		);
		$this->add_control(
			'style',
			[
				'label' => __( 'Style', 'orfarm' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'options' => [ 
					'list' => esc_html__( 'List', 'orfarm' ),
					'carousel' => esc_html__( 'Carousel', 'orfarm' ),
				],
				'default' => 'carousel'
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
			'columns',
			[
				'label' => __( 'Default Screen width 1200px to 1499px', 'orfarm' ),
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
		$this->end_controls_section();
		$this->start_controls_section(
			'carousel_only',
			[
				'label' => __( 'Carousel', 'orfarm' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);
		$this->add_control(
			'item_layout',
			[
				'label' => __( 'Show on effect', 'orfarm' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'options' => [
					'box' => esc_html__( 'Box', 'orfarm' ),
					'list' => esc_html__( 'List', 'orfarm' ),
					'simple' => esc_html__( 'Simple List', 'orfarm' ),
				],
				'default' => 'box'
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
			'margin',
			[
				'label' => __( 'Spacing', 'orfarm' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'input_type' => 'number',
				'default' => '20'
			]
		);
		$this->end_controls_section();

	}
	protected function render() {
		$settings = $this->get_settings_for_display();
		$data = $this->get_settings_for_display( 'data' );
		$_id = lionthemes_make_id();
		
		$control_nav = (($settings['control_nav'] != '') ? true : false);
		$pagination = (($settings['pagination'] != '') ? true : false);
		$autoplay = (($settings['autoplay'] != '') ? true : false);
		
		$owl_data = '';
		if($settings['style'] == 'carousel'){
			$owl_data .= 'data-owl="slide" data-ow-rtl="false" ';
			$owl_data .= 'data-bigdesk="'. esc_attr($settings['bigdesk']) .'" ';
			$owl_data .= 'data-desksmall="'. esc_attr($settings['desksmall']) .'" ';
			$owl_data .= 'data-bigtablet="'. esc_attr($settings['bigtablet']) .'" ';
			$owl_data .= 'data-tabletsmall="'. esc_attr($settings['tabletsmall']) .'" ';
			$owl_data .= 'data-mobile="'. esc_attr($settings['mobile_count']) .'" ';
			$owl_data .= 'data-tablet="'. esc_attr($settings['tablet_count']) .'" ';
			$owl_data .= 'data-margin="'. esc_attr($settings['margin']) .'" ';
			$owl_data .= 'data-item-slide="'. esc_attr($settings['columns']) .'" ';
			$owl_data .= 'data-autoplay="'. esc_attr($autoplay) .'" ';
			$owl_data .= 'data-nav="'. esc_attr($control_nav) .'" ';
			$owl_data .= 'data-dots="'. esc_attr($pagination) .'" ';
			$owl_data .= 'data-playtimeout="'. esc_attr($settings['playtimeout']) .'" ';
			$owl_data .= 'data-speed="'. esc_attr($settings['speed']) .'" ';
		}
		$showon_effect = ($settings['showon_effect']) ? 'wow ' . $settings['showon_effect'] : '';
		?>
		<?php if(!empty($data)){ ?>
		<div id="testimonial-<?php echo esc_attr($_id); ?>" class="testimonials <?php echo esc_attr($settings['el_class']); ?>">
			<?php if ($settings['title'] || $settings['short_desc']) { ?>
	            <div class="element-widget-title"> 
					<?php if($settings['title']){ ?>
						<h3 class="vc_widget_title vc_testimonial_title <?php echo (($settings['alignment'] != '') ? ' '. $settings['alignment'] : ''); ?>">
							<span><?php echo esc_html($settings['title']); ?></span>
						</h3>
					<?php } ?>
					<?php if($settings['short_desc']){ ?>
						<div class="widget-sub-title <?php echo (($settings['alignment'] != '') ? ' '. $settings['alignment'] : ''); ?>">
							<?php echo nl2br(esc_html($settings['short_desc'])); ?>
						</div>
					<?php } ?>
				</div>
			<?php } ?>
			<div <?php echo ($settings['style'] == 'carousel') ? $owl_data :'' ?> class="testimonials-list<?php echo ($settings['style'] == 'carousel') ? ' owl-carousel owl-theme':'' ?>">
				<?php $i=0; $duration = 100; foreach($data as $item) { 
					if ($item['author'] && $item['avatar'] && $item['quote'] && $item['reviews']) { 
					$i++; ?>
					<!-- Wrapper for slides -->
					<div class="quote <?php echo $settings['showon_effect']; ?> <?php echo ($settings['item_style']) ? $settings['item_style'] : ''; ?>" data-wow-delay="<?php echo $duration; ?>ms" data-wow-duration="0.5s">
						
						<div class="testitop">
							<div class="author">
								<div class="image">
									<img src="<?php echo $item['avatar']['url']; ?>" alt="<?php echo $item['author']; ?>" />
								</div>
							</div>
							<blockquote class="testimonials-text">
									<?php echo nl2br($item['quote']); ?>
							</blockquote>
							<div class="reviews">
								<div class="image-reviews">
									<img src="<?php echo $item['reviews']['url']; ?>"/>
								</div>
							</div>
							<?php if (($settings['show_rate'] != '' && $settings['show_rate'] == 'yes')) { ?>
									<div class="woocommerce">
										<div class="ratings">
											<div class="star-rating" role="img" aria-label="Rated 5.00 out of 5">
												<span style="width:100%">Rated <strong class="rating">5.00</strong> out of 5</span>
											</div>
										</div>
									</div>
								<?php } ?>
							<div class="quote-info">
								<div class="by-author">
									<h5 class="author-name"><?php echo $item['author']; ?></h5>
								</div>
								<div class="testimonial-job">
									<span class="author-job"><?php echo $item['job']; ?></span>
								</div>
							</div>
						</div>
						
					</div>
					<?php 
					$duration = $duration + 100; 
					}
					?>
				<?php } ?>
			</div>
		</div>
		<?php 
		}
		if ($settings['style'] == 'carousel') { ?>
			<script>
				jQuery(document).ready(function($) {
					<?php if (isset($_POST['action']) && $_POST['action'] == 'elementor_ajax') { ?>
					if (typeof owlCarousel !== "undefined") $('#testimonial-<?php echo esc_attr($_id); ?> [data-owl="slide"]').owlCarousel('destroy');
					<?php } ?>
					if (typeof initOwl !== "undefined") initOwl($('#testimonial-<?php echo esc_attr($_id); ?> [data-owl="slide"]'));
				});
			</script>
		<?php }
	}
}