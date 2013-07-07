<?php
/*
* Template Name: Guestbook
*/
get_header();
?>

<!-- BEGIN .container-wrap -->
<div class="container-wrap">

    <?php get_template_part('helper', 'page-cover'); ?>

    <div id="guestbook-form">
        <div class="inner-block">
            <form action="<?php the_permalink(); ?>" method="post">

                <div class="grids">
                    <div class="grid-12">
                        <label for="guestbook_message">Your Message</label>
                        <input type="text" name="guestbook_message" id="guestbook_message" required>
                    </div>
                </div>

                <div class="grids">
                    <div class="grid-9">
                        <label for="guestbook_name">Your Name</label>
                        <input type="text" name="guestbook_name" id="guestbook_name" required>
                    </div>
                    <div class="grid-3">
                        <label for="guestbook_verify">2+3=</label>
                        <input type="text" name="guestbook_verify" id="guestbook_verify" required>
                    </div>
                </div>


                <?php
                $error = false;
                if(isset($_POST['guestbook_verify'])) {
                  if(isset($_POST['guestbook_message'])){
                    $message = strip_tags(stripslashes($_POST['guestbook_message']));
                  }else{
                    echo '<div class="error-message">Please type your message.</div>';
                    $error = true;
                  }

                  if(isset($_POST['guestbook_name'])){
                    $name = $_POST['guestbook_name'];
                  }else{
                    echo '<div class="error-message">Please enter your name.</div>';
                    $error = true;
                  }

                  if(isset($_POST['guestbook_verify']) && $_POST['guestbook_verify'] === "5"){
                    $verify = true;
                  }else{
                    echo '<div class="error-message">Well, we are sure 2+3 is not equals what you have entered.</div>';
                    $error = true;
                  }

                  if($error === false && $verify === true){
                    $post = array(
                      'post_title' => $name,
                      'post_content' => $message,
                      'post_status' => 'publish',
                      'post_type' => 'the-guestbook'
                    );

                    $post_id = wp_insert_post($post);

                    echo '<div class="thanks">Your message has been added, thanks.</div>';

                  }

                }

                ?>

                <div class="submit">
                    <input type="submit" name="guestbook_add" value="Add Message">
                </div>

            </form>
        </div>
    </div>

    <!-- BEGIN .container -->
    <div class="container guestbook-posts">

        <?php
        $page = (get_query_var('paged')) ? get_query_var('paged') : 1;

        query_posts(array(
            'posts_per_page' => stag_get_option('general_guestbook_count'),
            'post_type' => 'the-guestbook',
            'paged' => $page
        ));

        if(have_posts()): while(have_posts()): the_post();
        ?>

        <article <?php post_class() ?>>
            <h2 class="guestbook-message"><?php echo strip_tags(strip_shortcodes(get_the_content())); ?></h2>
            <h3 class="guestbook-name"><?php the_title(); ?></h3>
        </article>

        <?php
        endwhile;
        ?>
        <?php
            $prev = get_previous_posts_link('<span>' . __('Previous Page', 'stag') . '</span>');
            $next = get_next_posts_link('<span>' . __('Next Page', 'stag') . '</span>');
        ?>

        <?php if($prev || $next): ?>
        <hr class="section-divider" data-icon="&#xe003;">
        <!-- BEGIN .navigation .page-navigation -->
        <div class="navigation page-navigation grids">
            <div class="paged-nav grid-6">
                <?php pagination(); ?>
            </div>
            <div class="left-right-nav grid-6">
                <div class="nav-prev"><?php echo $prev; ?></div>
                <div class="nav-next"><?php echo $next; ?></div>
            </div>
        <!-- END .navigation .page-navigation -->
        </div>
        <?php endif; ?>

        <?php

        else:

            _e('There isn\'t any messsage yet!', 'stag');

        endif;

        wp_reset_query();

        ?>

        <!-- END .container -->
    </div>

    <!-- END .container-wrap -->
</div>

<?php get_footer(); ?>