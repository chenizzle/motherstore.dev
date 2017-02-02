<?php



/* 	Get available sliders
-------------------------------------------*/
	
	if ( !function_exists('the1_sliders') ) {
	function the1_sliders(){
		
		# default values
		$query_args = array(
			'posts_per_page'   => 100,
			'post_type'        => 'the1_slider',
			'post_status'      => 'publish',
		);
		$sliders = get_posts($query_args);
		
		#return results			
		return $sliders;
		
	}
	}


/* 	Get available sliders (dropdown)
-------------------------------------------*/

	if ( !function_exists('the1_sliders_dropdown') ) {
	function the1_sliders_dropdown( $opts = false ){
		
		# default values
		$type = 'object';
		$selected = '';
		$name = '';
		$class = '';
		$style = '';
		$query_args = array(
			'posts_per_page'   => 100,
			'orderby'          => 'post_date',
			'order'            => 'DESC',
			'post_type'        => 'the1_slider',
			'post_status'      => 'publish',
		);
		$output = '';
		
		# check user options
		if ( is_array($opts) ){
			if ( isset($opts['type']) ) 	{ $type = $opts['type'];							unset($opts['type']); 		}
			if ( isset($opts['selected']) ) { $selected = $opts['selected'];					unset($opts['selected']); 	}
			if ( isset($opts['name']) ) 	{ $name = 'name="'.esc_attr($opts['name']).'"';		unset($opts['name']); 		}
			if ( isset($opts['class']) ) 	{ $class = 'class="'.esc_attr($opts['class']).'"';	unset($opts['class']); 		}
			if ( isset($opts['style']) ) 	{ $style = 'style="'.esc_attr($opts['style']).'"';	unset($opts['style']); 		}
			
			if ( !empty($opts) ){
				foreach( $opts as $key => $value ){
					$query_args[$key] = $value;
				}
			}
		} else if ( is_string($opts) ){
			$type = $opts;
		}
		
		# execute query
		$sliders = get_posts($query_args);
		
		# store output on a variable
		$output .= '<select '.$name.' '.$class.' '.$style.'>';
			foreach( $sliders as $slider ){
			$selected_attr = ( $selected === $slider->ID ? 'selected' : '' );
			$output .= '<option value="'. esc_attr($slider->ID) .'" '.$selected_attr.'>'.$slider->post_title.'</option>';
			}
		$output .= "</select>";
		
		#return results			
		return $output;
		
	}
	}



/* 	Shortcode for single slider
-------------------------------------------*/

	if ( !function_exists('the1_slider_shortcode') ) {
	function the1_slider_shortcode( $atts ){
		
		extract( shortcode_atts(
			array( 'id' => false ),
			$atts 
		) );
		
		if ( !$id || !is_numeric($id) ) return;
		return the1_slider( $id );
		
	}
	add_shortcode( 'the1-slider', 'the1_slider_shortcode' );
	}


?>