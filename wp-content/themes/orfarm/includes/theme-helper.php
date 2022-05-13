<?php
function orfarm_get_blog_option($key = '') { 
	$orfarm_opt = get_option( 'orfarm_opt' );
	$settings = array(
		'sidebar' => 'none',
		'blogcolumn' => 'col-sm-12',
		'coldata' => 1,
		'banner_image' => '',
		'banner_blog_title' => '', 
		'noexcerpt' => false,
		'meta' => true,
		'autogrid' => false,
		'postlayout' => 'big-image'
	);
	if (is_active_sidebar('blog')) {
		$settings['sidebar'] = 'right';
	}
	if(isset($orfarm_opt['sidebarblog_pos']) && is_active_sidebar('blog')) { 
		$settings['sidebar'] = $orfarm_opt['sidebarblog_pos'];
	}
	if(isset($orfarm_opt['blogpost_layout'])) {
		$settings['postlayout'] = $orfarm_opt['blogpost_layout'];
	}
	if(isset($_GET['side'])) {
		$settings['sidebar'] = sanitize_text_field($_GET['side']);
	}
	if(isset($orfarm_opt['banner_image'])) {
		$settings['banner_image'] = $orfarm_opt['banner_image'];
	}
	if(isset($orfarm_opt['banner_blog_title'])) {
		$settings['banner_blog_title'] = $orfarm_opt['banner_blog_title'];
	}
	if(!empty($orfarm_opt['blog_column'])) {
		if ($orfarm_opt['blog_column'] > 1) {
			$settings['blogcolumn'] = ($orfarm_opt['blog_column'] == 3) ? 'col-sm-4' : 'col-sm-6';
		}
		$settings['coldata'] = $orfarm_opt['blog_column'];
	}
	if(!empty($_GET['col'])) {
		if ($_GET['col'] == 2) {
			$settings['blogcolumn'] = 'col-sm-6';
			$settings['coldata'] = sanitize_text_field($_GET['col']);
		}
		if ($_GET['col'] == 3) {
			$settings['blogcolumn'] = 'col-sm-4';
			$settings['coldata'] = sanitize_text_field($_GET['col']);
		}
	}
	if ($settings['coldata'] > 1 && !empty($orfarm_opt['enable_autogrid'])) $settings['autogrid'] = true;
	if (!empty($orfarm_opt['noexcerpt'])) $settings['noexcerpt'] = false;
	if (!empty($_GET['grid'])) $settings['autogrid'] = false;
	if (!empty($_GET['postlayout'])) $settings['postlayout'] = sanitize_text_field($_GET['postlayout']);
	if (empty($orfarm_opt) && is_single()) $settings['sidebar'] = 'none';
	return ($key && isset($settings[$key])) ? $settings[$key] : $settings;
};

function orfarm_get_product_option($key = '') { 
	$orfarm_opt = get_option( 'orfarm_opt' );
	$settings = array(
		'sidebar_product' => 'none',
		'productcolumn' => 'col-sm-12',
		'coldata' => 1,
		'banner_image' => '',
		'banner_product_title' => '', 
		'noexcerpt' => false,
		'meta' => true,
		'autogrid' => false,
		'productlayout' => 'big-image'
	);
	if (isset($orfarm_opt ['sidebar_product']) )  {
		$settings['sidebar_product'] = $orfarm_opt ['sidebar_product'];
	}


	return ($key && isset($settings[$key])) ? $settings[$key] : $settings;
};

// All Orfarm theme helper functions in here
function orfarm_woocommerce_query($type,$post_per_page=-1,$cat='',$keyword=null){
	$args = orfarm_woocommerce_query_args($type,$post_per_page,$cat,$keyword);
	return new WP_Query($args);
}

