<?php
function orfarm_post_footer_entry() { ?>
<footer class="entry-meta">
	<?php if ('post' == get_post_type()) { // Hide category and tag text for pages on Search ?> 
	<div class="entry-meta-category-tag">
		<?php
			/* translators: used between list items, there is a space after the comma */
			$tags_list = get_the_tag_list('', esc_html__(', ', 'orfarm'));
			if ($tags_list) {
		?> 
		<span class="tags-links">
			<?php echo orfarm_bootstrap_tags_list($tags_list); ?> 
		</span>
		<?php } // End if $tags_list ?> 
	</div>
	<?php } // End if 'post' == get_post_type() ?> 

	<?php if( is_single() ) { ?>
		<?php do_action( 'lionthemes_end_single_post' ); ?>
	<?php } ?>
	<?php
		/* translators: used between list items, there is a space after the comma */
		$categories_list = get_the_category_list(esc_html__(', ', 'orfarm'));
		if (!empty($categories_list)) {
	?>  <div class="entry-wap">
			<div class="cat-links">
				<?php echo orfarm_bootstrap_categories_list($categories_list); ?> 
			</div>
		</div>
		<?php } // End if $tags_list ?> 
</footer>
<?php } 

function orfarm_post_header_entry() { 
	$orfarm_opt = get_option( 'orfarm_opt' );
	$post   = get_post( get_the_ID() );
?>
	
	<?php if ( !is_single() ) { ?>
		<?php if (empty($orfarm_opt['hide_postmeta'])) {
			do_action('orfarm_post_entry_info', $post);
		} 
		?>
		<header class="entry-header">
			<h2 class="entry-title">
				<a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a>
			</h2>			
		</header>
	<?php }else{ ?>
		<header class="entry-header">
			<?php if (empty($orfarm_opt['hide_postmeta'])) {
				orfarm_post_feature_image($post);
			} 
			?>
			<div class="post-info">
				<?php if (empty($orfarm_opt['hide_postmeta'])) {
					orfarm_post_entry_data_cat_links($post);
				} 
				?>
				<?php if (empty($orfarm_opt['hide_postmeta'])) {
					orfarm_post_entry_data($post);
				} 
				?>
				<h1 class="entry-title"><?php the_title(); ?></h1>
				
			</div>
		</header> 
	<?php } ?>
	
	<?php
}

add_action('orfarm_post_entry_info', 'orfarm_post_entry_data', 30, 1);
function orfarm_post_entry_data($post) { 
	$author_id = $post->post_author;
	?>
	<ul class="post-entry-data">
		<li class="post-date">
			<span><?php echo esc_html__('Post Date:', 'orfarm') ?></span>
			<a href="<?php echo get_the_permalink($post->ID) ?>"><?php echo  get_the_date( get_option( 'date_format' ), $post->ID ) ?></a>
		</li>
		<li class="post-author">
			<div class="author-avatar"><?php echo get_avatar($author_id, 100); ?></div>
			<div class="author-by">
				<span>
				<a title="<?php echo get_the_author_meta('display_name', $author_id); ?>" href="<?php echo get_author_posts_url($author_id); ?>"><?php echo get_the_author_meta('display_name', $author_id); ?></a>
			</div>
		</li>
	</ul>
	</div>
	<?php
}
add_action('orfarm_post_entry_info', 'orfarm_post_entry_data_cat_links', 20, 1);
function orfarm_post_entry_data_cat_links($post) { 
	$categories_list = get_the_category_list(esc_html__(', ', 'orfarm'));
	if (!empty($categories_list)) {
		echo '<div class="entry-wap"><div class="cat-links 1"><span class="cat-title">' . esc_html__('Categories:', 'orfarm') .  '</span>' . orfarm_bootstrap_categories_list($categories_list) . '</div>';
	}
}

