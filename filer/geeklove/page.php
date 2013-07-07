<?php get_header(); ?>

<!-- BEGIN .container-wrap -->
<div class="container-wrap">

    <?php get_template_part('helper', 'page-cover'); ?>

    <?php if (have_posts()) : while (have_posts()) : the_post(); ?>

    <div class='container hfeed'>

        <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

            <!-- <h2 class="entry-title"><?php the_title(); ?></h2> -->

            <div class="entry-content clearfix">
                <?php the_content(); ?>
            </div>

        </article>
    </div>

    <?php endwhile; ?>

    <?php endif; ?>
    <!-- END .container-wrap -->
</div>

<?php get_footer() ?>