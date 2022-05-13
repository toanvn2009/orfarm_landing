<?php
// awesome icon shortcode
add_shortcode('fa', 'lionthemes_fa_icon');
function lionthemes_fa_icon( $attr ) {
  	return (!empty($attr[0])) ? '<i class="fa fa-' . $attr[0] . '"></i>' : '';
}
add_shortcode('lnr', 'lionthemes_lnr_icon');
function lionthemes_lnr_icon( $attr ) {
  	return (!empty($attr[0])) ? '<i class="lnr lnr-' . $attr[0] . '"></i>' : '';
}

add_shortcode('searchform', 'lionthemes_searchform');
function lionthemes_searchform( $attr ) {
  	return get_search_form(array('echo' => false));
}

vc_add_shortcode_param( 'multiselect', 'lionthemes_param_settings_field' );
function lionthemes_param_settings_field( $settings, $value ) {
	$output = '';
	$css_option = str_replace( '#', 'hash-', vc_get_dropdown_option( $settings, $value ) );
	$output .= '<select name="'
	           . $settings['param_name']
	           . '" class="wpb_vc_param_value wpb-input wpb-select '
	           . $settings['param_name']
	           . ' ' . $settings['type']
	           . ' ' . $css_option
	           . '" data-option="' . $css_option . '" multiple="multiple">';
	if ( !is_array( $value ) ) {
		$value = explode(',', $value);
	}
	if ( ! empty( $settings['value'] ) ) {
		foreach ( $settings['value'] as $index => $data ) {
			if ( is_numeric( $index ) && ( is_string( $data ) || is_numeric( $data ) ) ) {
				$option_label = $data;
				$option_value = $data;
			} elseif ( is_numeric( $index ) && is_array( $data ) ) {
				$option_label = isset( $data['label'] ) ? $data['label'] : array_pop( $data );
				$option_value = isset( $data['value'] ) ? $data['value'] : array_pop( $data );
			} else {
				$option_value = $data;
				$option_label = $index;
			}
			$selected = '';
			$option_value_string = (string) $option_value;
		
			if ( '' !== $value && in_array($option_value_string, $value) ) {
				$selected = ' selected="selected"';
			}
			$option_class = str_replace( '#', 'hash-', $option_value );
			$output .= '<option class="' . esc_attr( $option_class ) . '" value="' . esc_attr( $option_value ) . '"' . $selected . '>'
			           . htmlspecialchars( $option_label ) . '</option>';
		}
	}
	$output .= '</select>';

	return $output;
}

add_action( 'vc_before_init', 'orfarm_vc_shortcodes' );

