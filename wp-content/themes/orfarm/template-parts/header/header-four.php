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
 

$custom_page = orfarm_get_page_custom_configs();
$orfarm_opt = orfarm_opt_by_home();
?>

<div class="header-container header-v4">
	<?php if(!$custom_page['hide_topbar'] && is_active_sidebar('top_bar_left_widget_area ') ) { ?>
		<div class="top-bar<?php echo esc_attr(!empty($orfarm_opt['hide_mobile_topbar']) ? ' d-none d-sm-block' : '') ?>">
			<div class="container-fluid">
				<div class="row">
					<div class="widget_left h-40 col-lg-12 d-flex justify-content-center align-items-center ">
						<?php if (is_active_sidebar('top_bar_left_widget_area ')) { ?> 
							<?php dynamic_sidebar('top_bar_left_widget_area'); ?> 
						<?php } ?>
					</div>
				</div>
			</div>
				
			
		</div>	
	<?php } ?>
	<div class="header border-bottom header-sticky">
		<div class="container-fluid">
			<div class="d-flex align-items-center -mx-4 h-80 position-relative">
				<?php if(has_nav_menu( 'mobilemenu' )){ ?>
					<div class="nav-mobile px-4 d-xl-none flex-1">
						<div class="toggle-menu"><i class="icon-menu1"></i></div>					
					</div>
				<?php } ?>	
				<div class="header-logo px-4 flex-1 text-center text-xl-start">
					<?php if( $orfarm_opt['logo_main'] ){ ?>
						<div class="logo">
							<a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home">
								<img src="<?php echo esc_url($orfarm_opt['logo_main']['url']); ?>" alt="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" />
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
						<?php if (is_active_sidebar('top_bar_right_widget_area ')) { ?> 
							<?php dynamic_sidebar('top_bar_right_widget_area'); ?> 
						<?php } ?>
				</div>
			</div>	
		</div>
	</div>	
</div>