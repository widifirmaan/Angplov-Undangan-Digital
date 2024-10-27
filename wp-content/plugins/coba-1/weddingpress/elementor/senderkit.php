<?php

namespace WeddingPress\elementor;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Typography;
use Elementor\Repeater;
use Elementor\Icons_Manager;
use Elementor\Core\Schemes\Color as Scheme_Color;
use Elementor\Core\Schemes\Typography as Scheme_Typography;
use Elementor\Widget_Base;

if (!defined('ABSPATH')) exit; // Exit if accessed directly

class WeddingPress_Widget_SenderKit extends Widget_Base {

    public function get_name() {
        return 'weddingpress-senderkit';
    }

    public function get_title() {
        return __( 'Senderkit', 'weddingpress' );
    }

    public function get_icon() {
        return 'elkit_icon eicon-welcome';
    }

    public function get_categories() {
        return [ 'weddingpress' ];
    }

    public function get_script_depends() {
        return [ 'weddingpress' ];
    }

    public function get_keywords() {
        return [ 'senderkit' ];
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
                'label' => __('Senderkit', 'weddingpress'),
            ]
        );

        $this->add_control(
            'send_whatsapp_to',
            [
                'label' => __('Send to', 'weddingpress'),
                'type' => Controls_Manager::SELECT,
                'default' => 'user',
                'options' => [
                    'admin' => __('Sent to Admin', 'weddingpress'),
                    'user' => __('Sent to User', 'weddingpress'),
                    'share' => __('Share to Whatsapp', 'weddingpress'),
                ]

            ]
        );


        $this->add_control(
            'phone',
            [
                'label' => __('Phone Number', 'weddingpress'),
                'type' => Controls_Manager::TEXT,
                'default' => '',
                'placeholder' => '081xxxxx',
                'separator' => 'before',
                'condition' => [
                    'send_whatsapp_to' => 'admin'
                ]
            ]
        );


        $this->add_control(
            'user_phone_label',
            [
                'label' => __('Phone Label', 'weddingpress'),
                'type' => Controls_Manager::TEXT,
                'default' => __('Nomor Whatsapp', 'weddingpress'),
                'condition' => [
                    'send_whatsapp_to' => 'user'
                ]
            ]
        );

        $this->add_control(
            'user_phone_placeholder',
            [
                'label' => __('Phone Placeholder', 'weddingpress'),
                'type' => Controls_Manager::TEXT,
                'default' => __('Nomor Whatsapp', 'weddingpress'),
                'placeholder' => __('Nomor Whatsapp', 'weddingpress'),
                'condition' => [
                    'send_whatsapp_to' => 'user'
                ]
            ]
        );

        $this->add_control(
            'message',
            [
                'label' => __('Pesan', 'weddingpress'),
                'type' => Controls_Manager::TEXTAREA,
                'rows' => '10',
                'default' => "Assalamu'alaikum Wr. Wb
Bismillahirahmanirrahim.

Tanpa mengurangi rasa hormat, perkenankan kami mengundang Bapak/Ibu/Saudara/i, teman sekaligus sahabat, untuk menghadiri acara pernikahan kami :

*%nama%*

Yang akan dilaksanakan pada: *%acara%*

*Berikut link undangan kami untuk info lengkap dari acara bisa kunjungi :*
 
%link%

Dan untuk pilihan waktunya dilaksanakan pada : *%option%*

Merupakan suatu kebahagiaan bagi kami apabila Bapak/Ibu/Saudara/i berkenan untuk hadir dan memberikan doa restu.

*Mohon maaf perihal undangan hanya di bagikan melalui  pesan ini.* Karena suasana masih pandemi diharapakan untuk *menggunakan masker dan datang pada jam yang telah ditentukan.* Terima kasih banyak atas perhatiannya.

Wassalamu'alaikum Wr. Wb.
Terima Kasih.",
                'placeholder' => "Assalamu'alaikum Wr. Wb
Bismillahirahmanirrahim.

Tanpa mengurangi rasa hormat, perkenankan kami mengundang Bapak/Ibu/Saudara/i, teman sekaligus sahabat, untuk menghadiri acara pernikahan kami :

*%nama%*

Yang akan dilaksanakan pada: *%acara%*

*Berikut link undangan kami untuk info lengkap dari acara bisa kunjungi :*
 
%link%

Dan untuk pilihan waktunya dilaksanakan pada : *%option%*

Merupakan suatu kebahagiaan bagi kami apabila Bapak/Ibu/Saudara/i berkenan untuk hadir dan memberikan doa restu.

*Mohon maaf perihal undangan hanya di bagikan melalui  pesan ini.* Karena suasana masih pandemi diharapakan untuk *menggunakan masker dan datang pada jam yang telah ditentukan.* Terima kasih banyak atas perhatiannya.

Wassalamu'alaikum Wr. Wb.
Terima Kasih.",
                'label_block' => true,
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'message_params',
            [
                'raw' => __('Parameters: <br/><strong><u>%option%</u></strong><br/><strong><u>%nama%</u></strong><br/><strong><u>%link%</u></strong><br/><strong><u>%acara%</u></strong>', 'weddingpress'),
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
                'default' => __('Nama Mempelai', 'weddingpress'),
                'placeholder' => __('Nama Mempelai', 'weddingpress'),
                'condition' => [
                    'form_placeholders' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'field_acara_label',
            [
                'label' => __('Acara Label', 'weddingpress'),
                'type' => Controls_Manager::TEXT,
                'default' => __('Acara', 'weddingpress'),
                'placeholder' => __('Acara', 'weddingpress'),
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'field_acara_placeholder',
            [
                'label' => __('Acara Placeholder', 'weddingpress'),
                'type' => Controls_Manager::TEXT,
                'default' => __('Waktu Acara', 'weddingpress'),
                'placeholder' => __('Waktu Acara', 'weddingpress'),
                'condition' => [
                    'form_placeholders' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'hide_acara',
            [
                'label' => __('Hide Acara', 'weddingpress'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => 'Hide',
                'label_off' => 'Show',
                'return_value' => 'hide',
            ]
        );

        $this->add_control(
            'field_link_label',
            [
                'label' => __('Link Label', 'weddingpress'),
                'type' => Controls_Manager::TEXT,
                'default' => __('Link', 'weddingpress'),
                'placeholder' => __('Link', 'weddingpress'),
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'field_link_placeholder',
            [
                'label' => __('Link Placeholder', 'weddingpress'),
                'type' => Controls_Manager::TEXT,
                'default' => __('Link Undangan', 'weddingpress'),
                'placeholder' => __('Link Undangan', 'weddingpress'),
                'condition' => [
                    'form_placeholders' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'hide_link',
            [
                'label' => __('Link', 'weddingpress'),
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
                'default' => __('Pilih Sesi', 'weddingpress'),
                'placeholder' => __('Pilih Sesi', 'weddingpress'),
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
                'label' => __('Pilihan Sesi', 'weddingpress'),
                'type' => Controls_Manager::TEXT,
                'placeholder' => __('Pilihan Sesi', 'weddingpress'),
                'label_block' => true,
            ]
        );

        $this->add_control(
            'option',
            [
                'label' => __('Pilihan Sesi', 'weddingpress'),
                'type' => Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'show_label' => true,
                'default' => [
                    [
                        'opsi'      => 'Sesi Pagi, 09.00 WIB s.d selesai',
                    ],
                    [
                        'opsi'      => 'Sesi Siang, 12.00 WIB s.d selesai',
                    ],
                    [
                        'opsi'      => 'Sesi Malam, 18.30 WIB s.d selesai',
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
            'selected_icon',
            [
                'label' => __( 'Icon', 'weddingpress' ),
                'type' => Controls_Manager::ICONS,
                'label_block' => true,
                'fa4compatibility' => 'icon',
            ]
        );

        $this->add_control(
            'field_submit_text',
            [
                'label' => __('Button Text', 'weddingpress'),
                'type' => Controls_Manager::TEXT,
                'default' => __('Kirim Undangan', 'weddingpress'),
                'placeholder' => __('Kirim Undangan', 'weddingpress'),
                'label_block' => true,
            ]
        );


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
                    '{{WRAPPER}} .elementor-wdp-form-wrapper input[type="text"], {{WRAPPER}} .elementor-wdp-form-wrapper input[type="acara"], {{WRAPPER}} .elementor-wdp-form-wrapper textarea' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'input_typography',
                'label' => __('Typography', 'weddingpress'),
                'scheme' => Scheme_Typography::TYPOGRAPHY_4,
                'selector' => '{{WRAPPER}} .elementor-wdp-form-wrapper input[type="text"], {{WRAPPER}} .elementor-wdp-form-wrapper input[type="acara"], {{WRAPPER}} .elementor-wdp-form-wrapper textarea',
            ]
        );

        $this->add_control(
            'input_background_color',
            [
                'label' => __('Background Color', 'weddingpress'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elementor-wdp-form-wrapper input[type="text"], {{WRAPPER}} .elementor-wdp-form-wrapper input[type="acara"], {{WRAPPER}} .elementor-wdp-form-wrapper textarea' => 'background-color: {{VALUE}};',
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
                'selector' => '{{WRAPPER}} .elementor-wdp-form-wrapper input[type="text"], {{WRAPPER}} .elementor-wdp-form-wrapper input[type="acara"], {{WRAPPER}} .elementor-wdp-form-wrapper textarea',
            ]
        );

        $this->add_control(
            'input_border_radius',
            [
                'label' => __('Border Radius', 'weddingpress'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .elementor-wdp-form-wrapper input[type="text"], {{WRAPPER}} .elementor-wdp-form-wrapper input[type="acara"], {{WRAPPER}} .elementor-wdp-form-wrapper textarea' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
                    '{{WRAPPER}} .elementor-wdp-form-wrapper input[type="text"], {{WRAPPER}} .elementor-wdp-form-wrapper input[type="acara"], {{WRAPPER}} .elementor-wdp-form-wrapper textarea' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
        if (!empty($settings['form_display'])) {
            $this->add_render_attribute('form_wrapper', 'class', 'elementor-wdp-form-display-' . $settings['form_display']);
        }
        if (!empty($settings['field_submit_align'])) {
            $this->add_render_attribute('form_wrapper', 'class', 'elementor-wdp-form-button-align-' . $settings['field_submit_align']);
        }

        $this->add_render_attribute('form', 'method', 'get');
        $this->add_render_attribute('form', 'class', 'wdp-form senderkit-wa');
        $this->add_render_attribute('form', 'id', 'senderkit-wa-' . $this->get_id());

        $field_option_id = 'senderkit-option-' . $this->get_id();
        $field_option_class = 'senderkit-option';
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

        $field_nama_id = 'senderkit-nama-' . $this->get_id();
        $field_nama_class = 'senderkit-nama';
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

        $field_acara_id = 'senderkit-acara-' . $this->get_id();
        $field_acara_class = 'senderkit-acara';
        $this->add_render_attribute('field_acara', 'name', $field_acara_class);
        $this->add_render_attribute('field_acara', 'class', $field_acara_class);
        $this->add_render_attribute('field_acara', 'id', $field_acara_id);
        if (!$settings['hide_acara']) {
            $field_acara_label = $settings['field_acara_label'];
            $field_acara_placeholder = $settings['form_placeholders'] ? $settings['field_acara_placeholder'] : '';
            $field_acara_value = '';
            $this->add_render_attribute('field_acara_label', 'for', $field_acara_id);
            $this->add_render_attribute('field_acara_label', 'class', $labels_class);
            $this->add_render_attribute('field_acara', 'type', 'text');
            $this->add_render_attribute('field_acara', 'placeholder', $field_acara_placeholder);
            $this->add_render_attribute('field_acara', 'required', '1');
            $this->add_render_attribute('field_acara', 'value', $field_acara_value);
        } else {
            $this->add_render_attribute('field_acara', 'type', 'hidden');
            $this->add_render_attribute('field_acara', 'value', 'hide');
        }

        $field_link_id = 'senderkit-link-' . $this->get_id();
        $field_link_class = 'senderkit-link';
        $this->add_render_attribute('field_link', 'name', $field_link_class);
        $this->add_render_attribute('field_link', 'class', $field_link_class);
        $this->add_render_attribute('field_link', 'id', $field_link_id);
        if (!$settings['hide_link']) {
            $field_link_label = $settings['field_link_label'];
            $field_link_placeholder = $settings['form_placeholders'] ? $settings['field_link_placeholder'] : '';
            $field_link_value = '';
            $this->add_render_attribute('field_link_label', 'for', $field_link_id);
            $this->add_render_attribute('field_link_label', 'class', $labels_class);
            $this->add_render_attribute('field_link', 'type', 'text');
            $this->add_render_attribute('field_link', 'placeholder', $field_link_placeholder);
            $this->add_render_attribute('field_link', 'required', '1');
        } else {
            $this->add_render_attribute('field_link', 'type', 'hidden');
            $this->add_render_attribute('field_link', 'value', 'hide');
        }

        $field_user_phone_id = 'senderkit-phone-' . $this->get_id();
        $field_user_phone_class = 'senderkit-phone';
        $this->add_render_attribute('field_user_phone', 'name', $field_user_phone_class);
        $this->add_render_attribute('field_user_phone', 'class', $field_user_phone_class);
        $this->add_render_attribute('field_user_phone', 'id', $field_user_phone_id);
    
        $field_user_phone_label = $settings['user_phone_label'];
        $field_user_phone_placeholder = $settings['form_placeholders'] ? $settings['user_phone_placeholder'] : '';
        $field_extra_value = '';
        $this->add_render_attribute('user_phone_label', 'for', $field_user_phone_id);
        $this->add_render_attribute('user_phone_label', 'class', $labels_class);
        $this->add_render_attribute('field_user_phone', 'type', 'text');
        $this->add_render_attribute('field_user_phone', 'placeholder', $field_user_phone_placeholder);
        $this->add_render_attribute('field_user_phone', 'required', '1');
        $this->add_render_attribute('field_user_phone', 'value', '');
        
        $field_submit_text = $settings['field_submit_text'];
        if (!$field_submit_text) {
            $field_submit_text = __('Kirim Undangan', 'weddingpress');
        }

        $this->add_render_attribute( 'field_button', 'type', 'submit' );
        $this->add_render_attribute( 'field_button', 'class', 'elementor-wdp-form-wrapper' );
        $this->add_render_attribute( 'field_button', 'data-action', 'senderkit-form-button' );

        $url = 'https://api.whatsapp.com/send';

        $phone = trim($settings['phone']);
        $phone = preg_replace('/^8/', '08', $phone);
        $phone = preg_replace('/[^0-9]/', '', $phone);
        $phone = preg_replace('/^620/', '62', $phone);
        $phone = preg_replace('/^0/', '62', $phone);
        $phone = $settings['send_whatsapp_to'] === 'admin' ? $phone : '[whatsapp_number]';
        $message = trim($settings['message']);

        if ($settings['send_whatsapp_to'] === 'share') {
            $url = $url . '?text=' . rawurlencode($message);           
        } elseif ($settings['send_whatsapp_to'] === 'admin')  {   
            $url = $url . '?phone=' . esc_attr($phone) . '&text=' . rawurlencode($message);
        } elseif ($settings['send_whatsapp_to'] === 'user')  {   
            $url = $url . '?phone=' . esc_attr($phone) . '&text=' . rawurlencode($message);
        }

        $this->add_render_attribute('form', 'data-senderkitapi', $url);
        $this->add_render_attribute('send_phone_number');
        $this->add_render_attribute('field_button', 'href', '#');

        $migrated = isset( $settings['__fa4_migrated']['selected_icon'] );
        $is_new = empty( $settings['icon'] ) && Icons_Manager::is_migration_allowed();

        ?>
        <div <?php echo $this->get_render_attribute_string('form_wrapper'); ?>>
            <form <?php echo $this->get_render_attribute_string('form'); ?>>
                <div class="wdp-form-fields-wrapper">
                    <?php if (!$settings['hide_link']) : ?>
                        <div class="wdp-form-field-link">
                            <label <?php echo $this->get_render_attribute_string('field_link_label'); ?>>
                                <?php echo $field_link_label; ?>
                            </label>
                            <input <?php echo $this->get_render_attribute_string('field_link'); ?>><?php echo $field_link_value; ?></input>
                        </div>
                    <?php else : ?>
                        <input <?php echo $this->get_render_attribute_string('field_link'); ?>>
                    <?php endif; ?>
                    <div class="wdp-form-field-nama">
                        <label <?php echo $this->get_render_attribute_string('field_nama_label'); ?>>
                            <?php echo $field_nama_label; ?>
                        </label>
                        <input <?php echo $this->get_render_attribute_string('field_nama'); ?>>
                    </div>
                    <?php if (!$settings['hide_acara']) : ?>
                        <div class="wdp-form-field-acara">
                            <label <?php echo $this->get_render_attribute_string('field_acara_label'); ?>>
                                <?php echo $field_acara_label; ?>
                            </label>
                            <input <?php echo $this->get_render_attribute_string('field_acara'); ?>>
                        </div>
                    <?php else : ?>
                        <input <?php echo $this->get_render_attribute_string('field_acara'); ?>>
                    <?php endif; ?>
                    <?php
                    if ($settings['send_whatsapp_to'] === 'user'):
                        ?>
                            <div class="wdp-form-field-user-phone" style="margin-bottom: 10px;">
                                <label <?php echo $this->get_render_attribute_string('user_phone_label'); ?>>  <?php echo esc_attr($field_user_phone_label); ?> </label>
                                <input <?php echo $this->get_render_attribute_string('field_user_phone'); ?> />
                            </div>
                        <?php
                    endif;
                    ?>
                    <?php if (!$settings['hide_option'] == 'bottom') : ?>
                        <?php $this->render_option_option($settings); ?>
                    <?php endif; ?>
                    <?php if ($settings['hide_option']) : ?>
                        <input <?php echo $this->get_render_attribute_string('field_option'); ?>>
                    <?php endif; ?>
                    <span style="padding-top: 15px"></span>
                    <div class="wdp-form-field-submit">
                        <button <?php echo $this->get_render_attribute_string( 'field_button' ); ?>>
                            <?php if ( ! empty( $settings['icon'] ) || ! empty( $settings['selected_icon']['value'] ) ) : ?>
                                            <span>
                                                <?php if ( $is_new || $migrated ) :
                                                    Icons_Manager::render_icon( $settings['selected_icon'], [ 'aria-hidden' => 'true' ] );
                                                else : ?>
                                                    <i class="<?php echo esc_attr( $settings['icon'] ); ?>" aria-hidden="true"></i>
                                                <?php endif; ?>
                                            </span>
                                            <?php endif; ?>
                            <?php echo $field_submit_text; ?>
                        </button>
                    </div>
                </div>
            </form>
        </div>

        <script>
        //edited by Dankedev

        !function(e,a){"use strict";function t(e,a=!0){var t,r=e.find(".senderkit-nama"),n=e.find(".senderkit-option"),o=e.find(".senderkit-phone"),d=e.find(".senderkit-acara"),p=e.find(".senderkit-link"),g=e.data("senderkitapi");if(a?(r=r[0].value,d=d[0].value,p=p[0].value,o=o[0].value):(r=r.val(),o=o.val(),d=d.val(),p=p.val()),r&&n&&d&&g){if(n.length>1)for(var f=0;f<n.length;f++)"radio"===n[f].type&&n[f].checked&&(t=n[f].value);else t=n.val();return t&&(g=g.replace(/%25option%25/g,encodeURI(t))),r&&(g=g.replace(/%25nama%25/g,encodeURIComponent(r))),d&&(g=g.replace(/%25acara%25/g,encodeURI(d))),p&&(g=g.replace(/%25link%25/g,encodeURIComponent(p))),o&&(o=o.replace(/^8/g,"08").replace(/^0/g,"0").replace(/^620/g,"62").replace(/^0/g,"62"),g=g.replace("[whatsapp_number]",o)),e.attr("data-senderkitapi",g),g}return g}e("#senderkit-wa-<?php echo $this->get_id(); ?>").on("change keypress keyup",function(a){t(e(this),!0)}).submit(r=>{r.preventDefault(),r.stopPropagation();var n=t(e(r.target),!1);(e(r.target).data("sendkitev")||e(r.target).data("sendterkitya")),setTimeout(function(){a.open(n,"_blank")},1e3)})}(jQuery,window);

        </script>
        <style>
            a.senderkit-form-button{
                min-width: 300px;
                max-width: 100%;
                font-family: var( --e-global-typography-accent-font-family ), Sans-serif;
                font-weight: var( --e-global-typography-accent-font-weight );
                background-color: var( --e-global-color-accent );
                padding: 12px 24px;
                border: 0;
                color: #ffffff;
                line-height: 1;
                text-align: center;
                font-size: 14px;
                display: inline-block;
            }
        </style>

        
        <?php
    }

    public function on_import( $element ) {
        return Icons_Manager::on_import_migration( $element, 'icon', 'selected_icon' );
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