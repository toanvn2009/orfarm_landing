<?php 

$product_settings = orfarm_get_product_option();
if ($product_settings['sidebar_product'] == 'left' || $product_settings['sidebar_product'] == 'right') { ?> 
	<div class="sidebar-product <?php echo esc_attr($product_settings['sidebar_product'] . '-sidebar') ?>" id="secondary">
		<div class="sidebar-backdrop toggle-action"></div>
		<div class="sidebar-container">
			<div class="sidebar-head">
				<a class="toggle-action" href="javascript:void(0)"><?php echo esc_html__('Close', 'orfarm') ?> &ndash;</a>
			</div>
			<div class="sidebar-scrollable">
				<?php do_action('before_sidebar'); ?> 
				<?php dynamic_sidebar('product_sidebar'); ?>
			</div>
		</div>
	</div>
<?php } ?> 