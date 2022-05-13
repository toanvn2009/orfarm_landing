<?php
/**
 * The template for displaying posts in the Home block & related block
 *
 * @package LionThemes
 * @subpackage Orfarm_theme
 * @since Orfarm Themes 2.0 
 */
 ?>
<?php 
	if(is_single()){
		$class_column = '';
		$showon_effect = '';
		$show_categories = true;
		$excerpt_length = 20;
		$readmore_text = 'Continue reading';
	} 
	
?>
<div class="blog-posts<?php echo esc_attr($row_cl) ?> <?php echo esc_attr($el_class) ?>">
	<?php if(is_single()){ ?>
		<?php if ($title || $short_desc) { ?>
			<div class="element-widget-title">	
				<?php if($title){ ?>
					<h3 class="vc_widget_title vc_blog_title <?php echo (($title_alignment != '') ? ' '. $title_alignment : ''); ?>"><span><?php echo wp_kses($title, array('strong' => array())) ?></span></h3>
				<?php } ?>
				<?php if($short_desc){ ?>
					<div class="widget-sub-title <?php echo (($title_alignment != '') ? ' '. $title_alignment : ''); ?>"><?php echo '' . $short_desc; ?></div>
				<?php } ?>
			</div>
		<?php } ?>
	<?php }else{ ?>
		<?php if ($pre_title || $title || $short_desc) { ?>
			<div class="element-widget-title">	
				<?php if($pre_title){ ?>
					<h4 class="widget-pre-title <?php echo (($title_alignment != '') ? ' '. $title_alignment : ''); ?>"><span><?php echo wp_kses($pre_title, array('strong' => array())) ?></span></h4>
				<?php } ?>
				<?php if($title){ ?>
					<h3 class="vc_widget_title vc_blog_title <?php echo (($title_alignment != '') ? ' '. $title_alignment : ''); ?>"><span><?php echo wp_kses($title, array('strong' => array())) ?></span></h3>
				<?php } ?>
				<?php if($short_desc){ ?>
					<div class="widget-sub-title <?php echo (($title_alignment != '') ? ' '. $title_alignment : ''); ?>"><?php echo '' . $short_desc; ?></div>
				<?php } ?>
			</div>
		<?php } ?>
	<?php } ?>
	
	<?php if($style == 'carousel'){ ?>
		<div class="owl-carousel owl-theme" <?php echo '' . $owl_data ?>>
	<?php }
		$duration = 100;
		$post_index = 0;
		foreach ( $postslist as $post ) {
			$author_id = $post->post_author;
			if($rows > 1 && $style == 'carousel'){
				
				if ($post_index % $rows == 0 ){ ?>
					<div class="group">
					<?php
				}
			}
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
									<a title="<?php echo get_the_author_meta('display_name', $author_id); ?>" href="<?php echo get_author_posts_url($author_id); ?>"><span> <?php echo get_the_author_meta('display_name', $author_id); ?></span></a>
								</div>
								<div class="post-date"><a href="<?php echo get_the_permalink($post->ID) ?>"><?php echo  get_the_date( get_option( 'date_format' ), $post->ID ) ?></a></div>
							</div>		
							<div class="entry-header">				
								<h3 class="entry-title"><a href="<?php echo get_the_permalink($post->ID) ?>"><?php echo get_the_title($post->ID)?></a></h3>
							</div>
							<div class="entry-content">
								<?php if ($excerpt_length > 0) { ?>
									<?php echo lionthemes_get_excerpt($post->ID, $excerpt_length);?>
								<?php } ?>
								
								<?php if($readmore_text){ ?>
								<div class="readmore-excerpt">
									<a class="readmore" href="<?php echo get_the_permalink($post->ID) ?>"><span class="readmore-text"><?php echo esc_html($readmore_text) ?></span></a>
									
								</div>
								<?php }?>
							</div>
						</div>
					</div>

				</div>
			</div>
			<?php
			$post_index ++;
			if($rows > 1 && $style == 'carousel'){
				if (($post_index % $rows == 0) || $post_index == $total ) { ?>
					</div>
				<?php }
			}
			$duration = $duration + 100;
		}
	if($style == 'carousel'){ ?>
		</div>
	<?php } ?>
</div> 