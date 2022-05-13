<?php 
	global $product, $hide_actions;
	$orfarm_opt = get_option('orfarm_opt');
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
		<?php if (empty($hide_actions) || !empty($orfarm_opt['enable_addcart'])) { ?>
			<div class="box-action">
				<?php if (empty($hide_actions)) { ?>
					<div class="item-buttons">
						<?php if(!empty($orfarm_opt['enable_wishlist'])){ ?>
							<?php if ( class_exists( 'YITH_WCWL' ) ) {
								echo preg_replace("/<img[^>]+\>/i", " ", do_shortcode('[yith_wcwl_add_to_wishlist]'));
							} ?>
						<?php } ?>
					
						<?php if(!empty($orfarm_opt['enable_compare'])){ ?>
							<?php if( class_exists( 'YITH_Woocompare' ) ) {
								echo do_shortcode('[yith_compare_button]');
							} ?>
						<?php } ?>

						<?php if(!empty($orfarm_opt['enable_quickview'])){ ?>
							<div class="quickviewbtn d-none d-md-block">
								<a class="detail-link quickview" data-quick-id="<?php the_ID();?>" href="<?php the_permalink(); ?>" title="<?php echo esc_attr('Quick View');?>"><?php esc_html_e('Quick View', 'orfarm');?></a>
							</div>
						<?php } ?>	

						<?php if(!empty($orfarm_opt['enable_addcart'])){ ?>
							<div class="button-switch d-md-none">
								<svg width="16" height="16" viewBox="0 0 14 16" fill="none" xmlns="http://www.w3.org/2000/svg">
								<path fill-rule="evenodd" clip-rule="evenodd" d="M4.39173 4.12764C4.44388 2.94637 5.40766 2.00487 6.58894 2.00487H7.38873C8.57131 2.00487 9.53591 2.94846 9.5861 4.13155C7.78094 4.36058 6.15509 4.35461 4.39173 4.12764ZM3.18982 5.16767L3.18982 7.73151C3.18982 8.06644 3.45838 8.33795 3.78966 8.33795C4.12095 8.33795 4.38951 8.06644 4.38951 7.73152L4.38951 5.33644C6.14735 5.55157 7.79071 5.55699 9.58815 5.34012V7.86711C9.58815 8.20204 9.85671 8.47355 10.188 8.47355C10.5193 8.47355 10.7878 8.20204 10.7878 7.86711V5.17238C12.0268 5.06423 13.025 6.16508 12.7509 7.30009L12.0455 10.2203C11.9677 10.5424 12.1657 10.8665 12.4877 10.9443C12.8098 11.022 13.1339 10.824 13.2116 10.502L13.917 7.58177C14.4003 5.58093 12.6964 3.86781 10.7784 3.97096C10.6482 2.19332 9.18032 0.791992 7.38873 0.791992H6.58894C4.79881 0.791992 3.33188 2.19103 3.19955 3.96661C1.28928 3.87048 -0.398284 5.57815 0.0829708 7.57053L1.49644 13.4223C1.80462 14.6981 2.9479 15.5959 4.26085 15.5959H9.74186C11.0548 15.5959 12.1981 14.6981 12.5063 13.4223C12.584 13.1003 12.3861 12.7761 12.064 12.6984C11.742 12.6206 11.4179 12.8186 11.3401 13.1406C11.1624 13.8764 10.5022 14.3962 9.74186 14.3962H4.26085C3.50047 14.3962 2.84032 13.8764 2.66259 13.1406L1.24911 7.28885C0.976309 6.15944 1.96169 5.06742 3.18982 5.16767Z" fill="#2D2A6E"></path>
								</svg>
								<?php orfarm_ajax_add_to_cart_button(); ?>
							</div>
						<?php } ?>
					</div>
				<?php } ?>	
				
			</div>
		<?php } ?>
	</div>