<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

class Lionthemes_Categories_Element extends \Elementor\Widget_Base { 
	
	private function get_taxonomies($tax = 'product_cat') {
		$cats = lionthemes_get_all_taxonomy_terms($tax, true, false);
		return array_flip($cats);
	}

	public function get_name() {
		return 'categories';
	}

	public function get_title() {
		return __( 'Categories', 'orfarm' );
	}
	public function get_icon() {
		return 'fa fa-folder-open';
	}
	public function get_categories() {
		return [ 'lionthemes' ];
	}

	protected function _register_controls() {
		
		$this->start_controls_section(
			'section_tabs',
			[
				'label' => __( 'Categories', 'elementor' ),
			]
		);

		$repeater = new \Elementor\Repeater();

		
		$repeater->add_control(
			'tab_title',
			[
				'label' => __( 'Title', 'orfarm' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => __( 'Categories Title', 'orfarm' ),
				'placeholder' => __( 'Categories Title', 'orfarm' ),
				'label_block' => true, 
			]
		);
		$repeater->add_control(
			'cat_desc',
			[
				'label' => __( 'Description', 'orfarm' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => __( 'Category Description', 'orfarm' ),
				'placeholder' => __( 'Category Description', 'orfarm' ),
				'label_block' => true,
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
		$repeater->add_control(
			'categories',
			[
				'label' => __( 'Categories', 'orfarm' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'options' => $this->get_taxonomies(),
				'label_block' => true,
			]
		);
		$repeater->add_control(
			'image',
			[
				'label' => __( 'Image', 'orfarm' ),
				'type' => \Elementor\Controls_Manager::MEDIA,
				'label_block' => true,
			]
		);

		$this->add_control(
			'tabs',
			[
				'label' => __( 'Categories Items', 'elementor' ),
				'type' => \Elementor\Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
				'default' => [
					[
						'tab_title' => __( 'Categories #1', 'orfarm' ),
					],
					[
						'tab_title' => __( 'Categories #2', 'orfarm' ),
					],
				],
				'title_field' => '{{{ tab_title }}}',
			]
		);

		$this->add_control(
			'view',
			[
				'label' => __( 'View', 'orfarm' ),
				'type' => \Elementor\Controls_Manager::HIDDEN,
				'default' => 'traditional',
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
			'item_style',
			[
				'label' => __( 'Item Design', 'orfarm' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'options' => [
					'style_1' => esc_html__( 'Style 1', 'orfarm' ),
					'style_2' => esc_html__( 'Style 2', 'orfarm' ),
					'style_3' => esc_html__( 'Style 3', 'orfarm' ),
					'style_4' => esc_html__( 'Style 4', 'orfarm' ),
				],
				'default' => 'style_1'
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
					'7'	=> '7',
					'8'	=> '8',
				],
				'default' => '5'
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
					'mansoy'	=> 'Mansoy',
				],
				'default' => 'grid'
			]
		);
		$this->add_control(
			'show_category_count',
			[
				'label' => __( 'Show category count', 'orfarm' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'options' => [
					'yes' => esc_html__( 'Yes', 'orfarm' ),
					'no' => esc_html__( 'No', 'orfarm' ),
				],
				'default' => 'yes'
			]
		);
		$this->add_control(
			'show_sub_list',
			[
				'label' => __( 'Show sub categories', 'orfarm' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'options' => [
					'yes' => esc_html__( 'Yes', 'orfarm' ),
					'no' => esc_html__( 'No', 'orfarm' ),
				],
				'default' => 'yes'
			]
		);
		$this->add_control(
			'limit_sub_list',
			[
				'label' => __( 'Limit sub categories', 'orfarm' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'input_type' => 'text',
				'default' => '4'
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
					'7'	=> '7',
					'8'	=> '8',
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

	}
	protected function render() {
		
		$settings = $this->get_settings_for_display();
		
		
		switch ($settings['colsnumber']) {
			case '6':
				$class_column='col-sm-2 col-xs-6';
				break;
			case '5':
				$class_column='col-md-20 col-sm-4 col-xs-6';
				break;
			case '4':
				$class_column='col-sm-3 col-xs-6';
				break;
			case '3':
				$class_column='col-sm-4 col-xs-6';
				break;
			case '2':
				$class_column='col-sm-6 col-xs-6';
				break;
			default:
				$class_column='col-sm-12 col-xs-6';
				break;
		}
		$control_nav = (($settings['control_nav'] != '') ? true : false);
		$pagination = (($settings['pagination'] != '') ? true : false);
		$autoplay = (($settings['autoplay'] != '') ? true : false);
		$owl_data = '';
		if($settings['style'] == 'carousel'){
			$owl_data .= 'data-owl="slide" data-ow-rtl="false" ';
			$owl_data .= 'data-data-desksmall="'. esc_attr($settings['desksmall']) .'" ';
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
		$terms = $this->get_settings_for_display( 'tabs' );
		$title = $settings['title'];
		$short_desc = $settings['short_desc'];
		$el_class = $settings['el_class'];
		$item_style = $settings['item_style'];
		$rows = $settings['rows'];
		$style = $settings['style'];	
		$showon_effect = ($settings['showon_effect']) ? 'wow ' . $settings['showon_effect'] : '';
		if($style == 'grid'){ 
			$wrapdiv = '<div class="featured-gird">';  
		}elseif($style == 'carousel'){
			$class_column = '';
			$wrapdiv = '<div '. $owl_data .' class="owl-carousel owl-theme featured-slide">';
		}else{
			$wrapdiv = '<div class="row">';
		}
		$featuredfound = count($terms);
		$featured_index = 0;
		if ( !empty($terms) ){ 
		?>
			<div class="lionthemes-featured-categories <?php echo esc_attr($el_class); ?> <?php echo ($item_style) ? $item_style : ''; ?>">
				<?php if($title){ ?>
					<h3 class="vc_widget_title <?php echo (($settings['alignment'] != '') ? ' '. $settings['alignment'] : ''); ?>">
						<span><?php echo wp_kses($title, array('strong' => array())); ?></span>
					</h3>
				<?php } ?>
				<?php if($short_desc){ ?>
					<div class="widget-sub-title">
						<?php echo nl2br(esc_html($short_desc)); ?>
					</div>
				<?php } ?>
				<div class="inner-content-featured <?php echo (($settings['style'] != '') ? ' '. $settings['style'] : ''); ?>">
					<?php 
					echo $wrapdiv; 
					$duration = 100;
					$count = 0;
					foreach($terms as $item){
						if($item['categories']){
							$cat = get_term_by('slug', $item['categories'], 'product_cat');
							$featured_index ++;
							?>
							<?php if($style == 'carousel' && $rows > 1){ ?>
								<?php if ( (0 == ( $featured_index - 1 ) % $rows ) || $featured_index == 1) { ?>
									<div class="group">
								<?php } ?>
							<?php } ?>
							<?php if ($cat) { ?>
							<div class="cat-item <?php echo (($settings['style'] != '' && $settings['style'] == 'grid') ? ' '. $class_column : '') . ' ' . $showon_effect; ?>" data-wow-delay="<?php echo $duration; ?>ms" data-wow-duration="0.5s">
								<div class="cat-inner">
									<?php if (!empty($item['image']['url'])) { ?>
										<a href="<?php echo get_term_link($cat->term_id); ?>"><img src="<?php echo esc_url($item['image']['url']); ?>" alt="<?php echo esc_attr($cat->name); ?>" /></a>
									<?php } ?>
									<div class="cat-item-info">
										<h3 class="cat-title"><a href="<?php echo get_term_link($cat->term_id); ?>"><?php echo (($item['tab_title'] != '') ? $item['tab_title'] : $cat->name); ?></a></h3>
										<?php if (!empty($item['cat_desc'])) { ?>
											<p class="cat-sub-title"><?php echo $item['cat_desc']; ?></p>
										<?php } ?>
										<?php if (($settings['show_category_count'] != '' && $settings['show_category_count'] == 'yes')) { ?>
											<span><?php echo sprintf( _n( '%s <span>items</span>', '%s <span>items</span>', $cat->count, 'orfarm' ), $cat->count ) ?></span>
										<?php } ?>
									</div>
									<?php if(isset($settings['show_sub_list']) && $settings['show_sub_list']=='yes'){ ?>
											<ul class="sub_categories">
											<?php 
												  $categories = get_terms( array(
														'taxonomy' => 'product_cat',
														'hide_empty' => false,
														'parent' => $cat->term_id // or 
														//'child_of' => 17 // to target not only direct children
													) );
													$i = 0; 
													foreach($categories as $category) { 
														$i++;
														if ( $i <= $settings['limit_sub_list'] ) {
														    echo '<li><a href="' . get_category_link( $category->term_id ) . '" title="' . sprintf( __( "View all posts in %s" ), $category->name ) . '" ' . '>' . $category->name.'</a></li>  ';
														} else {
															  echo '<li class="sub_hide"><a href="' . get_category_link( $category->term_id ) . '" title="' . sprintf( __( "View all posts in %s" ), $category->name ) . '" ' . '>' . $category->name.'</a></li>  ';
														}	
													}
													if($i > $settings['limit_sub_list']) {
														echo '<li class="show_all">show all</li>';
													}
											?>
											</ul>
									<?php } ?>
								</div>
							</div>
							<?php } ?>
							<?php if($style == 'carousel' && $rows > 1){ ?>
								<?php if ( ( ( 0 == $featured_index % $rows || $featuredfound == $featured_index ))  ) { ?>
									</div>
								<?php } ?>
							<?php } ?> 
							<?php $duration = $duration + 100; $count++; ?>
						<?php }?>
					<?php } ?>
					</div>
				</div>
			</div>
		<?php 
			if ($settings['style'] == 'carousel') { ?>
				<script>
					jQuery(document).ready(function($) {
						<?php if (isset($_POST['action']) && $_POST['action'] == 'elementor_ajax') { ?>
						if (typeof owlCarousel !== "undefined") $('.lionthemes-featured-categories [data-owl="slide"]').owlCarousel('destroy');
						<?php } ?>
						if (typeof initOwl !== "undefined") initOwl($('.lionthemes-featured-categories [data-owl="slide"]'));
					});
				</script>
		<?php }
		} 
	}
}