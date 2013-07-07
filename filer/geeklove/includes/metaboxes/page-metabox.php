<?php
add_action('add_meta_boxes', 'stag_metabox_page');

function stag_metabox_page(){
  $meta_box = array(
    'id' => 'stag_metabox_page',
    'title' => __('Page Settings', 'stag'),
    'description' => __('Add a subtitle and page cover.', 'stag'),
    'page' => 'post',
    'context' => 'normal',
    'priority' => 'high',
    'fields' => array(
        array(
            'name' => __('Page Sub Title', 'stag'),
            'desc' => __('Enter the sub title for the page.', 'stag'),
            'id' => '_stag_page_subtitle',
            'type' => 'text',
            'std' => ''
        ),
        array(
            'name' => __('Page Cover', 'stag'),
            'desc' => __('Choose a background cover for this page, ideal size 1260px x 260px.', 'stag'),
            'id' => '_stag_page_cover',
            'type' => 'file',
            'std' => ''
        ),
      )
    );
    $meta_box['page'] = 'page';
    stag_add_meta_box($meta_box);
}