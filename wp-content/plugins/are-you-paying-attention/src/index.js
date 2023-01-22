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
            sky_color: { type: "string" },
            grass_color: { type: "string" },
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
    function update_sky_color(event) {
        props.setAttributes({ sky_color: event.target.value });
    }

    function update_grass_color(event) {
        props.setAttributes({ grass_color: event.target.value });
    }

    // jsx
    return (
        <div className="paying-attention-edit-block">
            <TextControl label="Question:" />
            <p>Answers:</p>
            <Flex>
                <FlexBlock>
                    <TextControl />
                </FlexBlock>
                <FlexItem>
                    <Button>
                        <Icon icon="star-empty"></Icon>
                    </Button>
                </FlexItem>
                <FlexItem>
                    <Button>
                        Delete
                    </Button>
                </FlexItem>
            </Flex>
        </div>
    );
}