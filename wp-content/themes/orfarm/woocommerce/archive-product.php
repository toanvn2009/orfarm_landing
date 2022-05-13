<?php
/**
 * The Template for displaying product archives, including the main shop page which is a post type archive.
 *
 * Override this template by copying it to yourtheme/woocommerce/archive-product.php
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     4.5.2
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

get_header( 'shop' ); ?>
<?php
global $wp_query, $woocommerce_loop, $hide_categories;

$orfarm_opt = get_option( 'orfarm_opt' );
$hide_categories = isset($orfarm_opt['showlist_cats']) ? !$orfarm_opt['showlist_cats'] : false;

$orfarm_shopclass = 'maincol-sidebar-' . orfarm_get_shop_sidebar();

$orfarm_viewmode = orfarm_get_shop_viewmode();
if( isset($_GET['view_mode']) ) {
	$orfarm_viewmode = $_GET['view_mode']; 
}
$tablet_viewmode = (!empty($orfarm_opt['shop_tablet_view'])) ? $orfarm_opt['shop_tablet_view'] : 'col3-view';
$mobile_viewmode = (!empty($orfarm_opt['shop_mobile_view'])) ? $orfarm_opt['shop_mobile_view'] : 'col2-view';
$product_spacing = (!empty($orfarm_opt['product_spacing'])) ? 'bl-spacing-'.$orfarm_opt['product_spacing'] : '';

$shop_view = get_option('woocommerce_shop_page_display');
$cat_view = get_option('woocommerce_category_archive_display');
$detect_pro_view = true;
$cateID = 0;
$showsubcats = false;
if (is_product_category()) {
	$detect_pro_view = ($cat_view != 'subcategories');
	$cate = get_queried_object();
	$cateID = $cate->term_id;
	$display_type = get_term_meta($cateID, 'display_type'); 
	if(!empty($display_type[0]) && ($display_type[0] == 'products' || $display_type[0] == 'both')) $detect_pro_view = true;
	if(!empty($display_type[0]) && $display_type[0] == 'subcategories') $detect_pro_view = false;
	if(!empty($display_type[0]) && ($display_type[0] == 'subcategories' || $display_type[0] == 'both')) $showsubcats = true;
}
if(is_shop() && $shop_view == 'subcategories'){
	$detect_pro_view = false;
}
if(is_search() || count(WC_Query::get_layered_nav_chosen_attributes()) > 0) $detect_pro_view = true;
if (is_shop() && $shop_view != 'products' && $shop_view) $showsubcats = true;

$pag_mode = orfarm_get_shop_pagination_mode();
$show_sub_cates = 0;
if(isset( $orfarm_opt['enable_sub_cate'] )) $show_sub_cates = $orfarm_opt['enable_sub_cate'];

?>
<div class="main-container">
	<div class="page-content">
		
		<div class="before-archive-content">
			<?php
				/**
				 * woocommerce_before_main_content hook
				 *
				 * @hooked woocommerce_output_content_wrapper - 10 (outputs opening divs for the content)
				 * @hooked woocommerce_breadcrumb - 20
				 */
				do_action( 'woocommerce_before_main_content' );
			?>
		</div>
		<div class="shop_content">
			<div class="container <?php echo esc_attr($orfarm_shopclass) ?>"> 
				<div id="archive-product" class="<?php echo esc_attr($orfarm_shopclass) ?>">
					<div class="category-desc">
						<?php do_action( 'woocommerce_archive_description' ); ?>
					</div>
					<div class="archive-border">
						<?php if ( have_posts() ) : ?>
							
							<?php
								/**
								* remove message from 'woocommerce_before_shop_loop' and show here
								*/
								do_action( 'woocommerce_show_message' );
							?>
							<?php if($show_sub_cates==1){ ?>
								<div class="shop-categories categories shop-products grid-view">
									<?php woocommerce_output_product_categories(array('parent_id' => $cateID)); ?>
								</div>
							<?php } ?>
							<?php if($detect_pro_view){ ?>
							<div class="toolbar">
								<?php
									/**
									 * woocommerce_before_shop_loop hook
									 *
									 * @hooked woocommerce_result_count - 20
									 * @hooked woocommerce_catalog_ordering - 30
									 */
									do_action( 'woocommerce_before_shop_loop' );
								?>
							</div>
						
							<?php //woocommerce_product_loop_start(); ?>
							<div data-tabletview="<?php echo esc_attr($tablet_viewmode) ?>" data-mobileview="<?php echo esc_attr($mobile_viewmode) ?>" class="shop-products products <?php echo esc_attr($orfarm_viewmode);?> <?php echo esc_attr($product_spacing); ?>">
								
								<?php while ( have_posts() ) : the_post(); ?>

									<?php wc_get_template_part( 'content', 'product-archive' ); ?>

								<?php endwhile; // end of the loop. ?>
							</div>
							<?php //woocommerce_product_loop_end(); ?>
							
							<div class="toolbar tb-bottom<?php echo esc_attr(($pag_mode) ? ' hide':''); ?>">
								<?php
									/**
									 * woocommerce_before_shop_loop hook
									 *
									 * @hooked woocommerce_result_count - 20
									 * @hooked woocommerce_catalog_ordering - 30
									 */
									do_action( 'woocommerce_after_shop_loop' );
									//do_action( 'woocommerce_before_shop_loop' );
								?>
							</div>
							<?php if($pag_mode){ ?>
								<div class="load-more-product text-center <?php echo esc_attr($pag_mode); ?>"> 
									<?php if($pag_mode == 'button-more'){ ?>
										<img style="max-width: 30px;" class="hide" src="<?php echo get_template_directory_uri() ?>/images/loading.gif" alt="<?php echo esc_attr__('Loading', 'orfarm'); ?>" />
										<a class="button" data-all="<?php echo esc_attr__('That is all!', 'orfarm'); ?>" href="javascript:loadmoreProducts()"><?php echo esc_html__('Load more...', 'orfarm'); ?></a>
									<?php }else{ ?>
										<img width="50" class="hide" src="<?php echo get_template_directory_uri() ?>/images/loading.gif" alt="<?php echo esc_attr__('Loading', 'orfarm'); ?>" />
									<?php } ?>
								</div> 
							<?php } ?>
							<?php } ?>
						<?php elseif ( ! woocommerce_product_subcategories( array( 'before' => woocommerce_product_loop_start( false ), 'after' => woocommerce_product_loop_end( false ) ) ) ) : ?>

							<?php wc_get_template( 'loop/no-products-found.php' ); ?>

						<?php endif; ?>
					</div>
				</div>
				<?php get_template_part('template-parts/sidebar/shop'); ?>
			</div>
		</div>
	</div>
</div>
<?php get_footer( 'shop' ); ?>