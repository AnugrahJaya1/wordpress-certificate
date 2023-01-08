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
    wp_enqueue_script("university_main_script", get_theme_file_uri("/build/index.js"), ["jquery"], "1.0", true);
}

// load css and js script
add_action("wp_enqueue_scripts", "university_files");

function university_features()
{
    // setup title in header
    add_theme_support("title-tag");

    // add post thumbnails
    add_theme_support("post-thumbnails"); // by default add to post post_type/blog

    // resize size
    add_image_size("professor-landscape", 400, 260, true); // nickname, w, h, crop? (false)
    add_image_size("professor-portrait", 480, 650, true); // nickname, w, h, crop? (false)

    // add header menu
    register_nav_menu("header-menu-location", "Header Menu Location"); // location/slug, name

    // add footer menu 1 
    register_nav_menu("footer-menu-location-one", "Footer Menu Location One"); // location/slug, name

    // add footer menu 2
    register_nav_menu("footer-menu-location-two", "Footer Menu Location Two"); // location/slug, name
}

add_action("after_setup_theme", "university_features");

// manipulate query
function university_adjust_queries($query)
{
    // adjust events page queries
    if (
        !is_admin() && //if not in admin/dashboard
        is_post_type_archive("event") &&
        $query->is_main_query() // manipulate base queries
    ) {
        $today = date("Ymd");

        $query->set("meta_key", "event_date"); // set by meta_key
        $query->set("orderby", "meta_value_num"); // set by orderby
        $query->set("order", "ASC"); // set by order ASC/DESC
        $query->set("meta_query", [
            // only get upcoming event not the past
            [
                // greater than today
                "key" => "event_date", // custom field
                "compare" => ">=",
                "value" => $today, // YYYYmmdd
                "type" => "numeric"
            ]
        ]);
    }

    if (
        !is_admin() && //if not in admin/dashboard
        is_post_type_archive("program") &&
        $query->is_main_query() // manipulate base queries
    ) {
        $query->set("orderby", "title"); // set by orderby
        $query->set("order", "ASC"); // set by order ASC/DESC
        $query->set("posts_per_page", -1); // show all
    }
}

add_action("pre_get_posts", "university_adjust_queries");
