<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}


define( 'ADDONS_WC_WEDDINGPRESS_URL', trailingslashit( plugin_dir_url(__FILE__)));
define( 'ADDONS_WC_WEDDINGPRESS_PATH', trailingslashit( plugin_dir_url(__FILE__)));

/*
 * Credits: AgusMu
 * https://agusmu.com
*/

Class WDP_WooCommerce {

    private static $instance = null;


    /**
     * Instance
     *
     * Ensures only one instance of the class is loaded or can be loaded.
     *
     * @since 1.0.0
     *
     * @access public
     * @static
     *
     */
    public static function instance() {
        if ( is_null( self::$instance ) ) {
            self::$instance = new self(); // Self here denotes the class name.
        }

        return self::$instance;
    }

    public function __construct() {
        add_action( 'admin_menu', array( $this, 'create_settings' ), 101 );
        add_action( 'admin_init', array( $this, 'setup_sections' ) );
        add_action( 'admin_init', array( $this, 'setup_fields' ) );

        if ( $this->is_active() ) {
        
            $this->whatsapp_checkout_enabled = get_option( 'wc_whatsapp_checkout_enabled' );
            $this->wc_address_enabled = get_option( 'wc_address_enabled' );
            if ( $this->whatsapp_checkout_enabled == 'yes' ) {
                add_action( 'wp_head', array( $this,'weddingpress_wc_uniqcode_set' ) );
                add_action( 'woocommerce_cart_calculate_fees', array( $this,'weddingpress_wc_uniqcode' ) );
                add_filter( 'woocommerce_checkout_fields' , array( $this,'bbloomer_simplify_checkout_virtual' ) );
                add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts' ) );
                add_action( 'woocommerce_after_checkout_validation', array( $this, 'wc_prevent_submission' ), 10, 2 );
                add_action( 'wp_ajax_wa-checkout', array( $this, 'whatsapp_checkout' ) );
                add_action( 'wp_ajax_nopriv_wa-checkout', array( $this, 'whatsapp_checkout' ) );
                add_action( 'woocommerce_checkout_order_processed', array( $this, 'checkout_order_processed' ), 50, 3 );
                add_filter( 'woocommerce_checkout_posted_data', array( $this, 'set_shipping_fields' ) );
                add_action( 'woocommerce_before_template_part', array( $this, 'resend_wa_link' ), 10, 4 );
                add_action( 'woocommerce_before_thankyou', array( $this, 'resend_wa_link_thankyou' ), 10, 1 );
                add_filter( 'woocommerce_order_button_text', array( $this, 'button_text_wc_whatsapp_checkout' ), 9999 );
                $this->wa_message = 'Halo admin, 

Berikut pesanan saya di website [NAMAWEBSITEANDA], mohon segera diproses ya..
*ID Invoice:* {{order_id}}
*Nama:* {{first_name}} {{last_name}}
*No. HP:* {{phone}}
*Alamat Penerima:* {{address_1}}
*Catatan:* {{note}}

*Detail Pembelian:*
{{order-detail}}

Saya akan transfer ke rekening berikut ini:
[ISIKAN DATA TRANSFER]

Terimakasih 
{{first_name}} {{last_name}}';
            }
            
            
                
        }
        

    }

    public function is_active() {
        $license_status = get_option( 'weddingpress_license_status' );
        if ( ! ( isset( $license_status->license ) && $license_status->license == 'valid' ) ) {
            return false;
        }
        return true;
    }


    public function enqueue_scripts() {
        if ( $this->whatsapp_checkout_enabled == 'yes' ) {
            wp_register_script( 'woo-whatsapp-checkout', ADDONS_WC_WEDDINGPRESS_URL . 'assets/js/whatsapp-checkout.js', array( 'jquery' ), WEDDINGPRESS_ELEMENTOR_VERSION, true  );
        }
        wp_register_style( 'fontawesome', 'https://use.fontawesome.com/releases/v5.13.0/css/all.css' );   
        if( is_checkout() ) { 
            wp_enqueue_style( 'fontawesome' );
            wp_localize_script( 'woo-whatsapp-checkout', 'brizpress', array(
                'ajaxurl' => admin_url( '/admin-ajax.php' ),
                'security' => wp_create_nonce( 'brizpress-woo-checkout-wa' )
            ) );
            wp_enqueue_script( 'woo-whatsapp-checkout' );
         
        }
    }

    public function create_settings() {
        $page_title = esc_html__( 'WeddingPress WooCommerce', 'weddingpress' );
        $menu_title = esc_html__( 'WooCommerce', 'weddingpress' );
        $capability = 'manage_options';
        $slug = 'wdp_wc_settings';
        $callback = array( $this, 'settings_content' );
        add_submenu_page( 'weddingpress', $page_title, $menu_title, $capability, $slug, $callback );
    }

    public function settings_content() { 
        echo '<div class="wrap">';
        echo '<h2>' . esc_html__( '', 'weddingpress' ) . '</h2>';
        echo '<div class="brizpress-form" style="background: #fff; margin: 20px 0; padding: 20px;">';
        echo '<form method="POST" action="options.php">';
            settings_fields( 'wdp_wc_settings' );
            do_settings_sections( 'wdp_wc_settings' );
            submit_button();
        echo '</form>';
        echo '</div>';
        echo '</div>';
    }

    public function setup_sections() {

        if ( $this->is_active() ) {
            add_settings_section( 'wc-whatsapp-checkout-status', esc_html__( 'WooCommerce Settings', 'weddingpress' ), array(), 'wdp_wc_settings' );

        }

    }


    public function setup_fields() {

        if ( $this->is_active() ) { 

            $fields[] = array(
                'label'   => esc_html__( 'Enable Whatsapp Checkout', 'weddingpress' ),
                'id'      => 'wc_whatsapp_checkout_enabled',
                'label2'  => esc_html__( 'Aktifkan Whatsapp Checkout untuk Redirect ke Whatsapp', 'weddingpress' ),
                'type'    => 'checkbox',
                'section'     => 'wc-whatsapp-checkout-status',
            );

            
        }

        if ( $this->is_active() && $this->whatsapp_checkout_enabled ) { 

            $fields[] = array(
                'label'       => 'WhatsApp Number',
                'id'          => 'wdpwa_chat_id',
                'type'        => 'text',
                'default'     => '',
                'section'     => 'wc-whatsapp-checkout-status',
                'placeholder' => '628xxxxxx',
                'desc'        => esc_html__( 'Pastikan nomor whatsapp aktif.' ),
                'field_class' => 'regular-text',
            );

            $fields[] = array(
                'label'       => 'Button Text',
                'id'          => 'wdpwa_chat',
                'type'        => 'text',
                'default'     => '',
                'section'     => 'wc-whatsapp-checkout-status',
                'desc'        => esc_html__( 'Tombol ini digunakan apabila browser tidak mendukung/memblokir pop up' ),
                'field_class' => 'regular-text',
            );

            $fields[] = array(
                'label'       => 'Pesan WhatsApp',
                'id'          => 'wdpwa_chat_message',
                'desc'        => '',
                'type'        => 'textarea',
                'default'     => $this->wa_message,
                'section'     => 'wc-whatsapp-checkout-status',
                'field_class' => 'regular-text emojionearea',
                'desc'        => esc_html__( 'Sesuaikan Pesan ke Whatsapp setelah checkout di woocommerce', 'weddingpress' ),
            );

            // $fields[] = array(
            //     'label' => esc_html__( 'Shortcode', 'weddingpress' ),
            //     'id' => 'wc_whatsapp_checkout_shortcode',
            //     'type' => 'note',
            //     'section'     => 'wc-whatsapp-checkout-status',
            //     'label2' => '<p><strong>{{order_id}} </strong> : Order/invoice ID</p>
            //     <p><strong>{{first_name}} </strong> : Billing First name</p>
            //     <p><strong>{{last_name}} </strong> : Billing last name </p>
            //     <p><strong>{{email}} </strong> : Billing email</p>
            //     <p><strong>{{phone}} </strong> : Billing phone number</p>
            //     <p><strong>{{note}} </strong> : Order note</p>
            //     <p><strong>{{order-detail}} </strong> : Order detail</p>',
            //     'desc' => '',
            // );

            $fields[] = array(
                'label'       => 'Button Checkout Text',
                'id'          => 'button_checkout_text',
                'type'        => 'text',
                'placeholder' => 'Place order',
                'default'     => '',
                'section'     => 'wc-whatsapp-checkout-status',
                'field_class' => 'regular-text',
                'desc'        => esc_html__( 'Opsional ganti text place order di tombol checkout', 'weddingpress' ),
            );

            

        }


            $fields[] = array(
                    'label'    => 'Kode Unik',
                    'id'       => 'wdp_wc_kodeunik',
                    'type'     => 'select',
                    'section'  => 'wc-whatsapp-checkout-status',
                    'default'  => 'min',
                    'options'  => array(
                        'min' => 'Pengurangan',
                        'plus' => 'Penambahan',
                    ),
                    'desc' => esc_html__( 'Pengurangan/penambahan total order' ),
                    'field_class' => 'regular-text',
            );

            $fields[] = array(
                    'label'   => esc_html__( 'Alamat Lengkap', 'weddingpress' ),
                    'id'      => 'wc_address_enabled',
                    'label2'  => esc_html__( 'Sembunyikan kolom Alamat Lengkap di halaman Checkout', 'weddingpress' ),
                    'type'    => 'checkbox',
                    'section'     => 'wc-whatsapp-checkout-status',
            );

        foreach( $fields as $field ){
            add_settings_field( $field['id'], $field['label'], array( $this, 'field_callback' ), 'wdp_wc_settings', $field['section'], $field );
            if ( 'note' != $field['type'] ) {
                if ( false === strpos( $field['id'], '[' ) ) {
                    register_setting( 'wdp_wc_settings', $field['id'] );
                }
                else {
                    $a = explode( '[', $field['id'] );
                    $b = trim( $a[0] );
                    register_setting( 'wdp_wc_settings', $b );
                }
            }
        }
    }


    public function field_callback( $field ) {
        if ( false === strpos( $field['id'], '[' ) ) {
            $value = get_option( $field['id'] );
        }
        else {
            $a = explode( '[', $field['id'] );
            $b = trim( $a[0] );
            $c = trim( str_replace( ']', '', $a[1] ) );
            $d = get_option( $b );
            $value = isset( $d[$c] ) ? $d[$c] : false;
        }
        $defaults = array(
            'label'         => '',
            'label2'        => '',
            'type'          => 'text',
            'default'       => '',
            'desc'          => '',
            'placeholder'   => '',
            'field_class'   => '',
        );
        $field = wp_parse_args( $field, $defaults );
        $field['db'] = $field['id'];
        $field['id'] = str_replace( array( '[', ']' ), '_', $field['id'] );
        switch ( $field['type'] ) {
            case 'license':
                $this->license_field();
                break;
            case 'note':
                printf( '<label for="%1$s">%2$s</label><br/>',
                    $field['id'],
                    $field['label2']
                );
                break;
            case 'checkbox':
                printf( '<label for="%2$s"><input name="%1$s" id="%2$s" class="%3$s" type="%4$s" value="%5$s" %6$s /> %7$s</label><br/>',
                    $field['db'],
                    $field['id'],
                    $field['field_class'],
                    $field['type'],
                    'yes',
                    checked( $value, 'yes', false ),
                    $field['label2']
                );
                break;
            case 'radio':
                if( ! empty ( $field['options'] ) && is_array( $field['options'] ) ) {
                    $options_markup = '';
                    $iterator = 0;
                    if ( !$value && $field['default'] ) {
                        $value = $field['default'];
                    }
                    foreach( $field['options'] as $key => $label ) {
                        $iterator++;
                        $options_markup.= sprintf( '<label for="%2$s_%8$s"><input name="%1$s" id="%2$s_%8$s" class="%3$s" type="%4$s" value="%5$s" %6$s /> %7$s</label><br/>',
                            $field['db'],
                            $field['id'],
                            $field['field_class'],
                            $field['type'],
                            $key,
                            checked( $value, $key, false ),
                            $label,
                            $iterator
                        );
                    }
                    printf( '<fieldset>%s</fieldset>',
                        $options_markup
                    );
                }
                break;
            case 'select':
                if( ! empty ( $field['options'] ) && is_array( $field['options'] ) ) {
                    $attr = '';
                    $options = '';
                    foreach( $field['options'] as $key => $label ) {
                        $options.= sprintf( '<option value="%s" %s>%s</option>',
                            $key,
                            selected( $value, $key, false ),
                            $label
                        );
                    }
                    printf( '<select name="%1$s" id="%2$s" class="%3$s" %4$s>%5$s</select>',
                        $field['db'],
                        $field['id'],
                        $field['field_class'],
                        $attr,
                        $options
                    );
                }
                break;
            case 'multiselect':
                if( ! empty ( $field['options'] ) && is_array( $field['options'] ) ) {
                    $attr = '';
                    $options = '';
                    foreach( $field['options'] as $key => $label ) {
                        $options.= sprintf( '<option value="%s" %s>%s</option>',
                            $key,
                            !empty( $value) ? selected( $value[array_search( $key, $value, true )], $key, false ) : false,
                            $label
                        );
                    }
                    $attr = ' multiple="multiple" ';
                    printf( '<select name="%1$s[]" id="%2$s" class="%3$s" %4$s>%5$s</select>',
                        $field['db'],
                        $field['id'],
                        $field['field_class'],
                        $attr,
                        $options
                    );
                }
                break;
            case 'textarea':
                if ( empty( $value ) && !empty( $field['default'] ) ) {
                    $value = $field['default'];
                }
                printf( '<textarea name="%1$s" id="%2$s" class="%3$s" placeholder="%4$s" rows="7" cols="50">%5$s</textarea>',
                    $field['db'],
                    $field['id'],
                    $field['field_class'],
                    $field['placeholder'],
                    $value
                );
                break;
            case 'wysiwyg':
                wp_editor( $value, $field['db'] );
                break;
            case 'color':
                $value = empty( $value ) && isset( $field['default'] ) ? $field['default'] : '';
                $style = ! empty( $value ) ? 'style="background: ' . esc_attr( $value ) . '"' : '';
                echo '<span class="tpid_colorpickpreview" ' . $style . '>&nbsp;</span>';
                printf( '<input name="%1$s" id="%2$s" class="%3$s tpid_colorpick" type="text" placeholder="%4$s" value="%5$s" />',
                    $field['db'],
                    $field['id'],
                    $field['field_class'],
                    $field['placeholder'],
                    $value
                );
                break;
            default:
                printf( '<input name="%1$s" id="%2$s" class="%3$s" type="%4$s" placeholder="%5$s" value="%6$s" />',
                    $field['db'],
                    $field['id'],
                    $field['field_class'],
                    $field['type'],
                    $field['placeholder'],
                    $value
                );
        }
        if( $desc = $field['desc'] ) {
            printf( '<p class="description">%s </p>', $desc );
        }
    }

    function weddingpress_wc_uniqcode() {
        
            $cost_min = 1;
            $cost_max = 999;
            
            $mode = get_option('wdp_wc_kodeunik');
            if ( WC()->cart->subtotal != 0){
                
                $label = esc_html__( 'Kode Unik');
                
                $cost = WC()->session->get( 'weddingpress_wc_kodeunik' );
                if ( !$cost ) {
                    $cost = rand( $cost_min, $cost_max );
                    WC()->session->set( 'weddingpress_wc_kodeunik', $cost );
                }
                if( $cost ) {
                    if ( $mode != 'plus' ) {
                        $cost = -1*$cost;
                    }
                    WC()->cart->add_fee( $label, $cost);
                }
            }
        
    }

    function weddingpress_wc_uniqcode_set() {
        if ( !is_cart() && !is_checkout() ) {
            WC()->session->set( 'weddingpress_wc_kodeunik', 0 );
        }
    }

    public function bbloomer_simplify_checkout_virtual( $fields ) {
    
        
       foreach( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
          // Check if there are non-virtual products
          if ( ! $cart_item['data'] );   
       }
         
        if ( $this->wc_address_enabled == 'yes' ) {
           unset($fields['billing']['billing_company']);
           unset($fields['billing']['billing_address_1']);
           unset($fields['billing']['billing_address_2']);
           unset($fields['billing']['billing_city']);
           unset($fields['billing']['billing_postcode']);
           unset($fields['billing']['billing_country']);
           unset($fields['billing']['billing_state']);
           // unset($fields['billing']['billing_phone']);
           add_filter( 'woocommerce_enable_order_notes_field', '__return_false' );
         }
         
         return $fields;
    }


    public function wc_prevent_submission($data, $errors) {
        if ( isset($_POST['bpwoo_prevent_submit']) && empty( $errors->errors ) ) {
            $errors->add( 'theme', __( 'go_whatsapp_redirect', 'woocommerce' ) );
        } 
    }
    
    public function whatsapp_checkout() {
        check_ajax_referer( 'brizpress-woo-checkout-wa', 'security' );
        $checkout = WC_Checkout::instance();
        $checkout->process_checkout();
    }   
    
    public function checkout_order_processed( $order_id, $posted_data, $order ) { 

       if ( $this->whatsapp_checkout_enabled == 'yes' ) {
    
        $wa_send_number = get_option('wdpwa_chat_id');
           
        $customer = array(
            'billing' => $this->set_address( $posted_data ),
            'shipping' => $this->set_address( $posted_data, 'shipping' )
        );
        $fields = array( 'first_name', 'last_name', 'address_1', 'address_2', 'city', 'postcode', 'state', 'country','email', 'phone', 'note', 'order_id' );
        $wa_message = get_option( 'wdpwa_chat_message' );
            if ( empty( $wa_message ) ) {
                $wa_message = $this->message_wa;
            }
        if( $wa_message != '' ) {
            foreach( $fields as $f ) {
                if( $f == 'note' ) {
                    $wa_message = str_replace( "{{note}}", $posted_data['order_comments'], $wa_message );
                } elseif( $f == 'order_id' ) {
                    $wa_message = str_replace( "{{order_id}}", $order_id, $wa_message ); 
                } else {
                    $__text = '';
                    if( isset( $customer['billing'][$f] ) ) { $__text = $customer['billing'][$f]; }
                    $wa_message = str_replace( "{{".$f."}}", $__text, $wa_message );
                }
            }
        }
        $_wa_message = $this->checkout_whatsapp_message( $order );
        if( $_wa_message != '' ) {
            $wa_message = str_replace( "{{order-detail}}", $_wa_message, $wa_message );
        }
        $redirect_url = '';
        if( $order ) {
            $payment_method = $order->get_payment_method();
            if( WC()->cart->needs_payment() && $payment_method != 'cod' && $payment_method != 'bacs' ) {
                $redirect_url = $order->get_checkout_payment_url();
                $wa_message .= "\n\n";
                $wa_message .= 'Cara Pembayaran ' . $redirect_url;
            } else {
                $redirect_url = $order->get_checkout_order_received_url();
            }            
            WC()->cart->empty_cart();
            WC()->session->set('cart', array());    
        }            
        $return = array(
            'order_id' => $order_id,
            'to_number' => $wa_send_number,
            'wa_message' => urlencode( $wa_message ),
            'redirect' => $redirect_url
        );
        update_post_meta( $order_id, 'order_wa_to_number', $wa_send_number );
        update_post_meta( $order_id, 'order_wa_message', urlencode( $wa_message ) );

        $this->send_email( $order_id );

        echo json_encode( $return );
        die();

        }
    }

    public function send_email( $order_id ) {
        WC()->mailer();
        $mail_order = new WC_Email_New_Order();
        $mail_order->trigger( $order_id, $order );
        $mail = new WC_Email_Customer_Invoice();
        $mail->trigger( $order_id, $order );
    }

    
    public function set_shipping_fields( $data ) {
        foreach( $data as $key => $value ) {
            if( substr( $key, 0, 8 ) == 'billing_' ) {
                $fld = str_replace( 'billing_', '', $key );
                if( !isset( $data[ 'shipping_' . $fld ] ) ) {
                    $data[ 'shipping_' . $fld ] = $value;
                }
            }
        }
        return $data;
    }
    
    private function set_address( $data, $context='billing' ) {
        $address_fields = array(
            'first_name',
            'last_name',
            'company',
            'email',
            'phone',
            'address_1',
            'address_2',
            'city',
            'postcode',
            'state',
            'country',
        );
        $address = array();
        foreach( $address_fields as $field ) {
            if( isset( $data[ $context . '_' . $field ] ) ) {
                $address[ $field ] = $data[ $context.'_'.$field ];               
            }
        }
        return $address;            
    }
    
    private function checkout_whatsapp_message( $order ){

        $shippings = array();
        foreach ($order->get_items('shipping') as $item_id => $shipping_item_obj) {

            $shipping_data = $shipping_item_obj->get_data();

            $shipping_data_name = $shipping_data['name'];
            $shipping_data_total = $shipping_data['total']+$shipping_data['total_tax'];

            $shippings[] = $shipping_data_name . " " . $this->wc_price($shipping_data_total);
        }

        $cart = $this->get_cart_items();

        $txt = '';
        if( !empty( $cart['items'] ) ) {
            $i = 0;
            foreach( $cart['items'] as $item ){
                if( $txt != '' ) $txt .= "\n";
                $i++;
                $new_line = ($i > 1) ? '' : '';
                $txt .= "*".$new_line .$i.'. '.$item['name']."*";
                if( !empty( $item['variations'] ) ) {
                    $txt .= ' - ';
                    $variations = '';
                    foreach( $item['variations'] as $v ) {
                        if( $variations != '' ) $variations .= ', ';
                        $variations .= $v['key'].': '.$v['value'];
                    }
                    $txt .= $variations;
                }            
                $txt .= "\n";
                $txt .= ' @ ' . $this->wc_price( $item['price'] );
                $txt .= ' x ' . $item['quantity'] . ' = ' . 
                        $this->wc_price( $item['price']*$item['quantity'] );
            }
            $txt .= "\n";
            $txt .= "-----------------------------------------"."\n";
            $txt .= "*Subtotal:* " . $this->wc_price( $cart['subtotal'] );
            
            if( !empty( $cart['coupons']  ) ){
                foreach ( $cart['coupons'] as $c ){
                    $txt .= "\n";
                    $txt .= '*' . __( 'Kupon: ', 'woocommerce' ) . $c['code'] . '* ' . $this->wc_price( $c['amount'] );
                }       
            }

            if( !empty( $cart['fees']  ) ){
                foreach ( $cart['fees'] as $c ){
                    $txt .= "\n";
                    $txt .= '*' . $c['label'] . ':* ' . $this->wc_price( $c['amount'] );
                }       
            }

        }
        
        if( $shippings ) {        
            foreach( $shippings as $shipping ) {
                $txt .= "\n";
                $txt .= '*' . __( 'Ongkir:', 'woocommerce' ) . '* ' . $shipping;
            }
        } else {
            $txt .= "";

        } 
        
        
        $txt .= "\n";
        $txt .= "-----------------------------------------"."\n";
        $txt .= "*Total:* " . $this->wc_price( WC()->cart->total );

        
        $txt = str_replace( "&nbsp;"," ", $txt );
        return $txt;    
    }   
    
    private function get_resend_wa_link( $order_id ){
        $to_number = get_post_meta( $order_id, 'order_wa_to_number', true );
        $message = get_post_meta( $order_id, 'order_wa_message', true );
        $displayed = get_post_meta( $order_id, 'order_wa_resend_link_display', true );
        if( $displayed != 'yes' ) {
            if( $message != '' ) {
                $link_url = 'https://wa.me/'.$to_number.'?text=' . $message;
                $link_text = get_option('wdpwa_chat');
                if ( empty( $link_text ) ) {
                    $link_text = 'Klik disini jika tidak mengarah ke WhatsApp';
                }
                echo '<div class="woo-resend-whatsapp" style="background: #01e675; padding: 5px; border-radius: 3px; text-decoration: none; margin: 3px; text-align: center; font-weight: 300;"><a style="white-space: nowrap; color: #fff !important;" href="'.$link_url.'" target="_blank"><strong><i class="fab fa-whatsapp"></i> '. $link_text .'</strong></a></div>';
            }
            update_post_meta( $order_id, 'order_wa_resend_link_display', 'yes' );
        }
    }
    
    public function resend_wa_link_thankyou( $order_id ) {
        echo $this->get_resend_wa_link( $order_id );
    }
    
    public function resend_wa_link( $name, $path, $located, $args ) {
        if( $name == 'checkout/form-pay.php' ) {
            $order_id = $args['order']->get_id();
            echo $this->get_resend_wa_link( $order_id );
        }
    }       
    
    private function wc_price( $price, $args=array() ) {
        $args = apply_filters(
            'woo_custom_wc_price_args',
            wp_parse_args(
              $args,
              array(
                'ex_tax_label'       => false,
                'currency'           => '',
                'decimal_separator'  => wc_get_price_decimal_separator(),
                'thousand_separator' => wc_get_price_thousand_separator(),
                'decimals'           => wc_get_price_decimals(),
                'price_format'       => get_woocommerce_price_format(),
              )
            )
        );
        $unformatted_price = $price;
        $negative          = $price < 0;
        $price             = apply_filters( 'raw_woocommerce_price', floatval( $negative ? $price * -1 : $price ) );
        $price             = apply_filters( 'formatted_woocommerce_price', number_format( $price, $args['decimals'], $args['decimal_separator'], $args['thousand_separator'] ), $price, $args['decimals'], $args['decimal_separator'], $args['thousand_separator'] );
        if ( apply_filters( 'woocommerce_price_trim_zeros', false ) && $args['decimals'] > 0 ) {
            $price = wc_trim_zeros( $price );
        }
        $formatted_price = ( $negative ? '-' : '' ) . sprintf( $args['price_format'],  get_woocommerce_currency_symbol( $args['currency'] ), $price );
        $return          = $formatted_price;
        if ( $args['ex_tax_label'] && wc_tax_enabled() ) {
            $return .= WC()->countries->ex_tax_or_vat();
        }   
        return apply_filters( 'woo_custom_wc_price', $return, $price, $args, $unformatted_price );  
        return $price;
    }   
    
    private function get_cart_items() {
        $return = array(
            'items' => array(),
            'coupons' => array(),
            'fees'    => array(),
            'subtotal' => 0,
        );  
        $cart_items = WC()->cart->get_cart();
        if( !empty( $cart_items ) ) {       
            foreach ( $cart_items as $key => $item ) {  
                $product = new WC_product( $item['product_id'] );
                $product_id = $product->get_id();
                $variation_id = null;
                $product_var = null;
                $product_type = $product->get_type();
                $name = $product->get_name();        
                $item_meta = [];
                if( isset( $item['variation_id'] ) && $item['variation_id'] != '' ) {
                    $variation = new WC_Product_Variation( $item['variation_id'] );
                    $product_var = $item['variation'];
                    $product_type = $variation->get_type();
                    foreach( $product_var as $k => $v ) {
                        $_k = str_replace('attribute_', '', $k);
                        $_term = get_term_by( 'slug', $v, $_k );
                        if( $_term ) {
                            $label = wc_attribute_label( $_term->taxonomy, $product );
                            array_push( $item_meta, [
                                'key' => $label,
                                'value' => $_term->name,
                            ] );
                        } else {
                            $label = wc_attribute_label( $_k, $product );
                            array_push( $item_meta, [
                                'key' => $label,
                                'value' => $v
                            ] );
                        }
                    }
                    $variation_id = $variation->get_id();
                    $name = $variation->get_title();
                    $weight = $variation->get_weight();
                    $sku = $variation->get_sku();
                    $price = $variation->get_price();
                    $price_html = $variation->get_price_html();
                    $attributes = $item['variation'];
                } else {
                    $weight = $product->get_weight();    
                    $sku = $product->get_sku();
                    $price = $product->get_price();
                    $price_html = $product->get_price_html();
                }
                array_push( $return['items'], array(
                    'product_id' => $product_id,
                    'product_type' => $product_type,
                    'variation_id' => $variation_id,
                    'name' => $name,
                    'sku' => $sku,
                    'weight' => $weight,
                    'price' => $price,
                    'quantity' => $item['quantity'],
                    'product_var' => $product_var,
                    'variations' => $item_meta          
                ) );                
            }       
        }
        $subtotal = WC()->cart->subtotal;
        if( $subtotal > 0 ) {
            $return['subtotal'] = $subtotal;
        }
        
        $fees    =  WC()->cart->get_fees();
        if( !empty( $fees ) ) {
            foreach ( $fees as $label => $amount ){
                array_push( $return['fees'], array(
                    'label' => $amount->name,
                    'amount' => $amount->total,
                ) );
            }   
        }

        $coupons = WC()->cart->coupon_discount_totals;
        if( !empty( $coupons ) ) {
            foreach ( $coupons as $code => $amount ){
                array_push( $return['coupons'], array(
                    'code' => $code,
                    'amount' => $amount,
                ) );
            }   
        }
        return $return;
    }   

    public function button_text_wc_whatsapp_checkout( $text ) {
        if ( $text_new = get_option('button_checkout_text') ) {
            return $text_new;
        }
        return $text;
    }


}
 
WDP_WooCommerce::instance();