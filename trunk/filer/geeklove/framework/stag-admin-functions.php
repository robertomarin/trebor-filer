<?php
function stag_to_slug($str){
  $str = strtolower(trim($str));
  $str = preg_replace('/[^a-z0-9-]/', '-', $str);
  $str = preg_replace('/-+/', "-", $str);
  return $str;
}

function stag_create_field($item){
  $stag_values = get_option('stag_framework_values');
  echo '<div class="input '.stag_to_slug($item['type']).'">';

  $class = '';
  if(array_key_exists('class', $item)) $class = ' class="'.$item['class'].'" ';

  $attr = '';
  if(array_key_exists('attr', $item)) $attr = $item['attr'];

  $prefix = 'settings';
  if(array_key_exists('ignore', $item) && $item['ignore'] == true) $prefix = 'ignore';

  // TEXT INPUT
  if($item['type'] == 'text'){
    $val = '';
    if(array_key_exists('val', $item)) $val = ' value="'.$item['val'].'"';
    if(array_key_exists($item['id'], $stag_values)) $val = ' value="'.$stag_values[$item['id']].'"';
    echo '<input type="text" id="'.$item['id'].'" name="'.$prefix.'['.$item['id'].']" '.$val.$class.$attr.' />';
  }

  if($item['type'] == 'number' || $item['type'] == 'datetime' || $item['type'] == 'datetime'){
    $val = '';
    if(array_key_exists('val', $item)) $val = ' value="'.$item['val'].'"';
    if(array_key_exists($item['id'], $stag_values)) $val = ' value="'.$stag_values[$item['id']].'"';
    echo '<input type="'.$item['type'].'" id="'.$item['id'].'" name="'.$prefix.'['.$item['id'].']" '.$val.$class.$attr.' />';
  }

  // TEXTAREA
  if($item['type'] == 'textarea'){
    $val = '';
    if(array_key_exists('val', $item)) $val = $item['val'];
    if(array_key_exists($item['id'], $stag_values)) $val = $stag_values[$item['id']];
    echo '<textarea id="'. $item['id'] .'" name="'. $prefix .'['. $item['id'] .']"'. $class . $attr .' >'. stripslashes($val) .'</textarea>';
  }

  // WYSIWYG
  if($item['type'] == 'wysiwyg'){
    $val = '';
    $class .= ' class="wysiwyg_editor"';
    if(array_key_exists('val', $item)) $val = $item['val'];
    if(array_key_exists($item['id'], $stag_values)) $val = $stag_values[$item['id']];
    echo '<textarea id="'. $item['id'] .'" name="'. $prefix .'['. $item['id'] .']"'. $class . $attr .' >'. stripslashes($val) .'</textarea>';
  }

  // SELECT
  if($item['type'] == 'select' && array_key_exists('options', $item)){
    echo '<select id="'.$item['id'].'" name="'.$prefix.'['.$item['id'].']" '.$class.$attr.'>';
    foreach($item['options'] as $key=>$value){
      $val = '';
      if(array_key_exists($item['id'], $stag_values)){
        if($stag_values[$item['id']] == $key) $val = ' selected="selected"';
      }else{
        if(array_key_exists('val', $item) && $item['val'] == $key) $val = ' selected="selected"';
      }
      echo '<option value="'.$key.'"'.$val.'>'.$value.'</option>';
    }
    echo '</select>';
  }

  // PAGES DROPDOWN
  if($item['type'] == 'pages'){
    $stag_pages_obj = get_pages();
    echo '<select id="'. $item['id'] .'" name="'. $prefix .'['. $item['id'] .']"'. $class .$attr.'>';
    echo '<option value="">Select Page</option>';
    foreach($stag_pages_obj as $stag_page){
        $val = '';
        if(array_key_exists($item['id'], $stag_values)){
            if($stag_values[$item['id']] == $stag_page->ID) $val = ' selected="selected"';
        } else {
            if(array_key_exists('val', $item) && $item['val'] == $stag_page->ID) $val = ' selected="selected"';
        }
        echo '<option value="'. $stag_page->ID .'"'. $val .'>'. $stag_page->post_title .'</option>';
    }
    echo '</select>';
  }

  // CATEGORY DROPDOWN
  if($item['type'] == 'category'){
    $stag_categories_obj = get_categories('hide_empty=0');

    echo '<select id="'. $item['id'] .'" name="'. $prefix .'['. $item['id'] .']"'. $class .$attr.'>';
    foreach($stag_categories_obj as $stag_category){
        $val = '';
        if(array_key_exists($item['id'], $stag_values)){
            if($stag_values[$item['id']] == $stag_category->cat_ID) $val = ' selected="selected"';
        } else {
            if(array_key_exists('val', $item) && $item['val'] == $stag_category->cat_ID) $val = ' selected="selected"';
        }
        echo '<option value="'. $stag_category->cat_ID .'"'. $val .'>'. $stag_category->cat_name .'</option>';
    }
    echo '</select>';
  }

  // RADIO BUTTON
  if($item['type'] == 'radio' && array_key_exists('options', $item)){
    $i = 0;
    foreach($item['options'] as $key=>$value){
      $val = '';
      if(array_key_exists($item['id'], $stag_values)){
          if($stag_values[$item['id']] == $key) $val = ' checked="checked"';
      }else{
          if(array_key_exists('val', $item) && $item['val'] == $key) $val = ' checked="checked"';
      }
      echo '<label for="'. $item['id'] .'_'. $i .'"><input type="radio" id="'. $item['id'] .'_'. $i .'" name="'. $prefix .'['. $item['id'] .']" value="'. $key .'"'. $val . $class . $attr .'> '. $stag_values .'</label><br />';
      $i++;
    }
  }

  // CHECKBOX
  if($item['type'] == 'checkbox'){
    $val= '';
    if(array_key_exists('val', $item) && $item['val'] == 'on') $val = ' checked="yes"';
    if(array_key_exists($item['id'], $stag_values) && $stag_values[$item['id']] == 'on') $val = ' checked="yes"';
    if(array_key_exists($item['id'], $stag_values) && $stag_values[$item['id']] != 'on') $val = '';
    echo '<input type="hidden" name="'. $prefix .'['. $item['id'] .']" value="off" />
    <input type="checkbox" id="'. $item['id'] .'" name="'. $prefix .'['. $item['id'] .']" value="on"'. $class . $val . $attr .' /> ';
    if(array_key_exists('text', $item)) echo $item['text'];
  }

  // MULTI CHECKBOXES
  if($item['type'] == 'checkboxes' && array_key_exists('options', $item)){
    foreach($item['options'] as $key=>$value){
      $val = '';
      $id = $item['id'].'_'.stag_to_slug($key);
      if($value == 'on') $val = ' checked="yes"';
      if(array_key_exists($id, $stag_values) && $stag_values[$id] == 'on') $val = ' checked="yes"';
      if(array_key_exists($id, $stag_values) && $stag_values[$id] != 'on') $val = '';
      echo '<input type="hidden" name="'. $prefix .'['. $id .']" value="off" />
      <input type="checkbox" id="'. $id .'" name="'. $prefix .'['. $id .']" value="on"'. $class . $val . $attr .' /> ';
      echo '<label for="'. $id .'">'. $key .'</label><br />';
    }
  }


  // FILE
  if($item['type'] == 'file'){
    $val = 'Upload';
    if(array_key_exists('val', $item)) $val = $item['val'];
    $wp_uploads = wp_upload_dir();
    ?>
    <div id="uploaded_<?php echo $item['id']; ?>" class="ajax-upload">
      <?php
      if(array_key_exists($item['id'], $stag_values) && $item['id'] != ''){
        $ext = substr($stag_values[$item['id']], strrpos($stag_values[$item['id']], '.') + 1);
        if($ext == 'jpg' || $ext == 'png' || $ext == 'jpeg' || $ext == 'gif' || $ext == 'webp'){
          echo '<img src="'.$stag_values[$item['id']].'" alt"" />';
        }else{
          echo $stag_values[$item['id']];
        }
      }
      ?>
    </div>
    <?php
    $oup = '';
    if(isset($stag_values[$item['id']]) && $stag_values[$item['id']] != ''){
      $oup = $stag_values[$item['id']];
    }
    ?>
    <input type="text" id="text_<?php echo $item['id']; ?>" name="settings[<?php echo $item['id']; ?>]" hidden value="<?php echo @$oup; ?>" >
    <a href="#" id="file_upload_<?php echo $item['id']; ?>" class="cs-button" <?php echo @$attr; ?>><?php echo $val; ?></a>
    <a href="#" id="file_remove_<?php echo $item['id']; ?>" class="cs-button red" <?php if(@$stag_values[$item['id']] == ''){ echo ' style="display:none;"'; } ?>><?php _e('Remove', 'stag'); ?></a>
    <script type="text/javascript">
    jQuery(document).ready(function($){
      var hasAdded = false;
      $("#save-button").click(function(){
        hasAdded = false;
        $("span.changed").remove();
      });
      $("#file_upload_<?php echo $item['id'] ?>").click(function(e){
        e.preventDefault();
        var button = $(this);
        var id = "text_<?php echo $item['id'] ?>";
        wp.media.editor.send.attachment = function(props, attachment){
          $("#"+id).val(attachment.url);
          var file = attachment.url;
          $("#text_<?php echo $item['id']; ?>").val(file);
          $('#uploaded_<?php echo $item['id']; ?>').html('');
          var ext = file.substr(file.lastIndexOf(".")+1, file.length);
          if(ext && /^(jpg|png|jpeg|gif)$/.test(ext)){
            $('#uploaded_<?php echo $item['id']; ?>').html('<img src="'+file+'" alt="" />');
            $('#file_remove_<?php echo $item['id']; ?>').show();
          }else{
            $('#uploaded_<?php echo $item['id']; ?>').html(file);
          }
        }
        if(hasAdded === false){
          $("<span class='changed'><span></span>You have unsaved changes!</span>").insertBefore("#stag-admin-wrap");
        }
        wp.media.editor.open(button);
      });

      var remove = $('#file_remove_<?php echo $item['id']; ?>');
      remove.bind('click', function(){
        remove.text('Removing...');
        $("#text_<?php echo $item['id']; ?>").val('');
        $('#uploaded_<?php echo $item['id']; ?>').html('');
        remove.text('Remove');
        remove.hide();
        return false;
      });

    });
    </script>

    <?php
  }


  // FILES
  if($item['type'] == 'files'){
    $val = 'Upload';
    if(array_key_exists('val', $item)) $val = $item['val'];

    ?>
    <div id="uploaded_<?php echo $item['id']; ?>" class="ajax-upload">
      <?php

      if(array_key_exists($item['id'], $stag_values) && $item['id'] != ''){
        $values = $stag_values[$item['id']];
        $values = explode(",", $values);
        foreach($values as $dval){
          $ext = substr($dval, strrpos($dval, '.') + 1);
          if($ext == 'jpg' || $ext == 'png' || $ext == 'jpeg' || $ext == 'gif' || $ext == 'webp'){
            echo '<img src="'.$dval.'" alt"" />';
          }else{
            echo $dval;
          }
        }
      }
      ?>
    </div>
    <?php
    $oup = '';
    if(isset($stag_values[$item['id']]) && $stag_values[$item['id']] != ''){
      $oup = $stag_values[$item['id']];
    }
    ?>
    <input type="text" id="text_<?php echo $item['id']; ?>" name="settings[<?php echo $item['id']; ?>]" hidden value="<?php echo @$oup; ?>" >
    <a href="#" id="file_upload_<?php echo $item['id']; ?>" class="cs-button" <?php echo @$attr; ?>><?php echo $val; ?></a>
    <a href="#" id="file_remove_<?php echo $item['id']; ?>" class="cs-button red" <?php if(@$stag_values[$item['id']] == ''){ echo ' style="display:none;"'; } ?>><?php _e('Remove', 'stag'); ?></a>
    <script type="text/javascript">
    jQuery(document).ready(function($){
      var hasAdded = false;
      $("#save-button").click(function(){
        hasAdded = false;
        $("span.changed").remove();
      });

      var file_frame;
      $("#file_upload_<?php echo $item['id'] ?>").on('click', function(e){
        e.preventDefault();

        if ( file_frame ) {
          file_frame.open();
          return;
        }

        file_frame = wp.media.frames.file_frame = wp.media({
          title: 'Upload Files',
          button: {
            text: 'Insert',
          },
          multiple: true  // Set to true to allow multiple files to be selected
        });

        file_frame.on( 'select', function() {
          var text = $("#text_<?php echo $item['id']; ?>");
          $('#uploaded_<?php echo $item['id']; ?>').html('');
          var selection = file_frame.state().get('selection');
          var files = [];
          selection.map(function(attachment){
            files.push(attachment.attributes.url);
          });
          text.val(files);

          for (var i=0;i<files.length;i++){
            var ext = files[i].substr(files[i].lastIndexOf(".")+1, files[i].length);
            if(ext && /^(jpg|png|jpeg|gif)$/.test(ext)){
              $('#uploaded_<?php echo $item['id']; ?>').append('<img src="'+files[i]+'" alt="" />');
              $('#file_remove_<?php echo $item['id']; ?>').show();
            }else{
              $('#uploaded_<?php echo $item['id']; ?>').append(files[i]);
            }
          }

        });

        file_frame.open();

      });

      var remove = $('#file_remove_<?php echo $item['id']; ?>');
      remove.bind('click', function(){
        remove.text('Removing...');
        $("#text_<?php echo $item['id']; ?>").val('');
        $('#uploaded_<?php echo $item['id']; ?>').html('');
        remove.text('Remove');
        remove.hide();
        return false;
      });

    });
    </script>

    <?php
  }


  // COLOR PICKER
  if($item['type'] == 'color'){
    $val = '';
    $class .= 'class="colorpicker"';
    if(array_key_exists('val', $item)) $val = ' value="'. $item['val'] .'"';
    if(array_key_exists($item['id'], $stag_values)) $val = ' value="'. $stag_values[$item['id']] .'"';
    echo '<input data-default-color="'.$item['val'].'" type="text" id="'. $item['id'] .'_cp" name="'. $prefix .'['. $item['id'] .']"'. $val . $class . $attr .' />';
  }

  if($item['type'] == 'date'){
    $class .= 'class="stag-datepicker"';
    if(array_key_exists('val', $item)) $val = ' value="'. $item['val'] .'"';
    if(array_key_exists($item['id'], $stag_values)) $val = ' value="'. $stag_values[$item['id']] .'"';
    echo '<input type="text" id="'. $item['id'] .'" name="'. $prefix .'['. $item['id'] .']"'. $val . $class . $attr .' data-date-format="'. $item['format'] .'" />';
    ?>
    <script>
      jQuery(document).ready(function($){
        $('#<?php echo $item["id"] ?>').datepicker();
      });
    </script>

    <?php
  }

  // HTML
  if($item['type'] == 'html'){
    echo $item['val'];
  }

  // CUSTOM
  if($item['type'] == 'custom'){
    $func = '';
    $args = array();
    $id = '';
    if(array_key_exists('function', $item)) $func = $item['function'];
    if(array_key_exists('args', $item)) $args = $item['args'];
    if(array_key_exists('id', $item)) $id = $item['id'];

    if($func != '') call_user_func($func, $id, $args);
  }

  // AFTER
  if(array_key_exists('after', $item) && $item['after'] != ''){
    echo $item['after'];
  }
  echo '</div>';
}

