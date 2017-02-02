<?php



/*----------------------------------------* 
 *		Theme Options: General
 *-------------------------------------------*/
		
		## 	Save 

			function the1options_save__general() {
				check_ajax_referer('the1options_nonce__general', 'security');

				$data = $_POST;
				unset($data['security'], $data['action']);
			
				global $mnml;
				$options = mnml_themeoptions();
			
				if($options===$data) {
					die('No changes found');
				} else {
					if( update_option('mnml_theme_options', $data) ){
						die('Options Saved'); 
					} else { 
						die('Options could not be saved');
					}
				}

			}
			add_action('wp_ajax_the1options_save__general', 'the1options_save__general');

		## 	Reset

			function the1options_reset__general() {
				check_ajax_referer('the1options_nonce__general', 'security');

				if ( get_option( 'mnml_theme_options' ) ){
					if ( delete_option('mnml_theme_options' ) ){
						die('success');
					} else {
						die('Options reset failed');
					}
				} else {
					die('success');
				}
						
			}
			add_action('wp_ajax_the1options_reset__general', 'the1options_reset__general');





/*----------------------------------------* 
 *		Theme Options: Styling
 *-------------------------------------------*/
		
		## 	Save 

			function the1options_save__styling() {
				check_ajax_referer('the1options_nonce__styling', 'security');

				$data = $_POST;
				unset($data['security'], $data['action']);
			
				global $mnml;
				$options = mnml_themeoptions();
			
				if($options===$data) {
					die('No changes found');
				} else {
					if( update_option('mnml_theme_styling_options', $data) ){
						die('Options Saved'); 
					} else { 
						die('Options could not be saved');
					}
				}

			}
			add_action('wp_ajax_the1options_save__styling', 'the1options_save__styling');

		## 	Reset

			function the1options_reset__styling() {
				check_ajax_referer('the1options_nonce__styling', 'security');

				if ( get_option( 'mnml_theme_styling_options' ) ){
					if ( delete_option('mnml_theme_styling_options' ) ){
						die('success');
					} else {
						die('Options reset failed');
					}
				} else {
					die('success');
				}
						
			}
			add_action('wp_ajax_the1options_reset__styling', 'the1options_reset__styling');




















































/*----------------------------------------* 
 *		Save Theme General Options
 *-------------------------------------------*/
	
		function mnml_ajax_theme_options() {
			check_ajax_referer('the1-theme-options', 'security');

			$data = $_POST;
			unset($data['security'], $data['action']);
		
			switch ( $data['case'] ){
				
				case 'theme-options-update':
					global $mnml;
					$options = mnml_themeoptions();
				
					if(!empty($data) && is_array($data)) {
						$diff = array_diff($options, $data);
						$diff2 = array_diff($data, $options);
						$diff = array_merge($diff, $diff2);
					} else {
						$diff = array();
					}
				
					if($options===$data) {
						die('No changes found');
					} else {
						if( update_option('mnml_theme_options', $data) ){
							die('Options Saved'); 
						} else { 
							die('Options could not be saved');
						}
					}
					break;
					
				case 'theme-options-reset':
				
					if ( get_option( 'mnml_theme_options' ) ){
						if ( delete_option('mnml_theme_options' ) ){
							die('Options has been reset');
						} else {
							die('Could not reset options');
						}
					} else {
						die('Options has been reset');
					}
					
					break;
			}
		}
		add_action('wp_ajax_the1_theme_options', 'mnml_ajax_theme_options');


		function mnml_ajax_theme_options_reset() {
			if ( get_option( 'mnml_theme_options' ) ){
				if ( delete_option('mnml_theme_options' ) ){
					die('success');
				} else {
					die('failed');
				}
			} else {
				die('success');
			}

		}
		add_action('wp_ajax_mnml_theme_options_reset', 'mnml_ajax_theme_options_reset');
		
		
		function mnml_ajax_theme_style_reset(){
			if ( get_option( 'mnml_theme_styling_options' ) ){
				if ( delete_option('mnml_theme_styling_options' ) ){
					die('success');
				} else {
					die('failed');
				}
			} else {
				die('success');
			}
		}
		add_action('wp_ajax_mnml_theme_style_reset', 'mnml_ajax_theme_style_reset');



