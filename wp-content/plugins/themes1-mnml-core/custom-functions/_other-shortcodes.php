<?php
	### social icons
	function sc_socialicons($atts, $content = null){
		extract(shortcode_atts(array( "style"=>"style1", "rss"=>true ), $atts));
		ob_start();
			if (function_exists('mnml_social_profiles')){
				$opts = array( 'rss'=>$rss, 'style'=>$style );
				mnml_social_profiles($opts);
			}
		$output = ob_get_contents();
		ob_end_clean();
		return $output;
	}
	add_shortcode('the1-socialicons', 'sc_socialicons');
?>