function orfarm_woocommerce_query_args($type,$post_per_page=-1,$cat='',$keyword=null){
    $args = array(
        'post_type' => 'product',
        'posts_per_page' => $post_per_page,
        'post_status' => 'publish',
		'date_query' => array(
			array(
			   'before' => date('Y-m-d H:i:s', current_time( 'timestamp' ))
			)
		 ),
		 'post_parent' => 0
    );
    switch ($type) {
        case 'best_selling':
            $args['meta_key']='total_sales';
            $args['orderby']='meta_value_num';
            $args['ignore_sticky_posts']   = 1;
            $args['meta_query'] = array();
            break;
        case 'featured_product':
            $args['ignore_sticky_posts'] = 1;
            $args['meta_query'] = array();
            $args['tax_query'][] = array(
				'taxonomy'         => 'product_visibility',
				'terms'            => 'featured',
				'field'            => 'name',
				'operator'         => 'IN',
				'include_children' => false,
			);
            break;
        case 'top_rate':
            $args['meta_key']='_wc_average_rating';
            $args['orderby']='meta_value_num';
            $args['order']='DESC';
            $args['meta_query'] = array();
            break;
        case 'recent_product':
            $args['meta_query'] = array();
			$args['orderby']='date';
            $args['order']='DESC';
            break;
        case 'on_sale':
            $args['meta_query'] = array();
            $product_ids_on_sale    = wc_get_product_ids_on_sale();
			$product_ids_on_sale[]  = 0;
            $args['post__in'] = $product_ids_on_sale;
            break;
        case 'recent_review':
            if($post_per_page == -1) $_limit = 4;
            else $_limit = $post_per_page;
            global $wpdb;
            $query = "SELECT c.comment_post_ID FROM {$wpdb->posts} p, {$wpdb->comments} c WHERE p.ID = c.comment_post_ID AND c.comment_approved > 0 AND p.post_type = 'product' AND p.post_status = 'publish' AND p.comment_count > 0 ORDER BY c.comment_date ASC LIMIT 0, %d";
            $safe_sql = $wpdb->prepare( $query, $_limit );
			$results = $wpdb->get_results($safe_sql, OBJECT);
            $_pids = array();
            foreach ($results as $re) {
                $_pids[] = $re->comment_post_ID;
            }

            $args['meta_query'] = array();
            $args['post__in'] = $_pids;
            break;
        case 'deals':
            $args['meta_query'] = array();
            $args['meta_query'][] = array(
                                 'key' => '_sale_price_dates_to',
                                 'value' => '0',
                                 'compare' => '>');
            $product_ids_on_sale    = wc_get_product_ids_on_sale();
			$product_ids_on_sale[]  = 0;
            $args['post__in'] = $product_ids_on_sale;
            break;
    }
	if ( 'yes' == get_option( 'woocommerce_hide_out_of_stock_items' ) ) {
		$args['tax_query'][] = array(
			array(
				'taxonomy' => 'product_visibility',
				'field'    => 'name',
				'terms'    => 'outofstock',
				'operator' => 'NOT IN',
			),
		);
		$args['meta_query'][] = array(
			'key'       => '_stock_status',
			'value'     => 'outofstock',
			'compare'   => 'NOT IN'
		);
	}
    if($cat!=''){
        $args['tax_query'][] = array(
				'taxonomy' => 'product_cat',
				'field' => 'slug',
				'terms' => $cat
			);
		if (!isset($args['orderby'])) {
			$args['orderby']='menu_order';
            $args['order']='ASC';
		}
    }
	if($keyword){
		$args['s'] = $keyword;
	}
    return $args;
}
function orfarm_make_id($length = 5){
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, strlen($characters) - 1)];
    }
    return $randomString;
}
//Change excerpt length
add_filter( 'excerpt_length', 'orfarm_excerpt_length', 999 );
function orfarm_excerpt_length( $length ) {
	global $orfarm_opt;
	if(isset($orfarm_opt['excerpt_length'])){
		return $orfarm_opt['excerpt_length'];
	}
	return 50;
}

// Remove pages from search results
function orfarm_exclude_pages_from_search($query) {
    if ( $query->is_main_query() && is_search() && empty($_GET['post_type']) ) {
        $query->set( 'post_type', 'post' );
    }
    return $query;
}
add_filter( 'pre_get_posts','orfarm_exclude_pages_from_search' );

// define the the_content_more_link callback 
add_filter( 'the_content_more_link', 'orfarm_the_content_more_link', 10, 2 );
function orfarm_the_content_more_link( $a_href_get_permalink_more_post_id_class_more_link_more_link_text_a, $more_link_text ) { 
    return ''; 
	// return '<div>' . $a_href_get_permalink_more_post_id_class_more_link_more_link_text_a . '</div>'; 
}; 

function orfarm_get_the_excerpt($post_id) {
	global $post;
	$temp = $post;
    $post = get_post( $post_id );
    setup_postdata( $post );
    $excerpt = get_the_excerpt();
    wp_reset_postdata();
    $post = $temp;
    return $excerpt;
}

