<?php

/*-----------------------------------------------------
 *		COLOR PICKER or PALETTE
 *------------------------------------------------------------*/
 
		if ( !function_exists('mnml_optioncomponent_color') ) {
		function mnml_optioncomponent_color( $name, $opts = array() ){
			
			$opt_name	 	= $name;
			$class 			= ( isset($opts['class']) ? $opts['class'] : '' );
			$palette		= ( isset($opts['palette']) ? $opts['palette'] : false );
			$defaults 		= mnml_default_values();
			
			if ( $palette ){
				$curr_color		= ( mnml_themeoption($opt_name) ? mnml_themeoption($opt_name,'attr') : ( isset($defaults[$opt_name]) ? $defaults[$opt_name] : '#000000' ) );
				$curr_colorname	= ( mnml_themeoption($opt_name.'-clrname') ? mnml_themeoption($opt_name.'-clrname','attr') : ( isset($defaults[$opt_name.'-clrname']) ? $defaults[$opt_name.'-clrname'] : '#000000' ) );
				$output =	'<div class="the1-palette-container wp-picker-container">'.
								'<input type="hidden" name="'. esc_attr($opt_name) .'" class="CP-colorcode" value="'. esc_attr($curr_color).'" />'.
								'<input type="hidden" name="'. esc_attr($opt_name.'-clrname').'" class="CP-colorname" value="'. esc_attr($curr_colorname) .'" />'.
								'<a tabindex="0" class="wp-color-result the1-palette-result" title="select color" style="background-color:'. esc_attr($curr_color) .'"></a>'.
								'<div class="clear"></div>'.
								'<div class="the1-palette-holder">';
								foreach( $palette as $name => $code ){
				$output .= 			'<a tabindex="0" class="the1-palette-item" data-colorname="'.esc_attr($name).'" data-colorcode="'.esc_attr($code).'" style="background-color:'.$code.'"></a>';
								}
				$output .=		'</div>'.
							'</div>';
			} else {
				$curr_color = ( mnml_themeoption($opt_name) ? mnml_themeoption($opt_name,'attr') : ( isset($defaults[$opt_name]) ? $defaults[$opt_name] : '#000000' ) );
				$output = '<input type="text" id="'. esc_attr($opt_name) .'" name="'. esc_attr($opt_name) .'" class="CP '.esc_attr($class).'" value="'. esc_attr($curr_color) .'"/>';
			}
			
			return $output;
		}
		}


/*-----------------------------------------------------
 *		CHECKBOX - using <select> element
 *------------------------------------------------------------*/
 
		if ( !function_exists('mnml_optioncomponent_checkbox') ) {
		function mnml_optioncomponent_checkbox( $name, $opts = array() ){
			
			$opt_name = $name;

			$value = ( mnml_themeoption($opt_name)==='on' ? 'on' : '' );
			$html = '<div id="'.esc_attr($opt_name).'" class="inputtextToCheckbox '.$value.'">' .
					'<input type="text" name="'.esc_attr($opt_name).'" class="inputtextToCheckbox_input" value="'.$value.'" />'.
					'</div>';

			return $html;
		}
		}


/*-----------------------------------------------------
 *		FONT
 *------------------------------------------------------------*/
 
		if ( !function_exists('mnml_optioncomponent_font') ) {
		function mnml_optioncomponent_font( $name=false, $opts = false  ){
			if ( !$name ) exit();
			
			if ( $opts['parent'] ){
				$opt_family = 'font-family-'.$opts['parent'];
			} else {
				$opt_family = 'font-family-'.$name;
			}
		
			$defaults = mnml_default_values();
		
			$font_list = get_option('mnml_google_fonts');
			$font_list = unserialize($font_list);
			$font_weight = array('no option');
			
			/*predefined components*/
			$default_components = array('family','size','weight','spacing','transform','lineheight','color');
			/*
			if custom components are set then ($comp) components array is passed
			else, assigns false to $comp
			*/
			$comp = ( isset( $opts['comp'] ) && is_array( $opts['comp'] ) ? ( empty( $opts['comp'] ) ? false : $opts['comp'] ) : false );
			
			$child_of = array( 'classes' => '', 'comp' => array() );
			if ( $comp ){
				$child_of['comp'] = array_diff( $default_components, $comp );
				foreach( $child_of['comp'] as $component ){
					$child_of['classes'] .= 'child-of-font-'.$component.'-'.$opts['parent'].' ';
				}
			}
			
			$output = '<div class="font-option-wrapper '.esc_attr($child_of['classes']).'">';
			
			$curr_family = ( mnml_themeoption($opt_family) ? mnml_themeoption($opt_family) : ( isset($defaults[$opt_family]) ? $defaults[$opt_family] : 'Arial' ) );
			
				## font family
				if ( !$opts['parent'] ) {
					$output .= '<select class="font-switcher" name="'. esc_attr($opt_family) .'" id="'. esc_attr($opt_family) .'" style="width:160px;">';
					foreach( $font_list as $font ){
						$fontSelected = ( $curr_family==$font['family'] ? 'selected="selected" ' : '' );
						$output .= '<option '.$fontSelected.' value="'. esc_attr($font['family']) .'">'.$font['family'].'</option>';
					}
					$output .= '</select>';
				} else {
					$output .= '<div style="display:inline-block;margin-bottom:7px">&nbsp;</div>'/*Extended from: '.$opts['parent'].' '*/;
				}
		
				## size
				if ( !$comp || in_array( 'size', $comp ) ) {
				$output .= mnml_optioncomponent_fontsize( $name );
				}
		
				## weight
				if ( !$comp || in_array( 'weight', $comp ) ) {
				$output .= mnml_optioncomponent_fontweight( $name, $curr_family );
				}
								
				## spacing
				if ( !$comp || in_array( 'spacing', $comp ) ) {
				$output .= mnml_optioncomponent_fontspacing( $name );
				}

				## transform
				if ( !$comp || in_array( 'transform', $comp ) ) {
				$output .= mnml_optioncomponent_fonttransform( $name );
				}

				## color
				if ( !$comp || in_array( 'color', $comp ) ) {
				$output .= mnml_optioncomponent_color( 'font-color-'.$name, array('class'=>'font-color-switcher') );
				}

				## preview
				 $prev_opts = array();
				 if ( isset( $opts['sampletext'] ) ) { $prev_opts['sampletext'] = $opts['sampletext']; } 
				 $prev_opts['parent'] = ( $opts['parent'] ? $opts['parent'] : false ); 
				 $prev_opts['parents'] = ( $child_of['comp'] ? $child_of['comp'] : false ); 
				$output .= mnml_optioncomponent_fontpreview( $name, $prev_opts );

				## link to google font file
				if ( !$opts['parent'] ) {
				$linkk = 'http://fonts.googleapis.com/css?family='.mnml_get_google_font($curr_family,'query');
				$output .= '<link id="'. esc_attr('the1-font-family-'.$name) .'" href="'.esc_url($linkk).'" rel="stylesheet" type="text/css">';
				}
				
			$output .= '</div>';
			
			return $output;
		}
		}

