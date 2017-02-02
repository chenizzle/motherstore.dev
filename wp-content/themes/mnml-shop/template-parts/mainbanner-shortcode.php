<?php
if (is_home()){
	$id = get_option('page_for_posts');
	$sc = get_post_meta($id,'pl-slider-sc',true);
}
else {
	$sc = get_post_meta($post->ID,'pl-slider-sc',true);
}

if ( $sc ){
	$sc_content = do_shortcode($sc);
	if ( $sc_content ){
		echo $sc_content;
	} else {
		esc_html_e( 'Your shortcode didn\'t generate any results!', 'mnml-shop' );
	}
} else {
	esc_html_e( 'Shortcode field is empty!', 'mnml-shop' );
}
?>