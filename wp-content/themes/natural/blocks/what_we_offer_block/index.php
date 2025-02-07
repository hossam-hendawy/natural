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
$main_title = get_field('title');
$description = get_field('description');
$cta_button = get_field('cta_button');

?>
<section id="<?= esc_attr($id) ?>" class="<?= esc_attr($className) ?>">
  <div class="container">
    <div class="content-wrapper br-10">
      <!--       Left Content Wrapper -->
      <div class="left-content-wrapper">
        <?php if ($label) { ?>
          <h2 class="label light fz-14 fw-400"><?= $label ?></h2>
        <?php } ?>
        <?php if ($main_title) { ?>
          <h2 class="main-title natural-h2 fw-400 lh-72"><?= $main_title ?></h2>
        <?php } ?>
        <?php if (have_rows('accordion_repeater')): ?>
          <div class="accordion">
            <?php while (have_rows('accordion_repeater')): the_row();
              $title = get_sub_field('title');
              $description = get_sub_field('description');
              $cta_link = get_sub_field('cta_link');
              $image = get_sub_field('image');
              $index = get_row_index();
              ?>
              <div class="accordion-panel <?php echo ($index == 1) ? 'active' : ''; ?>" data-tab="<?php echo $index; ?>" itemscope itemprop="mainEntity" itemtype="https://schema.org/Question">
                <div id="panel<?php echo $index; ?>-title" class="accordion-title">
                  <button class="accordion-trigger medium" aria-expanded="<?php echo ($index == 1) ? 'true' : 'false'; ?>">
                    <span><?php echo esc_html($title); ?></span>
                    <span class="toggle-open minus-plus">
                        <svg width="50" height="50" viewBox="0 0 50 50" fill="none" aria-hidden="true">
                            <line class="vertical-line" x1="25" y1="5" x2="25" y2="45" stroke="#98A2B3" stroke-width="5"></line>
                            <line class="horizontal-line" x1="5" y1="25" x2="45" y2="25" stroke="#98A2B3" stroke-width="5"></line>
                        </svg>
                    </span>
                  </button>
                </div>
                <div class="accordion-content" role="region" aria-labelledby="panel<?php echo $index; ?>-title" aria-hidden="<?php echo ($index == 1) ? 'false' : 'true'; ?>">
                  <div class="answer" itemscope itemprop="acceptedAnswer" itemtype="https://schema.org/Answer">
                    <p class="spacer"></p>
                    <div class="description"><?= $description ?></div>
                    <?php if (!empty($cta_link) && is_array($cta_link)): ?>
                      <a class="cta-link fz-16 spinach-color fw-400" href="<?php echo esc_url($cta_link['url']); ?>" target="<?php echo esc_attr($cta_link['target']); ?>">
                        <?php echo esc_html($cta_link['title']); ?>
                        <svg width="15" height="12" viewBox="0 0 15 12" fill="none" aria-hidden="true">
                          <path d="M11.0332 4.18271e-07L8.59375 0C8.59375 2.4252 9.50345 3.79726 10.476 4.57086C11.287 5.21576 12.2971 5.55899 13.3333 5.55899C12.2971 5.55899 11.287 5.90178 10.476 6.54712C9.50301 7.32072 8.59375 8.69234 8.59375 11.118L11.0332 11.118C11.0332 11.118 10.7448 6.62143 14.5743 5.55943C10.7448 4.49656 11.0332 4.18271e-07 11.0332 4.18271e-07Z" fill="#1C301A"></path>
                          <path d="M9.66851 5.55855C5.83344 4.49656 6.12221 1.04972e-06 6.12221 1.04972e-06L3.67917 6.30837e-07C3.67917 2.4252 4.59022 3.79726 5.56415 4.57086C5.97118 4.8942 6.42825 5.14145 6.91367 5.30776L-7.06768e-07 3.96401L-1.27553e-06 7.15397L6.91367 5.81023C6.42825 5.97654 5.97162 6.22379 5.5646 6.54712C4.59022 7.32072 3.67961 8.69234 3.67961 11.118L6.12265 11.118C6.12265 11.118 5.83388 6.62143 9.66895 5.55943" fill="#1C301A"></path>
                        </svg>
                      </a>
                    <?php endif; ?>
                  </div>
                </div>
              </div>
            <?php endwhile; ?>
          </div>
        <?php endif; ?>
      </div>
      <!--       right content wrapper-->
      <?php if (have_rows('accordion_repeater')) { ?>
        <div class="right-content-wrapper">
          <?php
          $index = 1;
          while (have_rows('accordion_repeater')) {
            the_row();
            $image = get_sub_field('image');
            ?>
            <?php if ($image) { ?>
              <div class=" image-wrapper  <?= $index === 1 ? 'active' : '' ?>" data-content="<?= $index ?>">
                <?php
                $picture_class = 'aspect-ratio br-10';
                echo bis_get_attachment_picture(
                    $image,
                    [
                        375 => [156, 191, 1],
                        1024 => [165, 202, 1],
                        1280 => [208, 255, 1],
                        1440 => [234, 287, 1],
                        1920 => [314, 385, 1],
                        3840 => [314, 385, 1]
                    ],
                    [
                        'retina' => true, 'picture_class' => $picture_class,
                    ],
                );
                ?>
              </div>
            <?php } ?>
            <?php
            $index++;
          }
          ?>
        </div>
      <?php } ?>
    </div>
  </div>
</section>