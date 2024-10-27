<?php

//incorporates codes from Max López

define( 'WDP3_PLUGIN_NAME', 'Comment Kit 2');
define( 'WDP3_VERSION', '1.0.0');
define( 'ADDONS_WEDDINGPRESS3_URL', trailingslashit( plugin_dir_url(__FILE__)));
define( 'ADDONS_WEDDINGPRESS3_PATH', trailingslashit( plugin_dir_url(__FILE__)));

if (!defined('ABSPATH'))
    exit; // Exit if accessed directly


register_activation_hook(__FILE__, 'install_options_CUI');
//register_uninstall_hook
//register_deactivation_hook(__FILE__, 'delete_options_CUI');
add_action('admin_init', 'register_options_CUI');
add_action('admin_init', 'update_options_CUI');
add_action('admin_menu', 'add_options_page_CUI', 900);
add_action('wp_enqueue_scripts', 'add_styles_CUI');
add_action('wp_enqueue_scripts', 'add_scripts_CUI');
add_action('wp_enqueue_scripts', 'add_custom_styles_CUI');
add_action('admin_enqueue_scripts', 'add_admin_styles_CUI');
add_action('admin_enqueue_scripts', 'add_admin_scripts_CUI');


function register_options_CUI()
{
    register_setting('cui_group_options', 'cui_options', 'validate_options_CUI');
    $options = get_option('cui_options');
    $restore_options = isset($options['default_options']) ? $options['default_options'] : 'false';

    //Si está marcada la opción de restaurar a los valores por defecto
    if ($restore_options == 'true') {
        $default_options = default_options_CUI();
        update_option('cui_options', $default_options);
    }

}


function default_options_CUI()
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
        "class_popular_comment" => "cui-popular-comment",
        "only_registered" => "false",
        "disable_roles_reply_comments" => array(),
        "only_loggedin_can_rate" => "false",
        "exclude_users" => "",
        "text_only_registered" => "",
        "typejquery" => "current-theme",

        "default_options" => "false",

        "jpages" => "true",
        "num_comments_by_page" => "10",
        "text_counter" => "true",
        "text_counter_num" => "500",
        "display_form" => "true",
        "display_captcha" => "all",
        "disable_reply" => "false",
        "disable_actions_after_time" => "",
        "text_0_comments" => "#N# Comments",
        "text_1_comment" => "#N# Comment",
        "text_more_comments" => "#N# Comments",
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
        "css_background_button" => "#3D7DBC",
        "css_background_button_hover" => "#4d8ac5",
        "css_text_color_button" => "#FFFFFF",
        "css_success_color" => "#319342",
        "css_error_color" => "#C85951",
        "css_hadir_color" => "#3D9A62",
        "css_tidak_hadir_color" => "#d90a11",
        "css_masih_ragu_color" => "#d7a916",
        "custom_css" => "
.cui-post-author {
	color: white !important;
	background: #777 !important;
}",


        "text-time-ago" => "%s lalu",
        "text-time-right-now" => "baru saja",
        "text-year" => "tahun",
        "text-years" => "tahun",
        "text-month" => "bulan",
        "text-months" => "bulan",
        "text-week" => "minggu",
        "text-weeks" => "minggu",
        "text-day" => "hari",
        "text-days" => "hari",
        "text-hour" => "jam",
        "text-hours" => "jam",
        "text-min" => "menit",
        "text-mins" => "menit",
        "text-sec" => "detik",
        "text-secs" => "detik",

        // 'text-remark' => 'Ucapan',
        'text-konfirmasi-kehadiran' => 'Konfirmasi Kehadiran',
        'text-add-note' => 'Add note',
        'text-hadir' => 'Hadir',
        'text-tidak-hadir' => 'Tidak hadir',
        'text-masih-ragu' => 'Masih Ragu',
    );
    $basic_text_translations = get_basic_text_translations_CUI();
    $default_options = array_merge($default_options, $basic_text_translations);
    return $default_options;
}


