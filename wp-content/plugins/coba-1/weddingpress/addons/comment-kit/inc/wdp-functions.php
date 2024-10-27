<?php



/* --------------------------------------------------------------------

   Evitar error en comentarios duplicados

   https://developer.wordpress.org/reference/functions/__return_false/

-------------------------------------------------------------------- */

add_filter('duplicate_comment_id', 'allow_duplicate_comments_WDP');

function allow_duplicate_comments_WDP(){

    $options = get_option( 'wdp_options' );

    if( $options['allow_duplicate_comments'] == 'true' ){

        return false;

    }

    return true;

}



/* --------------------------------------------------------------------

   Función para insertar automaticamente el cuadro de comentarioss

-------------------------------------------------------------------- */

// add_filter( 'the_content', 'auto_show_WDP' );

// function auto_show_WDP( $content ){

//     $options = get_option( 'wdp_options' );

//     $where_add_comments_box = isset( $options['where_add_comments_box'] ) ? $options['where_add_comments_box'] : 'end-content';

//     if( $options['auto_show'] == 'true' && $where_add_comments_box == 'end-content' && should_display_WDP() ){

//         $content = $content . display_wdp();

//     }

//     return $content;

// }



/* --------------------------------------------------------------------

   Vefirica si se debe mostrar el cuadro de comentarioss

-------------------------------------------------------------------- */

function should_display_WDP(){

    global $post;

    $show_wdp = true;



    $options = get_option( 'wdp_options' );



    //Sólo mostrar en estos post/páginas

    if( ! empty( $options['include_pages'] ) ){

        $pages_ids = array_map( 'trim', explode( ',', $options['include_pages'] ) );

        if( is_page( $pages_ids ) || is_single( $pages_ids ) ){

            $show_wdp = true;

        } else{

            $show_wdp = false;

        }

    }



    //Excluir en determinados casos

    if( ! empty( $options['exclude_pages'] ) ){

        $pages_ids = array_map( 'trim', explode( ',', $options['exclude_pages'] ) );

        if( is_page( $pages_ids ) || is_single( $pages_ids ) ){

            $show_wdp = false;

        }

    }



    if( isset( $options['exclude_all_pages'] ) && $options['exclude_all_pages'] == 'true' ){

        if( is_page() ){

            $show_wdp = false;

        }

    }



    //Exclude Page Templates

    $exclude_page_templates = isset( $options['exclude_page_templates'] ) ? (array) $options['exclude_page_templates'] : array();

    $exclude_page_templates = array_filter( $exclude_page_templates );

    if( get_page_template_slug() != '' && in_array( get_page_template_slug(), $exclude_page_templates ) ){

        $show_wdp = false;

    }



    //Exclude Post Types

    $exclude_post_types = isset( $options['exclude_post_types'] ) ? (array) $options['exclude_post_types'] : array();

    $exclude_post_types = array_filter( $exclude_post_types );

    $post_type = isset( $post->ID ) ? get_post_type( $post->ID ) : '';

    if( $post_type && in_array( $post_type, $exclude_post_types ) ){

        $show_wdp = false;

    }



    return $show_wdp;

}





/* --------------------------------------------------------------------

   Función que Inserta el Enlace para Mostrar y Ocultar Comentarios

-------------------------------------------------------------------- */



add_shortcode( 'comment-kit', 'display_wdp' );

add_filter( 'widget_text', 'shortcode_unautop' );

add_filter( 'widget_text', 'do_shortcode', 11 );



function display_wdp( $atts = '' ){

    global $post, $user_ID, $user_email;

    $options = get_option( 'wdp_options' );

    $icon_link = $options['icon-link'];

    $width_comments = (int) $options['width_comments'];

    $only_registered = isset( $options['only_registered'] ) ? $options['only_registered'] : 'false';

    $text_link = 'Show Comments';



    //Shortcode Attributes

    extract( shortcode_atts( array(

        'post_id' => $post->ID,

        'get' => (int) $options['num_comments'],

        'style' => $options['theme'],

        'border' => isset( $options['border'] ) ? $options['border'] : 'true',

        'order' => $options['order_comments'],

        'form' => $options['display_form'],

        'auto_load' => isset( $options['auto_load'] ) ? $options['auto_load'] : 'false',

    ), $atts ) );



    //Excluir en la página de inicio

    $show_wdp = true;

    if( isset( $options['exclude_home'] ) && $options['exclude_home'] == 'true' ){

        if( is_home() || is_front_page() ){

            $show_wdp = false;

        }

    }

    //Verificamos si se debe mostrar

    if( ! $show_wdp ){

        return;

    }



    // $options['text_1_comment'] = "Ucapan";



    // $options['text_0_comments'] = "Ucapan";



    // 'text_more_comments' === "Ucapan";





    $num = get_comments_number( $post_id );//Solo comentarios aprobados



    switch( $num ){

        case 0:

            $text_link = str_replace( '#N#', '<span>' . $num . '</span>', $options['text_0_comments'] );

            $title_link = str_replace( '#N#', $num, $options['text_0_comments'] );

            break;

        case 1:

            $text_link = str_replace( '#N#', '<span>' . $num . '</span>', $options['text_1_comment'] );

            $title_link = str_replace( '#N#', $num, $options['text_1_comment'] );

            break;

        default:

            $text_link = str_replace( '#N#', '<span>' . $num . '</span>', $options['text_more_comments'] );

            $title_link = str_replace( '#N#', $num, $options['text_1_comment'] );

            break;

    }



    $class_wrap = "wdp-wrapper wdp-{$style}";

    if( ! comments_open( $post_id ) ){

        $class_wrap .= " wdp-comments-closed";

    }

    $data = "<div class='$class_wrap";

    if( $border == 'true' ) $data .= " wdp-border";

    $data .= "' style='overflow: hidden;";

    if( $width_comments ) $data .= " width: {$width_comments}px; ";

    $data .= "'>";



    // ENLACE DE MOSTRAR COMENTARIOS

    $data .= "<div class='wdp-wrap-link'>";

    $data .= "<a id='wdp-link-{$post_id}' class='wdp-link wdp-icon-link wdp-icon-link-{$icon_link} auto-load-{$auto_load}' href='?post_id={$post_id}&amp;comments={$num}&amp;get={$get}&amp;order={$order}' title='{$title_link}'><i aria-hidden='true' class='fas fa-dove'> </i> {$text_link}</a>";

    $data .= "</div><!--.wdp-wrap-link-->";



    // CONTENEDOR DE LOS COMENTARIOS

    $data .= "<div id='wdp-wrap-commnent-{$post_id}' class='wdp-wrap-comments' style='display:none;'>";

    if( post_password_required() ){

        $data .= '<p style="padding: 8px 15px;">This post is password protected. Enter the password to view comments</p>';

    } else{

        if( $form == 'true' && user_can_comment_WDP() ){

            $data .= "<div id='wdp-wrap-form-{$post_id}' class='wdp-wrap-form wdp-clearfix'>";

            // $data .= "<div class='wdp-form-avatar'>";

            // $data .= get_avatar_WDP( $options, $user_email, '28' )['image'];

            // $data .= "</div>";

            $data .= "<div id='wdp-container-form-{$post_id}' class='wdp-container-form";

            if( ! is_user_logged_in() )

                $data .= " wdp-no-login";

            $data .= "'>";



            if( $only_registered == 'true' && ! is_user_logged_in() ){

                $data .= "<p>{$options['text_only_registered']} " . sprintf( __( $options['text-login-to-comment'], 'WDP' ), "<a href='" . wp_login_url( get_permalink() ) . "'>", "</a>" ) . "</p>";

            } else if( ! comments_open( $post_id ) ){

                $data .= "<p>{$options['text-comments-closed']}</p>";

            } else{

                //Formulario

                $data .= get_comment_form_WDP( $post_id );

            }

            $data .= "</div><!--.wdp-container-form-->";

            $data .= "</div><!--.wdp-wrap-form-->";



        } // end if comments_open

        $data .= "<div id='wdp-comment-status-{$post_id}'  class='wdp-comment-status'></div>";



        $class_container = "wdp-container-comments wdp-order-$order ";

        if( $num > 1 ){//si hay más de 1 comentario

            $class_container .= " wdp-has-$num-comments wdp-multiple-comments";

            $total_likes = get_total_comment_likes_by_posts_WDP( $post_id );

            if( $total_likes >= 1 ){

                $class_container .= " wdp-has-likes";

            }

        }

        $data .= "<ul id='wdp-container-comment-{$post_id}' class='$class_container' data-order='$order'></ul>";

        $data .= "<div class='wdp-holder-{$post_id} wdp-holder'></div>";



    } // end if post_password_required



    $data .= "</div><!--.wdp-wrap-comments-->";



    $data .= "</div><!--.wdp-wrapper-->";





    return $data;

}



