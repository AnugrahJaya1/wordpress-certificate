// register block type for post -> global scope
wp.blocks.registerBlockType(
    "our-plugin/are-paying-attention", // sort name/var name
    {
        title: "Are You Paying Attention?",
        icon: "smiley",
        category: "common",
        edit: function () {
            return <h3>JSX</h3>
        },// js function -> control what u see in editor 
        save: function () {
            return wp.element.createElement(
                "h1",// type
                null,// desc element
                "FE",// children/content
            ); //create html within js
        }// js function -> what u see in public
    }// config obj
);