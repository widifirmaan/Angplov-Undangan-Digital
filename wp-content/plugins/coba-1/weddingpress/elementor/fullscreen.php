<?php

namespace WeddingPress\elementor;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Image_Size;
use Elementor\Utils;
use Elementor\Icons_Manager;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Text_Shadow;
use Elementor\Core\Schemes\Color as Scheme_Color;
use Elementor\Core\Schemes\Typography as Scheme_Typography;
use Elementor\Widget_Base;

if (!defined('ABSPATH')) exit; // Exit if accessed directly

class WeddingPress_Widget_FullScreen extends Widget_Base {

    public function get_name() {
        return 'wdp-fullscreen';
    }

    public function get_title() {
        return __( 'Invitation Full Screen', 'weddingpress' );
    }

    public function get_icon() {
        return 'elkit_icon eicon-site-identity';
    }

    public function get_categories() {
        return [ 'weddingpress' ];
    }

    // public function get_script_depends() {
    //     return [ 'weddingpress' ];
    // }

    public function get_custom_help_url() {
        return 'https://membershipdigital.com';
    }

    /**
     * Register button widget controls.
     *
     * Adds different input fields to allow the user to change and customize the widget settings.
     *
     * @since 0.1.0
     * @access protected
     */

    protected function register_controls(){

        $this->start_controls_section(
            'section_form',
            [
                'label' => __('Invitation Full Screen', 'weddingpress'),
            ]
        );

        $this->add_control(
            'image_wedding',
            [
                'label' => esc_html__( 'Upload Foto Pempelai', 'weddingpress' ),
                'type'  => Controls_Manager::MEDIA,
                'media_type' => 'image',
            ]
        );

        $this->add_control(
            'text_wedding',
            [
                'label' => __('Nama Mempelai', 'weddingpress'),
                'type' => Controls_Manager::TEXT,
                'default' => '',
                'placeholder' => 'Andy & Fitry',
                'label_block' => true,
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'text_dear',
            [
                'label' => __('Dear/To', 'weddingpress'),
                'type' => Controls_Manager::TEXTAREA,
                'default' => 'Kpd Bpk/Ibu/Saudara/i',
                'placeholder' => 'Kpd Bpk/Ibu/Saudara/i',
                'label_block' => true,
                'separator' => 'before',
            ]
        );
        
        $this->add_responsive_control(
            'align_dear',
            [
                'label' => __('Alignment', 'weddingpress'),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'left' => [
                        'title' => __('Left', 'weddingpress'),
                        'icon' => 'eicon-text-align-left',
                    ],
                    'fullwidth' => [
                        'title' => __('Center', 'weddingpress'),
                        'icon' => 'eicon-text-align-center',
                    ],
                    'right' => [
                        'title' => __('Right', 'weddingpress'),
                        'icon' => 'eicon-text-align-right',
                    ],
                ],
                'toggle' => true,
                'default' => 'center',
                'selectors' => [
                    '{{WRAPPER}} .wdp-dear' => 'text-align: {{VALUE}};'
                ],
            ]
        );

        $this->add_control(
            'text',
            [
                'label' => __('Invitation Text', 'weddingpress'),
                'type' => Controls_Manager::TEXTAREA,
                'default' => 'Tanpa Mengurangi Rasa Hormat, Kami Mengundang Anda Untuk Berhadir Di Acara Pernikahan Kami.',
                'placeholder' => 'Text undangan',
                'label_block' => true,
                'separator' => 'before',
            ]
        );
        
        $this->add_responsive_control(
            'align_text',
            [
                'label' => __('Alignment', 'weddingpress'),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'left' => [
                        'title' => __('Left', 'weddingpress'),
                        'icon' => 'eicon-text-align-left',
                    ],
                    'fullwidth' => [
                        'title' => __('Center', 'weddingpress'),
                        'icon' => 'eicon-text-align-center',
                    ],
                    'right' => [
                        'title' => __('Right', 'weddingpress'),
                        'icon' => 'eicon-text-align-right',
                    ],
                ],
                'toggle' => true,
                'default' => 'center',
                'selectors' => [
                    '{{WRAPPER}} .wdp-text' => 'text-align: {{VALUE}};'
                ],
            ]
        );

        $this->add_control(
            'text_open',
            [
                'label' => __('Button Text', 'weddingpress'),
                'type' => Controls_Manager::TEXT,
                'default' => 'Buka Undangan',
                'placeholder' => 'Text undangan',
                'label_block' => true,
                'separator' => 'before',
            ]
        );


