<?php

function university_like_routes()
{
    register_rest_route(
        "university/v1", // name space
        "manage-like", // route
        [
            "methods" => "POST", // make universal
            "callback" => "create_like",
            'permission_callback' => '__return_true'
        ]
    );

    register_rest_route(
        "university/v1", // name space
        "manage-like", // route
        [
            "methods" => "DELETE", // make universal
            "callback" => "delete_like",
            'permission_callback' => '__return_true'
        ]
    );
}

function create_like(){
    return "create";
}

function delete_like(){
    return "delete";
}

add_action("rest_api_init", "university_like_routes");
