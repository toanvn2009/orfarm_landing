<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

class Lionthemes_Product_Element extends \Elementor\Widget_Base {
	
	private function get_taxonomies($tax = 'product_cat') {
		$cats = lionthemes_get_all_taxonomy_terms($tax, true, false);
		return array_flip($cats);
	}

	public function get_name() {
		return 'specifyproducts';
	}

	public function get_title() {
		return __( 'WooCommerce Products', 'orfarm' );
	}
	public function get_icon() {
		return 'fa fa-shopping-cart';
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
			'type',
			[
				'label' => __( 'Type', 'orfarm' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'options' => array(
					'best_selling'		=> esc_html__( 'Best Selling', 'orfarm' ),
					'featured_product' 	=> esc_html__( 'Featured Products', 'orfarm' ),
					'top_rate' 			=> esc_html__( 'Top Rate', 'orfarm' ),
					'recent_product' 	=> esc_html__( 'Recent Products', 'orfarm' ),
					'on_sale' 			=> esc_html__( 'On Sale', 'orfarm' ),
					'recent_review' 	=> esc_html__( 'Recent Review', 'orfarm' ),
					'deals'		 		=> esc_html__( 'Product Deals', 'orfarm' )
				),
				'default' => 'recent_product'
			]
		);
		$this->add_control(
			'in_category',
			[
				'label' => __( 'Category Only', 'orfarm' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'options' => $this->get_taxonomies(),
			]
		);
		$this->add_control(
			'number',
			[
				'label' => __( 'Maximum Products', 'orfarm' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'input_type' => 'number',
				'default' => '20'
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
			'style',
			[
				'label' => __( 'Interface', 'orfarm' ),
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
			'deal_style',
			[
				'label' => __( 'Product deal style', 'orfarm' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'options' => [
					'style_1' => esc_html__( 'Style 1', 'orfarm' ),
					'style_2' => esc_html__( 'Style 2', 'orfarm' ),
				],
				'default' => 'style_1'
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
				'default' => 'no', 
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
			'end_date',
			[
				'label' => __( 'Finish Event Date/Time', 'orfarm' ),
				'type' => \Elementor\Controls_Manager::DATE_TIME,
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
		
		if($settings['end_date']) {
			$_id = lionthemes_make_id();
				$end = strtotime( $this->get_settings( 'end_date' ) );
				$now = strtotime('now');
				$left = $end - $now;
				$week_left = $day_left = $hours_left = $mins_left = $secs_left = 0;
				if ($left > 0) {
					$day_left = floor($left / (24 * 60 * 60));
					$week_left = floor($day_left / 7);
					$hours_left = floor(($left - ($day_left * 60 * 60 * 24)) / (60 * 60));
					$mins_left = floor(($left - ($day_left * 60 * 60 * 24) - ($hours_left * 60 * 60)) / 60);
					$secs_left = floor($left - ($day_left * 60 * 60 * 24) - ($hours_left * 60 * 60) - ($mins_left * 60));
			}
		}
		
		
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
			case '1':
				$class_column='col-md-12 col-sm-12 col-xs-12';
				break;	
			default:
				$class_column='col-md-3 col-sm-6 col-xs-12';
				break;
		}
		if($settings['type']) {
			$_id = lionthemes_make_id();
			$show_rating = $is_deals = false;
			$show_rating=true;
			if($settings['type'] == 'deals') $is_deals=true;
			
			$loop = orfarm_woocommerce_query($settings['type'], $settings['number'], $settings['in_category']);
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
		
			if ( $loop->have_posts() ) {
			?>
			<?php $_total = $loop->found_posts > $settings['number'] ? $settings['number'] : $loop->found_posts; ?>
			<div id="countdown-event-<?php echo $_id ?>"  class="woocommerce<?php echo (($settings['el_class'] != '') ? ' '. $settings['el_class'] : ''); ?> <?php echo (($settings['style'] != '') ? ' '. $settings['style'] : ''); ?>">
				<?php if($settings['title'] || $settings['short_desc'] ){ ?>
					<div class="element-widget-title">
						<?php if($settings['title']){ ?>
							<h3 class="vc_widget_title vc_products_title <?php echo (($settings['alignment'] != '') ? ' '. $settings['alignment'] : ''); ?> <?php echo (($settings['style'] != '') ? ' '. $settings['style'] : ''); ?>">
								<span><?php echo wp_kses($settings['title'], array('strong' => array())) ?></span>
							</h3>
						<?php } ?>
						<?php if($settings['end_date']) { ?> 
						  <div class="countdown">
							<div class="event-ended<?php echo $left > 0 ? ' d-none': ''; ?>"><span><?php echo esc_html__('The event has ended', 'orfarm') ?></span></div>
							<div class="countdown-sections<?php echo $left <= 0 ? ' d-none': ''; ?>">
								<span class="countdown-section">
									<span class="countdown-val days_left"><?php echo ''.$day_left; ?></span>
									<span class="countdown-label"><?php echo esc_html__('Days', 'orfarm'); ?></span>
								</span>
								<span class="countdown-section">
									<span class="countdown-val hours_left"><?php echo ''.$hours_left; ?></span>
									<span class="countdown-label"><?php echo esc_html__('Hrs', 'orfarm'); ?></span>
								</span>
								<span class="countdown-section">
									<span class="countdown-val mins_left"><?php echo ''.$mins_left; ?></span>
									<span class="countdown-label"><?php echo esc_html__('Mins', 'orfarm'); ?></span>
								</span>
								<span class="countdown-section">
									<span class="countdown-val secs_left"><?php echo ''.$secs_left; ?></span>
									<span class="countdown-label"><?php echo esc_html__('Secs', 'orfarm'); ?></span>
								</span>
							</div>
						</div>
						<?php } ?>
						<?php if($settings['short_desc']){ ?>
							<div class="widget-sub-title <?php echo (($settings['alignment'] != '') ? ' '. $settings['alignment'] : ''); ?>">
								<p><?php echo nl2br(strip_tags($settings['short_desc'])); ?></p>
							</div>
						<?php } ?>
					</div>
				<?php } ?>
				<div id="products-element-<?php echo $_id ?>" class="inner-content<?php echo ($is_deals) ? ' deal-layout ' . $settings['deal_style'] : ''; ?>">
					<?php wc_get_template( 'product-layout/'.$settings['style'].'.php', array( 
						'show_rating' => $show_rating,
						'showsold' => $settings['show_sold'],
						'hideactions' => ($settings['hide_actions'] == 'yes'),
						'showdesc' => $settings['show_desc'],
						'loop'=>$loop,
						'columns_count'=>$settings['columns'],
						'class_column' => $class_column,
						'_total'=>$_total,
						'number'=>$settings['number'],
						'rows'=>$settings['rows'],
						'isdeals' => $is_deals,
						'itemlayout'=> $settings['item_layout'],
						'showoneffect' => $settings['showon_effect'],
						'owl_data' => $owl_data
						) ); ?>
				</div>
			</div>
				<?php if ($settings['end_date'] && $left > 0) { ?>
			<script>
				jQuery(document).ready(function($) {
					var countdown_event_<?php echo $_id ?> = null;
					<?php if (isset($_POST['action']) && $_POST['action'] == 'elementor_ajax') { ?>
					if (countdown_event_<?php echo $_id ?>) clearInterval(countdown_event_<?php echo $_id ?>);
					<?php } ?>
					countdown_event_<?php echo $_id ?> = setInterval(function(){
						var me = $('#countdown-event-<?php echo $_id ?>');
						var days = parseInt(me.find('.days_left').text());
						var hours = parseInt(me.find('.hours_left').text());
						var mins = parseInt(me.find('.mins_left').text());
						var secs = parseInt(me.find('.secs_left').text());
						if (days > 0 || hours > 0 || mins > 0 || secs > 0) {
							if (secs == 0) {
								secs = 59;
								if (mins == 0) {
									mins = 59;
									if (hours == 0) {
										hours = 23;
										if ((days = 0)) {
											hours = 0;
											mins = 0;
											secs = 0;
										} else {
											days = days - 1;
										}
									} else {
										hours = hours - 1;
									}
								} else {
									mins = mins - 1;
								}
							} else {
								secs = secs - 1;
							}
							if (days > 0) {
								me.find('.weeks_left').html(Math.floor(days / 7));
							}
							me.find('.days_left').html(days);
							me.find('.hours_left').html(hours);
							me.find('.mins_left').html(mins);
							me.find('.secs_left').html(secs);
						} else {
							me.find('.event-ended').removeClass('d-none');
							me.find('.countdown-sections').addClass('d-none');
							clearInterval(countdown_event_<?php echo $_id ?>);
						}
					}, 1000);
				});
			</script>
				<?php } ?>
			<?php 
			if ($settings['style'] == 'carousel') { ?>
				<script>
					jQuery(document).ready(function($) {
						<?php if (isset($_POST['action']) && $_POST['action'] == 'elementor_ajax') { ?>
						if (typeof owlCarousel !== "undefined") $('#products-element-<?php echo $_id ?> [data-owl="slide"]').owlCarousel('destroy');
						<?php } ?>
						if (typeof initOwl !== "undefined") initOwl($('#products-element-<?php echo $_id ?> [data-owl="slide"]'));
					});
				</script>
			<?php }
			}
		}
	}
}