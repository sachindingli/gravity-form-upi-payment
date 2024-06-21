<?php
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
