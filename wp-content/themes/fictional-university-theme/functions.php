<?php


function university_files()
{
    // css
    wp_enqueue_style("university_main_style", get_theme_file_uri("/build/style-index.css")); // nickname, location
    wp_enqueue_style("university_extra_style", get_theme_file_uri("/build/index.css")); // nickname, location

    // icon
    wp_enqueue_style("font-awesome", "//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css"); // nickname, location

    // font
    wp_enqueue_style("custom-google-fonts", "//fonts.googleapis.com/css?family=Roboto+Condensed:300,300i,400,400i,700,700i|Roboto:100,300,400,400i,700,700i"); // nickname, location

    // js
    //nickname, location, dependency (if no have dependency -> NULL), version number, load before closing body tag
    wp_enqueue_script("university_main_script", get_theme_file_uri("/build/index.js"), ["jquery"], "1.0", true ); 
}

// load css and js script
add_action("wp_enqueue_scripts", "university_files");

function university_features(){
    // setup title in header
    add_theme_support("title-tag");

    // add header menu
    register_nav_menu("header-menu-location", "Header Menu Location");// location/slug, name

    // add footer menu 1 
    register_nav_menu("footer-menu-location-one", "Footer Menu Location One");// location/slug, name

    // add footer menu 2
    register_nav_menu("footer-menu-location-two", "Footer Menu Location Two");// location/slug, name
}

add_action("after_setup_theme", "university_features");

// add custom post type
function university_post_types(){
    // add event post type
    register_post_type("event", [
        "public" => true, // show in admin nav bar
        "labels" => [
            "name" => "Events"
        ],
        "menu_icon" => "dashicons-calendar"
    ]); // name of post type, argument
}

add_action("init","university_post_types");