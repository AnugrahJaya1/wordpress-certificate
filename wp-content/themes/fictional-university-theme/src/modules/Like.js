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
            this.delete_like();
        } else {
            this.create_like();
        }
    }

    create_like() {
        $.ajax({
            url: university_data.root_url + "/wp-json/university/v1/manage-like",
            type: "POST",
            success: (response) => {
                console.log(response);
            },
            error: (response) => {
                console.log(response);
            }
        });
    }

    delete_like() {
        $.ajax({
            url: university_data.root_url + "/wp-json/university/v1/manage-like",
            type: "DELETE",
            success: (response) => {
                console.log(response);
            },
            error: (response) => {
                console.log(response);
            }
        });
    }
}

export default Like