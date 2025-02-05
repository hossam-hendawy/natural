<?php
get_header();
?>

<?php
$id = '';
$className = 'hero_block';
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
            echo '<img width="100%" height="100%" src="' . get_template_directory_uri() . '/blocks/hero_block/screenshot.png">';
            return;
        }
    }
}
?>
<div class="page-not-found">
  <div class="container">
    <div class="content-wrapper">
          <h1  class="main-title es-h1 navy-color text-center">
            404
          </h1>
          <div class="description body navy-color text-center">
            Sorry, the page you are looking for could not be found. It might have been removed, renamed, or did not exist in the first place.
          </div>
        <a href="<?php site_url(); ?>"
           class="cta-button main-cta-button has-icon" >
          Back to Home
        </a>
    </div>
  </div>
</div>
<?php get_footer(); ?>


