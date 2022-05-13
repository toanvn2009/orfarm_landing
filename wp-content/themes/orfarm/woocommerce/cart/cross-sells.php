<?php
/**
 * Cross-sells
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     4.5.2
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $product, $woocommerce_loop, $orfarm_opt;
$woocommerce_loop['columns'] = 1; //apply for carousel work
if ( $cross_sells ) : ?>

	<div class="cross-sells">

		<h3 class="widget-title">
			<span>
				<?php esc_html_e( 'You may be interested in&hellip;', 'orfarm' ) ?>
			</span>
		</h3>

		<?php woocommerce_product_loop_start(); ?>
			<div data-owl="slide" data-bigdesk="4" data-desksmall="4" data-tablet="3" data-mobile="1" data-tabletsmall="2" data-item-slide="3" data-margin="10" data-ow-rtl="false" class="owl-carousel owl-theme cross-sells-slide">
			<?php foreach ( $cross_sells as $cross_sell ) : ?>

				<?php
				 	$post_object = get_post( $cross_sell->get_id() );

					setup_postdata( $GLOBALS['post'] =& $post_object );

					wc_get_template_part( 'content', 'product' ); ?>

			<?php endforeach; ?>
			</div>
		<?php woocommerce_product_loop_end(); ?>

	</div>

<?php endif;

wp_reset_postdata();
