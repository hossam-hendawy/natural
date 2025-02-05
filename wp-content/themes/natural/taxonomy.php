<?php
get_header();
$term = get_queried_object();
$term_id = $term->term_id;
$term_name = $term->name;
$term_count = $term->count;
$parent_term = get_term($term->parent, $term->taxonomy);
$is_parent = !$parent_term || is_wp_error($parent_term);
?>
<section class="work-title-block  <?php echo ($is_parent) ? '' : 'not-parent'; ?>">
  <div class="container">
    <div class="row align-end">
      <div class="col-7 col-sm-12">
        <div class="headline">
          <h1 class="hh-h1">
            <?php
            if (!$is_parent) {
              echo '<span class="parent">' . esc_html($parent_term->name) . ' <svg xmlns="http://www.w3.org/2000/svg" width="66" height="104" viewBox="0 0 66 104" fill="none"> <path d="M1 103L65 1" stroke="#EBEBEB"/> </svg></span> ';
            }
            ?>
            <span class="child"><?php echo esc_html($term_name); ?></span>
          </h1>
          <?php if ($is_parent) { ?>
            <span class="subheadline hh-h3-regular"><?php echo esc_html($term_count); ?></span>
          <?php } ?>
        </div>
      </div>
      <div class="col-5 col-sm-12">
        <?php if (!$is_parent) {
          ?>
          <a href="<?= get_term_link($parent_term) ?>" class="button-arrow left">
            <span class="hh-body-regular">back</span>
            <svg class="icon">
              <use xlink:href="#Variant=Left"></use>
            </svg>
          </a>
        <?php } ?>
      </div>
    </div>
  </div>
</section>