/* --------------------------------------------------------------------

  Obtiene el total de likes de todos los comentarios de un post

-------------------------------------------------------------------- */

function get_total_comment_likes_by_posts_WDP( $post_id = 0 ){

    $all_comments = get_comments( array( 'post_id' => $post_id ) );

    $total = 0;

    foreach( $all_comments as $comment ){

        if( ! $comment->comment_parent ){

            $likes_count = (int) get_comment_meta( $comment->comment_ID, 'wdp-likes_count', true );

            $total += $likes_count;

        }

    }

    return $total;

}



/* --------------------------------------------------------------------

  Comprueba si un usuario puede realizar comentarios

-------------------------------------------------------------------- */

function user_can_comment_WDP(){

    $options = get_option( 'wdp_options' );

    if( ! empty( $options['exclude_users'] ) ){

        $users_ids = explode( ',', $options['exclude_users'] );

        if( in_array( get_current_user_id(), $users_ids ) ){

            return false;

        }

    }

    return true;

}





/* --------------------------------------------------------------------

   Función para extraer el formulario de comentarios

-------------------------------------------------------------------- */

function get_comment_form_WDP( $post_id = null ){

    global $id;

    if( null === $post_id )

        $post_id = $id;

    else

        $id = $post_id;

    $options = get_option( 'wdp_options' );

    $num_fields = 1;

    $display = isset( $options['comment_by_name']) ? $options['comment_by_name'] : 'false';

    $konfirmasi_kehadiran = isset( $options['confirm_attendance']) ? $options['confirm_attendance'] : 'false';

    // isset( $options['only_registered'] ) ? $options['only_registered'] : 'false';

    if ( $display == 'false' ) :

            $plugin_fields = array(
                    'author' => '<p class="comment-form-author wdp-field-' . $num_fields . '"><input id="author" name="author" type="text" aria-required="true" class="wdp-input" placeholder="Nama Anda" /><span class="wdp-required">*</span><span class="wdp-error-info wdp-error-info-name">Mohon maaf! Khusus untuk tamu undangan</span></p>',
            );
            
    else :

            $plugin_fields = array(
                'author' => '<p class="comment-form-author wdp-field-' . $num_fields . '"><input id="author" name="author" type="text" aria-required="true" class="wdp-input" placeholder="Nama Anda" value="'. $_GET['to'] .'" required nofocus readonly="readonly" /><span class="wdp-required">*</span><span class="wdp-error-info wdp-error-info-name">Mohon maaf! Khusus untuk tamu undangan</span></p>',
            );
    endif;

    


    $fields = array();

    $fields = wp_parse_args( $plugin_fields, $fields  );



    if ( $konfirmasi_kehadiran == 'false' ) :

        $args = array(

        'title_reply' => '',

        'comment_notes_before' => '',

        'comment_notes_after' => '',

        'logged_in_as' => '',

        'id_form' => 'commentform-' . $post_id,

        'id_submit' => 'submit-' . $post_id,

        'label_submit' => ! empty( $options["text-send"] ) ? $options["text-send"] : 'Send',

        // 'comment_placeholder' => ! empty( $options["text-comment-placeholder"] ) ? $options["text-comment-placeholder"] : 'Berikan Ucapan & Doa untuk Kedua Mempelai',

        'fields' => $fields,

        'comment_field' => '<div class="wdp-wrap-textarea"><textarea id="wdp-textarea-' . $post_id . '" class="waci_comment wdp-textarea autosize-textarea" name="comment" aria-required="true" placeholder="' . $options['text-comment-placeholder'] . '" rows="3"></textarea><span class="wdp-required">*</span><span class="wdp-error-info wdp-error-info-text">' . $options['text-characteres-minimun'] . '.</span></div>

        <div class="wdp-wrap-select"><select class="waci_comment wdp-select" name="konfirmasi"><option value="" disabled selected>Konfirmasi Kehadiran</option>></option><option value="Hadir">Hadir</option><option value="Tidak Hadir">Tidak Hadir</option></select><span class="wdp-required">*</span><span class="wdp-error-info wdp-error-info-confirm">Silahkan pilih konfirmasi kehadiran</span></div>'

    );
    else :

            $args = array(

        'title_reply' => '',

        'comment_notes_before' => '',

        'comment_notes_after' => '',

        'logged_in_as' => '',

        'id_form' => 'commentform-' . $post_id,

        'id_submit' => 'submit-' . $post_id,

        'label_submit' => ! empty( $options["text-send"] ) ? $options["text-send"] : 'Send',

        // 'comment_placeholder' => ! empty( $options["text-comment-placeholder"] ) ? $options["text-comment-placeholder"] : 'Berikan Ucapan & Doa untuk Kedua Mempelai',

        'fields' => $fields,

        'comment_field' => '<div class="wdp-wrap-textarea"><textarea id="wdp-textarea-' . $post_id . '" class="waci_comment wdp-textarea autosize-textarea" name="comment" aria-required="true" placeholder="' . $options['text-comment-placeholder'] . '" rows="3"></textarea><span class="wdp-required">*</span><span class="wdp-error-info wdp-error-info-text">' . $options['text-characteres-minimun'] . '.</span></div>

        <div class="wdp-wrap-select"><select class="waci_comment wdp-select" name="konfirmasi" required><option value="" disabled selected>Konfirmasi Kehadiran</option>></option><option value="Hadir">Hadir</option><option value="Tidak Hadir">Tidak Hadir</option></select><span class="wdp-required">*</span><span class="wdp-error-info wdp-error-info-confirm">Silahkan pilih konfirmasi kehadiran</span></div>'

        );
    endif;



    $form = "";

    $form = "<div id='respond-{$post_id}' class='respond wdp-clearfix'>";

    $form .= "<form action='" . site_url( '/wp-comments-post.php' ) . "' method='post' id='" . $args['id_form'] . "'>";

    

        foreach( $args['fields'] as $name => $field ){

            

                $form .= apply_filters( "comment_form_field_{$name}", $field );

            

        }

    

    $form .= $args['comment_field'];



    //Google reCAPTCHA

    // $form .= adicional_form_fields_WDP();



    $form .= "<div class='wdp-wrap-submit wdp-clearfix'>";

    // $form .= $media_btns;





    $submit_field = "<p class='form-submit'>";

    //Prueba para evitar Spam

    $submit_field .= '<span class="wdp-hide">' . __( "Do not change these fields following", "WDP" ) . '</span><input type="text" class="wdp-hide" name="name" value="username"><input type="text" class="wdp-hide" name="nombre" value=""><input type="text" class="wdp-hide" name="form-wdp" value="">';



    $submit_field .= '<input type="button" class="wdp-form-btn wdp-cancel-btn" value="Batal">';

    // $submit_field .= '<input type="button" class="wdp-form-btn wdp-edit-btn" value="Edit">';



    $submit_field .= "<input name='submit' id='" . $args['id_submit'] . "' value='" . $args['label_submit'] . "' type='submit' />";

    $submit_field .= "<input type='hidden' name='commentpress' value='true' />";

    $submit_field .= get_comment_id_fields( $post_id );

    $submit_field .= "</p>";



    $form .= apply_filters( 'comment_form_submit_field', $submit_field, $args );

    $form .= "</div>";//wdp-wrap-submit



    //    ob_start();

//    wp_comment_form_unfiltered_html_nonce();

//    $form .= ob_get_contents();

//    ob_get_clean();



    $form .= "</form>";

    $form .= "</div>";

    return $form;

}



