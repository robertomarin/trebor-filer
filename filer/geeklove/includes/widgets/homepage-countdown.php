<?php
add_action('widgets_init', create_function('', 'return register_widget("stag_wedding_countdown");'));

class stag_wedding_countdown extends WP_Widget{
  function stag_wedding_countdown(){
    $widget_ops = array('classname' => 'wedding-countdown', 'description' => __('Display wedding countdown.', 'stag'));
    $control_ops = array('width' => 300, 'height' => 350, 'id_base' => 'stag_wedding_countdown');
    $this->WP_Widget('stag_wedding_countdown', __('Homepage: Wedding Countdown', 'stag'), $widget_ops, $control_ops);
  }

  function widget($args, $instance){
    extract($args);

    // VARS FROM WIDGET SETTINGS

    echo $before_widget;

    ?>

    <section class="inner-block" id="countdown">
        <!-- BEGIN #countdown -->
        <div id="the_countdown"></div>
        <?php

        $timezone = get_option('gmt_offset');
        if(!startsWith($timezone, '-')){
            $timezone = '+'.$timezone;
        }

        $time = str_replace(':', ',', stag_get_option('wedding_time'));

         ?>
        <script>
        jQuery(document).ready(function($){
            $('#the_countdown').countdown({
                until: new Date(<?php echo stag_wedding_date('Y') ?>, <?php echo stag_wedding_date('m') ?> - 1, <?php echo stag_wedding_date('d') ?>, <?php echo $time; ?>),
                timezone: <?php echo $timezone ?>
            });
        });
        </script>
    </section>

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
      <span class="description"><?php _e('Yay! No Options to set!', 'stag'); ?></span>
    </p>

    <?php
  }
}
?>