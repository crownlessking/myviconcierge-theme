<?php

/** CSS class to apply when a restaurant feature is NOT available. */
function grey_out_class($val) {
  return $val ? '' : 'class="themed-profile-unavailable"';
}

/** CSS class to apply when a restaurant feature is available.  */
function yes_class($val) {
  return $val ? 'class="themed-profile-yes"' : '';
}

/** Converts internal identifier to human readable */
function human_readable($identifier) {
  $identifier = str_replace(['-', '_'], ' ', esc_html($identifier));
  return ucwords($identifier);
}

/**
 * Converts to a shorter time format.
 * 
 * e.g "22:00" will ouput "10pm"
 * If the time is on the hour, the minutes will be omitted.
 */
function short_time_format($time) {
  $date = DateTime::createFromFormat('H:i', $time);
  if (!$date) {
    return $time; // Return original if parsing fails
  }
  return $date->format($date->format('i') == '00' ? 'ga' : 'g:ia');
}

/**
 * Applies a class based on the restaurant meal type.
 * 
 * e.g. breakfast, brunch, or dinner
 */
function themed_meal($meal) {
  $class = '';
  switch (strtolower($meal)) {
    case 'breakfast':
      $class = 'class="meal themed-meal-breakfast"';
      break;
    case 'brunch':
      $class = 'class="meal themed-meal-brunch"';
      break;
    case 'dinner':
      $class = 'class="meal themed-meal-dinner"';
      break;
    default:
      $class = 'class="meal themed-meal-default"';
      break;
  }
  return "<span $class>" . esc_html($meal) . "</span>";
}

/** Shorten the day. */
function short_day($day) {
  $days = [
    'monday' => 'Mon',
    'tuesday' => 'Tue',
    'wednesday' => 'Wed',
    'thursday' => 'Thu',
    'friday' => 'Fri',
    'saturday' => 'Sat',
    'sunday' => 'Sun'
  ];

  $day = strtolower($day);
  return isset($days[$day]) ? $days[$day] : ucfirst($day);
}

/**
 * Fills-in missing days and indicates them as "Close".
 * 
 * e.g.
 * $hour = [ 'day' => '', 'open' => '', 'close' => '', 'meal' => ''];
 * 
 * Set the missing day as "Close" by setting 'open' and 'close' as empty string.
 */
function fill_missing_days($hours) {
  if (!is_array($hours)) {
    return array();
  }

  $all_days = [
    'sunday' => array(),
    'monday' => array(),
    'tuesday' => array(),
    'wednesday' => array(),
    'thursday' => array(),
    'friday' => array(),
    'saturday' => array(),
  ];

  foreach ($hours as $hour) {
    $all_days[strtolower($hour['day'])][] = $hour;
  }

  foreach ($all_days as $day => $day_hours) {
    if (empty($day_hours)) {
      $filled_hours[] = ['day' => $day, 'open' => '', 'close' => '', 'meal' => 'Close'];
    } else {
      foreach ($day_hours as $hour) {
        $filled_hours[] = $hour;
      }
    }
  }

  return $filled_hours;
}

/**
 * Get custom post map icon.
 */
function map_icon() {
  $icon_url = get_post_meta(get_the_ID(), '_mvic_icon_url', true);

  return '<img src="' . esc_url($icon_url) . '" alt="Map icon" />';
}