wp.blocks.registerBlockType(
    "ourblocktheme/events-and-blogs",
    {
        title: "Events and Blogs",
        edit: function () {
            return wp.element.createElement(
                "div",
                null,
                "Events and Blogs Placeholder"
            )
        },
        save: function () {
            return null
        }
    }
)
