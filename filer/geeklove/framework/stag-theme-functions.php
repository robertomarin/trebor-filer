<?php
function stag_add_option( $name, $value ){
  stag_update_option( $name, $value );
}

function stag_update_option($name, $value){
  $stag_values = get_option('stag_framework_values');
  $stag_values[$name] = $value;
  update_option('stag_framework_values', $stag_values);
}

function stag_remove_option($name){
  $stag_values = get_option('stag_framework_values');
  unset($stag_values[$name]);
  update_option('stag_framework_values', $stag_values);
}

function stag_get_option($name){
  $stag_values = get_option( 'stag_framework_values' );
  if( @array_key_exists( $name, $stag_values ) ) return $stag_values[$name];
  return false;
}

// Add version information to head
function stag_add_version_meta(){
  echo '<meta name="generator" content="'. STAG_THEME_NAME .' '. STAG_THEME_VERSION .'" />'."\n";
  echo '  <meta name="generator" content="Stag Framework '. STAG_FRAMEWORK_VERSION .'" />'."\n";
}
add_action('stag_meta_head', 'stag_add_version_meta');


// Add featured image to RSS feed
function stag_add_featured_image_to_rss($content){
  global $post;
  if(has_post_thumbnail($post->ID)){
    $content = '<div style="float:left;">' . get_the_post_thumbnail($post->ID, 'archive-thumb') . '</div>'.$content;
  }
  return $content;
}
add_filter('the_excerpt_rss', 'stag_add_featured_image_to_rss');
add_filter('the_content_feed', 'stag_add_featured_image_to_rss');



// Get CatID from cat name
if ( !function_exists( 'get_category_id' ) ) {
  function get_category_id( $cat_name )
  {
    $term = get_term_by( 'name', $cat_name, 'category' );
    return $term->term_id;
  }
}

if ( !function_exists( 'stag_blog_url' ) ) {
  function stag_blog_url(){
    if( $posts_page_id = get_option('page_for_posts') ){
      return home_url(get_page_uri($posts_page_id));
    } else {
      return home_url();
    }
  }
}

add_filter('widget_text', 'shortcode_unautop');
add_filter('widget_text', 'do_shortcode');
remove_action( 'wp_head', 'wp_generator' );


// CUSTOM HOOKS
/* header.php -----------------------------------------------------------------*/
function stag_meta_head() { stag_do_contextual_hook('stag_meta_head'); }
function stag_head() { stag_do_contextual_hook('stag_head'); }
function stag_body_start() { stag_do_contextual_hook('stag_body_start'); }
function stag_header_before() { stag_do_contextual_hook('stag_header_before'); }
function stag_header_after() { stag_do_contextual_hook('stag_header_after'); }
function stag_header_start() { stag_do_contextual_hook('stag_header_start'); }
function stag_header_end() { stag_do_contextual_hook('stag_header_end'); }
function stag_nav_before() { stag_do_contextual_hook('stag_nav_before'); }
function stag_nav_after() { stag_do_contextual_hook('stag_nav_after'); }
function stag_content_start() { stag_do_contextual_hook('stag_content_start'); }

/* index.php, single.php, search.php, archive.php -----------------------------*/
function stag_post_before() { stag_do_contextual_hook('stag_post_before'); }
function stag_post_after() { stag_do_contextual_hook('stag_post_after'); }
function stag_post_start() { stag_do_contextual_hook('stag_post_start'); }
function stag_post_end() { stag_do_contextual_hook('stag_post_end'); }

/* page.php -------------------------------------------------------------------*/
function stag_page_before() { stag_do_contextual_hook('stag_page_before'); }
function stag_page_after() { stag_do_contextual_hook('stag_page_after'); }
function stag_page_start() { stag_do_contextual_hook('stag_page_start'); }
function stag_page_end() { stag_do_contextual_hook('stag_page_end'); }

/* single.php, page.php, templates with comments ------------------------------*/
function stag_comments_before() { stag_do_contextual_hook('stag_comments_before'); }
function stag_comments_after() { stag_do_contextual_hook('stag_comments_after'); }

/* sidebar.php ----------------------------------------------------------------*/
function stag_sidebar_before() { stag_do_contextual_hook('stag_sidebar_before'); }
function stag_sidebar_after() { stag_do_contextual_hook('stag_sidebar_after'); }
function stag_sidebar_start() { stag_do_contextual_hook('stag_sidebar_start'); }
function stag_sidebar_end() { stag_do_contextual_hook('stag_sidebar_end'); }

/* footer.php -----------------------------------------------------------------*/
function stag_content_end() { stag_do_contextual_hook('stag_content_end'); }
function stag_footer_before() { stag_do_contextual_hook('stag_footer_before'); }
function stag_footer_after() { stag_do_contextual_hook('stag_footer_after'); }
function stag_footer_start() { stag_do_contextual_hook('stag_footer_start'); }
function stag_footer_end() { stag_do_contextual_hook('stag_footer_end'); }
function stag_body_end() { stag_do_contextual_hook('stag_body_end'); }

if(!function_exists('stag_do_contextual_hook')){
  function stag_do_contextual_hook($tag = '', $args = ''){
    if (!$tag){
      return false;
    }
    do_action( $tag, $args );
    foreach( (array) stag_get_query_context() as $context ) {
      do_action( "{$tag}_{$context}", $args );
    }
  }
}

