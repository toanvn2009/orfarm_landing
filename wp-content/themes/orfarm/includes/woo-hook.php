<?php
// Share function
function orfarm_get_shop_sidebar() {
	$orfarm_opt = get_option( 'orfarm_opt' );
	$shopsidebar = is_active_sidebar('shop') ? 'left' : 'none';
	if(!empty($orfarm_opt['sidebarshop_pos']) && is_active_sidebar('shop')) $shopsidebar = $orfarm_opt['sidebarshop_pos'];
	if(isset($_GET['side']) && is_active_sidebar('shop')) $shopsidebar = $_GET['side'];
	return $shopsidebar;
}
function orfarm_get_shop_viewmode() {
	$orfarm_opt = get_option( 'orfarm_opt' );
	$orfarm_viewmode = 'col4-view';
	if(!empty($orfarm_opt['default_view'])) {
		$orfarm_viewmode = $orfarm_opt['default_view'];
	}
	if(!empty($_GET['view'])) {
		$orfarm_viewmode = $_GET['view'] . '-view';
	}
	return $orfarm_viewmode;
}
function orfarm_get_shop_pagination_mode() {
	$orfarm_opt = get_option( 'orfarm_opt' );
	$pagination_mode = '';
	if(!empty($orfarm_opt['enable_loadmore'])) {
		$pagination_mode = $orfarm_opt['enable_loadmore'];
	}
	if(!empty($_GET['mode'])) {
		$pagination_mode = $_GET['mode'] . '-more';
		if ($_GET['mode'] == 'none' ) $pagination_mode = '';
	}
	return $pagination_mode;
}
//WooCommerce Hook

//add cart total before cross sell
remove_action('woocommerce_cart_collaterals', 'woocommerce_cross_sell_display');
add_action('woocommerce_cart_collaterals', 'woocommerce_cross_sell_display', 20);

add_action( 'woocommerce_before_main_content', 'orfarm_woocommerce_category_image', 2 );
//add_action( 'woocommerce_breadcrumb', 'orfarm_woocommerce_sub_category', 3 );

//remove product link before - after product inner
remove_action( 'woocommerce_before_shop_loop_item', 'woocommerce_template_loop_product_link_open', 10 );
remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_product_link_close', 5 );
remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10 );
remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart' );
remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20 );
add_action( 'orfarm_before_main_product_content', 'woocommerce_breadcrumb', 20 );
remove_action('woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail', 10);

// change ul tag to div tag validate w3c
add_filter('woocommerce_before_widget_product_list', 'orfarm_before_widget_product_list');
add_filter('woocommerce_after_widget_product_list', 'orfarm_after_widget_product_list');
function orfarm_before_widget_product_list(){
	return '<div class="product_list_widget">';
}
function orfarm_after_widget_product_list(){
	return '</div>';
}

// shop toolbar
add_action('woocommerce_before_shop_loop', 'orfarm_shop_toolbar_view_mode', 25);
function orfarm_shop_toolbar_view_mode() { 
	$orfarm_viewmode = orfarm_get_shop_viewmode();
	$link_shop = "";
	if ( is_post_type_archive( 'product' ) || is_page( wc_get_page_id( 'shop' ) ) || is_shop() ) {
	    $link_shop = get_permalink( wc_get_page_id( 'shop' ) );
	}
	
	$viewModes = array ( 
		'col2-view' => array(
		    'name' =>'Two Columns View',
			'icon' =>'cols2-icon'
		),
		'col3-view' => array(
		    'name' =>'Three Columns View',
			'icon' =>'cols3-icon'
		),
		'col4-view' => array(
		    'name' =>'Four Columns View',
			'icon' =>'cols4-icon'
		),
		'col5-view' => array(
		    'name' =>'Five Columns View',
			'icon' =>'cols5-icon'
		),
		'list-view' => array(
		    'name' =>'List View',
			'icon' =>'list-icon'
		)

	);
	?>
	<div class="view-mode">
		<?php foreach($viewModes as $key => $viewMode) { 
				  if($key == 'list-view') {	
					$link = $link_shop.'?view_mode='.$key; 
				  } else {
					  $link = $link_shop.'?view_mode=grid-view&column='.$key;
				  }
		?>
		          <a data-toggle="tooltip" href="<?php echo esc_url($link) ;?>" data-mode="<?php echo esc_attr($key); ?>" class="<?php if( isset( $_GET['view_mode'] ) && $_GET['view_mode']== $key || $_GET['column'] == $key){ echo 'active';} ?> <?php if( $orfarm_viewmode == $key && !isset($_GET['view_mode'])) { echo esc_attr('is_default active'); } ?>" title="<?php echo esc_attr($viewMode['name']); ?>"><i class="<?php echo esc_attr($viewMode['icon']);?>"></i></a>
		<?php } ?>
	</div> 
<?php }

