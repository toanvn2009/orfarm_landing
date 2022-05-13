<?php
/**
 * Plugin Name: Orfarm LionThemes Helper
 * Plugin URI: https://blueskytechco.com/
 * Description: The helper plugin for Orfarm themes.
 * Version: 1.0.0
 * Author: LionThemes
 * Author URI: https://blueskytechco.com/
 * Text Domain: lionthemes
 * License: GPL/GNU.
 *  Copyright 2021  Bluesky Techcompany  (email : blueskytechcompany@gmail.com)
*/

$current_theme = wp_get_theme();
$theme = $current_theme->get('TextDomain');
if ($theme == 'orfarm') {
	
	define('LION_CURRENT_THEME', $theme);
	define('IMPORT_LOG_PATH', plugin_dir_path( __FILE__ ) . 'wbc_importer/');
	define('WP_PLUGIN_PATH', plugin_dir_path(__DIR__));
	function lionthemes_make_id($length = 5){
		$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$randomString = '';
		for ($i = 0; $i < $length; $i++) {
			$randomString .= $characters[rand(0, strlen($characters) - 1)];
		}
		return $randomString;
	}
	//get taxonomy list by parent children
	function lionthemes_get_all_taxonomy_terms($taxonomy = 'product_cat', $all = false, $keyval = true){
		
		global $wpdb;
		
		$arr = array(
			'orderby' => 'name',
			'hide_empty' => 0
		);
		$categories = $wpdb->get_results($wpdb->prepare("SELECT t.name,t.slug,t.term_group,x.term_taxonomy_id,x.term_id,x.taxonomy,x.description,x.parent,x.count FROM {$wpdb->prefix}term_taxonomy x LEFT JOIN {$wpdb->prefix}terms t ON (t.term_id = x.term_id) WHERE x.taxonomy=%s ORDER BY x.parent ASC, t.name ASC;", $taxonomy));
		$output = array();
		if($all) $output = $keyval ? array( array('label' => esc_html__('All categories', 'orfarm'), 'value' => '') ) : array(esc_html__('All categories', 'orfarm') => '');
		if(!is_array($categories)) return $output;
		lionthemes_get_repare_terms_children( 0, 0, $categories, 0, $output, $keyval );
		
		return $output;
	}

	function lionthemes_get_repare_terms_children( $parent_id, $pos, $categories, $level, &$output, $keyval ) {
		for ( $i = $pos; $i < count( $categories ); $i ++ ) {
			if ( isset($categories[ $i ]->parent) && $categories[ $i ]->parent == $parent_id ) {
				$name = str_repeat( " - ", $level ) . ucfirst($categories[ $i ]->name);
				$value = $categories[ $i ]->slug;
				if ($keyval) {
					$output[] = array( 'label' => $name, 'value' => $value );
				} else {
					$output[$name] = $value;
				}
				lionthemes_get_repare_terms_children( (int)$categories[ $i ]->term_id, $i, $categories, $level + 1, $output, $keyval );
			}
		}
	}

	// All Orfarm theme helper functions in here
	function lionthemes_get_effect_list($revert = false){
		$list = array(
			esc_html__( 'None', 'orfarm' ) 	=> '',
			esc_html__( 'Bounce In', 'orfarm' ) 	=> 'bounceIn',
			esc_html__( 'Bounce In Down', 'orfarm' ) 	=> 'bounceInDown',
			esc_html__( 'Bounce In Left', 'orfarm' ) 	=> 'bounceInLeft',
			esc_html__( 'Bounce In Right', 'orfarm' ) 	=> 'bounceInRight',
			esc_html__( 'Bounce In Up', 'orfarm' ) 	=> 'bounceInUp',
			esc_html__( 'Fade In', 'orfarm' ) 	=> 'fadeIn',
			esc_html__( 'Fade In Down', 'orfarm' ) 	=> 'fadeInDown',
			esc_html__( 'Fade In Left', 'orfarm' ) 	=> 'fadeInLeft',
			esc_html__( 'Fade In Right', 'orfarm' ) 	=> 'fadeInRight',
			esc_html__( 'Fade In Up', 'orfarm' ) 	=> 'fadeInUp',
			esc_html__( 'Flip In X', 'orfarm' ) 	=> 'flipInX',
			esc_html__( 'Flip In Y', 'orfarm' ) 	=> 'flipInY',
			esc_html__( 'Light Speed In', 'orfarm' ) 	=> 'lightSpeedIn',
			esc_html__( 'Rotate In', 'orfarm' ) 	=> 'rotateIn',
			esc_html__( 'Rotate In Down Left', 'orfarm' ) 	=> 'rotateInDownLeft',
			esc_html__( 'Rotate In Down Right', 'orfarm' ) 	=> 'rotateInDownRight',
			esc_html__( 'Rotate In Up Left', 'orfarm' ) 	=> 'rotateInUpLeft',
			esc_html__( 'Rotate In Up Right', 'orfarm' ) 	=> 'rotateInUpRight',
			esc_html__( 'Slide In Down', 'orfarm' ) 	=> 'slideInDown',
			esc_html__( 'Slide In Left', 'orfarm' ) 	=> 'slideInLeft',
			esc_html__( 'Slide In Right', 'orfarm' ) 	=> 'slideInRight',
			esc_html__( 'Roll In', 'orfarm' ) 	=> 'rollIn',
		);
		if ($revert) return array_flip($list);
		return $list;
	}
	
	// All Orfarm theme helper functions in here 
	function lionthemes_get_category_post_list($revert = false){
		$categories = get_categories();
		$ar_cat = [];
		foreach($categories as $category) {
		   $ar_cat[$category->term_id] = $category->name;
		}
		$list = $ar_cat;
		return $list;
	}


	if ( file_exists( plugin_dir_path( __FILE__ ). 'inc/custom-fields.php' ) ) {
		require_once( plugin_dir_path( __FILE__ ) . 'inc/custom-fields.php' );
	}
	if ( file_exists( plugin_dir_path( __FILE__ ). 'inc/widgets.php' ) ) {
		require_once( plugin_dir_path( __FILE__ ). 'inc/widgets.php' );
	}
	if (did_action( 'elementor/loaded' )) {
		if ( file_exists( plugin_dir_path( __FILE__ ). 'inc/elementor-extension.php' ) ) {
			require_once( plugin_dir_path( __FILE__ ) . 'inc/elementor-extension.php' );
		}
	}

	require_once( plugin_dir_path( __FILE__ ). 'inc/oneclick-import.php' );

	// add placeholder for input social icons 
	add_action("redux/field/orfarm_opt/sortable/fieldset/after/orfarm_opt", 'orfarm_redux_add_placeholder_sortable', 0);
	function orfarm_redux_add_placeholder_sortable($data){
		$fieldset_id = $data['id'] . '-list';
		$base_name = 'orfarm_opt['. $data['id'] .']';
		echo "<script type=\"text/javascript\">
				jQuery('#$fieldset_id li input[type=\"text\"]').each(function(){
					var my_name = jQuery(this).attr('name');
					placeholder = my_name.replace('$base_name', '').replace('[','').replace(']','');
					jQuery(this).attr('placeholder', placeholder);
					jQuery(this).next('span').attr('title', placeholder);
				});
			</script>";
	}
	//Redux wbc importer for import data one click.
	function lionthemes_helper_redux_register_extension_loader($ReduxFramework) {
		
		if ( ! class_exists( 'ReduxFramework_extension_wbc_importer' ) ) {
			$class_file = plugin_dir_path( __FILE__ ) . 'wbc_importer/extension_wbc_importer.php';
			$class_file = apply_filters( 'redux/extension/' . $ReduxFramework->args['opt_name'] . '/wbc_importer', $class_file );
			if ( $class_file ) {
				require_once( $class_file );
			}
		}
		if ( ! isset( $ReduxFramework->extensions[ 'wbc_importer' ] ) ) {
			$ReduxFramework->extensions[ 'wbc_importer' ] = new ReduxFramework_extension_wbc_importer( $ReduxFramework );
		}
	}
	add_action("redux/extensions/orfarm_opt/before", 'lionthemes_helper_redux_register_extension_loader', 0);

	function lionthemes_log($msg) {
		$datafeed = date('Y-m-d H:i:s') . ": " . $msg . "\r\n";
		$fp = fopen(plugin_dir_path( __FILE__ ) . '/log.txt', 'a+');
		fwrite($fp, $datafeed);
		fclose($fp);
	}

	//Less compiler
	function compileLess($input, $output, $params){
		// input and output location
		$inputFile = get_template_directory().'/less/'.$input;
		$outputFile = get_template_directory().'/css/'.$output;
		if(!file_exists($inputFile)) return;
		// include Less Lib
		if(file_exists( plugin_dir_path( __FILE__ ) . 'less/lessc.inc.php' )){
			require_once( plugin_dir_path( __FILE__ ) . 'less/lessc.inc.php' );
			try{
				$less = new lessc;
				$less->setVariables($params);
				$less->setFormatter("compressed");
				$cache = $less->cachedCompile($inputFile);
				file_put_contents($outputFile, $cache["compiled"]);
				$last_updated = $cache["updated"];
				$cache = $less->cachedCompile($cache);
				if ($cache["updated"] > $last_updated) {
					file_put_contents($outputFile, $cache["compiled"]);
				}
			}catch(Exception $e){
				$error_message = $e->getMessage();
				echo $error_message;
			}
		}
		return;
	}

	function lionthemes_ran_id($length = 5){
		$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$randomString = '';
		for ($i = 0; $i < $length; $i++) {
			$randomString .= $characters[rand(0, strlen($characters) - 1)];
		}
		return $randomString;
	}
	//
	register_activation_hook( __FILE__, 'lionthemes_new_like_post_table' );
	function lionthemes_new_like_post_table(){
		global $wpdb;
		$table_name = $wpdb->prefix . 'lionthemes_user_like_ip';
		if($wpdb->get_var("SHOW TABLES LIKE '{$table_name}'") != $table_name) {
			 //table not in database. Create new table
			 $charset_collate = $wpdb->get_charset_collate();
			 $sql = "CREATE TABLE `{$table_name}` (
				  `post_id` int(11) UNSIGNED NOT NULL DEFAULT '0',
				  `user_ip` VARCHAR(100) NOT NULL DEFAULT '',
				  PRIMARY KEY (`post_id`,`user_ip`)
			 ) {$charset_collate}";
			 require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
			 dbDelta( $sql );
		}
	}
	// function display number like of posts.
	function lionthemes_get_liked($postID){
		global $wpdb;
		$table_name = $wpdb->prefix . 'lionthemes_user_like_ip';
		if($wpdb->get_var($wpdb->prepare("SHOW TABLES LIKE %s", $table_name)) != $table_name) {
			lionthemes_new_like_post_table();
			return 0;
		}else{
			$safe_sql = $wpdb->prepare("SELECT COUNT(*) FROM {$table_name} WHERE post_id = %s", $postID);
			$results = $wpdb->get_var( $safe_sql );
			return $results;
		}
	}


	//ajax like count
	add_action( 'wp_footer', 'lionthemes_add_js_like_post');
	function lionthemes_add_js_like_post(){
		?>
		<script>
		jQuery(document).on('click', 'a.lionthemes_like_post', function(e){
			var like_title;
			if(jQuery(this).hasClass('liked')){
				jQuery(this).removeClass('liked');
				like_title = jQuery(this).data('unliked_title');
			}else{
				jQuery(this).addClass('liked');
				like_title = jQuery(this).data('liked_title');
			}
			var post_id = jQuery(this).data("post_id");
			var me = jQuery(this);
			jQuery.ajax({
				type: 'POST',
				dataType: 'json',
				url: ajaxurl,
				data: 'action=lionthemes_update_like&post_id=' + post_id, 
				success: function(data){
					me.children('.number').text(data);
					me.attr('title', like_title).attr('data-original-title', like_title);
					me.tooltip();
				}
			});
			e.preventDefault();
			return false;
		});
		</script>
	<?php 
	} 
	add_action( 'wp_ajax_lionthemes_update_like', 'lionthemes_update_like' );
	add_action( 'wp_ajax_nopriv_lionthemes_update_like', 'lionthemes_update_like' );
	function lionthemes_get_the_user_ip(){
		if ( ! empty( $_SERVER['HTTP_CLIENT_IP'] ) ) {
			$ip = $_SERVER['HTTP_CLIENT_IP'];
		} elseif ( ! empty( $_SERVER['HTTP_X_FORWARDED_FOR'] ) ) {
			$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
		} else {
			$ip = $_SERVER['REMOTE_ADDR'];
		}
		return $ip;
	}

	function lionthemes_check_liked_post($postID){
		global $wpdb;
		$table_name = $wpdb->prefix . 'lionthemes_user_like_ip';
		if($wpdb->get_var($wpdb->prepare("SHOW TABLES LIKE %s", $table_name)) != $table_name) {
			lionthemes_new_like_post_table();
			return 0;
		}else{
			$user_ip = lionthemes_get_the_user_ip();
			$safe_sql = $wpdb->prepare("SELECT COUNT(*) FROM {$table_name} WHERE post_id = %s AND user_ip = %s", $postID, $user_ip);
			$results = $wpdb->get_var( $safe_sql );
			return $results;
		}
	}

	function lionthemes_update_like(){
		$count_key = 'post_like_count';
		if(empty($_POST['post_id'])){
		   die('0');
		}else{
			global $wpdb;
			$table_name = $wpdb->prefix . 'lionthemes_user_like_ip';
			$postID = intval($_POST['post_id']);
			$check = lionthemes_check_liked_post($postID);
			$ip = lionthemes_get_the_user_ip();
			$data = array('post_id' => $postID, 'user_ip' => $ip);
			if($check){
				//remove like record
				$wpdb->delete( $table_name, $data ); 
			}else{
				//add new like record
				$wpdb->insert( $table_name, $data );
			}
			echo lionthemes_get_liked($postID);
			die();
		}
	}
	add_action('lionthemes_like_button', 'lionthemes_like_button_html');
	function lionthemes_like_button_html($id){
		$liked = lionthemes_check_liked_post($id); ?>
		<div class="likes-counter">
			<a  data-toggle="tooltip" title="<?php echo (!$liked) ?  esc_html__('Like this post', 'orfarm') : esc_html__('Unlike this post', 'orfarm'); ?>" class="lionthemes_like_post<?php echo ($liked) ? ' liked':''; ?>" href="javascript:void(0)" data-post_id="<?php echo $id; ?>" data-liked_title="<?php echo esc_html__('Unlike this post', 'orfarm') ?>" data-unliked_title="<?php echo esc_html__('Like this post', 'orfarm') ?>">
				<i class="fa fa-heart"></i><span class="number"><?php echo lionthemes_get_liked($id); ?></span>
			</a>
		</div>
		<?php
	}

	// display number view of posts.
	function lionthemes_get_post_viewed($postID){
		$count_key = 'post_views_count';
		delete_post_meta($postID, 'post_like_count');
		$count = get_post_meta($postID, $count_key, true);
		if($count==''){
			delete_post_meta($postID, $count_key);
			add_post_meta($postID, $count_key, '0');
			return 0;
		}
		return $count;
	}


	// count post views.
	add_action( 'wp', 'lionthemes_set_post_view' );
	function lionthemes_set_post_view() {
		if (get_post_type() == 'post' && is_singular()) {
			$postID = get_the_ID();
			$count_key = 'post_views_count';
			$count = (int)get_post_meta($postID, $count_key, true);
			if(!$count){
				$count = 1;
				delete_post_meta($postID, $count_key);
				add_post_meta($postID, $count_key, $count);
			}else{
				$count++;
				update_post_meta($postID, $count_key, $count);
			}
		}
	}

	add_action('lionthemes_display_view_count', 'lionthemes_display_view_count_html');
	function lionthemes_display_view_count_html($id) { ?>
		<div class="post-views" title="<?php echo esc_html__('Total Views', 'orfarm') ?>" data-toggle="tooltip">
			<i class="fa fa-eye"></i><?php echo lionthemes_get_post_viewed($id); ?>
		</div>
	<?php }

	// remove redux ads
	add_action('admin_enqueue_scripts','lionthemes_remove_redux_ads', 10, 1);
	function lionthemes_remove_redux_ads(){
		$remove_redux = 'jQuery(document).ready(function($){
							setTimeout(
								function(){
									$(".rAds, .redux-notice, .vc_license-activation-notice, #js_composer-update, #mega_main_menu-update, #vc_license-activation-notice").remove();
									$("tr[data-slug=\"mega_main_menu\"]").removeClass("update");
									$("tr[data-slug=\"js_composer\"]").removeClass("update");
									$("tr[data-slug=\"slider-revolution\"]").removeClass("is-uninstallable");
									$("tr[data-slug=\"slider-revolution\"]").next(".plugin-update-tr").remove();
									$("tr[data-slug=\"slider-revolution\"]").next(".plugin-update-tr").remove();
								}, 500);
						});';
		if ( ! wp_script_is( 'jquery', 'done' ) ) {
			wp_enqueue_script( 'jquery' );
		}
		wp_add_inline_script( 'jquery', $remove_redux );
	}

	add_action( 'wp_enqueue_scripts', 'lionthemes_register_script' );
	function lionthemes_register_script(){
		// add adminbar style sheet
		$style = '@media screen and (max-width: 600px){
						#wpadminbar{
							position: fixed;
						}
					}';
		wp_add_inline_style( 'orfarm-theme-options', $style );
		wp_enqueue_style( 'lionthemes-style', plugin_dir_url( __FILE__ ) . 'assets/style.css' );
		wp_enqueue_script( 'lionthemes-script', plugin_dir_url( __FILE__ ) . 'assets/script.js', array('jquery'), '', true );
	}
	function lionthemes_get_excerpt($post_id, $limit){
		$the_post = get_post($post_id); //Gets post ID
		$the_excerpt = $the_post->post_content; //Gets post_content to be used as a basis for the excerpt
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
	add_action('lionthemes_quickview_after_product_info', 'lionthemes_product_sharing');
	add_action( 'woocommerce_share', 'lionthemes_product_sharing', 40 );
	//social share products
	function lionthemes_product_sharing() {
		global $orfarm_opt;
		if(isset($_POST['data'])) { // for the quickview
			$postid = intval( $_POST['data'] );
		} else {
			$postid = get_the_ID();
		}
		if(isset($orfarm_opt['pro_social_share']) && is_array($orfarm_opt['pro_social_share'])){
			$pro_social_share = array_filter($orfarm_opt['pro_social_share']);
		}
		if(!empty($pro_social_share)){
		$share_url = get_permalink( $postid );

		$large_image_url = wp_get_attachment_image_src( get_post_thumbnail_id( $postid ), 'large' );
		$postimg = $large_image_url[0];
		$posttitle = get_the_title( $postid );
		?>
		<div class="social-sharing">
		<div class="widget widget_socialsharing_widget">
			<h3 class="widget-title"><?php if(isset($orfarm_opt['product_share_title'])) { echo esc_html($orfarm_opt['product_share_title']); } else { esc_html_e('Share this product', 'orfarm'); } ?></h3>
			<ul class="social-icons">
				<?php if(!empty($orfarm_opt['pro_social_share']['facebook'])){ ?>
					<li><a class="facebook social-icon" href="javascript:void(0)" onclick="javascript:window.open('<?php echo 'https://www.facebook.com/sharer/sharer.php?u='.$share_url; ?>', '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600'); return false;" title="<?php echo esc_attr__('Facebook', 'orfarm'); ?>"><i class="fa fa-facebook"></i></a></li>
				<?php } ?>
				<?php if(!empty($orfarm_opt['pro_social_share']['twitter'])){ ?>
					<li><a class="twitter social-icon" href="javascript:void(0)" onclick="javascript:window.open('<?php echo 'https://twitter.com/home?status='.$posttitle.'&nbsp;'.$share_url; ?>', '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600'); return false;" title="<?php echo esc_attr__('Twitter', 'orfarm'); ?>" ><i class="fa fa-twitter"></i></a></li>
				<?php } ?>
				<?php if(!empty($orfarm_opt['pro_social_share']['pinterest'])){ ?>
					<li><a class="pinterest social-icon" href="javascript:void(0)" onclick="javascript:window.open('<?php echo 'https://pinterest.com/pin/create/button/?url='.$share_url.'&amp;media='.$postimg.'&amp;description='.$posttitle; ?>', '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600'); return false;" title="<?php echo esc_attr__('Pinterest', 'orfarm'); ?>"><i class="fa fa-pinterest"></i></a></li>
				<?php } ?>
				<?php if(!empty($orfarm_opt['pro_social_share']['gplus'])){ ?>
				<li><a class="gplus social-icon" href="javascript:void(0)" onclick="javascript:window.open('<?php echo 'https://plus.google.com/share?url='.$share_url; ?>', '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600'); return false;" title="<?php echo esc_attr__('Google +', 'orfarm'); ?>"><i class="fa fa-google-plus"></i></a></li>
				<?php } ?>
				<?php if(!empty($orfarm_opt['pro_social_share']['linkedin'])){ ?>
					<li><a class="linkedin social-icon" href="javascript:void(0)" onclick="javascript:window.open('<?php echo 'https://www.linkedin.com/shareArticle?mini=true&amp;url='.$share_url.'&amp;title='.$posttitle; ?>', '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600'); return false;" title="<?php echo esc_attr__('LinkedIn', 'orfarm'); ?>"><i class="fa fa-linkedin"></i></a></li>
				<?php } ?>
			</ul>
		</div>
		</div>
		<?php
		}
	}
	add_action('lionthemes_end_single_post', 'lionthemes_blog_sharing');
	//social share blog
	function lionthemes_blog_sharing() {
		global $orfarm_opt;
		
		if(isset($orfarm_opt['post_social_share']) && is_array($orfarm_opt['post_social_share'])){
			$post_social_share = array_filter($orfarm_opt['post_social_share']);
		}
		if(!empty($post_social_share)){
		$postid = get_the_ID();
		
		$share_url = get_permalink( $postid );

		$large_image_url = wp_get_attachment_image_src( get_post_thumbnail_id( $postid ), 'large' );
		$postimg = $large_image_url[0];
		$posttitle = get_the_title( $postid );
		?>
		<div class="social-sharing">
		<div class="widget widget_socialsharing_widget">
			<ul class="social-icons">
				<?php if(!empty($orfarm_opt['post_social_share']['facebook'])){ ?>
				<li><a class="facebook social-icon" href="javascript:void(0)" onclick="javascript:window.open('<?php echo 'https://www.facebook.com/sharer/sharer.php?u='.$share_url; ?>', '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600'); return false;" title="<?php echo esc_attr__('Facebook', 'orfarm'); ?>"><i class="fa fa-facebook"></i></a></li>
				<?php } ?>
				<?php if(!empty($orfarm_opt['post_social_share']['twitter'])){ ?>
				<li><a class="twitter social-icon" href="javascript:void(0)" onclick="javascript:window.open('<?php echo 'https://twitter.com/home?status='.$posttitle.'&nbsp;'.$share_url; ?>', '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600'); return false;" title="<?php echo esc_attr__('Twitter', 'orfarm'); ?>"><i class="fa fa-twitter"></i></a></li>
				<?php } ?>
				<?php if(!empty($orfarm_opt['post_social_share']['pinterest'])){ ?>
				<li><a class="pinterest social-icon" href="javascript:void(0)" onclick="javascript:window.open('<?php echo 'https://pinterest.com/pin/create/button/?url='.$share_url.'&amp;media='.$postimg.'&amp;description='.$posttitle; ?>', '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600'); return false;" title="<?php echo esc_attr__('Pinterest', 'orfarm'); ?>"><i class="fa fa-pinterest"></i></a></li>
				<?php } ?>
				<?php if(!empty($orfarm_opt['post_social_share']['gplus'])){ ?>
				<li><a class="gplus social-icon" href="javascript:void(0)" onclick="javascript:window.open('<?php echo 'https://plus.google.com/share?url='.$share_url; ?>', '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600'); return false;" title="<?php echo esc_attr__('Google +', 'orfarm'); ?>"><i class="fa fa-google-plus"></i></a></li>
				<?php } ?>
				<?php if(!empty($orfarm_opt['post_social_share']['linkedin'])){ ?>
				<li><a class="linkedin social-icon" href="javascript:void(0)" onclick="javascript:window.open('<?php echo 'https://www.linkedin.com/shareArticle?mini=true&amp;url='.$share_url.'&amp;title='.$posttitle; ?>', '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600'); return false;" title="<?php echo esc_attr__('LinkedIn', 'orfarm'); ?>"><i class="fa fa-linkedin"></i></a></li>
				<?php } ?>
			</ul>
		</div>
		</div>
		<?php
		}
	}

	add_filter('body_class', 'lionthemes_body_class');
	function lionthemes_body_class($classes) {
		$classes[] = 'lionthemes_helped';
		return $classes;
	}

	function lionthemes_get_template_part( $file, $template_args = array() ) {

		$template_args = wp_parse_args( $template_args );
		extract($template_args);

		$hasFile = false;
		if ( file_exists( get_stylesheet_directory() . '/' . $file . '.php' ) ) {
			$hasFile = true;
			$file = get_stylesheet_directory() . '/' . $file . '.php';
		} elseif ( file_exists( get_template_directory() . '/' . $file . '.php' ) ) {
			$hasFile = true;
			$file = get_template_directory() . '/' . $file . '.php';
		}

		ob_start();
		if ($hasFile) {
			$return = require( $file );
		} else {
			$return = '';
		}
		$data = ob_get_clean();


		if ( ! empty( $template_args['return'] ) )
			if ( $return === false )
				return false;
			else
				return $data;

		echo $data;
	}
}