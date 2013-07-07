<?php
add_action('widgets_init', create_function('', 'return register_widget("stag_wedding_rsvp");'));

class stag_wedding_rsvp extends WP_Widget{
  function stag_wedding_rsvp(){
    $widget_ops = array('classname' => 'wedding-rsvp', 'description' => __('Display RSVP form.', 'stag'));
    $control_ops = array('width' => 300, 'height' => 350, 'id_base' => 'stag_wedding_rsvp');
    $this->WP_Widget('stag_wedding_rsvp', __('Homepage: RSVP Form', 'stag'), $widget_ops, $control_ops);
  }

  function widget($args, $instance){
    extract($args);

    // VARS FROM WIDGET SETTINGS
    $title = apply_filters('widget_title', $instance['title'] );
    $subtitle = $instance['subtitle'];
    echo $before_widget;

    ?>

    <!-- BEGIN #rsvp -->
    <section id="rsvp" class="section-block">

        <div class="inner-block">
            <h2 class="section-title"><?php echo $title; ?></h2>
            <?php if($subtitle != '') echo "<h4 class='sub-title'>$subtitle</h4>"; ?>

            <form method="post" action="#rsvp" id="rsvp-form" class="grids">
            <div class="grid-4">
              <label for="attendee_name"><?php _e('Your Name', 'stag'); ?></label>
              <input type="text" id="attendee_name" name="attendee_name" required>
            </div>

            <div class="grid-4">
              <label for="attendee_count"><?php _e('Number of Guests', 'stag') ?></label>
              <select id="attendee_count" name="attendee_number">
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4</option>
                <option value="5">5</option>
              </select>
            </div>

              <?php
              $all_events = stag_all_wedding_events();
              if(!empty($all_events)){
                echo '<div class="grid-4">';
                echo '<label for="attendee_event">'.__('You will attend...', 'stag').'</label>';
                echo '<select id="attendee_event" name="attendee_event">';
                if(count($all_events) > 1){
                  echo '<option value="all-events">All Events</option>';
                }
                foreach($all_events as $title){
                  echo '<option value="'.stag_to_slug($title).'">'.$title.'</option>';
                }
                echo '</select>';
                echo '</div>';
              }
              ?>

            <?php

            if(isset($_POST['submit_rsvp'])) {
              if(isset($_POST['attendee_name'])){
                $name = $_POST['attendee_name'];
              }else{
                echo 'Please enter your name';
              }

              $post = array(
                'post_title' => $name,
                'post_status' => 'publish',
                'post_type' => 'rsvp'
              );

              $post_id = wp_insert_post($post);

              if($post_id != ''){
                add_post_meta($post_id, '_stag_attendee_number', $_POST['attendee_number']);
                add_post_meta($post_id, '_stag_attendee_event', $_POST['attendee_event']);

                echo '<div class="thanks">Thanks for attending, we will see you at our wedding.</div>';
              }

            }

            ?>

            <div class="submit">
              <input type="submit" value="I Am Attending" name="submit_rsvp" />
              <input type="hidden" name="action" value="post" />
              <?php wp_nonce_field( 'new-post' ); ?>
            </div>

            </form>

            <!-- END .inner-block -->

        </div>

        <!-- END #rsvp -->
    </section>

    <?php
    echo $after_widget;
  }

  function update($new_instance, $old_instance){
    $instance = $old_instance;

    // STRIP TAGS TO REMOVE HTML
    $instance['title'] = strip_tags($new_instance['title']);
    $instance['subtitle'] = strip_tags($new_instance['subtitle']);

    return $instance;
  }

  function form($instance){
    $defaults = array(
      'title' => 'Are you attending? RSVP here!',
      'subtitle' => 'Please select the options below and click the button in order to RSVP!',
      );

    $instance = wp_parse_args((array) $instance, $defaults);

    /* HERE GOES THE FORM */
    ?>

    <p>
      <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:', 'stag'); ?></label>
      <input type="text" class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" />
    </p>

    <p>
      <label for="<?php echo $this->get_field_id('subtitle'); ?>"><?php _e('Sub Title:', 'stag'); ?></label>
      <input type="text" class="widefat" id="<?php echo $this->get_field_id( 'subtitle' ); ?>" name="<?php echo $this->get_field_name( 'subtitle' ); ?>" value="<?php echo $instance['subtitle']; ?>" />
    </p>

    <?php
  }
}
?>