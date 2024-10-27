<?php


if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// define( 'EL_WIDGET_MANAGER_PATH', plugin_dir_path( __FILE__ ) );
// define( 'EL_WIDGET_MANAGER_URL', plugin_dir_url( __FILE__ ) );
// define( 'EL_WIDGET_MANAGER_VERSION', '1.0.1' );



/**
 * Elementor Widget Manager class.
 *
 * The main class that initiates and runs the plugin.
 *
 * @since 1.0.0
 */
class Elementor_Widget_Manager {

	/**
	 * Holds all registered Elementor's widgets.
	 *
	 * @since 1.0.0
	 *
	 * @var array Getting all the widgets for react.
	 */
	public $widgets = array();

	/**
	 * Instance
	 *
	 * @since 1.0.0
	 *
	 * @access private
	 * @static
	 *
	 * @var Elementor_Widget_Manager The single instance of the class.
	 */
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
	 * @return Elementor_Widget_Manager An instance of the class.
	 */
	public static function instance() {
		if ( is_null( self::$instance ) ) {
			self::$instance = new self(); // Self here denotes the class name.
		}

		return self::$instance;
	}

	/**
	 * Constructor
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 */
	public function __construct() {

		// Action to see if conditions are met as plugin is loaded.
		add_action( 'plugins_loaded', array( $this, 'init' ) );
	}


	/**
	 * Initialize the plugin.
	 *
	 * Load the plugin only after Elementor (and other plugins) are loaded.
	 * Check for basic plugin requirements, if one check fail don't continue,
	 * if all check have passed load the files required to run the plugin.
	 *
	 * Fired by `plugins_loaded` action hook.
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function init() {

		$this->includes();

		add_action( 'elementor/widgets/widgets_registered', array( $this, 'unregister_widgets' ), 99 );
	}

	/**
	 * Includes.
	 *
	 * Include required files.
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function includes() {
		require_once 'class-widget-manager-loader.php';
	}


	/**
	 * Unregister Widget.
	 *
	 * Unregistering the selected widget.
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function unregister_widgets() {
		$elementor = Elementor\Plugin::instance();

		if ( ! $elementor->editor->is_edit_mode() ) {
			return;
		}

		$selected_widgets = get_option( 'ewm_widget' );

		if ( ! empty( $selected_widgets ) ) {
			foreach ( $selected_widgets as $widget ) {
				$elementor->widgets_manager->unregister_widget_type( $widget );
			}
		}
	}

	/**
	 * Get registered widgets.
	 *
	 * Get all registered widgets of Elementor.
	 *
	 * @since 1.0.0
	 *
	 * @return array
	 */
	public function get_registered_widgets() {
		if ( ! empty( $this->widgets ) ) {
			return $this->widgets;
		}

		$elementor = Elementor\Plugin::instance();

		// Fetching all the widget types names and its properties.
		$types = $elementor->widgets_manager->get_widget_types();

		$categories = $this->get_categories();

		$widgets = array();

		foreach ( $types as $type ) {
			$widget_cat = $type->get_categories();

			if ( ! in_array( $widget_cat[0], $categories, true ) ) {
				continue;
			}
			$widgets[ $type->get_name() ] = $type->get_title();
		}

		if ( isset( $widgets['common'] ) ) {
			unset( $widgets['common'] );
		}

		asort( $widgets );

		$this->widgets = $widgets;

		return $widgets;
	}

	/**
	 * Categories Function.
	 *
	 * Getting Categories to compare with Elementor categories.
	 *
	 * @since 1.0.0
	 *
	 * @return array
	 */
	public function get_categories() {
		return array(
			'weddingpress',
		);
	}
}

Elementor_Widget_Manager::instance();
