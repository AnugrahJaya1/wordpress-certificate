import $ from "jquery";

class Like {
    constructor() {
        this.events();
    }

    events() {
        $(".like-box").on("click", this.on_click_dispatcher.bind(this));
    }

    //custom function
    on_click_dispatcher(e) {
        var current_like_box = $(e.target).closest(".like-box");

        var status = current_like_box.data("exists");
        if (status == "yes") {
            this.delete_like(current_like_box);
        } else {
            this.create_like(current_like_box);
        }
    }

    create_like(current_like_box) {
        $.ajax({
            beforeSend: (xhr) => {
                xhr.setRequestHeader("X-WP-Nonce", university_data.nonce);//target, value
            },
            url: university_data.root_url + "/wp-json/university/v1/manage-like",
            type: "POST",
            data: {
                "professor_id" : current_like_box.data("id"),
            },
            success: (response) => {
                // increment like count
                current_like_box.attr("data-exists", "yes");
                var like_count = parseInt(current_like_box.find(".like-count").html(),10);//value, base
                like_count++;
                current_like_box.find(".like-count").html(like_count);
                current_like_box.attr("data-like", response);
                location.reload();
                console.log(response);
            },
            error: (response) => {
                console.log(response);
            }
        });
    }

    delete_like(current_like_box) {
        $.ajax({
            beforeSend: (xhr) => {
                xhr.setRequestHeader("X-WP-Nonce", university_data.nonce);//target, value
            },
            url: university_data.root_url + "/wp-json/university/v1/manage-like",
            type: "DELETE",
            data: {
                "like" : current_like_box.data("like"),
            },
            success: (response) => {
                current_like_box.attr("data-exists", "no");
                var like_count = parseInt(current_like_box.find(".like-count").html(),10);//value, base
                like_count--;
                current_like_box.find(".like-count").html(like_count);
                current_like_box.attr("data-like", "");
                location.reload();
                console.log(response);
            },
            error: (response) => {
                console.log(response);
            }
        });
    }
}

export default Like