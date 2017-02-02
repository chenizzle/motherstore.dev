<?php
add_action( 'vc_before_init', 'the1_product_slider_integrateWithVC' );
function the1_product_slider_integrateWithVC() {
    $product_items_array = array();
  
    $lastposts = get_posts(  array( 'post_type' => 'product', 'posts_per_page' => -1, ) );
    foreach ( $lastposts as $post ) {
      $product_item_id = $post->ID;
      $product_item_title = get_the_title($post->ID);
      $product_array_item_counter[$product_item_title] = 0;

      //Adds a number at the end if two products have the same title (VC Workaround)
      if (array_key_exists($product_item_title, $product_items_array)) {
          $product_items_array[$product_item_title.$product_array_item_counter[$product_item_title]] = $product_item_id;
          $product_array_item_counter[$product_item_title] = $product_array_item_counter[$product_item_title]+1;
      }
      else {     
        $product_items_array[$product_item_title] = $product_item_id;
      }
    }
    wp_reset_postdata();


    if (function_exists('vc_map')){
        vc_map( array(
            "name" => __( "Themes1 Woocommerce Products Slider", "themes1-mnml-core" ),
            "base" => "the1_product_slider",
            "class" => "",
            "category" => __( 'ThemesOne', 'themes1-mnml-core' ),
            "params" => array(
                array(
                  "type" => "checkbox",
                  "description" => "Select the products that you want to display.",
                  "heading" => "Products",
                  "param_name" => "products_all",
                  "value" =>  $product_items_array,
                ),
                array(
                  "type" => "textfield",
                  "class" => "",
                  "heading" => 'Button Text',
                  "param_name" => "button_text",
                  "value" => "",
                 ),
                array(
                  "type" => "textfield",
                  "class" => "",
                  "heading" => 'Button Link',
                  "param_name" => "button_link",
                  "value" => "",
                 ),
            ),
        ) );
    }
}

function the1_product_slider_func( $atts ) {
    extract(shortcode_atts(array(
            'products_all' => '', 
            'button_text'  => '',
            'button_link'  => '',
        ), $atts));
        $output = $currency = $product_href = $product_title = $featured_image_source = $product_price = $product_href = $product_title = '';

        $output .= '<div class="shop-featured">';
        $output .= '  <div class="shop-featured__items owl-carousel">';
        $currency_symbol = ( (function_exists('get_woocommerce_currency_symbol')) ? get_woocommerce_currency_symbol( $currency ) : '');

        $all_products_ids = explode(',', $products_all);

        if (is_array($all_products_ids)){
          foreach ($all_products_ids as $product_single) {
            if ( function_exists('wc_get_product') ){
              $product = wc_get_product( $product_single );
              $product_title = get_the_title( $product_single );
              $product_price = $product->price;
              $product_href = get_the_permalink($product_single);
              $featured_image_source = get_the_post_thumbnail_url( $product->id, 'large' );
            }
            
            $output .= '    <a href="'.esc_url($product_href).'" class="shop-featured__item">';
            $output .= '      <div class="shop-featured__title">'.$product_title.'</div>';
            $output .= '      <div class="catalogue__item__thumbnail" style="background-image:url('.$featured_image_source.');"></div>';
            $output .= '      <div class="shop-featured__price">'.$currency_symbol.$product_price.'</div>';
            $output .= '    </a>';
          }
        }

        $output .= '  </div>';
        if ($button_link && $button_text){
          $output .= '  <div class="shop-featured__button">';
          $output .= '    <a class="button button-hover--fill button-hover--2" href="'.esc_url($button_link).'">'.$button_text.'</a>';
          $output .= '  </div>';
        }
        $output .= '</div>';
        return $output;
}
add_shortcode( 'the1_product_slider', 'the1_product_slider_func' );

?>