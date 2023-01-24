<?php

function generate_professor_HTML($id)
{
    $prof = new WP_Query(array(
        "post_type" => "professor",
        "p" => $id
    ));

    while ($prof->have_posts()) {
        $prof->the_post();
        ob_start(); ?>
        <div class="professor-callout">
            <div class="professor-callout__photo" style="background-image: url(<?php the_post_thumbnail_url("professor-portrait") ?>);">

            </div>
            <div class="professor-callout__text">
                <h5>
                    <?php the_title(); ?>
                </h5>
                <p>
                    <?php
                    echo wp_trim_words(get_the_content(), 30);
                    ?>
                </p>

                <?php
                $related_programs = get_field("related_program");
                if ($related_programs) {
                    echo "<p>Name teachers: ";
                    foreach ($related_programs as $key => $program) {
                        echo get_the_title($program);
                        if ($key != array_key_last($related_programs) && count($related_programs) > 1) {
                            echo ", ";
                        }
                    }
                    echo ".</p>";
                }
                ?>

                <p>
                    <strong>
                        <a href="<?php the_permalink(); ?>">Learn more about <?php the_title(); ?> &raquo; </a>
                    </strong>
                </p>
            </div>
        </div>
<?php
        wp_reset_postdata();
        return ob_get_clean();
    }
}
