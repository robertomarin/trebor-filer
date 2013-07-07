<?php

function stag_downloadable_debug_info(){
  $output = '';
  $stag_values = get_option('stag_framework_values');
  $stag_options = get_option('stag_framework_options');
  $i = 0;
  foreach($stag_values as $key => $val){
    $i++;
    $output .= $i.". ".$key."[".stripslashes($val)."]"."\n";
  }
  foreach($stag_options as $key => $val){
    $i++;
    $output .= $i.". ".$key."[".$val."]"."\n";
  }

  $output .= $i++.'. WordPress Version['.get_bloginfo('version').']'."\n";
  $output .= $i++.'. Theme Name & Version['.STAG_THEME_NAME.' '.STAG_THEME_VERSION.']'."\n";
  $output .= $i++.'. PHP Version['.phpversion().']'."\n";
  $output .= $i++.'. Server Software['.$_SERVER['SERVER_SOFTWARE'].']'."\n";
  $output .= $i++.'. UPLOAD_MAX_FILESIZE['.ini_get( 'upload_max_filesize' ).']'."\n";
  $output .= $i++.'. DISPLAY_ERRORS['.ini_get( 'display_errors' ).']'."\n";
  return $output;
}

function stag_advanced(){
    $stag_options = get_option('stag_framework_options');
    ?>

<div id="stag-admin-wrap" class="advanced-wrap">
    <form action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="post" id="stag-form-advanced">
      <div class="stag-header">
        <h1><?php echo $stag_options['theme_name']; ?> <span><?php echo 'v'.$stag_options['theme_version']; ?></span></h1>
        <p>by <a href="//mauryaratan.me?ref=stagframework">Ram Ratan Maurya</a></p>
        <div id="stag-logo"><a href="//codestag.com?ref=stagframework" title="CodeStag"></a></div>
      </div>

      <div class="stag-content cf stag-tab-advanced">
        <h2>Advanced Settings</h2>
        <p class="page-description">Here you can import/export you theme settings and check debug information.</p>
        <div class="page">
            <div class="row clearfix">
                <h3>Import Settings</h3>
                <div class="desc">
                  Import your theme settings you saved before.
                </div>
                <div class="input">
                    <textarea name="import_code_data" id="import_code_data"></textarea>
                    <button type="submit" name="import_settings" id="export_code" class="cs-button ">Import Settings</button>
                    <?php
                    if(isset($_POST['import_settings'])){
                        if($_POST['import_code_data'] != ''){
                            $code = $_POST['import_code_data'];
                            $data = json_decode(base64_decode($code));
                            foreach($data as $key => $value){
                                stag_update_option($key, $value);
                            }
                            echo '<p>What a magic, go ahead check your stuffs.</p>';
                        }else{
                            echo "<p>Hmm! So you want import nothing? Seriously?</p>";
                        }
                    }
                   ?>
                </div>
            </div>

            <div class="row clearfix">
                <h3>Export Settings</h3>
                <div class="desc">
                  <?php $code = base64_encode(json_encode(get_option('stag_framework_values'))); ?>
                  <p>Use this code (contains current theme settings) into the import field to restore your settings if lost or using on another installation.</p>
                  <p><a id="download_export_data" href="#" data-code="<?php //echo $code; ?>">Click here</a> to generate text file with theme settings.</p>
                  <div id="theme_settings_data" hidden><?php echo $code; ?></div>
                  <output id="download_export_data_output"></output>
                </div>
                <div class="input">
                    <textarea id="import_code" readonly><?php echo $code; ?></textarea>
                </div>
            </div>

            <div class="row clearfix">
              <h3>Debug Information</h3>
              <div class="desc">
                <p>Download site debug information. (Useful when contacting to support team)</p>
                <p><a id="download_debug_info" href="#" data-code="<?php //echo stag_downloadable_debug_info(); ?>">Click here</a> to generate text file with theme debug information.</p>
                <div id="debug_info_data" hidden><?php echo stag_downloadable_debug_info(); ?></div>
                <output id="download_debug_info_output"></output>
              </div>
              <div class="input theme-debug-info">
                <p><span>Theme Name &amp; Version:</span> <?php echo STAG_THEME_NAME.' v'.STAG_THEME_VERSION; ?></p>
                <p><span>Framework Version:</span> <?php echo STAG_FRAMEWORK_VERSION; ?></p>
                <p><span>PHP Version:</span> <?php echo phpversion(); ?></p>
                <p><span>Server Software:</span> <?php echo $_SERVER['SERVER_SOFTWARE']; ?></p>
                <p><span>UPLOAD_MAX_FILESIZE:</span> <?php echo ini_get( 'upload_max_filesize' ); ?></p>
                <p><span>DISPLAY_ERRORS:</span> <?php echo ini_get( 'display_errors' ); ?></p>
              </div>
            </div>

            <div class="row clearfix">
              <h3>Report</h3>
              <div class="desc">
                <p>Report a bug or send feedback</p>
              </div>
              <div class="input theme-bug-report">
                Use this <a href="<?php echo STAG_FEEDBACK_URL; ?>">form</a> to send your feedback, suggestions, bug reports etc.
              </div>
            </div>

        </div>
      </div>
  </form>
</div>
<?php if(STAG_DEBUG): ?>
<div id="stag-debug-info">
  <p><b>Debug Information</b></p>
    <textarea readonly id="debug-info"><?php
      echo '//stag_framework_values'."\n";
      print_r(get_option('stag_framework_values'));
      echo "\n\n".'//stag_framework_options'."\n";
      print_r($stag_options);
      echo "\n\n";
      echo '//misc'."\n";
      echo 'TEMPLATEPATH: '. get_template_directory()."\n";
      echo "WordPress Version: ".get_bloginfo( 'version' )."\n";
      echo "PHP Version: ".phpversion()."\n";
      echo "Server Software: ".$_SERVER['SERVER_SOFTWARE']."\n";
      echo "UPLOAD_MAX_FILESIZE: ".ini_get( 'upload_max_filesize' )."\n";
      echo "DISPLAY_ERRORS: ".ini_get( 'display_errors' )."\n";
      ?></textarea>
</div>
<?php endif; ?>

  <?php
}