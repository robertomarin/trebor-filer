<?php
add_action('admin_init', 'stag_general_settings');
function stag_general_settings(){
    $general_settings['description'] = 'Configure general settings of your theme. Upload your preferred logo, favicon, and insert your analytics tracking code.';

    $general_settings[] = array(
        'title' => 'Plain Text Logo',
        'desc' => 'Check this box to enable a plain text logo rather than an image logo. Will use your site title.',
        'type' => 'checkbox',
        'id' => 'general_text_logo',
        'val' => 'on'
    );

  $general_settings[] = array(
    'title' => 'Custom Logo Upload',
    'desc' => 'Upload a logo for your theme.',
    'type' => 'file',
    'id' => 'general_custom_logo',
    'val' => 'Upload Image'
    );

    $general_settings[] = array(
    'title' => 'Custom Favicon Upload',
    'desc' => 'Upload a 16px x 16px Png/Gif image that will represent your website\'s favicon. Use <a href="http://www.xiconeditor.com/" target="_blank" rel="nofollow">X-Icon Editor</a> to easily create a favicon.',
    'type' => 'file',
    'id' => 'general_custom_favicon',
    'val' => 'Upload Image'
    );

    $general_settings[] = array(
    'title' => 'Contact Form Email Address',
    'desc' => 'Enter the <code>email address</code> where you\'d like to receive emails from the contact form, or leave blank to use admin email.',
    'type' => 'text',
    'id' => 'general_contact_email'
    );

    $general_settings[] = array(
    'title' => 'Tracking Code',
    'desc' => 'Paste your Google Analytics (or other) tracking code here. It will be inserted before the closing body tag of your theme.',
    'type' => 'textarea',
    'id' => 'general_tracking_code'
    );

    $general_settings[] = array(
    'title' => 'Post Excerpt Length',
    'desc' => 'Enter the length of post excerpt for blog page.',
    'type' => 'number',
    'id' => 'general_post_excerpt_length',
    'val' => '40',
    'attr' => 'step="5"'
    );

    $general_settings[] = array(
    'title' => 'Number of Guestbook messages per page',
    'desc' => 'Specify the number of guestbook messages per page',
    'type' => 'number',
    'id' => 'general_guestbook_count',
    'val' => '10',
    );

    $general_settings[] = array(
    'title' => 'Post Excerpt Text',
    'desc' => 'Enter the length of post excerpt for blog page.',
    'type' => 'text',
    'id' => 'general_post_excerpt_text',
    'val' => 'Read More...'
    );

    $general_settings[] = array(
    'title' => 'Disable Admin Bar',
    'desc' => 'Enable/Disable WordPress Admin Bar for all users.',
    'type' => 'checkbox',
    'id' => 'general_disable_admin_bar',
    'val' => 'off'
    );

    $general_settings[] = array(
    'title' => 'Disable SEO Settings',
    'desc' => 'Enable/Disable SEO Settings on single posts and pages.',
    'type' => 'checkbox',
    'id' => 'general_disable_seo_settings',
    'val' => 'off'
    );

    stag_add_framework_page( 'General Settings', $general_settings, 5 );
}



// OUTPUT THE FAVICON
function stag_show_favicon(){
    $stag_values =  get_option('stag_framework_values');
    if(stag_get_option('general_custom_favicon') != ''){
        echo '<link rel="shortcut icon" href="'.$stag_values['general_custom_favicon'].'" type="image/x-icon" />';
    }else{
        echo '<link rel="shortcut icon" href="'.get_template_directory_uri().'/assets/img/favicon.ico" type="image/x-icon" />';
    }
}
add_action('wp_head', 'stag_show_favicon');


if(stag_get_option('general_disable_admin_bar') === 'on'){
    show_admin_bar(false);
}

/**
* Output the tracking code
*/
function stag_tracking_code(){
    $stag_values = get_option( 'stag_framework_values' );
    if( array_key_exists( 'general_tracking_code', $stag_values ) && $stag_values['general_tracking_code'] != '' )
        echo stripslashes($stag_values['general_tracking_code']);
}
add_action( 'wp_footer', 'stag_tracking_code' );