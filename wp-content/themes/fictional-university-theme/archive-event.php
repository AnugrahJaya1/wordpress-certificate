<?php
get_header();
?>
<div class="page-banner">
    <div class="page-banner__bg-image" style="background-image: url(<?php echo get_theme_file_uri('/images/library-hero.jpg') ?>)"></div>
    <div class="page-banner__content container container--narrow">
        <h1 class="page-banner__title">
            All Events
        </h1>
        <div class="page-banner__intro">
            <p>
                See what is going on in our world.
            </p>
        </div>
    </div>
</div>

<!-- content -->
<div class="container container--narrow page-section">
    <?php
    while (have_posts()) {
        // get post
        the_post(); // keep track what post we use
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
    echo paginate_links();
    ?>
</div>

<?php
get_footer();
?>