/* --------------------------------------------------------------------

   Adicional form fields

-------------------------------------------------------------------- */

// function adicional_form_fields_WDP(){

//     $return = '';

//     //Google Captcha (reCAPTCHA) by BestWebSoft

//     $use_grecaptcha = true;//Agregar una opción en la página de opciones

//     if( $use_grecaptcha ){

//         $commenter = wp_get_current_commenter();

//         $user = wp_get_current_user();

//         $user_identity = $user->exists() ? $user->display_name : '';

//         ob_start();

//         if ( is_user_logged_in() ){

//             do_action( 'comment_form_logged_in_after', $commenter, $user_identity );

//         } else {

//             do_action( 'comment_form_after_fields' );

//         }

//         $return .= ob_get_contents();

//         ob_end_clean();

//     }

//     return $return;

// }





/* --------------------------------------------------------------------

   Función que obtiene Comentarios

-------------------------------------------------------------------- */

add_action( 'wp_ajax_get_comments', 'get_comments_WDP' );

add_action( 'wp_ajax_nopriv_get_comments', 'get_comments_WDP' );



function get_comments_WDP(){

    global $post, $id;

    $nonce = $_POST['nonce'];

    if( ! wp_verify_nonce( $nonce, 'wdp-nonce' ) ){

        die ( 'Busted!' );

    }

    $options = get_option( 'wdp_options' );

    $post_id = (int) isset( $_POST['post_id'] ) ? $_POST['post_id'] : $post->ID;

    $get = (int) isset( $_POST['get'] ) ? $_POST['get'] : $options['num_comments'];

    $post = get_post( $post_id );

    $numComments = $post->comment_count;

    $authordata = get_userdata( $post->post_author );

    $orderComments = isset( $_POST['order'] ) ? $_POST['order'] : $options['order_comments'];

    $default_order = get_option( 'comment_order' );





    if( $orderComments == 'likes' || $orderComments == 'LIKES' ){

        //Asignamos Campo Personalizado 'wdp-likes_count' a todos los comentarios

        foreach( get_comments( 'post_id=' . $post_id ) as $comment ){

            $comment_id = $comment->comment_ID;

            $likes_count = get_comment_meta( $comment_id, 'wdp-likes_count', true );

            update_comment_meta( $comment_id, 'wdp-likes_count', $likes_count );

        }

        $comments_args = array(

            'post_id' => $post_id,

            'number' => $get,//Número Máximo de Comentarios a Cargar

            'meta_key' => 'wdp-likes_count',

            'order' => 'DESC',//Orden de los Comentarios

            'orderby' => 'meta_value_num',

            'status' => 'approve',//Solo Comentarios Aprobados

        );

    } else{

        $offset = 0;



        $comments_args = array(

            'post_id' => $post_id,

            'number' => $get,//Número Máximo de Comentarios a Cargar

            'order' => $orderComments,//Orden de los Comentarios

            'orderby' => 'comment_date',//Orden de los Comentarios

            'offset' => $offset,//Desplazamiento desde el último comentario

            'status' => 'approve',//Solo Comentarios Aprobados

        );

    }



    $comments = get_comments( $comments_args );



    //ob_start(); // Activa almacenamiento en bufer



    //Display the list of comments

    $comments_depth = get_option( 'thread_comments_depth' );

    wp_list_comments( array( 'callback' => 'get_comment_HTML_WDP', 'max_depth' => $comments_depth ), $comments );



    // Obtiene el contenido del búfer actual y elimina el búfer de salida actual.



    //$listComment =  ob_get_clean();



    //echo $listComment;



    die(); // this is required to return a proper result



}





/* --------------------------------------------------------------------

  Función desencadenada inmediatamente después de insertar un comentario

-------------------------------------------------------------------- */

add_action( 'comment_post', 'ajax_comment_WDP', 120, 2 );

function ajax_comment_WDP( $comment_ID, $comment_status ){

    // Si el comentario se ejecutó con AJAX

    if( ! empty( $_SERVER['HTTP_X_REQUESTED_WITH'] ) && strtolower( $_SERVER['HTTP_X_REQUESTED_WITH'] ) == 'xmlhttprequest' ){

        //Comprobamos el estado del comentario

        switch( $comment_status ){

            //Si el comentario no está aprobado 'hold = 0'

            case "0":

                //Notificamos al moderador

                if( get_option( 'comments_notify' ) == 1 ){

                    wp_notify_moderator( $comment_ID );

                }



            //Si el comentario está aprobado 'approved = 1'

            case "1":



                //Notificamos al autor del post de un nuevo comentario

                //get_option('moderation_notify');

                if( get_option( 'comments_notify' ) == 1 ){

                    wp_notify_postauthor( $comment_ID );

                }



                // Obtenemos los datos del comentario

                $comment = get_comment( $comment_ID );

                //Obtenemos HTML del nuevo comentario

                //ob_start(); // Activa almacenamiento en bufer

                $args = array();

                $depth = 0;//nivel de comentario



                get_comment_HTML_WDP( $comment, $args, $depth );

                //$commentData =  ob_get_clean();// Obtiene el contenido del búfer actual y elimina el búfer de salida actual.



                //echo $commentData;

                break;

            default:

                echo "error";

        }

        exit;

    }

}



/* --------------------------------------------------------------------

   Función que extrae HTML de un Comentario

-------------------------------------------------------------------- */

