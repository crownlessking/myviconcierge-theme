<?php

require_once plugin_dir_path(__FILE__) . '/common/logic.php';
require_once get_template_directory() . '/lib/class-wp-bootstrap-navwalker.php';

/*****************************************************************************
 * WORDPRESS THEME SETUP
 *****************************************************************************/

if (function_exists('add_theme_support')) {
  add_theme_support('title-tag'); // Needed to properly generate the title for the webpage.
  add_theme_support('post-thumbnails');
}

function myvic_theme_setup() {
  register_nav_menus(array(
    'primary' => __('Primary Menu', 'myviconcierge-theme'),
  ));
}
add_action('after_setup_theme', 'myvic_theme_setup');

function mvic_theme_exclude_current_page_link($items, $args) {
  // Get the current page URL
  $current_url = home_url(add_query_arg(array(), $_SERVER['REQUEST_URI']));

  foreach ($items as $key => $item) {
    // Check if the current menu item URL matches the current page URL
    if ($item->url == $current_url) {
      // Remove the current page link
      unset($items[$key]);
    }
  }

  return $items;
}
add_filter('wp_nav_menu_objects', 'mvic_theme_exclude_current_page_link', 10, 2);

function mvic_theme_customize_nav_menu_items($items, $args) {
  // Check if we are on the front page
  if (is_front_page()) {
    // Specify the URLs of the links you want to exclude
    $excluded_urls = array(
      home_url('/virgin-islands-restaurants/'), // Replace with your actual URL
      home_url('/virgin-islands-beaches/'),     // Replace with your actual URL
      home_url('/virgin-islands-hotels-resorts/') // Replace with your actual URL
    );
    
    // Specify the URLs of the links you want to always include
    $included_urls = array(
      array(
        'title' => 'About',
        'url' => home_url('/about/'),    // Replace with your actual URL
      ),
      array(
        'title' => 'Contact',
        'url' => home_url('/contact/')      // Replace with your actual URL
      )
    );

    foreach ($items as $key => $item) {
      // Check if the current menu item URL is in the excluded URLs array
      if (in_array($item->url, $excluded_urls)) {
        // Remove the link
        unset($items[$key]);
      }
    }

    // Add the always included links
    foreach ($included_urls as $included_url) {
      $items[] = (object) array(
        'title' => $included_url['title'], // Replace with the link title
        'url' => $included_url['url']
      );
    }
  }
  return $items;
}
add_filter('wp_nav_menu_objects', 'mvic_theme_customize_nav_menu_items', 10, 2);

/** **************************************************************************
 * CSS IMPORTS
 *************************************************************************** */
function mvic_load_css() {

  // Google Font "Kanit"
  wp_enqueue_style('font-google-kanit',
    'https://fonts.googleapis.com/css2?family=Kanit:wght@400;700&display=swap'
  );

  // Google Font "Open Sans"
  wp_enqueue_style('font-google-open-sans',
    'https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;700&display=swap'
  );

  // Font Awesome CDN
  wp_enqueue_style('font-awesome',
    'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.1/css/all.min.css'
  );

  // Tailwind
  wp_enqueue_style('tailwind', get_template_directory_uri() . '/css/libs/tailwind/styles.css', array(), '1.0.0');

  // Main CSS
  wp_register_style('main',
    get_template_directory_uri() . '/css/main.css',
    array(),
    false,
    'all'
  );
  wp_enqueue_style('main');
}
add_action('wp_enqueue_scripts', 'mvic_load_css');

/* ****************************************************************************
 * JAVASCRIPT IMPORTS
 *****************************************************************************/

function mvic_load_js() {

  // Enqueue Google Maps API
  if (is_singular(array('restaurant', 'beach', 'accommodation'))) {
    add_action('wp_head', function() {
      ?>
      <script async defer src="https://maps.googleapis.com/maps/api/js?key=<?= esc_attr(get_option('google_maps_api_key', '')) ?>"></script>
      <?php
    });
  }

  // Enqueue jQuery from WordPress core
  wp_enqueue_script('jquery');

  // Enqueue main javaScript file
  wp_register_script('main',
    get_template_directory_uri() . '/js/main.js',
    'bootstrap',
    false,
    true
  );
  wp_enqueue_script('main');

  // Localize the script with business hours data
  if (is_single() && get_post_type() == 'restaurant') {
    $business_hours = fill_missing_days(
      get_post_meta(get_the_ID(), '_restaurant_business_hours_meta_key', true)
    );
    wp_localize_script('main', 'businessHours', $business_hours);
  }
}
add_action('wp_enqueue_scripts', 'mvic_load_js');

// Enables the use of custom logo.
function mvic_setup() {
  add_theme_support('custom-logo', array(
    'height'      => 100,
    'width'       => 400,
    'flex-height' => true,
    'flex-width'  => true,
  ));
}
add_action('after_setup_theme', 'mvic_setup');

