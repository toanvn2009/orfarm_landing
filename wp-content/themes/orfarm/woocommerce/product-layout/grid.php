<?php 
	global $hide_actions, $show_desc, $is_deals, $show_sold;
	$hide_actions = $hideactions;
	$show_desc = $showdesc;
	$show_sold = $showsold;
	$_delay = 100;
	$_count = 1;
	$hide_categories = $hidecategories;
	$showon_effect = ($showoneffect) ? 'wow ' . $showoneffect : '';
	$is_deals = !empty($isdeals);
?>
<div class="products-block shop-products products grid-view ">
	<div class="row">
	<?php while ( $loop->have_posts() ) : $loop->the_post(); global $product; ?>
		<!-- Product Item -->
		<div class="item-col <?php echo esc_attr($class_column); ?> product <?php echo esc_attr($showon_effect); ?>" data-wow-duration="0.5s" data-wow-delay="<?php echo esc_attr($_delay); ?>ms">
			<?php wc_get_template_part( 'content', 'product-inner' ); ?>
		</div>
		<?php $_delay+=100; ?>
		<!-- End Product Item -->
		<?php
			if($_count==$columns_count){
				$_count=0;$_delay=100;
			}
			$_count++;
		?>
	<?php endwhile; ?>
	</div>
</div>