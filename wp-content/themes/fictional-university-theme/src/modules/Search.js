import $ from "jquery"

class Search {
    // 1. describe and create/initiate our object
    constructor() {
        this.add_search_html();

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

                this.typing_timer = setTimeout(this.get_results.bind(this), 750); //function, milisec
            } else { //blank
                this.results_div.html("");
                this.is_spinner_visible = false;
            }
        }
        this.previous_value = this.search_field.val();
    }

    get_results() {
        $.getJSON(university_data.root_url + "/wp-json/university/v1/search?term=" + this.search_field.val(),
            (results) => {
                this.results_div.html(`
                <div class="row">
                    <div class="one-third">
                        <h2 class="search-overlay__section-title">General Information</h2>
                        ${results.general_info.length ? '<ul class="link-list min-list">' : "<p>No general Information matches the search.</p>"} <!--expression -->
                            <!-- looping -->
                            ${results.general_info.map(
                            item => `
                            <li>
                                <a href="${item.permalink}">${item.title}</a> ${item.post_type == "post" ? `by ${item.author_name}` : ""}
                            </li>`
                        ).join('')}
                        ${results.general_info.length ? "</ul>" : ""} <!--expression -->
                    </div>
                    <div class="one-third">
                        <h2 class="search-overlay__section-title">Programs</h2>
                        ${results.programs.length ? 
                            '<ul class="link-list min-list">' : 
                            `<p>No programs match the search.
                                <a href="${university_data.root_url}/programs">View all programs</a>
                            </p>`
                        } <!--expression -->
                            <!-- looping -->
                            ${results.programs.map(
                            item => `
                            <li>
                                <a href="${item.permalink}">${item.title}</a>
                            </li>`
                        ).join('')}
                        ${results.programs.length ? "</ul>" : ""} <!--expression -->

                        <h2 class="search-overlay__section-title">Professors</h2>
                        ${results.professors.length ? 
                            '<ul class="professor-cards">' : 
                            `<p>No professors match the search.</p>`
                        }
                            <!-- looping -->
                            ${results.professors.map(
                            item => `
                            <li class="professor-card__list-item">
                                <a class="professor-card" href="${item.permalink}">
                                    <img class="professor-card__image" src="${item.image}" alt="">
                                    <span class="professor-card__name">${item.title}</span>
                                </a>
                            </li>
                            `
                        ).join('')}
                        ${results.professors.length ? "</ul>" : ""} <!--expression -->
                    </div>
                    <div class="one-third">
                        <h2 class="search-overlay__section-title">Campuses</h2>
                        ${results.campuses.length ? 
                            '<ul class="link-list min-list">' : 
                            `<p>No campuses match the search.
                                <a href="${university_data.root_url}/campuses">View all campuses</a>
                            </p>`
                        }
                            <!-- looping -->
                            ${results.campuses.map(
                            item => `
                            <li>
                                <a href="${item.permalink}">${item.title}</a>
                            </li>`
                        ).join('')}
                        ${results.campuses.length ? "</ul>" : ""} <!--expression -->

                        <h2 class="search-overlay__section-title">Events</h2>
                        ${results.events.length ? 
                            '<ul class="link-list min-list">' : 
                            `<p>No events match the search.
                                <a href="${university_data.root_url}/events">View all events</a>
                            </p>`
                        }
                            <!-- looping -->
                            ${results.events.map(
                            item => `
                            <li>
                                <a href="${item.permalink}">${item.title}</a>
                            </li>`
                        ).join('')}
                        ${results.events.length ? "</ul>" : ""} <!--expression -->
                    </div>
                </div>
                `);
                this.is_spinner_visible = false;
            }
        );
    }

    key_press_dispatcher(e) {
        let key_code = e.keyCode;
        if (
            key_code == 83 &&
            !this.is_overlay_open &&
            !$("input, textarea").is(":focus") // not in input or textarea
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

        this.search_field.val("");

        this.results_div.html("");

        setTimeout(() => this.search_field.focus(), 300);

        this.is_overlay_open = true;
    }

    close_overlay() {
        this.search_overlay.removeClass("search-overlay--active");

        // add ability to scroll
        $("body").removeClass("body-no-scroll");

        this.is_overlay_open = false;
    }

    add_search_html() {
        $("body").append(
            `
            <div class="search-overlay">
                <div class="search-overlay__top">
                    <div class="container">
                        <i class="fa fa-search search-overlay__icon" aria-hidden="true"></i>
                        <input type="text" class="search-term" placeholder="What are you looking for?" id="search-term" autocomplete="off">
                        <i class="fa fa-window-close search-overlay__close" aria-hidden="true"></i>
                    </div>
                </div>
                <div class="container">
                    <div id="search-overlay__results">
                        
                    </div>
                </div>
            </div>
            `
        );
    }
}

export default Search;