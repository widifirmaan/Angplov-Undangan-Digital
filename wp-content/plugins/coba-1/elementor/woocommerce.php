<?php
/**
 * Add Meta Boxes
 *
 * @package     EDD\ContentRestriction\Metabox
 * @copyright   Copyright (c) 2013-2014, Pippin Williamson
 * @since       1.0.0
 */


// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

function edd_get_label_plural( $lowercase = false ) { 
    $defaults = edd_get_default_labels(); 
    return ( $lowercase ) ? strtolower( $defaults['plural'] ) : $defaults['plural']; 
}


function edd_get_default_labels() { 
    $defaults = array( 
       'singular' => __( 'Product', 'easy-digital-downloads' ),  
       'plural' => __( 'Products', 'easy-digital-downloads' ) 
 ); 
    return apply_filters( 'edd_default_downloads_name', $defaults ); 
} 

function edd_get_label_singular( $lowercase = false ) { 
    $defaults = edd_get_default_labels(); 
    return ($lowercase) ? strtolower( $defaults['singular'] ) : $defaults['singular']; 
} 


/**
 * Check to see if a user has access to a post/page
 *
 * @since       2.0
 * @param       int|bool $user_id Optional. The ID of the user to check. Default is false.
 * @param       array $restricted_to The array of downloads for a post/page
 * @param       int|false $post_id Optional. The ID of the object we are viewing. Default is false.
 * @return      array $return An array containing the status and optional message
 */
function edd_cr_user_can_access( $user_id = false, $restricted_to = array(), $post_id = false ) {

    $return = edd_cr_user_can_access_with_purchase( $user_id, $restricted_to, $post_id );

    // These filters remain only for backwards compatibility
    $return = array(
        'status' => apply_filters( 'edd_cr_user_can_access', $return['status'], $user_id, $restricted_to ),
        'message' => apply_filters( 'edd_cr_user_can_access_message', $return['message'], $user_id, $restricted_to )
    );

    // Filter the entire return array, so that the status and the message can be checked with the same filter call.
    $return = apply_filters( 'edd_cr_user_can_access_status_and_message', $return, $user_id, $restricted_to, $post_id  );

    return $return;
}


/**
 * Determine if a user has permission to view the currently viewed URL
 * Mainly for use in template files
 *
 * @since       2.1
 * @param       int $user_id The User ID to check (defaults to logged in user)
 * @param       int $post_id The Post ID to check access for (defaults to current post)
 * @return      bool If the current user has permission to view the current URL
 */
function edd_cr_user_has_access( $user_id = 0, $post_id = 0 ) {
    global $post;

    $user_id = empty( $user_id )                       ? get_current_user_id() : $user_id;
    $post_id = empty( $post_id ) && is_object( $post ) ? $post->ID             : $post_id;

    $has_access = true;

    if ( ! empty( $post_id ) ) {
        $is_post_restricted = edd_cr_is_restricted( $post_id );

        if ( $is_post_restricted ) {
            $user_has_access = edd_cr_user_can_access( $user_id, $is_post_restricted, $post_id );
            $has_access      = $user_has_access['status'] == false  ? false : true;
        }
    }

    return apply_filters( 'ecc_cr_user_has_access', $has_access );
}

/**
 * Check to see if a user has access to a post/page because of their user permissions
 *
 * @since       2.3
 * @param       int|bool $user_id Optional. The ID of the user to check. Default is false.
 * @param       array $restricted_to The array of downloads for a post/page
 * @param       int|false $post_id Optional. The ID of the object we are viewing. Default is false.
 * @return      array $return An array containing the status and optional message
 */
