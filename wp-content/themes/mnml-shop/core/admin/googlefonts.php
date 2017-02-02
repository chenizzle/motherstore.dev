<?php

###	Fetch Google Fonts List
	if ( !function_exists('mnml_get_google_fonts_list') ) :
		function mnml_get_google_fonts_list($key='AIzaSyBocPEbTZYQ-ldCXbC489HGagcYztog3TY', $sort='alpha') {
			// $key = Web Fonts Developer API
			// $sort =	alpha, date, popularity, style, trending
			
			$font_list = array(); # This will contain full processed font list
			
			$http = (!empty($_SERVER['HTTPS'])) ? "https" : "http";
			$google_api_url = 'https://www.googleapis.com/webfonts/v1/webfonts?key=' . $key . '&sort=' . $sort;
			
			# Lets fetch it
			$args = array( 'sslverify' => false );
			$remote_get = wp_remote_get( $google_api_url, $args );
			$response = wp_remote_retrieve_body( $remote_get );
			
			if ( !$response ){
				# a fallback for fonts list on the servers which don't have SSL enabled
				$remote_get = wp_remote_get( 'http://themes1.com/files/googlefonts/google_fonts_list.php' );
				$response = wp_remote_retrieve_body( $remote_get );	
			}
			
			if( is_wp_error( $response ) ) {
			} else {
				$data = json_decode($response, true);
				$items = $data['items'];  # Temporary store google fetched fonts on $items variable
				
				/***  
				Manualy attach any font on the final list
				***/
				$manual_items = array(
					array( 'family' => 'Arial', 'variants' => array( 'regular', 800 ) ),
				);
				
				foreach ( $manual_items as $item ) {
					$name = $item['family'];	#font name
					$sizes = array();			#font sizes
					foreach ( $item['variants'] as $variant ) {
						$sizes[] = $variant;
					}
					$font_list[$name] = array( 'family' => $name, 'variants' => $sizes );
				}
				
				# Process and attach google fetched fonts on the final list
				foreach ( $items as $item ) {
					$name = $item['family'];	#font name
					$sizes = array();			#font sizes
					
					foreach ( $item['variants'] as $variant ) {
						$sizes[] = $variant;
					}
					$font_list[$name] = array( 'family' => $name, 'variants' => $sizes );
				}
			}
			# Return the final list of Fonts
			return $font_list;
		}
	endif;


###	Store the Final Fonts List in an option
	if ( !function_exists('mnml_save_google_fonts_list') ) :
		function mnml_save_google_fonts_list(){
			
			$current_font_option = get_option( 'mnml_google_fonts');
			$current_theme_version = mnml_themeoption('options-version');
			
			$need_fonts_update = ( $current_theme_version && mnml_themeinfo('version') !== $current_theme_version ? true : false );
			
			if ( !$current_font_option || $need_fonts_update ) {
				$fonts_list = mnml_get_google_fonts_list();
				if ( is_array($fonts_list) && count($fonts_list) > 5 ){
					update_option( 'mnml_google_fonts', serialize($fonts_list) );
				}
			}
			
		}
		add_action('after_setup_theme', 'mnml_save_google_fonts_list');
	endif;


###	Get google font
	if ( !function_exists('mnml_get_google_font') ) {
		function mnml_get_google_font( $font, $type='' ){
			$font_list = unserialize( get_option('mnml_google_fonts') );
			if ( !$font ) { $font = 'Arial'; }
			
			if ( isset( $font_list[$font] ) ){ 
			
				$font = $font_list[$font];
	
				if ( $type === 'query' ) :
					if ( $font['family'] === 'Arial' ) { 
						$font = 'Roboto';
						$font = $font_list[$font];
					}
					for ( $i = 0; $i < count($font['variants']); $i++ ) {
						if ( $font['variants'][$i] == 'regular' ) { $font['variants'][$i] = '400'; }
						if ( $font['variants'][$i] == 'italic' ) { $font['variants'][$i] = '400italic'; }
					}
					$name = str_replace(' ', '+', $font['family']);
					$variants = implode(',',$font['variants']);				
					return $name.':'.$variants;
				else :
					return $font;
				endif;
				
			}
		}
	}


###	Include selected Google Fonts on frontend
	if ( !function_exists('mnml_google_fonts_url') ) {
		function mnml_google_fonts_url(){
			
			/***  Register font option names  ***/
			$fields = array(
				'font-family-postcontent',
				'font-family-body',
				'font-family-logo',
				'font-family-nav',
				'font-family-h1',
				'font-family-h2',
				'font-family-h3',
				'font-family-h4',
				'font-family-h5',
				'font-family-h6',
				'font-family-buttons',
				'font-family-footer-headlines',
				'font-family-footer-text',
			);
			
			
			$defaults = mnml_default_values();
			$font_query = array();
			
			if ( !empty( $fields ) ){
				foreach ( $fields as $field ) {
					$font = ( mnml_themeoption( $field ) ? mnml_themeoption( $field, 'attr' ) : ( isset($defaults[ $field ]) ? $defaults[ $field ] : 'Arial' ) );
					$font = $font === 'Arial' ? 'Roboto' : $font;
					$new_font = mnml_get_google_font( $font, 'query' );
					if ( $new_font ) {
						$font_query[] = $new_font;
					}
				}
				## additional fonts added through "Extra Google Fonts" field
				$ext_fonts = mnml_themeoption( 'extra-googlefonts' );
				if ( $ext_fonts ){
					$ext_fonts = explode(',',$ext_fonts);
					if ( is_array($ext_fonts) ){
						foreach( $ext_fonts as $ext_font ){
							$ext_font = trim( $ext_font );
							if ( $ext_font ){
								$new_font = mnml_get_google_font( $ext_font, 'query' );
								if ( $new_font ) {
									$font_query[] = $new_font;
								}
							}
						}
					}
				}
				$font_query = array_unique($font_query);
				$gf_complete_link = 'http://fonts.googleapis.com/css?family='.implode( '%7c', $font_query );
				return esc_url($gf_complete_link);
			}
		}
	}
	

###	AJAX request for font preview
	if ( !function_exists('mnml_ajax_google_font_switch') ) {
		function mnml_ajax_google_font_switch(){
			
			$request = $_POST['fontdata'];
			$font = array();
			
			$new_font = mnml_get_google_font( $request );
			if ( $new_font ) {
				$font['font'] = $new_font;
				$font['query'] = 'http://fonts.googleapis.com/css?family='.mnml_get_google_font( $request, 'query' );
				
				foreach($font['font']['variants'] as $key => $variant) {
					if(strpos($variant, 'italic') !== false){
						unset($font['font']['variants'][$key]);
					}
				}
				$font['font']['variants'] = str_replace("regular", "normal", $font['font']['variants']);
			}
			
			die ( json_encode( $font ) );
		}
		add_action('wp_ajax_the1_google_font_switch', 'mnml_ajax_google_font_switch');
	}


?>