function get_comment_HTML_WDP( $comment, $args, $depth ){



    $GLOBALS['comment'] = $comment;

    extract( $args, EXTR_SKIP );



    $commentPostID = $comment->comment_post_ID;

    $comment_id = $comment->comment_ID;

    //$commentContent = $comment->comment_content;

    //$commentContent = apply_filters('comment_text', $commentContent);

    $comment_date = $comment->comment_date;

    $autor_id = $comment->user_id;

    $autor_email = $comment->comment_author_email;

    $autor_name = $comment->comment_author;

    $autor_url = $comment->comment_author_url;

    $autor_url = comment_author_url_WDP( $autor_name, $autor_id, $autor_url );

    $autor_info = get_userdata( $autor_id );

    // if( is_object( $autor_info ) ){

    //     $autor_name = $autor_info->display_name;

    // }

    $current_user = wp_get_current_user();



    $options = get_option( 'wdp_options' );

    $date_format = $options['date_format'];

    $rating_btns = $options['display_rating_btns'];

    $comments_depth = get_option( 'thread_comments_depth' );

    $post = get_post( $commentPostID );

    $likes_count = (int) get_comment_meta( $comment->comment_ID, 'wdp-likes_count', true );

    $only_registered = isset( $options['only_registered'] ) ? $options['only_registered'] : 'false';

    $atendence = get_comment_meta($comment_id,'konfirmasi',true);

    $disable_reply = isset( $options['disable_reply'] ) ? $options['disable_reply'] : 'false';

    // $disable_roles = isset( $options['disable_roles_reply_comments'] ) ? (array) $options['disable_roles_reply_comments'] : array();

    // $role = 'anonymous';

    if( is_user_logged_in() ){

        $user = wp_get_current_user();

        $role = $user->roles ? $user->roles[0] : false;

    }

    // if( in_array( $role, $disable_roles ) ){

    //     $disable_reply = 'true';

    // }



    ?>

    <li <?php comment_class( 'wdp-item-comment' ); ?> id="wdp-item-comment-<?php echo $comment_id; ?>"  data-likes="<?php echo $likes_count; ?>">

    <div id="wdp-comment-<?php echo $comment_id; ?>" class="wdp-comment wdp-clearfix">



        <div class="wdp-comment-avatar">

            <?php echo get_avatar_WDP( $options, $autor_email, '28' )['image']; ?>

        </div><!--.wdp-comment-avatar-->



        <div class="wdp-comment-content">

            <div class="wdp-comment-info">

                <?php

                // if( ! empty( $autor_url ) ){

                //     echo "<a href='$autor_url' class='wdp-commenter-name' title='$autor_name'>$autor_name</a>";

                // } else {

                    echo "<a class='wdp-commenter-name' title='$autor_name'>$autor_name</a>";

                // }

                ?>



                <?php

                    echo "<span class=wdp-post-author><i class='fas fa-check-circle'></i> ".$atendence."</span>";

                ?>

                <br>

                <span class="wdp-comment-time">

                <i class="far fa-clock"></i>

          	<?php echo get_time_since_WDP( $comment_date ); ?>

          </span>

            </div><!--.wdp-comment-info-->

            <div class="wdp-comment-text">

                <?php //comment_text();//Elimina videos(iframe)

                ?>

                <?php echo my_get_comment_text( $comment_id ); ?>

            </div><!--.wdp-comment-text-->



            <div class="wdp-comment-actions">
                <?php
                if( $depth < $comments_depth && $disable_reply == 'false' ){ ?>
                    <a href="?comment_id=<?php echo $comment_id; ?>&amp;post_id=<?php echo $commentPostID; ?>"
                       class="wdp-reply-link"
                       id="wdp-reply-link-<?php echo $comment_id; ?>"><?php echo $options["text-reply"] ?></a>
                <?php }
                ?>


                <?php

                if( user_can_moderate_WDP( $comment_id ) && show_comment_actions_WDP( $comment_id ) ){ ?>

                    <a href="?comment_id=<?php echo $comment_id; ?>&amp;post_id=<?php echo $commentPostID; ?>"

                       class="wdp-edit-link"

                       id="wdp-edit-link-<?php echo $comment_id; ?>"><?php echo $options["text-edit"]; ?></a>

                    <a href="?comment_id=<?php echo $comment_id; ?>&amp;post_id=<?php echo $commentPostID; ?>"

                       class="wdp-delete-link"

                       id="wdp-delete-link-<?php echo $comment_id; ?>"><?php echo $options["text-delete"]; ?></a>

                <?php }

                ?>

            </div><!--.wdp-comment-actions-->



            <?php

            // $only_loggedin_can_rate = isset( $options['only_loggedin_can_rate'] ) ? $options['only_loggedin_can_rate'] : 'false';

            // if( $rating_btns == 'true' && ( $only_loggedin_can_rate == 'false' || $only_loggedin_can_rate == 'true' && is_user_logged_in() ) ){

            //     comment_rating_content_WDP( $comment_id );

            // }

            ?>

        </div><!--.wdp-comment-content-->

    </div><!--.wdp-comment-->

    <!--</li>-->

    <?php

}





/* --------------------------------------------------------------------

   Función que obtiene el texto de un comentario

-------------------------------------------------------------------- */

add_action( 'wp_ajax_get_comment_text_wdp', 'get_comment_text_WDP' );

add_action( 'wp_ajax_nopriv_get_comment_text_wdp', 'get_comment_text_WDP' );



function get_comment_text_WDP(){

    global $post, $id;

    $nonce = $_POST['nonce'];

    $post_id = absint( $_POST['post_id'] );

    $comment_id = absint( $_POST['comment_id'] );

    if( ! empty( $nonce ) && ! wp_verify_nonce( $nonce, 'wdp-nonce' ) ){

        die ( 'Busted!' );

    }

    if( ! empty( $comment_id ) ){

        $comment = get_comment( $comment_id );

        if( user_can_moderate_WDP( $comment_id ) ){

            echo get_comment_text( $comment_id );

        } else{

            echo 'wdp-error';

        }

    } else{

        echo 'wdp-error';

    }

    die(); // this is required to return a proper result

}


/* --------------------------------------------------------------------

   Función que elimina un comentario

-------------------------------------------------------------------- */

add_action( 'wp_ajax_delete_comment_wdp', 'delete_comment_WDP' );

add_action( 'wp_ajax_nopriv_delete_comment_wdp', 'delete_comment_WDP' );



function delete_comment_WDP(){

    global $post, $id;

    $nonce = $_POST['nonce'];

    $post_id = absint( $_POST['post_id'] );

    $comment_id = absint( $_POST['comment_id'] );

    if( ! empty( $nonce ) && ! wp_verify_nonce( $nonce, 'wdp-nonce' ) ){

        die ( 'Busted!' );

    }

    if( ! empty( $comment_id ) ){

        $comment = get_comment( $comment_id );

        if( user_can_moderate_WDP( $comment_id ) ){

            wp_delete_comment( $comment_id );

            die( 'ok' );

        }

    }

    die( 'wdp-error' ); // this is required to return a proper result

}



/* --------------------------------------------------------------------

   Función que obtiene el texto de un comentario

-------------------------------------------------------------------- */

add_action( 'wp_ajax_edit_comment_wdp', 'edit_comment_WDP' );

add_action( 'wp_ajax_nopriv_edit_comment_wdp', 'edit_comment_WDP' );



function edit_comment_WDP(){

    $nonce = $_POST['nonce'];

    $comment_content = trim( $_POST['comment_content'] );

    $post_id = absint( $_POST['post_id'] );

    $comment_id = absint( $_POST['comment_id'] );



    $result = array();

    $result['ok'] = true;



    if( ! empty( $nonce ) && ! wp_verify_nonce( $nonce, 'wdp-nonce' ) ){

        $result['ok'] = false;

        $result['error'] = 'nonce';

        die ( json_encode( $result ) );

    }



    if( ! user_can_moderate_WDP( $comment_id ) ){

        $result['ok'] = false;

        $result['error'] = 'can_edit';

        die ( json_encode( $result ) );

    }

    if( empty( $comment_content ) || $comment_content == 'undefined' ){

        $result['ok'] = false;

        $result['error'] = 'comment_empty';

        die ( json_encode( $result ) );

    }



    //Get original comment

    $comment = get_comment( $comment_id, ARRAY_A );

    $comment['comment_content'] = $comment_content;



    //Save the comment

    wp_update_comment( $comment );



    // ob_start();

    // comment_text($comment_id);

    // $result['comment_text'] = ob_get_contents();

    // ob_end_clean();



    $result['comment_text'] = my_get_comment_text( $comment_id );



    die( json_encode( $result ) );

}



