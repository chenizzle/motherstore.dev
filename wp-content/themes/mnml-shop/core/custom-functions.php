<?php

//	Get site logo
	function mnml_get_site_logo($location = 'header') {

		$logo_text = mnml_themeoption('site-logo-text','attr');
		$logo_image = mnml_themeoption('site-logo','url');
		$logo_type = ( $logo_text ? 'site-logo--text' : 'site-logo--image' );
		
		if ( $logo_text ) {
			$current_logo =  $logo_text;
		} else if ( $logo_image ){
			$current_logo =  '<img alt="Logo" src="'. esc_url($logo_image) .'"/>';
		} else {
			$logo_type = 'textual';
			$current_logo =  mnml_themeinfo('name');
		}
		
		if ( $location === 'footer' ) {
			# footer logo
			$logo =	'<a class="site-logo '.esc_attr($logo_type).'" href="'.esc_url( home_url() ).'">' . 
						'<span>' . $current_logo . '</span>' .
					'</a>';
		} else {
			# header (default) logo
			$logo =	'<a class="site-logo '.esc_attr($logo_type).' float-left" href="'.esc_url( home_url() ).'">' . 
						'<span class="valign-middle">' . $current_logo . '</span>' .
					'</a>';
		}

		#return result
		return $logo;
	}


//	Get post category
	function mnml_get_post_category( $opts = array() ) {

		$cats = wp_get_post_categories( get_the_ID() );
		$cat = ( $cats ? $cats[0] : false );
		
		if ( $cats ) {
			$cat = get_category( $cats[0] );
			$class = ( isset($opts['class']) ? $opts['class'] : '' );
			$element = ( isset($opts['element']) ? $opts['element'] : 'div' );
			$colors = ( isset($opts['colors']) ? $opts['colors'] : false );
			$catcolor = ( $colors ? 'catcolor_'.$cat->term_id : '' );
			$catlink = get_category_link( $cat->term_id );
			$output =	'<'.$element.' class="'.$class.' '.$catcolor.'">' .
							'<a href="'.$catlink.'">' . $cat->name . '</a>' .
						'</'.$element.'>';
		} else {
			$output = '';
		}

		#return result
		return $output;
	}


//	Get site skin
	function mnml_get_site_skin() {
		$skin = mnml_themeoption('skin');
		if ( !$skin ) { $skin = 'default'; }

		#return result
		return $skin;
	}


//	Get site layout
	function mnml_get_site_layout() {
		$site_layout = mnml_themeoption(mnml_get_site_skin().'-site-layout');
		if ( !$site_layout ) { return; }

		#return result
		return $site_layout;
	}
	
	
//	Get header layout
	function mnml_get_header_layout() {
		$skin = mnml_get_site_skin();
		$header_layout = mnml_themeoption($skin.'-header-layout');
		$site_layout = mnml_get_site_layout();
		if ( $site_layout === 'boxed' ){
		//	$header_layout = 'layout1';
		};
		
		#return result
		return ( $header_layout ? $header_layout : 'layout1' );
	}
	

//	Checks if current page has slider
	function mnml_page_slider(){
		$id = get_the_ID();
		$slider = array();
		
		if ( !is_page() ) return false;
		
		$type = get_post_meta( $id, 'pl-slider', true );
		if ( $type ) { 
			$slider['type'] = $type;
		} else {
			return false;
		}
		
		$sl = get_post_meta( $id, 'pl-slider-'.$type, true );
		if ( $sl ) { 
			$slider['name'] = $sl;
		} else {
			return false;
		}
		
		return $slider;
	}


//	Get a list of all registered sidebars
	function mnml_get_sidebars( $type = 'array' ) {
		global $wp_registered_sidebars;
		if ( empty( $wp_registered_sidebars ) ){
			return;
		};
		
		#store sidebar data on $sidebars array
		$sidebars = array();
		foreach( $wp_registered_sidebars as $sidebar ){
			$sidebars[$sidebar['id']] = $sidebar['name'];
		}
		
		#exclude the following sidebars from list
		$exclude = array(
			'footer-column-a',
			'footer-column-b',
			'footer-column-c',
			'footer-column-d',
		);
		if ( is_array($exclude) && !empty($exclude) ){
			foreach( $exclude as $exc ){
				unset($sidebars[$exc]);
			}
		}
		
		#return results
		return $sidebars;
	}
	
	
