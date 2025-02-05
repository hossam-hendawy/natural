<!doctype html>
<html <?php language_attributes(); ?>>
<head>
  <meta charset="<?php bloginfo("charset"); ?>">
  <meta content="width=device-width, initial-scale=1.0, maximum-scale=5, minimum-scale=1.0" name="viewport">
  <meta content="ie=edge" http-equiv="X-UA-Compatible">
  <?php wp_head(); ?>
  

<body <?php body_class(); ?>>

<header class="map-header">
  <div class="header-wrapper">
    <!--     logo-->
    <a href="<?= site_url() ?>" class="main-logo">
      <picture>
        <img src="<?= get_template_directory_uri() . '/images/main-logo.png' ?>" alt="main logo">
      </picture>
    </a>
    <!-- burger menu and cross-->
    <button aria-label="Open Menu Links" class="burger-menu hide-only-lg">
      <span></span>
      <span></span>
      <span></span>
    </button>
    <!--     links  -->
    <nav class="navbar">
      <div class="navbar-wrapper">
        <ul class="primary-menu">
          <li class="menu-item">
            <a href="#" class="cta-button">Map View</a>
          </li>
          <li class="menu-item">
            <a href="#" class="cta-button">Grid View</a>
          </li>
          <li class="menu-item menu-item-has-children">
            <div class="cta-button">Sort</div>
            <ul class="sub-menu">
              <li class="menu-item-in-sub-menu">
                <?php
                // Fetch all locations
                $locations = get_posts([
                    'post_type' => 'location',
                    'posts_per_page' => -1,
                ]);
                
                // Fetch industries taxonomy terms
                $industries = get_terms([
                    'taxonomy' => 'industry',
                    'hide_empty' => false,
                ]);
                if (is_wp_error($industries)) {
                  $industries = [];
                }
                // Fetch years acquired taxonomy terms
                $years_acquired = get_terms([
                    'taxonomy' => 'year-acquired',
                    'hide_empty' => false,
                ]);
                if (is_wp_error($years_acquired)) {
                  $years_acquired = [];
                }
                
                $industry_tax = get_taxonomy('industry');
                $year_tax = get_taxonomy('year-acquired');
                ?>
                <div class="box-wrapper item-wrapper fz-24 capitalize-text main-select">
                  <div class="tax-name">All</div>
                  <div class="checkbox">
                    <svg width="10" height="8" viewBox="0 0 10 8" fill="none" aria-hidden="true">
                      <path d="M0.75 3.99992L3.58 6.82992L9.25 1.16992" stroke="#191919" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                  </div>
                </div>
                
                <!-- Industries Sub-Menu -->
                <div class="box-wrapper item-wrapper fz-24 capitalize-text has-arrow has-sub-menu">
                  <div class="tax-name-and-arrow">
                    <?php if ($industry_tax) { ?>
                      <div class="tax-name"><?= esc_html($industry_tax->labels->name); ?></div>
                    <?php } ?>
                    <svg class="arrow-in-sub-menu" width="24" height="24" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                      <path d="M8.90991 19.9201L15.4299 13.4001C16.1999 12.6301 16.1999 11.3701 15.4299 10.6001L8.90991 4.08008" stroke="#4D4D4D" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                  </div>
                  <?php if (!empty($industries)) { ?>
                  <div class="inner-sub-menu industries-sub-menu">
                    <div class="box-wrapper fz-24 capitalize-text select-all-industries">
                      <div class="tax-name">Select All</div>
                      <div class="checkbox">
                        <svg width="10" height="8" viewBox="0 0 10 8" fill="none" aria-hidden="true">
                          <path d="M0.75 3.99992L3.58 6.82992L9.25 1.16992" stroke="#191919" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                      </div>
                    </div>
                      <?php foreach ($industries as $industry) : ?>
                        <div class="box-wrapper fz-24 capitalize-text" data-taxonomy="<?= esc_html($industry->name); ?>" data-term-id="<?= $industry->term_id; ?>">
                          <div class="tax-name"><?= esc_html($industry->name); ?></div>
                          <div class="checkbox">
                            <svg width="10" height="8" viewBox="0 0 10 8" fill="none" aria-hidden="true">
                              <path d="M0.75 3.99992L3.58 6.82992L9.25 1.16992" stroke="#191919" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                          </div>
                        </div>
                      <?php endforeach; ?>
                  </div>
                  <?php } ?>
                </div>
                
                <!-- Years Acquired Sub-Menu -->
                <div class="box-wrapper item-wrapper fz-24 capitalize-text has-arrow has-sub-menu">
                  <div class="tax-name-and-arrow">
                    <?php if ($year_tax) { ?>
                      <div class="tax-name"><?= esc_html($year_tax->labels->name); ?></div>
                    <?php } ?>
                    <svg class="arrow-in-sub-menu" width="24" height="24" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                      <path d="M8.90991 19.9201L15.4299 13.4001C16.1999 12.6301 16.1999 11.3701 15.4299 10.6001L8.90991 4.08008" stroke="#4D4D4D" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                  </div>
                  <?php if (!empty($years_acquired)) { ?>
                    <div class="inner-sub-menu years-sub-menu">
                    <div class="box-wrapper fz-24 capitalize-text select-all-years">
                      <div class="tax-name">Select All</div>
                      <div class="checkbox">
                        <svg width="10" height="8" viewBox="0 0 10 8" fill="none" aria-hidden="true">
                          <path d="M0.75 3.99992L3.58 6.82992L9.25 1.16992" stroke="#191919" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                      </div>
                    </div>
                      <?php foreach ($years_acquired as $year) : ?>
                        <div class="box-wrapper fz-24 capitalize-text" data-taxonomy="<?= esc_html($year->name); ?>" data-term-id="<?= $year->term_id; ?>">
                          <div class="tax-name"><?= esc_html($year->name); ?></div>
                          <div class="checkbox">
                            <svg width="10" height="8" viewBox="0 0 10 8" fill="none" aria-hidden="true">
                              <path d="M0.75 3.99992L3.58 6.82992L9.25 1.16992" stroke="#191919" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                          </div>
                        </div>
                      <?php endforeach; ?>
                  </div>
                  <?php } ?>
                </div>
                
                <div class="box-wrapper item-wrapper fz-24 capitalize-text has-check-box active-statues">
                  <div class="tax-name">Active</div>
                  <div class="checkbox">
                    <svg width="10" height="8" viewBox="0 0 10 8" fill="none" aria-hidden="true">
                      <path d="M0.75 3.99992L3.58 6.82992L9.25 1.16992" stroke="#191919" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                  </div>
                </div>
                <div class="box-wrapper item-wrapper fz-24 capitalize-text has-check-box realized-statues">
                  <div class="tax-name">Realized</div>
                  <div class="checkbox">
                    <svg width="10" height="8" viewBox="0 0 10 8" fill="none" aria-hidden="true">
                      <path d="M0.75 3.99992L3.58 6.82992L9.25 1.16992" stroke="#191919" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                  </div>
                </div>
              </li>
            </ul>
          </li>
        </ul>
      </div>
    </nav>
  </div>
</header>

