<?php
/**
 * Plugin Name: Artigot.dev CMP Banner
 * Description: Inserta el banner de consentimiento de cookies.
 * Version: 1.5
 * Author: Ciro Artigot
 * Text Domain: artigotdev-CMP-banner
 * Domain Path: /languages
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Salir si se accede directamente
}

// Cargar el archivo de texto de dominio para traducción
function artigotdev_cmp_banner_load_textdomain() {
    load_plugin_textdomain( 'artigotdev-CMP-banner', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );
}
add_action( 'plugins_loaded', 'artigotdev_cmp_banner_load_textdomain' );

// Incluir archivo de configuración
require_once plugin_dir_path( __FILE__ ) . 'admin/settings.php';

// Función para insertar el código en el footer
function insertar_codigo_footer() {
    // Obtener los valores de las opciones
    $bg_color = get_option( 'icf_bg_color', '#ffffff' );
    $text_color = get_option( 'icf_text_color', '#000000' );
    $google_tag = get_option( 'icf_google_tag', '' );

    ?>
    <!-- Tu código CSS aquí -->
    <style>
        #CCManager_cookie_button {
            position: fixed;
            bottom: 0;
            left: 0;
            padding: 5px;
            margin: 5px;
            border: 0;
            cursor: pointer;
            background-color: transparent;
            border-radius: 116px;
            display: flex;
        }

        #CCManager_modal_button_svg {
            width: 40px;
            height: 40px;
            fill: #fff;
        }

        #CCManager_modal {
            z-index: 9999;
            position: fixed;
            bottom: 10px;
            right: 10px;
            background-color: <?php echo esc_attr( $bg_color ); ?>;
            color: <?php echo esc_attr( $text_color ); ?>;
            padding: 20px 5px;
            transition: opacity 1s linear;
            text-align: center;
            display: flex;
            align-items: center;
            flex-direction: column;
            justify-content: center;
            flex-wrap: wrap;
            border: 2px solid white;
            border-radius: 10px;
            opacity: 0;
        }

        #CCManager_modal_text {
            padding: 20px;
        }

        #CCManager_modal_buttons,
        #CCManager_preferences_buttons {
            display: flex;
            flex-direction: row;
            align-items: center;
            justify-content: center;
            margin-top: 20px;
        }

        .CCManager_modal_button {
            margin: 5px;
            padding: 5px;
            cursor: pointer;
            background-color: transparent;
            border: 2px white solid;
            border-radius: 10px;
            color: white;
            transition: background-color 1s linear, color 1s linear;
            font-size: 20px;
        }

        .CCManager_modal_button:hover {
            color: black;
            background-color: white;
        }

        #CCManager_modal_moreinfo {
            padding-top: 15px;
            padding-bottom: 15px;
        }

        #CCManager_modal_moreinfo_link {
            text-decoration: none;
            color: #fff;
        }

        #CCManager_modal_moreinfo_link:hover {
            text-decoration: underline;
        }

        #CCManager_modal.CCManager_hidden {
            display: none;
        }

        #CCManager_modal.CCManager_opacity-100 {
            opacity: 1;
        }

        #CCManager_modal.CCManager_opacity-0 {
            opacity: 0;
        }

        #CCManager_preferences {
            display: none;
            flex-direction: column;
        }

        #CCManager_preferences.visible {
            display: flex;
        }

        .CCManager_preference_option {
            padding: 5px;
            background-color: transparent;
            border-radius: 10px;
            color: white;
            font-size: 16px;
            cursor: pointer;
            text-align: left;
        }

        .CCManager_preference_option input {
            margin-right: 10px;
        }

        .CCManager_preference_option:hover {
            background-color: white;
            color: black;
        }
    </style>

    <div id="CCManager_cookie">
        <button aria-label="<?php _e( 'Cookie consent button', 'artigotdev-CMP-banner' ); ?>" id="CCManager_cookie_button">
            <svg id="CCManager_modal_button_svg" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512.002 512.002">
                <g>
                    <g>
                        <path d="M501.791,236.285c-32.933-11.827-53.189-45.342-50.644-71.807c0-4.351-2.607-8.394-5.903-11.25
                        c-3.296-2.842-8.408-4.072-12.686-3.384c-50.186,7.363-96.14-29.352-100.693-80.962c-0.41-4.658-2.959-8.848-6.914-11.353
                        c-3.94-2.49-8.848-3.032-13.198-1.406C271.074,71.02,232.637,44.084,217.3,8.986c-2.871-6.563-9.99-10.181-17.007-8.628
                        C84.82,26.125,0.001,137.657,0.001,256.002c0,140.61,115.39,256,256,256s256-115.39,256-256
                        C511.584,247.068,511.522,239.771,501.791,236.285z M105.251,272.131c-8.284,0-15-6.716-15-15c0-8.286,6.716-15,15-15
                        s15,6.714,15,15C120.251,265.415,113.534,272.131,105.251,272.131z M166.001,391.002c-24.814,0-45-20.186-45-45
                        c0-24.814,20.186-45,45-45c24.814,0,45,20.186,45,45C211.001,370.816,190.816,391.002,166.001,391.002z M181.001,211.002
                        c-16.538,0-30-13.462-30-30c0-16.538,13.462-30,30-30c16.538,0,30,13.462,30,30C211.001,197.54,197.539,211.002,181.001,211.002z
                        M301.001,421.002c-16.538,0-30-13.462-30-30c0-16.538,13.462-30,30-30c16.538,0,30,13.462,30,30
                        C331.001,407.54,317.539,421.002,301.001,421.002z M316.001,301.002c-24.814,0-45-20.186-45-45c0-24.814,20.186-45,45-45
                        c24.814,0,45,20.186,45,45C361.001,280.816,340.816,301.002,316.001,301.002z M405.251,332.131c-8.284,0-15-6.716-15-15
                        c0-8.286,6.716-15,15-15s15,6.714,15,15C420.251,325.415,413.534,332.131,405.251,332.131z" />
                    </g>
                </g>
            </svg>
        </button>
    </div>

    <div id="CCManager_modal" class="CCManager_hidden">
        <div id="CCManager_modal_text">
            <?php _e( 'Este sitio web utiliza <strong>cookies</strong> para mejorar tu experiencia.<br>Al hacer clic en "Aceptar todas", aceptas nuestra <a href="/cookies">política de cookies</a>.<br>También puedes seleccionar qué cookies deseas permitir mediante el botón "Configurar".', 'artigotdev-CMP-banner' ); ?>
        </div>
        <div id="CCManager_modal_buttons">
            <button type="button" id="CCManager_modal_preferences" class="CCManager_modal_button">
                <span><?php _e( 'Configurar', 'artigotdev-CMP-banner' ); ?></span>
            </button>
            <button type="button" id="CCManager_modal_decline" class="CCManager_modal_button">
                <span><?php _e( 'Rechazar todas', 'artigotdev-CMP-banner' ); ?></span>
            </button>
            <button type="button" id="CCManager_modal_accept" class="CCManager_modal_button">
                <span><?php _e( 'Aceptar todas', 'artigotdev-CMP-banner' ); ?></span>
            </button>
        </div>
        <div id="CCManager_preferences" class="CCManager_hidden">
            <div class="CCManager_preference_option">
                <label>
                    <input type="checkbox" id="ad_storage_preference">
                    <?php _e( 'Personalizar la publicidad que ves en este y otros sitios web en función de tus intereses y actividad en línea.', 'artigotdev-CMP-banner' ); ?>
                </label>
            </div>
            <div class="CCManager_preference_option">
                <label>
                    <input type="checkbox" id="analytics_storage_preference">
                    <?php _e( 'Recopilar datos sobre cómo usas este sitio web para mejorar su rendimiento y experiencia de usuario.', 'artigotdev-CMP-banner' ); ?>
                </label>
            </div>
            <div class="CCManager_preference_option">
                <label>
                    <input type="checkbox" id="measurement_storage_preference">
                    <?php _e( 'Medir la efectividad de las campañas de marketing y la atribución de conversiones.', 'artigotdev-CMP-banner' ); ?>
                </label>
            </div>
            <div class="CCManager_preference_option">
                <label>
                    <input type="checkbox" id="personalization_storage_preference">
                    <?php _e( 'Personalizar tu experiencia en este sitio web en función de tus preferencias y comportamiento.', 'artigotdev-CMP-banner' ); ?>
                </label>
            </div>
            <div id="CCManager_preferences_buttons">
                <button type="button" id="CCManager_save_preferences" class="CCManager_modal_button">
                    <span><?php _e( 'Guardar Preferencias', 'artigotdev-CMP-banner' ); ?></span>
                </button>
                <button type="button" id="CCManager_cancel_preferences" class="CCManager_modal_button">
                    <span><?php _e( 'Cancelar', 'artigotdev-CMP-banner' ); ?></span>
                </button>
            </div>
        </div>
    </div>

    <script defer>
        window.dataLayer = window.dataLayer || [];
        function gtag() { dataLayer.push(arguments); }

        document.addEventListener("DOMContentLoaded", function () {
            const CCManager_cookie_button = document.getElementById('CCManager_cookie_button');
            const CCManager_modal_decline = document.getElementById('CCManager_modal_decline');
            const CCManager_modal_accept = document.getElementById('CCManager_modal_accept');
            const CCManager_modal_preferences = document.getElementById('CCManager_modal_preferences');
            const CCManager_save_preferences = document.getElementById('CCManager_save_preferences');
            const CCManager_cancel_preferences = document.getElementById('CCManager_cancel_preferences');
            const CCManager_modal = document.getElementById('CCManager_modal');
            const CCManager_preferences = document.getElementById('CCManager_preferences');
            const CCManager_modal_buttons = document.getElementById('CCManager_modal_buttons');
            const adStoragePreference = document.getElementById('ad_storage_preference');
            const analyticsStoragePreference = document.getElementById('analytics_storage_preference');
            const measurementStoragePreference = document.getElementById('measurement_storage_preference');
            const personalizationStoragePreference = document.getElementById('personalization_storage_preference');

            CCManager_cookie_button.addEventListener('click', () => {
                togglePopup('show');
            });

            CCManager_modal_decline.addEventListener('click', () => {
                setConsent('denied', 'denied', 'denied', 'denied');
                togglePopup('hide');
            });

            CCManager_modal_accept.addEventListener('click', () => {
                setConsent('granted', 'granted', 'granted', 'granted');
                togglePopup('hide');
            });

            CCManager_modal_preferences.addEventListener('click', () => {
                CCManager_preferences.classList.add('visible');
                CCManager_modal_buttons.style.display = 'none';
                loadPreferences();
            });

            CCManager_save_preferences.addEventListener('click', () => {
                const adConsent = adStoragePreference.checked ? 'granted' : 'denied';
                const analyticsConsent = analyticsStoragePreference.checked ? 'granted' : 'denied';
                const measurementConsent = measurementStoragePreference.checked ? 'granted' : 'denied';
                const personalizationConsent = personalizationStoragePreference.checked ? 'granted' : 'denied';
                setConsent(adConsent, analyticsConsent, measurementConsent, personalizationConsent);
                togglePopup('hide');
            });

            CCManager_cancel_preferences.addEventListener('click', () => {
                CCManager_preferences.classList.remove('visible');
                CCManager_modal_buttons.style.display = 'flex';
            });

            function togglePopup(option) {
                if (option === 'show') {
                    CCManager_modal.classList.remove('CCManager_opacity-0', 'CCManager_hidden');
                    setTimeout(() => {
                        CCManager_modal.classList.add('CCManager_opacity-100');
                    }, 10);
                } else {
                    CCManager_modal.classList.remove('CCManager_opacity-100');
                    CCManager_modal.classList.add('CCManager_opacity-0');
                    setTimeout(() => {
                        CCManager_modal.classList.add('CCManager_hidden');
                    }, 1000);
                }
            }

            function setConsent(adStorage, analyticsStorage, measurementStorage, personalizationStorage) {
                const consentmode = {
                    'ad_storage': adStorage,
                    'analytics_storage': analyticsStorage,
                    'measurement_storage': measurementStorage,
                    'personalization_storage': personalizationStorage
                };
                gtag('consent', 'update', consentmode);
                localStorage.setItem('consentMode', JSON.stringify(consentmode));
            }

            function loadPreferences() {
                const consentmode = JSON.parse(localStorage.getItem('consentMode')) || {
                    'ad_storage': 'denied',
                    'analytics_storage': 'denied',
                    'measurement_storage': 'denied',
                    'personalization_storage': 'denied'
                };

                adStoragePreference.checked = consentmode['ad_storage'] === 'granted';
                analyticsStoragePreference.checked = consentmode['analytics_storage'] === 'granted';
                measurementStoragePreference.checked = consentmode['measurement_storage'] === 'granted';
                personalizationStoragePreference.checked = consentmode['personalization_storage'] === 'granted';
            }

            function checkConsent() {
                gtag('consent', 'default', {
                    'ad_storage': 'denied',
                    'analytics_storage': 'denied',
                    'measurement_storage': 'denied',
                    'personalization_storage': 'denied'
                });

                const consentmode = JSON.parse(localStorage.getItem('consentMode'));
                if (consentmode) {
                    gtag('consent', 'default', consentmode);
                    togglePopup('hide');
                } else {
                    togglePopup('show');
                }
            }

            checkConsent();
        });

        (function (w, d, s, l, i) {
            w[l] = w[l] || [];
            w[l].push({ 'gtm.start': new Date().getTime(), event: 'gtm.js' });
            var f = d.getElementsByTagName(s)[0],
                j = d.createElement(s), dl = l != 'dataLayer' ? '&l=' + l : '';
            j.async = true;
            j.src = 'https://www.googletagmanager.com/gtm.js?id=' + i + dl;
            f.parentNode.insertBefore(j, f);
        })(window, document, 'script', 'dataLayer', '<?php echo $google_tag; ?>');
    </script>
    <?php
}
add_action( 'wp_footer', 'insertar_codigo_footer' );
