import $ from "jquery"

class Search {
    // 1. describe and create/initiate our object
    constructor() {
        this.open_button = $(".js-search-trigger");//jquery

        this.close_button = $(".search-overlay__close");

        this.search_overlay = $(".search-overlay");

        this.events();
    }

    // 2. events
    events() {
        this.open_button.on("click", this.open_overlay.bind(this));// event, function

        this.close_button.on("click", this.close_overlay.bind(this));// event, function

        // add keyup event (once call)
        $(document).on("keyup", this.key_press_dispatcher.bind(this));// event, function
    }

    // 3. methods
    open_overlay() {
        this.search_overlay.addClass("search-overlay--active");

        // remove ability to scroll
        $("body").addClass("body-no-scroll");
    }

    key_press_dispatcher(e) {
        let key_code = e.keyCode;
        if (key_code == 83) {// s
            this.open_overlay();
        } else if (key_code == 27) {//esc
            this.close_overlay();
        }
    }

    close_overlay() {
        this.search_overlay.removeClass("search-overlay--active");

        // add ability to scroll
        $("body").removeClass("body-no-scroll");
    }
}

export default Search;