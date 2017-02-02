<?php

/*---------------------------------------*
 *	Include other function pages
 *------------------------------------------*/

	require_once( get_template_directory().'/core/admin/googlefonts.php');

	require_once( get_template_directory().'/core/admin/option-components.php');
	require_once( get_template_directory().'/core/admin/option-wrappers.php');
	
	require_once( get_template_directory().'/core/admin/options_page.php');
	require_once( get_template_directory().'/core/admin/options_page__general.php');
	require_once( get_template_directory().'/core/admin/options_page__styling.php');
	require_once( get_template_directory().'/core/admin/options_page__importexport.php');
	require_once( get_template_directory().'/core/admin/options_page__oneclickdemo.php');

	require_once( get_template_directory().'/core/admin/admin_ajax.php');



/*----------------------------------------*
 *	Create menu items for Options Pages
 *-------------------------------------------*/

###	Add Options page on Appearance Menu
	function mnml_register_options_page() {
		global $mnml;
		$mnml['options_page'] = add_theme_page ( 'Mnml Theme Options', 'Mnml - Theme Options', 'manage_options', 'themes1_optionspage', 'mnml_options_page' );
	}
	add_action('admin_menu', 'mnml_register_options_page');


	// Includes on head of admin pages
	function mnml_adminheadfiles($curr_page){

		global $mnml;
		if( $curr_page === $mnml['options_page'] ){

				/* color picker */
				wp_enqueue_script('wp-color-picker');
				wp_enqueue_style('wp-color-picker');

				/* ui */
				wp_enqueue_script('jquery-ui-core');
				wp_enqueue_script('jquery-ui-sortable');
				wp_enqueue_script('jquery-ui-draggable');
				wp_enqueue_script('jquery-ui-slider');

				/* media uploader */
				wp_enqueue_media();
				
				/* admin */
				wp_enqueue_style('the1_admin_fontawesome', get_template_directory_uri().'/core/includes/fontawesome/css/font-awesome.min.css');
				wp_enqueue_script('the1_admin_interface', get_template_directory_uri().'/core/admin/admin.js', array('jquery'), '1.0', false);
				wp_enqueue_style('the1_admin_style', get_template_directory_uri().'/core/admin/admin.css');
				wp_enqueue_style('CP-tweak', get_template_directory_uri().'/core/admin/color-picker-tweak.css');
				
		}
	}
	add_action('admin_enqueue_scripts', 'mnml_adminheadfiles');


/*----------------------------------------*
 *		Custom functions
 *-------------------------------------------*/

//**	Get theme info
		function mnml_themeinfo($info=''){
			global $mnml;
			if ( $info=='' ){
				$option = $mnml['info'];
			} else {
				$option = ( isset($mnml['info'][$info]) ? $mnml['info'][$info] : '' );
			}
			return $option;
		}

//**	Get theme general options
		function mnml_themeoptions(){
			$opts = get_option('mnml_theme_options');
			return ( is_array($opts) ? $opts : array() );
		}

//**	Get theme styling options
		function mnml_themestylingoptions(){
			$opts = get_option('mnml_theme_styling_options');
			return ( is_array($opts) ? $opts : array() );
		}

//**	Get a single theme option
		function mnml_themeoption($optname=false, $type='', $echo=0){
			if ( $optname ){
				global $mnml;

				$styling = mnml_default_styling_values();
				$options = mnml_default_values();
				$default_values = array_merge($styling,$options);
				
				if ( isset($mnml['themeoptions'][$optname]) ){
					$option = $mnml['themeoptions'][$optname];
				} else if ( isset($default_values[$optname]) ){		//if option doesn't exist on database or new option then get the default value
					$option = $default_values[$optname];
				} else {
					return false; 
				}
				
				switch ($type){
					case 'attr' :
						$option = esc_attr(stripslashes($option));
						break;
						
					case 'url' :
						$option = esc_url(stripslashes($option));
						break;
						
					case 'html' :
						$option = esc_html(stripslashes($option));
						break;
						
					case 'textarea' :
						$option = esc_textarea(stripslashes($option));
						break;
						
					case 'js' :
						$option = esc_js(stripslashes($option));
						break;
						
					case 'checkbox' :
						$option = ( $option ? 'checked="checked"' : '' );
						break;
				}
				
				if ( $echo===1 || $type==='checkbox' ){
					echo $option;
				} else {
					return $option;
				}
			}
		}


//**	New feature indicator
		function mnml_newfeature($class){
			if( mnml_themeoption('options-version') !== mnml_themeinfo('version') ){
				echo '<span class="newfeature '.esc_attr($class).'"></span>';
			}
		}

?>