<?php

/**
 * @package Custom Post Types
 */

/*
Plugin Name: Custom Post Types
Plugin URI: 
Description: Custom Post Types
Author: Jaya
Version: 1.0.0
Text Domain: Jaya
*/

/**
 * If ABSPATH not defined
 * Destroy the plugin
 * or Exit if accessed directly.
 */
if (!defined('ABSPATH')) {
    die;
}


class Custom_Post_Type
{

    function __construct()
    {
        add_action("init", [$this, "event_post_type"]);
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

    function event_post_type()
    {
        // add custom post type
        {
            // add event post type
            register_post_type("event", [
                "rewrite" => [
                    "slug" => "events" // rewrite slug
                ],
                "has_archive" => true, // show archive event in event page
                "public" => true, // show in admin nav bar
                'show_in_rest' => true,
                "labels" => [
                    "name" => "Events", // name showed in admin nav bar
                    "add_new_item" => "Add New Event", // Text when add new item
                    "edit_item" => "Edit Event", // Text when edit item
                    "all_items" => "All Events", // Text of all events
                    "singular_name" => "Event" // Text of singular event
                ],
                "menu_icon" => "dashicons-calendar"
            ]); // name of post type, argument
        }
    }
}

if (class_exists("Custom_Post_Type")) {
    // initialize class
    $custom_post_type = new Custom_Post_Type();
}

/**
 * Activation
 * @param __FILE__ : this file
 * @param array (class, function)
 */
register_activation_hook(__FILE__, array($custom_post_type, 'activate'));

/**
 * Deactivation
 * @param __FILE__ : this file
 * @param array (class, function)
 */
register_deactivation_hook(__FILE__, array($custom_post_type, 'deactivate'));
