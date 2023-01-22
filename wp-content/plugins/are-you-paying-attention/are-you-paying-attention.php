<?php

/**
 * Plugin Name: Are You Paying Attention Quiz
 * Description: Are You Paying Attention Quiz
 * Version: 1.0
 * Author: Jaya
 */

if (!defined("ABSPATH")) {
    exit;
}

class AreYouPayingAttentionQuiz
{
    function __construct()
    {
        add_action("enqueue_block_editor_assets", array($this, "admin_assets"));
    }

    function admin_assets(){
        // load js
        wp_enqueue_script("our_new_block_type", plugin_dir_url(__FILE__)."/src/index.js", array("wp-blocks", "wp-element")); //load array before our file
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


if (class_exists("AreYouPayingAttentionQuiz")) {
    // initialize class
    $quiz = new AreYouPayingAttentionQuiz();
}

/**
 * Activation
 * @param __FILE__ : this file
 * @param array (class, function)
 */
register_activation_hook(__FILE__, array($quiz, 'activate'));

/**
 * Deactivation
 * @param __FILE__ : this file
 * @param array (class, function)
 */
register_deactivation_hook(__FILE__, array($quiz, 'deactivate'));
