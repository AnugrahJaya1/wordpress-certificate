<?php 

get_header();
// this file use for single page

// get all post
while (have_posts()) {
    // get post
    the_post(); // keep track what post we use
?>
    <!-- HTML mode -->

    <h2>
        <!-- get and print the title of current post -->
        <?php the_title() ?>
    </h2>
    <!-- get and print the content of current post -->
    <?php the_content() ?>
<?php
}

get_footer();
