<?php

/*****************************************************************************
 * WORDPRESS THEME SETUP
 *****************************************************************************/

// AI said I needed this to ensure that WordPress properly generate the title for the webpage.
add_theme_support('title-tag');

function myvic_theme_setup() {
  register_nav_menus(array( 'primary' => __('Primary Menu', 'my_theme'), ));
}
add_action('after_setup_theme', 'myvic_theme_setup');

/** **************************************************************************
 * CSS IS IMPORTED IN THIS FUNCTION.
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

/** **************************************************************************
 * JAVASCRIPT IS IMPORTED IN THIS FUNCTION.
 *************************************************************************** */
function mvic_load_js() {
  // Enqueue jQuery from WordPress core
  wp_enqueue_script('jquery');

  wp_register_script('main',
    get_template_directory_uri() . '/js/main.js',
    'bootstrap',
    false,
    true
  );
  wp_enqueue_script('main');
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
    register_sidebar( array(
        'name'          => __( 'Primary Sidebar', 'myviconcierge-theme' ),
        'id'            => 'primary-sidebar',
        'description'   => __( 'Main sidebar that appears on the right.', 'myviconcierge-theme' ),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h2 class="widget-title">',
        'after_title'   => '</h2>',
    ) );
}
add_action( 'widgets_init', 'mvic_theme_widgets_init' );

/*****************************************************************************
 * THEME ADMIN MENU SETTING PAGE
 *****************************************************************************/

// Hook into the admin menu action
add_action('admin_menu', 'mvic_theme_settings_page');

function mvic_theme_settings_page() {
    // Add a new submenu under Appearance
    add_theme_page(
        'My VI Concierge Theme Settings',  // Page title
        'Theme Settings',         // Menu title
        'manage_options',         // Capability
        'mvic-theme-settings',  // Menu slug
        'mvic_theme_settings_callback' // Function to display page content
    );
}

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

function mvic_theme_settings_init() {
  // Register a new setting
  register_setting('mvic_theme_settings_group', 'background_image_urls'); 

  // Add a new section to the settings page
  add_settings_section(
      'mvic_theme_settings_section',  // Section ID
      'Theme Options',           // Section title
      'mvic_theme_settings_section_callback', // Callback function
      'mvic-theme-settings'           // Page slug
  );

  add_settings_field(
    'background_image_urls',
    'Background Image URLs',
    'mvic_background_image_urls_callback',
    'mvic-theme-settings',
    'mvic_theme_settings_section'
  );
}

function mvic_theme_settings_section_callback() {
  echo '<p>Customize your theme settings here.</p>';
}

function mvic_background_image_urls_callback() {
    $urls = get_option('background_image_urls', '');
    echo '<textarea name="background_image_urls" rows="10" cols="50" class="large-text">' . esc_textarea($urls) . '</textarea>';
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
