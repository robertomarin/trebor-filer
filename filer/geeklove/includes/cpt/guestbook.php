<?php

function create_post_type_guestbook(){
  $labels = array(
    'name' => __( 'Guestbook Messages', 'stag'),
    'singular_name' => __( 'Guestbook' , 'stag'),
    'add_new' => _x('Add New', 'stag', 'stag'),
    'add_new_item' => __('Add New Guestbook', 'stag'),
    'edit_item' => __('Edit Guestbook', 'stag'),
    'new_item' => __('New Guestbook', 'stag'),
    'view_item' => __('View Guestbook', 'stag'),
    'search_items' => __('Search Guestbook', 'stag'),
    'not_found' =>  __('No Guestbooks found', 'stag'),
    'not_found_in_trash' => __('No Guestbooks found in Trash', 'stag'),
    'parent_item_colon' => ''
    );

    $args = array(
    'labels' => $labels,
    'public' => true,
    'exclude_from_search' => true,
    'publicly_queryable' => true,
    'rewrite' => array('slug' => __( 'the-guestbook', 'stag' )),
    'show_ui' => true,
    'query_var' => true,
    'capability_type' => 'post',
    'hierarchical' => false,
    'menu_position' => null,
    'has_archive' => false,
    'supports' => array('title', 'editor'),
    'hierarchical' => false,
    'show_in_nav_menus' => false,
    );

    register_post_type(__( 'the-guestbook', 'stag' ),$args);
}


function guestbook_edit_columns($columns){

    $columns = array(
        "cb" => "<input type=\"checkbox\" />",
        "title" => __( 'Name', 'stag' ),
        "date" => __('Date Added', 'stag')
    );

    return $columns;
}

add_action('init', 'create_post_type_guestbook');
add_filter("manage_edit-guestbook_columns", "guestbook_edit_columns");