//	Get sidebar layout for the current page
	if ( !function_exists('mnml_get_current_sidebar_layout') ) {
		function mnml_get_current_sidebar_layout( $post_id = false ) {
			
			$layout = false;
			
			//get current post ID and post type
			$post_id = ( $post_id ? $post_id : get_the_ID() );
			$post_type = get_post_type( $post_id );
			
			
			if ( is_search() ) {
				// if we're on 'search'
				$layout = mnml_themeoption('default-search-sidebar-layout');
			} else if ( $post_type === 'page' ){ 
				// if we're on 'page'
				$current_sidebar_layout = get_post_meta( $post_id, 'pl-sidebar-layout', true );
				if ( $current_sidebar_layout ) { $layout = $current_sidebar_layout; }
			}
			
			if ( !$layout || $layout === 'global' ){
				//get default sidebar layout for current post type
				$default_sidebar_layout = mnml_themeoption('default-'.$post_type.'-sidebar-layout');
				//fallback to 'post-sidebar' if default not set
				$layout = ( $default_sidebar_layout ? $default_sidebar_layout : 'right-sidebar' );
			}
			
			return $layout;
		}
	}


//	Get sidebar for the current page
	if ( !function_exists('mnml_get_current_sidebar') ) {
		function mnml_get_current_sidebar( $post_id = false ) {
			
			$sidebar = false;

			//get current post ID and post type
			$post_id = ( $post_id ? $post_id : get_the_ID() );
			$post_type = get_post_type( $post_id );

			if ( is_search() ) {
				// if we're on 'search'
				$sidebar = mnml_themeoption('default-search-sidebar');
			} else if ( $post_type === 'page' || $post_type === 'post' ){
				// if we're on 'page'
				$current_sidebar = get_post_meta( $post_id, 'pl-sidebar', true );
				if ( $current_sidebar ) { $sidebar = $current_sidebar; }
			} 
			
			if ( !$sidebar || $sidebar === 'global' ){
				//get default sidebar for current post type
				$default_sidebar = mnml_themeoption('default-'.$post_type.'-sidebar');
				//fallback to 'post-sidebar' if default not set
				$sidebar = ( $default_sidebar ? $default_sidebar : 'post-sidebar' );
			}
			
			return $sidebar;
		}
	}


//	Generate classes for content wrapper
	function mnml_content_main_class($usr=false){
		$classes = array('s-main');
		$classes[] = 's-main--'.mnml_get_current_sidebar_layout();
		
		$padding = 's-main--padding';
		if( get_the_ID() ){
			$postpad = get_post_meta( get_the_ID(), 'pl-content-padding', true );
			if ( $postpad ) { $padding = 's-main--nopadding'; }
		}
		//if ( $padding ){ $classes[] = $padding; }
		
		echo 'class="'. esc_attr( implode(' ', $classes).($usr ? ' '.$usr : '') ) .'"';
	}


//	Generate classes for sidebar
	function mnml_sidebar_class($usr=false){
		$classes = array('sidebar','s-sidebar');
		$classes[] = 's-sidebar--'.mnml_get_current_sidebar_layout();
		echo 'class="'. esc_attr( implode(' ', $classes).($usr ? ' '.$usr : '') ) .'"';
	}



//	Convert: hex -> rgb
	if ( !function_exists('mnml_hex2rgb') ){
	function mnml_hex2rgb($hex) {
		$hex = str_replace("#", "", $hex);
		
		if(strlen($hex) == 3) {
			$r = hexdec(substr($hex,0,1).substr($hex,0,1));
			$g = hexdec(substr($hex,1,1).substr($hex,1,1));
			$b = hexdec(substr($hex,2,1).substr($hex,2,1));
		} else {
			$r = hexdec(substr($hex,0,2));
			$g = hexdec(substr($hex,2,2));
			$b = hexdec(substr($hex,4,2));
		}
		$rgb = array($r, $g, $b);
		return $rgb;
	}
	}


