<?php
/* Set Max Content Width */
if ( ! isset( $content_width ) ) $content_width = 940;

global $is_retina;
(isset($_COOKIE['retina'])) ? $is_retina = true : $is_retina = false;

/* Theme Setup */
if(!function_exists('stag_theme_setup')){
  function stag_theme_setup(){
    load_theme_textdomain('stag', get_template_directory().'/languages');

    $locale = get_locale();
    $locale_file = get_template_directory()."/languages/$locale.php";
    if(is_readable($locale_file)){
      require_once($locale_file);
    }

    add_editor_style('framework/css/editor-style.css');

    if(function_exists('add_theme_support')){
      add_theme_support( 'post-thumbnails' );
      set_post_thumbnail_size( 170, 160 ); // Normal post thumbnails
    }

    if(function_exists('add_image_size')){
      // add_image_size( 'portfolio-thumb', 460, 310, true ); // Recent Posts thumbnail (homepage)
    }
  }
}
add_action('after_setup_theme', 'stag_theme_setup');

add_theme_support( 'automatic-feed-links' );

/* Register Sidebar */
if(!function_exists('stag_sidebar_init')){
  function stag_sidebar_init(){

    register_sidebar(array(
      'name' => __('Footer Widgets', 'stag'),
      'id' => 'sidebar-footer',
      'before_widget' => '<div class="grid-4">',
      'after_widget' => '</div>',
      'before_title' => '<h3 class="widget-title">',
      'after_title' => '</h3>',
    ));

    register_sidebar(array(
      'name' => __('Homepage Widgets', 'stag'),
      'id' => 'sidebar-homepage',
      'before_widget' => '',
      'after_widget' => '',
      'before_title' => '',
      'after_title' => '',
      'description' => __('Use only widgets whose name starts with "Homepage: "', 'stag')
    ));



  }
}
add_action('widgets_init', 'stag_sidebar_init');

/* WordPress Title Filter */
if ( !function_exists( 'stag_wp_title' ) ) {
  function stag_wp_title($title) {
    if( !stag_check_third_party_seo() ){
      if( is_front_page() ){
        if(get_bloginfo('description') == ''){
          return get_bloginfo('name');
        }else{
          return get_bloginfo('name') .' | '. get_bloginfo('description');
        }
      } else {
        return trim($title) .' | '. get_bloginfo('name');
      }
    }
    return $title;
  }
}
add_filter('wp_title', 'stag_wp_title');

/* Register Menu */
function register_menu() {
  register_nav_menu('primary-menu', __('Primary Menu', 'stag'));
}
add_action('init', 'register_menu');

/* Register and load scripts */
function stag_enqueue_scripts(){
  if(!is_admin()){
    global $is_IE;
    wp_enqueue_script('jquery');
    wp_enqueue_script('script', get_template_directory_uri().'/assets/js/jquery.custom.js', array('jquery', 'superfish'), '', true);
    wp_enqueue_script('chirp', get_template_directory_uri().'/assets/js/chirp.js', array('jquery'));

    // Theme Scripts
    wp_enqueue_script('modernizr', get_template_directory_uri().'/assets/js/modernizr.js', '', '', true);
    wp_enqueue_script('superfish', get_template_directory_uri().'/assets/js/superfish.js', array('jquery'), '', true);
    wp_enqueue_script('stag-plugins', get_template_directory_uri().'/assets/js/plugins.js', array('jquery', 'modernizr'), '', true);
    wp_enqueue_script('isotope', get_template_directory_uri().'/assets/js/jquery.isotope.js', array('jquery'), '', true);

    if(is_page_template('page-templates/template-home.php') || is_page_template('page-templates/template-photo-gallery.php')){
      if(is_mobile() === false){
        wp_enqueue_script('lightbox', get_template_directory_uri().'/assets/js/lightbox.js', array('jquery'), '', true);
      }
    }

    if( is_singular() ) wp_enqueue_script( 'comment-reply' ); // loads the javascript required for threaded comments

    // Enqueue Styles
    wp_enqueue_style('fonts', get_template_directory_uri().'/assets/css/fonts.css');
    wp_enqueue_style('style', get_template_directory_uri().'/style.css');
    wp_enqueue_style('lightbox', get_template_directory_uri().'/assets/css/lightbox.css');
    wp_enqueue_style('user-style', get_template_directory_uri().'/assets/css/user-styles.php');

    // IE CSS
    if (strpos($_SERVER['HTTP_USER_AGENT'],"MSIE 8")){
      wp_enqueue_style('ie8', get_template_directory_uri().'/assets/css/ie.css');
    }
  }
}
add_action('wp_enqueue_scripts', 'stag_enqueue_scripts');

