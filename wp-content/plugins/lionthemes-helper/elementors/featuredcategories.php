<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

class Lionthemes_Featuredcategories_Element extends \Elementor\Widget_Base {
	
	private function get_taxonomies($tax = 'product_cat') {
		$cats = lionthemes_get_all_taxonomy_terms($tax, true, false);
		return array_flip($cats);
	}

	public function get_name() {
		return 'featuredcategories';
	}

	public function get_title() {
		return __( 'Featured Categories', 'orfarm' );
	}
	public function get_icon() {
		return 'fa fa-bookmark';
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
			'layout',
			[
				'label' => __( 'Layout', 'orfarm' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'options' => [
					'grid' => esc_html__( 'Grid', 'orfarm' ),
					'masonry' => esc_html__( 'Masonry', 'orfarm' ),
				],
				'default' => 'grid'
			]
		);
		$this->add_control(
			'style_type',
			[
				'label' => __( 'Masonry style', 'orfarm' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'options' => [
					'style_1' => esc_html__( 'Style 1', 'orfarm' ),
					'style_2' => esc_html__( 'Style 2', 'orfarm' ),
				],
				'default' => 'style_1'
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
			'showon_effect',
			[
				'label' => __( 'Show on effect', 'orfarm' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'options' => lionthemes_get_effect_list(true),
			]
		);
		$this->end_controls_section();
		
		$this->start_controls_section(
			'responsive_opt',
			[
				'label' => __( 'Responsive columns', 'orfarm' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);
		$this->add_control(
			'bigdesktop',
			[
				'label' => __( 'Extra large (>= 1200px)', 'orfarm' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'options' => [
					'1'	=> '1',
					'2'	=> '2',
					'3'	=> '3',
					'4'	=> '4',
					'5'	=> '5',
					'6'	=> '6',
				],
				'default' => '3'
			]
		);
		$this->add_control(
			'desksmall',
			[
				'label' => __( 'Large (>=992px)', 'orfarm' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'options' => [
					'1'	=> '1',
					'2'	=> '2',
					'3'	=> '3',
					'4'	=> '4',
					'5'	=> '5',
					'6'	=> '6',
				],
				'default' => '3'
			]
		);
		$this->add_control(
			'bigtablet',
			[
				'label' => __( 'Medium (≥768px)', 'orfarm' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'options' => [
					'1'	=> '1',
					'2'	=> '2',
					'3'	=> '3',
					'4'	=> '4',
					'5'	=> '5',
					'6'	=> '6',
				],
				'default' => '2'
			]
		);
		$this->add_control(
			'tablet_count',
			[
				'label' => __( 'Tablet (≥576px)', 'orfarm' ),
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
				'label' => __( 'Mobile (<576px)', 'orfarm' ),
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
			'categories_opt',
			[
				'label' => __( 'Categories selection', 'orfarm' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);
		
		$repeater = new \Elementor\Repeater();

		
		$repeater->add_control(
			'cat_title',
			[
				'label' => __( 'Title', 'orfarm' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'placeholder' => __( 'Empty to use Category name', 'orfarm' ),
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
		
		$repeater->add_control(
			'cat_image',
			[
				'label' => __( 'Category feature image', 'orfarm' ),
				'type' => \Elementor\Controls_Manager::MEDIA,
				'description' => __( 'Image for Category display in this element', 'orfarm')
			]
		);
		
		$repeater->add_control(
			'cat_slug',
			[
				'label' => __( 'Category', 'orfarm' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'options' => $this->get_taxonomies(),
				'label_block' => true,
			]
		);
		

		$this->add_control(
			'cats',
			[
				'label' => __( 'Category Items', 'elementor' ),
				'type' => \Elementor\Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
				'default' => [
					[
						'cat_title' => '',
					],
					[
						'cat_title' => '',
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
		
		$smalest = $this->get_screen_column_class($settings['mobile_count'], 'col-xs');
		$tablet = $this->get_screen_column_class($settings['tablet_count'], 'col-sm');
		$bigtablet = $this->get_screen_column_class($settings['bigtablet'], 'col-md');
		$desksmall = $this->get_screen_column_class($settings['desksmall'], 'col-lg');
		$bigdesktop = $this->get_screen_column_class($settings['bigdesktop'], 'col-xl');
		
		$class_column = $smalest . ' ' . $tablet . ' ' . $bigtablet . ' ' . $desksmall . ' ' . $bigdesktop;
		
		$cats = $this->get_settings_for_display( 'cats' );
		
		
		$title = $settings['title'];
		$showon_effect = ($settings['showon_effect']) ? 'wow ' . $settings['showon_effect'] : '';
		
		if ( !empty($cats) ) { 
		?>
			<div class="lionthemes-feature-categories">
				<?php if($settings['title'] || $settings['short_desc']){ ?>
					<div class="element-widget-title">
						<?php if($title){ ?>
							<h3 class="vc_widget_title widget-title <?php echo (($settings['alignment'] != '') ? ' '. $settings['alignment'] : ''); ?>">
								<span><?php echo wp_kses($title, array('strong' => array())); ?></span>
							</h3>
						<?php } ?>
						<?php if($settings['short_desc']){ ?>
							<div class="widget-sub-title <?php echo (($settings['alignment'] != '') ? ' '. $settings['alignment'] : ''); ?>">
								<?php echo nl2br(esc_html($settings['short_desc'])); ?>
							</div>
						<?php } ?>
					</div>
				<?php } ?>
				<div class="inner-content <?php echo (($settings['style_type'] != '') ? ' '. $settings['style_type'] : ''); ?> <?php echo (($settings['layout'] != '') ? ' '. $settings['layout'] : ''); ?>">
					<div class="row">
					<?php 
					$duration = 100;
					foreach($cats as $cat) {
						if ($cat['cat_slug']) {
							$category = get_term_by('slug', $cat['cat_slug'], 'product_cat'); 
							if ($category) {
								$cat_name = !$cat['cat_title'] ? $category->name : $cat['cat_title'];
								?>
									<div class="cat-item <?php echo (($settings['layout'] != '' && $settings['layout'] == 'grid') ? ' '. $class_column : '') . ' ' . $showon_effect; ?>" data-wow-delay="<?php echo $duration; ?>ms" data-wow-duration="0.5s">
										<div class="cat-inner">
											<?php if (!empty($cat['cat_image']['url'])) { ?> 
												<a href="<?php echo get_term_link($category->term_id); ?>"><img src="<?php echo esc_url($cat['cat_image']['url']); ?>" alt="<?php echo esc_attr($cat_name); ?>" /></a>
											<?php } ?>
											<div class="cat-item-info">
												<h3 class="cat-title"><a href="<?php echo get_term_link($category->term_id); ?>"><?php echo $cat_name; ?></a></h3>
												<?php if (!empty($cat['cat_desc'])) { ?>
												<p class="cat-sub-title"><a href="<?php echo get_term_link($category->term_id); ?>"><?php echo $cat['cat_desc']; ?></a></p>
												<?php } ?>
												<?php if (($settings['show_category_count'] != '' && $settings['show_category_count'] == 'yes')) { ?>
												<span><?php echo sprintf( _n( '(%s Items)', '(%s Items)', $category->count, 'orfarm' ), $category->count ) ?></span>
												<?php } ?>
											</div>
										</div>
									</div>
									<?php $duration = $duration + 100; ?>
								<?php } ?>
							<?php } ?>
					<?php } ?>
					</div>
				</div>
			</div>
		<?php 
		} 
	}
}