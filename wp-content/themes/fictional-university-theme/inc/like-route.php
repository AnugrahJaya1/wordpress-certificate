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

function create_like($data)
{
    if (is_user_logged_in()) {
        // get data from js request
        $professor_id = sanitize_text_field($data["professor_id"]);

        return wp_insert_post([
            "post_type" => "like",
            "post_status" => "publish",
            "post_title" => "Test",
            "meta_input" => [
                "liked_professor_id" => $professor_id
            ]
        ]);
    } else {
        die("Only logged in users can create a like.");
    }
}

function delete_like()
{
    return "delete";
}

add_action("rest_api_init", "university_like_routes");
