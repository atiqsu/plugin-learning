<?php
/**
 * Plugin Name: My React Plugin
 * Description: React-based WordPress plugin with tabs and backend database.
 * Version: 1.0
 * Author: Shahel Alam
 */

if (!defined('ABSPATH')) exit;

// === Backend Core Logic ===
define('MY_REACT_PLUGIN_PATH', plugin_dir_path(__FILE__));
define('MY_REACT_PLUGIN_FILE', __FILE__);

spl_autoload_register(function ($class) {
  $prefix = 'MyReactPlugin\\';
  $base_dir = __DIR__ . '/includes/';

  $len = strlen($prefix);
  if (strncmp($prefix, $class, $len) !== 0) return;

  $relative_class = substr($class, $len);
  $file = $base_dir . str_replace('\\', '/', $relative_class) . '.php';

  if (file_exists($file)) {
    require $file;
  }
});

use MyReactPlugin\Core\PluginInit;
PluginInit::register();

// === React Admin Menu ===
add_action('admin_menu', function () {
  add_menu_page(
    'React Dashboard',
    'React Plugin',
    'manage_options',
    'react-dashboard',
    'render_react_dashboard',
    'dashicons-admin-generic',
    20
  );
});

function render_react_dashboard() {
  echo '<div id="react-dashboard"></div>';
}

// === Script Enqueue for Admin ===
add_action('admin_enqueue_scripts', function ($hook) {
  if ($hook !== 'toplevel_page_react-dashboard') return;

  $plugin_url = plugin_dir_url(__FILE__);

  wp_enqueue_script('my-react-plugin-js', $plugin_url . 'build/bundle.js', [], null, true);
  wp_enqueue_style('my-react-plugin-css', $plugin_url . 'build/styles.css');

  wp_localize_script('my-react-plugin-js', 'myPluginData', [
    'rest_url' => esc_url_raw(rest_url()),
    'nonce' => wp_create_nonce('wp_rest')
  ]);
});

// === Frontend Shortcode React Loader ===
add_action('wp_enqueue_scripts', 'enqueue_react_frontend_assets');
function enqueue_react_frontend_assets() {
  if (is_singular() && has_shortcode(get_post()->post_content, 'react_user_form')) {
    $plugin_url = plugin_dir_url(__FILE__);

    wp_enqueue_style('my-react-style', $plugin_url . 'build/styles.css', [], filemtime(plugin_dir_path(__FILE__) . 'build/styles.css'));
    wp_enqueue_script('my-react-script', $plugin_url . 'build/bundle.js', [], filemtime(plugin_dir_path(__FILE__) . 'build/bundle.js'), true);

    wp_localize_script('my-react-script', 'swiss_ajax', [
      'ajax_url' => admin_url('admin-ajax.php'),
      'nonce' => wp_create_nonce('form_data_nonce'),
    ]);
  }
}

add_shortcode('react_user_form', 'render_react_user_form');
function render_react_user_form() {
  return '<div id="react-user-form"></div>';
}
