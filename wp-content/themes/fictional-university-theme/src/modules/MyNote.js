import $ from "jquery";

class MyNote {
    constructor() {
        this.events();
    }

    events() {
        $("#my-notes").on("click", ".delete-note", this.delete_note);//event,functions
        $("#my-notes").on("click", ".edit-note", this.edit_note.bind(this));//event,functions
        $("#my-notes").on("click", ".update-note", this.update_note.bind(this));//event,functions
        $(".submit-note").on("click", this.create_note.bind(this));//event,functions
    }

    create_note(e) {
        var new_post = {
            "title": $(".new-note-title").val(),
            "content": $(".new-note-body").val(),
            "status": "private"
        }
        // ajax -> u can control any req instead of get if used getJSON
        $.ajax({
            beforeSend: (xhr) => {
                xhr.setRequestHeader("X-WP-Nonce", university_data.nonce);//target, value
            },
            url: university_data.root_url + "/wp-json/wp/v2/note/", // can use data-id, same with li
            type: "POST",
            data: new_post,
            success: (response) => {
                // remove string
                $(".new-note-title, .new-note-body").val("");
                // show in UI
                $(`
                <li data-id="${response.id}">
                    <input readonly type="text" class="note-title-field" value="${response.title.raw}">
                    <span class="edit-note">
                        <i class="fa fa-pencil" aria-hidden="true"></i>
                        Edit
                    </span>
                    <span class="delete-note">
                        <i class="fa fa-trash-o" aria-hidden="true"></i>
                        Delete
                    </span>
                    <textarea readonly class="note-body-field">${response.content.raw}</textarea>
                    <span class="update-note btn btn--blue btn--small">
                        <i class="fa fa-arrow-right" aria-hidden="true"></i>
                        Save
                    </span>
                </li>
                `).prependTo("#my-notes").hide().slideDown();

                console.log(response)
            },// arrow function
            error: (response) => {
                console.log(response)
            }
        });
    }

    edit_note(e) {
        var this_note = $(e.target).parents("li");// get li as "object"

        if (this_note.data("state") == "editable") {
            // make read only
            this.make_note_readonly(this_note);
        } else {
            // make editable
            this.make_note_editable(this_note);
        }
    }

    make_note_editable(this_note) {
        this_note.find(".edit-note").html('<i class="fa fa-times" aria-hidden="true"></i>Cancel');

        this_note.find(".note-title-field, .note-body-field").removeAttr("readonly").addClass("note-active-field");
        this_note.find(".update-note").addClass("update-note--visible");
        this_note.data("state", "editable");
    }

    make_note_readonly(this_note) {
        this_note.find(".edit-note").html('<i class="fa fa-pencil" aria-hidden="true"></i>Edit');

        this_note.find(".note-title-field, .note-body-field").attr("readonly", "readonly").removeClass("note-active-field");
        this_note.find(".update-note").removeClass("update-note--visible");
        this_note.data("state", "cancel");
    }

    update_note(e) {
        var this_note = $(e.target).parents("li");// get li as "object"

        var updated_post = {
            "title": this_note.find(".note-title-field").val(),
            "content": this_note.find(".note-body-field").val()
        }
        // ajax -> u can control any req instead of get if used getJSON
        $.ajax({
            beforeSend: (xhr) => {
                xhr.setRequestHeader("X-WP-Nonce", university_data.nonce);//target, value
            },
            url: university_data.root_url + "/wp-json/wp/v2/note/" + this_note.data("id"), // can use data-id, same with li
            type: "POST",
            data: updated_post,
            success: (response) => {
                this.make_note_readonly(this_note);
                console.log(response)
            },// arrow function
            error: (response) => {
                console.log(response)
            }
        });
    }

    // custom method
    delete_note(e) {
        var this_note = $(e.target).parents("li");// get li as "object"
        // ajax -> u can control any req instead of get if used getJSON
        $.ajax({
            beforeSend: (xhr) => {
                xhr.setRequestHeader("X-WP-Nonce", university_data.nonce);//target, value
            },
            url: university_data.root_url + "/wp-json/wp/v2/note/" + this_note.data("id"), // can use data-id, same with li
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