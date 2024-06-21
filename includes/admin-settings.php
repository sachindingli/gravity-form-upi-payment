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

function gf_upi_payment_main_section_callback() {
    echo '<p>' . __('Enter your default UPI ID and UPI Payment API URL.', 'gf-upi-payment') . '</p>';
}

function gf_upi_payment_upi_id_callback() {
    $upi_id = get_option('gf_upi_payment_upi_id');
    ?>
    <input type="text" name="gf_upi_payment_upi_id" value="<?php echo esc_attr($upi_id); ?>" class="regular-text" />
    <?php
}

function gf_upi_payment_api_url_callback() {
    $api_url = get_option('gf_upi_payment_api_url');
    ?>
    <input type="text" name="gf_upi_payment_api_url" value="<?php echo esc_attr($api_url); ?>" class="regular-text" />
    <?php
}

function gf_upi_payment_register_settings() {
    register_setting('gf_upi_payment_settings_group', 'gf_upi_payment_upi_id');
    register_setting('gf_upi_payment_settings_group', 'gf_upi_payment_api_url');
    add_settings_section(
        'gf_upi_payment_main_section',
        __('Main Settings', 'gf-upi-payment'),
        'gf_upi_payment_main_section_callback',
        'gf-upi-payment'
    );
    add_settings_field(
        'gf_upi_payment_upi_id',
        __('Default UPI ID', 'gf-upi-payment'),
        'gf_upi_payment_upi_id_callback',
        'gf-upi-payment',
        'gf_upi_payment_main_section'
    );
    add_settings_field(
        'gf_upi_payment_api_url',
        __('UPI Payment API URL', 'gf-upi-payment'),
        'gf_upi_payment_api_url_callback',
        'gf-upi-payment',
        'gf_upi_payment_main_section'
    );
}
