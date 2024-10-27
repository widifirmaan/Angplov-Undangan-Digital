<?php


/* --------------------------------------------------------------------

   Definimos Constantes

-------------------------------------------------------------------- */

define('WDP_PLUGIN_NAME', 'Comment Kit');

define('WDP_VERSION', '2.7.6');

define( 'ADDONS_WEDDINGPRESS_URL', trailingslashit( plugin_dir_url(__FILE__)));
define( 'ADDONS_WEDDINGPRESS_PATH', trailingslashit( plugin_dir_url(__FILE__)));

/* --------------------------------------------------------------------

   Configuración de Acciones y Ganchos

-------------------------------------------------------------------- */

register_activation_hook(__FILE__, 'install_options_WDP');


add_action('admin_init', 'requires_wp_version_WDP');

add_action('admin_init', 'register_options_WDP');

add_action('admin_init', 'update_options_WDP');

add_action('admin_menu', 'add_options_page_WDP', 900);

add_action('wp_enqueue_scripts', 'add_styles_WDP');

add_action('wp_enqueue_scripts', 'add_scripts_WDP');

add_action('wp_enqueue_scripts', 'add_custom_styles_WDP');

add_action('admin_enqueue_scripts', 'add_admin_styles_WDP');

add_action('admin_enqueue_scripts', 'add_admin_scripts_WDP');



/* --------------------------------------------------------------------

   Comprobamos si la version actual de WordPress es Compatible con el Plugin

-------------------------------------------------------------------- */

function requires_wp_version_WDP()

{

    global $wp_version;

    $plugin = plugin_basename(__FILE__);

    $plugin_data = get_plugin_data(__FILE__, false);



    if (version_compare($wp_version, "3.2", "<")) {

        if (is_plugin_active($plugin)) {

            deactivate_plugins($plugin);

            wp_die("'" . $plugin_data['Name'] . "' requires Wordpress 3.2 or higher, and is disabled, you must update Wordpress.<br /><br />Return to the <a href='" . admin_url() . "'>desktop WordPress</a>.");

        }

    }

}





/* --------------------------------------------------------------------

   Registramos las Opciones del Plugin

-------------------------------------------------------------------- */

function register_options_WDP()

{

    register_setting('wdp_group_options', 'wdp_options', 'validate_options_WDP');

    $options = get_option('wdp_options');

    $restore_options = isset($options['default_options']) ? $options['default_options'] : 'false';



    //Si está marcada la opción de restaurar a los valores por defecto

    if ($restore_options == 'true') {

        $default_options = default_options_WDP();

        update_option('wdp_options', $default_options);

    }



}



/* --------------------------------------------------------------------

   Valores por Defecto de las Opciones del Plugin

-------------------------------------------------------------------- */

function default_options_WDP()