// ADD FRAMEWORK PAGE
function stag_add_framework_page( $title, $data, $order = 0 ){
  if( !is_array($data) ) return false;

  $stag_options = get_option('stag_framework_options');
  $stag_framework = array();
  if( is_array($stag_options['stag_framework']) ) $stag_framework = $stag_options['stag_framework'];

  $stag_framework[$order] = array( $title => $data );

  $stag_options['stag_framework'] = $stag_framework;
  update_option('stag_framework_options', $stag_options);
}


// CHECK IF THERE IS ANY THIRD PARTY SEO PLUGIN IS ALREADY INSTALLED
function stag_check_third_party_seo(){
  include_once(ABSPATH .'wp-admin/includes/plugin.php');
  if(is_plugin_active('headspace2/headspace.php')) return true;
  if(is_plugin_active('all-in-one-seo-pack/all_in_one_seo_pack.php')) return true;
  if(is_plugin_active('wordpres-seo/wp-seo.php')) return true;
  return false;
}


function stag_admin_footer(){
  echo '<span class="stag-credits">'.STAG_THEME_NAME.' v'.STAG_THEME_VERSION.'. Theme powered by <a href="//codestag.com" target="_blank" rel="follow">Stag Framework v'.STAG_FRAMEWORK_VERSION.'</a>.</span>';
}
add_filter('admin_footer_text', 'stag_admin_footer');


