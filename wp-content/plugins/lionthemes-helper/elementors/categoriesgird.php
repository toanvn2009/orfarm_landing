<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

class Lionthemes_Categoriesgird_Element extends \Elementor\Widget_Base { 
	
	private function get_taxonomies($tax = 'product_cat') {
		$cats = lionthemes_get_all_taxonomy_terms($tax, true, false);
		return array_flip($cats);
	}

	public function get_name() {
		return 'categoriesgird';
	}

	public function get_title() {
		return __( 'Categories Gird', 'orfarm' );
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
				'label' => __( 'Categories Gird', 'elementor' ),
			]
		);

		$repeater = new \Elementor\Repeater();

		
		$repeater->add_control(
			'tab_title',
			[
				'label' => __( 'Title & Description', 'orfarm' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => __( 'Categories Title', 'orfarm' ),
				'placeholder' => __( 'Categories Title', 'orfarm' ),
				'label_block' => true, 
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

		$this->end_controls_section();

	}
	protected function render() {
		
		$settings = $this->get_settings_for_display();

		$terms = $this->get_settings_for_display( 'tabs' );
	
		if ( !empty($terms) ){ 
		?>
			<div class="categories-widget">
				<div class="categories-list-widget">
					<div class="categorygird-list categorygird-list-2col-left">
						<?php $i=0; foreach($terms as $key=>$category):$i++;$col = $i;  
							$cat = get_term_by('slug', $category['categories'], 'product_cat');?>
							
							<?php if($col == 1){ ?>
								<div class="category-item first">
							<?php } ?>
							<?php if($col == 2){ ?>
								<div class="category-item second">
							<?php } ?>
							<?php if($col == 3){ ?>
								<div class="category-item third">
							<?php } ?>
							<?php if($col == 4){ ?>
									<div class="category-item four">
							<?php } ?>
								<?php  $image = $category['image']['url']; ?>
								<?php if ($cat) { ?>
								<a href="<?php echo get_term_link( $cat->term_id, $cat->taxonomy ); ?>" style="background-image:url(<?php echo esc_url($image) ?>)">
									<div class="cat-name">
										<h3><?php echo $cat->name; ?></h3>
										<span><?php echo sprintf( _n( '%s Item', '%s Items', $cat->count, 'orfarm' ), $cat->count ) ?></span>
									</div>
								</a>
								<?php } ?>
							<?php if($col == 1){ ?>
									</div>
							<?php } ?>
							<?php if($col == 2){ ?>
									</div>
							<?php } ?>
							<?php if($col == 3){ ?>
									</div>
							<?php } ?>
							<?php if($col ==4){ ?>
								</div>
							<?php } ?>
						<?php endforeach  ?>
					</div>
				</div>
			</div>
		<?php 
		} 
	}
}