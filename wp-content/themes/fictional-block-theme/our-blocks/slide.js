import { InnerBlocks, InspectorControls, MediaUpload, MediaUploadCheck } from "@wordpress/block-editor"
import { registerBlockType } from "@wordpress/blocks"
import { Button, PanelBody, PanelRow } from "@wordpress/components"
import apiFetch from "@wordpress/api-fetch"
import { useEffect } from "@wordpress/element"

registerBlockType(
    "ourblocktheme/slide",
    {
        title: "Slide",
        supports: {
            align: ["full"]
        },
        attributes: {
            align: { type: "string", default: "full" },
            imageID: { type: "number" },
            imageURL: { type: "string", default: banner.fallback_image },
            themeImage: {type: "string"}
        },
        edit: EditComponent,
        save: SaveComponent
    }
)

function EditComponent(props) {
    useEffect(function () {
        if(props.attributes.themeImage){
            props.setAttributes({imageURL: `${slide.theme_image_path}${props.attributes.themeImage}`})
        }
    }, [])

    useEffect(
        function () {
            if (props.attributes.imageID) {
                async function go() {
                    const response = await apiFetch({
                        path: `/wp/v2/media/${props.attributes.imageID}`,
                        method: "GET"
                    })
                    props.setAttributes({ themeImage: "", imageURL: response.media_details.sizes.page_banner.source_url })
                }
                go()
            }
        },
        [props.attributes.imageID]
    )

    function onFileSelect(image) {
        props.setAttributes({ imageID: image.id })
    }

    return (
        <>
            <InspectorControls>
                <PanelBody title="Background" initialOpen={true}>
                    <PanelRow>
                        <MediaUploadCheck>
                            <MediaUpload
                                onSelect={onFileSelect}
                                value={props.attributes.imageID}
                                render={({ open }) => {
                                    return <Button onClick={open}>Choose Image</Button>
                                }} />
                        </MediaUploadCheck>
                    </PanelRow>
                </PanelBody>
            </InspectorControls>
            <div className="hero-slider__slide" style={{ backgroundImage: `url('${props.attributes.imageURL}')` }}>
                <div className="hero-slider__interior container">
                    <div className="hero-slider__overlay t-center">
                        <InnerBlocks allowedBlocks={["ourblocktheme/generic-heading", "ourblocktheme/generic-button"]} />
                    </div>
                </div>
            </div>
        </>
    )
}

function SaveComponent() {
    return <InnerBlocks.Content />
}