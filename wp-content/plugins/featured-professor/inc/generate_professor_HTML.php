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

        <?php
        wp_reset_postdata();
        return ob_get_clean();
    }
}
