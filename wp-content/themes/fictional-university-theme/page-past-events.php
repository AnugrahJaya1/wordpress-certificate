<?php
get_header();
page_banner([
    "title" => "Past Events",
    "subtitle" => "A recap of our past events.",
    "background_image_url" => get_theme_file_uri('/images/library-hero.jpg')
]);
?>
<!-- content -->
<div class="container container--narrow page-section">
    <?php
    $today = date("Ymd");

    $past_events = new WP_Query([
        "paged" => get_query_var("paged", 1), // get query var 
        "post_type" => "event",
        "orderby" => "meta_value_num", // default -> post date, reverse alphabet. meta_value -> get meta value,
        "meta_key" => "event_date",
        "meta_query" => [
            // only get upcoming event not the past
            [
                // greater than today
                "key" => "event_date", // custom field
                "compare" => "<",
                "value" => $today, // YYYYmmdd
                "type" => "numeric"
            ]
        ],
        "order" => "ASC", // default DESC
    ]);

    while ($past_events->have_posts()) {
        // get post
        $past_events->the_post(); // keep track what post we use
        // load .php file with html content
        get_template_part("template-parts/content", get_post_type()); // slug/location, -file name
    }
    //  add pagination
    // only work if using default query
    echo paginate_links([
        "total" => $past_events->max_num_pages,
    ]);
    ?>
</div>

<?php
get_footer();
?>