<?php 
if (is_home()){
	$id = get_option('page_for_posts');
	$slider_type = get_post_meta($id,'pl-slider',true);
}
else {
	$slider_type = get_post_meta($post->ID,'pl-slider',true);
}
?>
	<!-- main banner content: Slider -->
	<?php
	switch ($slider_type) {

		case 'revo' :
			if ( function_exists('putRevSlider') ) {
				putRevSlider( get_post_meta($post->ID,'pl-slider-revo',true) );
			} else {
				esc_html_e( 'Revolution slider is not installed', 'mnml-shop' );
			}
			break;

		case 'the1' :
			if ( function_exists('the1_slider') ) {
				the1_slider( get_post_meta($post->ID,'pl-slider-the1',true) );
			} else {
				esc_html_e( 'Themes1 slider is not installed', 'mnml-shop' );
			}
			break;
	}
	?>




	
