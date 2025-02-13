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
$small_image = get_field('small_image');
$medium_image = get_field('medium_image');
$large_image = get_field('large_image');
$label = get_field('label');
$title = get_field('title');
$description = get_field('description');
$cta_button = get_field('cta_button');
?>
<section id="<?= esc_attr($id) ?>" class="<?= esc_attr($className) ?>">
  <svg class="big-arrow" width="741" height="680" viewBox="0 0 741 680" fill="none" aria-hidden="true">
    <path opacity="0.05" d="M524.128 0.196533H375.075C375.075 148.441 430.659 232.311 490.08 279.599C539.638 319.019 601.356 340 664.669 340C601.356 340 539.638 360.954 490.08 400.401C430.632 447.689 375.075 531.531 375.075 679.803H524.128C524.128 679.803 506.51 404.943 740.492 340.027C506.51 275.057 524.128 0.196533 524.128 0.196533Z"
          fill="#1C301A"/>
    <path opacity="0.05" d="M440.787 339.973C206.448 275.057 224.093 0.196533 224.093 0.196533H74.813C74.813 148.441 130.482 232.311 189.993 279.599C214.864 299.363 242.794 314.477 272.455 324.643L-150 242.504V437.496L272.455 355.357C242.794 365.523 214.891 380.637 190.02 400.401C130.482 447.689 74.84 531.531 74.84 679.803H224.12C224.12 679.803 206.475 404.943 440.814 340.027"
          fill="#1C301A"/>
  </svg>
  <div class="container">
    <div class="cards-wrapper">
      <div class="image-card">
        <?php
        $picture_class = 'small-image cover-image br-10';
        echo bis_get_attachment_picture(
            $small_image,
            [
                768 => [142, 142, 1],
                992 => [142, 142, 1],
                1024 => [170, 170, 1],
                1280 => [204, 204, 1],
                1440 => [204, 204, 1]
            ],
            [
                'retina' => true,
                'picture_class' => $picture_class,
            ],
            [
                'data-speed' => 1.2
            ]
        );
        ?>
        <?php
        $picture_class = 'medium-image cover-image br-10';
        echo bis_get_attachment_picture(
            $medium_image,
            [
                768 => [140, 140, 1],
                992 => [140, 140, 1],
                1024 => [210, 210, 1],
                1280 => [266, 266, 1],
                1440 => [266, 266, 1]
            ],
            [
                'retina' => true, 'picture_class' => $picture_class,
            ],
            [
                'data-speed' => 1.1
            ]
        );
        ?>
        <?php
        $picture_class = 'large-image cover-image br-10';
        echo bis_get_attachment_picture(
            $large_image,
            [
                768 => [187, 187, 1],
                992 => [187, 187, 1],
                1024 => [250, 250, 1],
                1280 => [334, 334, 1],
                1440 => [334, 334, 1],
                1920 => [334, 334, 1]
            ],
            [
                'retina' => true, 'picture_class' => $picture_class,
            ],
            [
                'data-speed' => .9
            ]
        );
        ?>
      </div>
      <div class="swiper swiper-images">
        <div class="swiper-wrapper">
          <div class="swiper-slide">
            <?php
            $picture_class = 'cover-image br-10';
            echo bis_get_attachment_picture(
                $small_image,
                [
                    376 => [316, 316, 1],
                    600 => [316, 316, 1]
                ],
                [
                    'retina' => true, 'picture_class' => $picture_class,
                ],
            );
            ?></div>
          <div class="swiper-slide"> <?php
            $picture_class = 'cover-image br-10';
            echo bis_get_attachment_picture(
                $medium_image,
                [
                    376 => [316, 316, 1],
                    600 => [316, 316, 1]
                ],
                [
                    'retina' => true, 'picture_class' => $picture_class,
                ],
            );
            ?></div>
          <div class="swiper-slide"> <?php
            $picture_class = 'cover-image br-10';
            echo bis_get_attachment_picture(
                $large_image,
                [
                    376 => [316, 316, 1],
                    600 => [316, 316, 1]
                ],
                [
                    'retina' => true, 'picture_class' => $picture_class,
                ],
            );
            ?></div>
        </div>
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