<?php
/**
 * Displaying archive page (category, tag, archives post, author's post)
 *
 * @package LionThemes
 * @subpackage Orfarm_theme
 * @since Orfarm Themes 2.0 
 */

get_header(); 

/**
 * determine main column size from actived sidebar
 */
$orfarm_opt = get_option( 'orfarm_opt' );
$blog_settings = orfarm_get_blog_option();
set_query_var( 'blogcolumn', $blog_settings['blogcolumn'] );
?>
<?php do_action( 'orfarm_page_banner' ); ?>
<div class="main-container"> 
	<div class="container <?php echo esc_attr($blog_settings['sidebar'] . '-sidebar'); ?>">
		<div class="<?php echo esc_attr('maincol-sidebar-' . $blog_settings['sidebar']); ?>" id="main-blog">
			<main id="main" class="blog-page blog-column-<?php echo esc_attr($blog_settings['coldata']); ?> <?php echo esc_attr($blog_settings['postlayout'] . '-layout'); ?> site-main">
				<?php if (have_posts()) { ?> 
				<div class="list-posts<?php echo esc_attr(($blog_settings['autogrid']) ? ' auto-grid':''); ?>" data-col="<?php echo esc_attr($blog_settings['coldata']); ?>" data-pady="10">
				<?php 
				// start the loop
				while (have_posts()) {
					the_post();
					get_template_part('template-parts/post/content', get_post_format());
				}// end while
				?> 
				</div>
				<?php orfarm_bootstrap_pagination(); ?>
				<?php } else { ?> 
					<?php get_template_part( 'content', 'none' ); ?>
				<?php } // endif; ?> 
			</main>
		</div>
		<?php get_template_part('template-parts/sidebar/blog'); ?>
	</div>
</div>
<?php get_footer(); ?> 