<?php if ($is_parent) { ?>
  <section class="work-filter-block no-padding">
    <div class="container">
      <div class="row space-between align-end">
        <div class="col-5 col-sm-12">
          <h2 class="main-heading hh-h2">
            <?php
            $term_description = term_description($term->term_id, 'work');
            if ($term_description) {
              echo wp_kses_post($term_description);
            }
            ?>
          </h2>
        </div>
        <div class="col-7 col-sm-12">
          <div class="swiper-container navigation">
            <div class="swiper-wrapper justify-end-desktop">
              <?php
              $current_term = get_queried_object();
              $all_work_url = site_url('/all-work/');
              $all_work_active_class = (is_null($current_term) || $current_term->taxonomy !== 'work') ? 'active' : '';
              ?>
              <div class="swiper-slide">
                <a class="nav-item hh-body-regular <?php echo esc_attr($all_work_active_class); ?>"
                   href="<?php echo esc_url($all_work_url); ?>">
                  All Work
                </a>
              </div>
              <?php
              $current_term = get_queried_object();
              $terms = get_terms(array(
                  'taxonomy' => 'work',
                  'hide_empty' => true,
                  'parent' => 0
              ));
              if (!empty($terms) && !is_wp_error($terms)) {
                foreach ($terms as $term) {
                  $term_link = get_term_link($term);
                  if (!is_wp_error($term_link)) {
                    $active_class = ($current_term->term_id == $term->term_id) ? 'active' : '';
                    ?>
                    <div class="swiper-slide">
                      <a class="nav-item hh-body-regular <?php echo esc_attr($active_class); ?>"
                         tabindex="0"
                         href="<?php echo esc_url($term_link); ?>">
                        <?php echo esc_html($term->name); ?>
                      </a>
                    </div>
                    <?php
                  }
                }
              }
              ?>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
<?php } ?>
<section class="work-details-block work-1-animate-me-barba hh-ul-style">
  <div class="container">
    <div class="line-thick"></div>
    <?php if (have_rows('work_service_builder', 'term_' . $term_id)) : ?>
      <?php while (have_rows('work_service_builder', 'term_' . $term_id)) : the_row(); ?>
        
        <?php if (get_row_layout() == 'text') : ?>
          <div class="line-not-thick"></div>
          <div class="title-and-one-column-big-des mb-64">
            <div class="row">
              <h3 class="text-left hh-h3-medium col-6 col-sm-12">
                <?php the_sub_field('left_headline'); ?>
              </h3>
              <div class="text-right hh-h3-regular col-6 col-sm-12">
                <?php the_sub_field('right_text'); ?>
              </div>
            </div>
          </div>
        <?php endif; ?>
        
        <?php if (get_row_layout() == 'list') : ?>
          <div class="line-not-thick"></div>
          <div class="row mb-64">
            <div class="text-left hh-h3-medium col-6 col-sm-12">
              <?php the_sub_field('left_headline'); ?>
            </div>
            <div class="list-wrapper row col-6 col-sm-12">
              <?php
              // Get the sub_services_list repeater field
              $sub_services = get_sub_field('sub_services_list');
              if ($sub_services) :
                // Calculate the split index
                $split_index = ceil(count($sub_services) / 2);
                ?>
                <div class="list col-6 col-sm-12">
                  <?php for ($i = 0; $i < $split_index; $i++) : ?>
                    <div class="link-wrapper">
                      <?php if ($sub_services[$i]['just_text']) : ?>
                        <p class="hh-h3-regular"><?php echo $sub_services[$i]['text']; ?></p>
                      <?php else : ?>
                        <a class="hh-h3-regular"
                           href="<?php echo $sub_services[$i]['link']['url']; ?>"
                           target="<?php echo $sub_services[$i]['link']['target']; ?>"><?php echo $sub_services[$i]['link']['title']; ?></a>
                        <svg width="16" height="16" viewBox="0 0 16 16" fill="none"
                             xmlns="http://www.w3.org/2000/svg">
                          <path
                              d="M10.5462 3.75378L8.86621 3.75378V5.43378H10.5462V3.75378Z"
                              fill="#949499"/>
                          <path d="M12.2259 5.43378H10.5459V7.11378H12.2259V5.43378Z"
                                fill="#949499"/>
                          <path d="M12.2259 8.79376H10.5459V10.4738H12.2259V8.79376Z"
                                fill="#949499"/>
                          <path d="M10.5462 10.4738H8.86621V12.1538H10.5462V10.4738Z"
                                fill="#949499"/>
                          <path
                              d="M13.91 7.11377L2 7.11377L2 8.79377L13.91 8.79377V7.11377Z"
                              fill="#949499"/>
                        </svg>
                      <?php endif; ?>
                    </div>
                  <?php endfor; ?>
                </div>
                <div class="list col-6 col-sm-12">
                  <?php for ($i = $split_index; $i < count($sub_services); $i++) : ?>
                    <div class="link-wrapper">
                      <?php if ($sub_services[$i]['just_text']) : ?>
                        <p class="hh-h3-regular"><?php echo $sub_services[$i]['text']; ?></p>
                      <?php else : ?>
                        <a class="hh-h3-regular"
                           href="<?php echo $sub_services[$i]['link']['url']; ?>"
                           target="<?php echo $sub_services[$i]['link']['target']; ?>"><?php echo $sub_services[$i]['link']['title']; ?></a>
                        <svg width="16" height="16" viewBox="0 0 16 16" fill="none"
                             xmlns="http://www.w3.org/2000/svg">
                          <path
                              d="M10.5462 3.75378L8.86621 3.75378V5.43378H10.5462V3.75378Z"
                              fill="#949499"/>
                          <path d="M12.2259 5.43378H10.5459V7.11378H12.2259V5.43378Z"
                                fill="#949499"/>
                          <path d="M12.2259 8.79376H10.5459V10.4738H12.2259V8.79376Z"
                                fill="#949499"/>
                          <path d="M10.5462 10.4738H8.86621V12.1538H10.5462V10.4738Z"
                                fill="#949499"/>
                          <path
                              d="M13.91 7.11377L2 7.11377L2 8.79377L13.91 8.79377V7.11377Z"
                              fill="#949499"/>
                        </svg>
                      <?php endif; ?>
                    </div>
                  <?php endfor; ?>
                </div>
              <?php endif; ?>
            </div>
          </div>
        <?php endif; ?>
        
        <?php if (get_row_layout() == 'similar') : ?>
          <div class="line-not-thick"></div>
          <div class="title-and-similar mb-64">
            <div class="row">
              <div class="text-left hh-h3-medium col-6 col-sm-12">
                <?php the_sub_field('left_headline'); ?>
              </div>
              
              <div class="list-wrapper row col-6 col-sm-12">
                <?php
                // Get the current term
                $current_term = get_queried_object();
                
                // Get the parent service term
                $parent_service_term = get_term($current_term->parent, $term->taxonomy);
                
                // Get sub-service terms under the same parent service
                $sub_services = get_terms(array(
                    'taxonomy' => $term->taxonomy,
                    'parent' => $parent_service_term->term_id,
                    'hide_empty' => false,
                ));
                
                if ($sub_services) :
                  // Calculate the split index
                  $split_index = ceil(count($sub_services) / 2);
                  ?>
                  <div class="list col-6 col-sm-12">
                    <?php for ($i = 0; $i < $split_index; $i++) : ?>
                      <div class="link-wrapper">
                        <a class="hh-h3-regular"
                           href="<?php echo get_term_link($sub_services[$i]); ?>">
                          <?php echo $sub_services[$i]->name; ?>
                        </a>
                      </div>
                    <?php endfor; ?>
                  </div>
                  <div class="list col-6 col-sm-12">
                    <?php for ($i = $split_index; $i < count($sub_services); $i++) : ?>
                      <div class="link-wrapper">
                        <a class="hh-h3-regular"
                           href="<?php echo get_term_link($sub_services[$i]); ?>">
                          <?php echo $sub_services[$i]->name; ?>
                        </a>
                      </div>
                    <?php endfor; ?>
                  </div>
                <?php endif; ?>
              </div>
            </div>
          </div>
        <?php endif; ?>
        
        <?php if (get_row_layout() == 'two_col_text') : ?>
          <div class="line-not-thick"></div>
          <section class="text_two_columns_block">
            <div class="row">
              <h3 class="text-left hh-h3-medium col-6 col-sm-12">
                <?php the_sub_field('left_headline'); ?>
              </h3>
              <div class="col-12 col-md-6">
                <div class="row ">
                  <div class="hh-body-regular col-12 col-xl-6 col-md-12">
                    <?php the_sub_field('first_text'); ?>
                  </div>
                  <div class="hh-body-regular col-12 col-xl-6 col-md-12">
                    <?php the_sub_field('second_text'); ?>
                  </div>
                </div>
              </div>
            </div>
          </section>
        <?php endif; ?>
        
        <?php if (get_row_layout() == 'slider') : ?>
          <div class="work-slider-block">
            <div class="swiper-container">
              <div class="swiper-wrapper">
                <?php if (have_rows('slides')) : ?>
                  <?php $first_slide_desc = ''; ?>
                  <?php $i = 0; ?>
                  <?php while (have_rows('slides')) : the_row(); ?>
                    <?php if ($i == 0) {
                      $first_slide_desc = get_sub_field('slide_desc');
                    } ?>
                    <div class="swiper-slide" data-desc="<?php the_sub_field('slide_desc'); ?>">
                      <picture class="main-image">
                        <img src="<?php the_sub_field('slide_image'); ?>">
                      </picture>
                    </div>
                    <?php $i++; ?>
                  <?php endwhile; ?>
                <?php endif; ?>
              </div>
            </div>
            <div class="row slide-details">
              <div class="col-6 col-sm-12">
                <div class="black-color arrows-numbers-wrapper">
                  <div class='swiper-pagination hh-micro-medium'></div>
                  <div class="swiper-navigation  black-color">
                    <svg class="left-arrow">
                      <use xlink:href="#Variant=Left"></use>
                    </svg>
                    <svg class="right-arrow">
                      <use xlink:href="#Variant=Right"></use>
                    </svg>
                  </div>
                </div>
              </div>
              <div class="col-6 col-sm-12 swiper-desc hh-micro-medium black-color"><?php echo $first_slide_desc; ?></div>
            </div>
          </div>
        <?php endif; ?>
        
        <?php if (get_row_layout() == 'related_work') : ?>
          <div class="line-not-thick"></div>
          <section class="related-work mb-64">
            <div class="row">
              <div class="col-6 col-sm-12">
                <div class="flex-column">
                  <h3 class="hh-h3-medium black-color"><?php the_sub_field('left_title'); ?></h3>
                  <a href="<?= site_url() ?>/all-work" class="text-link-light">
                    <span class="hh-h3-regular">View All</span>
                    <svg class="icon">
                      <use xlink:href="#Variant=Right"></use>
                    </svg>
                  </a>
                </div>
              </div>
              <div class="col-6 col-sm-12">
                <?php
                $term = get_queried_object();
                $select_option = get_sub_field('select_option');
                $args = array(
                    'post_type' => 'works',
                    'posts_per_page' => 1,
                    'tax_query' => array(
                        array(
                            'taxonomy' => 'work',
                            'field' => 'term_id',
                            'terms' => $term->term_id,
                        ),
                    ),
                );
                
                if ($select_option == 'random') {
                  $args['orderby'] = 'date';
                  $args['order'] = 'DESC';
                } elseif ($select_option == 'select_manually') {
                  $selected_post = get_sub_field('select_related_article');
                  if ($selected_post) {
                    $args['p'] = $selected_post->ID;
                  }
                }
                
                $query = new WP_Query($args);
                if ($query->have_posts()) :
                  while ($query->have_posts()) : $query->the_post();
                    $company_name = get_the_title();
                    $slogan = get_field('work_label');
                    $tags = wp_get_post_terms(get_the_ID(), 'work', array("fields" => "names"));
                    get_template_part('template-parts/work-card-template');
                  endwhile;
                  wp_reset_postdata();
                else : ?>
                  <p><?php _e('No related work found.', 'text_domain'); ?></p>
                <?php endif; ?>
              </div>
            </div>
          </section>
        <?php endif; ?>
      
      <?php endwhile; ?>
    <?php endif; ?>
  </div>
