<?php
// Filter to replace default css class names for vc_row shortcode and vc_column
add_filter( 'vc_shortcodes_css_class', 'custom_css_classes_for_vc_row_and_vc_column', 10, 2 );
function custom_css_classes_for_vc_row_and_vc_column( $class_string, $tag ) {
  if ( $tag == 'vc_column' || $tag == 'vc_column_inner' ) {
    $class_string = preg_replace( '/vc_col-sm-(\d{1,2})/', 's-col-$1', $class_string ); // This will replace "vc_col-sm-%" with "my_col-sm-%"
  }
  return $class_string; // Important: you should always return modified or original $class_string
}
?>