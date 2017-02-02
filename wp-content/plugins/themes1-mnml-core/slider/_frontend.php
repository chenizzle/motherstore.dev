<?php


/*	Include style/scripts 
-------------------------------------------*/

	if ( !function_exists('the1_slider_frontend_scripts') ) {
	function the1_slider_frontend_scripts(){
		wp_enqueue_script( 'the1_slider', plugins_url('_frontend.js', __FILE__), array('jquery'), '1.0', true );	
		wp_enqueue_style( 'the1_slider', plugins_url('_frontend.css', __FILE__) );
		$globalss = array(
			'ajaxUrl' => admin_url('admin-ajax.php')
		);
		wp_localize_script( 'the1_slider', 'the1Globals', $globalss );
	}
	add_action( 'wp_enqueue_scripts', 'the1_slider_frontend_scripts' );
	}


	if ( !function_exists('the1_get_youtube_duration') ) {
	function the1_get_youtube_duration(){
		
		echo 'FYYSI';
		die('FYYSI');
	}
	add_action( 'wp_ajax_get_youtube_duration', 'the1_get_youtube_duration' );
	}
	
	
	
	

/*	Fetch Slider : return all data of a single slider as Array
---------------------------------------------------------------------------*/
	
	function the1slider_fetch_slider($id){
		
		# check if this is a Themes1_Slider post
		if ( get_post_type($id) !== 'the1_slider' ) {
			return false;
		}
		
		# get slides from post
		$slides = get_post_meta($id,'slides',true);
		
		# if no slides available, stop the function
		if ( !is_array($slides) || empty($slides) ) return false;
		
		# get slider settings. If any option not set, default will be used
		$settings_defaults = array(
			'width' 		=> '',
			'height'		=> '',
			'overlayer-use'	=> '',
			'fx'			=> '',
			'autoplay'		=> '',
			'autoplay_delay'=> '',
			'arrows'		=> '',
			'bottom_bar'	=> '',
			'thumb_width'	=> '',
			'thumb_height'	=> '',
			'tabs_color'	=> '',
		);
		$settings = get_post_meta($id,'settings',true);
		$settings = ( is_array($settings) ? array_merge($settings_defaults,$settings) : $settings_defaults );
		
		# merge $slides and $settings in a single array
		$slider = array(
			'settings' 	=> $settings,
			'slides' 	=> $slides,
		);
		
		# return $slider
		return $slider;
		
	}
	
	
	
