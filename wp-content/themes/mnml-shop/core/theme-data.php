<?php
###	Create a Global Variable to Store all Theme Options
	if ( !array_key_exists('the1', $GLOBALS) ) {
		$mnml = array();
	}


###	Setup core information
	if ( !function_exists( 'mnml_set_theme_info') ) {
		function mnml_set_theme_info(){
			$info = mnml_themeinfo();
			global $mnml;
			$mnml['info'] = $info;
		}
		add_action('after_setup_theme', 'mnml_set_theme_info', 1);
	}


###	Setup theme options
	if ( !function_exists( 'mnml_set_theme_options') ) {
		function mnml_set_theme_options(){
			
			# check if options array already exist. If no, use defaults
			if ( is_array(get_option('mnml_theme_options')) ) {
				$options = get_option('mnml_theme_options');
			} else {
				$options = mnml_default_values();
			}
			
			# check if options array already exist. If no, use defaults
			if ( is_array(get_option('mnml_theme_styling_options')) ) {
				$styling = get_option('mnml_theme_styling_options');
			} else {
				$styling = mnml_default_styling_values();
			}
			
			global $mnml;
			$mnml['themeoptions'] = array_merge($options,$styling);
		}
		add_action('after_setup_theme', 'mnml_set_theme_options', 2);
	}

###	Setup styling options
	if ( !function_exists( 'mnml_set_styling_options') ) {
		function mnml_set_styling_options(){
			# check if options array already exist. If no, use defaults
			if ( is_array(get_option('mnml_theme_styling_options')) ) {
				$options = get_option('mnml_theme_styling_options');
			} else {
				$options = mnml_default_styling_values();
			}
			global $mnml;
			$mnml['themestylingoptions'] =  $options;
		}
		add_action('after_setup_theme', 'mnml_set_styling_options', 2);
	}

### Adding editor style support
	if ( !function_exists('mnml_set_editor_style') ) {
		function mnml_set_editor_style() {
			add_editor_style( 'css/editor-style.css' );
		}
		add_action('after_setup_theme', 'mnml_set_editor_style', 2);
	}


## -------------------------------------------------
#		Theme Data
# ----------------------------------------------------

		
//**	Default Options
		function mnml_default_values(){
			$options = array(

				### logo
					'site-logo' => get_template_directory_uri().'/images/logo.png',
					'site-logo-text' => '',
				
				### header widgets area
					'header-columns'		=> '4,4,4',
					'use-header-widgets'	=> 'on',

				### sidebars
					'default-post-sidebar'			=> 'post-sidebar',
					'default-post-sidebar-layout'	=> 'right-sidebar',
					
					'default-page-sidebar'			=> 'post-sidebar',
					'default-page-sidebar-layout'	=> 'no-sidebar',

					'default-the1-portfolio-sidebar'			=> 'post-sidebar',
					'default-the1-portfolio-sidebar-layout'	=> 'no-sidebar',					
					
					'default-search-sidebar'		=> 'post-sidebar',
					'default-search-sidebar-layout'	=> 'no-sidebar',
				
				###	footer
					'copyright-text'	=> '&copy; 2016 MNML All Rights Reserved',

				### woocommerce
					'show-cart'			=> 'on',
					'woo-shop-title'	=> 'Shop',
					'woo-shop-subtitle'    => '',
					'woo-title-image'   => '',

				### subscribe popup
					'use-subscribe-area'	=> 'off',
					'subscribe-popup-image' => get_template_directory_uri().'/images/popup.png',
					'subscribe-title'		=> 'Get 10% off your first order',
					'subscribe-subtitle'	=> 'Join our newsletter to receive the latest updates and promotion',
					'subscribe-shortcode-or-html'	=> '',

				###	social profiles
					'SORT-ARRAY-socialprofiles'	=> '0,1',
					'socialprofiles-0-icon'	=> 'tw',
					'socialprofiles-1-icon'	=> 'ig',
					'use-rss'				=> 'on',
					'use-socialicons'		=> 'off',
					'left-title'			=> 'Facebook',
					'left-hyperlink'		=> '#',
					'right-title'			=> 'Instagram',
					'right-hyperlink'		=> '#',

				### frontpage template
					'homepage-listing-layout'	=> 'grid',
					
			);
			return $options;
		}



