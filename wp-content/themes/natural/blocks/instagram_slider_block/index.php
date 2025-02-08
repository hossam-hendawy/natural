<?php
$id = '';
$className = 'instagram_slider_block';
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
      echo '<img width="100%" height="100%" src="' . get_template_directory_uri() . '/blocks/instagram_slider_block/screenshot.png">';
      return;
    }
  }
}
?>

<?php
$title = get_field('title');
?>
<section id="<?= esc_attr($id) ?>" class="<?= esc_attr($className) ?>">
  <div class="container">
    <div class="insta-icon">
      <svg width="24" height="24" viewBox="0 0 24 24" fill="none" aria-hidden="true">
        <path d="M11.7391 2.11396C14.8757 2.11396 15.2471 2.12772 16.4806 2.18274C17.627 2.23319 18.2461 2.42578 18.6588 2.58628C19.2045 2.79721 19.5988 3.05401 20.007 3.46213C20.4197 3.87483 20.6719 4.26461 20.8828 4.81029C21.0433 5.223 21.2359 5.84664 21.2863 6.98845C21.3414 8.22656 21.3551 8.598 21.3551 11.73C21.3551 14.8665 21.3414 15.2379 21.2863 16.4715C21.2359 17.6179 21.0433 18.2369 20.8828 18.6496C20.6719 19.1953 20.4151 19.5897 20.007 19.9978C19.5943 20.4105 19.2045 20.6627 18.6588 20.8736C18.2461 21.0341 17.6225 21.2267 16.4806 21.2772C15.2425 21.3322 14.8711 21.346 11.7391 21.346C8.60258 21.346 8.23115 21.3322 6.99762 21.2772C5.85122 21.2267 5.23217 21.0341 4.81946 20.8736C4.27378 20.6627 3.87942 20.4059 3.4713 19.9978C3.05859 19.5851 2.80639 19.1953 2.59545 18.6496C2.43495 18.2369 2.24236 17.6133 2.19192 16.4715C2.13689 15.2334 2.12313 14.8619 2.12313 11.73C2.12313 8.59341 2.13689 8.22198 2.19192 6.98845C2.24236 5.84205 2.43495 5.223 2.59545 4.81029C2.80639 4.26461 3.06318 3.87024 3.4713 3.46213C3.884 3.04942 4.27378 2.79721 4.81946 2.58628C5.23217 2.42578 5.85581 2.23319 6.99762 2.18274C8.23115 2.12772 8.60258 2.11396 11.7391 2.11396ZM11.7391 0C8.55214 0 8.15319 0.0137568 6.90133 0.068784C5.65404 0.123811 4.79654 0.325577 4.05367 0.61447C3.2787 0.91712 2.62296 1.31607 1.97181 1.97181C1.31607 2.62296 0.91712 3.2787 0.61447 4.04908C0.325577 4.79654 0.123811 5.64946 0.068784 6.89674C0.0137568 8.15319 0 8.55214 0 11.7391C0 14.9261 0.0137568 15.3251 0.068784 16.5769C0.123811 17.8242 0.325577 18.6817 0.61447 19.4246C0.91712 20.1996 1.31607 20.8553 1.97181 21.5065C2.62296 22.1576 3.2787 22.5611 4.04908 22.8592C4.79654 23.1481 5.64946 23.3499 6.89674 23.4049C8.14861 23.4599 8.54755 23.4737 11.7345 23.4737C14.9215 23.4737 15.3205 23.4599 16.5724 23.4049C17.8196 23.3499 18.6771 23.1481 19.42 22.8592C20.1904 22.5611 20.8461 22.1576 21.4973 21.5065C22.1484 20.8553 22.552 20.1996 22.85 19.4292C23.1389 18.6817 23.3407 17.8288 23.3957 16.5815C23.4507 15.3297 23.4645 14.9307 23.4645 11.7437C23.4645 8.55673 23.4507 8.15778 23.3957 6.90591C23.3407 5.65863 23.1389 4.80112 22.85 4.05825C22.5611 3.2787 22.1622 2.62296 21.5065 1.97181C20.8553 1.32065 20.1996 0.91712 19.4292 0.619056C18.6817 0.330163 17.8288 0.128397 16.5815 0.0733696C15.3251 0.0137568 14.9261 0 11.7391 0Z" fill="#1C301A"/>
        <path d="M11.741 5.70898C8.41185 5.70898 5.71094 8.4099 5.71094 11.739C5.71094 15.0682 8.41185 17.7691 11.741 17.7691C15.0701 17.7691 17.7711 15.0682 17.7711 11.739C17.7711 8.4099 15.0701 5.70898 11.741 5.70898ZM11.741 15.6506C9.58118 15.6506 7.82948 13.8989 7.82948 11.739C7.82948 9.57923 9.58118 7.82753 11.741 7.82753C13.9008 7.82753 15.6525 9.57923 15.6525 11.739C15.6525 13.8989 13.9008 15.6506 11.741 15.6506Z" fill="#1C301A"/>
        <path d="M19.4093 5.47028C19.4093 6.24983 18.7765 6.87806 18.0015 6.87806C17.222 6.87806 16.5938 6.24525 16.5938 5.47028C16.5938 4.69073 17.2266 4.0625 18.0015 4.0625C18.7765 4.0625 19.4093 4.69531 19.4093 5.47028Z" fill="#1C301A"/>
      </svg>
    </div>
    <div class="swiper instagram-slider">
      <div class="swiper-wrapper">
        <div class="swiper-slide">
          <picture class="aspect-ratio br-10">
            <img src="<?= get_template_directory_uri() . '/images/accordine-image.png' ?>" alt="">
          </picture>
        </div>
        <div class="swiper-slide">
          <picture class="aspect-ratio br-10">
            <img src="<?= get_template_directory_uri() . '/images/accordine-image.png' ?>" alt="">
          </picture>
        </div>
        <div class="swiper-slide">
          <picture class="aspect-ratio br-10">
            <img src="<?= get_template_directory_uri() . '/images/accordine-image.png' ?>" alt="">
          </picture>
        </div>
        <div class="swiper-slide">
          <picture class="aspect-ratio br-10">
            <img src="<?= get_template_directory_uri() . '/images/accordine-image.png' ?>" alt="">
          </picture>
        </div>
        <div class="swiper-slide">
          <picture class="aspect-ratio br-10">
            <img src="<?= get_template_directory_uri() . '/images/accordine-image.png' ?>" alt="">
          </picture>
        </div>
        <div class="swiper-slide">
          <picture class="aspect-ratio br-10">
            <img src="<?= get_template_directory_uri() . '/images/accordine-image.png' ?>" alt="">
          </picture>
        </div>
        <div class="swiper-slide">
          <picture class="aspect-ratio br-10">
            <img src="<?= get_template_directory_uri() . '/images/accordine-image.png' ?>" alt="">
          </picture>
        </div>
      </div>
    </div>
  </div>
</section>