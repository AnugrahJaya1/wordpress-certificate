<?php


function university_files()
{
    // css
    wp_enqueue_style("university_main_style", get_theme_file_uri("/build/style-index.css")); // nickname, location
    wp_enqueue_style("university_extra_style", get_theme_file_uri("/build/index.css")); // nickname, location

    // js
}

// load css and js script
add_action("wp_enqueue_scripts", "university_files");
