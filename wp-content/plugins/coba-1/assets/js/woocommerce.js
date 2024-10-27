(function ($) {
	
	/**
	 * Function for Product Grid.
	 *
	 */
	var WidgetPPWooAddToCart = function ($scope, $) {
		$("body")
			.off("added_to_cart.pp_cart")
			.on("added_to_cart.pp_cart", function (
				e,
				fragments,
				cart_hash,
				this_button
			) {
				if (
					$(this_button)
						.parent()
						.parent()
						.parent()
						.hasClass("elementor-widget-pp-woo-add-to-cart")
				) {
					$btn = $(this_button);

					if ($btn.length > 0) {
						// View cart text.
						if (
							!pp_woo_products_script.is_cart &&
							$btn.hasClass("added")
						) {
							if( $btn.hasClass( 'pp-redirect' ) ) {
								setTimeout(function () {
									window.location =
										pp_woo_products_script.cart_url;
								}, 500);
							}
						}
					}
				}
			});
	};

	$(window).on("elementor/frontend/init", function () {

		elementorFrontend.hooks.addAction(
			"frontend/element_ready/wdp-woo-add-to-cart.default",
			WidgetPPWooAddToCart
		);

	});
	
})(jQuery);
