<?php
/**
 * The template for displaying Author Archive pages
 *
 * @package LionThemes
 * @subpackage Orfarm_theme
 * @since Orfarm Themes 2.0
 */

get_header();

$orfarm_opt = get_option( 'orfarm_opt' );
$blog_settings = orfarm_get_blog_option();
set_query_var( 'blogcolumn', $blog_settings['blogcolumn'] );
?>
<?php do_action( 'orfarm_page_banner' ); ?>
<div class="main-container">
	<div class="container <?php echo esc_attr($blog_settings['sidebar'] . '-sidebar'); ?>">
			<div class="<?php echo esc_attr('maincol-sidebar-' . $blog_settings['sidebar']); ?>" id="main-blog">
				<div class="page-content blog-page grid-layout">
					<?php if ( have_posts() ) : ?>

						<?php
							/* Queue the first post, that way we know
							 * what author we're dealing with (if that is the case).
							 *
							 * We reset this later so we can run the loop
							 * properly with a call to rewind_posts().
							 */
							the_post();
						?>
						<?php
							/* Since we called the_post() above, we need to
							 * rewind the loop back to the beginning that way
							 * we can run the loop properly, in full.
							 */
							rewind_posts();
						?>

						<?php
						// If a user has filled out their description, show a bio on their entries.
						if ( get_the_author_meta( 'description' ) ) : ?>
						<div class="author-info archives">
							<div class="author-avatar">
								<?php
								/**
								 * Filter the author bio avatar size.
								 *
								 * @since Orfarm Themes 2.0 
								 *
								 * @param int $size The height and width of the avatar in pixels.
								 */
								$author_bio_avatar_size = apply_filters( 'orfarm_author_bio_avatar_size', 68 );
								echo get_avatar( get_the_author_meta( 'user_email' ), $author_bio_avatar_size );
								?>
							</div><!-- .author-avatar -->
							<div class="author-description">
								<h2><?php printf( esc_html__( 'About %s', 'orfarm' ), get_the_author() ); ?></h2>
								<p><?php the_author_meta( 'description' ); ?></p>
							</div><!-- .author-description	-->
						</div><!-- .author-info -->
						<?php endif; ?>

						<?php /* Start the Loop */ ?>
						<div id="main" class="blog-page blog-column-<?php echo esc_attr($blog_settings['coldata']); ?> <?php echo esc_attr($blog_settings['postlayout'] . '-layout'); ?> site-main">
							<div class="list-posts<?php echo esc_attr(($blog_settings['autogrid']) ? ' auto-grid':''); ?>" data-col="<?php echo esc_attr($blog_settings['coldata']); ?>" data-pady="10">
							<?php while ( have_posts() ) : the_post(); ?>
								<?php get_template_part( 'template-parts/post/content', get_post_format() ); ?>
							<?php endwhile; ?>
							</div>
						</div>
						<div class="pagination">
							<?php orfarm_bootstrap_pagination(); ?>
						</div>

					<?php else : ?>
						<?php get_template_part( 'no-results', 'index' ); ?>
					<?php endif; ?>
				</div>
			</div>
			<?php get_template_part('template-parts/sidebar/blog'); ?>
	</div>
</div>
<?php get_footer(); ?>