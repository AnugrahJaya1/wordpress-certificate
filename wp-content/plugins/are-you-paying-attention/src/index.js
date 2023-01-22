// register block type for post -> global scope
wp.blocks.registerBlockType(
    "our-plugin/are-paying-attention", // sort name/var name
    {
        title: "Are You Paying Attention?",
        icon: "smiley",
        category: "common",
        edit: function () {
              // jsx
              return (
                <div>
                    <h1>HALLO</h1>
                    <h4 style={{ color: "skyblue" }} >WORLD</h4>
                </div>
            );
        },// js function -> control what u see in editor 
        save: function () {
              // jsx
              return (
                <>
                    <h1>HALLO</h1>
                    <h4>WORLD</h4>
                </>
            );
        }// js function -> what u see in public
    }// config obj
);