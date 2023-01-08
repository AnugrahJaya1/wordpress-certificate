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
        <div class="generic-content">
            <?php
            the_content();
            ?>
        </div>


        <?php
        // show related program
        $related_programs = get_field("related_program");

        if ($related_programs) {
        ?>
            <hr class="section-break">
            <h2 class="headline headline--medium">
                Subject(s) Taught
            </h2>
            <ul class="link-list min-list">
                <?php
                foreach ($related_programs as $program) {
                ?>
                    <li>
                        <a href="<?php echo get_the_permalink($program) ?>">
                            <?php
                            echo get_the_title($program);
                            ?>
                        </a>
                    </li>
                <?php
                }
                ?>
            </ul>
        <?php
        }
        ?>
    </div>
<?php
}

get_footer();
