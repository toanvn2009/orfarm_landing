<?php
/**
 * Template for dispalying single post (read full post page).
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
$banner_image = $blog_settings['banner_image'];
?>
<div class="main-container">
	<?php if($banner_image && isset($banner_image['url'])){ ?>
		<div class="banner-image-post-detail page-banner" style="background-image: url(<?php echo esc_url($banner_image['url']); ?>); min-height: <?php echo esc_url($banner_image['height']); ?>px;">
			<div class="container">
				<?php if($blog_settings['banner_blog_title']){ ?><h2><?php echo esc_html__( $blog_settings['banner_blog_title'], 'orfarm' ) ?></h2><?php } ?>
				<?php orfarm_breadcrumb(); ?>
			</div>
		</div> 
	<?php }else{ ?>
		<div class="container">
			<?php orfarm_breadcrumb(); ?>
		</div>
	<?php } ?>
	<?php 
		$sidebar_class = '';
		$main_sidebar_class = '';
		if (!is_single()) {
			$sidebar = isset($blog_settings['sidebar'])?$blog_settings['sidebar']:'';
			$sidebar_class = $sidebar?$sidebar . '-sidebar':'';
			$main_sidebar_class = $sidebar?'maincol-sidebar-' . $blog_settings['sidebar']:'';
		}
	?>
	<div class="container <?php echo esc_attr($sidebar_class) ?>"> 
		
		<div class="<?php echo esc_attr($main_sidebar_class); ?>" id="main-blog">
			<main id="main" class="site-main single-post-content">
				<?php 
				while (have_posts()) {
					the_post();
					do_action( 'lionthemes_before_post_content_detail' );
					get_template_part('template-parts/post/content', get_post_format());
					do_action( 'lionthemes_after_post_content_detail' );
					// If comments are open or we have at least one comment, load up the comment template
					if (comments_open() || '0' != get_comments_number()) {
						comments_template();
					}

					echo "\n\n";

				} //endwhile;
				?> 
			</main>
		</div>
		<?php if (!is_single()) { ?>
		<?php get_template_part('template-parts/sidebar/blog'); ?>
		<?php } ?>
	</div>
</div>
<?php get_footer(); ?> 