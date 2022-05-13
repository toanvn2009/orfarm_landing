<?php
/**
 * The template for displaying image attachments.
 *
 * @package LionThemes
 * @subpackage Orfarm_theme
 * @since Orfarm Themes 2.0 
 */

get_header();
?> 
<div class="container">
	<div class="row">
		<div class="col-md-12 content-area image-attachment" id="main-column">
			<main id="main" class="site-main">
				<?php 
				while (have_posts()) {
					the_post(); 
				?> 

				<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
					<header class="entry-header">
						<?php the_title('<h2 class="entry-title">', '</h2>'); ?> 

						<div class="entry-meta">
							<?php
								$metadata = wp_get_attachment_metadata();
								printf(wp_kses(__('Published <span class="entry-date"><time class="entry-date" datetime="%1$s">%2$s</time></span> at <a href="%3$s" title="Link to full-size image">%4$s &times; %5$s</a> in <a href="%6$s" title="Return to %7$s" rel="gallery">%8$s</a>', 'orfarm'), array('span', 'time', 'a')),
									esc_attr(get_the_date('c')),
									esc_html(get_the_date()),
									esc_url(wp_get_attachment_url()),
									$metadata['width'],
									$metadata['height'],
									esc_url(get_permalink($post->post_parent)),
									esc_attr(strip_tags(get_the_title($post->post_parent))),
									get_the_title($post->post_parent)
								);

								echo ' ';
								orfarm_bootstrap_edit_post_link();
							?> 
						</div><!-- .entry-meta -->

						<ul id="image-navigation" class="image-navigation pager">
							<li class="nav-previous previous"><?php previous_image_link(false, wp_kses(__('<span class="meta-nav">&larr;</span> Previous', 'orfarm'), array('span'))); ?></li>
							<li class="nav-next next"><?php next_image_link(false, wp_kses(__('Next <span class="meta-nav">&rarr;</span>', 'orfarm'), array('span'))); ?></li>
						</ul><!-- #image-navigation -->
					</header><!-- .entry-header -->

					<div class="entry-content">
						<div class="entry-attachment">
							<div class="attachment">
								<?php orfarm_bootstrap_attached_image(); ?> 
							</div><!-- .attachment -->

							<?php if (has_excerpt()) { ?> 
							<div class="entry-caption">
								<?php the_excerpt(); ?> 
							</div><!-- .entry-caption -->
							<?php } //endif; ?> 
						</div><!-- .entry-attachment -->

						<?php the_content(); ?> 
					</div><!-- .entry-content -->

					<?php orfarm_bootstrap_edit_post_link(); ?> 
				</article><!-- #post-## -->

				<?php
					// If comments are open or we have at least one comment, load up the comment template
					if (comments_open() || '0' != get_comments_number()) {
						comments_template();
					}
				?> 

				<?php 
				} //endwhile; // end of the loop. 
				?> 
			</main>
		</div>
	</div>
</div>
<?php get_footer(); ?> 