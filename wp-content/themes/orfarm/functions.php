<?php
/**
 * Orfarm Themes functions and definitions
 *
 * @package LionThemes
 * @subpackage Orfarm_theme
 * @since Orfarm Themes 2.0 
 */

//Plugin-Activation
require_once( get_template_directory().'/class-tgm-plugin-activation.php' );

 //Init the Redux Framework options
if ( class_exists( 'ReduxFramework' ) && !isset( $redux_demo ) ) {
	if(file_exists( get_template_directory().'/theme-config.php')){
		require_once( get_template_directory().'/theme-config.php' );
	}
}

// require system parts
if ( file_exists( get_template_directory().'/includes/theme-helper.php' ) ) {
	require_once( get_template_directory().'/includes/theme-helper.php' );
}
if ( file_exists( get_template_directory().'/includes/template-parts.php' ) ) {
	require_once( get_template_directory().'/includes/template-parts.php' );
}
if ( file_exists( get_template_directory().'/includes/widget-areas.php' ) ) {
	require_once( get_template_directory().'/includes/widget-areas.php' );
}
if ( file_exists( get_template_directory().'/includes/head-media.php' ) ) {
	require_once( get_template_directory().'/includes/head-media.php' );
}
if ( file_exists( get_template_directory().'/includes/bootstrap-extras.php' ) ) {
	require_once( get_template_directory().'/includes/bootstrap-extras.php' );
}
if ( file_exists( get_template_directory().'/includes/bootstrap-tags.php' ) ) {
	require_once( get_template_directory().'/includes/bootstrap-tags.php' );
}
if ( file_exists( get_template_directory().'/includes/woo-hook.php' ) ) {
	require_once( get_template_directory().'/includes/woo-hook.php' );
}

if ( file_exists( get_template_directory().'/includes/megamenu/megamenu-location.php' ) ) {
	require_once( get_template_directory().'/includes/megamenu/megamenu-location.php' );
}

add_action('wp_loaded', 'prefix_output_buffer_start');
function prefix_output_buffer_start() { 
    ob_start("prefix_output_callback"); 
}

function prefix_output_callback($buffer) {
    return preg_replace( "%[ ]type=[\'\"]text\/(javascript|css)[\'\"]%", '', $buffer );
}

add_action(
    'after_setup_theme',
    function() {
        add_theme_support( 'html5', array( "style", "script" ) );
    }
);

