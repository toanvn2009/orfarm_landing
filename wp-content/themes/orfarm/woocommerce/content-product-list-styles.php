<?php 
global $product, $hide_categories, $show_desc, $show_sold, $orfarm_opt;
	
	?>
	<div class="list-style d-flex flex-column flex-lg-row align-items-lg-center"> 
		<div class="product-info flex-1">
			<h3 class="product-name">
				<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
			</h3>
			<?php if(!empty($orfarm_opt['enable_rate'])){ ?>
				<?php orfarm_get_rating_html(); ?>
			<?php } ?>
			
			<div class="product-desc">
				<?php the_excerpt(); ?>
				<?php do_action('orfarm_woocommerce_after_shop_loop_item_title', $product); ?>
			</div>
			<?php if (!empty($show_sold)) { ?>
				<?php $managerStock = $product->managing_stock();
				if ($managerStock) {
					$stock_quantity = intval($product->get_stock_quantity());
					$soldout = $product->get_meta('lionthemes_woo_product_sold') ? intval($product->get_meta('lionthemes_woo_product_sold')) : 0;
					$total = $stock_quantity + $soldout;
					if ($total > 0) {
					echo '<div class="sout-out-progress">
						<div class="sold-out-bar"><div class="soldout" style="width: '. ceil(($soldout / $total) * 100) .'%"></div></div>
						<div class="sold-detail">'. esc_html__('Sold:', 'orfarm') . ' ' . $soldout . '/' . $total .'</div>
					</div>';
					}
				} ?>
			<?php } ?>
		</div>
		<div class="actions-info"> 
			<?php
				if(isset($orfarm_opt['enable_cate_products']) && $orfarm_opt['enable_cate_products'] == 1 && get_the_Id() ) { 		
					//echo '<div class="product-cats-list">' . get_the_term_list(get_the_Id(), 'product_cat', '', ', ', '') . '</div>'; 
				}
				if($product->get_manage_stock() && $product->is_in_stock() ) {
					echo  '<div class="stock-available">'.esc_html__('Availability:', 'orfarm'). wc_get_stock_html( $product ).'</div>';
				} else {
				    echo wc_get_stock_html( $product );
				}
			?>
			<div class="price"><?php echo ''.$product->get_price_html(); ?></div>
			<div class="actions">

				<?php if(!empty($orfarm_opt['enable_addcart'])){ ?>
					<?php orfarm_ajax_add_to_cart_button(); ?>
				<?php } ?>
				<?php if (empty($hide_actions)) { ?>
					<div class="bl-buttons">
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
					</div>
				<?php } ?>	
			</div>
		</div>
</div>