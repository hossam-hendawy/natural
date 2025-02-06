<?php
$id = '';
$className = 'latest_news_block';
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
      echo '<img width="100%" height="100%" src="' . get_template_directory_uri() . '/blocks/latest_news_block/screenshot.png">';
      return;
    }
  }
}
?>

<?php
$title = get_field('title');
$cta_button = get_field('cta_button');
$programmatic_or_manual = get_field("programmatic_or_manual");

if ($programmatic_or_manual === 'programmatic') {
  $query_options = get_field("query_options") ?: [];
  $number_of_posts = isset($query_options['number_of_posts']) ? (int)$query_options['number_of_posts'] : 3;
  if ($number_of_posts > 3) {
    $number_of_posts = 3;
  }
  $order = isset($query_options['order']) && in_array($query_options['order'], ['asc', 'desc']) ? $query_options['order'] : 'DESC';
  $args = [
      "post_type" => "post",
      "posts_per_page" => $number_of_posts,
      "order" => $order,
      "post_status" => "publish",
      "paged" => 1,
      'orderby' => 'date',
  ];
  $the_query = new WP_Query($args);
}
?>
<section id="<?= esc_attr($id) ?>" class="<?= esc_attr($className) ?>">
  <div class="container">
    <div class="top-content-wrapper">
      <?php if ($title): ?>
        <h3 class="en-h3 animation-fade-me-up"><?= esc_html($title) ?></h3>
      <?php endif; ?>
      <?php if (!empty($cta_button) && is_array($cta_button)): ?>
        <a class="cta-button blue-cta desktop-only animation-fade-me-up" href="<?= esc_url($cta_button['url']) ?>" target="<?= esc_attr($cta_button['target']) ?>">
          <?= esc_html($cta_button['title']) ?>
        </a>
        <a class="link mobile-only animation-fade-me-up" href="<?= esc_url($cta_button['url']) ?>" target="<?= esc_attr($cta_button['target']) ?>">
          all
          <svg width="8" height="9" viewBox="0 0 8 9" fill="none" aria-hidden="true">
            <path d="M0.764648 7.9668L7 1.73145M7 1.73145H0.764648M7 1.73145V7.9668" stroke="#0B0A40" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
          </svg>
        </a>
      <?php endif; ?>
    </div>
    
    <?php if ($programmatic_or_manual === "manual") { ?>
      <div class="swiper recent-projects-Swiper">
        <div class="swiper-wrapper">
          <?php foreach (get_field("project_card") as $card):
            get_template_part("partials/news-card/news-card", "", ["post_id" => $card->ID]);
          endforeach; ?>
        </div>
      </div>
    <?php } elseif (isset($the_query) && $the_query->have_posts()) { ?>
      <div class="swiper recent-projects-Swiper">
        <div class="swiper-wrapper">
          <?php while ($the_query->have_posts()) {
            $the_query->the_post();
            get_template_part("partials/news-card/news-card", "", ["post_id" => get_the_ID()]);
          } ?>
          <?php wp_reset_postdata(); ?>
        </div>
      </div>
    <?php } ?>
    <div class="swiper-navigations">
      <div class="swiper-button-prev swiper-navigation arrow" role="button" tabindex="0" aria-label="Previous Slide">
        <svg width="18" height="18" viewBox="0 0 18 18" fill="none" aria-hidden="true">
          <path d="M16.0339 8.61946H5.26195L8.21058 5.67085L6.94689 4.40717L1.89209 9.46194L6.94687 14.5167L8.21055 13.253L5.26195 10.3044H16.0339V8.61946Z" fill="#0B0A40"/>
        </svg>
      </div>
      <div class="swiper-button-next swiper-navigation arrow" role="button" tabindex="0" aria-label="Next Slide">
        <svg width="18" height="18" viewBox="0 0 18 18" fill="none" aria-hidden="true">
          <path d="M1.95389 8.63258H12.7258L9.77721 5.68398L11.0409 4.42029L16.0957 9.47506L11.0409 14.5298L9.77724 13.2662L12.7258 10.3175H1.95389V8.63258Z" fill="#0B0A40"/>
        </svg>
      </div>
    </div>
  </div>
</section>












