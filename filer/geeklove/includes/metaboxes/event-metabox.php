<?php
add_action('add_meta_boxes', 'stag_metabox_events');

function stag_metabox_events(){
  $meta_box = array(
    'id' => 'stag_metabox_events',
    'title' => __('Event Settings', 'stag'),
    'description' => __('Edit your event date, time, location and featured images', 'stag'),
    'page' => 'post',
    'context' => 'normal',
    'priority' => 'high',
    'fields' => array(
        array(
            'name' => __('Event Page Sub Title', 'stag'),
            'desc' => __('Enter the sub title for the event, used to display on single post.', 'stag'),
            'id' => '_stag_event_subtitle',
            'type' => 'text',
            'std' => ''
        ),
        array(
            'name' => __('Event Date', 'stag'),
            'desc' => __('Choose the event date.', 'stag'),
            'id' => '_stag_event_date',
            'type' => 'date',
            'std' => ''
        ),
        array(
            'name' => __('Event Time', 'stag'),
            'desc' => __('Enter the event timings.', 'stag'),
            'id' => '_stag_event_time',
            'type' => 'text',
            'std' => ''
        ),
        array(
            'name' => __('Event Featured Image', 'stag'),
            'desc' => __('Choose a featured image for event, ideal size 460px x 185px. Used to display on homepage.', 'stag'),
            'id' => '_stag_event_featured_image',
            'type' => 'file',
            'std' => ''
        ),
        array(
            'name' => __('Event Cover', 'stag'),
            'desc' => __('Choose a background cover for event, ideal size 1260px x 260px. Used to display on single post.', 'stag'),
            'id' => '_stag_event_cover',
            'type' => 'file',
            'std' => ''
        ),
        array(
            'name' => __('Event Location', 'stag'),
            'desc' => __('Enter the location of the event', 'stag'),
            'id' => '_stag_event_location',
            'type' => 'textarea',
            'std' => ''
        ),
        array(
            'name' => __('Event Map Link', 'stag'),
            'desc' => __('Enter the Google map link to display a map.', 'stag'),
            'id' => '_stag_event_map_url',
            'type' => 'text',
            'std' => ''
        ),
      )
    );
    $meta_box['page'] = 'events';
    stag_add_meta_box($meta_box);

    $meta_box2 = array(
      'id' => 'stag_metabox_events_linked_page',
      'title' => __('Linked Page', 'stag'),
      'description' => __('Display a link after the post to another page.', 'stag'),
      'page' => 'post',
      'context' => 'side',
      'priority' => 'high',
      'fields' => array(
          array(
              'name' => __('Linked Page URL', 'stag'),
              'desc' => __('This URL will used to display a link on the bottom of the page to display a link to another page (optional).', 'stag'),
              'id' => '_stag_event_link',
              'type' => 'text',
              'std' => ''
          ),
          array(
              'name' => __('Linked Page Button Title', 'stag'),
              'desc' => __('Display text for link.', 'stag'),
              'id' => '_stag_event_link_title',
              'type' => 'text',
              'std' => ''
          ),
        )
      );
    $meta_box2['page'] = 'events';
    stag_add_meta_box($meta_box2);
}