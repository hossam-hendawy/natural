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
<section id="<?= esc_attr($id) ?>" class="<?= esc_attr($className) ?>">
  <div class="container">
    <?php
    $image = get_field('image');
    ?>
    <div>
      <?php
      $picture_class = 'aspect-ratio image-wrapper';
      echo bis_get_attachment_picture(
          $image,
          [
              375 => [375, 500, 1],
              600 => [560, 304, 1],
              768 => [708, 385, 1],
              992 => [932, 507, 1],
              1024 => [964, 524, 1],
              1280 => [1220, 663, 1],
              1440 => [1380, 750, 1],
              1920 => [1320, 717, 1]
          ],
          [
              'retina' => true, 'picture_class' => $picture_class,
          ],
      );
      ?>
    </div>
  </div>
</section>