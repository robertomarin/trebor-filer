<?php

// INITIAL SETUP
function stag_admin_init(){
  if(stag_is_theme_activated()){
    flush_rewrite_rules();
    header( 'Location: '. home_url() .'/wp-admin/admin.php?page=stagframework&activated=true' );
  }

  $data = get_option('stag_framework_options');
  $data['theme_version'] = STAG_THEME_VERSION;
  $data['theme_name'] = STAG_THEME_NAME;
  $data['framework_version'] = STAG_FRAMEWORK_VERSION;
  $data['stag_framework'] = array();
  update_option('stag_framework_options', $data);

  $stag_values = get_option('stag_framework_values');
  if( !is_array($stag_values) ) update_option( 'stag_framework_values', array() );
}
add_action('init', 'stag_admin_init', 2);


// ADMIN STYLES
function stag_admin_styles(){
  wp_enqueue_style('stag_admin_css', STAG_URL. '/css/stag-admin.css');
  wp_enqueue_style('wp-color-picker');
  wp_enqueue_style('redactor', STAG_URL.'/css/redactor.css');
  wp_enqueue_style('stag-datepicker', STAG_URL.'/css/datepicker.css');
}
add_action('admin_print_styles', 'stag_admin_styles');


function stag_admin_scripts(){
  wp_enqueue_media(); //required for WP media uploader to work, uncomment if not required
  wp_enqueue_script('stag-ajaxupload', STAG_URL .'/js/ajax-upload.js', array('jquery'));
  wp_enqueue_script('stag-admin-js', STAG_URL .'/js/stag-admin.js', array('jquery', 'wp-color-picker', 'stag-datepicker'));
  wp_enqueue_script('redactor', STAG_URL.'/js/jquery.redactor.min.js', array('jquery', 'stag-admin-js'));
  wp_enqueue_script('stag-datepicker', STAG_URL.'/js/datepicker.js', array('jquery'));
}
if(isset($_GET) && @$_GET['page'] == 'stagframework'){
  add_action('admin_enqueue_scripts', 'stag_admin_scripts');
}

function stag_wp_media(){
  wp_enqueue_media();
}
add_action('admin_enqueue_scripts', 'stag_admin_scripts');



// ADMIN MENU
function stag_menu(){
  $stag_options = get_option('stag_framework_options');
  $icon = STAG_URL.'/img/favicon.png';
  add_object_page( STAG_THEME_NAME, STAG_THEME_NAME, 'update_core', 'stagframework', 'stag_options_page', $icon );
  add_submenu_page('stagframework', __('Theme Options', 'stag'), __('Theme Options', 'stag'), 'update_core', 'stagframework', 'stag_options_page' );
  add_submenu_page('stagframework', __('Advanced', 'stag'), __('Advanced', 'stag'), 'update_core', 'stagframework-advanced', 'stag_advanced' );

  // SETUP THEME UPDATE PAGE NOTIFICATION
  // $menu_title = 'Theme Updates';
  // if($xml = stag_get_theme_changelog()){
  //   if(version_compare(STAG_THEME_VERSION, $xml->latest) == -1){
  //     $menu_title = __('Theme Updates <span class="update-plugins count-1"><span class="udpate-count">1</span></span>', 'stag');
      // add_dashboard_page(STAG_THEME_NAME, STAG_THEME_NAME, 'update_core', 'stagframework-update', 'stag_update_page');
  //   }
  // }
  // add_submenu_page('stagframework', __('Theme Updates', 'stag'), __('Theme Updates', 'stag'), 'update_core', 'stagframework-update', 'stag_update_page' );
  // add_submenu_page('stagframework', __('Framework Updates', 'stag'), __('Framework Updates', 'stag'), 'update_core', 'stagframework-coreupdate', 'stag_framework_update' );
}
add_action('admin_menu', 'stag_menu');


// OUTPUT CUSTOM CSS FILE
function stag_link_custom_styles(){
  $output = '';
  if(apply_filters('stag_custom_styles', $output)){
    $perma_structure = get_option('permalink_structure');
    $url = home_url(). '/stag-custom-styles.css?'.time();
    if(!$perma_structure) $url = home_url(). '?page_id=stag-custom-styles.css';
    echo '<link rel="stylesheet" href="'.$url.'" type="text/css" media="screen" />';
  }
}
add_action('wp_enqueue_scripts', 'stag_link_custom_styles', 12);

// CREATE CUSTOM CSS FILE
function stag_create_custom_styles(){
  $perma_structure = get_option('permalink_structure');
  $show_css = false;

  if($perma_structure){
    if(!isset($_SERVER['REQUEST_URI'])){
      $_SERVER['REQUEST_URI'] = substr($_SERVER['PHP_SELF'], 1);
      if(isset($_SERVER['QUERY_STRING'])){$_SERVER['REQUEST_URI'].='?'.$_SERVER['QUERY_STRING'];}
    }
    $url = (isset($GLOBALS['HTTP_SERVER_VARS']['REQUEST_URI'])) ? $GLOBALS['HTTP_SERVER_VARS']['REQUEST_URI'] : $_SERVER['REQUEST_URI'];
    if(preg_replace('/\\?.*/', '', basename($url)) == 'stag-custom-styles.css') $show_css = true;
  }else{
    if(isset($_GET['page_id']) && $_GET['page_id'] == 'stag-custom-styles.css' ) $show_css =  true;
  }
  if($show_css){
    $output = '';
    header('Content-Type: text/css');
    echo apply_filters('stag_custom_styles', $output);
    exit;
  }
}
add_action('init', 'stag_create_custom_styles');