### 	FONT SIZE
		if ( !function_exists('mnml_optioncomponent_fontsize') ) {
		function mnml_optioncomponent_fontsize( $name, $opts = array() ){
			
			$opt_name 		= 'font-size-'.$name;
			$font_sizes 	= array( 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 26, 28, 30, 32, 37, 42, 50, 60, 72, 80, 88 );
			$class 			= ( isset($opts['class']) ? $opts['class'] : '' );
			$defaults 		= mnml_default_values();
			
			$output = '';
			$output .= '<select class="font-size-switcher '.esc_attr($class).'" name="'. esc_attr($opt_name) .'" id="'. esc_attr($opt_name) .'" style="width: 45px;">';
				$curr_size = ( mnml_themeoption($opt_name) ? mnml_themeoption($opt_name,'attr') : ( isset($defaults[$opt_name]) ? $defaults[$opt_name] : '12' ) );
				foreach( $font_sizes as $size ){
					$sizeSelected = ( $curr_size == $size ? 'selected="selected" ' : '' );
					$output .= '<option '.$sizeSelected.' value="'. esc_attr($size) .'">'.$size.'</option>';
				}
			$output .= '</select>';
			
			return $output;
		}
		}

### 	FONT SPACING
		if ( !function_exists('mnml_optioncomponent_fontspacing') ) {
		function mnml_optioncomponent_fontspacing( $name, $opts = array() ){
			
			$opt_name 		= 'font-spacing-'.$name;
			$font_spacings 	= array( 0, 0.03, 0.06, 0.08, 0.1, 0.15, 0.2, 0.3, 0.4, 0.5, 0.6, 0.7, 0.8, 0.9, 1 );
			$class 			= ( isset($opts['class']) ? $opts['class'] : '' );
			$defaults 		= mnml_default_values();
			
			$output = '';
			$output .= '<select class="font-spacing-switcher '.esc_attr($class).'" name="'. esc_attr($opt_name) .'" id="'. esc_attr($opt_name) .'" style="width: 50px;">';
				$curr_spacing = ( mnml_themeoption($opt_name) > -5 ? mnml_themeoption($opt_name,'attr') : ( isset($defaults[$opt_name]) ? $defaults[$opt_name] : '0' ) );
				foreach( $font_spacings as $spacing ){
					$spacingSelected = ( (string)$curr_spacing === (string)$spacing ? 'selected="selected" ' : '' );
					$output .= '<option '.$spacingSelected.' value="'. esc_attr($spacing) .'">'.$spacing.'</option>';
				}
			$output .= '</select>';

			
			return $output;
		}
		}

### 	FONT TRANSFORM
		if ( !function_exists('mnml_optioncomponent_fonttransform') ) {
		function mnml_optioncomponent_fonttransform( $name, $opts = array() ){
			
			$opt_name 		= 'font-transform-'.$name;
			$font_transforms= array( 'none', 'capitalize', 'lowercase', 'uppercase' );
			$class 			= ( isset($opts['class']) ? $opts['class'] : '' );
			$defaults 		= mnml_default_values();
			
			$output = '';
			$output .= '<select class="font-transform-switcher '.esc_attr($class).'" name="'. esc_attr($opt_name) .'" id="'. esc_attr($opt_name) .'" style="width: 82px;">';
				$curr_transform = ( mnml_themeoption($opt_name) ? mnml_themeoption($opt_name,'attr') : ( isset($defaults[$opt_name]) ? $defaults[$opt_name] : '0' ) );
				foreach( $font_transforms as $transform ){
					$transformSelected = ( $curr_transform == $transform ? 'selected="selected" ' : '' );
					$output .= '<option '.$transformSelected.' value="'. esc_attr($transform) .'">'.$transform.'</option>';
				}
			$output .= '</select>';
			
			return $output;
		}
		}

