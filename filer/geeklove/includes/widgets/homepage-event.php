<?php
add_action('widgets_init', create_function('', 'return register_widget("stag_wedding_event");'));

class stag_wedding_event extends WP_Widget{
  function stag_wedding_event(){
    $widget_ops = array('classname' => 'wedding-event', 'description' => __('Display wedding event details on homepage.', 'stag'));
    $control_ops = array('width' => 300, 'height' => 350, 'id_base' => 'stag_wedding_event');
    $this->WP_Widget('stag_wedding_event', __('Homepage: Wedding Event', 'stag'), $widget_ops, $control_ops);
  }

  function widget($args, $instance){
    extract($args);

    // VARS FROM WIDGET SETTINGS
    $title = apply_filters('widget_title', $instance['title'] );
    $welcomeText = $instance['welcomeText'];
    echo $before_widget;

    ?>

    <!-- BEGIN #event -->
    <section id="event" class="section-block">

        <div class="inner-block">
            <h2 class="section-title"><?php echo $title; ?></h2>
            <h4 class="sub-title"><?php if(function_exists('stag_wedding_date')) echo stag_full_wedding_date(); ?></h4>

            <?php if($welcomeText != '') echo "<p class='welcome-text'>$welcomeText</p>"; ?>

            <div class="all-events grids">
                <?php

                $q = new WP_Query('post_type=events&posts_per_page=6');
                if($q->have_posts()){
                    while($q->have_posts()): $q->the_post();
                    ?>
                    <div class="event grid-6">
                        <?php if(get_post_meta(get_the_ID(), '_stag_event_featured_image', true) != ''): ?>
                        <img class="wedding-cover" src="<?php echo get_post_meta(get_the_ID(), '_stag_event_featured_image', true); ?>" alt="<?php the_title(); ?>">
                        <?php endif; ?>
                      <div class="event-details accent-background">
                        <h3><?php echo the_title(); ?></h3>
                          <div class="event-time">
                            <?php if(get_post_meta(get_the_ID(), '_stag_event_date', true) != ''): ?>
                              <span class="the-block"><i class="icon icon-event_date"></i><span><?php echo stag_full_date(get_post_meta(get_the_ID(), '_stag_event_date', true)); ?></span></span>
                            <?php endif; ?>
                            <?php if(get_post_meta(get_the_ID(), '_stag_event_time', true) != ''): ?>
                              <span class="the-block"><i class="icon icon-event_time"></i><span><?php echo get_post_meta(get_the_ID(), '_stag_event_time', true); ?></span></span>
                            <?php endif; ?>
                          </div>
                      </div>
                      <a class="button" href="<?php the_permalink(); ?>" rel="bookmark" title="<?php printf(__('Permanent Link to %s', 'stag'), get_the_title()); ?>">Learn More</a>
                    </div>
                    <?php
                    endwhile;
                    wp_reset_postdata();
                }

                ?>
            </div>

            <!-- END .inner-block -->
        </div>

        <!-- END #event -->
    </section>

    <?php
    echo $after_widget;
  }

  function update($new_instance, $old_instance){
    $instance = $old_instance;

    // STRIP TAGS TO REMOVE HTML
    $instance['title'] = strip_tags($new_instance['title']);
    $instance['welcomeText'] = strip_tags($new_instance['welcomeText']);

    return $instance;
  }

  function form($instance){
    $defaults = array(
      'title' => 'The Wedding Event',
      'welcomeText' => '',
      );

    $instance = wp_parse_args((array) $instance, $defaults);

    /* HERE GOES THE FORM */
    ?>

    <p>
      <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:', 'stag'); ?></label>
      <input type="text" class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" />
    </p>

    <p>
      <label for="<?php echo $this->get_field_id('welcomeText'); ?>"><?php _e('Welcome Text:', 'stag'); ?></label>
      <textarea rows="5" class="widefat" id="<?php echo $this->get_field_id( 'welcomeText' ); ?>" name="<?php echo $this->get_field_name( 'welcomeText' ); ?>"><?php echo $instance['welcomeText']; ?></textarea>
    </p>

    <?php
  }
}
?>