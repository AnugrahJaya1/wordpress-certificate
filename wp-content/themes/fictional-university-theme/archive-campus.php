<?php
get_header();
page_banner([
    "title" => "Our Campuses",
    "subtitle" => "We have several conveniently located campuses.",
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
                    <?php
                    the_title();
                    ?>
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