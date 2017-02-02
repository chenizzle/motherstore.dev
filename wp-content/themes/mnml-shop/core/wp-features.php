<?php


### Content width global variable
	if( !isset($content_width) ) $content_width = 800;


### Text Domain
	function mnml_theme_textdomain(){
		load_theme_textdomain('mnml-shop', get_template_directory().'/languages');
	}
	add_action('after_setup_theme', 'mnml_theme_textdomain');


###	Title tag
	function mnml_title_tag_setup() {
	   add_theme_support( 'title-tag' );
	}
	add_action( 'after_setup_theme', 'mnml_title_tag_setup' );
	

###	WP custom background
	add_theme_support( 'custom-background', array('default-color' => '#aaa') );


### Menu Locations
	function mnml_register_my_menus() {
		register_nav_menu( 'main-navigation', 'Main Navigation' );
		register_nav_menu( 'footer-navigation', 'Footer Navigation' );
	}
	add_action( 'init', 'mnml_register_my_menus' );


### Sidebars
	if ( function_exists('register_sidebar') ){
		function mnml_register_default_sidebars(){
		
			register_sidebar(array(
				'name' => 'Post Sidebar',
				'id' => 'post-sticky-sidebar',
				'description' => 'This is the sidebar on posts',
				'before_widget' => '<li id="%1$s" class="widget %2$s">',
				'after_widget' => '</li>',
				'before_title' => '<h3 class="widgettitle">',
				'after_title' => '</h3>'
			));

			register_sidebar(array(
				'name' => 'Page Sidebar',
				'id' => 'page-sidebar',
				'description' => 'This is the sidebar on pages',
				'before_widget' => '<li id="%1$s" class="widget %2$s">',
				'after_widget' => '</li>',
				'before_title' => '<h3 class="widgettitle">',
				'after_title' => '</h3>'
			));
	
			register_sidebar(array(
				'name' => 'Alternative Sidebar',
				'id' => 'alternative-sidebar',
				'description' => 'This is an alternative sidebar',
				'before_widget' => '<li id="%1$s" class="widget %2$s">',
				'after_widget' => '</li>',
				'before_title' => '<h3 class="widgettitle">',
				'after_title' => '</h3>'
			));
	
			register_sidebar(array(
				'name' => 'Single Product Sidebar',
				'id' => 'single-product-sidebar',
				'description' => 'This is a sidebar for Woocommerce single products',
				'before_widget' => '<li id="%1$s" class="widget %2$s">',
				'after_widget' => '</li>',
				'before_title' => '<h3 class="widgettitle">',
				'after_title' => '</h3>'
			));		

			
		}
		add_action( 'widgets_init', 'mnml_register_default_sidebars' );
	}
	


### Add support: Automatic feed links
	add_theme_support( 'automatic-feed-links' );
	
	
### Add support: WP post thumbnails
	add_theme_support('post-thumbnails');
	
	add_image_size('post-thumb-medium', 820, 540, true);
	add_image_size('post-thumb', 717, 442, true);
	add_image_size('listing-thumbnail', 400, 9999, false);



?>