<?php 
$blog_settings = orfarm_get_blog_option();
if ($blog_settings['sidebar'] == 'left' || $blog_settings['sidebar'] == 'right') { ?> 
	<div class="sidebar-blog <?php echo esc_attr($blog_settings['sidebar'] . '-sidebar') ?>" id="secondary">
		<div class="sidebar-backdrop toggle-action"></div>
		<div class="sidebar-container">
			<div class="sidebar-head">
				<a class="toggle-action" href="javascript:void(0)"><?php echo esc_html__('Close', 'orfarm') ?> &ndash;</a>
			</div>
			<div class="sidebar-scrollable">
				<?php do_action('before_sidebar'); ?> 
				<?php dynamic_sidebar('blog'); ?>
			</div>
		</div>
	</div>
<?php } ?> 