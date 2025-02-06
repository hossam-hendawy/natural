<?php
if (isset($args) && is_array($args)) {
  extract($args);
}
$post_id = $post_id ?? get_the_ID();
$post_title = get_the_title($post_id);
$post_permalink = get_permalink($post_id);
$thumbnail_id = get_post_thumbnail_id($post_id);

?>
<div class="swiper-slide news-card">
  <a href="<?= $post_permalink ?>" target="_self">
    <?php
    $picture_class = 'aspect-ratio image-wrapper';
    echo bis_get_attachment_picture(
        $thumbnail_id,
        [
            375 => [335, 206, 1],
            1024 => [305, 187, 1],
            1280 => [365, 224, 1],
            1440 => [418, 257, 1],
            1920 => [418, 257, 1],
            2500 => [418, 257, 1]
        ],
        [
            'retina' => true, 'picture_class' => $picture_class,
        ]
    );
    ?>
  </a>
  <a href="<?= $post_permalink ?>" target="_self" class="post-title natural-h6 fw-400"><?= $post_title ?></a>
  <a class="cta-link fz-16 spinach-color  fw-400" href="<?= $post_permalink ?>" target="_self">
    Read Article
    <svg width="15" height="12" viewBox="0 0 15 12" fill="none" aria-hidden="true">
      <path d="M11.0332 4.18271e-07L8.59375 0C8.59375 2.4252 9.50345 3.79726 10.476 4.57086C11.287 5.21576 12.2971 5.55899 13.3333 5.55899C12.2971 5.55899 11.287 5.90178 10.476 6.54712C9.50301 7.32072 8.59375 8.69234 8.59375 11.118L11.0332 11.118C11.0332 11.118 10.7448 6.62143 14.5743 5.55943C10.7448 4.49656 11.0332 4.18271e-07 11.0332 4.18271e-07Z" fill="#1C301A"/>
      <path d="M9.66851 5.55855C5.83344 4.49656 6.12221 1.04972e-06 6.12221 1.04972e-06L3.67917 6.30837e-07C3.67917 2.4252 4.59022 3.79726 5.56415 4.57086C5.97118 4.8942 6.42825 5.14145 6.91367 5.30776L-7.06768e-07 3.96401L-1.27553e-06 7.15397L6.91367 5.81023C6.42825 5.97654 5.97162 6.22379 5.5646 6.54712C4.59022 7.32072 3.67961 8.69234 3.67961 11.118L6.12265 11.118C6.12265 11.118 5.83388 6.62143 9.66895 5.55943" fill="#1C301A"/>
    </svg>
  </a>
</div>
