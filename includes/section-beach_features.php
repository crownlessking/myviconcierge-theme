<?php

// BEACH FEATURES -----------------------------------------------
$show_features = get_post_meta(get_the_ID(), '_beach_show_features_meta_key', true);
if ($show_features) :
  $features = [
    // 'hasRestrooms' => ['_restaurant_has_restrooms_meta_key', 'fa-restroom', 'Has restrooms'],
    'swimSnorkel' => ['swim_snorkel', 'fa-solid fa-swimmer', 'Swim/Snorkel'],
    'rentChair' => ['rent_chair', 'fa-solid fa-chair', 'Rent a chair'],
    'rentUmbrella' => ['rent_umbrella', 'fa-solid fa-umbrella-beach', 'Rent an umbrella'],
    'buyFood' => ['buy_food', 'fa-solid fa-hamburger', 'Buy food'],
    'restroomAvailable' => ['restroom_available', 'fa-solid fa-restroom', 'Restroom available'],
    'accommodations' => ['accommodations', 'fa-solid fa-bed', 'Accommodations'],
    'taxiAvailable' => ['taxi_available', 'fa-solid fa-taxi', 'Taxi available'],
    'parkingLot' => ['parking_lot', 'fa-solid fa-parking', 'Parking lot'],
    'entranceFee' => ['entrance_fee', 'fa-solid fa-money-bill-wave', 'Entrance fee']
  ];

  foreach ($features as $key => $feature) {
    $$key = get_post_meta(get_the_ID(), "_beach_{$feature[0]}_meta_key", true);
  }
  ?>

  <h3 class="profile-title">Beach features</h3>
  <ul>
    <?php foreach ($features as $key => $feature) : ?>
      <li <?= grey_out_class($$key); ?>>
        <i class="<?= $feature[1]; ?>"></i> <?= $feature[2]; ?>: <span <?= yes_class($$key); ?>><?= $$key ? 'Yes' : 'No'; ?></span>
      </li>
    <?php endforeach; ?>
  </ul>
<?php endif; ?>
