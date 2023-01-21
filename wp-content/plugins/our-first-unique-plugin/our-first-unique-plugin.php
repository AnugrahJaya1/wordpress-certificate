<?php

/**
 * Plugin Name: Our First Unique Plugin
 * Description: Our First Unique Plugin
 * Version: 1.0
 * Author: Jaya
 */

class WordCountAndTimePlugin
{
    function __construct()
    {
        add_action("admin_menu", array($this, "admin_page"));

        add_action("admin_init", array($this, "settings"));
    }

    function admin_page()
    {
        add_options_page(
            "Word Count Settings", //title (head)
            "Word Count", // title (setting section)
            "manage_options", //capability
            "word-count-settings-page", //slug
            array($this, "our_HTML") //call back
        );
    }

    function our_HTML()
    {
?>
        <div class="wrap">
            <h1>Word Count Settings</h1>
            <form action="options.php" method="POST">
                <?php
                    // call function from our custom setting (HTML)
                    do_settings_sections("word-count-settings-page");

                    //submit wp button
                    submit_button();
                ?>
            </form>
        </div>
    <?php
    }

    function settings()
    {
        // settings section
        add_settings_section(
            "wcp_first_section", // name of section
            null, // title of section
            null, // html content
            "word-count-settings-page", // page slug
        );
        // build html for setting
        add_settings_field(
            "wcp_location", //name
            "Display Location", // HTML label
            array($this, "location_HTML"), // function -> return HTML
            "word-count-settings-page", //page slug
            "wcp_first_section" // section/field
        );
        // add custom setting
        register_setting(
            "word_count_plugin", // name of group
            "wcp_location", // specific setting
            [
                "sanitize_callback" => "sanitize_text_field", //sanitize,
                "default" => "0" // default 0-> beg, 1 end
            ] // array
        );
    }

    function location_HTML()
    {
    ?>
    <select name="wcp_location">
        <option value="0">Beginning of post</option>
        <option value="1">End of post</option>
    </select>
<?php
    }

    /**
     * Add menu page
     * Flush rewrite rules
     */
    function activate()
    {
        flush_rewrite_rules();
    }

    /**
     * Flush rewrite rules
     */
    function deactivate()
    {
        flush_rewrite_rules();
    }
}

if (class_exists("WordCountAndTimePlugin")) {
    // initialize class
    $word_count = new WordCountAndTimePlugin();
}

/**
 * Activation
 * @param __FILE__ : this file
 * @param array (class, function)
 */
register_activation_hook(__FILE__, array($word_count, 'activate'));

/**
 * Deactivation
 * @param __FILE__ : this file
 * @param array (class, function)
 */
register_deactivation_hook(__FILE__, array($word_count, 'deactivate'));
