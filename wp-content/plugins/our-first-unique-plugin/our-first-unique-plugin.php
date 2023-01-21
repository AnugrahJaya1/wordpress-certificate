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

        add_filter("the_content", array($this, "if_wrap"));
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
                // fix issue failed when save
                settings_fields("word_count_plugin");

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

        // DISPLAY LOCATION
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
                "sanitize_callback" => array($this, "sanitize_location"), //sanitize,
                "default" => "0" // default 0-> beg, 1 end
            ] // array
        );

        // HEADLINE
        // build html for setting
        add_settings_field(
            "wcp_headline", //name
            "Headline Text", // HTML label
            array($this, "headline_HTML"), // function -> return HTML
            "word-count-settings-page", //page slug
            "wcp_first_section" // section/field
        );
        // add custom setting
        register_setting(
            "word_count_plugin", // name of group
            "wcp_headline", // specific setting
            [
                "sanitize_callback" => "sanitize_text_field", //sanitize,
                "default" => "Post Statistics" // default
            ] // array
        );

        // Word Count
        // build html for setting
        add_settings_field(
            "wcp_word_count", //name
            "Word Count", // HTML label
            array($this, "checkbox_HTML"), // function -> return HTML
            "word-count-settings-page", //page slug
            "wcp_first_section", // section/field,
            array("the_name" => "wcp_word_count") // args argument
        );
        // add custom setting
        register_setting(
            "word_count_plugin", // name of group
            "wcp_word_count", // specific setting
            [
                "sanitize_callback" => "sanitize_text_field", //sanitize,
                "default" => "1" // default 0-> beg, 1 end
            ] // array
        );

        // Char Count
        // build html for setting
        add_settings_field(
            "wcp_char_count", //name
            "Character Count", // HTML label
            array($this, "checkbox_HTML"), // function -> return HTML
            "word-count-settings-page", //page slug
            "wcp_first_section", // section/field,
            array("the_name" => "wcp_char_count") // args argument
        );
        // add custom setting
        register_setting(
            "word_count_plugin", // name of group
            "wcp_char_count", // specific setting
            [
                "sanitize_callback" => "sanitize_text_field", //sanitize,
                "default" => "1" // default 0-> beg, 1 end
            ] // array
        );

        // Read Time
        // build html for setting
        add_settings_field(
            "wcp_read_time", //name
            "Read Time", // HTML label
            array($this, "checkbox_HTML"), // function -> return HTML
            "word-count-settings-page", //page slug
            "wcp_first_section", // section/field,
            array("the_name" => "wcp_read_time") // args argument
        );
        // add custom setting
        register_setting(
            "word_count_plugin", // name of group
            "wcp_read_time", // specific setting
            [
                "sanitize_callback" => "sanitize_text_field", //sanitize,
                "default" => "1" // default 0-> beg, 1 end
            ] // array
        );
    }

    function sanitize_location($input)
    {
        if ($input != "0" && $input != "1") {
            // add error message
            add_settings_error(
                "wcp_location", // name of option
                "wcp_location_error", // slug
                "Display location must be either beginning or end of post.", // error message
            );

            return get_option("wcp_location");
        }
        return $input;
    }

    function location_HTML()
    {
    ?>
        <select name="wcp_location">
            <option value="0" <?php selected(get_option("wcp_location"), "0") ?>>Beginning of post</option>
            <option value="1" <?php selected(get_option("wcp_location"), "1") ?>>End of post</option>
        </select>
    <?php
    }

    function headline_HTML()
    {
    ?>
        <input type="text" name="wcp_headline" value="<?php echo esc_attr(get_option('wcp_headline')); ?>">
    <?php
    }

    function checkbox_HTML($args)
    {
    ?>
        <input type="checkbox" name="<?php echo $args["the_name"] ?>" value="1" <?php checked(get_option($args["the_name"]), "1"); ?> 
    <?php                                                                                                                                
    }

    function if_wrap($content){
        if(
            (is_main_query() && is_single())
            &&
            (get_option("wcp_word_count", "1") OR
            get_option("wcp_char_count", "1") OR
            get_option("wcp_read_time", "1")
            )    
        )
        {//single page
            return $this->create_HTML($content);
        }

        return $content;
    }

    function create_HTML($content){
        $html = "<h3>".get_option("wcp_headline", "Post Statistics")."</h3><p>";
        $location = get_option("wcp_location", "0");//option name, default

        if($location=="0"){//beg
            return $html . $content;
        }

        return $content . $html;
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
                                                                                                                                