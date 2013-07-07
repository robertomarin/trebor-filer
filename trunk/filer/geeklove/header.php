<!DOCTYPE html>
<!--[if IE 8 ]>    <html <?php language_attributes(); ?> class="no-js ie8"> <![endif]-->
<!--[if IE 9 ]>    <html <?php language_attributes(); ?> class="no-js ie9"> <![endif]-->
<!--[if (gt IE 9)|!(IE)]><!--> <html <?php language_attributes(); ?> class="no-js"> <!--<![endif]-->
<head>
  <title><?php wp_title(''); ?></title>

  <!-- Meta Tags -->
  <meta name="viewport" content="width=device-width">
  <meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />
  <?php stag_meta_head(); ?>

  <!-- Prefetch DNS for external resource to speed up loading time -->
  <link rel="dns-prefetch" href="//fonts.googleapis.com">
  <link rel="dns-prefetch" href="//cdnjs.cloudflare.com">

  <!--[if lt IE 9]>
  <script src="http://css3-mediaqueries-js.googlecode.com/svn/trunk/css3-mediaqueries.js"></script>
  <script src="//cdnjs.cloudflare.com/ajax/libs/selectivizr/1.0.2/selectivizr-min.js"></script>
  <script src="//cdnjs.cloudflare.com/ajax/libs/html5shiv/3.6.1/html5shiv.js"></script>
  <![endif]-->

  <?php wp_head(); ?>
  <?php stag_head(); ?>
</head>

<!-- BEGIN body -->
<body <?php body_class(); ?>>
  <?php stag_body_start(); ?>


  <?php stag_header_before(); ?>

  <!-- BEGIN .header-outer -->
  <header class="header-outer" role="banner">

    <?php stag_header_start(); ?>

      <!-- BEGIN .header -->
      <div class="header clearfix">

        <!-- BEGIN #logo -->
        <div id="logo">
          <?php
          if( stag_get_option('general_text_logo') == 'on' ){ ?>
              <h1><a href="<?php echo site_url(); ?>" title="<?php bloginfo( 'name' ); ?>"><?php bloginfo( 'name' ); ?></a></h1>
              <?php if(get_bloginfo('description') != '') echo '<p>'.get_bloginfo('description').'</p>'; ?>
          <?php } elseif( stag_get_option('general_custom_logo') ) { ?>
            <a href="<?php echo site_url(); ?>" title="<?php bloginfo( 'name' ); ?>"><img src="<?php echo stag_get_option('general_custom_logo'); ?>" alt="<?php bloginfo( 'name' ); ?>"></a>
            <?php if(get_bloginfo('description') != '') echo '<p>'.get_bloginfo('description').'</p>'; ?>
          <?php } else{ ?>
            <a href="<?php echo site_url(); ?>" title="<?php bloginfo( 'name' ); ?>"><img src="<?php echo get_template_directory_uri(); ?>/assets/img/logo.png" alt="<?php bloginfo( 'name' ); ?>"></a>
            <?php if(get_bloginfo('description') != '') echo '<p>'.get_bloginfo('description').'</p>'; ?>
          <?php }
          ?>
          <!-- END #logo -->
        </div>

        <?php if(stag_full_wedding_date() != ''){
          echo '<h4 class="full-wedding-date">'.stag_full_wedding_date().'</h4>';
        } ?>

        <!-- END .header -->
      </div>

    <?php stag_header_end(); ?>

    <!-- END .header-outer -->
  </header>

  <?php stag_header_after(); ?>

  <!-- BEGIN #navigation -->
  <nav id="navigation" role="navigation" class="clearfix">

    <?php
      if(has_nav_menu('primary-menu')){
        wp_nav_menu(array(
          'theme_location' => 'primary-menu',
          'container' => '',
          'items_wrap'      => '<ul id="primary-menu" class="%2$s">%3$s</ul>',
          ));
      }
    ?>

    <!-- END #navigation -->
  </nav>

  <?php stag_content_start(); ?>