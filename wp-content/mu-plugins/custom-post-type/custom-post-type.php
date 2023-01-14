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

        add_action("init", [$this, "program_post_type"]);

        add_action("init", [$this, "professor_post_type"]);

        add_action("init", [$this, "campus_post_type"]);
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
        // add event post type
        register_post_type("event", [
            "capability_type" => "event", // add capability (not use post capability)
            "map_meta_cap" => true, // required permission
            "supports" => [
                "title",
                "editor",
                "excerpt", // add excerpt support,
            ],
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

    function program_post_type()
    {
        // add program post type
        register_post_type("program", [
            "capability_type" => "program", // add capability (not use post capability)
            "map_meta_cap" => true, // required permission
            "supports" => [
                "title"
            ],
            "rewrite" => [
                "slug" => "programs" // rewrite slug
            ],
            "has_archive" => true, // show archive event in event page
            "public" => true, // show in admin nav bar
            'show_in_rest' => true,
            "labels" => [
                "name" => "Programs", // name showed in admin nav bar
                "add_new_item" => "Add New Program", // Text when add new item
                "edit_item" => "Edit Program", // Text when edit item
                "all_items" => "All Programs", // Text of all Programs
                "singular_name" => "Program" // Text of singular Program
            ],
            "menu_icon" => "dashicons-awards"
        ]); // name of post type, argument
    }

    function professor_post_type()
    {
        // add  professor post type
        register_post_type("professor", [
            "capability_type" => "professor", // add capability (not use post capability)
            "map_meta_cap" => true, // required permission
            "supports" => [
                "title",
                "editor",
                "thumbnail"
            ],
            "public" => true, // show in admin nav bar
            'show_in_rest' => true,
            "labels" => [
                "name" => "Professors", // name showed in admin nav bar
                "add_new_item" => "Add New Professor", // Text when add new item
                "edit_item" => "Edit Professor", // Text when edit item
                "all_items" => "All Professors", // Text of all Professors
                "singular_name" => "Professor" // Text of singular Program
            ],
            "menu_icon" => "dashicons-welcome-learn-more"
        ]); // name of post type, argument
    }

    function campus_post_type()
    {
        // add campus post type
        register_post_type("campus", [
            "capability_type" => "campus", // add capability (not use post capability)
            "map_meta_cap" => true, // required permission
            "supports" => [
                "title",
                "editor",
                "excerpt", // add excerpt support,
            ],
            "rewrite" => [
                "slug" => "campuses" // rewrite slug
            ],
            "has_archive" => true, // show archive Campu in Campu page
            "public" => true, // show in admin nav bar
            'show_in_rest' => true,
            "labels" => [
                "name" => "Campuses", // name showed in admin nav bar
                "add_new_item" => "Add New Campus", // Text when add new item
                "edit_item" => "Edit Campus", // Text when edit item
                "all_items" => "All Campuses", // Text of all Campus
                "singular_name" => "Campus" // Text of singular event
            ],
            "menu_icon" => "dashicons-location-alt"
        ]); // name of post type, argument
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
