<?php
$id = '';
$className = 'home_here_block';
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
            echo '<img width="100%" height="100%" src="' . get_template_directory_uri() . '/blocks/home_here_block/screenshot.png">';
            return;
        }
    }
}
?>
<?php
$title = get_field('title');
$description = get_field('description');
$cta_button = get_field('cta_button');
$media_image = get_field('image');
$video = get_field('video');
?>
<section id="<?= esc_attr($id) ?>" class="<?= esc_attr($className) ?>">

    <?php if ($select_media = get_field('select_media') === 'video') { ?>
        <div class=" media-wrapper">
            <video playsinline autoplay muted loop src="<?= $video ?>" class="video " data-video-type="video_file"></video>
        </div>
    <?php } else { ?>
        <div>
            <?php
            $picture_class = 'aspect-ratio media-wrapper';
            echo bis_get_attachment_picture(
                $media_image,
                [
                    375 => [375, 785, 1],
                    600 => [600, 1256, 1],
                    768 => [708, 321, 1],
                    992 => [932, 422, 1],
                    1024 => [964, 437, 1],
                    1280 => [1220, 553, 1],
                    1440 => [1380, 625, 1]
                ],
                [
                    'retina' => true, 'picture_class' => $picture_class,
                ],
            );
            ?>
        </div>
    <?php } ?>

    <div class="green-bg">
        <div class="container">
            <div class="content-wrapper">
                <div class="content-inside-wrapper">
                    <svg class="corner trc" width="7" height="7" viewBox="0 0 7 7" fill="none">
                        <path opacity="0.5" d="M0.212232 1C3.40657 1 5.99609 3.58952 5.99609 6.78386" stroke="#FFFDE7"
                              stroke-width="0.827039"/>
                    </svg>
                    <svg class="corner tlc" width="7" height="7" viewBox="0 0 7 7" fill="none">
                        <path opacity="0.5" d="M1 6.78386C1 3.58952 3.58952 1 6.78386 1" stroke="#FFFDE7" stroke-width="0.827039"/>
                    </svg>
                    <svg class="corner brc" width="7" height="7" viewBox="0 0 7 7" fill="none">
                        <path opacity="0.5" d="M5.99609 0.216138C5.99609 3.41048 3.40657 6 0.21223 6" stroke="#FFFDE7" stroke-width="0.827039"/>
                    </svg>
                    <svg class="corner blc" width="7" height="7" viewBox="0 0 7 7" fill="none">
                        <path opacity="0.5" d="M6.78386 6C3.58952 6 1 3.41048 1 0.216137" stroke="#FFFDE7" stroke-width="0.827039"/>
                    </svg>
                    <svg class="corner tcc" width="13" height="7" viewBox="0 0 13 7" fill="none">
                        <path d="M6.25293 6.78386C6.25293 3.58952 8.84245 1 12.0368 1" stroke="#FFFDE7" stroke-width="0.827039" opacity="0.5"/>
                        <path d="M0.46907 0.999998C3.66341 0.999999 6.25293 3.58952 6.25293 6.78386" stroke="#FFFDE7" stroke-width="0.827039" opacity="0.5"/>
                    </svg>
                    <svg class="corner bcc" width="12" height="7" viewBox="0 0 12 7" fill="none">
                        <path d="M6.14502 7.50124e-05C6.14502 3.19441 3.5555 5.78394 0.361158 5.78394" stroke="#FFFDE7" stroke-width="0.827039" opacity="0.5"/>
                        <path d="M11.9289 5.78394C8.73454 5.78394 6.14502 3.19441 6.14502 7.4029e-05" stroke="#FFFDE7" stroke-width="0.827039" opacity="0.5"/>
                    </svg>
                    <svg class="corner mrc" width="7" height="12" viewBox="0 0 7 12" fill="none">
                        <path d="M0.208326 5.78369C3.40266 5.78369 5.99219 8.37321 5.99219 11.5676" stroke="#FFFDE7" stroke-width="0.827039" opacity="0.5"/>
                        <path d="M5.99219 -0.00016962C5.99219 3.19417 3.40266 5.78369 0.208325 5.78369" stroke="#FFFDE7" stroke-width="0.827039" opacity="0.5"/>
                    </svg>
                    <svg class="corner mlc" width="7" height="12" viewBox="0 0 7 12" fill="none">
                        <path d="M6.78386 5.78394C3.58952 5.78394 1 3.19441 1 7.35372e-05" stroke="#FFFDE7" stroke-width="0.827039" opacity="0.5"/>
                        <path d="M0.999999 11.5678C1 8.37346 3.58952 5.78394 6.78386 5.78394" stroke="#FFFDE7" stroke-width="0.827039" opacity="0.5"/>
                    </svg>
                    <?php if ($title): ?>
                        <h1 class="natural-h1 main-title"><?= $title ?></h1>
                    <?php endif; ?>
                    <?php if ($description): ?>
                        <div class="fz-24 description fw-200"><?= $description ?></div>
                    <?php endif; ?>
                    <?php if (!empty($cta_button) && is_array($cta_button)) { ?>
                        <a class="cta-button" href="<?= $cta_button['url'] ?>" target="<?= $cta_button['target'] ?>"><?= $cta_button['title'] ?></a>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</section>