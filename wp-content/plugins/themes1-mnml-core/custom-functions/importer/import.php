<?php

///	Import the predefined demo content
	require_once('themes1-importer.php');
		

///	Import the predefined demo content
	if ( !function_exists('mnml_importer') ) {
	function mnml_importer(){
		if ( !isset($_POST['demo']) ) { die('Error: No demo variable found'); }
		$demofolder = $_POST['demo'];
		#Theme settings
		$theme_settings = get_template_directory().'/core/importer/demo-files/'.$demofolder.'/theme_settings.txt';
        if ( file_exists($theme_settings) ){
			mnml_import_theme_options($theme_settings);
		}
		
		#WP content
		$a = new Themes1_Theme_Importer();
        $a->the1_process_imports(true,false,$demofolder);
        die();		
	}
	add_action( 'wp_ajax_mnml_importer', 'mnml_importer' );
	}


?>