/* Custom text length */
function stag_trim_text($text, $cut, $suffix = '...') {
  if ($cut < strlen($text)) {
    return substr($text, '0', $cut) . $suffix;
  } else {
    return substr($text, '0', $cut);
  }
}

/* Pagination */
function pagination(){
  global $wp_query;
    $total_pages = $wp_query->max_num_pages;
    if($total_pages > 1){
      if ($total_pages > 1){
        $current_page = max(1, get_query_var('paged'));
        $return = paginate_links(array(
            'base' => get_pagenum_link(1) . '%_%',
            'format' => 'page/%#%',
            'current' => $current_page,
            'total' => $total_pages,
            'prev_next' => false
          ));
        echo "<div class='pages'>{$return}</div>";
        }
  }else{
    return false;
  }
}


/* Comments */
function stag_comments($comment, $args, $depth) {

    $isByAuthor = false;

    if($comment->comment_author_email == get_the_author_meta('email')) {
        $isByAuthor = true;
    }

    $GLOBALS['comment'] = $comment; ?>
   <li <?php comment_class(); ?> id="li-comment-<?php comment_ID() ?>">
     <div id="comment-<?php comment_ID(); ?>" class="the-comment">

     <div class="comment-body clearfix">
        <div class="avatar-wrap">
          <?php
            global $is_retina;
            if($is_retina){
              echo get_avatar($comment,$size='112');
            }else{
              echo get_avatar($comment,$size='56');
            }
          ?>
        </div>
        <div class="comment-area">
            <?php comment_reply_link(array_merge( $args, array('depth' => $depth, 'max_depth' => $args['max_depth']))) ?>
            <h3 class="comment-author"><?php echo get_comment_author_link(); ?></h3>
            <p class="comment-date"><?php echo get_comment_date("U"); ?></p>
            <?php if ($comment->comment_approved == '0') : ?>
               <em class="moderation"><?php _e('Your comment is awaiting moderation.', 'stag') ?></em>
            <?php endif; ?>
            <div class="comment-text">
              <?php comment_text() ?>
            </div>
        </div>
      </div>

     </div>
   </li>

<?php
}

function stag_list_pings($comment, $args, $depth) {
       $GLOBALS['comment'] = $comment; ?>
<li id="comment-<?php comment_ID(); ?>"><?php comment_author_link(); ?>
<?php }


// A little math stuff
function is_multiple($number, $multiple){
  return ($number % $multiple) == 0;
}

if(!function_exists('custom_excerpt_length')){
  function custom_excerpt_length( $length ) {
    return stag_get_option('general_post_excerpt_length');
  }
  add_filter( 'excerpt_length', 'custom_excerpt_length', 999 );
}

if(!function_exists('new_excerpt_more')){
  function new_excerpt_more($more) {
    global $post;
    return ' <a class="read-more" data-through="gateway" data-postid="'.$post->ID.'" href="'. get_permalink($post->ID) . '">'.stag_get_option('general_post_excerpt_text').'</a>';
  }
  add_filter('excerpt_more', 'new_excerpt_more');
}

/*-----------------------------------------------------------------------------------*/
/*  A1llow shortcodes in Text Widgets
/*-----------------------------------------------------------------------------------*/

add_filter('widget_text', 'shortcode_unautop');
add_filter('widget_text', 'do_shortcode');


