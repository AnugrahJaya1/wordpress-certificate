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

        $exist_query = new WP_Query([
            "author" => get_current_user_id(),
            "post_type" => "like",
            "meta_query" => [
                [
                    "key" => "liked_professor_id",
                    "compare" => "=",
                    "value" => $professor_id
                ]
            ]
        ]);

        // already not like professor
        if ($exist_query->found_posts == 0 && get_post_type($professor_id) == "professor") {
            return wp_insert_post([
                "post_type" => "like",
                "post_status" => "publish",
                "post_title" => "Test",
                "meta_input" => [
                    "liked_professor_id" => $professor_id
                ]
            ]);
        } else {
            die("Invalid professor id");
        }
    } else {
        die("Only logged in users can create a like.");
    }
}

function delete_like($data)
{
    $like_id = sanitize_text_field($data["like"]);
    if (
        get_current_user_id() == get_post_field("post_author", $like_id) &&
        get_post_type($like_id) == "like"
    ) {
        wp_delete_post($like_id, true);
        return "Congrats, like deleted.";
    } else {
        die("You don't have permission to delete that.");
    }
}

add_action("rest_api_init", "university_like_routes");