/* --------------------------------------------------------------------

   Función que extrae el contenido de un comentario

-------------------------------------------------------------------- */

function my_get_comment_text( $comment_id ){

    global $wpdb;

    //$_comment = $wpdb->get_results("SELECT * FROM $wpdb->comments WHERE comment_ID = " .$comment_id );

    //$comment_content = $_comment[0]->comment_content;

    //$_comment = $wpdb->get_row("SELECT * FROM $wpdb->comments WHERE comment_ID = ".$comment_id);

    //$comment_content = $_comment->comment_content;

    $comment_content = $wpdb->get_var( "SELECT comment_content FROM $wpdb->comments WHERE comment_ID = " . $comment_id );



    $comment_content = wptexturize( $comment_content );

    $comment_content = nl2br( $comment_content ); //Inserta saltos de línea al final de un string

    $comment_content = convert_chars( $comment_content ); //Traduce referencias Unicode no válidos a válidos

    $comment_content = make_clickable( $comment_content ); //Hace clickeable los enlaces

    $comment_content = convert_smilies( $comment_content ); //Conserva las caritas

    $comment_content = force_balance_tags( $comment_content ); //Equilibra etiquetas faltantes o mal cerradas

    $comment_content = wpautop( $comment_content ); //Cambia dobles saltos de línea en párrafos

    $comment_content = do_shortcode( $comment_content ); //Shortcodes



    return $comment_content;

}





/* --------------------------------------------------------------------

   Función para verificar si el usuario actual puede editar un comentario

-------------------------------------------------------------------- */

function user_can_moderate_WDP( $comment_id ){

    $comment = get_comment( $comment_id );

    $current_user = wp_get_current_user();

    if( ! is_user_logged_in() ){

        return false;

    }

    if( ! current_user_can( 'moderate_comments' ) && $current_user->ID != $comment->user_id ){

        return false;

    }

    return true;

}



/* --------------------------------------------------------------------

   Comprueba si puede editar/eliminar comentario

-------------------------------------------------------------------- */

function show_comment_actions_WDP( $comment_id ){

    $comment = get_comment( $comment_id );

    $options = get_option( 'wdp_options' );

    $now = strtotime( current_time( 'mysql' ) );

    $comment_date = strtotime( $comment->comment_date );

    $max_hours = $options['disable_actions_after_time'];

    $hours = ( $now - $comment_date ) / 3600;//hours



    if( ! user_can_moderate_WDP( $comment_id ) ){

        return false;

    }

    if( is_numeric( $max_hours ) ){

        return $hours < floatval( $max_hours );

    }

    return true;

}





/* --------------------------------------------------------------------

   Función que elimina el formulario de comentarios por defecto

-------------------------------------------------------------------- */

// function remove_wp_commet_form_WDP( $comment_template ){

//     $options = get_option( 'wdp_options' );

//     $remove_default = isset( $options['remove_default_comments'] ) ? $options['remove_default_comments'] : 'true';



//     if( $options['auto_show'] == 'true' && $options['where_add_comments_box'] == 'same-place' && should_display_WDP() ){

//         echo display_wdp();

//     }

//     if( $remove_default == 'true' ){

//         return WDP_PATH . '/inc/wdp-comments-template.php';

//     }

// }



// add_filter( "comments_template", "remove_wp_commet_form_WDP" );



/* --------------------------------------------------------------------

   Función que retorna el link que un usuario escribió en los comentarios

-------------------------------------------------------------------- */

function comment_author_url_WDP( $autor_name, $autor_id, $autor_url = '' ){

    global $current_user;

    if( ! $current_user || ! $current_user->ID ){

        $current_user = wp_get_current_user();

    }



    $user_link = $autor_url;

    if( function_exists( 'um_user_profile_url' ) && $autor_id != 0 ){

        $user_link = um_user_profile_url( $autor_id );

    }

    return $user_link;

}



/* --------------------------------------------------------------------

   Función para evitar Spam

-------------------------------------------------------------------- */

// add_action( 'pre_comment_on_post', 'remove_spam_WDP' );

// function remove_spam_WDP( $comment_post_ID ){

//     // Si el comentario se ha enviado desde este plugin

//     if( isset( $_POST['form-wdp'] ) ){

//         // Si los campos ocultos no se han modificado

//         if( $_POST['name'] != 'username' || $_POST['nombre'] != '' ){

//             wp_die( __( '<strong>ERROR</strong>: Your comment has been detected as Spam!' ) );

//         }

//     }

// }



/* --------------------------------------------------------------------

   Función que Verifica si una URL de un video de YouTube o Vimeo es válido y retorna el Video

-------------------------------------------------------------------- */



add_action( 'wp_ajax_verificar_video_WDP', 'verificar_video_WDP' );

add_action( 'wp_ajax_nopriv_verificar_video_WDP', 'verificar_video_WDP' );



function verificar_video_WDP(){

    if( isset( $_POST['url_video'] ) && trim( $_POST['url_video'] ) != '' ){

        $video_player = '';

        $post_url_video = trim( $_POST['url_video'] );

        $tipo_video = get_tipo_video_WDP( $post_url_video );

        $id_video = get_id_video_WDP( $post_url_video, $tipo_video );

        if( $id_video != 'error url' && $id_video != 'error url youtube' && $id_video != 'error url vimeo' ){

            $video_player = get_embed_video_WDP( $id_video, $tipo_video, 560, 315 );

        } else{

            $id_video = 'error id video';

        }

    } else{

        $post_url_video = '';

    }

    /* Si no hay URL o la URL es inválida */

    if( $post_url_video == '' || $id_video == 'error id video' ){

        $response = 'error';

    } else{

        $response = '<div class="wdp-embed" data-embed-id="' . $id_video . '">' . $video_player . '</div>';

        $embed_shortcode = '[embed_commentpress type="' . $tipo_video . '" id="' . $id_video . '"]';

        $response .= "<input type='hidden' value='$embed_shortcode'>";

    }

    echo $response;

    exit;

}



/*

|---------------------------------------------------------------------------------------------------

| Build embed shortcode

|---------------------------------------------------------------------------------------------------

*/

add_shortcode( 'embed_commentpress', 'build_embed_commentpress_WDP' );

function build_embed_commentpress_WDP( $atts = array(), $content = null ){

    $atts = shortcode_atts( array(

        'type' => 'youtube',

        'id' => '0',

    ), $atts );



    $tipo_video = $atts['type'];

    $id_video = $atts['id'];

    $video_player = false;

    if( $id_video && ( $tipo_video == 'youtube' || $tipo_video == 'vimeo' ) ){

        $video_player = get_embed_video_WDP( $id_video, $tipo_video, 560, 315 );

    }



    $return = '';

    if( $video_player ){

        $return = '<div class="wdp-wrap-video wdp-video-' . $tipo_video . ' wdp-embed-shortcode" data-embed-id="' . $id_video . '">';

        $return .= $video_player;

        $return .= '</div>';

    }

    return $return;

}



/* --------------------------------------------------------------------

   Función que Devuelve el Tipo de Video desde una URL

-------------------------------------------------------------------- */

function get_tipo_video_WDP( $url_video ){

    $is_youtube_url = '/^(?:https?:\/\/)?(?:www\.)?(youtube\.com\/|youtu\.be\/)/';

    $is_vimeo_url = '/^(?:https?:\/\/)?(?:www\.)?(vimeo\.com\/)/';

    if( preg_match( $is_youtube_url, $url_video ) ){

        return "youtube";

    } else if( preg_match( $is_vimeo_url, $url_video ) ){

        return "vimeo";

    } else{

        return "desconocido";

    }

}



