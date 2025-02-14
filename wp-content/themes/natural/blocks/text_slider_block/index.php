<?php
$id = '';
$className = 'text_slider_block';
$slider_speed = get_field('slider_speed')?:10000;

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
<section id="<?= esc_attr($id) ?>" class="<?= esc_attr($className) ?>">
    <?php if (have_rows('core_values')) { ?>
      <!-- Use custom classes to avoid conflicts -->
      <div class="text-slider" data-slider-speed="<?= esc_attr($slider_speed); ?>">
        <div class="text-slider-wrapper">
          <?php while (have_rows('core_values')) {
            the_row();
            $text = get_sub_field('text');
            ?>
            <?php if ($text): ?>
              <div class="text-slider-slide">
                <div class="text-wrapper natural-h5 fw-400 capitalize-text">
                  <?= $text ?>
                  <svg aria-hidden="true" width="21" height="16" viewBox="0 0 21 16" fill="none">
                    <path d="M15.6803 0.838501H12.1841C12.1841 4.1105 13.4879 5.96163 14.8817 7.00535C16.0442 7.87542 17.4919 8.3385 18.977 8.3385C17.4919 8.3385 16.0442 8.80099 14.8817 9.67165C13.4873 10.7154 12.1841 12.5659 12.1841 15.8385H15.6803C15.6803 15.8385 15.2671 9.7719 20.7555 8.3391C15.2671 6.9051 15.6803 0.838501 15.6803 0.838501Z" fill="#1C301A"/>
                    <path d="M13.7912 8.3379C8.47906 6.9051 8.87904 0.838501 8.87904 0.838501H5.4951C5.4951 4.1105 6.75702 5.96163 8.10606 7.00535C8.66985 7.44158 9.30296 7.77517 9.97533 7.99955L0.398926 6.18661V10.4904L9.97533 8.67746C9.30296 8.90184 8.67046 9.23542 8.10668 9.67165C6.75702 10.7154 5.49571 12.5659 5.49571 15.8385H8.87966C8.87966 15.8385 8.47967 9.7719 13.7918 8.3391" fill="#1C301A"/>
                  </svg>
                </div>
              </div>
            <?php endif; ?>
          <?php } ?>
        </div>
      </div>
    <?php } ?>
</section>