### 	FONT WEIGHT
		if ( !function_exists('mnml_optioncomponent_fontweight') ) {
		function mnml_optioncomponent_fontweight( $name, $font_family = false ){
			
			if ( !$font_family ){ exit(); }
			
			$opt_name	 	= 'font-weight-'.$name;
			$class 			= ( isset($opts['class']) ? $opts['class'] : '' );
			$weight_list	= ( isset($opts['weightlist']) ? $opts['weightlist'] : false );
			$defaults 		= mnml_default_values();
			
			if ( !$weight_list ){
				$font_list = get_option('mnml_google_fonts');
				$font_list = unserialize($font_list);
				$weight_list = $font_list[$font_family]['variants'];
			}
			foreach($weight_list as $key => $variant) {
				if(strpos($variant, 'italic') !== false){
					unset($weight_list[$key]);
				}
			}

			$curr_weight = ( mnml_themeoption($opt_name) ? mnml_themeoption($opt_name,'attr') : ( isset($defaults[$opt_name]) ? $defaults[$opt_name] : 'normal' ) );

			$output = '';
			$output .= '<select class="font-weight-switcher '.esc_attr($class).'" name="'. esc_attr($opt_name) .'" id="'. esc_attr($opt_name) .'" style="width: 70px; text-transform:capitalize">';
				
				foreach( $weight_list as $weight ){
					$weight = ( $weight === 'regular' ? 'normal' : $weight );
					$weightSelected = ( $curr_weight == $weight ? 'selected="selected" ' : '' );
					$output .= '<option '.$weightSelected.' value="'. esc_attr($weight) .'">'.$weight.'</option>';
				}
			$output .= '</select>';
			
			return $output;
		}
		}
		
### 	FONT PREVIEW
		if ( !function_exists('mnml_optioncomponent_fontpreview') ) {
		function mnml_optioncomponent_fontpreview( $name, $opts = array() ){
			
			$opt_name	 	= 'font-family-'.$name.'-preview';
			$class 			= ( isset($opts['class']) ? $opts['class'] : '' );
			$sample_text 	= ( isset($opts['sampletext']) && $opts['sampletext'] ? $opts['sampletext'] : 'This is a sample text' );
			$defaults 		= mnml_default_values();
			
			$parents = ( is_array( $opts['parents'] ) ? $opts['parents'] : array() );
			
			
			$name_family 		= ( in_array('family', $parents) ? $opts['parent'] : $name );
			$curr_family = ( mnml_themeoption('font-family-'.$name_family) ? mnml_themeoption('font-family-'.$name_family,'attr') : ( isset($defaults['font-family-'.$name_family]) ? $defaults['font-family-'.$name_family] : 'Arial' ) );
			$curr_family_style 	= 'font-family:'.$curr_family.';';
			
			
			$name_size 			= ( in_array('size', $parents) ? $opts['parent'] : $name );
			$curr_size			= ( mnml_themeoption('font-size-'.$name_size) ? mnml_themeoption('font-size-'.$name_size,'attr') : ( isset($defaults['font-size-'.$name_size]) ? $defaults['font-size-'.$name_size] : '12' ) );
			$curr_size_style 	= 'font-size:'.$curr_size.'px;';
			
			$name_weight 		= ( in_array('weight', $parents) ? $opts['parent'] : $name );
			$curr_weight		= ( mnml_themeoption('font-weight-'.$name_weight) ? mnml_themeoption('font-weight-'.$name_weight,'attr') : ( isset($defaults['font-weight-'.$name_weight]) ? $defaults['font-weight-'.$name_weight] : 'normal' ) );
			$curr_weight_style 	= 'font-weight:'.$curr_weight.';';
			
			$name_color 		= ( in_array('color', $parents) ? $opts['parent'] : $name );
			$curr_color			= ( mnml_themeoption('font-color-'.$name_color) ? mnml_themeoption('font-color-'.$name_color,'attr') : ( isset($defaults['font-color-'.$name_color]) ? $defaults['font-color-'.$name_color] : '#222222' ) );
			$curr_color_style 	= 'color:'.$curr_color.';';

			$name_spacing 		= ( in_array('spacing', $parents) ? $opts['parent'] : $name );
			$curr_spacing		= ( mnml_themeoption('font-spacing-'.$name_spacing) > -5 ? mnml_themeoption('font-spacing-'.$name_spacing,'attr') : ( isset($defaults['font-spacing-'.$name_spacing]) ? $defaults['font-spacing-'.$name_spacing] : '0' ) );
			$curr_spacing_style = 'letter-spacing:'.$curr_spacing.'em;';

			$name_transform		= ( in_array('transform', $parents) ? $opts['parent'] : $name );
			$curr_transform		= ( mnml_themeoption('font-transform-'.$name_transform) ? mnml_themeoption('font-transform-'.$name_transform,'attr') : ( isset($defaults['font-transform-'.$name_transform]) ? $defaults['font-transform-'.$name_transform] : 'none' ) );
			$curr_transform_style = 'text-transform:'.$curr_transform.';';

			
			$output = '';
			$output .= '<div id="'. esc_attr($opt_name) .'" class="font-preview '.esc_attr($class).'" style="'.$curr_size_style.$curr_transform_style.$curr_family_style.$curr_weight_style.$curr_color_style.$curr_spacing_style.'">'.$sample_text.'</div>';
			
			return $output;
			
		}
		}
		