/* --------------------------------------------------------------------

   Función que Devuelve el Id de un Video de YouTube o Vimeo

-------------------------------------------------------------------- */

function get_id_video_WDP( $url_video, $tipo_video ){

    $id_video = '';

    $filter_youtube = '/^.*(youtu.be\/|v\/|\/u\/\w\/|embed\/|watch\?)\??v?=?([^#\&\?]*).*/';

    $filter_vimeo = '/^.*(vimeo\.com\/|groups\/[A-z]+\/videos\/|channels\/staffpicks\/)(\d+)$/';

    switch( $tipo_video ){

        case "youtube":

            $is_valid_url = preg_match( $filter_youtube, $url_video, $url_array );

            if( $is_valid_url && strlen( $url_array[2] ) == 11 ){

                $id_video = $url_array[2];

                return $id_video;

            } else{

                return "error url youtube";

            }

            break;

        case "vimeo":

            $is_valid_url = preg_match( $filter_vimeo, $url_video, $url_array );

            if( $is_valid_url ){

                $id_video = $url_array[2];

                return $id_video;

            } else{

                return "error url vimeo";

            }

            break;

        default:

            return "error url";

            break;

    }

}



/* --------------------------------------------------------------------

   Función que Retorna el Reproductor de un Video de Youtube o Vimeo

-------------------------------------------------------------------- */

function get_embed_video_WDP( $id_video, $tipo_video, $width = 610, $height = 280, $autoplay = 0 ){

    $video_player = '';

    if( $tipo_video == 'youtube' ){

        $video_player = '<iframe class="ytplayer" type="text/html" width="' . $width . '" height="' . $height . '" src="//www.youtube.com/embed/' . $id_video . '?autoplay=' . $autoplay . '" allowfullscreen frameborder="0">

</iframe>';

    } elseif( $tipo_video == 'vimeo' ){

        $video_player = '<iframe width="' . $width . '" height="' . $height . '"  src="//player.vimeo.com/video/' . $id_video . '?title=0&amp;autoplay=' . $autoplay . '&amp;byline=0&amp;portrait=0&amp;color=3D95D3" frameborder="0" webkitAllowFullScreen allowFullScreen></iframe>';



    }

    return $video_player;

}



/* --------------------------------------------------------------------

   Función que evita iframe, embed, object al insertar un comentario. Evita ataques XSS.

-------------------------------------------------------------------- */

add_filter('preprocess_comment', 'remove_embed_and_iframe_from_comment_WDP');

function remove_embed_and_iframe_from_comment_WDP($commentdata){

    //Solo filtrar si el comentario se inserta con el plugin

    if( $_POST['comment_press'] || $_POST['commentpress'] ){

        $comment_content = $commentdata['comment_content'];

        $comment_content = htmlspecialchars_decode($comment_content);

        $comment_content = preg_replace('/(<iframe.*?\/iframe>)|(<object.*?\/object>)|(<embed.*?\/embed>)|(<iframe.*?>)|(<embed.*?>)|(<object.*?>)|(alert\s?\(.*\))/i','', $comment_content);

        $comment_content = str_replace(array('<!-->', '">>-->', '-->">', '">-->'),'', $comment_content);

        $commentdata['comment_content'] = $comment_content;

    }

    return $commentdata;

}



/* --------------------------------------------------------------------

   Función que permite más tags HTML en los comentarios

-------------------------------------------------------------------- */

add_action( 'init', 'more_tags_html_WDP', 11 );

function more_tags_html_WDP(){

    global $allowedtags;

//    $allowedtags["p"] = array();

    //Importante para que se agreguen las imágenes

    $allowedtags["img"] = array(

        "src" => array(),

        "height" => array(),

        "width" => array(),

        "alt" => array(),

        "title" => array(),

    );


}



/* --------------------------------------------------------------------

   Contenido para Calificar Comentarios

-------------------------------------------------------------------- */

function comment_rating_content_WDP( $comment_id = 0 ){

    $options = get_option( 'wdp_options' );

    $likes_count = (int) get_comment_meta( $comment_id, 'wdp-likes_count', true );

    $likes_class = 'wdp-rating-neutral';



    if( $likes_count < 0 ){

        $likes_class = 'wdp-rating-negative';

    } else if( $likes_count > 0 ){

        $likes_class = 'wdp-rating-positive';

    }

    ?>

    <div class="wdp-comment-rating">

        <a class="wdp-rating-link wdp-rating-like" href="?comment_id=<?php echo $comment_id; ?>&amp;method=like"

           title="<?php echo $options["text-like"]; ?>"><span class="wdpo-thumb_up"></a>

        <span title="<?php echo $options["text-likes"]; ?>"

              class="wdp-rating-count <?php echo $likes_class ?>"><?php echo $likes_count; ?></span>

        <a class="wdp-rating-link wdp-rating-dislike" href="?comment_id=<?php echo $comment_id; ?>&amp;method=dislike"

           title="<?php echo $options["text-unlike"]; ?>"><span class="wdpo-thumb_down"></a>

    </div><!--.wdp-comment-rating-->

    <?php

}



/* --------------------------------------------------------------------

   Recibe la acción desde jQuery Ajax para Votar un Comentario

-------------------------------------------------------------------- */

add_action( 'wp_ajax_comment_rating', 'comment_rating_process_WDP' );

add_action( 'wp_ajax_nopriv_comment_rating', 'comment_rating_process_WDP' );



function comment_rating_process_WDP(){

    $nonce = $_POST['nonce'];

    if( ! wp_verify_nonce( $nonce, 'wdp-nonce' ) ){

        die ( 'Busted rated!' );

    }



    if( isset( $_POST['comment_id'] ) && is_numeric( $_POST['comment_id'] ) ){

        $comment_id = (int) $_POST['comment_id'];

        $action = $_POST['method'];

        $ip = $_SERVER['REMOTE_ADDR'];

        $current_user = wp_get_current_user();

        $user_id = (int) $current_user->ID;

        $can_vote = false;

        $success = false;

        $voted_IP = checkVotedIP_WDP( $comment_id, $ip );

        $voted_user = checkVotedUser_WDP( $comment_id, $user_id );

        $voted_action = checkVotedAction_WDP( $comment_id, $ip, $action );



        //Si la IP actual ya votó

        if( $voted_IP ){

            //Comprobamos que la acción actual es contraria "like/dislike"

            if( ! $voted_action ){

                $can_vote = true;

            } //si la IP ya fue registrada, pero se trata de otro usuario

            else if( ! $voted_user && is_user_logged_in() ){

                $can_vote = true;

            }

        } //si nunca a votado

        else{

            $can_vote = true;

        }

        if( $can_vote ){

            //se procede a realizar la votación

            makeTheVote_WDP( $comment_id, $ip, $current_user, $action );

        } else{

            $likes_count = get_comment_meta( $comment_id, 'wdp-likes_count', true );



            $result = array(

                'success' => $success,

                'likes' => $likes_count,

                'message' => '',

            );

            echo json_encode( $result );

        }

    }

    exit;

}



/* --------------------------------------------------------------------

   Función que realiza un Post Like a un Post

-------------------------------------------------------------------- */

