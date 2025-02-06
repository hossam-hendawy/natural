<?php
$id = '';
$className = 'home_here_block';
if (isset($block)) {
  $id = $block['id'];
  if (!empty($block['anchor'])) {
    $id = $block['anchor'];
  }
  if (!empty($block['className'])) {
    $className .= ' ' . $block['className'];
  }
  if (!empty($block['align'])) {
    $className .= ' align' . $block['align'];
  }
  if (function_exists('is_admin') && is_admin()) {
    if (wp_is_json_request() || (defined('REST_REQUEST') && REST_REQUEST) || (function_exists('get_current_screen') && get_current_screen()->is_block_editor())) {
      echo '<img width="100%" height="100%" src="' . get_template_directory_uri() . '/blocks/home_here_block/screenshot.png">';
      return;
    }
  }
}
?>
<?php
$media_image = get_field('image');
$video = get_field('video');
?>
<section id="<?= esc_attr($id) ?>" class="<?= esc_attr($className) ?>">
  <div class="container">
    <?php if ($select_media = get_field('select_media') === 'video') { ?>
      <div class="aspect-ratio media-wrapper">
        <video playsinline autoplay muted loop src="<?= $video ?>" class="video " data-video-type="video_file"></video>
      </div>
    <?php } else { ?>
      <div>
        <?php
        $picture_class = 'aspect-ratio media-wrapper';
        echo bis_get_attachment_picture(
            $media_image,
            [
                375 => [375, 785, 1],
                600 => [600, 1256, 1],
                768 => [708, 321, 1],
                992 => [932, 422, 1],
                1024 => [964, 437, 1],
                1280 => [1220, 553, 1],
                1440 => [1380, 625, 1]
            ],
            [
                'retina' => true, 'picture_class' => $picture_class,
            ],
        );
        ?>
      </div>
    <?php } ?>
  </div>
</section>