<?php
add_action('widgets_init', create_function('', 'return register_widget("stag_twitter_feeds");'));

class stag_twitter_feeds extends WP_Widget{
  function stag_twitter_feeds(){
    $widget_ops = array('classname' => 'twitter-feeds', 'description' => __('Display your latest Twitter tweets.', 'stag'));
    $control_ops = array('width' => 300, 'height' => 350, 'id_base' => 'stag_twitter_feeds');
    $this->WP_Widget('stag_twitter_feeds', __('Custom Twitter Feeds', 'stag'), $widget_ops, $control_ops);
  }

  function widget($args, $instance){
    extract($args);

    // VARS FROM WIDGET SETTINGS
    $title = apply_filters('widget_title', $instance['title'] );
    $twitter_username = $instance['twitter_username'];
    $tweettext = $instance['tweettext'];
    $postcount = $instance['postcount'];

    echo $before_widget;

    if ( $title ) { echo $before_title . $title . $after_title; }

    $id = rand(0,999);
    ?>

    <script type="text/javascript">
        jQuery(document).ready(function($){
          $.getJSON('http://api.twitter.com/1/statuses/user_timeline/<?php echo $twitter_username; ?>.json?count=<?php echo $postcount; ?>&callback=?', function(tweets){
            $("#twitter_update_list_<?php echo $id; ?>").html(stag_format_twitter(tweets));
          });
        });
    </script>

    <ul id="twitter_update_list_<?php echo $id; ?>" class="twitter">
        <li><p></p></li>
    </ul>
    <?php if( !empty($tweettext) ) { ?>
        <a href="http://twitter.com/<?php echo $twitter_username; ?>" class="twitter-link"><?php echo $tweettext; ?></a>
    <?php } ?>

    <?php
    echo $after_widget;
  }

  function update($new_instance, $old_instance){
    $instance = $old_instance;

    // STRIP TAGS TO REMOVE HTML
    $instance['title'] = strip_tags($new_instance['title']);
    $instance['twitter_username'] = strip_tags($new_instance['twitter_username']);
    $instance['tweettext'] = strip_tags($new_instance['tweettext']);
    $instance['postcount'] = strip_tags($new_instance['postcount']);

    return $instance;
  }

  function form($instance){
    $defaults = array(
      'title' => 'Twitter Feeds',
      'twitter_username' => 'CodeStag',
      'tweettext' => 'Follow me on twitter',
      'postcount' => 5
      );

    $instance = wp_parse_args((array) $instance, $defaults);

    /* HERE GOES THE FORM */
    ?>

    <p>
      <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:', 'stag'); ?></label>
      <input type="text" class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" />
    </p>

    <p>
      <label for="<?php echo $this->get_field_id('twitter_username'); ?>"><?php _e('Twitter username:', 'stag'); ?></label>
      <input type="text" class="widefat" id="<?php echo $this->get_field_id( 'twitter_username' ); ?>" name="<?php echo $this->get_field_name( 'twitter_username' ); ?>" value="<?php echo $instance['twitter_username']; ?>" />
    </p>

    <p>
      <label for="<?php echo $this->get_field_id('postcount'); ?>"><?php _e('Number of tweets (max 20):', 'stag'); ?></label>
      <input type="text" class="widefat" id="<?php echo $this->get_field_id( 'postcount' ); ?>" name="<?php echo $this->get_field_name( 'postcount' ); ?>" value="<?php echo $instance['postcount']; ?>" />
    </p>

    <p>
      <label for="<?php echo $this->get_field_id('tweettext'); ?>"><?php _e('Follow text e.g. Follow on twitter', 'stag'); ?></label>
      <input type="text" class="widefat" id="<?php echo $this->get_field_id( 'tweettext' ); ?>" name="<?php echo $this->get_field_name( 'tweettext' ); ?>" value="<?php echo $instance['tweettext']; ?>" />
    </p>

    <?php
  }
}