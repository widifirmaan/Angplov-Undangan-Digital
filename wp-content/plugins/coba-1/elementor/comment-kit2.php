<?php

namespace WeddingPress\elementor;

// Elementor Classes.
use Elementor\Controls_Manager;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Typography;
use Elementor\Core\Kits\Documents\Tabs\Global_Colors;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;
use Elementor\Utils;
use Elementor\Widget_Base;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Weddingpress_Widget_Comment_Kit2 extends Widget_Base {

	public function get_name() {
		return 'weddingpress-kit2';
	}

	public function get_title() {
		return __( 'Comment Kit 2', 'weddingpress' );
	}

	public function get_icon() {
		return 'elkit_icon eicon-testimonial';
	}

	public function get_categories() {
		return [ 'weddingpress' ];
	}

	// public function get_script_depends() {
    //     return [ 'wdp-script' ];
    // }
	
	public function get_keywords() {
		return [ 'Comment Box, buku tamu, ucapan selamat' ];
	}

    public function get_custom_help_url() {
        return 'https://member.elementorkit.net';
	}
	
	 /**
     * Register button widget controls.
     *
     * Adds different input fields to allow the user to change and customize the widget settings.
     *
     * @since 0.1.0
     * @access protected
     */

    protected function register_controls() {
        $this->start_controls_section(
            'section_product',
            [
                'label' => __( 'Comment Kit 2', 'weddingpress' ),
            ]
        );

        $this->add_control(
			'important_description',
			[
				'raw' => __( '<b>PENTING!:</b> Widget Comment Kit 2, pastikan sudah mensetting comment di wordpress. Custom style ada di menu Comment Kit 2', 'weddingpress'),
				'content_classes' => 'elementor-panel-alert elementor-panel-alert-info',
				'render_type'     => 'ui',
				'type'            => Controls_Manager::RAW_HTML,
			]
		);

        $this->add_control(
            'style_type',
            [
                'label' => __( 'Style', 'weddingpress' ),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    '' => '— ' . __( 'Select', 'weddingpress' ) . ' —',
                    'facebook' => __( 'Facebook', 'weddingpress' ),
                    'golden' => __( 'Golden', 'weddingpress' ),
                    'dark' => __( 'Dark', 'weddingpress' ),
                    'custom' => __( 'Custom', 'weddingpress' ),
                    
                ],
                'default' => 'facebook',

            ]
        );

        $this->end_controls_section();

    }

    private function get_shortcode() {
        $settings = $this->get_settings();

        
        $this->add_render_attribute( 'shortcode', 'style', $settings['style_type'] );

        $shortcode = sprintf( '[ck2 %s]', $this->get_render_attribute_string( 'shortcode' ) );

        return $shortcode;
    }

    protected function render() {
        $shortcode = $this->get_shortcode();

        if ( empty( $shortcode ) ) {
            return;
        }

        $html = do_shortcode( $shortcode );
        echo $html;
        
    }

    public function render_plain_content() {
        echo $this->get_shortcode();
    }

}
