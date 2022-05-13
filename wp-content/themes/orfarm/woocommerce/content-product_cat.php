<?php
/**
 * The template for displaying product category thumbnails within loops.
 *
 * Override this template by copying it to yourtheme/woocommerce/content-product_cat.php
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     5.2.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

global $product, $woocommerce_loop, $orfarm_opt, $orfarm_shopclass, $orfarm_viewmode;

// Store column count for displaying the grid
if ( empty( $woocommerce_loop['columns'] ) )
	$woocommerce_loop['columns'] = apply_filters( 'loop_shop_columns', 3 );

// Extra post classes
$classes = 'product-category category item-col col-xs-12';
if(!empty($orfarm_opt['product_per_row'])){
	$woocommerce_loop['columns'] = $orfarm_opt['product_per_row'];
}
$colwidth = ($woocommerce_loop['columns'] != 5) ? round(12/$woocommerce_loop['columns']) : 20;
if ($colwidth == 20 || $colwidth == 3 || $colwidth == 2) {
	$sm = ($colwidth == 20) ? 3 : $colwidth + 1;
	$classes .= ' col-sm-'. $sm .' col-md-'.$colwidth ;
} else {
	$classes .= ' col-sm-'.$colwidth ;
}
?>
<div class="product-category category<?php echo esc_attr($classes); ?>">

	<?php do_action( 'woocommerce_before_subcategory', $category ); ?>
	
	<?php do_action( 'woocommerce_before_subcategory_title', $category ); ?>
	
	<?php do_action( 'woocommerce_shop_loop_subcategory_title', $category ); ?>

	
	<?php
		/**
		 * woocommerce_after_subcategory_title hook
		 */
		do_action( 'woocommerce_after_subcategory_title', $category );
	?>
	<?php do_action( 'woocommerce_after_subcategory', $category ); ?>

</div>
