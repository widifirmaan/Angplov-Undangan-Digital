<?php
namespace Elementor;


use Elementor\Core\Common\Modules\Ajax\Module as ElementorAjax;


//Weddingpress Templates & Blocks Library MANAGER
if (!defined('ABSPATH')) exit; 

class WDP_Templates_Library_Manager{
	protected static $tp_library_source = null;
    private static $instance = null;
	public static function instance() {
        if ( is_null( self::$instance ) ) {
            self::$instance = new self();
            self::$instance->init();
        }
        return self::$instance;
    }


	public static function init() {
		add_action( 'elementor/editor/footer', [__CLASS__, 'print_html_views']);
		add_action( 'elementor/ajax/register_actions', [__CLASS__, 'ajax_calls']);
		add_action( 'elementor/editor/after_enqueue_scripts', [ __CLASS__, 'enqueue_library_assets_js']);
	}

	public static function get_source() {
		if ( is_null( self::$tp_library_source ) ) {
			self::$tp_library_source = new WDP_Templates_Library();
		}
		return self::$tp_library_source;
	}


	public static function enqueue_library_assets_js() {
		wp_enqueue_script('weddingpress-elementor-library', WEDDINGPRESS_ELEMENTOR_URL . 'admin/assets/js/weddingpress-library.js',['elementor-editor','jquery-hover-intent'],WEDDINGPRESS_ELEMENTOR_VERSION,true);
		$localize_script = [
			'noTemplateFoundTitle' => esc_html__('No Templates Found', 'weddingpress'),
			'noTemplateFoundMessage' => esc_html__('Try different category or sync for new templates.', 'weddingpress'),
			'noTemplateResultTitle' => esc_html__('No Results Found', 'weddingpress'),
			'noTemplateResultMessage' => esc_html__('Please make sure your search is spelled correctly or try a different words.', 'weddingpress'),
			'ASSETS_URL' => WEDDINGPRESS_ELEMENTOR_URL
		];
		wp_localize_script('weddingpress-elementor-library','weddingpressElementorLocal',$localize_script);		
		wp_enqueue_style('weddingpress-elementor-library',WEDDINGPRESS_ELEMENTOR_URL . 'admin/assets/css/weddingpress-library.css',[],WEDDINGPRESS_ELEMENTOR_VERSION);
	}




	public static function print_html_views() {
		include_once WEDDINGPRESS_ELEMENTOR_PATH . 'library/views.php';
	}

	public static function ajax_calls(ElementorAjax $ajax){
		//Requet Library Data
		$ajax->register_ajax_action('get_weddingpress_library_data', function( $data ) {
			if ( ! current_user_can( 'edit_posts' ) ) {
				throw new \Exception( 'Access Denied' );
			}
			if ( ! empty( $data['editor_post_id'] ) ) {
				$editor_post_id = absint( $data['editor_post_id'] );
				if ( ! get_post( $editor_post_id ) ) {
					throw new \Exception( __( 'Post not found.', 'weddingpress' ) );
				}
			}
			$result = self::get_library_data( $data );
			return $result;			
		});

		//Request Single Template Data
		$ajax->register_ajax_action('get_weddingpress_single_template_data', function( $data ) {
			if (!current_user_can('edit_posts')) {
				throw new \Exception('Access Denied');
			}
			if ( ! empty( $data['editor_post_id'])) {
				$editor_post_id = absint( $data['editor_post_id'] );
				if (!get_post( $editor_post_id)) {
					throw new \Exception( __('Post not found', 'weddingpress'));
				}
			}
			if ( empty( $data['template_id'] ) ) {
				throw new \Exception( __( 'Template id missing', 'weddingpress' ) );
			}
			$result = self::get_single_template_data( $data );
			return $result;
		} );
	}

	public static function get_library_data( array $args ) {
		$source = self::get_source();

		if ( ! empty( $args['sync'] ) ) {
			WDP_Templates_Library::get_library_data( true );
		}
		$data = $source->get_items();
		return [
			'templates' => $data['templates'] ,
			'tags' => $data['tags']
		];
	}

	public static function get_single_template_data( array $args ) {
		$source = self::get_source();
		$data = $source->get_data( $args );
		return $data;
	}




}