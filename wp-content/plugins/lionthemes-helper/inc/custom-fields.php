<?php
// new post meta data callback
function lionthemes_post_meta_box_callback( $post ) {
	wp_nonce_field( 'lionthemes_meta_box', 'lionthemes_meta_box_nonce' );
	$value = get_post_meta( $post->ID, 'lionthemes_featured_post_value', true );
	echo '<label for="lionthemes_post_intro">';
	esc_html_e( 'This content will be used to replace the featured image, use shortcode here', 'orfarm' );
	echo '</label><br />';
	wp_editor( $value, 'lionthemes_post_intro', $settings = array() );
}
// register new meta box
add_action( 'add_meta_boxes', 'lionthemes_add_post_meta_box' );
function lionthemes_add_post_meta_box(){
	$screens = array( 'post' );
	foreach ( $screens as $screen ) {
		add_meta_box(
			'lionthemes_post_intro_section',
			esc_html__( 'Post featured content', 'orfarm' ),
			'lionthemes_post_meta_box_callback',
			$screen
		);
	}
	add_meta_box(
		'lionthemes_page_config_section',
		esc_html__( 'Page config', 'orfarm' ),
		'lionthemes_page_meta_box_callback',
		'page',
		'normal',
		'high'
	);
}
// new page meta data callback
function lionthemes_page_meta_box_callback( $post ) {
	wp_nonce_field( 'lionthemes_meta_box', 'lionthemes_meta_box_nonce' );
	$header_val = get_post_meta( $post->ID, 'lionthemes_header_page', true );
	$hide_topbar = get_post_meta( $post->ID, 'lionthemes_page_hide_topbar', true );
	$footer_val = get_post_meta( $post->ID, 'lionthemes_footer_page', true );
	$layout_val = get_post_meta( $post->ID, 'lionthemes_layout_page', true );
	$logo_val = get_post_meta( $post->ID, 'lionthemes_logo_page', true );
	$banner_val = get_post_meta( $post->ID, 'lionthemes_page_banner', true );
	$heading_val = get_post_meta( $post->ID, 'lionthemes_page_heading', true );
	$banner_h_val = get_post_meta( $post->ID, 'lionthemes_page_banner_height', true );
	$open_menu = get_post_meta( $post->ID, 'lionthemes_page_opening_cate_menus', true );
	//Footer
	$footers = get_posts(array('numberposts' => -1, 'post_type' => 'lionthemes_block'));

	echo '<div class="bootstrap">';
	
		echo '<div class="option row">';
			echo '<div class="option_label col-md-3 col-sm-12"><label for="custom_hide_topbar">' . esc_html__('Hide topbar on header:', 'orfarm') . '</label></div>';
			echo '<div class="option_field col-md-9 col-sm-12"><select id="custom_hide_topbar" name="lionthemes_page_hide_topbar">';
			echo '<option value="">'. esc_html__('Inherit theme options', 'orfarm') .'</option>';
			echo '<option value="yes"'. (($hide_topbar == 'yes') ? ' selected="selected"' : '') .'>'. esc_html__('Yes', 'orfarm') .'</option>';
			echo '<option value="no"'. (($hide_topbar == 'no') ? ' selected="selected"' : '') .'>'. esc_html__('No', 'orfarm') .'</option>';
			echo '</select></div>';
		echo '</div>';
		
		
		echo '<div class="option row">';
			echo '<div class="option_label col-md-3 col-sm-12"><label for="custom_layout_option">' . esc_html__('Custom layout:', 'orfarm') . '</label></div>';
			echo '<div class="option_field col-md-9 col-sm-12"><select id="custom_layout_option" name="lionthemes_layout_page">';
			echo '<option value="">'. esc_html__('Inherit theme options', 'orfarm') .'</option>';
			echo '<option value="full"'. (($layout_val == 'full') ? ' selected="selected"' : '') .'>'. esc_html__('Full (Default)', 'orfarm') .'</option>';
			echo '<option value="box"'. (($layout_val == 'box') ? ' selected="selected"' : '') .'>'. esc_html__('Box', 'orfarm') .'</option>';
			echo '</select></div>';
		echo '</div>';
	
		echo '<div class="option row">';
			echo '<div class="option_label col-md-3 col-sm-12"><label>' . esc_html__('Custom banner:', 'orfarm') . '</label></div>';
			echo '<div class="option_field col-md-9 col-sm-12"><input type="hidden" name="lionthemes_page_banner" value="'. esc_attr($banner_val) . '" />';
			echo '<div class="wp-media-buttons"><button class="button lionthemes_media_button" type="button"/>'. esc_html__('Upload Banner', 'orfarm') .'</button><button class="button lionthemes_remove_media_button" type="button">'. esc_html__('Remove', 'orfarm') .'</button></div>';
			echo '<div class="lionthemes_selected_media">'. (($banner_val) ? '<img style="max-width: 400px" src="'. esc_url($banner_val) .'" />':'') .'</div>';
			echo '</div>';
		echo '</div>';

		echo '<div class="option row">';
			echo '<div class="option_label col-md-3 col-sm-12"><label for="custom_page_heading">' . esc_html__('Banner Heading:', 'orfarm') . '</label></div>';
			echo '<div class="option_field col-md-9 col-sm-12">';
			echo '<input type="text" id="custom_page_heading" name="lionthemes_page_heading" value="'. $heading_val .'"/>';
			echo '</div>';
		echo '</div>';
		
		echo '<div class="option row">';
			echo '<div class="option_label col-md-3 col-sm-12"><label for="custom_banner_height">' . esc_html__('Banner Height(px):', 'orfarm') . '</label></div>';
			echo '<div class="option_field col-md-9 col-sm-12">';
			echo '<input type="number" id="custom_banner_height" name="lionthemes_page_banner_height" value="'. $banner_h_val .'"/>';
			echo '</div>';
		echo '</div>';
		
		echo '<div class="option row">';
			echo '<div class="option_label col-md-3 col-sm-12"><label for="opening_cate_menus">' . esc_html__('Open categories menu on load:', 'orfarm') . '</label></div>';
			echo '<div class="option_field col-md-9 col-sm-12">';
			echo '<input type="checkbox" id="opening_cate_menus" name="lionthemes_page_opening_cate_menus" value="1"'. ($open_menu == 1 ? ' checked="checked"': '').' />';
			echo '</div>';
		echo '</div>';

	echo '</div>';
}
// save new meta box value
add_action( 'save_post', 'lionthemes_save_meta_box_data' );
function lionthemes_save_meta_box_data( $post_id ) {
	// Check if our nonce is set.
	if ( ! isset( $_POST['lionthemes_meta_box_nonce'] ) ) {
		return;
	}
	// Verify that the nonce is valid.
	if ( ! wp_verify_nonce( $_POST['lionthemes_meta_box_nonce'], 'lionthemes_meta_box' ) ) {
		return;
	}
	// If this is an autosave, our form has not been submitted, so we don't want to do anything.
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	// Check the user's permissions.
	if ( isset( $_POST['post_type'] ) && 'page' == $_POST['post_type'] ) {
		if ( ! current_user_can( 'edit_page', $post_id ) ) {
			return;
		}
	} else {
		if ( ! current_user_can( 'edit_post', $post_id ) ) {
			return;
		}
	}
	/* OK, it's safe for us to save the data now. */
	
	// Make sure that it is set.
	if ( isset( $_POST['lionthemes_post_intro'] ) ) {
		// Sanitize user input.
		$my_data = sanitize_text_field( $_POST['lionthemes_post_intro'] );
		// Update the meta field in the database.
		update_post_meta( $post_id, 'lionthemes_featured_post_value', $my_data );
	}
	if ( isset( $_POST['lionthemes_header_page'] ) ) {
		// Sanitize user input.
		$my_data = sanitize_text_field( $_POST['lionthemes_header_page'] );
		// Update the meta field in the database.
		update_post_meta( $post_id, 'lionthemes_header_page', $my_data );
	}
	if ( isset( $_POST['lionthemes_page_hide_topbar'] ) ) {
		// Sanitize user input.
		$my_data = sanitize_text_field( $_POST['lionthemes_page_hide_topbar'] );
		// Update the meta field in the database.
		update_post_meta( $post_id, 'lionthemes_page_hide_topbar', $my_data );
	}
	if ( isset( $_POST['lionthemes_footer_page'] ) ) {
		// Sanitize user input.
		$my_data = sanitize_text_field( $_POST['lionthemes_footer_page'] );
		// Update the meta field in the database.
		update_post_meta( $post_id, 'lionthemes_footer_page', $my_data );
	}
	if ( isset( $_POST['lionthemes_layout_page'] ) ) {
		// Sanitize user input.
		$my_data = sanitize_text_field( $_POST['lionthemes_layout_page'] );
		// Update the meta field in the database.
		update_post_meta( $post_id, 'lionthemes_layout_page', $my_data );
	}
	if ( isset( $_POST['lionthemes_logo_page'] ) ) {
		// Sanitize user input.
		$my_data = sanitize_text_field( $_POST['lionthemes_logo_page'] );
		// Update the meta field in the database.
		update_post_meta( $post_id, 'lionthemes_logo_page', $my_data );
	}
	if ( isset( $_POST['lionthemes_page_banner'] ) ) {
		// Sanitize user input.
		$my_data = sanitize_text_field( $_POST['lionthemes_page_banner'] );
		// Update the meta field in the database.
		update_post_meta( $post_id, 'lionthemes_page_banner', $my_data );
	}
	if ( isset( $_POST['lionthemes_page_heading'] ) ) {
		// Sanitize user input.
		$my_data = sanitize_text_field( $_POST['lionthemes_page_heading'] );
		// Update the meta field in the database.
		update_post_meta( $post_id, 'lionthemes_page_heading', $my_data );
	}
	if ( isset( $_POST['lionthemes_page_opening_cate_menus'] ) ) {
		// Sanitize user input.
		$my_data = sanitize_text_field( $_POST['lionthemes_page_opening_cate_menus'] );
		// Update the meta field in the database.
		update_post_meta( $post_id, 'lionthemes_page_opening_cate_menus', $my_data );
	} else {
		update_post_meta( $post_id, 'lionthemes_page_opening_cate_menus', 0 );
	}
	if ( isset( $_POST['lionthemes_page_banner_height'] ) ) {
		// Sanitize user input.
		$my_data = sanitize_text_field( $_POST['lionthemes_page_banner_height'] );
		// Update the meta field in the database.
		update_post_meta( $post_id, 'lionthemes_page_banner_height', $my_data );
	}
	
	return;
}


