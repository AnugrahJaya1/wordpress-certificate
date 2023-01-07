<?php
get_header();
?>
<div class="page-banner">
    <div class="page-banner__bg-image" style="background-image: url(<?php echo get_theme_file_uri('/images/library-hero.jpg') ?>)"></div>
    <div class="page-banner__content container container--narrow">
        <h1 class="page-banner__title">
            All Programs
        </h1>
        <div class="page-banner__intro">
            <p>
                There is something for everyone. Have a look a round.
            </p>
        </div>
    </div>
</div>

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