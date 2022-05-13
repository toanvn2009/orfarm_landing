<?php
	$_delay = 100;
	global $item_layout, $hide_actions, $show_desc, $show_sold, $hide_categories, $is_deals;
	$item_layout = $itemlayout;
	$hide_actions = $hideactions;
	$show_desc = $showdesc;
	$show_sold = $showsold;
	$hide_categories = $hidecategories;
	$showon_effect = ($showoneffect) ? 'wow ' . $showoneffect : '';
	$is_deals = !empty($isdeals);
?>
<div class="<?php echo esc_attr(( $item_layout == 'simple' ) ? 'product_list_widget': 'products-block shop-products products grid-view'); ?>">
	<div <?php echo ''.$owl_data; ?> class="owl-carousel owl-theme products-slide">
		<?php $index = 0; while ( $loop->have_posts() ) : $loop->the_post(); global $product; ?>
				
			<?php if ( $rows > 1 && $index % $rows == 0 ) { ?>
				<div class="group">
			<?php } ?>
			
				<?php 
					if($item_layout == 'simple'){
						wc_get_template( 'content-widget-product.php', array( 
							'show_rating' => $show_rating ,
							'show_sold' => $show_sold,
							'class_column' => 'col-sm-12 col-xs-6',
							'showon_effect'=> $showon_effect,
							'hide_addcart'=> $hideactions,
							'delay' => $_delay ) );
					}else{
						?>
						<div class="product <?php echo esc_attr($showon_effect); ?>" data-wow-duration="0.5s" data-wow-delay="<?php echo esc_attr($_delay); ?>ms">
						<?php wc_get_template_part( 'content', 'product-inner' ); ?>
						</div>
						<?php
					}
				?>
			<?php $index ++; ?>
			<?php if ($rows > 1 && ( $index % $rows == 0 ||  $index == $_total ) ) { ?>
				</div>
			<?php } ?>
			<?php $_delay+=100; ?>
		<?php endwhile; ?>
	</div>
</div>
