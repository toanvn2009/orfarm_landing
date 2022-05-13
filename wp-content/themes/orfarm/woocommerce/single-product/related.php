<?php
/**
 * Related Products
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     4.5.2
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $product, $woocommerce_loop, $orfarm_opt;

$woocommerce_loop['columns'] = 1;
if ( $related_products ) : ?>

<div class="widget related_products_widget related products ">
	<div class="container">
		<h3 class="widget-title"><span>
			<?php esc_html_e( 'You may also like&hellip;', 'orfarm' ); ?>
		</span></h3>
			<?php woocommerce_product_loop_start(); ?>
				<div data-owl="slide" data-bigdesk="5" data-desksmall="5" data-tablet="3" data-mobile="2" data-tabletsmall="2" data-item-slide="4" data-margin="20" data-ow-rtl="false" class="owl-carousel owl-theme products-slide">
				<?php $count = 0; foreach ( $related_products as $related_product ) : $count++; ?>

					<?php
						$post_object = get_post( $related_product->get_id() );

						setup_postdata( $GLOBALS['post'] =& $post_object );

						wc_get_template_part( 'content', 'product' ); 
					
					?>
						
				<?php endforeach; ?>
				</div>
			<?php woocommerce_product_loop_end(); ?>
	</div>
	
</div>

<?php endif;

wp_reset_postdata();
