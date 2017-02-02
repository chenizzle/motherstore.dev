<?php

## -------------------------------------------------
#		Include function pages
# ----------------------------------------------------

		require_once(get_template_directory().'/core/includes/tgm-plugin-activation/autoactivate-plugins.php');	# Include TGM plugin activation class

		require_once(get_template_directory().'/core/wp-features.php');										# WordPress default features
		require_once(get_template_directory().'/core/custom-functions.php');									# Custom functions
		
		require_once(get_template_directory().'/core/theme-config.php');										# Theme base config
		require_once(get_template_directory().'/core/theme-data.php');											# All theme data
		require_once( get_template_directory().'/core/style-dynamic.php');		# Dynamic style
		require_once(get_template_directory().'/core/admin/admin.php');										# Theme options panel

		require_once(get_template_directory().'/core/frontend-components/frontend-components.php');			# Frontend components
		require_once(get_template_directory().'/core/theme-tweaks.php');										# Theme tweaks
		require_once(get_template_directory().'/core/posts-taxonomies-metaboxes.php');							# Custom post types and metaboxes
		
		require_once(get_template_directory().'/core/woocommerce-functions.php');								# WooCommerce 


?>