//**	Default Options
		function mnml_default_styling_values(){
			$options = array(

				### site layout
					'site-layout' => 'fullwidth',
				
				### links and buttons
				
					# buttons
					'font-family-buttons'	=> 'Josefin Sans',
					'font-size-buttons' 	=> '12',
					'font-weight-buttons' 	=> '700',
					'font-spacing-buttons' 	=> '0',
					'font-transform-buttons'=> 'uppercase',
					
					'btn-primary-color'		=> '#00bd9c',
					'btn-secondary-color'	=> '#333333',
					'btn-third-color'		=> '#9c9c9c',
					
					#links
					'links-color'			=> '#000000',
					'links-hover-color'		=> '#666666',

				### typography

					# body
					'font-family-body'		=> 'Josefin Sans',
					'font-size-body' 		=> '18',
					'font-weight-body' 		=> '400',
					'font-spacing-body' 	=> '0.04',
					'font-transform-body'	=> 'none',
					'font-color-body' 		=> '#000',

									
					# headings
					'font-family-h1'	=> 'Old Standard TT',
					'font-size-h1' 		=> '42',
					'font-weight-h1' 	=> '700',
					'font-spacing-h1' 	=> '0',
					'font-transform-h1'	=> 'none',
					'font-color-h1' 	=> '#000',
					
					'font-family-h2'	=> 'Old Standard TT',
					'font-size-h2' 		=> '24',
					'font-weight-h2' 	=> '700',
					'font-spacing-h2' 	=> '0',
					'font-transform-h2'	=> 'uppercase',
					'font-color-h2' 	=> '#464646',
					
					'font-family-h3'	=> 'Old Standard TT',
					'font-size-h3' 		=> '18',
					'font-weight-h3' 	=> '600',
					'font-spacing-h3' 	=> '0',
					'font-transform-h3'	=> 'none',
					'font-color-h3' 	=> '#464646',
					
					'font-family-h4'	=> 'Old Standard TT',
					'font-size-h4' 		=> '15',
					'font-weight-h4' 	=> '700',
					'font-spacing-h4' 	=> '0',
					'font-transform-h4'	=> 'none',
					'font-color-h4' 	=> '#4646464',
					
					'font-family-h5'	=> 'Old Standard TT',
					'font-size-h5' 		=> '13',
					'font-weight-h5' 	=> '700',
					'font-spacing-h5' 	=> '0',
					'font-transform-h5'	=> 'none',
					'font-color-h5' 	=> '#464646',
					
					'font-family-h6'	=> 'Old Standard TT',
					'font-size-h6' 		=> '13',
					'font-weight-h6' 	=> 'normal',
					'font-spacing-h6' 	=> '0',
					'font-transform-h6'	=> 'none',
					'font-color-h6' 	=> '#464646',
					
					#extra google fonts
					'extra-googlefonts'	=> 'Open Sans, Quicksand, Karla, PT Sans, Poppins, Lato, Montserrat, Source Sans Pro, Raleway,Old Standard TT',
					
				### header
					'topstripe-bg-color'		=> '#ab8974',
					'header-info-color'			=> '#ffffff',

					'header-layout'				=> 'layout1',
					'header-overlayed'			=> 'off',
					
					'header-bg-color'			=> '#be967f',

					'font-family-logo'		=> 'Open Sans',
					'font-size-logo' 		=> '50',
					'font-weight-logo' 		=> 'Normal',
					'font-spacing-logo' 	=> '0.03',
					'font-transform-logo'	=> 'none',
					'font-color-logo' 		=> '#000000',
					
					'font-family-nav'		=> 'Lato',
					'font-size-nav' 		=> '12',
					'font-weight-nav' 		=> 'normal',
					'font-spacing-nav' 		=> '0.15',
					'font-transform-nav' 	=> 'uppercase',
					'font-color-nav' 		=> '#000',
					
					'nav-hover'				=> '#000',
										
				###	post
					'posttitlebar-overlay-color'	=> '#f6f6f6',
					'posttitlebar-overlay-opacity'	=> '100',
					'posttitlebar-scheme'			=> 'light',
					'posttitlebar-breadcrumbs'		=> 1,
					'posttitlebar-align'			=> 'align-center',
				
				###	page
					'pagetitlebar-overlay-color'	=> '#c4c4c4',
					'pagetitlebar-overlay-opacity'	=> '100',
					'pagetitlebar-scheme'			=> 'dark',
					'pagetitlebar-align'			=> 'align-center',
					'pagetitlebar-size'				=> 'x3',
					'pagetitlebar-parallax'			=> 1,

				###	archives
					'archivetitlebar-overlay-color'	=> '#353539',
					'archivetitlebar-overlay-opacity'=> '100',
					'archivetitlebar-scheme'		=> 'light',
					'archivetitlebar-align'			=> 'align-center',

				
				###	footer					
					'font-family-footer-text'		=> 'Josefin Sans',
					'font-size-footer-text' 		=> '12',
					'font-weight-footer-text' 		=> '400',
					'font-transform-footer-text'	=> 'none',
					'font-color-footer-text' 		=> '#aaa',

					'footer-links-color'			=> '#7e7e7e',
					'footer-links-hover-color'		=> '#ffffff',

				###	custom css
					'custom-css' =>	"",


			);
			return $options;
		}



?>