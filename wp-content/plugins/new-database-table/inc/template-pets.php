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

  <p>This page took <strong><?php echo timer_stop(); ?></strong> seconds to prepare. Found <strong><?php echo $pet->get_count() ?></strong> results (showing the first <?php echo count($pet->get_pets()); ?>).</p>

  <?php
  if (current_user_can("administrator")) { ?>
    <form action="<?php echo esc_url(admin_url("admin-post.php")) ?>" class="create-pet-form" method="POST">
      <p>
        Enter just name for a new pet. Its species, weight, and other details will be randomly generated.
      </p>
      <!-- will use as action name in BE -->
      <input type="hidden" name="action" value="create_pet">
      <input type="text" name="incoming_pet_name" placeholder="name...">
      <button>
        Add Pet
      </button>
    </form>
  <?php
  }
  ?>

  <table class="pet-adoption-table">
    <tr>
      <th>Name</th>
      <th>Species</th>
      <th>Weight</th>
      <th>Birth Year</th>
      <th>Hobby</th>
      <th>Favorite Color</th>
      <th>Favorite Food</th>
      <?php
      if (current_user_can("administrator")) {
        echo "<th>Delete</th>";
      }
      ?>
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
        <?php
        if (current_user_can("administrator")) { ?>
          <td style="text-align: center;">
            <form action="<?php echo esc_url(admin_url("admin-post.php")) ?>" method="POST">
            <input type="hidden" name="action" value="delete_pet">
            <input type="hidden" name="id_to_delete" value="<?php echo $pet->id?>">
            <button class="delete-pet-button">X</button>
            </form>
          </td>
        <?php
        }
        ?>
      </tr>
    <?php
    }
    ?>
  </table>

</div>

<?php get_footer(); ?>