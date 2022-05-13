<?php
/**
 * The template for displaying product content within loops.
 *
 * Override this template by copying it to yourtheme/woocommerce/content-product.php
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     4.5.2
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $product, $orfarm_opt, $hide_categories; 

// Ensure visibility
if ( ! $product || ! $product->is_visible() )
	return;

// Extra post classes
$classes = array();
$classes[] = 'item-col';
if( isset( $_GET['view_mode'] ) ) {
	$orfarm_viewmode = $_GET['view_mode'];
}

if($orfarm_viewmode == 'list-view' || $orfarm_opt['default_view'] == 'list-view' && $_GET['view_mode'] !=='grid-view') {
	wc_get_template_part( 'content', 'product-list-view' );
} else {
	wc_get_template_part( 'content', 'product-grid-view' );
}
?>

