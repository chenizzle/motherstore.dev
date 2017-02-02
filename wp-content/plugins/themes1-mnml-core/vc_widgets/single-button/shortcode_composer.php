<?php
add_action( 'vc_before_init', 'the1_single_button_integrateWithVC' );
function the1_single_button_integrateWithVC() {
    if (function_exists('vc_map')){
        vc_map( array(
            "name" => __( "Themes1 Single Button", "themes1-mnml-core" ),
            "base" => "the1_single_button",
            "class" => "",
            "category" => __( 'ThemesOne', 'themes1-mnml-core' ),
            "params" => array(
                array(
                    "type" => "textfield",
                    "class" => "",
                    "heading" => 'Button Text',
                    "param_name" => "single_button_button_text",
                    "value" => "",
                   ),
                array(
                    "type" => "textfield",
                    "class" => "",
                    "heading" => 'Button Hyperlink',
                    "param_name" => "single_button_button_link",
                    "value" => "",
                   ),
            ),
        )
    );
    }
}

function the1_single_button_func( $atts ) {
    extract(shortcode_atts(array(
            'single_button_button_text'  => '',
            'single_button_button_link'  => '',
        ), $atts));
        $output = "";
        
        $output .= '<div class="ts-button ts-align-center">';
        $output .= '    <a class="button button-hover--fill button-hover--2" href="'.esc_html($single_button_button_link).'">'.$single_button_button_text.'</a>';
        $output .= '</div>';
        
        
        return $output;
}
add_shortcode( 'the1_single_button', 'the1_single_button_func' );

?>