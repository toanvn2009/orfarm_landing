<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

class Lionthemes_Menus_Element extends \Elementor\Widget_Base {
	
	public function get_name() {
		return 'menu_location';
	}

	public function get_title() {
		return __( 'Menus', 'orfarm' );
	}
	public function get_icon() {
		return 'fa fa-bars';
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
			'location',
			[
				'label' => __( 'Location', 'orfarm' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'options' => array(
					'primary'		=> esc_html__( 'Primary Menu', 'orfarm' ),
					'categories' 	=> esc_html__( 'Categories Menu', 'orfarm' ),
					'mobilemenu' 	=> esc_html__( 'Mobile Menu', 'orfarm' )
				),
				'default' => 'primary'
			]
		);
		$this->add_control(
			'limit_items',
			[
				'label' => __( 'Limit first level items', 'orfarm' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'input_type' => 'number',
				'default' => '0'
			]
		);
		$this->add_control(
			'el_class',
			[
				'label' => __( 'Extra class name', 'orfarm' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'input_type' => 'text',
			]
		);
		$this->end_controls_section();
	}
	protected function render() {

		$settings = $this->get_settings_for_display();
		if($settings['location']) {
			ob_start();
			wp_nav_menu( array( 'theme_location' => $settings['location'], 'container_class' => 'widget-menu-container', 'menu_class' => 'nav-menu' ) );
			$content = ob_get_contents();
			ob_end_clean();
			if(function_exists('lionthemes_make_id')){
				$get_id = lionthemes_make_id();
			}else{
				$get_id = substr(str_shuffle(md5(time())),0, 6);
			}
			
			$new_menu_id = 'id="mega_menu_widget_'. $get_id .'"';
			$new_menu_ul_id = 'id="mega_menu_ul_widget_'. $get_id .'"';
			$content = preg_replace('/id="mega_main_menu"/', $new_menu_id, $content, 1);
			$content = preg_replace('/id="mega_main_menu_ul"/', $new_menu_ul_id, $content, 1);
			$limit_items = $settings['limit_items'];
			$el_class = $settings['el_class']; 
			$title = $settings['title'];  
			?>
				<div id="vc-menu-<?php echo $get_id ?>" class="menu-widget-container vc-menu-widget <?php echo (($limit_items != '0') ? 'showmore-menu ':'') ?> <?php echo esc_attr($el_class) ?>">
					<?php if($title){ ?>
						<h3 class="vc_widget_title vc_menu_title <?php echo (($settings['alignment'] != '') ? ' '. $settings['alignment'] : ''); ?>"><span><?php echo esc_html($title) ?></span></h3>
					<?php } ?>
					<div class="categories-menu">
					<?php echo $content; ?>
					<?php if($limit_items != '0'){?>
						<div data-items="<?php echo intval($limit_items) ?>" class="showmore-cats hide"><i class="fa fa-plus"></i><span><?php echo esc_html__('More Categories', 'orfarm') ?></span></div>
					<?php }?>
					</div>
				</div>
			<?php
		}
	}
}