<?php

/*
  Plugin Name: Featured Professor Block Type
  Version: 1.0
  Author: Jaya
  Author URI: https://www.udemy.com/user/bradschiff/
*/

if( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

require_once plugin_dir_path(__FILE__)."/inc/generate_professor_HTML.php";
require_once plugin_dir_path(__FILE__)."/inc/related_post_HTML.php";

class FeaturedProfessor {
  function __construct() {
    add_action('init', [$this, 'on_init']);
    add_action("rest_api_init", array($this, "prof_HTML"));

    // add filter to content
    add_filter("the_content", array($this, "add_related_posts"));
  }

  function on_init() {
    register_meta("post", "featured_professor", array(
      "show_in_rest" => true, 
      "type" => "number",
      "single" => false
    ));// post type, meta name (from index.js), 

    wp_register_script('featuredProfessorScript', plugin_dir_url(__FILE__) . 'build/index.js', array('wp-blocks', 'wp-i18n', 'wp-editor'));
    wp_register_style('featuredProfessorStyle', plugin_dir_url(__FILE__) . 'build/index.css');

    register_block_type('ourplugin/featured-professor', array(
      'render_callback' => [$this, 'renderCallback'],
      'editor_script' => 'featuredProfessorScript',
      'editor_style' => 'featuredProfessorStyle'
    ));
  }

  function renderCallback($attributes) {
    if($attributes["prof_id"]){
      wp_enqueue_style("featuredProfessorStyle");
      return generate_professor_HTML($attributes["prof_id"]);
    }else{
      return NULL;
    }
  }

  function prof_HTML(){
    register_rest_route("featured-professor/v1","get-HTML",array(
      "methods" => WP_REST_Server::READABLE,
      "callback" => array($this, "get_prof_HTML"),
      'permission_callback' => '__return_true'
    ));
  }

  function get_prof_HTML($data){
    return generate_professor_HTML($data["prof_id"]);
  }

  function add_related_posts($content){
    if(is_singular("professor") && in_the_loop() && is_main_query()){
      return $content . related_post_HTML(get_the_id());
    }
    return $content;
  }
}

$featuredProfessor = new FeaturedProfessor();