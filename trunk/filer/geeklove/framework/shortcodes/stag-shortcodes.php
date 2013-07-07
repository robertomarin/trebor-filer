<?php

class StagShortcodes{
    function __construct(){
        add_action('init', array(&$this, 'shortcodes_init'));
        add_action('admin_init', array(&$this, 'shortcodes_admin_init'));
    }

    function shortcodes_init(){
        if (!is_admin()){
            wp_enqueue_style( 'stag-shortcodes', get_template_directory_uri(). '/assets/css/shortcodes.css');
            wp_enqueue_script( 'jquery-ui-accordion' );
            wp_enqueue_script( 'jquery-ui-tabs' );
            wp_enqueue_script( 'stag-shortcodes-lib', STAG_URL. '/js/stag-shortcodes-lib.js', array('jquery', 'jquery-ui-accordion', 'jquery-ui-tabs'), '', true);
        }

        if(get_user_option('rich_editing') == 'true'){
          add_filter( 'mce_external_plugins', array(&$this, 'add_rich_plugins') );
          add_filter( 'mce_buttons', array(&$this, 'register_rich_buttons') );
        }
    }

    function shortcodes_admin_init(){
      wp_enqueue_style( 'stag-popup', STAG_URL . '/shortcodes/tinymce/css/popup.css', false, '1.0', 'all' );
      wp_enqueue_script( 'jquery-ui-sortable' );
      wp_enqueue_script( 'jquery-livequery', STAG_URL . '/shortcodes/tinymce/js/jquery.livequery.js', false, '1.1.1', false );
      wp_enqueue_script( 'jquery-appendo', STAG_URL . '/shortcodes/tinymce/js/jquery.appendo.js', false, '1.0', false );
      wp_enqueue_script( 'base64', STAG_URL . '/shortcodes/tinymce/js/base64.js', false, '1.0', false );
      wp_enqueue_script( 'stag-popup', STAG_URL . '/shortcodes/tinymce/js/popup.js', false, '1.0', false );
      wp_localize_script( 'jquery', 'StagShortcodes', array('plugin_folder' => STAG_URL.'/shortcodes/') );
    }

    /* Defins TinyMCE rich editor js plugin */
    function add_rich_plugins($plugin_array){
      $plugin_array['stagShortcodes'] = STAG_URL . '/shortcodes/tinymce/plugin.js';
      return $plugin_array;
    }

    function register_rich_buttons($buttons){
      array_push( $buttons, "|", 'stag_button' );
      return $buttons;
    }
}
$stag_shortcodes = new StagShortcodes();





/* COLUMNS SHORTCODES */
if (!function_exists('stag_one_third')) {
  function stag_one_third( $atts, $content = null ) {
     return '<div class="stag-one-third">' . do_shortcode($content) . '</div>';
  }
  add_shortcode('stag_one_third', 'stag_one_third');
}

if (!function_exists('stag_one_third_last')) {
  function stag_one_third_last( $atts, $content = null ) {
     return '<div class="stag-one-third stag-column-last">' . do_shortcode($content) . '</div><div class="clear"></div>';
  }
  add_shortcode('stag_one_third_last', 'stag_one_third_last');
}

if (!function_exists('stag_two_third')) {
  function stag_two_third( $atts, $content = null ) {
     return '<div class="stag-two-third">' . do_shortcode($content) . '</div>';
  }
  add_shortcode('stag_two_third', 'stag_two_third');
}

if (!function_exists('stag_two_third_last')) {
  function stag_two_third_last( $atts, $content = null ) {
     return '<div class="stag-two-third stag-column-last">' . do_shortcode($content) . '</div><div class="clear"></div>';
  }
  add_shortcode('stag_two_third_last', 'stag_two_third_last');
}

if (!function_exists('stag_one_half')) {
  function stag_one_half( $atts, $content = null ) {
     return '<div class="stag-one-half">' . do_shortcode($content) . '</div>';
  }
  add_shortcode('stag_one_half', 'stag_one_half');
}

if (!function_exists('stag_one_half_last')) {
  function stag_one_half_last( $atts, $content = null ) {
     return '<div class="stag-one-half stag-column-last">' . do_shortcode($content) . '</div><div class="clear"></div>';
  }
  add_shortcode('stag_one_half_last', 'stag_one_half_last');
}

if (!function_exists('stag_one_fourth')) {
  function stag_one_fourth( $atts, $content = null ) {
     return '<div class="stag-one-fourth">' . do_shortcode($content) . '</div>';
  }
  add_shortcode('stag_one_fourth', 'stag_one_fourth');
}

if (!function_exists('stag_one_fourth_last')) {
  function stag_one_fourth_last( $atts, $content = null ) {
     return '<div class="stag-one-fourth stag-column-last">' . do_shortcode($content) . '</div><div class="clear"></div>';
  }
  add_shortcode('stag_one_fourth_last', 'stag_one_fourth_last');
}

