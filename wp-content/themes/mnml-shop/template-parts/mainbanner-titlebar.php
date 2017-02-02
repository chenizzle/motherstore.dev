<?php
$mnml_title_small = $mnml_title_big = $mnml_post_id = '';

$mnml_titlebar_global = mnml_themeoption('page-top-text');
$mnml_opts = array();
$mnml_default = array(
	'pl-titlebar-title'	=> array(''),
	'pl-titlebar-subtitle' => array(''),
	'pl-title-show' => array(''),
	'pl-titlebar-options' => array('global'),
	'pl-titlebar-bgimage' => array('global'),
	'pl-titlebar-bgcolor' => array('global'),
	'pl-titlebar-bgcolorpicker' => array( mnml_themeoption('pagetitlebar-overlay-color') ),
	'pl-titlebar-scheme' => array('global'),
	'pl-titlebar-align' => array('global'),
	'pl-titlebar-size' => array('global'),
);

if (is_page()){
	$mnml_post_id = get_the_ID();
	if (is_array(get_post_custom())){
		$mnml_post_data = array_merge( $mnml_default, get_post_custom() );
	}
}
else if (is_home()){
	$mnml_post_id = get_option('page_for_posts');
	if (is_array(get_post_custom($mnml_post_id))){
		$mnml_post_data = array_merge( $mnml_default, get_post_custom($mnml_post_id) );
	}
}

$mnml_opts['title']      = $mnml_post_data['pl-titlebar-title'][0];
$mnml_opts['subtitle']	= $mnml_post_data['pl-titlebar-subtitle'][0];
$mnml_opts['show_title']	= $mnml_post_data['pl-title-show'][0];

if ( $mnml_post_data['pl-titlebar-options'][0] === 'custom' ){
	
	$mnml_align = $mnml_post_data['pl-titlebar-align'][0];
	$mnml_size = $mnml_post_data['pl-titlebar-size'][0];
	$mnml_scheme = $mnml_post_data['pl-titlebar-scheme'][0];
	$mnml_bg_image = $mnml_post_data['pl-titlebar-bgimage'][0];
	$mnml_bg_color = $mnml_post_data['pl-titlebar-bgcolor'][0];
	$mnml_bg_colorpicker = $mnml_post_data['pl-titlebar-bgcolorpicker'][0];
	
	$mnml_opts['size'] = ( $mnml_size !== 'global' ? $mnml_size : mnml_themeoption('pagetitlebar-size') );	
	$mnml_opts['align'] = ( $mnml_align !== 'global' ? $mnml_align : mnml_themeoption('pagetitlebar-align') );	
	$mnml_opts['scheme'] = ( $mnml_scheme !== 'global' ? $mnml_scheme : mnml_themeoption('pagetitlebar-scheme') );	
	$mnml_opts['bg_image'] = ( $mnml_bg_image !== 'global' ? $mnml_bg_image : false );
	$mnml_opts['parallax'] = ( mnml_themeoption('pagetitlebar-parallax') ? 's-parallax-background' : '' );
	$mnml_opts['bg_color'] = ( $mnml_bg_color === 'custom' ? $mnml_bg_colorpicker : false );
	
} else {

	$mnml_opts['align'] = mnml_themeoption('pagetitlebar-align');
	$mnml_opts['size'] = mnml_themeoption('pagetitlebar-size');
	$mnml_opts['scheme'] = mnml_themeoption('pagetitlebar-scheme');
	$mnml_opts['bg_image'] = false;
	$mnml_opts['parallax'] = ( mnml_themeoption('pagetitlebar-parallax') ? 's-parallax-background' : '' );
	$mnml_opts['bg_color'] = false;
	
}
?>


<?php 

	 
	$mnml_styles = array();
	if ( $mnml_opts['bg_image'] ) { 
		if ( $mnml_opts['bg_image'] === 'none' ) { 
			$mnml_styles[] = 'background-image: none;'; 
		} else if ( $mnml_opts['bg_image'] === 'featured' ) {
			if ( has_post_thumbnail() ){
				$mnml_thumb_id = get_post_thumbnail_id();
				$mnml_thumb_url_array = wp_get_attachment_image_src($mnml_thumb_id, 'thumbnail-size', true);
				$mnml_thumb_url = $mnml_thumb_url_array[0];
				$mnml_styles[] = 'background-image: url('.$mnml_thumb_url.');';
			}
		}
	}
	if ( $mnml_opts['bg_color'] ) { $mnml_styles[] = 'background-color:'.$mnml_opts['bg_color'].';'; }
	$mnml_styles = ( empty($mnml_styles) ? '' : implode('',$mnml_styles) );
	?>
	<!-- main banner content: Title bar -->
		
	<div class="titlebar image-to-load titlebar--<?php echo $mnml_opts['size'];?>">
		<div class="titlebar__content">
			<div class="titlebar__small"><?php echo $mnml_opts['title']; ?></div>
			<?php echo (  $mnml_opts['subtitle'] ? '<div class="titlebar__big">'.$mnml_opts['subtitle'].'</div>' : '' ); ?>
		</div>
		<?php if ( has_post_thumbnail($mnml_post_id) ){ echo get_the_post_thumbnail( $mnml_post_id, 'large' ); } ?>
	</div>
	
