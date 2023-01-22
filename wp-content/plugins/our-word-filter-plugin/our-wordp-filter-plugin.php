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
        add_menu_page(
            'Words Filter', //page_title
            'Words Filter', //menu_title
            'manage_options', //capability
            'words-filter', //menu_slug
            array($this, 'word_filter_page'), //callback_function
            'dashicons-smiley', //icon_url
            100, // order
        );

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
    }

    function word_filter_page(){
        
    }

    function options_sub_page(){
        
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
