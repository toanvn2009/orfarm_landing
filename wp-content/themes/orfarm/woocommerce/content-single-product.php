<?php
/**
 * The template for displaying product content in the single-product.php template
 *
 * Override this template by copying it to yourtheme/woocommerce/content-single-product.php
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     4.5.2
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
?>
<?php 
	global $orfarm_opt; 
	$layout = orfarm_get_single_product_layout();
	$sidebar_product="none";
	if (isset($orfarm_opt ['sidebar_product']) )  {
		$sidebar_product = $orfarm_opt ['sidebar_product'];
	}

?>

<?php
	/**
	 * woocommerce_before_single_product hook
	 *
	 * @hooked wc_print_notices - 10
	 */
	 do_action( 'woocommerce_before_single_product' );

	 if ( post_password_required() ) {
	 	echo get_the_password_form();
	 	return;
	 }
?>

<div itemscope itemtype="<?php echo orfarm_get_product_schema(); ?>" id="product-<?php the_ID(); ?>" <?php post_class(); ?>>

		<div class="product-view <?php echo esc_attr($layout) ?>">
			<?php do_action('orfarm_before_single_product_content'); ?>
			
			   <div class=" d-xl-flex justify-content-between main-sidebar-<?php echo esc_attr($sidebar_product);  ?> sidebar-<?php echo esc_attr($sidebar_product); ?>">
					<div class="main-content-detail">
				
						<div class="content-detail-inner">
						
							<div class="product-title-wrap">
								<h1 class="product_title entry-title" itemprop="name" content="<?php echo  get_the_title(); ?>"><?php echo  get_the_title(); ?> </h1>
								<?php do_action( 'orfarm_product_label_before_loop' );   ?>
								<?php if(!empty($orfarm_opt['enable_rate'])){ ?>
									<?php woocommerce_template_single_rating(); ?>
								<?php } ?>
							</div>	
							<div class="row">
								<div class=" col-lg-7 left-image">
									<div class="single-product-image">
										<?php
											/**
											 * woocommerce_before_single_product_summary hook
											 *
											 * @hooked woocommerce_show_product_sale_flash - 10
											 * @hooked woocommerce_show_product_images - 20
											 */
											do_action( 'woocommerce_before_single_product_summary' );
										?>
									</div>
								</div>
								<div class=" col-lg-5 right-product-info">
									<div class="single-product-info">				
										<?php
											/**
											 * woocommerce_single_product_summary hook
											 *
											 * @hooked woocommerce_template_single_title - 5
											 * @hooked woocommerce_template_single_rating - 10
											 * @hooked woocommerce_template_single_price - 10
											 * @hooked woocommerce_template_single_excerpt - 20
											 * @hooked woocommerce_template_single_add_to_cart - 30
											 * @hooked woocommerce_template_single_meta - 40
											 * @hooked woocommerce_template_single_sharing - 50
											 */
											do_action( 'woocommerce_single_product_summary' );
										?>
									</div>
								</div>
							</div>		
						</div>

					<?php
						/**
						 * woocommerce_after_single_product_summary hook
						 *
						 * @hooked woocommerce_output_product_data_tabs - 10
						 * @hooked woocommerce_output_related_products - 20
						 */
						do_action( 'woocommerce_after_single_product_summary' );
					?>
					
					<meta itemprop="url" content="<?php the_permalink(); ?>" />	
					
					<?php do_action('woocommerce_show_related_products'); ?>

					<?php do_action( 'woocommerce_after_single_product' ); ?>
				 </div>

					<?php get_template_part('template-parts/sidebar/product'); ?> 	
		</div>
		
	</div>
		
</div><!-- #product-<?php the_ID(); ?> -->

