<?php
/**
 * Single Product Image
 *
 */
 
global $product;
$post_thumbnail_id = $product->get_image_id();
$attachment_ids = $product->get_gallery_image_ids();

if (!$post_thumbnail_id && !count($attachment_ids)) { 
	return; 
}
$image_size = apply_filters( 'woocommerce_gallery_image_size', 'woocommerce_single' );
?>
 
 <div class="product-carousel-images">
	<div data-owl="slide" data-bigdesk="3" data-desksmall="3" data-tablet="3" data-mobile="1" data-tabletsmall="2" data-item-slide="3" data-margin="30" data-ow-rtl="false" data-nav="true" data-dots="false" class="owl-carousel owl-theme">
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
			echo '<img src="'. esc_url($src_thumb).'" alt="'.esc_attr($alt).'"/>';
			echo '</a>';
		}
	?>
	</div>
 </div>