if (!function_exists('stag_three_fourth')) {
  function stag_three_fourth( $atts, $content = null ) {
     return '<div class="stag-three-fourth">' . do_shortcode($content) . '</div>';
  }
  add_shortcode('stag_three_fourth', 'stag_three_fourth');
}

if (!function_exists('stag_three_fourth_last')) {
  function stag_three_fourth_last( $atts, $content = null ) {
     return '<div class="stag-three-fourth stag-column-last">' . do_shortcode($content) . '</div><div class="clear"></div>';
  }
  add_shortcode('stag_three_fourth_last', 'stag_three_fourth_last');
}

if (!function_exists('stag_one_fifth')) {
  function stag_one_fifth( $atts, $content = null ) {
     return '<div class="stag-one-fifth">' . do_shortcode($content) . '</div>';
  }
  add_shortcode('stag_one_fifth', 'stag_one_fifth');
}

if (!function_exists('stag_one_fifth_last')) {
  function stag_one_fifth_last( $atts, $content = null ) {
     return '<div class="stag-one-fifth stag-column-last">' . do_shortcode($content) . '</div><div class="clear"></div>';
  }
  add_shortcode('stag_one_fifth_last', 'stag_one_fifth_last');
}

if (!function_exists('stag_two_fifth')) {
  function stag_two_fifth( $atts, $content = null ) {
     return '<div class="stag-two-fifth">' . do_shortcode($content) . '</div>';
  }
  add_shortcode('stag_two_fifth', 'stag_two_fifth');
}

if (!function_exists('stag_two_fifth_last')) {
  function stag_two_fifth_last( $atts, $content = null ) {
     return '<div class="stag-two-fifth stag-column-last">' . do_shortcode($content) . '</div><div class="clear"></div>';
  }
  add_shortcode('stag_two_fifth_last', 'stag_two_fifth_last');
}

if (!function_exists('stag_three_fifth')) {
  function stag_three_fifth( $atts, $content = null ) {
     return '<div class="stag-three-fifth">' . do_shortcode($content) . '</div>';
  }
  add_shortcode('stag_three_fifth', 'stag_three_fifth');
}

if (!function_exists('stag_three_fifth_last')) {
  function stag_three_fifth_last( $atts, $content = null ) {
     return '<div class="stag-three-fifth stag-column-last">' . do_shortcode($content) . '</div><div class="clear"></div>';
  }
  add_shortcode('stag_three_fifth_last', 'stag_three_fifth_last');
}

if (!function_exists('stag_four_fifth')) {
  function stag_four_fifth( $atts, $content = null ) {
     return '<div class="stag-four-fifth">' . do_shortcode($content) . '</div>';
  }
  add_shortcode('stag_four_fifth', 'stag_four_fifth');
}

if (!function_exists('stag_four_fifth_last')) {
  function stag_four_fifth_last( $atts, $content = null ) {
     return '<div class="stag-four-fifth stag-column-last">' . do_shortcode($content) . '</div><div class="clear"></div>';
  }
  add_shortcode('stag_four_fifth_last', 'stag_four_fifth_last');
}

if (!function_exists('stag_one_sixth')) {
  function stag_one_sixth( $atts, $content = null ) {
     return '<div class="stag-one-sixth">' . do_shortcode($content) . '</div>';
  }
  add_shortcode('stag_one_sixth', 'stag_one_sixth');
}

if (!function_exists('stag_one_sixth_last')) {
  function stag_one_sixth_last( $atts, $content = null ) {
     return '<div class="stag-one-sixth stag-column-last">' . do_shortcode($content) . '</div><div class="clear"></div>';
  }
  add_shortcode('stag_one_sixth_last', 'stag_one_sixth_last');
}

if (!function_exists('stag_five_sixth')) {
  function stag_five_sixth( $atts, $content = null ) {
     return '<div class="stag-five-sixth">' . do_shortcode($content) . '</div>';
  }
  add_shortcode('stag_five_sixth', 'stag_five_sixth');
}

if (!function_exists('stag_five_sixth_last')) {
  function stag_five_sixth_last( $atts, $content = null ) {
     return '<div class="stag-five-sixth stag-column-last">' . do_shortcode($content) . '</div><div class="clear"></div>';
  }
  add_shortcode('stag_five_sixth_last', 'stag_five_sixth_last');
}


/* BUTTON SHORTCODES */
if (!function_exists('stag_button')) {
  function stag_button( $atts, $content = null ) {
    extract(shortcode_atts(array(
      'url' => '#',
      'target' => '_self',
      'style' => 'grey',
      'size' => 'small',
      'type' => 'round'
      ), $atts));

     return '<a target="'.$target.'" class="stag-button '.$size.' '.$style.' '. $type .'" href="'.$url.'">' . do_shortcode($content) . '</a>';
  }
  add_shortcode('stag_button', 'stag_button');
}


