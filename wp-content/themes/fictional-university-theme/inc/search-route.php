<?php

function university_register_search()
{
    register_rest_route(
        "university/v1", // name space
        "search", // route
        [
            "method" => WP_REST_Server::READABLE, // make universal
            "callback" => "university_search_results",
            'permission_callback' => '__return_true'
        ]
    );
}

function university_search_results(){
    return "HALLO";
}

add_action("rest_api_init", "university_register_search");