function edd_cr_user_can_access_with_permissions( $user_id = false, $restricted_to = array(), $post_id = false ) {

    $has_access = false;

    $return_array = array(
        'status' => $has_access,
        'message' => __( 'You do not have access because of your user permissions.', 'edd-cr' )
    );

    // If no user is given, use the current user
    if ( ! $user_id ) {
        $user_id = get_current_user_id();
    }

    // Admins have full access
    if ( user_can( $user_id, 'manage_options' ) ) {

        $return_array = array(
            'status' => true,
            'message' => __( 'You have access because of your user permissions.', 'edd-cr' )
        );

        return $return_array;
    }

    // The post author can always access
    if ( $post_id ) {

        $post = get_post( $post_id );

        if ( $post->post_author == $user_id ) {
            $return_array = array(
                'status' => true,
                'message' => __( 'You have access because you are the post author.', 'edd-cr' )
            );

            return $return_array;
        }
    }

    // If this post is not restricted to anything
    if ( ! $restricted_to || ! is_array( $restricted_to ) ) {

        $return_array = array(
            'status' => true,
            'message' => __( 'You have access because this post is not restricted.', 'edd-cr' )
        );

        return $return_array;
    }

    foreach ( $restricted_to as $item => $data ) {

        if ( empty( $data['download'] ) ) {

            $return_array = array(
                'status' => true,
                'message' => __( 'You have access because this post is not restricted.', 'edd-cr' )
            );

            return $return_array;
        }

        // As a possible product author, you do not get access to the post if it is set to "any", because there's no specific author to use.
        if ( 'any' == $data['download'] ) {

            $return_array = array(
                'status' => false,
                'message' => __( 'You do not have access because of your user permissions.', 'edd-cr' )
            );

            return $return_array;
        }

        // Make sure the download ID setting is an integer
        $download_id = absint( $data['download'] );

        // The author of a download always has access
        if ( (int) get_post_field( 'post_author', $download_id ) === (int) $user_id ) {

            $return_array = array(
                'status' => true,
                'message' => __( 'You have access because you are the author of a product that is required to view this content.', 'edd-cr' )
            );

            return $return_array;

        }
    }

    return $return_array;
}

/**
 * Check to see if a user has access to a post/page because of a one-time purchase.
 *
 * @since       2.3
 * @param       int|bool $user_id Optional. The ID of the user to check. Default is false.
 * @param       array $restricted_to The array of downloads for a post/page
 * @param       int|false $post_id Optional. The ID of the object we are viewing. Default is false.
 * @return      array $return An array containing the status and optional message
 */
function edd_cr_user_can_access_with_purchase( $user_id = false, $restricted_to = array(), $post_id = false ) {

    // In the event that a single post ID was sent in, convert to an array.
    if ( ! is_array( $restricted_to ) ) {
        $restricted_to = array( $restricted_to );
    }

    $user_permissions_results = edd_cr_user_can_access_with_permissions( $user_id, $restricted_to, $post_id );

    // If the user has access because of their user permissions
    if ( $user_permissions_results['status'] ) {
        return $user_permissions_results;
    }

    // Set up some defaults
    $message          = __( 'This content is restricted to buyers.', 'edd-cr' );
    $has_access       = false;
    $restricted_count = count( $restricted_to );
    $products         = array();

    // If no user is given, use the current user
    if ( empty( $user_id ) ) {
        $user_id = get_current_user_id();
    }

    // If this post is not restricted to anything
    if ( ! $restricted_to || ! is_array( $restricted_to ) ) {
        $has_access = true;
    }

    // Loop through each product this content is restricted to
    foreach ( $restricted_to as $item => $data ) {

        // If there is no product in this restricted_to item for some strange reason
        if ( empty( $data['download'] ) ) {
            $has_access = true;
        }

        // If restricted to any product
        if ( 'any' === $data['download'] ) {

            // If this user has purchased something, they have access
            if ( edd_has_purchases( $user_id ) ) {
                $has_access = true;
                break;
            }
        }

        // Check for variable prices
        if ( ! $has_access ) {

                $products[] = '<a href="' . get_permalink( $data['download'] ) . '">' . get_the_title( $data['download'] ) . '</a>';

                if ( ! empty( $user_id ) && get_product_purchased_last_date( $user_id, $data['download'] ) ) {
                    $has_access = true;
                }
            
        }

    }

    if ( $restricted_count > 1 ) {
        $message      = edd_cr_get_multi_restriction_message();
        $product_list = '';

        if ( ! empty( $products ) ) {
            $product_list .= '<ul>';

            foreach ( $products as $id => $product ) {
                $product_list .= '<li>' . $product . '</li>';
            }

            $product_list .= '</ul>';
        }

        $message = str_replace( '{product_names}', $product_list, $message );
    } else {
        if ( 'any' === $data['download'] ) {
            $message = edd_cr_get_any_restriction_message();
        } else {
            $message = edd_cr_get_single_restriction_message();
            $message = str_replace( '{product_name}', $products[0], $message );
        }
    }

    // Override message if per-content message is defined
    $content_message = get_post_meta( $post_id, '_edd_cr_restricted_message', true );
    $message         = ( $content_message && $content_message !== '' ? $content_message : $message );

    if ( ! isset( $message ) ) {
        $message = __( 'This content is restricted to buyers.', 'edd-cr' );
    }

    // Set up the return array.
    $return = array(
        'status' => $has_access,
        'message' => $message
    );

    return $return;
}



