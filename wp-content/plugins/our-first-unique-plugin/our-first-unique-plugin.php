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
        </div>
<?php
    }

    function settings(){
        // add custom setting
        register_setting(
            "word_count_plugin", // name of group
            "wcp_location", // specific setting
            [
                "sanitize_callback" => "sanitize_text_field",//sanitize,
                "default" => "0" // default 0-> beg, 1 end
            ] // array
        );
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