function stag_post_type_labels($singular, $plural = ''){
  if($plural = '') $plural = $singular.'s';
  return array(
    'name' => _x( $plural, 'post type general name', 'stag' ),
    'singular_name' => _x( $singular, 'post type singular name', 'stag' ),
    'add_new' => __( 'Add New', 'stag' ),
    'add_new_item' => sprintf( __( 'Add New %s', 'stag' ), $singular),
    'edit_item' => sprintf( __( 'Edit %s', 'stag' ), $singular),
    'new_item' => sprintf( __( 'New %s', 'stag' ), $singular),
    'view_item' => sprintf( __( 'View %s', 'stag' ), $singular),
    'search_items' => sprintf( __( 'Search %s', 'stag' ), $plural),
    'not_found' =>  sprintf( __( 'No %s found', 'stag' ), $plural),
    'not_found_in_trash' => sprintf( __( 'No %s found in Trash', 'stag' ), $plural),
    'parent_item_colon' => ''
  );
}


function stag_taxonomy_labels($singular, $plural = ''){
  if($plural = '') $plural = $singular.'s';
  return array(
    'name' => _x( $plural, 'taxonomy general name', 'stag' ),
    'singular_name' => _x( $singular, 'taxonomy singular name', 'stag' ),
    'search_items' => sprintf( __( 'Search %s', 'stag' ), $plural),
    'popular_items' => sprintf( __( 'Popular %s', 'stag' ), $plural),
    'all_items' => sprintf( __( 'All %s', 'stag' ), $plural),
    'parent_item' => null,
    'parent_item_colon' => null,
    'edit_item' => sprintf( __( 'Edit %s', 'stag' ), $singular),
    'update_item' => sprintf( __( 'Update %s', 'stag' ), $singular),
    'add_new_item' => sprintf( __( 'Add New %s', 'stag' ), $singular),
    'new_item_name' => sprintf( __( 'New %s Name', 'stag' ), $singular),
    'separate_items_with_commas' => sprintf( __( 'Separate %s with commas', 'stag' ), $plural),
    'add_or_remove_items' => sprintf( __( 'Add or remove %s', 'stag' ), $plural),
    'choose_from_most_used' => sprintf( __( 'Choose from the most used %s', 'stag' ), $plural)
  );
}



