import { registerBlockType} from "@wordpress/blocks"

registerBlockType(
    "ourblocktheme/generic-heading",
    {
        title: "Generic Heading",
        edit: EditComponent,
        save: SaveComponent
    }
)

function EditComponent() {
    return (
        <div>H</div>
    )
}

function SaveComponent() {
    return (
        <div>AS</div>
    )
}