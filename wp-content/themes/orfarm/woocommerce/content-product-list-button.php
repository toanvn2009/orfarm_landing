<?php 
	global $product, $hide_actions, $orfarm_opt ;
	$attr = empty($orfarm_opt['second_image']) ? array() : array('class' => 'primary_image');
	$size = apply_filters('single_product_archive_thumbnail_size', 'woocommerce_thumbnail');
	?>
	<div class="product-image">
		<a href="<?php the_permalink(); ?>">
			<?php
			if (!$product || ($product && !wp_get_attachment_image(get_post_thumbnail_id($product->get_id()), $size, false, $attr))) {
				if (function_exists('wc_placeholder_img')) {
					echo wc_placeholder_img( $size, $attr );
				}
			} else {
				echo wp_get_attachment_image(get_post_thumbnail_id($product->get_id()), $size, false, $attr);
				if (!empty($orfarm_opt['second_image'])) {
					$attachment_ids = $product->get_gallery_image_ids();
					if ($attachment_ids) {
						echo wp_get_attachment_image($attachment_ids[0], $size, false, array('class' => 'secondary_image'));
					}
				}
			} ?>
		</a>
	</div>