/******************************************************************************************************
* THEME UPDATES
******************************************************************************************************/

// CHECK IF THERE IS NEW VERSION AVAILABLE
function stag_do_you_need_update_on(){
  $stag_options = get_option('stag_framework_options');
  $theme_version = 0;

  $response = wp_remote_get(STAG_UPDATE_URL.'/?action=updatecheck&theme='.urlencode(STAG_THEME_NAME));
  if(!is_wp_error($response) && wp_remote_retrieve_response_code($response) == 200){
    $remote_version = wp_remote_retrieve_body($response);
    if(!$remote_version){
      $theme_version = false;
    }
    if($remote_version > $stag_options['theme_version']){
      $theme_version = $remote_version;
    }
  }else{
    $theme_version = false;
  }
  return $theme_version;
}


function stag_is_theme_activated(){
    global $pagenow;
    if ( is_admin() && isset($_GET['activated'] ) && $pagenow == "themes.php" )
        return true;
    return false;
}


// GET THEME CHANGELOG
function stag_get_theme_changelog(){
  $stag_options = get_option('stag_framework_options');
  $log_url = STAG_UPDATE_URL.'/'.stag_to_slug(STAG_THEME_NAME).'-changelog.xml';
  $transkey = 'stag_latest_theme_version_'.stag_to_slug(STAG_THEME_NAME);

  if(false === ($cached_xml = get_transient($transkey))){
    if(function_exists('curl_init')){
      $ch = curl_init($log_url);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
      curl_setopt($ch, CURLOPT_HEADER, 0);
      curl_setopt($ch, CURLOPT_TIMEOUT, 10);
      $xml = curl_exec($ch);
      curl_close($ch);
    }else{
      $xml = file_get_contents($log_url);
    }

    if($xml){
      set_transient($transkey, $xml, 3600);
    }else{
      return false;
    }
  }else{
    $xml = $cached_xml;
  }
  return @simplexml_load_string($xml);
}

// SETUP ADMIN NOTICE
function stag_admin_notice(){
  global $pagenow;

  if($pagenow == 'index.php' && $xml = stag_get_theme_changelog()){
    if(version_compare(STAG_THEME_VERSION, $xml->latest) == -1){
      ?>
      <div id="message" class="updated">
        <p><?php printf( __( '<strong>There is a new version of the %s theme available.</strong> You have version %s installed. <a href="%s">Update to version %s</a>.', 'stag' ), STAG_THEME_NAME, STAG_THEME_VERSION, admin_url( 'admin.php?page=stagframework-update' ), $xml->latest); ?></p>
      </div>
      <?php
    }
  }
  return false;
}
// add_action('admin_notices', 'stag_admin_notice');