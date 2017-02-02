<?php


## ---------------------------------------------------------
#	Global: $mnml
#
#	Create a global variable to store all
#	theme related data
# ----------------------------------------------------------

	if ( !array_key_exists('the1', $GLOBALS) ) {
		$mnml = array();
	}


## ---------------------------------------------------------
#	Setup theme information
# ----------------------------------------------------------

	function mnml_setup_theme_info(){
		$info = array(
			  'name'	=> 'mnml-shop',
			  'slug'	=> 'mnml-shop',
			  'version'	=> '1.0',
			  'prefix'	=> 'mnml_',
		);
		global $mnml;
		$mnml['info'] = $info;
	}
	add_action('after_setup_theme', 'mnml_setup_theme_info', 1);

?>