<?php
/*
Plugin Name: Send It Form
Plugin URI: https://avocadoweb.net
Description: A fully custom contact form plugin for AvocadoWeb Services with settings for Brevo SMTP, reCAPTCHA, and Akismet.
Version: 2.2
Author: Joseph Brzezowski / AvocadoWeb Services LLC
Author URI: https://avocadoweb.net
License: GPL2
*/

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

// ✅ Register the Admin Menu for Settings Page
function avocadoweb_create_menu() {
    add_menu_page(
        'Send It Form Settings', // Page Title
        'Send It Form', // Menu Title in Admin Sidebar
        'manage_options', // Capability (Only Admins Can See It)
        'avocadoweb-settings', // Menu Slug (Must Match URL Slug)
        'avocadoweb_settings_page', // Function to Display Page
        'dashicons-email', // Icon
        20 // Menu Position
    );
}
add_action('admin_menu', 'avocadoweb_create_menu');

// ✅ Register Plugin Settings
function avocadoweb_register_settings() {
    register_setting('avocadoweb-settings-group', 'avocadoweb_smtp_host');
    register_setting('avocadoweb-settings-group', 'avocadoweb_smtp_port');
    register_setting('avocadoweb-settings-group', 'avocadoweb_smtp_username');
    register_setting('avocadoweb-settings-group', 'avocadoweb_smtp_password');
    register_setting('avocadoweb-settings-group', 'avocadoweb_recaptcha_type');
    register_setting('avocadoweb-settings-group', 'avocadoweb_recaptcha_v2_site_key');
    register_setting('avocadoweb-settings-group', 'avocadoweb_recaptcha_v2_secret_key');
    register_setting('avocadoweb-settings-group', 'avocadoweb_recaptcha_v3_site_key');
    register_setting('avocadoweb-settings-group', 'avocadoweb_recaptcha_v3_secret_key');
    register_setting('avocadoweb-settings-group', 'avocadoweb_akismet_api_key');
    register_setting('avocadoweb-settings-group', 'avocadoweb_email_recipient');
}
add_action('admin_init', 'avocadoweb_register_settings');

// ✅ Render the Settings Page
function avocadoweb_settings_page() {
    ?>
    <style>
        .avocado-settings-box {
            background: #f9f9f9;
            padding: 15px;
            margin-bottom: 20px;
            border: 1px solid #ddd;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            width: 500px;
        }
    </style>
    <div class="wrap">
        <h1>Send It Form Settings</h1>
        <p>This is the settings page where you can provide information to ensure that the contact form will function with Brevo SMTP, reCAPTCHA, and Akismet.</p>

        <h2>How to Use the Contact Form</h2>
        <p>To display the contact form on any page or post, use the following shortcode:</p>
        <code>[send_it_contact_form]</code>

        <br><br><br>

        <form method="post" action="options.php">
            <?php settings_fields('avocadoweb-settings-group'); do_settings_sections('avocadoweb-settings-group'); ?>
            
            <div class="avocado-settings-box">
                <h2>Brevo SMTP Settings</h2>
                <label>SMTP Host</label>
                <input type="text" name="avocadoweb_smtp_host" value="<?php echo esc_attr(get_option('avocadoweb_smtp_host')); ?>">
                <br><br>
                <label>SMTP Port</label>
                <input type="text" name="avocadoweb_smtp_port" value="<?php echo esc_attr(get_option('avocadoweb_smtp_port')); ?>">
                <br><br>
                <label>SMTP Username</label>
                <input type="text" name="avocadoweb_smtp_username" value="<?php echo esc_attr(get_option('avocadoweb_smtp_username')); ?>">
                <br><br>
                <label>SMTP Password</label>
                <input type="password" name="avocadoweb_smtp_password" value="<?php echo esc_attr(get_option('avocadoweb_smtp_password')); ?>">
            </div>

            <div class="avocado-settings-box">
                <h2>reCAPTCHA Settings</h2>
                <label>reCAPTCHA Type</label>
                <select name="avocadoweb_recaptcha_type">
                    <option value="v2" <?php selected(get_option('avocadoweb_recaptcha_type'), 'v2'); ?>>reCAPTCHA v2</option>
                    <option value="v3" <?php selected(get_option('avocadoweb_recaptcha_type'), 'v3'); ?>>reCAPTCHA v3</option>
                </select>
                <br><br>
                <label>reCAPTCHA v2 Site Key</label>
                <input type="text" name="avocadoweb_recaptcha_v2_site_key" value="<?php echo esc_attr(get_option('avocadoweb_recaptcha_v2_site_key')); ?>">
                <br><br>
                <label>reCAPTCHA v2 Secret Key</label>
                <input type="text" name="avocadoweb_recaptcha_v2_secret_key" value="<?php echo esc_attr(get_option('avocadoweb_recaptcha_v2_secret_key')); ?>">
                <br><br>
                <label>reCAPTCHA v3 Site Key</label>
                <input type="text" name="avocadoweb_recaptcha_v3_site_key" value="<?php echo esc_attr(get_option('avocadoweb_recaptcha_v3_site_key')); ?>">
                <br><br>
                <label>reCAPTCHA v3 Secret Key</label>
                <input type="text" name="avocadoweb_recaptcha_v3_secret_key" value="<?php echo esc_attr(get_option('avocadoweb_recaptcha_v3_secret_key')); ?>">
            </div>

            <div class="avocado-settings-box">
                <h2>Akismet Spam Protection</h2>
                <label>Akismet API Key</label>
                <input type="text" name="avocadoweb_akismet_api_key" value="<?php echo esc_attr(get_option('avocadoweb_akismet_api_key')); ?>">
            </div>

            <div class="avocado-settings-box">
                <h2>Email Recipient</h2>
                <label>Email Address for Form Submissions</label>
                <input type="text" name="avocadoweb_email_recipient" value="<?php echo esc_attr(get_option('avocadoweb_email_recipient', 'info@avocadowebservices.com')); ?>" required>
            </div>
            
            <?php submit_button(); ?>
        </form>
    </div>
    <?php
}
?>
