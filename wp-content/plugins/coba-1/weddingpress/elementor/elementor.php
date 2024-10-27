<?php

namespace WeddingPress;

use Weddingpress\Elementor\Weddingpress_Widget_Whatsapp;
use Weddingpress\Elementor\Weddingpress_Widget_Countdown_Timer;
use Weddingpress\Elementor\Weddingpress_Widget_Guest_Book;
use Weddingpress\Elementor\Weddingpress_Widget_Timeline;
use Weddingpress\Elementor\Weddingpress_Widget_Audio;
use Weddingpress\Elementor\Weddingpress_Widget_Forms;
use Weddingpress\Elementor\Weddingpress_Widget_Wellcome;
use Weddingpress\Elementor\Weddingpress_Widget_Generatorkit;
use Weddingpress\Elementor\Weddingpress_Widget_Copy;
use Weddingpress\Elementor\Weddingpress_Widget_Senderkit;
use Weddingpress\Elementor\Weddingpress_Widget_Modal_Popup;
use Weddingpress\Elementor\Weddingpress_Widget_Comment_Kit;
use Weddingpress\Elementor\Weddingpress_Widget_Qrcode;
use Weddingpress\Elementor\Weddingpress_Widget_WC_Order;
use Weddingpress\Elementor\Weddingpress_Widget_Date_Kit;
use Weddingpress\Elementor\Weddingpress_Widget_FullScreen;
use Weddingpress\Elementor\Weddingpress_Widget_Kirim_Kit;
use Weddingpress\Elementor\Weddingpress_Widget_Comment_Kit2;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * Main Addons Class
 *
 * Register new elementor widget.
 *
 * @since 1.0.0
 */

class WDP_Elementor {

	/**
	 * Constructor
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 */
	public function __construct() {
		$this->add_actions();
	}

	/**
	 * Add Actions
	 *
	 * @since 1.0.0
	 *
	 * @access private
	 */
	private function add_actions() {

		$this->plugin_name = 'weddingpress';
		$this->version = WEDDINGPRESS_ELEMENTOR_VERSION;

			add_action( 'elementor/init', [ $this, 'on_init' ] );
			add_action( 'elementor/elements/categories_registered', [ $this, 'on_categories_registered' ], 1 );
			add_action( 'elementor/widgets/widgets_registered', [ $this, 'on_widgets_registered' ], 1 );
			add_action('wp_enqueue_scripts', [ $this, 'wdp_enqueue_style'] ); // enqueue scripts/styles for frontend
		    add_action( 'elementor/frontend/after_enqueue_styles', [ $this, 'after_enqueue_styles' ] );
			add_action( 'elementor/frontend/after_enqueue_scripts', [ $this, 'after_enqueue_scripts' ] );
			// Elementor dashboard panel style
			add_action( 'elementor/editor/after_enqueue_styles', [ $this, 'editor_scripts' ] );

			add_action( 'wp_enqueue_scripts', array( $this, 'register_style_scripts' ) );
			add_action( 'elementor/editor/before_enqueue_scripts', array( $this, 'register_style_scripts' ) );
			add_action( 'elementor/frontend/before_enqueue_scripts', array( $this, 'register_style_scripts' ) );
		
	}

	public function register_style_scripts() {

			wp_register_style(
				'wdp-woocommerce',
				WEDDINGPRESS_ELEMENTOR_WEB . 'assets/css/woocommerce.min.css',
				array(),
				WEDDINGPRESS_ELEMENTOR_VERSION
			);

			wp_register_script(
				'wdp-woocommerce',
				WEDDINGPRESS_ELEMENTOR_WEB . 'assets/js/woocommerce.min.js',
				array(
					'jquery',
				),
				WEDDINGPRESS_ELEMENTOR_VERSION,
				true
			);

			$wdp_woo_localize = apply_filters(
				'wdp_woo_elements_js_localize',
				array(
					'ajax_url' => admin_url( 'admin-ajax.php' ),
					'get_product_nonce' => wp_create_nonce( 'wdp-product-nonce' ),
				)
			);
			wp_localize_script( 'wdp-woocommerce', 'wdp_woo_products_script', $wdp_woo_localize );
		
	}



	/**
	 * On Init
	 *
	 * @since 0.1.0
	 *
	 * @access public
	 */
	public function on_init() {
	}

	/**

	 * On Categories Registered
	 *
	 * @since 0.1.0
	 *
	 * @access public
	 */