// theme setup
add_action( 'after_setup_theme', 'orfarm_setup');
function orfarm_setup(){
	$orfarm_opt = get_option( 'orfarm_opt' );
	// Load languages
	load_theme_textdomain( 'orfarm', get_template_directory() . '/languages' );

	// This theme supports a variety of post formats.
	add_theme_support( 'post-formats', array( 'image', 'gallery', 'video', 'audio' ) );
	
	// set default content width
	if ( ! isset( $content_width ) ) $content_width = 625;
	
	// This theme uses a custom image size for featured images, displayed on "standard" posts.
	add_theme_support( 'post-thumbnails' );
	
	// theme support
	add_theme_support( 'title-tag' );
	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'custom-background', array() );
	add_theme_support( 'custom-header', array() );
	add_theme_support( 'woocommerce' );
	add_theme_support( 'customize-selective-refresh-widgets' );
	add_theme_support( 'wp-block-styles' );
	add_theme_support( 'align-wide' );
	add_theme_support( 'responsive-embeds' );
	add_theme_support( 'editor-styles' );
	add_editor_style( 'style-editor.css' );
	// Add custom editor font sizes.
	add_theme_support(
		'editor-font-sizes',
		array(
			array(
				'name'      => esc_html__( 'Small', 'orfarm' ),
				'shortName' => esc_html__( 'S', 'orfarm' ),
				'size'      => 12,
				'slug'      => 'small',
			),
			array(
				'name'      => esc_html__( 'Normal', 'orfarm' ),
				'shortName' => esc_html__( 'M', 'orfarm' ),
				'size'      => 14,
				'slug'      => 'normal',
			),
			array(
				'name'      => esc_html__( 'Large', 'orfarm' ),
				'shortName' => esc_html__( 'L', 'orfarm' ),
				'size'      => 24,
				'slug'      => 'large',
			),
			array(
				'name'      => esc_html__( 'Huge', 'orfarm' ),
				'shortName' => esc_html__( 'XL', 'orfarm' ),
				'size'      => 28,
				'slug'      => 'huge',
			),
		)
	);
	// Editor color palette.
	add_theme_support(
		'editor-color-palette',
		array(
			array(
				'name'  => esc_html__( 'Primary', 'orfarm' ),
				'slug'  => 'primary',
				'color' => !empty($orfarm_opt['primary_color']) ? $orfarm_opt['primary_color'] : '#fcb700',
			),
			array(
				'name'  => esc_html__( 'Secondary', 'orfarm' ),
				'slug'  => 'secondary',
				'color' => !empty($orfarm_opt['primary_color2']) ? $orfarm_opt['primary_color2'] : '#fcb700',
			),
			array(
				'name'  => esc_html__( 'Dark Gray', 'orfarm' ),
				'slug'  => 'dark-gray',
				'color' => '#333333',
			),
			array(
				'name'  => esc_html__( 'Light Gray', 'orfarm' ),
				'slug'  => 'light-gray',
				'color' => '#a4a4a4',
			),
			array(
				'name'  => esc_html__( 'White', 'orfarm' ),
				'slug'  => 'white',
				'color' => '#FFF',
			),
		)
	);
	
	// thumbnails
	set_post_thumbnail_size( 1410, 9999 ); // Unlimited height, soft crop
	add_image_size( 'orfarm-category-thumb', 1410, 880, true ); // (cropped)
	add_image_size( 'orfarm-category-full', 1410, 880, true ); // (cropped)
	add_image_size( 'orfarm-post-thumb', 1410, 880, true ); // (cropped)
	add_image_size( 'orfarm-post-thumbwide', 500, 321, true ); // (cropped)
	
	if(class_exists('WooCommerce')){
		add_theme_support( 'wc-product-gallery-zoom' );
		add_theme_support( 'wc-product-gallery-lightbox' );
		add_theme_support( 'wc-product-gallery-slider' );
	}
}
function orfarm_register_url($link){
    return '<a href="' . get_permalink( get_option('woocommerce_myaccount_page_id') ) . '">'. esc_html__('Register', 'orfarm') .'</a>';
}
add_filter('register','orfarm_register_url');

/**
 * Add a pingback url auto-discovery header for single posts, pages, or attachments.
 */
function orfarm_header_link() {
	$orfarm_opt = get_option( 'orfarm_opt' );
	if ( is_singular() && pings_open() ) {
		printf( '<link rel="pingback" href="%s">', esc_url( get_bloginfo( 'pingback_url' ) ) );
	}
}
add_action( 'wp_head', 'orfarm_header_link' );