{

    $default_options = array(

        "auto_show" => "true",

        "where_add_comments_box" => "end-content",

        "exclude_pages" => "",

        "include_pages" => "",

        "exclude_home" => "false",

        "exclude_all_pages" => "false",

        "exclude_page_templates" => "",

        "exclude_post_types" => array(),

        "allow_post_types" => array(),

        "remove_default_comments" => "true",

        "allow_duplicate_comments" => "true",

        "auto_load" => "true",

        "num_comments" => "30",

        "order_comments" => "DESC",

        "class_popular_comment" => "wdp-popular-comment",

        "only_registered" => "false",

        "disable_roles_reply_comments" => array(),

        "only_loggedin_can_rate" => "false",

        "exclude_users" => "",

        "text_only_registered" => "",

        "typejquery" => "current-theme",



        "default_options" => "false",



        "jpages" => "true",

        "num_comments_by_page" => "5",

        "text_counter" => "true",

        "text_counter_num" => "500",

        "display_form" => "true",

        "display_captcha" => "all",

        "disable_reply" => "false",

        "disable_actions_after_time" => "",

        "display_media_btns" => "true",

        "display_email" => "true",

        "display_website" => "true",

        "display_rating_btns" => "true",

        "text_0_comments" => "#N# Ucapan",

        "text_1_comment" => "#N# Ucapan",

        "text_more_comments" => "#N# Ucapan",

        "icon-link" => 'true',

        "date_format" => 'date_fb',

        "max_width_images" => "100",

        "unit_images_size" => '%',



        "avatar_size" => "28px",

        "base_font_size" => "14px",

        "width_comments" => "",

        "border" => "true",

        "theme" => "default",

        "css_background_box" => "#F5F7FA",

        "css_border_color" => "#d5deea",

        "css_text_color" => "#44525F",

        "css_link_color" => "#3D7DBC",

        "css_link_color_hover" => "#2a5782",

        "css_text_color_secondary" => "#9DA8B7",

        "css_background_input" => "#FFFFFF",

        "css_background_confirm" => "#777",

        "css_background_button" => "#3D7DBC",

        "css_background_button_hover" => "#4d8ac5",

        "css_text_color_button" => "#FFFFFF",

        "css_rating_color" => "#c9cfd7",

        "css_rating_color_hover" => "#3D7DBC",

        "css_rating_positive_color" => "#2C9E48",

        "css_rating_negative_color" => "#D13D3D",

        "css_success_color" => "#319342",

        "css_error_color" => "#C85951",

        "custom_css" => "",





        "text-time-ago" => "%s yang lalu",

        "text-time-right-now" => "baru saja",

        "text-year" => "bulan",

        "text-years" => "bulan",

        "text-month" => "bulan",

        "text-months" => "bulan",

        "text-week" => "pekan",

        "text-weeks" => "pekan",

        "text-day" => "hari",

        "text-days" => "hari",

        "text-hour" => "jam",

        "text-hours" => "jam",

        "text-min" => "menit",

        "text-mins" => "menit",

        "text-sec" => "detik",

        "text-secs" => "detik",

    );

    $basic_text_translations = get_basic_text_translations_WDP();

    $default_options = array_merge($default_options, $basic_text_translations);

    return $default_options;

}



/* --------------------------------------------------------------------

   Establecemos Opciones del Plugin

-------------------------------------------------------------------- */

function install_options_WDP()

{

    $options = get_option('wdp_options');

    $default_options = default_options_WDP();

    if (is_array($options) && !empty($options)) {

        $set_options = array_merge($default_options, $options);

    } else {

        $set_options = $default_options;

    }

    update_option('wdp_options', $set_options);

}



/* --------------------------------------------------------------------

   Actualiza Opciones del Plugin

-------------------------------------------------------------------- */

function update_options_WDP()

{

    install_options_WDP();

}



/* --------------------------------------------------------------------

   Previene la carga de scripts con el plugin Autoptimize

-------------------------------------------------------------------- */

function get_basic_text_translations_WDP()

{

    return array(

        "text-post-author" => "Author",

        "text-write-comment" => "Tulis Ucapan & Doa",

        "text-send" => "Kirim",

        "text-comment-placeholder" => "Berikan Ucapan & Doa untuk Kedua Mempelai",

        "text-reply" => "Balas",

        "text-accept" => "Accept",

        "text-cancel" => "Cancel",

        "text-edit" => "Edit",

        "text-delete" => "Hapus",

        "text-like" => "Like",

        "text-unlike" => "Unlike",

        "text-likes" => "Likes",

        "text-name" => "Name",

        "text-email" => "Email",

        "text-website" => "Website",

        "text-insert-image" => "Insert image",

        "text-insert-link" => "Insert link",

        "text-insert-video" => "Insert video",

        "text-check-video" => "Check video",

        "text-url-image" => "Url image",

        "text-url-video" => "Url video youtube or vimeo",

        "text-url-link" => "Url link",

        "text-to-display" => "Text to display",

        "text-characteres-minimun" => "Minimal 2 karakter",

        "text-thanks-comment" => "Terima kasih atas ucapan & doanya!",

        "text-thanks-reply-comment" => "Terima kasih atas balasannya!",

        "text-duplicate-comment" => "You might have left one of the fields blank, or duplicate comments",

        "text-comments-closed" => "Comment ditutup! silahkan aktifkan comment di page/post ini.",

        "text-login-to-comment" => "Please %s login %s to comment",

        "text-nav-next" => "Selanjutnya",

        "text-nav-prev" => "Sebelumnya",

        "text-msg-delete-comment" => "Do you want delete this comment?",

        "text-load-more" => "Load more",

    );

}



/* --------------------------------------------------------------------

   Previene la carga de scripts con el plugin Autoptimize

-------------------------------------------------------------------- */

add_filter('autoptimize_filter_js_exclude', 'exclude_wdp_scripts');

