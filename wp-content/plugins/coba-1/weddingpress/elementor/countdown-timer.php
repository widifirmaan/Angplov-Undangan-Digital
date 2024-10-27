<?php

namespace WeddingPress\elementor;

// Elementor Classes.
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Border;
use Elementor\Core\Schemes\Color as Scheme_Color;
use Elementor\Core\Schemes\Typography as Scheme_Typography;
use Elementor\Utils;
use Elementor\Widget_Base;

if ( ! defined( 'ABSPATH' ) ) {
	exit;   // Exit if accessed directly.
}

/**
 * Class Countdown.
 */
class WeddingPress_Widget_Countdown_Timer extends Widget_Base {

	public function get_name() {
		return 'weddingpress-countdown';
	}

	public function get_title() {
		return __( 'Countdown', 'weddingpress' );
	}

	public function get_icon() {
		return 'elkit_icon eicon-countdown';
	}
	
	public function get_categories() {
		return [ 'weddingpress' ];
	}

	public function get_script_depends() {
        return [ 'weddingpress-wdp' ];
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
  			'wpkoi_elements_section_countdown_settings_general',
  			[
  				'label' => esc_html__( 'Countdown Settings', 'wpkoi-elements' )
  			]
  		);
		
		$this->add_control(
			'wpkoi_elements_countdown_due_time',
			[
				'label' => esc_html__( 'Countdown Target Date', 'wpkoi-elements' ),
				'type' => Controls_Manager::DATE_TIME,
				'default' => date("Y-m-d", strtotime("+ 1 day")),
				'description' => esc_html__( 'Set the target date and time', 'wpkoi-elements' ),
			]
		);

		$this->add_control(
			'wpkoi_elements_countdown_label_view',
			[
				'label' => esc_html__( 'Position', 'wpkoi-elements' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'wpkoi-elements-countdown-label-block',
				'options' => [
					'wpkoi-elements-countdown-label-block' => esc_html__( 'Block', 'wpkoi-elements' ),
					'wpkoi-elements-countdown-label-inline' => esc_html__( 'Inline', 'wpkoi-elements' ),
				],
			]
		);

		$this->add_responsive_control(
			'wpkoi_elements_countdown_label_padding_left',
			[
				'label' => esc_html__( 'Left spacing', 'wpkoi-elements' ),
				'type' => Controls_Manager::SLIDER,
				'description' => esc_html__( 'Use when you select inline labels', 'wpkoi-elements' ),
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .wpkoi-elements-countdown-label' => 'padding-left:{{SIZE}}px;',
				],
				'condition' => [
					'wpkoi_elements_countdown_label_view' => 'wpkoi-elements-countdown-label-inline',
				],
			]
		);

