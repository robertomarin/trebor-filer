<?php
// THEME OPTIONS SETUP
function stag_options_page(){
  $stag_options = get_option('stag_framework_options');
  ksort($stag_options['stag_framework']);
  ?>
  <?php if(isset($_GET['activated'])){ ?>
  <div class="updated admin-message" id="message">
    <p><?php echo sprintf(__('%s activated, please save settings before leaving this page.', 'stag'), STAG_THEME_NAME); ?></p>
  </div>
  <?php } ?>
  <div id="settings-saved">
  </div>
  <div id="stag-admin-wrap">
    <form action="<?php echo site_url() .'/wp-admin/admin-ajax.php'; ?>" method="post" id="stag-form">
      <div class="stag-header">
        <h1><?php echo $stag_options['theme_name']; ?> <span><?php echo 'v'.$stag_options['theme_version']; ?></span></h1>
        <p>
          by <a href="//mauryaratan.me?ref=stagframework" title="Ram Ratan Maurya's Personal Website" target="_blank">Ram Ratan Maurya</a>
          &middot; <a href="<?php echo STAG_FEEDBACK_URL; ?>" target="_blank" title="Send feedback to Codestag">Feedback</a>
          <?php if(STAG_THEME_TYPE === 'premium'): ?>
          &middot; <a href="//codestag.com/docs/<?php echo stag_to_slug(STAG_THEME_NAME); ?>-documentation.pdf" target="_blank" title="<?php echo STAG_THEME_NAME; ?>'s documentation">Documentation</a>
          <?php endif; ?>
        </p>
        <div id="stag-logo"><a href="//codestag.com?ref=stagframework" title="Codestag" target="_blank"></a></div>
      </div>
      <div class="stag-content cf">
        <div class="stag-sidebar">
          <ul>
            <?php foreach($stag_options['stag_framework'] as $page): ?>
            <li data-name="<?php echo stag_to_slug(key($page)); ?>"><a href="#<?php echo stag_to_slug( key($page) ); ?>"><?php echo key($page); ?></a></li>
            <?php endforeach; ?>
          </ul>
        </div>
        <div class="stag-main-content">
          <?php foreach( $stag_options['stag_framework'] as $page ):?>
          <div id="page-<?php echo stag_to_slug(key($page)); ?>" class="page">
            <h2><?php echo key($page); ?></h2>
            <p class="page-description">
              <?php if(isset($page[key($page)]['description']) && $page[key($page)]['description'] != '' ) echo $page[key($page)]['description']; ?>
            </p>

            <?php foreach($page[key($page)] as $item) : ?>
              <?php if(key((array)$item) == 'description') continue; ?>
              <div data-type="<?php echo $item['type']; ?>" class="row <?php echo stag_to_slug(@$item['title']); ?> clearfix">
                <h3><?php echo $item['title']; ?></h3>
                <?php if(isset($item['desc']) && $item['desc'] != '') : ?>
                <div class="desc">
                  <?php echo $item['desc']; ?>
                </div>
                <?php endif; ?>
                <?php stag_create_field($item); ?>
              </div>
            <?php endforeach; ?>

          </div>
          <?php endforeach; ?>
        </div>
      </div>

      <div class="footer clearfix">
        <input type="hidden" name="action" value="stag_framework_save" />
        <input type="hidden" name="stag_noncename" id="stag_noncename" value="<?php echo wp_create_nonce('stag_framework_options'); ?>" />
        <input type="button" value="<?php _e( 'Reset settings', 'stag' ); ?>" class="cs-button" id="reset-button" />
        <input type="submit" name="save_changes" value="<?php _e( 'Save Changes', 'stag' ); ?>" class="cs-button green" id="save-button" />
      </div>

    </form>
  </div>
  <?php
}

// Alright let's save the data
function stag_framework_save(){
  $response['error'] = false;
  $response['message'] = '';
  $response['type'] = '';

  // Got to check if it's coming from the right screen
  if(!isset($_POST['stag_noncename']) && !wp_verify_nonce($_POST['stag_noncename'], plugin_basename('stag_framework_options'))){
    $response['error'] = true;
    $response['message'] = __('You do not have sufficient permissions to save these options.', 'stag' );
    echo json_encode($response);
    die;
  }

  $stag_values = get_option('stag_framework_values');
  foreach($_POST['settings'] as $key => $val){
    $stag_values[$key] = $val;
  }

  $stag_values = apply_filters('stag_framework_save', $stag_values);
  update_option('stag_framework_values', $stag_values);

  $response['message'] = __('Settings Successfully Saved!', 'stag');
  echo json_encode($response);
  die;
}
add_action('wp_ajax_stag_framework_save', 'stag_framework_save');

// That's how I reset the form data
function stag_framework_reset(){
  $response['error'] = false;
  $response['message'] = '';

  if(!isset($_POST['nonce']) || !wp_verify_nonce($_POST['nonce'], plugin_basename('stag_framework_options'))){
      $response['error'] = true;
      $response['message'] = __('You do not have sufficient permissions to reset these options.', 'stag' );
      echo json_encode($response);
      die;
  }

  update_option('stag_framework_values', array());
  echo json_encode($response);
  die;
}
add_action('wp_ajax_stag_framework_reset', 'stag_framework_reset');


// AJAX UPLOAD SETUP
function stag_ajax_upload(){
  $response['error']=  false;
  $response['message']=  '';

  $wp_uploads = wp_upload_dir();
  $upload_file = $wp_uploads['path'].'/'.basename($_FILES['userfile']['name']);

  if(move_uploaded_file($_FILES['userfile']['tmp_name'], $upload_file)){
    $stag_values = get_option('stag_framework_values');
    $stag_values[$_POST['data']] = $wp_uploads['url'].'/'.basename($_FILES['userfile']['name']);
    update_option('stag_framework_values', $stag_values);
    $response['message'] = 'success';
  }else{
    $response['error'] = 'true';
    $response['message'] = 'error';
  }

  echo json_encode($response);
  die;
}
add_action('wp_ajax_stag_ajax_upload', 'stag_ajax_upload');


function stag_ajax_remove(){
  $response['error'] = false;
  $response['message'] = '';

  $data = $_POST['data'];

  $stag_values = get_option('stag_framework_values');
  unset($stag_values[$_POST['data']]);
  update_option('stag_framework_values', $stag_values);
  $response['message'] =  'success';

  echo json_encode($response);
  die;
}
add_action('wp_ajax_stag_ajax_remove', 'stag_ajax_remove');