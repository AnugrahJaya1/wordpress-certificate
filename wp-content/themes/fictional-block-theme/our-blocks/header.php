<header class="site-header">
    <div class="container">
        <h1 class="school-logo-text float-left">
            <a href="<?php echo site_url() ?>"><strong>Fictional</strong> University</a>
        </h1>
        <a href="<?php echo esc_url(site_url("/search")); ?>" class="js-search-trigger site-header__search-trigger">
            <i class="fa fa-search" aria-hidden="true"></i>
        </a>
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
                <?php
                if (is_user_logged_in()) {
                ?>
                    <a href="<?php echo esc_url(site_url("/my-notes")); ?>" class="btn btn--small btn--dark-orange push-right float-left">
                        My Notes
                    </a>
                    <a href="<?php echo esc_url(wp_login_url()); ?>" class="btn btn--small btn--dark-orange push-right float-left btn--with-photo">
                        <span class="site-header__avatar">
                            <?php
                            echo get_avatar(get_current_user_id(), 60); //user id/email, size
                            ?>
                        </span>
                        <span class="btn__text">Log Out</span>
                    </a>
                <?php
                } else {
                ?>
                    <a href="<?php echo wp_login_url(); ?>" class="btn btn--small btn--orange float-left push-right">Login</a>
                    <a href="<?php echo wp_registration_url(); ?>" class="btn btn--small btn--dark-orange push-right float-left">Sign Up</a>
                <?php
                }
                ?>
                <a href="<?php echo esc_url(site_url("/search")); ?>" class="search-trigger js-search-trigger">
                    <i class="fa fa-search" aria-hidden="true"></i>
                </a>
            </div>
        </div>
    </div>
</header>