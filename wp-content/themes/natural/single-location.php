<?php get_header(); ?>
<?php
$post_id = get_the_ID();
$select_media = get_field('select_media', $post_id);
$media_image = get_field('image', $post_id);
$video = get_field('video', $post_id);
$video_title = get_field('video_title', $post_id);
?>

<?php if (have_posts()): the_post(); ?>
  <!--   single hero block-->
  <section class="single_hero_block">
    <?php if ($video_title): ?>
      <div class="video-title">
        <div class="top-line line"></div>
        <h1 class="map-h1 white-color text-center  text-uppercase"><?= $video_title ?></h1>
        <div class="bottom-line line"></div>
      </div>
    <?php endif; ?>
    <?php if ($select_media === 'video') { ?>
      <div class="aspect-ratio media-wrapper">
        <video playsinline autoplay muted loop src="<?= $video ?>" class="video " data-video-type="video_file"></video>
      </div>
    <?php } else { ?>
      <div>
        <?php
        $picture_class = 'aspect-ratio media-wrapper';
        echo bis_get_attachment_picture(
            $media_image,
            [
                375 => [375, 156, 1],
                600 => [600, 250, 1],
                768 => [768, 320, 1],
                992 => [992, 413, 1],
                1024 => [1024, 427, 1],
                1280 => [1280, 533, 1],
                1440 => [1440, 600, 1],
                1920 => [1920, 800, 1],
                3840 => [3840, 1600, 1]
            ],
            [
                'retina' => true, 'picture_class' => $picture_class,
            ],
        );
        ?>
      </div>
    <?php } ?>
  </section>
  <?php the_content(); ?>
<?php endif; ?>
  
  <!-- region related location-->
<?php
$manual = get_field("select_related_locations_manually");
if (!$manual) {
  
  $terms = get_the_terms($post_id, 'industry');
  
  if ($terms && !is_wp_error($terms)) {
    $term_ids = wp_list_pluck($terms, 'term_id');
    
    $args = [
        'post_type' => 'location',
        'posts_per_page' => 2,
        'post__not_in' => [$post_id],
        'orderby' => 'date',
        'order' => 'DESC',
        'tax_query' => [
            [
                'taxonomy' => 'industry',
                'field' => 'term_id',
                'terms' => $term_ids,
            ]
        ],
    ];
    
    $the_query = new WP_Query($args);
  }
}
?>
  <section class="relates-posts-wrapper">
    <div class="container">
      <?php if ($manual) { ?>
        <div class="map-h1 white-color main-title">other properties</div>
        <div class="posts-wrapper">
          <?php foreach (get_field("related_locations") as $card):
            get_template_part("partials/related_location_card/related_location_card", "", ["post_id" => $card->ID]);
          endforeach; ?>
        </div>
      <?php } elseif (isset($the_query) && $the_query->have_posts()) { ?>
        <div class="map-h1 white-color main-title">other properties</div>
        <div class="posts-wrapper">
          <?php while ($the_query->have_posts()) {
            $the_query->the_post();
            get_template_part("partials/related_location_card/related_location_card", "", ["post_id" => get_the_ID()]);
          } ?>
          <?php wp_reset_postdata(); ?>
        </div>
      <?php } ?>
    </div>
  </section>
  <!-- endregion related location-->
<?php get_footer(); ?>