<?php
/*--------------------------------------------------*/
/* Include Theme Options
/*--------------------------------------------------*/
require_once('options/blog-settings.php');
require_once('options/general-settings.php');
require_once('options/styling-options.php');
require_once('options/wedding-options.php');


/*--------------------------------------------------*/
/* Include Widgets
/*--------------------------------------------------*/
require_once('widgets/widget-flickr.php');
require_once('widgets/widget-twitter.php');

require_once('widgets/homepage-blog.php');
require_once('widgets/homepage-countdown.php');
require_once('widgets/homepage-divider.php');
require_once('widgets/homepage-event.php');
require_once('widgets/homepage-gallery.php');
require_once('widgets/homepage-rsvp.php');
require_once('widgets/homepage-tweets.php');
require_once('widgets/homepage-wedding-intro.php');


/*--------------------------------------------------*/
/* Include Meta Boxes
/*--------------------------------------------------*/
if(stag_get_option('general_disable_seo_settings') == 'off'){
  require_once('metaboxes/seo.php');
}
require_once('metaboxes/event-metabox.php');
require_once('metaboxes/contact-metabox.php');
require_once('metaboxes/gallery-metabox.php');
require_once('metaboxes/page-metabox.php');
require_once('metaboxes/rsvp-metabox.php');


require_once('theme-shortcodes.php');


/*--------------------------------------------------*/
/* Include Custom Post Types
/*--------------------------------------------------*/
require_once('cpt/events.php');
require_once('cpt/gallery.php');
require_once('cpt/guestbook.php');
require_once('cpt/rsvp.php');