/**
* Get Wedding Date and Day
*/
function stag_wedding_date($arg, $data = null){
  if($data === null){
    $date = stag_get_option('wedding_date');
  }else{
    $date = $data;
  }
  $return = date_i18n($arg, strtotime($date));
  return $return;
}

function stag_full_wedding_date(){
  $return = '<span class="day-date accent-color">'.stag_wedding_date('l').' '.stag_wedding_date('d').'</span> ';
  $return .= '<span class="month">'.stag_wedding_date('F').'</span> ';
  $return .= '<span class="year accent-color">'.stag_wedding_date('Y').'</span> ';
  return $return;
}

function stag_full_date($date){
  $return = stag_wedding_date('l', $date)." ";
  $return .= stag_wedding_date('d', $date)." ";
  $return .= stag_wedding_date('F', $date)." ";
  $return .= stag_wedding_date('Y', $date)." ";
  return $return;
}

/**
* Get All available events
*/
function stag_all_wedding_events(){
  $q = new WP_Query('post_type=events');
  $titles = array();
  if($q->have_posts()){
    while($q->have_posts()): $q->the_post();
    $titles[] = get_the_title();
    endwhile;
    wp_reset_postdata();
  }
  return $titles;
}


function is_sidebar_active( $index = 1){
  $sidebars = wp_get_sidebars_widgets();
  $count = count($sidebars['sidebar-'.$index]);
  if($count === 0){
    return false;
  }else{
    return true;
  }
}

/**
* Check if string starts with a particular charcter
*/
function startsWith($haystack, $needle){
  return !strncmp($haystack, $needle, strlen($needle));
}

/**
* Get Relative Date
*/
add_filter( 'get_comment_date', 'get_the_relative_time' );
function get_the_relative_time($time = null){
    if(is_null($time)) $time = get_the_time("U");

    $time_diff = date_i18n("U") - $time; // difference in second

    $second = 1;
    $minute = 60;
    $hour = 60*60;
    $day = 60*60*24;
    $week = 60*60*24*7;
    $month = 60*60*24*7*30;
    $year = 60*60*24*7*30*365;

    if ($time_diff <= 120) {
        $output = "now";
    } elseif ($time_diff > $second && $time_diff < $minute) {
        $output = round($time_diff/$second)." second";
    } elseif ($time_diff >= $minute && $time_diff < $hour) {
        $output = round($time_diff/$minute)." minute";
    } elseif ($time_diff >= $hour && $time_diff < $day) {
        $output = round($time_diff/$hour)." hour";
    } elseif ($time_diff >= $day && $time_diff < $week) {
        $output = round($time_diff/$day)." day";
    } elseif ($time_diff >= $week && $time_diff < $month) {
        $output = round($time_diff/$week)." week";
    } elseif ($time_diff >= $month && $time_diff < $year) {
        $output = round($time_diff/$month)." month";
    } elseif ($time_diff >= $year && $time_diff < $year*10) {
        $output = round($time_diff/$year)." year";
    } else{ $output = " more than a decade ago"; }

    if ($output <> "now") {
      $output = (substr($output,0,2)<>"1 ") ? $output."s" : $output;
      $output .= " ago";
    }

    return $output;
}


function get_attachment_id_from_src ($image_src) {
  global $wpdb;
  $query = "SELECT ID FROM {$wpdb->posts} WHERE guid='$image_src'";
  $id = $wpdb->get_var($query);
  return $id;
}

function is_mobile(){
  $useragent=$_SERVER['HTTP_USER_AGENT'];

  // do the mobile detection
  if (
      preg_match('/android.+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|meego.+mobile|midp|mmp|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i',$useragent)
      ||
      preg_match('/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(di|rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i',substr($useragent,0,4))
  ){
    return true;
  }
  return false;
}



/* Include the StagFramework */
$tmpDir = get_template_directory();
require_once($tmpDir.'/framework/_init.php');
require_once($tmpDir.'/includes/_init.php');
require_once($tmpDir.'/includes/theme-customizer.php');