########	FONT STYLE APPLIER
			if ( !function_exists('mnml_applystyle_font') ) {
			function mnml_applystyle_font( $name, $selector, $props = array() ){
				
				if ( empty($props) ) return;
				
				$defaults = mnml_default_values();
				$saved = mnml_themeoption( 'font-'.$props[0].'-'.$name );
				
				$props_format = array(
					'family' => 'font-family:%s,Arial,sans-serif;',
					'size' => 'font-size:%spx;',
					'weight' => 'font-weight:%s;',
					'spacing' => 'letter-spacing:%sem;',
					'color' => 'color:%s;',
					'transform' => 'text-transform:%s;'
				);
				$props_setup = array();
				
				if ( $saved ) {
					foreach( $props as $prop ) {
					$props_setup[$prop] = sprintf( $props_format[$prop], mnml_themeoption('font-'.$prop.'-'.$name) );
					}
				} else if( isset($defaults['font-'.$props[0].'-'.$name]) ) {
					foreach( $props as $prop ) {
					$props_setup[$prop] = sprintf( $props_format[$prop], $defaults['font-'.$prop.'-'.$name] );
					}
				} else {
					return;
				}
				
				return $selector . '{ ' . implode(' ',$props_setup) . ' }';
				
				
			}
			}


/*-----------------------------------------------------
 *		IMAGE/PATTERN SELECTOR
 *------------------------------------------------------------*/

		if ( !function_exists('mnml_optioncomponent_imageselector') ) {
		function mnml_optioncomponent_imageselector( $name, $opts = array() ){
			
			$opt_name		= 'IS-'.$name;
			$class 			= ( isset($opts['class']) && $opts['class'] ? $opts['class'] : '' );
			$skins 			= ( isset($opts['skins']) && $opts['skins'] ? $opts['skins'] : false );
			$active			= ( isset($opts['active']) && $opts['active'] ? $opts['active'] : false );
			$noitems		= ( isset($opts['noitems']) && $opts['noitems'] ? $opts['noitems'] : 'There are currently no items on the list!' );
			$defaults 		= mnml_default_values();
			
			if ( !$skins ){ return 'No skins are setup. Do so by passing a "skins" array on $args'; }
			
			
			$output =	'<div class="IS-wrapper" id="'. esc_attr($opt_name) .'">';
				$orderNr = 0;
				foreach ( $skins as $skin_name => $skin_data ){
					$output .=	'<div class="IS-section" id="IS-section-'.$skin_name.'" style="'.( $active === $skin_name ? 'display:block;' : '' ).'">';
									$name_input = $opt_name.'-'.$skin_name;
									$name_selected = $opt_name.'-'.$skin_name.'-selected';
					$output .=		'<input type="hidden" class="IS-input" name="'. esc_attr($name_input) .'" value="'.mnml_themeoption($name_input,'attr').'" /><br />';
					$output .=		'<input type="hidden" class="IS-selected" name="'. esc_attr($name_selected) .'" value="'.mnml_themeoption($name_selected,'attr').'" /><br />';
									$orderNr = 0;
									foreach ( $skin_data['patt'] as $patt ) {
										$pattern_url = $skin_data['path'].$patt;
										$pattern_class = '';
										if ( $patt === 'none' ){ 
											$pattern_url = 'none';
											$pattern_class = 'none';
										}
					$output .=			'<div class="IS-patt '.esc_attr($pattern_class).'" data-nr="'.esc_attr($orderNr).'" data-patt="'.esc_attr($pattern_url).'" style="background:url('.$skin_data['path'].$patt.');"></div>';
										$orderNr++;
									}
					$output .=	'</div>';
				}
			$output .=	'</div>';
			
			return $output;
		}
		}


