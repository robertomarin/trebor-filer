<?php

function create_post_type_events(){
  $labels = array(
    'name' => __( 'Events', 'stag'),
    'singular_name' => __( 'Events' , 'stag'),
    'add_new' => _x('Add New', 'stag', 'stag'),
    'add_new_item' => __('Add New Events', 'stag'),
    'edit_item' => __('Edit Events', 'stag'),
    'new_item' => __('New Events', 'stag'),
    'view_item' => __('View Events', 'stag'),
    'search_items' => __('Search Events', 'stag'),
    'not_found' =>  __('No events found', 'stag'),
    'not_found_in_trash' => __('No events found in Trash', 'stag'),
    'parent_item_colon' => ''
    );

    $args = array(
    'labels' => $labels,
    'public' => true,
    'exclude_from_search' => true,
    'publicly_queryable' => true,
    'rewrite' => array('slug' => __( 'events', 'stag' )),
    'show_ui' => true,
    'query_var' => true,
    'capability_type' => 'post',
    'hierarchical' => false,
    'menu_position' => null,
    'has_archive' => true,
    'supports' => array('title', 'editor'),
    'hierarchical' => false,
    );

    register_post_type(__( 'events', 'stag' ),$args);
}

function event_edit_columns($columns){

    $columns = array(
        "cb" => "<input type=\"checkbox\" />",
        "title" => __( 'Event Title', 'stag' ),
        "event_date" => __( 'Event Date', 'stag' ),
        "time" => __( 'Event Time', 'stag' ),
        "date" => __('Date Added', 'stag')
    );

    return $columns;
}

function event_custom_columns($column){
    global $post;
    switch ($column){
        case __( 'time', 'stag' ):
        echo get_post_meta(get_the_ID(), '_stag_event_time', true);
        break;
        case __( 'event_date', 'stag' ):
        echo get_post_meta(get_the_ID(), '_stag_event_date', true);
        break;
    }
}

add_action('init', 'create_post_type_events');
add_filter("manage_edit-events_columns", "event_edit_columns");
add_action("manage_posts_custom_column",  "event_custom_columns");