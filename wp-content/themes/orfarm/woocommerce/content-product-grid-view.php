<?php 
$classes = array();
$classes[] = 'item-col';
?>
<div <?php post_class( $classes ); ?>>
	<div class="product-wrapper"> 
		<?php do_action( 'woocommerce_before_shop_loop_item' ); ?>	
		<?php do_action( 'orfarm_product_label_before_loop' );   ?>
		<div class="product-thumbnail">
			<?php wc_get_template_part( 'content', 'product-grid-button' ); ?>
		</div>
		<?php do_action( 'woocommerce_before_shop_loop_item_title' ); ?>
		<div class="product-info">
			<?php wc_get_template_part( 'content', 'products-grid-style' ); ?>
		</div>
	</div>
</div>