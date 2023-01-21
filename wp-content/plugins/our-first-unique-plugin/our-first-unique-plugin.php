<?php

/**
 * Plugin Name: Our First Unique Plugin
 * Description: Our First Unique Plugin
 * Version: 1.0
 * Author: Jaya
 */

add_action("admin_menu", "our_plugin_settings_link");

function our_plugin_settings_link()
{
    add_options_page(
        "Word Count Settings", //title (head)
        "Word Count", // title (setting section)
        "manage_options", //capability
        "word-count-settings-page", //slug
        "our_settings_page_HTML" //call back
    );
}

function our_settings_page_HTML()
{
?>
TEST
<?php
}
