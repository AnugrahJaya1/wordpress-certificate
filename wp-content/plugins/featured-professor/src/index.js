import "./index.scss"
import { useSelect } from "@wordpress/data"

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
          <option value="">Select a professor</option>
          {profs.map(prof => {
            return (
              <option value={prof.id} selected={props.attributes.prof_id == prof.id}>
                {prof.title.rendered}
              </option>
            )
          })}
        </select>
      </div>
      <div>
        The HTML preview of the selected professor will appear here.
      </div>
    </div>
  )
}