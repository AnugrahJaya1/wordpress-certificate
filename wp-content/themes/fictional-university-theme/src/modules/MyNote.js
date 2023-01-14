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
    delete_note() {
        
    }
}

export default MyNote;