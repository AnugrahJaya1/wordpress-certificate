import { registerBlockType } from "@wordpress/blocks"
import { RichText, BlockControls } from "@wordpress/block-editor"
import { ToolbarGroup, ToolbarButton } from "@wordpress/components"

registerBlockType(
    "ourblocktheme/generic-button",
    {
        title: "Generic Button",
        attributes: {
            text: { type: "string" },
            size: { type: "string", default: "large" }
        },
        edit: EditComponent,
        save: SaveComponent
    }
)

function EditComponent(props) {
    function handleTextChange(x) {
        props.setAttributes({ text: x })
    }

    return (
        <>
            <BlockControls>
                <ToolbarGroup>
                    <ToolbarButton isPressed={props.attributes.size == "large"} onClick={() => props.setAttributes({ size: "large" })}>
                        Large
                    </ToolbarButton>
                    <ToolbarButton isPressed={props.attributes.size == "medium"} onClick={() => props.setAttributes({ size: "medium" })}>
                        Medium
                    </ToolbarButton>
                    <ToolbarButton isPressed={props.attributes.size == "small"} onClick={() => props.setAttributes({ size: "small" })}>
                        Small
                    </ToolbarButton>
                </ToolbarGroup>
            </BlockControls>
            <RichText allowedFormats={[]} tagName="a" className={`btn btn--${props.attributes.size}`} value={props.attributes.text} onChange={handleTextChange} />
        </>
    )
}

function SaveComponent(props) {
    return <a href="#" className={`btn btn--${props.attributes.size}`}>
        {props.attributes.text}
    </a>
}