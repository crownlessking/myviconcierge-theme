      <?php

      // RESTAURANT PROFILE ------------------------------------------------
      $show_profile = get_post_meta(get_the_ID(), '_restaurant_show_profile_meta_key', true);
      if ($show_profile) :
      ?>
        <?php
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
        ?>
        <h3 class="profile-title">Restaurant Profile</h3>
        <ul>
          <?php if (!empty($phone)) : ?>
            <li><i class="fa-solid fa-phone"></i> Phone: <span class="font-bold"><a href="tel:<?= esc_html($phone); ?>"><?= esc_html($phone); ?></a></span></li>
          <?php endif; ?>
          <?php if (!empty($website)) : ?>
            <li><i class="fa-solid fa-earth-americas"></i> <a href="<?= esc_url($website); ?>">Website</a></li>
          <?php endif; ?>
          <?php if (!empty($cuisine)) : ?>
            <li><i class="fa-solid fa-utensils"></i> Cuisine: <span class="font-bold"><?= esc_html($cuisine); ?></span></li>
          <?php endif; ?>
          <?php if (!empty($costLow) && !empty($costHigh)) : ?>
            <li><i class="fa-solid fa-money-bill"></i> Cost: <span class="themed-profile-cost">$<?= esc_html($costLow); ?>-<?= esc_html($costHigh); ?></span></li>
          <?php endif; ?>
          <?php if (!empty($ambience)) : ?>
            <li><i class="fa-solid fa-people-roof"></i> Ambience: <span class="font-bold"><?= human_readable($ambience); ?></span></li>
          <?php endif; ?>
          <?php if (!empty($suitableFor)) : ?>
            <li><i class="fa-solid fa-user"></i> Suitable for: <span class="font-bold"><?= human_readable($suitableFor); ?></span></li>
          <?php endif; ?>
          <?php if (!empty($attire)) : ?>
            <li><i class="fa-solid fa-shirt"></i> Attire: <span class="font-bold"><?= human_readable($attire); ?></span></li>
          <?php endif; ?>
          <?php if (!empty($noiseLevel)) : ?>
            <li><i class="fa-solid fa-volume-low"></i> Noise level: <span class="font-bold"><?= human_readable($noiseLevel); ?></span></li>
          <?php endif; ?>
          <?php if (!empty($alcohol)) : ?>
            <li><i class="fa-solid fa-wine-glass"></i> Alcohol: <span class="font-bold"><?= human_readable($alcohol); ?></span></li>
          <?php endif; ?>
        </ul>
      <?php endif; ?>