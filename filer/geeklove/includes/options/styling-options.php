<?php
add_action('admin_init', 'stag_styling_options');
function stag_styling_options(){

  $styling_options['description'] = __('Configure the visual appearance of your theme, or insert any custom CSS. You can also edit your site color scheme using <a href="'.admin_url('customize.php').'">WordPress Live Customizer</a>, if applicable.', 'stag');


  $styling_options[] = array(
    'title' => 'Background Color',
    'desc' => 'Choose the background color of your site',
    'type' => 'color',
    'id' => 'style_background_color',
    'val' => '#ffffff'
  );

  $styling_options[] = array(
    'title' => 'Accent Color',
    'desc' => 'Choose the accent color of your site',
    'type' => 'color',
    'id' => 'accent_color',
    'val' => '#d44646'
  );

  $styling_options[] = array(
      'title' => 'Body Font',
      'desc' => 'Quickly add a custom Google Font for body from <a href="http://www.google.com/webfonts/" target="_blank">Google Font Directory.</a><br>
                 <code>Example font name: "Source Sans Pro"</code>, for including font weights type <code>Source Sans Pro:400,700,400italic</code>.',
      'type' => 'text',
      'id' => 'style_body_font',
      'val' => 'Open Sans:400, 700'
    );

  $styling_options[] = array(
      'title' => 'Heading Font',
      'desc' => 'Quickly add a custom Google Font for Headings from <a href="http://www.google.com/webfonts/" target="_blank">Google Font Directory.</a><br>
                 For font type: <code>"Source Sans Pro"</code>, for including specific font weights <code>Source Sans Pro:400,700,400italic</code>.',
      'type' => 'text',
      'id' => 'style_heading_font',
      'val' => 'Nixie One'
    );

  $styling_options[] = array(
    'title' => 'Custom CSS',
    'desc' => 'Quickly add some CSS to your theme by adding it to this block.',
    'type' => 'textarea',
    'id' => 'style_custom_css',
  );

  stag_add_framework_page( 'Styling Options', $styling_options, 10 );
}



/* CUSTOM STYLESHEET OUTPUT */
function stag_custom_css($content){
  $stag_values = get_option( 'stag_framework_values' );
  if( array_key_exists( 'style_custom_css', $stag_values ) && $stag_values['style_custom_css'] != '' ){
    $content .= '/* Custom CSS */' . "\n";
    $content .= stripslashes($stag_values['style_custom_css']);
    $content .= "\n\n";
  }
  return $content;
}
add_filter( 'stag_custom_styles', 'stag_custom_css' );

function stag_custom_font_output(){
  $fonts = array(stag_get_option('style_body_font'), stag_get_option('style_heading_font'));
  echo '<!-- Google Web Fonts -->'."\n";
  foreach($fonts as $name){
    if($name != ''){
      $name = stag_remove_trailing_char( $name );
      $name = str_replace( ' ', '+', $name );
      echo '  <link href="//fonts.googleapis.com/css?family='.$name.'" rel="stylesheet" type="text/css">'."\n";
    }
  }
  echo "\n";
}
add_action( 'wp_enqueue_scripts', 'stag_custom_font_output' );

if( ! function_exists( 'stag_remove_trailing_char' ) ) {
  function stag_remove_trailing_char( $string, $char = ' ' ) {
    $offset = strlen( $string ) - 1;
    $trailing_char = strpos( $string, $char, $offset );
    if( $trailing_char )
      $string = substr( $string, 0, -1 );
    return $string;
  }
}

if( ! function_exists( 'stag_get_font_face' ) ) {
  function stag_get_font_face( $option ) {
    $stack = null;
    if( $option !=  '') {
      $option = explode( ':', $option );
      // And also check for accidental space at end
      $name = stag_remove_trailing_char( $option[0] );
      // Add the deafult font stack to the end of the
      // google font.
      $stack = $name;
    } else {
      $stack = '';
    }
    return $stack;
  }
}