<?php
// Theme Update Page
function stag_update_page(){
  ?>
<div class="wrap">
  <div id="icon-link-manager" class="icon32"></div>
  <h2><?php _e('Theme Updates', 'stag'); ?></h2>
  <?php
  if($xml = stag_get_theme_changelog()){
    if(version_compare(STAG_THEME_VERSION, $xml->latest) == -1){
      global $pagenow;
      ?>
      <div id="message" class="updated">
        <p><?php printf( __( '<strong>There is a new version of the %s theme available.</strong> You have version %s installed. <a href="%s">Update to version %s</a>.', 'stag' ), STAG_THEME_NAME, STAG_THEME_VERSION, admin_url( 'admin.php?page=stagframework-update' ), $xml->latest); ?></p>
      </div>
      <img style="width:300px;float:right;margin:0 0px 20px 20px;border:1px solid #ddd;" src="<?php echo get_template_directory_uri() .'/screenshot.png'; ?>" alt="<?php echo STAG_THEME_NAME; ?>" />
      <h3>Update Download and Instructions</h3>
      <p><strong>Important:</strong> Before updating please make a backup of <?php echo STAG_THEME_NAME; ?> theme inside your WordPress folder <code><?php echo str_replace( site_url(), '', get_template_directory_uri() ); ?></code></p>

      <?php
      $message = '';
      if(STAG_THEME_TYPE == 'premium'){
        $message = 'To update the '.STAG_THEME_NAME.' theme, login to your <a href="http://themeforest.net/signin">ThemeForest</a> account, head over to your downloads section and re-download the theme.';
      }elseif(STAG_THEME_TYPE == 'free'){
        $message = 'To update the '.STAG_THEME_NAME.' theme, head over to dowloads section of Codestag.';
      }elseif(STAG_THEME_TYPE == 'client'){
        $message = 'To update the '.STAG_THEME_NAME.' theme, leave a request to theme developer <strong>Ram Ratan Maurya</strong> on email address <strong>ram[at]codestag[dot]com</strong>. Depending upon the importance of theme update there might be some charges involved.';
      }
      ?>

      <p><?php echo $message; ?></p>

      <p>Extract the zip's contents, find the extracted theme folder, and upload the new files using FTP to the <code><?php echo str_replace( site_url(), '', get_template_directory_uri() ); ?></code>. This will overwrite the old files and is why it's important to backup any changes you've made to the theme files beforehand.</p>

      <p>If you didn't make any changes to the theme files, you are free to overwrite them with the new files without risk of losing theme settings, pages, posts, etc, and backwards compatibility is guaranteed.</p>

      <p>If you have made changes to the theme files, you will need to compare your changed files to the new files listed in the changelog below and merge them together.</p><br />

      <h3><?php _e('Changelog', 'stag'); ?></h3>
      <?php echo $xml->changelog; ?>
      <?php
    }else{
      ?>
      <p>The <?php echo STAG_THEME_NAME; ?> theme is currently up to date at version <?php echo STAG_THEME_VERSION; ?>. You will be notified as soon as the new version is available.</p>
      <h3><?php _e('Changelog', 'stag'); ?></h3>
      <?php
      echo $xml->changelog;
    }
  }else{
    _e( '<p>Error: Unable to fetch the changelog.</p>', 'stag' );
  }
  ?>
</div>
  <?php
}