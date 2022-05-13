<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

class Lionthemes_Categorytabs_Element extends \Elementor\Widget_Base {
	
	private function get_taxonomies($tax = 'product_cat') {
		$cats = lionthemes_get_all_taxonomy_terms($tax, true, false);
		return array_flip($cats);
	}

	public function get_name() {
		return 'categorytabs';
	}

	public function get_title() {
		return __( 'Products Category tabs', 'orfarm' ); 
	}
	public function get_icon() {
		return 'fa fa-shopping-cart';
	}
	public function get_categories() {
		return [ 'lionthemes' ];
	}
	protected function _register_controls() {
		
		$this->start_controls_section(
			'section_tabs',
			[
				'label' => __( 'Tabs', 'elementor' ),
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
		
		$repeater = new \Elementor\Repeater();

		
		$repeater->add_control(
			'tab_title',
			[
				'label' => __( 'Title & Description', 'orfarm' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => __( 'Tab Title', 'orfarm' ),
				'placeholder' => __( 'Tab Title', 'orfarm' ),
				'label_block' => true,
			]
		);
		
		$repeater->add_control(
			'tab_icon',
			[
				'label' => __( 'Tab image icon', 'orfarm' ),
				'type' => \Elementor\Controls_Manager::MEDIA,
				'description' => __( 'It will display before the title', 'orfarm')
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
		

		$this->add_control(
			'tabs',
			[
				'label' => __( 'Tabs Items', 'elementor' ),
				'type' => \Elementor\Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
				'default' => [
					[
						'tab_title' => __( 'Tab #1', 'orfarm' ),
					],
					[
						'tab_title' => __( 'Tab #2', 'orfarm' ),
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
			'show_desc',
			[
				'label' => __( 'Show description', 'orfarm' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'return_value' => 'yes',
				'default' => 'yes',
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
			'style',
			[
				'label' => __( 'Style', 'orfarm' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'options' => [
					'grid' => esc_html__( 'Grid', 'orfarm' ),
					'list' => esc_html__( 'List', 'orfarm' ),
					'carousel' => esc_html__( 'Carousel', 'orfarm' ),
				],
				'default' => 'carousel'
			]
		);
		$this->add_control(
			'product_tab_style',
			[
				'label' => __( 'Product tab style', 'orfarm' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'options' => [
					'style_1' => esc_html__( 'Style 1', 'orfarm' ),
					'style_2' => esc_html__( 'Style 2', 'orfarm' ),
					'style_3' => esc_html__( 'Style 3', 'orfarm' ),
				],
				'default' => 'style_1'
			]
		);
		$this->add_control(
			'show_icon',
			[
				'label' => __( 'Hide category icon', 'orfarm' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);
        $this->add_control(
			'show_sold',
			[
				'label' => __( 'Show sold', 'orfarm' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'return_value' => 'yes',
				'default' => 'no', 
			]
		);
		$this->add_control(
			'hide_actions',
			[
				'label' => __( 'Hide action', 'orfarm' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'return_value' => 'yes',
				'default' => 'yes',
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
				'label' => __( 'Default Columns', 'orfarm' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'options' => [
					'1'	=> '1',
					'2'	=> '2',
					'3'	=> '3',
					'4'	=> '4',
					'5'	=> '5',
					'6'	=> '6',
					'7'	=> '7',
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
					'7'	=> '7',
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
					'7'	=> '7',
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
				'default' => '1'
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
			'enable_dots',
			[
				'label' => __( 'Pagination Dots', 'orfarm' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'return_value' => 'yes',
				'default' => 'no',
			]
		);
		$this->add_control(
			'enable_nav',
			[
				'label' => __( 'Navigations', 'orfarm' ),
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
		$tabs = $this->get_settings_for_display( 'tabs' );
		switch ($settings['columns']) {
			case '6':
				$class_column='col-lg-2 col-md-3 col-sm-4 col-xs-12';
				break;
			case '5':
				$class_column='col-lg-20 col-md-3 col-sm-4 col-xs-12';
				break;
			case '4':
				$class_column='col-lg-3 col-md-4 col-sm-6 col-xs-12';
				break;
			case '3':
				$class_column='col-md-4 col-sm-6 col-xs-12';
				break;
			case '2':
				$class_column='col-md-6 col-sm-6 col-xs-12';
				break;
			default:
				$class_column='col-md-3 col-sm-6 col-xs-12';
				break;
		}
		$autoplay = (($settings['autoplay'] != '') ? true : false);
		$owl_data = 'data-owl="slide" data-ow-rtl="false" ';
		$owl_data .= 'data-dots="'. ($settings['enable_dots'] == 'yes' ? 'true' : 'false') .'" ';
		$owl_data .= 'data-nav="'. ($settings['enable_nav'] == 'yes' ? 'true' : 'false') .'" ';
		$owl_data .= 'data-bigdesk="'. esc_attr($settings['bigdesk']) .'" ';
		$owl_data .= 'data-desksmall="'. esc_attr($settings['desksmall']) .'" ';
		$owl_data .= 'data-bigtablet="'. esc_attr($settings['bigtablet']) .'" ';
		$owl_data .= 'data-tabletsmall="'. esc_attr($settings['tabletsmall']) .'" ';
		$owl_data .= 'data-mobile="'. esc_attr($settings['mobile_count']) .'" ';
		$owl_data .= 'data-tablet="'. esc_attr($settings['tablet_count']) .'" ';
		$owl_data .= 'data-margin="'. esc_attr($settings['margin']) .'" ';
		$owl_data .= 'data-item-slide="'. esc_attr($settings['columns']) .'" ';
		$owl_data .= 'data-autoplay="'. esc_attr($autoplay) .'" ';
		$owl_data .= 'data-playtimeout="'. esc_attr($settings['playtimeout']) .'" ';
		$owl_data .= 'data-speed="'. esc_attr($settings['speed']) .'" '; 
		?>
		<div class="categories-tabs-widget <?php echo esc_attr($settings['el_class']); ?>  <?php echo $settings['product_tab_style']; ?>">
			<div class="categories-tabs-title">
				<?php if ($settings['title'] || $settings['short_desc']) { ?>
					<div class="element-widget-title"> 
						<?php if($settings['title']){ ?>
							<h3 class="vc_widget_title <?php echo (($settings['alignment'] != '') ? ' '. $settings['alignment'] : ''); ?>"><span><?php echo wp_kses($settings['title'], array('strong' => array())) ?></span></h3>
						<?php } ?>
						<?php if($settings['short_desc']){ ?>
							<div class="widget-sub-title <?php echo (($settings['alignment'] != '') ? ' '. $settings['alignment'] : ''); ?>"><?php echo nl2br(strip_tags($settings['short_desc'])) ?></div>
						<?php } ?>
					</div>
				<?php } ?>
				<ul class="category-tab-actions">
					<?php foreach($tabs as $index=>$item){  
					$category = get_term_by('slug', $item['categories'], 'product_cat'); 
					$tab_name = !$item['tab_title'] ? $category->name : $item['tab_title'];
					?>
					<li class="category-tab <?php echo ($index == 0) ? 'active':''; ?>">
						<a href="javascript:void(0)">
							<?php if($item['tab_icon'] && $item['tab_icon']['url']){ ?>
								<span class="cate-icon">
									<img src="<?php echo $item['tab_icon']['url']; ?>" alt="<?php echo $tab_name; ?>" />
								</span>
							<?php } ?>
							<span class="cat-name">
								<?php echo $tab_name; ?>
							</span>
						</a>
					</li>
					<?php } ?>
				</ul>
			</div>
			<div class="category-tab-contents">
			<?php
			foreach($tabs as $index=>$item){ ?>
				<div class="category-tab-content <?php echo ($index == 0) ? 'active':''; ?>">
				<?php
				$_id = lionthemes_make_id();
				$loop = orfarm_woocommerce_query('', $settings['number'], $item['categories']);
				if ( $loop->have_posts() ){ 
				?>
					<?php $_total = $loop->found_posts; ?>
					<div class="woocommerce">
						
						<div class="inner-content">
							
							<?php wc_get_template( 'product-layout/'.$settings['style'].'.php', array( 
									'show_rating' => true,
									'showdesc' => $settings['show_desc'],
                                    'showsold' => $settings['show_sold'],
									'_id'=>$_id,
									'loop'=>$loop,
									'columns_count'=>$settings['columns'],
									'class_column' => $class_column,
									'_total'=>$_total,
									'number'=>$settings['number'],
									'rows'=>$settings['rows'],
									'owl_data'=>$owl_data,
									'showoneffect' => $settings['showon_effect'],
									'hideactions' => $settings['hide_actions'],
									'itemlayout'=> $settings['item_layout'],
									) ); ?>
						</div>
					</div>
				<?php } ?>
				</div>
			<?php } ?>
			</div>
		</div>
		<?php
		if ($settings['style'] == 'carousel') { ?>
			<script>
				jQuery(document).ready(function($) {
					<?php if (isset($_POST['action']) && $_POST['action'] == 'elementor_ajax') { ?>
					if (typeof owlCarousel !== "undefined") $('.category-tab-contents [data-owl="slide"]').owlCarousel('destroy');
					<?php } ?>
					if (typeof initOwl !== "undefined") initOwl($('.category-tab-contents [data-owl="slide"]'));
				});
			</script>
		<?php }
	}
}