//Add breadcrumbs
function orfarm_breadcrumb() {
	global $post, $orfarm_opt;

	$brseparator = '';
	if (isset( $orfarm_opt['page_breadcrumb'] ) && !is_home()) {
		echo '<div class="breadcrumbs circle-style" itemprop="breadcrumb">'; 
		
		echo '<a href="';
		echo esc_url( home_url( '/' ) );
		echo '">';
		echo esc_html__('Home', 'orfarm');
		echo '</a>'.$brseparator;
		if (is_category() || is_single()) {
			if (is_category()) {
				$cat = get_category(get_query_var('cat'), false);
				echo '<span> '. esc_html($cat->name).'</span>';
			} else {
				$cats = get_the_category($post->ID);
				if(!empty($cats[0]->name)) {
					echo '<a href="'. get_category_link($cats[0]->cat_ID) .'">' . $cats[0]->name . '</a>';
				}
			}
			if (is_single()) {
				if (function_exists('is_project') && is_project()) {
					echo '<a href="'. esc_url( get_permalink(projects_get_page_id('projects')) ) .'">' . esc_html__('Portfolio', 'orfarm') . '</a>';
				}
				echo ''.$brseparator;
				echo '<span> '. esc_html(get_the_title()).'</span>';
			}
		} elseif (is_page()) {
			if($post->post_parent){
				$anc = get_post_ancestors( $post->ID );
				$title = get_the_title();
				foreach ( $anc as $ancestor ) {
					$output = '<a href="'. esc_url(get_permalink($ancestor)).'" title="'.esc_attr(get_the_title($ancestor)).'">'. esc_html(get_the_title($ancestor)) .'</a>'.$brseparator;
				}
				echo wp_kses($output, array(
						'a'=>array(
							'href' => array(),
							'title' => array()
						),
						'span'=>array(
							'class'=>array()
						)
					)
				);
				echo '<span title="'.esc_attr($title).'"> '.esc_html($title).'</span>';
			} else {
				echo '<span> '. esc_html(get_the_title()).'</span>';
			}
		}
		elseif (is_tag()) {single_tag_title();}
		elseif (is_day()) {echo "<span>" . sprintf(esc_html__('Archive for %s', 'orfarm'), get_the_time('F jS, Y')); echo '</span>';}
		elseif (is_month()) {echo "<span>" . sprintf(esc_html__('Archive for %s', 'orfarm'), get_the_time('F, Y')); echo '</span>';}
		elseif (is_year()) {echo "<span>" . sprintf(esc_html__('Archive for %s', 'orfarm'), get_the_time('Y')); echo '</span>';} 
		elseif (is_author()) {echo "<span>" . esc_html__('Author Archive', 'orfarm'); echo '</span>';}
		elseif (isset($_GET['paged']) && !empty($_GET['paged'])) {echo "<span>" . esc_html__('Blog Archives', 'orfarm'); echo '</span>';}
		elseif (is_search()) {echo "<span>" . esc_html__('Search Results', 'orfarm'); echo '</span>';}
		elseif (function_exists('is_projects_archive') && is_projects_archive()) {
			if (is_post_type_archive( 'project' )) {
				echo "<span>" . esc_html__('Portfolio', 'orfarm'); echo '</span>';
			} else {
				echo "<span>" . esc_html(get_the_title()); echo '</span>';
			}
		}
		echo '</div>';
	} else {
		
		echo '<div class="breadcrumbs circle-style" itemprop="breadcrumb">';
		
		echo '<a href="';
		echo esc_url( home_url( '/' ) );
		echo '">';
		echo esc_html__('Home', 'orfarm');
		echo '</a>'.$brseparator;
		
		if(isset($orfarm_opt['blog_header_text']) && $orfarm_opt['blog_header_text']!=""){
			echo '<span> '. esc_html($orfarm_opt['blog_header_text']).'</span>';
		} else {
			echo '<span> '. esc_html__('Blog', 'orfarm').'</span>';
		}
		
		echo '</div>';
	}
}

//get taxonomy list by parent children
function orfarm_get_all_taxonomy_terms($taxonomy = 'product_cat', $all = false){
	
	global $wpdb;
	
	$arr = array(
		'orderby' => 'name',
		'hide_empty' => 0
	);
	$categories = $wpdb->get_results($wpdb->prepare("SELECT t.name,t.slug,t.term_group,x.term_taxonomy_id,x.term_id,x.taxonomy,x.description,x.parent,x.count FROM {$wpdb->prefix}term_taxonomy x LEFT JOIN {$wpdb->prefix}terms t ON (t.term_id = x.term_id) WHERE x.taxonomy=%s ORDER BY x.parent ASC, t.name ASC;", $taxonomy));
	$output = array();
	if($all) $output = array( array('label' => esc_html__('All categories', 'orfarm'), 'value' => '') );
	if(!is_array($categories)) return $output;
	orfarm_get_repare_terms_children( 0, 0, $categories, 0, $output );
	
	return $output;
}

function orfarm_get_repare_terms_children( $parent_id, $pos, $categories, $level, &$output ) {
	for ( $i = $pos; $i < count( $categories ); $i ++ ) {
		if ( isset($categories[ $i ]->parent) && $categories[ $i ]->parent == $parent_id ) {
			$name = str_repeat( " - ", $level ) . ucfirst($categories[ $i ]->name);
			$value = $categories[ $i ]->slug;
			$output[] = array( 'label' => $name, 'value' => $value );
			orfarm_get_repare_terms_children( (int)$categories[ $i ]->term_id, $i, $categories, $level + 1, $output );
		}
	}
}

//register new menu location
function orfarm_register_menu(){
	register_nav_menu( 'primary', esc_html__( 'Primary Menu', 'orfarm' ) );
	register_nav_menu( 'categories', esc_html__( 'Categories Menu', 'orfarm' ) );
	register_nav_menu( 'mobilemenu', esc_html__( 'Mobile Menu', 'orfarm' ) );
}
add_action( 'init', 'orfarm_register_menu' );

