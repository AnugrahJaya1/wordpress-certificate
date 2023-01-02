<?php 
get_header();

// get all post
while (have_posts()) {
    // get post
    the_post(); // keep track what post we use
?>
    <!-- HTML mode -->

    <h2>
        <!-- get the permanent link -->
        <a href="<?php echo get_permalink(); ?>">
            <!-- get and print the title of current post -->
            <?php the_title() ?>
        </a>
    </h2>
    <!-- get and print the content of current post -->
    <?php the_content() ?>
    <hr>
<?php
}

get_footer();