function exclude_wdp_scripts($ao_noptimize)

{

    $ao_noptimize = $ao_noptimize . ',jquery,wdp_script.js';

    return $ao_noptimize;

}



/* --------------------------------------------------------------------

   Carga de Scripts jQuery y Estilos CSS

-------------------------------------------------------------------- */

function add_admin_scripts_WDP($hook)

{
    global $wp_version;

    if ( isset( $_GET['page'] ) && $_GET['page'] == 'weddingpress_page-commentkit-settings' ) {

        return;

    }

    //If the WordPress version is greater than or equal to 3.5, then load the new WordPress color picker.

    if (3.5 <= $wp_version) {

        //Both the necessary css and javascript have been registered already by WordPress, so all we have to do is load them with their handle.

        wp_enqueue_style('wp-color-picker');

        wp_enqueue_script('wp-color-picker');

    } //If the WordPress version is less than 3.5 load the older farbtasic color picker.

    else {

        //As with wp-color-picker the necessary css and javascript have been registered already by WordPress, so all we have to do is load them with their handle.

        wp_enqueue_style('farbtastic');

        wp_enqueue_script('farbtastic');

    }



    //Loading JS using wp_enqueue

    wp_register_script('wdp_admin_js_script', ADDONS_WEDDINGPRESS_URL . '/js/wdp_admin_script.js', array('jquery'), WDP_VERSION, true);

    wp_enqueue_script('wdp_admin_js_script');

}



function add_scripts_WDP()

{

    //Loading JS using wp_enqueue

    $options = get_option('wdp_options');

    if (!is_admin()) {

        switch ($options['typejquery']) {

            case 'current-theme':

                //Not load jQuery

                break;



            case 'google':

                wp_deregister_script('jquery');

                wp_register_script('jquery', 'http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js', false, '1.10.2', false);

                wp_enqueue_script('jquery');

                break;



            case 'jquery-plugin':

                wp_deregister_script('jquery');

                wp_register_script('jquery', ADDONS_WEDDINGPRESS_URL . '/js/libs/jquery.min.v1.10.2.js', false, '1.10.2', false);

                break;

        }



        //Añadimos el Script JS Principal

        wp_register_script('wdp_js_script', ADDONS_WEDDINGPRESS_URL . '/js/wdp_script.js', array('jquery'), WDP_VERSION, true);

        wp_enqueue_script('wdp_js_script');

        wp_localize_script('wdp_js_script', 'WDP_WP',

            array(

                'ajaxurl' => admin_url('admin-ajax.php'),

                'wdpNonce' => wp_create_nonce('wdp-nonce'),

                'jpages' => $options['jpages'],

                'jPagesNum' => $options['num_comments_by_page'],

                'textCounter' => $options['text_counter'],

                'textCounterNum' => $options['text_counter_num'],

                'widthWrap' => $options['width_comments'],

                'autoLoad' => $options['auto_load'],

                'thanksComment' => $options['text-thanks-comment'],

                'thanksReplyComment' => $options['text-thanks-reply-comment'],

                'duplicateComment' => $options['text-duplicate-comment'],

                'insertImage' => $options['text-insert-image'],

                'insertVideo' => $options['text-insert-video'],

                'insertLink' => $options['text-insert-link'],

                'checkVideo' => $options['text-check-video'],

                'accept' => $options['text-accept'],

                'cancel' => $options['text-cancel'],

                'reply' => $options['text-reply'],

                'textWriteComment' => $options['text-write-comment'],

                'classPopularComment' => $options['class_popular_comment'],

                'textUrlImage' => $options['text-url-image'],

                'textUrlVideo' => $options['text-url-video'],

                'textUrlLink' => $options['text-url-link'],

                'textToDisplay' => $options['text-to-display'],

                'textCharacteresMin' => $options['text-characteres-minimun'],

                'textNavNext' => $options['text-nav-next'],

                'textNavPrev' => $options['text-nav-prev'],

                'textMsgDeleteComment' => $options['text-msg-delete-comment'],

                'textLoadMore' => $options['text-load-more'],

                'textLikes' => $options['text-likes'],

            )

        );



        //Si está activado Paginación de Comentarios

        if ($options['jpages'] == 'true') {

            wp_register_script('wdp_jPages', ADDONS_WEDDINGPRESS_URL . '/js/libs/jquery.jPages.min.js', array('jquery'), '0.7', true);

            wp_enqueue_script('wdp_jPages');

        }

        //Si está activado Contador de Caracteres

        if ($options['text_counter'] == 'true') {

            wp_register_script('wdp_textCounter', ADDONS_WEDDINGPRESS_URL . '/js/libs/jquery.textareaCounter.js', array('jquery'), '2.0', true);

            wp_enqueue_script('wdp_textCounter');

        }

        //PlaceHolder

        wp_register_script('wdp_placeholder', ADDONS_WEDDINGPRESS_URL . '/js/libs/jquery.placeholder.min.js', array('jquery'), '2.0.7', true);

        wp_enqueue_script('wdp_placeholder');

        //Autosize

        wp_register_script('wdp_autosize', ADDONS_WEDDINGPRESS_URL . '/js/libs/autosize.min.js', array('jquery'), '1.14', true);

        wp_enqueue_script('wdp_autosize');



    }

}



