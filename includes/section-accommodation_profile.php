<?php

// ACCOMMODATION PROFILE ------------------------------------------------
$show_profile = get_post_meta(get_the_ID(), '_accommodation_show_profile_meta_key', true);
if ($show_profile) :
  $accommodation_meta_keys = [
    'type' => '_accommodation_type_meta_key',
    'phone' => '_accommodation_phone_meta_key',
    'website' => '_accommodation_website_meta_key',
    'address' => '_accommodation_address_meta_key',
    'ambience' => '_accommodation_ambience_meta_key',
    'room_total' => '_accommodation_room_total_meta_key'
  ];

  $ambience_icon = [
    'beach' => 'fa-solid fa-person-swimming',
    'town_view' => 'fa-solid fa-tree-city',
    'town' => 'fa-solid fa-building'
  ];

  $a_read = [ // Human readable ambience.
    'beach' => 'Beach',
    'town_view' => 'Town view',
    'town' => 'Town'
  ];

  $title = [
    'hotel' => 'Hotel',
    'resort' => 'Resort',
    'ownership' => 'Timeshare'
  ];

  $accommodation_meta = [];
  foreach ($accommodation_meta_keys as $key => $meta_key) {
    $$key = get_post_meta(get_the_ID(), $meta_key, true);
  }
?>
  <h3 class="profile-title"><?= $title[$type]; ?> profile</h3>
  <ul>
    <?php if (!empty($type)) : ?>
      <li><i class="fa-solid fa-hotel"></i> Type: <span class="font-bold"><?= $title[$type]; ?></span></li>
    <?php endif; ?>
    <?php if (!empty($phone)) : ?>
      <li><i class="fa-solid fa-phone"></i> Phone: <span class="font-bold"><a href="tel:<?= esc_html($phone); ?>"><?= esc_html($phone); ?></a></span></li>
    <?php endif; ?>
    <?php if (!empty($address)) : ?>
      <li class="r-address"><i class="fa-solid fa-location-dot"></i> Address: <span class="font-bold"><?= wpautop(esc_html($address)); ?></span></li>
    <?php endif; ?>
    <?php if (!empty($website)) : ?>
      <li><i class="fa-solid fa-earth-americas"></i> <a href="<?= esc_url($website); ?>">Website</a></li>
    <?php endif; ?>
    <?php if (!empty($ambience)) : ?>
      <li><i class="<?= $ambience_icon[$ambience]; ?>"></i> Ambience: <span class="font-bold"><?= $a_read[$ambience]; ?></span></li>
    <?php endif; ?>
    <?php if (!empty($room_total)) : ?>
      <li><i class="fa-solid fa-house-user"></i> Room total: <span class="font-bold"><?= esc_html($room_total); ?></span></li>
    <?php endif; ?>
  </ul>
<?php endif; ?>