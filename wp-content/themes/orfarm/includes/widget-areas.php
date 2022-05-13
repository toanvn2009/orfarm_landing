<?php
/**
* Theme specific widgets or widget overrides
*
* @package LionThemes
* @subpackage Orfarm_theme
* @since Orfarm Themes 2.0
*/
 
/**
 * Register widgets
 *
 * @return void
 */
function orfarm_widget_area_register() {
	register_sidebar( array(
		'name' => esc_html__( 'Blog Sidebar', 'orfarm' ),
		'id' => 'blog',
		'description' => esc_html__( 'Appears on blog page', 'orfarm' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => '</aside>',
		'before_title' => '<h3 class="widget-title"><span>',
		'after_title' => '</span></h3>',
	) );
	
	register_sidebar( array(
		'name' => esc_html__( 'Shop Sidebar', 'orfarm' ),
		'id' => 'shop',
		'description' => esc_html__( 'Sidebar on shop page', 'orfarm' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => '</aside>',
		'before_title' => '<h3 class="widget-title"><span>',
		'after_title' => '</span></h3>',
	) );
			
	register_sidebar( array(
		'name' => esc_html__( 'Top Bar Left Widget area', 'orfarm' ),
		'id' => 'top_bar_left_widget_area',
		'description' => esc_html__( 'This area on top bar of header to display wellcome text ,shipping infor ...', 'orfarm' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => '</aside>',
		'before_title' => '<h3 class="widget-title"><span>',
		'after_title' => '</span></h3>',
	) );
	register_sidebar( array(
		'name' => esc_html__( 'Top Bar Left 2 Widget area', 'orfarm' ),
		'id' => 'top_bar_left_2_widget_area',
		'description' => esc_html__( 'This area on top bar of header to display wellcome text ,shipping infor ...', 'orfarm' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => '</aside>',
		'before_title' => '<h3 class="widget-title"><span>',
		'after_title' => '</span></h3>',
	) );
	register_sidebar( array(
		'name' => esc_html__( 'Top Bar Right Widget area', 'orfarm' ),
		'id' => 'top_bar_right_widget_area',
		'description' => esc_html__( 'This area on top bar of header to display wellcome text ,shipping infor ...', 'orfarm' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => '</aside>',
		'before_title' => '<h3 class="widget-title"><span>',
		'after_title' => '</span></h3>',
	) );
	register_sidebar( array(
		'name' => esc_html__( 'Shop Filter', 'orfarm' ),
		'id' => 'shopfilter',
		'description' => esc_html__( 'Filter area on shop page', 'orfarm' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h3 class="widget-title"><span>',
		'after_title' => '</span></h3>',  
	) );
	
	register_sidebar( array(
		'name' => esc_html__( 'Product sidebar', 'orfarm' ),
		'id' => 'product_sidebar',
		'description' => esc_html__( 'Product detail sidebar', 'orfarm' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => '</aside>',
		'before_title' => '<h3 class="widget-title"><span>',
		'after_title' => '</span></h3>',
	) );
}
add_action( 'widgets_init', 'orfarm_widget_area_register' ); 

