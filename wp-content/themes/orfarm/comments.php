<?php
/**
 * Template for displaying comments
 *
 * @package LionThemes
 * @subpackage Orfarm_theme
 * @since Orfarm Themes 2.0 
 */


if (post_password_required()) {
	return;
}
?>
<div id="comments" class="comments-area">

	<?php // You can start editing here -- including this comment! ?>

	<?php if (have_comments()) { ?>
		<h3 class="comments-title">
			<?php echo esc_html__('Leave a comment ', 'orfarm'); ?>
		</h3>
		<?php if (get_comment_pages_count() > 1 && get_option('page_comments')) { // are there comments to navigate through  ?> 
			<h3 class="screen-reader-text sr-only"><?php esc_html__('Comment navigation', 'orfarm'); ?></h3> 
			<ul id="comment-nav-above" class="comment-navigation pager">
				<li class="nav-previous previous"><?php previous_comments_link(esc_html__('&larr; Older Comments', 'orfarm')); ?></li>
				<li class="nav-next next"><?php next_comments_link(esc_html__('Newer Comments &rarr;', 'orfarm')); ?></li>
			</ul><!-- #comment-nav-above -->
		<?php } // check for comment navigation  ?> 

		<ul class="media-list">
			<?php
			/* Loop through and list the comments. Tell wp_list_comments()
			 * to use orfarm_bootstrap_comment() to format the comments.
			 * If you want to override this in a child theme, then you can
			 * define orfarm_bootstrap_comment() and that will be used instead.
			 * See orfarm_bootstrap_comment() in inc/template-tags.php for more.
			 */
			wp_list_comments(array('avatar_size' => '64', 'callback' => 'orfarm_bootstrap_comment'));
			?>
		</ul><!-- .comment-list -->

		<?php if (get_comment_pages_count() > 1 && get_option('page_comments')) { // are there comments to navigate through  ?> 
			<h3 class="screen-reader-text sr-only"><?php esc_html_e('Comment navigation', 'orfarm'); ?></h3>
			<ul id="comment-nav-below" class="comment-navigation comment-navigation-below pager">
				<li class="nav-previous previous"><?php previous_comments_link(esc_html__('&larr; Older Comments', 'orfarm')); ?></li>
				<li class="nav-next next"><?php next_comments_link(esc_html__('Newer Comments &rarr;', 'orfarm')); ?></li>
			</ul><!-- #comment-nav-below -->
		<?php } // check for comment navigation  ?> 

	<?php } // have_comments()  ?>

	<?php
	// If comments are closed and there are comments, let's leave a little note, shall we?
	if (!comments_open() && '0' != get_comments_number() && post_type_supports(get_post_type(), 'comments')) { ?> 
		<p class="no-comments"><?php esc_html_e('Comments are closed.', 'orfarm'); ?></p>
	<?php 
	} //endif; 
	?> 

	<?php 
	$req      = get_option('require_name_email');
	$aria_req = ($req ? " aria-required='true'" : '');
	$html5 = true;
	
	// re-format comment allowed tags
	$comment_allowedtags = allowed_tags();
	$comment_allowedtags = str_replace(array("\r\n", "\r", "\n"), '', $comment_allowedtags);
	$comment_allowedtags_array = explode('&gt; &lt;', $comment_allowedtags);
	$formatted_comment_allowedtags = '';
	foreach ($comment_allowedtags_array as $item) {
		$formatted_comment_allowedtags .= '<code>';
		
		if ($comment_allowedtags_array[0] != $item) {
			$formatted_comment_allowedtags .= '&lt;';
		}
		
		$formatted_comment_allowedtags .= $item;
		
		if (end($comment_allowedtags_array) != $item) {
			$formatted_comment_allowedtags .= '&gt;';
		}
		
		$formatted_comment_allowedtags .= '</code> ';
	}
	$comment_allowed_tags = $formatted_comment_allowedtags;
	unset($comment_allowedtags, $comment_allowedtags_array, $formatted_comment_allowedtags);
	
	ob_start();
	
	comment_form(
		array(
			'class_submit' => 'btn btn-primary',
				'fields' => array(
					'email'  => '<div class="info-wrapper">' . 
								'<label class="control-label" for="email">' . esc_html__('Email', 'orfarm') . ($req ? ' <span class="required">*</span>' : '') . '</label> ' .
								'<div class="comment-form-email">' . 
								'<input id="email" name="email" placeholder="Email" ' . ($html5 ? 'type="email"' : 'type="text"') . ' value="' . esc_attr($commenter['comment_author_email']) . '" size="30"' . $aria_req . ' class="form-control" />' . 
								'</div>' . 
								'</div>',
					'author' => '<div class="info-wrapper">' . 
								'<label class="control-label " for="author">' . esc_html__('Name', 'orfarm') . ($req ? ' <span class="required">*</span>' : '') . '</label> ' .
								'<div class="comment-form-author">' . 
								'<input id="author" name="author" placeholder="Name" type="text" value="' . esc_attr($commenter['comment_author']) . '" size="30"' . $aria_req . ' class="form-control" />' . 
								'</div>' . 
								'</div>',
					'url'    => '<div class="info-wrapper">' . 
								'<label class="control-label " for="url">' . esc_html__('Website', 'orfarm') . '</label> ' .
								'<div class="comment-form-url">' . 
								'<input id="url" name="url" ' . ($html5 ? 'type="url"' : 'type="text"') . ' value="' . esc_url($commenter['comment_author_url']) . '" size="30" class="form-control" />' . 
								'</div>' . 
								'</div>',
				),
				'comment_field' => '<div class="message-wrapper">' . 
							'<label class="control-label " for="comment">' . esc_html__('Comment', 'orfarm') . ' <span class="required">*</span></label> ' . 
							'<div class="comment-form-comment">' . 
							'<textarea id="comment" name="comment" placeholder="Comment" cols="45" rows="8" aria-required="true" class="form-control"></textarea>' . 
							'</div>' . 
							'</div>'
		)
	); 
	
	/**
	 * WordPress comment form does not support action/filter form and input submit elements. Rewrite these code when there is support available.
	 * @todo Change form class modification to use WordPress hook action/filter when it's available.
	 */
	$comment_form = str_replace('class="comment-form', 'class="comment-form form form-horizontal', ob_get_clean());
	echo ''.$comment_form;
	
	unset($comment_allowed_tags, $comment_form);
	?>

</div><!-- #comments -->
