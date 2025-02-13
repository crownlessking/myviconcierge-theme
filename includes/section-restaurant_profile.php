<?php

// RESTAURANT PROFILE ------------------------------------------------
$show_profile = get_post_meta(get_the_ID(), '_restaurant_show_profile_meta_key', true);
if ($show_profile) :
  $restaurant_meta_keys = [
    'phone' => '_restaurant_phone_meta_key',
    'address' => '_restaurant_address_meta_key',
    'website' => '_restaurant_website_meta_key',
    'cuisine' => '_restaurant_cuisine_meta_key',
    'costLow' => '_restaurant_cost_low_meta_key',
    'costHigh' => '_restaurant_cost_high_meta_key',
    'ambience' => '_restaurant_ambience_meta_key',
    'suitableFor' => '_restaurant_suitable_for_meta_key',
    'attire' => '_restaurant_attire_meta_key',
    'noiseLevel' => '_restaurant_noise_level_meta_key',
    'alcohol' => '_restaurant_alcohol_meta_key',
  ];

  $restaurant_meta = [];
  foreach ($restaurant_meta_keys as $key => $meta_key) {
    $restaurant_meta[$key] = get_post_meta(get_the_ID(), $meta_key, true);
  }

?>
  <h3 class="profile-title">Restaurant profile</h3>
  <ul>
    <?php if (!empty($restaurant_meta['phone']) && strlen($restaurant_meta['phone']) >= 10) : ?>
      <li><i class="fa-solid fa-phone"></i> Phone: <span class="font-bold"><a href="tel:<?= esc_html($restaurant_meta['phone']); ?>"><?= esc_html($restaurant_meta['phone']); ?></a></span></li>
    <?php endif; ?>
    <?php if (!empty($restaurant_meta['address'])) : ?>
      <li class="r-address"><i class="fa-solid fa-location-dot"></i> Address: <span class="font-bold"><?= wpautop(esc_html($restaurant_meta['address'])); ?></span></li>
    <?php endif; ?>
    <?php if (!empty($restaurant_meta['website'])) : ?>
      <li><i class="fa-solid fa-earth-americas"></i> <a href="<?= esc_url($restaurant_meta['website']); ?>">Website</a></li>
    <?php endif; ?>
    <?php if (!empty($restaurant_meta['cuisine'])) : ?>
      <li><i class="fa-solid fa-utensils"></i> Cuisine: <span class="font-bold"><?= esc_html($restaurant_meta['cuisine']); ?></span></li>
    <?php endif; ?>
    <?php if (!empty($restaurant_meta['costLow']) && !empty($restaurant_meta['costHigh'])) : ?>
      <li><i class="fa-solid fa-money-bill"></i> Cost: <span class="themed-profile-cost">$<?= esc_html($restaurant_meta['costLow']); ?>-<?= esc_html($restaurant_meta['costHigh']); ?></span></li>
    <?php endif; ?>
    <?php if (!empty($restaurant_meta['ambience'])) : ?>
      <li><i class="fa-solid fa-people-roof"></i> Ambience: <span class="font-bold"><?= human_readable($restaurant_meta['ambience']); ?></span></li>
    <?php endif; ?>
    <?php if (!empty($restaurant_meta['suitableFor'])) : ?>
      <li><i class="fa-solid fa-user"></i> Suitable for: <span class="font-bold"><?= human_readable($restaurant_meta['suitableFor']); ?></span></li>
    <?php endif; ?>
    <?php if (!empty($restaurant_meta['attire'])) : ?>
      <li><i class="fa-solid fa-shirt"></i> Attire: <span class="font-bold"><?= human_readable($restaurant_meta['attire']); ?></span></li>
    <?php endif; ?>
    <?php if (!empty($restaurant_meta['noiseLevel'])) : ?>
      <li><i class="fa-solid fa-volume-low"></i> Noise level: <span class="font-bold"><?= human_readable($restaurant_meta['noiseLevel']); ?></span></li>
    <?php endif; ?>
    <?php if (!empty($restaurant_meta['alcohol'])) : ?>
      <li><i class="fa-solid fa-wine-glass"></i> Alcohol: <span class="font-bold"><?= human_readable($restaurant_meta['alcohol']); ?></span></li>
    <?php endif; ?>
  </ul>
<?php endif; ?>