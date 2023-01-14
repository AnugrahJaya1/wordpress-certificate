<?php

if (!is_user_logged_in()) {
    wp_redirect(esc_url(site_url("/")));
    exit;
}

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
        <div class="min-list link-list" id="my-notes">
            <?php
            $user_notes = new WP_Query([
                "post_type" => "note",
                "post_per_page" => -1,
                "author" => get_current_user_id(),
            ]);

            while ($user_notes->have_posts()) {
                $user_notes->the_post();
            ?>
                <li data-id="<?php the_ID()?>">
                    <input readonly type="text" class="note-title-field" value="<?php echo esc_attr(get_the_title()); ?>">
                    <span class="edit-note">
                        <i class="fa fa-pencil" aria-hidden="true"></i>
                        Edit
                    </span>
                    <span class="delete-note">
                        <i class="fa fa-trash-o" aria-hidden="true"></i>
                        Delete
                    </span>
                    <textarea readonly class="note-body-field"><?php echo esc_attr(wp_strip_all_tags(get_the_content())); ?></textarea>
                </li>
            <?php
            }
            ?>
        </div>
    </div>
<?php
}

get_footer();
