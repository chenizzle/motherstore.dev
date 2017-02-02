<?php 
require_once(get_template_directory().'/core/core.php');

###	insert all of your code below this line ###


## ---------------------------------------------------
#		Enqueue Scripts and Styles
# ----------------------------------------------------
 
	## 	Enqueue styles
		function mnml_enqueue_styles(){
				$mnml_dynamic_css = mnml_dynamic_style();
				wp_enqueue_style('mnml-structure', get_template_directory_uri().'/css/structure.css');	// Set Selected Theme Skin
				wp_enqueue_style('fontawesome',get_template_directory_uri().'/core/includes/fontawesome/css/font-awesome.min.css'); // FontAwesome
				wp_enqueue_style('linearicons',get_template_directory_uri().'/core/includes/linearicons/css/linear-icons.css'); // Linear Icons
				wp_enqueue_style('owl-carousel', get_template_directory_uri().'/css/owl.carousel.css'); // Owl Carousel
				wp_enqueue_style('mnml-google-fonts', mnml_google_fonts_url()); // Google Fonts
				wp_enqueue_style('mnml-style', get_template_directory_uri().'/style.css'); // Main stylesheet
				wp_enqueue_style('mnml-style-responsive', get_template_directory_uri().'/css/style-responsive.css'); // Main responsiveness stylesheet
				wp_add_inline_style( 'mnml-style-responsive', $mnml_dynamic_css ); // Dynamic style
		}
		add_action('wp_enqueue_scripts', 'mnml_enqueue_styles');
			
	## 	Enqueue scripts
		function mnml_enqueue_scripts(){
			
				## Wordpress scripts
					wp_enqueue_script( 'comment-reply' );
					
				//	jQuery libraries
					wp_enqueue_script('jquery-ui-core');
				
				//	Third party
					wp_register_script('owl-carousel', get_template_directory_uri().'/js/owl.carousel.min.js', array('jquery'), '1.0', true);
					wp_enqueue_script('images-loaded', get_template_directory_uri().'/js/imagesloaded.pkgd.min.js', array('jquery'), '1.0', true);					
					
				//	Theme main Javascript
					wp_register_script('mnml-the1_lookbook', get_template_directory_uri().'/js/jquery.lookbook.js', array('images-loaded'), '1.0', true);
					wp_enqueue_script('mnml-the1_functions', get_template_directory_uri().'/js/functions.js', array('owl-carousel', 'images-loaded'), '1.0', true);
		}
		add_action('wp_enqueue_scripts', 'mnml_enqueue_scripts');


		function mnml_styles_admin(){
					wp_enqueue_script('wp-color-picker');
		}
		add_action('admin_enqueue_scripts', 'mnml_styles_admin');
?>