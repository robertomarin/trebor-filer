<?php
add_action('add_meta_boxes', 'stag_metabox_gallery');

function stag_metabox_gallery(){
  $meta_box = array(
    'id' => 'stag_metabox_gallery',
    'title' => __('Gallery', 'stag'),
    'description' => __('Upload images for this gallery', 'stag'),
    'page' => 'page',
    'context' => 'normal',
    'priority' => 'high',
    'fields' => array(
        array(
            'name' => __('Gallery Pics', 'stag'),
            'desc' => __('Choose bulk images for gallery.', 'stag'),
            'id' => '_stag_gallery_pics',
            'type' => 'file',
            'std' => '',
            'title' => 'Upload Images',
            'multiple' => 'true',
        ),
      )
    );

    $meta_box['page'] = 'gallery';
    stag_add_meta_box($meta_box);
}