<?php
add_action( 'vc_before_init', 'the1_frontbox_integrateWithVC' );
function the1_frontbox_integrateWithVC() {
    if (function_exists('vc_map')){
        vc_map( array(
            "name" => __( "Themes1 Frontbox", "themes1-mnml" ),
            "base" => "the1_frontbox",
            "class" => "",
            "category" => __( 'ThemesOne', 'themes1-mnml-core' ),
            "params" => array(
                array(
                  "type" => "dropdown",
                  "heading" => "Style",
                  "description" => "Select style from dropdown.",
                  "param_name" => "frontbox_style",
                  "admin_label" => true,
                  "value" =>  array('Style 1'=> 'style1', 'Style 2' => 'style2', 'Style 3' => 'style3', 'Style 4' => 'style4', 'Style 5' => 'style5', 'Style 6' => 'style6'),
                ),
                array(
                    "type" => "textfield",
                    "class" => "",
                    "heading" => 'Title',
                    'dependency' => array(
                        'element' => 'frontbox_style',
                        'value' => array( 'style1', 'style2', 'style3' ),
                      ),
                    "param_name" => "frontbox_title",
                    "value" => "",
                   ),
                array(
                    "type" => "textarea",
                    "class" => "",
                    "heading" => 'Excerpt',
                    'dependency' => array(
                        'element' => 'frontbox_style',
                        'value' => array( 'style1', 'style2', 'style3' ),
                      ),
                    "param_name" => "frontbox_excerpt",
                    "value" => "",
                   ),
                array(
                    "type" => "textfield",
                    "class" => "",
                    "heading" => 'Category',
                    "param_name" => "frontbox_category",
                    "value" => "",
                   ),
                array(
                    "type" => "attach_image",
                    "class" => "",
                    "heading" => 'Select Image',
                    "param_name" => "frontbox_image",
                    "value" => '',
                ),
            ),
        ) );
    }
}

function the1_frontbox_func( $atts ) {
    extract(shortcode_atts(array(
            'frontbox_style'    => '', 
            'frontbox_title'    => '',
            'frontbox_excerpt'  => '',
            'frontbox_category' => '',
            'frontbox_image'    => '',
        ), $atts));
        $output = "";
        $frontbox_style = ( $frontbox_style ? $frontbox_style : 'style1');
        $featured_image = wp_get_attachment_image_src( $frontbox_image ,'full');
        $featured_image_alt = get_post_meta($frontbox_image, '_wp_attachment_image_alt', true);
        $alt_html = ( $featured_image_alt ? ' alt="'.$featured_image_alt.'"' : '');
        $featured_image_source = $featured_image[0];

        switch ($frontbox_style) {
            case 'style1':
                $output .= '<div class="frontbox frontbox--style1 clearfix">';
                $output .= '    <div class="frontbox__category"><span>'.$frontbox_category.'</span></div>';
                $output .= '    <div class="frontbox__thumbnail"><img src="'.$featured_image_source.'"'.$alt_html.'/></div>';
                $output .= '    <div class="frontbox__content">';
                $output .= '        <div class="frontbox__title">'.$frontbox_title.'</div>';
                $output .= '        <div class="frontbox__excerpt">'.$frontbox_excerpt.'</div>';
                $output .= '    </div>';
                $output .= '</div>';
                break;
            
            case 'style2':
                $output .='<div class="frontbox frontbox--style2 clearfix">';
                $output .='    <div class="frontbox__category"><span>'.$frontbox_category.'</span></div>';
                $output .='    <div class="frontbox__thumbnail"><img src="'.$featured_image_source.'"'.$alt_html.'/></div>';
                $output .='    <div class="frontbox__content">';
                $output .='        <div class="frontbox__title">'.$frontbox_title.'</div>';
                $output .='        <div class="frontbox__excerpt">'.$frontbox_excerpt.'</div>';
                $output .='   </div>';
                $output .='</div>';
                break;

            case 'style3':
                $output .= '<div class="frontbox frontbox--style3 clearfix">';
                $output .= '    <div class="frontbox__category"><span>'.$frontbox_category.'</span></div>';
                $output .= '    <div class="frontbox__thumbnail"><img src="'.$featured_image_source.'"'.$alt_html.'/></div>';
                $output .='    <div class="frontbox__content">';
                $output .= '        <div class="frontbox__title">'.$frontbox_title.'</div>';
                $output .= '        <div class="frontbox__excerpt">'.$frontbox_excerpt.'</div>';
                $output .= '    </div>';
                $output .= '</div>';
                break;

            case 'style5':
                $output .= '<div class="frontbox frontbox--style5 clearfix">';
                $output .= '    <div class="frontbox__category"><span>'.$frontbox_category.'</span></div>';
                $output .= '    <div class="frontbox__thumbnail"><img src="'.$featured_image_source.'"'.$alt_html.'/></div>';
                $output .= '</div>';
                break;

            case 'style6':
                $output .= '<div class="frontbox frontbox--style6 clearfix" style="margin-right: -44px;">';
                $output .= '    <div class="frontbox__category"><span>'.$frontbox_category.'</span></div>';
                $output .= '    <div class="frontbox__thumbnail"><img src="'.$featured_image_source.'"'.$alt_html.'/></div>';
                $output .= '</div>';
                break;
            
            default:
                $output .= '<div class="frontbox frontbox--style6 clearfix" style="margin-right: -44px;">';
                $output .= '    <div class="frontbox__category"><span>'.$frontbox_category.'</span></div>';
                $output .= '    <div class="frontbox__thumbnail"><img src="'.$featured_image_source.'"'.$alt_html.'/></div>';
                $output .= '</div>';
                break;
        }
        
        
        return $output;
}
add_shortcode( 'the1_frontbox', 'the1_frontbox_func' );

?>