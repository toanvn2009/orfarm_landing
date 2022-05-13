<?php
/**
 * Template for quote post format
 *
 * @package LionThemes
 * @subpackage Orfarm_theme
 * @since Orfarm Themes 2.0 
 */

$blogcolumn = get_query_var('blogcolumn');
$noexcerpt = get_query_var('noexcerpt');
if(is_single()) $blogcolumn = '';
?>
<article id="post-<?php the_ID(); ?>" <?php post_class($blogcolumn); ?>>
	<div class="post-wrapper<?php if ( !has_post_thumbnail() ) { echo ' no-thumbnail';} ?>">
		<div class="post-info">
			<?php if (!$noexcerpt) { ?> 
				<div class="entry-content">
					<?php orfarm_post_entry_content() ?>
				</div>
			<?php } ?>
			<?php if ( is_single() ){ ?>
				<?php orfarm_post_footer_entry() ?>
			<?php } ?>
		</div>
	</div>
</article>