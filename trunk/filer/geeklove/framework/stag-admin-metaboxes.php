<?php
function stag_add_meta_box($meta_box){
  if(!is_array($meta_box)) return false;

  $call_func = create_function('$post, $meta_box', 'stag_create_meta_box($post, $meta_box["args"]);');
  add_meta_box($meta_box['id'], $meta_box['title'], $call_func, $meta_box['page'], $meta_box['context'], $meta_box['priority'], $meta_box);
}


function stag_create_meta_box($post, $meta_box){
  if(!is_array($meta_box)) return false;

  if(isset($meta_box['description']) && $meta_box['description'] != '' ){
    echo '<p>'.$meta_box['description'].'</p>';
  }

  wp_nonce_field(basename(__FILE__), 'stag_meta_box_nonce');
  echo '<table class="stag-metabox-table">';

  foreach($meta_box['fields'] as $field){
    $meta = get_post_meta($post->ID, $field['id'], true);
    echo '<tr>
            <th>
              <label for="'.$field['id'].'"><strong>'.$field['name'].'</strong><span>'.$field['desc'].'</span></label>
            </th>';

    switch($field['type']){
      case 'text':
      echo '<td class="stag-box-'.$field['type'].'"><input type="text" name="stag_meta['.$field['id'].']" id="'.$field['id'].'" value="'.($meta ? $meta : $field['std']).'" size="30" /></td>';
      break;

      case 'textarea':
      echo '<td class="stag-box-'.$field['type'].'"><textarea name="stag_meta['.$field['id'].']" id="'.$field['id'].'"  rows="8" cols="5">'.($meta ? $meta : $field['std']).'</textarea></td>';
      break;

      case 'file':

      (array_key_exists('title', $field)) ? $title = $field['title'] : $title = 'Choose an Image';
      (array_key_exists('text', $field)) ? $text = $field['text'] : $text = 'Insert into Post';
      (array_key_exists('multiple', $field)) ? $multiple = $field['multiple'] : $multiple = 'false';

      $output = '';
      if($meta != ''){
        $metas = explode(',', $meta);
        foreach($metas as $m){
          $output .= '<div class="row-image"><img src="'.$m.'" alt="" /></div>';
        }
      }

      echo '<td class="stag-box-'.$field['type'].'">
      <input type="text" name="stag_meta['.$field['id'].']" id="'.$field['id'].'" value="'.($meta ? $meta : $field['std']).'" size="30" class="file" />
      <input data-id="'.get_the_ID().'" data-multiple="'.$multiple.'" data-title="'.$title.'" data-text="'.$text.'" type="button" class="button" name="'.$field['id'].'_button" id="'.$field['id'].'_button" value="Browse" /><div id="all-images">'.$output.'</div></td>';
      ?>
      <script>
      jQuery(document).ready(function($){

        var file_frame,
            wp_media_post_id = wp.media.model.settings.post.id;

          $('#<?php echo $field["id"] ?>_button').on('click', function(e){
            e.preventDefault();
            var the_button = $(this);
            set_to_post_id = the_button.data('id')
            var target = the_button.prev();
            if(file_frame){
              file_frame.uploader.uploader.param('post_id', set_to_post_id);
              file_frame.open();
              return;
            }else{
              wp.media.model.settings.post.id = set_to_post_id;
            }

            file_frame = wp.media.frames.file_frame = wp.media({
              title: the_button.data('title'),
              button: {
                text: the_button.data('text')
              },
              multiple: the_button.data('multiple')
            });

            file_frame.on('select', function(){

              if(the_button.data('multiple') === true){
                var selection = file_frame.state().get('selection');
                var files = [];
                selection.map( function( attachment ) {
                  attachment = attachment.toJSON();
                  files.push(attachment.url);
                  the_button.prev().val(files);
                });
                // just to be in safe side, remove it.
                the_button.next().html('');
                for (var i=0;i<files.length;i++){
                  var ext = files[i].substr(files[i].lastIndexOf(".")+1, files[i].length);
                  if(ext && /^(jpg|png|jpeg|gif)$/.test(ext)){
                    the_button.next().append('<div class="row-image"><img src="'+files[i]+'" alt="" /></div>');
                  }
                }

              }else{
                the_button.next().html('');
                attachment = file_frame.state().get('selection').first().toJSON();
                the_button.prev().val(attachment.url);
                the_button.next().append('<div class="row-image"><img src="'+attachment.url+'" alt="" /></div>');
              }
              wp.media.model.settings.post.id = wp_media_post_id;
            });
            file_frame.open();
          });
          jQuery('a.add_media').on('click', function() {
            wp.media.model.settings.post.id = wp_media_post_id;
          });
      });
    </script>
      <?php
      break;

      // Datepicker
      case 'date':
      echo '<td class="stag-box-'.$field['type'].'"><input type="text" name="stag_meta['.$field['id'].']" id="'.$field['id'].'" value="'.($meta ? $meta : $field['std']).'" size="30" data-date-format="dd-mm-yyyy" /></td>';
      ?>
      <script>
        jQuery(document).ready(function($){
          $('#<?php echo $field["id"] ?>').datepicker();
        });
      </script>
      <?php
      break;

      // Select
      case 'select':
      echo'<td class="stag-box-'.$field['type'].'"><select name="stag_meta['. $field['id'] .']" id="'. $field['id'] .'">';
      foreach( $field['options'] as $option ){
        echo'<option';
        if( $meta ){
          if( $meta == $option ) echo ' selected="selected"';
        } else {
          if( $field['std'] == $option ) echo ' selected="selected"';
        }
        echo'>'. $option .'</option>';
      }
      echo'</select></td>';
      break;

      // Radio
      case 'radio':
      echo '<td class="stag-box-'.$field['type'].'">';
      foreach( $field['options'] as $option ){
        echo '<label class="radio-label"><input type="radio" name="stag_meta['. $field['id'] .']" value="'. $option .'" class="radio"';
        if( $meta ){
          if( $meta == $option ) echo ' checked="yes"';
        } else {
          if( $field['std'] == $option ) echo ' checked="yes"';
        }
        echo ' /> '. $option .'</label> ';
      }
      echo '</td>';
      break;

      // Colorpicker
      case 'color':
      if( array_key_exists('val', $field) ) $val = ' value="' . $field['val'] . '"';
      if( $meta ) $val = ' value="' . $meta . '"';
      echo '<td class="stag-box-'.$field['type'].'">';
        echo '<div class="colorpicker-wrapper">';
        echo '<input type="text" id="'. $field['id'] .'_cp" name="stag_meta[' . $field['id'] .']"' . $val . ' />';
        echo '<div id="' . $field['id'] . '" class="colorpicker"></div>';
        echo '</div>';
        echo '</td>';
      break;

      case 'checkbox':
      echo '<td class="stag-box-'.$field['type'].'">';
      $val = '';
      if( $meta ) {
          if( $meta == 'on' ) $val = ' checked="yes"';
      } else {
          if( $field['std'] == 'on' ) $val = ' checked="yes"';
      }

      echo '<input type="hidden" name="stag_meta['. $field['id'] .']" value="off" />
      <input type="checkbox" id="'. $field['id'] .'" name="stag_meta['. $field['id'] .']" value="on"'. $val .' /> ';
      echo '</td>';
      break;
    }
    echo '</tr>';
  }
  echo '</table>';
}

function stag_save_meta_box($post_id){
  if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE )
    return;

  if(!isset($_POST['stag_meta']) || !isset($_POST['stag_meta_box_nonce']) || !wp_verify_nonce($_POST['stag_meta_box_nonce'], basename(__FILE__)) )
    return;

  if('page' == $_POST['post_type']){
    if(!current_user_can('edit_page', $post_id)) return;
  }else{
    if(!current_user_can('edit_post', $post_id)) return;
  }

  foreach($_POST['stag_meta'] as $key => $val){
    update_post_meta($post_id, $key, stripslashes(htmlspecialchars($val)));
  }
}
add_action('save_post', 'stag_save_meta_box');
?>