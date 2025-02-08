<?php
$id = '';
$className = 'text_slider_block';
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
      echo '<img width="100%" height="100%" src="' . get_template_directory_uri() . '/blocks/text_slider_block/screenshot.png">';
      return;
    }
  }
}
?>

<?php
$title = get_field('title');
?>
<section id="<?= esc_attr($id) ?>" class="<?= esc_attr($className) ?>">
  <div class="swiper text-slider">
    <div class="swiper-wrapper">
      <div class="swiper-slide natural-h5 fw-400">
        Passionate Partners
      </div>
      <div class="swiper-slide natural-h5 fw-400">
        Quality Commitment
      </div>
      <div class="swiper-slide natural-h5 fw-400">
        Inclusive Creativity
      </div>
      <div class="swiper-slide natural-h5 fw-400">
        Planetary Care
      </div>
    </div>
  </div>
</section>