//Footer html addition
add_action( 'wp_footer', 'orfarm_popup_onload');
function orfarm_popup_onload(){
	
	$orfarm_opt = get_option( 'orfarm_opt' );
	
	//quickview wrapper
	?>
	<div class="quickview-wrapper">
		<div class="overlay-bg" onclick="hideQuickView()"><div class="lds-ripple"><div></div><div></div></div></div> 
		<div class="quick-modal">
			<span class="closeqv"><i class="icon-x"></i></span>
			<div id="quickview-content"></div><div class="clearfix"></div>
		</div>
	</div>
	
	<?php
	// newletter-form popup
	if(isset($orfarm_opt['enable_popup']) && $orfarm_opt['enable_popup']){
		if (is_front_page() && !empty($orfarm_opt['popup_onload_form']) && !empty($orfarm_opt['popup_onload_form'])) {
			$no_again = 0; 
			if(isset($_COOKIE['no_again'])) $no_again = $_COOKIE['no_again'];
			if(!$no_again){ 
		?>
			<div class="popup-content" id="popup_onload">
				<div class="overlay-bg"><div class="lds-ripple"><div></div><div></div></div></div>
				<div class="popup-content-wrapper" id="popup-style-apply">
					<div class="col-popup">
					<a class="close-popup" href="javascript:void(0)"><i class="icon-x"></i></a>
					<?php if(!empty($orfarm_opt['popup_onload_content'])){ ?>
					<div class="popup-content-text">
						<?php echo '' . $orfarm_opt['popup_onload_content']; ?>
					</div>
					<?php } ?>
					<?php if(!empty($orfarm_opt['popup_onload_form'])){ ?>
					<div class="newletter-form">
						<?php echo do_shortcode( '[mc4wp_form id="'. intval($orfarm_opt['popup_onload_form']) .'"]' ); ?>
					</div>
					<?php } ?>
					<p class="no-thanks"><?php echo esc_html__('No Thank ! I am not interested in this promotion', 'orfarm'); ?></p>
					<label class="not-again"><input type="checkbox" value="1" name="not-again" /><span><?php echo esc_html__('Do not show this popup again', 'orfarm'); ?></span></label>
					</div>
				</div>
			</div>
		<?php } 
		}
	}
}
// login popup form 
add_action( 'wp_footer', 'orfarm_account_login_popup');
function orfarm_account_login_popup() {
	$orfarm_opt = get_option( 'orfarm_opt' );
	?>
	<div id ="login-form-popup">
		<div class="tab">
		  <button class="tablinks active" onclick="openTab(event, 'login_form')">Login</button>
		  <button class="tablinks" onclick="openTab(event, 'register_form')">Register</button>
		</div>

		<div style="display:block" id="login_form" class="tabcontent">
			<?php 	if ( !is_user_logged_in() ) { ?>
				<div id="login-form-popup" >
					<form id="popup-form-login" class="woocommerce-form woocommerce-form-login login  data-tab-name="login" autocomplete="off" method="post"
								  action="<?php echo get_permalink( get_option( 'woocommerce_myaccount_page_id' ) ) ?>">
								<?php do_action( 'woocommerce_login_form_start' ); ?>
								<p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide woocommerce-form-username">
									<label for="username"><?php esc_html_e( 'Username or email address', 'orfarm' ); ?>
										&nbsp;<span class="required">*</span></label>
									<span class="woocommerce-input-style">
										<svg width="15" height="16" viewBox="0 0 15 16" fill="none" xmlns="http://www.w3.org/2000/svg">
											<path fill-rule="evenodd" clip-rule="evenodd" d="M7.50009 4.71731C6.52035 4.71731 5.73498 5.51368 5.73498 6.49605C5.73498 7.44433 6.47007 8.2175 7.40148 8.26665C7.46564 8.26136 7.53406 8.26089 7.60052 8.26655C8.52792 8.21661 9.25911 7.44644 9.2652 6.49456C9.2644 5.51392 8.4734 4.71731 7.50009 4.71731ZM4.68848 6.49605C4.68848 4.93335 5.94031 3.66272 7.50009 3.66272C9.05186 3.66272 10.3117 4.9323 10.3117 6.49605V6.49903H10.3117C10.3032 8.02352 9.11323 9.27012 7.60164 9.32205C7.57094 9.32311 7.54022 9.32143 7.50981 9.31706C7.51282 9.31749 7.51341 9.31745 7.51147 9.31733C7.50967 9.31721 7.50667 9.31708 7.50271 9.31708C7.49413 9.31708 7.48622 9.31766 7.48127 9.31829C7.45384 9.32174 7.42618 9.323 7.39854 9.32205C5.88959 9.27021 4.68848 8.02554 4.68848 6.49605Z" fill="#ACAFB7"/>
											<path fill-rule="evenodd" clip-rule="evenodd" d="M4.32484 12.0599C3.7875 12.4246 3.48714 12.8419 3.3701 13.2386C4.4907 14.1842 5.92732 14.7501 7.50146 14.7501C9.07561 14.7501 10.5122 14.1842 11.6328 13.2386C11.5157 12.8417 11.2152 12.4242 10.6773 12.0594C9.83301 11.4902 8.6849 11.1891 7.5067 11.1891C6.329 11.1891 5.17688 11.49 4.32484 12.0599ZM7.5067 10.1345C8.84335 10.1345 10.2066 10.473 11.2599 11.1833L11.261 11.184C12.1001 11.753 12.6339 12.5252 12.7241 13.3796C12.7417 13.5461 12.6797 13.7112 12.5572 13.8243C11.2227 15.0557 9.45139 15.8047 7.50146 15.8047C5.55154 15.8047 3.78023 15.0557 2.44576 13.8243C2.3232 13.7112 2.26124 13.5461 2.27882 13.3796C2.36901 12.5252 2.90283 11.753 3.7419 11.184L3.7445 11.1823L3.74451 11.1823C4.80397 10.4731 6.16988 10.1345 7.5067 10.1345Z" fill="#ACAFB7"/>
											<path fill-rule="evenodd" clip-rule="evenodd" d="M7.5 1.74343C3.93584 1.74343 1.04651 4.65505 1.04651 8.24672C1.04651 11.8384 3.93584 14.75 7.5 14.75C11.0642 14.75 13.9535 11.8384 13.9535 8.24672C13.9535 4.65505 11.0642 1.74343 7.5 1.74343ZM0 8.24672C0 4.07262 3.35786 0.688843 7.5 0.688843C11.6421 0.688843 15 4.07262 15 8.24672C15 12.4208 11.6421 15.8046 7.5 15.8046C3.35786 15.8046 0 12.4208 0 8.24672Z" fill="#ACAFB7"/>
										</svg>
										<input type="text" placeholder="Your username or email" class="woocommerce-Input woocommerce-Input--text input-text"
											name="username" id="username"
											value="<?php echo ( ! empty( $_POST['username'] ) ) ? esc_attr( wp_unslash( $_POST['username'] ) ) : ''; ?>"/><?php // @codingStandardsIgnoreLine ?>
									</span>	
								</p>
								<p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide woocommerce-form-password">
									<label for="password"><?php esc_html_e( 'Password', 'orfarm' ); ?>&nbsp;<span
												class="required">*</span></label>
									<span class="woocommerce-input-style">
										<svg width="15" height="16" viewBox="0 0 15 16" fill="none" xmlns="http://www.w3.org/2000/svg">
										<path fill-rule="evenodd" clip-rule="evenodd" d="M4.63938 1.89614C4.16687 2.45615 4 3.27128 4 4.29605V5.56896C4 5.83258 3.77614 6.0463 3.5 6.0463C3.22386 6.0463 3 5.83258 3 5.56896V4.29605C3 3.21417 3.16646 2.11994 3.86062 1.29726C4.57359 0.452272 5.74776 0 7.5 0C9.25224 0 10.4264 0.452272 11.1394 1.29726C11.8335 2.11994 12 3.21417 12 4.29605V5.56896C12 5.83258 11.7761 6.0463 11.5 6.0463C11.2239 6.0463 11 5.83258 11 5.56896V4.29605C11 3.27128 10.8331 2.45615 10.3606 1.89614C9.90692 1.35843 9.08109 0.954678 7.5 0.954678C5.91891 0.954678 5.09308 1.35843 4.63938 1.89614Z" fill="#ACAFB7"/>
										<path fill-rule="evenodd" clip-rule="evenodd" d="M7.50006 9.0284C6.84407 9.0284 6.31228 9.56429 6.31228 10.2253C6.31228 10.8864 6.84407 11.4223 7.50006 11.4223C8.15605 11.4223 8.68784 10.8864 8.68784 10.2253C8.68784 9.56429 8.15605 9.0284 7.50006 9.0284ZM5.29419 10.2253C5.29419 8.99767 6.28179 8.00244 7.50006 8.00244C8.71833 8.00244 9.70593 8.99767 9.70593 10.2253C9.70593 11.453 8.71833 12.4482 7.50006 12.4482C6.28179 12.4482 5.29419 11.453 5.29419 10.2253Z" fill="#ACAFB7"/>
										<path fill-rule="evenodd" clip-rule="evenodd" d="M1.59093 6.98706C1.23407 7.35764 1.04651 8.04796 1.04651 9.50084V10.9498C1.04651 12.4027 1.23407 13.093 1.59093 13.4636C1.94778 13.8342 2.61254 14.029 4.01163 14.029H10.9884C12.3875 14.029 13.0522 13.8342 13.4091 13.4636C13.7659 13.093 13.9535 12.4027 13.9535 10.9498V9.50084C13.9535 8.04796 13.7659 7.35764 13.4091 6.98706C13.0522 6.61648 12.3875 6.42171 10.9884 6.42171H4.01163C2.61254 6.42171 1.94778 6.61648 1.59093 6.98706ZM0.850932 6.21861C1.54059 5.50244 2.62002 5.33496 4.01163 5.33496H10.9884C12.38 5.33496 13.4594 5.50244 14.1491 6.21861C14.8387 6.93479 15 8.05572 15 9.50084V10.9498C15 12.395 14.8387 13.5159 14.1491 14.2321C13.4594 14.9482 12.38 15.1157 10.9884 15.1157H4.01163C2.62002 15.1157 1.54059 14.9482 0.850932 14.2321C0.161277 13.5159 0 12.395 0 10.9498V9.50084C0 8.05572 0.161277 6.93479 0.850932 6.21861Z" fill="#ACAFB7"/>
										</svg>				
										<input class="woocommerce-Input woocommerce-Input--text input-text" placeholder="Password" type="password"
										   name="password" id="password" autocomplete="current-password"/>
									<span>
								</p>
								<?php do_action( 'woocommerce_login_form' ); ?>
								<div class="box-password">
									<p>
										<label class="woocommerce-form__label woocommerce-form__label-for-checkbox inline">
											<input class="woocommerce-form__input woocommerce-form__input-checkbox"
												   name="rememberme" type="checkbox" id="rememberme" value="forever"/>
											<span><?php esc_html_e( 'Remember me', 'orfarm' ); ?></span>
										</label>
									</p>
									<a href="<?php echo esc_url( wp_lostpassword_url() ); ?>"
									   class="lost-password"><?php esc_html_e( 'Lost password ?', 'orfarm' ); ?></a>
								</div>
								<p class="login-submit">
									<?php wp_nonce_field( 'woocommerce-login', 'woocommerce-login-nonce' ); ?>
									<button type="submit" class="woocommerce-Button button" name="login"
											value="<?php esc_attr_e( 'Log in', 'orfarm' ); ?>"><?php esc_html_e( 'Log in', 'orfarm' ); ?></button>
								</p>
								<?php do_action( 'woocommerce_login_form_end' ); ?>
								<div class="login_info">
									<?php if (!empty($orfarm_opt['popup_login_info'])) {
											echo html_entity_decode($orfarm_opt['popup_login_info']); 
									  } ?> 
								</div>
					</form>
				</div>
				<?php } ?>
		</div>
		<?php 	if ( !is_user_logged_in() ) { ?>
		<div id="register_form" class="tabcontent">
			<div id="register-form" >
				<form id="popup-form-register" method="post" autocomplete="off"
					  class="woocommerce-form woocommerce-form-register rt-tab-panel register"
					  data-tab-name="register" <?php do_action( 'woocommerce_register_form_tag' ); ?>
					  action="<?php echo get_permalink( get_option( 'woocommerce_myaccount_page_id' ) ) ?>">	
					<?php do_action( 'woocommerce_register_form_start' ); ?>
					<?php if ( 'no' === get_option( 'woocommerce_registration_generate_username' ) ) : ?>
						<p class="woocommerce-form-row woocommerce-form-row--wide form-row-wide">
							<label for="reg_username"><?php esc_html_e( 'Username', 'orfarm' ); ?>
								&nbsp;<span class="required">*</span></label>
							<input type="text" class="woocommerce-Input woocommerce-Input--text input-text"
								   name="username" id="reg_username" autocomplete="username"
								   value="<?php echo ( ! empty( $_POST['username'] ) ) ? esc_attr( wp_unslash( $_POST['username'] ) ) : ''; ?>"/><?php // @codingStandardsIgnoreLine ?>
						</p>
					<?php endif; ?>
					<p class="woocommerce-form-row woocommerce-form-row--wide form-row-wide woocommerce-email-address">
						<label for="reg_email"><?php esc_html_e( 'Email address', 'orfarm' ); ?>
							&nbsp;<span class="required">*</span></label>
						
						<span class="woocommerce-input-style">
							<svg width="15" height="16" viewBox="0 0 15 16" fill="none" xmlns="http://www.w3.org/2000/svg">
								<path fill-rule="evenodd" clip-rule="evenodd" d="M7.50009 4.71731C6.52035 4.71731 5.73498 5.51368 5.73498 6.49605C5.73498 7.44433 6.47007 8.2175 7.40148 8.26665C7.46564 8.26136 7.53406 8.26089 7.60052 8.26655C8.52792 8.21661 9.25911 7.44644 9.2652 6.49456C9.2644 5.51392 8.4734 4.71731 7.50009 4.71731ZM4.68848 6.49605C4.68848 4.93335 5.94031 3.66272 7.50009 3.66272C9.05186 3.66272 10.3117 4.9323 10.3117 6.49605V6.49903H10.3117C10.3032 8.02352 9.11323 9.27012 7.60164 9.32205C7.57094 9.32311 7.54022 9.32143 7.50981 9.31706C7.51282 9.31749 7.51341 9.31745 7.51147 9.31733C7.50967 9.31721 7.50667 9.31708 7.50271 9.31708C7.49413 9.31708 7.48622 9.31766 7.48127 9.31829C7.45384 9.32174 7.42618 9.323 7.39854 9.32205C5.88959 9.27021 4.68848 8.02554 4.68848 6.49605Z" fill="#ACAFB7"/>
								<path fill-rule="evenodd" clip-rule="evenodd" d="M4.32484 12.0599C3.7875 12.4246 3.48714 12.8419 3.3701 13.2386C4.4907 14.1842 5.92732 14.7501 7.50146 14.7501C9.07561 14.7501 10.5122 14.1842 11.6328 13.2386C11.5157 12.8417 11.2152 12.4242 10.6773 12.0594C9.83301 11.4902 8.6849 11.1891 7.5067 11.1891C6.329 11.1891 5.17688 11.49 4.32484 12.0599ZM7.5067 10.1345C8.84335 10.1345 10.2066 10.473 11.2599 11.1833L11.261 11.184C12.1001 11.753 12.6339 12.5252 12.7241 13.3796C12.7417 13.5461 12.6797 13.7112 12.5572 13.8243C11.2227 15.0557 9.45139 15.8047 7.50146 15.8047C5.55154 15.8047 3.78023 15.0557 2.44576 13.8243C2.3232 13.7112 2.26124 13.5461 2.27882 13.3796C2.36901 12.5252 2.90283 11.753 3.7419 11.184L3.7445 11.1823L3.74451 11.1823C4.80397 10.4731 6.16988 10.1345 7.5067 10.1345Z" fill="#ACAFB7"/>
								<path fill-rule="evenodd" clip-rule="evenodd" d="M7.5 1.74343C3.93584 1.74343 1.04651 4.65505 1.04651 8.24672C1.04651 11.8384 3.93584 14.75 7.5 14.75C11.0642 14.75 13.9535 11.8384 13.9535 8.24672C13.9535 4.65505 11.0642 1.74343 7.5 1.74343ZM0 8.24672C0 4.07262 3.35786 0.688843 7.5 0.688843C11.6421 0.688843 15 4.07262 15 8.24672C15 12.4208 11.6421 15.8046 7.5 15.8046C3.35786 15.8046 0 12.4208 0 8.24672Z" fill="#ACAFB7"/>
							</svg>		
							<input type="email" placeholder="Email address" class="woocommerce-Input woocommerce-Input--text input-text"
							   name="email" id="reg_email" autocomplete="email"
							   value="<?php echo ( ! empty( $_POST['email'] ) ) ? esc_attr( wp_unslash( $_POST['email'] ) ) : ''; ?>"/><?php // @codingStandardsIgnoreLine ?>
						</span>
					</p>
					<?php if ( 'no' === get_option( 'woocommerce_registration_generate_password' ) ) : ?>
						<p class="woocommerce-form-row woocommerce-form-row--wide form-row-wide">
							<label for="reg_password"><?php esc_html_e( 'Password', 'orfarm' ); ?>
								&nbsp;<span class="required">*</span></label>
							<input type="password"
								   class="woocommerce-Input woocommerce-Input--text input-text"
								   name="password" id="reg_password" autocomplete="new-password"/>
						</p>
					<?php else : ?>
						<p><?php esc_html_e( 'A password will be sent to your email address.', 'orfarm' ); ?></p>
					<?php endif; ?>
					<?php do_action( 'woocommerce_register_form' ); ?>
					<p class="woocommerce-FormRow">
						<?php wp_nonce_field( 'woocommerce-register', 'woocommerce-register-nonce' ); ?>
						<button type="submit" class="woocommerce-Button button" name="register"
								value="<?php esc_attr_e( 'Register', 'orfarm' ); ?>"><?php esc_html_e( 'Register', 'orfarm' ); ?></button>
					</p>
					<?php do_action( 'woocommerce_register_form_end' ); ?>
					<div class="login_info">
						<?php if (!empty($orfarm_opt['popup_login_info'])) {
								echo html_entity_decode($orfarm_opt['popup_login_info']); 
						  } ?> 
					</div>
				</form>
			</div>	
		</div>
		<?php } ?>
	</div>
  <?php 	
}

