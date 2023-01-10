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
        <!-- metabox will go here -->
        <div class="metabox metabox--position-up metabox--with-home-link">
            <p>
                <a class="metabox__blog-home-link" href="<?php echo get_post_type_archive_link("campus"); ?>">
                    <i class="fa fa-home" aria-hidden="true"></i>
                    All Campuses
                </a>
                <span class="metabox__main">
                    <?php
                    the_title();
                    ?>
                </span>
            </p>
        </div>

        <div class="generic-content">
            <?php
            the_content();
            ?>
        </div>

        <div class="acf-map">
            <?php
            $map_location = get_field("map_location");
            $lat = empty($map_location["lat"]) ? "6.9039" : $map_location["lat"];
            $lng = empty($map_location["lng"]) ? "107.6491" : $map_location["lng"];
            ?>
            <div class="marker" data-lat="<?php echo $lat ?>" data-lng="<?php echo $lng ?>">
                <h3>
                    <?php echo the_title(); ?>
                </h3>
                <?php
                echo $map_location["address"];
                ?>
            </div>
        </div>

        <?php
        // professor
        $related_professors = new WP_Query([
            "posts_per_page" => -1, // show only 2 post
            "post_type" => "professor",
            "orderby" => "title", // default -> post date, reverse alphabet. meta_value -> get meta value,
            "meta_query" => [
                [
                    "key" => "related_program", // custom field
                    "compare" => "LIKE",
                    "value" => '"' . get_the_ID() . '"', // search "ID"
                ]
            ],
            "order" => "ASC", // default DESC
        ]);

        if ($related_professors->have_posts()) {
            echo "<hr class='section-break'>";
            echo "<h2 class='headline headline--medium'>" . get_the_title() . " Professors</h2>";
            echo "<ul class='professor-cards'>";
            while ($related_professors->have_posts()) {
                $related_professors->the_post();
        ?>
                <li class="professor-card__list-item">
                    <a class="professor-card" href="<?php the_permalink(); ?>">
                        <img class="professor-card__image" src="<?php the_post_thumbnail_url("professor-landscape"); ?>" alt="">
                        <span class="professor-card__name"><?php the_title(); ?></span>
                    </a>
                </li>
        <?php
            }
            echo "</ul>";
        }
        // reset our custom queries
        wp_reset_postdata();


        $today = date("Ymd");

        // need update re-save permalink
        // by default order by publish date/post date
        // get events post
        $home_page_events = new WP_Query([
            "posts_per_page" => 2, // show only 2 post
            "post_type" => "event",
            "orderby" => "meta_value_num", // default -> post date, reverse alphabet. meta_value -> get meta value,
            "meta_key" => "event_date",
            "meta_query" => [
                // only get upcoming event not the past
                [
                    // greater than today
                    "key" => "event_date", // custom field
                    "compare" => ">=",
                    "value" => $today, // YYYYmmdd
                    "type" => "numeric"
                ],
                [
                    "key" => "related_program", // custom field
                    "compare" => "LIKE",
                    "value" => '"' . get_the_ID() . '"', // search "ID"
                ]
            ],
            "order" => "ASC", // default DESC
        ]);

        if ($home_page_events->have_posts()) {
            echo "<hr class='section-break'>";
            echo "<h2 class='headline headline--medium'>Upcoming " . get_the_title() . " Events</h2>";
            while ($home_page_events->have_posts()) {
                $home_page_events->the_post();

                // load .php file with html content
                get_template_part("template-parts/content", get_post_type()); // slug/location, -file name
            }
        }
        // reset our custom queries
        wp_reset_postdata();
        ?>
    </div>
<?php
}

get_footer();