	public function on_categories_registered( $elements_manager ) {
		$elements_manager->add_category(
			'weddingpress',
			[
				'title' => __( 'Weddingpress', 'weddingpress' ),
				'icon' => 'font',
			]
		);
	}

	public function editor_scripts() {
		wp_enqueue_style( "wdp-editor", WEDDINGPRESS_ELEMENTOR_URL . '/assets/css/editor.css' );
	}


 	public function wdp_enqueue_style() {
		wp_enqueue_style( 'wdp-centered-css', WEDDINGPRESS_ELEMENTOR_WEB  . 'assets/css/wdp-centered-timeline.min.css', array());
		wp_register_style( 'wdp-horizontal-css', WEDDINGPRESS_ELEMENTOR_WEB  . 'assets/css/wdp-horizontal-styles.min.css', array());
		wp_register_style( 'wdp-fontello-css', WEDDINGPRESS_ELEMENTOR_WEB  . 'assets/css/wdp-fontello.css', array());		
		wp_register_script( 'wdp-swiper-js', WEDDINGPRESS_ELEMENTOR_WEB  . 'assets/js/wdp-swiper.min.js',array('jquery'),null, true );	
		wp_register_script( 'wdp-horizontal-js', WEDDINGPRESS_ELEMENTOR_WEB  . 'assets/js/wdp-horizontal.js', array('jquery'),null, true );	
		wp_register_script( 'weddingpress-qr', WEDDINGPRESS_ELEMENTOR_WEB  . 'assets/js/qr-code.js', array('jquery'),null, true );
		wp_enqueue_style( 'wdp-horizontal-css' );
		wp_enqueue_style( 'wdp-fontello-css' );
		wp_enqueue_script( 'wdp-swiper-js' );	
		wp_enqueue_script( 'weddingpress-qr' );
		
		if ( ! \Elementor\Plugin::$instance->editor->is_edit_mode() ) {
			wp_enqueue_script( 'wdp-horizontal-js' );
		}
		wp_enqueue_style( 'exad-main-style', WEDDINGPRESS_ELEMENTOR_WEB  . 'assets/css/exad-styles.min.css' );
        wp_enqueue_script( 'exad-main-script', WEDDINGPRESS_ELEMENTOR_WEB . 'assets/js/exad-scripts.min.js', array('jquery'), WEDDINGPRESS_ELEMENTOR_VERSION, true );
		
	}
	
	public function after_enqueue_styles() {
		wp_enqueue_style(
			'weddingpress-wdp',
			WEDDINGPRESS_ELEMENTOR_URL . 'assets/css/wdp.css',
			[],
			WEDDINGPRESS_ELEMENTOR_VERSION
		);

		wp_enqueue_style(
			'kirim-kit',
			WEDDINGPRESS_ELEMENTOR_WEB . 'assets/css/guest-book.css',
			array(),
			WEDDINGPRESS_ELEMENTOR_VERSION
		);

	}

	public function after_enqueue_scripts() {
		wp_enqueue_script(
			'weddingpress-wdp',
			WEDDINGPRESS_ELEMENTOR_WEB . 'assets/js/wdp.min.js',
			[
				'jquery',
			],
			WEDDINGPRESS_ELEMENTOR_VERSION,
			true
		);


		wp_enqueue_script(
			'kirim-kit',
			WEDDINGPRESS_ELEMENTOR_WEB . 'assets/js/guest-form.js',
			array(
				'jquery',
			),
			WEDDINGPRESS_ELEMENTOR_VERSION,
			true
		);
		
		wp_localize_script( 'weddingpress-wdp', 'cevar', array(
			'ajax_url' => admin_url('admin-ajax.php'), 
			'plugin_url' => WEDDINGPRESS_ELEMENTOR_WEB, 
		));

	}

	/**
	 * On Widgets Registered
	 *
	 * @since 0.1.0
	 *
	 * @access public
	 */

	public function on_widgets_registered() {
		$this->includes();
		$this->register_widget();
	}

