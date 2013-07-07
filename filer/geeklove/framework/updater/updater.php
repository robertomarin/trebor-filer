<?php
/**
 * STAG_Framework_Updater Class
 *
 * @package STAG
 * @subpackage Updater
 */
class STAG_Framework_Updater{
  /**
   * Adds notifications if there are new version available.
   * Runs on time a day
   */
  public static function check_update(){
    if(get_transient('framework_version') !== STAG_FRAMEWORK_VERSION){
      $lastChecked = 0;
    }else{
      $lastChecked = (int) stag_get_option('framework_last_checked');
    }

    if($lastChecked == 0 || ($lastChecked + 60 * 60 * 24) < time()){
      if(self::has_update()){
        stag_add_option('framework_status', 'needs_update');
      }else{
        stag_remove_option('framework_status');
      }
      stag_add_option('framework_last_checked', time());
      set_transient('framework_version', STAG_FRAMEWORK_VERSION);
    }
    if(stag_get_option('framework_status') == 'needs_update'){
      add_action('admin_notices', array(__CLASS__, 'notification'));
    }
  }


  /**
   * Checks if new there is a new version of CodeStag framework available.
   * @return bool
   */
  public function has_update(){
    $remoteVersion = self::get_remote_version();
    $localVersion = self::get_framework_version();

    if(preg_match('/[0-9]*\.?[0-9]+/', $remoteVersion)){
      if(version_compare($localVersion, $remoteVersion) == -1){
        return true;
      }
    }
    return false;
  }


  /**
   * Returns current framework version pulled from CodeStag Update server.
   * @since 1.0.0
   * @return string
   */
  public static function get_remote_version(){
    global $wp_version;
    $url = STAG_UPDATE_URL.'/framework/version';
    $options = array(
      'timeout' => 3,
      'user-agent' => 'WordPress/' . $wp_version . '; ' . home_url( '/' )
      );
    $response = wp_remote_get($url, $options);
    if (is_wp_error($response) || 200 != wp_remote_retrieve_response_code($response)) {
      return 'Can\'t connect to CodeStag server. Please try again later.';
    }

    $version = trim(wp_remote_retrieve_body($response));
    $version = maybe_unserialize($version);
    return $version;
  }

  /* FRAMEWORK CHANGELOG */
  public static function get_changelog(){
    global $wp_version;
    $url = STAG_UPDATE_URL.'/framework/changelog';
    $options = array(
      'timout' => 3,
      'user-agent' => 'WordPress/' . $wp_version . '; ' . home_url( '/' )
      );
    $response = wp_remote_get($url, $options);

    if (is_wp_error($response) || 200 != wp_remote_retrieve_response_code($response)) {
        return 'Can\'t connect to CodeStag server. Please try again later.';
    }

    $response = trim(wp_remote_retrieve_body($response));
    $response = maybe_unserialize($response);
    return $response;
  }


  /* GET FRAMEWORK VERSION */
  public static function get_framework_version(){
    return STAG_FRAMEWORK_VERSION;
  }

  /* SET UPDATE NOTIFICATION IN ADMIN IF THERE IS AN UPDATE AVAILABLE */
  public static function notification(){
    $msg = sprintf('There is a new version available of CodeStag Framework, please check the <a href="%s">update page</a>.', admin_url('admin.php?page=stagframework-coreupdate'));
    echo '<div class="update-nag zoomfw-core">' . $msg . '</div>';
  }


  public function update_init(){
    if(!isset($_GET['page'])) return;

    $fsmethod = get_filesystem_method();
    $fs = WP_Filesystem();

    if($fs == false){
      function framework_update_filesystem_warning(){
        $method = get_filesystem_method();
        echo "<p>Failed: Filesystem preventing downloads. ($method)</p>";
      }
      add_action( 'admin_notices', 'framework_update_filesystem_warning' );
      return;
    }

    if(isset($_POST['stag-do-update'])){
      $action = strtolower(trim(strip_tags($_POST['stag-do-update'])));

      if($action == 'update'){
        $fwurl = STAG_UPDATE_URL.'/framework/stag-framework.zip';
        $fwfile = download_url($fwurl);

        if(is_wp_error($fwurl)){
          $error = $fwfile->get_error_code();
          if($error == 'http_no_url'){
            $rmessage = "<p>Failed: Invalid URL Provided</p>";
          }else{
            $rmessage = "<p>Failed: Upload - $error</p>";
          }
          function framework_update_warning() {
            global $rmessage;
            echo "<p>$rmessage</p>";
          }
          add_action('admin_notices', 'framework_update_warning');
          return;
        }
      }

      global $WP_Filesystem;
      $to = STAG_DIR;
      $dounzip = unzip_file($fwfile, $to);

      unlink($fwfile);

      if(is_wp_error($dounzip)){
        $error = $dounzip->get_error_code();
        $data = $dounzip->get_error_data($error);

        if($error == 'incompatible_archive') {
          //The source file was not found or is invalid
          function framework_update_no_archive_warning() {
          echo "<p>Failed: Incompatible archive</p>";
        }
        add_action( 'admin_notices', 'framework_update_no_archive_warning' );

        }
        if($error == 'empty_archive') {
          function framework_update_empty_archive_warning() {
            echo "<p>Failed: Empty Archive</p>";
          }
          add_action( 'admin_notices', 'framework_update_empty_archive_warning' );
        }

        if($error == 'mkdir_failed') {
          function framework_update_mkdir_warning() {
            echo "<p>Failed: mkdir Failure</p>";
          }
          add_action( 'admin_notices', 'framework_update_mkdir_warning' );
        }

        if($error == 'copy_failed') {
          function framework_update_copy_fail_warning() {
            echo "<p>Failed: Copy Failed</p>";
          }
          add_action( 'admin_notices', 'update_copy_fail_warning' );
        }
        return;
      }

      function framework_updated_success(){
        echo '<div class="updated fade"><p>New framework successfully downloaded, extracted and updated.</p></div>';
      }
      add_action('admin_notices', 'framework_updated_success');

      remove_action('admin_notices', array(__CLASS__, 'notification'));

      stag_remove_option('framework_status');
      stag_update_option('framework_last_checked', time());
    }
  }
}



add_action('admin_init', array('STAG_Updater', 'init'));

class STAG_Updater{
  public static function init(){
    add_action('admin_head', array('STAG_Framework_Updater', 'check_update'));
    add_action('admin_head', array('STAG_Framework_Updater', 'update_init'));
  }
}