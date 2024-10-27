<?php

namespace WeddingPress\elementor;

// Elementor Classes.
use Elementor\Controls_Manager;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Typography;
use Elementor\Core\Schemes\Color as Scheme_Color;
use Elementor\Core\Schemes\Typography as Scheme_Typography;
use Elementor\Utils;
use Elementor\Widget_Base;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class WeddingPress_Widget_Guest_Book extends Widget_Base {

	public function get_name() {
		return 'weddingpress-guestbook';
	}

	public function get_title() {
		return __( 'Guest Book', 'weddingpress' );
	}

	public function get_icon() {
		return 'elkit_icon eicon-testimonial';
	}

	public function get_categories() {
		return [ 'weddingpress' ];
	}

	public function get_script_depends() {
        return [ 'weddingpress-wdp' ];
    }
	
	public function get_keywords() {
		return [ 'guestbook, buku tamu, ucapan selamat' ];
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

	protected function register_controls() {


		$this->start_controls_section(
			'section_guestbook',
			[
				'label' => __( 'Guest Book', 'weddingpress' ),
			]
		);
		
		$this->add_control(
			'important_description',
			[
				'raw' => __( '<b>Info:</b> Widget GuestBook hanya bisa dipakai 1 (satu) di tiap page atau landing page, tidak boleh double dalam 1 (satu) page.<br> Nama form gunakan nama yang berbeda dengan form lain, bisa isi dengan angka, huruf atau angka huruf.', 'weddingpress'),
				'content_classes' => 'elementor-panel-alert elementor-panel-alert-info',
				'render_type'     => 'ui',
				'type'            => Controls_Manager::RAW_HTML,
			]
		);

		$this->add_control(
            'comment_by_name',
            [
                'label' => __('Comment by Name', 'weddingpress'),
                'rows' => '6',
                'type' => Controls_Manager::SELECT,
                'options' => array(
                    'yes' => __('Yes', 'weddingpress'),
                    'no' => __('No', 'weddingpress')
                ),
                'default' => 'no', 
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'message_params',
            [
                'raw' => __('GuestBook hanya bisa diisi oleh orang yang diudang lewat link undangan digital, untuk menghidari spam.', 'weddingpress'),
                'type' => Controls_Manager::RAW_HTML,
                'classes' => 'elementor-descriptor',
            ]
        );

		$this->add_control(
			'data_id',
			[
				'label' => __( 'Nama Form', 'weddingpress' ),
				'type' => Controls_Manager::TEXT,
				'default' => 'Nama Undangan',
				'show_label' => true,
				'separator' => 'before',

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
				'default' => 'yes',
				'separator' => 'before',
			]
		);
			
		
		$this->add_control(
			'avatar',
			[
				'label' => __( 'Choose Image', 'weddingpress' ),
				'type' => Controls_Manager::MEDIA,
				'default' => [
					'url' => Utils::get_placeholder_image_src(),
				],
				'separator' => 'before',
			]
		);

		$this->end_controls_section();
		
		$this->start_controls_section(
			'section_field_name',
			[
				'label' => __( 'Nama', 'weddingpress' ),
			]
		);

		$this->add_control(
			'field_name_label',
			[
				'label' => __( 'Label', 'weddingpress' ),
				'type' => Controls_Manager::TEXT,
				'default' => __( 'Nama', 'weddingpress' ),
				'placeholder' => __( 'Isikan Nama Anda', 'weddingpress' ),
			]
		);

		$this->add_control(
			'field_name_placeholder',
			[
				'label' => __( 'Placeholder', 'weddingpress' ),
				'type' => Controls_Manager::TEXT,
				'default' => __( 'Isikan Nama Anda', 'weddingpress' ),
				'placeholder' => __( 'Isikan Nama Anda', 'weddingpress' ),
			]
		);

		$this->end_controls_section();
		
		$this->start_controls_section(
			'section_field_message',
			[
				'label' => __( 'Pesan', 'weddingpress' ),
			]
		);

		$this->add_control(
			'field_message_label',
			[
				'label' => __( 'Label', 'weddingpress' ),
				'type' => Controls_Manager::TEXT,
				'default' => __( 'Pesan', 'weddingpress' ),
				'placeholder' => __( 'Berikan Ucapan Dan Doa Restu', 'weddingpress' ),
			]
		);

		$this->add_control(
			'field_message_placeholder',
			[
				'label' => __( 'Placeholder', 'weddingpress' ),
				'type' => Controls_Manager::TEXT,
				'default' => __( 'Berikan Ucapan Dan Doa Restu', 'weddingpress' ),
				'placeholder' => __( 'Berikan Ucapan Dan Doa Restu', 'weddingpress' ),
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_field_confirm',
			[
				'label' => __( 'Confirmation', 'weddingpress' ),
			]
		);

		$this->add_control(
			'field_confirm_label',
			[
				'label' => __( 'Label', 'weddingpress' ),
				'type' => Controls_Manager::TEXT,
				'default' => __( 'Konfirmasi Kehadiran', 'weddingpress' ),
				'placeholder' => __( 'Konfirmasi Kehadiran', 'weddingpress' ),
			]
		);

		$this->add_control(
            'show_confirm',
            [
                'label' => __('Show Confirmation', 'weddingpress'),
                'type' => Controls_Manager::SELECT,
                'options' => array(
                    'yes' => __('Yes', 'weddingpress'),
                    'no' => __('No', 'weddingpress')
                ),
                'default' => 'no', 
            ]
        );


		$this->end_controls_section();
		
		
		$this->start_controls_section(
			'section_field_submit',
			[
				'label' => __( 'Submit Button', 'weddingpress' ),
			]
		);

		$this->add_control(
			'field_submit_text',
			[
				'label' => __( 'Text', 'weddingpress' ),
				'type' => Controls_Manager::TEXT,
				'default' => __( 'Kirimkan Ucapan', 'weddingpress' ),
				'placeholder' => __( 'Kirimkan Ucapan', 'weddingpress' ),
			]
		);

		$this->add_responsive_control(
			'field_submit_align',
			[
				'label' => __( 'Alignment', 'weddingpress' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'left'    => [
						'title' => __( 'Left', 'weddingpress' ),
						'icon' => 'eicon-text-align-left',
					],
					'center' => [
						'title' => __( 'Center', 'weddingpress' ),
						'icon' => 'eicon-text-align-center',
					],
					'right' => [
						'title' => __( 'Right', 'weddingpress' ),
						'icon' => 'eicon-text-align-right',
					],
					'justify' => [
						'title' => __( 'Justified', 'weddingpress' ),
						'icon' => 'eicon-text-align-justify',
					],
				],
				'prefix_class' => 'elementor%s-align-',
				'default' => '',
			]
		);

		$this->end_controls_section();
		
		$this->start_controls_section(
			'section_name_style',
			[
				'label' => __( 'Nama', 'weddingpress' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'name_text_color',
			[
				'label' => __( 'Text Color', 'weddingpress' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .guestbook-name' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'name_typography',
				'label' => __( 'Typography', 'weddingpress' ),
				'scheme' => Scheme_Typography::TYPOGRAPHY_4,
				'selector' => '{{WRAPPER}} .guestbook-name',
			]
		);

		$this->end_controls_section();
		
		$this->start_controls_section(
			'section_message_style',
			[
				'label' => __( 'Pesan', 'weddingpress' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'message_text_color',
			[
				'label' => __( 'Text Color', 'weddingpress' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .guestbook-message' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'message_typography',
				'label' => __( 'Typography', 'weddingpress' ),
				'scheme' => Scheme_Typography::TYPOGRAPHY_4,
				'selector' => '{{WRAPPER}} .guestbook-message',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_confirm_style',
			[
				'label' => __( 'Confirm', 'weddingpress' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'confirm_bg_color',
			[
				'label' => __( 'Background Color', 'weddingpress' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .wdp-confirm' => 'background: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'confirm_text_color',
			[
				'label' => __( 'Text Color', 'weddingpress' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .wdp-confirm' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'confirm_typography',
				'label' => __( 'Typography', 'weddingpress' ),
				'scheme' => Scheme_Typography::TYPOGRAPHY_4,
				'selector' => '{{WRAPPER}} .wdp-confirm',
			]
		);

		$this->end_controls_section();
		
		$this->start_controls_section(
			'section_button_style',
			[
				'label' => __( 'Form Button', 'weddingpress' ),
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
				'default' => '1px',
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

  /**
   * Render the widget output on the frontend.
   *
   * Written in PHP and used to generate the final HTML.
   *
   * @since 1.1.0
   *
   * @access protected
   */  
	protected function render() {
		$settings = $this->get_settings();
		$data_array = get_option('post_guestbook_box_data'.$settings['data_id'],array());
		
		$labels_class = ! $settings['form_labels'] ? 'elementor-screen-only' : '';
		
		$field_name_label = $settings['field_name_label'];
		$field_name_value = '';
		
		$field_message_label = $settings['field_message_label'];
		$field_message_value = '';

		$field_confirm_label = $settings['field_confirm_label'];
		$field_confirm_value = '';
		
		$field_submit_text = $settings['field_submit_text'];
		if ( !$field_submit_text ) {
			$field_submit_text = __( 'Kirim', 'weddingpress' );
		}

		$this->add_render_attribute( 'wrapper', 'class', 'elementor-lp-form-wrapper' );
		if ( ! empty( $settings['form_display'] ) ) {
			$this->add_render_attribute( 'wrapper', 'class', 'elementor-lp-form-display-' . $settings['form_display'] );
		}
		
		
		$this->add_render_attribute( 'field_name_label', 'class', $labels_class );
		$this->add_render_attribute( 'field_name', 'type', 'text' );
		$this->add_render_attribute( 'field_name', 'required', '1' );
		$this->add_render_attribute( 'field_name', 'value', $field_name_value );
		
		$this->add_render_attribute( 'field_message_label', 'class', $labels_class );
		$this->add_render_attribute( 'field_message', 'required', '1' );

		$this->add_render_attribute( 'field_confirm_label', 'class', $labels_class );
		$this->add_render_attribute( 'field_confirm', 'required', '1' );

		$this->add_render_attribute( 'button', 'type', 'submit' );
		
		$this->add_render_attribute( 'wrapper', 'elementor-comment-box-wrapper' );
		$image_html = Group_Control_Image_Size::get_attachment_image_html( $settings, 'thumbnail', 'avatar' );
		$display = isset($settings['comment_by_name']) ? $settings['comment_by_name'] : 'yes';
		$display_confirm = isset($settings['show_confirm']) ? $settings['show_confirm'] : 'yes';
		?>
	
		
		<div class="guestbook-box-content elementor-comment-box-wrapper" 
			data-id="<?php echo $settings['data_id']; ?>" 
		>		
			<div class="comment-form-container">
				<form id="post-guestbook-box">
					<div class="guestbook-label">
					<label <?php echo $this->get_render_attribute_string( 'field_name_label' ); ?>>
							<?php echo $field_name_label; ?>
					</label></div>
					<?php if ('yes' === $display) : ?>
                         <input style="pointer-events: none;" class="form-control" type="text" name="guestbook-name" placeholder="Mohon maaf, hanya tamu undangan yang dapat memberikan ucapan!" value="<?php echo $_GET['to']; ?>" required nofocus readonly="readonly">
                	<?php else: ?>
                    <input class="form-control" type="text" name="guestbook-name" placeholder="<?php echo $settings['field_name_placeholder'] ?>" required >
                	<?php endif; ?>					
					<div class="guestbook-label">
					<label <?php echo $this->get_render_attribute_string( 'field_message_label' ); ?>>
							<?php echo $field_message_label; ?>
					</label></div>
					<textarea class="form-control" rows="3" name="guestbook-message" placeholder="<?php echo $settings['field_message_placeholder'] ?>" required ></textarea>
					<?php if ('yes' === $display_confirm) : ?>
						<div class="guestbook-label">
						<label <?php echo $this->get_render_attribute_string( 'field_confirm_label' ); ?>>
								<?php echo $field_confirm_label; ?>
						</label>
						</div>
						<select class="form-control" name="confirm" required>
							<option value="">Konfirmasi Kehadiran</option>
							<option value="Hadir">Hadir</option>
							<option value="Akan Hadir">Akan Hadir</option>
							<option value="Tidak Hadir">Tidak Hadir</option>
						</select>
					<?php else: ?>
					<?php endif; ?>
					<div class="elementor-button-wrapper">
						<button type="submit" class="elementor-button-link elementor-button elementor-size-sm">
							<?php echo $field_submit_text; ?>
						</button>
					</div>
				</form>
			</div>
			
			<div id="hidden-avatar" style="display:none;"><?php echo $image_html; ?></div>
			
			<div class="guestbook-list">
				<?php for($i = count($data_array) - 1; $i>=0; $i--) { 
				
					$data = $data_array[$i];
					?>
				
					<div class="user-guestbook">
						<div><?php echo $image_html; ?></div>
						<div class="guestbook">
							<a class="guestbook-name"><?php echo str_replace("\\", "", htmlspecialchars ($data['name']))?></a><span class="wdp-confirm"><i class="fas fa-check-circle"></i> <?php echo $data['confirm']?></span>
							<div class="guestbook-message"><?php echo str_replace("\\", "", htmlspecialchars ($data['message']))?></div>
						</div>
					</div>
			
				<?php } ?>
			</div>
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
