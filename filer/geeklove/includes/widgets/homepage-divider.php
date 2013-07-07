<?php
add_action('widgets_init', create_function('', 'return register_widget("stag_wedding_divider");'));

class stag_wedding_divider extends WP_Widget{
  function stag_wedding_divider(){
    $widget_ops = array('classname' => 'wedding-divider', 'description' => __('Separate homepage sections with this horizontal divider.', 'stag'));
    $control_ops = array('width' => 300, 'height' => 350, 'id_base' => 'stag_wedding_divider');
    $this->WP_Widget('stag_wedding_divider', __('Homepage: Section Divider', 'stag'), $widget_ops, $control_ops);
  }

  function widget($args, $instance){
    extract($args);

    // VARS FROM WIDGET SETTINGS

    echo $before_widget;

    ?>

    <!-- BEGIN .section-divider -->
    <hr class="section-divider" data-icon="&#xe003;">
    <!-- END .section-divider -->

    <?php
    echo $after_widget;
  }

  function update($new_instance, $old_instance){
    $instance = $old_instance;

    // STRIP TAGS TO REMOVE HTML

    return $instance;
  }

  function form($instance){
    $defaults = array(

      );

    $instance = wp_parse_args((array) $instance, $defaults);

    /* HERE GOES THE FORM */
    ?>

    <p>
      <span class="description"><?php _e('Yay! No options to set!', 'stag'); ?></span>
    </p>

    <?php
  }
}
?>