function add_admin_styles_WDP()

{

    //Loading CSS using wp_enqueue

    if (is_admin()) {

        wp_register_style('wdp_admin_style', ADDONS_WEDDINGPRESS_URL . '/css/wdp_admin_style.css', array(), WDP_VERSION, 'screen');

        wp_enqueue_style('wdp_admin_style');

    }

}



function add_styles_WDP()

{

    //Loading CSS using wp_enqueue

    if (!is_admin()) {

        wp_register_style('wdp_style', ADDONS_WEDDINGPRESS_URL . '/css/wdp_style.css', array(), WDP_VERSION, 'screen');

        wp_enqueue_style('wdp_style');



        //Custom CSS by Users

        $options = get_option('wdp_options');

        $max_width_img = $options['max_width_images'];

        $unit = $options['unit_images_size'];

        ?>

        <style type="text/css">

            .wdp-comment-text img {

                max-width: <?php echo $max_width_img.$unit; ?> !important;

            }

        </style>

        <?php

    }

}



/* --------------------------------------------------------------------

   Estilos personalizados

-------------------------------------------------------------------- */

function add_custom_styles_WDP()

{

    $options = get_option('wdp_options');



    $custom_css = "

        .wdp-wrapper {

          font-size: {$options['base_font_size']}

        }

    ";

    if ($options['theme'] == 'custom') {

        $custom_css .= "

        .wdp-wrapper {

          background: {$options['css_background_box']};

        }

        .wdp-wrapper.wdp-border {

          border: 1px solid {$options['css_border_color']};

        }



        .wdp-wrapper .wdp-wrap-comments a:link,

        .wdp-wrapper .wdp-wrap-comments a:visited {

          color: {$options['css_link_color']};

        }



        .wdp-wrapper .wdp-wrap-link a.wdp-link {

          color: {$options['css_link_color']};

        }

        .wdp-wrapper .wdp-wrap-link a.wdp-link.wdp-icon-link-true .wdpo-comment {

          color: {$options['css_link_color']};

        }

        .wdp-wrapper .wdp-wrap-link a.wdp-link:hover {

          color: {$options['css_link_color_hover']};

        }

        .wdp-wrapper .wdp-wrap-link a.wdp-link:hover .wdpo-comment {

          color: {$options['css_link_color_hover']};

        }



        .wdp-wrapper .wdp-wrap-form {

          border-top: 1px solid {$options['css_border_color']};

        }

        .wdp-wrapper .wdp-wrap-form .wdp-container-form textarea.wdp-textarea {

          border: 1px solid {$options['css_border_color']};

          background: {$options['css_background_input']};

          color: {$options['css_text_color']};

        }

        .wdp-wrapper ul.wdp-container-comments li.wdp-item-comment .wdp-comment-content .wdp-comment-info .wdp-post-author {

          background: {$options['css_background_confirm']};

        }

        .wdp-wrapper .wdp-wrap-form .wdp-container-form input[type='text'] {

          border: 1px solid {$options['css_border_color']};

          background: {$options['css_background_input']};

          color: {$options['css_text_color']};

        }

        .wdp-wrapper .wdp-wrap-form .wdp-container-form input.wdp-input:focus,

        .wdp-wrapper .wdp-wrap-form .wdp-container-form textarea.wdp-textarea:focus {

          border-color: #64B6EC;

        }

        .wdp-wrapper .wdp-wrap-form .wdp-container-form input[type='submit'],

        .wdp-wrapper .wdp-wrap-form .wdp-container-form input[type='button'].wdp-form-btn {

          color: {$options['css_text_color_button']};

          background: {$options['css_background_button']};

        }

        .wdp-wrapper .wdp-wrap-form .wdp-container-form input[type='submit']:hover,

        .wdp-wrapper .wdp-wrap-form .wdp-container-form input[type='button'].wdp-form-btn:hover {

          background: {$options['css_background_button_hover']};

        }

        .wdp-wrapper .wdp-wrap-form .wdp-container-form .wdp-captcha .wdp-captcha-text {

          color: {$options['css_text_color']};

        }



        .wdp-wrapper .wdp-media-btns a > span {

          color: {$options['css_link_color']};

        }

        .wdp-wrapper .wdp-media-btns a > span:hover {

          color: {$options['css_link_color_hover']};

        }



        .wdp-wrapper .wdp-comment-status {

          border-top: 1px solid {$options['css_border_color']};

        }

        .wdp-wrapper .wdp-comment-status p.wdp-ajax-success {

          color: {$options['css_success_color']};

        }

        .wdp-wrapper .wdp-comment-status p.wdp-ajax-error {

          color: {$options['css_error_color']};

        }

        .wdp-wrapper .wdp-comment-status.wdp-loading > span {

          color: {$options['css_link_color']};

        }



        .wdp-wrapper ul.wdp-container-comments {

          border-top: 1px solid {$options['css_border_color']};

        }

        .wdp-wrapper ul.wdp-container-comments li.wdp-item-comment {

          border-bottom: 1px solid {$options['css_border_color']};

        }

        .wdp-wrapper ul.wdp-container-comments li.wdp-item-comment ul li.wdp-item-comment {

          border-top: 1px solid {$options['css_border_color']};

        }

        .wdp-wrapper ul.wdp-container-comments li.wdp-item-comment .wdp-comment-content .wdp-comment-info a.wdp-commenter-name {

          color: {$options['css_link_color']} !important;

        }

        .wdp-wrapper ul.wdp-container-comments li.wdp-item-comment .wdp-comment-content .wdp-comment-info a.wdp-commenter-name:hover {

          color: {$options['css_link_color_hover']} !important;

        }

        .wdp-wrapper ul.wdp-container-comments li.wdp-item-comment .wdp-comment-content .wdp-comment-info .wdp-comment-time {

          color: {$options['css_text_color_secondary']};

        }

        .wdp-wrapper ul.wdp-container-comments li.wdp-item-comment .wdp-comment-content .wdp-comment-text p {

          color: {$options['css_text_color']};

        }

        .wdp-wrapper ul.wdp-container-comments li.wdp-item-comment .wdp-comment-content .wdp-comment-actions a {

          color: {$options['css_link_color']};

        }

        .wdp-wrapper ul.wdp-container-comments li.wdp-item-comment .wdp-comment-content .wdp-comment-actions a:hover {

          color: {$options['css_link_color_hover']};

        }

        .wdp-wrapper ul.wdp-container-comments li.wdp-item-comment .wdp-comment-content .wdp-comment-rating .wdp-rating-link > span {

          color: {$options['css_rating_color']};

        }

        .wdp-wrapper ul.wdp-container-comments li.wdp-item-comment .wdp-comment-content .wdp-comment-rating .wdp-rating-link > span:hover {

          color: {$options['css_rating_color_hover']};

        }

        .wdp-wrapper ul.wdp-container-comments li.wdp-item-comment .wdp-comment-content .wdp-comment-rating .wdp-rating-count {

          color: {$options['css_text_color_secondary']};

        }

        .wdp-wrapper ul.wdp-container-comments li.wdp-item-comment .wdp-comment-content .wdp-comment-rating .wdp-rating-count.wdp-rating-positive {

          color: {$options['css_rating_positive_color']};

        }

        .wdp-wrapper ul.wdp-container-comments li.wdp-item-comment .wdp-comment-content .wdp-comment-rating .wdp-rating-count.wdp-rating-negative {

          color: {$options['css_rating_negative_color']};

        }

        .wdp-wrapper ul.wdp-container-comments li.wdp-item-comment .wdp-comment-content .wdp-comment-rating .wdp-rating-count.wdpo-loading {

          color: {$options['css_rating_color']};

        }

        .wdp-wrapper ul.wdp-container-comments a.wdp-load-more-comments:hover {

          color: {$options['css_link_color_hover']};

        }



        .wdp-wrapper .wdp-counter-info {

          color: {$options['css_text_color_secondary']};

        }



        .wdp-wrapper .wdp-holder span {

          color: {$options['css_link_color']};

        }

        .wdp-wrapper .wdp-holder a,

        .wdp-wrapper .wdp-holder a:link,

        .wdp-wrapper .wdp-holder a:visited {

          color: {$options['css_link_color']};

        }

        .wdp-wrapper .wdp-holder a:hover,

        .wdp-wrapper .wdp-holder a:link:hover,

        .wdp-wrapper .wdp-holder a:visited:hover {

          color: {$options['css_link_color_hover']};

        }

        .wdp-wrapper .wdp-holder a.jp-previous.jp-disabled, .wdp-wrapper .wdp-holder a.jp-previous.jp-disabled:hover, .wdp-wrapper .wdp-holder a.jp-next.jp-disabled, .wdp-wrapper .wdp-holder a.jp-next.jp-disabled:hover {

          color: {$options['css_text_color_secondary']};

        }

        ";

    };



    $custom_css .= $options['custom_css'];



    $avatar_size = get_avatar_WDP($options, '', '28')['size'];

    $content_margin_left = $avatar_size + 10;



    $avatar_size2 = $avatar_size - 4;

    $avatar_size3 = $avatar_size2 - 3;



    $avatar_css = "

    .wdp-wrapper ul.wdp-container-comments li.wdp-item-comment .wdp-comment-avatar img {

        max-width: {$avatar_size}px;

        max-height: {$avatar_size}px;

    }

    .wdp-wrapper ul.wdp-container-comments li.wdp-item-comment .wdp-comment-content {

        margin-left: {$content_margin_left}px;

    }

    .wdp-wrapper ul.wdp-container-comments li.wdp-item-comment ul .wdp-comment-avatar img {

        max-width: {$avatar_size2}px;

        max-height: {$avatar_size2}px;

    }

    .wdp-wrapper ul.wdp-container-comments li.wdp-item-comment ul ul .wdp-comment-avatar img {

        max-width: {$avatar_size3}px;

        max-height: {$avatar_size3}px;

    }

    ";



    $custom_css .= $avatar_css;



    wp_add_inline_style('wdp_style', $custom_css);

}