/*-----------------------------------------------------
 *		SORTABLES
 *------------------------------------------------------------*/

		if ( !function_exists('mnml_optioncomponent_sortable') ) {
		function mnml_optioncomponent_sortable( $name, $opts = array() ){

			$class 			= ( isset($opts['class']) && $opts['class'] ? $opts['class'] : '' );
			$type 			= ( isset($opts['type']) && $opts['type'] ? $opts['type'] : false );
			$noitems		= ( isset($opts['noitems']) && $opts['noitems'] ? $opts['noitems'] : 'There are currently no items on the list!' );
			$defaults 		= mnml_default_values();
			
			if ( !$type ){ exit(); }
			
			$sort_string = ( mnml_themeoption('SORT-ARRAY-'.$name) !== false ? mnml_themeoption('SORT-ARRAY-'.$name,'attr') : ( isset($defaults['SORT-ARRAY-'.$name]) ? $defaults['SORT-ARRAY-'.$name] : '' ) );
			$sort_array = explode( ',', $sort_string );

			/* Store list items on a variable */
			$items = '';
			if ( $sort_string != '' ) {
				
				switch ( $type ) { //Check the item type and call the proper function
				  	#homesections
					case 'videosets' : 
					foreach ( $sort_array as $number ) { $items .= mnml_optioncomponent_sortablevideosets( $name, $number ); }
					break;
				  	#socialicons
					case 'socialicons' : 
					foreach ( $sort_array as $number ) { $items .= mnml_optioncomponent_sortablesocialicons( $name, $number ); }
					break;
				  	#slider
					case 'slider' : 
					foreach ( $sort_array as $number ) { $items .= mnml_optioncomponent_sortableslider( $name, $number ); }
					break;
				  	#error: no proper type set	
					default : 
					$items .= '<li class="noitems error">No proper type set</li>';
					break;
				}
			} else {
				//'No Items' message is displayed if there are no items
				$items .= mnml_optioncomponent_sortablenoitems( $noitems );
			}
			
			$output =	'<div class="SORT-wrapper '.esc_attr($class).'" id="'. esc_attr($name) .'" data-type="'. esc_attr($type) .'" data-noitems="'.esc_attr($noitems).'">'.
							'<div class="SORT-overlayer"></div>'.
							'<input type="hidden" class="SORT-array" name="'. esc_attr('SORT-ARRAY-'.$name) .'" value="'. esc_attr($sort_string) .'" />'.
							/*$type.'&nbsp;&nbsp;-&nbsp;&nbsp;'.*/'<a href="#" class="SORT-add">Add New</a><br /><br /><br />'.
							'<ul class="SORT-list" id="'. esc_attr('SORT-LIST-'.$name) .'">'.
								$items.
							'</ul>'.
						'</div>';
			
			return $output;
		}
		}

###		SORTABLE: videosets
		if ( !function_exists('mnml_optioncomponent_sortablevideosets') ) {
		function mnml_optioncomponent_sortablevideosets( $name = 'XX', $number = 'YY', $opts = array() ){
			
			$opt_name 	= $name.'-'.$number;
			$class 		= ( isset($opts['class']) && $opts['class'] ? $opts['class'] : '' );
			$defaults 	= ( isset($opts['empty']) ? array() : mnml_default_values() );
			
			//	component: #upload-webm
				$vid_webm =	'<input type="text" name="'. esc_attr($opt_name.'-video-webm') .'" value="'.mnml_themeoption($opt_name.'-video-webm','attr').'" class="upload-field the1-upload-field" />' .
							'&nbsp;' .
							'<a href="javascript:void(0);" class="the1-btn2 the1-upload-btn">Upload</a>';
				//	end: #upload-webm

			//	component: #upload-mp4
				$vid_mp4 =	'<input type="text" name="'. esc_attr($opt_name.'-video-mp4') .'" value="'.mnml_themeoption($opt_name.'-video-mp4','attr').'" class="upload-field the1-upload-field" />' .
							'&nbsp;' .
							'<a href="javascript:void(0);" class="the1-btn2 the1-upload-btn">Upload</a>';
				//	end: #upload-mp4

			//	component: #upload-image
				$vid_image =	'<input type="text" name="'. esc_attr($opt_name.'-video-image') .'" value="'.mnml_themeoption($opt_name.'-video-image','attr').'" class="upload-field the1-upload-field" />' .
							'&nbsp;' .
							'<a href="javascript:void(0);" class="the1-btn2 the1-upload-btn">Upload</a>';
				//	end: #upload-image


			$output = 	'<li class="SORT-item" id="'. esc_attr('SORT-ITEM-'.$opt_name) .'">'.
			
							'<div class="SORT-item-head">'.
								'<div class="head-span grey sort-label">Title:</div>'.
								'<div class="head-span" id="'. esc_attr('typr-'.$opt_name) .'-title">'.mnml_themeoption($opt_name.'-title','attr').'</div>'.
								'<div class="head-span grey sort-label">Handle:</div>'.
								'<div class="head-span" style="font-family: courier new;">vb__<span class="typr-'.esc_attr($opt_name).'-handle">'.mnml_themeoption($opt_name.'-handle','attr').'</span>__vb</div>'.
								'<div class="ctrl">'.
									'<div class="delete"></div>'.
									'<div class="grip"></div> '.                                           
									'<div class="expand"></div>'.
								'</div>'.
							'</div>'.
							
							'<div class="SORT-item-body">'.
								'<div>'.
									#title
									'<div style="margin-bottom:10px;">'.
										'<span style="display:inline-block;width: 110px;">Title</span>'.
										'<input placeholder="Use this title for your description only..." type="text" name="'. esc_attr($opt_name.'-title') .'" id="'. esc_attr($opt_name.'-title') .'" value="'.mnml_themeoption($opt_name.'-title','attr').'" class="dynamictyping"/>'.
									'</div>'.
									#handle
									'<div style="margin-bottom:10px;">'.
										'<span style="display:inline-block;width: 110px;">Handle (tag)</span>'.
										'<input type="text" name="'. esc_attr($opt_name.'-handle') .'" id="'. esc_attr($opt_name.'-handle') .'" value="'.mnml_themeoption($opt_name.'-handle','attr').'" class="dynamictyping"/><br />'.
										'<span style="display:inline-block;width: 110px;height: 2px;"></span>'.
										'<div class="grey explanation" style="display:inline-block;width:350px;">Use only "a-z","-" and "_" to create a handle parameter.<br />Use the "vb__<span class="typr-'.esc_attr($opt_name).'-handle">'.mnml_themeoption($opt_name.'-handle','attr').'</span>__vb" handle as a class name to a visual composer row to link it to the current video set.</div>' .
									'</div>'.
								'</div>'.
								'<br /><br />'.
								'<div>'.
									#video webm
									'<div style="margin-bottom:10px;">'.
										'<span style="display:inline-block;width: 110px;">Webm</span>'.
										$vid_webm .
									'</div>'.
									#video mp4
									'<div style="margin-bottom:10px;">'.
										'<span style="display:inline-block;width: 110px;">Mp4</span>'.
										$vid_mp4 .
									'</div>'.
									#video image
									'<div style="margin-bottom:10px;">'.
										'<span style="display:inline-block;width: 110px;">Poster image</span>'.
										$vid_image .
									'</div>'.
								'</div>'.
							'</div>'.
							
					 	'</li>';


			if ( isset($_POST['SORTadd']) ){
				die($output);
			} else {
				return $output;
			}
		}
		}


