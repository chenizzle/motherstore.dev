<?php 
if ( function_exists( 'vc_map' ) ) {
	vc_add_param("vc_column", array(
		"type" => "dropdown",
		"group" => "Themes1 Options",
		"class" => "",
		"heading" => "Padding",
		"param_name" => "the1_padding",
		"value" => array(
			"No Padding" => "",
			"Padding 1"  => "s-padding-x1",
			"Padding 2"  => "s-padding-x2",
			"Padding 3"  => "s-padding-x3"		
		)
	));
	vc_add_param("vc_column", array(
		"type" => "dropdown",
		"group" => "Themes1 Options",
		"class" => "",
		"heading" => "CSS Animation",
		"param_name" => "the1_animation",
		"value" => array(
			"No" => "",
			"Top to bottom"	=> "top-to-bottom",
			"Bottom to top"	=> "bottom-to-top",
			"Left to right"	=> "left-to-right",
			"Right to left"	=> "right-to-left",		
		)
	));
}
?>