/* --------------------------------------------------------------------

   Función para validar los campos del Formulario de Opciones

-------------------------------------------------------------------- */

function validate_options_WDP($input)

{

    $input['num_comments'] = wp_filter_nohtml_kses($input['num_comments']);

    return $input;

}



/* --------------------------------------------------------------------

   Añadimos La Página de Opciones al Ménu

-------------------------------------------------------------------- */

function add_options_page_WDP()

{

   add_submenu_page('weddingpress', 'Comment Kit', 'Comment Kit', 'manage_options', 'commentkit-settings', 'commentkitpage_settings');


}



/*

|---------------------------------------------------------------------------------------------------

| Get user roles, $capabilities = array('edit_posts), $exclude = array('administrator', 'editor')

|---------------------------------------------------------------------------------------------------

*/

function wdp_get_user_roles( $capabilities = array(), $exclude = array() ){

    global $wp_roles;

    $roles = array();

    if( isset( $wp_roles->roles, $wp_roles->role_names ) && is_array( $wp_roles->roles ) ){

        if( empty( $capabilities ) ){

            $roles = $wp_roles->role_names;

        } else{

            foreach( $wp_roles->roles as $role_key => $role_data ){

                $array_keys = array_keys( $role_data['capabilities'] );

                foreach( $capabilities as $cap ){

                    if( in_array( $cap, $array_keys ) ){

                        $roles[$role_key] = $role_data['name'];

                    }

                }

            }

        }

    }

    if( ! empty( $exclude ) ){

        foreach( $roles as $role_key => $role ){

            if( in_array( $role_key, $exclude ) ){

                unset( $roles[$role_key] );

            }

        }

    }

    return $roles;

}



/* --------------------------------------------------------------------

   Añadimos las Fuciones para Insertar Comentarios

-------------------------------------------------------------------- */

include_once('inc/wdp-functions.php');


function commentkitpage_settings()
{
    include_once('inc/wdp-options-page.php');
}