		$this->add_control(
			'wpkoi_elements_countdown_days',
			[
				'label' => esc_html__( 'Display Days', 'wpkoi-elements' ),
				'type' => Controls_Manager::SWITCHER,
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);

		$this->add_control(
			'wpkoi_elements_countdown_days_label',
			[
				'label' => esc_html__( 'Label for Days', 'wpkoi-elements' ),
				'type' => Controls_Manager::TEXT,
				'default' => esc_html__( 'Hari', 'wpkoi-elements' ),
				'condition' => [
					'wpkoi_elements_countdown_days' => 'yes',
				],
			]
		);
		

		$this->add_control(
			'wpkoi_elements_countdown_hours',
			[
				'label' => esc_html__( 'Display Hours', 'wpkoi-elements' ),
				'type' => Controls_Manager::SWITCHER,
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);

		$this->add_control(
			'wpkoi_elements_countdown_hours_label',
			[
				'label' => esc_html__( 'Label for Hours', 'wpkoi-elements' ),
				'type' => Controls_Manager::TEXT,
				'default' => esc_html__( 'Jam', 'wpkoi-elements' ),
				'condition' => [
					'wpkoi_elements_countdown_hours' => 'yes',
				],
			]
		);

		$this->add_control(
			'wpkoi_elements_countdown_minutes',
			[
				'label' => esc_html__( 'Display Minutes', 'wpkoi-elements' ),
				'type' => Controls_Manager::SWITCHER,
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);

		$this->add_control(
			'wpkoi_elements_countdown_minutes_label',
			[
				'label' => esc_html__( 'Label for Minutes', 'wpkoi-elements' ),
				'type' => Controls_Manager::TEXT,
				'default' => esc_html__( 'Menit', 'wpkoi-elements' ),
				'condition' => [
					'wpkoi_elements_countdown_minutes' => 'yes',
				],
			]
		);
			
		$this->add_control(
			'wpkoi_elements_countdown_seconds',
			[
				'label' => esc_html__( 'Display Seconds', 'wpkoi-elements' ),
				'type' => Controls_Manager::SWITCHER,
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);

		$this->add_control(
			'wpkoi_elements_countdown_seconds_label',
			[
				'label' => esc_html__( 'Label for Seconds', 'wpkoi-elements' ),
				'type' => Controls_Manager::TEXT,
				'default' => esc_html__( 'Detik', 'wpkoi-elements' ),
				'condition' => [
					'wpkoi_elements_countdown_seconds' => 'yes',
				],
			]
		);

		$this->add_control(
			'wpkoi_elements_countdown_separator_heading',
			[
				'label' => __( 'Countdown Separator', 'wpkoi-elements' ),
				'type' => Controls_Manager::HEADING,
			]
		);

		$this->add_control(
			'wpkoi_elements_countdown_separator',
			[
				'label' => esc_html__( 'Display Separator', 'wpkoi-elements' ),
				'type' => Controls_Manager::SWITCHER,
				'return_value' => 'wpkoi-elements-countdown-show-separator',
				'default' => '',
			]
		);


		$this->end_controls_section();
		
		$this->start_controls_section(
			'wpkoi_elements_section_countdown_styles_general',
			[
				'label' => esc_html__( 'Countdown Styles', 'wpkoi-elements' ),
				'tab' => Controls_Manager::TAB_STYLE
			]
		);

		$this->add_responsive_control(
			'wpkoi_elements_countdown_spacing',
			[
				'label' => esc_html__( 'Space Between Boxes', 'wpkoi-elements' ),
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
					'{{WRAPPER}} .wpkoi-elements-countdown-item > div' => 'margin-right:{{SIZE}}px; margin-left:{{SIZE}}px;',
					'{{WRAPPER}} .wpkoi-elements-countdown-container' => 'margin-right: -{{SIZE}}px; margin-left: -{{SIZE}}px;',
				],
			]
		);
		
		$this->add_responsive_control(
			'wpkoi_elements_countdown_container_margin_bottom',
			[
				'label' => esc_html__( 'Space Below Container', 'wpkoi-elements' ),
				'type' => Controls_Manager::SLIDER,
				'default' => [
					'size' => 0,
				],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .wpkoi-elements-countdown-container' => 'margin-bottom:{{SIZE}}px;',
				],
			]
		);
		
		$this->add_responsive_control(
			'wpkoi_elements_countdown_box_padding',
			[
				'label' => esc_html__( 'Padding', 'wpkoi-elements' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .wpkoi-elements-countdown-item > div' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'wpkoi_elements_countdown_box_border',
				'label' => esc_html__( 'Border', 'wpkoi-elements' ),
				'selector' => '{{WRAPPER}} .wpkoi-elements-countdown-item > div',
			]
		);

		$this->add_control(
			'wpkoi_elements_countdown_box_border_radius',
			[
				'label' => esc_html__( 'Border Radius', 'wpkoi-elements' ),
				'type' => Controls_Manager::DIMENSIONS,
				'selectors' => [
					'{{WRAPPER}} .wpkoi-elements-countdown-item > div' => 'border-radius: {{TOP}}px {{RIGHT}}px {{BOTTOM}}px {{LEFT}}px;',
				],
			]
		);
		
		$this->end_controls_section();
		
		
		$this->start_controls_section(
			'wpkoi_elements_section_countdown_styles_content',
			[
				'label' => esc_html__( 'Color &amp; Typography', 'wpkoi-elements' ),
				'tab' => Controls_Manager::TAB_STYLE
			]
		);

		$this->add_control(
			'wpkoi_elements_countdown_box_bg_heading',
			[
				'label' => __( 'Element Background', 'wpkoi-elements' ),
				'type' => Controls_Manager::HEADING,
			]
		);
		
		$this->add_control(
			'wpkoi_elements_countdown_background',
			[
				'label' => esc_html__( 'Element Background Color', 'wpkoi-elements' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#111111',
				'selectors' => [
					'{{WRAPPER}} .wpkoi-elements-countdown-item > div' => 'background: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'wpkoi_elements_countdown_digits_heading',
			[
				'label' => __( 'Countdown Digits', 'wpkoi-elements' ),
				'type' => Controls_Manager::HEADING,
			]
		);

		$this->add_control(
			'wpkoi_elements_countdown_digits_color',
			[
				'label' => esc_html__( 'Digits Color', 'wpkoi-elements' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .wpkoi-elements-countdown-digits' => 'color: {{VALUE}};',
				],
			]
		);
		
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
             'name' => 'wpkoi_elements_countdown_digit_typography',
				'scheme' => Scheme_Typography::TYPOGRAPHY_2,
				'selector' => '{{WRAPPER}} .wpkoi-elements-countdown-digits',
			]
		);

		$this->add_control(
			'wpkoi_elements_countdown_label_heading',
			[
				'label' => __( 'Countdown Labels', 'wpkoi-elements' ),
				'type' => Controls_Manager::HEADING,
			]
		);

		$this->add_control(
			'wpkoi_elements_countdown_label_color',
			[
				'label' => esc_html__( 'Label Color', 'wpkoi-elements' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .wpkoi-elements-countdown-label' => 'color: {{VALUE}};',
				],
			]
		);
		
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
             'name' => 'wpkoi_elements_countdown_label_typography',
				'scheme' => Scheme_Typography::TYPOGRAPHY_2,
				'selector' => '{{WRAPPER}} .wpkoi-elements-countdown-label',
			]
		);	

		$this->add_control(
			'wpkoi_elements_countdown_separator_c_heading',
			[
				'label' => __( 'Separator', 'wpkoi-elements' ),
				'type' => Controls_Manager::HEADING,
				'condition' => [
					'wpkoi_elements_countdown_separator' => 'wpkoi-elements-countdown-show-separator',
				],
			]
		);

		$this->add_control(
			'wpkoi_elements_countdown_separator_color',
			[
				'label' => esc_html__( 'Separator Color', 'wpkoi-elements' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'condition' => [
					'wpkoi_elements_countdown_separator' => 'wpkoi-elements-countdown-show-separator',
				],
				'selectors' => [
					'{{WRAPPER}} .wpkoi-elements-countdown-digits::after' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
             'name' => 'wpkoi_elements_countdown_separator_typography',
				'scheme' => Scheme_Typography::TYPOGRAPHY_2,
				'selector' => '{{WRAPPER}} .wpkoi-elements-countdown-digits::after',
				'condition' => [
					'wpkoi_elements_countdown_separator' => 'wpkoi-elements-countdown-show-separator',
				],
			]
		);	


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

	protected function render( ) {
		
      $settings = $this->get_settings();
		
		$get_due_date =  esc_attr($settings['wpkoi_elements_countdown_due_time']);
		$due_date = date("M d Y G:i:s", strtotime($get_due_date));
	?>

	<div class="wpkoi-elements-countdown-wrapper">
		<div class="wpkoi-elements-countdown-container <?php echo esc_attr($settings['wpkoi_elements_countdown_label_view'] ); ?> <?php echo esc_attr($settings['wpkoi_elements_countdown_separator'] ); ?>">		
			<ul id="wpkoi-elements-countdown-<?php echo esc_attr($this->get_id()); ?>" class="wpkoi-elements-countdown-items" data-date="<?php echo esc_attr($due_date) ; ?>">
			    <?php if ( ! empty( $settings['wpkoi_elements_countdown_days'] ) ) : ?><li class="wpkoi-elements-countdown-item"><div class="wpkoi-elements-countdown-days"><span data-days class="wpkoi-elements-countdown-digits">00</span><?php if ( ! empty( $settings['wpkoi_elements_countdown_days_label'] ) ) : ?><span class="wpkoi-elements-countdown-label"><?php echo esc_attr($settings['wpkoi_elements_countdown_days_label'] ); ?></span><?php endif; ?></div></li><?php endif; ?>
			    <?php if ( ! empty( $settings['wpkoi_elements_countdown_hours'] ) ) : ?><li class="wpkoi-elements-countdown-item"><div class="wpkoi-elements-countdown-hours"><span data-hours class="wpkoi-elements-countdown-digits">00</span><?php if ( ! empty( $settings['wpkoi_elements_countdown_hours_label'] ) ) : ?><span class="wpkoi-elements-countdown-label"><?php echo esc_attr($settings['wpkoi_elements_countdown_hours_label'] ); ?></span><?php endif; ?></div></li><?php endif; ?>
			   <?php if ( ! empty( $settings['wpkoi_elements_countdown_minutes'] ) ) : ?><li class="wpkoi-elements-countdown-item"><div class="wpkoi-elements-countdown-minutes"><span data-minutes class="wpkoi-elements-countdown-digits">00</span><?php if ( ! empty( $settings['wpkoi_elements_countdown_minutes_label'] ) ) : ?><span class="wpkoi-elements-countdown-label"><?php echo esc_attr($settings['wpkoi_elements_countdown_minutes_label'] ); ?></span><?php endif; ?></div></li><?php endif; ?>
			   <?php if ( ! empty( $settings['wpkoi_elements_countdown_seconds'] ) ) : ?><li class="wpkoi-elements-countdown-item"><div class="wpkoi-elements-countdown-seconds"><span data-seconds class="wpkoi-elements-countdown-digits">00</span><?php if ( ! empty( $settings['wpkoi_elements_countdown_seconds_label'] ) ) : ?><span class="wpkoi-elements-countdown-label"><?php echo esc_attr($settings['wpkoi_elements_countdown_seconds_label'] ); ?></span><?php endif; ?></div></li><?php endif; ?>
			</ul>
			<div class="clearfix"></div>
		</div>
	</div>


	<script type="text/javascript">
	jQuery(document).ready(function($) {
		'use strict';
		$("#wpkoi-elements-countdown-<?php echo esc_attr($this->get_id()); ?>").countdown();
	});
	</script>
	
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