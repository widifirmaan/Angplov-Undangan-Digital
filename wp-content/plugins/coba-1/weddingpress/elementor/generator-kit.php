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
use Elementor\Widget_Base;

if (!defined('ABSPATH')) exit; // Exit if accessed directly

class WeddingPress_Widget_Generatorkit extends Widget_Base {

    public function get_name() {
        return 'weddingpress-generator-kit';
    }

    public function get_title() {
        return __( 'Generator Kit', 'weddingpress' );
    }

    public function get_icon() {
        return 'wdp_icon eicon-site-title';
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

    protected function register_controls() {
        $this->start_controls_section(
            'section_field_name',
            [
                'label' => __( 'Undangan', 'weddingpress' ),
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
            'field_name_label',
            [
                'label' => __( 'Label', 'weddingpress' ),
                'type' => Controls_Manager::TEXT,
              
                'default' => __( 'Undangan', 'weddingpress' ),
            ]
        );

        $this->add_control(
            'field_name_placeholder',
            [
                'label' => __( 'Placeholder', 'weddingpress' ),
                'type' => Controls_Manager::TEXT,
                
                'default' => __( 'Undangan', 'weddingpress' ),
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_field_message',
            [
                'label' => __( 'Nama Tamu', 'weddingpress' ),
            ]
        );

        $this->add_control(
            'field_message_label',
            [
                'label' => __( 'Label', 'weddingpress' ),
                'type' => Controls_Manager::TEXT,
                'default' => __( 'Nama Tamu', 'weddingpress' ),
            ]
        );

        $this->add_control(
            'field_message_placeholder',
            [
                'label' => __( 'Placeholder', 'weddingpress' ),
                'type' => Controls_Manager::TEXT,
                'default' => __( 'Nama Tamu', 'weddingpress' ),
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_field_generate',
            [
                'label' => __( 'Copy URL', 'weddingpress' ),
            ]
        );

        $this->add_control(
            'field_generate_label',
            [
                'label' => __( 'Label', 'weddingpress' ),
                'type' => Controls_Manager::TEXT,
                'default' => __( 'Copy URL', 'weddingpress' ),
            ]
        );


        $this->end_controls_section();
        
        
        $this->start_controls_section(
            'section_field_submit',
            [
                'label' => __( 'Generate URL', 'weddingpress' ),
            ]
        );

        $this->add_control(
            'field_submit_text',
            [
                'label' => __( 'Generate URL', 'weddingpress' ),
                'type' => Controls_Manager::TEXT,
                
               
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

    protected function render() {
        $settings = $this->get_settings();
    
        $labels_class = ! $settings['form_labels'] ? 'elementor-screen-only' : '';

        $this->add_render_attribute( 'form_wrapper', 'class', 'wdp-form-wrapper-kit' );

        $field_name_label = $settings['field_name_label'];
        $field_name_value = '';
        $field_nama_class = 'wdp-form-nama';
        

        $field_message_label = $settings['field_message_label'];
        $field_message_value = '';
        $field_message_class = 'wdp-form-nama';

        $field_generate_label = $settings['field_generate_label'];
        $field_generate_value = '';
        
        $field_submit_text = $settings['field_submit_text'];
        if ( !$field_submit_text ) {
            $field_submit_text = __( 'Generate URL', 'weddingpress' );
        }
        
        $this->add_render_attribute( 'wrapper', 'class', 'wdp-form-button' );
        if ( ! empty( $settings['form_display'] ) ) {
            $this->add_render_attribute( 'wrapper', 'class', 'elementor-wdp-form-display-' . $settings['form_display'] );
        }
        
        
        $this->add_render_attribute( 'field_name_label', 'class', $labels_class );
        $this->add_render_attribute( 'field_name', 'type', 'text' );
        $this->add_render_attribute( 'field_name', 'required', '1' );
        $this->add_render_attribute( 'field_name', 'value', $field_name_value );
        
        $this->add_render_attribute( 'field_message_label', 'class', $labels_class );
        $this->add_render_attribute( 'field_message', 'required', '1' );

        $this->add_render_attribute( 'field_generate_label', 'class', $labels_class );
        $this->add_render_attribute( 'field_generate', 'type', 'text' );
        $this->add_render_attribute( 'field_generate', 'required', '1' );
        $this->add_render_attribute( 'field_generate', 'value', $field_generate_value );

        $this->add_render_attribute( 'button', 'type', 'submit' );
        
        $this->add_render_attribute( 'wrapper', 'wdp-form-button' );
        // $messagekit = $settings['copy_messagekit'];
        
        ?>
        
            <div <?php echo $this->get_render_attribute_string( 'form_wrapper' ); ?>>
                <div class="weddingpress-form-fields-wrapper">
                   <form action="action.php" id="postData">
                     
                        <div class="wdp-form-nama">
                            <label <?php echo $this->get_render_attribute_string( 'field_name_label' ); ?>>
                                <?php echo $field_name_label; ?>
                            </label>
                        </div>
                            <input type="text" class="" id="undangan" placeholder="<?php echo $settings['field_name_placeholder'] ?>" name="undangan" required>

                        <div class="wdp-form-nama">
                            <label <?php echo $this->get_render_attribute_string( 'field_message_label' ); ?>>
                                <?php echo $field_message_label; ?>
                            </label>
                        </div>
                            <input type="text" class="" id="tamu" placeholder="<?php echo $settings['field_message_placeholder'] ?>" name="tamu" required>

                         <div class="wdp-form-nama">
                              <label for="tamu">Keterangan Di/ Dari/ Asal</label>
                              <select id="kota" name="kota">
                                  <option value=""></option>
                                 <option value="+Di+:+">Di:</option>
                                 <option value="+Dari+:+">Dari:</option>
                                 <option value="+Asal+:+">Asal:</option>
                                </select>
                        </div>
                       
                            <input type="text" class="" id="asal" name="asal" placeholder="Kota/Kabupaten">
                       
                        <div class="">
                            <button type="submit" class="wdp-form-button elementor%s-align-" id="submit"><?php echo $field_submit_text; ?></button>
                        </div>
                    
                </form>

                <div class="" style="padding-top: 1.6rem!important;"></div>

                    <div class="wdp-form-nama">
                        <label <?php echo $this->get_render_attribute_string( 'field_generate_label' ); ?>>
                            <?php echo $field_generate_label; ?>
                        </label>
                    </div>
               
                        <input type="text" class="" style="width: auto;" id="result" readonly>
                    <div class="">
                        <button id="copykit">Copy Link</button>
                        <a id="linkkit" target="_blank"><button class="wdp-form-button elementor%s-align-">View Link</button></a>
                        <a href="#" id="wa" target="_blank"><button style="margin-top:10px;" class="wdp-form-button elementor%s-align-">Share to Whatsapp</button></a>
                    </div>
                    <span class="share wdp-notice-copy"></span>
                </div>
            </div>

    
        <script type="text/javascript">
            let submit =  document.querySelector('#submit');
            let result =  document.querySelector('#result');
            let undangan = document.querySelector('#undangan');
            let tamu = document.querySelector('#tamu');
            let asal = document.querySelector('#asal');
            let kota = document.querySelector('#kota');
            let copy = document.querySelector('#copykit');
            let form =  document.querySelector('#postData');

            form.addEventListener('submit',  event => {
                event.preventDefault();
                const data = new URLSearchParams();
                for(const p of new FormData(form)){
                    data.append(p[0], p[1]);
                }
                fetch('action.php', {
                    method: 'POST',
                    body: data
                })
                .then(response => response.text())
                .then(response => {
                    console.log(response);
                })
                .catch(error => console.log(error));
            });

            submit.onclick = () => {
                if(undangan.value.length !== 0 && tamu.value.length !== 0){
                    let undanganReplace = undangan.value.replace(/ /g, '+');
                    let kotaReplace = kota.value.replace(/ /g, '+');
                    let tamuReplace = tamu.value.replace(/ /g, '+');
                    let asalReplace = asal.value.replace(/ /g, '+');
                    undanganReplace = undanganReplace.replace("&", "%26");
                    tamuReplace = tamuReplace.replace("&", "dan");
                    result.value = `<?php echo get_home_url(); ?>/${undanganReplace}?to=${tamuReplace}${kotaReplace}${asalReplace}`;                   
                    let resultReplace = result.value.replace(/\+/g, '%2B').replace('<br>', '%3Cbr%3E').replace('%3Cbr%3E', '%253Cbr%253E').replace('%26','%2526');


                /**
                * Merubah Isi Pesan share to WhatsApp!
                * gunakan parameter:  
                * ${undanganReplace} untuk munculkan nama undangan/acara
                * ${tamuReplace} untuk munculkan nama tamu
                * ${kotaReplace} untuk munculkan keterangan Di/ Dari/ Asal
                * ${asalReplace} untuk munculkan nama kota/kabupaten/lokasi
                * ${resultReplace} untuk munculkan link undangan
                *
                * Penggunaan Kode Style
                * %0A%0A untuk 2 spasi enter ke bawah
                * %0A untuk 1 spasi enter ke bawah
                * 
                */
                    result.valuewa = `https://api.whatsapp.com/send?text=Assalamu'alaikum Wr. Wb %0ABismillahirahmanirrahim. Tanpa mengurangi rasa hormat, perkenankan kami mengundang Bapak/Ibu/Saudara/i - ${tamuReplace} - untuk menghadiri acara kami. %0A%0A *Berikut link undangan kami*, untuk info lengkap dari acara bisa kunjungi : %0A${resultReplace} %0A%0AMerupakan suatu kebahagiaan bagi kami apabila Bapak/Ibu/Saudara/i berkenan untuk hadir dan memberikan doa restu. %0A%0A*Mohon maaf perihal undangan hanya di bagikan melalui pesan ini.* %0A%0ADan karena suasana masih pandemi, diharapakan untuk *tetap menggunakan masker dan datang pada jam yang telah ditentukan.* %0A%0ATerima kasih banyak atas perhatiannya. %0AWassalamu'alaikum Wr. Wb. %0A%0ATerima Kasih.`; 

                    document.getElementById("linkkit").href= result.value ;
                    document.getElementById("wa").href= result.valuewa ;
                    
                }
            };
            copy.onclick = () => {
                if(result.value.length !== 0) {
                    undangan.value = "";
                    tamu.value = "";
                    result.select();
                    result.setSelectionRange(0, 99999); 
                    document.execCommand("Copy");
                    
                }                
            }
        </script>
        <?php
    }

}