function install_options_CUI()
{
    $options = get_option('cui_options');
    $default_options = default_options_CUI();
    if (is_array($options) && !empty($options)) {
        $set_options = array_merge($default_options, $options);
    } else {
        $set_options = $default_options;
    }
    update_option('cui_options', $set_options);
}


function update_options_CUI()
{
    install_options_CUI();
}


function get_basic_text_translations_CUI()
{
    return array(
        "text-post-author" => "Author",
        "text-write-comment" => "Ucapan",
        "text-send" => "Kirim",
        "text-reply" => "Reply",
        "text-accept" => "Accept",
        "text-cancel" => "Cancel",
        "text-edit" => "Edit",
        "text-delete" => "Delete",
        "text-name" => "Nama",
        "text-to-display" => "Text to display",
        "text-characteres-minimun" => "2 characters minimum",
        "text-thanks-comment" => "Thanks for your comment!",
        "text-thanks-reply-comment" => "Thanks for answering the comment!",
        "text-duplicate-comment" => "You might have left one of the fields blank, or duplicate comments",
        "text-comments-closed" => "Comments are closed",
        "text-login-to-comment" => "Please %s login %s to comment",
        "text-nav-next" => "Next",
        "text-nav-prev" => "Previous",
        "text-msg-delete-comment" => "Do you want delete this comment?",
        "text-load-more" => "Load more",
        // "text-remark" => "Ucapan",
        "text-konfirmasi-kehadiran" => "Konfirmasi Kehadiran",
        "text-add-note" => "Add note",
        "text-hadir" => "Hadir",
        "text-tidak-hadir" => "Tidak hadir",
        "text-masih-ragu" => "Masih Ragu",
    );
}



function add_admin_scripts_CUI($hook)
{
    global $wp_version;

    if ( isset( $_GET['page'] ) && $_GET['page'] == 'weddingpress_page_commentkit2') {
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
    wp_register_script('cui_admin_js_script', ADDONS_WEDDINGPRESS3_URL . '/js/cui_admin_script.js', array('jquery'), WDP3_VERSION, true);
    wp_enqueue_script('cui_admin_js_script');
}

function add_scripts_CUI()
{
    //Loading JS using wp_enqueue
    $options = get_option('cui_options');
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
                wp_register_script('jquery', ADDONS_WEDDINGPRESS3_URL . '/js/libs/jquery.min.v1.10.2.js', false, '1.10.2', false);
                break;
        }

        //Añadimos el Script JS Principal
        wp_register_script('cui_js_script', ADDONS_WEDDINGPRESS3_URL . '/js/cui_script.js', array('jquery'), WDP3_VERSION, true);
        wp_enqueue_script('cui_js_script');
        wp_localize_script('cui_js_script', 'CUI_WP',
            array(
                'ajaxurl' => admin_url('admin-ajax.php'),
                'cuiNonce' => wp_create_nonce('cui-nonce'),
                'jpages' => $options['jpages'],
                'jPagesNum' => $options['num_comments_by_page'],
                'textCounter' => $options['text_counter'],
                'textCounterNum' => $options['text_counter_num'],
                'widthWrap' => $options['width_comments'],
                'autoLoad' => $options['auto_load'],
                'thanksComment' => $options['text-thanks-comment'],
                'thanksReplyComment' => $options['text-thanks-reply-comment'],
                'duplicateComment' => $options['text-duplicate-comment'],
                'accept' => $options['text-accept'],
                'cancel' => $options['text-cancel'],
                'reply' => $options['text-reply'],
                'textWriteComment' => $options['text-write-comment'],
                'classPopularComment' => $options['class_popular_comment'],
                'textToDisplay' => $options['text-to-display'],
                'textCharacteresMin' => $options['text-characteres-minimun'],
                'textNavNext' => $options['text-nav-next'],
                'textNavPrev' => $options['text-nav-prev'],
                'textMsgDeleteComment' => $options['text-msg-delete-comment'],
                'textLoadMore' => $options['text-load-more'],
            )
        );

        //Si está activado Paginación de Comentarios
        if ($options['jpages'] == 'true') {
            wp_register_script('cui_jPages', ADDONS_WEDDINGPRESS3_URL . '/js/libs/jquery.jPages.min.js', array('jquery'), '0.7', true);
            wp_enqueue_script('cui_jPages');
        }
        //Si está activado Contador de Caracteres
        if ($options['text_counter'] == 'true') {
            wp_register_script('cui_textCounter', ADDONS_WEDDINGPRESS3_URL . '/js/libs/jquery.textareaCounter.js', array('jquery'), '2.0', true);
            wp_enqueue_script('cui_textCounter');
        }
        //PlaceHolder
        wp_register_script('cui_placeholder', ADDONS_WEDDINGPRESS3_URL . '/js/libs/jquery.placeholder.min.js', array('jquery'), '2.0.7', true);
        wp_enqueue_script('cui_placeholder');
        //Autosize
        wp_register_script('cui_autosize', ADDONS_WEDDINGPRESS3_URL . '/js/libs/autosize.min.js', array('jquery'), '1.14', true);
        wp_enqueue_script('cui_autosize');

    }
}