/* ALERT SHORTCODE */
if (!function_exists('stag_alert')) {
  function stag_alert( $atts, $content = null ) {
    extract(shortcode_atts(array(
      'style'   => 'white'
      ), $atts));

     return '<div class="stag-alert '.$style.'"><i class="icon icon-'.$style.'"></i>' . do_shortcode($content) . '</div>';
  }
  add_shortcode('stag_alert', 'stag_alert');
}

/* TOGGLE SHORTCODES */
if (!function_exists('stag_toggle')) {
  function stag_toggle( $atts, $content = null ) {
      extract(shortcode_atts(array(
      'title'      => 'Title goes here',
      'state'    => 'open'
      ), $atts));

    return "<div data-id='".$state."' class=\"stag-toggle\"><span class=\"stag-toggle-title\">". $title ."</span><div class=\"stag-toggle-inner\">". do_shortcode($content) ."</div></div>";
  }
  add_shortcode('stag_toggle', 'stag_toggle');
}

/* TABS SHORTCODES */
if (!function_exists('stag_tabs')) {
  function stag_tabs( $atts, $content = null ) {
    $defaults = array();
    extract( shortcode_atts( $defaults, $atts ) );

    // Extract the tab titles for use in the tab widget.
    preg_match_all( '/tab title="([^\"]+)"/i', $content, $matches, PREG_OFFSET_CAPTURE );

    $tab_titles = array();
    if( isset($matches[1]) ){ $tab_titles = $matches[1]; }

    $output = '';

    if( count($tab_titles) ){
        $output .= '<div id="stag-tabs-'. rand(1, 100) .'" class="stag-tabs"><div class="stag-tab-inner">';
      $output .= '<ul class="stag-nav stag-clearfix">';

      foreach( $tab_titles as $tab ){
        $output .= '<li><a href="#stag-tab-'. sanitize_title( $tab[0] ) .'">' . $tab[0] . '</a></li>';
      }

        $output .= '</ul>';
        $output .= do_shortcode( $content );
        $output .= '</div></div>';
    } else {
      $output .= do_shortcode( $content );
    }

    return $output;
  }
  add_shortcode( 'stag_tabs', 'stag_tabs' );
}

if (!function_exists('stag_tab')) {
  function stag_tab( $atts, $content = null ) {
    $defaults = array( 'title' => 'Tab' );
    extract( shortcode_atts( $defaults, $atts ) );

    return '<div id="stag-tab-'. sanitize_title( $title ) .'" class="stag-tab">'. do_shortcode( $content ) .'</div>';
  }
  add_shortcode( 'stag_tab', 'stag_tab' );
}

/* AUTHOR SHORTCODE */
if (!function_exists('stag_author'))
{
  function stag_author( $atts )
  {
    extract(shortcode_atts(array(
      'author' => ''
    ), $atts ));

    $stag_author_info = get_userdata( $author );

    $return = '<div class="stag_author_wrap stag-clearfix">';

      $return .= '<div class="stag_author_gravatar">';
        $return .= get_avatar( $author );
      $return .= '</div>';

      $return .= '<div class="stag_author_info">';
        $return .= '<h4>' . $stag_author_info->user_firstname . ' ' . $stag_author_info->user_lastname . '</h4>';
        $return .= '<p>' . $stag_author_info->user_description . '</p>';
      $return .= '</div>';

    $return .= '</div>';

    return $return;
  }

  add_shortcode('stag_author', 'stag_author' );
}

/* CODE DISPLAY */
if (!function_exists('stag_code')) {
  function stag_code( $atts, $content = null ) {
    extract(shortcode_atts(array(
      'style' => '',
      'data_line' => ''
      ), $atts));

     return '<pre data-line="'.$data_line.'" class="language-' . $style . '"><code class="language-' . $style . '">' . do_shortcode($content) . '</code></pre>';
  }
  add_shortcode('stag_code', 'stag_code');
}

/* DIVIDER SHORTCODE */
if( !function_exists('stag_divider') ){
  function stag_divider($atts, $content=null){
    extract(shortcode_atts(array(
      'style' => ''
      ), $atts));
    return '<div class="stag-divider '.$style.'"></div>';
  }
  add_shortcode('stag_divider', 'stag_divider');
}

/* Intro Shortcode */
if (!function_exists('stag_intro_text')) {
  function stag_intro_text( $atts, $content = null ) {
    return '<div class="intro-text">' . do_shortcode($content) . '</div>';
  }
  add_shortcode('stag_intro', 'stag_intro_text');
}