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
            $address = empty($map_location["address"]) ? "Lorem ipsum dolor sit amet, consectetur adipiscing elit." : $map_location["address"];
            ?>
            <div class="marker" data-lat="<?php echo $lat ?>" data-lng="<?php echo $lng ?>">
                <h3>
                    <?php echo the_title(); ?>
                </h3>
                <?php
                echo $address
                ?>
            </div>
        </div>


        <?php
        // program
        $related_programs = new WP_Query([
            "posts_per_page" => -1, // show only 2 post
            "post_type" => "program",
            "orderby" => "title", // default -> post date, reverse alphabet. meta_value -> get meta value,
            "meta_query" => [
                [
                    "key" => "related_campuses", // custom field
                    "compare" => "LIKE",
                    "value" => '"' . get_the_ID() . '"', // search "ID"
                ]
            ],
            "order" => "ASC", // default DESC
        ]);

        if ($related_programs->have_posts()) {
            echo "<hr class='section-break'>";
            echo "<h2 class='headline headline--medium'>Programs Available At This Campus</h2>";
            echo "<ul class='min-list link-list'>";
            while ($related_programs->have_posts()) {
                $related_programs->the_post();
        ?>
                <li>
                    <a href="<?php the_permalink(); ?>">
                        <?php the_title(); ?>
                    </a>
                </li>
        <?php
            }
            echo "</ul>";
        }
        // reset our custom queries
        wp_reset_postdata();
        ?>
    </div>
<?php
}

get_footer();
