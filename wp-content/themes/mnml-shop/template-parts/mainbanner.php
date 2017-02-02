<?php

if (is_home()){
	$mnml_id = get_option('page_for_posts');
	$mnml_slider_type = get_post_meta($mnml_id,'pl-slider',true);
}
else {
	$mnml_slider_type = get_post_meta(get_the_id(),'pl-slider',true);
}

$mnml_current_banner = $mnml_css_class = '';
switch ($mnml_slider_type) {
	case 'tb':
		$mnml_current_banner = 'titlebar';
		break;
	
	case 'cat':
		$mnml_current_banner = 'catalogue';
		break;

	case 'sc':
		$mnml_current_banner = 'shortcode';
		break;

	case 'revo' :
		$mnml_current_banner = 'slider';
		break;

	case 'the1':
		$mnml_current_banner = 'slider';
		break;
		
	case '':
		$mnml_current_banner = '';
		$mnml_css_class = 'no-banner';
		break;

	default:
		$mnml_current_banner = 'titlebar';
		break;
}

?>


<!-- Main Banner Area -->
<div class="mainbanner-area-container s-container">
	<div class="mainbanner-area <?php echo $mnml_css_class; ?>">

		<?php 

		# inner content of the main banner
		if ($mnml_current_banner){
			get_template_part( 'template-parts/mainbanner', $mnml_current_banner );
		}

		# vertical social links
		get_template_part( 'template-parts/sidelinks' ); 

		?>

	</div>
</div>