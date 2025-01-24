      <?php

      // RESTAURANT FEATURES -----------------------------------------------
      $show_features = get_post_meta(get_the_ID(), '_restaurant_show_features_meta_key', true);
      if ($show_features) :
      ?>
        <?php
        $show_features = get_post_meta(get_the_ID(), '_restaurant_show_features_meta_key', true);
        $takesReservations = get_post_meta(get_the_ID(), '_restaurant_takes_reservations_meta_key', true);
        $delivers = get_post_meta(get_the_ID(), '_restaurant_delivers_meta_key', true);
        $takeOut = get_post_meta(get_the_ID(), '_restaurant_take_out_meta_key', true);
        $acceptsCreditCards = get_post_meta(get_the_ID(), '_restaurant_accepts_credit_cards_meta_key', true);
        $acceptsMastercard = get_post_meta(get_the_ID(), '_restaurant_accepts_mastercard_meta_key', true);
        $acceptsVisa = get_post_meta(get_the_ID(), '_restaurant_accepts_visa_meta_key', true);
        $acceptsDiscover = get_post_meta(get_the_ID(), '_restaurant_accepts_discover_meta_key', true);
        $acceptsAmex = get_post_meta(get_the_ID(), '_restaurant_accepts_amex_meta_key', true); // American Express
        $privateParkingLot = get_post_meta(get_the_ID(), '_restaurant_private_parking_lot_meta_key', true);
        $wheelchairAccessible = get_post_meta(get_the_ID(), '_restaurant_wheelchair_accessible_meta_key', true);
        $kidsFriendly = get_post_meta(get_the_ID(), '_restaurant_kids_friendly_meta_key', true);
        $groupFriendly = get_post_meta(get_the_ID(), '_restaurant_group_friendly_meta_key', true);
        $outdoorSeats = get_post_meta(get_the_ID(), '_restaurant_outdoor_seats_meta_key', true);
        $hasWifi = get_post_meta(get_the_ID(), '_restaurant_has_wifi_meta_key', true);
        $hasTv = get_post_meta(get_the_ID(), '_restaurant_has_tv_meta_key', true);
        $waiterService = get_post_meta(get_the_ID(), '_restaurant_waiter_service_meta_key', true);
        $hasRestrooms = get_post_meta(get_the_ID(), '_restaurant_has_restrooms_meta_key', true);
        ?>

        <h3 class="profile-title">Restaurant Features</h3>
        <ul>
          <li <?= grey_out_class($takesReservations); ?>>
            <i class="fa-solid fa-envelope"></i> Takes reservations: <span <?= yes_class($takesReservations); ?>><?= $takesReservations ? 'Yes' : 'No'; ?></span>
          </li>
          <li <?= grey_out_class($delivers); ?>>
            <i class="fa-solid fa-truck"></i> Delivers: <span <?= yes_class($delivers); ?>"><?= $delivers ? 'Yes' : 'No'; ?></span>
          </li>
          <li <?= grey_out_class($takeOut); ?>>
            <i class="fa-solid fa-gift"></i> Can take out: <span <?= yes_class($takeOut); ?>><?= $takeOut ? 'Yes' : 'No'; ?></span>
          </li>
          <li <?= grey_out_class($acceptsCreditCards); ?>>
            <i class="fa-solid fa-credit-card"></i> Accepts credit cards: <span <?= yes_class($acceptsCreditCards); ?>><?= $acceptsCreditCards ? 'Yes' : 'No'; ?></span>
          </li>
          <li <?= grey_out_class($acceptsMastercard); ?>>
            <i class="fa-solid fa-credit-card"></i> Accepts Mastercard: <span <?= yes_class($acceptsMastercard); ?>><?= $acceptsMastercard ? 'Yes' : 'No'; ?></span>
          </li>
          <li <?= grey_out_class($acceptsVisa); ?>>
            <i class="fa-solid fa-credit-card"></i> Accepts Visa: <span <?= yes_class($acceptsVisa); ?>><?= $acceptsVisa ? 'Yes' : 'No'; ?></span>
          </li>
          <li <?= grey_out_class($acceptsDiscover); ?>>
            <i class="fa-solid fa-credit-card"></i> Accepts Discover: <span <?= yes_class($acceptsDiscover); ?>><?= $acceptsDiscover ? 'Yes' : 'No'; ?></span>
          </li>
          <li <?= grey_out_class($acceptsAmex); ?>>
            <i class="fa-solid fa-credit-card"></i> Accepts Amex: <span <?= yes_class($acceptsAmex); ?>><?= $acceptsAmex ? 'Yes' : 'No'; ?></span>
          </li>
          <li <?= grey_out_class($privateParkingLot); ?>>
            <i class="fa-solid fa-square-parking"></i> Private parking lot: <span <?= yes_class($privateParkingLot); ?>><?= $privateParkingLot ? 'Yes' : 'No'; ?></span>
          </li>
          <li <?= grey_out_class($wheelchairAccessible); ?>>
            <i class="fa-brands fa-accessible-icon"></i> Wheelchair accessible: <span <?= yes_class($wheelchairAccessible); ?>><?= $wheelchairAccessible ? 'Yes' : 'No'; ?></span>
          </li>
          <li <?= grey_out_class($kidsFriendly); ?>>
            <i class="fa-solid fa-child"></i> Kids friendly: <span <?= yes_class($kidsFriendly); ?>><?= $kidsFriendly ? 'Yes' : 'No'; ?></span>
          </li>
          <li <?= grey_out_class($groupFriendly); ?>>
            <i class="fa-solid fa-people-group"></i> Group friendly: <span <?= yes_class($groupFriendly); ?>><?= $groupFriendly ? 'Yes' : 'No'; ?></span>
          </li>
          <li <?= grey_out_class($outdoorSeats); ?>>
            <i class="fa-solid fa-chair"></i> Outdoor seats: <span <?= yes_class($outdoorSeats); ?>><?= $outdoorSeats ? 'Yes' : 'No'; ?></span>
          </li>
          <li <?= grey_out_class($hasWifi); ?>>
            <i class="fa-solid fa-wifi"></i> Has WI-FI: <span <?= yes_class($hasWifi); ?>><?= $hasWifi ? 'Yes' : 'No'; ?></span>
          </li>
          <li <?= grey_out_class($hasTv); ?>>
            <i class="fa-solid fa-tv"></i> Has TV: <span <?= yes_class($hasTv); ?>><?= $hasTv ? 'Yes' : 'No'; ?></span>
          </li>
          <li <?= grey_out_class($waiterService); ?>>
            <i class="fa-solid fa-bell-concierge"></i> Waiter Service: <span <?= yes_class($waiterService); ?>><?= $waiterService ? 'Yes' : 'No'; ?></span>
          </li>
          <li <?= grey_out_class($hasRestrooms); ?>>
            <i class="fa-solid fa-restroom"></i> Has restrooms: <span <?= yes_class($hasRestrooms); ?>><?= $hasRestrooms ? 'Yes' : 'No'; ?></span>
          </li>
        </ul>
      <?php endif; ?>