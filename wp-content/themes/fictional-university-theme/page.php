<?php

get_header();
// this file use for single page

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
        <?php
        $id = get_the_ID(); // get id of current page
        $parent_id = wp_get_post_parent_id($id); // get id of parent page

        // show breadcrumbs if at child pages
        if ($parent_id) {
        ?>
            <div class="metabox metabox--position-up metabox--with-home-link">
                <p>
                    <a class="metabox__blog-home-link" href="<?php echo get_permalink($parent_id)?>">
                        <i class="fa fa-home" aria-hidden="true"></i>
                        Back to 
                        <?php
                        // parent title
                        echo get_the_title($parent_id);
                        ?>
                    </a>
                    <span class="metabox__main">
                        <?php
                        // print current page
                        the_title();
                        ?>
                    </span>
                </p>
            </div>

        <?php } ?>

        <!-- <div class="page-links">
            <h2 class="page-links__title"><a href="#">About Us</a></h2>
            <ul class="min-list">
                <li class="current_page_item"><a href="#">Our History</a></li>
                <li><a href="#">Our Goals</a></li>
            </ul>
        </div> -->

        <div class="generic-content">
            <?php
            // print content
            the_content();
            ?>
        </div>
    </div>
<?php
}

get_footer();
