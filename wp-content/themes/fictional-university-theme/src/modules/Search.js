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
    }

    // 3. methods
    open_overlay() {
        this.search_overlay.addClass("search-overlay--active");
    }

    close_overlay() {
        this.search_overlay.removeClass("search-overlay--active");
    }
}

export default Search;