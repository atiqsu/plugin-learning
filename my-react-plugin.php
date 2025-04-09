<?php
/**
 * Plugin Name: My React Plugin
 * Description: React-based WordPress plugin with tabs.
 * Version: 1.0
 * Author: Shahel Alam
 */

if (!defined('ABSPATH')) exit;

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

add_action('admin_enqueue_scripts', function ($hook) {
  if ($hook !== 'toplevel_page_react-dashboard') return;

  $plugin_url = plugin_dir_url(__FILE__);

  wp_enqueue_script('my-react-plugin-js', $plugin_url . 'build/bundle.js', [], null, true);
  wp_enqueue_style('my-react-plugin-css', $plugin_url . 'build/styles.css');
});

add_action('wp_enqueue_scripts', 'enqueue_react_frontend_assets');
function enqueue_react_frontend_assets() {
    if (is_singular() && has_shortcode(get_post()->post_content, 'react_user_form')) {
        $plugin_url = plugin_dir_url(__FILE__);

        wp_enqueue_style(
            'my-react-style',
            $plugin_url . 'build/styles.css',
            [],
            filemtime(plugin_dir_path(__FILE__) . 'build/styles.css')
        );

        wp_enqueue_script(
            'my-react-script',
            $plugin_url . 'build/bundle.js',
            [],
            filemtime(plugin_dir_path(__FILE__) . 'build/bundle.js'),
            true
        );
    }
}

add_shortcode('react_user_form', 'render_react_user_form');
function render_react_user_form(){
  return '<div id="react-user-form"></div>';
}
