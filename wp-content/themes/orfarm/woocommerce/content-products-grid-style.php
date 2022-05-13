<?php 

$orfarm_opt = get_option( 'orfarm_opt' );	
if( $orfarm_opt['products_style'] == 'hover' ) {
	 wc_get_template_part( 'content', 'products-grid-hover' ); 
} elseif( $orfarm_opt['products_style'] == 'standard' ){
	 wc_get_template_part( 'content', 'products-grid-standard' ); 
}
