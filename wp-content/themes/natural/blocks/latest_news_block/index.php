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
        <h3 class="natural-h3 title capitalize-text"><?= esc_html($title) ?></h3>
      <?php endif; ?>
      <div class="swiper-navigations">
        <div class="swiper-button-prev swiper-navigation arrow" role="button" tabindex="0" aria-label="Previous Slide">
          <svg width="30" height="30" viewBox="0 0 30 30" fill="none" aria-hidden="true">
            <circle cx="15" cy="15" r="14.5" transform="rotate(-180 15 15)" stroke="#1C301A"/>
            <path d="M11.9056 19.1992L13.9062 19.1992C13.9063 17.2103 13.1602 16.085 12.3626 15.4506C11.6975 14.9217 10.8691 14.6402 10.0193 14.6402C10.8691 14.6402 11.6975 14.3591 12.3626 13.8299C13.1606 13.1954 13.9063 12.0705 13.9063 10.0812L11.9056 10.0812C11.9056 10.0812 12.1421 13.7689 9.00156 14.6399C12.1421 15.5115 11.9056 19.1992 11.9056 19.1992Z"
                  fill="#1C301A"/>
            <path d="M13.0239 14.6406C16.1691 15.5115 15.9322 19.1992 15.9322 19.1992L17.9358 19.1992C17.9358 17.2103 17.1886 16.085 16.3899 15.4506C16.0561 15.1854 15.6812 14.9827 15.2831 14.8463L20.9531 15.9483L20.9531 13.3322L15.2831 14.4342C15.6812 14.2978 16.0557 14.095 16.3895 13.8299C17.1886 13.1954 17.9354 12.0705 17.9354 10.0812L15.9319 10.0812C15.9319 10.0812 16.1687 13.7689 13.0235 14.6399"
                  fill="#1C301A"/>
          </svg>
        </div>
        <div class="swiper-button-next swiper-navigation arrow" role="button" tabindex="0" aria-label="Next Slide">
          <svg width="30" height="30" viewBox="0 0 30 30" fill="none" aria-hidden="true">
            <circle cx="15" cy="15" r="14.5" stroke="#1C301A"/>
            <path d="M18.0944 10.8008L16.0938 10.8008C16.0937 12.7897 16.8398 13.915 17.6374 14.5494C18.3025 15.0783 19.1309 15.3598 19.9807 15.3598C19.1309 15.3598 18.3025 15.6409 17.6374 16.1701C16.8394 16.8046 16.0937 17.9295 16.0937 19.9188L18.0944 19.9188C18.0944 19.9188 17.8579 16.2311 20.9984 15.3601C17.8579 14.4885 18.0944 10.8008 18.0944 10.8008Z" fill="#1C301A"/>
            <path d="M16.9761 15.3594C13.8309 14.4885 14.0678 10.8008 14.0678 10.8008L12.0642 10.8008C12.0642 12.7897 12.8114 13.915 13.6101 14.5494C13.9439 14.8146 14.3188 15.0173 14.7169 15.1537L9.04687 14.0517L9.04687 16.6678L14.7169 15.5658C14.3188 15.7022 13.9443 15.905 13.6105 16.1701C12.8114 16.8046 12.0646 17.9295 12.0646 19.9188L14.0681 19.9188C14.0681 19.9188 13.8313 16.2311 16.9765 15.3601" fill="#1C301A"/>
          </svg>
        </div>
      </div>
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
  </div>
</section>












