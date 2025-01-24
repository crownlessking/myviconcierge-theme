        <?php

        // LOCATION MAP ICON --------------------------------------------------
        $icon_url = get_post_meta(get_the_ID(), '_mvic_icon_url', true);
        if (!empty($icon_url)) :
        ?>
          <div class="w-full flex justify-center">
            <img src="<?= esc_url($icon_url) ?>" alt="Map icon" />
          </div>
        <?php endif; ?>