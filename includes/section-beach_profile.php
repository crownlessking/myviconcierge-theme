<?php

// BEACH PROFILE ------------------------------------------------
$show_profile = get_post_meta(get_the_ID(), '_beach_show_profile_meta_key', true);
if ($show_profile) :
  $beach_meta_keys = [
    'phone' => '_beach_phone_meta_key',
    'address' => '_beach_address_meta_key',
    'website' => '_beach_website_meta_key',
  ];

  $beach_meta = [];
  foreach ($beach_meta_keys as $key => $meta_key) {
    $beach_meta[$key] = get_post_meta(get_the_ID(), $meta_key, true);
  }

?>
  <h3 class="profile-title">Beach profile</h3>
  <ul>
    <?php if (!empty($beach_meta['phone'])) : ?>
      <li><i class="fa-solid fa-phone"></i> Phone: <span class="font-bold"><a href="tel:<?= esc_html($beach_meta['phone']); ?>"><?= esc_html($beach_meta['phone']); ?></a></span></li>
    <?php endif; ?>
    <?php if (!empty($beach_meta['address'])) : ?>
      <li class="r-address"><i class="fa-solid fa-location-dot"></i> Address: <span class="font-bold"><?= wpautop(esc_html($beach_meta['address'])); ?></span></li>
    <?php endif; ?>
    <?php if (!empty($beach_meta['website'])) : ?>
      <li><i class="fa-solid fa-earth-americas"></i> <a href="<?= esc_url($beach_meta['website']); ?>">Website</a></li>
    <?php endif; ?>
  </ul>
<?php endif; ?>