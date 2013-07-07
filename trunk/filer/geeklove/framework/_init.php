<?php
/**
* @since 1.0.0
* Defining constants
*/
define('STAG_DIR', get_template_directory().'/framework');
define('STAG_URL', get_template_directory_uri().'/framework');
define('STAG_FRAMEWORK_VERSION', '1.0.2');
define('STAG_DEBUG', false);
define('STAG_UPDATE_URL', 'http://updates.codestag.com');
define('STAG_THEME_TYPE', 'premium'); // Could be premium, free, client
define('STAG_FEEDBACK_URL', 'http://codestag.wufoo.com/forms/stag-framework-feedback/');

require_once(STAG_DIR. '/stag-admin-functions.php');
require_once(STAG_DIR. '/stag-admin-init.php');
require_once(STAG_DIR. '/stag-admin-metaboxes.php');
require_once(STAG_DIR. '/stag-admin-page-options.php');
require_once(STAG_DIR. '/stag-theme-functions.php');
require_once(STAG_DIR. '/stag-advanced.php');
require_once(STAG_DIR. '/shortcodes/stag-shortcodes.php');


// Updater files
// require_once(STAG_DIR. '/updater/updater.php');
// require_once(STAG_DIR. '/updater/framework-update.php');


/*
* Get & Define Theme Info
*/
if(function_exists('wp_get_theme')){
  if(is_child_theme()){
    $temp_obj = wp_get_theme();
    $theme_obj = wp_get_theme( $temp_obj->get('Template') );
  }else{
    $theme_obj = wp_get_theme();
  }
  $theme_version = $theme_obj->get('Version');
  $theme_name = $theme_obj->get('Name');
  $theme_uri = $theme_obj->get('ThemeURI');
  $theme_author = $theme_obj->get('Author');
  $theme_author_uri = $theme_obj->get('AuthorURI');
}

define('STAG_THEME_NAME', $theme_name);
define('STAG_THEME_VERSION', $theme_version);
define('STAG_THEME_URI', $theme_uri);
define('STAG_THEME_AUTHOR', $theme_author);
define('STAG_THEME_AUTHOR_URI', $theme_author_uri);

?>