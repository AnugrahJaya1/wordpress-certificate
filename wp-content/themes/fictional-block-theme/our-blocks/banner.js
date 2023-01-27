wp.blocks.registerBlockTye(
    "our-block-theme/banner", //name
    {
        title: "Banner",
        edit: EditComponent,
        save: SaveComponent
    }// object
);

function EditComponent(){

}

function SaveComponent(){
    return <p>Save</p>
}