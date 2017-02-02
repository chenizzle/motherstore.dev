<?php

//**	Display Social Profiles Icons
		function mnml_social_profiles( $opts = array( 'rss'=>true, 'style'=>'style1' ) ){
			
			$social_profiles = mnml_themeoption('SORT-ARRAY-socialprofiles');	// Get the Icons option
			$is_RSS = mnml_themeoption('use-rss');								// Get the include RSS option
			
			$rss = $opts['rss'];
			$style = $opts['style'];
			
			
			if ( !$social_profiles && !$is_RSS ) { return false; } 			// Stop function execution if no icons available
			
			// Blank output variables
			$social_profiles_output = $rss_output = $extra_wrapper_class = '';
			
			# Process the array if icons array in not empty
			if ( $social_profiles ) {
				$social_profiles = explode( ',', $social_profiles );
				
				// classes
				$icons = array(
					'be'	=> array( 'name' => 'Behance', 		'cl' => 'fa fa-behance',		'tagline' => esc_html__('Follow us on Behance','mnml-shop')			),
					'da'	=> array( 'name' => 'DeviantArt', 	'cl' => 'fa fa-deviantart',		'tagline' => esc_html__('Follow us on DeviantArt','mnml-shop')		),
					'dr'	=> array( 'name' => 'Dribbble', 	'cl' => 'fa fa-dribbble',		'tagline' => esc_html__('Follow us on Dribbble','mnml-shop')		),
					'fb'	=> array( 'name' => 'Facebook', 	'cl' => 'fa fa-facebook',		'tagline' => esc_html__('Follow us on Facebook','mnml-shop')		),
					'fr'	=> array( 'name' => 'Flickr', 		'cl' => 'fa fa-flickr',			'tagline' => esc_html__('Follow us on Flickr','mnml-shop')			),
					'gg'	=> array( 'name' => 'Google+', 		'cl' => 'fa fa-google-plus',	'tagline' => esc_html__('Follow us on Google+','mnml-shop')			),
					'ig'	=> array( 'name' => 'Instagram', 	'cl' => 'fa fa-instagram',		'tagline' => esc_html__('Follow us on Instagram','mnml-shop')		),
					'fm'	=> array( 'name' => 'LastFM', 		'cl' => 'fa fa-lastfm',			'tagline' => esc_html__('Follow us on LastFM','mnml-shop')			),
					'li'	=> array( 'name' => 'LinkedIn', 	'cl' => 'fa fa-linkedin',		'tagline' => esc_html__('Follow us on LinkedIn','mnml-shop')		),
					'pi'	=> array( 'name' => 'Pinterest', 	'cl' => 'fa fa-pinterest',		'tagline' => esc_html__('Follow us on Pinterest','mnml-shop')		),
					'sc'	=> array( 'name' => 'SoundCloud', 	'cl' => 'fa fa-soundcloud',		'tagline' => esc_html__('Follow us on SoundCloud','mnml-shop')		),
					'tu'	=> array( 'name' => 'Tumblr', 		'cl' => 'fa fa-tumblr',			'tagline' => esc_html__('Follow us on Tumblr','mnml-shop')			),
					'tw'	=> array( 'name' => 'Twitter', 		'cl' => 'fa fa-twitter',		'tagline' => esc_html__('Follow us on Twitter','mnml-shop')			),
					'yt'	=> array( 'name' => 'YouTube', 		'cl' => 'fa fa-youtube',		'tagline' => esc_html__('Watch our videos on YouTube','mnml-shop')	),
					'vi'	=> array( 'name' => 'Vimeo', 		'cl' => 'fa fa-vimeo-square',	'tagline' => esc_html__('Watch our videos on Vimeo','mnml-shop')	),
					'rss'	=> array( 'name' => 'Rss', 			'cl' => 'fa fa-rss',			'tagline' => esc_html__('Get our Rss feed','mnml-shop')				),
				);
				
				
				switch ( $style ) {
					
					
					case 'style1' :
						// Loop through each icon and store them in the output variable
						foreach ( $social_profiles as $s ){
							$icon = mnml_themeoption( 'socialprofiles-'.$s.'-icon' );
							$url = mnml_themeoption( 'socialprofiles-'.$s.'-url' );
							$url = ( $url ? $url : '#' );
							$social_profiles_output .= 	'<a class="'.esc_attr($icon).'" href="'.esc_url($url).'" target="_blank">' .
															'<i class="'.esc_attr(($icons[$icon]['cl'])).'"></i>' .
														'</a>';
						}
						# Print the rss icon if enabled on theme options
						if ( $rss === true && $is_RSS ) {
							$rss_url = get_bloginfo_rss('rss2_url');
							$social_profiles_output .= 	'<a class="rss" href="'.esc_url($rss_url).'" >' .
															'<i class="'. esc_attr(($icons['rss']['cl'])) .'"></i>' .
														'</a>';
						}
						break;
					
					
					case 'style2' :
						// Loop through each icon and store them in the output variable
						foreach ( $social_profiles as $s ){
							$icon = mnml_themeoption( 'socialprofiles-'.$s.'-icon' );
							$url = mnml_themeoption( 'socialprofiles-'.$s.'-url' );
							$url = ( $url ? $url : '#' );
							$social_profiles_output .= 	'<a class="'.esc_attr($icon).'" href="'.esc_url($url).'" target="_blank">' .
															'<i class="'.esc_attr(($icons[$icon]['cl'])).'"></i>' .
														'</a>';
						}
						# Print the rss icon if enabled on theme options
						if ( $rss === true && $is_RSS ) {
							$rss_url = get_bloginfo_rss('rss2_url');
							$social_profiles_output .= 	'<a class="rss" href="'.esc_url($rss_url).'" >' .
															'<i class="'. esc_attr(($icons['rss']['cl'])) .'"></i>' .
														'</a>';
						}

						$extra_wrapper_class = ' style2';
						break;
					
					
				}//end: switch($style)
			}			
			
			$output = 	'<div class="social-profiles'.$extra_wrapper_class.'">' .
							$social_profiles_output .
						'</div>';
			
			echo $output;
				
				
		}



?>