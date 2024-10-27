( function($){
    $(document).ready( function(){
        var $viewportMeta = $('meta[name="viewport"]');
        if( $viewportMeta.length ) {
            $viewportMeta.attr('content', 'width=device-width,initial-scale=1,maximum-scale=1');
        }        
        var checkout_form = $( 'form.checkout' );
        checkout_form.on( 'checkout_place_order', function() {
            checkout_form.append( '<input type="hidden" id="wa-checkout" name="bpwoo_prevent_submit" value="1">' );
            return true;
        } );
        $( document.body ).on( 'checkout_error', function() {        
            var error_text = $('.woocommerce-error').find('li').first().text().trim();
            if ( error_text == 'go_whatsapp_redirect' ) {
                $( '.woocommerce-error' ).hide();
                $( '#customer_details' ).hide();
                $( '#wa-checkout' ).remove();
                checkout_form.append( '<input type="hidden" name="security" value="'+brizpress.security+'">' );
                checkout_form.block({
                    message: null,
                    overlayCSS: {
                        background: '#fff',
                        opacity: 0.6
                    }
                });                           
                var send_data = checkout_form.serialize();
                $.ajax( {
                    url: brizpress.ajaxurl+'?action=wa-checkout',
                    type: 'POST',
                    data: send_data,
                    dataType: 'json',
                    success: function( response ) {                    
                        // send whatsapp
                        var the_phone = response.to_number;
                        var the_text = response.wa_message;
                        var send_wa = window.setInterval( function(){
                            var url = 'https://api.whatsapp.com/send?phone=' + the_phone + '&text=' + the_text;
                            var isSafari = !!navigator.userAgent.match(/Version\/[\d\.]+.*Safari/);
                            var iOS = /iphone|ipod|ipad|android|blackberry|webos|mobile|bb10/.test(navigator.userAgent) && !window.MSStream;			
                            if( isSafari && iOS ) {
                                location = url;
                            } else {
                                location = url;
                            }
                            window.clearInterval( send_wa );
                            var redirect = window.setInterval( function(){
                                document.location = response.redirect;
                                window.clearInterval(redirect);      
                              	checkout_form.unblock();
                            }, 300 );
                        }, 500 );
                    }
                } );
            } else {
                $('.woocommerce-error').show();
            }
        });        
        
    } );    
} )(jQuery);