<?php

function create_post_type_rsvp(){
  $labels = array(
    'name' => __( 'Attendees', 'stag'),
    'singular_name' => __( 'RSVP' , 'stag'),
    'add_new' => _x('Add New', 'stag', 'stag'),
    'add_new_item' => __('Add New RSVP', 'stag'),
    'edit_item' => __('Edit RSVP', 'stag'),
    'new_item' => __('New RSVP', 'stag'),
    'view_item' => __('View RSVP', 'stag'),
    'search_items' => __('Search RSVP', 'stag'),
    'not_found' =>  __('No RSVPs found', 'stag'),
    'not_found_in_trash' => __('No RSVPs found in Trash', 'stag'),
    'parent_item_colon' => ''
    );

    $args = array(
    'labels' => $labels,
    'public' => true,
    'exclude_from_search' => true,
    'publicly_queryable' => true,
    'rewrite' => array('slug' => __( 'rsvp', 'stag' )),
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

    register_post_type(__( 'rsvp', 'stag' ),$args);
}


function rsvp_edit_columns($columns){

    $columns = array(
        "cb" => "<input type=\"checkbox\" />",
        "title" => __( 'RSVP Title', 'stag' ),
        "attendee_number" => __( 'Number of Attendees', 'stag' ),
        "attendee_event" => __( 'Event Attending', 'stag' ),
        "date" => __('Date Added', 'stag')
    );

    return $columns;
}

function rsvp_custom_columns($column){
    global $post;
    switch ($column){
        case __( 'attendee_number', 'stag' ):
        echo get_post_meta(get_the_ID(), '_stag_attendee_number', true);
        break;
        case __( 'attendee_event', 'stag' ):
        echo ucwords(str_replace('-', ' ', get_post_meta(get_the_ID(), '_stag_attendee_event', true)));
        break;
    }
}

add_action('init', 'create_post_type_rsvp');
add_filter("manage_edit-rsvp_columns", "rsvp_edit_columns");
add_action("manage_posts_custom_column",  "rsvp_custom_columns");