//	Convert: rgb -> hex
	if ( !function_exists('mnml_rgb2hex') ){
	function mnml_rgb2hex($rgb) {
		$hex = "#";
		$hex .= str_pad(dechex($rgb[0]), 2, "0", STR_PAD_LEFT);
		$hex .= str_pad(dechex($rgb[1]), 2, "0", STR_PAD_LEFT);
		$hex .= str_pad(dechex($rgb[2]), 2, "0", STR_PAD_LEFT);
		
		return $hex; // returns the hex value including the number sign (#)
	}
	}
	
	
//	Get color brightness: light or dark
	if ( !function_exists('mnml_get_brightness') ){
	function mnml_get_brightness($rgb){
		$r = $rgb[0];
		$g = $rgb[1];
		$b = $rgb[2];
		
		$br = ( ($r*299)+($g*587)+($b*114) ) / 1000;
		
		if( $br > 120 ) {
			return 'light'; 
		} else {
			return 'dark'; 
		}
	}
	}


//	Customized wp_title
	function mnml_wp_title($sep = '&raquo;', $display = true, $seplocation = '') {
		global $wp_locale;
	
		$m = get_query_var('m');
		$year = get_query_var('year');
		$monthnum = get_query_var('monthnum');
		$day = get_query_var('day');
		$search = get_query_var('s');
		$title = '';
	
		$t_sep = '%WP_TITILE_SEP%'; // Temporary separator, for accurate flipping, if necessary
	
	
		// If there's a post type archive
		if ( is_post_type_archive() ) {
			$post_type = get_query_var( 'post_type' );
			if ( is_array( $post_type ) )
				$post_type = reset( $post_type );
			$post_type_object = get_post_type_object( $post_type );
			if ( ! $post_type_object->has_archive )
				$title = post_type_archive_title( '', false );
		}
	
		// If there's a category or tag
		if ( is_category() || is_tag() ) {
			$title = single_term_title( '', false );
		}
	
		// If there's a taxonomy
		if ( is_tax() ) {
			$term = get_queried_object();
			if ( $term ) {
				$tax = get_taxonomy( $term->taxonomy );
				$title = single_term_title( $tax->labels->name . $t_sep, false );
			}
		}
	
		// If there's an author
		if ( is_author() && ! is_post_type_archive() ) {
			$author = get_queried_object();
			if ( $author )
				$title = $author->display_name;
		}
	
		// Post type archives with has_archive should override terms.
		if ( is_post_type_archive() && $post_type_object->has_archive )
			$title = post_type_archive_title( '', false );
	
		// If there's a month
		if ( is_archive() && !empty($m) ) {
			$my_year = substr($m, 0, 4);
			$my_month = $wp_locale->get_month(substr($m, 4, 2));
			$my_day = intval(substr($m, 6, 2));
			$title = $my_year . ( $my_month ? $t_sep . $my_month : '' ) . ( $my_day ? $t_sep . $my_day : '' );
		}
	
		// If there's a year
		if ( is_archive() && !empty($year) ) {
			$title = $year;
			if ( !empty($monthnum) )
				$title .= $t_sep . $wp_locale->get_month($monthnum);
			if ( !empty($day) )
				$title .= $t_sep . zeroise($day, 2);
		}
	
		// If it's a search
		if ( is_search() ) {
			/* translators: 1: separator, 2: search phrase */
			$title = sprintf(esc_html__('Search Results %1$s %2$s','mnml-shop'), $t_sep, strip_tags($search));
		}
	
		// If it's a 404 page
		if ( is_404() ) {
			$title = esc_html__('Page not found','mnml-shop');
		}
	
		$prefix = '';
		if ( !empty($title) )
			$prefix = " $sep ";
	
		/**
		 * Filter the parts of the page title.
		 *
		 * @since 4.0.0
		 *
		 * @param array $title_array Parts of the page title.
		 */
		$title_array = apply_filters( 'wp_title_parts', explode( $t_sep, $title ) );
	
		// Determines position of the separator and direction of the breadcrumb
		if ( 'right' == $seplocation ) { // sep on right, so reverse the order
			$title_array = array_reverse( $title_array );
			$title = implode( " $sep ", $title_array ) . $prefix;
		} else {
			$title = $prefix . implode( " $sep ", $title_array );
		}
	
		/**
		 * Filter the text of the page title.
		 *
		 * @since 2.0.0
		 *
		 * @param string $title       Page title.
		 * @param string $sep         Title separator.
		 * @param string $seplocation Location of the separator (left or right).
		 */
		$title = apply_filters( 'mnml_wp_title', $title, $sep, $seplocation );
	
		// Send it out
		if ( $display )
			echo esc_html($title);
		else
			return esc_html($title);
	
	}
	
	
	
	
	
	
	if (!function_exists('mnml_import_theme_options')){
	function mnml_import_theme_options($location){
		WP_Filesystem();
		global $wp_filesystem;
		$get_presets_from_file = $wp_filesystem->get_contents($location);
		//$unserialized_preset = unserialize($get_presets_from_file);
		$file_content = json_decode($get_presets_from_file);
		$unserialized_preset = maybe_unserialize($file_content);
		
		$has_theme_settings = false;
		$settings_updated = false;
		
		if ( is_array($unserialized_preset) ) {
					
			if ( array_key_exists("themes1_general",$unserialized_preset) ){
				$has_theme_settings = true;
				if ( is_array($unserialized_preset['themes1_general']) ){
					if ( update_option('mnml_theme_options', $unserialized_preset['themes1_general']) ){
						$settings_updated = true;
					}
				}
			}
			
			if ( array_key_exists("themes1_style",$unserialized_preset) ){ 
				$has_theme_settings = true;
				if ( is_array($unserialized_preset['themes1_style']) ){
					if ( update_option('mnml_theme_styling_options', $unserialized_preset['themes1_style']) ){
						$settings_updated = true;	
					}
				}
			}
			
		}
		
		if ( !$has_theme_settings ){
			return 	'<span class="import-msg import-note">' .
						'<i class="fa fa-exclamation-triangle"></i>&nbsp;&nbsp;&nbsp;' .
						'This is not a valid theme settings file' .
					'</span>';
		} else {
			if ( $settings_updated ){
				return 	'<span class="import-msg import-success">' .
							'<i class="fa fa-check"></i>&nbsp;&nbsp;&nbsp;' .
							'Theme settings has been imported successfuly' .
						'</span>'; 
			} else {
				return 	'<span class="import-msg import-neutral">' .
							'<i class="fa fa-info-circle"></i>&nbsp;&nbsp;&nbsp;' .
							'Settings import not required. Theme settings are same as the imported ones.' .
						'</span>'; 
			}
		}
		
	}
	}
	
	
	if (!function_exists('mnml_export_theme_options')){
	function mnml_export_theme_options(){
		WP_Filesystem();
		global $wp_filesystem;
		
		$sel = '';
		$filename = '/core/temp/'.'mnml_exported_settings.txt';
		$filepath = get_template_directory().$filename; 
		$fileuri = get_template_directory_uri().$filename; 
		
		$options = array(); 
		if ( isset($_POST['ex_general']) ){
			$options['themes1_general'] = get_option( 'mnml_theme_options' );
			$sel .= 'general';
		}
		if ( isset($_POST['ex_style']) ){	
			$options['themes1_style'] =  get_option( 'mnml_theme_styling_options' );
			$sel .= ' styles';
		}
		//$toBeSaved = serialize($options);
		$toBeSaved = json_encode(serialize($options));
		$wp_filesystem->put_contents( $filepath, $toBeSaved );
		die( $fileuri );
	}
	add_action('wp_ajax_the1_export_settings','mnml_export_theme_options');
	}	
	
	if (!function_exists('mnml_get_post_category_titles')){
		function mnml_get_post_category_titles( $args = array( 'post_id' => '' , 'category_count' => 1, 'before_wrapper' => '', 'after_wrapper' => '' ) ){
		$post_id = $args['post_id'];
		
		$post_categories = wp_get_post_categories( $post_id );
		$cats = array();

		if (is_array($post_categories)){				
			foreach($post_categories as $c){
				$cat = get_category( $c );
				$cats[] = array( 'name' => $cat->name, 'ID' => $cat->cat_ID );
			}
			if (count($cats)>0)
			return $cats[0];
			}
		}	
	}

	function mnml_get_post_meta(){

		$separator = '';
		$meta_elements = array();

		# date
		$meta_elements[] = '<span class="meta__date">'.get_the_date().'</span>';

		# author
		if ( $author = get_the_author() ){
			$meta_elements[] = '<span class="meta__author">'.esc_html__('by','mnml-shop').' '.$author.'</span>';
		};

		### return
		return 	implode( $separator, $meta_elements );

	}


	function mnml_get_post_meta_single(){

		$separator = '&nbsp;&nbsp;/&nbsp;&nbsp;';
		$meta_elements = array();

		# date
		$meta_elements[] = '<span class="metadata__date">'.get_the_date() . '</span>';

		# likes
		if ( function_exists('printLikes') && !is_single() ) {
			$likes_number = '';
			$likes_text = '';
			$likes_number = mnml_likethis(get_the_ID());
			if ( $likes_number == 1){
				$likes_text = 'Like';
			}
			else{
				$likes_text = 'Likes';
			}
			$meta_elements[] = '<span class="metadata__likes"><i class="fa fa-heart-o"></i> ' . $likes_number . '</span>';
		}

		# comments
		if ( comments_open() && is_single() ){
			$comments_number = get_comments_number();
			$comment_text = '';
			if ($comments_number == 1){
				$comment_text = 'Comment';
			} else {
				$comment_text = 'Comments';
			}
			$meta_elements[] = '<span class="metadata__comments"><i class="fa fa-comment-o"></i> ' . $comments_number . '</span>';
		}

		# author
		if ( $author = get_the_author() ){
			$meta_elements[] = '<span class="metadata__author">' . $author . '</span>';
		};

		### return
		if ( !(get_post_type(get_the_ID())==='page') ) {
			return 	implode( $separator, $meta_elements );
		}

	}




	// my custom excerpt
	function mnml_excerpt($excerpt_length = 55, $id = false, $echo = true) {
		  
	    $text = '';
	    $my_id = $id;

		  if($id) {
		  	$the_post = get_post( $my_id );
		  	$text = ($the_post->post_excerpt) ? $the_post->post_excerpt : $the_post->post_content;
		  } else {
		  	global $post;
		  	$text = ($post->post_excerpt) ? $post->post_excerpt : get_the_content('');
	    }
		  
			$text = strip_shortcodes( $text );
			$text = apply_filters('the_content', $text);
			$text = str_replace(']]>', ']]&gt;', $text);
		  $text = strip_tags($text);
		
			$excerpt_more = '...';
			$words = preg_split("/[\n\r\t ]+/", $text, $excerpt_length + 1, PREG_SPLIT_NO_EMPTY);
			if ( count($words) > $excerpt_length ) {
				array_pop($words);
				$text = implode(' ', $words);
				$text = $text . $excerpt_more;
			} else {
				$text = implode(' ', $words);
			}
		if($echo)
	  echo apply_filters('the_content', $text);
		else
		return $text;
	}
	function mnml_get_excerpt($excerpt_length = 55, $id = false, $echo = false) {
		return mnml_excerpt($excerpt_length, $id, $echo);
	}

if (!function_exists('mnml_get_tags_list')){
	function mnml_get_tags_list(){
		$tags_list = get_the_tag_list( '', _x( ', ', 'Used between list items, there is a space after the comma.', 'mnml-shop' ) );
		if ( $tags_list ) {
			printf( '<div class="post-tags"><h4 class="post-tags__label">%1$s</h4><div class="post-tags__tags">%2$s</div></div>',
				_x( 'Tags', 'Used before tag names.', 'mnml-shop' ),
				$tags_list
			);
		}
	}
}


?>