// custom shop action & filter 
remove_action('woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30);
add_action('woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 40);
add_action('woocommerce_before_shop_loop', 'orfarm_shop_toolbar_filter_widgets', 1);
function orfarm_shop_toolbar_filter_widgets() {
    $orfarm_opt = get_option( 'orfarm_opt' );
    $shopsidebar = 'none';
    if(!empty($orfarm_opt['sidebarshop_pos'])) $shopsidebar = $orfarm_opt['sidebarshop_pos'];
	if(isset($_GET['side'])) $shopsidebar = $_GET['side'];
    if ($shopsidebar == 'canvas' || $shopsidebar == 'shop-filters-left') {
        if (is_active_sidebar('shop')) {
            echo '<div class="shop-filters">';
                echo '<a class="toggle-filter" href="javascript:void(0)">'. esc_html__('Filter', 'orfarm') .'</a>';
            echo '</div>';
        }
	}
    if ($shopsidebar == 'shop-filters-v2' || $shopsidebar == 'shop-filters') {
        if (is_active_sidebar('shopfilter')) {
            echo '<div class="shop-filters">';
            if ($shopsidebar == 'shop-filters') {
                echo '<a class="toggle-filter" href="javascript:void(0)">'. esc_html__('Filter', 'orfarm') .'</a>';
            }
                echo '<div class="filter-content">';
                    echo '<div class="filter-content-inner">';
                        dynamic_sidebar('shopfilter');
                    echo '</div>';
                echo '</div>';
            echo '</div>';
        }
    }
}

// woocommerce breadcrumb
add_filter( 'woocommerce_breadcrumb_defaults', 'orfarm_woocommerce_breadcrumbs' );
function orfarm_woocommerce_breadcrumbs() {
	 
    return array(
            'delimiter'   => '',
            'wrap_before' => '<div class="breadcrumbs circle-style" itemprop="breadcrumb">',
            'wrap_after'  => '</div>',
            'before'      => '',
            'after'       => '',
            'home'        => esc_html__('Home', 'orfarm'),
        );
}
// hook to custom thumbnail for categories list
remove_action( 'woocommerce_before_subcategory_title', 'woocommerce_subcategory_thumbnail', 10 );
add_action('woocommerce_before_subcategory_title', 'orfarm_subcategory_thumbnail', 10);
function orfarm_subcategory_thumbnail($category){
	$image = get_term_meta($category->term_id, '_square_image');
	if ( !empty($image[0]) ) {
		echo '<img src="' . esc_url($image[0]) . '" alt="'. esc_attr($category->name) .'" />';
	}else{
		woocommerce_subcategory_thumbnail( $category );
	}
	return;
}

// Add image to category description
function orfarm_woocommerce_category_image() {
	$orfarm_opt = get_option( 'orfarm_opt' );
	
	$page_title_layout = "";
	$page_title_size = "";
	$page_title_tag = 'h1';
	$page_title_color = '';
	if(isset($orfarm_opt['page_title_layout'])) { $page_title_layout =  $orfarm_opt['page_title_layout']; }
	if(isset($orfarm_opt['page_title_size'])) { $page_title_size =  $orfarm_opt['page_title_size']; }
	if(isset($orfarm_opt['page_title_tag'])) { $page_title_tag =  $orfarm_opt['page_title_tag']; }
	if(isset($orfarm_opt['page_title_color'])) { $page_title_color =  $orfarm_opt['page_title_color']; }
	if ( is_product_category() ){
		global $wp_query;
		
		$cat = $wp_query->get_queried_object();
		$thumbnail_id = get_term_meta( $cat->term_id, 'thumbnail_id', true );
		$image = wp_get_attachment_url( $thumbnail_id );
		
		if ( $image ) {
			echo '<div class="page-banner category-banner" style="background-image: url(' . esc_url($image) . '); height: 40vh">';
				echo '<div class="page-banner-content">';
				echo '<h1 class="category-title entry-title">'. $cat->name .'</h1>';
				woocommerce_breadcrumb();
			echo '</div></div>';
		}else{
			echo '<div class="container default-entry-header">';
			echo '<h1 class="category-title entry-title simple-title">'. $cat->name .'</h1>';
			woocommerce_breadcrumb();
			echo '</div>';
		}
	} elseif (is_shop()) {
		$shop = get_option( 'woocommerce_shop_page_id' );
		$lionthemes_banner = '';
		if(get_post_meta( $shop, 'lionthemes_page_banner', true )){
			$lionthemes_banner = get_post_meta( $shop, 'lionthemes_page_banner', true );
		}
		$sub_page_h = get_post_meta( $shop, 'lionthemes_sub_page_heading', true );
		$page_h = get_post_meta( $shop, 'lionthemes_page_heading', true );
		$banner_h = intval(get_post_meta( $shop, 'lionthemes_page_banner_height', true ));
		$page_heading = ($page_h) ? $page_h : get_the_title($shop);
		if($page_title_tag == 'default') $page_title_tag = 'h1';
		
		if ($lionthemes_banner) {
			echo '<div class="page-banner shop-banner" style="background-image: url('. esc_url($lionthemes_banner) .'); min-height: '. $banner_h .'px;">';
			echo '<div class="page-banner-content container">
				<'.$page_title_tag.' class="entry-title">'. $page_heading .'</'.$page_title_tag.'>';
				if ($orfarm_opt['page_breadcrumb'] == 1)  {
					echo woocommerce_breadcrumb();
				}
			echo '</div></div>';
		} else {
			echo '<div class="default-entry-header '.$page_title_layout.' '.$page_title_size.' '.$page_title_color.' ">';
			    echo '<div class="container">';
			if ($orfarm_opt['page_breadcrumb'] == 1)  {
					echo woocommerce_breadcrumb();
			}
			
			if( isset( $orfarm_opt['enable_shop_title'] ) && $orfarm_opt['enable_shop_title'] == 1 ) {
				echo '<'.$page_title_tag.' class="entry-title">'. $page_heading .'</'.$page_title_tag.'>';
			}
			//orfarm_woocommerce_sub_category(); 
			    echo '</div>'; 
			echo '</div>';
		}		
	}
}

// Add sub category description
function orfarm_woocommerce_sub_category() {
	$orfarm_opt = get_option( 'orfarm_opt' );
	if( isset( $orfarm_opt['enable_shop_cate'] ) && $orfarm_opt['enable_shop_cate'] == 0 ) return; 
    $args = array(
        'taxonomy' => 'product_cat'
    );
    $categories = get_categories( $args );
    if (count($categories) > 0) {
        echo '<ul class="sub-category">';
        foreach ($categories as $category) { 
            echo '<li><a href="' . get_category_link( $category->term_id ) . '" title="' . $category->name . '" ' . '>' . $category->name.'</a> </li> ';
        }
        echo '</ul>';
    }
}

// hook on header icons
add_action('orfarm_header_badges', 'orfarm_wishlist_icon_counter', 20);
function orfarm_wishlist_icon_counter() {
	if (class_exists('YITH_WCWL')) {
		?>
		<div class="wl-icon-wrapper">
			<a title="<?php echo esc_attr__('View wishlist', 'orfarm'); ?>" href="<?php echo YITH_WCWL()->get_wishlist_url(); ?>">
				<span class="wl-icon"><span class="icon-heart icons"></span></span>
				<span class="wl-count qty-count"><?php echo YITH_WCWL()->count_all_products(); ?></span>
				<div class="wl-text">
					<span class="text1">Favorite</span>
					<a href="<?php echo YITH_WCWL()->get_wishlist_url(); ?>" class="text2">My Wishlist</a>
				</div>
			</a>
		</div>
		<?php
	}
}
add_action('orfarm_header_badges', 'orfarm_cart_icon_counter', 30);
function orfarm_cart_icon_counter() {
	$orfarm_opt = get_option( 'orfarm_opt' );
	$canshow = isset($aorfarm_opt['show_minicart']) ? $aorfarm_opt['show_minicart'] : true;
	if (class_exists('WooCommerce') && $canshow && !is_cart() && !is_checkout()) {
		$qty = WC()->cart->get_cart_contents_count();
		?>
		<div class="topcart">
			<a class="cart-toggler toggle-cartside" href="javascript:void(0)">
				<span class="content-cart">
					<span class="my-cart">
					<svg width="16" height="16" viewBox="0 0 14 16" fill="none" xmlns="http://www.w3.org/2000/svg">
					<path fill-rule="evenodd" clip-rule="evenodd" d="M4.39173 4.12764C4.44388 2.94637 5.40766 2.00487 6.58894 2.00487H7.38873C8.57131 2.00487 9.53591 2.94846 9.5861 4.13155C7.78094 4.36058 6.15509 4.35461 4.39173 4.12764ZM3.18982 5.16767L3.18982 7.73151C3.18982 8.06644 3.45838 8.33795 3.78966 8.33795C4.12095 8.33795 4.38951 8.06644 4.38951 7.73152L4.38951 5.33644C6.14735 5.55157 7.79071 5.55699 9.58815 5.34012V7.86711C9.58815 8.20204 9.85671 8.47355 10.188 8.47355C10.5193 8.47355 10.7878 8.20204 10.7878 7.86711V5.17238C12.0268 5.06423 13.025 6.16508 12.7509 7.30009L12.0455 10.2203C11.9677 10.5424 12.1657 10.8665 12.4877 10.9443C12.8098 11.022 13.1339 10.824 13.2116 10.502L13.917 7.58177C14.4003 5.58093 12.6964 3.86781 10.7784 3.97096C10.6482 2.19332 9.18032 0.791992 7.38873 0.791992H6.58894C4.79881 0.791992 3.33188 2.19103 3.19955 3.96661C1.28928 3.87048 -0.398284 5.57815 0.0829708 7.57053L1.49644 13.4223C1.80462 14.6981 2.9479 15.5959 4.26085 15.5959H9.74186C11.0548 15.5959 12.1981 14.6981 12.5063 13.4223C12.584 13.1003 12.3861 12.7761 12.064 12.6984C11.742 12.6206 11.4179 12.8186 11.3401 13.1406C11.1624 13.8764 10.5022 14.3962 9.74186 14.3962H4.26085C3.50047 14.3962 2.84032 13.8764 2.66259 13.1406L1.24911 7.28885C0.976309 6.15944 1.96169 5.06742 3.18982 5.16767Z" fill="#2D2A6E"/>
					</svg>
					</span>
					<span class="cart-total">
						<span class="text-cart"><?php echo esc_html__('My Cart', 'orfarm') ?></span>
						<span class="total-cart"><?php echo WC()->cart->get_cart_subtotal(); ?></span>
					</span>
					<span class="qty qty-count"><?php echo sprintf( _n( '%s', '%s', $qty, 'orfarm' ), $qty ); ?></span>
				</span>
			</a>
		</div>
		<?php
	}
}


// add cart content in footer
add_action('wp_footer', 'orfarm_cart_side_content');
function orfarm_cart_side_content()
{
	global $yith_woocompare;
	$orfarm_opt = get_option('orfarm_opt');
    $minicart_message_shipping = !empty($orfarm_opt['minicart_message_shipping'])
        ? '<div class="minicart-message">'.$orfarm_opt['minicart_message_shipping'].'</div>'
        : '';
	echo '<div class="cart-side-content">';
	if (class_exists('WooCommerce') && !empty($orfarm_opt['open_minicart']) && !empty($orfarm_opt['show_minicart']) && !is_cart() && !is_checkout()) {
		echo '<div class="cart-side-backdrop toggle-cartside"></div>';
		echo '<div class="cart-widget-content">';
		the_widget('WC_Widget_Cart', array('title' => esc_html__('Your Cart', 'orfarm')), array('before_title' => ''.$minicart_message_shipping.'<h2 class="widgettitle"><span>', 'after_title' => '</span><a href="javascript:void(0)" class="toggle-cartside"><i class="icon-x"></i></a></h2>'));
        echo '</div>';
	}
	echo '</div>';
	if (!empty($orfarm_opt['sticky_icons'])) {
		$sticky_icons = array_filter($orfarm_opt['sticky_icons']);
		if (count($sticky_icons)) {
			echo '<ul class="side-sticky-icons">';
			if (!empty($sticky_icons['home'])) echo '<li class="quick-compare"><a class="home-link" href="'. home_url( '/' ) .'"><span class="icon-home1 icons"></span></a></li>';
			if (!empty($sticky_icons['menu'])) echo '<li><a class="toggle-menu" href="javascript:void(0)"><span class="icon-menu icons"></span></a></li>';
			if (!empty($sticky_icons['cart']) && class_exists('WooCommerce') && !is_cart() && !is_checkout()) echo '<li class="quick-cart"><a class="toggle-cartside" href="javascript:void(0)"><span class="badge">' . WC()->cart->get_cart_contents_count() . '</span><svg width="22" height="24" viewBox="0 0 22 24" fill="none" xmlns="http://www.w3.org/2000/svg">
				<path fill-rule="evenodd" clip-rule="evenodd" d="M6.90128 5.24203C6.98308 3.38562 8.49765 1.90595 10.354 1.90595H11.6109C13.4693 1.90595 14.9852 3.38889 15.0639 5.24818C12.2272 5.60809 9.67227 5.5987 6.90128 5.24203ZM5.01258 6.87637L5.01257 10.905C5.01257 11.4313 5.43459 11.8579 5.95518 11.8579C6.47577 11.8579 6.8978 11.4313 6.8978 10.905L6.8978 7.14158C9.66012 7.47964 12.2425 7.48815 15.0671 7.14736V11.118C15.0671 11.6444 15.4891 12.071 16.0097 12.071C16.5303 12.071 16.9523 11.6444 16.9523 11.118V6.88377C18.8992 6.71382 20.4679 8.44373 20.0371 10.2273L18.9286 14.8163C18.8064 15.3223 19.1175 15.8316 19.6236 15.9539C20.1296 16.0761 20.6389 15.765 20.7612 15.2589L21.8696 10.67C22.6291 7.52579 19.9515 4.83374 16.9376 4.99582C16.733 2.20224 14.4263 0 11.6109 0H10.354C7.54088 0 5.23564 2.19865 5.02784 4.989C2.02599 4.83794 -0.625874 7.52141 0.130383 10.6523L2.35155 19.8479C2.83582 21.8528 4.63241 23.2635 6.69562 23.2635H15.3086C17.3718 23.2635 19.1684 21.8528 19.6527 19.8479C19.7749 19.3419 19.4638 18.8325 18.9578 18.7103C18.4517 18.5881 17.9424 18.8992 17.8202 19.4053C17.5409 20.5615 16.5035 21.3783 15.3086 21.3783H6.69562C5.50073 21.3783 4.46336 20.5615 4.18407 19.4052L1.96289 10.2097C1.5342 8.43487 3.08265 6.71883 5.01258 6.87637Z" fill="white"/>
				</svg></a></li>';
			if (!empty($sticky_icons['wishlist']) && class_exists('YITH_WCWL')) echo '<li class="quick-wishlist"><a href="' . YITH_WCWL()->get_wishlist_url() . '"><span class="badge">' . YITH_WCWL()->count_all_products() . '</span><span class="icon-heart icons"></span></a></li>';
			if (!empty($sticky_icons['account'])) echo '<li><a href="' . get_permalink(get_option('woocommerce_myaccount_page_id')) . '"><span class="icon-user icons"></span></a></li>';
			echo '</ul>';
		}
	}
}

// add search by category hook
add_action('pre_get_posts', 'orfarm_woo_search_pre_get_posts');
function orfarm_woo_search_pre_get_posts($query){
	
	if ( !$query->is_search ) return $query;
	
	if(!empty($_GET['cat']) && isset($_GET['post_type']) && $_GET['post_type'] == 'product'){
		$taxquery = array(
			array(
				'taxonomy' => 'product_cat',
				'field' => 'slug',
				'terms' => $_GET['cat']
			)
		);
		$query->set( 'tax_query', $taxquery );
	}
}

add_action( 'wp_ajax_orfarm_product_remove', 'orfarm_product_remove' );
add_action( 'wp_ajax_nopriv_orfarm_product_remove', 'orfarm_product_remove' );
function orfarm_product_remove(){
	$cart = WC()->instance()->cart;
	if(!empty($_POST['remove_item'])){
	   $cart->remove_cart_item($_POST['remove_item']);
	}
	$qty = WC()->cart->get_cart_contents_count();
	$subtotal = WC()->cart->get_cart_subtotal();
    echo json_encode(array(
			'qty'=> intval($qty), 
			'subtotal' => strip_tags($subtotal),
			'qtycount' => intval($qty)
		));
    die();
}

//quickview ajax
add_action( 'wp_ajax_product_quickview', 'orfarm_product_quickview' );
add_action( 'wp_ajax_nopriv_product_quickview', 'orfarm_product_quickview' );

function orfarm_product_quickview() {
	global $product, $post, $woocommerce_loop, $orfarm_opt;
	if($_POST['data']){
		$productid = intval( $_POST['data'] );
		$product = wc_get_product( $productid );
		$post = get_post( $productid );
	}
	?>
	<div class="woocommerce product">
		<div class="product-images">
			<div class="quick-thumbnails">
				<?php 
				echo '<div>' . wp_get_attachment_image( get_post_thumbnail_id($product->get_id()), apply_filters( 'woocommerce_gallery_image_size', 'woocommerce_single' ), false, array() ) . '</div>';
				
				$attachment_ids = $product->get_gallery_image_ids();
				
				if ( count($attachment_ids) ) {
					$loop = 0;
					$columns = apply_filters( 'woocommerce_product_thumbnails_columns', 3 );
					?>
				
					<?php foreach ( $attachment_ids as $attachment_id ) {
						?>
						<div>
						<?php
							$classes = array( 'zoom' );
							if ( $loop == 0 || $loop % $columns == 0 ) $classes[] = 'first';
							if ( ( $loop + 1 ) % $columns == 0 ) $classes[] = 'last';
							echo wp_get_attachment_image( $attachment_id, apply_filters( 'woocommerce_gallery_image_size', 'woocommerce_single' ), false, $classes );
							$loop++;
						?>
						</div>
						<?php
					} ?>
				<?php }	?>
			</div>
			<a class="see-all" href="<?php echo esc_url($product->get_permalink()); ?>"><?php echo esc_html__('View details', 'orfarm'); ?></a>
		</div>
		<div class="product-info">
			<h1><a href="<?php echo esc_url($product->get_permalink()); ?>"><?php echo esc_html($product->get_name()); ?></a></h1>
			<?php if(!empty($orfarm_opt['enable_rate'])){ ?>
				<?php woocommerce_template_single_rating(); ?>
			<?php } ?>
			<div class="price-box" itemprop="offers" itemscope itemtype="http://schema.org/Offer">
				<p class="price">
					<?php echo '' . $product->get_price_html(); ?>
				</p>
			</div>
			<div class="quick-desc"><?php echo do_shortcode(get_post($productid)->post_excerpt); ?></div>
			<div class="quick-add-to-cart">
				<?php woocommerce_template_single_add_to_cart(); ?>
			</div>
			<?php woocommerce_template_single_meta(); ?>
			<?php do_action('lionthemes_quickview_after_product_info'); ?>
		</div>
	</div>
	<?php
	die();
}


add_action( 'wp_ajax_orfarm_autocomplete_search', 'orfarm_autocomplete_search' );
add_action( 'wp_ajax_nopriv_orfarm_autocomplete_search', 'orfarm_autocomplete_search' );
function orfarm_autocomplete_search(){
	$html = '';
	if(!empty($_POST['keyword'])){
		$category = (!empty($_POST['cat'])) ? $_POST['cat'] : '';
		$limit = (!empty($orfarm_opt['ajaxsearch_result_items'])) ? intval($orfarm_opt['ajaxsearch_result_items']) : 6;
		$loop = orfarm_woocommerce_query('recent_product', $limit, $category, $_POST['keyword']);
		if ( $loop->have_posts() ){
			while ( $loop->have_posts() ){
				$loop->the_post(); 
				global $product; 
				$html .= wc_get_template( 'content-widget-product.php', array( 
								'show_rating' => false , 
								'showon_effect' => '' , 
								'class_column' => '', 
								'show_category'=> false , 
								'delay' => 0 ) 
							);
			}
			$total = $loop->found_posts;
			$html .= '<div class="last-total-result"><span>'. sprintf(esc_html__('%s results found.', 'orfarm'), $total) .'</span></div>';
		}else{
			$html .= '<div class="item-product-widget"><span class="no-results">'. esc_html__('No products found!', 'orfarm') .'</span></div>';
		}
	}else{
		$html .= '<div class="item-product-widget"><span class="no-results">'. esc_html__('No products found!', 'orfarm') .'</span></div>';
	}
	echo '' . $html;
	die();
}



// Count number of products from shortcode
add_filter( 'woocommerce_shortcode_products_query', 'orfarm_woocommerce_shortcode_count');
function orfarm_woocommerce_shortcode_count( $args ) {
	global $orfarm_opt, $orfarm_productsfound;
	$orfarm_productsfound = new WP_Query($args);
	$orfarm_productsfound = $orfarm_productsfound->post_count;
	return $args;
}

// number products per page
add_filter( 'loop_shop_per_page', 'orfarm_shop_per_page', 100 );
function orfarm_shop_per_page() {
	$orfarm_opt = get_option('orfarm_opt');
	return !empty($orfarm_opt['product_per_page']) ? $orfarm_opt['product_per_page'] : 24;
}
// remove sale label default
add_filter('woocommerce_sale_flash', 'orfarm_hide_sale_flash');
function orfarm_hide_sale_flash()
{
return false;
}
// product label 
function orfarm_product_label()
{	
	global $orfarm_opt, $product ;
	$productLabel = "";
	$percentage = '';
	$labelDesign = '';
	
	if(isset($orfarm_opt['products_label'])) {
	   if($orfarm_opt['products_label'] == 'round') {
		   $labelDesign =' round';
	   } else if($orfarm_opt['products_label'] == 'rectangle') {
		   $labelDesign =' rectangle';
	   }
	}
	$productLabel .= '<div class="products-label '.$labelDesign.'">';
	if(isset($orfarm_opt['enable_new_label']) && $orfarm_opt['enable_new_label'] == 1 ) {
		$new_date = $product->get_meta('orfarm_new_date');
		
		$expired_new = "";
		if(isset($orfarm_opt['expired_new']))  {
		    $expired_new    = $orfarm_opt['expired_new'];
		}
		//$postdate        = get_the_time( 'Y-m-d', $product->get_id() );
		//$post_date_stamp = strtotime( $postdate );
		if($new_date) {
		
			if ( $new_date && time() <= strtotime( $new_date ) ) {
				$productLabel .='<div class="new-label"><span>' . esc_html__( 'New', 'orfarm' ) . '</span></div>';
			}
		}
	}

	if(isset( $orfarm_opt['enable_sale_label'] ) && $orfarm_opt['enable_sale_label'] == 1 && $product->is_on_sale() ) {
	
		if ( $product->get_type() == 'variable') {

			$available_variations = $product->get_variation_prices();
			$max_percentage       = 0;

			foreach ( $available_variations['regular_price'] as $key => $regular_price ) {
				$sale_price = $available_variations['sale_price'][ $key ];

				if ( $sale_price < $regular_price ) {
					$percentage = round( ( ( $regular_price - $sale_price ) / $regular_price ) * 100 );

					if ( $percentage > $max_percentage ) {
						$max_percentage = $percentage;
					}
				}
			}

			$percentage = $max_percentage;
		} elseif ( ( $product->get_type() == 'simple' || $product->get_type() == 'external' || $product->get_type() == 'variation' ) ) {
			$percentage = round( ( ( $product->get_regular_price() - $product->get_sale_price() ) / $product->get_regular_price() ) * 100 );
		}	
			   
	   if( isset( $orfarm_opt['percentage_label'] ) && $orfarm_opt['percentage_label'] == 1 ) {
		   if($percentage) {
		       $productLabel .='<div class="sale-label"><span class="onsale">'.'-'. $percentage . '%'.'</span></div>';
		   }
	   } else {
		       $productLabel .='<div class="sale-label"><span class="onsale">'.esc_html__( 'Sale!', 'orfarm' ).'</span></div>';
	   }
	} 
	$productLabel .= '</div>';
	echo  html_entity_decode($productLabel);
}
add_action('orfarm_product_label_before_loop', 'orfarm_product_label');
function orfarm_ajax_add_to_cart_button(){
	global $product;
	
	if ( $product ) {
		echo '<p class="woocommerce add_to_cart_inline">';
		$defaults = array(
			'quantity' => 1,
			'class'    => implode( ' ', array_filter( array(
					'button',
					'product_type_' . $product->get_type(),
					$product->is_purchasable() && $product->is_in_stock() ? 'add_to_cart_button' : '',
					$product->supports( 'ajax_add_to_cart' ) ? 'ajax_add_to_cart' : '',
			) ) ),
			'attributes' => array(
				'data-product_id'  => $product->get_id(),
				'data-product_sku' => $product->get_sku(),
				'aria-label'       => $product->add_to_cart_description(),
				'rel'              => 'nofollow',
			),
		);
		$args = array();
		$args = apply_filters( 'woocommerce_loop_add_to_cart_args', wp_parse_args( $args, $defaults ), $product );

		wc_get_template( 'loop/add-to-cart.php', $args );
		echo '</p>';
	}
}
add_filter('woocommerce_layered_nav_term_html', 'orfarm_woocommerce_layered_nav_term_html', 100, 4);
function orfarm_woocommerce_layered_nav_term_html($html, $term, $link, $count) {
	if (class_exists('Woo_Variation_Swatches')) {
		$color = sanitize_hex_color(get_term_meta($term->term_id, 'product_attribute_color', true));
		$icon = get_term_meta($term->term_id, 'product_attribute_image', true);
		if ($color) {
			$span = sprintf('<span class="variable-item-color" style="background-color:%s;"></span>', esc_attr($color));
			$label = sprintf('<span class="color-label">%s</span>', esc_attr($term->name));
			return '<a class="has-variable" rel="nofollow" href="' . $link . '">' . $span . $label. '</a>';
		}
		if ($icon) {
			$url = wp_get_attachment_url( $icon );
			if ($url) {
				$span = sprintf('<img class="variable-item-image" src="%s" alt="'. esc_attr($term->name) .'" />', esc_attr($url));
				$label = sprintf('<span class="image-label">%s</span>', esc_attr($term->name));
				return '<a class="has-variable" rel="nofollow" href="' . $link . '">' . $span . $label. '</a>';
			}
		}
	}
	return $html;
}
function orfarm_get_product_schema(){
	return ((is_ssl()) ? 'https' : 'http') . '://schema.org/Product';
}
function orfarm_get_rating_html(){
	if ( get_option( 'woocommerce_enable_review_rating' ) === 'no' ) {
		return;
	}
	global $product;
	?>
	<div class="ratings"><?php echo wc_get_rating_html($product->get_average_rating()); ?></div>
	<?php
}

// hook to custom gallery thumbnail images size in product page
add_filter( 'woocommerce_get_image_size_gallery_thumbnail', function( $size ) {
	$orfarm_opt = get_option( 'orfarm_opt' );
	if (!empty($orfarm_opt['gallery_thumbnail_size'])) {
		$size['width'] = $orfarm_opt['gallery_thumbnail_size']['width'];
		$size['height'] = $orfarm_opt['gallery_thumbnail_size']['height'];
		if (!$size['height']) {
			$size['crop']   = 0;
		}
	}
	return $size;
});
remove_action('woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20);
remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_upsell_display', 15 );
add_action('orfarm_woocommerce_after_product_container', 'woocommerce_output_related_products', 20);
add_action('orfarm_woocommerce_after_product_container', 'woocommerce_upsell_display', 15);

// setting related product counter 
add_filter( 'woocommerce_output_related_products_args', 'orfarm_related_products_args', 200 );
function orfarm_related_products_args($args) {
	$orfarm_opt = get_option( 'orfarm_opt' );
	if (!empty($orfarm_opt['related_amount'])) $args['posts_per_page'] = $orfarm_opt['related_amount'];
	return $args;
}

add_filter('woocommerce_single_product_image_gallery_classes', 'orfarm_woocommerce_single_product_image_gallery_classes');
function orfarm_woocommerce_single_product_image_gallery_classes($array) {
	$orfarm_opt = get_option( 'orfarm_opt' );
	$layout = orfarm_get_single_product_layout();
	$sliderClass = empty($orfarm_opt['thumb_slider_direct']) ? 'vertical-left-slider' : $orfarm_opt['thumb_slider_direct'];
	
	if (!empty($_GET['slider']) && in_array($_GET['slider'], array('vertical-left', 'vertical', 'horizontal'))) {
		$sliderClass = $_GET['slider'] . '-slider';
	}
	if ($layout == 'thumbnail-layout') {
		$array[] = $sliderClass;
	}
	return $array;
}

function orfarm_get_single_product_layout() {
	$orfarm_opt = get_option( 'orfarm_opt' );
	$layout = !empty($orfarm_opt['product_layout']) ? $orfarm_opt['product_layout'] . '-layout' : 'default-layout';
	if (!empty($_GET['layout'])) $layout = $_GET['layout'] . '-layout';
	return $layout;
} 

add_action('orfarm_before_title_loop_product', 'orfarm_display_product_categories_list', 10, 2);
function orfarm_display_product_categories_list($id, $hide) {
	if (!$hide) {
		$cats = get_the_terms($id, 'product_cat');
		if (!empty($cats)) {
			echo '<ul class="quick-categories">';
			foreach($cats as $key => $cat) {
				echo '<li><a href="'. get_term_link( $cat->term_id, 'product_cat' ) .'">'. esc_html($cat->name) .'</a>'. (($key !== count($cats) - 1) ? ', '  : '') .'</li>';
			}
			echo '</ul>'; 
		}
	}
}
//move title on product page
remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_title', 5);
//add_action('woocommerce_before_single_product', 'orfarm_woocommerce_template_single_title', 5);
function orfarm_woocommerce_template_single_title() {
	echo '<h1 class="product_title entry-title" itemprop="name" content="'. get_the_title() .'">' . get_the_title() . '</h1>';
}
//move rating on product page
remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_rating', 10);


// Shop hook product gridview 
function orfarm_the_archive_product_gridview($isdeals = false) {
	global $product, $hide_categories, $show_desc, $show_sold,$orfarm_opt;
	?>
	<div class="gridview">
		<?php 
		   	if(isset($orfarm_opt['enable_cate_products']) && $orfarm_opt['enable_cate_products'] == 1 && get_the_Id() ) { 		
			    echo '<div class="product-cats-list">' . get_the_term_list(get_the_Id(), 'product_cat', '', ', ', '') . '</div>'; 
			}
		?>
		<h3 class="product-name">
			<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
		</h3>
		<?php if(!empty($orfarm_opt['enable_rate'])){ ?>
			<?php orfarm_get_rating_html(); ?>
		<?php } ?>
		<div class="switcher-wrapper">
			<div class="price-switcher">
				<div class="price"><?php echo ''.$product->get_price_html(); ?></div>
			</div>
			<?php do_action('orfarm_woocommerce_after_shop_loop_item_title', $product); ?>
		</div>
		<div class="hover-content d-none d-md-block">
			<?php if(!empty($orfarm_opt['enable_addcart'])){ ?>
				<div class="button-switch">
					<?php orfarm_ajax_add_to_cart_button(); ?>
				</div>
			<?php } ?>
			<?php if ($show_desc == 'yes') { ?>
			<div class="product-desc">
				<?php the_excerpt(); ?>
				<?php do_action('orfarm_woocommerce_after_shop_loop_item_title', $product); ?>
			</div>	
			<?php } ?>
		</div>	
		
		
		<?php if (!empty($isdeals)) {
			$current_date = current_time( 'timestamp' );
			$sale_end = get_post_meta( $product->get_id(), '_sale_price_dates_to', true );
			$timestemp_left = intval($sale_end) + 24*60*60 - 1 - $current_date;
			if($timestemp_left > 0) {
				$day_left = floor($timestemp_left / (24 * 60 * 60));
				$hours_left = floor(($timestemp_left - ($day_left * 60 * 60 * 24)) / (60 * 60));
				$mins_left = floor(($timestemp_left - ($day_left * 60 * 60 * 24) - ($hours_left * 60 * 60)) / 60);
				$secs_left = floor($timestemp_left - ($day_left * 60 * 60 * 24) - ($hours_left * 60 * 60) - ($mins_left * 60));
				
				echo '<div class="deals-countdown">
						<div class="deals-label">' . esc_html__('Harry Up! Offer end in:', 'orfarm') . '</div>
						<span class="countdown-row">	
							<span class="countdown-section">
								<span class="countdown-val days_left">'. $day_left .'</span>
								<span class="countdown-label">' . esc_html__('Days', 'orfarm') . '</span>
							</span>
							<span class="countdown-section">
								<span class="countdown-val hours_left">'. $hours_left .'</span>
								<span class="countdown-label">' . esc_html__('Hrs', 'orfarm') . '</span>
							</span>
							<span class="countdown-section">
								<span class="countdown-val mins_left">' . $mins_left . '</span>
								<span class="countdown-label">' . esc_html__('Mins', 'orfarm') . '</span>
							</span>
							<span class="countdown-section">
								<span class="countdown-val secs_left">' . $secs_left . '</span>
								<span class="countdown-label">' . esc_html__('Secs', 'orfarm') . '</span>
							</span>
						</span>
					</div>';
			}
		} ?>

		<?php if (!empty($show_sold)) { ?>
			<?php $managerStock = $product->managing_stock();
			if ($managerStock) {
				$stock_quantity = intval($product->get_stock_quantity());
				$soldout = $product->get_meta('lionthemes_woo_product_sold') ? intval($product->get_meta('lionthemes_woo_product_sold')) : 0;
				$total = $stock_quantity + $soldout;
				if ($total > 0) {
				echo '<div class="sout-out-progress">
					<div class="sold-out-bar"><div class="soldout" style="width: '. ceil(($soldout / $total) * 100) .'%"></div></div>
					<div class="sold-detail">
						<div class="sold">
							'. esc_html__('Sold:', 'orfarm') . ' <span>' . $soldout .'/' . $total .'</span>
						</div>
					</div>
				</div>';
				}
			} ?>
		<?php } ?>
	</div>
	<?php
}

// Shop hook product listview 
function orfarm_the_archive_product_listview() {
	global $product, $hide_categories, $show_desc, $show_sold;
	$orfarm_opt = get_option( 'orfarm_opt' );
	?>
	<div class="listview">
		<div class="woocommerce-shortdes">
			<h3 class="product-name">
				<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
			</h3>
			<?php if(!empty($orfarm_opt['enable_rate'])){ ?>
				<?php orfarm_get_rating_html(); ?>
			<?php } ?>
			<div class="price"><?php echo ''.$product->get_price_html(); ?></div>
			<div class="product-desc">
				<?php the_excerpt(); ?>
				<?php do_action('orfarm_woocommerce_after_shop_loop_item_title', $product); ?>
			</div>
			<?php if (!empty($show_sold)) { ?>
				<?php $managerStock = $product->managing_stock();
				if ($managerStock) {
					$stock_quantity = intval($product->get_stock_quantity());
					$soldout = $product->get_meta('lionthemes_woo_product_sold') ? intval($product->get_meta('lionthemes_woo_product_sold')) : 0;
					$total = $stock_quantity + $soldout;
					if ($total > 0) {
					echo '<div class="sout-out-progress">
						<div class="sold-out-bar"><div class="soldout" style="width: '. ceil(($soldout / $total) * 100) .'%"></div></div>
						<div class="sold-detail">'. esc_html__('Sold:', 'orfarm') . ' ' . $soldout . '/' . $total .'</div>
					</div>';
					}
				} ?>
			<?php } ?>
		</div>
		<div class="actions">
			<?php if(!empty($orfarm_opt['enable_addcart'])){ ?>
				<?php orfarm_ajax_add_to_cart_button(); ?>
			<?php } ?>
			<?php if (empty($hide_actions)) { ?>
				<div class="item-buttons">
					<?php if(!empty($orfarm_opt['enable_wishlist'])){ ?>
						<?php if ( class_exists( 'YITH_WCWL' ) ) {
							echo preg_replace("/<img[^>]+\>/i", " ", do_shortcode('[yith_wcwl_add_to_wishlist]'));
						} ?>
					<?php } ?>
					<?php if(!empty($orfarm_opt['enable_compare'])){ ?>
						<?php if( class_exists( 'YITH_Woocompare' ) ) {
							echo do_shortcode('[yith_compare_button]');
						} ?>
					<?php } ?>					
				</div>
			<?php } ?>	
		</div>
	</div>
	<?php
}

// product grid image
function orfarm_the_archive_product_image_buttons() {
	global $product, $hide_actions;
	$orfarm_opt = get_option('orfarm_opt');
	$attr = empty($orfarm_opt['second_image']) ? array() : array('class' => 'primary_image');
	$size = apply_filters('single_product_archive_thumbnail_size', 'woocommerce_thumbnail');
	?>
	<div class="product-image">
		<a href="<?php the_permalink(); ?>">
			<?php
			if (!$product || ($product && !wp_get_attachment_image(get_post_thumbnail_id($product->get_id()), $size, false, $attr))) {
				if (function_exists('wc_placeholder_img')) {
					echo wc_placeholder_img( $size, $attr );
				}
			} else {
				echo wp_get_attachment_image(get_post_thumbnail_id($product->get_id()), $size, false, $attr);
				if (!empty($orfarm_opt['second_image'])) {
					$attachment_ids = $product->get_gallery_image_ids();
					if ($attachment_ids) {
						echo wp_get_attachment_image($attachment_ids[0], $size, false, array('class' => 'secondary_image'));
					}
				}
			} ?>
		</a>
		<?php if (empty($hide_actions) || !empty($orfarm_opt['enable_addcart'])) { ?>
			<div class="box-action">
				<?php if (empty($hide_actions)) { ?>
					<div class="item-buttons">
						<?php if(!empty($orfarm_opt['enable_wishlist'])){ ?>
							<?php if ( class_exists( 'YITH_WCWL' ) ) {
								echo preg_replace("/<img[^>]+\>/i", " ", do_shortcode('[yith_wcwl_add_to_wishlist]'));
							} ?>
						<?php } ?>
					
						<?php if(!empty($orfarm_opt['enable_compare'])){ ?>
							<?php if( class_exists( 'YITH_Woocompare' ) ) {
								echo do_shortcode('[yith_compare_button]');
							} ?>
						<?php } ?>

						<?php if(!empty($orfarm_opt['enable_quickview'])){ ?>
							<div class="quickviewbtn d-none d-md-block">
								<a class="detail-link quickview" data-quick-id="<?php the_ID();?>" href="<?php the_permalink(); ?>" title="<?php esc_html_e('Quick View', 'orfarm'); ?>"><?php esc_html_e('Quick View', 'orfarm');?></a>
							</div> 
						<?php } ?>	

						<?php if(!empty($orfarm_opt['enable_addcart'])){ ?>
							<div class="button-switch d-md-none">
								<svg width="16" height="16" viewBox="0 0 14 16" fill="none" xmlns="http://www.w3.org/2000/svg">
								<path fill-rule="evenodd" clip-rule="evenodd" d="M4.39173 4.12764C4.44388 2.94637 5.40766 2.00487 6.58894 2.00487H7.38873C8.57131 2.00487 9.53591 2.94846 9.5861 4.13155C7.78094 4.36058 6.15509 4.35461 4.39173 4.12764ZM3.18982 5.16767L3.18982 7.73151C3.18982 8.06644 3.45838 8.33795 3.78966 8.33795C4.12095 8.33795 4.38951 8.06644 4.38951 7.73152L4.38951 5.33644C6.14735 5.55157 7.79071 5.55699 9.58815 5.34012V7.86711C9.58815 8.20204 9.85671 8.47355 10.188 8.47355C10.5193 8.47355 10.7878 8.20204 10.7878 7.86711V5.17238C12.0268 5.06423 13.025 6.16508 12.7509 7.30009L12.0455 10.2203C11.9677 10.5424 12.1657 10.8665 12.4877 10.9443C12.8098 11.022 13.1339 10.824 13.2116 10.502L13.917 7.58177C14.4003 5.58093 12.6964 3.86781 10.7784 3.97096C10.6482 2.19332 9.18032 0.791992 7.38873 0.791992H6.58894C4.79881 0.791992 3.33188 2.19103 3.19955 3.96661C1.28928 3.87048 -0.398284 5.57815 0.0829708 7.57053L1.49644 13.4223C1.80462 14.6981 2.9479 15.5959 4.26085 15.5959H9.74186C11.0548 15.5959 12.1981 14.6981 12.5063 13.4223C12.584 13.1003 12.3861 12.7761 12.064 12.6984C11.742 12.6206 11.4179 12.8186 11.3401 13.1406C11.1624 13.8764 10.5022 14.3962 9.74186 14.3962H4.26085C3.50047 14.3962 2.84032 13.8764 2.66259 13.1406L1.24911 7.28885C0.976309 6.15944 1.96169 5.06742 3.18982 5.16767Z" fill="#2D2A6E"></path>
								</svg>
								<?php orfarm_ajax_add_to_cart_button(); ?>
							</div>
						<?php } ?>
					</div>
				<?php } ?>	
				
			</div>
		<?php } ?>
	</div>
<?php }


// product single tab
add_filter( 'woocommerce_product_tabs', 'orfarm_custom_product_tabs' );
function orfarm_custom_product_tabs($tabs) {
	
	$orfarm_opt = get_option('orfarm_opt'); 
	$tab_title1 = $orfarm_opt['tab_tile_1'];
	$tab_title2 = $orfarm_opt['tab_tile_2'];
	$tab_title3 = $orfarm_opt['tab_tile_3'];
	$tab_des1 = $orfarm_opt['tab_des_1'];
	
	if ( $tab_title1 ) {
		$tabs['orfarm_additional_tab'] = array(
			'title'    => $tab_title1,
			'priority' => 50,
			'callback' => 'orfarm_additional_product_tab_content',
		);
	}
	if ( $tab_title2 ) {
		$tabs['orfarm_additional_tab_2'] = array(
			'title'    => $tab_title2,
			'priority' => 50,
			'callback' => 'orfarm_additional_product_tab_2_content',
		);
	}
	
	if ( $tab_title3 ) {
		$tabs['orfarm_additional_tab_3'] = array(
			'title'    => $tab_title3,
			'priority' => 50,
			'callback' => 'orfarm_additional_product_tab_3_content',
		);
	}
	
	return $tabs;
}

if ( ! function_exists( 'orfarm_additional_product_tab_content' ) ) {
	function orfarm_additional_product_tab_content() {
	    $orfarm_opt = get_option('orfarm_opt'); 
		$content_html = "";
		if(isset( $orfarm_opt['enable_tab_html'] ) && $orfarm_opt['enable_tab_html'] == 1) {
			if (class_exists( '\Elementor\Plugin'))
			    $content_html = \Elementor\Plugin::instance()->frontend->get_builder_content_for_display($orfarm_opt['tab_html_1']);
		} else {
			$content_html = $orfarm_opt['tab_des_1'];
		}
		
		echo html_entity_decode($content_html);
	}
}


if ( ! function_exists( 'orfarm_additional_product_tab_2_content' ) ) {
	function orfarm_additional_product_tab_2_content() {
	    $orfarm_opt = get_option('orfarm_opt'); 
		$content_html = "";
		if(isset( $orfarm_opt['enable_tab_2_html'] ) && $orfarm_opt['enable_tab_2_html'] == 1) {
			if (class_exists( '\Elementor\Plugin'))
			    $content_html = \Elementor\Plugin::instance()->frontend->get_builder_content_for_display($orfarm_opt['tab_html_2']);
		} else {
			$content_html = $orfarm_opt['tab_des_2'];
		}
		 
		echo html_entity_decode($content_html);
	}
}

if ( ! function_exists( 'orfarm_additional_product_tab_3_content' ) ) {
	function orfarm_additional_product_tab_3_content() {
	  	$orfarm_opt = get_option('orfarm_opt'); 
		$content_html = "";
		if(isset( $orfarm_opt['enable_tab_3_html'] ) && $orfarm_opt['enable_tab_3_html'] == 1) {
			if (class_exists( '\Elementor\Plugin'))
				$content_html = \Elementor\Plugin::instance()->frontend->get_builder_content_for_display($orfarm_opt['tab_html_3']);
		} else {
			$content_html = $orfarm_opt['tab_des_3'];
		}
		
		echo html_entity_decode($content_html);
	}
}

// product bar
function displayProductBar()
{
    global $wp_the_query;
    $orfarm_opt = get_option('orfarm_opt');
    if(empty($orfarm_opt['enable_product_sticky'])){
        return;
    }
    if (!class_exists('WooCommerce')) {
        return;
    }
    $product = null;

    if (isset($wp_the_query) && is_object($wp_the_query)) {
        $posts = $wp_the_query->get_posts();
        if (count($posts) == 1) {
            $product = wc_get_product($posts[0]->ID);
        }	
    }
    if (!is_product() || !is_object($product)) {
        return;
    }
    $isInStock = $product->is_in_stock();
    if (!$isInStock && $product->get_type() == 'variable') {
        $variations = $product->get_available_variations();
        if (!empty($variations)) {
            $isInStock = true;
        }
    }
    if ($isInStock) {
        wc_get_template('single-product/product-bar.php', array('product' => $product, 'isInStock' => $isInStock));
    }
}
add_action('wp_footer', 'displayProductBar', PHP_INT_MAX);

// fake order
function purchase_fake_order()
{
    $orfarm_opt = get_option('orfarm_opt');
    if(empty($orfarm_opt['enable_fake_order'])){
        return;
    }
    $seconds_hide = !empty($orfarm_opt['fake_order_seconds_hide'])?$orfarm_opt['fake_order_seconds_hide']:3;
    $seconds_displayed = !empty($orfarm_opt['fake_order_seconds_displayed'])?$orfarm_opt['fake_order_seconds_displayed']:5;
    ?>
    <div id="purchase-fake-order" data-url="<?php echo esc_attr(admin_url('admin-ajax.php')); ?>" data-seconds-hide="<?php echo esc_attr($seconds_hide) ?>" data-seconds-displayed="<?php echo esc_attr($seconds_displayed) ?>" class="purchase-order fadeInUp animated hidden-xs" style="display: none;">
        <a class="purchase-close" href="javascript:void(0);"></a>
        <div class="product-purchase"></div>
    </div>
    <?php
}
add_action('wp_footer', 'purchase_fake_order', PHP_INT_MAX);

add_action( 'wp_ajax_fake_order_get_post_content', 'fake_order_get_post_content_callback' );
add_action( 'wp_ajax_nopriv_fake_order_get_post_content', 'fake_order_get_post_content_callback');
function fake_order_get_post_content_callback() {
    global $wp_the_query;
    $orfarm_opt = get_option('orfarm_opt');
    $html = '';
    $messages = !empty($orfarm_opt['fake_order_messages'])?$orfarm_opt['fake_order_messages']:'';

    $args = array(
        'posts_per_page'   => 1,
        'orderby'          => 'rand',
        'post_type'        => 'product' ); 
    
    $loop = new WP_Query( $args );
    
    while ( $loop->have_posts() ) : $loop->the_post(); global $product;
        $image =  wp_get_attachment_image_src( get_post_thumbnail_id( $loop->post->ID ), 'single-post-thumbnail' );
        $url = get_permalink($product->ID);
        $title = get_the_title($product->ID);
        if(!isset($image[0])){
            $img = '//via.placeholder.com/150';
        }
        else{
            $img = $image[0];	
        }
        
        $html .= '
            <div class="purchase-image">
                <a class="purchase-img" href="'.esc_attr($url).'">
                    <img alt="'.esc_attr($title).'" class="img_purchase" src="'.esc_attr($img).'">
                </a>
            </div>
            <div class="purchase-info">
                <span class="dib">'.$messages.'</span>
                <h3 class="title"><a href="'.esc_attr($url).'">'.$title.'</a></h3>
                <div class="minutes-ago"><span class="minute-number">0'.rand(1,9).'</span> <span>'.esc_html__('minutes ago', 'orfarm' ).'</span></div>
                <a class="btnProductQuickview" href="'.esc_attr($url).'">
                    '.esc_html__('view', 'orfarm').'
                </a>
            </div>
        ';
    endwhile; 
    wp_reset_postdata();

    $response['html'] = $html;
    wp_send_json( $response );
    exit;
}
