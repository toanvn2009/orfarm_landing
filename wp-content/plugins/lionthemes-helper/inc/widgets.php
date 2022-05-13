<?php
/**
* Theme specific widgets or widget overrides
*
* @package WordPress
* @subpackage Orfarm_theme
* @since Orfarm Themes 1.0
*/
 
/**
 * Register widgets
 *
 * @return void
 */
function orfarm_widgets_init() {
	register_widget( 'Orfarm_Widget_Post' );
	register_widget( 'Orfarm_Widget_Recent_Comment' );
	register_widget( 'Orfarm_Widget_Social_Icons' );
	register_widget( 'Orfarm_Widget_Whishlist_Compare_Quick_Access' );
}
add_action( 'widgets_init', 'orfarm_widgets_init' ); 

//custom whishlist compare icons widget
class Orfarm_Widget_Whishlist_Compare_Quick_Access extends WP_Widget {
	function __construct() {
		$widget_ops = array(
			'description' => esc_html__( 'Orfarm whishlist - compare icons - display two icons on topbar', 'orfarm' )
		);
		parent::__construct( 'orfarm_wishlist_compare_quick_access', esc_html__( 'Orfarm - Wishlist Compare Icons', 'orfarm' ), $widget_ops );
	}

	function widget( $args, $instance ) {
		extract( $args );
		$orfarm_opt = get_option('orfarm_opt');
		if(class_exists('YITH_WCWL') || class_exists( 'YITH_WOOCOMPARE' )) {
			echo $before_widget;
			echo '<div class="widget widget-quick-wishlist-compare">';
			if (class_exists('YITH_WCWL')) {
				echo '<div class="quick-wishlist"><a href="'. YITH_WCWL()->get_wishlist_url() .'">
						<span class="icon-heart icons"></span>
						<span class="text">'. esc_html__('Whishlist', 'orfarm') . ' (<span class="badge">' . YITH_WCWL()->count_all_products() .'</span>)</span>
					</a></div>';
			}
			if (class_exists('YITH_WCWL')) {
				global $yith_woocompare;
				echo '<div class="quick-compare"><a class="yith-woocompare-open" href="javascript:void(0)">
						<span class="icon-layers icons"></span>
						<span class="text">'. esc_html__('Compare', 'orfarm') . ' (<span class="badge">' . count($yith_woocompare->obj->products_list) .'</span>)</span>
					</a></div>';
			}
			echo '</div>';
			echo $after_widget;
		}
	}
	// widget options
	function form( $instance ){
	}
}

//custom social icons widget
class Orfarm_Widget_Social_Icons extends WP_Widget {
	function __construct() {
		$widget_ops = array(
			'description' => esc_html__( 'Orfarm social icons - display list icon & url from theme options config', 'orfarm' )
		);
		parent::__construct( 'orfarm_social_icons', esc_html__( 'Orfarm - Social Icons', 'orfarm' ), $widget_ops );
	}

	function widget( $args, $instance ) {
		extract( $args );
		$title = apply_filters( 'widget_title', empty( $instance['title'] ) ? '' : $instance['title'], $instance, $this->id_base );
		$orfarm_opt = get_option('orfarm_opt');
		if(isset($orfarm_opt['social_icons'])) {
			echo $before_widget;
			echo '<div class="widget widget-social">';
			if ( $title ) {
				echo $before_title . $title . $after_title;
			}
			echo '<ul class="social-icons">';
			foreach($orfarm_opt['social_icons'] as $key=>$value ) {
				if($value!=''){
					if($key=='vimeo') {
						echo '<li><a class="'.esc_attr($key).' social-icon" href="'.esc_url($value).'" title="'.ucwords(esc_attr($key)).'" target="_blank"><i class="fa fa-vimeo-square"></i></a></li>';
					} elseif ($key=='mail-to') {
						echo '<li><a class="'.esc_attr($key).' social-icon" href="'.esc_url($value).'" title="'.ucwords(esc_attr($key)).'" target="_blank"><i class="fa fa-envelope"></i></a></li>';
					} else {
						echo '<li><a class="'.esc_attr($key).' social-icon" href="'.esc_url($value).'" title="'.ucwords(esc_attr($key)).'" target="_blank"><i class="fa fa-'.esc_attr($key).'"></i></a></li>';
					}
				}
			}
			echo '</ul>';
			echo '</div>';
			echo $after_widget;
		}
	}
	// widget options
	function form( $instance ){
		$title = isset( $instance['title'] ) ? esc_attr( $instance['title'] ) : '';
		?>
		<p><label for="<?php echo esc_attr($this->get_field_id( 'title' )); ?>"><?php echo esc_html__( 'Title:', 'orfarm' ); ?></label>
		<input class="widefat" id="<?php echo esc_attr($this->get_field_id( 'title' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'title' )); ?>" type="text" value="<?php echo esc_attr($title); ?>" /></p>
		<?php
	}
}


//custom blog widget
class Orfarm_Widget_Post extends WP_Widget {
	function __construct() {
		$widget_ops = array(
			'description' => esc_html__( 'Orfarm recent post', 'orfarm' )
		);
		parent::__construct( 'orfarm_recent_post', esc_html__( 'Orfarm - Recent Post', 'orfarm' ), $widget_ops );
	}

