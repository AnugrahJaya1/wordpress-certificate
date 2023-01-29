wp.blocks.registerBlockType(
    "ourblocktheme/page-my-notes",
    {
        title: "Fictional University Page My Notes",
        edit: function () {
            return wp.element.createElement(
                "div",
                { className: "our-placeholder-block" },
                "Page My Notes Placeholder")
        },
        save: function () {
            return null
        }
    }
)
