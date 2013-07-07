<?php
add_action('admin_init', 'stag_wedding_settings');
function stag_wedding_settings(){

  $wedding_settings['description'] = __('Customize your homepage preferences.', 'stag');

  $wedding_settings[] = array(
    'title'   => 'Wedding Date',
    'desc'    => 'Select the wedding date',
    'type'    => 'date',
    'val'     => '12-31-2014',
    'id'      => 'wedding_date',
    'format'  => 'dd-mm-yyyy'
  );

  $wedding_settings[] = array(
    'title'   => 'Wedding Time',
    'desc'    => 'Select the wedding time in H:i:s format.<br>For example: 20:12:55; hours, minutes and seconds respectively.',
    'type'    => 'text',
    'id'      => 'wedding_time',
    'val'     => '0:0:0',
  );

  $wedding_settings[] = array(
    'title'   => 'Bridegroom details',
    'type'    => 'html',
    'val'     => ''
  );

  $wedding_settings[] = array(
    'title' => 'First Name',
    'desc' => 'Enter the first name of the Bridegroom',
    'type' => 'text',
    'id' => 'wedding_bridegroom_first_name'
  );

  $wedding_settings[] = array(
    'title' => 'Last Name',
    'desc' => 'Enter the Last name of the Bridegroom',
    'type' => 'text',
    'id' => 'wedding_bridegroom_last_name'
  );

  $wedding_settings[] = array(
    'title' => 'Bridegroom Avatar',
    'desc' => 'Upload the avatar of Bridegroom.<br>Ideal size 115px x 115px or 230px x 230px for retina displays',
    'type' => 'file',
    'id' => 'wedding_bridegroom_avatar'
  );

  $wedding_settings[] = array(
    'title' => 'Bridegroom Short Bio',
    'desc' => 'Bio text for bridegroom',
    'type' => 'textarea',
    'id' => 'wedding_bridegroom_bio'
  );


  $wedding_settings[] = array(
    'title' => 'Bride details',
    'type' => 'html',
    'val' => ''
  );

  $wedding_settings[] = array(
    'title' => 'First Name',
    'desc' => 'Enter the first name of the Bride',
    'type' => 'text',
    'id' => 'wedding_bride_first_name'
  );

  $wedding_settings[] = array(
    'title' => 'Last Name',
    'desc' => 'Enter the Last name of the Bride',
    'type' => 'text',
    'id' => 'wedding_bride_last_name'
  );

  $wedding_settings[] = array(
    'title' => 'Bride Avatar',
    'desc' => 'Upload the avatar of Bride.<br>Ideal size 115px x 115px or 230px x 230px for retina displays',
    'type' => 'file',
    'id' => 'wedding_bride_avatar'
  );

  $wedding_settings[] = array(
    'title' => 'Bride Short Bio',
    'desc' => 'Bio text for bride',
    'type' => 'textarea',
    'id' => 'wedding_bride_bio'
  );

  $wedding_settings[] = array(
    'title' => 'Intro Section Slideshow',
    'type' => 'html',
    'val' => ''
  );

  $wedding_settings[] = array(
    'title' => 'Slideshow Images',
    'type' => 'files',
    'id' => 'wedding_slideshow'
  );

  $wedding_settings[] = array(
    'title' => 'Slideshow Duration',
    'desc' => 'Enter the duration between slideshows.<br><em>1000 is equal to 1 second.</em>',
    'type' => 'text',
    'id' => 'wedding_slideshow_duration',
    'val' => '3000'
  );

  $wedding_settings[] = array(
    'title' => 'Fade Duration',
    'desc' => 'Enter the duration between slideshows fade animation.<br><em>1000 is equal to 1 second.</em>',
    'type' => 'text',
    'id' => 'wedding_fade_duration',
    'val' => '750'
  );


  stag_add_framework_page( 'Wedding Settings', $wedding_settings, 11 );
}