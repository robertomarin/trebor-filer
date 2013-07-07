<?php

function create_post_type_gallery(){
  $labels = array(
    'name' => __( 'Gallery', 'stag'),
    'singular_name' => __( 'Gallery' , 'stag'),
    'add_new' => _x('Add New', 'stag', 'stag'),
    'add_new_item' => __('Add New Gallery', 'stag'),
    'edit_item' => __('Edit Gallery', 'stag'),
    'new_item' => __('New Gallery', 'stag'),
    'view_item' => __('View Gallery', 'stag'),
    'search_items' => __('Search Gallery', 'stag'),
    'not_found' =>  __('No galleries found', 'stag'),
    'not_found_in_trash' => __('No galleries found in Trash', 'stag'),
    'parent_item_colon' => ''
    );

    $args = array(
    'labels' => $labels,
    'public' => true,
    'exclude_from_search' => true,
    'publicly_queryable' => true,
    'rewrite' => array('slug' => __( 'gallery', 'stag' )),
    'show_ui' => true,
    'query_var' => true,
    'capability_type' => 'post',
    'hierarchical' => false,
    'menu_position' => null,
    'has_archive' => false,
    'supports' => array('title'),
    'hierarchical' => false,
    'show_in_nav_menus' => false,
    );

    register_post_type(__( 'gallery', 'stag' ),$args);
}

function gallery_build_taxonomies(){
  register_taxonomy(__( "photo-type", 'stag' ), array(__( "gallery", 'stag' )), array("hierarchical" => true, "label" => __( "Categories", 'stag' ), "singular_label" => __( "Categories", 'stag' ), "rewrite" => array('slug' => 'photo-type', 'hierarchical' => true)));
}

function gallery_edit_columns($columns){

    $columns = array(
        "cb" => "<input type=\"checkbox\" />",
        "title" => __( 'Gallery Title', 'stag' ),
        "date" => __('Date Added', 'stag')
    );

    return $columns;
}

add_action('init', 'create_post_type_gallery');
add_action('init', 'gallery_build_taxonomies', 0);
add_filter("manage_edit-gallery_columns", "gallery_edit_columns");