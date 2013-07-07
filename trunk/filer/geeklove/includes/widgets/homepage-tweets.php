<?php
add_action('widgets_init', create_function('', 'return register_widget("stag_wedding_tweets");'));

class stag_wedding_tweets extends WP_Widget{
  function stag_wedding_tweets(){
    $widget_ops = array('classname' => 'wedding-rsvp', 'description' => __('Display back to back tweets from bridegroom and bride.', 'stag'));
    $control_ops = array('width' => 300, 'height' => 350, 'id_base' => 'stag_wedding_tweets');
    $this->WP_Widget('stag_wedding_tweets', __('Homepage: Wedding Couple Tweets', 'stag'), $widget_ops, $control_ops);
  }

  function widget($args, $instance){
    extract($args);

    // VARS FROM WIDGET SETTINGS
    $title = apply_filters('widget_title', $instance['title'] );
    $subtitle = $instance['subtitle'];
    $brg_twitter = $instance['brg_twitter'];
    $br_twitter = $instance['br_twitter'];
    echo $before_widget;

    $id = rand(0,999);
    ?>

    <!-- BEGIN #tweets -->
    <section id="tweets" class="section-block">

        <div class="inner-block">
            <h2 class="section-title"><?php echo $title; ?></h2>
            <?php if($subtitle != '') echo "<h4 class='sub-title'>$subtitle</h4>"; ?>

            <div class="grids">
              <div class="grid-6 tweets">
                <div class="tweet-header">
                  <?php if(stag_get_option('wedding_bride_avatar') != ''): ?>
                    <img src="<?php echo stag_get_option('wedding_bride_avatar'); ?>" alt="" class="avatar-tw">
                  <?php endif; ?>

                  <h4><?php echo stag_get_option('wedding_bride_first_name'); ?></h4><span><a href="//twitter.com/<?php echo $br_twitter; ?>">@<?php echo $br_twitter; ?></a></span>
                </div>
                <script type="text/javascript">
                  Chirp({
                    user: '<?php echo $br_twitter; ?>',
                    max: 3,
                    templates: {
                      base:'<ul class="chirp">{{tweets}}</ul>',
                      tweet: '<li><p>{{html}}</p><time>{{time_ago}}</time></li>'
                    }
                  });
                </script>

                <div class="follow">
                  <a href="//twitter.com/<?php echo $br_twitter; ?>" class="button">Follow</a>
                </div>
              </div>

              <div class="grid-6 tweets">
                <div class="tweet-header">
                  <?php if(stag_get_option('wedding_bridegroom_avatar') != ''): ?>
                    <img src="<?php echo stag_get_option('wedding_bridegroom_avatar'); ?>" alt="" class="avatar-tw">
                  <?php endif; ?>

                  <h4><?php echo stag_get_option('wedding_bridegroom_first_name'); ?></h4><span><a href="//twitter.com/<?php echo $brg_twitter; ?>">@<?php echo $brg_twitter; ?></a></span>
                </div>
                <script type="text/javascript">
                  Chirp({
                    user: '<?php echo $brg_twitter; ?>',
                    max: 3,
                    templates: {
                      base:'<ul class="chirp">{{tweets}}</ul>',
                      tweet: '<li><p>{{html}}</p><time>{{time_ago}}</time></li>'
                    }
                  });
                </script>

                <div class="follow">
                  <a href="//twitter.com/<?php echo $brg_twitter; ?>" class="button">Follow</a>
                </div>
              </div>


            </div>

            <!-- END .inner-block -->
        </div>

        <!-- END #tweets -->
    </section>

    <?php
    echo $after_widget;
  }

  function update($new_instance, $old_instance){
    $instance = $old_instance;

    // STRIP TAGS TO REMOVE HTML
    $instance['title'] = strip_tags($new_instance['title']);
    $instance['subtitle'] = strip_tags($new_instance['subtitle']);
    $instance['brg_twitter'] = strip_tags($new_instance['brg_twitter']);
    $instance['br_twitter'] = strip_tags($new_instance['br_twitter']);

    return $instance;
  }

  function form($instance){
    $defaults = array(
      'title' => 'Tweets Back to Back',
      'subtitle' => '',
      'brg_twitter' => '',
      'br_twitter' => '',
      );

    $instance = wp_parse_args((array) $instance, $defaults);

    /* HERE GOES THE FORM */
    ?>
    <p>
      <span class="description">This widget will use avatar and first name of bride and bridegroom set under Theme Options > <a href="<?php echo admin_url('admin.php?page=stagframework#wedding-settings'); ?>">Wedding Settings</a>.</span>
    </p>
    <p></p>

    <p>
      <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:', 'stag'); ?></label>
      <input type="text" class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" />
    </p>

    <p>
      <label for="<?php echo $this->get_field_id('subtitle'); ?>"><?php _e('Sub Title:', 'stag'); ?></label>
      <input type="text" class="widefat" id="<?php echo $this->get_field_id( 'subtitle' ); ?>" name="<?php echo $this->get_field_name( 'subtitle' ); ?>" value="<?php echo $instance['subtitle']; ?>" />
    </p>

    <p>
      <label for="<?php echo $this->get_field_id('brg_twitter'); ?>"><?php _e('Bridegroom Twitter Username:', 'stag'); ?></label>
      <input type="text" class="widefat" id="<?php echo $this->get_field_id( 'brg_twitter' ); ?>" name="<?php echo $this->get_field_name( 'brg_twitter' ); ?>" value="<?php echo $instance['brg_twitter']; ?>" />
    </p>

    <p>
      <label for="<?php echo $this->get_field_id('br_twitter'); ?>"><?php _e('Bride Twitter Username:', 'stag'); ?></label>
      <input type="text" class="widefat" id="<?php echo $this->get_field_id( 'br_twitter' ); ?>" name="<?php echo $this->get_field_name( 'br_twitter' ); ?>" value="<?php echo $instance['br_twitter']; ?>" />
    </p>

    <?php
  }
}
?>