function edd_has_purchases( $product_id = false ) {
    global  $wpdb ;
    $user_id = get_current_user_id();
    if ( $user_id == 0 ) {
        return 0;
    }
    
    if ( !$product_id ) {
        //overall paid orders
        $paid_orders_count = $wpdb->get_var( "SELECT COUNT(p.ID) FROM {$wpdb->posts} p, {$wpdb->postmeta} pm1, {$wpdb->postmeta} pm2 " . "                                         WHERE p.ID = pm1.post_id AND p.ID = pm2.post_id" . "                                         AND (p.post_status = 'wc-completed' OR p.post_status = 'wc-processing') " . "                                         AND p.post_type = 'shop_order'" . "                                         AND pm1.meta_key = '_customer_user' AND pm2.meta_value = '" . (int) $user_id . "'" );
        return (int) $paid_orders_count;
    }
    
    
    if ( $product_id ) {
        //paid orders for specific ticket type
        $current_user = wp_get_current_user();
        $user_email = $current_user->user_email;
        if ( is_array( $product_id ) ) {
            //ticket type id is actually a list of ids / array (so we need to build a bit complicated query)
            
            if ( count( $product_id ) > 1 ) {
                foreach ( $product_id as $product_id_key => $product_id_value ) {
                    if ( wc_customer_bought_product( $user_email, $user_id, $product_id_value ) ) {
                        return 1;
                    }
                }
                return 0;
            } else {
                //array contains only one element / ticket type id
                if ( wc_customer_bought_product( $user_email, $user_id, $product_id[0] ) ) {
                    return 1;
                }
            }
        
        }
        return 0;
    }

}


function get_product_purchased_last_date( $user_id, $product_id ) {
    global  $wpdb ;
    return $wpdb->get_var( $wpdb->prepare( "\n    SELECT p.post_date FROM {$wpdb->prefix}posts p\n    INNER JOIN {$wpdb->prefix}postmeta pm ON p.ID = pm.post_id\n    INNER JOIN {$wpdb->prefix}woocommerce_order_items oi ON oi.order_id = p.ID\n    INNER JOIN {$wpdb->prefix}woocommerce_order_itemmeta oim ON oi.order_item_id = oim.order_item_id\n    WHERE p.post_type = 'shop_order' AND (p.post_status = 'wc-completed' OR p.post_status = 'wc-processing')\n    AND pm.meta_key = '_customer_user' AND pm.meta_value = '%d'\n    AND oim.meta_key IN ('_product_id','_variation_id') AND oim.meta_value = '%d'\n    ORDER BY p.ID DESC LIMIT 1\n    ", $user_id, $product_id ) );
}

function edd_has_variable_prices( $download_id = 0 ) { 
 
    if( empty( $download_id ) ) { 
        return false; 
    } 
 
    $download = new WC_Product( $download_id ); 
    return $download->has_variable_prices(); 
} 


/**
 * Register meta box
 *
 * @since       2.0
 * @global      object $post The post/page we are editing
 * @return      void
 */
function edd_cr_add_meta_box() {
    global $post;

    $included_types = apply_filters( 'edd_cr_included_post_types', get_post_types( array( 'show_ui' => true, 'public' => true ) ) );
    $excluded_types = apply_filters( 'edd_cr_excluded_post_types', array( 'download', 'edd_payment', 'reply', 'acf', 'deprecated_log', 'edd-checkout-fields', 'fes-forms' ) );
    $post_type      = get_post_type( $post->ID );

    if ( in_array( $post_type, $included_types ) && ! in_array( $post_type, $excluded_types ) ) {
        add_meta_box(
            'content-restriction',
            __( 'Pengaturan Akses', 'edd-cr' ),
            'edd_cr_render_meta_box',
            '',
            'normal',
            'default'
        );
    }
}
add_action( 'add_meta_boxes', 'edd_cr_add_meta_box' );


/**
 * Render metabox
 *
 * @since       2.0
 * @param       int $post_id The ID of the post we are editing
 * @global      object $post The post/page we are editing
 * @return      void
 */
