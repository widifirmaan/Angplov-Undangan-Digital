<?php
namespace WeddingPress\elementor;

// Elementor Classes.
use Elementor\Controls_Manager;
use Elementor\Icons_Manager;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Typography;
use Elementor\Core\Schemes\Color as Scheme_Color;
use Elementor\Core\Schemes\Typography as Scheme_Typography;
use Elementor\Utils;
use Elementor\Widget_Base;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class WeddingPress_Widget_Audio extends Widget_Base {

	public function get_name() {
		return 'weddingpress-audio';
	}

	public function get_title() {
		return __( 'Audio MP3', 'weddingpress' );
	}

	public function get_icon() {
		return 'elkit_icon eicon-headphones';
	}

	public function get_categories() {
		return [ 'weddingpress' ];
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
			'section_audio',
			[
				'label' => __( 'Audio MP3', 'weddingpress' ),
			]
		);

		$this->add_control(
            'src_type',
            [
                'label' => esc_html__( 'Audio Source', 'weddingpress' ),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'upload',
                'options' => [
                    'upload' => esc_html__( 'Upload Audio', 'weddingpress' ),
                    'link' => esc_html__( 'Audio Link', 'weddingpress' ),
                ],
            ]
        );

		$this->add_control(
            'audio_upload',
            array(
                'label' => esc_html__( 'Upload Audio', 'weddingpress' ),
                'type'  => \Elementor\Controls_Manager::MEDIA,
                'media_type' => 'audio',
                'condition' => array(
                    'src_type' => 'upload',
                ),
            )
        );

        $this->add_control(
            'audio_link',
            [
                'label' => esc_html__( 'Audio Link', 'weddingpress' ),
                'type' => \Elementor\Controls_Manager::URL,
                'placeholder' => esc_html__( 'https://example.com/music-name.mp3', 'weddingpress' ),
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


		$this->add_control(
			'autoplay',
			[
				'label' => __( 'Autoplay', 'weddingpress' ),
				'type' => Controls_Manager::SWITCHER,
				'default' => 'disable',
				'options' => [
					'' => __( 'Yes', 'weddingpress' ),
					'disable' => __( 'No', 'weddingpress' ),
				],
				'separator' => 'before',
				
			]
		);
				
		$this->add_control(
			'pause_icon',
			[
				'label' => __( 'Icon Play', 'weddingpress' ),
				'type' => Controls_Manager::ICONS,
				'fa4compatibility' => 'icon',
				'default' => [
					'value' => 'fa fa-play-circle',
					'library' => 'fa-solid',
				],
				'separator' => 'before',
			]
		);

		$this->add_control(
			'play_icon',
			[
				'label' => __( 'Icon Stop', 'weddingpress' ),
				'type' => Controls_Manager::ICONS,
				'fa4compatibility' => 'icon',
				'default' => [
					'value' => 'fa fa-stop-circle',
					'library' => 'fa-solid',
				],
			]
		);
		
		

		$this->add_control(
			'view',
			[
				'label' => __( 'View', 'weddingpress' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'default' => __( 'Default', 'weddingpress' ),
					'stacked' => __( 'Stacked', 'weddingpress' ),
					'framed' => __( 'Framed', 'weddingpress' ),
				],
				'default' => 'default',
				'prefix_class' => 'elementor-view-',
			]
		);

		$this->add_control(
			'shape',
			[
				'label' => __( 'Shape', 'weddingpress' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'circle' => __( 'Circle', 'weddingpress' ),
					'square' => __( 'Square', 'weddingpress' ),
				],
				'default' => 'circle',
				'condition' => [
					'view!' => 'default',
				],
				'prefix_class' => 'elementor-shape-',
			]
		);

		$this->add_responsive_control(
			'align',
			[
				'label' => __( 'Alignment', 'weddingpress' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'left' => [
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
				],
				'default' => 'center',
				'selectors' => [
					'{{WRAPPER}} .elementor-icon-wrapper' => 'text-align: {{VALUE}};',
				],
			]
		);

		// $this->add_control(
		// 	'sticky_button',
		// 	[
		// 		'label' => __( 'Sticky/Floating', 'weddingpress' ),
		// 		'type' => Controls_Manager::SWITCHER,
		// 		'default' => '',
		// 		'label_on' => __( 'Yes', 'weddingpress' ),
		// 		'label_off' => __( 'No', 'weddingpress' ),
		// 		'return_value' => 'yes',
		// 	]
		// );
		
		$this->end_controls_section();
		
		$this->start_controls_section(
			'section_style_icon',
			[
				'label' => __( 'Icon', 'weddingpress' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->start_controls_tabs( 'icon_colors' );

		$this->start_controls_tab(
			'icon_colors_normal',
			[
				'label' => __( 'Normal', 'weddingpress' ),
			]
		);

		$this->add_control(
			'primary_color',
			[
				'label' => __( 'Primary Color', 'weddingpress' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}}.elementor-view-stacked .elementor-icon' => 'background-color: {{VALUE}};',
					'{{WRAPPER}}.elementor-view-framed .elementor-icon, {{WRAPPER}}.elementor-view-default .elementor-icon' => 'color: {{VALUE}}; border-color: {{VALUE}};',
					'{{WRAPPER}}.elementor-view-framed .elementor-icon, {{WRAPPER}}.elementor-view-default .elementor-icon svg' => 'fill: {{VALUE}};',
				],
				'scheme' => [
					'type' => Scheme_Color::get_type(),
					'value' => Scheme_Color::COLOR_1,
				],
			]
		);

		$this->add_control(
			'secondary_color',
			[
				'label' => __( 'Secondary Color', 'weddingpress' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'condition' => [
					'view!' => 'default',
				],
				'selectors' => [
					'{{WRAPPER}}.elementor-view-framed .elementor-icon' => 'background-color: {{VALUE}};',
					'{{WRAPPER}}.elementor-view-stacked .elementor-icon' => 'color: {{VALUE}};',
					'{{WRAPPER}}.elementor-view-stacked .elementor-icon svg' => 'fill: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'icon_colors_hover',
			[
				'label' => __( 'Hover', 'weddingpress' ),
			]
		);

		$this->add_control(
			'hover_primary_color',
			[
				'label' => __( 'Primary Color', 'weddingpress' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}}.elementor-view-stacked .elementor-icon:hover' => 'background-color: {{VALUE}};',
					'{{WRAPPER}}.elementor-view-framed .elementor-icon:hover, {{WRAPPER}}.elementor-view-default .elementor-icon:hover' => 'color: {{VALUE}}; border-color: {{VALUE}};',
					'{{WRAPPER}}.elementor-view-framed .elementor-icon:hover, {{WRAPPER}}.elementor-view-default .elementor-icon:hover svg' => 'fill: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'hover_secondary_color',
			[
				'label' => __( 'Secondary Color', 'weddingpress' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'condition' => [
					'view!' => 'default',
				],
				'selectors' => [
					'{{WRAPPER}}.elementor-view-framed .elementor-icon:hover' => 'background-color: {{VALUE}};',
					'{{WRAPPER}}.elementor-view-stacked .elementor-icon:hover' => 'color: {{VALUE}};',
					'{{WRAPPER}}.elementor-view-stacked .elementor-icon:hover svg' => 'fill: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'hover_animation',
			[
				'label' => __( 'Hover Animation', 'weddingpress' ),
				'type' => Controls_Manager::HOVER_ANIMATION,
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_responsive_control(
			'size',
			[
				'label' => __( 'Size', 'weddingpress' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 6,
						'max' => 300,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .elementor-icon' => 'font-size: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'icon_padding',
			[
				'label' => __( 'Padding', 'weddingpress' ),
				'type' => Controls_Manager::SLIDER,
				'selectors' => [
					'{{WRAPPER}} .elementor-icon' => 'padding: {{SIZE}}{{UNIT}};',
				],
				'range' => [
					'em' => [
						'min' => 0,
						'max' => 5,
					],
				],
				'condition' => [
					'view!' => 'default',
				],
			]
		);

		$this->add_responsive_control(
			'rotate',
			[
				'label' => __( 'Rotate', 'weddingpress' ),
				'type' => Controls_Manager::SLIDER,
				'default' => [
					'size' => 0,
					'unit' => 'deg',
				],
				'selectors' => [
					'{{WRAPPER}} .elementor-icon i, {{WRAPPER}} .elementor-icon svg' => 'transform: rotate({{SIZE}}{{UNIT}});',
				],
			]
		);

		$this->add_control(
			'border_width',
			[
				'label' => __( 'Border Width', 'weddingpress' ),
				'type' => Controls_Manager::DIMENSIONS,
				'selectors' => [
					'{{WRAPPER}} .elementor-icon' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'condition' => [
					'view' => 'framed',
				],
			]
		);

		$this->add_control(
			'border_radius',
			[
				'label' => __( 'Border Radius', 'weddingpress' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .elementor-icon' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'condition' => [
					'view!' => 'default',
				],
			]
		);

		$this->end_controls_section();

	}

	/**
	 * Render button widget output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @since 1.0.0
	 * @access protected
	 */

	protected function render() {
		$settings = $this->get_settings();	
		
		$this->add_render_attribute( 'wrapper', 'class', 'elementor-icon-wrapper' );

		// if ( $settings['sticky_button'] == 'yes' ) {
		// 	$this->add_render_attribute( 'wrapper', 'class', 'elementor-button-sticky' );
		// }

		$this->add_render_attribute( 'icon-wrapper', 'class', 'elementor-icon' );


		if ( ! empty( $settings['hover_animation'] ) ) {
			$this->add_render_attribute( 'icon-wrapper', 'class', 'elementor-animation-' . $settings['hover_animation'] );
		}

		$icon_tag = 'div';

		if ( empty( $settings['icon'] ) && ! Icons_Manager::is_migration_allowed() ) {
			// add old default
			$settings['icon'] = 'fa fa-music';
		}

		if ( ! empty( $settings['icon'] ) ) {
			$this->add_render_attribute( 'icon', 'class', $settings['icon'] );
			$this->add_render_attribute( 'icon', 'aria-hidden', 'true' );
		}

		$migrated = isset( $settings['__fa4_migrated']['selected_icon'] );
		$is_new = empty( $settings['icon'] ) && Icons_Manager::is_migration_allowed();

		// audio link
        if($settings['src_type'] == 'upload'){
            $audio_link = $settings['audio_upload']['url'];
        } else {
            $audio_link = $settings['audio_link']['url'];
        }
		
        if($audio_link):
        $arr = explode('.', $audio_link);
        $file_ext = end($arr);

		?>
		
		<script>
			var settingAutoplay = '<?php echo $settings['autoplay']; ?>';
			window.settingAutoplay = settingAutoplay === 'disable' ? false : true;
		</script>

		<div id="audio-container" class="audio-box">			

			<audio id="song" loop>
				<source src="<?php echo esc_url($audio_link); ?>"
                type="audio/<?php echo esc_attr($file_ext); ?>">
			</audio>  

			<div <?php echo $this->get_render_attribute_string( 'wrapper' ); ?> id="unmute-sound" style="display: none;">
				<<?php echo $icon_tag . ' ' . $this->get_render_attribute_string( 'icon-wrapper' ); ?>>
				<?php if ( $is_new || $migrated ) :
					Icons_Manager::render_icon( $settings['pause_icon'], [ 'aria-hidden' => 'true' ] );
				else : ?>
					<i <?php echo $this->get_render_attribute_string( 'icon' ); ?>></i>
				<?php endif; ?>
				</<?php echo $icon_tag; ?>>
			</div> 

			<div <?php echo $this->get_render_attribute_string( 'wrapper' ); ?> id="mute-sound" style="display: none;">
				<<?php echo $icon_tag . ' ' . $this->get_render_attribute_string( 'icon-wrapper' ); ?>>
				<?php if ( $is_new || $migrated ) :
					Icons_Manager::render_icon( $settings['play_icon'], [ 'aria-hidden' => 'true' ] );
				else : ?>
					<i <?php echo $this->get_render_attribute_string( 'icon' ); ?>></i>
				<?php endif; ?>
				</<?php echo $icon_tag; ?>>
			</div>
			
		</div>
		
		<?php 

		else:
            echo '<div class="weddingpress_not_found">';
            echo "<span>". esc_html__('No Audio File Selected/Uploaded', 'weddingpress') ."</span>";
            echo '</div>';
        endif;
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
		?>
		<# 
				iconHTML = elementor.helpers.renderIcon( view, settings.pause_icon, { 'aria-hidden': true }, 'i' , 'object' ),
				migrated = elementor.helpers.isIconMigrated( settings, 'pause_icon' ),
				iconTag = 'div';
		#>
		<div class="elementor-icon-wrapper">
			<{{{ iconTag }}} class="elementor-icon elementor-animation-{{ settings.hover_animation }}" >
				<# if ( iconHTML && iconHTML.rendered && ( ! settings.icon || migrated ) ) { #>
					{{{ iconHTML.value }}}
				<# } else { #>
					<i class="{{ settings.icon }}" aria-hidden="true"></i>
				<# } #>
			</{{{ iconTag }}}>
		</div>
		<?php
	}
}
