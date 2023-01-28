<?php

require get_theme_file_path("/inc/search-route.php");
require get_theme_file_path("/inc/like-route.php");

define("GOOGLE_KEY", "AIzaSyDLL3JqFUUcV2JBrYAjPXj-fOBzDWwJvU0");

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

    // google js
    wp_enqueue_script("google-map", "//maps.googleapis.com/maps/api/js?key=" . GOOGLE_KEY, NULL, "1.0", true);

    // output js data into html source
    wp_localize_script("university_main_script", "university_data", [
        "root_url" => get_site_url(),
        "nonce" => wp_create_nonce("wp_rest") // create secret key for auth
    ]); // handle of name script, variable name, array of data
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
    add_image_size("professor_landscape", 400, 260, true); // nickname, w, h, crop? (false)
    add_image_size("professor_portrait", 480, 650, true); // nickname, w, h, crop? (false)
    add_image_size("page_banner", 1500, 350, true); // nickname, w, h, crop? (false)

    // add header menu
    register_nav_menu("header-menu-location", "Header Menu Location"); // location/slug, name

    // add footer menu 1 
    register_nav_menu("footer-menu-location-one", "Footer Menu Location One"); // location/slug, name

    // add footer menu 2
    register_nav_menu("footer-menu-location-two", "Footer Menu Location Two"); // location/slug, name

    // block type
    add_theme_support("editor-styles");
    add_editor_style(array(
        "https://fonts.googleapis.com/css?family=Roboto+Condensed:300,300i,400,400i,700,700i|Roboto:100,300,400,400i,700,700i",
        "build/style-index.css",
        "build/index.css"
    ));
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

    // program
    if (
        !is_admin() && //if not in admin/dashboard
        is_post_type_archive("program") &&
        $query->is_main_query() // manipulate base queries
    ) {
        $query->set("orderby", "title"); // set by orderby
        $query->set("order", "ASC"); // set by order ASC/DESC
        $query->set("posts_per_page", -1); // show all
    }

    // campus
    if (
        !is_admin() && //if not in admin/dashboard
        is_post_type_archive("campus") &&
        $query->is_main_query() // manipulate base queries
    ) {
        $query->set("posts_per_page", -1); // show all
    }
}

add_action("pre_get_posts", "university_adjust_queries");

function page_banner($args = NULL)
{
    // php logic will live here
    $title = empty($args["title"]) ? "" : $args["title"];
    $subtitle = empty($args["subtitle"]) ? "" : $args["subtitle"];
    $background_image_url = empty($args["background_image_url"]) ? "" : $args["background_image_url"];

    if (!$title) {
        $title = get_the_title();
    }

    if (!$subtitle) {
        $subtitle = get_field("page_banner_subtitle");
    }

    if (!$background_image_url) {
        $page_banner_background_image = get_field("page_banner_background_image");
        if ($page_banner_background_image) {
            $background_image_url = $page_banner_background_image["sizes"]["page-banner"];
        } else {
            $background_image_url = get_theme_file_uri('/images/ocean.jpg');
        }
    }
?>
    <div class="page-banner">
        <div class="page-banner__bg-image" style="background-image: url(
            <?php echo $background_image_url; ?>
            )"></div>
        <div class="page-banner__content container container--narrow">
            <h1 class="page-banner__title">
                <?php echo $title; ?>
            </h1>
            <div class="page-banner__intro">
                <p>
                    <?php echo $subtitle ?>
                </p>
            </div>
        </div>
    </div>
<?php
}

function university_map_key($api)
{
    $api["key"] = GOOGLE_KEY;
    return $api;
}

// add google api key
add_filter("acf/fields/google_map/api", "university_map_key");

// add custom field wp output

function university_custom_rest()
{
    register_rest_field("post", "author_name", [
        "get_callback" => function () {
            return get_the_author();
        }
    ]); // post type, new field, array

    register_rest_field("note", "user_note_count", [
        "get_callback" => function () {
            return count_user_posts(get_current_user_id(), "note");
        }
    ]); // post type, new field, array
}

add_action("rest_api_init", "university_custom_rest");

// redirect subscriber account out of admin and onto homepage

function redirect_subs_to_front_end()
{
    $current_user = wp_get_current_user();
    if (
        count($current_user->roles) == 1 &&
        $current_user->roles[0] == "subscriber"
    ) {
        wp_redirect(site_url("/"));
        exit;
    }
}