/*----------------------------------------* 
 *		Save Theme Styling Options
 *-------------------------------------------*/
	
		function mnml_ajax_theme_styling_options() {
			check_ajax_referer('the1-theme-styling-options', 'security');

			$data = $_POST;
			unset($data['security'], $data['action']);
		
			switch ( $data['case'] ){
				
				case 'save-options':
				
					global $mnml;
					$options = mnml_themestylingoptions();
				
					if(!empty($data)) {
						$diff = array_diff($options, $data);
						$diff2 = array_diff($data, $options);
						$diff = array_merge($diff, $diff2);
					} else {
						$diff = array();
					}
				
					if(!empty($diff)) {
						if( update_option('mnml_theme_styling_options', $data) ){
							die('Options Saved'); 
						} else { 
							die('Options could not be saved');
						}
					} else {
						die('Options Saved');
					}
					break;
					
				case 'new-preset':
				
					if ( !isset($data['newpreset']) || !$data['newpreset'] ) die('Invalid preset name!');
					
					$new_name = $data['newpreset'];
					$new_preset = array( $new_name => $data );
					
					die( mnml_register_style_preset( $new_preset ) );
											
					break;
					
				case 'reset-style':
				
					if ( get_option( 'mnml_theme_styling_options' ) ){
						if ( delete_option('mnml_theme_styling_options' ) ){
							die('Styles has been reset');
						} else {
							die('Could not reset styles');
						}
					} else {
						die('Styles has been reset');
					}
				
					break;


				case 'export-settings':
					mnml_savefile( serialize($data) );
					die('Settings Exported');
					break;

			}
		}
		add_action('wp_ajax_mnml_theme_styling_options', 'mnml_ajax_theme_styling_options');
		
		
		function mnml_register_style_preset( $new_preset ){
			
			$presets = get_option('mnml_options_presets');
			$presets = ( !$presets ? array() : $presets );
			
			$new_key = key($new_preset);
			if ( array_key_exists( $new_key, $presets ) ) return '"'.$new_key.'" preset already exists! Enter another name';
			
			$presets = $new_preset + $presets;
			
			if( update_option('mnml_options_presets', $presets) ){
				return('New Preset Created'); 
			} else { 
				return('Preset could not be created');
			}
		}
		
		
		function mnml_get_style_presets(){
			$presets = get_option('mnml_options_presets');
			$presets = ( is_array($presets) ? $presets :  array() );
			
			$output = '<select class="preset-select" id="style-preset-selector">';
			if ( !empty($presets) ){
				foreach ( $presets as $name => $opts ) {
					$output .= '<option value="'. esc_attr($name) .'">'.$name.'</option>';
				}
			} else {
				$output .= '<option value="">No presets available</option>';
			}
			$output .= '</select>';
			return $output;
		}

		function mnml_style_presets(){
			echo mnml_get_style_presets();
			if ( isset($_POST['action']) ){ die(); }
		}
		add_action('wp_ajax_mnml_style_presets', 'mnml_style_presets');
		
		
		
		
		function mnml_load_style_presets($to_load = false){
			
			if ( isset($_POST['name']) && $_POST['name']) {
				
				$name = $_POST['name'];
				$presets = get_option('mnml_options_presets');
				
				if ( !isset( $presets[$name] ) ) die('Preset not found!');
				
				$current_preset = $presets[$name];
				if( update_option('mnml_theme_styling_options', $current_preset) ){
					die('success'); 
				} else { 
					die('failed');
				}
			}
			
		}
		add_action('wp_ajax_mnml_load_style_presets', 'mnml_load_style_presets');


		
?>