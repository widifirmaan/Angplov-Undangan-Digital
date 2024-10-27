/*global jQuery, document, ajaxurl, window, console*/
jQuery(document).ready(function ($) {
    "use strict";

    $('body').on('change', '#edd-cr-active', function ( e ) {

      var restricted_products = true;

      // Check if there are any rows in the table
      var number_of_required_products = $( '#edd-cr-options tbody .edd_repeatable_row' ).length;

      if ( 1 == number_of_required_products ) {

        var first_row_value = $( document ).find( '#edd-cr-options option[selected=selected]' ).val();

        // If the only product required is "none"
        if ( ! first_row_value ) {

          // Set the value of no_restricted_products to be true
          restricted_products = false;
        }
      }

      // If there are restricted products, don't allow the checkbox to be unchecked
      if ( restricted_products && ! $(this).is(':checked') ) {

        // Throw an alert asking the user to confirm whether they want to remove all required products or not
        if (confirm( edd_cr_admin_vars.remove_products_before_unchecking_message )) {

          // The user agreed to remove all required product, so do that, but leave the first option (None) and the last (Add Download button)
          $( '#edd-cr-options .edd_repeatable_table tbody > *:not(:first-child):not(:last-child)' ).remove();

          // Set the first option to "None"
          $( '#edd-cr-options .edd_cr_download' ).val( '' ).change();

          $( '#edd-cr-options' ).hide();

        } else {

          // The user did not agree to remove all required products, so do nothing
          e.preventDefault();
          this.checked=!this.checked;
          return false;

        }

      } else {

        // If there are no restricted products, toggle the options in or out of view
        var target = $( '#edd-cr-options' );
        if ( $(this).is(':checked') ) {
            target.show();
        } else {
            target.hide();
        }
      }

    } );

    $('body').on('change', 'select.edd_cr_download', function () {
        var $this = $(this), download_id = $this.val(), key = $this.data('key'), postData;

        // Remove the attribute 'eddcr-selected' from the previously chosen option
        $this.find( 'option').prop('selected', false).removeAttr( 'selected' );

        if (parseInt(download_id) > 0 || 'any' == download_id ) {
            $this.parent().next('td').find('select').remove();
            $this.parent().next().find('.edd_cr_loading').show();

            // Add the attribute 'eddcr-selected' to the chosen option
            $this.find( 'option[value*=' + download_id + ']').prop('selected', true).attr( 'selected', 'selected' );

            postData = {
                action : 'edd_cr_check_for_download_price_variations',
                download_id: download_id,
                key: key
            };

            $.ajax({
                type: "POST",
                data: postData,
                url: ajaxurl,
                success: function (response) {
                    if (response) {
                        $this.parent().next('td').find('.edd_cr_variable_none').hide();
                        $(response).appendTo($this.parent().next('td'));
                    } else {
                        $this.parent().next('td').find('.edd_cr_variable_none').show();
                    }
                }
            }).fail(function (data) {
                if (window.console && window.console.log) {
                    console.log(data);
                }
            });

            $this.parent().next().find('.edd_cr_loading').hide();
        } else {
            $this.parent().next('td').find('.edd_cr_variable_none').show();
            $this.parent().next('td').find('.edd_price_options_select').remove();
        }
    });
});
