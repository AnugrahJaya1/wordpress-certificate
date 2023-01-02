<?php


function university_files()
{
    // css
    wp_enqueue_style("university_main_style", get_stylesheet_uri()); // nickname, location

    // js
}

// load css and js script
add_action("wp_enqueue_scripts", "university_files");
