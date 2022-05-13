<?php
/**
 * The template for displaying posts in the Image post format
 *
 * @package LionThemes
 * @subpackage Orfarm_Themes
 * @since Orfarm Themes 2.0 
 */
$orfarm_opt = get_option( 'orfarm_opt' );
$blog_settings = orfarm_get_blog_option();
$blogcolumn = $blog_settings['blogcolumn'];
if(is_single()) $blogcolumn = '';
?>
<article id="post-<?php the_ID(); ?>" <?php post_class($blogcolumn); ?>>
	<div class="post-wrapper<?php if ( !has_post_thumbnail() ) { echo ' no-thumbnail';} ?>">
		<?php do_action('lionthemes_post_archive_feature'); ?>
		<div class="post-info">
			<?php orfarm_post_header_entry() ?>
			<?php if (!$blog_settings['noexcerpt']) { ?>
				<?php if (is_search()) { // Only display Excerpts for Search ?> 
				<div class="entry-summary">
					<?php the_excerpt(); ?> 
					<div class="clearfix"></div>
				</div><!-- .entry-summary -->
				<?php } else { ?> 
					<div class="entry-content">
						<?php orfarm_post_entry_content() ?>
					</div>
				<?php } //endif; ?> 
			<?php } elseif(is_single()) { ?>
				<div class="entry-content">
					<?php orfarm_post_entry_content() ?>
				</div>
			<?php } ?> 
			<?php if ( is_single() ){ ?>
				<?php orfarm_post_footer_entry() ?>
			<?php } ?>
		</div>
	</div>
</article><!-- #post-## -->