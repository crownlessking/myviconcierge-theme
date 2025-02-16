<?php

// LOCATION MAP ICON --------------------------------------------------
$show_map = get_post_meta(get_the_ID(), '_mvic_show_map', true);
$icon_url = get_post_meta(get_the_ID(), '_mvic_icon_url', true);
$latitude  = get_post_meta($post->ID, '_mvic_latitude', true);
$longitude = get_post_meta($post->ID, '_mvic_longitude', true);
$location = get_post_meta($post->ID, '_mvic_location', true);

wp_localize_script('main', 'mapData', array(
  'showMap' => $show_map,
  'iconUrl' => $icon_url,
  'latitude' => $latitude,
  'longitude' => $longitude,
  'location' => $location
));

if ($show_map && !empty($icon_url)) :
?>
  <div class="w-full flex justify-center">
    <span class="leading-loose font-bold uppercase">Map icon:</span> <img src="<?= esc_url($icon_url) ?>" alt="Map icon" />
  </div>
<?php endif; ?>