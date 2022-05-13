<?php
/**
 * The Header template for our theme
 *
 * Displays all of the <head> section and everything up till <div id="main">
 *
 * @package LionThemes
 * @subpackage Orfarm_Themes
 * @since Orfarm Themes 2.0 
 */
 
$orfarm_opt = get_option( 'orfarm_opt' );
$custom_page = orfarm_get_page_custom_configs();
?>

<div class="header-container header-v1">
	<?php if(!$custom_page['hide_topbar'] && is_active_sidebar('top_bar_left_widget_area ') ) { ?>
		<div class="top-bar<?php echo esc_attr(!empty($orfarm_opt['hide_mobile_topbar']) ? ' p-2 d-none d-sm-block' : '') ?>">
			<div class="container">
				<div class="row">
					<div class="widget_left col-lg-6 d-flex justify-content-center justify-content-lg-start">
						<?php if (is_active_sidebar('top_bar_left_widget_area ')) { ?> 
							<?php dynamic_sidebar('top_bar_left_widget_area'); ?> 
						<?php } ?>
					</div>
					<div class="widget_right col-lg-6 d-flex justify-content-center justify-content-lg-end">
						<?php if (is_active_sidebar('top_bar_right_widget_area ')) { ?> 
							<?php dynamic_sidebar('top_bar_right_widget_area'); ?> 
						<?php } ?>
					</div>
				</div>
			</div>
		</div>	
	<?php } ?>
	<div class="header border-bottom header-sticky">
		<div class="container">
			<div class="d-flex align-items-center -mx-4 h-80 position-relative">
				<?php if(has_nav_menu( 'mobilemenu' )){ ?>
					<div class="nav-mobile px-4 d-xl-none flex-1">
						<div class="toggle-menu"><i class="icon-menu1"></i></div>					
					</div>
				<?php } ?>	
				<div class="header-logo px-4 flex-1 text-center text-xl-start">
					<?php if( $custom_page['page_logo'] ){ ?>
						<div class="logo">
							<a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home">
								<img src="<?php echo esc_url($custom_page['page_logo']); ?>" alt="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" />
							</a>
						</div>
					<?php
					} else { ?>
						<h1 class="logo"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
						<?php
					} ?>
				</div>
				<div class="nav-menus d-none d-xl-block px-4 flex-grow-2 text-center">
					<div class="nav-desktop">
						<?php if(has_nav_menu( 'primary' )){
								$megamenu = new MegamenuLocation();
								$megamenu->megamenu_primary();  
						?>
						<?php } else { ?>
					    <span class="empty-menu"><?php echo esc_html__('Please assign your primary menu to primary location', 'orfarm') ?></span>
						<?php } ?>	
					</div>
					
				</div>					
				<div class="header-right d-flex center-vertical justify-content-end px-4 flex-1">
					<div class="search-switcher d-none d-md-block">
						<?php if(class_exists('WC_Widget_Product_Search')) { ?>	
						<span class="search-opener"><i class="icon-search"></i></span>
						<?php get_template_part('template-parts/search/advance'); ?>
						<?php } ?>
					</div>
					<div class="header-login-form d-none d-md-block">
						<div class="acc-form-padding">
						<?php if ( is_user_logged_in() ) {
							?>
							<p class="acc-buttons margin_0">
								<a class="acc-btn" href="<?php echo get_permalink( get_option('woocommerce_myaccount_page_id') ); ?>" title="<?php esc_html_e('My Account','orfarm'); ?>"><?php esc_html_e('My Account','orfarm'); ?></a>
							</p>
						<?php } else { ?>
							<div class="acc-link acc-buttons">
									<a class="lost-pwlink" href="<?php echo get_permalink( get_option('woocommerce_myaccount_page_id') ); ?>" title="<?php esc_html_e('Login / Register','orfarm'); ?>"><?php esc_html_e('Login / Register','orfarm'); ?></a>
							</div><?php 
						} ?> 
						</div>
					</div>
					
					<?php do_action('orfarm_header_badges'); ?>	
				</div>
			</div>	
		</div>
	</div>	
</div>