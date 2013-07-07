<?php
add_action('widgets_init', create_function('', 'return register_widget("stag_flickr_widget");'));

class stag_flickr_widget extends WP_Widget{
  function stag_flickr_widget(){
    $widget_ops = array(
      'classname' => 'stag_flickr_widget',
      'description' => __('Display Flickr photos from a user\'s photostream', 'stag')
    );
    $control_ops = array('width' => 300, 'height' => 350, 'id_base' => 'stag_flickr_widget');
    $this->WP_Widget('stag_flickr_widget', __('Custom Flickr Photos', 'stag'), $widget_ops, $control_ops);
  }

  function widget($args, $instance){
    extract($args);

    // VARS FROM WIDGET SETTINGS
    $title = apply_filters('widget_title', $instance['title'] );
    $flickrID = $instance['flickrID'];
    $postcount = $instance['postcount'];
    $type = $instance['type'];
    $display = $instance['display'];

    echo $before_widget;

    if ( $title ) { echo $before_title . $title . $after_title; }
    ?>

    <div id="flickr_badge_wrapper" class="clearfix">

      <script type="text/javascript" src="http://www.flickr.com/badge_code_v2.gne?count=<?php echo $postcount ?>&amp;display=<?php echo $display ?>&amp;size=s&amp;layout=x&amp;source=<?php echo $type ?>&amp;<?php echo $type ?>=<?php echo $flickrID ?>"></script>

    </div>

    <?php
    echo $after_widget;
  }

  function update($new_instance, $old_instance){
    $instance = $old_instance;

    // STRIP TAGS TO REMOVE HTML
    $instance['title'] = strip_tags($new_instance['title']);
    $instance['flickrID'] = strip_tags($new_instance['flickrID']);
    $instance['postcount'] = $new_instance['postcount'];
    $instance['type'] = $new_instance['type'];
    $instance['display'] = $new_instance['display'];

    return $instance;
  }

  function form($instance){
    $defaults = array(
      'title' => 'Flickr Widget',
      'flickrID' => '10133335@N08',
      'postcount' => '9',
      'type' => 'user',
      'display' => 'latest'
      );

    $instance = wp_parse_args((array) $instance, $defaults);

    /* HERE GOES THE FORM */
    ?>

    <p>
      <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:', 'stag'); ?></label>
      <input type="text" class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" />
    </p>

    <p>
      <label for="<?php echo $this->get_field_id( 'flickrID' ); ?>"><?php _e('Flickr ID:', 'stag') ?> (<a href="http://idgettr.com/">idGettr</a>)</label>
      <input class="widefat" id="<?php echo $this->get_field_id( 'flickrID' ); ?>" name="<?php echo $this->get_field_name( 'flickrID' ); ?>" value="<?php echo $instance['flickrID']; ?>" />
    </p>

    <p>
      <label for="<?php echo $this->get_field_id( 'postcount' ); ?>"><?php _e('Number of Photos:', 'stag') ?></label>
      <select id="<?php echo $this->get_field_id( 'postcount' ); ?>" name="<?php echo $this->get_field_name( 'postcount' ); ?>" class="widefat">
        <option <?php if ( '4' == $instance['postcount'] ) echo 'selected="selected"'; ?>>4</option>
        <option <?php if ( '8' == $instance['postcount'] ) echo 'selected="selected"'; ?>>8</option>
      </select>
    </p>

    <p>
      <label for="<?php echo $this->get_field_id( 'type' ); ?>"><?php _e('Type (user or group):', 'stag') ?></label>
      <select id="<?php echo $this->get_field_id( 'type' ); ?>" name="<?php echo $this->get_field_name( 'type' ); ?>" class="widefat">
        <option <?php if ( 'user' == $instance['type'] ) echo 'selected="selected"'; ?>>user</option>
        <option <?php if ( 'group' == $instance['type'] ) echo 'selected="selected"'; ?>>group</option>
      </select>
    </p>

    <p>
      <label for="<?php echo $this->get_field_id( 'display' ); ?>"><?php _e('Display (random or latest):', 'stag') ?></label>
      <select id="<?php echo $this->get_field_id( 'display' ); ?>" name="<?php echo $this->get_field_name( 'display' ); ?>" class="widefat">
        <option <?php if ( 'random' == $instance['display'] ) echo 'selected="selected"'; ?>>random</option>
        <option <?php if ( 'latest' == $instance['display'] ) echo 'selected="selected"'; ?>>latest</option>
      </select>
    </p>

    <?php
  }
}

?>