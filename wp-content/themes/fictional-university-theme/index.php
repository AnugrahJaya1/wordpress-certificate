<?php
get_header();
?>
<div class="page-banner">
    <div class="page-banner__bg-image" style="background-image: url(<?php echo get_theme_file_uri('/images/library-hero.jpg') ?>)"></div>
    <div class="page-banner__content container container--narrow">
        <h1 class="page-banner__title">
            Welcome to our blog!
        </h1>
        <div class="page-banner__intro">
            <p>Keep up with our latest news.</p>
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
        <div class="post-item">
            <h2 class="headline headline--medium headline--post-title">
                <a href="<?php the_permalink(); ?>">
                    <?php the_title(); ?>
                </a>
            </h2>

            <div class="metabox">
                <p>Posted by
                    <?php
                    // show author as link
                    the_author_posts_link();
                    ?> on
                    <?php
                    // show the date
                    the_date();
                    ?> in
                    <?php
                    // show category as list
                    echo get_the_category_list(", ");
                    ?>
                </p>
            </div>

            <div class="generic-content">
                <?php
                the_excerpt(); // show some of content
                ?>
                <p>
                    <a class="btn btn--blue" href="<?php the_permalink(); ?>">
                        Continue reading &raquo;
                    </a>
                </p>
            </div>


        </div>
    <?php
    }
    ?>
</div>

<?php
get_footer();
?>