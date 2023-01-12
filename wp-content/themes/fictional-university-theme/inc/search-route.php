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

function university_search_results(WP_REST_Request $request)
{
    $main_query = new WP_Query([
        "post_type" => ["post", "page", "professor", "program", "event", "campus"],
        "s" => sanitize_text_field($request["term"]), // s=>search
    ]);

    $results = [
        "general_info" => [],
        "professors" => [],
        "programs" => [],
        "events" => [],
        "campuses" => []
    ];

    while ($main_query->have_posts()) {
        $main_query->the_post();

        if (get_post_type() == "post" || get_post_type() == "page") {
            array_push($results["general_info"], [
                "title" => get_the_title(),
                "permalink" => get_the_permalink(),
                "post_type" => get_post_type(),
                "author_name" => get_the_author(),
            ]);
        } else if (get_post_type() == "professor") {
            array_push($results["professors"], [
                "title" => get_the_title(),
                "permalink" => get_the_permalink(),
                "image" => get_the_post_thumbnail_url(0, "professor_landscape"), //current post,size
            ]);
        } else if (get_post_type() == "program") {
            array_push($results["programs"], [
                "title" => get_the_title(),
                "permalink" => get_the_permalink(),
                "id" => get_the_ID(),
            ]);
        } else if (get_post_type() == "event") {
            $event_date = new DateTime(get_field("event_date"));
            $description = "";
            if (has_excerpt()) {
                $description = get_the_excerpt();
            } else {
                // word, length
                $description = wp_trim_words(get_the_content(), 18);
            }
            array_push($results["events"], [
                "title" => get_the_title(),
                "permalink" => get_the_permalink(),
                "month" =>  $event_date->format("M"),
                "day" => $event_date->format("d"),
                "description" => $description
            ]);
        } else if (get_post_type() == "campus") {
            array_push($results["campuses"], [
                "title" => get_the_title(),
                "permalink" => get_the_permalink()
            ]);
        }
    }

    if ($results["programs"]) {
        $programs_meta_query = [
            "relation" => "OR",
            // loops program
        ];

        foreach ($results["programs"] as $program) {
            array_push($programs_meta_query, [
                "key" => "related_program",
                "compare" => "LIKE",
                "value" => '"' . $program["id"] . '"',
            ]);
        }

        $program_relationship_query = new WP_Query([
            "post_type" => ["professor", "event"],
            "meta_query" => $programs_meta_query
        ]);

        while ($program_relationship_query->have_posts()) {
            $program_relationship_query->the_post();

            if (get_post_type() == "professor") {
                array_push($results["professors"], [
                    "title" => get_the_title(),
                    "permalink" => get_the_permalink(),
                    "image" => get_the_post_thumbnail_url(0, "professor_landscape"), //current post,size
                ]);
            } if (get_post_type() == "event") {
                $event_date = new DateTime(get_field("event_date"));
                $description = "";
                if (has_excerpt()) {
                    $description = get_the_excerpt();
                } else {
                    // word, length
                    $description = wp_trim_words(get_the_content(), 18);
                }
                array_push($results["events"], [
                    "title" => get_the_title(),
                    "permalink" => get_the_permalink(),
                    "month" =>  $event_date->format("M"),
                    "day" => $event_date->format("d"),
                    "description" => $description
                ]);
            }
        }

        $results["professors"] = array_values(array_unique($results["professors"], SORT_REGULAR)); //remove duplicate
        $results["events"] = array_values(array_unique($results["events"], SORT_REGULAR)); //remove duplicate
    }

    return $results;
}

add_action("rest_api_init", "university_register_search");
