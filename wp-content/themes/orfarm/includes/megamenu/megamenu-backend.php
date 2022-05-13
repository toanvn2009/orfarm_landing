<?php 
function menu_item_width_menu( $item_id, $item ) {
	if ( $item->menu_item_parent != 0 ) return;
	$menu_item_width = get_post_meta( $item_id, '_menu_item_width', true );
	$menu_width = explode('_',$menu_item_width);
	$menu_width_selected = $menu_width[0];
	?>
	<div style="clear: both;">
	    <span class="type-menu"><?php _e( "Sub menu Width (only apply for sub menu make by elementor)", 'orfarm' ); ?></span><br />
		<input type="hidden" class="nav-menu-id" value="<?php echo esc_attr($item_id) ;?>" />
	    <div class="logged-input-holder">
			<select class="item_width" name="menu_item_width[<?php echo esc_attr($item_id) ;?>]" id="menu-item-type-<?php echo esc_attr($item_id) ;?>">
			    <option value="default" <?php if( $menu_item_width =='default' ) {?> selected="selected" <?php } ?> ><?php _e( "default", 'orfarm' ); ?></option>
			    <option value="fullwidth" <?php if( $menu_item_width =='fullwidth' ) {?> selected="selected" <?php } ?> ><?php _e( "Full width", 'orfarm' ); ?></option>
			    <option data-item ="<?php echo  esc_attr($menu_item_width); ?>" value="width" <?php if( $menu_width_selected =='width' ) {?> selected="selected" <?php } ?> ><?php _e( "Set width", 'orfarm' ); ?></option>
			</select>
	    </div>
		<input name="menu_item_width1[<?php echo esc_attr($item_id) ;?>]" type="text" class="nav-menu-width" value="<?php if( isset($menu_width[1]) ) echo esc_attr($menu_width[1]); ?>" />
	</div>
	<script type="text/javascript">
	    jQuery(document).ready(function() { 
		        jQuery('.item_width').change(function() {
					var selected = jQuery(this).val();
					if(selected == 'width') {
						jQuery(this).parent().parent().find('.nav-menu-width').show();
					} else {
						jQuery(this).parent().parent().find('.nav-menu-width').hide();
					}
				});   
				 jQuery('.item_width').each(function() {
					var selected = jQuery(this).val();
					if(selected == 'width') {
						jQuery(this).parent().parent().find('.nav-menu-width').show();
					} else {
						jQuery(this).parent().parent().find('.nav-menu-width').hide();
					}
				});   
		});
	</script>
	<?php
}
add_action( 'wp_nav_menu_item_custom_fields', 'menu_item_width_menu', 10, 2 );

function save_menu_item_width_menu( $menu_id, $menu_item_db_id ) {
	if ( isset( $_POST['menu_item_width'][$menu_item_db_id]  ) ) {
		$sanitized_data = sanitize_text_field( $_POST['menu_item_width'][$menu_item_db_id] );
		if ( $_POST['menu_item_width'][$menu_item_db_id] =='width' ) {
		    $sanitized_data = sanitize_text_field( 'width_'.$_POST['menu_item_width1'][$menu_item_db_id] );	
		}
		update_post_meta( $menu_item_db_id, '_menu_item_width', $sanitized_data );
	} else {
		delete_post_meta( $menu_item_db_id, '_menu_item_width' );
	}
}
add_action( 'wp_update_nav_menu_item', 'save_menu_item_width_menu', 10, 2 );

