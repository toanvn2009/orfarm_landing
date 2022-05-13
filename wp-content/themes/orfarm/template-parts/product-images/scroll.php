<?php
/**
 * Single Product Image
 *
 */
 
global $product;
$post_thumbnail_id = $product->get_image_id();
$attachment_ids = $product->get_gallery_image_ids();

if (!$post_thumbnail_id && !count($attachment_ids)) { 
	$html  = '<div class="woocommerce-product-gallery__image--placeholder">';
	$html .= sprintf( '<img src="%s" alt="%s" class="wp-post-image" />', esc_url( wc_placeholder_img_src( 'woocommerce_single' ) ), esc_html__( 'Awaiting product image', 'orfarm' ) );
	$html .= '</div>';
	echo apply_filters( 'woocommerce_single_product_image_thumbnail_html', $html, $post_thumbnail_id );
	return; 
}
 
 ?>
 
 <div class="product-scroll-images">
	<?php 
		echo wp_get_attachment_image($post_thumbnail_id, 'full');
		foreach ( $attachment_ids as $attachment_id ) {
			echo wp_get_attachment_image($attachment_id, 'full');
		}
	?>
 </div>