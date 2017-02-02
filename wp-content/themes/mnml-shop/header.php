<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">

	<?php wp_head(); ?>


</head>


<body <?php body_class();?> >

	<!-- mobile navigation -->
	<?php
	$mnml_mobilenavargs = array(
	   	'container'		  => 'ul',
	   	'container_class' => 'menu',
	   	'container_id'	  => '',
	    'echo'            => false,
	    'theme_location' => 'main-navigation',
	    'fallback_cb'     => 'mnml_nomenu',
	    'items_wrap'      => '<ul class="mobile-nav">%3$s</ul>',
	    'depth'           => 0,
	);
	$mnml_mobile_nav = wp_nav_menu( $mnml_mobilenavargs );
	?>
	<nav id="mobile-nav-wrapper" class="mobile-nav-wrapper">
		<?php echo $mnml_mobile_nav; ?>
	</nav>

	<!-- main header (fixed) -->
	<?php get_template_part('template-parts/header'); ?>

	<!-- cart panel -->
	<?php if ( mnml_themeoption('show-cart') === 'on' ) { get_template_part('template-parts/cart-panel'); } ?>

	<!-- vertical social links -->
	<?php get_template_part( 'template-parts/sidelinks' ); ?>
	
	<div id="wrapper">
		<div id="wrapper__inner">


			<div class="header-spacer header-height"><!-- do not delete this div --></div>

