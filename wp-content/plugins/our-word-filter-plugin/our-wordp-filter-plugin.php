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

        if(get_option("plugin_words_filter")){
            add_filter("the_content", array($this, "filter_logic"));
        }

        add_action("admin_init", array($this, "our_settings"));
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
            <?php
                if(isset($_POST["just_submitted"]) && $_POST["just_submitted"]=="true"){
                    $this->handle_form();
                }
            ?>
            <input type="hidden" name="just_submitted" value="true">
            <?php
                wp_nonce_field(
                    "save_filter_words", //action name
                    "our_nonce" //name of nonce
                );
            ?>
            <label for="plugin_words_filter">
                <p>
                    Enter a <strong>comma-separated</strong> list of words to filter from your site's content.
                </p>
                <div class="word-filter__flex-container">
                    <textarea name="plugin_words_filter" id="plugin_words_filter" placeholder="bad, mean, awful, horrible"><?php echo esc_textarea(get_option("plugin_words_filter"));?></textarea>
                </div>
                <input type="submit" name="submit" id="submit" class="button button-primary" value="Save Changes">
            </label>
        </form>
    </div>
    <?php
    }

    function handle_form(){
        if(isset($_POST["our_nonce"]) && wp_verify_nonce($_POST["our_nonce"], "save_filter_words") && current_user_can("manage_options")){// nonce, action name
            update_option("plugin_words_filter", sanitize_text_field($_POST["plugin_words_filter"]));?>
            <div class="updated">
                <p>Your filtered words were saved.</p>
            </div>
            <?php
        }else{ ?>
            <div class="error">
                <p>
                    Sorry, you don't have permission to perform that action.
                </p>
            </div>
        <?php
        }
    }

    function filter_logic($content){
        // split
        $words_filter = explode(",", get_option("plugin_words_filter"));
        // trim white space
        $words_filter_trimmed = array_map("trim", $words_filter);
        // replace
        return str_ireplace(
            $words_filter_trimmed, // want to replace
            esc_html(get_option("replacement_text"), "****"), // replace with
            $content // content
        );
    }

    function main_page_assets(){
        wp_enqueue_style("filter_admin_css", plugin_dir_url(__FILE__)."/css/style.css");
    }

    function options_sub_page()
    {?>
        <div class="wrap">
            <h1>Words Filter Options</h1>
            <form action="options.php" method="POST">
                <?php
                    // add section
                    settings_fields("replacement_fields"); // group name from register setting
                    // print custom section
                    do_settings_sections("words-filter-options"); // slug name
                    submit_button();
                ?>
            </form>
        </div>
    <?php
    }

    function our_settings(){
        add_settings_section(
            "replacement-text-section" , // name of sections
            null , //
            null , //
            "words-filter-options"  // slug
        );

        register_setting(
            "replacement_fields", //option group
            "replacement_text" // specific name
        );

        add_settings_section(
            "replacement-text", // id
            "Filtered Text", // filed labe
            array($this, "replacement_field_HTML"), // callback
            "words-filter-options", // slug
            "replacement-text-section", // section
        );
    }

    function replacement_field_HTML(){?>
    <input type="text" name="replacement_text" value="<?php echo esc_attr(get_option("replacement_text"));?>">
    <p class="description">
        Leave blank to simply to remove the filtered words.
    </p>
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
