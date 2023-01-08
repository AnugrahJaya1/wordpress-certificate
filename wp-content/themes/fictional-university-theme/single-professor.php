<?php

get_header();
// this file use for single post

// get all post
while (have_posts()) {
    // get post
    the_post(); // keep track what post we use
    page_banner();
?>
    <!-- HTML mode -->
    

    <div class="container container--narrow page-section">
        <div class="generic-content">
            <div class="row group">
                <div class="one-third">
                    <?php
                    // show thumbnail
                    the_post_thumbnail("professor-portrait");
                    ?>
                </div>

                <div class="two-third">
                    <?php
                    the_content();
                    ?>
                </div>
            </div>
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
