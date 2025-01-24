        <?php

        // BUSINESS HOURS -----------------------------------------------
        $show_business_hours = get_post_meta(get_the_ID(), '_restaurant_show_bh_meta_key', true);
        if ($show_business_hours) :
        ?>
          <?php
          $business_hours = fill_missing_days(
            get_post_meta(get_the_ID(), '_restaurant_business_hours_meta_key', true)
          );

          // Pass business hours to JavaScript
          wp_localize_script('main', 'businessHours', $business_hours);

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
        <?php endif; ?>