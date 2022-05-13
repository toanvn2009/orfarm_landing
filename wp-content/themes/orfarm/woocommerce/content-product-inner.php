<?php

global $product, $orfarm_opt, $item_layout, $show_desc, $show_sold, $hide_actions, $hide_categories, $is_deals; 
?>
	<div class="product-wrapper<?php echo esc_attr((isset($item_layout) && $item_layout == 'list') ? ' item-list-layout':' item-box-layout'); ?> post-<?php esc_attr($product->get_id()) ?>">
		<?php 
			 do_action( 'orfarm_product_label_before_loop' );
		?>
		<div class="product-thumbnail">
			<?php orfarm_the_archive_product_image_buttons(); ?>
		</div>
		<?php do_action( 'woocommerce_before_shop_loop_item_title' ); ?>
		<div class="product-info">
			<?php orfarm_the_archive_product_gridview($is_deals); ?> 
		</div>
		<?php do_action( 'woocommerce_after_shop_loop_item' ); ?>
	</div>