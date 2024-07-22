<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Salir si se accede directamente
}

// Añadir página de configuración al menú de administración
function icf_add_admin_menu() {
    add_options_page(
        __( 'Artigot DEV CPM', 'artigotdev-CMP-banner' ),
        __( 'Artigot DEV CPM', 'artigotdev-CMP-banner' ),
        'manage_options',
        'icf-settings',
        'icf_settings_page'
    );
}
add_action( 'admin_menu', 'icf_add_admin_menu' );

// Registrar ajustes
function icf_register_settings() {
    register_setting( 'icf-settings-group', 'icf_bg_color' );
    register_setting( 'icf-settings-group', 'icf_text_color' );
    register_setting( 'icf-settings-group', 'icf_google_tag' );
}
add_action( 'admin_init', 'icf_register_settings' );

// Página de configuración
function icf_settings_page() {
    ?>
    <div class="wrap">
        <h1><?php _e( 'Configuración del Banner de Cookies', 'artigotdev-CMP-banner' ); ?></h1>
        <form method="post" action="options.php">
            <?php settings_fields( 'icf-settings-group' ); ?>
            <?php do_settings_sections( 'icf-settings-group' ); ?>
            <table class="form-table">
                <tr valign="top">
                    <th scope="row"><?php _e( 'Color de Fondo', 'artigotdev-CMP-banner' ); ?></th>
                    <td><input type="text" name="icf_bg_color" value="<?php echo esc_attr( get_option( 'icf_bg_color', '#ffffff' ) ); ?>" /></td>
                </tr>
                <tr valign="top">
                    <th scope="row"><?php _e( 'Color de Texto', 'artigotdev-CMP-banner' ); ?></th>
                    <td><input type="text" name="icf_text_color" value="<?php echo esc_attr( get_option( 'icf_text_color', '#000000' ) ); ?>" /></td>
                </tr>
                <tr valign="top">
                    <th scope="row"><?php _e( 'Etiqueta de Google', 'artigotdev-CMP-banner' ); ?></th>
                    <td><textarea name="icf_google_tag" rows="5" cols="50"><?php echo esc_textarea( get_option( 'icf_google_tag', '' ) ); ?></textarea></td>
                </tr>
            </table>
            <?php submit_button(); ?>
        </form>
    </div>
    <?php
}