add_action('orfarm_post_entry_info', 'orfarm_post_feature_image', 10, 1);
function orfarm_post_feature_image($post) { ?>
	<?php
		if ( ! post_password_required() && ! is_attachment() ) {
			$orfarm_opt = get_option( 'orfarm_opt' );
			$content = apply_filters( 'the_content', get_the_content() );
			$video = false;

			// Only get video from the content if a playlist isn't present.
			if ( false === strpos( $content, 'wp-playlist-script' ) ) {
				$video = get_media_embedded_in_content( $content, array( 'video', 'object', 'embed', 'iframe' ) );
			}

			$hasFeature = (get_post_meta( get_the_ID(), 'orfarm_featured_post_value', true ) && (get_post_format(get_the_ID()) == 'video' || get_post_format(get_the_ID()) == 'gallery'));
		?>
		<?php if ( is_single() ) { ?>
			<div class="post-thumbnail">
				<?php if($hasFeature) { ?>
					<div class="feature-intro"><?php echo do_shortcode(get_post_meta( get_the_ID(), 'orfarm_featured_post_value', true )); ?></div>
				<?php } elseif ( has_post_thumbnail() ) { ?>
					<?php the_post_thumbnail(); ?>
				<?php } ?>
			</div>
			<?php if ( get_post_format(get_the_ID()) == 'audio' ) { ?>
				<div class="player"><?php echo do_shortcode(get_post_meta( get_the_ID(), 'orfarm_featured_post_value', true )); ?></div>
			<?php } ?>
		<?php }	?>
		<?php if ( !is_single() && empty($video) ) { ?>
			<div class="post-thumbnail">
				<?php if($hasFeature) { ?>
					<div class="feature-intro"><?php echo do_shortcode(get_post_meta( get_the_ID(), 'orfarm_featured_post_value', true )); ?></div>
				<?php } elseif ( has_post_thumbnail() ) { ?>
					<a href="<?php the_permalink(); ?>"><?php the_post_thumbnail('orfarm-post-thumb'); ?></a>
				<?php } ?>
			</div>
		<?php } ?>
	<?php } ?>
<?php }

function orfarm_get_excerpt($id) {
	$the_post = get_post($id); //Gets post ID
	$the_excerpt = $the_post->post_content; //Gets post_content to be used as a basis for the excerpt
	$limit = 54;
	$the_excerpt = strip_tags(strip_shortcodes($the_excerpt)); //Strips tags and images
	$words = explode(' ', $the_excerpt, $limit + 1);

	if(count($words) > $limit) :
		array_pop($words);
		array_push($words, '…');
		$the_excerpt = implode(' ', $words);
	endif;

	$the_excerpt = '<p>' . $the_excerpt . '</p>';

	return $the_excerpt;
}


function orfarm_post_entry_content() {
	$orfarm_opt = get_option( 'orfarm_opt' );
	if (!is_single()) {
		if (empty($orfarm_opt)) {
			if (class_exists('ReduxFrameworkPlugin')) {
				
				the_content();
			}else{
				echo orfarm_get_excerpt(get_the_ID());
			}
		} else {
			if (class_exists('ReduxFrameworkPlugin')) {
				if($orfarm_opt['excerpt_length'] > 0 ){
					echo lionthemes_get_excerpt(get_the_ID(),$orfarm_opt['excerpt_length']);
				}
			}else{
				echo orfarm_get_excerpt(get_the_ID());
			}
		}
		if (class_exists('ReduxFrameworkPlugin')) {
			if (!empty($orfarm_opt['show_readmore'])) {
				echo '<div class="readmore-excerpt">
						<a class="readmore" href="' . get_the_permalink() . '"><span class="readmore-text">'. esc_html__('Continue reading', 'orfarm') .'</span></a>
					</div>';
			}
		}else{
			echo '<div class="readmore-excerpt">
						<a class="readmore" href="' . get_the_permalink() . '"><span class="readmore-text">'. esc_html__('Continue reading', 'orfarm') .'</span></a>
					</div>';
		}
	} else {
		the_content();
		wp_link_pages(array(
			'before' => '<div class="clearfix"></div><div class="page-links"><span>' . esc_html__('Pages:', 'orfarm') . '</span><ul class="pagination">',
			'after'  => '</ul></div>',
			'separator' => ''
		));
	}
}