function add_admin_styles_CUI()
{
    //Loading CSS using wp_enqueue
    if (is_admin()) {
        wp_register_style('cui_admin_style', ADDONS_WEDDINGPRESS3_URL . '/css/cui_admin_style.css', array(), WDP3_VERSION, 'screen');
        wp_enqueue_style('cui_admin_style');
    }
}

function add_styles_CUI()
{
    //Loading CSS using wp_enqueue
    if (!is_admin()) {
        wp_register_style('cui_style', ADDONS_WEDDINGPRESS3_URL . '/css/cui_style.css', array(), WDP3_VERSION, 'screen');
        wp_enqueue_style('cui_style');

        //Custom CSS by Users
        $options = get_option('cui_options');
        $max_width_img = $options['max_width_images'];
        $unit = $options['unit_images_size'];
        ?>
        <style type="text/css">
            .cui-comment-text img {
                max-width: <?php echo $max_width_img.$unit; ?> !important;
            }
        </style>
        <?php
    }
}


function add_custom_styles_CUI()
{
    $options = get_option('cui_options');
//.cui-wrapper ul.cui-container-comments li.cui-item-comment .cui-comment-content
    $custom_css = "
		.cui-wrapper {
		  font-size: {$options['base_font_size']}
		}
	";

    $content_height = isset($options['num_maximum_content_height']) ? esc_attr($options['num_maximum_content_height']) :0;
    $content_height = absint($content_height);
    if ($content_height !==0){
        $custom_css .="
        .cui-wrapper ul.cui-container-comments {
            max-height: {$content_height}px;
            overflow-y:scroll;
        }
        ";
    }

    if ($options['theme'] == 'custom') {
        $custom_css .= "
		.cui-wrapper {
		  background: {$options['css_background_box']};
		}
		.cui-wrapper.cui-border {
		  border: 1px solid {$options['css_border_color']};
		}

		.cui-wrapper .cui-wrap-comments a:link,
		.cui-wrapper .cui-wrap-comments a:visited {
		  color: {$options['css_link_color']};
		}

		.cui-wrapper .cui-wrap-link a.cui-link {
		  color: {$options['css_link_color']};
		}
		.cui-wrapper .cui-wrap-link a.cui-link.cui-icon-link-true .cuio-comment {
		  color: {$options['css_link_color']};
		}
		.cui-wrapper .cui-wrap-link a.cui-link:hover {
		  color: {$options['css_link_color_hover']};
		}
		.cui-wrapper .cui-wrap-link a.cui-link:hover .cuio-comment {
		  color: {$options['css_link_color_hover']};
		}

		.cui-wrapper .cui-wrap-form {
		  border-top: 1px solid {$options['css_border_color']};
		}
		.cui-wrapper .cui-wrap-form .cui-container-form textarea.cui-textarea {
		  border: 1px solid {$options['css_border_color']};
		  background: {$options['css_background_input']};
		  color: {$options['css_text_color']};
		}
		.cui-wrapper .cui-wrap-form .cui-container-form input[type='text'] {
		  border: 1px solid {$options['css_border_color']};
		  background: {$options['css_background_input']};
		  color: {$options['css_text_color']};
		}
		.cui-wrapper .cui-wrap-form .cui-container-form input.cui-input:focus,
		.cui-wrapper .cui-wrap-form .cui-container-form textarea.cui-textarea:focus {
		  border-color: #64B6EC;
		}
		.cui-wrapper .cui-wrap-form .cui-container-form input[type='submit'],
		.cui-wrapper .cui-wrap-form .cui-container-form input[type='button'].cui-form-btn {
		  color: {$options['css_text_color_button']};
		  background: {$options['css_background_button']};
		}
		.cui-wrapper .cui-wrap-form .cui-container-form input[type='submit']:hover,
		.cui-wrapper .cui-wrap-form .cui-container-form input[type='button'].cui-form-btn:hover {
		  background: {$options['css_background_button_hover']};
		}
		.cui-wrapper .cui-wrap-form .cui-container-form .cui-captcha .cui-captcha-text {
		  color: {$options['css_text_color']};
		}

		.cui-wrapper .cui-media-btns a > span {
		  color: {$options['css_link_color']};
		}
		.cui-wrapper .cui-media-btns a > span:hover {
		  color: {$options['css_link_color_hover']};
		}

		.cui-wrapper .cui-comment-status {
		  border-top: 1px solid {$options['css_border_color']};
		}
		.cui-wrapper .cui-comment-status p.cui-ajax-success {
		  color: {$options['css_success_color']};
		}
		.cui-wrapper .cui-comment-status p.cui-ajax-error {
		  color: {$options['css_error_color']};
		}
		.cui-wrapper .cui-comment-status.cui-loading > span {
		  color: {$options['css_link_color']};
		}

		.cui-wrapper ul.cui-container-comments {
		  border-top: 1px solid {$options['css_border_color']};
		}
		.cui-wrapper ul.cui-container-comments li.cui-item-comment {
		  border-bottom: 1px solid {$options['css_border_color']};
		}
		.cui-wrapper ul.cui-container-comments li.cui-item-comment ul li.cui-item-comment {
		  border-top: 1px solid {$options['css_border_color']};
		}
		.cui-wrapper ul.cui-container-comments li.cui-item-comment .cui-comment-content .cui-comment-info a.cui-commenter-name {
		  color: {$options['css_link_color']} !important;
		}
		.cui-wrapper ul.cui-container-comments li.cui-item-comment .cui-comment-content .cui-comment-info a.cui-commenter-name:hover {
		  color: {$options['css_link_color_hover']} !important;
		}
		.cui-wrapper ul.cui-container-comments li.cui-item-comment .cui-comment-content .cui-comment-info .cui-comment-time {
		  color: {$options['css_text_color_secondary']};
		}
		.cui-wrapper ul.cui-container-comments li.cui-item-comment .cui-comment-content .cui-comment-text p {
		  color: {$options['css_text_color']};
		}
		.cui-wrapper ul.cui-container-comments li.cui-item-comment .cui-comment-content .cui-comment-actions a {
		  color: {$options['css_link_color']};
		}
		.cui-wrapper ul.cui-container-comments li.cui-item-comment .cui-comment-content .cui-comment-actions a:hover {
		  color: {$options['css_link_color_hover']};
		}
		.cui-wrapper ul.cui-container-comments li.cui-item-comment .cui-comment-content .cui-comment-rating .cui-rating-link > span {
		  color: {$options['css_rating_color']};
		}
		.cui-wrapper ul.cui-container-comments li.cui-item-comment .cui-comment-content .cui-comment-rating .cui-rating-link > span:hover {
		  color: {$options['css_rating_color_hover']};
		}
		.cui-wrapper ul.cui-container-comments li.cui-item-comment .cui-comment-content .cui-comment-rating .cui-rating-count {
		  color: {$options['css_text_color_secondary']};
		}
		.cui-wrapper ul.cui-container-comments li.cui-item-comment .cui-comment-content .cui-comment-rating .cui-rating-count.cui-rating-positive {
		  color: {$options['css_rating_positive_color']};
		}
		.cui-wrapper ul.cui-container-comments li.cui-item-comment .cui-comment-content .cui-comment-rating .cui-rating-count.cui-rating-negative {
		  color: {$options['css_rating_negative_color']};
		}
		.cui-wrapper ul.cui-container-comments li.cui-item-comment .cui-comment-content .cui-comment-rating .cui-rating-count.cuio-loading {
		  color: {$options['css_rating_color']};
		}
		.cui-wrapper ul.cui-container-comments a.cui-load-more-comments:hover {
		  color: {$options['css_link_color_hover']};
		}

		.cui-wrapper .cui-counter-info {
		  color: {$options['css_text_color_secondary']};
		}

		.cui-wrapper .cui-holder span {
		  color: {$options['css_link_color']};
		}
		.cui-wrapper .cui-holder a,
		.cui-wrapper .cui-holder a:link,
		.cui-wrapper .cui-holder a:visited {
		  color: {$options['css_link_color']};
		}
		.cui-wrapper .cui-holder a:hover,
		.cui-wrapper .cui-holder a:link:hover,
		.cui-wrapper .cui-holder a:visited:hover {
		  color: {$options['css_link_color_hover']};
		}
		.cui-wrapper .cui-holder a.jp-previous.jp-disabled, .cui-wrapper .cui-holder a.jp-previous.jp-disabled:hover, .cui-wrapper .cui-holder a.jp-next.jp-disabled, .cui-wrapper .cui-holder a.jp-next.jp-disabled:hover {
		  color: {$options['css_text_color_secondary']};
		}
		";
    };

    $custom_css .= $options['custom_css'];

    $avatar_size = get_avatar_CUI($options, '', '28')['size'];
    $content_margin_left = $avatar_size + 10;

    $avatar_size2 = $avatar_size - 4;
    $avatar_size3 = $avatar_size2 - 3;

    $avatar_css = "
	.cui-wrapper ul.cui-container-comments li.cui-item-comment .cui-comment-avatar img {
		max-width: {$avatar_size}px;
		max-height: {$avatar_size}px;
	}
	.cui-wrapper ul.cui-container-comments li.cui-item-comment .cui-comment-content {
		margin-left: {$content_margin_left}px;
	}
	.cui-wrapper ul.cui-container-comments li.cui-item-comment ul .cui-comment-avatar img {
		max-width: {$avatar_size2}px;
		max-height: {$avatar_size2}px;
	}
	.cui-wrapper ul.cui-container-comments li.cui-item-comment ul ul .cui-comment-avatar img {
		max-width: {$avatar_size3}px;
		max-height: {$avatar_size3}px;
	}
    .cui_comment_count_card.cui_card-tidak_hadir {
    background-color: {$options['css_tidak_hadir_color']};
    }
    .cui_comment_count_card.cui_card-hadir {
    background-color: {$options['css_hadir_color']};
    }
    .cui_comment_count_card.cui_card-masih_ragu {
    background-color: {$options['css_masih_ragu_color']};
    }
	";

    $custom_css .= $avatar_css;

    wp_add_inline_style('cui_style', $custom_css);
}


function validate_options_CUI($input)
{
    $input['num_comments'] = wp_filter_nohtml_kses($input['num_comments']);
    return $input;
}


function add_options_page_CUI()
{
    
    add_submenu_page(
			'weddingpress', // Parent slug.
			__( 'Comment Kit 2', 'weddingpress' ), // Page title.
			__( 'Comment Kit 2', 'weddingpress' ), // Menu title.
			'manage_options', // Capability.
			'commentkit2', // Menu slug.
			'add_options_form_CUI' // Callback function.
		);

}


function add_options_form_CUI()
{
    include_once('inc/cui-options-page.php');
}


include_once('inc/cui-functions.php');
