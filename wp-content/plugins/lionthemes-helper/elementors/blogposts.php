<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

class Lionthemes_Blogposts_Element extends \Elementor\Widget_Base {

	public function get_name() {
		return 'blogposts';
	}

	public function get_title() {
		return __( 'Blog posts', 'orfarm' ); 
	} 
	public function get_icon() {
		return 'fa fa-newspaper-o';
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
			'pre_title',
			[
				'label' => __( 'Prepend Title', 'orfarm' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'input_type' => 'text',
			]
		);
		$this->add_control(
			'short_desc',
			[
				'label' => __( 'Short description', 'orfarm' ),
				'type' => \Elementor\Controls_Manager::WYSIWYG,
			]
		);
		$this->add_control(
			'category_post',
			[
				'label' => __( 'Show Category Blog', 'orfarm' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'options' => lionthemes_get_category_post_list(),
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
			'show_categories',
			[
				'label' => __( 'Show categories', 'orfarm' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);
		$this->add_control(
			'style',
			[
				'label' => __( 'Style', 'orfarm' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'options' => [ 
					'list' => esc_html__( 'List', 'orfarm' ),
					'grid' => esc_html__( 'Grid', 'orfarm' ),
					'carousel' => esc_html__( 'Carousel', 'orfarm' ),
				],
				'default' => 'carousel'
			]
		);
		$this->add_control(
			'layout',
			[
				'label' => __( 'Design layout', 'orfarm' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'options' => [
					'style_1' => esc_html__( 'Design 1', 'orfarm' ),
					'style_2' => esc_html__( 'Design 2', 'orfarm' ),
					'style_3' => esc_html__( 'Design 3', 'orfarm' ),
					'style_4' => esc_html__( 'Design 4', 'orfarm' ),
				],
				'default' => 'style_1'
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
			'showon_effect',
			[
				'label' => __( 'Show on effect', 'orfarm' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'options' => lionthemes_get_effect_list(true),
			]
		);
		$this->add_control(
			'image',
			[
				'label' => __( 'Image scale', 'orfarm' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'options' => [
					'wide'	=> 'Wide',
					'square'	=> 'Square',
				],
				'default' => 'wide'
			]
		);
		$this->add_control(
			'length',
			[
				'label' => __( 'Excerpt length', 'orfarm' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'input_type' => 'number',
				'default' => '20'
			]
		);
		$this->add_control(
			'readmore_text',
			[
				'label' => __( 'Readmore text', 'orfarm' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => 'Read more'
			]
		);
		$this->add_control(
			'orderby',
			[
				'label' => __( 'Order by', 'orfarm' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'options' => [
					'date'	=> __( 'Posted Date', 'orfarm' ),
					'menu_order'	=> __('Ordering','orfarm' ),
					'rand'	=> __('Random','orfarm' ),
				],
				'default' => 'date'
			]
		);
		$this->add_control(
			'order',
			[
				'label' => __( 'Order Direction', 'orfarm' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'options' => [
					'DESC'	=> __( 'Descending', 'orfarm' ),
					'ASC'	=> __('Ascending','orfarm' ),
				],
				'default' => 'DESC'
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
		if($settings['image'] == 'wide'){
		$imagesize = 'orfarm-post-thumbwide';
		} else {
			$imagesize = 'orfarm-post-thumb';
		}
		$postargs = array(
			'posts_per_page'   => $settings['number'],
			'offset'           => 0,
			'category'         => $settings['category_post'],
			'category_name'    => '',
			'orderby'          => $settings['orderby'],
			'order'            => $settings['order'],
			'include'          => '',
			'exclude'          => '',
			'meta_key'         => '',
			'meta_value'       => '',
			'post_type'        => 'post',
			'post_mime_type'   => '',
			'post_parent'      => '',
			'post_status'      => 'publish',
			'suppress_filters' => true );
		$postslist = get_posts( $postargs );
		$total = count($postslist);
		if($total == 0) return;
		switch ($settings['columns']) {
			case '5':
				$class_column='col-sm-20 col-xs-6';
				break;
			case '4':
				$class_column='col-sm-3 col-xs-6';
				break;
			case '3':
				$class_column='col-lg-4 col-md-4 col-sm-4 col-xs-6';
				break;
			case '2':
				$class_column='col-lg-6 col-md-6 col-sm-6 col-xs-6';
				break;
			default:
				$class_column='col-lg-12 col-md-12 col-sm-12 col-xs-6';
				break;
		}
		$el_class = 'el_class';
		if ($settings['el_class']) {
			$el_class .= ' ' . $settings['el_class'];
		}
		$row_cl = ' row';
		if($settings['style'] != 'grid'){
			$row_cl = $class_column = '';
		}
		if ($settings['layout']) {
			$row_cl .= ' ' . $settings['layout'];
		}
		$autoplay = (($settings['autoplay'] != '') ? true : false);
		$owl_data = '';
		if($settings['style'] == 'carousel'){
			$owl_data .= 'data-dots="false" data-nav="true" data-owl="slide" data-ow-rtl="false" ';
			$owl_data .= 'data-bigdesk="'. esc_attr($settings['bigdesk']) .'" ';
			$owl_data .= 'data-desksmall="'. esc_attr($settings['desksmall']) .'" ';
			$owl_data .= 'data-tabletsmall="'. esc_attr($settings['tabletsmall']) .'" ';
			$owl_data .= 'data-bigtablet="'. esc_attr($settings['bigtablet']) .'" ';
			$owl_data .= 'data-mobile="'. esc_attr($settings['mobile_count']) .'" ';
			$owl_data .= 'data-tablet="'. esc_attr($settings['tablet_count']) .'" ';
			$owl_data .= 'data-margin="'. esc_attr($settings['margin']) .'" ';
			$owl_data .= 'data-item-slide="'. esc_attr($settings['columns']) .'" ';
			$owl_data .= 'data-autoplay="'. esc_attr($autoplay) .'" ';
			$owl_data .= 'data-playtimeout="'. esc_attr($settings['playtimeout']) .'" ';
			$owl_data .= 'data-speed="'. esc_attr($settings['speed']) .'" ';
		}
		$showon_effect = ($settings['showon_effect']) ? ' wow ' . $settings['showon_effect'] : ''; 
		if (function_exists('lionthemes_get_template_part')) {
			lionthemes_get_template_part('template-parts/post/content-archive', array(
				'postslist' => $postslist,
				'title' => $settings['title'],
				'pre_title' => $settings['pre_title'],
				'title_alignment' => $settings['alignment'],
				'short_desc' => $settings['short_desc'],
				'style' => $settings['style'],
				'rows' => $settings['rows'],
				'imagesize' => $imagesize,
				'show_categories' => $settings['show_categories'],
				'excerpt_length' => $settings['length'],
				'owl_data' => $owl_data,
				'row_cl' => $row_cl,
				'el_class' => $el_class,
				'class_column' => $class_column,
				'showon_effect' => $showon_effect,
				'readmore_text' => $settings['readmore_text'],
			));
		}
		if ($settings['style'] == 'carousel') { ?>
			<script>
				jQuery(document).ready(function($) {
					<?php if (isset($_POST['action']) && $_POST['action'] == 'elementor_ajax') { ?>
					if (typeof owlCarousel !== "undefined") $('.blog-posts [data-owl="slide"]').owlCarousel('destroy');
					<?php } ?>
					if (typeof initOwl !== "undefined") initOwl($('.blog-posts [data-owl="slide"]'));
				});
			</script>
		<?php }
	}
}