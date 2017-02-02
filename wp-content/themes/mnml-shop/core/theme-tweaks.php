<?php

###	wp_title tweak - backwards compatibility
	if ( ! function_exists( '_wp_render_title_tag' ) ) {
		function mnml_render_title() {
		
		?>
		
		<title><?php wp_title( '|', true, 'right' ); ?></title>
		
		<?php
		}
		add_action( 'wp_head', 'mnml_render_title' );
	}

## wp_title separator
	function mnml_title_separator( $separator ) {

	    $separator = " | ";

	    return $separator;

	}
	add_filter( 'document_title_separator', 'mnml_title_separator' );

### Set visual composer as integrated theme plugin
	if ( function_exists('vc_set_as_theme') ){
   		vc_set_as_theme();
	}
   

###	Body classes - filter
	function mnml_body_classes( $classes ) {
		
		$full_class = '';
		$layout_option = ( is_page() || is_single() ? get_post_meta(get_the_id(),'pl-site-layout',true) : 'global' );
		if ( $layout_option === 'global' || !$layout_option ){
			$layout_option = mnml_themeoption('site-layout');
		}
		else {
			$layout_option = $layout_option;
		}

		
		if( $layout_option === 'banner' ){
			$full_class = 'fullwidth-header fullwidth-banner';
		} else if ( $layout_option === 'fullwidth' ){
			$full_class = 'fullwidth-header fullwidth-banner fullwidth-all';
		}
		else if ( $layout_option === 'fixed' ){
			$full_class = '';
		}
		
		$alternate_posts = mnml_themeoption('alternate-posts');

		if ( $alternate_posts ){
			$classes[] = 'alternate-posts';
		}
		if ( mnml_page_slider() ){
			$classes[] = 'has-banner';
		};
		if ( $full_class ){
			$classes[] = $full_class;
		}
		return $classes;
	}
	add_filter( 'body_class', 'mnml_body_classes' );
	

###	prettyPhoto relative attribute
	add_filter('wp_get_attachment_link', 'mnml_rc_add_rel_attribute');
	function mnml_rc_add_rel_attribute($link) {
		global $post;
		return str_replace('<a href', '<a rel="prettyPhoto[pp_gal]" href', $link);
	}	


### excerpt length and MORE dots
	function mnml_new_excerpt_length($length) {
		return 30;
	}
	//add_filter('excerpt_length', 'mnml_new_excerpt_length');
	
	function mnml_new_excerpt_readmore($more) {
		return '&nbsp;...';
	}
	add_filter('excerpt_more', 'mnml_new_excerpt_readmore');


###	remove id-s from menu items to avoid duplicating conflict
	function mnml_remove_menuitem_ids($id, $item, $args) {
		return "";
	}	
	add_filter('nav_menu_item_id', 'mnml_remove_menuitem_ids', 10, 3);


### FIX: importing serialized metabox data issue

	//-----------------------------------------------------
	// WordPress Importer Filter
	// Helper function to clean up data from XML
	// 1) Update the domain URL from the source to the local
	// 2) Watch out for serialized data with line breaks!
	//----------------------------------------------------- 

	if ( !function_exists('mnml_import_post_meta_fix') ){
	add_filter( 'wp_import_post_meta', 'mnml_import_post_meta_fix', 10, 3 );
	function mnml_import_post_meta_fix( $postmeta, $post_id, $post ) {
	
		// Sometimes you want to import files from a source domain. If we do this, we need to replace the URL in the meta data.
		$find = 'http://demo.themes1.com/wp/Mnml/wp-content/uploads'; // Search url
		$upload_dir = wp_upload_dir(); // Replace URL
		$replace = $upload_dir['baseurl']; // upload url of the local site.
	
		// Watch out for newlines inside of serialized data when importing from XML, they will break the import.
		// I've found that the XML leaves a discrepancy of how many chars are in the serialized string. I add 1 extra for each line break.
		$find2 = "\n"; // look for newline
		$replace2 = "\n "; // replace newline + 1 extra char (Hack you say? Yes I am aware.)
	
		// Multidimensional array loop
		foreach ($postmeta as $key => $value){
			foreach ($value as $sub_key => $sub_value){
	
				// If this is serialized data we need to unserialize to find / replace.
				if (is_serialized($sub_value)){
					$reserialize = true;
					$sub_value = str_replace($find2, $replace2, $sub_value); // Clean up

						$sub_value = unserialize($sub_value); // unserialize

				}else{
					$reserialize = false;
				}
	
				$sub_value  = str_replace($find, $replace, $sub_value); // Find / replace value 1
	
				if(is_array($sub_value)){ // We may nned to go even deeper...
	
					foreach ($sub_value as $sub_sub_key => $sub_sub_value){                         
	
						$sub_value[$sub_sub_key] = str_replace($find, $replace, $sub_sub_value); // Find and replace value 1
						$sub_value[$sub_sub_key] = str_replace($find2, $replace2, $sub_value[$sub_sub_key]); // Find and replace value 2
	
						if(is_array($sub_sub_value)){ // We may nned to go even DEEPER..!
							foreach ($sub_sub_value as $sub_sub_sub_key => $sub_sub_sub_value){
	
								$sub_value[$sub_sub_key][$sub_sub_sub_key]  = str_replace($find, $replace, $sub_sub_sub_value); // Find and replace value 1
								$sub_value[$sub_sub_key][$sub_sub_sub_key] = str_replace($find2, $replace2, $sub_value[$sub_sub_key][$sub_sub_sub_key]); // Find and replace value 2
	
	
							}
						}                   
					}
				}
	
				// If we unserialized then serialize back up again.
				if($reserialize){
					$value[$sub_key] = serialize($sub_value);
				}else{
					$value[$sub_key] = $sub_value;
				}
			}
			$postmeta[$key] = $value;
		}
	
		return $postmeta;
	}
	}


?>