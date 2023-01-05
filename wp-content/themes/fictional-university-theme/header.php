<!DOCTYPE html>
<!-- add language attribute -->
<html <?php language_attributes(); ?>>

<head>
    <!-- tell browser what char type used -->
    <meta charset="<?php bloginfo("charset"); ?>">
    <!-- make website responsive -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php
    // load css and js
    wp_head();
    ?>
</head>

<!-- add different body class -->

<body <?php body_class() ?>>
    <header class="site-header">
        <div class="container">
            <h1 class="school-logo-text float-left">
                <a href="<?php echo site_url() ?>"><strong>Fictional</strong> University</a>
            </h1>
            <span class="js-search-trigger site-header__search-trigger"><i class="fa fa-search" aria-hidden="true"></i></span>
            <i class="site-header__menu-trigger fa fa-bars" aria-hidden="true"></i>
            <div class="site-header__menu group">
                <nav class="main-navigation">
                    <?php
                        // show admin nav menu
                        wp_nav_menu([
                            "theme_location" => "header-menu-location" // in functions.php
                        ]);
                    ?>
                </nav>
                <div class="site-header__util">
                    <a href="#" class="btn btn--small btn--orange float-left push-right">Login</a>
                    <a href="#" class="btn btn--small btn--dark-orange push-right float-left">Sign Up</a>
                    <span class="search-trigger js-search-trigger"><i class="fa fa-search" aria-hidden="true"></i></span>
                </div>
            </div>
        </div>
    </header>