add_action( 'wp_ajax_orfarm_save_purchased_code', 'orfarm_save_purchased_code' );
add_action( 'wp_ajax_nopriv_orfarm_save_purchased_code', 'orfarm_save_purchased_code' );
function orfarm_save_purchased_code() {
	
	$code = sanitize_text_field($_POST['code']);
	if($code == 'bluesky-techo') {
		update_option( 'envato_purchase_code_orfarm', $code );
	} else {
		$item_id = sanitize_text_field($_POST['item_id']);
		update_option( 'envato_purchase_code_' . $item_id, $code );
		update_option( 'envato_purchase_code_orfarm', $code );
	}
	die('1');
} 

// new page to submit purchase code
add_action('admin_menu', 'orfarm_admin_menu');
function orfarm_admin_menu() {
	$menu = add_theme_page( 'Orfarm theme verify', 'Orfarm theme verify', 'manage_options', 'orfarm_theme_verify', 'orfarm_theme_verify_page' );
	add_action('admin_print_scripts-' . $menu, 'orfarm_theme_verify_script' );
}

// show notice in dashboard
add_action( 'admin_notices', 'orfarm_admin_notice' );
function orfarm_admin_notice() {
	$code = get_option( 'envato_purchase_code_orfarm' );
	if (!$code) {
		?>
		<div class="notice notice-error">
			<p><?php echo sprintf(wp_kses(__( 'You did not register theme purchase code yet! Please search on youtube tutorial video to see how to get purchase code on themeforest.net then register it in <a href="%s">here</a>', 'orfarm' ), array('a'=> array('href' => array()))), admin_url('admin.php?page=orfarm_theme_verify')); ?></p>
		</div>
		<?php
	}
}

