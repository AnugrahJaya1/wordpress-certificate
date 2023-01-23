import React from "react"
import ReactDOM from "react-dom"
import "./frontend.scss"

const div_to_update = document.querySelectorAll(".paying-attention-update-me")

div_to_update.forEach(function (div){
    ReactDOM.render(<Quiz/>, div)
    div.classList.remove("paying-attention-update-me")
})

function Quiz(){
    return (
        <div className="paying-attention-frontend">
            Hallo
        </div>
    )
}