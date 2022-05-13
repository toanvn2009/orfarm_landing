<?php
/**
 * The template for displaying product search form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/product-searchform.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you (the theme developer).
 * will need to copy the new files to your theme to maintain compatibility. We try to do this.
 * as little as possible, but it does happen. When this occurs the version of the template file will.
 * be bumped and the readme will list any important changes.
 *
 * @see     http://docs.woothemes.com/document/template-structure/
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 4.5.2
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
$real_id = orfarm_make_id();
$cat = isset($_GET['cat']) ? $_GET['cat'] : '';
$categories = orfarm_get_all_taxonomy_terms('product_cat', true);
?>

<form role="search" method="get" class="woocommerce-product-search" action="<?php echo esc_url( home_url( '/'  ) ); ?>">
	<input type="search" id="woocommerce-product-search-field-<?php echo esc_attr($real_id); ?>" class="search-field" placeholder="<?php echo esc_attr_x( 'Search Products&hellip;', 'placeholder', 'orfarm' ); ?>" value="<?php echo get_search_query(); ?>" name="s" title="<?php echo esc_attr_x( 'Search for:', 'label', 'orfarm' ); ?>" />
	<div class="categories-list">
		<select id="woocommerce-product-search-cat-field-<?php echo esc_attr($real_id); ?>" class="search-cat-field vitual-style-el" name="cat">
			<?php foreach($categories as $category){ ?>
				<option value="<?php echo esc_attr($category['value']); ?>"<?php if ($category['value'] == $cat) echo esc_html(' selected="selected"'); ?>><?php echo esc_html($category['label']); ?></option>
			<?php } ?>
		</select>
	</div>
	<button type="submit" value="<?php echo esc_attr_x( 'Search', 'submit button', 'orfarm' ); ?>"><i class="icon-search"></i></button>
	<input type="hidden" name="post_type" value="product" />
</form>

