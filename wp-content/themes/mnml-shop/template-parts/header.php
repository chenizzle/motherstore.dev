<?php

##  Navigation (Main)
$navargs = array(
   	'container'		  => 'ul',
   	'container_class' => 'menu',
   	'container_id'	  => '',
    'echo'            => false,
    'theme_location' => 'main-navigation',
    'fallback_cb'     => 'mnml_nomenu',
    'items_wrap'      => '<ul class="main-nav">%3$s</ul>',
    'depth'           => 0,
);
$main_nav = wp_nav_menu( $navargs );


## Site Logo or Text
$site_logo = '';
$site_logo_text = mnml_themeoption('site-logo-text','attr');
$site_logo_img = mnml_themeoption('site-logo','url');

if ( $site_logo_text ){
	$site_logo = $site_logo_text;
}
else if ( $site_logo_img ){
	$site_logo = '<img alt="logo" src="'. esc_url($site_logo_img) .'"/>';
}
else{
	$site_logo = mnml_themeinfo('name');
}

?>





		<!-- Header -->
		<div class="header-wrapper">

			<div class="header-container s-container">

				<header id="header" class="main-header header-height clearfix">

					<!-- mobile nav toggle -->
					<div id="mobile-nav-toggle" class="mobile-nav-toggle s-visible-small"><i></i></div>
					
					<?php if ( mnml_is_woocommerce_activated() && mnml_themeoption('show-cart') === 'on' ) { ?>
					<!-- shopping cart -->
					<div id="cart-link-header" class="cart-link-header"><i></i></div>

					<?php }?>
					<!-- site logo -->
					<div class="site-logo-wrapper valign-middle">
						<a href="<?php echo home_url(); ?>" class="site-logo"><?php echo $site_logo; ?></a>
					</div>
					
					<!-- main navigation -->
					<nav class="main-nav-wrapper s-visible-large">
						<?php echo $main_nav; ?>
					</nav>

				</header>

			</div>

		</div>
		<!-- end: Header -->