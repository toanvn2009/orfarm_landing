<?php
/**
 * The template part for displaying message that posts cannot be found.
 *
 * @package LionThemes
 * @subpackage Orfarm_theme
 * @since Orfarm Themes 2.0 
 */

?>
<section class="no-results not-found">
	<header class="page-header">
		<h1 class="page-title"><?php esc_html_e('Nothing Found', 'orfarm'); ?></h1>
	</header><!-- .page-header -->

	<div class="page-content row-with-vspace">
		<?php if (is_home() && current_user_can('publish_posts')) { ?> 
			<p><?php printf(wp_kses(__('Ready to publish your first post? <a href="%1$s">Get started here</a>.', 'orfarm'), array('a')), esc_url(admin_url('post-new.php'))); ?></p>
		<?php } elseif (is_search()) { ?> 
			<p><?php esc_html_e('Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'orfarm'); ?></p>
			<?php echo orfarm_bootstrap_fullpage_search_form(); ?> 
		<?php } else { ?> 
			<p><?php esc_html_e('It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching can help.', 'orfarm'); ?></p>
			<?php echo orfarm_bootstrap_fullpage_search_form(); ?> 
		<?php } //endif; ?> 
	</div><!-- .page-content -->
</section><!-- .no-results -->