        $this->add_control(
            'selected_icon',
            [
                'label' => __( 'Icon', 'weddingpress' ),
                'type' => Controls_Manager::ICONS,
                'label_block' => true,
                'fa4compatibility' => 'icon',
            ]
        );
        
        $this->add_control(
            'src_type',
            [
                'label' => esc_html__( 'Background Source', 'weddingpress' ),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'upload',
                'options' => [
                    'upload' => esc_html__( 'Upload Image', 'weddingpress' ),
                    'link' => esc_html__( 'Image Link', 'weddingpress' ),
                ],
                'separator' => 'before',
            ]
        );
        
        $this->add_control(
            'image_upload',
            array(
                'label' => esc_html__( 'Upload Image', 'weddingpress' ),
                'type'  => \Elementor\Controls_Manager::MEDIA,
                'media_type' => 'image',
                'condition' => array(
                    'src_type' => 'upload',
                ),
            )
        );

        $this->add_control(
            'image_link',
            [
                'label' => esc_html__( 'Image Link', 'weddingpress' ),
                'type' => \Elementor\Controls_Manager::URL,
                'placeholder' => esc_html__( 'https://example.com/picture.jpeg', 'weddingpress' ),
                'show_external' => false,
                'default' => [
                    'url' => '',
                    'is_external' => false,
                    'nofollow' => false,
                ],
                'condition' => [
                    'src_type'    =>  'link',
                ]
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'wpkoi_elements_countdown_box_bg_heading',
            [
                'label' => esc_html__( 'Background', 'wpkoi-elements' ),
                'tab' => Controls_Manager::TAB_STYLE
            ]
        );
        
        $this->add_group_control(
            Group_Control_Background::get_type(),
            array(
                'name'     => 'popup_bg',
                'label'    => __( 'Background', 'powerpack' ),
                'types'    => array( 'classic', 'gradient' ),
                'selector' => '{{WRAPPER}} .overlayy',
            )
        );

        $this->add_control(
            'opacity_invitation',
            [
                'label' => __( 'Opacity (%)', 'elementor' ),
                'type' => Controls_Manager::SLIDER,
                'default' => [
                    'size' => .5,
                ],
                'range' => [
                    'px' => [
                        'max' => 1,
                        'step' => 0.01,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .overlayy' => 'opacity: {{SIZE}};',
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'wdp_invitation_section_styles_general',
            [
                'label' => esc_html__( 'Space', 'weddingpress' ),
                'tab' => Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_responsive_control(
            'wdp_invitation_spacing',
            [
                'label' => esc_html__( 'Space Between Text', 'weddingpress' ),
                'type' => Controls_Manager::SLIDER,
                'default' => [
                    'size' => 15,
                ],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .wdp-text' => 'margin-top:{{SIZE}}px;',
                    '{{WRAPPER}} .wdp-dear' => 'margin-top:{{SIZE}}px;',
                    '{{WRAPPER}} .wdp-name' => 'margin-top:{{SIZE}}px;',
                ],
            ]
        );
        
        $this->add_responsive_control(
            'wdp_invitation_container_margin_bottom',
            [
                'label' => esc_html__( 'Space Button', 'weddingpress' ),
                'type' => Controls_Manager::SLIDER,
                'default' => [
                    'size' => 10,
                ],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .wdp-button-wrapper' => 'margin-top:{{SIZE}}px;',
                ],
            ]
        );
        
        
        $this->end_controls_section();


        $this->start_controls_section(
            'section_style_image',
            [
                'label' => __( 'Image', 'elementor' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'width',
            [
                'label' => __( 'Width', 'elementor' ),
                'type' => Controls_Manager::SLIDER,
                'default' => [
                    'unit' => '%',
                ],
                'tablet_default' => [
                    'unit' => '%',
                ],
                'mobile_default' => [
                    'unit' => '%',
                ],
                'size_units' => [ '%', 'px', 'vw' ],
                'range' => [
                    '%' => [
                        'min' => 1,
                        'max' => 100,
                    ],
                    'px' => [
                        'min' => 1,
                        'max' => 1000,
                    ],
                    'vw' => [
                        'min' => 1,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-image img' => 'width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'space',
            [
                'label' => __( 'Max Width', 'elementor' ),
                'type' => Controls_Manager::SLIDER,
                'default' => [
                    'unit' => '%',
                ],
                'tablet_default' => [
                    'unit' => '%',
                ],
                'mobile_default' => [
                    'unit' => '%',
                ],
                'size_units' => [ '%', 'px', 'vw' ],
                'range' => [
                    '%' => [
                        'min' => 1,
                        'max' => 100,
                    ],
                    'px' => [
                        'min' => 1,
                        'max' => 1000,
                    ],
                    'vw' => [
                        'min' => 1,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-image img' => 'max-width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'height',
            [
                'label' => __( 'Height', 'elementor' ),
                'type' => Controls_Manager::SLIDER,
                'default' => [
                    'unit' => 'px',
                ],
                'tablet_default' => [
                    'unit' => 'px',
                ],
                'mobile_default' => [
                    'unit' => 'px',
                ],
                'size_units' => [ 'px', 'vh' ],
                'range' => [
                    'px' => [
                        'min' => 1,
                        'max' => 500,
                    ],
                    'vh' => [
                        'min' => 1,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-image img' => 'height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'object-fit',
            [
                'label' => __( 'Object Fit', 'elementor' ),
                'type' => Controls_Manager::SELECT,
                'condition' => [
                    'height[size]!' => '',
                ],
                'options' => [
                    '' => __( 'Default', 'elementor' ),
                    'fill' => __( 'Fill', 'elementor' ),
                    'cover' => __( 'Cover', 'elementor' ),
                    'contain' => __( 'Contain', 'elementor' ),
                ],
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .elementor-image img' => 'object-fit: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'separator_panel_style',
            [
                'type' => Controls_Manager::DIVIDER,
                'style' => 'thick',
            ]
        );

        $this->start_controls_tabs( 'image_effects' );

        $this->start_controls_tab( 'normal',
            [
                'label' => __( 'Normal', 'elementor' ),
            ]
        );


        $this->end_controls_tab();

        $this->start_controls_tab( 'hover',
            [
                'label' => __( 'Hover', 'elementor' ),
            ]
        );


        $this->add_control(
            'hover_animation',
            [
                'label' => __( 'Hover Animation', 'elementor' ),
                'type' => Controls_Manager::HOVER_ANIMATION,
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'image_border',
                'selector' => '{{WRAPPER}} .elementor-image img',
                'separator' => 'before',
            ]
        );

        $this->add_responsive_control(
            'image_border_radius',
            [
                'label' => __( 'Border Radius', 'elementor' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-image img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'image_box_shadow',
                'exclude' => [
                    'box_shadow_position',
                ],
                'selector' => '{{WRAPPER}} .elementor-image img',
            ]
        );

        $this->end_controls_section();
           

        $this->start_controls_section(
            'section_elkit_mempelai_style',
            [
                'label'                 => __( 'Nama Mempelai', 'weddingpress' ),
                'tab'                   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'                  => 'elkit_mempelai_typography',
                'label'                 => __( 'Typography', 'weddingpress' ),
                'selector'              => '{{WRAPPER}} .wdp-mempelai',
            ]
        );

        $this->add_control(
            'elkit_mempelai_text_color',
            [
                'label'                 => __( 'Text Color', 'weddingpress' ),
                'type'                  => Controls_Manager::COLOR,
                'selectors'             => [
                    '{{WRAPPER}} .wdp-mempelai' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->end_controls_section();

        /**
         * Style Tab: Dear
         */
        $this->start_controls_section(
            'section_wdp_name_style',
            [
                'label'                 => __( 'Invitation Name', 'weddingpress' ),
                'tab'                   => Controls_Manager::TAB_STYLE,
            ]
        );
        
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'                  => 'wdp_name_typography',
                'label'                 => __( 'Typography', 'weddingpress' ),
                'selector'              => '{{WRAPPER}} .wdp-name',
            ]
        );

        $this->add_control(
            'wdp_name_text_color',
            [
                'label'                 => __( 'Text Color', 'weddingpress' ),
                'type'                  => Controls_Manager::COLOR,
                'default'               => '',
                'selectors'             => [
                    '{{WRAPPER}} .wdp-name' => 'color: {{VALUE}}',
                ],
            ]
        );
        
        $this->end_controls_section();

        /**
         * Style Tab: Product or Description
         */
        $this->start_controls_section(
            'section_wdp_text_style',
            [
                'label'                 => __( 'Invitation Text', 'weddingpress' ),
                'tab'                   => Controls_Manager::TAB_STYLE,
            ]
        );
        
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'                  => 'wdp_text_typography',
                'label'                 => __( 'Typography', 'weddingpress' ),
                'selector'              => '{{WRAPPER}} .wdp-text',
            ]
        );

        $this->add_control(
            'wdp_text_text_color',
            [
                'label'                 => __( 'Text Color', 'weddingpress' ),
                'type'                  => Controls_Manager::COLOR,
                'default'               => '',
                'selectors'             => [
                    '{{WRAPPER}} .wdp-text' => 'color: {{VALUE}}',
                ],
            ]
        );
        
        $this->end_controls_section();

        /**
         * Style Tab: Dear
         */
        $this->start_controls_section(
            'section_wdp_dear_style',
            [
                'label'                 => __( 'Dear/To', 'weddingpress' ),
                'tab'                   => Controls_Manager::TAB_STYLE,
            ]
        );
        
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'                  => 'wdp_dear_typography',
                'label'                 => __( 'Typography', 'weddingpress' ),
                'selector'              => '{{WRAPPER}} .wdp-dear',
            ]
        );

        $this->add_control(
            'wdp_dear_text_color',
            [
                'label'                 => __( 'Text Color', 'weddingpress' ),
                'type'                  => Controls_Manager::COLOR,
                'default'               => '',
                'selectors'             => [
                    '{{WRAPPER}} .wdp-dear' => 'color: {{VALUE}}',
                ],
            ]
        );
        
        $this->end_controls_section();

        $this->start_controls_section(
            'section_button_style',
            [
                'label' => __( 'Button', 'weddingpress' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->start_controls_tabs( 'tabs_button_style' );

        $this->start_controls_tab(
            'tab_button_normal',
            [
                'label' => __( 'Normal', 'weddingpress' ),
            ]
        );

        $this->add_control(
            'button_text_color',
            [
                'label' => __( 'Text Color', 'weddingpress' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} a.elementor-button, {{WRAPPER}} .elementor-button' => 'fill: {{VALUE}}; color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'typography',
                'label' => __( 'Typography', 'weddingpress' ),
                'scheme' => Scheme_Typography::TYPOGRAPHY_4,
                'selector' => '{{WRAPPER}} a.elementor-button, {{WRAPPER}} .elementor-button',
            ]
        );

        $this->add_control(
            'background_color',
            [
                'label' => __( 'Background Color', 'weddingpress' ),
                'type' => Controls_Manager::COLOR,
                'scheme' => [
                    'type' => Scheme_Color::get_type(),
                    'value' => Scheme_Color::COLOR_4,
                ],
                'selectors' => [
                    '{{WRAPPER}} a.elementor-button, {{WRAPPER}} .elementor-button' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'border',
                'label' => __( 'Border', 'weddingpress' ),
                'placeholder' => '1px',
                'selector' => '{{WRAPPER}} .elementor-button',
            ]
        );

        $this->add_control(
            'border_radius',
            [
                'label' => __( 'Border Radius', 'weddingpress' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'selectors' => [
                    '{{WRAPPER}} a.elementor-button, {{WRAPPER}} .elementor-button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'text_padding',
            [
                'label' => __( 'Text Padding', 'weddingpress' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors' => [
                    '{{WRAPPER}} a.elementor-button, {{WRAPPER}} .elementor-button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'separator' => 'before',
            ]
        );
        
        $this->add_responsive_control(
            'button_margin',
            [
                'label' => __( 'Margin', 'weddingpress' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-button' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'tab_button_hover',
            [
                'label' => __( 'Hover', 'weddingpress' ),
            ]
        );

        $this->add_control(
            'hover_color',
            [
                'label' => __( 'Text Color', 'weddingpress' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} a.elementor-button:hover, {{WRAPPER}} .elementor-button:hover, {{WRAPPER}} a.elementor-button:focus, {{WRAPPER}} .elementor-button:focus' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'button_background_hover_color',
            [
                'label' => __( 'Background Color', 'weddingpress' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} a.elementor-button:hover, {{WRAPPER}} .elementor-button:hover, {{WRAPPER}} a.elementor-button:focus, {{WRAPPER}} .elementor-button:focus' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'button_hover_border_color',
            [
                'label' => __( 'Border Color', 'weddingpress' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} a.elementor-button:hover, {{WRAPPER}} .elementor-button:hover, {{WRAPPER}} a.elementor-button:focus, {{WRAPPER}} .elementor-button:focus' => 'border-color: {{VALUE}};',
                ],
            ]
        );


        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->end_controls_section();
        
    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        $this->add_render_attribute('form_wrapper', 'class', 'modalx');
        $this->add_inline_editing_attributes( 'text', 'none' );
        $this->add_inline_editing_attributes( 'text_open', 'none' );
        $this->add_inline_editing_attributes( 'text_dear', 'none' );
        if($settings['src_type'] == 'upload'){
            $image_link = $settings['image_upload']['url'];
        } else {
            $image_link = $settings['image_link']['url'];
        }
        
        $image_html = Group_Control_Image_Size::get_attachment_image_html( $settings, 'thumbnail', 'image_wedding' );

        $this->add_render_attribute( 'button', 'class', 'elementor-button' );  
        

        $this->add_render_attribute( 'content-wrapper', 'class', 'elementor-button-content-wrapper' );

        $migrated = isset( $settings['__fa4_migrated']['selected_icon'] );
        $is_new = empty( $settings['icon'] ) && Icons_Manager::is_migration_allowed();

        ?>
        
        <div class="modalx" data-sampul='<?php echo esc_url($image_link); ?>'>
        
            <div class="overlayy"></div>
                <div class="content-modalx">
                    <div class="info_modalx">
                            <?php if ( $settings['image_wedding'] ) : ?>
                                <div class="elementor-image img"><?php echo $image_html; ?></div>
                        <?php endif; ?>
                        <?php if ( $settings['text_wedding'] ) : ?>
                                <div class="wdp-mempelai" <?php $this->print_render_attribute_string( 'text_wedding' ); ?>><?php echo esc_html( $settings['text_wedding'] ); ?>
                                </div>
                        <?php endif; ?>
                        <?php if ( $settings['text_dear'] ) : ?>
                                <div class="wdp-dear" <?php $this->print_render_attribute_string( 'text_dear' ); ?>><?php echo esc_html( $settings['text_dear'] ); ?></div>
                        <?php endif; ?>
                        <div class="wdp-name"><?php echo $_GET['to']; ?></div>
                            <?php if ( $settings['text'] ) : ?>
                                <div class="wdp-text" <?php $this->print_render_attribute_string( 'text' ); ?>><?php echo esc_html( $settings['text'] ); ?></div>
                            <?php endif; ?>
                        <?php if ( $settings['text_open'] ) : ?>
                        <div class="wdp-button-wrapper" id="wdp-button-wrapper">
                            <button class="elementor-button">
                                <?php if ( ! empty( $settings['icon'] ) || ! empty( $settings['selected_icon']['value'] ) ) : ?>
                                <span <?php echo $this->get_render_attribute_string( 'icon-align' ); ?>>
                                    <?php if ( $is_new || $migrated ) :
                                        Icons_Manager::render_icon( $settings['selected_icon'], [ 'aria-hidden' => 'true' ] );
                                    else : ?>
                                        <i class="<?php echo esc_attr( $settings['icon'] ); ?>" aria-hidden="true"></i>
                                    <?php endif; ?>
                                </span>
                                <?php endif; ?>
                                <?php echo esc_html( $settings['text_open'] ); ?>
                            </button>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
        </div>
        
        <script>
            const sampul = jQuery('.modalx').data('sampul');
            jQuery('.modalx').css('background-image','url('+sampul+')');
            jQuery('body').css('overflow','hidden');
            jQuery('.wdp-button-wrapper button').on('click',function(){
                jQuery('.modalx').addClass('removeModals');
                jQuery('body').css('overflow','auto');

            });
        </script>
        <script>
            var z = document.querySelector('#wdp-button-wrapper');
            z.addEventListener("click", function(event) {
                document.getElementById("song").play();
                document.documentElement.requestFullscreen();
            });
        </script>
        <?php
    }

    public function on_import( $element ) {
        return Icons_Manager::on_import_migration( $element, 'icon', 'selected_icon' );
    }

    /**
       * Render the widget output in the editor.
       *
       * Written as a Backbone JavaScript template and used to generate the live preview.
       *
       * @since 1.1.0
       *
       * @access protected
       */
    protected function content_template() {
    }
}