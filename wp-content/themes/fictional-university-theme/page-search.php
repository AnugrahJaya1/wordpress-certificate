<?php

get_header();
// this file use for single page

// get all post
while (have_posts()) {
    // get post
    the_post(); // keep track what post we use
    page_banner();
?>
    <!-- HTML mode -->
    <div class="container container--narrow page-section">
        <?php
        $id = get_the_ID(); // get id of current page
        $parent_id = wp_get_post_parent_id($id); // get id of parent page

        // show breadcrumbs if at child pages
        if ($parent_id) {
        ?>
            <div class="metabox metabox--position-up metabox--with-home-link">
                <p>
                    <a class="metabox__blog-home-link" href="<?php echo get_permalink($parent_id) ?>">
                        <i class="fa fa-home" aria-hidden="true"></i>
                        Back to
                        <?php
                        // parent title
                        echo get_the_title($parent_id);
                        ?>
                    </a>
                    <span class="metabox__main">
                        <?php
                        // print current page
                        the_title();
                        ?>
                    </span>
                </p>
            </div>

        <?php } ?>

        <?php
        $child_of_page = get_pages([
            'child_of' => get_the_ID()
        ]);
        // show only if have parent or in parent page
        if ($parent_id || $child_of_page) {
        ?>
            <div class="page-links">
                <h2 class="page-links__title">
                    <a href="<?php echo get_permalink($parent_id); ?>">
                        <?php echo get_the_title($parent_id) ?>
                    </a>
                </h2>
                <ul class="min-list">
                    <?php
                    if ($parent_id) {
                        $find_children_of = $parent_id;
                    } else {
                        $find_children_of = get_the_ID(); //get current page id
                    }

                    // get all list of pages
                    wp_list_pages(
                        // add arguments to show related pages
                        [
                            "title_li" => NULL, // hide pages title
                            "child_of" => $find_children_of,
                            "sort_column" => "menu_order"
                        ]
                    );
                    ?>
                </ul>
            </div>
        <?php } ?>

        <div class="generic-content">
            <?php
            // load search form
            get_search_form();
            ?>
        </div>
    </div>
<?php
}

get_footer();
