<?php

require_once plugin_dir_path(__FILE__) . "pet.php";
$pet = new Pet();

get_header(); ?>

<div class="page-banner">
  <div class="page-banner__bg-image" style="background-image: url(<?php echo get_theme_file_uri('/images/ocean.jpg'); ?>);"></div>
  <div class="page-banner__content container container--narrow">
    <h1 class="page-banner__title">Pet Adoption</h1>
    <div class="page-banner__intro">
      <p>Providing forever homes one search at a time.</p>
    </div>
  </div>
</div>

<div class="container container--narrow page-section">

  <p>This page took <strong><?php echo timer_stop(); ?></strong> seconds to prepare. Found <strong>x</strong> results (showing the first x).</p>

  <table class="pet-adoption-table">
    <tr>
      <th>Name</th>
      <th>Species</th>
      <th>Weight</th>
      <th>Birth Year</th>
      <th>Hobby</th>
      <th>Favorite Color</th>
      <th>Favorite Food</th>
    </tr>
    <?php
    foreach ($pet->get_pets() as $pet) { ?>
      <tr>
        <td><?php echo $pet->pet_name; ?></td>
        <td><?php echo $pet->species; ?></td>
        <td><?php echo $pet->pet_weight; ?></td>
        <td><?php echo $pet->birth_year; ?></td>
        <td><?php echo $pet->fav_hobby; ?></td>
        <td><?php echo $pet->fav_color; ?></td>
        <td><?php echo $pet->fav_food; ?></td>
      </tr>
    <?php
    }
    ?>
  </table>

</div>

<?php get_footer(); ?>