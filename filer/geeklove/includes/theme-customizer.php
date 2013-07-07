<?php

function stag_customize_register( $wp_customize ){

    $wp_customize->add_section('accent_control', array(
        'title' => __('Styling Options', 'stag'),
        // 'description' => __('', 'stag'),
        'priority' => 36,
    ));

    $wp_customize->add_setting( 'stag_framework_values[accent_color]' , array(
        'default' => '#d44646',
        'type' => 'option'
    ));

    $wp_customize->add_setting( 'stag_framework_values[style_background_color]' , array(
        'default' => '#ffffff',
        'type' => 'option'
    ));

    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'stag_framework_values[style_background_color]', array(
        'label' => __('Choose Site Background', 'stag'),
        'section' => 'accent_control',
        'settings' => 'stag_framework_values[style_background_color]',
    )));

    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'stag_framework_values[accent_color]', array(
        'label' => __('Choose accent color', 'stag'),
        'section' => 'accent_control',
        'settings' => 'stag_framework_values[accent_color]',
    )));
}
add_action( 'customize_register', 'stag_customize_register' );

function proxy_customize_css()
{
    ?>
<style type="text/css">

body, .container{ background-color:<?php echo stag_get_option('style_background_color'); ?>; }

hr.section-divider:after{ background-color:<?php echo stag_get_option('style_background_color'); ?>; }

.accent-color, a, .wedding-couple-wrap h2, [class*="icon-"], [data-icon]:before, .hentry:before, .countdown_section:before, .section-title, #reply-title,h3#comments,.comment-author, .commentlist li:after, .entry-content h2,.stag-toggle .ui-state-active,.stag-tabs ul.stag-nav .ui-state-active a,.stag-divider.plain:after{ color:<?php echo stag_get_option('accent_color'); ?>; }

::selection{ background-color:<?php echo stag_get_option('accent_color'); ?>; }
::-moz-selection{ background-color:<?php echo stag_get_option('accent_color'); ?>; color: #fff; }
.wedding-couple-wrap .person-info:first-child:before{ background-color:<?php echo stag_get_option('accent_color'); ?>; }

.meta-data,.accent-background, #navigation, #primary-menu ul,#mobile-nav,#mobile-primary-nav,input[type="submit"], button, .button, .stag-button, .countdown_section, .nav-next a, .nav-prev a, .page-numbers, blockquote{ background-color:<?php echo stag_get_option('accent_color'); ?>; }

.person-info:first-child:after{ background-color:<?php echo stag_get_option('accent_color'); ?>; }


</style>
    <?php
}
add_action( 'wp_head', 'proxy_customize_css');