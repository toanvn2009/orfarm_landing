<?php 
global $product, $hide_categories, $show_desc, $show_sold;
	$orfarm_opt = get_option( 'orfarm_opt' );
	?>
	<div class="gridview standard">
		<h3 class="product-name">
			<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
		</h3>
		<?php if(!empty($orfarm_opt['enable_rate'])){ ?>
			<?php orfarm_get_rating_html(); ?>
		<?php } ?>
		<div class="switcher-wrapper">
			<div class="price-switcher">
				<div class="price"><?php echo ''.$product->get_price_html(); ?></div>
			</div>
			<?php do_action('orfarm_woocommerce_after_shop_loop_item_title', $product); ?>
		</div>
		<div class="hover-content d-none d-md-block">
			<?php if(!empty($orfarm_opt['enable_addcart'])){ ?>
				<div class="button-switch">
					<?php orfarm_ajax_add_to_cart_button(); ?>
				</div>
			<?php } ?>

			<div class="product-desc">
				<?php the_excerpt(); ?>
				<?php do_action('orfarm_woocommerce_after_shop_loop_item_title', $product); ?>
			</div>	
		</div>	
		
		
		<?php if (!empty($isdeals)) {
			$current_date = current_time( 'timestamp' );
			$sale_end = get_post_meta( $product->get_id(), '_sale_price_dates_to', true );
			$timestemp_left = intval($sale_end) + 24*60*60 - 1 - $current_date;
			if($timestemp_left > 0) {
				$day_left = floor($timestemp_left / (24 * 60 * 60));
				$hours_left = floor(($timestemp_left - ($day_left * 60 * 60 * 24)) / (60 * 60));
				$mins_left = floor(($timestemp_left - ($day_left * 60 * 60 * 24) - ($hours_left * 60 * 60)) / 60);
				$secs_left = floor($timestemp_left - ($day_left * 60 * 60 * 24) - ($hours_left * 60 * 60) - ($mins_left * 60));
				
				echo '<div class="deals-countdown">
						<div class="deals-label">' . esc_html__('Harry Up! Offer end in:', 'orfarm') . '</div>
						<span class="countdown-row">	
							<span class="countdown-section">
								<span class="countdown-val days_left">'. $day_left .'</span>
								<span class="countdown-label">' . esc_html__('Days', 'orfarm') . '</span>
							</span>
							<span class="countdown-section">
								<span class="countdown-val hours_left">'. $hours_left .'</span>
								<span class="countdown-label">' . esc_html__('Hrs', 'orfarm') . '</span>
							</span>
							<span class="countdown-section">
								<span class="countdown-val mins_left">' . $mins_left . '</span>
								<span class="countdown-label">' . esc_html__('Mins', 'orfarm') . '</span>
							</span>
							<span class="countdown-section">
								<span class="countdown-val secs_left">' . $secs_left . '</span>
								<span class="countdown-label">' . esc_html__('Secs', 'orfarm') . '</span>
							</span>
						</span>
					</div>';
			}
		} ?>
		<?php if (!empty($show_sold)) { ?>
			<?php $managerStock = $product->managing_stock();
			if ($managerStock) {
				$stock_quantity = intval($product->get_stock_quantity());
				$soldout = $product->get_meta('lionthemes_woo_product_sold') ? intval($product->get_meta('lionthemes_woo_product_sold')) : 0;
				$total = $stock_quantity + $soldout;
				if ($total > 0) {
				echo '<div class="sout-out-progress">
					<div class="sold-out-bar"><div class="soldout" style="width: '. ceil(($soldout / $total) * 100) .'%"></div></div>
					<div class="sold-detail">
						<div class="sold">
							'. esc_html__('Sold:', 'orfarm') . ' <span>' . $soldout .'/' . $total .'</span>
						</div>
					</div>
				</div>';
				}
			} ?>
		<?php } ?>
	</div>