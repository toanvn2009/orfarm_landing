<?php
/**
 * The template for displaying a "No posts found" message
 *
 * @package LionThemes
 * @subpackage Orfarm_Themes
 * @since Orfarm Themes 2.0 
 */
?>

	<article id="post-0" class="post no-results not-found">
		<header class="entry-header">
			<h2 class="entry-title"><?php esc_html_e( 'Nothing Found', 'orfarm' ); ?></h2>
		</header>

		<div class="entry-content">
			<p><?php esc_html_e( 'Apologies, but no results were found. Perhaps searching will help find a related post.', 'orfarm' ); ?></p>
			<?php get_search_form(); ?>
		</div>
	</article>
