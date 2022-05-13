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
$image_size = apply_filters( 'woocommerce_gallery_image_size', 'woocommerce_single' );
?>
 
 <div class="product-grid-images">
	<?php 
		list($src) = wp_get_attachment_image_src($post_thumbnail_id, 'full');
		list($src_thumb) = wp_get_attachment_image_src($post_thumbnail_id, $image_size);
		$alt = trim( strip_tags( get_post_meta( $attachment_id, '_wp_attachment_image_alt', true ) ) );
		echo '<a class="prfancybox" rel="gallery-' . $product->get_id() . '" href="' . esc_url($src) . '">';
		echo '<img src="'.esc_url($src_thumb).'" alt="'.esc_attr($alt).'"/>';
		echo '</a>';
		foreach ( $attachment_ids as $attachment_id ) {
			list($src) = wp_get_attachment_image_src($attachment_id, 'full');
			list($src_thumb) = wp_get_attachment_image_src($attachment_id, $image_size);
			$alt = trim( strip_tags( get_post_meta( $attachment_id, '_wp_attachment_image_alt', true ) ) );
			echo '<a class="prfancybox" rel="gallery-' . $product->get_id() . '" href="' . esc_url($src) . '">';
			echo '<img src="'.esc_url($src_thumb).'" alt="'.esc_attr($alt).'"/>';
			echo '</a>';
		}
	?>
 </div>