<?php
header("Content-type: text/css");

if(file_exists('../../../../wp-load.php')) :
  include '../../../../wp-load.php';
else:
  include '../../../../../wp-load.php';
endif;

@ob_flush();
?>

/*==========================================================================================
This file contains styles related to the user settings of the theme
==========================================================================================*/

body, button, input[type="text"], .button, input[type=submit], #reply-title small,input[type=email],input[type=url],input[type=number]{
    <?php if(stag_get_option('style_body_font') != ''){
        $fontname = stag_get_font_face(stag_get_option('style_body_font'));
        echo 'font-family: "'.$fontname.'", Arial;'."\n";
    } ?>
}

h1,h2,h3,h4,h5,h6,
#countdown .digit,
.countdown_amount,
.intro-text,
blockquote,
.thanks,.error-message,
.stag-alert,
.heading{
    <?php if(stag_get_option('style_heading_font') != ''){
        $fontname = stag_get_font_face(stag_get_option('style_heading_font'));
        echo 'font-family: "'.$fontname.'";'."\n";
    } ?>
}

.entry-content li:before
{ color:<?php echo stag_get_option('accent_color'); ?>; }

hr.section-divider:after, #event:after, .hentry:after, .footer-outer:before, #event:before, #comment-wrap:after, #comment-wrap:before, #tweets:before,#tweets:after,#guestbook-form:after,#guestbook-form:before{
    background-color:<?php echo stag_get_option('style_background_color'); ?>;
}

<?php @ob_end_flush(); ?>