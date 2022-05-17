<?php

/**
 * ReduxFramework Sample Config File
 * For full documentation, please visit: https://docs.reduxframework.com
 * */

if (!class_exists('Orfarm_Theme_Config')) {

    class Orfarm_Theme_Config {

        public $args        = array();
        public $sections    = array();
        public $theme;
        public $ReduxFramework;

        public function __construct() {

            if (!class_exists('ReduxFramework')) {
                return;
            }

            // This is needed. Bah WordPress bugs.  ;)
            if (  true == Redux_Helpers::isTheme(__FILE__) ) {
                $this->initSettings();
            } else {
                add_action('plugins_loaded', array($this, 'initSettings'), 10);
            }

        }

        public function initSettings() { 

            // Just for demo purposes. Not needed per say.
            $this->theme = wp_get_theme();

            // Set the default arguments
            $this->setArguments();

            // Set a few help tabs so you can see how it's done
            $this->setHelpTabs();

            // Create the sections and fields
            $this->setSections();

            if (!isset($this->args['opt_name'])) {
                return;
            }
			// fix import/export  
			

			// if(isset( $_SERVER['REQUEST_URI'])) {
				// $path = $_SERVER['REQUEST_URI']; 
				// $path = parse_url($path);
				// parse_str($path['query'], $params);
				// if(isset( $params['action'] ) ) {
					// $action = $params['action'];
					// $action = explode('redux_download_options-',$action);
					// if(isset( $action['1'] ) )
						// $this->args['opt_name'] =  $action['1']; 
				// }
			// }   
            $this->ReduxFramework = new ReduxFramework($this->sections, $this->args);
        }

        function compiler_action($options, $css, $changed_values) {
            echo '<h1>The compiler hook has run!</h1>';
            echo "<pre>";
            print_r($changed_values);
            echo "</pre>";
        }

        function dynamic_section($sections) {
            $sections[] = array(
                'title' => esc_html__('Section via hook', 'orfarm'),
                'desc' => esc_html__('<p class="description">This is a section created by adding a filter to the sections array. Can be used by child themes to add/remove sections from the options.</p>', 'orfarm'),
                'icon' => 'el-icon-paper-clip',
                'fields' => array()
            );

            return $sections;
        }

        function change_arguments($args) {

            return $args;
        }

        function change_defaults($defaults) {
            $defaults['str_replace'] = 'Testing filter hook!';

            return $defaults;
        }

        function remove_demo() {

            if (class_exists('ReduxFrameworkPlugin')) {
                remove_action('admin_notices', array(ReduxFrameworkPlugin::instance(), 'admin_notices'));
            }
        }

        public function setSections() {

            ob_start();

            $ct             = wp_get_theme();
            $this->theme    = $ct;
            $item_name      = $this->theme->get('Name');
            $tags           = $this->theme->Tags;
            $screenshot     = $this->theme->get_screenshot();
            $class          = $screenshot ? 'has-screenshot' : '';

            $customize_title = sprintf(esc_html__('Customize &#8220;%s&#8221;', 'orfarm'), $this->theme->display('Name'));
            
            ?>
            <div id="current-theme" class="<?php echo esc_attr($class); ?>">
            <?php if ($screenshot) : ?>
                <?php if (current_user_can('edit_theme_options')) : ?>
                        <a href="<?php echo wp_customize_url(); ?>" class="load-customize hide-if-no-customize" title="<?php echo esc_attr($customize_title); ?>">
                            <img src="<?php echo esc_url($screenshot); ?>" alt="<?php esc_attr_e('Current theme preview', 'orfarm'); ?>" />
                        </a>
                <?php endif; ?>
                    <img class="hide-if-customize" src="<?php echo esc_url($screenshot); ?>" alt="<?php esc_attr_e('Current theme preview', 'orfarm'); ?>" />
                <?php endif; ?>

                <h4><?php echo esc_html($this->theme->display('Name')); ?></h4>

                <div>
                    <ul class="theme-info">
                        <li><?php printf(esc_html__('By %s', 'orfarm'), $this->theme->display('Author')); ?></li>
                        <li><?php printf(esc_html__('Version %s', 'orfarm'), $this->theme->display('Version')); ?></li>
                        <li><?php echo '<strong>' . esc_html__('Tags', 'orfarm') . ':</strong> '; ?><?php printf($this->theme->display('Tags')); ?></li>
                    </ul>
                    <p class="theme-description"><?php echo esc_html($this->theme->display('Description')); ?></p>
            <?php
            if ($this->theme->parent()) {
                printf(' <p class="howto">' . esc_html__('This <a href="%1$s">child theme</a> requires its parent theme, %2$s.', 'orfarm') . '</p>', esc_html__('http://codex.wordpress.org/Child_Themes', 'orfarm'), $this->theme->parent()->display('Name'));
            }
            ?>

                </div>
            </div>

            <?php
            $item_info = ob_get_contents();

            ob_end_clean();

            $sampleHTML = '';
           
			$form_options = array();
			if(class_exists('WYSIJA')){
				$wysija_model_forms = WYSIJA::get('forms', 'model');
				$wysija_forms = $wysija_model_forms->getRows();
				foreach($wysija_forms as $wysija_form){
					$form_options[$wysija_form['form_id']] = esc_html($wysija_form['name']);
				}
			}
			$orfarm_url = get_template_directory_uri(); 
			
            // General
            $this->sections[] = array(
                'title'     => esc_html__('General', 'orfarm'),
                'desc'      => esc_html__('General theme options', 'orfarm'),
                'icon'      => 'el-icon-cog',
                'fields'    => array(

                   
					
					array(
                        'id'       => 'sticky_icons',
                        'type'     => 'checkbox',
                        'title'    => esc_html__('Sticky icon', 'orfarm'),
                        'options'  => array(
							'home' => esc_html__('Home', 'orfarm'),
                            'account' => esc_html__('Account', 'orfarm'),
                            'menu' => esc_html__('Menu', 'orfarm'),
                            'wishlist' => esc_html__('Wishlist', 'orfarm'),
                            'cart' => esc_html__('Mini cart', 'orfarm'),
                        ),
                        'default' => array(
                            'account' => '1',
							'menu' => '1',
                            'wishlist' => '1',
                            'cart' => '1',
                            'home' => '1',
                        )
                    ),
					array(
						'id'=>'popup_login_info',
						'type' => 'textarea',
						'title' => esc_html__('Poup login information', 'orfarm'), 
						'subtitle'         => esc_html__('Poup login information', 'orfarm'),
						'default' => '
							<p class="message">By providing  your email address, you agree to  our 
								<a href="#">Privacy Policy</a> and 	<a href="#">Term of sevices</a>
							</p>
						',
					),
                ),
            );
			
			// Page title option 
            $this->sections[] = array(
                'title'     => esc_html__('Page title', 'orfarm'),
                'desc'      => esc_html__('Page title options.', 'orfarm'),
                'icon'      => 'el-icon-wrench',
                'fields'    => array(
					array(
						'id'       => 'page_title_layout',
						'type'     => 'image_select',
						'title'    => __('Page title design', 'orfarm'), 
						'subtitle' => __('Select page title section design or disable it completely on all pages', 'orfarm'),
						'options'  => array(
							'left'      => array(
								'alt'   => 'Left', 
								'img'   => $orfarm_url.'/images/default.jpg'
							),
							'center'      => array(
								'alt'   => 'Center', 
								'img'  => $orfarm_url.'/images/center.jpg'
							),
							'none'      => array(
								'alt'   => 'Disabled', 
								'img'   => $orfarm_url.'/images/disable.jpg'
							)
						),
						'default' => 'none'
					),
					array(
                        'id'        => 'page_title_size',
                        'type'      => 'select',
                        'title'     => esc_html__('Page title size', 'orfarm'),
						'subtitle'  => esc_html__('You can set your  different sizes for page title', 'orfarm'),
                        'options'   => array(
                            'size-inherit' => 'Inherit',
							'size-default' => 'Default',
                            'size-small' => 'Small',
                            'size-large' => 'Large',
                        ),
                        'default'   => 'size-inherit'
                    ),
					array(
					'id'        => 'title_bg',
					'type'      => 'background',
					'output'    => array('.default-entry-header'),
					'title'     => esc_html__('Image for page title', 'orfarm'),
					'subtitle'  => esc_html__('Upload image or select color. Only work with box layout', 'orfarm'),
					),
					array(
                        'id'        => 'page_title_color',
                        'type'      => 'select',
                        'title'     => esc_html__('Text color for title', 'orfarm'),
						'subtitle'  => esc_html__('Choose which HTML tag to use for the page title.', 'orfarm'),
                        'options'   => array(
                            'color-scheme-default' => esc_html__('Default', 'orfarm'),
                            'color-scheme-light' => esc_html__('Light', 'orfarm'),
                            'color-scheme-dark' => esc_html__('Dark', 'orfarm'),
                        ),
                        'default'   => 'color-scheme-dark'
                    ),
					array(
                        'id'        => 'page_title_tag',
                        'type'      => 'select',
                        'title'     => esc_html__('Page Title tag', 'orfarm'),
						'subtitle'  => esc_html__('Choose which HTML tag to use for the page title.', 'orfarm'),
                        'options'   => array(
                            'default' => 'Default',
                            'h1' => 'H1',
                            'h2' => 'H2',
                            'h3' => 'H3',
                            'h4' => 'H4',
                            'h4' => 'H5',
                            'h6' => 'H6',
                            'p' =>  'P',
                            'div' => 'Div',
                            'span' => 'Span',
                        ),
                        'default'   => 'h1'
                    ),
					array(
                        'id'        => 'page_breadcrumb',
                        'type'      => 'switch',
                        'title'     => esc_html__('Show breadcrumbs', 'orfarm'),
						'desc'      => esc_html__('Displays a full chain of links to the current page.', 'orfarm'),
						'default'   => true,
                    ),
                ),
            );
			$home_defaul = array();
			if(!isset($_GET['slug_home'])) {
				$home_defaul  = array(
							'id'        => 'home_default',
							'type'      => 'select',
							'title'     => esc_html__('Home Default', 'orfarm'),
							'options'   => array(
								'default'=> 'Default',
								'home-shop-1'=> 'Home page',
								'home-shop-2'=>'Home page 2',
								'home-shop-3'=>'Home page 3',
								'home-shop-4'=>'Home page 4',
								'home-shop-5'=>'Home page 5',
								'home-shop-6'=>'Home page 6'
							),
							'default'   => 'home-shop-1'
						);
			}		
			// Colors
            $this->sections[] = array(
                'title'     => esc_html__('Colors', 'orfarm'),
                'desc'      => esc_html__('Color options', 'orfarm'),
                'icon'      => 'el-icon-tint',
                'fields'    => array(
					$home_defaul,
					array(
                        'id'        => 'primary_color',
                        'type'      => 'color',
                        'title'     => esc_html__('Primary Color', 'orfarm'),
                        'subtitle'  => esc_html__('Pick a color for primary color (default: #96AE00).', 'orfarm'),
						'transparent' => false,
                        'default'   => '#96AE00',
                        'validate'  => 'color',
                    ),
					array(
                        'id'        => 'link_color',
                        'type'      => 'color',
                        'title'     => esc_html__('Link a Color', 'orfarm'),
                        'subtitle'  => esc_html__('Pick a color for link a Color (default: #4f4f4f).', 'orfarm'),
                        'transparent' => false,
                        'default'   => '#4f4f4f',
                        'validate'  => 'color',
                    ),
					array(
                        'id'        => 'sale_color',
                        'type'      => 'color',
                        'title'     => esc_html__('Sale Label BG Color', 'orfarm'),
                        'subtitle'  => esc_html__('Pick a color for bg sale label (default: #12B7CE).', 'orfarm'),
						'transparent' => true,
                        'default'   => '#12B7CE',
                        'validate'  => 'color',
                    ),
					
					array(
                        'id'        => 'saletext_color',
                        'type'      => 'color',
                        'title'     => esc_html__('Sale Label Text Color', 'orfarm'),
                        'subtitle'  => esc_html__('Pick a color for sale label text (default: #ffffff).', 'orfarm'),
						'transparent' => false,
                        'default'   => '#ffffff',
                        'validate'  => 'color',
                    ),
					
					array(
                        'id'        => 'rate_color',
                        'type'      => 'color',
                        'title'     => esc_html__('Rating Star Color', 'orfarm'),
                        'subtitle'  => esc_html__('Pick a color for star of rating (default: #FFB800).', 'orfarm'),
						'transparent' => false,
                        'default'   => '#FFB800',
                        'validate'  => 'color',
                    ),
					
					array(
                        'id'        => 'price_color',
                        'type'      => 'color',
                        'title'     => esc_html__('Price Label Text Color', 'orfarm'),
                        'subtitle'  => esc_html__('Pick a color for price label text (default: #EA0D42).', 'orfarm'),
						'transparent' => false,
                        'default'   => '#EA0D42',
                        'validate'  => 'color',
                    ),
					
					array(
                        'id'        => 'old_price_color',
                        'type'      => 'color',
                        'title'     => esc_html__('Old Price Color', 'orfarm'),
                        'subtitle'  => esc_html__('Pick a color for old price (default: #999999).', 'orfarm'),
						'transparent' => false,
                        'default'   => '#999999',
                        'validate'  => 'color',
                    ),
                    array(
                        'id'        => 'button_background_color',
                        'type'      => 'color',
                        'title'     => esc_html__('Button background color', 'orfarm'),
                        'subtitle'  => esc_html__('Pick a color for price label text (default: #96ae00).', 'orfarm'),
                        'transparent' => false,
                        'default'   => '#96ae00',
                        'validate'  => 'color',
                    ),
                    array(
                        'id'        => 'button_color',
                        'type'      => 'color',
                        'title'     => esc_html__('Button color', 'orfarm'),
                        'subtitle'  => esc_html__('Pick a color for price label text (default: #fff).', 'orfarm'),
                        'transparent' => false,
                        'default'   => '#ffffff',
                        'validate'  => 'color',
                    ),
                ),
            );
			
			//Fonts
			$this->sections[] = array(
                'title'     => esc_html__('Fonts', 'orfarm'),
                'desc'      => esc_html__('Fonts options', 'orfarm'),
                'icon'      => 'el-icon-font',
                'fields'    => array(
                    array(
                        'id'            => 'bodyfont',
                        'type'          => 'typography',
                        'title'         => esc_html__('Body font', 'orfarm'),
                        'google'        => true,
                        'font-backup'   => false,
                        'subsets'       => false,
						'text-align'   => false,
                        'line-height'   => false,
                        'all_styles'    => true,
                        'units'         => 'px',
                        'subtitle'      => esc_html__('Main body font.', 'orfarm'),
                        'default'       => array(
                            'color'         => '#4D5574',
                            'font-weight'    => '400',
                            'font-family'   => 'Jost',
                            'google'        => true,
                            'font-size'     => '16px',
						),
                    ),
					array(
                        'id'        => 'background_opt',
                        'type'      => 'background',
                        'output'    => array('body'),
                        'title'     => esc_html__('Body background', 'orfarm'),
                        'subtitle'  => esc_html__('Upload image or select color. Only work with box layout', 'orfarm'),
						'default'   => array('background-color' => '#F2F2F6'),
                    ),
					array(
                        'id'            => 'headingfont',
                        'type'          => 'typography',
                        'title'         => esc_html__('Heading font', 'orfarm'),
                        'google'        => true, 
                        'font-backup'   => false,
                        'subsets'       => false,
                        'font-size'     => false,
                        'line-height'   => false,
						'text-align'   => false,
                        'all_styles'    => true,
                        'units'         => 'px',
                        'subtitle'      => esc_html__('Heading font.', 'orfarm'),
                        'default'       => array(
							'color'         => '#2D2A6E',
                            'font-weight'    => '700',
                            'font-family'   => 'Quicksand',
                            'google'        => true,
						),
                    ),
                ),
            );
			
			//Header
			$this->sections[] = array(
                'title'     => esc_html__('Header', 'orfarm'),
                'desc'      => esc_html__('Header options', 'orfarm'),
                'icon'      => 'el-icon-tasks',
                'fields'    => array(

					array(
                        'id'        => 'header_layout',
                        'type'      => 'select',
                        'title'     => esc_html__('Header Layout', 'orfarm'),
                        'options'   => array(
                            'first' => 'First (Default)',
							'second' => 'Second',
                            'third' => 'Third',
                            'four' => 'Four',
                        ),
                        'default'   => 'first'
                    ),

					array(
                        'id'        => 'logo_main',
                        'type'      => 'media',
                        'title'     => esc_html__('Logo', 'orfarm'),
                        'compiler'  => 'true',
                        'readonly'      => false,
                        'desc'      => esc_html__('Upload logo here.', 'orfarm'),
                    ),
					array(
                        'id'        => 'max_logo_width',
                        'type'      => 'slider',
                        'title'     => esc_html__('Max logo width (for retina)', 'orfarm'),
                        'default'   => 130,
						'min'       => 50,
						'step'      => 5,
						'max'       => 400,
						'display_value' => 'text'
                    ),
					array(
                        'id'        => 'opt-favicon',
                        'type'      => 'media',
                        'title'     => esc_html__('Favicon', 'orfarm'),
                        'compiler'  => 'true',
                        'readonly'      => false,
                        'desc'      => esc_html__('Upload favicon here.', 'orfarm'),
                    ),

					array(
                        'id'        => 'enable_topbar',
                        'type'      => 'switch',
                        'title'     => esc_html__('Enable Topbar', 'orfarm'),
						'default'   => true,
                    ),
					array(
                        'id'        => 'hide_mobile_topbar',
                        'type'      => 'switch',
                        'title'     => esc_html__('Hide Topbar on Mobile', 'orfarm'),
						'default'   => true,
                    ),
					array(
                        'id'        => 'show_minicart',
                        'type'      => 'switch',
                        'title'     => esc_html__('Show minicart badge', 'orfarm'),
						'default'   => true,
                    ),
					array(
						'id'       => 'open_minicart',
						'type'     => 'switch',
						'title'    => esc_html__('Open cart side after added', 'orfarm'),
						'default'  => true,
					),
                    array(
						'id'=>'minicart_message_shipping',
						'type' => 'textarea',
						'title' => esc_html__('Message Shipping', 'orfarm'), 
						'subtitle'         => esc_html__('HTML tags allowed: a, img, br, em, span, strong, p, ul, li', 'orfarm'),
						'default' => '<p class="message">Free shipping on orders overs $90</p>',
					),
					array(
                        'id'        => 'header_background',
                        'type'      => 'background',
                        'output'    => array('header .header'),
                        'title'     => esc_html__('Header background', 'orfarm'),
                        'subtitle'  => esc_html__('Only apply for default header layout', 'orfarm'),
						'default'   => array('background-color' => '#ffffff'),
                    ),
					
					array(
                        'id'        => 'topbar_background',
                        'type'      => 'background',
                        'output'    => array('header .top-bar'),
                        'title'     => esc_html__('Topbar background', 'orfarm'),
                        'subtitle'  => esc_html__('Only apply for default header layout', 'orfarm'),
						'default'   => array('background-color' => '#2D2A6E'),
                    ),
					array(
                        'id'        => 'topbar_color',
                        'type'      => 'color',
                        'title'     => esc_html__('Topbar text color', 'orfarm'),
						'subtitle'  => esc_html__('Only apply for default header layout', 'orfarm'),
						'default'   => '#fff',
                    ),
					array(
                        'id'        => 'header_color',
                        'type'      => 'color',
                        'title'     => esc_html__('Header color', 'orfarm'),
						'subtitle'  => esc_html__('Only apply for default header layout', 'orfarm'),
						'default'   => '#2D2A6E',
                    ),
					array(
                        'id'        => 'header_icons_color',
                        'type'      => 'color',
                        'title'     => esc_html__('Header icons color', 'orfarm'),
						'subtitle'  => esc_html__('Only apply for default header layout', 'orfarm'),
						'default'   => '#2D2A6E',
                    ),
                ),
            );
			$this->sections[] = array(
				'icon'       => 'el-icon-magic',
				'title'      => esc_html__( 'Main Menu', 'orfarm' ),
				'subsection' => true,
				'fields'     => array(
					array(
                        'id'        => 'sticky_header',
                        'type'      => 'switch',
                        'title'     => esc_html__('Sticky Menu', 'orfarm'),
						'default'   => true,
                    ),
					array(
                        'id'            => 'menufont',
                        'type'          => 'typography',
                        'title'         => esc_html__('Menu font', 'orfarm'),
                        'google'        => true,
                        'font-backup'   => false,
                        'subsets'       => false,
                        'font-size'     => true,
                        'line-height'   => false,
						'text-align'   => false,
                        'all_styles'    => true, 
                        'units'         => 'px', 
                        'subtitle'      => esc_html__('Menu font.', 'orfarm'),
                        'default'       => array(
							'color'         => '#2D2A6E',
                            'font-weight'    => '600',
                            'font-family'   => 'Jost',
							'font-size'     => '13px',
                            'google'        => true,
						),
                    ),
					array(
                        'id'        => 'sticky_bg',
                        'type'      => 'color',
                        'title'     => esc_html__('Sticky background color', 'orfarm'),
						'default'   => '#ffffff',
                    ),
					array(
                        'id'        => 'sticky_color',
                        'type'      => 'color',
                        'title'     => esc_html__('Sticky menu color', 'orfarm'),
						'default'   => '#2d2a6e',
                    ),
					array(
                        'id'        => 'sub_menu_bg',
                        'type'      => 'color',
                        'title'     => esc_html__('Submenu background', 'orfarm'),
                        'subtitle'  => esc_html__('Pick a color for sub menu bg (default: #ffffff).', 'orfarm'),
						'transparent' => false,
                        'default'   => '#ffffff',
                        'validate'  => 'color',
                    ),
					array(
                        'id'        => 'sub_menu_color',
                        'type'      => 'color',
                        'title'     => esc_html__('Submenu color', 'orfarm'),
                        'subtitle'  => esc_html__('Pick a color for sub menu color (default: #334763).', 'orfarm'),
						'transparent' => false,
                        'default'   => '#334763',
                        'validate'  => 'color',
                    ),
				)
			);
			
		
			//Footer
			$this->sections[] = array(
                'title'     => esc_html__('Footer', 'orfarm'),
                'desc'      => esc_html__('Footer options', 'orfarm'),
                'icon'      => 'el-icon-cog',
                'fields'    => array(
					array(
                        'id'        => 'footer_layout',
                        'type'      => 'select',
                        'title'     => esc_html__('Footer Elementor Layout', 'orfarm'),
                        'data'  => 'posts',
                        'args'  => array(
                            'posts_per_page' => -1,
                            'orderby'        => 'title',
                            'order'          => 'ASC',
							'post_type'		 => 'lionthemes_block'
                        )
                    ),
					array(
                        'id'        => 'back_to_top',
                        'type'      => 'switch',
                        'title'     => esc_html__('Back To Top', 'orfarm'),
						'desc'      => esc_html__('Show back to top button on all pages', 'orfarm'),
						'default'   => true,
                    ),
					array(
                        'id'        => 'enable_footer',
                        'type'      => 'switch',
                        'title'     => esc_html__('Enable Footer', 'orfarm'),
						'desc'      => esc_html__('Enable/Disabled Footer', 'orfarm'),
						'default'   => true,
                    ),
                ),
            );		
			//Social Icons
			$this->sections[] = array(
                'title'     => esc_html__('Social Icons', 'orfarm'),
                'desc'      => esc_html__('This setting for social icons.', 'orfarm'),
                'icon'      => 'el-icon-website',
                'fields'    => array(
					array(
						'id'       => 'social_icons',
						'type'     => 'sortable',
						'title'    => esc_html__('Social Icons', 'orfarm'),
						'subtitle' => esc_html__('Enter social links', 'orfarm'),
						'desc'     => esc_html__('Drag/drop to re-arrange', 'orfarm'),
						'mode'     => 'text',
						'options'  => array(
							'facebook'     => '',
							'twitter'     => '',
							'google-plus'     => '',
							'youtube'     => '',
							'pinterest'     => '',
							'mail-to' => '',
							'instagram' => '',
							'tumblr'     => '',
							'linkedin'     => '',
							'behance'     => '',
							'dribbble'     => '',							
							'vimeo'     => '',
							'rss'     => '',
							'vk'     => '',
                            'skype' => '',
							
						),
						'default' => array(
							'twitter'     => '#twitter.com',
						    'facebook'     => '#facebook',
							'pinterest'     => '#pinterest',
							'youtube'     => '#youtube',
							'skype' => '#skype',
						),
					),
				)
			);
			

			// Layout
            $this->sections[] = array(
                'title'     => esc_html__('Layout', 'orfarm'),
                'desc'      => esc_html__('Select page layout: Box or Full Width', 'orfarm'),
                'icon'      => 'el-icon-align-justify',
                'fields'    => array(
					array(
						'id'       => 'page_layout',
						'type'     => 'select',
						'multi'    => false,
						'title'    => esc_html__('Page Layout', 'orfarm'),
						'options'  => array(
							'full' => 'Full Width',
							'box' => 'Box'
						),
						'default'  => 'full'
					),
					array(
						'id'        => 'box_layout_width',
						'type'      => 'slider',
						'title'     => esc_html__('Box layout width home page', 'orfarm'),
						'desc'      => esc_html__('Box layout width in pixels, default value: 1430', 'orfarm'),
						"default"   => 1430,
						"min"       => 960,
						"step"      => 1,
						"max"       => 1920,
						'display_value' => 'text'
					),
                ),
            );
		
			// Products
            $this->sections[] = array(
                'title'     => esc_html__('Products', 'orfarm'),
                'desc'      => esc_html__('Use this section to select options for product', 'orfarm'),
                'icon'      => 'el-icon-tags',
                'fields'    => array(
					array(
						'id'       => 'sidebarshop_pos',
						'type'     => 'image_select',
						'title'    => __('Sidebar', 'orfarm'), 
						'subtitle' => __('Sidebar on archive pages.', 'orfarm'),
						'options'  => array(
							'left'      => array(
								'alt'   => 'Left', 
								'img'   => $orfarm_url.'/images/sidebar_left.png'
							),
							'right'      => array(
								'alt'   => 'Right', 
								'img'  => $orfarm_url.'/images/sidebar_right.png'
							),
							'canvas'      => array(
								'alt'   => 'Canvas', 
								'img'   => $orfarm_url.'/images/filter_canvas.png'
							),
							'shop-filters'      => array(
								'alt'  => 'Shop Filters V1', 
								'img'  => $orfarm_url.'/images/filters_v1.png'
							),
								'shop-filters-v2'      => array(
								'alt'  => 'Shop Filters V2', 
								'img'  => $orfarm_url.'/images/filters_v2.png'
							),
								'shop-filters-left'      => array(
								'alt'  => 'Shop Filters Left', 
								'img'  => $orfarm_url.'/images/sidebar_left.png'
							),
								'none'      => array(
								'alt'  => 'None', 
								'img'  => $orfarm_url.'/images/none.png'
							)
						),
						'default' => 'left'
					),
					array(
							'id'       => 'default_view',
							'type'     => 'image_select',
							'title'    => __('Shop default view', 'orfarm'), 
							'subtitle' => __('Select the layout for list/grid view.', 'orfarm'),
							'options'  => array(
								'col2-view'      => array(
									'alt'   => 'Two Columns View', 
									'img'   => $orfarm_url.'/images/col2.png'
								),
								'col3-view'      => array(
									'alt'   => 'Three Columns View', 
									'img'  => $orfarm_url.'/images/col3.png'
								),
								'col4-view'      => array(
									'alt'   => 'Four Columns View', 
									'img'   => $orfarm_url.'/images/col4.png'
								),
								'col5-view'      => array(
									'alt'   => 'Five Columns View', 
									'img'   => $orfarm_url.'/images/col5.png'
								),
								'list-view'      => array(
									'alt'  => 'List view', 
									'img'  => $orfarm_url.'/images/list.png'
								)
							),
							'default' => '4'
					),
					
					array(
						'id'       => 'shop_tablet_view',
						'type'     => 'image_select',
						'title'    => __('Tablet view', 'orfarm'), 
						'subtitle' => __('Select the layout for list/grid view.', 'orfarm'),
						'options'  => array(
							'col1-view'      => array(
								'alt'   => 'One Column View', 
								'img'   => $orfarm_url.'/images/col1.png'
							),
							'col2-view'      => array(
								'alt'   => 'Two Columns View', 
								'img'  => $orfarm_url.'/images/col2.png'
							),
							'col3-view'      => array(
								'alt'   => 'Three Columns View', 
								'img'   => $orfarm_url.'/images/col3.png'
							),
							'col4-view'      => array(
								'alt'   => 'Four Columns View', 
								'img'   => $orfarm_url.'/images/col4.png'
							),
							'list-view'      => array(
								'alt'  => 'List view', 
								'img'  => $orfarm_url.'/images/list.png'
							)
						),
						'default' => '2'
					),
					array(
						'id'       => 'shop_mobile_view',
						'type'     => 'image_select',
						'title'    => __('Mobile view', 'orfarm'), 
						'subtitle' => __('Select the layout for list/grid view.', 'orfarm'),
						'options'  => array(
							'col1-view'      => array(
								'alt'   => 'One Column View', 
								'img'   => $orfarm_url.'/images/col1.png'
							),
							'col2-view'      => array(
								'alt'   => 'Two Columns View', 
								'img'  => $orfarm_url.'/images/col2.png'
							),
							'col3-view'      => array(
								'alt'   => 'Three Columns View', 
								'img'   => $orfarm_url.'/images/col3.png'
							),
							'list-view'      => array(
								'alt'  => 'List view', 
								'img'  => $orfarm_url.'/images/list.png'
							)
						),
						'default' => 'col1-view'
					),
					array(
						'id'        => 'product_per_page',
						'type'      => 'slider',
						'title'     => esc_html__('Products per page', 'orfarm'),
						'subtitle'      => esc_html__('Amount of products per page on category page', 'orfarm'),
						"default"   => 12,
						"min"       => 4,
						"step"      => 1,
						"max"       => 80,
						'display_value' => 'text'
					),
					array(
						'id'        => 'product_spacing',
						'type'      => 'slider',
						'title'     => esc_html__('Space between products', 'orfarm'),
						'subtitle'      => esc_html__('You can set different spacing between blocks on shop page (only enter value 0,5,10...30)', 'orfarm'),
						"default"   => 5,
						"min"       => 0,
						"step"      => 5,
						"max"       => 30,
						'display_value' => 'text'
					),
					array(
						'id'       => 'enable_loadmore',
						'type'     => 'radio',
						'title'    => esc_html__('Load more ajax', 'orfarm'),
						'options'  => array(
							'' => esc_html__('Default pagination', 'orfarm'),
							'scroll-more' => esc_html__('Scroll to load more', 'orfarm'),
							'button-more' => esc_html__('Button load more', 'orfarm')
							),
						'default'  => ''
					),
					array(
                        'id'        => 'categories_search',
                        'type'      => 'select',
                        'title'     => esc_html__('Categories in search box', 'orfarm'),
                        'data'  => 'terms',
						'multi' => true,
						'args'  => array(
							'taxonomies' => array( 'product_cat' ),
							'hide_empty' => true,
						)
                    ),
					array(
						'id'       => 'enable_ajaxsearch',
						'type'     => 'switch',
						'title'    => esc_html__('Autocomplete Ajax Search', 'orfarm'),
						'desc'      => esc_html__('Apply for woocommerce search form plugin or header search form', 'orfarm'),
						'default'  => true,
					),
					array(
						'id'        => 'ajaxsearch_result_items',
						'type'      => 'slider',
						'title'     => esc_html__('Number of search results', 'orfarm'),
						'default'   => 6,
						'min'       => 2,
						'step'      => 2,
						'max'       => 20,
						'display_value' => 'text'
					),
					array(
						'id'       => 'second_image',
						'type'     => 'switch',
						'title'    => esc_html__('Use secondary product image', 'orfarm'),
						'desc'      => esc_html__('Show the secondary image when hover on product on list', 'orfarm'),
						'default'  => true,
					),
                    array(
                        'id'       => 'enable_rate',
                        'type'     => 'switch',
                        'title'    => esc_html__('Enable rating star', 'orfarm'),
                        'default'  => true,
                    ),
					array(
						'id'       => 'showlist_cats',
						'type'     => 'switch',
						'title'    => esc_html__('Show categories', 'orfarm'),
						'default'  => true,
					),
					array(
						'id'       => 'enable_quickview',
						'type'     => 'switch',
						'title'    => esc_html__('Quickview button', 'orfarm'),
						'default'  => true,
					),
					array(
						'id'       => 'enable_addcart',
						'type'     => 'switch',
						'title'    => esc_html__('Add to cart button', 'orfarm'),
						'default'  => true,
					),
					array(
						'id'       => 'enable_wishlist',
						'type'     => 'switch',
						'title'    => esc_html__('Wishlist button', 'orfarm'),
						'default'  => true,
					),
					array(
						'id'       => 'enable_compare',
						'type'     => 'switch',
						'title'    => esc_html__('Compare button', 'orfarm'),
						'default'  => true,
					),
					array(
						'id'       => 'enable_cate_products',
						'type'     => 'switch',
						'title'    => esc_html__('Categories in product', 'orfarm'),
						'default'  => true,
					),
                ),
            );
			
			$this->sections[] = array(
				'title'     => esc_html__('Products Label', 'orfarm'),
                'desc'      => esc_html__('', 'orfarm'),
                'icon'      => 'el-icon-tags',
				'subsection' => true,
                'fields'    => array(
					array(
						'id'       => 'products_label',
						'type'     => 'image_select',
						'title'    => __('Label design', 'orfarm'), 
						'subtitle' => __('Use this section to select label for product as sale, new product.', 'orfarm'),
						'options'  => array(
							'round'      => array(
								'alt'   => 'round', 
								'img'   => $orfarm_url.'/images/round.png'
							),
							'rectangle'      => array(
								'alt'   => 'Rectangle', 
								'img'  => $orfarm_url.'/images/rectangle.png'
							),
						
						),
						'default' => 'round'
					),
					array(
						'id'       => 'percentage_label',
						'type'     => 'switch',
						'title'    => esc_html__('Shop sale label in percentage', 'orfarm'),
						'subtitle'    => esc_html__('Works with Simple, Variable and External products only.', 'orfarm'),
						'default'  => true,
					),
					array(
						'id'       => 'enable_new_label',
						'type'     => 'switch',
						'title'    => esc_html__('"New" label on products', 'orfarm'),
						'default'  => true,
					),
					// array(
						// 'id'        => 'expired_new',
						// 'type'      => 'slider',
						// 'title'     => esc_html__('New Arrivals Range', 'orfarm'),
						// "default"   => 8,
						// "min"       => 1,
						// "step"      => 1,
						// "max"       => 100,
						// 'display_value' => 'text'
					// ),
					array(
						'id'       => 'enable_sale_label',
						'type'     => 'switch',
						'title'    => esc_html__('"Sale" label on products', 'orfarm'),
						'default'  => true,
					),
                )
			);
			
			$this->sections[] = array(
				'title'     => esc_html__('Products Style', 'orfarm'),
                'desc'      => esc_html__('', 'orfarm'),
                'icon'      => 'el-icon-tags',
				'subsection' => true,
                'fields'    => array(
					array(
						'id'       => 'products_style',
						'type'     => 'image_select',
						'title'    => __('Products Style', 'orfarm'), 
						'subtitle' => __('Use this section to select style for product.', 'orfarm'),
						'options'  => array(
							'hover'      => array(
								'alt'   => 'Show summary on hover', 
								'img'   => $orfarm_url.'/images/product-hover.jpg'
							),
							// 'standard'      => array(
							// 	'alt'   => 'Standard button', 
							// 	'img'  => $orfarm_url.'/images/standard.png'
							// ),
						
						),
						'default' => 'col1-view'
					)
                )
			);	
			
			
            $this->sections[] = array(
				'icon'       => 'el-icon-website',
				'title'      => esc_html__( 'Fake Order', 'orfarm' ),
				'subsection' => true,
				'fields'     => array(
                    array(
						'id'       => 'enable_fake_order',
						'type'     => 'switch',
						'title'    => esc_html__('Enable Fake Order', 'orfarm'),
						'default'  => false
					),
					array(
                        'id'        => 'fake_order_seconds_displayed',
                        'type'      => 'text',
                        'title'     => esc_html__('Seconds Displayed', 'orfarm'),
						'options'   => '',
                    ),
					array(
                        'id'        => 'fake_order_seconds_hide',
                        'type'      => 'text',
                        'title'     => esc_html__('Seconds Hide	', 'orfarm'),
						'options'   => '',
                    ),
					array(
                        'id'        => 'fake_order_messages',
                        'type'      => 'text',
                        'title'     => esc_html__('Messages', 'orfarm'),
						'options'   => '',
                    )
				)
			);
			// page title shop
			 $this->sections[] = array(
				'icon'       => 'el-icon-website',
				'title'      => esc_html__( 'Shop title', 'orfarm' ),
				'subsection' => true,
				'fields'     => array(
                    array(
						'id'       => 'enable_shop_title',
						'type'     => 'switch',
						'title'    => esc_html__('Shop title', 'orfarm'),
						'default'  => true
					),
					array(
						'id'       => 'enable_sub_cate',
						'type'     => 'switch',
						'title'    => esc_html__('Show/hide sub categories.', 'orfarm'),
						'default'  => true
					),
				)
			);
			
			$this->sections[] = array(
				'icon'       => 'el-icon-website',
				'title'      => esc_html__( 'Product detail page', 'orfarm' ),
				'fields'     => array(
					array(
						'id'       => 'sidebar_product',
						'type'     => 'image_select',
						'title'    => __('Sidebar', 'orfarm'), 
						'subtitle' => __('Sidebar on Product page.', 'orfarm'),
						'options'  => array(
							'left'      => array(
								'alt'   => __('Left', 'orfarm'), 
								'img'   => $orfarm_url.'/images/p_left.png'
							),
							'right'      => array(
								'alt'   => __('Right', 'orfarm'), 
								'img'  => $orfarm_url.'/images/p_right.png'
							),
							'none'      => array(
								'alt'   => __('None', 'orfarm'), 
								'img'  => $orfarm_url.'/images/p_none.png'
							),
						
						),
						'default' => 'none'
					),
                   	array(
						'id'       => 'product_layout',
						'type'     => 'image_select',
						'title'    => esc_html__('Product Gallery Layout', 'orfarm'),
						'subtitle' => esc_html__('Product gallery layout on product detail page', 'orfarm'),
						'options'  => array(
							'default'      => array(
								'alt'   =>  esc_html__('Default', 'orfarm'),
								'img'  => $orfarm_url.'/images/p_none.png'
							),
							'thumbnail'      => array(
								'alt'   => esc_html__('Thumbnail gallery', 'orfarm'),
								'img'   => $orfarm_url.'/images/p_gallery.png'
							),
							'grid'      => array(
								'alt'   => esc_html__('Images grid', 'orfarm'),
								'img'  => $orfarm_url.'/images/p_grid.png'
							),
							'carousel'      => array(
								'alt'   => esc_html__('Big images carousel', 'orfarm'),
								'img'  => $orfarm_url.'/images/p_carousel.png'
							),
							'scroll'      => array(
								'alt'   => esc_html__('Big images scrolling', 'orfarm'),
								'img'  => $orfarm_url.'/images/p_scrolling.png'
							),
						
						
						),
						'default' => 'thumbnail'
					),
					array(
						'id'       => 'thumb_slider_direct',
						'type'     => 'image_select',
						'title'    => esc_html__('Thumbnail slider direction', 'orfarm'),
						'subtitle'      => esc_html__('This option only apply for Thumbnail gallery layout', 'orfarm'),
						'options'  => array(
							'horizontal-slider'      => array(
								'alt'   => esc_html__('Horizontal', 'orfarm'),
								'img'  => $orfarm_url.'/images/pt_horizontal.png'
							),
							'vertical-slider'      => array(
								'alt'   => esc_html__('Vertical right', 'orfarm'),
								'img'   => $orfarm_url.'/images/pt_right.png'
							),
							'vertical-left-slider'      => array(
								'alt'   => esc_html__('Vertical left', 'orfarm'),
								'img'  => $orfarm_url.'/images/pt_left.png'
							)
						),
						'default' => 'horizontal-slider'
					),
					array(
                        'id'        => 'gallery_thumbnail_size',
                        'type'      => 'dimensions',
                        'title'     => esc_html__('Gallery thumbnails size', 'orfarm'),
                        'subtitle'  => esc_html__('Width x Height : Empty height value to disable crop image. This option only apply for Thumbnail gallery layout', 'orfarm'),
                        'units'     => false,
                        'default'  => array(
                            'width'   => '120', 
                            'height'  => '120'
                        ),
                    ),
					array(
						'id'        => 'related_amount',
						'type'      => 'slider',
						'title'     => esc_html__('Number of related products', 'orfarm'),
						"default"   => 8,
						"min"       => 1,
						"step"      => 1,
						"max"       => 16,
						'display_value' => 'text'
					),
                    array(
						'id'       => 'enable_product_sticky',
						'type'     => 'switch',
						'title'    => esc_html__('Enable Product Sticky', 'orfarm'),
						'default'  => true
					),
					array(
						'id'       => 'pro_social_share',
						'type'     => 'checkbox',
						'title'    => esc_html__('Social share', 'orfarm'), 
						'options'  => array(
							'facebook' => esc_html__('Facebook', 'orfarm'),
							'twitter' => esc_html__('Twitter', 'orfarm'),
							'pinterest' => esc_html__('Pinterest', 'orfarm'),
							'gplus' => esc_html__('Google +', 'orfarm'),
							'linkedin' => esc_html__('LinkedIn', 'orfarm')
						),
						'default' => array(
							'facebook' => '1', 
							'twitter' => '1', 
							'pinterest' => '1',
							'gplus' => '1',
							'linkedin' => '1'
						)
					),
					array(
						'id'     => 'section_tab_1',
						'type'   => 'section',
						'title'  => esc_html__( 'Product single Tab 1', 'orfarm' ),
						'indent' => true,
					),
					array(
						'id'       => 'tab_tile_1',
						'type'     => 'text',
						'title'    => esc_html__('Tab titile 1', 'orfarm'),
						'subtitle'  => esc_html__('if the text empty. The Tab will not show', 'orfarm'),
        
		
					),
					array(
						'id'       => 'tab_des_1',
						'type'     => 'editor',
						'title'    => esc_html__('Description', 'orfarm'),
		
						'default'  => ''
					),
					array(
						'id'       => 'enable_tab_html',
						'type'     => 'switch',
						'title'    => esc_html__('HTML Blocks', 'orfarm'), 
						'default'  => false,
                    ),
					array(
                        'id'        => 'tab_html_1',
                        'type'      => 'select',
                        'title'     => esc_html__('Orfarm HTML Blocks', 'orfarm'),
                        'data'  => 'posts',
                        'args'  => array(
                            'posts_per_page' => -1,
                            'orderby'        => 'title',
                            'order'          => 'ASC',
							'post_type'		 => 'lionthemes_block'
                        )
                    ),
						array(
						'id'     => 'section_tab_2',
						'type'   => 'section',
						'title'  => esc_html__( 'Product single Tab 2', 'orfarm' ),
						'indent' => true,
					),
					array(
						'id'       => 'tab_tile_2',
						'type'     => 'text',
						'title'    => esc_html__('Tab titile ', 'orfarm'),
						'subtitle'  => esc_html__('if the text empty. The Tab will not show', 'orfarm'),
		
					),
					array(
						'id'       => 'tab_des_2',
						'type'     => 'editor',
						'title'    => esc_html__('Description', 'orfarm'),
		
						'default'  => ''
					),
					array(
						'id'       => 'enable_tab_2_html',
						'type'     => 'switch',
						'title'    => esc_html__('HTML Blocks', 'orfarm'), 
						'default'  => false,
                    ),
					array(
                        'id'        => 'tab_html_2',
                        'type'      => 'select',
                        'title'     => esc_html__('Orfarm HTML Blocks', 'orfarm'),
                        'data'  => 'posts',
                        'args'  => array(
                            'posts_per_page' => -1,
                            'orderby'        => 'title',
                            'order'          => 'ASC',
							'post_type'		 => 'lionthemes_block'
                        )
                    ),
						array(
						'id'     => 'section_tab_3',
						'type'   => 'section',
						'title'  => esc_html__( 'Product single Tab 3', 'orfarm' ),
						'indent' => true,
					),
					array(
						'id'       => 'tab_tile_3',
						'type'     => 'text',
						'title'    => esc_html__('Tab titile ', 'orfarm'),
						'subtitle'  => esc_html__('if the text empty. The Tab will not show', 'orfarm'),
		
					),
					array(
						'id'       => 'tab_des_3',
						'type'     => 'editor',
						'title'    => esc_html__('Description', 'orfarm'),
		
						'default'  => ''
					),
					array(
						'id'       => 'enable_tab_3_html',
						'type'     => 'switch',
						'title'    => esc_html__('HTML Blocks', 'orfarm'), 
						'default'  => false,
                    ),
					array(
                        'id'        => 'tab_html_3',
                        'type'      => 'select',
                        'title'     => esc_html__('Orfarm HTML Blocks', 'orfarm'),
                        'data'  => 'posts',
                        'args'  => array(
                            'posts_per_page' => -1,
                            'orderby'        => 'title',
                            'order'          => 'ASC',
							'post_type'		 => 'lionthemes_block'
                        )
                    ),
			
				)
			);
		
			// Blog options
            $this->sections[] = array(
                'title'     => esc_html__('Blog', 'orfarm'),
                'desc'      => esc_html__('Use this section to select options for blog', 'orfarm'),
                'icon'      => 'el-icon-file',
                'fields'    => array(
					array(
						'id'       => 'sidebarblog_pos',
						'type'     => 'radio',
						'title'    => esc_html__('Sidebar', 'orfarm'),
						'subtitle'      => esc_html__('Sidebar on Blog page', 'orfarm'),
						'options'  => array(
							'left' => 'Left',
							'right' => 'Right',
							'none' => 'None'
						),
						'default'  => 'right'
                    ),
					array(
                        'id'        => 'blog_column',
                        'type'      => 'select',
                        'title'     => esc_html__('Blog Content Column', 'orfarm'),
                        'options'   => array(
							1 => 'One Column',
							2 => 'Two Column',
							3 => 'Three Column',
                        ),
                        'default'   => 1
                    ),
					array(
						'id'       => 'enable_autogrid',
						'type'     => 'switch',
						'title'    => esc_html__('Enable auto arrange top', 'orfarm'),
						'subtitle' => esc_html__('Only apply for multiple columns layout', 'orfarm'),
						'default'  => true,
                    ),
               
                ),
            );
			// Blog Archive options
            $this->sections[] = array(
			    'title'     => esc_html__('Blog Archive', 'orfarm'),
                'desc'      => esc_html__('Use this section to select options for Blog archive', 'orfarm'),
                'icon'      => 'el-icon-file',
				'subsection' => true,
                'fields'    => array(
				     array(
						'id'       => 'blogpost_layout',
						'type'     => 'radio',
						'title'    => esc_html__('Blog post layout', 'orfarm'),
						'options'  => array(
							'side-by-side' => esc_html__('Image & Intro side by side', 'orfarm'),
							'big-image' => esc_html__('Big image on top', 'orfarm'),
							),
						'default'  => 'big-image'
					),
				    
					array(
						'id'       => 'noexcerpt',
						'type'     => 'switch',
						'title'    => esc_html__('No Excerpt', 'orfarm'), 
						'default'  => false,
                    ),
					array(
						'id'        => 'excerpt_length',
						'type'      => 'slider',
						'title'     => esc_html__('Excerpt length on blog page', 'orfarm'),
						"default"   => 25,
						"min"       => 10,
						"step"      => 2,
						"max"       => 150,
						'display_value' => 'text'
					),
						array(
                        'id'        => 'show_readmore',
                        'type'      => 'switch',
                        'title'     => esc_html__('Show readmore button', 'orfarm'),
                        'default'   => true
                    ),
					array(
                        'id'        => 'hide_postmeta',
                        'type'      => 'switch',
                        'title'     => esc_html__('Hide author & date meta info', 'orfarm'),
						'default'   => false,
                    ),
					array(
						'id'       => 'enable_blogloadmore',
						'type'     => 'radio',
						'title'    => esc_html__('Load more ajax', 'orfarm'),
						'options'  => array(
							'' => esc_html__('Default pagination', 'orfarm'),
							'scroll-more' => esc_html__('Scroll to load more', 'orfarm'),
							'button-more' => esc_html__('Button load more', 'orfarm')
							),
						'default'  => ''
                    ),
					array(
                        'id'        => 'blog_slide',
                        'type'      => 'select',
                        'title'     => esc_html__('Posts Slider on top', 'orfarm'),
                        'data'  => 'posts',
						'args'     => array( 
							    'numberposts' => -1 
						    ),
						'multi' => true,
                    ),
					array(
                        'id'        => 'enable_post_slide',
                        'type'      => 'switch',
                        'title'     => esc_html__('Show posts slide on top', 'orfarm'),
                        'default'   => true
                    ),
			
				)
			    
			);
			
			// Blog Single options
            $this->sections[] = array(
			    'title'     => esc_html__('Blog Single', 'orfarm'),
                'desc'      => esc_html__('Use this section to select options for Blog single', 'orfarm'),
                'icon'      => 'el-icon-file',
				'subsection' => true,
                'fields'    => array(
				   	
					array(
                        'id'        => 'hide_post_link',
                        'type'      => 'switch',
                        'title'     => esc_html__('Hide post detail navigations', 'orfarm'),
						'default'   => false,
                    ),
					array(
                        'id'        => 'hide_post_author',
                        'type'      => 'switch',
                        'title'     => esc_html__('Hide post detail author', 'orfarm'),
						'default'   => false,
                    ),
					array(
                        'id'        => 'hide_post_related',
                        'type'      => 'switch',
                        'title'     => esc_html__('Hide post detail related posts', 'orfarm'),
						'default'   => false,
                    ),
					array(
						'id'        => 'post_related_count',
						'type'      => 'slider',
						'title'     => esc_html__('Number of related posts', 'orfarm'),
						'default'   => 6,
						'min'       => 2,
						'step'      => 2,
						'max'       => 20,
						'display_value' => 'text'
					),
					 array(
						'id'       => 'post_social_share',
						'type'     => 'checkbox',
						'title'    => esc_html__('Post socials share', 'orfarm'), 
						'options'  => array(
							'facebook' => esc_html__('Facebook', 'orfarm'),
							'twitter' => esc_html__('Twitter', 'orfarm'),
							'pinterest' => esc_html__('Pinterest', 'orfarm'),
							'gplus' => esc_html__('Google +', 'orfarm'),
							'linkedin' => esc_html__('LinkedIn', 'orfarm')
						),
						'default' => array(
							'facebook' => '1', 
							'twitter' => '1', 
							'pinterest' => '1',
							'gplus' => '1',
							'linkedin' => '1'
						)
					),
				)
			    
			);
			
			// Less Compiler
            $this->sections[] = array(
                'title'     => esc_html__('Custom Code', 'orfarm'),
                'desc'      => esc_html__('Custom Code Javascript', 'orfarm'),
                'icon'      => 'el-icon-wrench',
               'fields' => array(
					array(
						'id'       => 'custom_js_enable',
						'type'     => 'switch',
						'title'    => esc_html__( 'Custom Javascript?', 'orfarm' ),
						'subtitle' => esc_html__( 'Turn on to enable custom javascript', 'orfarm' ),
						'default'  => false,
					),
					array(
						'id'       => 'custom_js',
						'type'     => 'ace_editor',
						'mode'     => 'javascript',
						'options'  => array( 'minLines' => 20 ),
						'required' => array( 'custom_js_enable', '=', true ),
					),
					array(
						'id'       => 'custom_css_enable',
						'type'     => 'switch',
						'title'    => esc_html__( 'Custom Css?', 'orfarm' ),
						'subtitle' => esc_html__( 'Turn on to enable custom javascript', 'orfarm' ),
						'default'  => false,
					),
					array(
						'id'       => 'custom_css',
						'type'     => 'ace_editor',
						'mode'     => 'css',
						'options'  => array( 'minLines' => 20 ),
						'required' => array( 'custom_css_enable', '=', true ),
					),
				),
            );
			
			// Error 404 page
            $this->sections[] = array(
                'title'     => esc_html__('Error 404 Page', 'orfarm'),
                'desc'      => esc_html__('Error 404 page options', 'orfarm'),
                'icon'      => 'el-icon-cog',
                'fields'    => array(
					array(
                        'id'        => 'background_error',
                        'type'      => 'background',
                        'output'    => array('body.error404'),
                        'title'     => esc_html__('Error 404 background', 'orfarm'),
                        'subtitle'  => esc_html__('Upload image or select color.', 'orfarm'),
						'default'   => array('background-color' => '#ffffff'),
                    ),
					array(
                        'id'        => '404_color',
                        'type'      => 'color',
                        'output'    => array('body.error404 h1'),
                        'title'     => esc_html__('Error 404 color', 'orfarm'),
						'default'   => '#000000',
						'validate' => 'color'
                    ),
                    array(
                        'id'    => '404_page',
                        'type'  => 'select',
                        'title' => esc_html__( 'Page content for 404 error', 'orfarm' ), 
                        'data'  => 'pages',
                        'args'  => array(
                            'posts_per_page' => -1,
                            'orderby'        => 'title',
                            'order'          => 'ASC',
                        )
                    )
                ),
            );
			
			// Less Compiler
            $this->sections[] = array(
                'title'     => esc_html__('Less Compiler', 'orfarm'),
                'desc'      => esc_html__('Turn on this option to apply all theme options. Turn of when you have finished changing theme options and your site is ready.', 'orfarm'),
                'icon'      => 'el-icon-wrench',
                'fields'    => array(
					array(
                        'id'        => 'enable_less',
                        'type'      => 'switch',
                        'title'     => esc_html__('Enable Less Compiler', 'orfarm'),
						'default'   => true,
                    ),
                ),
            );
			
		
			
			/*** end theme config****/
            $theme_info  = '<div class="redux-framework-section-desc">';
            $theme_info .= '<p class="redux-framework-theme-data description theme-uri">' . esc_html__('<strong>Theme URL:</strong> ', 'orfarm') . '<a href="' . esc_url($this->theme->get('ThemeURI')) . '" target="_blank">' . $this->theme->get('ThemeURI') . '</a></p>';
            $theme_info .= '<p class="redux-framework-theme-data description theme-author">' . esc_html__('<strong>Author:</strong> ', 'orfarm') . $this->theme->get('Author') . '</p>';
            $theme_info .= '<p class="redux-framework-theme-data description theme-version">' . esc_html__('<strong>Version:</strong> ', 'orfarm') . $this->theme->get('Version') . '</p>';
            $theme_info .= '<p class="redux-framework-theme-data description theme-description">' . $this->theme->get('Description') . '</p>';
            $tabs = $this->theme->get('Tags');
            if (!empty($tabs)) {
                $theme_info .= '<p class="redux-framework-theme-data description theme-tags">' . esc_html__('<strong>Tags:</strong> ', 'orfarm') . implode(', ', $tabs) . '</p>';
            }
            $theme_info .= '</div>';

            $this->sections[] = array(
                'title'     => esc_html__('Import / Export', 'orfarm'),
                'desc'      => esc_html__('Import and Export your Redux Framework settings from file, text or URL.', 'orfarm'),
                'icon'      => 'el-icon-refresh',
                'fields'    => array(
                    array(
                        'id'            => 'opt-import-export',
                        'type'          => 'import_export',
                        'title'         => 'Import Export',
                        'subtitle'      => 'Save and restore your Redux options',
                        'full_width'    => false,
                    ),
                ),
            );

            $this->sections[] = array(
                'icon'      => 'el-icon-info-sign',
                'title'     => esc_html__('Theme Information', 'orfarm'),
                'fields'    => array(
                    array(
                        'id'        => 'opt-raw-info',
                        'type'      => 'raw',
                        'content'   => $item_info,
                    )
                ),
            );
        }

        public function setHelpTabs() {

            // Custom page help tabs, displayed using the help API. Tabs are shown in order of definition.
            $this->args['help_tabs'][] = array(
                'id'        => 'redux-help-tab-1',
                'title'     => esc_html__('Theme Information 1', 'orfarm'),
                'content'   => esc_html__('<p>This is the tab content, HTML is allowed.</p>', 'orfarm')
            );

            $this->args['help_tabs'][] = array(
                'id'        => 'redux-help-tab-2',
                'title'     => esc_html__('Theme Information 2', 'orfarm'),
                'content'   => esc_html__('<p>This is the tab content, HTML is allowed.</p>', 'orfarm')
            );

            // Set the help sidebar
            $this->args['help_sidebar'] = esc_html__('<p>This is the sidebar content, HTML is allowed.</p>', 'orfarm');
        }

        public function setArguments() {

            $theme = wp_get_theme();
			$slug_home = "orfarm_opt"; 
			
			if( isset( $_GET['slug_home'] ) )  $slug_home = "orfarm_opt_".$_GET['slug_home'];
			
			if( isset( $_POST['_wp_http_referer'])) {
				$path = $_POST['_wp_http_referer']; 
				$path = parse_url($path);
				parse_str($path['query'], $params);
				$slug_home = "orfarm_opt_".$params['slug_home'];
			}
			
            $this->args = array(
                'opt_name'          => $slug_home,
                'display_name'      => $theme->get('Name'),
                'display_version'   => $theme->get('Version'),
                'menu_type'         => 'menu',                
                'allow_sub_menu'    => true,                  
                'menu_title'        => esc_html__('Theme Options', 'orfarm'),
                'page_title'        => esc_html__('Theme Options', 'orfarm'),
                
                'google_api_key' => '',
                
                'async_typography'  => true,
                'admin_bar'         => true,
                'global_variable'   => '',  
                'dev_mode'          => false,
                'customizer'        => true, 

                'page_priority'     => null,
                'page_parent'       => 'themes.php',
                'page_permissions'  => 'manage_options',
                'menu_icon'         => '',              
                'last_tab'          => '',              
                'page_icon'         => 'icon-themes',   
                'page_slug'         => '_options',      
                'save_defaults'     => true,            
                'default_show'      => false,           
                'default_mark'      => '',              
                'show_import_export' => true,           
                
                'transient_time'    => 60 * MINUTE_IN_SECONDS,
                'output'            => true,                   
                'output_tag'        => true,                   
                
                'database'              => '', 
                'system_info'           => false,

                // HINTS
                'hints' => array(
                    'icon'          => 'icon-question-sign',
                    'icon_position' => 'right',
                    'icon_color'    => 'lightgray',
                    'icon_size'     => 'normal',
                    'tip_style'     => array(
                        'color'         => 'light',
                        'shadow'        => true,
                        'rounded'       => false,
                        'style'         => '',
                    ),
                    'tip_position'  => array(
                        'my' => 'top left',
                        'at' => 'bottom right',
                    ),
                    'tip_effect'    => array(
                        'show'          => array(
                            'effect'        => 'slide',
                            'duration'      => '500',
                            'event'         => 'mouseover',
                        ),
                        'hide'      => array(
                            'effect'    => 'slide',
                            'duration'  => '500',
                            'event'     => 'click mouseleave',
                        ),
                    ),
                )
            );

            $this->args['share_icons'][] = array(
                'url'   => 'https://github.com/ReduxFramework/ReduxFramework',
                'title' => 'Visit us on GitHub',
                'icon'  => 'el-icon-github'
            );
            $this->args['share_icons'][] = array(
                'url'   => 'https://www.facebook.com/pages/Redux-Framework/243141545850368',
                'title' => 'Like us on Facebook',
                'icon'  => 'el-icon-facebook'
            );
            $this->args['share_icons'][] = array(
                'url'   => 'http://twitter.com/reduxframework',
                'title' => 'Follow us on Twitter',
                'icon'  => 'el-icon-twitter'
            );
            $this->args['share_icons'][] = array(
                'url'   => 'http://www.linkedin.com/company/redux-framework',
                'title' => 'Find us on LinkedIn',
                'icon'  => 'el-icon-linkedin'
            );

            // Panel Intro text -> before the form
            if (!isset($this->args['global_variable']) || $this->args['global_variable'] !== false) {
                if (!empty($this->args['global_variable'])) {
                    $v = $this->args['global_variable'];
                } else {
                    $v = str_replace('-', '_', $this->args['opt_name']);
                }
            }
        }

    }   
    global $reduxConfig;
    $reduxConfig = new Orfarm_Theme_Config();
}

if (!function_exists('redux_my_custom_field')):
    function redux_my_custom_field($field, $value) {
        print_r($field);
        echo '<br/>';
        print_r($value);
    }
endif;


if (!function_exists('redux_validate_callback_function')):
    function redux_validate_callback_function($field, $value, $existing_value) {
        $error = false;
        $value = 'just testing';
        $return['value'] = $value;
        if ($error == true) {
            $return['error'] = $field;
        }
        return $return;
    }
endif;
