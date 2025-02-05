<?php get_header(); ?>
<?php
$post_id = get_the_ID();
$hide_sidebar = get_field('hide_sidebar', $post_id);
?>

    <!-- region hero block -->
    <section id="single_hero_block" class="single_hero_block">
        <div class="square-wrapper square-wrapper-left">
            <div class="square square-1"></div>
            <div class="square square-2"></div>
        </div>
        <div class="square-wrapper square-wrapper-right">
            <div class="square square-1"></div>
            <div class="square square-2"></div>
        </div>
        <div class="mobile-square-1"></div>
        <div class="mobile-square-2"></div>
        <div class="container">
            <div class="content-wrapper">
                <h1 class="en-h1 post-title medium navy-color text-center"><?php the_title(); ?></h1>
                <div class="body-2 regular navy-color text-center">See project details</div>
                <div class="line"></div>
            </div>
        </div>
    </section>
    <!-- endregion-->

    <!-- region single content -->
    <section class="single-content">
        <div class="container">
            <div class="content-wrapper">
                <?php if (!$hide_sidebar) { ?>
                    <div class="left-content-wrapper">
                        <div class="sticky-project-sidebar">
                            <?php if (have_rows('project_overview_card')) { ?>
                                <div class="box">
                                    <div class="title body-2 bold navy-color">Overview</div>
                                    <?php while (have_rows('project_overview_card')) {
                                        the_row();
                                        $label = get_sub_field('label');
                                        $value = get_sub_field('value');
                                        ?>
                                        <div class="key-and-val">
                                            <div class="key body bold navy-color"><?= $label ?></div>
                                            <div class="body-2 regular navy-color"><?= $value ?></div>
                                        </div>
                                    <?php } ?>
                                </div>
                            <?php } ?>
                            <div class="desktop">
                                <?php
                                get_template_part("partials/contact-number/contact-number", "", ["no-box" => true]);
                                ?>
                            </div>
                        </div>
                    </div>
                <?php } ?>
                <div class="right-content-wrapper">
                    <?php the_content(); ?>
                    <div class="mobile">
                        <?php
                        get_template_part("partials/contact-number/contact-number", "", ["no-box" => true]);
                        ?>
                    </div>
                    <a class="cta-link body-2 regular navy-color" href="<?= site_url('projects') ?>">
                        <svg width="7" height="10" viewBox="0 0 7 10" fill="none" aria-hidden="true">
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M-0.000229084 5.26186L5.21337 9.77494L6.13281 8.96155L1.83617 5.24654L6.02675 1.45342L5.10959 0.642044L-0.000229084 5.26186Z" fill="#0B0A40"/>
                        </svg>
                        Back to all projects</a>
                </div>
            </div>
        </div>
    </section>
    <!-- endregion-->

    <!--  region recent projects block -->
    <section id="recent_projects_block" class="recent_projects_block in-single-page">
        <div class="container">
            <div class="top-content-wrapper">
                <h3 class="en-h3 animation-fade-me-up">More Projects</h3>
                <a class="cta-button blue-cta desktop-only animation-fade-me-up" href="#" target="_self">
                    See more projects
                </a>
                <a class="link mobile-only animation-fade-me-up" href="#" target="_self">
                    all
                    <svg width="8" height="9" viewBox="0 0 8 9" fill="none" aria-hidden="true">
                        <path d="M0.764648 7.9668L7 1.73145M7 1.73145H0.764648M7 1.73145V7.9668" stroke="#0B0A40" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </a>
            </div>
            <?php
            $current_post_id = get_the_ID();
            $args = [
                'post_type' => 'post',
                'posts_per_page' => 3,
                'post__not_in' => [$current_post_id],
                'orderby' => 'date',
                'order' => 'DESC',
            ];
            $query = new WP_Query($args);
            ?>
            <?php if ($query->have_posts()): ?>
                <div class="swiper recent-projects-Swiper">
                    <div class="swiper-wrapper">
                        <?php while ($query->have_posts()): $query->the_post(); ?>
                            <?php
                            get_template_part("partials/project-card/project-card", "", ["post_id" => get_the_ID()]);
                            ?>
                        <?php endwhile; ?>
                    </div>
                </div>
                <?php wp_reset_postdata(); ?>
            <?php endif; ?>
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
    <!-- endregion-->
<?php get_footer(); ?>