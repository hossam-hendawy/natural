<?php
$id = '';
$className = 'get_started_block';
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
      echo '<img width="100%" height="100%" src="' . get_template_directory_uri() . '/blocks/get_started_block/screenshot.png">';
      return;
    }
  }
}
?>
<?php
$title = get_field('title');
$first_cta = get_field('first_cta');
$second_cta = get_field('second_cta');
?>
<section id="<?= esc_attr($id) ?>" class="<?= esc_attr($className) ?>">
  <div class="container">
    <div class="content-wrapper br-10">
      <?php if ($title): ?>
        <h4 class="main-title natural-h4"><?= $title ?></h4>
      <?php endif; ?>
      <div class="cta-wrapper">
        
        <?php if (!empty($first_cta) && is_array($first_cta)) { ?>
          <a class="cta-button" href="<?= $first_cta['url'] ?>" target="<?= $first_cta['target'] ?>">
            <?= $first_cta['title'] ?>
            <svg class="circle-arrow" width="33" height="33" viewBox="0 0 33 33" fill="none" aria-hidden="true">
              <circle cx="16.5" cy="16.5" r="16.5" fill="#1C301A"/>
              <path d="M20.2417 11H17.8984C17.8984 13.193 18.7723 14.4336 19.7064 15.1331C20.4855 15.7163 21.4558 16.0266 22.4511 16.0266C21.4558 16.0266 20.4855 16.3366 19.7064 16.9201C18.7718 17.6197 17.8984 18.8599 17.8984 21.0533H20.2417C20.2417 21.0533 19.9647 16.9873 23.6432 16.027C19.9647 15.0659 20.2417 11 20.2417 11Z"
                    fill="#96F56D"/>
              <path d="M18.9757 16.0262C15.4154 15.0659 15.6835 11 15.6835 11H13.4155C13.4155 13.193 14.2613 14.4336 15.1655 15.1331C15.5433 15.4255 15.9676 15.6491 16.4183 15.7995L10 14.5844V17.4689L16.4183 16.2538C15.9676 16.4042 15.5437 16.6278 15.1659 16.9201C14.2613 17.6197 13.416 18.8599 13.416 21.0533H15.6839C15.6839 21.0533 15.4159 16.9873 18.9761 16.027"
                    fill="#96F56D"/>
            </svg>
          </a>
        <?php } ?>
        <?php if (!empty($second_cta) && is_array($second_cta)) { ?>
          <a class="cta-button" href="<?= $second_cta['url'] ?>" target="<?= $second_cta['target'] ?>">
            <?= $second_cta['title'] ?>
            <svg class="circle-arrow" width="33" height="33" viewBox="0 0 33 33" fill="none" aria-hidden="true">
              <circle cx="16.5" cy="16.5" r="16.5" fill="#1C301A"/>
              <path d="M20.2417 11H17.8984C17.8984 13.193 18.7723 14.4336 19.7064 15.1331C20.4855 15.7163 21.4558 16.0266 22.4511 16.0266C21.4558 16.0266 20.4855 16.3366 19.7064 16.9201C18.7718 17.6197 17.8984 18.8599 17.8984 21.0533H20.2417C20.2417 21.0533 19.9647 16.9873 23.6432 16.027C19.9647 15.0659 20.2417 11 20.2417 11Z"
                    fill="#96F56D"/>
              <path d="M18.9757 16.0262C15.4154 15.0659 15.6835 11 15.6835 11H13.4155C13.4155 13.193 14.2613 14.4336 15.1655 15.1331C15.5433 15.4255 15.9676 15.6491 16.4183 15.7995L10 14.5844V17.4689L16.4183 16.2538C15.9676 16.4042 15.5437 16.6278 15.1659 16.9201C14.2613 17.6197 13.416 18.8599 13.416 21.0533H15.6839C15.6839 21.0533 15.4159 16.9873 18.9761 16.027"
                    fill="#96F56D"/>
            </svg>
          </a>
        <?php } ?>
      
      </div>
    </div>
  </div>
</section>