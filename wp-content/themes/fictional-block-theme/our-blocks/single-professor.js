wp.blocks.registerBlockType(
    "ourblocktheme/single-professor",
    {
        title: "Fictional University Single Professor",
        edit: function () {
            return wp.element.createElement(
                "div",
                { className: "our-placeholder-block" },
                "Single Professor Placeholder")
        },
        save: function () {
            return null
        }
    }
)
