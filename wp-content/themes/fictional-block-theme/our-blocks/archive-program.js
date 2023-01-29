wp.blocks.registerBlockType(
    "ourblocktheme/archive-program",
    {
        title: "Fictional University Archive Program",
        edit: function () {
            return wp.element.createElement(
                "div",
                { className: "our-placeholder-block" },
                "Archive Program Placeholder")
        },
        save: function () {
            return null
        }
    }
)