function edd_cr_render_meta_box( $post_id ) {
    global $post;

    $downloads     = get_posts( array( 'post_type' => 'product', 'posts_per_page' => -1 ) );
    $restricted_to = get_post_meta( $post->ID, '_edd_cr_restricted_to', true );
    $message       = get_post_meta( $post->ID, '_edd_cr_restricted_message', true );

    if ( $downloads ) {
        ?>
        <div id="edd-cr-options-visibility-toggle">
            <p>
                <label for="edd-cr-active">
                    <input id="edd-cr-active" type="checkbox" <?php echo ! $restricted_to ? '' : 'checked'; ?>></input>
                    <span><?php echo __( 'Batasi Akses', 'edd-cr' ) . ' ' . $post->post_type; ?> Ini</span>
                </label>

            </p>
        </div>
        <div id="edd-cr-options" class="edd_meta_table_wrap" <?php echo ! $restricted_to ? 'hidden' : ''; ?>>
            <p><strong><?php echo sprintf( __( 'Akses ini hanya bisa dilihat oleh member yang telah membeli produk yang sesuai produk.', 'edd-cr' ) ); ?></strong></p>

            <?php

            // Action hook which is used to output options that are not related to any specific restricted product
            do_action( 'edd_cr_restricted_table_before', $post->ID ); ?>

            <table class="widefat edd_repeatable_table" width="100%" cellpadding="0" cellspacing="0">
                <thead>
                    <th>Produk</th>
                    <!-- <th><?php echo sprintf( __( '%s Variation', 'edd-cr' ), edd_get_label_singular() ); ?></th> -->
                    <?php do_action( 'edd_cr_table_head', $post_id ); ?>
                    <!-- <th style="width: 2%"></th> -->
                </thead>
                <tbody>
                    <?php
                    if( ! empty( $restricted_to ) && is_array( $restricted_to ) ) {
                        foreach( $restricted_to as $key => $value ) {
                            echo '<tr class="edd-cr-option-wrapper edd_repeatable_row" data-key="' . absint( $key ) . '">';
                            do_action( 'edd_cr_render_option_row', $key, $post_id );
                            echo '</tr>';
                        }
                    } else {
                        echo '<tr class="edd-cr-option-wrapper edd_repeatable_row">';
                        do_action( 'edd_cr_render_option_row', 0, $post_id );
                        echo '</tr>';
                    }
                    ?>
                    <!-- <tr>
                        <td class="submit" colspan="4" style="float: none; clear:both; background:#fff;">
                            <a class="button-secondary edd_add_repeatable" style="margin: 6px 0;"><?php _e( 'Add New Download', 'edd-cr' ); ?></a>
                        </td>
                    </tr> -->
                </tbody>
            </table>
            <p>
                <label for="edd_cr_restricted_message"><strong><?php _e( 'Pesan untuk member yang tidak punya akses.', 'edd-cr' ); ?></strong></label>
                <?php wp_editor( wptexturize( stripslashes( $message ) ), 'edd_cr_restricted_message', array( 'textarea_name' => 'edd_cr_restricted_message', 'textarea_rows' => 5 ) ); ?>
            </p>
        </div>
        <?php

        echo wp_nonce_field( 'edd-cr-nonce', 'edd-cr-nonce' );
    }
}


/**
 * Individual Option Row
 *
 * Used to output a table row for each download.
 * Can be called directly, or attached to an action.
 *
 * @since       2.0
 * @param       int $key The unique key for this option row
 * @param       object $post The post we are editing
 * @return      void
 */
function edd_cr_render_option_row( $key, $post ) {
    $downloads     = get_posts( array( 'post_type' => 'product', 'posts_per_page' => -1 ) );
    $restricted_to = get_post_meta( $post->ID, '_edd_cr_restricted_to', true );
    $download_id   = isset( $restricted_to[ $key ]['download'] ) ? $restricted_to[ $key ]['download'] : 0;
    ?>
    <td>
        <select name="edd_cr_download[<?php echo $key; ?>][download]" id="edd_cr_download[<?php echo $key; ?>][download]" class="edd_cr_download" data-key="<?php echo esc_attr( $key ); ?>">
            <option value=""><?php echo __( 'None', 'edd-cr' ); ?></option>
            <option value="any"<?php selected( 'any', $download_id ); ?>><?php echo sprintf( __( 'User yang sudah membeli berbagai produk', 'edd-cr' ) ); ?></option>
            <?php
            foreach ( $downloads as $download ) {
                echo '<option value="' . absint( $download->ID ) . '" ' . selected( $download_id, $download->ID, false ) . '>' . esc_html( get_the_title( $download->ID ) ) . '</option>';
            }
            ?>
        </select>
    </td>
    
    <?php

    do_action( 'edd_cr_metabox', $post->ID, $restricted_to, null );
}
add_action( 'edd_cr_render_option_row', 'edd_cr_render_option_row', 10, 3 );


