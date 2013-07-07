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

<?php if(!is_singular()): ?>
<h2 class="entry-title"><a href="<?php the_permalink(); ?>" rel="bookmark" title="<?php printf(__('Permanent Link to %s', 'stag'), get_the_title()); ?>"><?php the_title(); ?></a></h2>
<?php else: ?>

<h2 class="entry-title accent-color"><?php the_title(); ?></h2>

<?php endif; ?>

<div class="entry-content">
  <?php

    if(!is_singular()){
        echo strip_shortcodes(get_the_excerpt());
    }else{
        the_content('Continue Reading', 'stag');
        wp_link_pages(array('before' => '<p><strong>'.__('Pages:', 'stag').'</strong> ', 'after' => '</p>', 'next_or_number' => 'number'));
    }

  ?>
</div>