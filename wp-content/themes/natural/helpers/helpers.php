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
  
  
}
