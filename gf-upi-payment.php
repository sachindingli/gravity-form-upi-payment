<?php
/*
Plugin Name: Gravity Forms UPI Payment
Plugin URI:  http://yourwebsite.com
Description: A plugin to integrate UPI payments with Gravity Forms.
Version:     1.0
Author:      Your Name
Author URI:  http://yourwebsite.com
License:     GPL2
*/

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

// Include the main class
require_once plugin_dir_path(__FILE__) . 'includes/class-gf-upi-payment.php';

// Include admin settings
require_once plugin_dir_path(__FILE__) . 'includes/admin-settings.php';

function gf_upi_payment_init() {
    new GFUPIPayment();
}
add_action('gform_loaded', 'gf_upi_payment_init', 5);

function gf_upi_payment_admin_menu() {
    add_menu_page(
        'UPI Payment Settings', // Page title
        'UPI Payment', // Menu title
        'manage_options', // Capability
        'gf-upi-payment', // Menu slug
        'gf_upi_payment_settings_page', // Function to display page content
        'dashicons-admin-generic' // Icon URL
    );
}
add_action('admin_menu', 'gf_upi_payment_admin_menu');

function gf_upi_payment_enqueue_assets($hook_suffix) {
    if ($hook_suffix == 'toplevel_page_gf-upi-payment') {
        wp_enqueue_style('gf-upi-payment-styles', plugin_dir_url(__FILE__) . 'assets/css/styles.css');
        wp_enqueue_script('gf-upi-payment-scripts', plugin_dir_url(__FILE__) . 'assets/js/scripts.js', array('jquery'), null, true);
    }
}
add_action('admin_enqueue_scripts', 'gf_upi_payment_enqueue_assets');

function gf_upi_payment_settings_page() {
    ?>
    <div class="wrap">
        <h1><?php _e('UPI Payment Settings', 'gf-upi-payment'); ?></h1>
        <form method="post" action="options.php">
            <?php
            settings_fields('gf_upi_payment_settings_group');
            do_settings_sections('gf-upi-payment');
            submit_button();
            ?>
        </form>
    </div>
    <?php
}

function gf_upi_payment_api_url_callback() {
    $api_url = get_option('gf_upi_payment_api_url');
    ?>
    <input type="url" name="gf_upi_payment_api_url" value="<?php echo esc_attr($api_url); ?>" class="regular-text" />
    <?php
}

function gf_upi_payment_register_settings() {
    register_setting('gf_upi_payment_settings_group', 'gf_upi_payment_api_url', array(
        'type' => 'string',
        'sanitize_callback' => 'esc_url_raw',
        'validate_callback' => 'gf_upi_payment_validate_api_url',
    ));
}

function gf_upi_payment_validate_api_url($input) {
    if (!filter_var($input, FILTER_VALIDATE_URL)) {
        add_settings_error('gf_upi_payment_api_url', 'invalid_api_url', __('Invalid API URL. Please enter a valid URL.', 'gf-upi-payment'));
        return get_option('gf_upi_payment_api_url');
    }
    return $input;
}

// Register settings and callbacks
add_action('admin_init', 'gf_upi_payment_register_settings');

// Add your custom scripts here
add_action('admin_enqueue_scripts', function() {
    ?>
    <script>
    jQuery(document).ready(function($) {
        // Example script
        console.log("UPI Payment Plugin admin page loaded");
    });
    </script>
    <?php
});
