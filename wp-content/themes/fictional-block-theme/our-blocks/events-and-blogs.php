<div class="full-width-split group">
    <div class="full-width-split__one">
        <div class="full-width-split__inner">
            <h2 class="headline headline--small-plus t-center">Upcoming Events</h2>

            <?php
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
                    ]
                ],
                "order" => "ASC", // default DESC
            ]);
            while ($home_page_events->have_posts()) {
                $home_page_events->the_post();

                // load .php file with html content
                get_template_part("template-parts/content", get_post_type()); // slug/location, -file name
            }
            // reset our custom queries
            wp_reset_postdata();
            ?>

            <p class="t-center no-margin"><a href="<?php echo get_post_type_archive_link("event") ?>" class="btn btn--blue">View All Events</a></p>
        </div>
    </div>
    <div class="full-width-split__two">
        <div class="full-width-split__inner">
            <h2 class="headline headline--small-plus t-center">From Our Blogs</h2>

            <?php
            /**
             * by default wp queries only return the post that related with current url
             * e.g:  if you at home page, have_posts only have home post
             */

            // custom queries
            $home_page_posts = new WP_Query([
                "posts_per_page" => 2, // show only 2 post
            ]);


            while ($home_page_posts->have_posts()) {
                $home_page_posts->the_post();
            ?>
                <div class="event-summary">
                    <a class="event-summary__date event-summary__date--beige t-center" href="<?php the_permalink(); ?>">
                        <span class="event-summary__month"><?php the_time("M"); ?></span>
                        <span class="event-summary__day"><?php the_time("d"); ?></span>
                    </a>
                    <div class="event-summary__content">
                        <h5 class="event-summary__title headline headline--tiny">
                            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                        </h5>
                        <p>
                            <?php
                            if (has_excerpt()) {
                                echo get_the_excerpt();
                            } else {
                                // word, length
                                echo wp_trim_words(get_the_content(), 18);
                            }
                            ?>
                            <a href="<?php the_permalink(); ?>" class="nu gray">Read more</a>
                        </p>
                    </div>
                </div>
            <?php
            }
            // reset our custom queries
            wp_reset_postdata();
            ?>
            <p class="t-center no-margin"><a href="<?php echo site_url("/blog"); ?>" class="btn btn--yellow">View All Blog Posts</a></p>
        </div>
    </div>
</div>