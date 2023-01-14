import $ from "jquery";

class MyNote {
    constructor() {
        this.delete_button = $(".delete-note");

        this.events();
    }

    events() {
        this.delete_button.on("click", this.delete_note);//event,functions
    }

    // custom method
    delete_note(e) {
        var this_note = $(e.target).parents("li");// get li as "object"
        // ajax -> u can control any req instead of get if used getJSON
        $.ajax({
            beforeSend: (xhr) => {
                xhr.setRequestHeader("X-WP-Nonce", university_data.nonce);//target, value
            },
            url: university_data.root_url + "/wp-json/wp/v2/note/"+this_note.data("id"), // can use data-id, same with li
            type: "DELETE",
            success: (response) => {
                this_note.slideUp();// remove by slide animation
                console.log(response)
            },// arrow function
            error: (response) => {
                console.log(response)
            }
        });
    }
}

export default MyNote;