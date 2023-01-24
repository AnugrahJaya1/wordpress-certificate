import "./index.scss"
import { useSelect } from "@wordpress/data"
import { useState, useEffect } from "react"
import apiFetch from "@wordpress/api-fetch"

const __ = wp.i18n.__

wp.blocks.registerBlockType("ourplugin/featured-professor", {
  title: "Professor Callout",
  description: "Include a short description and link to a professor of your choice",
  icon: "welcome-learn-more",
  category: "common",
  attributes: {
    prof_id: { type: "string" }
  },
  edit: EditComponent,
  save: function () {
    return null
  }
})

function EditComponent(props) {
  const [the_preview, set_the_preview] = useState("");

  useEffect(() => {
    if (profs.attributes.prof_id) {
      update_the_meta()
      async function go() {
        const response = await apiFetch({
          path: `/featured-professor/v1/get-HTML?prof_id=${props.attributes.prof_id}`,
          method: "GET"
        })
        set_the_preview(response)
      }
      go()
    }
  }, [props.attributes.prof_id])

  useEffect(() => {
    return () => {
      update_the_meta()
    }
  }, [])

  function update_the_meta() {
    const prof_for_meta = wp.data.select("core/block-editor")
      .getBlocks()
      .filter(x => x.name == "ourplugin/featured-professor")
      .map(x => x.attributes.prof_id)
      .filter((value, index, arr) => {
        return arr.indexOf(value) == index
      })

    console.log(prof_for_meta)
    wp.data.dispatch("core/editor").editPost({
      meta: { featured_professor: prof_for_meta }
    })
  }

  const profs = useSelect(select => {
    return select("core").getEntityRecords("postType", "professor", { per_page: -1 })
  })

  if (profs == undefined) {
    return <p>Loading...</p>
  }

  return (
    <div className="featured-professor-wrapper">
      <div className="professor-select-container">
        <select onChange={e => props.setAttributes({ prof_id: e.target.value })}>
          <option value="">{__("Select a professor", "featured-professor")}</option>
          {profs.map(prof => {
            return (
              <option value={prof.id} selected={props.attributes.prof_id == prof.id}>
                {prof.title.rendered}
              </option>
            )
          })}
        </select>
      </div>
      <div dangerouslySetInnerHTML={{ __html: the_preview }}></div>
    </div>
  )
}