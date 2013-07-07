<?php
add_action('add_meta_boxes', 'stag_metabox_rsvp');

function stag_metabox_rsvp(){
  $meta_box = array(
    'id' => 'stag_metabox_rsvp',
    'title' => __('RSVP Information', 'stag'),
    'description' => __('Attendee Information', 'stag'),
    'page' => 'page',
    'context' => 'normal',
    'priority' => 'high',
    'fields' => array(
        array(
            'name' => __('Attendee Number', 'stag'),
            'desc' => __('How many people are attending the event?', 'stag'),
            'id' => '_stag_attendee_number',
            'type' => 'text',
            'std' => '',
        ),
        array(
            'name' => __('Event Attending', 'stag'),
            'desc' => __('Which event attending?', 'stag'),
            'id' => '_stag_attendee_event',
            'type' => 'text',
            'std' => '',
        ),
      )
    );

    $meta_box['page'] = 'rsvp';
    stag_add_meta_box($meta_box);
}