<?php
/**
 * Template Name: Page Template No Breadcrumb
 *
 * @package LionThemes
 * @subpackage Orfarm_theme
 * @since Orfarm Themes 2.0 
 */
get_header(); 
?>
<div id="main-content" class="home-content">
	<div class="homepage-content">
	<?php while ( have_posts() ) : the_post(); ?>
		<?php 
			the_content(); 
		?>
		
	<?php endwhile; // end of the loop. ?>
	</div>
</div>
<?php
get_footer();
