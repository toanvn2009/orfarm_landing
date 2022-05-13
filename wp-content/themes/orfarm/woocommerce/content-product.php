<?php
/**
 * The template for displaying product content within loops.
 *
 * Override this template by copying it to yourtheme/woocommerce/content-product.php
 *
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 4.5.2
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $product, $orfarm_opt, $hide_categories;
// Ensure visibility
if ( ! $product || ! $product->is_visible() ) {
	return;
}

if (!is_bool($hide_categories)) {
	if (isset($orfarm_opt['showlist_cats'])) $hide_categories = !$orfarm_opt['showlist_cats'];
}
?>
<div class="item-col product wow fadeInUp" data-wow-duration="0.5s" data-wow-delay="100ms">
	<div class="product-wrapper"> 
		<?php do_action( 'woocommerce_before_shop_loop_item' ); ?>
		<div class="product-thumbnail">
			<?php orfarm_the_archive_product_image_buttons(); ?>
		</div>
		<?php do_action( 'woocommerce_before_shop_loop_item_title' ); ?>
		<div class="product-info">
			<?php orfarm_the_archive_product_gridview(); ?>
		</div>
		<?php do_action('orfarm_woocommerce_after_shop_loop_item_title', $product); ?>
		<?php do_action( 'woocommerce_after_shop_loop_item' ); ?>
	</div>
</div>
