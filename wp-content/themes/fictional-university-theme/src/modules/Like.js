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
        }else{
            this.create_like();
        }
    }

    create_like() {
        
    }

    delete_like() {
        
    }
}

export default Like