function makeTheVote_WDP( $comment_id, $ip, $current_user, $action ){

    $user_id = (int) $current_user->ID;

    $user_name = $current_user->user_login;



    $likes_count = get_comment_meta( $comment_id, 'wdp-likes_count', true );

    $likes_IP = getVotedIP_WDP( $comment_id );

    $likes_action = getVotedIP_WDP( $comment_id );

    $likes_IP[$ip] = time();

    $likes_action[$ip] = $action;





    //Actualizamos 'Likes por IP y Acción' del comentario

    update_comment_meta( $comment_id, 'wdp-likes_IP', $likes_IP );

    update_comment_meta( $comment_id, 'wdp-likes_action', $likes_action );



    // Si la acción de Like

    if( $action == 'like' ){

        //Sumamos un 'Like' al comentario

        update_comment_meta( $comment_id, 'wdp-likes_count', ++$likes_count );



        //Actualizamos 'wdp-likes_comment' del Usuario

        $likes_comment = getCommentLikeUser_WDP();

        $likes_comment = array_diff( $likes_comment, array( $comment_id ) );

        $likes_comment = array_values( $likes_comment );

        $likes_comment[] = $comment_id;

        update_user_meta( $user_id, 'wdp-likes_comment', $likes_comment );

    } else{

        //Restamos un 'Like' al comentario

        update_comment_meta( $comment_id, 'wdp-likes_count', --$likes_count );



        //Actualizamos 'wdp-dislikes_comment' del Usuario

        $dislikes_comment = getCommentDislikeUser_WDP();

        $dislikes_comment = array_diff( $dislikes_comment, array( $comment_id ) );

        $dislikes_comment = array_values( $dislikes_comment );

        $dislikes_comment[] = $comment_id;

        update_user_meta( $user_id, 'wdp-dislikes_comment', $dislikes_comment );



    }

    //Mostramos el resultado

    $success = true;

    $result = array(

        'success' => $success,

        'likes' => $likes_count,

        'message' => ''

    );

    echo json_encode( $result );

}



/* --------------------------------------------------------------------

   Función que comprueba si un Usuario ya ha votado

-------------------------------------------------------------------- */

function checkVotedUser_WDP( $comment_id, $user_id = '' ){

    $likes_comment = getCommentLikeUser_WDP( $user_id );

    $dislikes_comment = getCommentDislikeUser_WDP( $user_id );



    if( in_array( $comment_id, array_values( $likes_comment ) ) ){

        return true;

    }

    if( in_array( $comment_id, array_values( $dislikes_comment ) ) ){

        return true;

    }

    return false;

}



/* --------------------------------------------------------------------

   Función que obtiene el Campo Personalizado 'wdp-likes_comment' de un Usuario

-------------------------------------------------------------------- */

function getCommentLikeUser_WDP( $user_id = '' ){

    $user_likes_comment = get_user_meta( $user_id, 'wdp-likes_comment' );

    $likes_comment = $user_likes_comment[0];

    if( ! is_array( $likes_comment ) ){

        $likes_comment = array();

    }

    return $likes_comment;

}



/* --------------------------------------------------------------------

   Función que obtiene el Campo Personalizado 'wdp-dislikes_comment' de un Usuario

-------------------------------------------------------------------- */

function getCommentDislikeUser_WDP( $user_id = '' ){

    $user_dislikes_comment = get_user_meta( $user_id, 'wdp-dislikes_comment' );

    $dislikes_comment = $user_dislikes_comment[0];

    if( ! is_array( $dislikes_comment ) ){

        $dislikes_comment = array();

    }

    return $dislikes_comment;

}





/* --------------------------------------------------------------------

   Función que comprueba si una IP ya ha votado

-------------------------------------------------------------------- */

function checkVotedIP_WDP( $comment_id, $ip = '' ){

    if( $ip == '' ){

        $ip = $_SERVER['REMOTE_ADDR'];

    }

    $likes_IP = getVotedIP_WDP( $comment_id );

    if( in_array( $ip, array_keys( $likes_IP ) ) ){

        return true;

    } else{

        return false;

    }

}



/* --------------------------------------------------------------------

   Función que obtiene todas la IP que han votado un Comentario

-------------------------------------------------------------------- */

function getVotedIP_WDP( $comment_id ){

    $likes_IP = get_comment_meta( $comment_id, 'wdp-likes_IP', true );

    if( ! is_array( $likes_IP ) ){

        $likes_IP = array();

    }

    return $likes_IP;

}



/* --------------------------------------------------------------------

   Función que comprueba la última acción de un voto "like/dislike"

-------------------------------------------------------------------- */

function checkVotedAction_WDP( $comment_id, $ip = '', $action ){

    if( $ip == '' ){

        $ip = $_SERVER['REMOTE_ADDR'];

    }

    $action_IP = get_comment_meta( $comment_id, 'wdp-likes_action', true );

    if( ! is_array( $action_IP ) ){

        $action_IP = array();

        return false;

    }

    if( isset( $action_IP[$ip] ) && $action == $action_IP[$ip] ){

        return true;

    }

    return false;

}





/* --------------------------------------------------------------------

   Tiempo en que se ha publicado un Comentario

-------------------------------------------------------------------- */

function get_time_since_WDP( $time = '' ){

    if( $time == '' ){

        $time_since_posted = make_time_since_WDP( get_the_time( 'U' ), current_time( 'timestamp' ) );

    } else{

        $time_since_posted = make_time_since_WDP( $time, current_time( 'timestamp' ) );

    }

    return $time_since_posted;

}



/* --------------------------------------------------------------------

   Retorna la diferencia entre dos tiempos, función						   					   bp_core_time_since() de budypress modificada

-------------------------------------------------------------------- */

function make_time_since_WDP( $older_date, $newer_date = false ){

    global $post;

    $options = get_option( 'wdp_options' );

    $unknown_text = 'sometime';

    $right_now_text = $options['text-time-right-now'];//'right now';

    $ago_text = $options['text-time-ago'];



    //Time Periods

    $chunks = array(

        array( 60 * 60 * 24 * 365, $options['text-year'], $options['text-years'] ),

        array( 60 * 60 * 24 * 30, $options['text-month'], $options['text-months'] ),

        array( 60 * 60 * 24 * 7, $options['text-week'], $options['text-weeks'] ),

        array( 60 * 60 * 24, $options['text-day'], $options['text-days'] ),

        array( 60 * 60, $options['text-hour'], $options['text-hours'] ),

        array( 60, $options['text-min'], $options['text-mins'] ),

        array( 1, $options['text-sec'], $options['text-secs'] )

    );



    if( ! empty( $older_date ) && ! is_numeric( $older_date ) ){

        $time_chunks = explode( ':', str_replace( ' ', ':', $older_date ) );

        $date_chunks = explode( '-', str_replace( ' ', '-', $older_date ) );

        $older_date = gmmktime( (int) $time_chunks[1], (int) $time_chunks[2], (int) $time_chunks[3], (int) $date_chunks[1], (int) $date_chunks[2], (int) $date_chunks[0] );

    }



    $newer_date = ( ! $newer_date ) ? strtotime( current_time( 'mysql', true ) ) : $newer_date;



    // Diferencia en segundos

    $since = $newer_date - $older_date;



    // Si algo salió mal y terminamos con una fecha negativa

    if( 0 > $since ){

        $output = $unknown_text;



        /**

         * Solo mostraremos dos bloques de tiempo, ejemplo:

         * x años, xx meses

         * x días, xx horas

         * x horas, xx minutos

         */

    } else{

        for( $i = 0, $j = count( $chunks ); $i < $j; ++$i ){

            $seconds = $chunks[$i][0];

            $count = floor( $since / $seconds );

            if( 0 != $count ){

                break;

            }

        }

        // Si el evento ocurrió hace 0 segundos

        if( ! isset( $chunks[$i] ) ){

            $output = $right_now_text;

        } else{

            $output = ( 1 == $count ) ? '1 ' . $chunks[$i][1] : $count . ' ' . $chunks[$i][2];

            if( $i + 2 < $j ){

                $seconds2 = $chunks[$i + 1][0];

                $name2 = $chunks[$i + 1][1];

                $count2 = floor( ( $since - ( $seconds * $count ) ) / $seconds2 );

                if( 0 != $count2 ){

                    $output .= ( 1 == $count2 ) ? ', 1 ' . $name2 : ', ' . $count2 . ' ' . $chunks[$i + 1][2];

                }

            }

            if( ! (int) trim( $output ) ){

                $output = $right_now_text;

            }

        }

    }

    if( $output != $right_now_text ){

        $output = sprintf( $ago_text, $output );

    }



    return $output;

}



