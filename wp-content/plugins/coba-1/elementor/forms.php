<?php

namespace WeddingPress\elementor;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Typography;
use Elementor\Repeater;
use Elementor\Core\Schemes\Color as Scheme_Color;
use Elementor\Core\Schemes\Typography as Scheme_Typography;
use Elementor\Widget_Base;

if (!defined('ABSPATH')) exit; // Exit if accessed directly

class WeddingPress_Widget_Forms extends Widget_Base {

    public function get_name() {
        return 'weddingpress-forms';
    }

    public function get_title() {
        return __( 'Forms', 'weddingpress' );
    }

    public function get_icon() {
        return 'elkit_icon eicon-form-horizontal';
    }

    public function get_categories() {
        return [ 'weddingpress' ];
    }

    public function get_script_depends() {
        return [ 'weddingpress' ];
    }

    public function get_keywords() {
        return [ 'forms, wa forms' ];
    }

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

    protected function register_controls()
    {

        $this->start_controls_section(
            'section_form',
            [
                'label' => __('Form Whatsapp', 'weddingpress'),
            ]
        );

        $this->add_control(
            'phone',
            [
                'label' => __('No. Whatsapp', 'weddingpress'),
                'type' => Controls_Manager::TEXT,
                'default' => '',
                'placeholder' => '081xxxxx',
                'label_block' => true,
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'message',
            [
                'label' => __('Pesan', 'weddingpress'),
                'type' => Controls_Manager::TEXTAREA,
                'rows' => '6',
                'default' => "Hai, saya %nama% ingin konfirmasi kehadiran pada undangan pernikahan digital bahwa %option% bersama %jumlah% orang. Saya ucapkan:  _*%pesan%*_. Terima kasih ya.",
                'placeholder' => "Hai, saya %nama% ingin konfirmasi kehadiran pada undangan pernikahan digital bahwa %option% bersama %jumlah% orang. Saya ucapkan:  _*%pesan%*_. Terima kasih ya.",
                'label_block' => true,
            ]
        );

        $this->add_control(
            'message_params',
            [
                'raw' => __('Parameters: <br/><strong><u>%option%</u></strong> <strong><u>%nama%</u></strong> <strong><u>%pesan%</u></strong> <strong><u>%jumlah%</u></strong>', 'weddingpress'),
                'type' => Controls_Manager::RAW_HTML,
                'classes' => 'elementor-descriptor',
            ]
        );

        $this->add_control(
            'form_labels',
            [
                'label' => __('Form Labels', 'weddingpress'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => __('Show', 'weddingpress'),
                'label_off' => __('Hide', 'weddingpress'),
                'return_value' => 'yes',
                'default' => 'yes',
                'separator' => 'none',
            ]
        );

        $this->add_control(
            'form_placeholders',
            [
                'label' => __('Form Placeholders', 'weddingpress'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => __('Show', 'weddingpress'),
                'label_off' => __('Hide', 'weddingpress'),
                'return_value' => 'yes',
                'default' => '',
                'separator' => 'none',
            ]
        );

         $this->add_control(
            'field_nama_label',
            [
                'label' => __('Name Label', 'weddingpress'),
                'type' => Controls_Manager::TEXT,
                'default' => __('Nama', 'weddingpress'),
                'placeholder' => __('Nama', 'weddingpress'),
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'field_nama_placeholder',
            [
                'label' => __('Name Placeholder', 'weddingpress'),
                'type' => Controls_Manager::TEXT,
                'default' => __('Nama', 'weddingpress'),
                'placeholder' => __('Nama', 'weddingpress'),
                'condition' => [
                    'form_placeholders' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'field_jumlah_label',
            [
                'label' => __('Jumlah Label', 'weddingpress'),
                'type' => Controls_Manager::TEXT,
                'default' => __('Jumlah', 'weddingpress'),
                'placeholder' => __('Jumlah', 'weddingpress'),
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'field_jumlah_placeholder',
            [
                'label' => __('Jumlah Placeholder', 'weddingpress'),
                'type' => Controls_Manager::TEXT,
                'default' => __('Jumlah', 'weddingpress'),
                'placeholder' => __('Jumlah', 'weddingpress'),
                'condition' => [
                    'form_placeholders' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'hide_jumlah',
            [
                'label' => __('Hide Jumlah', 'weddingpress'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => 'Hide',
                'label_off' => 'Show',
                'return_value' => 'hide',
            ]
        );

        $this->add_control(
            'field_pesan_label',
            [
                'label' => __('Message Label', 'weddingpress'),
                'type' => Controls_Manager::TEXT,
                'default' => __('Pesan', 'weddingpress'),
                'placeholder' => __('Pesan', 'weddingpress'),
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'field_pesan_placeholder',
            [
                'label' => __('Message Placeholder', 'weddingpress'),
                'type' => Controls_Manager::TEXT,
                'default' => __('Pesan', 'weddingpress'),
                'placeholder' => __('Pesan', 'weddingpress'),
                'condition' => [
                    'form_placeholders' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'hide_pesan',
            [
                'label' => __('Hide Message', 'weddingpress'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => 'Hide',
                'label_off' => 'Show',
                'return_value' => 'hide',
            ]
        );

        $this->add_control(
            'field_option_label',
            [
                'label' => __('Options Title', 'weddingpress'),
                'type' => Controls_Manager::TEXT,
                'default' => __('Konfirmasi', 'weddingpress'),
                'placeholder' => __('Konfirmasi', 'weddingpress'),
                'separator' => 'before',
            ]
        );

        /**
         * Tambahan
         * @by Hadie Danker
         */
        $this->add_control(
            'display_option_type',
            [
                'label' => __('Selection Type', 'weddingpress'),
                'type' => Controls_Manager::SELECT,
                'options' => array(
                    'radio' => __('Radio Button', 'weddingpress'),
                    'select' => __('Select', 'weddingpress')
                ),
                'default' => 'radio',
                
            ]
        );

        $repeater = new Repeater();

        $repeater->add_control(
            'opsi',
            [
                'label' => __('Options', 'weddingpress'),
                'type' => Controls_Manager::TEXT,
                'placeholder' => __('Pilihan', 'weddingpress'),
                'label_block' => true,
            ]
        );

        $this->add_control(
            'option',
            [
                'label' => __('Options', 'weddingpress'),
                'type' => Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'show_label' => true,
                'default' => [
                    [
                        'opsi'      => 'Iya, Saya akan Datang',
                    ],
                    [
                        'opsi'      => 'Saya Masih Ragu',
                    ],
                    [
                        'opsi'      => 'Maaf, Saya Tidak Bisa Datang',
                    ],
                ],
                'title_field' => '{{{ opsi }}}',
            ]
        );

        $this->add_control(
            'hide_option',
            [
                'label' => __('Hide Options', 'weddingpress'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => 'Hide',
                'label_off' => 'Show',
                'return_value' => 'hide',
            ]
        );

        $this->add_control(
            'field_submit_align',
            [
                'label' => __('Alignment', 'weddingpress'),
                'type' => Controls_Manager::CHOOSE,
                'default' => 'left',
                'options' => [
                    'left' => [
                        'title' => __('Left', 'weddingpress'),
                        'icon' => 'eicon-text-align-left',
                    ],
                    'fullwidth' => [
                        'title' => __('Justified', 'weddingpress'),
                        'icon' => 'eicon-text-align-justify',
                    ],
                    'right' => [
                        'title' => __('Right', 'weddingpress'),
                        'icon' => 'eicon-text-align-right',
                    ],
                ],
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'field_submit_text',
            [
                'label' => __('Button Text', 'weddingpress'),
                'type' => Controls_Manager::TEXT,
                'default' => __('Reservasi via Whatsapp', 'weddingpress'),
                'placeholder' => __('Reservasi via Whatsapp', 'weddingpress'),
                'label_block' => true,
            ]
        );

        // $this->add_control(
        //     'form_display',
        //     [
        //         'label' => __('Form Display', 'weddingpress'),
        //         'type' => Controls_Manager::SELECT,
        //         'default' => 'default',
        //         'options' => [
        //             'default' => __('Boxed', 'weddingpress'),
        //             'fullwidth' => __('Full Width', 'weddingpress'),
        //         ],
        //         'separator' => 'before',
        //     ]
        // );

        // $this->add_control(
        //     'form_width',
        //     [
        //         'label' => __('Form Width', 'weddingpress'),
        //         'type' => Controls_Manager::SLIDER,
        //         'range' => [
        //             'px' => [
        //                 'min' => 300,
        //                 'max' => 1600,
        //             ],
        //         ],
        //         'size_units' => ['px'],
        //         'default' => [
        //             'size' => '300',
        //             'unit' => 'px',
        //         ],
        //         'selectors' => [
        //             '{{WRAPPER}} .elementor-wdp-form-wrapper input[type="text"], {{WRAPPER}} .elementor-wdp-form-wrapper input[type="jumlah"], {{WRAPPER}} .elementor-wdp-form-wrapper textarea, .elementor-wdp-form-wrapper .contact-form input[type="text"], {{WRAPPER}} .elementor-wdp-form-wrapper .contact-form input[type="jumlah"], {{WRAPPER}} .elementor-wdp-form-wrapper .contact-form textarea, {{WRAPPER}} .elementor-wdp-form-wrapper.elementor-button-width-input input[type="submit"], {{WRAPPER}} .elementor-wdp-form-wrapper.elementor-button-width-input button' => 'min-width: {{SIZE}}{{UNIT}};',
        //         ],
        //         'condition' => [
        //             'form_display' => ['default'],
        //         ],
        //         'show_label' => true,
        //         'separator' => 'none',
        //     ]
        // );


        $this->end_controls_section();


        $this->start_controls_section(
            'section_label_style',
            [
                'label' => __('Form Label', 'weddingpress'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'label_text_color',
            [
                'label' => __('Text Color', 'weddingpress'),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .elementor-wdp-form-wrapper label' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'label_typography',
                'label' => __('Typography', 'weddingpress'),
                'scheme' => Scheme_Typography::TYPOGRAPHY_4,
                'selector' => '{{WRAPPER}} .elementor-wdp-form-wrapper label',
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_input_style',
            [
                'label' => __('Form Input / Textarea', 'weddingpress'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'input_text_color',
            [
                'label' => __('Text Color', 'weddingpress'),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .elementor-wdp-form-wrapper input[type="text"], {{WRAPPER}} .elementor-wdp-form-wrapper input[type="jumlah"], {{WRAPPER}} .elementor-wdp-form-wrapper textarea' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'input_typography',
                'label' => __('Typography', 'weddingpress'),
                'scheme' => Scheme_Typography::TYPOGRAPHY_4,
                'selector' => '{{WRAPPER}} .elementor-wdp-form-wrapper input[type="text"], {{WRAPPER}} .elementor-wdp-form-wrapper input[type="jumlah"], {{WRAPPER}} .elementor-wdp-form-wrapper textarea',
            ]
        );

        $this->add_control(
            'input_background_color',
            [
                'label' => __('Background Color', 'weddingpress'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elementor-wdp-form-wrapper input[type="text"], {{WRAPPER}} .elementor-wdp-form-wrapper input[type="jumlah"], {{WRAPPER}} .elementor-wdp-form-wrapper textarea' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'input_border',
                'label' => __('Border', 'weddingpress'),
                'placeholder' => '1px',
                'default' => '1px',
                'selector' => '{{WRAPPER}} .elementor-wdp-form-wrapper input[type="text"], {{WRAPPER}} .elementor-wdp-form-wrapper input[type="jumlah"], {{WRAPPER}} .elementor-wdp-form-wrapper textarea',
            ]
        );

        $this->add_control(
            'input_border_radius',
            [
                'label' => __('Border Radius', 'weddingpress'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .elementor-wdp-form-wrapper input[type="text"], {{WRAPPER}} .elementor-wdp-form-wrapper input[type="jumlah"], {{WRAPPER}} .elementor-wdp-form-wrapper textarea' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'input_text_padding',
            [
                'label' => __('Text Padding', 'weddingpress'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .elementor-wdp-form-wrapper input[type="text"], {{WRAPPER}} .elementor-wdp-form-wrapper input[type="jumlah"], {{WRAPPER}} .elementor-wdp-form-wrapper textarea' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_button_style',
            [
                'label' => __('Form Button', 'weddingpress'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->start_controls_tabs('tabs_button_style');

        $this->start_controls_tab(
            'tab_button_normal',
            [
                'label' => __('Normal', 'weddingpress'),
            ]
        );

        $this->add_control(
            'button_text_color',
            [
                'label' => __('Text Color', 'weddingpress'),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .elementor-wdp-form-wrapper input[type="submit"], {{WRAPPER}} .elementor-wdp-form-wrapper button' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'typography',
                'label' => __('Typography', 'weddingpress'),
                'scheme' => Scheme_Typography::TYPOGRAPHY_4,
                'selector' => '{{WRAPPER}} .elementor-wdp-form-wrapper input[type="submit"], {{WRAPPER}} .elementor-wdp-form-wrapper button',
            ]
        );

        $this->add_control(
            'background_color',
            [
                'label' => __('Background Color', 'weddingpress'),
                'type' => Controls_Manager::COLOR,
                'scheme' => [
                    'type' => Scheme_Color::get_type(),
                    'value' => Scheme_Color::COLOR_4,
                ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-wdp-form-wrapper input[type="submit"], {{WRAPPER}} .elementor-wdp-form-wrapper button' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'border',
                'label' => __('Border', 'weddingpress'),
                'placeholder' => '1px',
                'default' => '1px',
                'selector' => '{{WRAPPER}} .elementor-wdp-form-wrapper input[type="submit"], {{WRAPPER}} .elementor-wdp-form-wrapper button',
            ]
        );

        $this->add_control(
            'border_radius',
            [
                'label' => __('Border Radius', 'weddingpress'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .elementor-wdp-form-wrapper input[type="submit"], {{WRAPPER}} .elementor-wdp-form-wrapper button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'text_padding',
            [
                'label' => __('Text Padding', 'weddingpress'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .elementor-wdp-form-wrapper input[type="submit"], {{WRAPPER}} .elementor-wdp-form-wrapper button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'tab_button_hover',
            [
                'label' => __('Hover', 'weddingpress'),
            ]
        );

        $this->add_control(
            'hover_color',
            [
                'label' => __('Text Color', 'weddingpress'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elementor-wdp-form-wrapper input[type="submit"]:hover, {{WRAPPER}} .elementor-wdp-form-wrapper button:hover' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'button_background_hover_color',
            [
                'label' => __('Background Color', 'weddingpress'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elementor-wdp-form-wrapper input[type="submit"]:hover, {{WRAPPER}} .elementor-wdp-form-wrapper button:hover' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'button_hover_border_color',
            [
                'label' => __('Border Color', 'weddingpress'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elementor-wdp-form-wrapper input[type="submit"]:hover, {{WRAPPER}} .elementor-wdp-form-wrapper button:hover' => 'border-color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->end_controls_section();


        /**
         * By Hadie Danker
         */
        $this->start_controls_section('_option_radio_section_style', [
            'tab' => Controls_Manager::TAB_STYLE,
            'condition' => [
                'display_option_type' => 'radio'
            ],
            'label' => __('Radio Style', 'weddingpress')
        ]);

        $this->add_responsive_control('display_option', [
            'label' => __('Display Option', 'weddingpress'),
            'type' => Controls_Manager::SELECT,
            'options' => array(
                'inline-block' => __('Inline', 'weddingpress'),
                'block' => __('Block', 'weddingpress'),
            ),
            'default' => 'block',
            'selectors' => [
                '{{WRAPPER}} .wdp-form-field-option.wdp-option-type-radio label.to-select-option' => 'display:{{VALUE}};'
            ]
        ]);


        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'typography_label_option',
                'label' => __('Typography', 'weddingpress'),
                'scheme' => Scheme_Typography::TYPOGRAPHY_4,
                'selector' => '{{WRAPPER}} label.to-select-option',
            ]
        );


        $this->add_control('label_option_color', [
            'label' => __('Color', 'weddingpress'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} label.to-select-option' => 'color:{{VALUE}}'
            ]
        ]);

        $this->add_responsive_control('space_between_option', [
            'label' => __('Margin', 'weddingpress'),
            'type' => Controls_Manager::DIMENSIONS,
            'selectors' => [
                '{{WRAPPER}} label.to-select-option' => 'margin:{{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}'
            ]
        ]);

        $this->end_controls_section();

    }

    protected function render()
    {
        $settings = $this->get_settings();

        $labels_class = !$settings['form_labels'] ? 'elementor-screen-only' : '';

        $this->add_render_attribute('form_wrapper', 'class', 'elementor-wdp-form-wrapper');

        if (!empty($settings['field_submit_align'])) {
            $this->add_render_attribute('form_wrapper', 'class', 'elementor-wdp-form-button-align-' . $settings['field_submit_align']);
        }

        $this->add_render_attribute('form', 'method', 'get');
        $this->add_render_attribute('form', 'class', 'wdp-form wdp-wa-form');
        $this->add_render_attribute('form', 'id', 'wdp-wa-form-' . $this->get_id());

        $field_option_id = 'wdp-form-option-' . $this->get_id();
        $field_option_class = 'wdp-form-option';
        $field_option_label = $settings['field_option_label'];
        $this->add_render_attribute('field_option', 'name', $field_option_class);
        $this->add_render_attribute('field_option', 'class', $field_option_class);
        $this->add_render_attribute('field_option', 'id', $field_option_id);
        if (!$settings['hide_option']) {
            $this->add_render_attribute('field_option_label', 'for', $field_option_id);
            $this->add_render_attribute('field_option_label', 'class', '');
        } else {
            $this->add_render_attribute('field_option', 'type', 'hidden');
            $this->add_render_attribute('field_option', 'value', 'produk');
        }

        $field_nama_id = 'wdp-form-nama-' . $this->get_id();
        $field_nama_class = 'wdp-form-nama';
        $field_nama_label = $settings['field_nama_label'];
        $field_nama_placeholder = $settings['form_placeholders'] ? $settings['field_nama_placeholder'] : '';
        $field_nama_value = '';
        $this->add_render_attribute('field_nama_label', 'for', $field_nama_id);
        $this->add_render_attribute('field_nama_label', 'class', $labels_class);
        $this->add_render_attribute('field_nama', 'type', 'text');
        $this->add_render_attribute('field_nama', 'name', $field_nama_class);
        $this->add_render_attribute('field_nama', 'class', $field_nama_class);
        $this->add_render_attribute('field_nama', 'id', $field_nama_id);
        $this->add_render_attribute('field_nama', 'placeholder', $field_nama_placeholder);
        $this->add_render_attribute('field_nama', 'required', '1');
        $this->add_render_attribute('field_nama', 'value', $field_nama_value);

        $field_jumlah_id = 'wdp-form-jumlah-' . $this->get_id();
        $field_jumlah_class = 'wdp-form-jumlah';
        $this->add_render_attribute('field_jumlah', 'name', $field_jumlah_class);
        $this->add_render_attribute('field_jumlah', 'class', $field_jumlah_class);
        $this->add_render_attribute('field_jumlah', 'id', $field_jumlah_id);
        if (!$settings['hide_jumlah']) {
            $field_jumlah_label = $settings['field_jumlah_label'];
            $field_jumlah_placeholder = $settings['form_placeholders'] ? $settings['field_jumlah_placeholder'] : '';
            $field_jumlah_value = '';
            $this->add_render_attribute('field_jumlah_label', 'for', $field_jumlah_id);
            $this->add_render_attribute('field_jumlah_label', 'class', $labels_class);
            $this->add_render_attribute('field_jumlah', 'type', 'text');
            $this->add_render_attribute('field_jumlah', 'placeholder', $field_jumlah_placeholder);
            $this->add_render_attribute('field_jumlah', 'required', '1');
            $this->add_render_attribute('field_jumlah', 'value', $field_jumlah_value);
        } else {
            $this->add_render_attribute('field_jumlah', 'type', 'hidden');
            $this->add_render_attribute('field_jumlah', 'value', 'hide');
        }

        $field_pesan_id = 'wdp-form-pesan-' . $this->get_id();
        $field_pesan_class = 'wdp-form-pesan';
        $this->add_render_attribute('field_pesan', 'name', $field_pesan_class);
        $this->add_render_attribute('field_pesan', 'class', $field_pesan_class);
        $this->add_render_attribute('field_pesan', 'id', $field_pesan_id);
        if (!$settings['hide_pesan']) {
            $field_pesan_label = $settings['field_pesan_label'];
            $field_pesan_placeholder = $settings['form_placeholders'] ? $settings['field_pesan_placeholder'] : '';
            $field_pesan_value = '';
            $this->add_render_attribute('field_pesan_label', 'for', $field_pesan_id);
            $this->add_render_attribute('field_pesan_label', 'class', $labels_class);
            $this->add_render_attribute('field_pesan', 'rows', '4');
            $this->add_render_attribute('field_pesan', 'placeholder', $field_pesan_placeholder);
            $this->add_render_attribute('field_pesan', 'required', '1');
        } else {
            $this->add_render_attribute('field_pesan', 'type', 'hidden');
            $this->add_render_attribute('field_pesan', 'value', 'hide');
        }

        $field_submit_text = $settings['field_submit_text'];
        if (!$field_submit_text) {
            $field_submit_text = __('Reservasi via Whatsapp', 'weddingpress');
        }

        $this->add_render_attribute( 'field_button', 'type', 'submit' );
        $this->add_render_attribute( 'field_button', 'class', 'wdp-form-button' );

        $url = 'https://api.whatsapp.com/send';

        $phone = trim($settings['phone']);
        $phone = preg_replace('/^8/', '08', $phone);
        $phone = preg_replace('/[^0-9]/', '', $phone);
        $phone = preg_replace('/^620/', '62', $phone);
        $phone = preg_replace('/^0/', '62', $phone);

        $message = trim($settings['message']);

        $url = $url . '?phone=' . esc_attr($phone) . '&text=' . rawurlencode($message);

        $this->add_render_attribute('form', 'data-waapi', $url);


        ?>
        <div <?php echo $this->get_render_attribute_string('form_wrapper'); ?>>
            <form <?php echo $this->get_render_attribute_string('form'); ?>>
                <div class="wdp-form-fields-wrapper">
                    <div class="wdp-form-field-nama">
                        <label <?php echo $this->get_render_attribute_string('field_nama_label'); ?>>
                            <?php echo $field_nama_label; ?>
                        </label>
                        <input <?php echo $this->get_render_attribute_string('field_nama'); ?>>
                    </div>
                    <?php if (!$settings['hide_jumlah']) : ?>
                        <div class="wdp-form-field-jumlah">
                            <label <?php echo $this->get_render_attribute_string('field_jumlah_label'); ?>>
                                <?php echo $field_jumlah_label; ?>
                            </label>
                            <input <?php echo $this->get_render_attribute_string('field_jumlah'); ?>>
                        </div>
                    <?php else : ?>
                        <input <?php echo $this->get_render_attribute_string('field_jumlah'); ?>>
                    <?php endif; ?>
                    <?php if (!$settings['hide_pesan']) : ?>
                        <div class="wdp-form-field-pesan">
                            <label <?php echo $this->get_render_attribute_string('field_pesan_label'); ?>>
                                <?php echo $field_pesan_label; ?>
                            </label>
                            <textarea <?php echo $this->get_render_attribute_string('field_pesan'); ?>><?php echo $field_pesan_value; ?></textarea>
                        </div>
                    <?php else : ?>
                        <input <?php echo $this->get_render_attribute_string('field_pesan'); ?>>
                    <?php endif; ?>
                    <?php if (!$settings['hide_option'] == 'bottom') : ?>
                        <?php $this->render_option_option($settings); ?>
                    <?php endif; ?>
                    <?php if ($settings['hide_option']) : ?>
                        <input <?php echo $this->get_render_attribute_string('field_option'); ?>>
                    <?php endif; ?>
                    <div class="wdp-form-field-submit">
                        <button <?php echo $this->get_render_attribute_string( 'field_button' ); ?>>
                            <?php echo $field_submit_text; ?>
                        </button>
                    </div>
                </div>
            </form>
        </div>
        <script>
            
            !function(t,r){"use strict";function n(e,a){var t,r=e.find(".wdp-form-nama"),n=e.find(".wdp-form-option"),o=e.find(".lp-form-user-phone"),d=e.find(".wdp-form-pesan"),p=e.find(".wdp-form-jumlah"),c=e.data("waapi");if(a?(r=r[0].value,d=d[0].value,p=p[0].value,o=o[0].value):(r=r.val(),o=o.val(),d=d.val(),p=p.val()),r&&n&&d&&c){if(1<n.length)for(var f=0;f<n.length;f++)"radio"===n[f].type&&n[f].checked&&(t=n[f].value);else t=n.val();return t&&(c=c.replace("%25option%25",encodeURI(t))),r&&(c=c.replace("%25nama%25",encodeURI(r))),d&&(c=c.replace("%25pesan%25",encodeURI(d))),p&&(c=c.replace("%25jumlah%25",encodeURI(p))),o&&(o=o.replace(/^8/g,"08").replace(/^0/g,"0").replace(/^620/g,"62").replace(/^0/g,"62"),c=c.replace("[whatsapp_number]",o)),e.attr("data-waapi",c),c}return c}t("#wdp-wa-form-<?php echo $this->get_id(); ?>").on("change keypress keyup",function(e){n(t(this),!0)}).submit(e=>{e.preventDefault(),e.stopPropagation();var a=n(t(e.target),!1);setTimeout(function(){r.location=a},1e3)})}(jQuery,window);

        </script>
        <?php
    }


    /**
     * @param $settings
     * by Hadie Danker
     */
    private function render_option_option($settings)
    {
        $field_option_label = $settings['field_option_label'];

        $display = isset($settings['display_option_type']) ? $settings['display_option_type'] : 'select';
        $field_option_id = 'wdp-form-option-' . $this->get_id();
        $field_option_class = 'wdp-form-option';


        $this->add_render_attribute('field_option', 'name', $field_option_class);
        $this->add_render_attribute('field_option', 'class', $field_option_class);
        $this->add_render_attribute('field_option', 'id', $field_option_id);
        $this->add_render_attribute('field_option', 'required', '1');
        if (!$settings['hide_option']) {
            $this->add_render_attribute('field_option_label', 'for', $field_option_id);
            $this->add_render_attribute('field_option_label', 'class', '');
        } else {
            $this->add_render_attribute('field_option', 'type', 'hidden');
            $this->add_render_attribute('field_option', 'value', 'produk');
        }
        ?>
        <div class="wdp-form-field-option wdp-option-type-<?php echo $display; ?>">
            <label <?php echo $this->get_render_attribute_string('field_option_label'); ?>>
                <?php echo $field_option_label; ?>
            </label>

            <?php if (!empty($settings['option'])) : $i = 0; ?>
                <?php if ('radio' === $display) : ?>
                    <?php
                    $this->remove_render_attribute('field_option', 'id');
                    foreach ($settings['option'] as $option) : $i++;
                        $this->add_render_attribute('field_option', 'id', $field_option_id . $i);

                        ?>
                        <label class="to-select-option"><input
                                    type="radio" <?php echo $this->get_render_attribute_string('field_option'); ?>
                                    value="<?php echo $option['opsi']; ?>"> <?php echo $option['opsi']; ?></label>
                    <?php endforeach; ?>
                <?php else: ?>
                    <select <?php echo $this->get_render_attribute_string('field_option'); ?>>
                        <?php foreach ($settings['option'] as $option) : $i++; ?>
                            <option value="<?php echo $option['opsi']; ?>" <?php if ($i == 1) echo 'selected="selected"'; ?>><?php echo $option['opsi']; ?></option>
                        <?php endforeach; ?>
                    </select>
                <?php endif; //if display not ratio ?>
            <?php endif; ?>
        </div>
        <?php
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