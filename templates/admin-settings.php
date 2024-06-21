// Add menu item
function gf_upi_payment_add_menu_item() {
    add_menu_page(
        'UPI Payment Settings',
        'UPI Payment',
        'manage_options',
        'gf-upi-payment-settings',
        'gf_upi_payment_settings_page'
    );
}
add_action('admin_menu', 'gf_upi_payment_add_menu_item');

// Register settings
function gf_upi_payment_register_settings() {
    register_setting('gf_upi_payment_settings_group', 'gf_upi_payment_api_url');
}
add_action('admin_init', 'gf_upi_payment_register_settings');

// Settings page content
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

// API URL field callback
function gf_upi_payment_api_url_callback() {
    $api_url = get_option('gf_upi_payment_api_url');
    ?>
    <input type="text" name="gf_upi_payment_api_url" value="<?php echo esc_attr($api_url); ?>" class="regular-text" />
    <?php
}

// Add API URL field to the settings page
function gf_upi_payment_settings_fields() {
    add_settings_section(
        'gf_upi_payment_settings_section',
        __('UPI Payment API URL', 'gf-upi-payment'),
        'gf_upi_payment_api_url_section_callback',
        'gf-upi-payment'
    );

    add_settings_field(
        'gf_upi_payment_api_url',
        __('API URL', 'gf-upi-payment'),
        'gf_upi_payment_api_url_callback',
        'gf-upi-payment',
        'gf_upi_payment_settings_section'
    );
}
add_action('admin_init', 'gf_upi_payment_settings_fields');

// Section callback (if needed)
function gf_upi_payment_api_url_section_callback() {
    echo '<p>' . __('Enter the API URL for UPI payments.', 'gf-upi-payment') . '</p>';
}
