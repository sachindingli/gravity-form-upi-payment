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
