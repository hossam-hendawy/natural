<?php
$id = '';
$className = 'three_images_and_text_block';
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
      echo '<img width="100%" height="100%" src="' . get_template_directory_uri() . '/blocks/three_images_and_text_block/screenshot.png">';
      return;
    }
  }
}
?>
<?php
$image = get_field('image');
$label = get_field('label');
$title = get_field('title');
$description = get_field('description');
$cta_button = get_field('cta_button');
?>
<section id="<?= esc_attr($id) ?>" class="<?= esc_attr($className) ?>">
  <div class="container">
    <div class="cards-wrapper">
      <div class="image-card">
        <?php
        $picture_class = 'left-image aspect-ratio br-10';
        echo bis_get_attachment_picture(
            $image,
            [
                375 => [335, 335, 1],
                600 => [560, 560, 1],
                768 => [312, 312, 1],
                992 => [410, 410, 1],
                1024 => [454, 454, 1],
                1280 => [575, 575, 1],
                1440 => [590, 590, 1],
                1920 => [562, 562, 1]
            ],
            [
                'retina' => true, 'picture_class' => $picture_class,
            ],
        );
        ?>
      </div>
      <div class="right-content">
        <?php if ($label) { ?>
          <h2 class="label fz-14 fw-400"><?= $label ?></h2>
        <?php } ?>
        <?php if ($title) { ?>
          <h2 class="title natural-h1 fw-400 lh-72"><?= $title ?></h2>
        <?php } ?>
        <?php if ($description) { ?>
          <div class="description fz-16 fw-300"><?= $description ?></div>
        <?php } ?>
        <?php if (!empty($cta_button) && is_array($cta_button)) { ?>
          <a class="cta-button" href="<?= $cta_button['url'] ?>" target="<?= $cta_button['target'] ?>"><?= $cta_button['title'] ?></a>
        <?php } ?>

      </div>
    </div>
  </div>
</section>