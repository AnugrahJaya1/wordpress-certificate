<?php

/**
 * Plugin Name: Our First Unique Plugin
 * Description: Our First Unique Plugin
 * Version: 1.0
 * Author: Jaya
 */


function add_to_end_of_post($content)
{
    if (
        is_single() && // in single page
        is_main_query()
    ) {
        return $content . "<p>Test</p>";
    }

    return $content;
}

add_filter("the_content", "add_to_end_of_post");
