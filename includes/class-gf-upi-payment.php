<?php
require_once WP_PLUGIN_DIR . '/gravityforms/includes/addon/class-gf-payment-addon.php';
if (!class_exists('GFForms')) {
    die('Gravity Forms is required for this plugin.');
}

GFForms::include_addon_framework();

class GFUPIPayment extends GFPaymentAddOn {
    protected $_version = '1.0';
    protected $_min_gravityforms_version = '2.4';
    protected $_slug = 'gf-upi-payment';
    protected $_path = 'gf-upi-payment/gf-upi-payment.php';
    protected $_full_path = __FILE__;
    protected $_title = 'Gravity Forms UPI Payment';
    protected $_short_title = 'UPI Payment';

    public function init() {
        parent::init();
        // Add additional init code here
    }

    public function pre_process_payment($feed, $submission_data, $form, $entry) {
        // Get total amount from Gravity Form entry
        $amount = GFCommon::get_order_total($form, $entry);

        // Get UPI ID from the settings
        $upi_id = get_option('gf_upi_payment_upi_id');

        // Call UPI payment gateway API
        $response = $this->process_upi_payment($upi_id, $amount);

        if ($response->success) {
            // Payment succeeded
            $entry['payment_status'] = 'Paid';
            $entry['payment_date'] = gmdate('Y-m-d H:i:s');
            $entry['transaction_id'] = $response->transaction_id;
            GFAPI::update_entry($entry);
        } else {
            // Payment failed
            $entry['payment_status'] = 'Failed';
            GFAPI::update_entry($entry);
            GFFormsModel::add_note(
                $entry['id'],
                0,
                __('System', 'gravityforms'),
                __('UPI Payment Failed: ' . $response->error_message, 'gravityforms')
            );
        }
    }

    private function process_upi_payment($upi_id, $amount) {
        // Get API URL from settings
        $api_url = get_option('gf_upi_payment_api_url');

        // Make API call to process UPI payment
        $api_data = array(
            'upi_id' => $upi_id,
            'amount' => $amount,
            // Add any other required parameters for your API
        );

        $response = wp_remote_post($api_url, array(
            'body' => $api_data,
            'timeout' => 20,
            'headers' => array(
                'Content-Type' => 'application/json',
            ),
        ));

        if (is_wp_error($response)) {
            // Handle API call error
            return (object) array(
                'success' => false,
                'error_message' => $response->get_error_message(),
            );
        }

        $body = wp_remote_retrieve_body($response);
        $api_response = json_decode($body);

        if ($api_response->success) {
            // Payment succeeded
            return (object) array(
                'success' => true,
                'transaction_id' => $api_response->transaction_id,
            );
        } else {
            // Payment failed
            return (object) array(
                'success' => false,
                'error_message' => $api_response->error_message,
            );
        }
    }
}