/* --------------------------------------------------------------------

  Avatar de un comentario

-------------------------------------------------------------------- */

function get_avatar_WDP( $options, $email = '', $size = '28' ){

    $avatar_size = isset( $options['avatar_size'] ) ? (int) $options['avatar_size'] : (int) $size;

    if( $avatar_size < 1 ){

        $avatar_size = 28;

    }

    $avatar_url = isset( $options['avatar_url'] );

    return array(

        'size' => $avatar_size,

        'image' => '<img src="'. $options['avatar_url'] .'">',

    );

}



/* --------------------------------------------------------------------

  Remove User name from comment class

-------------------------------------------------------------------- */

add_filter( 'comment_class', 'remove_comment_author_class' );

function remove_comment_author_class( $classes ){

    foreach( $classes as $key => $class ){

        if( strstr( $class, "comment-author-" ) ){

            unset( $classes[$key] );

        }

    }

    return $classes;

}





/* --------------------------------------------------------------------

   Permitir Comentarios al insertar en Custom Post Types

-------------------------------------------------------------------- */

add_filter( 'wp_insert_post_data', 'allow_comments_on_insert_WDP' );

function allow_comments_on_insert_WDP( $data ) {

    $options = get_option( 'wdp_options' );

    $allow_post_types = isset( $options['allow_post_types'] ) ? (array) $options['allow_post_types'] : array();

    $allow_post_types = array_filter( $allow_post_types );



    if( in_array( $data['post_type'], $allow_post_types ) ){

        $data['comment_status'] = "open";

    }

    return $data;

}



/* --------------------------------------------------------------------

   Permitir Comentarios en Custom Post Types

-------------------------------------------------------------------- */

add_filter( 'admin_init', 'allow_comments_all_custom_post_types_WDP' );

function allow_comments_all_custom_post_types_WDP() {

    global $wpdb;

    $options = get_option( 'wdp_options' );

    $allow_post_types = isset( $options['allow_post_types'] ) ? (array) $options['allow_post_types'] : array();

    $allow_post_types = array_filter( $allow_post_types );

    $saved_allow_post_types = get_option('wdp_allow_post_types');



    if( $saved_allow_post_types === false || $saved_allow_post_types != $allow_post_types ){

        foreach( $allow_post_types as $post_type ){

            $table_name = "{$wpdb->prefix}posts";

            $wpdb->query( $wpdb->prepare("UPDATE `$table_name` SET comment_status = %s WHERE post_type = %s", 'open', $post_type) );

            update_option('wdp_allow_post_types', $allow_post_types);

        }

    }

    if( empty( $allow_post_types) ){

        delete_option('wdp_allow_post_types');

    }

}



/* --------------------------------------------------------------------

   Acepta comentarios duplicados

-------------------------------------------------------------------- */

add_filter( 'duplicate_comment_id', 'duplicate_comment_id_WDP', 10, 2);

function duplicate_comment_id_WDP( $dupe_id, $commentdata ){

    return false;

}



function add_confirmation_comment_meta( $comment_id ) {

    if (isset($_POST['konfirmasi'])){

        add_comment_meta( $comment_id, 'konfirmasi', $_POST['konfirmasi'] );
    }
}

add_action( 'comment_post', 'add_confirmation_comment_meta' );

add_action('wp_ajax_wp_comment_export_data_to_csv', 'cui_export_data_to_csv');
function cui_export_data_to_csv()
{
    if (!wp_verify_nonce(sanitize_text_field($_POST['_token']), 'nonce_ajax_export')) {
        wp_send_json_error();
        wp_die();
    }
    $ids = isset($_POST['ids']) ? sanitize_text_field($_POST['ids']) : null;
    $exclude_page = isset($_POST['exclude_pages']) ? sanitize_text_field($_POST['exclude_pages']) : null;
    $post_type = isset($_POST['post_type']) ? wp_slash($_POST['post_type']) : [];

    $args = array(
        'posts_per_page' => -1,
        'orderby' => 'ID',
        'order' => 'DESC',
        'fields' => 'ids',
        'comment_count' => array(
            'value' => 0,
            'compare' => '>',
        ),
    );

    if (count($post_type) === 1 && $post_type[0] === 'custom') {
        $post_ids = get_post_ids_by_array_slugs($ids);
        $post_ids = array_filter($post_ids, 'trim');


    } elseif (!empty($post_type)) {
        unset($post_type['custom']);
        if ($exclude_page) {
            $args['post__not_in'] = get_post_ids_by_array_slugs($exclude_page);
        }

        $args['post_type'] = $post_type;
        $post_ids = get_posts($args);
    } else {
        $post_ids = [];
    }

    $comments = [];
    $comment_args = [];
    if (!empty($post_ids)) {
        $comment_args = array(
            'post__in' => array_filter($post_ids, 'absint'),
        );
        $get_comment = get_comments($comment_args);
        if (!empty($get_comment)) {
           foreach ($get_comment as $item){
               
               $message = str_replace(',','-',wp_strip_all_tags($item->comment_content));
               $comments[] = array(
                   'undangan' => get_the_title($item->comment_post_ID),
                   'nama_tamu' => $item->comment_author,
                   'konfirmasi' => get_comment_meta($item->comment_ID,'konfirmasi',true),
                   'ucapan' => $message,
                   'tanggal' => $item->comment_date,
               );
           }

            $file_name = 'commentkit-'.time();
            $header = array_keys($comments[0]);
            wp_send_json_success(compact('file_name','header','comments'));
            wp_die();
        }
    }

    if (!empty($get_comment)){

       

    }else{
         wp_send_json_error();
        wp_die();
    }
   
}

function get_post_ids_by_array_slugs($slugs, $post_types = null)
{
    global $wpdb;
    $table = $wpdb->prefix . 'posts';
    $array = array_map('esc_attr', explode(',', $slugs));
    $array = implode("','", $array);
    $query = "SELECT ID from {$table} WHERE post_name IN ('" . $array . "')";
    if ($post_types) {
        $post_types = implode("','", $post_types);

        $query .= " AND post_type IN ('" . $post_types . "')";
    }
    $results = $wpdb->get_results($query, ARRAY_A);
    if (!empty($results)) {
        $results = array_map(function ($val) {
            return $val['ID'];
        }, array_values($results));
    }
    return $results;
}



function generate_csv_invitation_comment($array, $filename = "export.csv", $delimiter=";") {
    // tell the browser it's going to be a csv file
    header('Content-Type: text/csv; charset=utf-8');

    // tell the browser we want to save it instead of displaying it
    header(sprintf('Content-Disposition: attachment; filename=%s',$filename));

    // open the "output" stream
    $f = fopen('php://output', 'w');

    // use keys as column titles
    fputcsv( $f, array_keys( $array['0'] ) , $delimiter );

    foreach ($array as $line) {
        fputcsv($f, $line, $delimiter);
    }
}

