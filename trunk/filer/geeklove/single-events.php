<?php get_header(); ?>

<div class="container-wrap">

    <div class="blog-cover">
        <?php if(get_post_meta(get_the_ID(), '_stag_event_cover', true) != ''): ?>
            <img src="<?php echo get_post_meta(get_the_ID(), '_stag_event_cover', true); ?>" alt="">
        <?php endif; ?>
        <div class="center blog-title-wrap">
            <div class="blog-title-inner-wrap">
                <h2 class="section-title"><?php the_title(); ?></h2>
                <?php if(get_post_meta(get_the_ID(), '_stag_event_subtitle', true) != '') echo '<h4 class="sub-title">'.get_post_meta(get_the_ID(), '_stag_event_subtitle', true).'</h4>'; ?>
            </div>
        </div>
    </div>

        <div class="container">
        <?php if (have_posts()) : while (have_posts()) : the_post(); ?>

            <div class="all-posts">
                <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                    <?php if(get_post_meta(get_the_ID(), '_stag_event_map_url', true) != ''): ?>
                    <iframe width="100%" height="350" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="<?php echo get_post_meta(get_the_ID(), '_stag_event_map_url', true); ?>&amp;output=embed"></iframe>
                    <?php endif; ?>

                    <!-- BEGIN .entry-content -->
                    <div class="entry-content">
                        <div class="post-metas pull-right">
                            <?php if(get_post_meta(get_the_ID(), '_stag_event_location', true) != ''):  ?>
                            <div class="meta-data">
                                <h3 data-icon="&#xe00a;">Location:</h3>
                                <p><?php echo nl2br(get_post_meta(get_the_ID(), '_stag_event_location', true)); ?></p>
                            </div>
                            <?php endif; ?>

                            <?php if(get_post_meta(get_the_ID(), '_stag_event_date', true) != ''):  ?>
                            <div class="meta-data">
                                <h3 data-icon="&#xe00d;">Date:</h3>
                                <p>
                                <?php
                                    $date = get_post_meta(get_the_ID(), '_stag_event_date', true);
                                    echo date('l', strtotime($date)).' ';
                                    echo date('d', strtotime($date)).' ';
                                    echo date('F', strtotime($date)).' ';
                                    echo date('Y', strtotime($date));
                                ?>
                                </p>
                            </div>
                            <?php endif; ?>

                            <?php if(get_post_meta(get_the_ID(), '_stag_event_time', true) != ''):  ?>
                            <div class="meta-data">
                                <h3 data-icon="&#xe00c;">Time:</h3>
                                <p><?php echo get_post_meta(get_the_ID(), '_stag_event_time', true); ?></p>
                            </div>
                            <?php endif; ?>

                        </div>
                        <?php the_content('Continue Reading', 'stag'); ?>
                        <!-- END .entry-content -->
                    </div>
                </article>
            </div>
        <?php endwhile; ?>

        <hr class="section-divider" data-icon="&#xe003;">

        <?php if(get_post_meta(get_the_ID(), '_stag_event_link', true)): ?>
            <div class="center">
                <a href="<?php echo get_post_meta(get_the_ID(), '_stag_event_link', true); ?>" class="button stag-button large"><?php echo get_post_meta(get_the_ID(), '_stag_event_link_title', true) ?></a>
            </div>
        <?php endif; ?>

        </div>

    <?php endif; ?>
</div>

<?php get_footer() ?>