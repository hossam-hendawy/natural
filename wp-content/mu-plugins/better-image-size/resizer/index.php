<?php

defined('ABSPATH') || exit;

if (!class_exists('Better_image_sizes_resizer')) {
    class Better_image_sizes_resizer
    {
        private $detector = false;
        private $bis_dir = '';

        function __construct()
        {
            $this->bis_dir = apply_filters('bis_dir_path', $this->get_bis_dir());

            $this->check_bis_dir();

            add_action('admin_menu', array($this, 'admin_menu_item'));
            add_filter('media_row_actions', array($this, 'media_row_action'), 10, 2);
            add_filter('attachment_fields_to_edit', array($this, 'attachment_fields_to_edit'), 10, 2);
            add_action('delete_attachment', array($this, 'delete_attachment_bis_images'));
            add_action('switch_blog', array($this, 'blog_switched'));
            add_filter('intermediate_image_sizes_advanced', array($this, 'remove_disabled_image_sizes'));
            add_filter('bis_get_attachment_image_attributes', array($this, 'retina_attribute'), 10, 4);

            if (intval(get_option('bis_disable_big_image_size_threshold', 0)) === 1) {
                add_filter('big_image_size_threshold', '__return_false');
            }
        }

        // make it works for multisite network
        function blog_switched()
        {
            $this->bis_dir = '';
            $this->bis_dir = apply_filters('bis_dir_path', $this->get_bis_dir());
        }

        function get_bis_dir($path = '')
        {
            if (empty($this->bis_dir)) {
                $wp_upload_dir = wp_upload_dir();
                return $wp_upload_dir['basedir'] . DIRECTORY_SEPARATOR . 'bis-images' . ($path !== '' ? DIRECTORY_SEPARATOR . $path : '');
            } else {
                return $this->bis_dir . ($path !== '' ? DIRECTORY_SEPARATOR . $path : '');
            }
        }

        function check_bis_dir()
        {
            if (!is_dir($this->bis_dir)) {
                wp_mkdir_p($this->bis_dir);
            }
        }

        function bis_dir_writable()
        {
            return is_dir($this->bis_dir) && wp_is_writable($this->bis_dir);
        }

        function delete_all_bis_images()
        {
            if (!function_exists('WP_Filesystem')) return false;
            WP_Filesystem();
            global $wp_filesystem;
            if ($wp_filesystem->rmdir($this->get_bis_dir(), true)) {
                $this->check_bis_dir();
                return true;
            }
            return false;
        }

        function delete_attachment_bis_images($attachment_id = 0)
        {
            if (!function_exists('WP_Filesystem')) return false;
            WP_Filesystem();
            global $wp_filesystem;
            return $wp_filesystem->rmdir($this->get_bis_dir($attachment_id), true);
        }

        function admin_menu_item()
        {
            add_management_page(
                __('Better image sizes', 'bis-images'),
                __('Better image sizes', 'bis-images'),
                'manage_options',
                BIS_BASE,
                array($this, 'options_page')
            );

            add_filter('plugin_action_links_' . BIS_BASE, function ($links, $file) {
                array_unshift($links, '<a href="tools.php?page=' . BIS_BASE . '">' . __('Settings', '_new-plugin') . '</a>');
                return $links;
            }, 10, 2);
        }

        function get_all_image_sizes()
        {
            global $_wp_additional_image_sizes;
            $sizes = array();
            foreach (get_intermediate_image_sizes() as $_size) {
                if (in_array($_size, array('thumbnail', 'medium', 'medium_large', 'large'))) {
                    $sizes[$_size]['w'] = get_option("{$_size}_size_w");
                    $sizes[$_size]['h'] = get_option("{$_size}_size_h");
                } elseif (isset($_wp_additional_image_sizes[$_size])) {
                    $sizes[$_size] = array(
                        'w' => $_wp_additional_image_sizes[$_size]['width'],
                        'h' => $_wp_additional_image_sizes[$_size]['height'],
                    );
                }
            }
            return $sizes;
        }

        function options_page()
        {
            if (isset($_POST['bis_nonce']) && wp_verify_nonce($_POST['bis_nonce'], 'delete_all_bis_images')) {
                $this->delete_all_bis_images();
                echo '<div class="updated"><p>' . esc_html__('All cached images have been deleted.', 'bis-images') . '</p></div>';
            } elseif (isset($_POST['bis_disabled_sizes_nonce']) && wp_verify_nonce($_POST['bis_disabled_sizes_nonce'], 'disabled_sizes')) {
                $sizes = $this->get_all_image_sizes();
                $bis_disabled_sizes = array();
                foreach ($_POST['bis_disabled_sizes'] as $key => $value) {
                    if (isset($sizes[$key])) {
                        $bis_disabled_sizes[$key] = intval($value);
                    }
                }
                update_option('bis_disabled_sizes', $bis_disabled_sizes);
                echo '<div class="updated"><p>' . esc_html__('Disable autogenerated sizes updated.', 'bis-images') . '</p></div>';
            } elseif (isset($_POST['bis_disable_threshold_nonce']) && wp_verify_nonce($_POST['bis_disable_threshold_nonce'], 'disable_threshold')) {
                $disable_threshold = 0;
                if (isset($_POST['bis_disable_big_image_size_threshold'])) {
                    $disable_threshold = intval($_POST['bis_disable_big_image_size_threshold']);
                }
                update_option('bis_disable_big_image_size_threshold', $disable_threshold ? 1 : 0);
                echo '<div class="updated"><p>' . esc_html__('Big image threshold updated.', 'bis-images') . '</p></div>';
            } elseif (isset($_GET['delete-bis-image'], $_GET['ids'], $_GET['bis_nonce']) && wp_verify_nonce($_GET['bis_nonce'], 'delete_bis_image')) {
                $ids = array_map('intval', array_map('trim', explode(',', sanitize_key($_GET['ids']))));
                if (!empty($ids)) {
                    foreach ($ids as $id) {
                        $this->delete_attachment_bis_images($id);
                    }
                    echo '<div class="updated"><p>' . esc_html__('All cached images for this media file have been deleted.', 'bis-images') . '</p></div>';
                }
            } ?>

            <div class="wrap">
            <h2>Better image sizes</h2>

            <div class="card">
                <h3><?php esc_html_e('Images directory', 'bis-images'); ?></h3>
                <p><code><?php echo esc_html($this->get_bis_dir()) ?></code></p>
                <?php if ($this->bis_dir_writable()): ?>
                    <p style="color:#7AD03A"><?php esc_html_e('Writeable', 'bis-images') ?></p>
                <?php else: ?>
                    <p style="color:#A00"><?php esc_html_e('Not Writeable - please make sure this folder exists and is writeable!', 'bis-images') ?></p>
                <?php endif ?>
            </div>

            <div class="card">
                <h3><?php esc_html_e('Disable autogenerated sizes', 'bis-images') ?></h3>
                <p class="notice notice-info notice-large">
                    <?php esc_html_e('You should not disable thumbnail size', 'bis-images'); ?>
                </p>
                <form method="post" action=""><?php
                    wp_nonce_field('disabled_sizes', 'bis_disabled_sizes_nonce');
                    $bis_disabled_sizes = get_option('bis_disabled_sizes', array());
                    $sizes = $this->get_all_image_sizes();
                    foreach ($sizes as $size => $data) {
                        if (!isset($bis_disabled_sizes[$size])) {
                            $bis_disabled_sizes[$size] = 0;
                        } ?>
                        <label>
                            <input type="checkbox" name="bis_disabled_sizes[<?php echo esc_attr($size) ?>]"
                                   value="1" <?php checked($bis_disabled_sizes[$size], 1) ?>>
                            <?php echo esc_html($size) ?> <small>(<?php echo esc_html($data['w'] . 'x' . $data['h']) ?>
                                )</small>
                        </label><br><?php
                    } ?>
                    <br><input class="button button-primary" value="<?php esc_html_e('Save', 'bis-images') ?>"
                               type="submit">
                </form>
            </div>

            <div class="card">
                <h3><?php esc_html_e('Disable big image size threshold', 'bis-images') ?></h3>
                <p><?php esc_html_e('WordPress will automatically scale down your uploaded images, if the original image width or height is above 2560px', 'bis-images') ?></p>
                <form method="post" action="">
                    <?php wp_nonce_field('disable_threshold', 'bis_disable_threshold_nonce') ?>
                    <label>
                        <input type="checkbox" name="bis_disable_big_image_size_threshold"
                               value="1" <?php checked(get_option('bis_disable_big_image_size_threshold', 0), 1) ?>>
                        <?php esc_html_e('disable auto-scaling of big images', 'bis-images') ?>
                    </label><br><br>
                    <input class="button button-primary" value="<?php esc_html_e('Save', 'bis-images') ?>"
                           type="submit">
                </form>
            </div>

            <div class="card">
                <h3><?php esc_html_e('Delete cached images', 'bis-images') ?></h3>
                <p><?php esc_html_e('Delete all generated image sizes for all images', 'bis-images') ?></p>
                <p>
                    <small><?php esc_html_e('* they will be regenerated instantly when you visit your website', 'bis-images') ?></small>
                </p>
                <br>
                <form method="post" action="">
                    <?php wp_nonce_field('delete_all_bis_images', 'bis_nonce') ?>
                    <input class="button button-primary" value="<?php esc_html_e('Delete all', 'bis-images') ?>"
                           type="submit">
                </form>
            </div>
            </div><?php
        }

        function remove_disabled_image_sizes($sizes)
        {
            $bis_disabled_sizes = get_option('bis_disabled_sizes', array());
            foreach ($bis_disabled_sizes as $key => $value) {
                if (intval($value)) {
                    unset($sizes[$key]);
                }
            }
            return $sizes;
        }

        function media_row_action($actions, $post)
        {
            if (in_array($post->post_mime_type, BIS_ALLOWED_MIME_TYPES)) {
                $url = wp_nonce_url(admin_url('tools.php?page=' . BIS_BASE . '&delete-bis-image&ids=' . $post->ID), 'delete_bis_image', 'bis_nonce');
                $actions['bis-image-delete'] = '<a href="' . esc_url($url) . '" title="' . esc_attr(__('Delete all cached image sizes for this image', 'bis-images')) . '">' . __('Regenerate BIS images', 'bis-images') . '</a>';
            }
            return $actions;
        }

        function attachment_fields_to_edit($form_fields, $post)
        {
            if (in_array(get_post_mime_type($post->ID), BIS_ALLOWED_MIME_TYPES)) {
                $url = wp_nonce_url(admin_url('tools.php?page=' . BIS_BASE . '&delete-bis-image&ids=' . $post->ID), 'delete_bis_image', 'bis_nonce');
                $form_fields['regenerate_bis_images'] = array(
                    'value' => 1,
                    'label' => __('Better image sizes', 'better-image-sizes'),
                    'input' => 'html',
                    'html' => '<a class="button button-small" href="' . esc_url($url) . '" title="' . esc_attr(__('Delete all cached image sizes for this image', 'bis-images')) . '">' . __('Regenerate', 'bis-images') . '</a>'
                );
            }
            return $form_fields;
        }

        function get_bis_file_name($file_name, $width, $height, $crop)
        {
            $file_name_only = pathinfo($file_name, PATHINFO_FILENAME);
            $file_extension = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
            $crop_extension = '';
            if ($crop === true || $crop === 1) {
                $crop_extension = '-c';
            } elseif ($crop === 'face') {
                $crop_extension = '-fd';
            } elseif (is_array($crop)) {
                if (is_numeric($crop[0])) {
                    $crop_extension = '-f' . round(floatval($crop[0]) * 100) . '_' . round(floatval($crop[1]) * 100);
                } else {
                    $crop_extension = '-' . implode('', array_map(function ($position) {
                            return $position[0];
                        }, $crop));
                }
            }
            return $file_name_only . '-' . intval($width) . 'x' . intval($height) . $crop_extension . '.' . $file_extension;
        }

        function get_bis_path($absolute_path = '')
        {
            $wp_upload_dir = wp_upload_dir();
            $path = $wp_upload_dir['baseurl'] . str_replace($wp_upload_dir['basedir'], '', $absolute_path);
            return str_replace(DIRECTORY_SEPARATOR, '/', $path);
        }

        function get_attachment_image_src($attachment_id = 0, $size = '', $crop = null)
        {
            if ($attachment_id < 1 || empty($size)) {
                return array();
            }

            if ($size == 'full' || !in_array(get_post_mime_type($attachment_id), BIS_ALLOWED_MIME_TYPES)) {
                $default_attachment = wp_get_attachment_image_src($attachment_id, 'full');
                if (is_array($default_attachment)) {
                    return array_combine(array('src', 'width', 'height', 'resized'), $default_attachment);
                }
                return array();
            }

            $image = wp_get_attachment_metadata($attachment_id);
            if ($image) {
                switch (gettype($size)) {
                    case 'array':
                        $width = $size[0];
                        $height = $size[1];
                        break;
                    default:
                        return array();
                }

                // fix for images with 0 width or height - do not crop them
                if (intval($width) === 0 || intval($height) === 0) {
                    $crop = false;
                }

                // maybe load default focal point
                if ($crop === true || $crop === 1) {
                    $crop = sanitize_focal_point(get_post_meta($attachment_id, 'focal_point', true));
                }

                $bis_dir = $this->get_bis_dir($attachment_id);
                $original_file_path = get_attached_file($attachment_id);
                $original_file_name = basename($original_file_path);
                $original_file_name_only = pathinfo($original_file_name, PATHINFO_FILENAME);
                $original_file_extension = strtolower(pathinfo($original_file_name, PATHINFO_EXTENSION));

                if ($crop === true || $crop === 1) {
                    $crop_extension = '-c';
                } elseif ($crop === 'face') {
                    $crop_extension = '-fd';
                } elseif (is_array($crop)) {
                    if (is_numeric($crop[0])) {
                        $crop_extension = '-f' . round(floatval($crop[0]) * 100) . '_' . round(floatval($crop[1]) * 100);
                    } else {
                        $crop_extension = '-' . implode('', array_map(function ($position) {
                                return $position[0];
                            }, $crop));
                    }
                } else {
                    $crop_extension = '';
                }

                // Generate the base file name without extension
                $base_file_name = $original_file_name_only . '-' . intval($width) . 'x' . intval($height) . $crop_extension;

                $file_name_without_ext = pathinfo($original_file_name, PATHINFO_FILENAME);


                $uploads_info = wp_upload_dir();
                $upload_dir = $uploads_info['basedir'];


                $original_file_dir_var = pathinfo($original_file_path, PATHINFO_DIRNAME);
                $new_file_path_with_avif = $original_file_dir_var . DIRECTORY_SEPARATOR . $original_file_name_only . '.avif';
                $new_file_path_with_webp = $original_file_dir_var . DIRECTORY_SEPARATOR . $original_file_name_only . '.webp';


                $avif_file_name = $base_file_name . '.avif';
                $avif_file_path = $bis_dir . DIRECTORY_SEPARATOR . $avif_file_name;

                $webp_file_name = $base_file_name . '.webp';
                $webp_file_path = $bis_dir . DIRECTORY_SEPARATOR . $webp_file_name;


                $bis_file_path = $bis_dir . DIRECTORY_SEPARATOR . $this->get_bis_file_name($original_file_name, $width, $height, $crop);

                if (
                    file_exists($bis_file_path)
//					&& (!file_exists($new_file_path_with_avif)||file_exists($avif_file_path))
                    && (!file_exists($new_file_path_with_webp) || file_exists($webp_file_path))
                ) {
                    $image_size = getimagesize($bis_file_path);
                    if (!empty($image_size)) {
                        return array(
                            'src' => $this->get_bis_path($bis_file_path),
                            'width' => $image_size[0],
                            'height' => $image_size[1],
                        );
                    } else {
                        return array();
                    }
                }

                //todo add delete here, replace with empty string, remove lasy -fnumber_number.extention
                //todo $remove_image_path = $bis_file_path
                $this->check_bis_dir();

                $image_editor = wp_get_image_editor(get_attached_file($attachment_id));
                if (!is_wp_error($image_editor)) {
                    // maybe do face detection crop
                    if ($crop === 'face') {
                        require_once('face-detector.php');
                        if ($this->detector === false) {
                            $this->detector = new FaceDetector();
                        }
                        $focal_point = $this->detector->faceDetect(get_attached_file($attachment_id));
                        if ($focal_point) {
                            $crop = sanitize_focal_point($focal_point);
                        } else {
                            $crop = sanitize_focal_point(get_post_meta($attachment_id, 'focal_point', true));
                        }
                    }

                    // create new image
                    if (is_array($crop) && is_numeric($crop[0])) {
                        // get original image size
                        $original_sizes = $image_editor->get_size();

                        // sanitize and distribute parameters
                        $dst_w = intval($size[0]);
                        $dst_h = intval($size[1]);
                        $focal_x = floatval($crop[0]);
                        $focal_y = floatval($crop[1]);

                        // maybe replace empty sizes
                        if (!$dst_w) $dst_w = $original_sizes['width'];
                        if (!$dst_h) $dst_h = $original_sizes['height'];

                        // calculate cropped image size
                        $src_w = $original_sizes['width'];
                        $src_h = $original_sizes['height'];

                        if ($original_sizes['width'] / $original_sizes['height'] > $dst_w / $dst_h) {
                            $src_w = round($original_sizes['height'] * ($dst_w / $dst_h));
                        } else {
                            $src_h = round($original_sizes['width'] * ($dst_h / $dst_w));
                        }

                        // calculate focal top left position
                        $src_x = $original_sizes['width'] * $focal_x - $src_w * $focal_x;
                        if ($src_x + $src_w > $original_sizes['width']) {
                            $src_x += $original_sizes['width'] - $src_w - $src_x;
                        }
                        if ($src_x < 0) {
                            $src_x = 0;
                        }
                        $src_x = round($src_x);

                        $src_y = $original_sizes['height'] * $focal_y - $src_h * $focal_y;
                        if ($src_y + $src_h > $original_sizes['height']) {
                            $src_y += $original_sizes['height'] - $src_h - $src_y;
                        }
                        if ($src_y < 0) {
                            $src_y = 0;
                        }
                        $src_y = round($src_y);

                        // crop and resize
                        $image_editor->crop($src_x, $src_y, $src_w, $src_h, $dst_w, $dst_h);
                    } else {
                        $image_editor->resize($width, $height, $crop);
                    }

                    $image_editor->save($bis_file_path);
                    do_action('bis_image_created', $attachment_id, $bis_file_path);

//					if (file_exists($new_file_path_with_avif)) {
//						$image_editor->save($avif_file_path, 'image/avif');
//						do_action('bis_image_created', $attachment_id, $avif_file_path);
//					}

                    if (file_exists($new_file_path_with_webp)) {
                        $image_editor->save($webp_file_path, 'image/webp');
                        do_action('bis_image_created', $attachment_id, $webp_file_path);
                    }

                    // Image created, return its data
                    $image_dimensions = $image_editor->get_size();
                    return array(
                        'src' => $this->get_bis_path($bis_file_path),
                        'width' => $image_dimensions['width'],
                        'height' => $image_dimensions['height'],
                    );
                }
            }

            // Something went wrong
            return array();
        }

        function get_attachment_image($attachment_id = 0, $size = '', $crop = null, $attr = array())
        {
            if ($attachment_id < 1 || empty($size)) {
                return '';
            }

            if ($size == 'full' || !in_array(get_post_mime_type($attachment_id), BIS_ALLOWED_MIME_TYPES)) {
                return wp_get_attachment_image($attachment_id, $size, false, $attr);
            }

            $html = '';
            $image = $this->get_attachment_image_src($attachment_id, $size, $crop);
            if ($image) {
                $hwstring = image_hwstring($image['width'], $image['height']);
                $size_class = $size;
                if (is_array($size_class)) {
                    $size_class = join('x', $size);
                }
                $attachment = get_post($attachment_id);
                $default_attr = array(
                    'src' => $image['src'],
                    'class' => 'attachment-' . $size_class,
                    'alt' => trim(strip_tags(get_post_meta($attachment_id, '_wp_attachment_image_alt', true))),
                );
                if (empty($default_attr['alt'])) {
                    $default_attr['alt'] = trim(strip_tags($attachment->post_excerpt));
                }
                if (empty($default_attr['alt'])) {
                    $default_attr['alt'] = trim(strip_tags($attachment->post_title));
                }

                if (wp_lazy_loading_enabled('img', 'wp_get_attachment_image')) {
                    $default_attr['loading'] = 'lazy';
                }

                $attr = wp_parse_args($attr, $default_attr);

                if (array_key_exists('loading', $attr) && !$attr['loading']) {
                    unset($attr['loading']);
                }

                $attr = apply_filters('bis_get_attachment_image_attributes', $attr, $attachment, $size, $crop);

                $attr = array_map('esc_attr', $attr);
                $html = rtrim("<img $hwstring");
                foreach ($attr as $name => $value) {
                    $html .= " $name=" . '"' . $value . '"';
                }
                $html .= ' />';
            }

            return apply_filters('bis_get_attachment_image', $html, $attachment_id, $size, $attr);
        }


        function get_attachment_picture($attachment_id = 0, $sizes = array(), $attr = array(), $img_attr = array())
        {
            if ($attachment_id < 1 || !is_array($sizes) || count($sizes) === 0) {
                return '';
            }

            // Filter out the sizes that are not 375 or 1440
            $sizes = array_filter($sizes, function($key) {
                return in_array($key, [375, 1440]);
            }, ARRAY_FILTER_USE_KEY);

            ksort($sizes);

            // Handle div class attribute for picture class
            $div_class = isset($attr['picture_class']) ? 'class="' . esc_attr($attr['picture_class']) . '"' : '';

            $last_breakpoint = 0;
            $html = '<div ' . $div_class . '>';
            $html .= '<picture>';
            foreach ($sizes as $breakpoint => $data) {
                if (intval($breakpoint) && count($data) >= 2) {
                    $maybe_alternative_attachment_id = isset($data[3]) && $data[3] ? $data[3] : $attachment_id;
                    $img = bis_get_attachment_image_src($maybe_alternative_attachment_id, array($data[0], $data[1]), isset($data[2]) ? $data[2] : false);
                    if ($img) {
                        mb_internal_encoding('UTF-8');
                        $srcset = $img['src'];
                        $extension = pathinfo($srcset, PATHINFO_EXTENSION);
                        $normalized_srcset = bis_get_attachment_image_src($maybe_alternative_attachment_id, array($data[0], $data[1]), isset($data[2]) ? $data[2] : false)['src'];
                        $wordpressAbsolutePath = ABSPATH;
                        $parsedUrl = parse_url($normalized_srcset);
                        $modifiedUrl = $parsedUrl['path'];
                        $wpContentPath = rtrim($wordpressAbsolutePath, '/') . $modifiedUrl;

                        $base_avif = str_replace('.' . $extension, '.avif', $wpContentPath);
                        $base_webp = str_replace('.' . $extension, '.webp', $wpContentPath);

                        // Check if the base AVIF and WebP files exist
                        $webp_exists = file_exists($base_webp);

                        if (isset($attr['retina']) && $attr['retina']) {
                            $retina = bis_get_attachment_image_src($maybe_alternative_attachment_id, array($data[0] * 2, $data[1] * 2), isset($data[2]) ? $data[2] : false);
                            if ($webp_exists) {
                                $webp_srcset = str_replace('.' . pathinfo($retina['src'], PATHINFO_EXTENSION), '.webp', $retina['src']) . ' 1x, ' . $retina['src'] . ' 2x';
                            }
                            $srcset .= ' 1x, ' . $retina['src'] . ' 2x';
                        }

                        if ($webp_exists) {
                            $html .= '<source media="(max-width:' . intval($breakpoint) . 'px)" srcset="' . $webp_srcset . '" type="image/webp">';
                        }
                        $html .= '<source media="(max-width:' . intval($breakpoint) . 'px)" srcset="' . $srcset . '">';
                        $last_breakpoint = intval($breakpoint);
                    }
                }
            }
            $html .= '<source media="(min-width:' . ($last_breakpoint + 1) . 'px)" srcset="' . wp_get_attachment_url($attachment_id) . '">';

            // Add loading="lazy" attribute to the img_attr
            $img_attr['loading'] = 'lazy';

            // Build img attributes string
            $img_attr_string = '';
            foreach ($img_attr as $key => $value) {
                $img_attr_string .= esc_attr($key) . '="' . esc_attr($value) . '" ';
            }

            // Append the custom attributes directly to the <img> tag
            $html .= str_replace('<img ', '<img ' . $img_attr_string, wp_get_attachment_image($attachment_id, 'full', false, $attr));
            $html .= '</picture>';
            $html .= '</div>';

            return apply_filters('bis_get_attachment_picture', $html, $attachment_id, $sizes, $attr);
        }

        function retina_attribute($attr, $attachment, $size, $crop)
        {
            if (isset($attr['retina'])) {
                unset($attr['retina']);
                $imgx2 = bis_get_attachment_image_src($attachment->ID, array($size[0] * 2, $size[1] * 2), $crop);
                $attr['srcset'] = $attr['src'] . ' 1x, ' . $imgx2['src'] . ' 2x';
            }
            return $attr;
        }
    }

    new Better_image_sizes_resizer();
}

