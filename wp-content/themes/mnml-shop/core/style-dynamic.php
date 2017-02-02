<?php

	if ( !function_exists('mnml_dynamic_style') ){
		function mnml_dynamic_style(){
			$output = '';
		/*	font: body  */
		
			$output .= mnml_applystyle_font( 'body', 'body', array('family','color','size','weight') ); 
			
			$links_color = ( mnml_themeoption('links-color') ? mnml_themeoption('links-color','attr') : '#000000' );
			$output .=  'a {';
			$output .=  ( $links_color ? 'color:'.$links_color.';' : '' );
			$output .= 	'}';

			$links_hover_color = ( mnml_themeoption('links-hover-color') ? mnml_themeoption('links-hover-color','attr') : '#29a78e' );
			$output .= 'a:hover {';
			$output .= ( $links_hover_color ? 'color:'.$links_hover_color.';' : '' );
			$output .= '}';

		/*	font: headings  */
		
			$output .=  mnml_applystyle_font( 'h1', 'h1', array('weight','spacing','color','family','transform') );
			$output .=  mnml_applystyle_font( 'h2', 'h2', array('weight','spacing','color','family','transform') );
			$output .=  mnml_applystyle_font( 'h3', 'h3', array('weight','spacing','color','family','transform') );
			$output .=  mnml_applystyle_font( 'h4', 'h4', array('weight','spacing','color','family','transform') );
			$output .=  mnml_applystyle_font( 'h5', 'h5', array('weight','spacing','color','family','transform') );
			$output .=  mnml_applystyle_font( 'h6', 'h6', array('weight','spacing','color','family','transform') );

			$output .=  mnml_applystyle_font( 'h1', 'h1 a', array('color') );
			$output .=  mnml_applystyle_font( 'h2', 'h2 a', array('color') );
			$output .=  mnml_applystyle_font( 'h3', 'h3 a', array('color') );
			$output .=  mnml_applystyle_font( 'h4', 'h4 a', array('color') );
			$output .=  mnml_applystyle_font( 'h5', 'h5 a', array('color') );
			$output .=  mnml_applystyle_font( 'h6', 'h6 a', array('color') );
			
			$output .= "\r\n";
			$output .= '@media screen and (min-width:901px){';
				$output .= mnml_applystyle_font( 'h1', 'h1', array('size') );
				$output .= mnml_applystyle_font( 'h2', 'h2', array('size') );
				$output .= mnml_applystyle_font( 'h3', 'h3', array('size') );
				$output .= mnml_applystyle_font( 'h4', 'h4', array('size') );
				$output .= mnml_applystyle_font( 'h5', 'h5', array('size') );
				$output .= mnml_applystyle_font( 'h6', 'h6', array('size') );
			$output .= '}';

		
		/*	header  */
		
			
			$output .= $header_bg_alpha = ( mnml_themeoption('header-bg-opacity') !== false ? mnml_themeoption('header-bg-opacity','attr')*0.01 : false );
			$output .= $header_bg_color = ( mnml_themeoption('header-bg-color') ? mnml_themeoption('header-bg-color','attr') : '#ffffff' );
			$output .= $header_bg = ( $header_bg_alpha !== false && $header_bg_color ? implode(',',mnml_hex2rgb($header_bg_color)).','.$header_bg_alpha : '' );
			$output .= $header_height = ( mnml_themeoption('header-height') ? mnml_themeoption('header-height','attr') : false );
			$output .= $border_radius = ( mnml_themeoption('header-border-radius') ? mnml_themeoption('header-border-radius','attr') : 0 );

			$output .= $header_position = ( mnml_themeoption('header-position') ? mnml_themeoption('header-position','attr') : 0 );
			$output .= "\r\n";
			$output .= '.header-wrapper{';
				$output .= ( $header_position ? 'margin-top: '.$header_position.'px;' : '' );
			$output .= '	}';
			$output .= '.header-spacer{';
				$output .= ( $header_position ? 'margin-bottom: '.$header_position.'px;' : '' );
			$output .= '	}';
			$output .= '#header-sticky{';
				$output .= ( $header_bg_color ? 'background-color: '.$header_bg_color.';' : '' );
			$output .= '	}';
			
			$output .= "\r\n";	
			$output .= '#header{';
				$output .= ( $header_bg ? 'background-color: '.$header_bg_color.';' : '' );
			$output .= '	}';
			$output .= '@media screen and (min-width:601px){';			
			$output .= '#header{';
				$output .= ( $header_bg ? 'background-color: rgba('.$header_bg.');' : '' );
				$output .= ( $border_radius ? 'border-radius: '.$border_radius.'px;' : '' );
			$output .= '	}';
			$output .= '}';
			
			
			$topinfo_color = ( mnml_themeoption('header-info-color') ? mnml_themeoption('header-info-color','attr') : false );
			$topinfo_color_link = ( $topinfo_color ? implode(',',mnml_hex2rgb($topinfo_color)).',0.7' : '' );
			$output .= "\r\n";
			$output .= '.header-info,';
			$output .= '.header-info a{';
				$output .= ( $topinfo_color_link ? 'color: rgba('.$topinfo_color_link.');' : '' );
			$output .= '}';
			$output .= '.header-info a:hover{';
				$output .= ( $topinfo_color ? 'color:'.$topinfo_color.';' : '' );
			$output .= '	}';

			$output .= mnml_applystyle_font( 'logo', '.site-logo, .site-logo:hover', array('weight','spacing','color','family','size','transform') );
			
		/*	title-bar  */
			
			
			# titlebar: Page
			$bar = array();
			$pre_name = 'pagetitlebar';
			$bar['bg-image'] = ( mnml_themeoption($pre_name.'-bg') ? mnml_themeoption($pre_name.'-bg','url') : false );
			$bar['alpha'] = ( mnml_themeoption($pre_name.'-overlay-opacity') ? mnml_themeoption($pre_name.'-overlay-opacity','attr')/100 : '1' );
			$bar['bg-color'] = ( mnml_themeoption($pre_name.'-overlay-color') ? mnml_themeoption($pre_name.'-overlay-color','attr') : '#333' );
			
			$output .= "\r\n";
			$output .= '.titlebar{';
				$output .= ( $bar['bg-image'] ? 'background-image: url('.$bar['bg-image'].');' : '' );
				$output .= ( $bar['bg-color'] ? 'background-color: '.$bar['bg-color'].';' : '' );
			$output .= '	}';
		

		/*	micromenu  */
		
			$output .= "\r\n";
			$output .= '@media screen and (min-width:801px){';
			$output .= '	.header-home.fixed .site-logo span,';
			$output .= '	.header-inside.fixed .site-logo span{';
			$output .= '		font-size: 85%;';
			$output .= '	}';
			$output .= '}';


		/*	footer  */
			$output .= mnml_applystyle_font( 'footer-text', '#footer, #footer a, .copyright', array('family','size','color','transform') );

			$output .= $foot_bg = ( mnml_themeoption('footer-bg') ? mnml_themeoption('footer-bg','url') : '' );
			$output .= "\r\n";
			$output .= '#footer{';
				$output .= ( $foot_bg ? 'background-image: url(' .$foot_bg. ');': '');
			$output .= '}';
			
			$foot_overlayer_color = ( mnml_themeoption('footer-overlay-color') ? mnml_themeoption('footer-overlay-color','attr') : '#000000' );
			$foot_overlayer_opacity = ( mnml_themeoption('footer-overlay-opacity') ? mnml_themeoption('footer-overlay-opacity','attr')/100 : '0.85' );
			$foot_overlayer = ( $foot_overlayer_color && $foot_overlayer_opacity ? implode(',',mnml_hex2rgb($foot_overlayer_color)).','.$foot_overlayer_opacity : '' );
			$output .= '.footer-overlay{';
				$output .= ( $foot_overlayer ? 'background-color: rgba('.$foot_overlayer.') !important;' : '' );
			$output .= '}';

			$copyright_color = ( mnml_themeoption('copyright-bg') ? mnml_themeoption('copyright-bg','attr') : false );
			$copyright_opacity = ( mnml_themeoption('copyright-opacity') ? mnml_themeoption('copyright-opacity','attr')/100 : '1' );
			$copyright_bg = ( $copyright_color ? implode(',',mnml_hex2rgb($copyright_color)).','.$copyright_opacity : false );
			$output .= '.copyright-wrapper{';
				$output .= ( $copyright_bg ? 'background-color: rgba('.$copyright_bg.') !important;' : '' ); 
			$output .= '}';

			$footer_links_color = ( mnml_themeoption('footer-links-color') ? mnml_themeoption('footer-links-color','attr') : false );
			$output .= '#footer a {';
				$output .= ( $footer_links_color ? 'color:'.$footer_links_color.';' : '' );
			$output .= '}';

			$footer_links_hover_color = ( mnml_themeoption('footer-links-hover-color') ? mnml_themeoption('footer-links-hover-color','attr') : false );
			$output .= '#footer a:hover {';
				$output .= ( $footer_links_hover_color ? 'color:'.$footer_links_hover_color.';' : '' );
			$output .= '}';
			
		/*	service blocks  */
		
			$output .= mnml_applystyle_font( 'h2', '.service-title', array('family') );

		/*	USER CUSTOM CSS  */
			$output .= esc_html(stripslashes(mnml_themeoption('custom-css')));
			return $output;
			?>			
	<?php
		}
	}
?>