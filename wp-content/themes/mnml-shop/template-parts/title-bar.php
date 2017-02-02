<?php

##  Navigation
$mnml_navargs = array(
   	'container'		  => 'ul',
   	'container_class' => 'menu',
   	'container_id'	  => '',
    'echo'            => false,
    'theme_location' => 'main-navigation',
    'fallback_cb'     => 'mnml_nomenu',
    'items_wrap'      => '<ul class="menu">%3$s</ul>',
    'depth'           => 0,
);
$mnml_main_nav = wp_nav_menu( $mnml_navargs );

## Site Logo or Text
$mnml_site_logo = '';
$mnml_site_logo_text = mnml_themeoption('site-logo-text','attr');
$mnml_site_logo_img = mnml_themeoption('site-logo','url');

if ( $mnml_site_logo_text ){
	$mnml_site_logo = $mnml_site_logo_text;
}
else if ( $mnml_site_logo_img ){
	$mnml_site_logo = '<img alt="logo" src="'. esc_url($mnml_site_logo_img) .'"/>';
}
else{
	$mnml_site_logo = mnml_themeinfo('name');
}

?>





		<!-- Header -->
		<div class="header-wrapper">
			<header id="header" class="main-header clearfix">

				<!-- site logo -->
				<a href="#" class="site-logo valign-middle"><img src="<?php echo get_template_directory_uri();?>/images/logo.png"/></a>


				<!-- shopping cart -->
				<div class="header-cart"><i class="fa fa-shopping-basket"></i></div>

				
				<!-- main navigation -->
				<nav class="main-nav">
					<ul>
						<?php echo $mnml_main_nav; ?>
					</ul>
				</nav>



			</header>
		</div>
		<!-- end: Header -->