// custom js in admin
function orfarm_theme_verify_script() {
	wp_enqueue_script( 'orfarm-theme-verify', get_template_directory_uri() . '/js/theme-verify.js', array('jquery'), filemtime( get_template_directory() . '/js/theme-verify.js'), true );
} 

// verify page content
function orfarm_theme_verify_page() {
	if ( !current_user_can( 'manage_options' ) )  {
		wp_die( esc_html__( 'You do not have sufficient permissions to access this page.', 'orfarm' ) );
	}
	$code = get_option( 'envato_purchase_code_orfarm' );
	?>
	<div id="theme-verify" class="wrap">
		<h1><?php _ex( 'Orfarm theme puchased code verify', 'title of the main page', 'orfarm' ); ?></h1>
		<p><?php echo esc_html__('From May 2021, you must verify purchased code in here to ensure you are buyer of Orfarm theme item on Themeforest market', 'orfarm'); ?></p>
		<div class="orfarm-verify">
		<table class="form-table">
			<tr>
				<th class="row">
					<?php echo esc_html__('Purchased code:', 'orfarm') ?>
				</th>
				<td>
					<p class="correct<?php echo esc_attr(($code) ? ' show': ''); ?>"><?php echo esc_html__('Your purchased code is correct, you can continue use Orfarm theme', 'orfarm') ?></p>
					<input type="text" id="purchased_code" value="<?php echo esc_attr($code) ?>" />
					<p class="incorrect"><?php echo esc_html__('Incorrect purchase code, please check again!', 'orfarm') ?></p>
				<td>
			</tr>
		</table>
		<p class="submit">
			<input id="orfarm-submit-code" type="button" class="button button-primary" value="<?php echo esc_attr__('Save', 'orfarm') ?>" /> 
			<img width="24" height="24" class="loading" src="<?php echo get_template_directory_uri() . '/images/loading.gif'; ?>" alt="<?php echo esc_attr__('Loading', 'orfarm') ?>"/>
		</p>
		</div>
	</div>
	<?php
}
//add mobile menu
add_action( 'wp_footer', 'mobile_menu');
function mobile_menu(){
	global $orfarm_opt;
	$custom_page = orfarm_get_page_custom_configs();
	?>
	<div class="mobile-menu-overlay"></div>
	<div class="mobile-navigation hidden-md hidden-lg">
		<div id="close-menu-moblie"><a href="#"><?php echo esc_html__('Close', 'orfarm') ?><i class="icon-x"></i></a></div>
		<?php if(class_exists('WC_Widget_Product_Search')) { ?>	
			<?php get_template_part('template-parts/search/advance'); ?>
			<?php } ?>
			
				<div class="tab">
				  <button class="tablinks active" onclick="openTab(event, 'mobile-megamenu')"><?php echo esc_html__('Menu', 'orfarm') ?></button>
				  <button class="tablinks" onclick="openTab(event, 'mobile-categories')"><?php echo esc_html__('Categories', 'orfarm') ?></button>
				</div>

				<div style="display:block" id="mobile-megamenu" class="tabcontent">
					<?php if(has_nav_menu( 'mobilemenu' )){ ?>
						<?php
							$megamenu = new MegamenuLocation();			
							$megamenu->megamenu_mobile();  
						?> 
					<?php } else { ?>
					    <span class="empty-menu"><?php echo esc_html__('Please assign your mobilemenu menu to mobilemenu location', 'orfarm') ?></span>
						<?php } ?>		
				</div>

				<div style="display:none" id="mobile-categories" class="tabcontent">
					<?php if(has_nav_menu( 'categories' )){ ?>
						<?php
							$megamenu = new MegamenuLocation();			
							$megamenu->categories_mobile();  
						?> 
					<?php } else { ?>
					    <span class="empty-menu"><?php echo esc_html__('Please assign your categories menu to categories location', 'orfarm') ?></span>
					<?php } ?>		
				</div>
	
			<div class="my-account-link">							
				<?php if(is_user_logged_in()){ ?>
					<a href="<?php echo get_permalink( get_option('woocommerce_myaccount_page_id') ); ?>" title="<?php esc_attr__('My account','orfarm'); ?>"><?php esc_html_e('My account','orfarm'); ?><i class="icon-user icons"></i></a>
				<?php }else{ ?>
					<a href="<?php echo get_permalink( get_option('woocommerce_myaccount_page_id') ); ?>" title="<?php esc_attr__('Login / Register','orfarm'); ?>"><?php esc_html_e('Login / Register','orfarm'); ?><i class="icon-user icons"></i></a>
				<?php } ?>
			</div>	
			<?php if(class_exists('YITH_WCWL')){ ?>
				<div class="wishlist-link">
					<a href="<?php echo get_permalink(get_option('yith_wcwl_wishlist_page_id')); ?>">
						<?php esc_html_e('Wishlist','orfarm'); ?><i class="icon-heart"></i>
					</a>
				</div>
			<?php } ?>
			<?php if(is_active_sidebar('top_header')){ ?>
				<div class="header-top-setting visible-sm visible-xs">						
					<?php if (is_active_sidebar('top_header')) { ?> 
						<a href="#"> <?php esc_html_e('More options','orfarm'); ?><i class="icon-plus"></i></a>
						<div class="setting-container">
							<?php dynamic_sidebar('top_header'); ?> 
						</div>
					<?php } ?>			
				</div>
			<?php } ?>				
	</div>
	<?php 
	
}
// move form comment to below email
function orfarm_move_comment_field_to_bottom( $fields ) {
$comment_field = $fields['comment'];
unset( $fields['comment'] );
$fields['comment'] = $comment_field;
return $fields;
}
add_filter( 'comment_form_fields', 'orfarm_move_comment_field_to_bottom' );

