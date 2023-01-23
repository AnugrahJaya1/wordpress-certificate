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
        add_action("init", array($this, "admin_assets"));
    }

    function admin_assets()
    {
        // register block type
        register_block_type(
            __DIR__, // name space
            [
                "render_callback" => array($this, "the_HTML") // returning html
            ] // array of options
        );
    }

    function the_HTML($attributes)
    {
        if (!is_admin()) { // not in BE
            // load js
            wp_enqueue_script("attention_frontend", plugin_dir_url(__FILE__) . "build/frontend.js", array("wp-element")); //load array before our file
            // load css
            wp_enqueue_style("attention_frontend_css", plugin_dir_url(__FILE__) . "build/frontend.css");
        }

        ob_start(); ?>
        <div class="paying-attention-update-me">
            <pre style="display: none;">
                <?php
                echo wp_json_encode($attributes);
                ?>
            </pre>
        </div>
        <?php
        return ob_get_clean();
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
