<?php
/**
 * Single Product Meta
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/meta.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see         https://docs.woocommerce.com/document/template-structure/
 * @package     WooCommerce\Templates
 * @version     3.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

global $product;
?>
<div class="product_meta">

	<?php do_action( 'woocommerce_product_meta_start' ); ?>

	<?php if ( wc_product_sku_enabled() && ( $product->get_sku() || $product->is_type( 'variable' ) ) ) : ?>

		<div class="sku_wrapper"><span class="label"><?php esc_html_e( 'SKU:', 'orfarm' ); ?></span><div class="list-sku"><span class="sku"><?php echo esc_html_e(($product->get_sku()) ? $product->get_sku() : esc_html__( 'N/A', 'orfarm' )); ?></span></div></div>

	<?php endif; ?> 

	<?php if(count( $product->get_category_ids())) : ?>
		<div class="category_wrapper">
			<span class="label"><?php (1 == count( $product->get_category_ids())) ? ''.esc_html_e( 'Category:', 'orfarm' ).'' : ''.esc_html_e( 'Categories:', 'orfarm' ).''; ?></span>
			<?php echo wc_get_product_category_list( $product->get_id(), ', ', '<span class="posted_in">', '</span>' ); ?>
		</div>
	<?php endif; ?> 
	
	<?php if(count( $product->get_tag_ids())) : ?>
		<div class="tag_wrapper">
			<span class="label"><?php (1 == count( $product->get_tag_ids())) ? ''.esc_html_e( 'Tag:', 'orfarm' ).'' : ''.esc_html_e( 'Tags:', 'orfarm' ).''; ?></span>
			<?php echo wc_get_product_tag_list( $product->get_id(), ', ', '<span class="tagged_as">', '</span>' ); ?>
		</div>
	<?php endif; ?> 
	<?php do_action( 'woocommerce_product_meta_end' ); ?>

</div>
