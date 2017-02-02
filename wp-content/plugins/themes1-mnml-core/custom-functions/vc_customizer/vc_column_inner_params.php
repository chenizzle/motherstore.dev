<?php 
if ( function_exists( 'vc_map' ) ) {
	vc_add_param("vc_column_inner", array(
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
	vc_add_param("vc_column_inner", array(
		"type" => "dropdown",
		"group" => "Themes1 Options",
		"class" => "",
		"heading" => "Animate",
		"param_name" => "the1_animation",
		"value" => array(
			"None" => "",
			"From left"  => "from-left",
			"From right"  => "from-right",
			"From top"  => "from-top",
			"From bottom"	=> "from-bottom",		
		)
	));
}
?>