if( !function_exists('stag_get_query_context')){
  function stag_get_query_context(){
    global $wp_query, $query_context;

    if(isset($query_context->context) && is_array($query_context->context)){
      return $query_context->context;
    }else{
      $query_context = new stdClass;
    }

    $query_context->context = array();

    if(is_front_page()){$query_context->context[] = 'home';}

    if(is_home() && is_front_page()){
      $query_context->context[] = 'blog';
    }elseif(is_singular()){
      $query_context->context[] = 'singular';
      $query_context->context[] = "singular-{$wp_query->post->post_type}";
      if(is_page_template()){
        $skip = array('page', 'post');
        $page_template = basename(get_page_template());
        $page_template = str_replace('.php', '', $page_template);
        $page_template = str_replace('.', '-', $page_template);

        if($page_template && !in_array($page_template, $skip)){
          $query_context->context[] = $page_template;
        }
      }
      $query_context->context[] = "singular-{$wp_query->post->post_type}-{$wp_query->post->ID}";
    }elseif(is_archive()){
      $query_context->context[] = 'archive';

      if(is_tax() || is_category() || is_tag()){
        $term = $wp_query->get_queried_object();
        $query_context->context[] = 'taxonomy';
        $query_context->context[] = $term->taxonomy;
        $query_context->context[] = "{$term->taxonomy}-" . sanitize_html_class( $term->slug, $term->term_id );
      }elseif(is_author()){
        $query_context->context[] = 'user';
        $query_context->context[] = 'user-' . sanitize_html_class( get_the_author_meta( 'user_nicename', get_query_var( 'author' ) ), $wp_query->get_queried_object_id() );
      }else{
        if ( is_date() ) {
          $query_context->context[] = 'date';
          if ( is_year() )
            $query_context->context[] = 'year';
          if ( is_month() )
            $query_context->context[] = 'month';
          if ( get_query_var( 'w' ) )
            $query_context->context[] = 'week';
          if ( is_day() )
            $query_context->context[] = 'day';
        }
        if ( is_time() ) {
          $query_context->context[] = 'time';
          if ( get_query_var( 'hour' ) )
            $query_context->context[] = 'hour';
          if ( get_query_var( 'minute' ) )
            $query_context->context[] = 'minute';
        }
      }
    }elseif(is_search()){
      $query_context->context[] = 'search';
    }elseif(is_404()){
      $query_context->context[] = 'error-404';
    }
    return $query_context->context;
  }
}

/**
* Adding browser name to body class
* @return array new body Class
* @since v1.0.0
*/
function stag_body_classes($classes){
  global $is_lynx, $is_gecko, $is_IE, $is_opera, $is_NS4, $is_safari, $is_chrome, $is_iphone;

  if($is_lynx) $classes[] = 'lynx';
  elseif($is_gecko) $classes[] = 'gecko';
  elseif($is_opera) $classes[] = 'opera';
  elseif($is_NS4) $classes[] = 'ns4';
  elseif($is_safari) $classes[] = 'safari';
  elseif($is_chrome) $classes[] = 'chrome';
  elseif($is_chrome){
    $classes[] = 'ie';
    if(preg_match('/MSIE ([0-9]+)([a-zA-Z0-9.]+)/', $_SERVER['HTTP_USER_AGENT'], $browser_version )){
      $classes[] = 'ie'.$browser_version[1];
    }else{
      $classes[] = 'unknown';
    }
  }

  if(isset($_COOKIE['retina']) && $_COOKIE['retina'] > 1) $classes[] = 'retina';

  if($is_iphone) $classes[] = 'iphone';

  if(stristr($_SERVER['HTTP_USER_AGENT'], "mac")){
    $classes[] = 'mac';
  }elseif(stristr($_SERVER['HTTP_USER_AGENT'], "linux")){
    $classes[] = 'linux';
  }elseif(stristr($_SERVER['HTTP_USER_AGENT'], "windows")){
    $classes[] = 'windows';
  }

  // array_push($classes, 'stag');
  return $classes;
}
add_filter('body_class','stag_body_classes');


function stag_toolbar_items($admin_bar){
  $admin_bar->add_menu( array(
      'id'    => 'stagframework',
      'title' => 'Theme Options',
      'href'  => admin_url('admin.php?page=stagframework'),
      'meta'  => array(
          'title' => __('Theme Options', 'stag'),
      ),
  ));

  $stag_options = get_option('stag_framework_options');

  foreach($stag_options['stag_framework'] as $page){
    $admin_bar->add_menu( array(
        'parent'    => 'stagframework',
        'id'    => 'stagframework-'. stag_to_slug(key($page)),
        'title' => key($page),
        'href'  => admin_url('index.php?page=stagframework#'.stag_to_slug(key($page))),
    ));
  }
}
add_action('admin_bar_menu', 'stag_toolbar_items', 100);

/**
* Fixes the wrong language problem with twitter embeds
*/
if ( !function_exists( 'ucc_oembed_twitter_lang' ) ) {
function ucc_oembed_twitter_lang( $provider, $url, $args ) {
  if ( 'twitter.com' == parse_url( $url, PHP_URL_HOST ) ) {
    if ( defined( 'WPLANG' ) )
      $lang = strtolower( WPLANG );
    if ( empty( $lang ) )
      $lang = 'en';

    $args['lang'] = $lang;
    $provider = add_query_arg( 'lang', urlencode( $lang ), $provider );
  }
  return $provider;
} }
add_filter( 'oembed_fetch_url', 'ucc_oembed_twitter_lang', 10, 3 );