<?php

$absolute_path = __FILE__;
$path_to_file = explode( 'wp-content', $absolute_path );
$path_to_wp = $path_to_file[0];

// Access WordPress
require_once( $path_to_wp . '/wp-load.php' );

global $wpdb, $stag_author;
$wp_user_search = $wpdb->get_results("SELECT ID, display_name FROM $wpdb->users ORDER BY ID");

$stag_author = array();

foreach ( $wp_user_search as $userid ) {
  $user_id       = (int) $userid->ID;
  $display_name  = stripslashes($userid->display_name);

  $stag_author[$user_id] = $display_name;

}

?>