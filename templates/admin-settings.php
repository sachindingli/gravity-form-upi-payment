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