</section>

<?php if ($is_parent) { ?>
  <section class="work-posts-block">
    <div class="container">
      <div class="row row-gap-46">
        <?php
        $term = get_queried_object();
        $args = array(
            'post_type' => 'works',
            'posts_per_page' => 11,
            'orderby' => 'date',
            'order' => 'ASC',
            'tax_query' => array(
                array(
                    'taxonomy' => 'work',
                    'field' => 'term_id',
                    'terms' => $term->term_id,
                ),
            ),
        );
        $query = new WP_Query($args);
        if ($query->have_posts()) :
          $count = 0;
          while ($query->have_posts()) : $query->the_post();
            
            $company_name = get_the_title();
            $slogan = get_field('work_label');
            $tags = wp_get_post_terms(get_the_ID(), 'work', array("fields" => "names"));
            
            // Determine the class based on the count
            $class = ($count < 2) ? 'col-6 col-sm-12' : 'col-4 col-sm-12';
            
            // Increment the counter
            $count++;
            
            // Include the template part and pass the class as a variable
            set_query_var('custom_class', $class);
            get_template_part('template-parts/work-card-template');
            ?>
          
          <?php endwhile;
          $post_count = $query->post_count;
          $regular_items_count = $post_count - 2; // Subtract the first two special items
          $remainder = $regular_items_count % 3; // For rows with 3 items each
          
          // Check if the last row is incomplete
          if ($remainder == 1 || $remainder == 2) { ?>
            
            <div class="card col-4 feather-aniamtion">
              <picture>
                <img loading="lazy" src="<?= get_template_directory_uri() ?>/images/feather-sq-@1x.gif"
                     class="feather"/>
              </picture>
            </div>
          <?php }
          wp_reset_postdata();
        else : ?>
          <p><?php _e('No works found.', 'text_domain'); ?></p>
        <?php endif; ?>
      </div>
    </div>
  </section>
<?php } ?>

<?php
set_query_var('category_names', array($term_name));
get_template_part('template-parts/related_insights_block');
?>
<?php get_footer(); ?>


