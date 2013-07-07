<?php get_header(); ?>

        <div class="container-wrap">
            <div class="blog-cover">
                <?php if(stag_get_option('blog_cover_image') != ''): ?>
                    <img src="<?php echo stag_get_option('blog_cover_image'); ?>" alt="">
                <?php endif; ?>
                <?php if(stag_get_option('blog_title') != '' && stag_get_option('blog_subtitle') != ''): ?>
                <div class="center blog-title-wrap">
                    <div class="blog-title-inner-wrap">
                        <?php if(stag_get_option('blog_title') != '') echo '<h4 class="section-title">'.stag_get_option('blog_title').'</h4>'; ?>
                        <?php if(stag_get_option('blog_subtitle') != '') echo '<h4 class="sub-title">'.stag_get_option('blog_subtitle').'</h4>'; ?>
                    </div>
                </div>
                <?php endif; ?>
            </div>

            <!-- BEGIN .container -->
            <div class="container">

            <div class="all-posts hfeed">

                <?php if (have_posts()) : while (have_posts()) : the_post(); ?>

                    <?php stag_post_before(); ?>

                    <article <?php post_class(); ?> id="post-<?php the_ID(); ?>">
                    <?php stag_post_start(); ?>

                    <?php get_template_part('content', 'standard'); ?>

                    <?php stag_post_end(); ?>
                    </article>
                    <?php stag_post_after(); ?>

                    <?php endwhile; ?>

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

                    <?php else: ?>

                    <!--BEGIN #post-0-->
                    <div id="post-0" <?php post_class(); ?>>

                        <h2 class="entry-title"><?php _e('Error 404 - Not Found', 'stag') ?></h2>

                        <!--BEGIN .entry-content-->
                        <div class="entry-content">
                            <p><?php _e("Sorry, but you are looking for something that isn't here.", "stag") ?></p>
                        <!--END .entry-content-->
                        </div>

                    <!--END #post-0-->
                    </div>

                    <?php endif; ?>
            </div>
                <!-- END .container -->
            </div>
        </div>

<?php get_footer(); ?>