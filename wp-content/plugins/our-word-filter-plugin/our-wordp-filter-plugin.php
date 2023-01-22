<?php

/**
 * Plugin Name: Our Word Filter PLugin
 * Description: Our Word Filter PLugin
 * Version: 1.0
 * Author: Jaya
 */

if (!defined("ABSPATH")) {
    exit;
}

class OurWordFilterPlugin
{
    function __construct()
    {
        add_action("admin_menu", array($this, "our_menu"));
    }

    function our_menu()
    {
        // Main menu
        $main_page_hook = add_menu_page(
            'Words Filter', //page_title
            'Words Filter', //menu_title
            'manage_options', //capability
            'words-filter', //menu_slug
            array($this, 'word_filter_page'), //callback_function
            plugin_dir_url(__FILE__) . "/assets/custom.svg", //icon_url
            100, // order
        ); // return hook

        // change parent name
        add_submenu_page(
            "words-filter", // slug parent
            "Words Filter", // page title
            "Word List", // menu title
            'manage_options', //capability
            "words-filter", //slug
            array($this, "word_filter_page"), //callback
        );

        add_submenu_page(
            "words-filter", // slug parent
            "Word Filter Options", // page title
            "Options", // menu title
            'manage_options', //capability
            "words-filter-options", //slug
            array($this, "options_sub_page"), //callback
        );

        // load css
        add_action("load-{$main_page_hook}", array($this, "main_page_assets"));
    }

    function word_filter_page()
    { ?>
    <div class="wrap">
        <h1>Words Filter</h1>
        <form action="" method="POST">
            <label for="plugin_words_filter">
                <p>
                    Enter a <strong>comma-separated</strong> list of words to filter from your site's content.
                </p>
                <div class="word-filter__flex-container">
                    <textarea name="plugin_words_filter" id="plugin_words_filter" placeholder="bad, mean, awful, horrible"></textarea>
                </div>
                <input type="submit" name="submit" id="submit" class="button button-primary" value="Save Changes">
            </label>
        </form>
    </div>
    <?php
    }

    function main_page_assets(){
        wp_enqueue_style("filter_admin_css", plugin_dir_url(__FILE__)."/css/style.css");
    }

    function options_sub_page()
    {
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


if (class_exists("OurWordFilterPlugin")) {
    // initialize class
    $word_filter = new OurWordFilterPlugin();
}

/**
 * Activation
 * @param __FILE__ : this file
 * @param array (class, function)
 */
register_activation_hook(__FILE__, array($word_filter, 'activate'));

/**
 * Deactivation
 * @param __FILE__ : this file
 * @param array (class, function)
 */
register_deactivation_hook(__FILE__, array($word_filter, 'deactivate'));