function lionthemes_custom_media_upload_field_js($hook) {
	
	wp_enqueue_script('media-upload');
	wp_enqueue_script('thickbox');
	wp_enqueue_style('thickbox');
	
	$media_upload_js = '
		var file_frame;
		jQuery(document).on("click", ".lionthemes_remove_media_button", function(e){
			e.preventDefault();
			var _this_row = jQuery(this).closest(".option");
			_this_row.find("input").val("");
			_this_row.find(".lionthemes_selected_media").html("");
		});
		jQuery(document).on("click", ".lionthemes_media_button", function(e){
			var _this_row = jQuery(this).closest(".option");
			if (file_frame){
				file_frame.open();
				return;
			}
			file_frame = wp.media.frames.file_frame = wp.media({
				title: jQuery(this).data("uploader_title"),
				button: {
					text: jQuery(this).data("uploader_button_text"),
				},
				multiple: false
			});
			file_frame.on("select", function(){
				attachment = file_frame.state().get("selection").first().toJSON();
				var url = attachment.url;
				_this_row.find("input").val(url);
				_this_row.find(".lionthemes_selected_media").html(\'<img height="150" src="\'+ url +\'" />\');
				file_frame.close();
			});
			file_frame.open();
			e.preventDefault();
		});
	';
	wp_add_inline_script( 'media-upload', $media_upload_js );
}
add_action('admin_enqueue_scripts','lionthemes_custom_media_upload_field_js', 10, 1);

// custom block post type
function lionthemes_custom_block_type() {
	// Set UI labels for Custom Post Type
    $labels = array(
        'name'                => _x( 'Orfarm Block', 'Post Type General Name', 'lionthemes' ),
        'singular_name'       => _x( 'Orfarm Block', 'Post Type Singular Name', 'lionthemes' ),
        'menu_name'           => __( 'Orfarm Blocks', 'lionthemes' ),
        'parent_item_colon'   => __( 'Parent Block', 'lionthemes' ),
        'all_items'           => __( 'All Blocks', 'lionthemes' ),
        'view_item'           => __( 'View Block', 'lionthemes' ),
        'add_new_item'        => __( 'Add New Block', 'lionthemes' ),
        'add_new'             => __( 'Add New', 'lionthemes' ),
        'edit_item'           => __( 'Edit Block', 'lionthemes' ),
        'update_item'         => __( 'Update Block', 'lionthemes' ),
        'search_items'        => __( 'Search Block', 'lionthemes' ),
        'not_found'           => __( 'Not Found', 'lionthemes' ),
        'not_found_in_trash'  => __( 'Not found in Trash', 'lionthemes' ),
    );
     
    $args = array(
        'label'               => __( 'Orfarm Block', 'lionthemes' ),
        'description'         => __( 'Orfarm manage block layout to display in theme Orfarm', 'lionthemes' ),
        'labels'              => $labels,
        'supports'            => array( 'title', 'editor' ),
        'taxonomies'          => array(),
        'hierarchical'        => false,
        'public'              => true,
        'show_ui'             => true,
        'show_in_menu'        => true,
        'show_in_nav_menus'   => false,
        'show_in_admin_bar'   => true,
        'menu_position'       => 80,
		'query_var' 		  => true,
        'can_export'          => true,
        'has_archive'         => false,
        'exclude_from_search' => false,
        'publicly_queryable'  => true,
        'capability_type'     => 'post',
        'show_in_rest' => true,
 
    );
     
    // Registering your Custom Post Type
    register_post_type( 'lionthemes_block', $args );
}
add_action( 'init', 'lionthemes_custom_block_type', 0 );

// custom block post type menu
function lionthemes_custom_block_mega_menu() {
		$labels = array(
				'name'               => _x( 'Orfarm Megamenu', 'Post Type General Name', 'orfarm' ),
				'singular_name'      => _x( 'Orfarm Mega Menu', 'Post Type Singular Name', 'orfarm' ),
				'menu_name'          => esc_html__( 'Orfarm Mega Menu', 'orfarm' ),
				'name_admin_bar'     => esc_html__( 'Orfarm Mega Menu', 'orfarm' ),
				'parent_item_colon'  => esc_html__( 'Parent Menu:', 'orfarm' ),
				'all_items'          => esc_html__( 'All Menus', 'orfarm' ),
				'add_new_item'       => esc_html__( 'Add New Menu', 'orfarm' ),
				'add_new'            => esc_html__( 'Add New', 'orfarm' ),
				'new_item'           => esc_html__( 'New Menu', 'orfarm' ),
				'edit_item'          => esc_html__( 'Edit Menu', 'orfarm' ),
				'update_item'        => esc_html__( 'Update Menu', 'orfarm' ),
				'view_item'          => esc_html__( 'View Menu', 'orfarm' ),
				'search_items'       => esc_html__( 'Search Menu', 'orfarm' ),
				'not_found'          => esc_html__( 'Not found', 'orfarm' ),
				'not_found_in_trash' => esc_html__( 'Not found in Trash', 'orfarm' ),
			);

			$args = array(
				'label'               => esc_html__( 'Mega Menus', 'orfarm' ),
				'description'         => esc_html__( ' Mega Menu', 'orfarm' ),
				'labels'              => $labels,
				'supports'            => array(
					'title',
					'editor',
					'revisions',
				),
				'hierarchical'        => false,
				'public'              => true,
				'show_ui'             => true,
				'show_in_menu'        => true,
				'menu_position'       => 120,
				'menu_icon'           => 'dashicons-menu',
				'show_in_admin_bar'   => true,
				'show_in_nav_menus'   => true,
				'can_export'          => true,
				'has_archive'         => false,
				'exclude_from_search' => true,
				'publicly_queryable'  => true,
				'rewrite'             => false,
				'capability_type'     => 'page',
			);

			register_post_type( 'lionthemes_mega_menu', $args );
}
add_action( 'init', 'lionthemes_custom_block_mega_menu', 0 );


// Add the custom columns to the book post type:
add_filter( 'manage_lionthemes_block_posts_columns', 'lionthemes_set_custom_edit_lionthemes_block_columns' );
function lionthemes_set_custom_edit_lionthemes_block_columns($columns) {
    unset($columns['date']);
	$columns['shortcode'] = __( 'Shortcode', 'lionthemes' );

    return $columns;
}

// Add the data to the custom columns for the book post type:
add_action( 'manage_lionthemes_block_posts_custom_column' , 'lionthemes_custom_lionthemes_block_column', 10, 2 );
function lionthemes_custom_lionthemes_block_column( $column, $post_id ) {
    switch ( $column ) {

        case 'shortcode' :
            echo '[lionthemes_block id="'. $post_id .'"]';
            break;

    }
}

add_shortcode('lionthemes_block', 'lionthemes_block_shortcode');
function lionthemes_block_shortcode( $atts ) {
	$atts = shortcode_atts( array(
		'id' => 0,
	), $atts, 'lionthemes_block' );
	extract($atts);
	if (!empty($id)) {
		$args = array(
			'include'        => array(intval($id)),
			'post_type'   => 'lionthemes_block',
			'post_status' => 'publish',
			'numberposts' => 1
		);
		if( class_exists( '\Elementor\Plugin' ) )
		    return \Elementor\Plugin::instance()->frontend->get_builder_content_for_display( $id);
	
	}
  	return '';  
}
// custom field for wocommerce product 
function lionthemes_custom_woo_product_general_field() {
	$args = array(
		'id' => 'lionthemes_woo_product_sold',
		'label' => __( 'Sold after sale schedule', 'lionthemes' ),
		'class' => 'lionthemes-custom-field',
		'desc_tip' => true,
		'description' => __( 'The counter automatic decrease when place order success. You can update it if it has back order.', 'lionthemes' ),
	);
	woocommerce_wp_text_input( $args );
}
add_action( 'woocommerce_product_options_general_product_data', 'lionthemes_custom_woo_product_general_field' );

function lionthemes_save_woo_product_general_field( $post_id ) {
	$product = wc_get_product( $post_id );
	$count = isset( $_POST['lionthemes_woo_product_sold'] ) ? intval($_POST['lionthemes_woo_product_sold']) : 0;
	$product->update_meta_data( 'lionthemes_woo_product_sold', sanitize_text_field( $count ) );
	$product->save();
}
add_action( 'woocommerce_process_product_meta', 'lionthemes_save_woo_product_general_field' );

add_action('woocommerce_thankyou','lionthemes_custom_woocommerce_payment_complete');
 function lionthemes_custom_woocommerce_payment_complete($order_id){
	if ( ! $order_id )
        return;
	$order = wc_get_order( $order_id );
	foreach ( $order->get_items() as $item_id => $item ) {
		// Get the product object
		$product = $item->get_product();
		$quantity = $item->get_quantity();
		$product_id = $product->get_id();
		$sale_end = get_post_meta( $product_id, '_sale_price_dates_to', true );
		if ($sale_end && $product->is_on_sale() && $product->managing_stock()) {
			$soldout = $product->get_meta('lionthemes_woo_product_sold') ? intval($product->get_meta('lionthemes_woo_product_sold')) : 0;
			$current_date = current_time( 'timestamp' );
			$timestemp_left = intval($sale_end) + 24*60*60 - 1 - $current_date;
			if($timestemp_left > 0) {
				$soldout += $quantity;
				$product->update_meta_data( 'lionthemes_woo_product_sold', $soldout );
				$product->save();
			}
		}
	}
 }
 
 // New date field 
function woocommerce_product_custom_fields()
{
  $args = array(
      'id' => 'orfarm_new_date',
      'label' => __('New Dates', 'orfarm'),
	  'type'  => 'date',
  );
  woocommerce_wp_text_input($args);
}
 
add_action('woocommerce_product_options_advanced', 'woocommerce_product_custom_fields');

function save_woocommerce_product_custom_fields($post_id)
{
    $product = wc_get_product($post_id);
    $orfarm_new_date = isset($_POST['orfarm_new_date']) ? $_POST['orfarm_new_date'] : '';
    $product->update_meta_data('orfarm_new_date', sanitize_text_field($orfarm_new_date));
    $product->save();
}
add_action('woocommerce_process_product_meta', 'save_woocommerce_product_custom_fields');