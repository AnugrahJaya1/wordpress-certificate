import React from "react"
import ReactDOM from "react-dom"
import "./frontend.scss"

const div_to_update = document.querySelectorAll(".paying-attention-update-me")

div_to_update.forEach(function (div){
    const data = JSON.parse(div.querySelector("pre").innerHTML)
    ReactDOM.render(<Quiz {...data}/>, div) // add data to props
    div.classList.remove("paying-attention-update-me")
})

function Quiz(props){
    function handle_answer(index){
        if(index == props.correct_answer){
            alert("Congrats")
        }else{
            alert("Sorry")
        }
    }

    return (
        <div className="paying-attention-frontend">
            <p>{props.question}</p>
            <ul>
                {props.answers.map(function(answer, index){
                    return <li onClick={() => handle_answer(index)}>{answer}</li>
                })}
            </ul>
        </div>
    )
}