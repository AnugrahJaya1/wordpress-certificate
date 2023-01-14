<?php
get_header();
page_banner([
    "title" => "Search Results",
    "subtitle" => "You search for &ldquo;" . esc_html(get_search_query(false)) . "&rdquo;", // false -> prevent s filled with script
    "background_image_url" => get_theme_file_uri('/images/library-hero.jpg')
]);
?>
<!-- content -->
<div class="container container--narrow page-section">
    <?php
    while (have_posts()) {
        // get post
        the_post(); // keep track what post we use

        get_template_part("/template-parts/content", get_post_type());
    ?>
        
    <?php
    }
    //  add pagination
    echo paginate_links();
    ?>
</div>

<?php
get_footer();
?>