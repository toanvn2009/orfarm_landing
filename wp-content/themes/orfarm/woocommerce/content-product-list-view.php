<div <?php post_class( ); ?>>
	<?php  do_action( 'orfarm_product_label_before_loop' ); ?>
	<div class="product-list-item product-wrapper d-sm-flex align-items-sm-center"> 
		<?php do_action( 'woocommerce_before_shop_loop_item' ); ?>	
		<div class="product-thumbnail product-element-top">
			<?php wc_get_template_part( 'content', 'product-list-button' ); ?>
		</div>
		<?php do_action( 'woocommerce_before_shop_loop_item_title' ); ?>
		<div class="product-list-content flex-1">
			<?php wc_get_template_part( 'content', 'product-list-styles' ); ?>
		</div>
	</div>
</div>