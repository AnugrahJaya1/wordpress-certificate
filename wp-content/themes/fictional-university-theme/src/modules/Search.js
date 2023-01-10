import $ from "jquery"

class Search {
    // 1. describe and create/initiate our object
    constructor() {
        this.open_button = $(".js-search-trigger");//jquery

        this.close_button = $(".search-overlay__close");

        this.search_overlay = $(".search-overlay");

        this.search_field = $("#search-term");

        this.results_div = $("#search-overlay__results");

        this.typing_timer;
        this.previous_value;

        // state overlay
        this.is_overlay_open = false;
        this.is_spinner_visible = false;

        this.events();
    }

    // 2. events
    events() {
        this.open_button.on("click", this.open_overlay.bind(this));// event, function

        this.close_button.on("click", this.close_overlay.bind(this));// event, function

        // add keyup event (once call)
        $(document).on("keydown", this.key_press_dispatcher.bind(this));// event, function

        // add countdown after user type
        this.search_field.on("keyup", this.typing_logic.bind(this));
    }

    // 3. methods
    typing_logic() {
        if (this.search_field.val() != this.previous_value) {
            clearTimeout(this.typing_timer); //value that we want to clear

            if (this.search_field.val()) {
                if (!this.is_spinner_visible) {
                    this.is_spinner_visible = true;
                    this.results_div.html("<div class='spinner-loader'></div>");
                }

                this.typing_timer = setTimeout(this.get_results.bind(this), 2000); //function, milisec
            } else { //blank
                this.results_div.html("");
                this.is_spinner_visible = false;
            }
        }
        this.previous_value = this.search_field.val();
    }

    get_results() {
        this.is_spinner_visible = false;
        this.results_div.html("Results here..");
    }

    key_press_dispatcher(e) {
        let key_code = e.keyCode;
        if (
            key_code == 83 &&
            this.is_overlay_open &&
            !$("input, textarea").is(":focus") // not in input or textare
        ) {// s
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