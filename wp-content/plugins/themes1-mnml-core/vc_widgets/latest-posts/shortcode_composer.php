<?php
add_action( 'vc_before_init', 'the1_latest_posts_integrateWithVC' );
function the1_latest_posts_integrateWithVC() {
    $post_items_array = array();
  
    $lastposts = get_posts(  array( 'post_type' => 'post', 'posts_per_page' => -1, ) );
    foreach ( $lastposts as $post ) {
      $post_item_id = $post->ID;
      $post_item_title = get_the_title($post->ID);
      $post_array_item_counter[$post_item_title] = 0;

      //Adds a number at the end if two posts have the same title (VC Workaround)
      if (array_key_exists($post_item_title, $post_items_array)) {
          $post_items_array[$post_item_title.$post_array_item_counter[$post_item_title]] = $post_item_id;
          $post_array_item_counter[$post_item_title] = $post_array_item_counter[$post_item_title]+1;
      }
      else {     
        $post_items_array[$post_item_title] = $post_item_id;
      }
    }
    wp_reset_postdata();


    if (function_exists('vc_map')){
        vc_map( array(
            "name" => __( "Themes1 Latest Posts", "themes1-mnml-core" ),
            "base" => "the1_latest_posts",
            "class" => "",
            "category" => __( 'ThemesOne', 'themes1-mnml-core' ),
            "params" => array(
                array(
                  "type" => "checkbox",
                  "description" => "Select the posts that you want to display.",
                  "heading" => "posts",
                  "param_name" => "posts_all",
                  "value" =>  $post_items_array,
                ),
                array(
                "type" => "textfield",
                "class" => "",
                "heading" => 'Latest Posts title',
                "param_name" => "latest_title",
                "value" => "",
                ),
            ),
        ) );
    }
}

function the1_latest_posts_func( $atts ) {
    extract(shortcode_atts(array(
            'posts_all'    => '',
            'latest_title' => '',
        ), $atts));
        $output = $featured_image_source = '';

        $output .= '<div class="post-related">';

        $output .= '  <div class="post-latest__header align-center">';
        $output .= '    <h3>'.$latest_title.'</h3>';
        $output .= '  </div>';

        $output .= '  <div class="s-row">';
        

        $all_posts_ids = explode(',', $posts_all);

        if (is_array($all_posts_ids)){
          foreach ($all_posts_ids as $single_post_id) {
            /* Post thumbnail */
            $featured_image = wp_get_attachment_image_src( get_post_thumbnail_id($single_post_id),'large');
            $featured_image_source = $featured_image[0];
            $single_post_excerpt = mnml_excerpt($excerpt_length = 10, $id = $single_post_id, $echo = false);


            $output .= '<div class="s-col-4">';
            $output .= '  <div class="post-related__single">';
            $output .= '    <div class="post-related__thumbnail">';
            $output .= (    $featured_image_source ? '<img src="'.esc_html($featured_image_source).'" />' : '');
            $output .= '    </div>';
            $output .= '    <h3 class="post-latest__title"><a href="'.get_permalink($single_post_id).'">'.get_the_title($single_post_id).'</a></h3>';
            $output .= '    <div class="post-latest__text"><p>'.$single_post_excerpt.'</p></div>';
            $output .= '  </div>';
            $output .= '</div>';
          }
        }

        $output .= '  </div>';
        
        $output .= '</div>';
        return $output;
}
add_shortcode( 'the1_latest_posts', 'the1_latest_posts_func' );

?>