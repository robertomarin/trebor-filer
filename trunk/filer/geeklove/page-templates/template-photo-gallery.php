<?php
/*
Template Name: Photo Gallery
*/
?>
<?php get_header(); ?>

<!-- BEGIN .container-wrap -->
<div class="container-wrap">

    <?php get_template_part('helper', 'page-cover'); ?>

    <!-- BEGIN .container -->
    <div class="container">

        <!-- BEGIN #photo-gallery -->
        <div id="photo-gallery">

            <!-- BEGIN #filters -->
            <ul id="filters">
                <li><a href="#" data-filter="*" class="active button">All Photos</a></li>
                <?php
                $c = get_categories('taxonomy=photo-type&type=gallery&hide_empty=1');
                foreach($c as $cat){
                    echo '<li><a class="button" href="#" data-filter=".'.$cat->slug.'">'.$cat->name.'</a></li>';
                }
                ?>
                <!-- END #filters -->
            </ul>
            <div id="photo-list" class="clearfix">
                <?php
                $page = (get_query_var('paged')) ? get_query_var('paged') : 1;
                query_posts(array(
                    'post_type' => 'gallery',
                    'paged' => $page
                ));
                $all_photos = '';

                if(have_posts()): while(have_posts()): the_post();

                if(get_post_meta(get_the_ID(), '_stag_gallery_pics', true) != ''){
                  $pics = get_post_meta(get_the_ID(), '_stag_gallery_pics', true);
                  $pics = explode(",", $pics);

                $terms = get_the_terms( get_the_ID(), 'photo-type' );
                if ( $terms && ! is_wp_error( $terms ) ) :
                    $links = array();
                    foreach ( $terms as $term ){
                        $links[] = $term->slug;
                    }
                    $tax = join( " ", $links );
                else :
                    $tax = '';
                endif;
                  foreach($pics as $pic){
                    $picid = get_attachment_id_from_src($pic);
                    $p = get_post($picid);
                    if(is_mobile()){
                      echo '<div class="ipad-6 photo '.$tax.'"><a title="'.$p->post_excerpt.'" rel="lightbox[photos]"><img src="'.$pic.'" alt=""></a></div>';
                    }else{
                      echo '<div class="ipad-6 photo '.$tax.'"><a title="'.$p->post_excerpt.'" href="'.$pic.'" rel="lightbox[photos]"><img src="'.$pic.'" alt=""></a></div>';
                    }
                  }
                }
            ?>

            <?php endwhile; ?>

                    <!-- END #photo-list -->
                </div>

                <!-- END #photo-gallery -->
            </div>

            <hr class="section-divider" data-icon="&#xe003;">

            <?php
                $prev = get_previous_posts_link('<span>' . __('Previous Page', 'stag') . '</span>');
                $next = get_next_posts_link('<span>' . __('Next Page', 'stag') . '</span>');
            ?>
            <?php if($prev || $next): ?>
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
            <?php endif ?>

            <?php endif; ?>

            <?php wp_reset_query(); ?>


        <!-- END .container -->
    </div>
    <!-- END .container-wrap -->
</div>

<?php get_footer(); ?>