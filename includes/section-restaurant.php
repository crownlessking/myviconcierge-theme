<?php

require_once plugin_dir_path(__FILE__) . '../common/logic.php';

while ( have_posts() ) :
  the_post();
  ?>

  <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>><!-- relative prose -->
    <header class="relative">
      <?php the_title( '<h1 class="entry-title text-center text-4xl mt-5 mb-20 tracking-wide leading-tight border-b-2 pb-2 font-thin">', '</h1>' ); ?>
      <div class="absolute w-12 inset-0 top-[4rem] mx-auto text-center font-bold">
        <span id="bh-status"></span>
      </div>
    </header><!-- .entry-header -->

    <?php
    $show_profile = get_post_meta(get_the_ID(), '_restaurant_show_profile_meta_key', true);
    if ($show_profile) :
    ?>
      <aside class="profile">
        <?php

        // BUSINESS HOURS -----------------------------------------------
        $business_hours = fill_missing_days(
          get_post_meta(get_the_ID(), '_restaurant_business_hours_meta_key', true)
        );
        if (!empty($business_hours)) :
        ?>
          <h3 class="profile-title">Business Hours</h3>
          <ul>
            <?php foreach ($business_hours as $hours) : ?>
              <li>
                <span class="themed-weekday"><?= short_day($hours['day']); ?>:</span> 
                <?php if (!empty($hours['open']) && !empty($hours['close'])) : ?>
                  <span class="font-bold"><?= short_time_format($hours['open']); ?> - <?= short_time_format($hours['close']); ?></span>
                  <?= themed_meal($hours['meal']); ?>
                <?php else: ?>
                  <span class="themed-bh-close">Closed</span>
                <?php endif; ?>
              </li>
            <?php endforeach; ?>
          </ul>
        <?php endif; ?>
        <?php

        // RESTAURANT PROFILE ------------------------------------------------
        $phone = get_post_meta(get_the_ID(), '_restaurant_phone_meta_key', true);
        $website = get_post_meta(get_the_ID(), '_restaurant_website_meta_key', true);
        $cuisine = get_post_meta(get_the_ID(), '_restaurant_cuisine_meta_key', true);
        $costLow = get_post_meta(get_the_ID(), '_restaurant_cost_low_meta_key', true);
        $costHigh = get_post_meta(get_the_ID(), '_restaurant_cost_high_meta_key', true);
        $ambience = get_post_meta(get_the_ID(), '_restaurant_ambience_meta_key', true);
        $suitableFor = get_post_meta(get_the_ID(), '_restaurant_suitable_for_meta_key', true);
        $attire = get_post_meta(get_the_ID(), '_restaurant_attire_meta_key', true);
        $noiseLevel = get_post_meta(get_the_ID(), '_restaurant_noise_level_meta_key', true);
        $alcohol = get_post_meta(get_the_ID(), '_restaurant_alcohol_meta_key', true);

        // RESTAURANT FEATURES -----------------------------------------------
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
        <h3 class="profile-title">Restaurant Profile</h3>
        <ul>
          <li><i class="fa-solid fa-phone"></i> Phone: <span class="font-bold"><a href="tel:<?= esc_html($phone); ?>"><?= esc_html($phone); ?></a></span></li>
          <li><i class="fa-solid fa-earth-americas"></i> <a href="<?= esc_url($website); ?>">Website</a></li>
          <li><i class="fa-solid fa-utensils"></i> Cuisine: <span class="font-bold"><?= esc_html($cuisine); ?></span></li>
          <li><i class="fa-solid fa-money-bill"></i> Cost: <span class="themed-profile-cost">$<?= esc_html($costLow); ?>-<?= esc_html($costHigh); ?></span></li>
          <li><i class="fa-solid fa-people-roof"></i> Ambience: <span class="font-bold"><?= human_readable($ambience); ?></span></li>
          <li><i class="fa-solid fa-user"></i> Suitable for: <span class="font-bold"><?= human_readable($suitableFor); ?></span></li>
          <li><i class="fa-solid fa-shirt"></i> Attire: <span class="font-bold"><?= human_readable($attire); ?></span></li>
          <li><i class="fa-solid fa-volume-low"></i> Noise level: <span class="font-bold"><?= human_readable($noiseLevel); ?></span></li>
          <li><i class="fa-solid fa-wine-glass"></i> Alcohol: <span class="font-bold"><?= human_readable($alcohol); ?></span></li>
        </ul>
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
        <?php if ( is_active_sidebar( 'primary-sidebar' ) ) : ?>
          <?php dynamic_sidebar( 'primary-sidebar' ); ?>
        <?php endif; ?>
      </aside><!-- .entry-sidebar -->
    <?php endif; ?>

    <?php the_content(); ?><!-- .entry-content -->

    <footer class="entry-footer">
      <?php edit_post_link( __( 'Edit', 'textdomain' ), '<span class="edit-link">', '</span>' ); ?>
    </footer><!-- .entry-footer -->

  </article><!-- #post-<?php the_ID(); ?> -->

  <?php
  // If comments are open or we have at least one comment, load up the comment template.
  if ( comments_open() || get_comments_number() ) :
      comments_template();
  endif;

endwhile; // End of the loop.
?>