###		SORTABLE: slider
		if ( !function_exists('mnml_optioncomponent_sortableslider') ) {
		function mnml_optioncomponent_sortableslider( $name = 'XX', $number = 'YY', $opts = array() ){
			
			$opt_name 	= $name.'-'.$number;
			$class 		= ( isset($opts['class']) && $opts['class'] ? $opts['class'] : '' );
			$defaults 	= ( isset($opts['empty']) ? array() : mnml_default_values() );
			
			$output = 	'<li class="SORT-item" id="'. esc_attr('SORT-ITEM-'.$opt_name) .'">'.
							'<div class="SORT-item-head">'.
								'<div class="head-span" id="'. esc_attr('typr-'.$opt_name.'-input') .'">'.mnml_themeoption($opt_name.'-input','attr').'</div>'.
								'<div class="ctrl">'.
									'<div class="delete"></div>'.
									'<div class="grip"></div> '.                                           
									'<div class="expand"></div>'.
								'</div>'.
							'</div>'.
							'<div class="SORT-item-body">'.
								'<input type="text" name="'. esc_attr($opt_name.'-input') .'" id="'. esc_attr($opt_name.'-input') .'" value="'.mnml_themeoption($opt_name.'-input','attr').'" class="dynamictyping"/>'.
								'<div class="SORT-item-foot"><a href="#" class="updateitem">Close</a></div>'.
							'</div>'.
						'</li>';
										
			if ( isset($_POST['SORTadd']) ){
				die($output);
			} else {
				return $output;
			}
		}
		}


###		SORTABLE: Social Icons
		if ( !function_exists('mnml_optioncomponent_sortablesocialicons') ) {
		function mnml_optioncomponent_sortablesocialicons( $name = 'XX', $number = 'YY', $opts = array() ){
			
			$opt_name 	= $name.'-'.$number;
			$class 		= ( isset($opts['class']) && $opts['class'] ? $opts['class'] : '' );
			
			if ( isset($opts['empty']) ){
				$option_icon 	= 'be';
				$option_url 	= '';
				$newitem_class	= 'NEWITEM';
			} else {
				$option_icon 	= mnml_themeoption($opt_name.'-icon','attr');
				$option_url 	= mnml_themeoption($opt_name.'-url','attr');
				$newitem_class	= '';
			}
			
			$output = 	'<li class="SORT-item" id="'. esc_attr('SORT-ITEM-'.$opt_name) .'">'.
							'<div class="SORT-item-head '.esc_attr($newitem_class).'">'.
								#icon
								'<div class="head-span" style="width: 50px">'.
									'<div class="socialdd">'.
										'<input type="hidden" class="socialdd-input" name="'. esc_attr($opt_name.'-icon') .'" value="'. esc_attr($option_icon) .'"/>'.
										'<div class="socialdd-icon '. esc_attr($option_icon).'"><div class="socialdd-arrow"></div></div>'.
										'<div class="socialdd-list">'.
											'<a data-value="be">Behance</a>'.
											'<a data-value="da">DeviantArt</a>'.
											'<a data-value="dr">Dribbble</a>'.
											'<a data-value="fb">Facebook</a>'.
											'<a data-value="fr">Flickr</a>'.
											'<a data-value="gg">Google+</a>'.
											'<a data-value="ig">Instagram</a>'.
											'<a data-value="fm">LastFm</a>'.
											'<a data-value="li">LinkedIn</a>'.
											'<a data-value="pi">Pinterest</a>'.
											'<a data-value="sc">SoundCloud</a>'.
											'<a data-value="tu">Tumblr</a>'.
											'<a data-value="tw">Twitter</a>'.
											'<a data-value="yt">YouTube</a>'.
											'<a data-value="vi">Vimeo</a>'.
										'</div>'.
									'</div>'.
								'</div>'.
								#url
								'<div class="head-span" style="width: 400px">'.
									'<input type="text" name="'. esc_attr($opt_name.'-url') .'" value="'. esc_attr($option_url) .'" style="margin-top: 4px" placeholder="Type full URL to your profile here..." />'.
								'</div>'.
								#controls
								'<div class="ctrl">'.
									'<div class="delete"></div>'.
									'<div class="grip"></div> '.                                           
								'</div>'.
							'</div>'.
						'</li>';
										
			if ( isset($_POST['SORTadd']) ){
				die($output);
			} else {
				return $output;
			}
		}
		}