// add page banner
add_action('orfarm_page_banner', 'orfarm_page_banner_html');
function orfarm_page_banner_html() {
	$orfarm_opt = get_option( 'orfarm_opt' );
	if (!is_front_page()) {
		$lionthemes_banner = '';
		$blog_banner = is_home() ? ' blog-banner' : '';
		global $wp_query, $page_id;
		$queried_object = get_queried_object();
		if (!$page_id) $page_id = $wp_query->get_queried_object_id();
		
		if (function_exists('is_projects_archive') && is_projects_archive()) {
			$page_id = projects_get_page_id('projects');
		}
		
		if(get_post_meta( $page_id, 'lionthemes_page_banner', true )){
			$lionthemes_banner = get_post_meta( $page_id, 'lionthemes_page_banner', true );
		}

		$page_h = get_post_meta( $page_id, 'lionthemes_page_heading', true );
		$banner_h = intval(get_post_meta( $page_id, 'lionthemes_page_banner_height', true ));
		$page_heading = ($page_h) ? $page_h : get_the_title($page_id);
		
		
		if (is_category()) {
			$cat = get_category(get_query_var('cat'), false);
			if ($cat) {
				$page_heading = $cat->name;
				$lionthemes_banner = get_term_meta( $cat->term_id, 'lionthemes_cat_banner', true );
				$banner_h = get_term_meta( $cat->term_id, 'lionthemes_cat_banner_height', true );
			}
		}
		
		if (is_search()) {
			$page_heading = sprintf(esc_html__('Search Results for: %s', 'orfarm'), '<span>' . get_search_query() . '</span>');
		}
		if (is_tag()) {
			$page_heading = sprintf( esc_html__( 'Tag Archives: %s', 'orfarm' ), '<span>' . single_tag_title( '', false ) . '</span>' );
		}
		if (is_archive()) {
			$page_heading = get_the_archive_title();
		}
		if (is_author()) {
			$page_heading = sprintf( esc_html__( 'Author Archives: %s', 'orfarm' ), '<span class="vcard"><a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( "ID" ) ) ) . '" title="' . esc_attr( get_the_author() ) . '" rel="me">' . get_the_author() . '</a></span>' );
		}
		
		$banner_h = ($banner_h) ? $banner_h : 300;
		$page_title_layout = "";
		$page_title_size = "";
		$page_title_image = "";
		$page_title_tag = "h6";
		$page_title_color = ""; 
		
		if(isset($orfarm_opt['page_title_layout'])) { $page_title_layout =  $orfarm_opt['page_title_layout']; }
		if(isset($orfarm_opt['page_title_size'])) { $page_title_size =  $orfarm_opt['page_title_size']; }
		if(isset($orfarm_opt['page_title_image'])) { $page_title_image =  $orfarm_opt['page_title_image']; }
		if(isset($orfarm_opt['page_title_tag'])) { $page_title_tag =  $orfarm_opt['page_title_tag']; }
		if(isset($orfarm_opt['page_title_color'])) { $page_title_color =  $orfarm_opt['page_title_color']; }
		if($lionthemes_banner) {
			echo '<div class="page-banner' . $blog_banner . '" style="background-image: url('. esc_url($lionthemes_banner) .'); min-height: '. $banner_h .'px;">
				<div class="page-banner-content container">
					<'.$page_title_tag.' class="entry-title">'. $page_heading .'</'.$page_title_tag.'>';
					orfarm_breadcrumb();
					orfarm_woocommerce_sub_blog();
			echo '</div></div>';
		}else{
			echo '<div class="default-entry-header '.$page_title_layout.' '.$page_title_size.' '.$page_title_color.'">'; 
			    echo '<div class="container">';
					orfarm_breadcrumb();
				   if ($page_heading) {
					 echo '<'.$page_title_tag.' class="entry-title simple-title ">'. $page_heading .'</'.$page_title_tag.'>';
				   } else {
					 echo '<'.$page_title_tag.' class="entry-title simple-title '.$page_title_layout.' '.$page_title_size.'">'. $queried_object->name .'</'.$page_title_tag.'>';
				  }
				  orfarm_woocommerce_sub_blog();
			   echo '</div>';
			echo '</div>';
		}
	}
}
// add page banner
add_action('orfarm_posts_slider', 'orfarm_posts_slider_html');
function orfarm_posts_slider_html() {
	global $orfarm_opt;  
	if(isset( $orfarm_opt['blog_slide'] ) && $orfarm_opt['enable_post_slide']==1) { 
		$postargs = array( 
		  'post_type'        => 'post',
		  'post__in' => $orfarm_opt['blog_slide']
		);
		$settings = array();
		$settings['bigdesk'] = 3;
		$settings['desksmall'] = 3;
		$settings['tabletsmall'] = 1;
		$settings['bigtablet'] = 2;
		$settings['mobile_count'] = 1;
		$settings['tablet_count'] = 1;
		$settings['margin'] = 30;
		$autoplay = false; 
		$settings['playtimeout'] = 500;
		$settings['speed'] = 1000;
		$postslist = get_posts( $postargs );
		$owl_data = "";
		
		$image_size = 'orfarm-post-thumb';
		$owl_data .= 'data-dots="false" data-nav="true" data-owl="slide" data-ow-rtl="false" ';
		$owl_data .= 'data-bigdesk="'. esc_attr($settings['bigdesk']) .'" ';
		$owl_data .= 'data-desksmall="'. esc_attr($settings['desksmall']) .'" ';
		$owl_data .= 'data-tabletsmall="'. esc_attr($settings['tabletsmall']) .'" ';
		$owl_data .= 'data-bigtablet="'. esc_attr($settings['bigtablet']) .'" ';
		$owl_data .= 'data-mobile="'. esc_attr($settings['mobile_count']) .'" ';
		$owl_data .= 'data-tablet="'. esc_attr($settings['tablet_count']) .'" ';
		$owl_data .= 'data-margin="'. esc_attr($settings['margin']) .'" ';
		$owl_data .= 'data-autoplay="'. esc_attr($autoplay) .'" ';
		$owl_data .= 'data-playtimeout="'. esc_attr($settings['playtimeout']) .'" ';
		$owl_data .= 'data-speed="'. esc_attr($settings['speed']) .'" ';
		lionthemes_get_template_part('template-parts/post/content-slider', array(
				'postslist' => $postslist,
				'imagesize' => $image_size,
				'owl_data' => $owl_data,
		) ); 
	} else {
	    return ; 
	}	
}
	

// Add sub category blog
function orfarm_woocommerce_sub_blog() {
	return; 
	if ( !is_front_page() && is_home() ) {
		$categories = get_categories();
		if (count($categories) > 0) {
			echo '<ul class="sub-category">';
			foreach($categories as $category) { 
				echo '<li><a href="' . get_category_link( $category->term_id ) . '" title="' . $category->name . '" ' . '>' . $category->name.'</a> </li> ';
			}
			echo '</ul>';
		}
	}
}

// add post detail link 
add_action('lionthemes_after_post_content_detail', 'lionthemes_post_detail_link', 10);
function lionthemes_post_detail_link() {
	$orfarm_opt = get_option( 'orfarm_opt' );
	if (empty($orfarm_opt['hide_post_link'])) {
		$previous = get_previous_post();
		$next = get_next_post();
		if ($previous || $next) {
			echo '<div  class="post-links">';
			if ($previous) {
				$prev_thumb = get_the_post_thumbnail_url($previous, array(100, 100));
				$pre_title = get_the_title($previous);
				$pre_link = get_the_permalink($previous);
				$pre_img = '';
				if ($prev_thumb) {
					$pre_img = '<div class="post-link-image">
									<a title="'. $pre_title .'" href="'. $pre_link .'">
										<img src="' . esc_url($prev_thumb) . '" alt="'. $pre_title .'"/>
									</a>
								</div>';
				}
				echo '<div class="post-link prev-link">
						'. $pre_img .'
						<div class="post-link-meta">
							<a title="'. $pre_title .'" href="'. $pre_link .'">
								<span class="fa fa-chevron-left">
								<span>'. esc_html__('Previous post', 'orfarm') .'</span>
							</a>
							<a title="'. $pre_title .'" href="'. $pre_link .'">
								<span>' . $pre_title . '</span>
							</a>
						</div>
					</div>';
			}
			if ($next) {
				$next_thumb = get_the_post_thumbnail_url($next, array(100, 100));
				$next_title = get_the_title($next);
				$next_link = get_the_permalink($next);
				$next_img = '';
				if ($next_thumb) {
					$next_img = '<div class="post-link-image">
									<a title="'. $next_title .'" href="'. $next_link .'">
										<img src="' . esc_url($next_thumb) . '" alt="'. $next_title .'" />
									</a>
								</div>';
				}
				echo '<div class="post-link next-link">
						'. $next_img .'
						<div class="post-link-meta">
							<a title="'. $next_title .'" href="'. $next_link .'">
								<span class="fa fa-chevron-right">
								<span>'. esc_html__('Next post', 'orfarm') .'</span>
							</a>
							<a title="'. $next_title .'" href="'. $next_link .'">
								<span>' . $next_title . '</span>
							</a>
						</div>
					</div>';
			}
			echo '</div>';  
		}
	}
}


// add post detail link 
add_action('lionthemes_after_post_content_detail', 'lionthemes_post_detail_author', 20);
function lionthemes_post_detail_author() {
	$orfarm_opt = get_option( 'orfarm_opt' );
	if (empty($orfarm_opt['hide_post_author']) && get_the_author_meta('description')) {
		$author_id = get_the_author_meta('ID');
		if ($author_id) {
			echo '<div class="post-detail-author">';
			echo '<div class="author-avatar">'. get_avatar($author_id, 100) .'</div>';
			echo '<div class="author-meta">
					<div class="author-name">
						<span>'. get_the_author_meta('display_name') .'</span>
					</div>
					<div class="author-desc">' . get_the_author_meta('description') . '</div>
					<a class="author-link" href="'.  get_author_posts_url($author_id) .'" title="'. get_the_author_meta('display_name')  .'">'. esc_html__('All Author Posts', 'orfarm') .'</a>
				</div>';
			echo '</div>';
		}
	}
}


// add posts related 
add_action('lionthemes_after_post_content_detail', 'lionthemes_post_detail_related', 30);
function lionthemes_post_detail_related() {
	$orfarm_opt = get_option( 'orfarm_opt' );
	if (empty($orfarm_opt['hide_post_related'])) {
		$post_related_count = (!empty($orfarm_opt['post_related_count'])) ? $orfarm_opt['post_related_count'] : 6;
		$post_id = get_the_ID();
		$tags = wp_get_post_tags($post_id);
		$all_tags = array();
		foreach ($tags as $tag) {
			if ($tag->term_id) $all_tags[] = $tag->term_id;
		}
		$cats = wp_get_post_categories($post_id);
		$args = array(
			'post__not_in' => array($post_id),
			'posts_per_page' => $post_related_count,
			'tax_query' => array(
				'relation' => 'OR',
				array(
					'taxonomy' => 'category',
					'field' => 'ID',
					'terms' => $cats,
					'include_children' => false 
				),
				array(
					'taxonomy' => 'post_tag',
					'field' => 'ID',
					'terms' => $all_tags,
				)
			)
		);
		$postslist = get_posts( $args );
		$total = count($postslist);
		if ($total > 0) {
			$owl_data = 'data-owl="slide" data-ow-rtl="false" ';
			$owl_data .= 'data-dots="false" ';
			$owl_data .= 'data-nav="true" ';
			$owl_data .= 'data-bigdesk="3" ';
			$owl_data .= 'data-desksmall="2" ';
			$owl_data .= 'data-tabletsmall="1" '; 
			$owl_data .= 'data-bigtablet="2" ';
			$owl_data .= 'data-mobile="1" ';
			$owl_data .= 'data-tablet="2" ';
			$owl_data .= 'data-margin="30" ';
			$owl_data .= 'data-item-slide="3" ';	
			if (function_exists('lionthemes_get_template_part')) {
				lionthemes_get_template_part('template-parts/post/content-archive', array(
					'postslist' => $postslist,
					'title' => esc_html__('You Might Also Like', 'orfarm'),
					'title_alignment' => '',
					'short_desc' => '',
					'style' => 'carousel',
					'rows' => 1,
					'imagesize' => 'orfarm-post-thumb',
					'show_categories' => false,
					'excerpt_length' => 0,
					'owl_data' => $owl_data,
					'row_cl' => '',
					'readmore_text' => '',
				));
			}
		}
	}
}

function orfarm_get_page_custom_configs() {
	$page_id = get_queried_object_id();
	$orfarm_opt = get_option( 'orfarm_opt' ); 
	$out = array(
		'header_layout' => !empty($orfarm_opt['header_layout']) ? $orfarm_opt['header_layout'] : 'first',
		'footer_layout' => !empty($orfarm_opt['footer_layout']) ? $orfarm_opt['footer_layout'] : '',
		'page_layout' => (isset($orfarm_opt['page_layout']) && $orfarm_opt['page_layout'] == 'box') ? 'box-layout':'',
		'page_logo' => ( !empty($orfarm_opt['logo_main']['url']) ) ? $orfarm_opt['logo_main']['url'] : '',
		'hide_topbar' => (isset($orfarm_opt['enable_topbar'])) ? !$orfarm_opt['enable_topbar'] : false,
		'open_menu' => false,
	);
	if(get_post_meta( $page_id, 'lionthemes_header_page', true )){
		$out['header_layout'] = get_post_meta( $page_id, 'lionthemes_header_page', true );
	}
	if(get_post_meta( $page_id, 'lionthemes_layout_page', true )) {
		$out['page_layout'] = (get_post_meta( $page_id, 'lionthemes_layout_page', true ) == 'box') ? 'box-layout' : '';
	}
	if(get_post_meta( $page_id, 'lionthemes_footer_page', true )) {
		$out['footer_layout'] = get_post_meta( $page_id, 'lionthemes_footer_page', true );
	}
	if(get_post_meta( $page_id, 'lionthemes_logo_page', true )){
		$out['page_logo'] = get_post_meta( $page_id, 'lionthemes_logo_page', true );
	}
	if(get_post_meta( $page_id, 'lionthemes_page_hide_topbar', true )){
		$out['hide_topbar'] = get_post_meta( $page_id, 'lionthemes_page_hide_topbar', true ) == 'yes' ? true : false;
	}
	if (get_post_meta( $page_id, 'lionthemes_page_opening_cate_menus', true ) == 1) {
		$out['open_menu'] = true;
	}
	return $out;
}
