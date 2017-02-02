	<!-- main banner content: Title bar -->
	<?php
	$mnml_title_small = $mnml_title_big = $mnml_featured_image_source = '';

	if (is_page()){
		$post_data = get_post_custom();
		$mnml_title_big      = $post_data['pl-titlebar-title'][0];
		$mnml_title_small	= $post_data['pl-titlebar-subtitle'][0];
		$featured_image = wp_get_attachment_image_src( get_post_thumbnail_id(get_the_id()),'large');
		$mnml_featured_image_source = $featured_image[0];
	}
	else if (mnml_is_woocommerce_activated()){
		if ( is_shop() ){
			$mnml_title_small = mnml_themeoption('woo-shop-subtitle');
			$mnml_title_big      = mnml_themeoption('woo-shop-title');
			$mnml_featured_image_source = mnml_themeoption('woo-title-image');
		}
		else if ( is_archive() ){
			$mnml_title_big = strip_tags(get_the_archive_title());
			$mnml_title_small = strip_tags(get_the_archive_description());
		}
		else if ( is_woocommerce() ){
			$mnml_title_big = woocommerce_page_title( $echo = false );
			$mnml_title_small = get_the_archive_description();
		}
	}
	else {
		$mnml_title_big = get_the_archive_title();
		$mnml_title_small = get_the_archive_description();
	}
	

	?>
	<div class="titlebar titlebar--x1">
		<div class="titlebar__content">
			<?php echo ( $mnml_title_small ? '<div class="titlebar__small">'.esc_html($mnml_title_small).'</div>' : '' ); ?>
			<?php echo ( $mnml_title_big ? '<div class="titlebar__big">'.esc_html($mnml_title_big).'</div>' : '' ); ?>
		</div>
		<?php if ( $mnml_featured_image_source ){ echo '<img src="'.esc_url($mnml_featured_image_source).'">'; } ?>
	</div>