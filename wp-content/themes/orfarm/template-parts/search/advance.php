<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
$orfarm_opt = get_option( 'orfarm_opt' );
$real_id = orfarm_make_id();
$categories = array();
if(!empty($orfarm_opt['categories_search'])){
	$categories = get_terms(array(
		'taxonomy' => 'product_cat',
		'hide_empty' => false,
		'include' => $orfarm_opt['categories_search']
	));
}
$cat = isset($_GET['cat']) ? $_GET['cat'] : '';
?>

<form role="search" method="get" class="search-form-container" action="<?php echo esc_url( home_url( '/'  ) ); ?>">
	<div class="popup-overlay"></div>
	<div class="search-content-popup">
		<a class="close-popup" href="javascript:void(0)"><i class="icon-x"></i><span><?php echo esc_html__('Close', 'orfarm') ?></span></a>
		<h3><?php echo esc_html__('What Are You Looking For?', 'orfarm') ?></h3>
		
		<div class="field-container <?php if (!empty($orfarm_opt['enable_ajaxsearch'])) echo esc_attr('orfarm-autocomplete-search-wrap'); ?>">
			<?php if(!empty($categories)){ ?>
			<div class="categories-list">
				<select class="items-list">
					<option class="cat-item<?php echo (!$cat) ? ' selected' : ''; ?>"><a href="javascript:void(0)" data-slug=""><?php echo esc_html__('All categories', 'orfarm') ?></a></option>
					<?php foreach($categories as $category){ ?>
					<option class="cat-item<?php echo esc_attr(($category->slug == $cat) ? ' selected' : ''); ?>"><a data-slug="<?php echo esc_attr($category->slug); ?>" href="javascript:void(0)"><?php echo esc_html($category->name); ?></a></option>
					<?php } ?>
				</select>
				<input type="hidden" name="cat" class="search-cat-field" value="<?php echo esc_attr($cat) ?>" /> 
			</div>
			<?php } ?>
			<input type="search" autocomplete="off" id="woocommerce-product-search-field-<?php echo esc_attr($real_id); ?>" class="search-field" placeholder="<?php echo esc_attr_x( 'Search Products&hellip;', 'placeholder', 'orfarm' ); ?>" value="<?php echo get_search_query(); ?>" name="s" title="<?php echo esc_attr_x( 'Search for:', 'label', 'orfarm' ); ?>" />
			<input type="submit" class="btn-search" value="<?php echo esc_attr_x( 'Search', 'submit button', 'orfarm' ); ?>" /><i class="icon-search"></i>
			<?php if(!empty($orfarm_opt['enable_ajaxsearch'])) { ?>
			<div class="orfarm-autocomplete-search-results"></div>
			<div class="orfarm-autocomplete-search-loading">
				<img  class="loading-img" src="<?php echo get_template_directory_uri() . '/images/loading.gif'; ?>" alt="<?php echo esc_attr__('Loading', 'orfarm') ?>"/>
			</div>
			<?php } ?>
		</div>
		<input type="hidden" name="post_type" value="product" />
	</div>
</form>