<?php $cover = get_post_meta(get_the_ID(), '_stag_page_cover', true); ?>
<div class="blog-cover <?php if($cover === '') echo 'no-cover'; ?>">
    <?php if($cover != ''): ?>
        <img src="<?php echo $cover; ?>" alt="">
    <?php endif; ?>
    <div class="center blog-title-wrap">
        <div class="blog-title-inner-wrap">
            <h2 class="section-title"><?php the_title(); ?></h2>
            <?php if(get_post_meta(get_the_ID(), '_stag_page_subtitle', true) != '') echo '<h4 class="sub-title">'.get_post_meta(get_the_ID(), '_stag_page_subtitle', true).'</h4>'; ?>
        </div>
    </div>
</div>