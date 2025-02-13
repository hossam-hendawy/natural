<?php
/**
 * Theme Helper
 *
 */

namespace Theme;

class Helpers
{
  
  /**
   * get_image
   *
   * @return string
   */
  public static function get_image($attachment_id, $size = '1536x1536', $attachment_attributes = array())
  {
    if (!$attachment_id) {
      return false;
    }
    
    $attachment_mime_type = get_post_mime_type($attachment_id);
    if ($attachment_mime_type !== 'image/svg+xml') {

      return Helpers::build_picture_element($attachment_id, $size, $attachment_attributes);
    } else {
  
      $attachment_url = wp_get_attachment_url($attachment_id);
      $local_path = str_replace(home_url(), $_SERVER['DOCUMENT_ROOT'], $attachment_url);
      
      return file_exists($local_path) ? file_get_contents($local_path) : null;
    }
  }
  
  
  public static function build_picture_element($attachment_id, $size, $attachment_attributes)
  {
    $original_image_html = wp_get_attachment_image($attachment_id, $size, false, $attachment_attributes);
    
    // Extract srcset and sizes from the original image
    $srcset_pattern = '/srcset="([^"]*)"/i';
    $sizes_pattern = '/sizes="([^"]*)"/i';
    
    preg_match($srcset_pattern, $original_image_html, $srcset_matches);
    preg_match($sizes_pattern, $original_image_html, $sizes_matches);
    
    $original_srcset = $srcset_matches[1] ?? '';
    $sizes_attr = $sizes_matches[1] ?? '';
    
    $sizes = explode(', ', $original_srcset ?? '');
    
    $srcset_avif = Helpers::generate_format_srcset($sizes, 'avif');
    $srcset_webp = Helpers::generate_format_srcset($sizes, 'webp');
    
    $picture = '';
    if (!empty($srcset_avif)) {
      $picture .= '<source srcset="' . $srcset_avif . '" sizes="' . $sizes_attr . '" type="image/avif"/>';
    }
    if (!empty($srcset_webp)) {
      $picture .= '<source srcset="' . $srcset_webp . '" sizes="' . $sizes_attr . '" type="image/webp"/>';
    }
    $picture .= $original_image_html; // Fallback to original image
    
    return $picture;
  }
  
  
  public static function display_attachment($attachment_id, $attachment_attributes = array())
  {
    if (!$attachment_id) {
      return false;
    }
    
    // If width and height are not provided, get them from the attachment
    if (!isset($attachment_attributes['width']) && !isset($attachment_attributes['height'])) {
      $image_attributes = wp_get_attachment_image_src($attachment_id, 'full');
      if ($image_attributes) {
        $attachment_attributes['width'] = $image_attributes[1];
        $attachment_attributes['height'] = $image_attributes[2];
      } else {
        // Default dimensions or error handling
        $attachment_attributes['width'] = 300; // Default width
        $attachment_attributes['height'] = 300; // Default height
      }
    }
    
    // Construct the image attributes string
    $img_attr = '';
    foreach ($attachment_attributes as $key => $value) {
      $img_attr .= $key . '="' . esc_attr($value) . '" ';
    }
    
    $attachment_mime_type = get_post_mime_type($attachment_id);
    $attachment_url = wp_get_attachment_url($attachment_id);
    $attachment_alt = trim(strip_tags(get_post_meta($attachment_id, '_wp_attachment_image_alt', true))) ?: get_the_title($attachment_id);
    
    if ($attachment_mime_type !== 'image/svg+xml') {
      return '<img src="' . esc_url($attachment_url) . '" alt="' . esc_attr($attachment_alt) . '" ' . $img_attr . '/>';
    } else {
      // Handle SVG file path properly for localhost
      $parsed_url = parse_url($attachment_url);
      $local_path = rtrim($_SERVER['DOCUMENT_ROOT'], '/') . $parsed_url['path'];
      
      if (file_exists($local_path)) {
        return file_get_contents($local_path);
      } else {
        return '<!-- SVG file not found: ' . esc_html($local_path) . ' -->';
      }
    }
  }

}
