import $ from "jquery"

class Search {
    // 1. describe and create/initiate our object
    constructor() {
        this.open_button = $(".js-search-trigger");//jquery

        this.close_button = $(".search-overlay__close");

        this.search_overlay = $(".search-overlay");

        this.search_field = $("#search-term");

        this.typing_timer;

        // state overlay
        this.is_overlay_open = false;

        this.events();
    }

    // 2. events
    events() {
        this.open_button.on("click", this.open_overlay.bind(this));// event, function

        this.close_button.on("click", this.close_overlay.bind(this));// event, function

        // add keyup event (once call)
        $(document).on("keyup", this.key_press_dispatcher.bind(this));// event, function

        // add countdown after user type
        this.search_field.on("keydown", this.typing_logic.bind(this));
    }

    // 3. methods
    typing_logic() {
        clearTimeout(this.typing_timer); //value that we want to clear
        this.typing_timer = setTimeout(function () {
            console.log("timeout")
        }, 2000); //function, milisec
    }

    key_press_dispatcher(e) {
        let key_code = e.keyCode;
        if (key_code == 83 && !this.is_overlay_open) {// s
            this.open_overlay();
        }

        if (key_code == 27 && this.is_overlay_open) {//esc
            this.close_overlay();
        }
    }

    open_overlay() {
        this.search_overlay.addClass("search-overlay--active");

        // remove ability to scroll
        $("body").addClass("body-no-scroll");

        this.is_overlay_open = true;
    }

    close_overlay() {
        this.search_overlay.removeClass("search-overlay--active");

        // add ability to scroll
        $("body").removeClass("body-no-scroll");

        this.is_overlay_open = false;
    }
}

export default Search;