if (!function_exists('bis_get_attachment_image_src')) {
    function bis_get_attachment_image_src($attachment_id = 0, $size = '', $crop = null)
    {
        return (new Better_image_sizes_resizer)->get_attachment_image_src($attachment_id, $size, $crop);
    }
}

if (!function_exists('bis_get_attachment_image')) {
    function bis_get_attachment_image($attachment_id = 0, $size = '', $crop = null, $attr = array())
    {
        return (new Better_image_sizes_resizer)->get_attachment_image($attachment_id, $size, $crop, $attr);
    }
}

if (!function_exists('bis_get_attachment_picture')) {
    function bis_get_attachment_picture($attachment_id = 0, $sizes = array(), $attr = array(), $img_attr = array())
    {
        return (new Better_image_sizes_resizer)->get_attachment_picture($attachment_id, $sizes, $attr, $img_attr);
    }
}

// fallback for fly_ functions

if (!function_exists('fly_get_attachment_image_src')) {
    function fly_get_attachment_image_src($attachment_id = 0, $size = '', $crop = null)
    {
        return bis_get_attachment_image_src($attachment_id, $size, $crop);
    }
}

if (!function_exists('fly_get_attachment_image')) {
    function fly_get_attachment_image($attachment_id = 0, $size = '', $crop = null, $attr = array())
    {
        return bis_get_attachment_image($attachment_id, $size, $crop, $attr);
    }
}