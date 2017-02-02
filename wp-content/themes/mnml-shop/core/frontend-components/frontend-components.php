<?php

## -------------------------------------------------
#		External components
# ----------------------------------------------------

		
		require_once( get_template_directory().'/core/frontend-components/_comments-template.php' );		# Template for the comments display
		require_once( get_template_directory().'/core/frontend-components/_social-profile-icons.php' );		# Social Profiles Shortcode
		require_once( get_template_directory().'/core/frontend-components/_sharepost-links.php' );			# Share Link Buttons
		require_once( get_template_directory().'/core/frontend-components/_related-posts.php' );			# Related Posts Class | Returns Array
		

//**	No-Menu fallback
		function mnml_nomenu(){
			return '<ul class="notice-wrapper"><li class="notice" style="line-height: 28px;">'.esc_html__('No menus are found. Please setup a menu by going to Admin &gt; Appearance &gt; Menus' ,'mnml-shop').'</li></ul>';
		}


?>