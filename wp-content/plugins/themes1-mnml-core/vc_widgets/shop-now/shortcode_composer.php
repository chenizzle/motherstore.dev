<?php
add_action( 'vc_before_init', 'the1_shop_now_integrateWithVC' );
function the1_shop_now_integrateWithVC() {
    if (function_exists('vc_map')){
        vc_map( array(
            "name" => __( "Themes1 Shop Now", "themes1-mnml-core" ),
            "base" => "the1_shop_now",
            "class" => "",
            "category" => __( 'ThemesOne', 'themes1-mnml-core' ),
            "params" => array(
                array(
                  "type" => "dropdown",
                  "heading" => "Style",
                  "description" => "Select style from dropdown.",
                  "param_name" => "shop_now_style",
                  "admin_label" => true,
                  "value" =>  array('Style 1'=> 'style1', 'Style 2' => 'style2', 'Style 3' => 'style3')
                ),
                array(
                    "type" => "textfield",
                    "class" => "",
                    "heading" => 'Title',
                    "param_name" => "shop_now_title",
                    "value" => "",
                   ),
                array(
                    "type" => "textfield",
                    "class" => "",
                    "heading" => 'Category',
                    "param_name" => "shop_now_category",
                    "value" => "",
                   ),
                array(
                    "type" => "textfield",
                    "class" => "",
                    "heading" => 'Button Text',
                    "param_name" => "shop_now_button_text",
                    "value" => "",
                   ),
                array(
                    "type" => "textfield",
                    "class" => "",
                    "heading" => 'Button Hyperlink',
                    "param_name" => "shop_now_button_link",
                    "value" => "",
                   ),
                array(
                    "type" => "attach_image",
                    "class" => "",
                    "heading" => 'Select Image',
                    "param_name" => "shop_now_image",
                    "value" => '',
                ),
            ),
        )
    );
    }
}

function the1_shop_now_func( $atts ) {
    extract(shortcode_atts(array(
            'shop_now_style'        => '', 
            'shop_now_title'        => '',
            'shop_now_category'     => '',
            'shop_now_button_text'  => '',
            'shop_now_button_link'  => '',
            'shop_now_image'        => '',
        ), $atts));
        $output = "";
        $shop_now_style = ( $shop_now_style ? $shop_now_style : 'style1');
        $featured_image = wp_get_attachment_image_src( $shop_now_image ,'full');
        $featured_image_alt = get_post_meta($shop_now_image, '_wp_attachment_image_alt', true);
        $alt_html = ( $featured_image_alt ? ' alt="'.$featured_image_alt.'"' : '');

        $featured_image_source = $featured_image[0];

        switch ($shop_now_style) {
            case 'style1':
                $output .= '<div class="shop_now shop_now--style1 clearfix">';
                $output .= '    <div class="shop_now__thumbnail" style="background-image:url('.$featured_image_source.')"></div>';
                $output .= '    <div class="shop_now__content">';
                $output .= '        <div class="shop_now__category"><span>'.$shop_now_category.'</span></div>';
                $output .= '        <div class="shop_now__title">'.$shop_now_title.'</div>';
                $output .= '        <div class="shop_now__button"><a href="'.esc_url($shop_now_button_link).'">'.$shop_now_button_text.'</a></div>';
                $output .= '    </div>';
                $output .= '</div>';
                break;
            
            case 'style2':
               $output .= '<div class="shop_now shop_now--style2 clearfix">';
               $output .= '    <div class="shop_now__thumbnail" style="background-image:url('.$featured_image_source.')"></div>';
                $output .= '    <div class="shop_now__content">';
                $output .= '        <div class="shop_now__category"><span>'.$shop_now_category.'</span></div>';
                $output .= '        <div class="shop_now__title">'.$shop_now_title.'</div>';
                $output .= '        <div class="shop_now__button"><a href="'.esc_url($shop_now_button_link).'">'.$shop_now_button_text.'</a></div>';
                $output .= '    </div>';
                $output .= '</div>';
                break;

            
            default:
                $output .= '<div class="shop_now shop_now--style3 clearfix">';
                $output .= '    <div class="shop_now__thumbnail" style="background-image:url('.$featured_image_source.')"></div>';
                $output .= '    <div class="shop_now__content">';
                $output .= '        <div class="shop_now__category"><span>'.$shop_now_category.'</span></div>';
                $output .= '        <div class="shop_now__title">'.$shop_now_title.'</div>';
                $output .= '        <div class="shop_now__button"><a href="'.esc_url($shop_now_button_link).'">'.$shop_now_button_text.'</a></div>';
                $output .= '    </div>';
                $output .= '</div>';
                break;
        }
        
        
        return $output;
}
add_shortcode( 'the1_shop_now', 'the1_shop_now_func' );

?>