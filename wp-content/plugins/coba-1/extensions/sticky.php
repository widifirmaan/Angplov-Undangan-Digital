<?php

namespace WeddingPress\Elementor;

use Elementor\Controls_Manager;
use Elementor\Utils;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Wdp_Sticky {

    public static function init() {
        
        add_action( 'elementor/frontend/column/before_render', array( __CLASS__, 'before_render' ) );
        
        add_action( 'elementor/element/section/section_advanced/after_section_end', array( __CLASS__, 'register_controls' ), 10 );
        add_action( 'elementor/element/column/section_advanced/after_section_end', array( __CLASS__, 'register_controls' ), 10 );
        add_action( 'elementor/element/common/_section_style/after_section_end', array( __CLASS__, 'register_controls' ), 10 );
	}

    public static function register_controls( $section ) {

        $section->start_controls_section(
            'wdp_sticky_section',
            [
                'label' => 'WeddingPress Sticky',
                'tab'   => Controls_Manager::TAB_ADVANCED
            ]
        );
		
		$section->add_control(
            'wdp_enable_section_sticky',
            [
				'label'        => __( 'Sticky', 'weddingpress' ),
				'type'         => Controls_Manager::SWITCHER,
				'default'      => 'no',
                'return_value' => 'yes',
                'render_type'  => 'template',
				'label_on'     => __( 'Yes', 'weddingpress' ),
                'label_off'    => __( 'No', 'weddingpress' ),
                'prefix_class' => 'wdp-sticky-section-',
            ]
        );

        $section->add_control(
            'floating_bar_on_position',
            [
                'label' => __( 'Position', 'weddingpress' ),
                'type' => Controls_Manager::SELECT,
                'default' => 'bottom',
                'options' => [
                    'top' => 'Top',
                    'bottom' => 'Bottom'
                ],
                'condition' => [
                    'wdp_enable_section_sticky' => 'yes'
                ],
                'prefix_class' => 'wdp-sticky-section-positon-',
            ]
        );
        
        $section->end_controls_section();

	}

    public static function before_render( $section ) {

        $settings = $section->get_settings();
        $data     = $section->get_data();
        $type     = isset( $data['elType'] ) ? $data['elType'] : 'column';

        if ( 'column' !== $type ) {
            return false;
        }

        if ( isset( $settings['wdp_enable_section_sticky'] ) ) {

            if ( filter_var( $settings['wdp_enable_section_sticky'], FILTER_VALIDATE_BOOLEAN ) ) {

                $section->add_render_attribute( '_wrapper', array(
                    'class'         => 'wdp-column-sticky',
                    'data-type' => $type,
                    'data-top_spacing' => $settings['wdp_sticky_top_spacing'],
                ) );

                $section->sticky_columns[] = $data['id'];
            }
        }

    }

}

Wdp_Sticky::init();
