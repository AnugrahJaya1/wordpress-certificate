import { TextControl, Flex, FlexBlock, FlexItem, Button, Icon } from "@wordpress/components"
import "./index.scss"

// register block type for post -> global scope
wp.blocks.registerBlockType(
    "our-plugin/are-paying-attention", // sort name/var name
    {
        title: "Are You Paying Attention?",
        icon: "smiley",
        category: "common",
        attributes: {
            question: { type: "string" },
            answers: { type: "array", default: [""] },
            correct_answer: {type: "number", default: undefined}
        },
        edit: EditComponent,// js function -> control what u see in editor 
        save: function (props) {
            // jsx
            return null
        },// js function -> what u see in public
    }// config obj
);

function EditComponent(props) {
    // wp will throw val as props
    function update_question(value) {
        props.setAttributes({ question: value });
    }

    function delete_answer(index_to_delete){
        const new_answers = props.attributes.answers.filter(function(x, index){//don't need first param
            return index !=index_to_delete // return true if not same with index we wanna delete
        }) // return copy
        props.setAttributes({answers: new_answers})
    }

    function mark_as_correct(index){
        props.setAttributes({correct_answer: index})
    }

    // jsx
    return (
        <div className="paying-attention-edit-block">
            <TextControl label="Question:" value={props.attributes.question} onChange={update_question} style={{ fontSize: "20px" }} />
            <p style={{ fontSize: "13px", margin: "20px 0 8px 0" }}>Answers:</p>
            {/* make dynamic */}
            {props.attributes.answers.map(function (answer, index) {
                return (
                    <Flex>
                        <FlexBlock>
                            <TextControl value={answer} onChange={new_value => {
                                const new_answers = props.attributes.answers.concat([]) // return copy
                                new_answers[index] = new_value
                                props.setAttributes({ answers: new_answers })
                            }} />
                        </FlexBlock>
                        <FlexItem>
                            <Button onClick={() => mark_as_correct(index)}>
                                <Icon className="mark-as-correct" icon={props.attributes.correct_answer == index ? "star-filled" : "star-empty"}></Icon>
                            </Button>
                        </FlexItem>
                        <FlexItem>
                            <Button isLink className="attention-delete" onClick={() => delete_answer(index)}>
                            Delete
                        </Button>
                    </FlexItem>
                    </Flex>
    )
})}
<Button isPrimary onClick={() => {
    props.setAttributes({ answers: props.attributes.answers.concat([""]) })
}}>Add another answers</Button>
        </div >
    );
}