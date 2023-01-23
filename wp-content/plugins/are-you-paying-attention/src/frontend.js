import React, { useState, useEffect } from "react"
import ReactDOM from "react-dom"
import "./frontend.scss"

const div_to_update = document.querySelectorAll(".paying-attention-update-me")

div_to_update.forEach(function (div) {
    const data = JSON.parse(div.querySelector("pre").innerHTML)
    ReactDOM.render(<Quiz {...data} />, div) // add data to props
    div.classList.remove("paying-attention-update-me")
})

function Quiz(props) {
    const [is_correct, set_is_correct] = useState(undefined)
    const [is_correct_delayed, set_is_correct_delayed] = useState(undefined)


    useEffect(
        () => {
            if (is_correct == false) {
                setTimeout(() => {
                    set_is_correct(undefined)
                }, 2600)
            }

            if (is_correct == true) {
                setTimeout(() => {
                    set_is_correct_delayed(true)
                }, 1000)
            }
        }, // function
        [is_correct]// when will run
    )

    function handle_answer(index) {
        if (index == props.correct_answer) {
            set_is_correct(true)
        } else {
            set_is_correct(false)
        }
    }

    return (
        <div className="paying-attention-frontend" style={{ backgroundColor: props.bg_color }}>
            <p>{props.question}</p>
            <ul>
                {props.answers.map(function (answer, index) {
                    return (
                        <li className={(is_correct_delayed == true && index == props.correct_answer ? "no-click " : "") + (is_correct_delayed == true && index != props.correct_answer ? "fade-incorrect" : "")} onClick={is_correct == true ? undefined : () => handle_answer(index)}>
                            {is_correct_delayed == true && index == props.correct_answer && (
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" className="bi bi-check" viewBox="0 0 16 16">
                                    <path d="M10.97 4.97a.75.75 0 0 1 1.07 1.05l-3.99 4.99a.75.75 0 0 1-1.08.02L4.324 8.384a.75.75 0 1 1 1.06-1.06l2.094 2.093 3.473-4.425a.267.267 0 0 1 .02-.022z" />
                                </svg>
                            )}
                            {is_correct_delayed == true && index != props.correct_answer && (
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" className="bi bi-x" viewBox="0 0 16 16">
                                    <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z" />
                                </svg>
                            )}
                            {answer}
                        </li>
                    )
                })}
            </ul>
            <div className={"correct-message " + (is_correct == true ? "correct-message--visible" : "")}>
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" className="bi bi-emoji-smile" viewBox="0 0 16 16">
                    <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z" />
                    <path d="M4.285 9.567a.5.5 0 0 1 .683.183A3.498 3.498 0 0 0 8 11.5a3.498 3.498 0 0 0 3.032-1.75.5.5 0 1 1 .866.5A4.498 4.498 0 0 1 8 12.5a4.498 4.498 0 0 1-3.898-2.25.5.5 0 0 1 .183-.683zM7 6.5C7 7.328 6.552 8 6 8s-1-.672-1-1.5S5.448 5 6 5s1 .672 1 1.5zm4 0c0 .828-.448 1.5-1 1.5s-1-.672-1-1.5S9.448 5 10 5s1 .672 1 1.5z" />
                </svg>
                <p>That is correct!</p>
            </div>
            <div className={"incorrect-message " + (is_correct == false ? "correct-message--visible" : "")}>
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" className="bi bi-emoji-frown" viewBox="0 0 16 16">
                    <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z" />
                    <path d="M4.285 12.433a.5.5 0 0 0 .683-.183A3.498 3.498 0 0 1 8 10.5c1.295 0 2.426.703 3.032 1.75a.5.5 0 0 0 .866-.5A4.498 4.498 0 0 0 8 9.5a4.5 4.5 0 0 0-3.898 2.25.5.5 0 0 0 .183.683zM7 6.5C7 7.328 6.552 8 6 8s-1-.672-1-1.5S5.448 5 6 5s1 .672 1 1.5zm4 0c0 .828-.448 1.5-1 1.5s-1-.672-1-1.5S9.448 5 10 5s1 .672 1 1.5z" />
                </svg>
                <p>Sorry, try again</p>
            </div>
        </div>
    )
}