	function widget( $args, $instance ) {
		extract( $args );
		$title = apply_filters( 'widget_title', empty( $instance['title'] ) ? '' : $instance['title'], $instance, $this->id_base );
		if ( empty( $instance['number'] ) || !$number = absint( $instance['number'] ) ) {
			$number = 10;
		}
		$layout = !empty( $instance['layout'] ) ? $instance['layout'] : 'list';
		$columns = empty( $instance['columns'] ) ? 1 : $instance['columns'];
		$autoplay = empty( $instance['autoplay'] ) ? true : $instance['autoplay'];
		$args_sql = array(
			'post_type' => 'post', 
			'numberposts' => $number,
			'post_status' => 'publish, future',
			'date_query' => array(
				array(
				   'before' => date('Y-m-d H:i:s', current_time( 'timestamp' ))
				)
			 )
		);
		$recents = wp_get_recent_posts($args_sql);
		$imagesize = 'orfarm-post-thumb';
		$owl_data = '';
		if($layout == 'carousel') {
			$owl_data .= 'data-dots="false" data-nav="true" data-owl="slide" data-ow-rtl="false" ';
			$owl_data .= 'data-bigdesk="'. esc_attr($columns) .'" ';
			$owl_data .= 'data-desksmall="'. esc_attr($columns) .'" ';
			$owl_data .= 'data-tabletsmall="'. esc_attr($columns) .'" ';
			$owl_data .= 'data-bigtablet="'. esc_attr($columns) .'" ';
			$owl_data .= 'data-mobile="'. esc_attr($columns) .'" ';
			$owl_data .= 'data-tablet="'. esc_attr($columns) .'" ';
			$owl_data .= 'data-margin="15" ';
			$owl_data .= 'data-item-slide="'. esc_attr($columns) .'" ';
			$owl_data .= 'data-autoplay="'. esc_attr($autoplay) .'" ';
			$owl_data .= 'data-playtimeout="5000" ';
			$owl_data .= 'data-speed="300" ';
		}
		
		if ( !empty($recents) ){
			echo $before_widget;
			if ( $title ) {
				echo $before_title . $title . $after_title;
			}
			echo '<ul '.$owl_data .' class="'. ($layout == 'list' ? 'recent-post-list' : 'recent-post-carousel owl-carousel owl-theme') .'">';
			foreach( $recents as $recent ){ ?>
				<li>
					<a class="post-thumbnail <?php echo ($layout == 'list') ? 'pull-left' : ''; ?><?php echo (!get_the_post_thumbnail( $recent["ID"], $imagesize )) ? ' no-thumb':''; ?>" href="<?php echo get_permalink($recent["ID"]); ?>">
						<?php echo get_the_post_thumbnail( $recent["ID"], $imagesize ); ?>
					</a>
					<div class="post-info media-body">
						<span class="post-date"><?php echo get_the_date(get_option( 'date_format' ), $recent["ID"]); ?></span>
						<a class="post-title" href="<?php echo get_permalink($recent["ID"]); ?>">
							<?php echo esc_html($recent["post_title"]); ?>
						</a> 
					</div>
				</li>
			<?php }
			echo '</ul>';
			echo $after_widget;
		}
		
	}
	// widget options
	function form( $instance ){
		$title = isset( $instance['title'] ) ? esc_attr( $instance['title'] ) : '';
		$number = isset( $instance['number'] ) ? absint( $instance['number'] ) : 10;
		$layout = isset( $instance['layout'] ) ?  $instance['layout'] : 'list';
		$columns = isset( $instance['columns'] ) ? absint( $instance['columns'] ) : 1;
		$autoplay = isset( $instance['autoplay'] ) ? $instance['autoplay'] : true;
		?>
		<p><label for="<?php echo esc_attr($this->get_field_id( 'title' )); ?>"><?php echo esc_html__( 'Title:', 'orfarm' ); ?></label>
		<input class="widefat" id="<?php echo esc_attr($this->get_field_id( 'title' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'title' )); ?>" type="text" value="<?php echo esc_attr($title); ?>" /></p>

		<p><label for="<?php echo esc_attr($this->get_field_id( 'number' )); ?>"><?php echo esc_html__( 'Number of post to show:', 'orfarm' ); ?></label>
		<input id="<?php echo esc_attr($this->get_field_id( 'number' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'number' )); ?>" type="text" value="<?php echo esc_attr($number); ?>" size="3" /></p>
		
		<p>
			<label for="<?php echo esc_attr($this->get_field_id( 'layout' )); ?>"><?php echo esc_html__( 'Layout type:', 'orfarm' ); ?></label>
			<select id="<?php echo esc_attr($this->get_field_id( 'layout' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'layout' )); ?>" value="<?php echo esc_attr($layout); ?>">
				<option value="list"<?php echo $layout == 'list' ? 'selected="selected"' : ''; ?>><?php echo esc_html__( 'List', 'orfarm' ); ?></option>
				<option value="carousel"<?php echo $layout == 'carousel' ? 'selected="selected"' : ''; ?>><?php echo esc_html__( 'Carousel', 'orfarm' ); ?></option>
			</select>
		</p>
		
		
		<p><label for="<?php echo esc_attr($this->get_field_id( 'columns' )); ?>"><?php echo esc_html__( 'Carousel columns:', 'orfarm' ); ?></label>
		<input id="<?php echo esc_attr($this->get_field_id( 'columns' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'columns' )); ?>" type="number" value="<?php echo esc_attr($columns); ?>" size="3" /></p>
		
		<p>
			<label for="<?php echo esc_attr($this->get_field_id( 'autoplay' )); ?>"><?php echo esc_html__( 'Carousel Autoplay:', 'orfarm' ); ?></label>
			<select id="<?php echo esc_attr($this->get_field_id( 'autoplay' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'autoplay' )); ?>" value="<?php echo esc_attr($autoplay); ?>">
				<option value="true"<?php echo $autoplay == 'true' ? 'selected="selected"' : ''; ?>><?php echo esc_html__( 'Yes', 'orfarm' ); ?></option>
				<option value="false"<?php echo $autoplay == 'false' ? 'selected="selected"' : ''; ?>><?php echo esc_html__( 'No', 'orfarm' ); ?></option>
			</select>
		</p>
		
		<?php
	}
}

