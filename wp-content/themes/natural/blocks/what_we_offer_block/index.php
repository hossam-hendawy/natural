<?php
$id = '';
$className = 'what_we_offer_block';
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
      echo '<img width="100%" height="100%" src="' . get_template_directory_uri() . '/blocks/what_we_offer_block/screenshot.png">';
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
    <div class="content-wrapper">
      <div class="left-content-wrapper">
        <?php if ($label) { ?>
          <h2 class="label light fz-14 fw-400"><?= $label ?></h2>
        <?php } ?>
        <?php if ($title) { ?>
          <h2 class="title natural-h2 fw-400 lh-72"><?= $title ?></h2>
        <?php } ?>
      </div>
  
    </div>
  </div>
</section>