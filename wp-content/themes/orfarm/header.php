<?php
/**
 * The Header template for our theme
 *
 * @package LionThemes
 * @subpackage Orfarm_theme
 * @since Orfarm Themes 2.0 
 */
?>
<?php 
global $orfarm_opt ; 
$slug_page = "";
	
if( is_front_page() ) {
	if(isset( $orfarm_opt['home_default'] )) { 
		$slug_page = $orfarm_opt['home_default'];
		$orfarm_opt = get_option('orfarm_opt_'.$slug_page); 
	}
	if( isset($orfarm_opt['home_default']) && $orfarm_opt['home_default'] == 'default' || $slug_page == 'default') { 
		$orfarm_opt = get_option( 'orfarm_opt' );
	}	
} else {
	if($post->post_name) {
	 if(get_option('orfarm_opt_'.$post->post_name) == false )  {
			 $orfarm_opt = get_option( 'orfarm_opt' );
			 $slug_page = $orfarm_opt['home_default'];
		 } else {
			$slug_page = $post->post_name;
		 }
		$orfarm_opt = get_option('orfarm_opt_'.$slug_page);  
		if($slug_page == 'default') $orfarm_opt = get_option( 'orfarm_opt' );
	}
}
$custom_page = orfarm_get_page_custom_configs();
if( !$orfarm_opt['header_layout'] ){
	$header_layout = 'first';
} else {
	$header_layout = $orfarm_opt['header_layout'];
}
?>


<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>" />
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="//gmpg.org/xfn/11" />
	<?php wp_head(); ?> 
</head>
<body <?php body_class(); ?>>
<?php if (function_exists('wp_body_open')) wp_body_open(); ?>
<div class="main-wrapper <?php echo esc_attr($custom_page['page_layout']); ?>">
	<?php do_action('before'); ?> 
	<header>
		<?php get_template_part('template-parts/header/header', $header_layout);	?>
	</header>
	<div id="content" class="site-content">