//custom recent comment widget
class Orfarm_Widget_Recent_Comment extends WP_Widget {
	function __construct() {
		$widget_ops = array(
			'description' => esc_html__( 'Orfarm recent comment', 'orfarm' )
		);
		parent::__construct( 'orfarm_recent_comment', esc_html__( 'Orfarm - Recent Comment', 'orfarm' ), $widget_ops );
	}

	function widget( $args, $instance ) {
		extract( $args );
		$title = apply_filters( 'widget_title', empty( $instance['title'] ) ? '' : $instance['title'], $instance, $this->id_base );
		if ( empty( $instance['number'] ) || !$number = absint( $instance['number'] ) ) {
			$number = 10;
		}
		$args = array();
		$args['post_type'] = empty( $instance['post_type'] ) ? '' : $instance['post_type'];
		$args['status'] = 'approve';
		$args['number'] = $number;
		$comments = get_comments($args);
		if ( !empty($comments) ){
			echo $before_widget;
			if ( $title ) {
				echo $before_title . $title . $after_title;
			}
			echo '<ul>';
			foreach( $comments as $comment ){ ?>
				<li>
					<div class="avatar pull-left"><?php echo get_avatar( $comment->comment_author_email ) ?></div>
					<div class="comment_info media-body">
						<p class="author"><?php echo esc_html($comment->comment_author) ?></p>
						<p class="comment_content"><?php echo wp_trim_words( $comment->comment_content, $num_words = 5, $more = '...' ) ?></p>
						<p class="on_post"><?php echo esc_html__('on', 'orfarm') ?> <a href="<?php echo get_permalink($comment->comment_post_ID) . '#comment-' . $comment->comment_ID; ?>"><?php echo get_the_title($comment->comment_post_ID) ?></a></p>
					</div>
				</li>
			<?php }
			echo '</ul>';
			echo $after_widget;
		}
		
	}
	// widget options
	function form( $instance ){
		$title = isset( $instance['title'] ) ? esc_attr( $instance['title'] ) : '';
		$number = isset( $instance['number'] ) ? absint( $instance['number'] ) : 10;
		$post_type = isset( $instance['post_type'] ) ? esc_attr( $instance['post_type'] ) : '';
		?>
		<p><label for="<?php echo esc_attr($this->get_field_id( 'title' )); ?>"><?php echo esc_html__( 'Title:', 'orfarm' ); ?></label>
		<input class="widefat" id="<?php echo esc_attr($this->get_field_id( 'title' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'title' )); ?>" type="text" value="<?php echo esc_attr($title); ?>" /></p>

		<p><label for="<?php echo esc_attr($this->get_field_id( 'number' )); ?>"><?php echo esc_html__( 'Number of post to show:', 'orfarm' ); ?></label>
		<input id="<?php echo esc_attr($this->get_field_id( 'number' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'number' )); ?>" type="text" value="<?php echo esc_attr($number); ?>" size="3" /></p>
		
		<p><label for="<?php echo esc_attr($this->get_field_id( 'post_type' )); ?>"><?php echo esc_html__( 'Type of list:', 'orfarm' ); ?></label>
			<select id="<?php echo esc_attr($this->get_field_id( 'post_type' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'post_type' )); ?>">
				<option value=""><?php echo esc_html__('All', 'orfarm' ) ?></option>
				<option value="product" <?php echo ($post_type == 'product') ? 'selected="selected"': ''; ?>><?php echo esc_html__('Products', 'orfarm' ) ?></option>
				<option value="post" <?php echo ($post_type == 'post') ? 'selected="selected"': ''; ?>><?php echo esc_html__('Post', 'orfarm' ) ?></option>
			</select>
		</p>
		
		<?php
	}
}
