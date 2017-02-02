<?php


//	Add support for thumbnails

	add_theme_support('post-thumbnails');
	add_image_size('the1_slider-thumb', 500, 350, true);
	add_image_size('the1_slider-thumbbar', 500, 1050, true);
	add_image_size('the1_slider-thumb', 140, 100, true);

	add_image_size('the1_slider-full-mobile', 1024, 9999);
	add_image_size('the1_slider-full', 1600, 9999);


//	Register custom post type

	/*-------------------------------------------------------*
	 *	POST TYPE
	 *	slider	: the1_slider
	 *-------------------------------------------------------*/
 
 	if ( !function_exists('the1_slider_cpt') ) {
		function the1_slider_cpt() {
			
			register_post_type( 'the1_slider',
				array(
					'labels'		=> array(
							'name' 			=> 'Slider',
							'singular_name' => 'Slider',
							'edit_item'		=> 'Edit Slider'
						),
					'supports'		=> array( 
							'title',
						),
					'menu_position'	=> 4,
					'public'		=> true,
					'has_archive'	=> true,
					'rewrite'		=> array('slug' => 'slider'),
					'show_in_nav_menus' => true,
					'menu_icon'		=> 'dashicons-images-alt2'
				)
			);
			
		}
		add_action( 'init', 'the1_slider_cpt' );
	}
	

//	Metaboxes

	require_once('_frontend.php');
	require_once('_backend.php');
	require_once('_api.php');
	

?>