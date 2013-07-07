<?php get_header(); ?>

<div class="container-wrap">
    <div class="container">
        <?php if (have_posts()) : while (have_posts()) : the_post(); ?>

        <div class='hfeed'>
            <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                <?php get_template_part('content', 'standard'); ?>
            </article>
        </div>
        <?php endwhile; ?>

        <hr class="section-divider" data-icon="&#xe003;">

        <!--BEGIN .navigation .page-navigation -->
        <div class="navigation page-navigation grids">
            <?php if(has_tag()): ?>
            <div class="post-tags grid-6" data-icon="&#xe000;">
                <?php the_tags('<span>Post Tags: </span>'); ?>
            </div>
            <?php else: ?>
            <div class="post-tags grid-6"></div>
            <?php endif; ?>
            <div class="left-right-nav grid-6">
                <div class="nav-prev"><?php previous_post_link('%link', 'Previous Post') ?></div>
                <div class="nav-next"><?php next_post_link('%link', 'Next Post') ?></div>
            </div>
        <!--END .navigation .page-navigation -->
        </div>

    </div>
</div>

    <?php

    if($post->post_type === 'post'){
        comments_template('', true);
    }

    ?>

    <?php endif; ?>

<?php get_footer() ?>