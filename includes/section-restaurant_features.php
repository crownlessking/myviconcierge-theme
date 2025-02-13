<?php

// RESTAURANT FEATURES -----------------------------------------------
$show_features = get_post_meta(get_the_ID(), '_restaurant_show_features_meta_key', true);
if ($show_features) :
  $features = [
    'takesReservations' => ['_restaurant_takes_reservations_meta_key', 'fa-solid fa-envelope', 'Takes reservations'],
    'delivers' => ['_restaurant_delivers_meta_key', 'fa-solid fa-truck', 'Delivers'],
    'takeOut' => ['_restaurant_take_out_meta_key', 'fa-solid fa-gift', 'Can take out'],
    'acceptsCreditCards' => ['_restaurant_accepts_credit_cards_meta_key', 'fa-solid fa-credit-card', 'Accepts credit cards'],
    'acceptsMastercard' => ['_restaurant_accepts_mastercard_meta_key', 'fa-solid fa-credit-card', 'Accepts Mastercard'],
    'acceptsVisa' => ['_restaurant_accepts_visa_meta_key', 'fa-solid fa-credit-card', 'Accepts Visa'],
    'acceptsDiscover' => ['_restaurant_accepts_discover_meta_key', 'fa-solid fa-credit-card', 'Accepts Discover'],
    'acceptsAmex' => ['_restaurant_accepts_amex_meta_key', 'fa-solid fa-credit-card', 'Accepts Amex'],
    'privateParkingLot' => ['_restaurant_private_parking_lot_meta_key', 'fa-solid fa-square-parking', 'Private parking lot'],
    'wheelchairAccessible' => ['_restaurant_wheelchair_accessible_meta_key', 'fa-brands fa-accessible-icon', 'Wheelchair accessible'],
    'kidsFriendly' => ['_restaurant_kids_friendly_meta_key', 'fa-solid fa-child', 'Kids friendly'],
    'groupFriendly' => ['_restaurant_group_friendly_meta_key', 'fa-solid fa-people-group', 'Group friendly'],
    'outdoorSeats' => ['_restaurant_outdoor_seats_meta_key', 'fa-solid fa-chair', 'Outdoor seats'],
    'hasWifi' => ['_restaurant_has_wifi_meta_key', 'fa-solid fa-wifi', 'Has WI-FI'],
    'hasTv' => ['_restaurant_has_tv_meta_key', 'fa-solid fa-tv', 'Has TV'],
    'waiterService' => ['_restaurant_waiter_service_meta_key', 'fa-solid fa-bell-concierge', 'Waiter Service'],
    'hasRestrooms' => ['_restaurant_has_restrooms_meta_key', 'fa-solid fa-restroom', 'Has restrooms'],
  ];

  foreach ($features as $key => $feature) {
    $$key = get_post_meta(get_the_ID(), $feature[0], true);
  }
  ?>

  <h3 class="profile-title">Restaurant Features</h3>
  <ul>
    <?php foreach ($features as $key => $feature) : ?>
      <li <?= grey_out_class($$key); ?>>
        <i class="<?= $feature[1]; ?>"></i> <?= $feature[2]; ?>: <span <?= yes_class($$key); ?>><?= $$key ? 'Yes' : 'No'; ?></span>
      </li>
    <?php endforeach; ?>
  </ul>
<?php endif; ?>
