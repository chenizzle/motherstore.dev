<?php
add_action( 'vc_before_init', 'the1_title_text_integrateWithVC' );
function the1_title_text_integrateWithVC() {
    if (function_exists('vc_map')){
        vc_map( array(
            "name" => __( "Themes1 Section title/subtitle", "themes1-mnml" ),
            "base" => "the1_title_text",
            "class" => "",
            "category" => __( 'ThemesOne', 'themes1-mnml-core' ),
            "params" => array(
                array(
                    "type" => "textfield",
                    "class" => "",
                    "heading" => 'Title',
                    "param_name" => "title",
                    "value" => "",
                   ),
                array(
                    "type" => "textfield",
                    "class" => "",
                    "heading" => 'Subtitle',
                    "param_name" => "subtitle",
                    "value" => "",
                ),
            ),
        ) );
    }
}

function the1_title_text_func( $atts ) {
    extract(shortcode_atts(array(
            'title' => '', 
            'subtitle' => '',
        ), $atts));
        $output = "";
        
        $output .= '<div class="section-header">';
        $output .= '  <div class="section-title">'.$title.'</div>';
        $output .= '  <div class="section-subtitle">'.$subtitle.'</div>';
        $output .= '</div>';
        
        return $output;
}
add_shortcode( 'the1_title_text', 'the1_title_text_func' );

?>