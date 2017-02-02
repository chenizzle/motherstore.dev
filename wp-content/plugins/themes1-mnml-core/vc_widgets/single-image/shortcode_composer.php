<?php
add_action( 'vc_before_init', 'the1_single_image_integrateWithVC' );
function the1_single_image_integrateWithVC() {
    if (function_exists('vc_map')){
        vc_map( array(
            "name" => __( "Themes1 Single Image", "themes1-mnml-core" ),
            "base" => "the1_single_image",
            "class" => "",
            "category" => __( 'ThemesOne', 'themes1-mnml-core' ),
            "params" => array(
                array(
                    "type" => "attach_image",
                    "class" => "",
                    "heading" => 'Select Image',
                    "param_name" => "single_image",
                    "value" => '',
                ),
            ),
        ) );
    }
}

function the1_single_image_func( $atts ) {
    extract(shortcode_atts(array(
            'single_image' => '', 
        ), $atts));
        $featured_image = wp_get_attachment_image_src( $single_image ,'full');
        $featured_image_alt = get_post_meta($single_image, '_wp_attachment_image_alt', true);
        $featured_image_source = $featured_image[0];
        
        $alt_html = ( $featured_image_alt ? ' alt="'.$featured_image_alt.'"' : '');

        $output = "";
        $output .= '<img src="'.$featured_image_source.'"'.$alt_html.' style="display: block;">';
        return $output;
}
add_shortcode( 'the1_single_image', 'the1_single_image_func' );

?>