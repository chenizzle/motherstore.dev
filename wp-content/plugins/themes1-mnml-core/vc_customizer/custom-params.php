<?php
/* Register scripts for metaboxes */
function the1_plugin_param_styles(){
	wp_enqueue_style( 'param-style', plugin_dir_url( __FILE__ ) .'/css/custom-params.css' );
}
add_action( 'admin_enqueue_scripts', 'the1_plugin_param_styles' );

if (function_exists('vc_map')){
	function the1_select_by_image_settings_field( $settings, $value ) {
		$output = '';
		$output .= '<select name="'
		           . $settings['param_name']
		           . '" class="wpb_vc_param_value vc_params-preset-select '
		           . $settings['param_name']
		           . ' ' . $settings['type']
		           . '">';
		foreach ($settings['value'] as $key => $array_value) {
			$output .= '<option '.selected($array_value,$value,false).' value="'.$array_value.'" name="' . esc_attr( $settings['param_name'] ) . '">'.$array_value.'</option>';
		}
		$output .= '</select>';
	   return $output;
	}

	vc_add_shortcode_param('the1_select_by_image', 'the1_select_by_image_settings_field', plugin_dir_url( __FILE__ ) .'js\the1_select_by_image.js');
}
?>