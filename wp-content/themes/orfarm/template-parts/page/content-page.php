<?php
/**
 * The template for displaying posts in the Image post format
 *
 * @package LionThemes
 * @subpackage Orfarm_theme
 * @since Orfarm Themes 2.0 
 */

 $hide = (is_front_page()) ? ' hide' : '';

?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<div class="entry-content">
		<?php the_content(); ?> 
		<div class="clearfix"></div>
		<?php wp_link_pages(array(
			'before' => '<div class="page-links"><span>' . esc_html__('Pages:', 'orfarm') . '</span><ul class="pagination">',
			'after'  => '</ul></div>',
			'separator' => ''
		)); ?>
	</div>
	
	<footer class="entry-meta">
		<?php orfarm_bootstrap_edit_post_link(); ?> 
	</footer>
</article>