/**
* TGM-Plugin-Activation
*/
add_action( 'tgmpa_register', 'orfarm_register_required_plugins'); 
function orfarm_register_required_plugins(){
	$plugins = array(
				array(
					'name'               => esc_html__('LionThemes Helper', 'orfarm'),
					'slug'               => 'lionthemes-helper',
					'source'             => get_template_directory() . '/plugins/lionthemes-helper.zip',
					'required'           => true,
				),
				array(
					'name'               => esc_html__('Elementor Page Builder', 'orfarm'),
					'slug'               => 'elementor',
					'required'           => true,
				),
				array(
					'name'               => esc_html__('Revolution Slider', 'orfarm'),
					'slug'               => 'revslider',
					'required'           => true,
					'source'       => 'https://blueskytechco.com/plugins/revslider.zip', 
				),
				array(
					'name'               => esc_html__('Variation Swatches for WooCommerce', 'orfarm'),
					'slug'               => 'woo-variation-swatches',
					'required'           => false,
				),
				// Plugins from the Online WordPress Plugin
				array(
					'name'      => esc_html__('WooCommerce', 'orfarm'),
					'slug'      => 'woocommerce',
					'required'  => true,
				),
				array(
					'name'		=> esc_html__('Redux Framework', 'orfarm'),
					'slug'		=> 'redux-framework',
					'required'	=> true,
				),
				array(
					'name'      => esc_html__('Contact Form 7', 'orfarm'),
					'slug'      => 'contact-form-7',
					'required'  => false,
				),
				array(
					'name'      => esc_html__('MailChimp for WP', 'orfarm'),
					'slug'      => 'mailchimp-for-wp',
					'required'  => false,
				),
				array(
					'name'      => esc_html__('YITH WooCommerce Wishlist', 'orfarm'),
					'slug'      => 'yith-woocommerce-wishlist',
					'required'  => false,
				),
				array(
					'name'      => esc_html__('YITH WooCommerce Compare', 'orfarm'),
					'slug'      => 'yith-woocommerce-compare',
					'required'  => false,
				),
				array(
					'name'      => esc_html__('Smash Balloon Instagram Feed', 'orfarm'),
					'slug'      => 'instagram-feed',
					'required'  => false,
				),
				array(
					'name'      => esc_html__('Wiget import export', 'orfarm'),
					'slug'      => 'widget-importer-exporter',
					'required'  => false,
				),
				array(
					'name'      => esc_html__('SVG Support', 'orfarm'),
					'slug'      => 'svg-support',
					'required'  => false,
				),
			);
			
	/**
	 * Array of configuration settings. Amend each line as needed.
	 * If you want the default strings to be available under your own theme domain,
	 * leave the strings uncommented.
	 * Some of the strings are added into a sprintf, so see the comments at the
	 * end of each line for what each argument will be.
	 */
	$config = array(
		'default_path' => '',                      // Default absolute path to pre-packaged plugins.
		'menu'         => 'tgmpa-install-plugins', // Menu slug.
		'has_notices'  => true,                    // Show admin notices or not.
		'dismissable'  => true,                    // If false, a user cannot dismiss the nag message.
		'dismiss_msg'  => '',                      // If 'dismissable' is false, this message will be output at top of nag.
		'is_automatic' => false,                   // Automatically activate plugins after installation or not.
		'message'      => '',                      // Message to output right before the plugins table.
		'strings'      => array(
			'page_title'                      => esc_html__( 'Install Required Plugins', 'orfarm' ),
			'menu_title'                      => esc_html__( 'Install Plugins', 'orfarm' ),
			'installing'                      => esc_html__( 'Installing Plugin: %s', 'orfarm' ), // %s = plugin name.
			'oops'                            => esc_html__( 'Something went wrong with the plugin API.', 'orfarm' ),
			'notice_can_install_required'     => _n_noop( 'This theme requires the following plugin: %1$s.', 'This theme requires the following plugins: %1$s.', 'orfarm' ),
			'notice_can_install_recommended'  => _n_noop( 'This theme recommends the following plugin: %1$s.', 'This theme recommends the following plugins: %1$s.', 'orfarm' ), // %1$s = plugin name(s).
			'notice_cannot_install'           => _n_noop( 'Sorry, but you do not have the correct permissions to install the %s plugin. Contact the administrator of this site for help on getting the plugin installed.', 'Sorry, but you do not have the correct permissions to install the %s plugins. Contact the administrator of this site for help on getting the plugins installed.', 'orfarm' ), // %1$s = plugin name(s).
			'notice_can_activate_required'    => _n_noop( 'The following required plugin is currently inactive: %1$s.', 'The following required plugins are currently inactive: %1$s.', 'orfarm' ), // %1$s = plugin name(s).
			'notice_can_activate_recommended' => _n_noop( 'The following recommended plugin is currently inactive: %1$s.', 'The following recommended plugins are currently inactive: %1$s.', 'orfarm' ), // %1$s = plugin name(s).
			'notice_cannot_activate'          => _n_noop( 'Sorry, but you do not have the correct permissions to activate the %s plugin. Contact the administrator of this site for help on getting the plugin activated.', 'Sorry, but you do not have the correct permissions to activate the %s plugins. Contact the administrator of this site for help on getting the plugins activated.', 'orfarm' ), // %1$s = plugin name(s).
			'notice_ask_to_update'            => _n_noop( 'The following plugin needs to be updated to its latest version to ensure maximum compatibility with this theme: %1$s.', 'The following plugins need to be updated to their latest version to ensure maximum compatibility with this theme: %1$s.', 'orfarm' ), // %1$s = plugin name(s).
			'notice_cannot_update'            => _n_noop( 'Sorry, but you do not have the correct permissions to update the %s plugin. Contact the administrator of this site for help on getting the plugin updated.', 'Sorry, but you do not have the correct permissions to update the %s plugins. Contact the administrator of this site for help on getting the plugins updated.', 'orfarm' ), // %1$s = plugin name(s).
			'install_link'                    => _n_noop( 'Begin installing plugin', 'Begin installing plugins', 'orfarm' ),
			'activate_link'                   => _n_noop( 'Begin activating plugin', 'Begin activating plugins', 'orfarm' ),
			'return'                          => esc_html__( 'Return to Required Plugins Installer', 'orfarm' ),
			'plugin_activated'                => esc_html__( 'Plugin activated successfully.', 'orfarm' ),
			'complete'                        => esc_html__( 'All plugins installed and activated successfully. %s', 'orfarm' ), // %s = dashboard link.
			'nag_type'                        => 'updated' // Determines admin notice type - can only be 'updated', 'update-nag' or 'error'.
		)
	);
	tgmpa( $plugins, $config );
}

