<?php

class Pet
{
    function __construct()
    {
        
    }

    function get_pets()
    {
        global $wpdb;
        $table_name = $wpdb->prefix . "pets";

        $args = $this->get_args();
        $placeholders = $this->create_placeholders();

        $query = "SELECT * FROM $table_name";
        $query .= $this->create_where_text();  
        $query .=" LIMIT 100";       

        $pets = $wpdb->get_results($wpdb->prepare($query, $placeholders));

        return $pets;
    }

    function get_args(){

    }

    function create_placeholders(){

    }

    function create_where_text(){

    }
}
