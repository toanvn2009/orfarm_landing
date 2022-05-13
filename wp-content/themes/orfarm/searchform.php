<?php
/**
 * Template for displaying search form in orfarm theme
 *
 * @package LionThemes
 * @subpackage Orfarm_theme
 * @since Orfarm Themes 2.0 
 */

?>
<form method="get" class="search-form form" action="<?php echo esc_url(home_url('/')); ?>">
	<label for="form-search-input" class="sr-only"><?php esc_html__('Search for', 'orfarm'); ?></label>
	<div class="input-group">
		<input type="search" id="form-search-input" class="form-control" placeholder="<?php echo esc_attr_x('Search the blog &hellip;', 'placeholder', 'orfarm'); ?>" value="<?php echo esc_attr(get_search_query()); ?>" name="s" title="<?php echo esc_html__('Search for:', 'orfarm'); ?>">
		<span class="input-group-btn">
			<button type="submit" class="btn btn-default"><?php esc_html_e('Search', 'orfarm'); ?></button>
		</span>
	</div>
</form>