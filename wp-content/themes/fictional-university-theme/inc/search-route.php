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

function university_search_results(WP_REST_Request $request){
    $professors = new WP_Query([
        "post_type" => "professor",
        "s" => sanitize_text_field($request["term"]),// s=>search
    ]);

    $professor_results = [];

    while($professors->have_posts()){
        $professors->the_post();

        array_push($professor_results, [
            "title" => get_the_title(),
            "permalink" => get_the_permalink()
        ]);
    }

    return $professor_results;    
}

add_action("rest_api_init", "university_register_search");
