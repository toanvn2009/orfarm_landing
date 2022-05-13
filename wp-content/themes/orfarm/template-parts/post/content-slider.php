
	<div class="post-slider owl-carousel owl-theme" <?php echo html_entity_decode($owl_data); ?>>
	 <?php
		$show_categories = true;
		$excerpt_length	 = 30;	
		$readmore_text = esc_html__('Continue reading', 'orfarm');
		foreach ( $postslist as $post ) {
			$author_id = $post->post_author;
			$class_nothumb = '';
			if(!get_the_post_thumbnail( $post->ID, $imagesize ) && !get_post_meta( $post->ID, 'orfarm_featured_post_value', true )) $class_nothumb = ' no-thumb'; ?>
			<div class="item-post post-<?php echo esc_html($post->ID) ?> <?php echo ''. $class_column . $class_nothumb . $showon_effect ?>" data-wow-delay="<?php echo esc_attr($duration) ?>ms" data-wow-duration="0.5s">
				<div class="post-wrapper">
					<div class="post-info">
						<div class="post-thumbnail">
							<?php
							if(get_post_format( $post->ID ) == 'audio' && get_the_post_thumbnail( $post->ID, $imagesize )){ ?>
								<a href="<?php echo get_the_permalink($post->ID)?>"><?php echo get_the_post_thumbnail($post->ID, $imagesize)?></a>
							<?php } 
							elseif(get_post_meta( $post->ID, 'orfarm_featured_post_value', true ) && get_post_format( $post->ID ) == 'video'){
								echo str_replace('"title="', '" title="', do_shortcode(get_post_meta( $post->ID, 'orfarm_featured_post_value', true )));
							}elseif(get_the_post_thumbnail( $post->ID, $imagesize )){ ?>
								<a href="<?php echo get_the_permalink($post->ID)?>"><?php echo get_the_post_thumbnail($post->ID, $imagesize)?></a>
							<?php } ?>
						</div>
						<div class="post-content">
							<div class="entry-wap">
								<div class="cat-links">
									<?php if($show_categories){ ?>
										<?php echo get_the_category_list( ', ', 'single', $post->ID ) ?>
									<?php } ?>
								</div>
								<div class="author-by">
									<a title="<?php echo get_the_author_meta('display_name', $author_id); ?>" href="<?php echo get_author_posts_url($author_id); ?>"><?php echo get_the_author_meta('display_name', $author_id); ?></a>
								</div>
								<div class="post-date"><a href="<?php echo get_the_permalink($post->ID) ?>"><?php echo  get_the_date( get_option( 'date_format' ), $post->ID ) ?></a></div>
							</div>						
							<div class="entry-header">				
								<h3 class="entry-title"><a href="<?php echo get_the_permalink($post->ID) ?>"><?php echo get_the_title($post->ID)?></a></h3>
							</div>
							<?php if($readmore_text){ ?>
							<div class="readmore-excerpt">
								<a class="readmore" href="<?php echo get_the_permalink($post->ID) ?>"><span class="readmore-text"><?php echo esc_html($readmore_text) ?></span></a>
							</div>
							<?php }?>
						</div>
					</div>

				</div>
			</div>

		<?php } ?>
</div>

<script>
	jQuery(document).ready(function($) {
		if (typeof initOwl !== "undefined") initOwl($('.post-slider [data-owl="slide"]'));
	});
</script>