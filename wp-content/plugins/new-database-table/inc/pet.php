<?php

class Pet
{
    private $table_name,$args, $placeholders;
    function __construct()
    {
        global $wpdb;
        $this->table_name = $wpdb->prefix . "pets";

        $this->args = $this->get_args();
        $this->placeholders = $this->create_placeholders($this->args);
    }

    function get_pets()
    {
        global $wpdb;

        $query = "SELECT * FROM $this->table_name";
        $query .= $this->create_where_text($this->args);
        $query .= " LIMIT 100";

        $pets = $wpdb->get_results($wpdb->prepare($query, $this->placeholders));

        return $pets;
    }

    function get_count()
    {
        global $wpdb;

        $query = "SELECT COUNT(*) FROM $this->table_name";
        $query .= $this->create_where_text($this->args);
        $query .= " LIMIT 100";

        $count = $wpdb->get_var($wpdb->prepare($query, $this->placeholders));

        return $count;
    }

    function get_args()
    {
        $temp = [];

        if (isset($_GET['fav_color'])) $temp['fav_color'] = sanitize_text_field($_GET['fav_color']);
        if (isset($_GET['species'])) $temp['species'] = sanitize_text_field($_GET['species']);
        if (isset($_GET['min_year'])) $temp['min_year'] = sanitize_text_field($_GET['min_year']);
        if (isset($_GET['max_year'])) $temp['max_year'] = sanitize_text_field($_GET['max_year']);
        if (isset($_GET['min_weight'])) $temp['min_weight'] = sanitize_text_field($_GET['min_weight']);
        if (isset($_GET['max_weight'])) $temp['max_weight'] = sanitize_text_field($_GET['max_weight']);
        if (isset($_GET['fav_hobby'])) $temp['fav_hobby'] = sanitize_text_field($_GET['fav_hobby']);
        if (isset($_GET['fav_food'])) $temp['fav_food'] = sanitize_text_field($_GET['fav_food']);

        return array_filter($temp, function ($x) {
            return $x;
        });
    }

    function create_placeholders($args)
    {
        return array_map(function ($x) {
            return $x;
        }, $args);
    }

    function create_where_text($args)
    {
        $where_query = "";

        if (count($args)) {
            $where_query = " WHERE ";
        }

        $current_position = 0;
        foreach ($args as $index => $item) {
            $where_query .= $this->specific_query($index);

            if ($current_position != count($args) - 1) {
                $where_query .= " AND ";
            }

            $current_position++;
        }

        return $where_query;
    }

    function specific_query($index)
    {
        switch ($index) {
            case "min_weight":
                return "pet_weight >= %d";
            case "max_weight":
                return "pet_weight <= %d";
            case "min_year":
                return "birth_year >= %d";
            case "max_year":
                return "birth_year <= %d";
            default:
                return $index . " = %s";
        }
    }
}
