<div class="post-item">
    <h2 class="headline headline--medium headline--post-title">
        <a href="<?php the_permalink(); ?>">
            <?php the_title(); ?>
        </a>
    </h2>

    <div class="generic-content">
        <?php
        the_excerpt(); // show some of content
        ?>
        <p>
            <a class="btn btn--blue" href="<?php the_permalink(); ?>">
                View Campus &raquo;
            </a>
        </p>
    </div>
</div>