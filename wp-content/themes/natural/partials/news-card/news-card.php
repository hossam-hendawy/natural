<?php
if (isset($args) && is_array($args)) {
  extract($args);
}
$post_id = $post_id ?? get_the_ID();
$post_title = get_the_title($post_id);
$post_permalink = get_permalink($post_id);
$thumbnail_id = get_post_thumbnail_id($post_id);
$location = get_field('location', $post_id);
?>
<div class="swiper-slide project-card">
  <a href="<?= $post_permalink ?>" target="_self">
    <?php
    $picture_class = 'aspect-ratio image-wrapper image-hover-effect';
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
  <a href="<?= $post_permalink ?>" target="_self" class="post-title body navy-color bold"><?= $post_title ?></a>
  <?php if (!empty($location) && is_array($location)) { ?>
    <a class="location body-2 navy-tint-color" href="<?= $location['url'] ?>" target="<?= $location['target'] ?>">
      <svg width="11" height="13" viewBox="0 0 11 13" fill="none" aria-hidden="true">
        <path fill-rule="evenodd" clip-rule="evenodd" d="M6.21637 11.5082C6.02535 11.6977 5.83308 11.8883 5.64082 12.0806C5.44856 11.8883 5.2563 11.6977 5.06527 11.5082C2.8717 9.33303 0.84082 7.31917 0.84082 4.88057C0.84082 2.2296 2.98985 0.0805664 5.64082 0.0805664C8.29179 0.0805664 10.4408 2.2296 10.4408 4.88057C10.4408 7.31917 8.40994 9.33303 6.21637 11.5082ZM7.44082 4.88057C7.44082 5.87468 6.63493 6.68057 5.64082 6.68057C4.64671 6.68057 3.84082 5.87468 3.84082 4.88057C3.84082 3.88645 4.64671 3.08057 5.64082 3.08057C6.63493 3.08057 7.44082 3.88645 7.44082 4.88057Z" fill="#818093"/>
      </svg>
      <?= $location['title'] ?>
    </a>
  <?php } ?>
</div>
