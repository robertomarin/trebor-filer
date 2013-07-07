<?php
add_action('admin_init', 'stag_blog_setting');
function stag_blog_setting(){

  $blog_settings['description'] = __('Modify your blog settings.', 'stag');

  $blog_settings[] = array(
    'title' => 'Blog Cover',
    'desc' => 'Choose a cover image for blog',
    'type' => 'file',
    'id' => 'blog_cover_image',
    'val' => 'Choose Cover Image'
  );

  $blog_settings[] = array(
    'title' => 'Blog Title',
    'desc' => 'Choose the title for blog page',
    'type' => 'text',
    'id' => 'blog_title',
  );

  $blog_settings[] = array(
    'title' => 'Blog Subitle',
    'desc' => 'Choose the subtitle for blog page',
    'type' => 'text',
    'id' => 'blog_subtitle',
  );

  $blog_settings[] = array(
    'title' => 'Blog Footer',
    'desc' => 'Enter the blog footer text',
    'type' => 'wysiwyg',
    'id' => 'blog_footer',
    'val' => 'Copyright '.date('Y').' '.get_bloginfo('title'),
  );

  stag_add_framework_page( 'Blog Settings', $blog_settings, 40 );
}