/*	Slider HTML
-------------------------------------------*/
	
	if ( !function_exists('the1_slider') ) {
	function the1_slider( $id = false ){
		

		if ( !$id ) {
			echo 'Please specify the slider ID!';
			return false;
		}
		
		$slider = the1slider_fetch_slider($id);
		if ( !$slider ){ 
			echo 'No slider matches your ID';
			return false;
		}
			
		# vars initialize 
		$output = $output_sl_media = $output_sl_content = $output_arrows = $output_thumbs = $output_dots = $output_tabs = $output_bottombar = $output_curtain = $output_autoplay = '';
		$slides = $slider['slides'];
		$settings = $slider['settings'];
		$slideCount = count($slides);
		
		$tabs_color = ( $settings['bottom_bar']==='tabs' ? 'background-color:'.$settings['tabs_color'].';' : '' );


		# autoplayer
		$output_autoplay = ( $settings['autoplay'] ? '<div class="ts-autoplay-bar"><div class="ts-autoplay-progress" style="'.$tabs_color.'"></div></div>' : '' );
		
		# slides
		$currSlide = 0;
		foreach ( $slides as $slide ) {
			$type = $slide['media_type'];
			
			if ( $slide['media_type'] === 'image' ){
				$media_url = wp_get_attachment_image_src( $slide['media_id'], 'full' );
				$media_url = $media_url[0];
				$thumb_url = wp_get_attachment_image_src( $slide['media_id'], 'thumbnail' );
				$thumb_url = $thumb_url[0];
			} else {
				$media_url = esc_attr($slide['media_url']);
				$thumb_url = esc_attr($slide['media_thumb']);
			}
			
			$data_type = ( $type ? 'data-type="'.$type.'"' : '' );
			$data_src = ( $media_url ? 'data-src="'.$media_url.'"' : '' );
			$bg_img = ( $type==='image' ? 'background-image:url('.$media_url.');' : '' );
			$bg_img_thumb = 'background-image:url('.$thumb_url.');';
			$bg_color = ( $slide['bg_color'] ? 'background-color:'.$slide['bg_color'].';' : '' );
			$align = ( $slide['text_align'] ? 'ts-align-'.$slide['text_align'] : '' );
			
			// append: slide media
			$output_sl_media .=	'<div class="ts-item type-'.$type.'" '.$data_type.' '.$data_src.' style="'.$bg_img.$bg_color.'">' .
								'</div>';
								
			// append: slide content
			$sl_title = '';
			if ( $slide['title'] ){
				$sl_title = $slide['title'];
				
				#apply thin font if needed
				$sl_title = str_replace('((','<span style="font-weight:normal;">',$sl_title);
				$sl_title = str_replace('))','</span>',$sl_title);
				#set title size
				$sl_title_size = ( isset($slide['title_size']) ? $slide['title_size'] : '' );
				#title HTML
				$sl_title = '<h2 class="ts-title ts-align-center ts-title--'.$sl_title_size.'">'.$sl_title.'</h2>';
			}
			$sl_text = ( $slide['text'] ? '<div class="ts-text ts-align-center ">'.$slide['text'].'</div>' : '' );
			$sl_button = ( $slide['tab_button_text'] ? '<div class="ts-button ts-align-center">'.$slide['tab_button_text'].'</div>' : '' );
			$sl_maxwidth = ( $settings['width'] ? 'style="max-width:'.$settings['width'].'px;"' : '' );
			if ( $sl_title || $sl_text ) {
				$sl_content =	'<div class="ts-content__width '.$align.'" '.$sl_maxwidth.'>' .
									'<div class="ts-content__layer">' .
										$sl_title . 
										$sl_text .
										$sl_button .
									'</div>' .
								'</div>';
			} else {
				$sl_content = '';
			}
			$output_sl_content .= 	'<div class="ts-item type-'.$type.' '.$align.'" '.$data_type.'>' .
										$sl_content .
									'</div>';
									
			// append: thumbnail
			$output_thumbs .= '<div class="ts-thumb type-'.$type.'" data-index="'.$currSlide.'" style="'.$bg_img_thumb.'">&nbsp;</div>';
			
			// append: dot
			$output_dots .=	'<div class="ts-dot type-'.$type.'" data-index="'.$currSlide.'">&nbsp;</div>';

			// append: tab
			$tab_width = (100/$slideCount);
			$tab_title = ( $slide['tab_title'] ? $slide['tab_title'] : $slide['title'] );
			$output_tabs .=	'<div class="ts-tab type-'.$type.'" data-index="'.$currSlide.'" style="width:'.$tab_width.'%; '.$tabs_color.' ">' .
								$output_autoplay .
								'<div class="ts-tab-content">' .
								$tab_title.'&nbsp;' .
								'</div>' .
							'</div>';
			
			$currSlide++;
		}
		
		# curtain
		if ( $settings['overlayer-use'] ){
			$overlayer_color = $settings['overlayer_color'];
			if ( $overlayer_color ){
				$overlayer_color = hex2rgb($overlayer_color);
				$overlayer_color = 'background-color: rgba('.implode(',',$overlayer_color).',0.8);';
			}
			$output_curtain = '<div class="ts-curtain '. $settings['overlayer_pattern'] .'" style="'.$overlayer_color.'"></div>';
		}
		
		# arrows
		$output_arrows = ( $settings['arrows'] ? '<div class="ts-arrows">' . '<div class="ts-arrow ts-goLeft"><i class="fa fa-chevron-left"></i></div>' . '<div class="ts-arrow ts-goRight"><i class="fa fa-chevron-right"></i></div>' . '</div>' : '' );
							
		# bottom bar
		if ( $settings['bottom_bar'] && $slideCount > 1 ) {
			switch ( $settings['bottom_bar'] ) {
				case 'dots' :
					$output_bottombar =	'<div class="ts-dots">'.$output_dots.'</div>';
					break;
				case 'dots-arrows' :
					$output_bottombar =	'<div class="ts-dots">' .
											'<div class="ts-dot-arrow ts-goLeft">&nbsp;</div>' .
											$output_dots .
											'<div class="ts-dot-arrow ts-goRight">&nbsp;</div>' .
										'</div>';
					break;
				case 'thumbs' :
					$output_bottombar =	'<div class="ts-thumbs">'.$output_thumbs.'</div>';
					break;
				case 'thumbs-arrows' :
					$output_bottombar =	'<div class="ts-thumbs">' .
											'<div class="ts-thumb-arrow ts-goLeft">&nbsp;</div>' .
											$output_thumbs .
											'<div class="ts-thumb-arrow ts-goRight">&nbsp;</div>' .
										'</div>';
					break;
				case 'tabs' :
					$output_bottombar =	'<div class="ts-tabs" style="'.$tabs_color.'">' .
											$output_tabs .
										'</div>';
					break;
			}
			$output_bottombar = '<div class="ts-bottom-bar" style="'.$tabs_color.'">'.$output_bottombar.'</div>';
			
		}
		
		
		# settings
		$opts = array();
		if ( $settings['width'] ){ $opts[] = 'data-width="'.$settings['width'].'"'; }
		if ( $settings['height'] ){ $opts[] = 'data-height="'.$settings['height'].'"'; }
		

		if ( $settings['autoplay'] ){ $opts[] = 'data-autoplay="'.$settings['autoplay'].'"'; }
		if ( $settings['autoplay_delay'] ){ $opts[] = 'data-autoplay_delay="'.$settings['autoplay_delay'].'"'; }
		if ( $settings['bottom_bar'] ){ $opts[] = 'data-bottom_bar="'.$settings['bottom_bar'].'"'; }
		$opts[] = 'data-totalslides="'.$slideCount.'"';

		if ( $settings['width'] && $settings['height'] ){ 
			$ratio = 'padding-bottom:' . (($settings['height']/$settings['width'])*100).'%' . '; height: 0;'; 
		} else {
			$ratio = '';
		}

		# Completed slider
		$output =	'<div class="ts-wrapper noselect '. 'using-'.$settings['bottom_bar'] .'" '. implode( ' ', $opts ) .' style="'.$ratio.'">' .
						'<div class="ts-slides">' .
							'<div class="ts-media">' . 
								$output_sl_media . 
								$output_curtain .
							'</div>' .
							'<div class="ts-content">' . $output_sl_content . '</div>' .
							//$output_autoplay .
							$output_arrows .
						'</div>' .
						$output_bottombar .
					'</div>';
		
		# print the slider
		echo $output;
		
	}
	}





	
	function dissplaySlider(){
		
		ob_start();
		the1_slider(322);
		$comtent = ob_get_contents();
		ob_end_clean();
		return $comtent;
			
	}
	add_shortcode('display_slider','dissplaySlider');
	
	
	
?>