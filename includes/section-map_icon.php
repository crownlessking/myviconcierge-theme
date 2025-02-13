<?php

// LOCATION MAP ICON --------------------------------------------------
$show_map = get_post_meta(get_the_ID(), '_mvic_show_map', true);
$icon_url = get_post_meta(get_the_ID(), '_mvic_icon_url', true);
if ($show_map && !empty($icon_url)) :
?>
  <div class="w-full flex justify-center">
    <img src="<?= esc_url($icon_url) ?>" alt="Map icon" />
  </div>
<?php endif; ?>