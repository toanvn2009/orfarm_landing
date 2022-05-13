<?php 
	get_header(); 
	
	$orfarm_opt = get_option( 'orfarm_opt' );
	$custom_page = '';
	if (!empty($orfarm_opt['404_page'])) {
		if(did_action( 'elementor/loaded' )) {
			$custom_page = \Elementor\Plugin::$instance->frontend->get_builder_content_for_display($orfarm_opt['404_page']);
		}
	}
	
?>
	<div class="page-404<?php if (!$custom_page) echo ' default-page'; ?>">
		<div class="container">
			<article>
				<div class="page-content">	
					<?php if ($custom_page) { 
						echo '' . $custom_page;
					} else { ?>
					<img src="<?php echo get_template_directory_uri() . '/images/404-img.png'; ?>" alt="<?php echo esc_attr__('404', 'orfarm') ?>"/>
					<h2><?php echo esc_html__('Oop... that link is broken.', 'orfarm') ?></h2>
					<p><?php echo esc_html__('Sorry for the inconvenience. Go to our homepage or check out our latest collections.', 'orfarm') ?></p>
					<a class="btn btn-default" href="<?php echo esc_url( home_url( '/' ) )?>"><?php echo esc_html__('Back to Homepage', 'orfarm') ?> </a>
					<?php } ?>
				</div>
			</article>
		</div>

	</div>
	

<?php get_footer(); ?> 