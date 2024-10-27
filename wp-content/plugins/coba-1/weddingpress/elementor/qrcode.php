<?php

namespace WeddingPress\elementor;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Image_Size;
use Elementor\Utils;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Text_Shadow;
use Elementor\Core\Schemes\Color as Scheme_Color;
use Elementor\Core\Schemes\Typography as Scheme_Typography;
use Elementor\Icons_Manager;
use Elementor\Widget_Base;

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

class Weddingpress_Widget_Qrcode extends Widget_Base {

    public function get_name() {
        return 'wdp-qrcode';
    }

    public function get_title() {
        return __( 'QR Code', 'weddingpress' );
    }

    public function get_icon() {
        return 'elkit_icon eicon-barcode';
    }

    public function get_categories() {
        return [ 'weddingpress' ];
    }

    public function get_keywords() {
        return [ 'qr', 'code' ];
    }

    /**
     * A list of scripts that the widgets is depended in
     * @since 1.3.0
     * */
    public function get_script_depends() {
        return ['weddingpress-qr'];
    }


    public function get_custom_help_url() {
        return 'https://membershipdigital.com';
    }

    protected function register_controls() {


        $this->start_controls_section(
            'section_layout',
            [
                'label' => esc_html__('QR Code', 'weddingpress'),
            ]
        );

        $this->add_control(
            'form_labels',
            [
                'label' => __( 'Form Labels', 'weddingpress' ),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => __( 'Show', 'weddingpress' ),
                'label_off' => __( 'Hide', 'weddingpress' ),
                'return_value' => 'yes',
                'separator' => 'before',
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'hide_name',
            [
                'label' => __('Nama Tamu', 'weddingpress'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => 'Hide',
                'label_off' => 'Show',
                'return_value' => 'hide',
            ]
        );

        $this->add_control(
            'copy_message',
            [
                'label' => __( 'Copy Sucess Message', 'weddingpress' ),
                'type' => Controls_Manager::TEXT,
                'dynamic' => [
                    'active' => true,
                ],
                'default' => __( 'Link telah dicopy!', 'weddingpress' ),
                
                'label_block' => true,
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_field_link',
            [
                'label' => __( 'ID Undangan', 'weddingpress' ),
            ]
        );

        $this->add_control(
            'field_link_label',
            [
                'label' => __( 'Label', 'weddingpress' ),
                'type' => Controls_Manager::TEXT,
                'default' => __( 'ID Undangan', 'weddingpress' ),
            ]
        );

        $this->add_control(
            'field_link_placeholder',
            [
                'label' => __( 'Placeholder', 'weddingpress' ),
                'type' => Controls_Manager::TEXT,
                'default' => __( 'ID Undangan', 'weddingpress' ),
            ]
        );

        $this->end_controls_section();


        $this->start_controls_section(
            'section_field_name',
            [
                'label' => __( 'Nama Tamu', 'weddingpress' ),
            ]
        );

        $this->add_control(
            'field_name_label',
            [
                'label' => __( 'Label', 'weddingpress' ),
                'type' => Controls_Manager::TEXT,
                'default' => __( 'Nama Tamu', 'weddingpress' ),
            ]
        );

        $this->add_control(
            'field_name_placeholder',
            [
                'label' => __( 'Placeholder', 'weddingpress' ),
                'type' => Controls_Manager::TEXT,
                'default' => __( 'Nama Tamu', 'weddingpress' ),
            ]
        );

        $this->end_controls_section();
        
        $this->start_controls_section(
            'section_field_submit',
            [
                'label' => __( 'Generate QR Code', 'weddingpress' ),
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
                'label' => __( 'Generate QR Code Text', 'weddingpress' ),
                'type' => Controls_Manager::TEXT,
                'default' => __( 'Generate QR Code', 'weddingpress' ),
                'label_block' => true,
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
                    '{{WRAPPER}} .wdp-form-nama' => 'margin-top:{{SIZE}}px;',
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

        /**
         * Style Tab: Product or Description
         */
        $this->start_controls_section(
            'section_label_style',
            [
                'label'                 => __( 'Labels', 'weddingpress' ),
                'tab'                   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'label_text_color',
            [
                'label'                 => __( 'Text Color', 'weddingpress' ),
                'type'                  => Controls_Manager::COLOR,
                'selectors'             => [
                    '{{WRAPPER}} .wdp-form-wrapper-kit label' => 'color: {{VALUE}};',
                ],
            ]
        );
        
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'                  => 'weddingpress_text_labels_typography',
                'label'                 => __( 'Typography', 'weddingpress' ),
                'selector'              => '{{WRAPPER}} .wdp-form-wrapper-kit label',
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
                    '{{WRAPPER}} .wdp-form-wrapper-kit input[type="text"], {{WRAPPER}} .wdp-form-wrapper-kit input[type="email"], {{WRAPPER}} .wdp-form-wrapper-kit textarea' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'input_typography',
                'label' => __('Typography', 'weddingpress'),
                'scheme' => Scheme_Typography::TYPOGRAPHY_4,
                'selector' => '{{WRAPPER}} .wdp-form-wrapper-kit input[type="text"], {{WRAPPER}} .wdp-form-wrapper-kit input[type="email"], {{WRAPPER}} .wdp-form-wrapper-kit textarea',
            ]
        );

        $this->add_control(
            'input_background_color',
            [
                'label' => __('Background Color', 'weddingpress'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .wdp-form-wrapper-kit input[type="text"], {{WRAPPER}} .wdp-form-wrapper-kit input[type="email"], {{WRAPPER}} .wdp-form-wrapper-kit textarea' => 'background-color: {{VALUE}};',
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
                'selector' => '{{WRAPPER}} .wdp-form-wrapper-kit input[type="text"], {{WRAPPER}} .wdp-form-wrapper-kit input[type="email"], {{WRAPPER}} .wdp-form-wrapper-kit textarea',
            ]
        );

        $this->add_control(
            'input_border_radius',
            [
                'label' => __('Border Radius', 'weddingpress'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .wdp-form-wrapper-kit input[type="text"], {{WRAPPER}} .wdp-form-wrapper-kit input[type="email"], {{WRAPPER}} .wdp-form-wrapper-kit textarea' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
                    '{{WRAPPER}} .wdp-form-wrapper-kit input[type="text"], {{WRAPPER}} .wdp-form-wrapper-kit input[type="email"], {{WRAPPER}} .wdp-form-wrapper-kit textarea' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
                    '{{WRAPPER}} .wdp-form-wrapper-kit input[type="submit"], {{WRAPPER}} .wdp-form-wrapper-kit button' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'typography',
                'label' => __('Typography', 'weddingpress'),
                'scheme' => Scheme_Typography::TYPOGRAPHY_4,
                'selector' => '{{WRAPPER}} .wdp-form-wrapper-kit input[type="submit"], {{WRAPPER}} .wdp-form-wrapper-kit button',
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
                    '{{WRAPPER}} .wdp-form-wrapper-kit input[type="submit"], {{WRAPPER}} .wdp-form-wrapper-kit button' => 'background-color: {{VALUE}};',
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
                'selector' => '{{WRAPPER}} .wdp-form-wrapper-kit input[type="submit"], {{WRAPPER}} .wdp-form-wrapper-kit button',
            ]
        );

        $this->add_control(
            'border_radius',
            [
                'label' => __('Border Radius', 'weddingpress'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .wdp-form-wrapper-kit input[type="submit"], {{WRAPPER}} .wdp-form-wrapper-kit button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
                    '{{WRAPPER}} .wdp-form-wrapper-kit input[type="submit"], {{WRAPPER}} .wdp-form-wrapper-kit button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
                    '{{WRAPPER}} .wdp-form-wrapper-kit input[type="submit"]:hover, {{WRAPPER}} .wdp-form-wrapper-kit button:hover' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'button_background_hover_color',
            [
                'label' => __('Background Color', 'weddingpress'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .wdp-form-wrapper-kit input[type="submit"]:hover, {{WRAPPER}} .wdp-form-wrapper-kit button:hover' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'button_hover_border_color',
            [
                'label' => __('Border Color', 'weddingpress'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .wdp-form-wrapper-kit input[type="submit"]:hover, {{WRAPPER}} .wdp-form-wrapper-kit button:hover' => 'border-color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->end_controls_section();

        
    }


    public function render( ) {

        $settings = $this->get_settings();

        $labels_class = ! $settings['form_labels'] ? 'elementor-screen-only' : '';

        $this->add_render_attribute( 'form_wrapper', 'class', 'wdp-form-wrapper-kit' );
        if (!$settings['hide_name']) {
        $field_name_label = $settings['field_name_label'];
        $field_name_value = '';
        $field_nama_class = 'wdp-form-nama';
        } else {
            $this->add_render_attribute('field_name', 'type', 'hidden');
            $this->add_render_attribute('field_name', 'value', 'hide');
        }

        $field_link_label = $settings['field_link_label'];
        $field_link_value = '';
        $field_link_class = 'wdp-form-nama';

        // $field_generate_label = $settings['field_generate_label'];
        // $field_generate_value = '';
        
        $field_submit_text = $settings['field_submit_text'];
        if ( !$field_submit_text ) {
            $field_submit_text = __( 'Generate', 'weddingpress' );
        }
        
        $this->add_render_attribute( 'wrapper', 'class', 'wdp-form-button' );

        if ( ! empty( $settings['form_display'] ) ) {
            $this->add_render_attribute( 'wrapper', 'class', 'elementor-wdp-form-display-' . $settings['form_display'] );
        }
        
        
        $this->add_render_attribute( 'field_name_label', 'class', $labels_class );
        $this->add_render_attribute( 'field_name', 'type', 'text' );
        $this->add_render_attribute( 'field_name', 'required', '1' );
        $this->add_render_attribute( 'field_name', 'value', $field_name_value );

        $this->add_render_attribute( 'field_link_label', 'class', $labels_class );
        $this->add_render_attribute( 'field_link', 'required', '1' );

        // $this->add_render_attribute( 'field_generate_label', 'class', $labels_class );
        // $this->add_render_attribute( 'field_generate', 'type', 'text' );
        // $this->add_render_attribute( 'field_generate', 'required', '1' );
        // $this->add_render_attribute( 'field_generate', 'value', $field_generate_value );

        $this->add_render_attribute( 'button', 'type', 'submit' );
        
        $this->add_render_attribute( 'wrapper', 'wdp-form-button' );

        $messageqr = $settings['copy_message'];

        $migrated = isset( $settings['__fa4_migrated']['selected_icon'] );
        $is_new = empty( $settings['icon'] ) && Icons_Manager::is_migration_allowed();

        ?>
        <div <?php echo $this->get_render_attribute_string( 'form_wrapper' ); ?>>
        <div class="elementor-lp-form-wrapper">
            <div class="wdp-form-nama">
                <label <?php echo $this->get_render_attribute_string( 'field_link_label' ); ?>>
                <?php echo $field_link_label; ?>
                </label></div>
                <input type="text" class="" name="link" id="link" placeholder="<?php echo $settings['field_link_placeholder'] ?>" required="required"></input>
            <?php if (!$settings['hide_name']) : ?>
            <div class="wdp-form-nama">
                <label <?php echo $this->get_render_attribute_string( 'field_name_label' ); ?>>
                <?php echo $field_name_label; ?>
                </label></div>
                <input type="text" class="" name="nama" id="nama" placeholder="<?php echo $settings['field_name_placeholder'] ?>" required="required"></input>
            <?php endif; ?>
            <div class="wdp-button-wrapper qrcode-button">
                <button class="wdp-form-button elementor%s-align-" type="submit" id="qr-gn"><?php if ( ! empty( $settings['icon'] ) || ! empty( $settings['selected_icon']['value'] ) ) : ?>
                        <span>
                            <?php if ( $is_new || $migrated ) :
                                Icons_Manager::render_icon( $settings['selected_icon'], [ 'aria-hidden' => 'true' ] );
                            else : ?>
                                <i class="<?php echo esc_attr( $settings['icon'] ); ?>" aria-hidden="true"></i>
                            <?php endif; ?>
                        </span>
                        <?php endif; ?><?php echo $field_submit_text; ?>
                </button> 
            </div>
        
            <div class="qrcode-show" id="munculkan" style="display:none;">
                <div class="qrcode-text">
                <p> Horey! Generate QR Code berhasil.</p>
                <?php if (!$settings['hide_name']) : ?>
                 <span type="text" class="" id="messageSpan1" value="" ></span>
                <?php else: ?>
                <span type="text" class="" id="messageSpan2" value="" ></span>
                <?php endif; ?>
                </div>
                <div class="wdp-center">
                <div class="" >
                <button id="cp_btn_qr">Copy Link</button>
                <button id="viewqr" target="_blank">View Link</button>
                <div class="share wdp-qrcode-copy"></div>
                </div>
                <div id="qrcode" class="wdp-qrcode-center"></div>
                </div>
            </div>

        </div>
        </div>
        
        <script>

            jQuery(document).ready(function($) {
               $("#qr-gn").click(function(){
                   $("#qrcode").html("");
                   var link = $.trim($('input[name="link"]').val()).replace(/ /g, '+');
                   var nama = $.trim($('input[name="nama"]').val()).replace("&", "%26");

                   var width = 200;
                   var height = 200;

                   txt = `<?php echo get_home_url(); ?>/` + link + `/?to=` + nama;

                   $("#viewqr").click(function() {
                       url = txt;
                       window.open(url, '_blank');
                    });

                   $('#munculkan').show();


                   generateQRcode(width, height, txt );
                   showMessage1();
                   showMessage2();
                   
                   return false;
               });

              
              function generateQRcode(width, height, text) {
                 $('#qrcode').qrcode({width: width,height: height,text: text});
              }

             function showMessage1() {
                    var link = jQuery("#link").val().replace(/ /g, '%20');
                    message = `<?php echo get_home_url(); ?>/` + link;
                    jQuery("#messageSpan2").text(message);

             }

             function showMessage2() {
                    var nama = jQuery("#nama").val().replace("&", "%26");
                    var link = jQuery("#link").val().replace(/ /g, '%20');
                    txt2 = `<?php echo get_home_url(); ?>/` + link + `/?to=` + nama;
                    jQuery("#messageSpan1").text(txt2);
             }


            });

            document.getElementById("cp_btn_qr").addEventListener("click", copy_password1);
            document.getElementById("cp_btn_qr").addEventListener("click", copy_password2);
 
            function copy_password1() {
                var copyText = document.getElementById("messageSpan1");
                var textArea = document.createElement("textarea");
                textArea.value = copyText.textContent;
                document.body.appendChild(textArea);
                textArea.select();
                document.execCommand("Copy");
                textArea.remove();
                document.querySelector('.share').innerHTML = "<?php echo $messageqr; ?>";
            }

            function copy_password2() {
                var copyText = document.getElementById("messageSpan2");
                var textArea = document.createElement("textarea");
                textArea.value = copyText.textContent;
                document.body.appendChild(textArea);
                textArea.select();
                document.execCommand("Copy");
                textArea.remove();
                document.querySelector('.share').innerHTML = "<?php echo $messageqr; ?>";
            }

        </script>

    <?php
    }

    public function on_import( $element ) {
        return Icons_Manager::on_import_migration( $element, 'icon', 'selected_icon' );
    }


    protected function content_template() {
    }
}

   