function orfarm_vc_shortcodes() {
	vc_add_params( 'vc_tta_tabs', array(
		
		array(
			'type' => 'dropdown',
			'holder' => 'div',
			'class' => '',
			'heading' => esc_html__( 'Tab layout', 'orfarm' ),
			'param_name' => 'tab_layout',
			'value' => array(
				esc_html__( 'Style 1', 'orfarm' ) => 'style_1',
				esc_html__( 'Style 2', 'orfarm' ) => 'style_2',
				esc_html__( 'Style 3', 'orfarm' ) => 'style_3',
				esc_html__( 'Style 4', 'orfarm' ) => 'style_4',
				esc_html__( 'Style 5', 'orfarm' ) => 'style_5',
				esc_html__( 'Style 6', 'orfarm' ) => 'style_6',
			),
			'group' => esc_html__( 'Orfarm Options', 'orfarm' ),
			'save_always' => true,
		),
		array(
			'type' => 'attach_image',
			'holder' => 'div',
			'class' => '',
			'heading' => esc_html__( 'Left banner', 'orfarm' ),
			'param_name' => 'left_banner',
			'value' => '',
			'group' => esc_html__( 'Orfarm Options', 'orfarm' ),
			'save_always' => true,
		),
	) );
	//Get menu by location
	vc_map( array(
		'name' => esc_html__( 'Menus', 'orfarm' ),
		'base' => 'menu_location',
		'class' => '',
		'category' => esc_html__( 'Orfarm Theme', 'orfarm'),
		'params' => array(
			array(
				'type' => 'textfield',
				'holder' => 'div',
				'class' => '',
				'heading' => esc_html__( 'Title', 'orfarm' ),
				'param_name' => 'title',
				'value' => '',
			),
			array(
				'type' => 'dropdown',
				'holder' => 'div',
				'class' => '',
				'heading' => esc_html__( 'Location', 'orfarm' ),
				'param_name' => 'location',
				'value' => array(
					array('value' => 'primary', 'label' => esc_html__( 'Primary Menu', 'orfarm' )),
					array('value' => 'categories', 'label' => esc_html__( 'Categories Menu', 'orfarm' )),
					array('value' => 'mobilemenu', 'label' => esc_html__( 'Mobile Menu', 'orfarm' ))
				)
			),
			array(
				'type' => 'textfield',
				'holder' => 'div',
				'class' => '',
				'heading' => esc_html__( 'Limit first level items', 'orfarm' ),
				'param_name' => 'limit_items',
				'value' => '0',
				'description' => esc_html__( 'This option to display show more function to display full menu items. Set 0 for un-limit.', 'orfarm' )
			),
			array(
				'type' => 'textfield',
				'holder' => 'div',
				'class' => '',
				'heading' => esc_html__( 'Extra class name', 'orfarm' ),
				'param_name' => 'el_class',
				'value' => '',
				'description' => esc_html__( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'orfarm' )
			)
		)
	) );

	// Social icon from theme options
	vc_map( array(
		'name' => esc_html__( 'Social icons - From Theme options', 'orfarm' ),
		'base' => 'lionthemes_socialicons',
		'class' => '',
		'category' => esc_html__( 'Orfarm Theme', 'orfarm'),
		'params' => array(
			array(
				'type' => 'textfield',
				'holder' => 'div',
				'class' => '',
				'heading' => esc_html__( 'Title', 'orfarm' ),
				'param_name' => 'title',
				'value' => '',
			),
			array(
				'type' => 'textarea',
				'holder' => 'div',
				'class' => '',
				'heading' => esc_html__( 'Short description', 'orfarm' ),
				'param_name' => 'short_desc',
				'value' => '',
			),
			array(
				'type' => 'dropdown',
				'holder' => 'div',
				'class' => '',
				'heading' => esc_html__( 'Alignment', 'orfarm' ),
				'param_name' => 'alignment',
				'value' => array(
						esc_html__( 'Left', 'orfarm' )	 	=> 'left',
						esc_html__( 'Center', 'orfarm' ) 		=> 'center',
						esc_html__( 'Right', 'orfarm' ) 	=> 'right',
					),
				'save_always' => 'center',
			),
		)
	) );

	// Custom dynamic heading
	vc_map( array(
		'name' => esc_html__( 'Dynamic Heading', 'orfarm' ),
		'base' => 'lionthemes_heading',
		'class' => '',
		'category' => esc_html__( 'Orfarm Theme', 'orfarm'),
		'params' => array(
			array(
				'type' => 'textfield',
				'holder' => 'div',
				'class' => '',
				'heading' => esc_html__( 'Title', 'orfarm' ),
				'param_name' => 'title',
				'value' => '',
				'description' => esc_html__( 'Only allow <strong> tag', 'orfarm' ),
			),
			array(
				'type' => 'textarea',
				'holder' => 'div',
				'class' => '',
				'heading' => esc_html__( 'Sub heading', 'orfarm' ),
				'param_name' => 'subtitle',
				'value' => '',
				'description' => esc_html__( 'Only allow <strong> tag', 'orfarm' ),
			),
			array(
				'type' => 'attach_image',
				'holder' => 'div',
				'class' => '',
				'heading' => esc_html__( 'Heading image', 'orfarm' ),
				'param_name' => 'heading_image',
				'value' => '',
			),
			array(
				'type' => 'dropdown',
				'holder' => 'div',
				'class' => '',
				'heading' => esc_html__( 'Style', 'orfarm' ),
				'param_name' => 'style',
				'value' => array(
						esc_html__( 'Style 1 (default)', 'orfarm' )	 	=> '',
						esc_html__( 'Style 2', 'orfarm' ) 	=> 'style-2',
						esc_html__( 'Style 3', 'orfarm' ) 	=> 'style-3',
						esc_html__( 'Style 4', 'orfarm' ) 	=> 'style-4',
						esc_html__( 'Style 5', 'orfarm' ) 	=> 'style-5',
					),
			),
		)
	) );

	//Brand logos
	vc_map( array(
		'name' => esc_html__( 'Brand Logos', 'orfarm' ),
		'base' => 'ourbrands',
		'class' => '',
		'category' => esc_html__( 'Orfarm Theme', 'orfarm'),
		'params' => array(
			array(
				'type' => 'textfield',
				'holder' => 'div',
				'class' => '',
				'heading' => esc_html__( 'Title', 'orfarm' ),
				'param_name' => 'title',
				'value' => '',
			),
			array(
				'type' => 'textarea',
				'holder' => 'div',
				'class' => '',
				'heading' => esc_html__( 'Short description', 'orfarm' ),
				'param_name' => 'short_desc',
				'value' => '',
			),
			array(
				'type' => 'dropdown',
				'holder' => 'div',
				'class' => '',
				'heading' => esc_html__( 'Alignment', 'orfarm' ),
				'param_name' => 'alignment',
				'value' => array(
						esc_html__( 'Left', 'orfarm' )	 	=> 'left',
						esc_html__( 'Center', 'orfarm' ) 		=> 'center',
						esc_html__( 'Right', 'orfarm' ) 	=> 'right',
					),
				'save_always' => 'center',
			),
			array(
				'type' => 'dropdown',
				'holder' => 'div',
				'class' => '',
				'heading' => esc_html__( 'Number of columns', 'orfarm' ),
				'param_name' => 'colsnumber',
				'value' => array(
						'1'	=> '1',
						'2'	=> '2',
						'3'	=> '3',
						'4'	=> '4',
						'5'	=> '5',
						'6'	=> '6',
					),
				'save_always' => true,
			),
			array(
				'type' => 'dropdown',
				'holder' => 'div',
				'class' => '',
				'heading' => esc_html__( 'Show on effect', 'orfarm' ),
				'param_name' => 'showon_effect',
				'value' => lionthemes_get_effect_list(),
				'save_always' => true,
			),
			array(
				'type' => 'dropdown',
				'holder' => 'div',
				'class' => '',
				'heading' => esc_html__( 'Number of rows', 'orfarm' ),
				'param_name' => 'rows',
				'value' => array(
						'1'	=> '1',
						'2'	=> '2',
						'3'	=> '3',
						'4'	=> '4',
					),
				'save_always' => true,
				'group' => esc_html__( 'Carousel Options', 'orfarm' ),
			),
			array(
				'type' => 'dropdown',
				'holder' => 'div',
				'class' => '',
				'heading' => esc_html__( 'Style', 'orfarm' ),
				'param_name' => 'style',
				'value' => array(
						esc_html__( 'Grid', 'orfarm' )	 	=> 'grid',
						esc_html__( 'Carousel', 'orfarm' ) 	=> 'carousel',
					),
			),
			array(
				'type' => 'dropdown',
				'holder' => 'div',
				'class' => '',
				'heading' => esc_html__( 'Auto rotate', 'orfarm' ),
				'param_name' => 'autoplay',
				'value' => array(
					esc_html__( 'No', 'orfarm' ) 	=> 'false',
					esc_html__( 'Yes', 'orfarm' ) 	=> 'true',
				),
				'save_always' => true,
				'group' => esc_html__( 'Carousel Options', 'orfarm' ),
			),
			array(
				'type' => 'textfield',
				'holder' => 'div',
				'class' => '',
				'heading' => esc_html__( 'Play Timeout', 'orfarm' ),
				'param_name' => 'playtimeout',
				'value' => '5000',
				'save_always' => true,
				'group' => esc_html__( 'Carousel Options', 'orfarm' ),
			),
			array(
				'type' => 'textfield',
				'holder' => 'div',
				'class' => '',
				'heading' => esc_html__( 'Rotate speed', 'orfarm' ),
				'param_name' => 'speed',
				'value' => '250',
				'save_always' => true,
				'group' => esc_html__( 'Carousel Options', 'orfarm' ),
			),
			array(
				'type' => 'dropdown',
				'holder' => 'div',
				'class' => '',
				'heading' => esc_html__( 'Columns count on big desktop (Over 1500px)', 'orfarm' ),
				'param_name' => 'bigdesk',
				'value' => array(
						'1'	=> '1',
						'2'	=> '2',
						'3'	=> '3',
						'4'	=> '4',
						'5'	=> '5',
						'6'	=> '6',
					),
				'save_always' => true,
				'group' => esc_html__( 'Carousel Options', 'orfarm' ),
			),
			array(
				'type' => 'dropdown',
				'holder' => 'div',
				'class' => '',
				'heading' => esc_html__( 'Columns count desktop small (992px - 1199px)', 'orfarm' ),
				'param_name' => 'desksmall',
				'value' => array(
						'1'	=> '1',
						'2'	=> '2',
						'3'	=> '3',
						'4'	=> '4',
						'5'	=> '5',
						'6'	=> '6',
					),
				'save_always' => true,
				'group' => esc_html__( 'Carousel Options', 'orfarm' ),
			),
			array(
				'type' => 'dropdown',
				'holder' => 'div',
				'class' => '',
				'heading' => esc_html__( 'Columns count on big tablet (768px - 991px)', 'orfarm' ),
				'param_name' => 'bigtablet',
				'value' => array(
						'1'	=> '1',
						'2'	=> '2',
						'3'	=> '3',
						'4'	=> '4',
						'5'	=> '5',
						'6'	=> '6',
					),
				'save_always' => true,
				'group' => esc_html__( 'Carousel Options', 'orfarm' ),
			),
			array(
				'type' => 'dropdown',
				'holder' => 'div',
				'class' => '',
				'heading' => esc_html__( 'Columns count tablet (640px - 767px)', 'orfarm' ),
				'param_name' => 'tablet_count',
				'value' => array(
						'1'	=> '1',
						'2'	=> '2',
						'3'	=> '3',
						'4'	=> '4',
						'5'	=> '5',
					),
				'save_always' => true,
				'group' => esc_html__( 'Carousel Options', 'orfarm' ),
			),
			array(
				'type' => 'dropdown',
				'holder' => 'div',
				'class' => '',
				'heading' => esc_html__( 'Columns count tablet small (480px - 639px)', 'orfarm' ),
				'param_name' => 'tabletsmall',
				'value' => array(
						'1'	=> '1',
						'2'	=> '2',
						'3'	=> '3',
						'4'	=> '4',
						'5'	=> '5',
					),
				'save_always' => true,
				'group' => esc_html__( 'Carousel Options', 'orfarm' ),
			),
			array(
				'type' => 'dropdown',
				'holder' => 'div',
				'class' => '',
				'heading' => esc_html__( 'Columns count mobile (Under 479px)', 'orfarm' ),
				'param_name' => 'mobile_count',
				'value' => array(
						'1'	=> '1',
						'2'	=> '2',
						'3'	=> '3',
						'4'	=> '4',
						'5'	=> '5',
					),
				'save_always' => true,
				'group' => esc_html__( 'Carousel Options', 'orfarm' ),
			),
			array(
				'type' => 'textfield',
				'holder' => 'div',
				'class' => '',
				'heading' => esc_html__( 'Margin', 'orfarm' ),
				'param_name' => 'margin',
				'value' => '30',
				'save_always' => true,
				'group' => esc_html__( 'Carousel Options', 'orfarm' ),
			),
			array(
				'type' => 'textfield',
				'holder' => 'div',
				'class' => '',
				'heading' => esc_html__( 'Extra class name', 'orfarm' ),
				'param_name' => 'el_class',
				'value' => '',
				'description' => esc_html__( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'orfarm' )
			)
		)
	) );
	//Products Featured Categories
	vc_map( array(
		'name' => esc_html__( 'Products Featured Categories', 'orfarm' ),
		'base' => 'featuredcategories',
		'class' => '',
		'category' => esc_html__( 'Orfarm Theme', 'orfarm'),
		'params' => array(
			array(
				'type' => 'textfield',
				'holder' => 'div',
				'class' => '',
				'heading' => esc_html__( 'Title', 'orfarm' ),
				'param_name' => 'title',
				'value' => '',
			),
			array(
				'type' => 'dropdown',
				'holder' => 'div',
				'class' => '',
				'heading' => esc_html__( 'Show on effect', 'orfarm' ),
				'param_name' => 'showon_effect',
				'value' => lionthemes_get_effect_list(),
				'save_always' => true,
			),
			array(
				'type' => 'dropdown',
				'holder' => 'div',
				'class' => '',
				'heading' => esc_html__( 'Item Design', 'orfarm' ),
				'param_name' => 'item_style',
				'value' => array(
						esc_html__( 'Style 1', 'orfarm' ) 	=> 'style-1',
						esc_html__( 'Style 2', 'orfarm' ) 		=> 'style-2',
					),
				'save_always' => true,
			),

			array(
				'type' => 'textfield',
				'holder' => 'div',
				'class' => '',
				'heading' => esc_html__( 'Extra class name', 'orfarm' ),
				'param_name' => 'el_class',
				'value' => '',
				'description' => esc_html__( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'orfarm' )
			)
		)
	) );
	//Specify Products
	vc_map( array(
		'name' => esc_html__( 'Specify Products', 'orfarm' ),
		'base' => 'specifyproducts',
		'class' => '',
		'category' => esc_html__( 'Orfarm Theme', 'orfarm'),
		'params' => array(
			array(
				'type' => 'textfield',
				'holder' => 'div',
				'class' => '',
				'heading' => esc_html__( 'Title', 'orfarm' ),
				'param_name' => 'title',
				'value' => '',
			),
			array(
				'type' => 'textarea',
				'holder' => 'div',
				'class' => '',
				'heading' => esc_html__( 'Short description', 'orfarm' ),
				'param_name' => 'short_desc',
				'value' => '',
			),
			array(
				'type' => 'dropdown',
				'holder' => 'div',
				'class' => '',
				'heading' => esc_html__( 'Alignment', 'orfarm' ),
				'param_name' => 'alignment',
				'value' => array(
						esc_html__( 'Left', 'orfarm' )	 	=> 'left',
						esc_html__( 'Center', 'orfarm' ) 		=> 'center',
						esc_html__( 'Right', 'orfarm' ) 	=> 'right',
					),
				'save_always' => 'center',
			),
			array(
				'type' => 'dropdown',
				'holder' => 'div',
				'class' => '',
				'heading' => esc_html__( 'Type', 'orfarm' ),
				'param_name' => 'type',
				'value' => array(
						esc_html__( 'Best Selling', 'orfarm' )		=> 'best_selling',
						esc_html__( 'Featured Products', 'orfarm' ) => 'featured_product',
						esc_html__( 'Top Rate', 'orfarm' ) 			=> 'top_rate',
						esc_html__( 'Recent Products', 'orfarm' ) 	=> 'recent_product',
						esc_html__( 'On Sale', 'orfarm' ) 			=> 'on_sale',
						esc_html__( 'Recent Review', 'orfarm' ) 	=> 'recent_review',
						esc_html__( 'Product Deals', 'orfarm' )		 => 'deals'
					),
			),
			array(
				'type' => 'dropdown',
				'holder' => 'div',
				'class' => '',
				'heading' => esc_html__( 'Deal style', 'orfarm' ),
				'param_name' => 'deal_style',
				'value' => array(
						esc_html__( 'Style 1', 'orfarm' ) 		=> 'style_1',
						esc_html__( 'Style 2', 'orfarm' ) 	=> 'style_2',
					),
				'save_always' => true,
			),
			array(
				'type' => 'dropdown',
				'holder' => 'div',
				'class' => '',
				'heading' => esc_html__( 'Only In Category', 'orfarm' ),
				'param_name' => 'in_category',
				'value' => lionthemes_get_all_taxonomy_terms('product_cat', true),
				'save_always' => true,
			),
			array(
				'type' => 'textfield',
				'holder' => 'div',
				'class' => '',
				'heading' => esc_html__( 'Number of products to display', 'orfarm' ),
				'param_name' => 'number',
				'value' => '10',
			),
			array(
				'type' => 'dropdown',
				'holder' => 'div',
				'class' => '',
				'heading' => esc_html__( 'Style', 'orfarm' ),
				'param_name' => 'style',
				'value' => array(
						esc_html__( 'Grid', 'orfarm' )	 	=> 'grid',
						esc_html__( 'List', 'orfarm' ) 		=> 'list',
						esc_html__( 'Carousel', 'orfarm' ) 	=> 'carousel',
					),
				'save_always' => true,
			),
			array(
				 'type' => 'checkbox',
				 'heading' => esc_html__('Hide categories list','orfarm'),
				 'param_name' => 'hide_categories',
				 'value' => array(
								'Yes' => true
							)
			),
			array(
				'type' => 'dropdown',
				'holder' => 'div',
				'class' => '',
				'heading' => esc_html__( 'Show on effect', 'orfarm' ),
				'param_name' => 'showon_effect',
				'value' => lionthemes_get_effect_list(),
				'save_always' => true,
			),
			array(
				'type' => 'dropdown',
				'holder' => 'div',
				'class' => '',
				'heading' => esc_html__( 'Item layout', 'orfarm' ),
				'param_name' => 'item_layout',
				'value' => array(
						esc_html__( 'Box', 'orfarm' ) 		=> 'box',
						esc_html__( 'List', 'orfarm' ) 	=> 'list',
						esc_html__( 'Simple List', 'orfarm' ) 	=> 'simple',
					),
				'save_always' => true,
				'group' => esc_html__( 'Carousel Options', 'orfarm' ),
			),
			array(
				'type' => 'dropdown',
				'holder' => 'div',
				'class' => '',
				'heading' => esc_html__( 'Number of rows', 'orfarm' ),
				'param_name' => 'rows',
				'value' => array(
						'1'	=> '1',
						'2'	=> '2',
						'3'	=> '3',
						'4'	=> '4',
					),
				'save_always' => true,
				'group' => esc_html__( 'Carousel Options', 'orfarm' ),
			),
			array(
				'type' => 'dropdown',
				'holder' => 'div',
				'class' => '',
				'heading' => esc_html__( 'Auto rotate', 'orfarm' ),
				'param_name' => 'autoplay',
				'value' => array(
					esc_html__( 'No', 'orfarm' ) 	=> 'false',
					esc_html__( 'Yes', 'orfarm' ) 	=> 'true',
				),
				'save_always' => true,
				'group' => esc_html__( 'Carousel Options', 'orfarm' ),
			),
			array(
				'type' => 'textfield',
				'holder' => 'div',
				'class' => '',
				'heading' => esc_html__( 'Play Timeout', 'orfarm' ),
				'param_name' => 'playtimeout',
				'value' => '5000',
				'group' => esc_html__( 'Carousel Options', 'orfarm' ),
				'save_always' => true,
			),
			array(
				'type' => 'textfield',
				'holder' => 'div',
				'class' => '',
				'heading' => esc_html__( 'Rotate speed', 'orfarm' ),
				'param_name' => 'speed',
				'value' => '250',
				'save_always' => true,
				'group' => esc_html__( 'Carousel Options', 'orfarm' ),
			),
			array(
				'type' => 'dropdown',
				'holder' => 'div',
				'class' => '',
				'heading' => esc_html__( 'Columns', 'orfarm' ),
				'param_name' => 'columns',
				'value' => array(
						'1'	=> '1',
						'2'	=> '2',
						'3'	=> '3',
						'4'	=> '4',
						'5'	=> '5',
						'6'	=> '6',
					),
				'save_always' => true,
				'group' => esc_html__( 'Carousel Options', 'orfarm' ),
			),
			array(
				'type' => 'dropdown',
				'holder' => 'div',
				'class' => '',
				'heading' => esc_html__( 'Columns count on big desktop (Over 1500px)', 'orfarm' ),
				'param_name' => 'bigdesk',
				'value' => array(
						'1'	=> '1',
						'2'	=> '2',
						'3'	=> '3',
						'4'	=> '4',
						'5'	=> '5',
						'6'	=> '6',
					),
				'save_always' => true,
				'group' => esc_html__( 'Carousel Options', 'orfarm' ),
			),
			array(
				'type' => 'dropdown',
				'holder' => 'div',
				'class' => '',
				'heading' => esc_html__( 'Columns count desktop small (992px - 1199px)', 'orfarm' ),
				'param_name' => 'desksmall',
				'value' => array(
						'1'	=> '1',
						'2'	=> '2',
						'3'	=> '3',
						'4'	=> '4',
						'5'	=> '5',
						'6'	=> '6',
					),
				'save_always' => true,
				'group' => esc_html__( 'Carousel Options', 'orfarm' ),
			),
			
			array(
				'type' => 'dropdown',
				'holder' => 'div',
				'class' => '',
				'heading' => esc_html__( 'Columns count on big tablet (768px - 991px)', 'orfarm' ),
				'param_name' => 'bigtablet',
				'value' => array(
						'1'	=> '1',
						'2'	=> '2',
						'3'	=> '3',
						'4'	=> '4',
						'5'	=> '5',
						'6'	=> '6',
					),
				'save_always' => true,
				'group' => esc_html__( 'Carousel Options', 'orfarm' ),
			),
			array(
				'type' => 'dropdown',
				'holder' => 'div',
				'class' => '',
				'heading' => esc_html__( 'Columns count tablet (640px - 767px)', 'orfarm' ),
				'param_name' => 'tablet_count',
				'value' => array(
						'1'	=> '1',
						'2'	=> '2',
						'3'	=> '3',
						'4'	=> '4',
						'5'	=> '5',
					),
				'save_always' => true,
				'group' => esc_html__( 'Carousel Options', 'orfarm' ),
			),
			array(
				'type' => 'dropdown',
				'holder' => 'div',
				'class' => '',
				'heading' => esc_html__( 'Columns count tablet small (480px - 639px)', 'orfarm' ),
				'param_name' => 'tabletsmall',
				'value' => array(
						'1'	=> '1',
						'2'	=> '2',
						'3'	=> '3',
						'4'	=> '4',
						'5'	=> '5',
					),
				'save_always' => true,
				'group' => esc_html__( 'Carousel Options', 'orfarm' ),
			),
			array(
				'type' => 'dropdown',
				'holder' => 'div',
				'class' => '',
				'heading' => esc_html__( 'Columns count mobile (Under 479px)', 'orfarm' ),
				'param_name' => 'mobile_count',
				'value' => array(
						'1'	=> '1',
						'2'	=> '2',
						'3'	=> '3',
						'4'	=> '4',
						'5'	=> '5',
					),
				'save_always' => true,
				'group' => esc_html__( 'Carousel Options', 'orfarm' ),
			),
			array(
				'type' => 'textfield',
				'holder' => 'div',
				'class' => '',
				'heading' => esc_html__( 'Margin', 'orfarm' ),
				'param_name' => 'margin',
				'value' => '0',
				'group' => esc_html__( 'Carousel Options', 'orfarm' ),
			),
			array(
				'type' => 'textfield',
				'holder' => 'div',
				'class' => '',
				'heading' => esc_html__( 'Extra class name', 'orfarm' ),
				'param_name' => 'el_class',
				'value' => '',
				'description' => esc_html__( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'orfarm' )
			)
		)
	) );
	//Products Category
	vc_map( array(
		'name' => esc_html__( 'Products Category', 'orfarm' ),
		'base' => 'productscategory',
		'class' => '',
		'category' => esc_html__( 'Orfarm Theme', 'orfarm'),
		'params' => array(
			array(
				'type' => 'textfield',
				'holder' => 'div',
				'class' => '',
				'heading' => esc_html__( 'Title', 'orfarm' ),
				'param_name' => 'title',
				'value' => '',
			),
			array(
				'type' => 'textarea',
				'holder' => 'div',
				'class' => '',
				'heading' => esc_html__( 'Short description', 'orfarm' ),
				'param_name' => 'short_desc',
				'value' => '',
			),
			array(
				'type' => 'dropdown',
				'holder' => 'div',
				'class' => '',
				'heading' => esc_html__( 'Alignment', 'orfarm' ),
				'param_name' => 'alignment',
				'value' => array(
						esc_html__( 'Left', 'orfarm' )	 	=> 'left',
						esc_html__( 'Center', 'orfarm' ) 		=> 'center',
						esc_html__( 'Right', 'orfarm' ) 	=> 'right',
					),
				'save_always' => 'center',
			),
			array(
				'type' => 'dropdown',
				'holder' => 'div',
				'class' => '',
				'heading' => esc_html__( 'Category', 'orfarm' ),
				'param_name' => 'category',
				'value' => lionthemes_get_all_taxonomy_terms(),
			),
			array(
				 'type' => 'checkbox',
				 'heading' => esc_html__('Show description','orfarm'),
				 'param_name' => 'show_desc',
				 'value' => array(
								'Yes' => false
							)
			),
			array(
				'type' => 'textfield',
				'holder' => 'div',
				'class' => '',
				'heading' => esc_html__( 'Number of products to show', 'orfarm' ),
				'param_name' => 'number',
				'value' => '10',
			),
			array(
				'type' => 'dropdown',
				'holder' => 'div',
				'class' => '',
				'heading' => esc_html__( 'Style', 'orfarm' ),
				'param_name' => 'style',
				'value' => array(
						esc_html__( 'Grid', 'orfarm' )	 	=> 'grid',
						esc_html__( 'List', 'orfarm' ) 		=> 'list',
						esc_html__( 'Carousel', 'orfarm' ) 	=> 'carousel',
					),
			),
			array(
				 'type' => 'checkbox',
				 'heading' => esc_html__('Hide categories list','orfarm'),
				 'param_name' => 'hide_categories',
				 'value' => array(
								'Yes' => true
							)
			),
			array(
				'type' => 'dropdown',
				'holder' => 'div',
				'class' => '',
				'heading' => esc_html__( 'Columns', 'orfarm' ),
				'param_name' => 'columns',
				'value' => array(
						'1'	=> '1',
						'2'	=> '2',
						'3'	=> '3',
						'4'	=> '4',
						'5'	=> '5',
						'6'	=> '6',
					),
				'save_always' => true,
			),
			array(
				'type' => 'dropdown',
				'holder' => 'div',
				'class' => '',
				'heading' => esc_html__( 'Show on effect', 'orfarm' ),
				'param_name' => 'showon_effect',
				'value' => lionthemes_get_effect_list(),
				'save_always' => true,
			),
			array(
				'type' => 'dropdown',
				'holder' => 'div',
				'class' => '',
				'heading' => esc_html__( 'Item layout', 'orfarm' ),
				'param_name' => 'item_layout',
				'value' => array(
						esc_html__( 'Box', 'orfarm' ) 		=> 'box',
						esc_html__( 'List', 'orfarm' ) 	=> 'list',
						esc_html__( 'Simple List', 'orfarm' ) 	=> 'simple',
					),
				'save_always' => true,
				'group' => esc_html__( 'Carousel Options', 'orfarm' ),
			),
			array(
				'type' => 'dropdown',
				'holder' => 'div',
				'class' => '',
				'heading' => esc_html__( 'Number of rows', 'orfarm' ),
				'param_name' => 'rows',
				'value' => array(
						'1'	=> '1',
						'2'	=> '2',
						'3'	=> '3',
						'4'	=> '4',
					),
				'save_always' => true,
				'group' => esc_html__( 'Carousel Options', 'orfarm' ),
			),
			array(
				'type' => 'dropdown',
				'holder' => 'div',
				'class' => '',
				'heading' => esc_html__( 'Auto rotate', 'orfarm' ),
				'param_name' => 'autoplay',
				'value' => array(
					esc_html__( 'No', 'orfarm' ) 	=> 'false',
					esc_html__( 'Yes', 'orfarm' ) 	=> 'true',
				),
				'save_always' => true,
				'group' => esc_html__( 'Carousel Options', 'orfarm' ),
			),
			array(
				'type' => 'textfield',
				'holder' => 'div',
				'class' => '',
				'heading' => esc_html__( 'Play Timeout', 'orfarm' ),
				'param_name' => 'playtimeout',
				'value' => '5000',
				'save_always' => true,
				'group' => esc_html__( 'Carousel Options', 'orfarm' ),
			),
			array(
				'type' => 'textfield',
				'holder' => 'div',
				'class' => '',
				'heading' => esc_html__( 'Rotate speed', 'orfarm' ),
				'param_name' => 'speed',
				'value' => '250',
				'save_always' => true,
				'group' => esc_html__( 'Carousel Options', 'orfarm' ),
			),
			array(
				'type' => 'dropdown',
				'holder' => 'div',
				'class' => '',
				'heading' => esc_html__( 'Columns count on big desktop (Over 1500px)', 'orfarm' ),
				'param_name' => 'bigdesk',
				'value' => array(
						'1'	=> '1',
						'2'	=> '2',
						'3'	=> '3',
						'4'	=> '4',
						'5'	=> '5',
						'6'	=> '6',
					),
				'save_always' => true,
				'group' => esc_html__( 'Carousel Options', 'orfarm' ),
			),
			array(
				'type' => 'dropdown',
				'holder' => 'div',
				'class' => '',
				'heading' => esc_html__( 'Columns count desktop small (992px - 1199px)', 'orfarm' ),
				'param_name' => 'desksmall',
				'value' => array(
						'1'	=> '1',
						'2'	=> '2',
						'3'	=> '3',
						'4'	=> '4',
						'5'	=> '5',
						'6'	=> '6',
					),
				'save_always' => true,
				'group' => esc_html__( 'Carousel Options', 'orfarm' ),
			),
			array(
				'type' => 'dropdown',
				'holder' => 'div',
				'class' => '',
				'heading' => esc_html__( 'Columns count on big tablet (768px - 991px)', 'orfarm' ),
				'param_name' => 'bigtablet',
				'value' => array(
						'1'	=> '1',
						'2'	=> '2',
						'3'	=> '3',
						'4'	=> '4',
						'5'	=> '5',
						'6'	=> '6',
					),
				'save_always' => true,
				'group' => esc_html__( 'Carousel Options', 'orfarm' ),
			),
			array(
				'type' => 'dropdown',
				'holder' => 'div',
				'class' => '',
				'heading' => esc_html__( 'Columns count tablet (640px - 767px)', 'orfarm' ),
				'param_name' => 'tablet_count',
				'value' => array(
						'1'	=> '1',
						'2'	=> '2',
						'3'	=> '3',
						'4'	=> '4',
						'5'	=> '5',
					),
				'save_always' => true,
				'group' => esc_html__( 'Carousel Options', 'orfarm' ),
			),
			array(
				'type' => 'dropdown',
				'holder' => 'div',
				'class' => '',
				'heading' => esc_html__( 'Columns count tablet small (480px - 639px)', 'orfarm' ),
				'param_name' => 'tabletsmall',
				'value' => array(
						'1'	=> '1',
						'2'	=> '2',
						'3'	=> '3',
						'4'	=> '4',
						'5'	=> '5',
					),
				'save_always' => true,
				'group' => esc_html__( 'Carousel Options', 'orfarm' ),
			),
			array(
				'type' => 'dropdown',
				'holder' => 'div',
				'class' => '',
				'heading' => esc_html__( 'Columns count mobile (Under 479px)', 'orfarm' ),
				'param_name' => 'mobile_count',
				'value' => array(
						'1'	=> '1',
						'2'	=> '2',
						'3'	=> '3',
						'4'	=> '4',
						'5'	=> '5',
					),
				'save_always' => true,
				'group' => esc_html__( 'Carousel Options', 'orfarm' ),
			),
			array(
				'type' => 'textfield',
				'holder' => 'div',
				'class' => '',
				'heading' => esc_html__( 'Margin', 'orfarm' ),
				'param_name' => 'margin',
				'value' => '0',
				'group' => esc_html__( 'Carousel Options', 'orfarm' ),
			),
			array(
				'type' => 'textfield',
				'holder' => 'div',
				'class' => '',
				'heading' => esc_html__( 'Extra class name', 'orfarm' ),
				'param_name' => 'el_class',
				'value' => '',
				'description' => esc_html__( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'orfarm' )
			)
		)
	) );
	
	//Testimonials
	vc_map( array(
		'name' => esc_html__( 'Orfarm Testimonials', 'orfarm' ),
		'base' => 'testimonials',
		'class' => '',
		'category' => esc_html__( 'Orfarm Theme', 'orfarm'),
		'params' => array(
			array(
				'type' => 'textfield',
				'holder' => 'div',
				'class' => '',
				'heading' => esc_html__( 'Title', 'orfarm' ),
				'param_name' => 'title',
				'value' => '',
			),
			array(
				'type' => 'textarea',
				'holder' => 'div',
				'class' => '',
				'heading' => esc_html__( 'Short description', 'orfarm' ),
				'param_name' => 'short_desc',
				'value' => '',
			),
			array(
				'type' => 'dropdown',
				'holder' => 'div',
				'class' => '',
				'heading' => esc_html__( 'Alignment', 'orfarm' ),
				'param_name' => 'alignment',
				'value' => array(
						esc_html__( 'Left', 'orfarm' )	 	=> 'left',
						esc_html__( 'Center', 'orfarm' ) 		=> 'center',
						esc_html__( 'Right', 'orfarm' ) 	=> 'right',
					),
				'save_always' => 'center',
			),
			array(
				'type' => 'textfield',
				'holder' => 'div',
				'class' => '',
				'heading' => esc_html__( 'Number of products to show', 'orfarm' ),
				'param_name' => 'number',
				'value' => '10',
			),
			array(
				'type' => 'dropdown',
				'holder' => 'div',
				'class' => '',
				'heading' => esc_html__( 'Item Design', 'orfarm' ),
				'param_name' => 'item_style',
				'value' => array(
						esc_html__( 'Design 1', 'orfarm' ) 	=> 'style-1',
						esc_html__( 'Design 2', 'orfarm' ) 		=> 'style-2',
					),
				'save_always' => true,
			),
			array(
				'type' => 'dropdown',
				'holder' => 'div',
				'class' => '',
				'heading' => esc_html__( 'Style', 'orfarm' ),
				'param_name' => 'style',
				'value' => array(
						esc_html__( 'Carousel', 'orfarm' ) 	=> 'carousel',
						esc_html__( 'List', 'orfarm' ) 		=> 'list',
					),
			),
			array(
				'type' => 'dropdown',
				'holder' => 'div',
				'class' => '',
				'heading' => esc_html__( 'Show on effect', 'orfarm' ),
				'param_name' => 'showon_effect',
				'value' => lionthemes_get_effect_list(),
				'save_always' => true,
			),
			array(
				'type' => 'dropdown',
				'holder' => 'div',
				'class' => '',
				'heading' => esc_html__( 'Columns', 'orfarm' ),
				'param_name' => 'columns',
				'value' => array(
						'1'	=> '1',
						'2'	=> '2',
						'3'	=> '3',
						'4'	=> '4',
						'5'	=> '5',
						'6'	=> '6',
					),
				'save_always' => true,
			),
			array(
				'type' => 'dropdown',
				'holder' => 'div',
				'class' => '',
				'heading' => esc_html__( 'Columns count on big desktop (Over 1500px)', 'orfarm' ),
				'param_name' => 'bigdesk',
				'value' => array(
						'1'	=> '1',
						'2'	=> '2',
						'3'	=> '3',
						'4'	=> '4',
						'5'	=> '5',
						'6'	=> '6',
					),
				'save_always' => true,
				'group' => esc_html__( 'Carousel Options', 'orfarm' ),
			),
			array(
				'type' => 'dropdown',
				'holder' => 'div',
				'class' => '',
				'heading' => esc_html__( 'Number of rows', 'orfarm' ),
				'param_name' => 'rows',
				'value' => array(
						'1'	=> '1',
						'2'	=> '2',
						'3'	=> '3',
						'4'	=> '4',
					),
				'save_always' => true,
				'group' => esc_html__( 'Carousel Options', 'orfarm' ),
			),
			array(
				'type' => 'dropdown',
				'holder' => 'div',
				'class' => '',
				'heading' => esc_html__( 'Auto rotate', 'orfarm' ),
				'param_name' => 'autoplay',
				'value' => array(
					esc_html__( 'Yes', 'orfarm' ) 	=> 'true',
					esc_html__( 'No', 'orfarm' ) 	=> 'false',
				),
				'save_always' => true,
				'group' => esc_html__( 'Carousel Options', 'orfarm' ),
			),
			array(
				'type' => 'dropdown',
				'holder' => 'div',
				'class' => '',
				'heading' => esc_html__( 'Pagination', 'orfarm' ),
				'param_name' => 'pagination',
				'value' => array(
					esc_html__( 'Yes', 'orfarm' ) 	=> 'true',
					esc_html__( 'No', 'orfarm' ) 	=> 'false',
				),
				'save_always' => true,
				'group' => esc_html__( 'Carousel Options', 'orfarm' ),
			),
			array(
				'type' => 'dropdown',
				'holder' => 'div',
				'class' => '',
				'heading' => esc_html__( 'Control Navigation', 'orfarm' ),
				'param_name' => 'control_nav',
				'value' => array(
					esc_html__( 'No', 'orfarm' ) 	=> 'false',
					esc_html__( 'Yes', 'orfarm' ) 	=> 'true',
				),
				'save_always' => true,
				'group' => esc_html__( 'Carousel Options', 'orfarm' ),
			),
			array(
				'type' => 'textfield',
				'holder' => 'div',
				'class' => '',
				'heading' => esc_html__( 'Play Timeout', 'orfarm' ),
				'param_name' => 'playtimeout',
				'value' => '5000',
				'save_always' => true,
				'group' => esc_html__( 'Carousel Options', 'orfarm' ),
			),
			array(
				'type' => 'textfield',
				'holder' => 'div',
				'class' => '',
				'heading' => esc_html__( 'Rotate speed', 'orfarm' ),
				'param_name' => 'speed',
				'value' => '250',
				'save_always' => true,
				'group' => esc_html__( 'Carousel Options', 'orfarm' ),
			),
			array(
				'type' => 'dropdown',
				'holder' => 'div',
				'class' => '',
				'heading' => esc_html__( 'Columns count desktop small (992px - 1199px)', 'orfarm' ),
				'param_name' => 'desksmall',
				'value' => array(
						'1'	=> '1',
						'2'	=> '2',
						'3'	=> '3',
						'4'	=> '4',
						'5'	=> '5',
						'6'	=> '6',
					),
				'save_always' => true,
				'group' => esc_html__( 'Carousel Options', 'orfarm' ),
			),
			array(
				'type' => 'dropdown',
				'holder' => 'div',
				'class' => '',
				'heading' => esc_html__( 'Columns count on big tablet (768px - 991px)', 'orfarm' ),
				'param_name' => 'bigtablet',
				'value' => array(
						'1'	=> '1',
						'2'	=> '2',
						'3'	=> '3',
						'4'	=> '4',
						'5'	=> '5',
						'6'	=> '6',
					),
				'save_always' => true,
				'group' => esc_html__( 'Carousel Options', 'orfarm' ),
			),
			array(
				'type' => 'dropdown',
				'holder' => 'div',
				'class' => '',
				'heading' => esc_html__( 'Columns count tablet (640px - 767px)', 'orfarm' ),
				'param_name' => 'tablet_count',
				'value' => array(
						'1'	=> '1',
						'2'	=> '2',
						'3'	=> '3',
						'4'	=> '4',
						'5'	=> '5',
					),
				'save_always' => true,
				'group' => esc_html__( 'Carousel Options', 'orfarm' ),
			),
			array(
				'type' => 'dropdown',
				'holder' => 'div',
				'class' => '',
				'heading' => esc_html__( 'Columns count tablet small (480px - 639px)', 'orfarm' ),
				'param_name' => 'tabletsmall',
				'value' => array(
						'1'	=> '1',
						'2'	=> '2',
						'3'	=> '3',
						'4'	=> '4',
						'5'	=> '5',
					),
				'save_always' => true,
				'group' => esc_html__( 'Carousel Options', 'orfarm' ),
			),
			array(
				'type' => 'dropdown',
				'holder' => 'div',
				'class' => '',
				'heading' => esc_html__( 'Columns count mobile (Under 479px)', 'orfarm' ),
				'param_name' => 'mobile_count',
				'value' => array(
						'1'	=> '1',
						'2'	=> '2',
						'3'	=> '3',
						'4'	=> '4',
						'5'	=> '5',
					),
				'save_always' => true,
				'group' => esc_html__( 'Carousel Options', 'orfarm' ),
			),
			array(
				'type' => 'textfield',
				'holder' => 'div',
				'class' => '',
				'heading' => esc_html__( 'Margin', 'orfarm' ),
				'param_name' => 'margin',
				'value' => '0',
				'group' => esc_html__( 'Carousel Options', 'orfarm' ),
			),
			array(
				'type' => 'textfield',
				'holder' => 'div',
				'class' => '',
				'heading' => esc_html__( 'Extra class name', 'orfarm' ),
				'param_name' => 'el_class',
				'value' => '',
				'description' => esc_html__( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'orfarm' )
			)
		)
	) );

	//Mail Chimp Newsletter Form
	vc_map( array(
		'name' => esc_html__( 'Newsletter Form (Mail Chimp)', 'orfarm' ),
		'base' => 'mailchimp_form',
		'class' => '',
		'category' => esc_html__( 'Orfarm Theme', 'orfarm'),
		'params' => array(
			array(
				'type' => 'textfield',
				'holder' => 'div',
				'class' => '',
				'heading' => esc_html__( 'Title', 'orfarm' ),
				'param_name' => 'title',
				'value' => '',
			),
			array(
				'type' => 'textarea',
				'holder' => 'div',
				'class' => '',
				'heading' => esc_html__( 'Short description', 'orfarm' ),
				'param_name' => 'short_desc',
				'value' => '',
			),
			array(
				'type' => 'dropdown',
				'holder' => 'div',
				'class' => '',
				'heading' => esc_html__( 'Alignment', 'orfarm' ),
				'param_name' => 'alignment',
				'value' => array(
						esc_html__( 'Left', 'orfarm' )	 	=> 'left',
						esc_html__( 'Center', 'orfarm' ) 		=> 'center',
						esc_html__( 'Right', 'orfarm' ) 	=> 'right',
					),
				'save_always' => 'center',
			),
			array(
				'type' => 'textfield',
				'holder' => 'div',
				'class' => '',
				'heading' => esc_html__( 'Form ID', 'orfarm' ),
				'param_name' => 'id',
				'value' => '',
				'description' => esc_html__( 'Enter form ID here', 'orfarm' ),
			),
			array(
				'type' => 'dropdown',
				'holder' => 'div',
				'class' => '',
				'heading' => esc_html__( 'Layout style', 'orfarm' ),
				'param_name' => 'style',
				'value' => array(
						esc_html__('Style 1', 'orfarm')	=> ' style_1',
						esc_html__('Style 2', 'orfarm')	=> ' style_2',
						esc_html__('Style 3', 'orfarm')	=> ' style_3',
					),
				'save_always' => true,
				'description' => esc_html__( 'This option for list style defined help for theme design.', 'orfarm' )
			),
			array(
				'type' => 'textfield',
				'holder' => 'div',
				'class' => '',
				'heading' => esc_html__( 'Extra class name', 'orfarm' ),
				'param_name' => 'el_class',
				'value' => '',
				'description' => esc_html__( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'orfarm' )
			)
		)
	) );
	
	//Feature content widget
	vc_map( array(
		'name' => esc_html__( 'Feature content', 'orfarm' ),
		'base' => 'featuredcontent',
		'class' => '',
		'category' => esc_html__( 'Orfarm Theme', 'orfarm'),
		'params' => array(
			array(
				'type' => 'textfield',
				'holder' => 'div',
				'class' => '',
				'heading' => esc_html__( 'Icon shortcode', 'orfarm' ),
				'description' => 'Support <a target="_blank" href="http://astronautweb.co/snippet/font-awesome/">Awesome icons (fa heart)</a> and <a target="_blank" href="https://linearicons.com/free">Linear icons(lnr car)</a>',
				'param_name' => 'icon',
				'value' => '',
			),
			array(
				'type' => 'textarea_raw_html',
				'holder' => 'div',
				'class' => '',
				'heading' => esc_html__( 'Feature text', 'orfarm' ),
				'param_name' => 'feature_text',
				'value' => '',
			),
			array(
				'type' => 'textarea_raw_html',
				'holder' => 'div',
				'class' => '',
				'heading' => esc_html__( 'Short description', 'orfarm' ),
				'param_name' => 'short_desc',
				'value' => '',
			),
			array(
				'type' => 'dropdown',
				'holder' => 'div',
				'class' => '',
				'heading' => esc_html__( 'Alignment', 'orfarm' ),
				'param_name' => 'alignment',
				'value' => array(
						esc_html__( 'Left', 'orfarm' )	 	=> 'left',
						esc_html__( 'Center', 'orfarm' ) 		=> 'center',
						esc_html__( 'Right', 'orfarm' ) 	=> 'right',
					),
				'save_always' => 'center',
			),
			array(
				'type' => 'dropdown',
				'holder' => 'div',
				'class' => '',
				'heading' => esc_html__( 'Show on effect', 'orfarm' ),
				'param_name' => 'showon_effect',
				'value' => lionthemes_get_effect_list(),
				'save_always' => true,
			),
			array(
				'type' => 'dropdown',
				'holder' => 'div',
				'class' => '',
				'heading' => esc_html__( 'Layout style', 'orfarm' ),
				'param_name' => 'style',
				'value' => array(
						esc_html__('Style 1', 'orfarm')	=> 'style_1',
						esc_html__('Style 2', 'orfarm')	=> 'style_2',
						esc_html__('Style 3', 'orfarm')	=> 'style_3',
					),
				'save_always' => true,
				'description' => esc_html__( 'This option for list style defined help for theme design.', 'orfarm' )
			),
			array(
				'type' => 'textfield',
				'holder' => 'div',
				'class' => '',
				'heading' => esc_html__( 'Extra class name', 'orfarm' ),
				'param_name' => 'el_class',
				'value' => '',
				'description' => esc_html__( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'orfarm' )
			)
		)
	) );
	
	//Latest posts
	vc_map( array(
		'name' => esc_html__( 'Blog posts', 'orfarm' ),
		'base' => 'blogposts',
		'class' => '',
		'category' => esc_html__( 'Orfarm Theme', 'orfarm'),
		'params' => array(
			array(
				'type' => 'textfield',
				'holder' => 'div',
				'class' => '',
				'heading' => esc_html__( 'Title', 'orfarm' ),
				'param_name' => 'title',
				'value' => '',
			),
			array(
				'type' => 'textarea',
				'holder' => 'div',
				'class' => '',
				'heading' => esc_html__( 'Short description', 'orfarm' ),
				'param_name' => 'short_desc',
				'value' => '',
			),
			array(
				'type' => 'dropdown',
				'holder' => 'div',
				'class' => '',
				'heading' => esc_html__( 'Alignment', 'orfarm' ),
				'param_name' => 'alignment',
				'value' => array(
						esc_html__( 'Left', 'orfarm' )	 	=> 'left',
						esc_html__( 'Center', 'orfarm' ) 		=> 'center',
						esc_html__( 'Right', 'orfarm' ) 	=> 'right',
					),
			),
			array(
				'type' => 'textfield',
				'holder' => 'div',
				'class' => '',
				'heading' => esc_html__( 'Number of post to show', 'orfarm' ),
				'param_name' => 'number',
				'value' => '5',
			),
			array(
				'type' => 'dropdown',
				'holder' => 'div',
				'class' => '',
				'heading' => esc_html__( 'Show categories', 'orfarm' ),
				'param_name' => 'show_categories',
				'value' => array(
					esc_html__( 'Yes', 'orfarm' ) 	=> 'true',
					esc_html__( 'No', 'orfarm' ) 	=> 'false',
				),
				'save_always' => true,
			),
			array(
				'type' => 'dropdown',
				'holder' => 'div',
				'class' => '',
				'heading' => esc_html__( 'Style', 'orfarm' ),
				'param_name' => 'style',
				'value' => array(
						esc_html__( 'Carousel', 'orfarm' ) 	=> 'carousel',
						esc_html__( 'List', 'orfarm' ) 		=> 'list',
						esc_html__( 'Grid', 'orfarm' )	 	=> 'grid',
					),
			),
			array(
				'type' => 'dropdown',
				'holder' => 'div',
				'class' => '',
				'heading' => esc_html__( 'Design layout', 'orfarm' ),
				'param_name' => 'layout',
				'value' => array(
					esc_html__( 'Design 1 (default)', 'orfarm' ) 	=> '',
					esc_html__( 'Design 2', 'orfarm' ) 	=> 'layout-2',
				),
				'save_always' => true,
			),
			array(
				'type' => 'dropdown',
				'holder' => 'div',
				'class' => '',
				'heading' => esc_html__( 'Columns', 'orfarm' ),
				'param_name' => 'columns',
				'value' => array(
						'1'	=> '1',
						'2'	=> '2',
						'3'	=> '3',
						'4'	=> '4',
						'5'	=> '5',
					),
				'save_always' => true,
			),
			array(
				'type' => 'dropdown',
				'holder' => 'div',
				'class' => '',
				'heading' => esc_html__( 'Show on effect', 'orfarm' ),
				'param_name' => 'showon_effect',
				'value' => lionthemes_get_effect_list(),
				'save_always' => true,
			),
			array(
				'type' => 'dropdown',
				'holder' => 'div',
				'class' => '',
				'heading' => esc_html__( 'Number of rows', 'orfarm' ),
				'param_name' => 'rows',
				'value' => array(
						'1'	=> '1',
						'2'	=> '2',
						'3'	=> '3',
						'4'	=> '4',
					),
				'save_always' => true,
				'group' => esc_html__( 'Carousel Options', 'orfarm' ),
			),
			array(
				'type' => 'dropdown',
				'holder' => 'div',
				'class' => '',
				'heading' => esc_html__( 'Auto rotate', 'orfarm' ),
				'param_name' => 'autoplay',
				'value' => array(
					esc_html__( 'No', 'orfarm' ) 	=> 'false',
					esc_html__( 'Yes', 'orfarm' ) 	=> 'true',
				),
				'save_always' => true,
				'group' => esc_html__( 'Carousel Options', 'orfarm' ),
			),
			array(
				'type' => 'textfield',
				'holder' => 'div',
				'class' => '',
				'heading' => esc_html__( 'Play Timeout', 'orfarm' ),
				'param_name' => 'playtimeout',
				'value' => '5000',
				'save_always' => true,
				'group' => esc_html__( 'Carousel Options', 'orfarm' ),
			),
			array(
				'type' => 'textfield',
				'holder' => 'div',
				'class' => '',
				'heading' => esc_html__( 'Rotate speed', 'orfarm' ),
				'param_name' => 'speed',
				'value' => '250',
				'save_always' => true,
				'group' => esc_html__( 'Carousel Options', 'orfarm' ),
			),
			array(
				'type' => 'dropdown',
				'holder' => 'div',
				'class' => '',
				'heading' => esc_html__( 'Image scale', 'orfarm' ),
				'param_name' => 'image',
				'value' => array(
						esc_html__( 'Wide', 'orfarm' )	=> 'wide',
						esc_html__( 'Square', 'orfarm' ) => 'square',
					),
				'save_always' => true,
			),
			array(
				'type' => 'textfield',
				'holder' => 'div',
				'class' => '',
				'heading' => esc_html__( 'Excerpt length', 'orfarm' ),
				'param_name' => 'length',
				'value' => '20',
			),
			array(
				'type' => 'textfield',
				'holder' => 'div',
				'class' => '',
				'heading' => esc_html__( 'Readmore text', 'orfarm' ),
				'param_name' => 'readmore_text',
				'value' => 'Read more',
				'save_always' => true,
			),
			array(
				'type' => 'dropdown',
				'holder' => 'div',
				'class' => '',
				'heading' => esc_html__( 'Order by', 'orfarm' ),
				'param_name' => 'orderby',
				'value' => array(
						esc_html__( 'Posted Date', 'orfarm' )	=> 'date',
						esc_html__( 'Ordering', 'orfarm' ) => 'menu_order',
						esc_html__( 'Random', 'orfarm' ) => 'rand',
					),
			),
			array(
				'type' => 'dropdown',
				'holder' => 'div',
				'class' => '',
				'heading' => esc_html__( 'Order Direction', 'orfarm' ),
				'param_name' => 'order',
				'value' => array(
						esc_html__( 'Descending', 'orfarm' )	=> 'DESC',
						esc_html__( 'Ascending', 'orfarm' ) => 'ASC',
					),
			),
			array(
				'type' => 'dropdown',
				'holder' => 'div',
				'class' => '',
				'heading' => esc_html__( 'Columns count on big desktop (Over 1500px)', 'orfarm' ),
				'param_name' => 'bigdesk',
				'value' => array(
						'1'	=> '1',
						'2'	=> '2',
						'3'	=> '3',
						'4'	=> '4',
						'5'	=> '5',
						'6'	=> '6',
					),
				'save_always' => true,
				'group' => esc_html__( 'Carousel Options', 'orfarm' ),
			),
			array(
				'type' => 'dropdown',
				'holder' => 'div',
				'class' => '',
				'heading' => esc_html__( 'Columns count desktop small (992px - 1199px)', 'orfarm' ),
				'param_name' => 'desksmall',
				'value' => array(
						'1'	=> '1',
						'2'	=> '2',
						'3'	=> '3',
						'4'	=> '4',
						'5'	=> '5',
						'6'	=> '6',
					),
				'save_always' => true,
				'group' => esc_html__( 'Carousel Options', 'orfarm' ),
			),
			array(
				'type' => 'dropdown',
				'holder' => 'div',
				'class' => '',
				'heading' => esc_html__( 'Columns count on big tablet (768px - 991px)', 'orfarm' ),
				'param_name' => 'bigtablet',
				'value' => array(
						'1'	=> '1',
						'2'	=> '2',
						'3'	=> '3',
						'4'	=> '4',
						'5'	=> '5',
						'6'	=> '6',
					),
				'save_always' => true,
				'group' => esc_html__( 'Carousel Options', 'orfarm' ),
			),
			array(
				'type' => 'dropdown',
				'holder' => 'div',
				'class' => '',
				'heading' => esc_html__( 'Columns count tablet (640px - 767px)', 'orfarm' ),
				'param_name' => 'tablet_count',
				'value' => array(
						'1'	=> '1',
						'2'	=> '2',
						'3'	=> '3',
						'4'	=> '4',
						'5'	=> '5',
					),
				'save_always' => true,
				'group' => esc_html__( 'Carousel Options', 'orfarm' ),
			),
			array(
				'type' => 'dropdown',
				'holder' => 'div',
				'class' => '',
				'heading' => esc_html__( 'Columns count tablet small (480px - 639px)', 'orfarm' ),
				'param_name' => 'tabletsmall',
				'value' => array(
						'1'	=> '1',
						'2'	=> '2',
						'3'	=> '3',
						'4'	=> '4',
						'5'	=> '5',
					),
				'save_always' => true,
				'group' => esc_html__( 'Carousel Options', 'orfarm' ),
			),
			array(
				'type' => 'dropdown',
				'holder' => 'div',
				'class' => '',
				'heading' => esc_html__( 'Columns count mobile (Under 479px)', 'orfarm' ),
				'param_name' => 'mobile_count',
				'value' => array(
						'1'	=> '1',
						'2'	=> '2',
						'3'	=> '3',
						'4'	=> '4',
						'5'	=> '5',
					),
				'save_always' => true,
				'group' => esc_html__( 'Carousel Options', 'orfarm' ),
			),
			array(
				'type' => 'textfield',
				'holder' => 'div',
				'class' => '',
				'heading' => esc_html__( 'Margin', 'orfarm' ),
				'param_name' => 'margin',
				'value' => '0',
				'group' => esc_html__( 'Carousel Options', 'orfarm' ),
			),
			array(
				'type' => 'textfield',
				'holder' => 'div',
				'class' => '',
				'heading' => esc_html__( 'Extra class name', 'orfarm' ),
				'param_name' => 'el_class',
				'value' => '',
				'description' => esc_html__( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'orfarm' )
			)
		)
	) );
}
// Filter to replace default css class names for vc_row shortcode and vc_column
add_filter( 'vc_shortcodes_css_class', 'orfarm_custom_css_classes_for_vc_row_and_vc_column', 10, 2 );
function orfarm_custom_css_classes_for_vc_row_and_vc_column( $class_string, $tag ) {
  $class_string = str_replace( 'vc_row ', 'section-element vc_row ', $class_string ); // This will replace "vc_col-sm-%" with "my_col-sm-%"
  return $class_string; // Important: you should always return modified or original $class_string
}
?>