###		AJAX ADD ITEMS
		if ( !function_exists('mnml_optioncomponent_sortableajaxadd') ) {
		function mnml_optioncomponent_sortableajaxadd(){

			$name 	= $_POST['name'];
			$number = $_POST['number'];
			$type 	= $_POST['type'];

			switch ( $type ) { //Check the item type and call the proper function
				#homesections
				case 'videosets' : 
				$item = mnml_optioncomponent_sortablevideosets( $name, $number, array('empty'=>true) );
				break;
				#socialicons
				case 'socialicons' : 
				$item = mnml_optioncomponent_sortablesocialicons( $name, $number, array('empty'=>true) );
				break;
				#slider
				case 'slider' : 
				$item = mnml_optioncomponent_sortableslider( $name, $number, array('empty'=>true) );
				break;
				#error: no proper type set
				default : 
				$item = '<li class="noitems error">No proper type set</li>';
				break;
			}

			echo $items;
			die();

		}
		add_action('wp_ajax_sortable_ajaxadd', 'mnml_optioncomponent_sortableajaxadd');
		}

###		NO ITEMS
		if ( !function_exists('mnml_optioncomponent_sortablenoitems') ) {
		function mnml_optioncomponent_sortablenoitems( $label ){
			
			$output = '<li class="noitems">'.$label.'</li>';
			return $output;
		}
		}


/*-----------------------------------------------------
 *		GALLERY
 *------------------------------------------------------------*/

		if ( !function_exists('mnml_optioncomponent_gallery') ) {
		function mnml_optioncomponent_gallery( $name, $opts = array() ){

			$class 			= ( isset($opts['class']) && $opts['class'] ? $opts['class'] : '' );
			$type 			= ( isset($opts['type']) && $opts['type'] ? $opts['type'] : false );
			$noitems		= ( isset($opts['noitems']) && $opts['noitems'] ? $opts['noitems'] : 'There are currently no items on the list!' );
			$defaults 		= mnml_default_values();
			
			$sort_string = ( mnml_themeoption('GALLERY-ARRAY-'.$name) ? mnml_themeoption('GALLERY-ARRAY-'.$name,'attr') : ( isset($defaults['GALLERY-ARRAY-'.$name]) ? $defaults['GALLERY-ARRAY-'.$name] : '' ) );
			$sort_array = explode( ',', $sort_string );

			/* Store list items on a variable */
			$items = '';
			if ( $sort_string != '' ) {
				
				$items = mnml_optioncomponent_gallerygenerateimages( $name, $sort_array );
				
			} else {
				//'No Items' message is displayed if there are no items
				$items .= mnml_optioncomponent_sortablenoitems( $noitems );
			}
			
			$output =	'<div class="GALLERY-wrapper '.esc_attr($class).'" id="'.esc_attr($name).'" data-type="'.esc_attr($type).'" data-noitems="'.esc_attr($noitems).'">'.
							'<input type="text" class="GALLERY-array" name="'. esc_attr('GALLERY-ARRAY-'.$name) .'" value="'.esc_attr($sort_string).'" />'.
							'&nbsp;&nbsp;-&nbsp;&nbsp;'.
							'<a href="#" class="UPLOAD-MEDIA" data-target="'.esc_attr($name).'" data-multiple="true" data-title="'. esc_attr('apllodi per: '.$name) .'" data-framework="gallery">Add new item</a>'.
							'<br /><br /><br />'.
							'<ul class="GALLERY-list" id="'. esc_attr('GALLERY-LIST-'.$name) .'">'.
								$items.
							'</ul>'.
						'</div>';
			
			return $output;
		}
		}


###		GALLERY: Single item
		if ( !function_exists('mnml_optioncomponent_gallerygenerateimages') ) {
		function mnml_optioncomponent_gallerygenerateimages( $name = 'XX', $items_array = false, $opts = array() ){
			
			$class 		= ( isset($opts['class']) && $opts['class'] ? $opts['class'] : '' );
			$defaults 	= ( isset($opts['empty']) ? array() : mnml_default_values() );
			
			$output = '';
			
			if ( $items_array ){
				
				
				foreach ( $items_array as $item ) {

					$opt_name = $name.'-'.$item;
					$thumbimg = wp_get_attachment_link( $item, 'thumbnail', true );
					
					$output .= 	'<li class="GALLERY-item" id="'. esc_attr('GALLERY-ITEM-'.$opt_name) .'">'.
								'<div>'.
									'<div class="GALLERY-item-image">'.$thumbimg.'</div>'.
									'<div class="GALLERY-item-data">'.
										'<div class="GALLERY-item-title"><input type="text" name="'. esc_attr($opt_name.'-title') .'" value="'.mnml_themeoption($opt_name.'-title','attr').'" /></div>'.
										'<div class="GALLERY-item-description"><input type="text" name="'. esc_attr($opt_name.'-description') .'" value="'.mnml_themeoption($opt_name.'-description','attr').'" /></div>'.
									'</div>'.
									'<div class="GALLERY-item-controls">'.
										'<div class="GALLERY-item-delete">Del</div>'.
									'</div>'.
								'</div>'.
								'</li>';

				}
				
								
			}
			
			if ( isset($_POST['GALLERYadd']) ){
				die($output);
			} else {
				return $output;
			}
		}
		}


