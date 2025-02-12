<?php
$id = '';
$className = 'how_we_do_it_block';
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
      echo '<img width="100%" height="100%" src="' . get_template_directory_uri() . '/blocks/how_we_do_it_block/screenshot.png">';
      return;
    }
  }
}
?>
<?php
$image = get_field('image');
$label = get_field('label');
$main_title = get_field('title');
$description = get_field('description');
$cta_button = get_field('cta_button');


?>
<section id="<?= esc_attr($id) ?>" class="<?= esc_attr($className) ?>">
  <div class="container">
    <div class="content-wrapper">
      <?php if ($label) { ?>
        <h2 class="label fz-14 fw-400"><?= $label ?></h2>
      <?php } ?>
      <?php if ($main_title) { ?>
        <h2 class="main-title natural-h2 fw-400 lh-72"><?= $main_title ?></h2>
      <?php } ?>
      <?php if (have_rows('accordion_repeater')): ?>
        <div class="accordion">
          <?php while (have_rows('accordion_repeater')): the_row();
            $title = get_sub_field('title');
            $description = get_sub_field('description');
            $icon = get_sub_field('icon');
            $index = get_row_index();
            ?>
            <div class="accordion-panel <?php echo ($index == 1) ? 'active' : ''; ?>" data-tab="<?php echo $index; ?>" itemscope itemprop="mainEntity" itemtype="https://schema.org/Question">
              <div id="panel<?php echo $index; ?>-title" class="accordion-title">
                <button class="accordion-trigger medium" aria-expanded="<?php echo ($index == 1) ? 'true' : 'false'; ?>">
                    <span class="icon-and-title">
                          <?= \theme\Helpers::get_image(113, '1536x1536') ?>
                      <?php
                      
                      ?>
                      <?php if (!empty($icon) && is_array($icon)) { ?>
                        <picture class="icon-wrapper">
                          <img src="<?= $icon['url'] ?>" alt="<?= $icon['alt'] ?>">
                      </picture>
                      <?php } ?>
                      <?php echo esc_html($title); ?>
                    </span>
                
                </button>
              </div>
              <div class="accordion-content" role="region" aria-labelledby="panel<?php echo $index; ?>-title" aria-hidden="<?php echo ($index == 1) ? 'false' : 'true'; ?>">
                <div class="answer" itemscope itemprop="acceptedAnswer" itemtype="https://schema.org/Answer">
                  <p class="spacer"></p>
                  <div class="description"><?= $description ?></div>
                  <p class="spacer-2"></p>
                </div>
              </div>
              <span class="toggle-open minus-plus">
                        <svg width="50" height="50" viewBox="0 0 50 50" fill="none" aria-hidden="true">
                            <line class="vertical-line" x1="25" y1="5" x2="25" y2="45" stroke="#98A2B3" stroke-width="5"></line>
                            <line class="horizontal-line" x1="5" y1="25" x2="45" y2="25" stroke="#98A2B3" stroke-width="5"></line>
                        </svg>
                    </span>
            </div>
          <?php endwhile; ?>
        </div>
      <?php endif; ?>
    </div>
  </div>
</section>