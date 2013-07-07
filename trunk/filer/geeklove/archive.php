<?php get_header(); ?>
<?php /* Get author data */
    if(get_query_var('author_name')) :
    $curauth = get_userdatabylogin(get_query_var('author_name'));
    else :
    $curauth = get_userdata(get_query_var('author'));
    endif;
?>

<!-- BEGIN .container-wrap -->
<div class="container-wrap">

    <?php if(have_posts()): ?>
    <div class="blog-cover">
        <?php if(stag_get_option('blog_cover_image') != ''): ?>
            <img src="<?php echo stag_get_option('blog_cover_image'); ?>" alt="">
        <?php endif; ?>
        <div class="center blog-title-wrap">
            <div class="blog-title-inner-wrap">
                <h4 class="section-title">Archive</h4>
                <?php $post = $posts[0]; // Hack. Set $post so that the_date() works. ?>
                <?php /* If this is a category archive */ if (is_category()) { ?>
                    <h4 class="sub=title"><?php printf(__('All posts in %s', 'stag'), single_cat_title('',false)); ?></h1>
                <?php /* If this is a tag archive */ } elseif( is_tag() ) { ?>
                    <h4 class="sub=title"><?php printf(__('All posts tagged %s', 'stag'), single_tag_title('',false)); ?></h1>
                <?php /* If this is a daily archive */ } elseif (is_day()) { ?>
                    <h4 class="sub=title"><?php _e('Archive for', 'stag') ?> <?php the_time('F jS, Y'); ?></h1>
                 <?php /* If this is a monthly archive */ } elseif (is_month()) { ?>
                    <h4 class="sub=title"><?php _e('Archive for', 'stag') ?> <?php the_time('F, Y'); ?></h1>
                <?php /* If this is a yearly archive */ } elseif (is_year()) { ?>
                    <h4 class="sub=title"><?php _e('Archive for', 'stag') ?> <?php the_time('Y'); ?></h1>
                <?php /* If this is an author archive */ } elseif (is_author()) { ?>
                    <h4 class="sub=title"><?php _e('All posts by', 'stag') ?> <?php echo $curauth->display_name; ?></h1>
                <?php /* If this is a paged archive */ } elseif (isset($_GET['paged']) && !empty($_GET['paged'])) { ?>
                    <h4 class="sub=title"><?php _e('Blog Archives', 'stag') ?></h1>
                <?php } ?>
            </div>
        </div>
    </div>

    <!-- BEGIN .container -->
    <div class="container">

        <div class="all-posts hfeed archives">
            <?php while(have_posts()): the_post(); ?>

            <article <?php post_class(); ?>>
                <h2 class="entry-title"><a href="<?php the_permalink(); ?>" rel="bookmark" title="<?php printf(__('Permanent Link to %s', 'stag'), get_the_title()); ?>"><?php the_title(); ?></a></h2>
                <div class="archive-meta"><span class="accent-color"><?php the_time('M d Y'); ?></span> <span class="sep">/</span> In Category <?php the_category(', '); ?></div>
            </article>

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

        </div>


        <?php endif; ?>
        <!-- END .container -->
    </div>
    <!-- END .container-wrap -->
</div>

<?php get_footer(); ?>