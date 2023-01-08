<?php
get_header();
page_banner([
    "title" => "All Programs",
    "subtitle" => "There is something for everyone. Have a look a round.",
    "background_image_url" => get_theme_file_uri('/images/library-hero.jpg')
]);
?>
<!-- content -->
<div class="container container--narrow page-section">
    <ul class="link-list min-list">
        <?php
        while (have_posts()) {
            // get post
            the_post(); // keep track what post we use
        ?>
            <li>
                <a href="<?php the_permalink(); ?>">
                    <?php the_title(); ?>
                </a>
            </li>
        <?php
        }
        //  add pagination
        echo paginate_links();
        ?>
    </ul>
    </p>
</div>

<?php
get_footer();
?>