###		AJAX ADD ITEMS
		if ( !function_exists('mnml_optioncomponent_galleryajaxadd') ) {
		function mnml_optioncomponent_galleryajaxadd(){

			$name 	= $_POST['name'];
			$items_array = explode( ',', $_POST['items'] );

			$item = mnml_optioncomponent_gallerygenerateimages( $name, $items_array, array('empty'=>true) );

			echo $items;
			die();

		}
		add_action('wp_ajax_gallery_ajaxadd', 'mnml_optioncomponent_galleryajaxadd');
		}

###		NO ITEMS
		if ( !function_exists('mnml_optioncomponent_gallerynoitems') ) {
		function mnml_optioncomponent_gallerynoitems( $label ){
			
			$output = '<li class="noitems">'.$label.'</li>';
			return $output;
		}
		}


/*-----------------------------------------------------
 *		TWITTER FEED api 1.1
 *------------------------------------------------------------*/

		if ( !function_exists('mnml_optioncomponent_twitterfeed') ) {
		function mnml_optioncomponent_twitterfeed(){
			
			$output =	'<p>'.
							'Username<br />'.
							'<input type="text" name="tw-username" value="'.mnml_themeoption('tw-username', 'attr').'" style="width:130px;"/>'.
						'</p>'.
						'<input type="hidden" name="tw-cachetime" value="'.mnml_themeoption('tw-cachetime', 'attr').'"/>' .
						/*
						'<p>'.
							'Cache Time:'.
							'<select name="tw-cachetime" value="'.mnml_themeoption('tw-cachetime', 'attr').'" style="width:50px">'.
								'<option value="200"> 2 </option>'.
								'<option value="400"> 4 </option>'.
								'<option value="600"> 6 </option>'.
								'<option value="800"> 8 </option>'.
							'</select> h'.
						'</p>'.
						*/
						'<br />'.
						'<p>'.
							'Consumer Key:<br />'.
							'<input type="text" name="tw-consumerkey" value="'.mnml_themeoption('tw-consumerkey', 'attr').'"/><br />'.
						'</p>'.
						'<p>'.
							'Consumer Secret:<br />'.
							'<input type="text" name="tw-consumersecret" value="'.mnml_themeoption('tw-consumersecret', 'attr').'"/><br />'.
						'</p>'.
							'<p>'.
							'Access Token:<br />'.
							'<input type="text" name="tw-accesstoken" value="'.mnml_themeoption('tw-accesstoken', 'attr').'"/><br />'.
						'</p>'.
						'<p>'.
							'Access Token Secret:<br />'.
							'<input type="text" name="tw-accesstokensecret" value="'.mnml_themeoption('tw-accesstokensecret', 'attr').'"/>'.
							'<br /><br />'.
						'</p>';
			
			return $output;
		}
		}




/*-----------------------------------------------------
 *		OTHERS
 *------------------------------------------------------------*/


###		SELECT
		if ( !function_exists('mnml_optioncomponent_select') ) {
		function mnml_optioncomponent_select( $args ){
			
			$name = ( isset($args['name']) && $args['name'] ? $args['name'] : false );
			if ( !$name ) { return 'name required'; };
			
			$options = ( isset($args['options']) && is_array($args['options']) && !empty($args['options']) ? $args['options'] : false );
			if ( !$options ) { return 'options required'; };
			
			$selected = ( isset($args['selected']) && $args['selected'] ? $args['selected'] : mnml_themeoption($name,'attr') );
			
			$style = ( isset($args['style']) && $args['style'] ? 'style="'. esc_attr($args['style']) .'"' : '' );
			
			$output = '';
			
			$output .= '<select name="'. esc_attr($name) .'" id="'. esc_attr($name) .'" '.$style.'>';
				foreach ( $options as $val => $text ) {
					$sel = ( $val === $selected ? 'selected="selected"' : '' );
					$output .=	'<option value="'. esc_attr($val) .'" '.$sel.'>'.$text.'</option>';
				}
			$output .= '</select>';
			
			return $output;
		}
		}


###		SLIDER (jQuery ui)
		if ( !function_exists('mnml_optioncomponent_uislider') ) {
		function mnml_optioncomponent_uislider( $args ){
			
			$name = ( isset($args['name']) && $args['name'] ? $args['name'] : false );
			if ( !$name ) { return 'name required'; };

			$defaults = mnml_default_values();
			$value = ( mnml_themeoption($name) !== false || mnml_themeoption($name) !== '' ? mnml_themeoption($name,'attr') : ( isset($defaults[$name]) ? $defaults[$name] : 85 ) );

			$label = ( isset($args['label']) && $args['label'] ? $args['label'].':&nbsp;&nbsp;' : '' );

			$dataset = ( isset($args['data']) && is_array($args['data']) && !empty($args['data']) ? implode(' ',$args['data']) : '' );
			
			$style = ( isset($args['style']) && $args['style'] ? 'style="'. esc_attr( $args['style'] ) . '"' : '' );
			
			$output =	'<div class="SLIDER-wrapper" '. $style .'">'.
							'<div class="SLIDER-label">'.$label.'<span class="SLIDER-displayvalue"></span></div>'.
							'<div class="SLIDER" '.$style.' '.$dataset.'></div>'.
							'<input type="hidden" class="SLIDER-value" name="'. esc_attr($name) .'" value="'. esc_attr($value).'" />'.
						'</div>';
			
			return $output;
		}
		}

?>