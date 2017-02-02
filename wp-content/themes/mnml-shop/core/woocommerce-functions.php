<?php
### Check if woocommerce is activated
	if ( ! function_exists( 'mnml_is_woocommerce_activated' ) ) {
		function mnml_is_woocommerce_activated() {
			if ( class_exists( 'woocommerce' ) ) { return true; } else { return false; }
		}
	}
/* Removes the Woocommerce wrappers */
	remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10);
	remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10);


### Add support: Woocommerce
	function mnml_woocommerce_support() {
	    add_theme_support( 'woocommerce' );
	}
	add_action( 'after_setup_theme', 'mnml_woocommerce_support' );

### Changing the wrappers
	if (!function_exists('mnml_the1_wrapper_start')){
		function mnml_the1_wrapper_start() {
		  echo '<div id="content" class="content">';
		}
		add_action('woocommerce_before_main_content', 'mnml_the1_wrapper_start', 10);
	}

	if (!function_exists('mnml_the1_wrapper_end')){
			function mnml_the1_wrapper_end() {
			  echo '</div>';
			}
			add_action('woocommerce_after_main_content', 'mnml_the1_wrapper_end', 10);
	}


### Removing all the tabs
	function mnml_wcs_woo_remove_tabs($tabs) {
		unset( $tabs['description'] );      	// Remove the description tab
    	unset( $tabs['reviews'] ); 			// Remove the reviews tab
    	unset( $tabs['additional_information'] );  	// Remove the additional information tab

    	return $tabs;
	}
	add_filter( 'woocommerce_product_tabs', 'mnml_wcs_woo_remove_tabs', 10 );

### Removing the woocommerce sidebar 
	remove_action( 'woocommerce_sidebar', 'woocommerce_get_sidebar', 10 );

### Removing the "Add to cart" and "Read more" buttons from products listing
	remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10 );

### Removing the page title from shop and categories
	function mnml_woo_hide_page_title() {
		
		return false;
		
	}
	add_filter( 'woocommerce_show_page_title' , 'mnml_woo_hide_page_title' );
	
	/*remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail', 10 );

	function mnml_woocommerce_template_loop_product_thumbnail(){
		echo '<div class="catalogue__item__thumbnail">';
			echo woocommerce_get_product_thumbnail();
		echo '</div>';
	}
	add_action( 'woocommerce_before_shop_loop_item_title', 'mnml_woocommerce_template_loop_product_thumbnail', 10 );*/

### Removing single product meta (Category and others)
	remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40 );
?>