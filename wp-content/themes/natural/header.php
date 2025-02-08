<!doctype html>
<html <?php language_attributes(); ?>>
<head>
  <meta charset="<?php bloginfo("charset"); ?>">
  <meta content="width=device-width, initial-scale=1.0, maximum-scale=5, minimum-scale=1.0" name="viewport">
  <meta content="ie=edge" http-equiv="X-UA-Compatible">
  <link rel="stylesheet" href="https://use.typekit.net/rpo6xba.css">
  
  <?php wp_head(); ?>


<body <?php body_class(); ?>>

<?php
$header_logo = get_field('header_logo', 'options');
$contact_us = get_field('contact_us', 'options');
?>
<header class="natural-header">
  <div class="header-wrapper">
    <!--     logo-->
    <a href="<?= site_url() ?>" class="main-logo"></a>
    <!-- burger menu and cross-->
    <button aria-label="Open Menu Links" class="burger-menu hide-only-lg">
      <span></span>
      <span></span>
      <span></span>
    </button>
    <!--     links  -->
    <nav class="navbar">
      <div class="navbar-wrapper">
        <?php if (have_rows('menu_links', 'options')) { ?>
          <ul class="primary-menu">
            <?php while (have_rows('menu_links', 'options')) {
              the_row();
              $menu_link = get_sub_field('menu_link');
              ?>
              <li class="menu-item">
                <a href="<?= $menu_link['url'] ?>" target="<?= $menu_link['target'] ?>"
                   class="header-link">
                  <?= $menu_link['title'] ?>
                </a>
              </li>
            <?php } ?>
          </ul>
        <?php } ?>
        <?php if (!empty($contact_us) && is_array($contact_us)) { ?>
          <a class="cta-button contactUS-btn" href="<?= $contact_us['url'] ?>" target="<?= $contact_us['target'] ?>"><?= $contact_us['title'] ?></a>
        <?php } ?>
      </div>
    </nav>
  </div>
</header>

