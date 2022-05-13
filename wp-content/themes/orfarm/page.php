<?php
/**
 * The template for default page
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
?> 
<?php if (!is_front_page()) { ?>
	<?php do_action( 'orfarm_page_banner' ); ?>
<?php } ?>
<div id="main-content" class="main-container">
	<div class="container">
		<div class="content-area" id="main-column">
			<main id="main" class="site-main">
				<?php 
				while (have_posts()) {
					the_post();
					get_template_part('template-parts/page/content', 'page');
					if (comments_open() || '0' != get_comments_number()) {
						comments_template();
					}
					echo "\n\n";
				} //endwhile;
				?> 
			</main>
		</div>
	</div>
</div>
<?php get_footer(); ?> 