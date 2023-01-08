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
        "paged" => get_query_var("paged",1), // get query var 
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
    ?>
        <div class="event-summary">
            <a class="event-summary__date t-center" href="<?php the_permalink(); ?>">
                <span class="event-summary__month">
                    <?php
                    // convert string to date
                    $event_date = new DateTime(get_field("event_date"));
                    echo $event_date->format("M");
                    ?>
                </span>
                <span class="event-summary__day">
                    <?php
                    echo $event_date->format("d");
                    ?>
                </span>
            </a>
            <div class="event-summary__content">
                <h5 class="event-summary__title headline headline--tiny">
                    <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                </h5>
                <p><?php
                    // word, length
                    echo wp_trim_words(get_the_content(), 18);
                    ?>
                    <a href="<?php the_permalink(); ?>" class="nu gray">Learn more</a>
                </p>
            </div>
        </div>
    <?php
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