<?php
/**
 * Functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package map
 * @since 1.0.0
 */

/**
 * Enqueue the CSS files.
 *
 * @return void
 * @since 1.0.0
 *
 */

function map_styles()
{
  wp_enqueue_style(
      'map-style',
      get_stylesheet_uri(),
      [],
      wp_get_theme()->get('Version')
  );
}

add_action('wp_enqueue_scripts', 'map_styles');

function enqueue_jquery() {
  if (!is_admin()) {
    wp_enqueue_script('jquery');
  }
}
add_action('wp_enqueue_scripts', 'enqueue_jquery');

function mapCustomStyles()
{
  wp_enqueue_style('custom-css', get_stylesheet_directory_uri() . '/assets/index.css', '', '1.0', 'all');
  wp_enqueue_script('custom-js', get_stylesheet_directory_uri() . '/assets/index.js', '', null, true);
}

add_action('wp_enqueue_scripts', 'mapCustomStyles');

add_theme_support('editor-styles');

require_once "helpers/helpers.php";


//region register blocks
include "blocks/blocks-related-functions.php";
//endregion register blocks


add_theme_support('post-thumbnails');


function my_custom_admin_editor_inline_styles()
{ ?>
  <style>
    body .editor-styles-wrapper {
      padding: 0 4vw;
    }
    
    .acf-block-component.acf-block-body {
      margin-bottom: 80px;
    }
  </style>
<?php }

add_action('admin_head', 'my_custom_admin_editor_inline_styles');

if (function_exists('acf_add_options_page')) {
  acf_add_options_page(array(
      'page_title' => 'Site Settings',
      'menu_title' => 'Site Settings',
      'menu_slug' => 'site-settings',
      'capability' => 'edit_posts',
      'redirect' => false
  ));
}

// Allow SVG uploads
function add_svg_to_upload_mimes($mimes)
{
  $mimes['svg'] = 'image/svg+xml';
  return $mimes;
}

add_filter('upload_mimes', 'add_svg_to_upload_mimes');

// Sanitize SVG uploads
function sanitize_svg($file)
{
  $wp_filetype = wp_check_filetype_and_ext($file['tmp_name'], $file['name']);
  if ($wp_filetype['ext'] !== 'svg') {
    return $file;
  }
  $svg = simplexml_load_file($file['tmp_name']);
  if (!$svg) {
    $file['error'] = __('Sorry, this file could not be sanitized and is therefore not allowed.', 'my-theme');
    return $file;
  }
  // Sanitize SVG content here if needed
  return $file;
}

add_filter('wp_handle_upload_prefilter', 'sanitize_svg');