/**
 * Save metabox data
 *
 * @since       1.0.0
 * @param       int $post_id The ID of this post
 * @return      void
 */
function edd_cr_save_meta_data( $post_id ) {
    // Return if nothing to update
    if ( ! isset( $_POST['edd_cr_download'] ) || ! is_array( $_POST['edd_cr_download'] ) ) {
        return;
    }

    // Return if nonce validation fails
    if ( ! isset( $_POST['edd-cr-nonce'] ) || ! wp_verify_nonce( $_POST['edd-cr-nonce'], 'edd-cr-nonce' ) ) {
        return;
    }

    if ( ! empty( $_POST['edd_cr_download'] ) ) {

        // Grab the items this post was previously restricted to and remove related meta
        $previous_items = get_post_meta( $post_id, '_edd_cr_restricted_to', true );

        if ( $previous_items ) {
            foreach ( $previous_items as $item ) {
                if( 'any' !== $item['download'] ) {
                    delete_post_meta( $item['download'], '_edd_cr_protected_post', $post_id );
                }
            }
        }

        $has_items = false;
        $sanitized_edd_cr_download = array();

        // Add this page/post to the meta for the product, so the product knows which pages/posts it unlocks.
        foreach ( $_POST['edd_cr_download'] as $item ) {
            if ( 'any' !== $item['download'] && ! empty( $item['download'] ) ) {

                // Sanitize the posted value
                $download_id = absint( $item['download'] );

                // Sanitize any variable price id that might exist
                if ( isset( $item['price_id'] ) ) {

                    if ( 'all' == $item['price_id'] ) {
                        $price_id = 'all';
                    } else {
                        $price_id = absint( $item['price_id'] );
                    }

                } else {
                    $price_id = null;
                }

                if ( $price_id ) {

                    // Rebuild the array in $_POST with the sanitized values
                    $sanitized_edd_cr_download[] = array(
                        'download' => $download_id,
                        'price_id' => $price_id
                    );

                } else {

                    // Rebuild the array in $_POST with the sanitized values
                    $sanitized_edd_cr_download[] = array(
                        'download' => $download_id,
                    );

                }

                $saved_ids = get_post_meta( $download_id, '_edd_cr_protected_post' );

                if ( ! in_array( $post_id, $saved_ids ) ) {
                    add_post_meta( $download_id, '_edd_cr_protected_post', $post_id );
                }

                $has_items = true;

            } elseif ( 'any' == $item['download'] ) {

                // Rebuild the array in $_POST with a sanitized value for 'any'
                $sanitized_edd_cr_download[] = array(
                    'download' => 'any'
                );

                $has_items = true;
            }
        }

        if ( $has_items ) {
            update_post_meta( $post_id, '_edd_cr_restricted_to', $sanitized_edd_cr_download );
        } else {
            delete_post_meta( $post_id, '_edd_cr_restricted_to' );
        }
    } else {
        delete_post_meta( $post_id, '_edd_cr_restricted_to' );
    }

    if ( ! empty( $_POST['edd_cr_restricted_message'] ) ) {
        update_post_meta( $post_id, '_edd_cr_restricted_message', trim( wp_kses_post( $_POST['edd_cr_restricted_message'] ) ) );
    } else {
        delete_post_meta( $post_id, '_edd_cr_restricted_message' );
    }

    do_action( 'edd_cr_save_meta_data', $post_id, $_POST );
}
add_action( 'save_post', 'edd_cr_save_meta_data' );


/**
 * Check if a post/page is restricted
 *
 * @since       1.0.0
 * @param       int $post_id the ID of the post to check
 * @return      bool True if post is restricted, false otherwise
 */
function edd_cr_is_restricted( $post_id ) {
    $restricted = get_post_meta( $post_id, '_edd_cr_restricted_to', true );

    return $restricted;
}


/**
 * Filter restricted content
 *
 * @since       1.0.0
 * @param       string $content The content to filter
 * @param       array $restricted The items to which this is restricted
 * @param       string $message The message to display to users
 * @param       int $post_id The ID of the current post/page
 * @param       string $class Additional classes for the displayed error
 * @global      int $user_ID The ID of the current user
 * @return      string $content The content to display to the user
 */
