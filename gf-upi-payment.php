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

function gf_upi_payment_init() {
    new GFUPIPayment();
}
add_action('gform_loaded', 'gf_upi_payment_init', 5);
