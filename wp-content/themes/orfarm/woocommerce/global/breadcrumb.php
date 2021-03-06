<?php
/**
 * Shop breadcrumb
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     4.5.2
 * @see         woocommerce_breadcrumb()
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! empty( $breadcrumb ) ) {

	echo '' . $wrap_before;

	foreach ( $breadcrumb as $key => $crumb ) {

		echo '' . $before;

		if ( ! empty( $crumb[1] ) && sizeof( $breadcrumb ) !== $key + 1 ) {
			echo '<a href="' . esc_url( $crumb[1] ) . '">' . esc_html( $crumb[0] ) . '</a>';
		} else {
			echo '<span> '. esc_html( $crumb[0] ) . '</span>';
		}

		echo ''. $after;

		if ( sizeof( $breadcrumb ) !== $key + 1 ) {
			echo '' . $delimiter;
		}

	}

	echo '' . $wrap_after;

}