function add_navbar_brand_class_to_custom_logo($html) {
  $html = str_replace('custom-logo-link', 'custom-logo-link navbar-brand', $html);
  return $html;
}
add_filter('get_custom_logo', 'add_navbar_brand_class_to_custom_logo');

function mvic_theme_widgets_init() {
  register_sidebar(array(
    'name'          => __( 'Primary Sidebar', 'myviconcierge-theme' ),
    'id'            => 'primary-sidebar',
    'description'   => __( 'Main sidebar that appears on the right.', 'myviconcierge-theme' ),
    'before_widget' => '<div id="%1$s" class="widget %2$s">',
    'after_widget'  => '</div>',
    'before_title'  => '<h2 class="widget-title">',
    'after_title'   => '</h2>',
  ));
}
add_action( 'widgets_init', 'mvic_theme_widgets_init' );

/*****************************************************************************
 * THEME ADMIN MENU SETTING PAGE - SETTING WEBSITE BACKGROUND IMAGE
 *****************************************************************************/

// Hook into the admin menu action
add_action('admin_menu', 'mvic_theme_settings_page');

/**
 * Add a new submenu under Appearance
 */
function mvic_theme_settings_page() {
  add_theme_page(
    'My VI Concierge Theme Settings',  // Page title
    'Theme Settings',         // Menu title
    'manage_options',         // Capability
    'mvic-theme-settings',  // Menu slug
    'mvic_theme_settings_callback' // Function to display page content
  );
}

/**
 * Function to dsplay page content.
 */
function mvic_theme_settings_callback() {
  ?>
    <div class="wrap">
      <h1>My VI Concierge Theme Settings</h1>
      <form method="post" action="options.php">
        <?php
        // Display settings fields
        settings_fields('mvic_theme_settings_group');
        do_settings_sections('mvic-theme-settings');
        submit_button();
        ?>
      </form>
    </div>
  <?php
}

// Hook into the admin_init action
add_action('admin_init', 'mvic_theme_settings_init');

/**
 * Function to hook into the admin_init action.
 */
function mvic_theme_settings_init() {
  // Register background image setting
  register_setting('mvic_theme_settings_group', 'background_image_urls');

  // Register setting for the Google Maps API key
  // The key will be stored in the WordPress options table and can be retrieved
  // using get_option('google_maps_api_key').
  register_setting('mvic_theme_settings_group', 'google_maps_api_key');

  // Add a section to the settings page
  add_settings_section(
    'mvic_theme_settings_section',  // Section ID
    'Theme Options',           // Section title
    'mvic_theme_settings_section_callback', // Callback function
    'mvic-theme-settings'           // Page slug
  );

  // Settings field for background image URLs.
  add_settings_field(
    'background_image_urls',
    'Background Image URLs',
    'mvic_background_image_urls_callback',
    'mvic-theme-settings',
    'mvic_theme_settings_section'
  );

  // Add settings field for the Google Maps API key
  add_settings_field(
    'google_maps_api_key',
    'Google Maps API Key',
    'mvic_theme_google_maps_api_key_callback',
    'mvic-theme-settings',
    'mvic_theme_settings_section'
  );
}

function mvic_theme_settings_section_callback() {
  echo '<p>Customize your theme settings here.</p>';
}

/** Callback function to render the textarea to input background image URLs. */
function mvic_background_image_urls_callback() {
    $urls = get_option('background_image_urls', '');
    echo '<textarea name="background_image_urls" rows="10" cols="50" class="large-text">' . esc_textarea($urls) . '</textarea>';
}

/** Callback function to render the Google Maps API key input field. */
function mvic_theme_google_maps_api_key_callback() {
  $api_key = get_option('google_maps_api_key', '');
  echo '<input type="text" name="google_maps_api_key" value="' . esc_attr($api_key) . '" class="regular-text">';
}

// Handle Ajax request
function mvic_get_random_background_image() {
    $urls = get_option('background_image_urls', '');
    $urls_array = array_filter(array_map('trim', explode("\n", $urls)));
    if (!empty($urls_array)) {
        $random_url = $urls_array[array_rand($urls_array)];
        echo esc_url($random_url);
    } else {
        echo ':('; // Ensure this is only output if no URLs are found
    }
    wp_die();
}
add_action('wp_ajax_mvic_get_random_background_image', 'mvic_get_random_background_image');
add_action('wp_ajax_nopriv_mvic_get_random_background_image', 'mvic_get_random_background_image');

/** Add custom class to `post_class()` output */
function add_custom_post_class($classes) {
    if (is_single()) {
        $classes[] = 'relative';
        $classes[] = 'prose';
    }
    return $classes;
}
add_filter('post_class', 'add_custom_post_class');
