import { InnerBlocks, InspectorControls, MediaUpload, MediaUploadCheck } from "@wordpress/block-editor"
import { registerBlockType } from "@wordpress/blocks"
import { Button, PanelBody, PanelRow } from "@wordpress/components"

registerBlockType(
    "ourblocktheme/banner",
    {
        title: "Banner",
        supports: {
            align: ["full"]
        },
        attributes: {
            align: { type: "string", default: "full" }
        },
        edit: EditComponent,
        save: SaveComponent
    }
)

function EditComponent() {
    const useMeLater = (
        <>
            <h1 className="headline headline--large">Welcome!</h1>
            <h2 className="headline headline--medium">We think you&rsquo;ll like it here.</h2>
            <h3 className="headline headline--small">Why don&rsquo;t you check out the <strong>major</strong> you&rsquo;re interested in?</h3>
            <a href="#" className="btn btn--large btn--blue">Find Your Major</a>
        </>
    )

    function onFileSelect(x){
        console.log(x)
    }

    return (
        <>
            <InspectorControls>
                <PanelBody title="Background" initialOpen={true}>
                    <PanelRow>
                        <MediaUploadCheck>
                            <MediaUpload onSelect={onFileSelect} value={1} render={({ open }) => {
                                return <Button onClick={open}>Choose Image</Button>
                            }} />
                        </MediaUploadCheck>
                    </PanelRow>
                </PanelBody>
            </InspectorControls>
            <div className="page-banner">
                <div className="page-banner__bg-image" style={{ backgroundImage: "url('/wp-content/themes/fictional-block-theme/images/library-hero.jpg')" }}></div>
                <div className="page-banner__content container t-center c-white">
                    <InnerBlocks allowedBlocks={["ourblocktheme/generic-heading", "ourblocktheme/generic-button"]} />
                </div>
            </div >
        </>
    )
}

function SaveComponent() {
    return <InnerBlocks.Content />
}