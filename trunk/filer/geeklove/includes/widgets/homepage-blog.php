<?php
add_action('widgets_init', create_function('', 'return register_widget("stag_recent_post");'));

class stag_recent_post extends WP_Widget{
  function stag_recent_post(){
    $widget_ops = array('classname' => 'stag-recent-post', 'description' => __('Display a recent post from blog.', 'stag'));
    $control_ops = array('width' => 300, 'height' => 350, 'id_base' => 'stag_recent_post');
    $this->WP_Widget('stag_recent_post', __('Homepage: Blog', 'stag'), $widget_ops, $control_ops);
  }

  function widget($args, $instance){
    extract($args);

    // VARS FROM WIDGET SETTINGS
    $title = apply_filters('widget_title', $instance['title'] );
    $subtitle = $instance['subtitle'];
    $count = $instance['count'];
    echo $before_widget;

    ?>

    <!-- BEGIN #blog -->
    <section id="blog" class="section-block">

        <div class="inner-block">
            <h2 class="section-title"><?php echo $title; ?></h2>
            <?php if($subtitle != ''){
              echo "<h4 class='sub-title'>$subtitle</h4>";
            } ?>
            <div class="all-posts">
            <?php

            query_posts(array(
              'posts_per_page'  =>  $count,
            ));

            if(have_posts()): while(have_posts()): the_post();
            ?>

            <article id="post-<?php echo get_the_ID(); ?>" <?php post_class(); ?>>

              <?php if(has_post_thumbnail()){
                echo '<div class="post-thumb">';
                echo the_post_thumbnail('full');
                echo '</div>';
              } ?>

              <div class="entry-meta entry-header grids">
                <span class="grid-3 author"><i class="icon icon-author"></i><span>Posted By </span><?php the_author_posts_link(); ?></span>
                <span class="grid-3 category"><i class="icon icon-categories"></i><span>In Category </span><?php the_category(', '); ?></span>
                <span class="grid-3 date"><i class="icon icon-date"></i><span><?php the_time('M d Y'); ?></span></span>
                <span class="grid-3 comments"><i class="icon icon-comments"></i><span><?php comments_number(__('0 Comments', 'stag'), __('1 Comment', 'stag'), __('% Comments', 'stag')); ?></span></span>
              </div>

              <h2 class="entry-title"><a href="<?php the_permalink(); ?>" rel="bookmark" title="<?php printf(__('Permanent Link to %s', 'stag'), get_the_title()); ?>"><?php the_title(); ?></a></h2>
              <div class="entry-content">
                <?php the_excerpt(); ?>
              </div>
            </article>

            <?php
            endwhile;
            ?>
            </div>
            <div class="center">
              <a href="<?php echo ( get_option( 'show_on_front' ) == 'page' ) ? get_permalink( get_option('page_for_posts' ) ) : home_url(); ?>" class="button accent-background">Go to Blog</a>
            </div>
            <?php
            endif;
            wp_reset_query();

            ?>

            <!-- END .inner-block -->
        </div>

        <!-- END #blog -->
    </section>

    <?php
    echo $after_widget;
  }

  function update($new_instance, $old_instance){
    $instance = $old_instance;

    // STRIP TAGS TO REMOVE HTML
    $instance['title'] = strip_tags($new_instance['title']);
    $instance['subtitle'] = strip_tags($new_instance['subtitle']);
    $instance['count'] = strip_tags($new_instance['count']);

    return $instance;
  }

  function form($instance){
    $defaults = array(
      'title' => 'From the Blog',
      'subtitle' => 'Present ideas, Stories, and latest updates for the Wedding.',
      'count' => 1,
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

    <p>
      <label for="<?php echo $this->get_field_id('count'); ?>"><?php _e('Post Count:', 'stag'); ?></label>
      <input type="text" class="widefat" id="<?php echo $this->get_field_id( 'count' ); ?>" name="<?php echo $this->get_field_name( 'count' ); ?>" value="<?php echo $instance['count']; ?>" />
    </p>

    <?php
  }
}
?>