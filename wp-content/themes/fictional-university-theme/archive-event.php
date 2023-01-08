<?php
get_header();
page_banner([
    "title" => "All Events",
    "subtitle" => "See what is going on in our world.",
    "background_image_url" => get_theme_file_uri('/images/library-hero.jpg')
]);
?>

<!-- content -->
<div class="container container--narrow page-section">
    <?php
    while (have_posts()) {
        // get post
        the_post(); // keep track what post we use
        
        // load .php file with html content
        get_template_part("template-parts/content", get_post_type()); // slug/location, -file name
    }
    //  add pagination
    echo paginate_links();
    ?>

    <hr class="section-break">
    <p>Looking for a recap of past events?
        <a href="<?php echo site_url("/past-events"); ?>">Check out our past events archive.</a>
    </p>
</div>

<?php
get_footer();
?>