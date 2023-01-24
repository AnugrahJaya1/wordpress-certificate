<?php

function related_post_html($id)
{
    $posts = new WP_Query(array(
        "posts_per_page" => -1,
        "post_type" => "post",
        "meta_query" => array(
            array(
                "key" => "featured_professor",
                "compare" => "=",
                "value" => $id
            )
        )
    ));

    ob_start();

    if ($posts->found_posts) { ?>
        <p>
            <?php the_title(); ?> is mentioned in the following posts:
        </p>
        <ul>
            <?php
            while ($posts->have_posts()) {
                $posts->the_post(); ?>
                <li>
                    <a href="<?php the_permalink();?>">
                        <?php the_title();?>
                    </a>
                </li>
            <?php
            }
            ?>
        </ul>

<?php
    }

    wp_reset_postdata();
    return ob_get_clean();
}
