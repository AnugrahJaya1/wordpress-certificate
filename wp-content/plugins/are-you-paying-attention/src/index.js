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
        edit: function (props) {
            // wp will throw val as props
            function update_sky_color(event){
                props.setAttributes({sky_color: event.target.value});
            }

            function update_grass_color(event){
                props.setAttributes({grass_color: event.target.value});
            }

            // jsx
            return (
                <div>
                    <input type="text" placeholder="Sky Color" value={props.attributes.sky_color} onChange={update_sky_color}></input>
                    <input type="text" placeholder="Grass Color" value={props.attributes.grass_color} onChange={update_grass_color}></input>
                </div>
            );
        },// js function -> control what u see in editor 
        save: function (props) {
            // jsx
            return (
                <p>Today the sky is {props.attributes.sky_color} and the grass is {props.attributes.grass_color}.</p>
            );
        }// js function -> what u see in public
    }// config obj
);