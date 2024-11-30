<?php

/*
 * Plugin Name:       Show Admin Notice
 * Plugin URI:        https://frankremmy.com
 * Description:       A simple plugin to display a custom message in the WordPress admin dashboard.
 * Version:           1.0.0
 * Author:            Frank Remmy
 * Author URI:        https://frankremmy.com/
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Update URI:        https://example.com/my-plugin/
 * Text Domain:       show-admin-notice
 * Domain Path:       /languages
 */


 function cam_display_admin_message() {
    $message = get_option( 'cam_admin_message', 'Hello, Admin! This is your custom message.' );
    echo '<div class="notice notice-success is-dismissible">';
    echo '<p>' . esc_html( $message ) . '</p>';
    echo '</div>';
}

function cam_add_settings_page() {
    add_options_page(
        'Custom Admin Message Settings',
        'Admin Message',
        'manage_options',
        'custom-admin-message',
        'cam_settings_page_callback'
    );
}
add_action( 'admin_menu', 'cam_add_settings_page' );

function cam_settings_page_callback() {
    ?>
    <div class="wrap">
        <h1><?php _e( 'Custom Admin Message Settings', 'custom-admin-message' ); ?></h1>
        <form method="post" action="options.php">
            <?php
            settings_fields( 'cam_settings_group' );
            do_settings_sections( 'custom-admin-message' );
            submit_button();
            ?>
        </form>
    </div>
    <?php
}

function cam_register_settings() {
    register_setting( 'cam_settings_group', 'cam_admin_message' );
    add_settings_section( 'cam_section', 'Admin Message Settings', null, 'custom-admin-message' );
    add_settings_field(
        'cam_message',
        'Admin Message',
        'cam_message_field_callback',
        'custom-admin-message',
        'cam_section'
    );
}
add_action( 'admin_init', 'cam_register_settings' );

function cam_message_field_callback() {
    $message = get_option( 'cam_admin_message', 'Hello, Admin! This is your custom message.' );
    echo '<input type="text" name="cam_admin_message" value="' . esc_attr( $message ) . '" class="regular-text" />';
}