//add diev outsite input wrapper on comment area
function orfarm_comment_form_before_fields() {
    echo '<div class="form-area row">';
}
add_action('comment_form_before_fields', 'orfarm_comment_form_before_fields');

function orfarm_comment_form_after_fields() {
    echo '</div>';
}
add_action('comment_form_after_fields', 'orfarm_comment_form_after_fields');

function orfarm_opt_by_home() { 
	global $wp_query; 
	$orfarm_opt = get_option('orfarm_opt');
	$slug_page = null;
	if( is_front_page() ) {
		if(isset( $orfarm_opt['home_default'] )) { 
	        $slug_page = $orfarm_opt['home_default'];
		    $orfarm_opt = get_option('orfarm_opt_'.$slug_page); 
		}
		if( isset($orfarm_opt['home_default']) && $orfarm_opt['home_default'] == 'default' || $slug_page == 'default') { 
			$orfarm_opt = get_option( 'orfarm_opt' );
		}	
	}else {
	
		if($wp_query->post->post_name) {
		if(get_option('orfarm_opt_'.$wp_query->post->post_name) == false )  {
			     $orfarm_opt = get_option( 'orfarm_opt' );
			     $slug_page = $orfarm_opt['home_default'];
			 } else {
				$slug_page = $wp_query->post->post_name;
			 }
			$orfarm_opt = get_option('orfarm_opt_'.$slug_page);  
			if($slug_page == 'default') $orfarm_opt = get_option( 'orfarm_opt' );
		}
	}
  return $orfarm_opt; 
}