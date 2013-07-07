<?php
add_action('widgets_init', create_function('', 'return register_widget("stag_wedding_intro");'));

class stag_wedding_intro extends WP_Widget{
  function stag_wedding_intro(){
    $widget_ops = array('classname' => 'wedding-intro', 'description' => __('Display wedding intro on homepage.', 'stag'));
    $control_ops = array('width' => 300, 'height' => 350, 'id_base' => 'stag_wedding_intro');
    $this->WP_Widget('stag_wedding_intro', __('Homepage: Wedding Intro', 'stag'), $widget_ops, $control_ops);
  }

  function widget($args, $instance){
    extract($args);

    // VARS FROM WIDGET SETTINGS
    $title = apply_filters('widget_title', $instance['title'] );
    echo $before_widget;

    ?>

    <!-- BEGIN #intro -->
    <section id="intro">
        <?php

        $slide_imgs = stag_get_option('wedding_slideshow');

        $class = '';

        // Break the values and wrap them in double quotes to make it work with backstretch
        if($slide_imgs != ''){
            $paths = array();
            foreach(explode(',', $slide_imgs) as $src){
                $paths[] = '"'.$src.'"';
            }
            $path = implode(',', $paths);
        ?>
        <script>
        jQuery(document).ready(function($){
            $('#intro .wedding-couple-wrap').backstretch([<?php echo $path; ?>], {duration: <?php echo stag_get_option('wedding_slideshow_duration') ?>, fade: <?php echo stag_get_option('wedding_fade_duration') ?>});
        });
        </script>

        <?php
        }else{
            $class = " no-cover";
        }

        ?>
        <div class="wedding-couple-wrap<?php echo $class; ?>">

            <div class="wedding-couple-info">

                <div class="person-info">
                    <div class="info-header clearfix">
                        <?php

                        $br_first_name  = stag_get_option('wedding_bride_first_name');
                        $br_last_name   = stag_get_option('wedding_bride_last_name');
                        $br_avatar   = stag_get_option('wedding_bride_avatar');
                        $br_bio   = stag_get_option('wedding_bride_bio');

                        if($br_avatar != '')        echo "<img src='$br_avatar' class='person-avatar' alt='$br_first_name'>";
                        if($br_first_name != '')    echo "<h2>$br_first_name</h2>";
                        if($br_last_name != '')     echo "<p>$br_last_name</p>";

                        ?>
                    </div>
                    <?php if($br_bio != '') echo "<p class='person-bio'>$br_bio</p>"; ?>
                </div>

                <div class="person-info">
                    <div class="info-header clearfix">
                        <?php

                        $brg_first_name = stag_get_option('wedding_bridegroom_first_name');
                        $brg_last_name  = stag_get_option('wedding_bridegroom_last_name');
                        $brg_avatar   = stag_get_option('wedding_bridegroom_avatar');
                        $brg_bio   = stag_get_option('wedding_bridegroom_bio');

                        if($brg_avatar != '')           echo "<img src='$brg_avatar' class='person-avatar' alt='$brg_first_name'>";
                        if($brg_first_name  != '')      echo "<h2>$brg_first_name</h2>";
                        if($brg_last_name   != '')      echo "<p>$brg_last_name</p>";

                        ?>
                    </div>
                    <?php if($brg_bio != '') echo "<p class='person-bio'>$brg_bio</p>"; ?>
                </div>

            </div>

            <!-- END .wedding-couple-wrap -->
        </div>

        <h2 class="news"><?php echo $title; ?></h2>
        <h3 class='accent-color'><?php echo stag_full_wedding_date(); ?></h3>

        <!-- END #intro -->
    </section>

    <?php
    echo $after_widget;
  }

  function update($new_instance, $old_instance){
    $instance = $old_instance;

    // STRIP TAGS TO REMOVE HTML
    $instance['title'] = strip_tags($new_instance['title']);

    return $instance;
  }

  function form($instance){
    $defaults = array(
      'title' => 'Are Getting Married!',
      );

    $instance = wp_parse_args((array) $instance, $defaults);

    /* HERE GOES THE FORM */
    ?>

    <p>
      <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:', 'stag'); ?></label>
      <input type="text" class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" />
    </p>

    <?php
  }
}
?>