add_action("admin_init", "redirect_subs_to_front_end");

function no_subs_admin_bar()
{
    $current_user = wp_get_current_user();
    if (
        count($current_user->roles) == 1 &&
        $current_user->roles[0] == "subscriber"
    ) {
        show_admin_bar(false);
    }
}

add_action("wp_loaded", "no_subs_admin_bar");


// customize login screen
function our_header_url()
{
    return esc_url(site_url("/"));
}

add_filter("login_headerurl", "our_header_url"); //object want change, callback function

function our_login_css()
{
    // css
    wp_enqueue_style("university_main_style", get_theme_file_uri("/build/style-index.css")); // nickname, location
    wp_enqueue_style("university_extra_style", get_theme_file_uri("/build/index.css")); // nickname, location

    // icon
    wp_enqueue_style("font-awesome", "//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css"); // nickname, location

    // font
    wp_enqueue_style("custom-google-fonts", "//fonts.googleapis.com/css?family=Roboto+Condensed:300,300i,400,400i,700,700i|Roboto:100,300,400,400i,700,700i"); // nickname, location
}

add_action("login_enqueue_scripts", "our_login_css");

function our_login_title()
{
    return get_bloginfo("name");
}

add_filter("login_headertext", "our_login_title");

// Force note post to be private

function make_note_private($data, $postarr)
{
    // remove html in content
    if ($data["post_type"] == "note") {
        // limit post per user
        if (count_user_posts(get_current_user_id(), "note") > 5 - 1 && !$postarr["ID"]) { //id,post type, check id if existed
            die("You have reached your note limit.");
        }

        //remove html
        $data["post_title"] = sanitize_text_field($data["post_title"]);
        $data["post_content"] = sanitize_textarea_field($data["post_content"]);
    }

    if ($data["post_type"] == "note" && $data["post_status"] != "trash") {
        $data["post_status"] = "private";
    }
    return $data;
}

add_filter("wp_insert_post_data", "make_note_private", 10, 2); //hook, function, prior, params

function ignore_certain_files($exclude_filters)
{
    $exclude_filters[] = "themes/fictional-university-themes/node_modules";

    return $exclude_filters;
}

add_filter("ai1wm_exclude_content_from_export", "ignore_certain_files");

class PlaceholderBlock
{
    private $name;
    function __construct($name)
    {
        $this->name = $name;
        add_action('init', [$this, 'on_init']);
    }

    function our_render_callback($attributes, $content)
    {
        ob_start();
        require get_theme_file_path("/our-blocks/{$this->name}.php");
        return ob_get_clean();
    }

    function on_init()
    {
        wp_register_script(
            $this->name,
            get_stylesheet_directory_uri() . "/our-blocks/{$this->name}.js",
            array('wp-blocks', 'wp-editor')
        );

        register_block_type("ourblocktheme/{$this->name}", array(
            'editor_script' => $this->name,
            'render_callback' => [$this, 'our_render_callback']
        ));
    }
}

new PlaceholderBlock("events-and-blogs");
new PlaceholderBlock("header");
new PlaceholderBlock("footer");

class JSXBlock
{
    private $name, $render_callback, $data;
    function __construct($name, $render_callback = null, $data = null)
    {
        $this->name = $name;
        $this->render_callback = $render_callback;
        $this->data = $data;
        add_action("init", array($this, "on_init"));
    }

    function our_render_callback($attributes, $content)
    {
        ob_start();
        require get_theme_file_path("/our-blocks/{$this->name}.php");
        return ob_get_clean();
    }

    function on_init()
    {
        wp_register_script(
            $this->name, //name
            get_stylesheet_directory_uri() . "/build/{$this->name}.js", // dir
            array("wp-blocks", "wp-editor") // array
        );

        if (isset($this->data)) {
            wp_localize_script($this->name, $this->name, $this->data);
        }

        $our_args = array(
            "editor_script" => $this->name
        );

        if ($this->render_callback) {
            $our_args["render_callback"] = array($this, "our_render_callback");
        }

        register_block_type(
            "ourblocktheme/{$this->name}", //name
            $our_args
        );
    }
}

new JSXBlock("banner", true, ["fallback_image" => get_theme_file_uri("/images/library-hero.jpg")]);
new JSXBlock("generic-heading");
new JSXBlock("generic-button");