add_action( 'admin_footer', 'orfarm_opt_store_template' );
function orfarm_opt_store_template() {
	$post_url = add_query_arg( array( 
				    'page' => '_options', 
				    'tab' => $_GET['tab'] 
				), admin_url( 'admin.php' ) );
	$home_orfarm = array(
		'default'=> 'Default',
	    'home-shop-1'=> 'Home page',
		'home-shop-2'=>'Home page 2',
		'home-shop-3'=>'Home page 3',
		'home-shop-4'=>'Home page 4',
		'home-shop-5'=>'Home page 5',
		'home-shop-6'=>'Home page 6'
    );	
				
	$html ='';
	$html .='<div class="redux-home_setting" style="position:absolute; top: 8px; left:50%;">';
			$html .='<select id="redux-home_setting" name="orfarm_opt[home_setting]"> ';

				foreach ($home_orfarm as $slug=>$page) { 
					$select = false;
					if( isset( $_GET['slug_home'] ) && $slug == $_GET['slug_home'] ) { 
						$select = "selected=selected";
					}
			        $html .='<option value ="'.$slug.'" '.$select.'>'.$page.'</option>';		
			    }
			$html .='</select>';
	$html .='</div>';
?>
	<script type ="text/javascript">
	
	function html_block (enable, id1, id2) {
		if( enable == 1 ) {
			id1.hide();
			id2.show();
			id1.parent().parent().find('th').hide();
			id2.parent().parent().find('th').show();
		} else {
			id1.show();
			id2.hide();
			id1.parent().parent().find('th').show();
			id2.parent().parent().find('th').hide();
	
		}
	}
	jQuery(document).ready(function ($) { 
		$('#redux-sticky').append('<?php echo html_entity_decode($html); ?>');
		$('#redux-home_setting').change(function() {
			var selected = $(this).val();
			if(selected =='default') {
			 var option_url = "<?php echo esc_url($post_url); ?>";
			} else {
			 var option_url = "<?php echo esc_url($post_url); ?>"+'&slug_home='+selected;
			}
			window.location.href = option_url;
		});
		// html block on single product page
		$('#orfarm_opt-enable_tab_html .switch-options').click(function() { 
			var enable_tab_html = $('#enable_tab_html').val();
			html_block(enable_tab_html,$('#orfarm_opt-tab_des_1'),$('#orfarm_opt-tab_html_1'));
		});
		$('#orfarm_opt-enable_tab_2_html .switch-options').click(function() { 
			var enable_tab_html = $('#enable_tab_2_html').val();
			html_block(enable_tab_html,$('#orfarm_opt-tab_des_2'),$('#orfarm_opt-tab_html_2'));
		});
		$('#orfarm_opt-enable_tab_3_html .switch-options').click(function() { 
			var enable_tab_html = $('#enable_tab_3_html').val();
			html_block(enable_tab_html,$('#orfarm_opt-tab_des_3'),$('#orfarm_opt-tab_html_3'));
		});
		var enable_tab_html = $('#enable_tab_html').val();
			html_block(enable_tab_html,$('#orfarm_opt-tab_des_1'),$('#orfarm_opt-tab_html_1'));
		var enable_tab_html = $('#enable_tab_2_html').val();
			html_block(enable_tab_html,$('#orfarm_opt-tab_des_2'),$('#orfarm_opt-tab_html_2'));
		var enable_tab_html = $('#enable_tab_3_html').val();
			html_block(enable_tab_html,$('#orfarm_opt-tab_des_3'),$('#orfarm_opt-tab_html_3'));
	})
	</script>
<?php 		


}