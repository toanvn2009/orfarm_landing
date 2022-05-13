<?php 
$orfarm_opt = get_option( 'orfarm_opt' );
$shopsidebar = is_active_sidebar('shop') ? 'left' : 'none';
if(!empty($orfarm_opt['sidebarshop_pos']) && is_active_sidebar('shop')) $shopsidebar = $orfarm_opt['sidebarshop_pos'];
if(isset($_GET['side']) && is_active_sidebar('shop')) $shopsidebar = $_GET['side'];
if ($shopsidebar == 'left' || $shopsidebar == 'right' || $shopsidebar == 'canvas' || $shopsidebar == 'shop-filters-left'  || $shopsidebar == 'shop-filters-v2'  || $shopsidebar == 'shop-filters') { ?> 
	<div class="sidebar-shop <?php echo esc_attr($shopsidebar . '-sidebar') ?>" id="secondary">
		<div class="sidebar-backdrop toggle-action"></div>
		<div class="sidebar-container">
			<div class="sidebar-head">
				<a class="toggle-action" href="javascript:void(0)"><?php echo esc_html__('Filters', 'orfarm') ?></a>
			</div>
			<div class="sidebar-scrollable">
				<?php do_action('before_sidebar'); ?> 
				<?php dynamic_sidebar('shop'); ?>  
			</div>
		</div>
	</div>
<?php } ?> 