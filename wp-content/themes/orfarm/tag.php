<?php
/**
 * The template for displaying Tag pages
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
	<div class="container <?php echo esc_attr($blog_settings['sidebar'] . '-sidebar') ?>">
		<div class="<?php echo esc_attr('maincol-sidebar-' . $blog_settings['sidebar']); ?>" id="main-blog">
			<main id="main" class="site-main blog-page blog-column-<?php echo esc_attr($blog_settings['coldata']); ?> <?php echo esc_attr($blog_settings['postlayout'] . '-layout'); ?>">
				<?php if ( have_posts() ) : ?>
					
					<?php if ( tag_description() ) : // Show an optional tag description ?>
					<header class="archive-header">
						<div class="archive-meta"><?php echo tag_description(); ?></div>
					</header><!-- .archive-header -->
					<?php endif; ?>
					
					<div class="list-posts<?php echo esc_attr(($blog_settings['autogrid']) ? ' auto-grid':''); ?>" data-col="<?php echo esc_attr($blog_settings['coldata']); ?>" data-pady="10">
					<?php
					while ( have_posts() ) : the_post();
						get_template_part('template-parts/post/content', get_post_format());
					endwhile;
					?>
					</div>
					<div class="pagination">
						<?php orfarm_bootstrap_pagination(); ?>
					</div>
				<?php else : ?>
					<?php get_template_part( 'content', 'none' ); ?>
				<?php endif; ?>
			</main>
		</div>
		<?php get_template_part('template-parts/sidebar/blog'); ?>
	</div>
</div>
<?php get_footer(); ?>