<?php

get_header();
// this file use for single post

// get all post
while (have_posts()) {
    // get post
    the_post(); // keep track what post we use
?>
    <!-- HTML mode -->
    <div class="page-banner">
        <div class="page-banner__bg-image" style="background-image: url(<?php echo get_theme_file_uri('/images/library-hero.jpg') ?>)"></div>
        <div class="page-banner__content container container--narrow">
            <h1 class="page-banner__title">
                <?php
                // print title of pages
                the_title();
                ?>
            </h1>
            <div class="page-banner__intro">
                <p>Don't forget to replace me later</p>
            </div>
        </div>
    </div>

    <div class="container container--narrow page-section">
        <!-- metabox will go here -->
        <div class="metabox metabox--position-up metabox--with-home-link">
            <p>
                <a class="metabox__blog-home-link" href="<?php echo site_url("/blog"); ?>">
                    <i class="fa fa-home" aria-hidden="true"></i>
                    Back to Home
                </a>
                <span class="metabox__main">
                    Posted by
                    <?php
                    // show author as link
                    the_author_posts_link();
                    ?> on
                    <?php
                    // show the date
                    the_date();
                    ?> in
                    <?php
                    // show category as list
                    echo get_the_category_list(", ");
                    ?>
                </span>
            </p>
        </div>

        <div class="generic-content">
            <?php
            the_content();
            ?>
        </div>
    </div>
<?php
}

get_footer();
