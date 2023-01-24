<?php

/*
  Plugin Name: Featured Professor Block Type
  Version: 1.0
  Author: Jaya
  Author URI: https://www.udemy.com/user/bradschiff/
*/

if( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

require_once plugin_dir_path(__FILE__)."/inc/generate_professor_HTML.php";

class FeaturedProfessor {
  function __construct() {
    add_action('init', [$this, 'on_init']);
  }

  function on_init() {
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

}

$featuredProfessor = new FeaturedProfessor();