<?php
get_header();
page_banner([
    "title" => "Our Campuses",
    "subtitle" => "We have several conveniently located campuses.",
]);
?>
<!-- content -->
<div class="container container--narrow page-section">
    <div class="acf-map">
        <?php
        while (have_posts()) {
            // get post
            the_post(); // keep track what post we use

            $map_location = get_field("map_location");
            $lat = empty($map_location["lat"]) ? "6.9039" : $map_location["lat"];
            $lng = empty($map_location["lng"]) ? "107.6491" : $map_location["lng"];
        ?>
            <div class="marker" data-lat="<?php echo $lat ?>" data-lng="<?php echo $lng ?>">

            </div>
        <?php
        }
        //  add pagination
        echo paginate_links();
        ?>
    </div>
</div>

<?php
get_footer();
?>