function edd_cr_filter_restricted_content( $content = '', $restricted = false, $message = null, $post_id = 0, $class = '' ) {
    global $user_ID;

    // If the current user can edit this post, it can't be restricted!
    if ( ! current_user_can( 'edit_post', $post_id ) && $restricted ) {
        $has_access = edd_cr_user_can_access( $user_ID, $restricted, $post_id );

        if ( $has_access['status'] == false ) {
            if ( ! empty( $message ) ) {
                $has_access['message'] = $message;
            }

            $content = wp_die('<div class="edd_cr_message ' . $class . '">' . $has_access['message'] . '</div>');



        }
    }

    return $content;
}


/**
 * Get the message to display to people who have not purchased
 * the necessary product to view the content
 *
 * @since       2.1
 * @return      string $message The message for non-purchases of a product
 */
function edd_cr_get_single_restriction_message() {
    $default_message = sprintf( __( 'Halaman ini hanya bisa diakses member yang sudah membeli produk %s.', 'edd-cr' ), '{product_name}' );
    // $saved_message   = edd_get_option( 'edd_cr_single_resriction_message', false );
    $message         = ! empty( $saved_message ) ? $saved_message : $default_message;

    return wpautop( $message );
}


/**
 * Get the message to display to people who have not purchased
 * the necessary product(s) to view the content
 *
 * @since       2.1
 * @return      string $message The message for non-purchases of the products
 */
function edd_cr_get_multi_restriction_message() {
    $default_message = sprintf( __( 'Halaman ini hanya bisa diakses member yang sudah membeli produk:' . "\n\n" . '%s', 'edd-cr' ), '{product_names}' );
    // $saved_message   = edd_get_option( 'edd_cr_multi_resriction_message', false );
    $message         = ! empty( $saved_message ) ? $saved_message : $default_message;

    return wpautop( $message );
}


/**
 * Get the message to display to people who have not purchased any products
 *
 * @since       2.1
 * @return      string $message The message for non-purchases
 */
function edd_cr_get_any_restriction_message() {
    $default_message = __( 'Akses Terbatas! khusus member yang sudah membeli produk.' );
    // $saved_message   = edd_get_option( 'edd_cr_any_resriction_message', false );
    $message         = ! empty( $saved_message ) ? $saved_message : $default_message;

    return wpautop( $message );
}



/**
 * Filter content to handle restricted posts/pages
 *
 * @since       1.0.0
 * @param       string $content The content to filter
 * @global      object $post The post we are editing
 * @return      string $content The filtered content
 */
function edd_cr_filter_content($content) {
    global $post;

    // If $post isn't an object, we aren't handling it!
    if ( ! is_object( $post ) ) {
        return $content;
    }

    $restricted = edd_cr_is_restricted( $post->ID );

    if ( $restricted ) {
        $content = edd_cr_filter_restricted_content( $content, $restricted, null, $post->ID );

    }

    return $content;
}
add_filter( 'body_class', 'edd_cr_filter_content' );


/**
 * Enqueue scripts if necessary
 *
 * @since       2.2.0
 * @return      void
 */
function edd_cr_scripts() {

    wp_enqueue_style( 'edd-cr', WEDDINGPRESS_ELEMENTOR_URL . 'assets/css/edd-cr.css' );
    
}
add_action( 'wp_enqueue_scripts', 'edd_cr_scripts' );


/**
 * Enqueue admin scripts if necessary
 *
 * @since       1.0.0
 * @global      object $post The post/page we are editing
 * @return      void
 */
function edd_cr_admin_scripts() {
    global $post;

    // Use minified libraries if SCRIPT_DEBUG is turned off
    $suffix = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '' : '.min';

    // Only enqueue if this is the add/edit post/page screen
    if ( is_object( $post ) && isset( $post->ID ) ) {
        wp_enqueue_script( 'edd-cr', WEDDINGPRESS_ELEMENTOR_URL . 'assets/js/admin' . $suffix . '.js', array( 'jquery' ), WEDDINGPRESS_ELEMENTOR_VERSION );
        wp_enqueue_style( 'edd-cr', WEDDINGPRESS_ELEMENTOR_URL . 'assets/css/admin.css' );

        wp_localize_script( 'edd-cr', 'edd_cr_admin_vars', array(
            'remove_products_before_unchecking_message' => __( 'Disabling restriction will remove all product requirements. This action is not reversible. Click OK to disable restriction. Click Cancel to make no change.', 'edd-cr' )
        ) );
    }
}
add_action( 'admin_enqueue_scripts', 'edd_cr_admin_scripts' );
