<?php 
if ( function_exists( 'vc_map' ) ) {
	vc_add_param("vc_row", array(
		"type" => "dropdown",
		"group" => "Themes1 Options",
		"class" => "",
		"heading" => "Type",
		"param_name" => "the1_padding",
		"value" => array(
			"No Padding" => "",
			"Padding 1"  => "s-padding-x1",
			"Padding 2"  => "s-padding-x2",
			"Padding 3"  => "s-padding-x3"		
		)
	));
	vc_add_param("vc_row",array(
		"type" => "colorpicker",
		"group" => "Themes1 Options",
		"class" => "",
		"heading" => "Color",
		"param_name" => "the1_colorpicker",
		"value" => ""
		));
}
?>