	/**
	 * Includes
	 *
	 * @since 0.1.0
	 *
	 * @access private
	 */
	private function includes() {
		require_once ( WEDDINGPRESS_ELEMENTOR_PATH . 'elementor/whatsapp.php' );
		require_once ( WEDDINGPRESS_ELEMENTOR_PATH . 'elementor/countdown-timer.php' );
		require_once ( WEDDINGPRESS_ELEMENTOR_PATH . 'elementor/guest-book.php' );
		require_once ( WEDDINGPRESS_ELEMENTOR_PATH . 'elementor/timeline.php' );
		require_once ( WEDDINGPRESS_ELEMENTOR_PATH . 'elementor/audio.php' );
		require_once ( WEDDINGPRESS_ELEMENTOR_PATH . 'elementor/forms.php' );
		require_once ( WEDDINGPRESS_ELEMENTOR_PATH . 'elementor/wellcome.php' );
		require_once ( WEDDINGPRESS_ELEMENTOR_PATH . 'elementor/generator-kit.php' );
		require_once ( WEDDINGPRESS_ELEMENTOR_PATH . 'elementor/copy.php' );
		require_once ( WEDDINGPRESS_ELEMENTOR_PATH . 'elementor/senderkit.php' );
		require_once ( WEDDINGPRESS_ELEMENTOR_PATH . 'elementor/modal-popup.php' );
		require_once ( WEDDINGPRESS_ELEMENTOR_PATH . 'elementor/comment-kit.php' );
		require_once ( WEDDINGPRESS_ELEMENTOR_PATH . 'elementor/qrcode.php' );
		if ( function_exists( 'WC' ) ) {
		require_once ( WEDDINGPRESS_ELEMENTOR_PATH . 'elementor/woo-add-to-cart.php' );
		}
		require_once ( WEDDINGPRESS_ELEMENTOR_PATH . 'elementor/date-kit.php' );
		require_once ( WEDDINGPRESS_ELEMENTOR_PATH . 'elementor/fullscreen.php' );
		require_once ( WEDDINGPRESS_ELEMENTOR_PATH . 'elementor/kirim-kit.php' );
		require_once ( WEDDINGPRESS_ELEMENTOR_PATH . 'elementor/comment-kit2.php' );

	}

	/**
	 * Register Widget
	 *
	 * @since 0.1.0
	 *
	 * @access private
	 */
	private function register_widget() {
		\Elementor\Plugin::$instance->widgets_manager->register_widget_type( new Weddingpress_Widget_Whatsapp() );
		\Elementor\Plugin::$instance->widgets_manager->register_widget_type( new Weddingpress_Widget_Countdown_Timer() );
		\Elementor\Plugin::$instance->widgets_manager->register_widget_type( new Weddingpress_Widget_Guest_Book() );
		\Elementor\Plugin::$instance->widgets_manager->register_widget_type( new Weddingpress_Widget_Timeline() );
		\Elementor\Plugin::$instance->widgets_manager->register_widget_type( new Weddingpress_Widget_Audio() );
		\Elementor\Plugin::$instance->widgets_manager->register_widget_type( new Weddingpress_Widget_Forms() );
		\Elementor\Plugin::$instance->widgets_manager->register_widget_type( new Weddingpress_Widget_Wellcome() );
		\Elementor\Plugin::$instance->widgets_manager->register_widget_type( new Weddingpress_Widget_Generatorkit() );
		\Elementor\Plugin::$instance->widgets_manager->register_widget_type( new Weddingpress_Widget_Copy() );
		\Elementor\Plugin::$instance->widgets_manager->register_widget_type( new Weddingpress_Widget_Senderkit() );
		\Elementor\Plugin::$instance->widgets_manager->register_widget_type( new Weddingpress_Widget_Modal_Popup() );
		\Elementor\Plugin::$instance->widgets_manager->register_widget_type( new Weddingpress_Widget_Comment_Kit() );
		\Elementor\Plugin::$instance->widgets_manager->register_widget_type( new Weddingpress_Widget_Comment_Kit2() );
		\Elementor\Plugin::$instance->widgets_manager->register_widget_type( new Weddingpress_Widget_Qrcode() );
		if ( function_exists( 'WC' ) ) {
		\Elementor\Plugin::$instance->widgets_manager->register_widget_type( new Weddingpress_Widget_WC_Order() );
		}
		\Elementor\Plugin::$instance->widgets_manager->register_widget_type( new Weddingpress_Widget_Date_Kit() );
		\Elementor\Plugin::$instance->widgets_manager->register_widget_type( new Weddingpress_Widget_FullScreen() );
		\Elementor\Plugin::$instance->widgets_manager->register_widget_type( new Weddingpress_Widget_Kirim_Kit() );



	}
	
}

new WDP_Elementor();

