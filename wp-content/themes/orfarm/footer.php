<?php
/**
 * The template for displaying the footer
 *
 * @package LionThemes
 * @subpackage Orfarm_theme
 * @since Orfarm Themes 2.0 
 */
?>
</div> <!-- close tag for id="content" class="site-content" -->
<?php 

$orfarm_opt = orfarm_opt_by_home();
$custom_page = orfarm_get_page_custom_configs();
$custom_footer = '';
if ($orfarm_opt['footer_layout']) {
	
		if( $orfarm_opt['footer_layout'] &&  class_exists( '\Elementor\Plugin' ) ) { 
				$custom_footer .= '<div class="bl-elementor">' . \Elementor\Plugin::instance()->frontend->get_builder_content_for_display($orfarm_opt['footer_layout'] ) . '</div>';
		}	
}
?>
		
		<?php if (isset($orfarm_opt['back_to_top']) && $orfarm_opt['back_to_top'] ) { ?>
			<div id="back-top"><div class="to-top"></div></div>
		<?php } ?>
		<footer id="site-footer">
			<?php if ($custom_footer) {
				echo '' . $custom_footer;
			} else { ?>
				<div class="footer default">
					<div class="container">
                        <div class="widget-copyright">
                            <?php printf(esc_html_e('Copyright %s %d . All Rights Reserved', 'orfarm'), '<a href="'.esc_url( home_url( '/' ) ).'">'.get_bloginfo('name').'</a>', date('Y')); ?>
                        </div>
					</div>
				</div>
			<?php } ?>
		</footer>
	</div>  <!-- close tag for class="main-wrapper" -->
	<?php wp_footer(); ?>
</body>
</html>